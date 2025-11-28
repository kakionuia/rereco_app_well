@extends('admin.layout')

@section('title','Tambah Produk')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="font-semibold mb-4">Tambah Produk Baru</h3>

        @if($errors->any())
            <div class="p-3 bg-red-50 text-red-700 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm text-gray-700">Nama Produk</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full mt-1 px-3 py-2 border rounded" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-700">Harga (Rp)</label>
                        <input type="text" name="price" value="{{ old('price') }}" placeholder="Contoh: 150000 untuk Rp 150.000" class="w-full mt-1 px-3 py-2 border rounded" required>
                        <p class="text-xs text-gray-500 mt-1">Masukkan harga dalam angka (tanpa simbol). Contoh: <code>150000</code> = Rp 150.000</p>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700">Stok</label>
                        <input type="number" name="stock" value="{{ old('stock', 0) }}" class="w-full mt-1 px-3 py-2 border rounded" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm text-gray-700">Kategori</label>
                    <select name="category_id" class="w-full mt-1 px-3 py-2 border rounded">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}" @if(old('category_id') == $c->id) selected @endif>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm text-gray-700">Deskripsi</label>
                    <textarea name="description" rows="6" class="w-full mt-1 px-3 py-2 border rounded">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm text-gray-700">Gambar Produk (opsional)</label>
                    <input type="file" name="image" accept="image/*" class="mt-1">
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Simpan Produk</button>
                    <a href="{{ route('admin.products') }}" class="text-sm text-gray-600">Batal</a>
                </div>
            </div>
        </form>
    </div>
@endsection
