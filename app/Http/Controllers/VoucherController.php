<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\UserVoucher;
use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller
{
    public function claim(Request $request, $id)
    {
        $user = Auth::user();
        if (! $user) return redirect()->route('login');

        $voucher = Voucher::findOrFail($id);

        if ($voucher->stock <= 0) {
            return back()->with('error', 'Maaf, kuota voucher sudah habis.');
        }

        // prevent duplicate claims: one claim per user per voucher
        $exists = UserVoucher::where('user_id', $user->id)->where('voucher_id', $voucher->id)->first();
        if ($exists) {
            return back()->with('info', 'Anda sudah mengklaim voucher ini.');
        }

        // create claim and decrement stock (atomic-ish)
        $uv = UserVoucher::create([
            'user_id' => $user->id,
            'voucher_id' => $voucher->id,
            'claimed_at' => now(),
        ]);

        $voucher->decrement('stock', 1);

        return back()->with('success', 'Voucher berhasil diklaim. Cek di halaman pembayaran saat memesan.');
    }
}
