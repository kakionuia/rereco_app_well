@extends('admin.layout')

@section('title','Manage Vouchers')

@section('content')
<div class="">
    <h1 class="text-2xl font-bold mb-4">Manage Vouchers</h1>

    @if(session('success'))<div class="p-3 bg-emerald-100 text-emerald-800 rounded mb-4">{{ session('success') }}</div>@endif

    <div class="bg-white rounded-lg p-4 shadow-sm">
        <table class="min-w-full">
            <thead>
                <tr class="text-left text-sm text-gray-600">
                    <th class="px-3 py-2">Tier</th>
                    <th class="px-3 py-2">Code</th>
                    <th class="px-3 py-2">Discount</th>
                    <th class="px-3 py-2">Stock</th>
                    <th class="px-3 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vouchers as $v)
                <tr class="border-t border-gray-300">
                    <td class="px-3 py-2">{{ ucfirst($v->tier) }}</td>
                    <td class="px-3 py-2">{{ $v->code }}</td>
                    <td class="px-3 py-2">@if($v->discount_type === 'percent') {{ $v->discount_value }}% @else Rp {{ number_format($v->discount_value,0,',','.') }} @endif</td>
                    <td class="px-3 py-2">{{ $v->stock }}</td>
                    <td class="px-3 py-2">
                        <form action="{{ route('admin.vouchers.update', $v->id) }}" method="POST" class="flex items-center space-x-2">
                            @csrf @method('PATCH')
                            <input type="number" name="stock" value="{{ $v->stock }}" min="0" class="w-24 px-2 py-1 border rounded">
                            <input type="number" name="discount_value" value="{{ $v->discount_value }}" min="0" class="w-20 px-2 py-1 border rounded">
                            <button class="px-3 py-1 bg-green-800 text-white rounded">Update</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
