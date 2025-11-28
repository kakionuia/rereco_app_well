@extends('admin.layout')

@section('title','Forum Diskusi')

@section('content')
<div class="bg-white p-6 rounded shadow-md">
    <h2 class="text-xl font-semibold mb-4">Forum Diskusi</h2>

    <div class="lg:flex lg:space-x-6">
        <div class="lg:w-1/3 border-r border-gray-300 pr-4">
            <div class="space-y-2">
                @foreach($threads as $t)
                    <a href="{{ route('admin.forum.show', $t->id) }}" class="block p-3 rounded hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="font-semibold">{{ $t->title }}</div>
                            <div class="text-xs text-gray-400">{{ $t->updated_at->diffForHumans() }}</div>
                        </div>
                        <div class="text-sm text-gray-500 mt-1">{{ $t->name ?? 'Pengguna' }} • {{ $t->messages()->count() }} pesan</div>
                    </a>
                @endforeach
            </div>
            <div class="mt-4">{{ $threads->links() }}</div>
        </div>

        <div class="lg:flex-1">
            <div class="p-6 bg-gray-50 rounded">
                <div class="text-sm text-gray-500">Pilih topik di sebelah kiri untuk melihat percakapan.</div>
            </div>
        </div>
    </div>
</div>
@endsection
