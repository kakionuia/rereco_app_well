<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voucher;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::orderBy('tier')->get();
        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function update(Request $request, $id)
    {
        $v = Voucher::findOrFail($id);
        $data = $request->validate([
            'stock' => 'required|integer|min:0',
            'discount_value' => 'required|integer|min:0',
        ]);
        $v->stock = (int) $data['stock'];
        $v->discount_value = (int) $data['discount_value'];
        $v->save();
        return redirect()->route('admin.vouchers')->with('success', 'Voucher updated.');
    }
}
