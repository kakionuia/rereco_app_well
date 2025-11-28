<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    
<div class="container mx-auto p-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold">Detail Karyawan Kurir</h1>
            <p class="text-sm text-gray-600">Nama akun: <span class="font-semibold">{{ $kurir->name }}</span></p>
            <p class="text-sm text-gray-600">Wilayah tugas: <span class="font-semibold">{{ $kurir->village ?? $kurir->adress ?? '-' }}</span></p>
        </div>
        <div class="text-right">
            <a href="{{ route('kurir.dashboard') }}" class="text-sm text-green-800 hover:text-green-800">← Kembali ke Dashboard</a>
        </div>
    </div>

    <div class="bg-white shadow-xl rounded-xl p-6 sm:p-8 mb-8 border-t-4 border-green-700">
        <div class="flex flex-col sm:flex-row items-center sm:items-start space-y-4 sm:space-y-0 sm:space-x-6">
            <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 text-xl font-semibold">
                {{ strtoupper(substr($kurir->name,0,2)) }}
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $kurir->name }}</h2>
                <p class="text-lg text-green-800 font-semibold">Status: {{ ($kurir->is_kurir ? 'Aktif' : 'Nonaktif') }}</p>
                <p class="text-gray-500 mt-1">Mulai Bekerja: {{ $kurir->created_at ? $kurir->created_at->format('d M Y') : '-' }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">

            @php
                $formatKg = function($v) {
                    if ($v === null || $v === '') return '0kg';
                    $n = (float) $v;
                    if ($n == (int) $n) return (int)$n . 'kg';
                    // Trim trailing zeros
                    $s = rtrim(rtrim(number_format($n, 2, '.', ''), '0'), '.');
                    return $s . 'kg';
                };
            @endphp

            <div class="bg-green-800 text-white shadow-xl rounded-xl p-6">
            <p class="text-sm font-medium uppercase opacity-90">Total Sampah Terkumpul (Selesai)</p>
            <div class="flex items-end justify-between mt-2">
                <span class="text-5xl font-extrabold">
                    {{ $formatKg($totalKg ?? 0) }}
                </span>
            </div>
            <p class="mt-4 text-xs opacity-80">Data diperbarui terakhir: {{ optional($tasks->first())->updated_at ? $tasks->first()->updated_at->format('d M Y') : '-' }}</p>
        </div>

        <div class="bg-yellow-500 text-white shadow-xl rounded-xl p-6">
            <p class="text-sm font-medium uppercase opacity-90">Total Poin Akumulasi (dari Tugas Selesai)</p>
            <div class="flex items-end justify-between mt-2">
                <span class="text-5xl font-extrabold">
                    {{ number_format($totalPoints ?? 0) }}
                </span>
                <span class="text-3xl font-light">
                    Poin
                </span>
            </div>
            <p class="mt-4 text-xs opacity-80">Poin dapat ditukar dengan insentif bulanan.</p>
        </div>
    </div>

    <div class="bg-white shadow-xl rounded-xl overflow-hidden">
        <div class="p-6 bg-gray-50 border-b">
            <h3 class="text-xl font-bold text-gray-800">Riwayat Penjemputan (Selesai)</h3>
            <p class="text-sm text-gray-500">Daftar tugas yang sudah selesai ditangani oleh Anda.</p>
        </div>

        <ul class="divide-y divide-gray-200">
            @forelse($tasks as $task)
                <li class="p-4 sm:p-6 hover:bg-green-50 transition duration-100 flex justify-between items-center">
                    <div>
                        <p class="text-lg font-semibold text-gray-800">Penjemputan #{{ $task->id }} — {{ $task->jenis ?? '-' }}</p>
                        <p class="text-sm text-gray-500">Pengguna: {{ $task->user?->name ?? '-' }} ({{ $task->user?->phone ?? '-' }})</p>
                        <p class="text-sm text-gray-500">Alamat: {{ $task->alamat_pickup ?? '-' }}</p>
                        <p class="text-sm text-gray-500">Janji: {{ $task->tanggal_pickup ? $task->tanggal_pickup->format('d M Y') : '-' }}@if($task->waktu_pickup), pukul {{ $task->waktu_pickup }}@endif</p>
                    </div>
                    <div class="text-right">
                        <p class="text-green-600 font-bold text-xl">@if($task->berat_aktual !== null){{ $formatKg($task->berat_aktual) }}@else-@endif</p>
                        <p class="text-sm text-gray-700">Poin: {{ $task->points_awarded ?? 0 }}</p>
                        <p class="text-xs text-gray-400">Selesai: {{ $task->updated_at->diffForHumans() }}</p>
                    </div>
                </li>
            @empty
                <li class="p-6 text-center text-gray-600">Belum ada riwayat penjemputan.</li>
            @endforelse
        </ul>

        <div class="p-4 text-center border-t border-gray-200">
            <a href="#" class="text-sm font-medium text-green-600 hover:text-green-800">Lihat Semua Riwayat</a>
        </div>
    </div>

</div>

</body>
</html>