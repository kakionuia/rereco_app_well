@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <a href="{{ route('shop.index') }}" class="inline-flex items-center space-x-2 text-green-600 font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                <span>Kembali ke Toko</span>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-green-600">Riwayat Pesanan</h1>
            </div>
        </div>

        <!-- Filter Tabs (Optional) -->
        @php $currentStatus = request('status', 'all'); @endphp
        <div class="mb-6 flex flex-wrap gap-2">
            <a href="{{ route('shop.orders', ['status' => 'all']) }}" class="px-4 py-2 rounded-full font-semibold {{ $currentStatus === 'all' ? 'bg-green-600 text-white' : 'bg-white text-gray-700 border border-gray-300 hover:border-green-600' }}">Semua</a>
            <a href="{{ route('shop.orders', ['status' => 'processing']) }}" class="px-4 py-2 rounded-full font-semibold {{ $currentStatus === 'processing' ? 'bg-green-600 text-white' : 'bg-white text-gray-700 border border-gray-300 hover:border-green-600' }}">Diproses</a>
            <a href="{{ route('shop.orders', ['status' => 'on_the_way']) }}" class="px-4 py-2 rounded-full font-semibold {{ $currentStatus === 'on_the_way' ? 'bg-green-600 text-white' : 'bg-white text-gray-700 border border-gray-300 hover:border-green-600' }}">Dikirim</a>
            <a href="{{ route('shop.orders', ['status' => 'delivered']) }}" class="px-4 py-2 rounded-full font-semibold {{ $currentStatus === 'delivered' ? 'bg-green-600 text-white' : 'bg-white text-gray-700 border border-gray-300 hover:border-green-600' }}">Selesai</a>
            <a href="{{ route('shop.orders', ['status' => 'rejected']) }}" class="px-4 py-2 rounded-full font-semibold {{ $currentStatus === 'rejected' ? 'bg-red-600 text-white' : 'bg-white text-gray-700 border border-gray-300 hover:border-red-600' }}">Ditolak</a>
        </div>

        @if($orders->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <div class="mb-4">
                    <svg class="w-16 h-16 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14a2 2 0 012 2v7a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2z"></path>
                    </svg>
                </div>
                <p class="text-gray-600 font-medium mb-4">Belum ada pesanan</p>
                <p class="text-gray-500 mb-6">Yuk mulai belanja dan ciptakan pesanan pertama Anda!</p>
                <a href="{{ route('shop.index') }}" class="inline-flex items-center space-x-2 px-6 py-3 bg-green-600 hover:bg-green-800 text-white rounded-lg font-semibold transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14a2 2 0 012 2v7a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2z"></path></svg>
                    <span>Mulai Belanja Sekarang</span>
                </a>
            </div>
        @else
            <!-- Orders List -->
            <div class="space-y-4">
                @foreach($orders as $order)
                    <a href="{{ route('shop.orders.show', $order->id) }}" class="order-card block bg-white rounded-lg shadow-md hover:shadow-lg transition no-underline group overflow-hidden" data-status="{{ $order->status }}">
                        <!-- Order Card -->
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-start">
                                <!-- Product Info -->
                                <div class="md:col-span-2">
                                    <div class="flex items-start space-x-4">
                                        <!-- Order Icon -->
                                        <div class="flex-shrink-0">
                                            @php
                                                switch($order->status) {
                                                    case 'pending': $icon = '📋'; $bgColor = 'bg-gray-100'; break;
                                                    case 'confirmed': $icon = '✓'; $bgColor = 'bg-blue-100'; break;
                                                    case 'on_the_way': $icon = '🚚'; $bgColor = 'bg-amber-100'; break;
                                                    case 'delivered': $icon = '✓'; $bgColor = 'bg-green-100'; break;
                                                    case 'rejected': $icon = '✕'; $bgColor = 'bg-red-100'; break;
                                                    case 'canceled': $icon = '✕'; $bgColor = 'bg-red-100'; break;
                                                    case 'complained': $icon = '⚠'; $bgColor = 'bg-yellow-100'; break;
                                                    default: $icon = '•'; $bgColor = 'bg-gray-100'; break;
                                                }
                                            @endphp
                                            <div class="w-12 h-12 rounded-lg {{ $bgColor }} flex items-center justify-center text-xl font-bold">
                                                {{ $icon }}
                                            </div>
                                        </div>
                                        
                                        <!-- Product Details -->
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-base font-semibold text-gray-900 line-clamp-2 group-hover:text-green-600 transition">
                                                {{ $order->product_name }}
                                            </h3>
                                            <div class="flex items-center space-x-4 mt-2 text-sm text-gray-600">
                                                <span class="flex items-center space-x-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.972 1.972 0 013 12V7a4 4 0 014-4z"></path></svg>
                                                    <span>Qty: {{ $order->qty }}</span>
                                                </span>
                                                <span class="flex items-center space-x-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    <span>{{ $order->created_at->format('d M Y') }}</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="md:text-right">
                                    @php
                                        switch($order->status) {
                                            case 'pending': $statusColor = 'bg-gray-100 text-gray-800'; $statusLabel = 'Menunggu'; break;
                                            case 'confirmed': $statusColor = 'bg-blue-100 text-blue-800'; $statusLabel = 'Dikonfirmasi'; break;
                                            case 'on_the_way': $statusColor = 'bg-amber-100 text-amber-800'; $statusLabel = 'Dikirim'; break;
                                            case 'delivered': $statusColor = 'bg-green-100 text-green-700'; $statusLabel = 'Terima'; break;
                                            case 'rejected': $statusColor = 'bg-red-100 text-red-800'; $statusLabel = 'Ditolak'; break;
                                            case 'canceled': $statusColor = 'bg-red-100 text-red-800'; $statusLabel = 'Dibatalkan'; break;
                                            case 'complained': $statusColor = 'bg-yellow-100 text-yellow-800'; $statusLabel = 'Ada Keluhan'; break;
                                            default: $statusColor = 'bg-gray-100 text-gray-800'; $statusLabel = 'Unknown'; break;
                                        }
                                    @endphp
                                    <span class="inline-flex lg:relative lg:left-25 items-end px-3 py-1 rounded-full text-sm font-semibold {{ $statusColor }}">
                                        {{ $statusLabel }}
                                    </span>

                                    <!-- Rejection Reason (if any) -->
                                    @php
                                        $latestComplaint = null;
                                        if(isset($order->complaints) && $order->complaints->isNotEmpty()) {
                                            $latestComplaint = $order->complaints->sortByDesc('created_at')->first();
                                        }
                                        $rejectReason = $order->status == 'rejected' ? ($order->metadata['reject_reason'] ?? null) : null;
                                        if(!$rejectReason && $latestComplaint && ($latestComplaint->status === 'rejected')) {
                                            $rejectReason = is_array($latestComplaint->metadata) ? ($latestComplaint->metadata['admin_note'] ?? $latestComplaint->metadata['note'] ?? null) : null;
                                        }
                                    @endphp
                                    @if($rejectReason)
                                        <div class="mt-3 text-left md:text-right">
                                            <p class="text-xs text-red-600 font-medium">Alasan penolakan:</p>
                                            <p class="text-xs text-red-700 mt-1">{{ \Illuminate\Support\Str::limit($rejectReason, 100) }}</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Price -->
                                <div class="md:text-right">
                                    <div class="text-2xl font-bold text-green-600">
                                        Rp {{ number_format($order->total,0,',','.') }}
                                    </div>
                                    <p class="text-xs text-gray-600 mt-1">Total Pesanan</p>
                                </div>
                            </div>
                        </div>

                        <!-- Order Footer -->
                        <div class="border-t px-6 py-3 bg-gray-50 flex items-center justify-between">
                            <div class="text-sm text-gray-600">
                                Order #{{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }}
                            </div>
                            <div class="flex items-center space-x-2 text-green-800 font-semibold group-hover:space-x-3 transition-all">
                                <span>Lihat Detail</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Empty state for filtered results (hidden by default) -->
            <div id="orders-empty" class="hidden bg-white rounded-lg shadow-md p-12 text-center">
                <div class="mb-4">
                    <svg class="w-16 h-16 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p id="orders-empty-title" class="text-gray-600 font-medium mb-2">Tidak ada pesanan di kategori ini</p>
                <p id="orders-empty-desc" class="text-gray-500 mb-6">Coba ubah filter atau kembali ke halaman utama toko.</p>
                <a href="{{ route('shop.index') }}" class="inline-flex items-center space-x-2 px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"></path></svg>
                    <span>Kembali ke Toko</span>
                </a>
            </div>

            <!-- Pagination -->
            @if($orders->hasPages())
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            @endif

            <script>
                document.addEventListener('DOMContentLoaded', function(){
                    // Read status from URL param
                    var params = new URLSearchParams(window.location.search);
                    var status = params.get('status') || 'all';

                    // Mapping for UI-friendly categories to internal statuses
                    var mapping = {
                        'all': [],
                        'processing': ['pending','confirmed'],
                        'on_the_way': ['on_the_way'],
                        'delivered': ['delivered'],
                        'rejected': ['rejected']
                    };

                    var cards = Array.from(document.querySelectorAll('.order-card'));
                    var shown = 0;

                    cards.forEach(function(card){
                        var s = card.getAttribute('data-status');
                        if(status === 'all'){
                            card.style.display = '';
                            shown++;
                        } else {
                            var allowed = mapping[status] || [status];
                            if(allowed.indexOf(s) !== -1){
                                card.style.display = '';
                                shown++;
                            } else {
                                card.style.display = 'none';
                            }
                        }
                    });

                    var empty = document.getElementById('orders-empty');
                    if(shown === 0){
                        empty.classList.remove('hidden');
                        var title = document.getElementById('orders-empty-title');
                        var desc = document.getElementById('orders-empty-desc');
                        switch(status){
                            case 'processing':
                                title.textContent = 'Belum ada pesanan yang sedang diproses';
                                desc.textContent = 'Saat ini tidak ada pesanan dengan status diproses.';
                                break;
                            case 'on_the_way':
                                title.textContent = 'Belum ada pesanan yang dikirim';
                                desc.textContent = 'Tidak ada pesanan yang sedang dalam proses pengiriman.';
                                break;
                            case 'delivered':
                                title.textContent = 'Belum ada pesanan yang selesai';
                                desc.textContent = 'Belum ada pesanan yang berstatus selesai.';
                                break;
                            case 'rejected':
                                title.textContent = 'Tidak ada pesanan yang ditolak';
                                desc.textContent = 'Tidak ada pesanan yang ditolak oleh admin pada saat ini.';
                                break;
                            default:
                                title.textContent = 'Tidak ada pesanan';
                                desc.textContent = 'Coba ubah filter atau kembali ke toko untuk membuat pesanan.';
                        }
                    } else {
                        empty.classList.add('hidden');
                    }
                });
            </script>
        @endif
    </div>
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection
