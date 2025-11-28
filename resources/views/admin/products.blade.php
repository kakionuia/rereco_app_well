@extends('admin.layout')

@section('title','Kelola Produk')

@section('content')
    @if(session('success'))
        <div class="p-3 bg-green-50 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    <div class="bg-white p-6 rounded-xl shadow-md">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Daftar Produk</h3>
            <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-700 hover:bg-green-800 text-white font-medium rounded-lg text-sm transition">+ Tambah Produk</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($products as $product)
                @php
                    $catName = strtolower($product->category?->slug ?? $product->category?->name ?? '');
                    $isReward = ($catName === 'rewards' || $catName === 'reward');
                @endphp

                @unless($isReward)
                <div class="bg-gray-50 rounded-lg overflow-hidden hover:shadow-lg transition duration-300 relative">
                    <img src="{{ $product->image ?? '/image/tutup.jpg' }}" alt="{{ $product->name }}" class="w-full h-40 object-cover">
                    <div class="p-4">
                        <h4 class="font-semibold text-sm text-gray-900 truncate">{{ $product->name }}</h4>
                        <div class="text-xs text-gray-500 mt-1">{{ $product->category?->name }}</div>
                        <div class="mt-3 flex items-center justify-between">
                            <div class="text-green-700 font-bold">Rp {{ number_format($product->price,0,',','.') }}</div>
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-800 transition text-sm">Edit</a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 transition text-sm">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endunless
            @endforeach
        </div>

        <div class="mt-4">{{ $products->links() }}</div>
    </div>
@endsection
