@extends('admin.layout')

@section('title','Ulasan Pengguna')

@section('content')
<div>
    <h1 class="text-2xl font-bold mb-4">Ulasan Pengguna</h1>
    @if(session('success'))<div class="p-3 bg-green-100 text-green-800 rounded mb-4">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="p-3 bg-red-100 text-red-800 rounded mb-4">{{ session('error') }}</div>@endif
    @if(!empty($missing) && $missing)
        <div class="p-4 rounded bg-yellow-50 border border-yellow-200 mb-4">
            <div class="font-semibold text-yellow-800">Tabel ulasan tidak ditemukan</div>
            <div class="text-sm text-yellow-700 mt-1">Sepertinya Anda belum menjalankan migrasi database yang membuat tabel <code>reviews</code>.</div>
            <div class="mt-2 text-sm text-gray-700">Jalankan perintah berikut dari folder proyek untuk membuat tabel:</div>
            <pre class="mt-2 p-3 bg-gray-100 rounded text-sm">cd /Applications/XAMPP/xamppfiles/htdocs/proyek_tim
php artisan migrate</pre>
        </div>
    @endif

    <div class="bg-white p-4 rounded shadow">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="text-left text-gray-600">
                    <th class="px-3 py-2">User</th>
                    <th class="px-3 py-2">Produk</th>
                    <th class="px-3 py-2">Rating</th>
                    <th class="px-3 py-2">Ulasan</th>
                    <th class="px-3 py-2">Tanggal</th>
                    <th class="px-3 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reviews as $r)
                <tr class="border-t border-gray-300">
                    <td class="px-3 py-2">{{ $r->user->name }}</td>
                    <td class="px-3 py-2">{{ $r->product->name }}</td>
                    <td class="px-3 py-2">{{ $r->rating }}</td>
                    <td class="px-3 py-2">{{ \Illuminate\Support\Str::limit($r->body, 80) }}</td>
                    <td class="px-3 py-2">{{ $r->created_at->format('d M Y') }}</td>
                    <td class="px-3 py-2">
                        <form method="POST" action="{{ route('admin.reviews.destroy', $r->id) }}" onsubmit="return confirm('Hapus ulasan ini?');">
                            @csrf @method('DELETE')
                            <button class="px-3 py-1 bg-red-600 text-white rounded">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">{{ $reviews->links() }}</div>
    </div>
</div>
@endsection
