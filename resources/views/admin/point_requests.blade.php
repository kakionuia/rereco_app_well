@extends('admin.layout')

@section('title','Permintaan Poin')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-lg font-semibold mb-4">Daftar Permintaan Poin</h3>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-gray-600 uppercase"><th class="px-4 py-2">ID</th><th class="px-4 py-2">Pengguna</th><th class="px-4 py-2">Poin</th><th class="px-4 py-2">Nominal (IDR)</th><th class="px-4 py-2">Provider</th><th class="px-4 py-2">No. Telp</th><th class="px-4 py-2">Status</th><th class="px-4 py-2">Dibuat</th><th class="px-4 py-2">Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($requests as $r)
                        @php $d = $r->data ?? []; @endphp
                        <tr class="border-t">
                            <td class="px-4 py-3">{{ $r->id }}</td>
                            <td class="px-4 py-3">{{ $r->user?->name ?? 'Pengguna Terhapus' }}</td>
                            <td class="px-4 py-3">{{ number_format($d['points'] ?? 0) }}</td>
                            <td class="px-4 py-3">Rp {{ number_format($d['amount_idr'] ?? 0,0,',','.') }}</td>
                            <td class="px-4 py-3">{{ strtoupper($d['provider'] ?? '-') }}</td>
                            <td class="px-4 py-3">{{ $d['phone'] ?? ($r->user?->phone ?? '-') }}</td>
                            <td class="px-4 py-3">{{ ucfirst($d['status'] ?? 'pending') }}</td>
                            <td class="px-4 py-3">{{ $r->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-4 py-3"><a href="{{ route('admin.point_requests.show', $r->id) }}" class="text-blue-600 hover:underline">Lihat</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="p-4 text-gray-600">Belum ada permintaan poin.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $requests->links() }}
        </div>
    </div>
@endsection
