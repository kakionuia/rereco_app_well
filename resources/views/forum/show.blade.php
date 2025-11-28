<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="max-w-3xl mx-auto px-4 py-10">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <header class="mb-4">
            <h2 class="text-xl font-bold">{{ $thread->title }}</h2>
            {{-- <div class="flex items-center gap-3 mt-2">
                <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-white font-bold">{{ strtoupper(substr($thread->name ?? 'U',0,1)) }}</div>
                <div class="text-sm text-gray-600">{{ $thread->name ?? 'Pengguna' }} <span class="text-xs text-gray-400">• {{ $thread->created_at->format('j M Y H:i') }}</span></div>
            </div> --}}
        </header>

        <div class="space-y-4">
            @foreach($thread->messages as $m)
                @php
                    $isFirst = $loop->first;
                    $isAdmin = $m->is_admin;
                    $isMe = auth()->check() && $m->user_id && auth()->id() === $m->user_id;
                @endphp

                <div class="flex items-start gap-3">
                    {{-- avatar --}}
                    <div class="shrink-0">
                        @if($isAdmin)
                            <div class="w-9 h-9 rounded-full bg-orange-400 flex items-center justify-center text-white font-bold">A</div>
                        @elseif($m->user && $m->user->profile_photo_path)
                            <img src="{{ Storage::url($m->user->profile_photo_path) }}" alt="avatar" class="w-9 h-9 rounded-full object-cover">
                        @else
                            <div class="w-9 h-9 rounded-full bg-gray-300 flex items-center justify-center text-white font-bold">{{ strtoupper(substr($m->user?->name ?? $m->thread->name ?? 'G', 0,1)) }}</div>
                        @endif
                    </div>

                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="text-sm font-semibold">
                                    @if($isAdmin)
                                        {{ 'Admin' }}
                                    @elseif($isMe)
                                        {{ 'Anda' }}
                                    @else
                                        {{ $m->user?->name ?? $m->thread->name ?? 'Pengguna' }}
                                    @endif
                                </div>
                                @if($isAdmin)
                                    <span class="inline-block text-[11px] px-2 py-1 rounded-full bg-orange-50 text-orange-700">Admin</span>
                                @elseif($isMe)
                                    <span class="inline-block text-[11px] px-2 py-1 rounded-full bg-green-50 text-green-700">Anda</span>
                                @endif
                            </div>
                            <div class="text-xs text-gray-400">{{ $m->created_at->format('j M Y H:i') }}</div>
                        </div>

                        {{-- message bubble: first message (question) vs replies have different bg --}}
                        @if($isFirst)
                            <div class="mt-2 p-4 rounded-lg bg-gray-50 border border-gray-100">
                                <div class="text-sm text-gray-800">{!! nl2br(e($m->body)) !!}</div>
                            </div>
                        @elseif($isAdmin)
                            <div class="mt-2 p-3 rounded-lg bg-orange-50 border border-orange-100">
                                <div class="text-sm text-orange-800">{!! nl2br(e($m->body)) !!}</div>
                            </div>
                        @elseif($isMe)
                            <div class="mt-2 p-3 rounded-lg bg-green-600 text-white">
                                <div class="text-sm">{!! nl2br(e($m->body)) !!}</div>
                            </div>
                        @else
                            <div class="mt-2 p-3 rounded-lg bg-white border border-gray-100">
                                <div class="text-sm text-gray-700">{!! nl2br(e($m->body)) !!}</div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Composer: allow any user to reply (guest will be labeled Pengunjung) --}}
        {{-- Composer: logged-in users will show their profile, guests will post as Pengguna (G) --}}
        <div class="mt-6">
            <form action="{{ route('forum.reply', $thread->id) }}" method="POST">@csrf
                <div class="flex gap-3 items-start">
                    <div class="shrink-0">
                        @if(auth()->check() && auth()->user()->profile_photo_path)
                            <img src="{{ Storage::url(auth()->user()->profile_photo_path) }}" alt="you" class="w-9 h-9 rounded-full object-cover">
                        @else
                            <div class="w-9 h-9 rounded-full bg-gray-300 flex items-center justify-center text-white font-bold">@if(auth()->check()) {{ strtoupper(substr(auth()->user()->name,0,1)) }} @else G @endif</div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <textarea name="body" rows="3" placeholder="Tulis balasan Anda..." class="w-full rounded-md bg-white px-3 py-2 focus:outline-none border border-gray-100" required></textarea>
                    </div>
                    <div class="flex items-end">
                        <button class="bg-green-600 text-white px-4 py-2 rounded-lg">Kirim</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="max-w-3xl mx-auto px-4 py-6">
        <a href="{{ route('forum.index') }}" class="text-sm text-gray-600">← Kembali ke Forum</a>
    </div>

</body>
</html>