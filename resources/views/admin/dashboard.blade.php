@extends('admin.layout')

@section('title','Dashboard Admin')

@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Akun</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['articles'] ?? 0 }}</p>
            </div>
            <i class="fas fa-user text-4xl text-green-500 opacity-30"></i>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Keluhan Bulan Ini</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['complaints_this_month'] ?? 0 }}</p>
            </div>
            <i class="fas fa-comment-dots text-4xl text-amber-500 opacity-30"></i>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Produk Terjual (unit)</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['products_sold'] ?? 0 }}</p>
                <p class="text-xs text-gray-500 mt-2">Delivered: {{ $stats['delivered_orders'] ?? 0 }}</p>
            </div>
            <i class="fas fa-hand-holding-usd text-4xl text-blue-500 opacity-30"></i>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Laporan Pending</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['reports'] ?? 0 }}</p>
                <p class="text-xs text-gray-500 mt-2">Pesanan: {{ $stats['pending_orders'] ?? 0 }} | Sampah: {{ $stats['pending_sampah'] ?? 0 }} | Permintaan poin: <span class="text-sm font-bold text-red-600 mt-2">{{ $stats['pending_point_requests'] ?? 0 }}</span></p>

            </div>
            <i class="fas fa-exclamation-triangle text-4xl text-red-500 opacity-30"></i>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-md mt-6">
        <h3 class="text-xl font-semibold text-gray-800">Ringkasan Sampah & Produk</h3>
        <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="p-4 border border-gray-300 rounded-lg">
                <p class="text-sm text-gray-500">Total Sampah (kg) - Tercatat dari kurir semua wilayah</p>
                <p class="text-2xl font-bold text-green-800 mt-2">{{ number_format($stats['total_kg_all'] ?? 0, 2) }} kg</p>
            </div>
            <div class="p-4 border border-gray-300 rounded-lg">
                <p class="text-sm text-gray-500">Produk Dihasilkan dari Daur Ulang</p>
                <p class="text-2xl font-bold text-gray-900 mt-2">{{ $stats['products_from_waste'] ?? 0 }}</p>
            </div>
            <div class="p-4 border border-gray-300 rounded-lg">
                <p class="text-sm text-gray-500">Pendapatan dari Produk Terjual (delivered)</p>
                <p class="text-2xl font-bold text-gray-900 mt-2">Rp {{ number_format($stats['delivered_revenue'] ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="mt-6">
            <h4 class="text-md font-semibold text-gray-700">Rincian Berdasarkan Jenis Sampah (kg)</h4>
            <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                @if(!empty($stats['sampah_by_jenis']))
                    @foreach($stats['sampah_by_jenis'] as $jenis => $kg)
                        <div class="p-3 border border-gray-300 rounded-lg">
                            <div class="text-sm text-gray-600">{{ $jenis }}</div>
                            <div class="text-lg font-bold text-gray-900">{{ number_format($kg, 2) }} kg</div>
                        </div>
                    @endforeach
                @else
                    <div class="p-3 text-sm text-gray-500">Belum ada data sampah selesai untuk ditampilkan.</div>
                @endif
            </div>
        </div>
    </div>
@endsection
