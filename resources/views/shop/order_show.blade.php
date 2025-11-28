@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('shop.orders') }}" class="inline-flex items-center space-x-1 text-green-600 hover:text-green-700 font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                <span>Kembali ke Riwayat Pesanan</span>
            </a>
        </div>

        <!-- Order Header Card -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $order->product_name }}</h1>
                    <p class="text-sm text-gray-600">Order #{{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }}</p>
                </div>
                @php
                    // Map status to badge + icon and a localized label when needed
                    $statusLabel = ucfirst(str_replace('_', ' ', $order->status));
                    switch($order->status) {
                        case 'pending': $badgeClass = 'bg-gray-100 text-gray-800'; $icon = '⏳'; break;
                        case 'confirmed': $badgeClass = 'bg-blue-100 text-blue-800'; $icon = '✓'; break;
                        case 'on_the_way': $badgeClass = 'bg-amber-100 text-amber-800'; $icon = '🚚'; break;
                        case 'delivered': $badgeClass = 'bg-green-100 text-green-800'; $icon = '✓ Done'; break;
                        case 'rejected': $badgeClass = 'bg-red-100 text-red-800'; $icon = '✕'; break;
                        case 'canceled': $badgeClass = 'bg-red-100 text-red-800'; $icon = '✕'; $statusLabel = 'Dibatalkan'; break;
                        case 'complained': $badgeClass = 'bg-yellow-100 text-yellow-800'; $icon = '⚠'; break;
                        default: $badgeClass = 'bg-gray-100 text-gray-800'; $icon = '•'; break;
                    }
                @endphp
                <div class="mt-4 sm:mt-0">
                    <span class="inline-flex items-center space-x-2 px-4 py-2 rounded-full {{ $badgeClass }} font-semibold">
                        <span>{{ $icon }}</span>
                        <span>{{ $statusLabel }}</span>
                    </span>
                </div>
            </div>

            <!-- Quick Info -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="border-l-4 border-green-500 pl-4">
                    <p class="text-xs text-gray-600 uppercase">Harga Total</p>
                    <p class="text-lg font-bold text-gray-900">Rp {{ number_format($order->total,0,',','.') }}</p>
                </div>
                <div class="border-l-4 border-amber-500 pl-4">
                    <p class="text-xs text-gray-600 uppercase">Jumlah</p>
                    <p class="text-lg font-bold text-gray-900">{{ $order->qty }} pcs</p>
                </div>
                <div class="border-l-4 border-green-600 pl-4">
                    <p class="text-xs text-gray-600 uppercase">Pesan Pada</p>
                    <p class="text-lg font-bold text-gray-900">{{ $order->created_at->format('d M Y') }}</p>
                </div>
                <div class="border-l-4 border-amber-500 pl-4">
                    @if(in_array($order->status, ['confirmed','on_the_way']))
                        @php $eta = $order->created_at->copy()->addDays(3); @endphp
                        <p class="text-xs text-gray-600 uppercase">Est. Tiba</p>
                        <p class="text-lg font-bold text-gray-900">{{ $eta->format('d M Y') }}</p>
                    @else
                        <p class="text-xs text-gray-600 uppercase">Waktu</p>
                        <p class="text-lg font-bold text-gray-900">{{ $order->created_at->format('H:i') }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Payment Method -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Metode Pembayaran</h3>
            @php
                $pm = strtolower($order->payment_method ?? '');
                $pmLabel = 'Tidak Diketahui';
                $pmIcon = '';
                if($pm === 'qris') { $pmLabel = 'QRIS'; $pmIcon = ''; }
                elseif($pm === 'cod') { $pmLabel = 'Bayar di Tempat (COD)'; $pmIcon = ''; }
                elseif($pm === 'poin' || $pm === 'point' || $pm === 'points') { $pmLabel = 'Poin'; $pmIcon = ''; }
            @endphp

            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-700 text-xl">
                        {{ $pmIcon }}
                    </div>
                    <div>
                        <div class="text-sm text-gray-600">Metode</div>
                        <div class="text-lg font-bold text-gray-900">{{ $pmLabel }}</div>
                    </div>
                </div>
                @if(in_array($pm, ['poin','point','points']))
                    <div class="text-right">
                        @php $pointsUsed = $order->item_total ?? $order->total ?? null; @endphp
                        @if($pointsUsed)
                            <div class="text-sm text-gray-600">Poin Terpakai</div>
                            <div class="text-lg font-bold text-green-600">{{ number_format($pointsUsed,0,',','.') }} poin</div>
                        @else
                            <div class="text-sm text-gray-600">Poin Terpakai</div>
                            <div class="text-lg font-bold text-green-600">-</div>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Order Timeline -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Status Pengiriman</h3>
            
            @php
                $steps = [
                    ['key' => 'pending', 'label' => 'Menunggu Konfirmasi', 'icon' => '⏳'],
                    ['key' => 'confirmed', 'label' => 'Pesanan Dikonfirmasi', 'icon' => '✓'],
                    ['key' => 'on_the_way', 'label' => 'Sedang Dikirim', 'icon' => '🚚'],
                    ['key' => 'delivered', 'label' => 'Pesanan Tiba', 'icon' => '📦'],
                ];

                $statusIndex = -1;
                foreach($steps as $idx => $step) {
                    if($order->status === $step['key']) {
                        $statusIndex = $idx;
                        break;
                    }
                }

                // Handle special cases (rejected, canceled, complained)
                if(in_array($order->status, ['rejected', 'canceled', 'complained'])) {
                    $statusIndex = -1; // Don't show timeline for these
                }
            @endphp

            @if($statusIndex >= 0)
                <div class="space-y-6">
                    @foreach($steps as $idx => $step)
                        @php
                            $isActive = $idx === $statusIndex;
                            $isCompleted = $idx < $statusIndex;
                        @endphp
                        <div class="flex items-start">
                            <!-- Timeline Node -->
                            <div class="flex flex-col items-center">
                                <div class="@if($isActive || $isCompleted) bg-green-500 @else bg-gray-300 @endif w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-lg @if($isActive) ring-4 ring-green-200 @endif">
                                    @if($isCompleted)
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                                    @else
                                        {{ $step['icon'] }}
                                    @endif
                                </div>
                                @if($idx < count($steps) - 1)
                                    <div class="w-1 @if($isCompleted) bg-green-500 @else bg-gray-300 @endif" style="height: 60px; margin-top: 8px;"></div>
                                @endif
                            </div>

                            <!-- Timeline Content -->
                            <div class="ml-6 flex-1 pb-6">
                                <div class="@if($isActive) font-bold text-green-600 @elseif($isCompleted) text-gray-900 @else text-gray-600 @endif text-base">
                                    {{ $step['label'] }}
                                </div>
                                @if($isActive)
                                    <p class="text-sm text-gray-600 mt-1">Sedang berlangsung</p>
                                @elseif($isCompleted)
                                    <p class="text-sm text-gray-600 mt-1">Selesai</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Special Status Timeline -->
                <div class="text-center py-8">
                    @if($order->status === 'rejected')
                        <div class="text-4xl mb-2">✕</div>
                        <p class="text-lg font-semibold text-red-600">Pesanan Ditolak</p>
                        <p class="text-sm text-gray-600 mt-1">Admin telah menolak pesanan Anda</p>
                    @elseif($order->status === 'canceled')
                        <div class="text-4xl mb-2">✕</div>
                        <p class="text-lg font-semibold text-red-600">Pesanan Dibatalkan</p>
                        <p class="text-sm text-gray-600 mt-1">Pesanan ini telah dibatalkan</p>
                    @elseif($order->status === 'complained')
                        <div class="text-4xl mb-2">⚠</div>
                        <p class="text-lg font-semibold text-yellow-600">Ada Keluhan</p>
                        <p class="text-sm text-gray-600 mt-1">Keluhan sedang ditinjau oleh admin</p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Status Alert Messages -->
        @if($order->status === 'complained')
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                    <div class="ml-3">
                        <p class="font-semibold text-yellow-800">Keluhan telah dikirim</p>
                        <p class="text-sm text-yellow-700 mt-1">Tim admin akan meninjau keluhan Anda. Kami akan memberitahu Anda segera setelah ada perkembangan.</p>
                    </div>
                </div>
            </div>
        @endif

        @if(isset($complaint) && $complaint->status === 'confirmed')
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6 rounded">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0zm6 0a1 1 0 11-2 0 1 1 0 012 0zm2 4a1 1 0 100-2 1 1 0 000 2zm-6 0a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" /></svg>
                    <div class="ml-3 flex-1">
                        <p class="font-semibold text-blue-800">Admin telah menanggapi</p>
                        @php
                            $adminNote = null;
                            if(!empty($complaint->metadata) && is_array($complaint->metadata)) {
                                $adminNote = $complaint->metadata['admin_note'] ?? $complaint->metadata['note'] ?? null;
                            }
                        @endphp
                        <p class="text-sm text-blue-700 mt-2">{{ $adminNote ?? 'Admin telah menanggapi keluhan Anda.' }}</p>
                        
                        <div class="mt-4 flex items-center space-x-2">
                            <p class="text-sm font-medium text-blue-800">Apakah Anda puas dengan tanggapan ini?</p>
                        </div>
                        <form method="POST" action="{{ route('shop.complaints.satisfaction', $complaint->id) }}" class="mt-2 flex items-center space-x-2">
                            @csrf
                            <button type="submit" name="satisfied" value="yes" class="px-4 py-2 bg-green-800 hover:bg-green-700 text-white rounded-lg font-medium transition">Puas</button>
                            <button type="submit" name="satisfied" value="no" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-medium transition">Belum Puas</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        @if($order->status === 'rejected')
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-red-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                    <div class="ml-3">
                        <p class="font-semibold text-red-800">Pesanan telah ditolak</p>
                        <p class="text-sm text-red-700 mt-1">Alasan: <strong>{{ $order->metadata['reject_reason'] ?? 'Tidak ada alasan diberikan' }}</strong></p>
                        <p class="text-sm text-red-700 mt-2">Dana Anda akan dikembalikan segera.</p>
                    </div>
                </div>
            </div>

            @if(isset($complaint) && $complaint->status === 'rejected')
                @php
                    $adminNote = null;
                    if(!empty($complaint->metadata) && is_array($complaint->metadata)) {
                        $adminNote = $complaint->metadata['admin_note'] ?? $complaint->metadata['note'] ?? null;
                    }
                @endphp
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                        <div class="ml-3">
                            <p class="font-semibold text-red-800">Keluhan ditolak</p>
                            <p class="text-sm text-red-700 mt-2">Keterangan dari admin: <strong>{{ $adminNote ?? 'Admin tidak memberikan keterangan' }}</strong></p>
                            <div class="mt-4 flex items-center space-x-2">
                                <button id="btn-appeal" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">Ajukan Banding</button>
                            </div>
                            <script>
                                document.getElementById('btn-appeal')?.addEventListener('click', function(){
                                    document.getElementById('complaint-form').style.display = 'block';
                                    var complainBtn = document.getElementById('btn-complain');
                                    if(complainBtn) complainBtn.style.display = 'none';
                                    var titleInput = document.querySelector('#complaint-form input[name="title"]');
                                    if(titleInput){ titleInput.value = 'Banding: {{ addslashes($complaint->title ?? "") }}'; }
                                    setTimeout(function(){ window.scrollTo({ top: document.getElementById('complaint-form').offsetTop - 80, behavior: 'smooth' }); }, 50);
                                });
                            </script>
                        </div>
                    </div>
                </div>
            @endif

            @if(isset($complaint) && $complaint->status === 'closed')
                <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-800 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                        <div class="ml-3">
                            <p class="font-semibold text-green-800">Keluhan diselesaikan</p>
                            <p class="text-sm text-green-700 mt-1">{{ $complaint->metadata['admin_note'] ?? $complaint->metadata['note'] ?? 'Keluhan Anda telah ditandai sebagai diselesaikan.' }}</p>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        @php $cancelReq = data_get($order->metadata, 'cancel_request', null); @endphp
        @if(!empty($cancelReq) && is_array($cancelReq) && ($cancelReq['status'] ?? 'pending') === 'pending')
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd" /></svg>
                    <div class="ml-3">
                        <p class="font-semibold text-yellow-800">Permintaan pembatalan diajukan</p>
                        <p class="text-sm text-yellow-700 mt-1">Permintaan pembatalan Anda sedang menunggu konfirmasi admin.</p>
                        <p class="text-sm text-gray-700 mt-2"><strong>Alasan:</strong> {{ $cancelReq['reason'] ?? '-' }}</p>
                        <p class="text-xs text-gray-600">Diajukan: {{ $cancelReq['requested_at'] ?? '-' }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Recipient & Shipping Info Card -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Recipient Info -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center space-x-2 mb-4">
                    <svg class="w-5 h-5 text-green-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <h3 class="text-lg font-semibold text-gray-900">Penerima</h3>
                </div>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-gray-600 uppercase tracking-wide">Nama Penerima</p>
                        <p class="text-base font-semibold text-gray-900 mt-1">{{ $order->name }}</p>
                    </div>
                </div>
            </div>

            <!-- Shipping Info -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center space-x-2 mb-4">
                    <svg class="w-5 h-5 text-green-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                    <h3 class="text-lg font-semibold text-gray-900">Alamat Pengiriman</h3>
                </div>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $order->address }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi</h3>
            <div class="space-y-3">
                {{-- If admin has confirmed or shipped the order, show receive + action --}}
                @if(in_array($order->status, ['confirmed','on_the_way']))
                    <div class="flex flex-col sm:flex-row gap-3">
                        <form method="POST" action="{{ route('shop.orders.receive', $order->id) }}" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full px-4 py-3 bg-green-800 hover:bg-green-700 text-white rounded-lg font-semibold transition flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>Pesanan Sudah Diterima</span>
                            </button>
                        </form>

                        @if($order->status === 'confirmed')
                            {{-- For confirmed orders: allow user to request cancellation (provide reason) --}}
                            <button id="btn-open-cancel" class="flex-1 px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                <span>Batalkan Pesanan</span>
                            </button>
                        @else
                            {{-- For on_the_way orders: keep complain button --}}
                            <button id="btn-complain" class="flex-1 px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 6a9 9 0 110-18 9 9 0 010 18z"></path></svg>
                                <span>Ajukan Komplain</span>
                            </button>
                        @endif
                    </div>

                {{-- If order was rejected, show refund acknowledgement + complain --}}
                @elseif($order->status === 'rejected')
                    <div class="p-4 bg-amber-50 border border-amber-200 rounded-lg mb-3">
                        <p class="text-sm text-amber-800">Admin akan segera mengembalikan dana Anda. Apakah Anda sudah menerima pengembalian?</p>
                    </div>
                    @php $refundAck = data_get($order->metadata, 'refund_acknowledged', false); @endphp
                    <div class="flex flex-col sm:flex-row gap-3">
                        @if(!$refundAck)
                            <form method="POST" action="{{ route('shop.orders.refund_received', $order->id) }}" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Saya Sudah Menerima</span>
                                </button>
                            </form>

                            <button id="btn-complain" class="flex-1 px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 6a9 9 0 110-18 9 9 0 010 18z"></path></svg>
                                <span>Ajukan Komplain</span>
                            </button>
                        @else
                            <div class="flex-1 px-4 py-3 bg-green-100 text-green-800 rounded-lg font-semibold text-center">
                                ✓ Pengembalian telah dikonfirmasi
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Review Section (if delivered) -->
        @if($order->status === 'delivered')
            <div class="bg-gradient-to-r from-green-50 via-emerald-50 to-green-50 border-l-4 border-green-500 rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">Bagikan Pengalaman Anda</h3>
                        <p class="text-sm text-gray-600">Bantu pembeli lain dengan memberi ulasan produk ini</p>
                    </div>
                    <div>
                        @php $hasReview = \App\Models\Review::where('order_id', $order->id)->where('user_id', auth()->id())->exists(); @endphp
                        @if($hasReview)
                            <span class="inline-flex items-center px-4 py-2 bg-green-100 text-green-800 rounded-lg font-semibold">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                                Anda sudah memberi ulasan
                            </span>
                        @else
                            <a href="{{ route('orders.review.create', $order->id) }}" class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                <span>Beri Ulasan</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Complaint Form (Hidden) -->
        <div id="complaint-form" class="bg-white rounded-lg shadow-md p-6" style="display:none;">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Formulir Keluhan</h3>
            <form method="POST" action="{{ route('shop.orders.complain', $order->id) }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Judul Keluhan</label>
                    <input name="title" required placeholder="Contoh: Produk tidak sesuai dengan deskripsi" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Detail Penjelasan</label>
                    <textarea name="description" rows="5" placeholder="Jelaskan keluhan Anda secara detail..." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Foto Bukti (opsional)</label>
                    <input type="file" name="evidence" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg file:mr-3 file:px-3 file:py-2 file:bg-gray-100 file:border-0 file:rounded file:text-sm file:font-semibold hover:file:bg-gray-200" />
                    <p class="text-xs text-gray-600 mt-1">Format: JPG, PNG. Ukuran maksimal: 5MB</p>
                </div>
                <div class="flex items-center space-x-3 pt-4 border-t">
                    <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition">Kirim Keluhan</button>
                    <button type="button" id="btn-cancel-complain" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-semibold transition">Batal</button>
                </div>
            </form>
        </div>

        <!-- Cancel Form (Hidden) -->
        <div id="cancel-form" class="bg-white rounded-lg shadow-md p-6" style="display:none;">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Formulir Pembatalan Pesanan</h3>
            <form method="POST" action="{{ route('shop.orders.cancel', $order->id) }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Alasan Pembatalan</label>
                    <textarea name="cancel_reason" required rows="4" placeholder="Jelaskan mengapa Anda ingin membatalkan pesanan ini..." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none"></textarea>
                    <p class="text-xs text-gray-600 mt-1">Alasan akan dikirim ke admin untuk diproses.</p>
                </div>
                <div class="flex items-center space-x-3 pt-4 border-t">
                    <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition">Kirim Permintaan Pembatalan</button>
                    <button type="button" id="btn-cancel-cancel" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-semibold transition">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
    <script>
        // Open complaint form (for on_the_way)
        document.getElementById('btn-complain')?.addEventListener('click', function(){
            var cf = document.getElementById('complaint-form');
            if(cf){ cf.style.display = 'block'; }
            this.style.display = 'none';
        });
        document.getElementById('btn-cancel-complain')?.addEventListener('click', function(){
            var cf = document.getElementById('complaint-form');
            if(cf){ cf.style.display = 'none'; }
            var complainBtn = document.getElementById('btn-complain');
            if(complainBtn) complainBtn.style.display = 'inline-block';
        });

        // Open cancel form (for confirmed)
        document.getElementById('btn-open-cancel')?.addEventListener('click', function(){
            var cancelForm = document.getElementById('cancel-form');
            if(cancelForm) cancelForm.style.display = 'block';
            this.style.display = 'none';
        });
        document.getElementById('btn-cancel-cancel')?.addEventListener('click', function(){
            var cancelForm = document.getElementById('cancel-form');
            if(cancelForm) cancelForm.style.display = 'none';
            var openBtn = document.getElementById('btn-open-cancel');
            if(openBtn) openBtn.style.display = 'inline-block';
        });
    </script>
    @if(session('show_complaint_form'))
        <script>
            // If redirected after "Tidak" (not satisfied), auto-open complaint form
            document.addEventListener('DOMContentLoaded', function(){
                var form = document.getElementById('complaint-form');
                if (form) {
                    form.style.display = 'block';
                    var btn = document.getElementById('btn-complain');
                    if (btn) btn.style.display = 'none';
                    try { window.scrollTo({ top: form.offsetTop - 80, behavior: 'smooth' }); } catch(e) {}
                }
            });
        </script>
    @endif
@endsection
