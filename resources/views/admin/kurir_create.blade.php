@extends('admin.layout')

@section('title', 'Tambah Kurir Sampah')

@section('content')
    <div class="bg-white p-6 rounded-xl shadow-md max-w-lg mx-auto">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Tambah Akun Kurir Sampah</h3>
        <form method="POST" action="{{ route('admin.kurir.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Nama</label>
                <input type="text" name="name" class="w-full border border-gray-300 rounded-lg px-3 py-2" required value="{{ old('name') }}">
                @error('name')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Wilayah</label>
                <select name="wilayah" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                    <option value="">-- Pilih Wilayah --</option>
                    @foreach(\App\Models\Village::orderBy('name')->pluck('name') as $village)
                        <option value="{{ $village }}" {{ old('wilayah') == $village ? 'selected' : '' }}>{{ $village }}</option>
                    @endforeach
                </select>
                @error('wilayah')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">No. Telepon</label>
                <input type="text" name="phone" class="w-full border border-gray-300 rounded-lg px-3 py-2" required value="{{ old('phone') }}">
                @error('phone')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Email</label>
                <input type="email" name="email" class="w-full border border-gray-300 rounded-lg px-3 py-2" required value="{{ old('email') }}">
                @error('email')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Password</label>
                <input type="password" name="password" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                @error('password')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="flex justify-end">
                <a href="{{ route('admin.kurir') }}" class="mr-4 mt-2 text-gray-600 hover:underline">Batal</a>
                <button type="submit" class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg font-semibold">Simpan</button>
            </div>
        </form>
    </div>
@endsection
