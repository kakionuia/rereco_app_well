@extends('admin.layout')

@section('title','Forum Thread')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">{{ $thread->title }}</h2>
    <div class="space-y-4 mb-6">
        @foreach($thread->messages as $m)
            <div class="p-4 rounded-lg {{ $m->is_admin ? 'bg-amber-50' : 'bg-gray-50' }}">
                <div class="flex gap-3 items-start">
                    <div class="w-9 h-9 rounded-full bg-gray-300 flex items-center justify-center text-white font-bold">{{ $m->user ? strtoupper(substr($m->user->name,0,1)) : ($m->is_admin ? 'A' : 'G') }}</div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <div class="text-sm font-semibold">{{ $m->user?->name ?? ($m->is_admin ? 'Admin' : 'Pengunjung') }}</div>
                            <div class="text-xs text-gray-400">{{ $m->created_at->format('j M Y H:i') }}</div>
                        </div>
                        <div class="text-sm text-gray-700 mt-2">{!! nl2br(e($m->body)) !!}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <form action="{{ route('admin.forum.reply', $thread->id) }}" method="POST" class="space-y-3">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700">Balas sebagai Admin</label>
            <textarea name="body" rows="4" class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2" required></textarea>
        </div>
        <div class="text-right">
            <button class="px-4 py-2 bg-green-600 text-white rounded">Kirim Balasan</button>
        </div>
    </form>
</div>
@endsection
