@extends('admin.layout')

@section('title','Detail Kurir')

@section('content')
    <div class="bg-white p-6 rounded-xl shadow-md">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-xl font-semibold text-gray-900">Detail Kurir</h3>
                <p class="text-sm text-gray-600">Informasi akun dan statistik penjemputan</p>
            </div>
            <a href="{{ route('admin.kurir') }}" class="text-sm text-green-700 font-semibold">&larr; Kembali</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="p-4 border border-gray-300 rounded-lg">
                <h4 class="text-sm font-semibold text-gray-700">Nama</h4>
                <div class="mt-2 text-lg font-medium text-gray-900">{{ $kurir->name }}</div>
                <div class="mt-1 text-sm text-gray-600">{{ $kurir->email }}</div>
            </div>
            <div class="p-4 border border-gray-300 rounded-lg">
                <h4 class="text-sm font-semibold text-gray-700">Total Kg Diterima Bulan Ini</h4>
                <div class="mt-2 text-lg font-medium text-gray-900">{{ (int) $totalKg }} kg</div>
                <div class="mt-1 text-sm text-gray-600">(Hanya penimbangan selesai)</div>
            </div>
            <div class="p-4 border border-gray-300 rounded-lg">
                <h4 class="text-sm font-semibold text-gray-700">Total Poin Diberikan</h4>
                <div class="mt-2 text-lg font-medium text-gray-900">{{ $totalPoints }}</div>
                <div class="mt-1 text-sm text-gray-600">(Jumlah poin tercatat pada tiap pengajuan)</div>
            </div>
        </div>

        <div class="mt-4">
            <h4 class="text-lg font-semibold text-gray-800 mb-3">Riwayat Pengajuan Sampah</h4>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700">ID</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700">Tanggal Pickup</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700">Jenis</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700">Berat (kg)</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700">Poin</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($submissions as $s)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $s->id }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ optional($s->tanggal_pickup)->format('Y-m-d') }} {{ $s->waktu_pickup ?? '' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $s->jenis }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ ucfirst($s->status) }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $s->berat_aktual ? (int)$s->berat_aktual : '-' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $s->points_awarded ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-green-700">
                                    <a href="{{ route('admin.sampah.show', $s->id) }}" class="font-semibold hover:underline">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-4 py-4 text-center text-gray-500">Belum ada pengajuan yang diterima oleh kurir ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
