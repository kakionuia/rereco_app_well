@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto p-6">
        <div class="bg-white rounded shadow p-6">
            <h2 class="text-2xl font-bold mb-4">Detail Pengajuan #{{ $submission->id }}</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500">Jenis</p>
                    <p class="font-semibold">{{ $submission->jenis }}</p>

                    <p class="text-sm text-gray-500 mt-4">Metode</p>
                    <p>{{ ucfirst($submission->metode) }}</p>

                    <p class="text-sm text-gray-500 mt-4">Deskripsi</p>
                    <p>{{ $submission->deskripsi }}</p>

                    <p class="text-sm text-gray-500 mt-4">Status</p>
                    <p class="font-semibold">{{ ucfirst($submission->status) }}</p>

                    <p class="text-sm text-gray-500 mt-4">Poin</p>
                    <p>{{ $submission->points_awarded ?? 0 }}</p>

                    @if($submission->status === 'rejected' && $submission->reject_reason)
                        <div class="mt-6 p-4 bg-red-50 border border-red-100 rounded">
                            <h4 class="font-semibold text-red-700 mb-2">Alasan Pengajuan Ditolak</h4>
                            <p class="text-sm text-red-700">{{ $submission->reject_reason }}</p>
                        </div>
                    @endif
                </div>

                <div>
                    @if($submission->foto_path)
                        <img src="{{ $submission->foto_path }}" alt="foto" class="w-full h-64 object-cover rounded">
                    @else
                        <div class="w-full h-64 bg-gray-100 flex items-center justify-center rounded">Tidak ada foto</div>
                    @endif
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('recycle') }}" class="text-blue-600 hover:underline">Kembali ke Pengajuan Saya</a>
            </div>
        </div>
    </div>
@endsection
