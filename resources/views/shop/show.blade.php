@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm overflow-hidden">
            <img loading="lazy" src="{{ $product->image ?? '/image/tutup.jpg' }}" alt="{{ $product->name }}" class="w-full h-96 object-cover">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-gray-900">{{ $product->name }}</h1>
                <div class="mt-2 text-sm text-gray-500">Kategori: <span class="font-semibold text-gray-700">{{ $product->category?->name ?? '-' }}</span></div>
                <div class="mt-4 text-gray-700 leading-relaxed">{!! nl2br(e($product->description)) !!}</div>
            </div>
        </div>

        <aside class="bg-white h-fit rounded-xl shadow-sm p-6">
            <div class="text-3xl font-bold text-amber-600">Rp {{ number_format($product->price,0,',','.') }}</div>
            <div class="mt-2 text-sm text-gray-500">Stok: <span class="font-semibold text-gray-700">{{ $product->stock }}</span></div>

            @php $available = ($product->stock ?? 0) > 0 && ($product->is_active ?? true); @endphp
            <div class="mt-2">
                @if($available)
                    <span class="inline-block px-2 py-1 bg-green-500 text-white text-xs rounded">Tersedia</span>
                @else
                    <span class="inline-block px-2 py-1 bg-gray-400 text-white text-xs rounded">Stok Habis</span>
                @endif
            </div>

            <form action="{{ route('shop.buy', $product->slug) }}" method="GET" class="mt-6">
                

                @if($available)
                    <button type="submit" class="mt-4 w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg">Bayar Sekarang</button>
                @else
                    <button type="button" disabled class="mt-4 w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-gray-400 text-white rounded-lg cursor-not-allowed">Stok Habis</button>
                @endif
            </form>

            <div class="mt-6">
                <a href="{{ route('shop.index') }}" class="text-sm text-gray-600 hover:underline">&larr; Kembali ke toko</a>
            </div>
            
            {{-- Latest single review: show the most recent approved review (no slider) --}}
            @php
                try {
                    $latestReview = $product->reviews()->where('approved', true)->latest()->first();
                } catch (\Exception $e) { $latestReview = null; }
            @endphp
            @if($latestReview)
                <div class="mt-6">
                    <h3 class="text-lg font-semibold">Ulasan Terbaru</h3>
                    <div class="mt-3">
                        <a href="{{ route('reviews.show', $latestReview->id) }}" class="bg-white rounded-lg p-4 shadow-md hover:shadow-lg no-underline text-current block">
                            <div class="flex items-start gap-3">
                                <div class="shrink-0 h-12 w-12 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center font-semibold">{{ strtoupper(substr($latestReview->user->name,0,1)) }}</div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <div class="font-medium text-gray-900">{{ $latestReview->user->name }}</div>
                                        <div class="flex items-center gap-1">
                                            @for($s=1;$s<=5;$s++)
                                                @if($s <= $latestReview->rating)
                                                    <i class="fas fa-star text-amber-500"></i>
                                                @else
                                                    <i class="far fa-star text-gray-300"></i>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="mt-2 text-sm text-gray-700">{{ \Illuminate\Support\Str::limit($latestReview->body ?? $latestReview->title ?? '', 300) }}</div>
                                    <div class="mt-3 text-xs text-gray-400">{{ $latestReview->created_at->format('d M Y H:i') }}</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endif
        </aside>
    </div>

    @if($related->isNotEmpty())
        <section class="mt-10">
            <h2 class="text-lg font-semibold text-amber-300">Produk terkait</h2>
            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($related as $r)
                    <a href="{{ route('shop.show', $r->slug) }}" class="block bg-white border border-gray-100 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                        <img loading="lazy" src="{{ $r->image ?? '/image/tutup.jpg' }}" alt="{{ $r->name }}" class="w-full h-36 object-cover">
                        <div class="p-3 text-sm font-medium text-gray-900">{{ $r->name }}</div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection
