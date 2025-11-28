@extends('admin.layout')

@section('content')
<div class="p-6 max-w-3xl">
    <h1 class="text-2xl font-bold mb-4">Order #{{ $order->order_number }}</h1>

    <div class="bg-white p-4 rounded shadow">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="md:col-span-2">
                <h2 class="text-lg font-semibold">{{ $order->product_name }}</h2>
                <p class="text-sm text-gray-600">Jumlah: {{ $order->qty }}</p>
                <p class="text-sm text-gray-600">Total: Rp {{ number_format($order->total,0,',','.') }}</p>
                <p class="mt-2 text-sm">Nama: {{ $order->name }}</p>
                <p class="text-sm">Alamat: {{ $order->address }}</p>
                <p class="text-sm">Metode: {{ $order->payment_method }}</p>
                <p class="text-sm">Status:
                    @php
                        switch($order->status) {
                            case 'rejected': $badge = 'text-red-600'; break;
                            case 'confirmed': $badge = 'text-green-600'; break;
                            case 'delivered': $badge = 'text-green-600'; break;
                            case 'complained': $badge = 'text-yellow-600'; break;
                            case 'pending': default: $badge = 'text-gray-600'; break;
                        }
                    @endphp
                    <strong class="{{ $badge }}">{{ ucfirst($order->status) }}</strong>
                </p>
                @php $rewardNote = $order->metadata['reward_note'] ?? null; @endphp
                @if($rewardNote)
                    <p class="mt-2 text-sm text-gray-700"><strong>Catatan (Rewards):</strong> {{ $rewardNote }}</p>
                @endif
                @php $cancelReq = $order->metadata['cancel_request'] ?? null; @endphp
                @if(!empty($cancelReq) && is_array($cancelReq))
                    <div class="mt-4 p-3 border border-gray-300 rounded bg-yellow-50">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-semibold text-yellow-800">Permintaan Pembatalan oleh Pengguna</p>
                                <p class="text-sm text-gray-700 mt-1"><strong>Alasan:</strong> {{ $cancelReq['reason'] ?? '-' }}</p>
                                <p class="text-xs text-gray-600 mt-1">Diajukan: {{ $cancelReq['requested_at'] ?? '-' }}</p>
                                <p class="text-xs text-gray-600">Status: {{ ucfirst($cancelReq['status'] ?? 'pending') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                @php $rewardBankAccount = $order->metadata['reward_bank_account'] ?? null; @endphp
                @if($rewardBankAccount)
                    <p class="mt-2 text-sm text-gray-700"><strong>No. Rekening (Rewards):</strong> {{ $rewardBankAccount }}</p>
                @endif
            </div>
            <div class="md:col-span-1">
                <div class="space-y-2">
                    @if($order->status === 'pending')
                        <form method="POST" action="{{ route('admin.orders.confirm', $order->id) }}">@csrf
                            <button class="w-full px-3 py-2 bg-green-600 text-white rounded">Konfirmasi Pembayaran</button>
                        </form>

                        <form method="POST" action="{{ route('admin.orders.reject', $order->id) }}">@csrf
                            <textarea name="reason" placeholder="Alasan penolakan (opsional)" class="w-full mt-2 p-2 border rounded" rows="3"></textarea>
                            <button class="w-full mt-2 px-3 py-2 bg-red-600 text-white rounded">Tolak Order</button>
                        </form>

                    @elseif($order->status === 'confirmed')
                        <form method="POST" action="{{ route('admin.orders.ship', $order->id) }}">@csrf
                            <button class="w-full px-3 py-2 bg-emerald-600 text-white rounded">Dikirim</button>
                        </form>

                        @php $cancelReq = $order->metadata['cancel_request'] ?? null; @endphp
                        @if(!empty($cancelReq) && is_array($cancelReq) && ($cancelReq['status'] ?? 'pending') === 'pending')
                            <form method="POST" action="{{ route('admin.orders.cancel_request', $order->id) }}">@csrf
                                <input type="hidden" name="action" value="accept" />
                                <input type="hidden" name="note" value="" />
                                <button class="w-full mt-2 px-3 py-2 bg-red-600 text-white rounded">Terima Permintaan Pembatalan</button>
                            </form>
                            <form method="POST" action="{{ route('admin.orders.cancel_request', $order->id) }}">@csrf
                                <input type="hidden" name="action" value="reject" />
                                <div class="mt-2">
                                    <textarea name="note" placeholder="Catatan admin (opsional)" class="w-full p-2 border rounded" rows="2"></textarea>
                                </div>
                                <button class="w-full mt-2 px-3 py-2 bg-yellow-600 text-white rounded">Tolak Permintaan Pembatalan</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.orders.cancel', $order->id) }}">@csrf
                                <button class="w-full mt-2 px-3 py-2 bg-red-600 text-white rounded">Batalkan Order</button>
                            </form>
                        @endif

                    @elseif($order->status === 'canceled')
                        <form method="POST" action="{{ route('admin.orders.destroy', $order->id) }}">@csrf @method('DELETE')
                            <div class="text-sm text-gray-600">Order telah dibatalkan. Jika ingin menghapus permanen, klik tombol di bawah.</div>
                            <button type="submit" class="w-full mt-2 px-3 py-2 bg-red-600 text-white rounded">Hapus Order</button>
                        </form>
                    @else
                        <div class="text-sm text-gray-600">Tidak ada tindakan tersedia.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.orders') }}" class="text-sm text-gray-600 hover:underline">&larr; Kembali ke daftar orders</a>
    </div>
</div>
@endsection
