<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Complaint;
use App\Models\Voucher;
use App\Models\UserVoucher;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $category = $request->query('category');

        $categories = Category::orderBy('name')->get();

        $products = Product::query()
            // show products that are either active or have stock available
            ->where(function($q){
                $q->where('is_active', true)
                  ->orWhere('stock', '>', 0);
            })
            ->when($q, function ($query, $q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('description', 'like', "%{$q}%");
            })
            ->when($category, function ($query, $category) {
                $query->whereHas('category', function ($q) use ($category) {
                    $q->where('slug', $category);
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        $user = Auth::user();
        $tierVoucher = null; $userClaimed = null;
        if ($user) {
            // determine user tier based on points (same ranges as profile view)
            $points = (int) ($user->points ?? 0);
            $tier = 'bronze';
            if ($points >= 89900) $tier = 'obsidian';
            elseif ($points >= 39900) $tier = 'diamond';
            elseif ($points >= 12900) $tier = 'gold';
            elseif ($points >= 2800) $tier = 'silver';
            else $tier = 'bronze';

            // Wrap DB-dependent calls so page doesn't crash if migrations not run yet
            try {
                $tierVoucher = Voucher::where('tier', $tier)->where('stock','>',0)->first();
                if ($tierVoucher) {
                    $userClaimed = UserVoucher::where('user_id', $user->id)->where('voucher_id', $tierVoucher->id)->first();
                }
            } catch (\Exception $e) {
                // table might not exist yet (migrations not run). Fail silently and show no voucher.
                $tierVoucher = null;
                $userClaimed = null;
            }
        }

        return view('shop.index', compact('products', 'categories', 'q', 'category','tierVoucher','userClaimed'));
    }

    /**
     * Show single product detail by slug.
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where(function($q){ $q->where('is_active', true)->orWhere('stock','>',0); })
            ->with('category')->firstOrFail();

        // simple related: same category
        $related = [];
        if ($product->category) {
            $related = Product::where('category_id', $product->category->id)
                ->where('id', '!=', $product->id)
                ->where('is_active', true)
                ->take(4)
                ->get();
        }

        return view('shop.show', compact('product', 'related'));
    }

    /**
     * Show checkout / payment page for a product
     */
    public function buy(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)
            ->where(function($q){ $q->where('is_active', true)->orWhere('stock','>',0); })
            ->with('category')->firstOrFail();
        $user = Auth::user();
        $claimedVouchers = [];
        if ($user) {
            try {
                $claimedVouchers = UserVoucher::with('voucher')->where('user_id', $user->id)->where('used', false)->get();
            } catch (\Exception $e) {
                // table missing -> no vouchers available
                $claimedVouchers = [];
            }
        }
        return view('shop.checkout', compact('product','claimedVouchers'));
    }

    /**
     * Handle a mock payment submission and show thank you page.
     */
    public function pay(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();

        // Determine if product is rewards to validate payment method
        $catSlug = strtolower($product->category?->slug ?? '');
        $catName = strtolower($product->category?->name ?? '');
        $isRewards = ($catSlug === 'rewards' || $catName === 'rewards');
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required_unless:shipping_option,dropoff|string|max:1000',
            'qty' => 'required|integer|min:1',
            'payment_method' => $isRewards ? 'required|string|in:poin' : 'required|string|in:qris,cod',
            'shipping_option' => 'required|string|in:our,paket,dropoff',
            'reward_note' => 'nullable|string|max:1000',
            'reward_bank_account' => 'nullable|string|max:255',
        ]);

        $qty = (int) $data['qty'];

        $itemTotal = $product->price * $qty;
        
        // For rewards products, validate user has enough points
        if ($isRewards) {
            $userPoints = Auth::user()->points ?? 0;
            if ($userPoints < $itemTotal) {
                return redirect()->back()->withErrors(['points' => 'Poin Anda tidak cukup. Anda membutuhkan ' . $itemTotal . ' poin, tapi hanya memiliki ' . $userPoints . ' poin.']);
            }
        }
        
        $serviceFee = $isRewards ? 0 : 2000; // Skip 2000 fee for rewards products
        $shippingCost = 0;
        $shippingLabel = '';
        switch ($data['shipping_option']) {
            case 'our':
                $shippingCost = 6000;
                $shippingLabel = 'Jasa kami';
                break;
            case 'paket':
                $shippingCost = 10000;
                $shippingLabel = 'Jasa paket';
                break;
            case 'dropoff':
            default:
                $shippingCost = 0;
                $shippingLabel = 'Dropoff (SMKN 1 Gunungputri)';
                break;
        }

        $total = $itemTotal + $serviceFee + $shippingCost;

        // optional voucher application
        $appliedVoucher = null;
        if ($request->filled('voucher_id')) {
            $uv = UserVoucher::where('id', $request->input('voucher_id'))->where('user_id', Auth::id())->where('used', false)->with('voucher')->first();
            if ($uv && $uv->voucher) {
                $v = $uv->voucher;
                if ($v->discount_type === 'percent') {
                    $discount = (int) round(($v->discount_value/100) * $itemTotal);
                } else {
                    $discount = (int) $v->discount_value;
                }
                // ensure discount does not exceed item total
                $discount = min($discount, $itemTotal);
                $total = max(0, $total - $discount);
                $appliedVoucher = ['code' => $v->code, 'discount' => $discount, 'voucher_id' => $v->id, 'user_voucher_id' => $uv->id];
            }
        }

        // If user selected dropoff, override address with the fixed dropoff location
        if (isset($data['shipping_option']) && $data['shipping_option'] === 'dropoff') {
            $data['address'] = 'SMKN 1 Gunungputri';
        }

        // persist order to DB so admin can confirm payment
        $order = Order::create([
            'order_number' => strtoupper(Str::random(10)),
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'product_name' => $product->name,
            'qty' => $qty,
            'total' => $total,
            'name' => $data['name'],
            'address' => $data['address'],
            'payment_method' => $data['payment_method'],
            'status' => 'pending',
            'metadata' => array_filter([
                'item_total' => $itemTotal,
                'service_fee' => $serviceFee,
                'shipping' => ['option' => $data['shipping_option'], 'label' => $shippingLabel, 'cost' => $shippingCost],
                'voucher' => $appliedVoucher,
                'reward_note' => $request->input('reward_note') ?? null,
                'reward_bank_account' => $request->input('reward_bank_account') ?? null,
            ]),
        ]);

        // mark user voucher used
        if ($appliedVoucher && ! empty($appliedVoucher['user_voucher_id'])) {
            $uv = UserVoucher::find($appliedVoucher['user_voucher_id']);
            if ($uv) {
                $uv->used = true;
                $uv->times_used = ($uv->times_used ?? 0) + 1;
                $uv->used_at = now();
                $uv->save();
            }
        }

        // Deduct points for rewards products
        if ($isRewards) {
            $user = Auth::user();
            $user->points = ($user->points ?? 0) - $itemTotal;
            $user->save();
        }

        // keep a copy in session for immediate thank-you view
        session(['last_order' => $order->toArray()]);

        return redirect()->route('shop.checkout.thankyou');
    }

    public function thankyou()
    {
        $order = session('last_order');
        if (!$order) {
            return redirect()->route('shop.index');
        }
        return view('shop.thankyou', compact('order'));
    }

    // Show authenticated user's orders
    public function orders()
    {
        $orders = \App\Models\Order::with(['complaints'])->where('user_id', Auth::id())->orderBy('created_at','desc')->paginate(12);
        return view('shop.orders', compact('orders'));
    }

    public function orderShow($id)
    {
        $order = \App\Models\Order::where('id', $id)->where(function($q){ $q->where('user_id', Auth::id())->orWhereNull('user_id'); })->firstOrFail();

        // load user's latest complaint for this order (if any)
        $complaint = \App\Models\Complaint::where('order_id', $order->id)
            ->where(function($q){ $q->where('user_id', Auth::id())->orWhereNull('user_id'); })
            ->orderBy('created_at','desc')
            ->first();

        return view('shop.order_show', compact('order','complaint'));
    }

    /**
     * Mark an order as received by the user.
     */
    public function receive(Request $request, $id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $order->status = 'delivered';
        $order->save();

        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'mark_order_received',
            'subject_type' => Order::class,
            'subject_id' => $order->id,
            'data' => ['order_number' => $order->order_number],
            'ip' => $request->ip(),
        ]);

        return redirect()->route('shop.orders.show', $id)->with('success', 'Pesanan ditandai sudah diterima.');
    }

    /**
     * User acknowledges refund received after admin rejected an order.
     */
    public function refundReceived(Request $request, $id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // only allow when order was rejected
        if ($order->status !== 'rejected') {
            return redirect()->route('shop.orders.show', $id)->with('error', 'Aksi tidak tersedia.');
        }

        $meta = $order->metadata ?? [];
        $meta = is_array($meta) ? $meta : (array) $meta;
        $meta['refund_acknowledged'] = true;
        $meta['refund_acknowledged_at'] = now()->toDateTimeString();

        // Save metadata acknowledging refund but do NOT set an unknown enum status.
        // The orders.status column is an ENUM and does not include 'refunded' by default,
        // setting it would cause a SQL warning. Keep the existing status (e.g. 'rejected')
        // and record the refund acknowledgment in metadata instead.
        $order->metadata = $meta;
        $order->save();

        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'acknowledge_refund',
            'subject_type' => Order::class,
            'subject_id' => $order->id,
            'data' => ['order_number' => $order->order_number],
            'ip' => $request->ip(),
        ]);

        return redirect()->route('shop.orders.show', $id)->with('success', 'Terima kasih — kami mencatat bahwa Anda telah menerima pengembalian.');
    }

    /**
     * Submit a complaint for an order.
     */
    public function submitComplaint(Request $request, $id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'evidence' => 'nullable|image|max:4096',
        ]);

        $evidencePath = null;
        if ($request->hasFile('evidence')) {
            $path = $request->file('evidence')->store('complaints', 'public');
            $evidencePath = '/storage/' . $path;
        }

        $complaint = Complaint::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'evidence_path' => $evidencePath,
            'status' => 'open',
            'metadata' => null,
        ]);

        // mark order as complained so admin can see it quickly
        $order->status = 'complained';
        $order->save();

        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'create_complaint',
            'subject_type' => Complaint::class,
            'subject_id' => $complaint->id,
            'data' => ['order_id' => $order->id, 'title' => $complaint->title],
            'ip' => $request->ip(),
        ]);

        return redirect()->route('shop.orders.show', $id)->with('success', 'Komplain Anda telah dikirim. Tim admin akan meninjaunya.');
    }

    /**
     * User requests cancellation for a confirmed order.
     * The request is stored in order metadata for admin review.
     */
    public function cancelRequest(Request $request, $id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // only allow cancellation requests when order is confirmed
        if ($order->status !== 'confirmed') {
            return redirect()->route('shop.orders.show', $id)->with('error', 'Permintaan pembatalan hanya dapat diajukan untuk pesanan yang berstatus terkonfirmasi.');
        }

        $data = $request->validate([
            'cancel_reason' => 'required|string|max:2000',
        ]);

        $meta = $order->metadata ?? [];
        $meta = is_array($meta) ? $meta : (array) $meta;
        $meta['cancel_request'] = [
            'user_id' => Auth::id(),
            'reason' => $data['cancel_reason'],
            'requested_at' => now()->toDateTimeString(),
            'status' => 'pending', // admin will mark 'canceled' or 'continue'
        ];

        $order->metadata = $meta;
        $order->save();

        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'request_order_cancellation',
            'subject_type' => Order::class,
            'subject_id' => $order->id,
            'data' => ['order_number' => $order->order_number, 'reason' => $data['cancel_reason']],
            'ip' => $request->ip(),
        ]);

        return redirect()->route('shop.orders.show', $id)->with('success', 'Permintaan pembatalan telah dikirim. Admin akan meninjau permintaan Anda.');
    }

    /**
     * Handle user's satisfaction response after admin confirmed the complaint.
     */
    public function complaintSatisfaction(Request $request, $id)
    {
        $complaint = Complaint::with('order')->where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $data = $request->validate([
            'satisfied' => 'required|in:yes,no',
        ]);

        if ($complaint->status !== 'confirmed') {
            return redirect()->route('shop.orders.show', $complaint->order_id)->with('error', 'Aksi tidak tersedia.');
        }

        $meta = $complaint->metadata ?? [];
        $meta = is_array($meta) ? $meta : (array) $meta;

        if ($data['satisfied'] === 'yes') {
            $complaint->status = 'closed';
            $meta['user_satisfied'] = true;
            $meta['user_satisfied_at'] = now()->toDateTimeString();
            $complaint->metadata = $meta;
            $complaint->save();

            // mark order as delivered
            if ($complaint->order) {
                $order = $complaint->order;
                $order->status = 'delivered';
                $order->save();
            }

            Activity::create([
                'user_id' => Auth::id(),
                'action' => 'complaint_closed_by_user',
                'subject_type' => Complaint::class,
                'subject_id' => $complaint->id,
                'data' => ['satisfied' => true],
                'ip' => $request->ip(),
            ]);

            return redirect()->route('shop.orders.show', $complaint->order_id)->with('success', 'Terima kasih — keluhan ditutup dan pesanan ditandai sebagai diterima.');
        }

        // user is not satisfied -> keep complaint marked as confirmed but record user's dissatisfaction
        $meta['user_satisfied'] = false;
        $meta['user_satisfied_at'] = now()->toDateTimeString();
        $complaint->metadata = $meta;
        $complaint->save();

        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'complaint_user_unsatisfied',
            'subject_type' => Complaint::class,
            'subject_id' => $complaint->id,
            'data' => ['satisfied' => false],
            'ip' => $request->ip(),
        ]);

        // return to order page and open complaint form so user can re-submit if they want
        return redirect()->route('shop.orders.show', $complaint->order_id)
            ->with('info', 'Anda memilih tidak puas dengan jawaban admin. Jika ingin, silakan ajukan keluhan baru.')->with('show_complaint_form', true);
    }
}
