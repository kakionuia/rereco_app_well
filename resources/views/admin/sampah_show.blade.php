@extends('admin.layout')

@section('content')
    <div class="p-6">
        <h2 class="text-2xl font-semibold text-gray-900 mb-6">Detail Pengajuan #{{ $submission->id }}</h2>

        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="mb-6 bg-gray-50 rounded-lg p-4">
                <h4 class="font-semibold text-gray-900 mb-2">Pengirim</h4>
                @if($submission->user)
                    <p class="text-sm text-gray-700">{{ $submission->user->name }} — <a href="{{ route('admin.users.show', $submission->user->id) }}" class="text-blue-600 hover:text-blue-800">Lihat profil</a></p>
                    <p class="text-sm text-gray-600 mt-1">{{ $submission->user->email }}</p>
                    <p class="text-sm text-gray-600">{{ $submission->user->phone ?? '-' }}</p>
                @else
                    <p class="text-sm text-gray-600">Pengguna tidak terdaftar / guest</p>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="mb-4">
                        <p class="text-xs text-gray-600 uppercase tracking-wider font-semibold">Jenis</p>
                        <h3 class="text-lg font-semibold text-gray-900 mt-1">{{ $submission->jenis }}</h3>
                    </div>

                    <div class="mb-4">
                        <p class="text-xs text-gray-600 uppercase tracking-wider font-semibold">Metode</p>
                        <p class="text-gray-900 mt-1">{{ $submission->metode }}</p>
                    </div>

                    <div class="mb-4">
                        <p class="text-xs text-gray-600 uppercase tracking-wider font-semibold">Deskripsi</p>
                        <p class="text-gray-900 mt-1">{{ $submission->deskripsi }}</p>
                    </div>

                    @if($submission->metode === 'pickup')
                        <div class="border-t border-gray-200 pt-4">
                            <p class="text-xs text-gray-600 uppercase tracking-wider font-semibold">Nama Penjemput</p>
                            <p class="text-gray-900 mt-1">{{ $submission->nama_pickup }}</p>

                            <p class="text-xs text-gray-600 uppercase tracking-wider font-semibold mt-3">Alamat</p>
                            <p class="text-gray-900 mt-1">{{ $submission->alamat_pickup }}</p>

                            <p class="text-xs text-gray-600 uppercase tracking-wider font-semibold mt-3">Tanggal Pickup</p>
                            <p class="text-gray-900 mt-1">{{ $submission->tanggal_pickup }}</p>

                            <p class="text-xs text-gray-600 uppercase tracking-wider font-semibold mt-3">Waktu Pickup</p>
                            <p class="text-gray-900 mt-1">{{ $submission->tanggal_pickup ?? '-' }} {{ $submission->waktu_pickup ? 'pukul ' . $submission->waktu_pickup : '' }}</p>
                        </div>
                    @endif
 
                </div>

                <div>
                    @if($submission->foto_path)
                        <img src="{{ $submission->foto_path }}" alt="foto" class="w-full h-64 object-cover rounded-lg shadow">
                    @else
                        <div class="w-full h-64 bg-gray-100 flex items-center justify-center rounded-lg text-gray-500">Tidak ada foto</div>
                    @endif
                </div>
            </div>

            <div class="mt-6 bg-gray-50 p-6 rounded-lg">
                <div class="space-y-2">
                    <div class="text-sm"><strong>Status:</strong> {{ ucfirst($submission->status) }}</div>
                    <div class="text-sm"><strong>Poin diberikan oleh kurir:</strong> {{ $submission->points_awarded ?? 0 }}</div>
                    @if($submission->status === 'rejected')
                        <div class="text-sm text-red-700"><strong>Alasan ditolak:</strong> {{ $submission->reject_reason ?? '-' }}</div>
                    @endif
                    @if($submission->admin_message)
                        <div class="text-sm text-gray-700"><strong>Catatan Kurir:</strong> {{ $submission->admin_message }}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-6 flex flex-col md:flex-row md:items-center md:space-x-4 space-y-2 md:space-y-0">
            <a href="{{ route('admin.sampah') }}" class="text-sm text-blue-600 hover:text-blue-800">← Kembali</a>
            @if($submission->status !== 'rejected')
            <form method="POST" action="{{ route('admin.sampah.reject', $submission->id) }}" class="inline-block">
                @csrf
                <input type="hidden" name="reason" value="">
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold ml-2">Tolak Pengajuan</button>
            </form>
            @endif
            <form method="POST" action="{{ route('admin.sampah.destroy', $submission->id) }}" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus pengajuan ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-semibold ml-2">Hapus Pengajuan</button>
            </form>
        </div>
    </div>
@endsection
