@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white p-6 rounded-lg shadow text-center">
        <h2 class="text-2xl font-semibold mb-4">Terima kasih! Pesanan Anda telah diterima.</h2>

        <div class="text-left mx-auto max-w-lg">
            <p class="text-sm text-gray-600">Nomor Pesanan: <span class="font-mono font-semibold">{{ $order['id'] }}</span></p>
            <p class="mt-2">Produk: <strong>{{ $order['product_name'] }}</strong></p>
            <p class="mt-1">Jumlah: {{ $order['qty'] }}</p>
            <p class="mt-1">Total: Rp {{ number_format($order['total'],0,',','.') }}</p>
            <p class="mt-1">Metode Pembayaran:
                @if($order['payment_method'] === 'qris')
                    QRIS
                @elseif($order['payment_method'] === 'poin')
                    Pembayaran dengan Poin
                @elseif($order['payment_method'] == 'bank_transfer')
                    Bank Transfer
                @else
                    Cash on Delivery (COD)
                @endif
            </p>

            @if(isset($order['payment_method']) && $order['payment_method'] === 'qris')
                <div class="mt-6 flex justify-center">
                    <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-lg text-center">
                        <h3 class="text-lg font-semibold mb-3">Scan QRIS untuk membayar</h3>
                        <div class="mx-auto w-64 h-64 bg-gray-100 rounded-md flex items-center justify-center overflow-hidden">
                            @if(!empty($order['qris_image']))
                                <img src="{{ $order['qris_image'] }}" alt="QRIS" class="object-contain w-full h-full" />
                            @else
                                {{-- Placeholder SVG ketika belum ada gambar QRIS --}}
                                <svg class="w-40 h-40 text-gray-400" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="2" y="2" width="20" height="20" rx="2" stroke="currentColor" stroke-width="1.5" />
                                    <rect x="6" y="6" width="3" height="3" fill="currentColor" />
                                    <rect x="10" y="6" width="8" height="8" fill="currentColor" />
                                    <rect x="6" y="10" width="8" height="8" fill="currentColor" />
                                </svg>
                            @endif
                        </div>
                        <p class="mt-4 text-sm text-gray-700">Tunjukkan/scan kode QR di aplikasi pembayaran di atas untuk menyelesaikan transaksi.</p>
                        
                    </div>
                </div>
            @endif
            <p class="mt-3 text-sm text-gray-700">Kami akan menghubungi Anda melalui data yang Anda berikan untuk konfirmasi dan instruksi pembayaran jika diperlukan.</p>
        </div>

        <div class="mt-6">
            <a href="{{ route('shop.index') }}" class="px-4 py-2 bg-green-600 text-white rounded">Kembali ke Toko</a>
        </div>
    </div>
</div>
@endsection
