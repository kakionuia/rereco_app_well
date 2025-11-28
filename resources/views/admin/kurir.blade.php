@extends('admin.layout')

@section('title','Kurir Sampah')

@section('content')
    @if(session('success'))
        <div class="p-3 bg-green-50 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    <div class="bg-white p-6 rounded-xl shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Daftar Kurir Sampah</h3>
            <a href="{{ route('admin.kurir.create') }}" class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg font-semibold">+ Tambah Kurir</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Wilayah</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No. Telepon</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($kurirs as $kurir)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $kurir->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $kurir->adress }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $kurir->phone }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $kurir->email }}</td>
                            <td class="px-6 py-4 text-sm">
                                <a href="{{ route('admin.kurir.show', $kurir->id) }}" class="text-green-700 font-semibold hover:underline">Lihat</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada kurir.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
