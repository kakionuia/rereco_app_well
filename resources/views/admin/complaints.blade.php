@extends('admin.layout')

@section('title','Keluhan Pengguna')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold">Daftar Keluhan</h2>
            <form method="GET" action="{{ route('admin.complaints') }}" class="flex items-center space-x-2">
                <input type="search" name="q" value="{{ $q ?? request('q') }}" placeholder="Cari keluhan, order atau pengguna..." class="px-3 py-2 border border-gray-300 rounded-md text-sm" />
                <button class="px-3 py-2 bg-green-800 text-white rounded text-sm">Cari</button>
                @if(!empty($q))
                    <a href="{{ route('admin.complaints') }}" class="px-3 py-2 bg-gray-100 rounded text-sm text-gray-700">Bersihkan</a>
                @endif
            </form>
        </div>
        @if($complaints->count())
            <div class="space-y-2">
                @foreach($complaints as $c)
                    <div class="p-3 border border-gray-300 rounded flex justify-between items-center">
                        <div>
                            <div class="font-semibold">{{ $c->title }}</div>
                            <div class="text-sm text-gray-600">Order: {{ $c->order->order_number ?? $c->order_id }} — oleh: {{ $c->user?->name ?? 'Guest' }}</div>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if($c->status === 'rejected')
                                <div class="text-right">
                                    <span class="text-sm px-2 py-1 rounded bg-red-100 text-red-800">{{ ucfirst($c->status) }}</span>
                                    @if(is_array($c->metadata) && ($c->metadata['admin_note'] ?? null))
                                        <div class="text-xs text-red-700 mt-1">Pengajuan komplain ditolak: {{ \Illuminate\Support\Str::limit($c->metadata['admin_note'], 120) }}</div>
                                    @else
                                        <div class="text-xs text-red-700 mt-1">Pengajuan komplain ditolak</div>
                                    @endif
                                </div>
                            @else
                                <span class="text-sm px-2 py-1 rounded {{ $c->status === 'open' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">{{ ucfirst($c->status) }}</span>
                            @endif
                            <a href="{{ route('admin.complaints.show', $c->id) }}" class="text-sm text-blue-600 hover:underline">Lihat</a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $complaints->links() }}
            </div>
        @else
            <div class="text-gray-600">Belum ada keluhan.</div>
        @endif
    </div>
@endsection
