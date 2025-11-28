@extends('admin.layout')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Orders</h1>
        <form method="GET" action="{{ route('admin.orders') }}" class="flex items-center space-x-2">
            <input type="search" name="q" value="{{ $q ?? request('q') }}" placeholder="Cari order, nomor, pembeli..." class="px-3 py-2 border border-gray-300 rounded-md text-sm" />
            <button class="px-3 py-2 bg-green-800 text-white rounded text-sm">Cari</button>
            @if(!empty($q))
                <a href="{{ route('admin.orders') }}" class="px-3 py-2 bg-gray-100 rounded text-sm text-gray-700">Bersihkan</a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">#</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Order Number</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Buyer</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Product</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Qty</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Total</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Status</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($orders as $order)
                <tr>
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $order->id }}</td>
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $order->order_number }}</td>
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $order->user?->name ?? $order->name }}</td>
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $order->product_name }}</td>
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $order->qty }}</td>
                    <td class="px-4 py-2 text-sm text-gray-700">Rp {{ number_format($order->total,0,',','.') }}</td>
                    <td class="px-4 py-2 text-sm text-gray-700">
                        @php
                            switch($order->status) {
                                case 'rejected': $badge = 'bg-red-100 text-red-800'; break;
                                case 'canceled': $badge = 'bg-red-50 text-red-700'; break;
                                case 'confirmed': $badge = 'bg-green-100 text-green-800'; break;
                                case 'on_the_way': $badge = 'bg-amber-100 text-amber-800'; break;
                                case 'delivered': $badge = 'bg-green-100 text-green-800'; break;
                                case 'complained': $badge = 'bg-yellow-100 text-yellow-800'; break;
                                case 'pending': default: $badge = 'bg-gray-100 text-gray-800'; break;
                            }
                        @endphp
                        <span class="px-2 py-1 rounded text-sm {{ $badge }}">{{ str_replace('_',' ', ucfirst($order->status)) }}</span>
                    </td>
                    <td class="px-4 py-2 text-sm text-gray-700">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-sm text-blue-600">Lihat</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $orders->links() }}</div>
</div>
@endsection
