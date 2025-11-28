<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        try {
            $reviews = Review::with(['user','product'])->orderBy('created_at','desc')->paginate(20);
            $missing = false;
        } catch (\Exception $e) {
            // likely migration not run or table missing; show empty collection and flag missing
            $reviews = collect();
            $missing = true;
        }
        return view('admin.reviews.index', compact('reviews','missing'));
    }

    public function destroy($id)
    {
        try {
            $r = Review::findOrFail($id);
            $r->delete();
            return redirect()->route('admin.reviews')->with('success', 'Ulasan dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.reviews')->with('error', 'Tindakan gagal — tabel ulasan mungkin belum dibuat. Jalankan migrasi database.');
        }
    }
}
