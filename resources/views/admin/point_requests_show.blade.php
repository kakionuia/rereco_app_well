@extends('admin.layout')

@section('title','Detail Permintaan Poin')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <a href="{{ route('admin.point_requests') }}" class="text-sm text-blue-600 hover:underline">&larr; Kembali ke daftar</a>

        <h3 class="text-xl font-semibold mt-4">Permintaan Poin #{{ $req->id }}</h3>

        @php $d = $req->data ?? []; @endphp

        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <div class="text-sm text-gray-600">Pengguna</div>
                <div class="font-semibold">{{ $req->user?->name ?? 'Pengguna Terhapus' }} (ID: {{ $req->user_id }})</div>
                <div class="text-sm text-gray-600 mt-2">Email</div>
                <div>{{ $req->user?->email ?? '-' }}</div>
                <div class="text-sm text-gray-600 mt-2">Nomor Telepon</div>
                <div>{{ $d['phone'] ?? ($req->user?->phone ?? '-') }}</div>
            </div>

            <div>
                <div class="text-sm text-gray-600">Poin Diminta</div>
                <div class="font-semibold">{{ number_format($d['points'] ?? 0) }}</div>
                <div class="text-sm text-gray-600 mt-2">Nominal (IDR)</div>
                <div class="font-semibold">Rp {{ number_format($d['amount_idr'] ?? 0,0,',','.') }}</div>
                <div class="text-sm text-gray-600 mt-2">Provider</div>
                <div>{{ strtoupper($d['provider'] ?? '-') }}</div>
                <div class="text-sm text-gray-600 mt-2">Status</div>
                <div>{{ ucfirst($d['status'] ?? 'pending') }}</div>
            </div>
        </div>

        <div class="mt-6">
            @if(($d['status'] ?? 'pending') !== 'completed')
                <form method="POST" action="{{ route('admin.point_requests.complete', $req->id) }}" onsubmit="return confirm('Tandai permintaan ini sebagai selesai (sudah dikirim)?');">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded">Tandai Selesai</button>
                </form>
            @else
                <div class="p-3 bg-green-50 text-green-800 rounded">Permintaan ini sudah ditandai selesai pada {{ $d['completed_at'] ?? '—' }} oleh admin ID {{ $d['admin_id'] ?? '—' }}.</div>
            @endif
        </div>

    </div>
@endsection
