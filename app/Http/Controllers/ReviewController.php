<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create($orderId)
    {
        $order = Order::where('id', $orderId)->where('user_id', Auth::id())->firstOrFail();
        if ($order->status !== 'delivered') {
            return redirect()->route('shop.orders.show', $order->id)->with('error', 'Ulasan hanya boleh dibuat jika pesanan sudah diterima.');
        }

        $product = Product::findOrFail($order->product_id);
        // ensure user hasn't already reviewed this order
        $exists = Review::where('order_id', $order->id)->where('user_id', Auth::id())->first();
        if ($exists) {
            return redirect()->route('shop.orders.show', $order->id)->with('info', 'Anda sudah memberi ulasan untuk pesanan ini.');
        }

        return view('reviews.create', compact('order','product'));
    }

    public function store(Request $request, $orderId)
    {
        $order = Order::where('id', $orderId)->where('user_id', Auth::id())->firstOrFail();
        if ($order->status !== 'delivered') {
            return redirect()->route('shop.orders.show', $order->id)->with('error', 'Ulasan hanya boleh dibuat jika pesanan sudah diterima.');
        }

        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'body' => 'nullable|string|max:2000',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $photos = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                if ($photo->isValid()) {
                    $path = $photo->store('reviews/' . Auth::id(), 'public');
                    $photos[] = $path;
                }
            }
        }

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $order->product_id,
            'order_id' => $order->id,
            'rating' => $data['rating'],
            'title' => $data['title'] ?? null,
            'body' => $data['body'] ?? null,
            'photos' => !empty($photos) ? $photos : null,
            'approved' => true,
        ]);

        return redirect()->route('shop.orders.show', $order->id)->with('success', 'Terima kasih — ulasan Anda telah dikirim.');
    }

    public function show($id)
    {
        $review = Review::with(['user','product'])->findOrFail($id);
        return view('reviews.show', compact('review'));
    }
}
