@extends('admin.layout')

@section('title','Edit Produk')

@section('content')
    <div class="bg-white p-6 rounded-xl shadow-md max-w-2xl">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Edit Produk</h3>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-700" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Harga (Rp)</label>
                    <input type="text" name="price" value="{{ old('price', $product->price) }}" placeholder="Contoh: 150000 untuk Rp 150.000" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-700" required>
                    <p class="text-xs text-gray-500 mt-1">Masukkan harga dalam angka (tanpa simbol). Contoh: <code>150000</code> = Rp 150.000</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Stok</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-700" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                    <select name="category_id" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-700">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}" @if($product->category_id == $c->id) selected @endif>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description" rows="6" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-700">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="flex items-center gap-3 pt-3">
                    <button type="submit" class="px-4 py-2 bg-green-700 hover:bg-green-800 text-white font-medium rounded-lg transition">Simpan</button>
                    <a href="{{ route('admin.products') }}" class="text-sm text-gray-600 hover:text-gray-800">Batal</a>
                </div>
            </div>
        </form>
    </div>
@endsection
