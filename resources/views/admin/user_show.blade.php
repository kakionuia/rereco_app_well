@extends('admin.layout')

@section('title','Detail Pengguna')

@section('content')
    @if(session('success'))
        <div class="p-3 bg-green-50 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    <div class="bg-white p-6 rounded-xl shadow-md max-w-2xl">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Detail Pengguna</h3>

        <div class="space-y-4">
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-xs text-gray-600 uppercase tracking-wider font-semibold">Nama</p>
                <p class="text-base font-medium text-gray-900 mt-1">{{ $user->name }}</p>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-xs text-gray-600 uppercase tracking-wider font-semibold">Email</p>
                <p class="text-base font-medium text-gray-900 mt-1">{{ $user->email }}</p>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-xs text-gray-600 uppercase tracking-wider font-semibold">Telepon</p>
                <p class="text-base font-medium text-gray-900 mt-1">{{ $user->phone ?? '-' }}</p>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-xs text-gray-600 uppercase tracking-wider font-semibold">Poin</p>
                <p class="text-base font-medium text-gray-900 mt-1">{{ $user->points ?? 0 }}</p>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-xs text-gray-600 uppercase tracking-wider font-semibold">Alamat</p>
                <p class="text-base font-medium text-gray-900 mt-1">{{ $user->adress ?? '-' }}</p>
                @if($user->village)
                    <p class="text-xs text-gray-600 mt-2">Wilayah: <span class="font-semibold text-gray-800">{{ $user->village }}</span></p>
                @endif
            </div>

            <div class="flex gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.users') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition">Kembali</a>
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?');" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition">Hapus</button>
                </form>
            </div>
        </div>
    </div>
@endsection
