@extends('admin.layout')

@section('title','Keluhan — Detail')

@section('content')
    <div class="bg-white p-6 rounded-xl shadow-md max-w-3xl">
        <h2 class="text-2xl font-semibold text-gray-900 mb-6">Detail Keluhan</h2>

        <div class="bg-gray-50 p-6 rounded-lg mb-6">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <div class="text-xl font-semibold text-gray-900">{{ $complaint->title }}</div>
                    <div class="text-sm text-gray-600 mt-2">Order: {{ $complaint->order?->order_number ?? $complaint->order_id }}</div>
                    <div class="text-sm text-gray-600">Pengirim: {{ $complaint->user?->name ?? 'Guest' }} (ID: {{ $complaint->user_id ?? '-' }})</div>
                </div>
                <div class="mt-4 sm:mt-0">
                    @if($complaint->status === 'rejected')
                        <div class="text-right">
                            <span class="px-3 py-1 rounded-lg bg-red-100 text-red-800 text-sm font-semibold">{{ ucfirst($complaint->status) }}</span>
                            <div class="text-sm text-red-700 mt-2 font-medium">Pengajuan komplain ditolak</div>
                            @if(is_array($complaint->metadata) && ($complaint->metadata['admin_note'] ?? null))
                                <div class="text-xs text-red-600 mt-2">Keterangan: {{ \Illuminate\Support\Str::limit($complaint->metadata['admin_note'], 300) }}</div>
                            @endif
                        </div>
                    @else
                        <span class="px-3 py-1 rounded-lg {{ $complaint->status === 'open' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }} text-sm font-semibold">{{ ucfirst($complaint->status) }}</span>
                    @endif
                </div>
            </div>
            <div class="mt-4 text-gray-700 leading-relaxed">{{ $complaint->description }}</div>
        </div>

        @if($complaint->evidence_path)
            <div class="mb-6">
                <div class="font-semibold text-gray-900 mb-3">Bukti Foto</div>
                <img src="{{ $complaint->evidence_path }}" alt="Bukti" class="max-w-sm rounded-lg shadow">
            </div>
        @endif

        <div class="bg-gray-50 p-6 rounded-lg">
            <form method="POST" action="{{ route('admin.complaints.resolve', $complaint->id) }}">
                @csrf
                <label class="block text-sm font-semibold text-gray-900 mb-3">Catatan Admin <span class="text-red-600">(wajib)</span></label>
                <textarea name="note" required class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-700 mb-4" rows="4"></textarea>
                <div class="flex gap-3">
                    <button name="action" value="confirm" class="px-4 py-2 bg-green-700 hover:bg-green-800 text-white font-medium rounded-lg transition">✓ Konfirmasi Ajuan</button>
                    <button name="action" value="reject" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition">✕ Tolak Ajuan</button>
                </div>
                @if($errors->has('note'))
                    <div class="mt-3 text-sm text-red-600">{{ $errors->first('note') }}</div>
                @endif
            </form>
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.complaints') }}" class="text-sm text-blue-600 hover:text-blue-800">← Kembali ke daftar keluhan</a>
        </div>
    </div>
@endsection
