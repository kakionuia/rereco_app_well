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
    {{-- @section('content') --}}
<div class="max-w-5xl mx-auto px-4 py-8 sm:py-12 bg-gray-50">
    <div class="space-y-8">
        <div class="flex justify-between items-center">
            <h2 class="text-4xl font-extrabold text-gray-900 border-b-4 border-green-700 pb-3 inline-block">
            Forum Diskusi
            </h2>
                 <a href="{{ route('recycle') }}" class="text-sm text-gray-600">← Kembali</a>
        </div>
        

        {{-- Post Composer (Modern, elevated card) --}}
        <div class="bg-white p-6 sm:p-8 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Mulai Diskusi Baru</h3>
            <form action="{{ route('forum.store') }}" method="POST" class="space-y-3">
                @csrf
                <div class="flex gap-4 items-start">
                    {{-- Avatar --}}
                    <div class="shrink-0">
                        @if(auth()->check() && auth()->user()->profile_photo_path)
                            <img src="{{ Storage::url(auth()->user()->profile_photo_path) }}" alt="avatar" class="w-12 h-12 rounded-full object-cover ring-1 ring-green-200" />
                        @else
                            <div class="w-12 h-12 bg-emerald-500 rounded-full flex items-center justify-center text-white text-lg font-bold shadow-sm">
                                @if(auth()->check()) {{ strtoupper(substr(auth()->user()->name,0,1)) }} @else G @endif
                            </div>
                        @endif
                    </div>

                    {{-- Inputs and Button --}}
                    <div class="flex-1 space-y-2">
                        <input 
                            name="title" 
                            placeholder="Judul singkat" 
                            class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2 text-base focus:ring-0 focus:border-green-700 transition duration-150" 
                        />
                        <textarea 
                            name="body" 
                            rows="4" 
                            placeholder="Tulis pertanyaan atau topik diskusi..." 
                            class="w-full rounded-lg border border-gray-200 bg-white px-4 py-3 focus:ring-0 focus:border-green-700 transition duration-150 resize-none" 
                            required
                        ></textarea>

                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-500">Ketik pertanyaan Anda. Tamu akan tampil sebagai Pengguna.</div>
                            <div class="text-right">
                                <button type="submit" class="inline-flex items-center gap-2 bg-green-700 text-white font-semibold py-2 px-4 rounded-full shadow-sm hover:bg-emerald-700 transition duration-200 focus:outline-none">
                                    Kirim
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <h3 class="text-2xl font-bold text-gray-800 border-b-2 border-gray-200 pb-2 mb-4">Pertanyaan Terbaru</h3>
        
        {{-- Thread List --}}
        <div class="space-y-4">
            @foreach($threads as $t)
                <a href="{{ route('forum.show', $t->id) }}" class="block bg-white p-4 sm:p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-0.5 transition-transform duration-200">
                    <div class="flex items-start gap-4">
                        {{-- Avatar/initials --}}
                        <div class="w-11 h-11 shrink-0 rounded-full bg-gray-100 text-gray-700 flex items-center justify-center font-semibold text-lg">
                            {{ strtoupper(substr($t->name ?? 'U',0,1)) }}
                        </div>

                        <div class="flex-1">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                <div class="min-w-0">
                                    <p class="text-lg font-semibold text-gray-900 truncate">{{ $t->title }}</p>
                                    <div class="text-sm text-gray-500 truncate mt-1">
                                        Oleh <span class="font-medium text-gray-700">{{ $t->name ?? 'Pengguna' }}</span>
                                        <span class="mx-1">•</span>
                                        <span>{{ $t->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>

                                {{-- Stats --}}
                                <div class="flex items-center gap-3 mt-3 sm:mt-0">
                                    <div class="inline-flex items-center gap-2 bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full text-sm font-semibold">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                        {{ $t->messages_count }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
{{-- @endsection --}}
</body>
</html>
