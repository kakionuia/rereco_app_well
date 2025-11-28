@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('shop.index') }}" class="inline-flex items-center space-x-2 text-green-800 hover:text-green-700 font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                <span>Kembali ke Toko</span>
            </a>
        </div>

        @php
            $product = $review->product;
            $allReviews = \App\Models\Review::where('product_id', $product->id)->with('user')->latest()->get();
            $totalReviews = $allReviews->count();
            $averageRating = $allReviews->avg('rating');
            $ratingDistribution = [
                5 => $allReviews->where('rating', 5)->count(),
                4 => $allReviews->where('rating', 4)->count(),
                3 => $allReviews->where('rating', 3)->count(),
                2 => $allReviews->where('rating', 2)->count(),
                1 => $allReviews->where('rating', 1)->count(),
            ];
        @endphp

        <!-- Product Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <p class="text-sm text-gray-600 mb-2">
                        Ulasan untuk produk <a href="{{ route('shop.show', $product->slug) }}" class="text-green-800 hover:text-green-700 font-semibold no-underline">{{ $product->name }}</a>
                    </p>
                    <h1 class="text-3xl font-bold text-gray-900">Semua Ulasan Pembeli</h1>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Left Sidebar - Stats -->
            <div class="lg:col-span-1">
                <div class="sticky top-20 bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Rating & Ulasan</h3>

                    <!-- Average Rating -->
                    <div class="text-center mb-6 pb-6 border-b border-gray-200">
                        <div class="text-5xl font-bold text-yellow-500 mb-2">{{ number_format($averageRating, 1) }}</div>
                        <div class="flex items-center justify-center space-x-1 mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= round($averageRating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                </svg>
                            @endfor
                        </div>
                        <p class="text-sm text-gray-600 font-medium">dari {{ $totalReviews }} ulasan</p>
                    </div>

                    <!-- Rating Distribution -->
                    <div class="space-y-3">
                        @foreach([5, 4, 3, 2, 1] as $rating)
                            @php
                                $count = $ratingDistribution[$rating];
                                $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                            @endphp
                            <div class="flex items-center space-x-2">
                                <div class="flex items-center space-x-1 w-12">
                                    @for($i = 1; $i <= $rating; $i++)
                                        <svg class="w-3 h-3 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                        </svg>
                                    @endfor
                                </div>
                                <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-yellow-400 rounded-full transition-all" style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="text-xs text-gray-600 w-6 text-right font-medium">{{ $count }}</span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Stats Summary -->
                    <div class="mt-6 pt-6 border-t border-gray-200 space-y-2">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">5 Bintang</span>
                            <span class="font-bold text-gray-900">{{ round(($ratingDistribution[5] / $totalReviews * 100) ?? 0) }}%</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">4 Bintang</span>
                            <span class="font-bold text-gray-900">{{ round(($ratingDistribution[4] / $totalReviews * 100) ?? 0) }}%</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">3 Bintang</span>
                            <span class="font-bold text-gray-900">{{ round(($ratingDistribution[3] / $totalReviews * 100) ?? 0) }}%</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">2 Bintang</span>
                            <span class="font-bold text-gray-900">{{ round(($ratingDistribution[2] / $totalReviews * 100) ?? 0) }}%</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">1 Bintang</span>
                            <span class="font-bold text-gray-900">{{ round(($ratingDistribution[1] / $totalReviews * 100) ?? 0) }}%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Reviews List -->
            <div class="lg:col-span-3">
                @if($allReviews->isNotEmpty())
                    <div class="space-y-4">
                        @foreach($allReviews as $rev)
                            <!-- Review Card -->
                            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                                <!-- Review Header -->
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-start space-x-4 flex-1">
                                        <!-- User Avatar -->
                                        <div class="w-12 h-12 rounded-full bg-linear-to-br from-green-400 to-blue-500 flex items-center justify-center text-white font-bold shrink-0 text-lg">
                                            {{ substr($rev->user->name ?? 'U', 0, 1) }}
                                        </div>

                                        <!-- User Info -->
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center space-x-2 flex-wrap gap-2">
                                                <p class="font-bold text-gray-900">{{ $rev->user->name ?? 'Pembeli Anonim' }}</p>
                                                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">{{ $rev->created_at->diffForHumans() }}</span>
                                            </div>

                                            <!-- Star Rating -->
                                            <div class="flex items-center space-x-1 mt-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-4 h-4 {{ $i <= $rev->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                                    </svg>
                                                @endfor
                                                <span class="text-sm text-gray-600 ml-2 font-medium">{{ $rev->rating }}/5</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Review Flag (if highlighted) -->
                                    @if($rev->id === $review->id)
                                        <div class="shrink-0 bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold">
                                            ⭐ Ulasan Anda
                                        </div>
                                    @endif
                                </div>

                                <!-- Review Content -->
                                <div class="ml-16">
                                    @if($rev->title)
                                        <h4 class="font-bold text-gray-900 mb-2">{{ $rev->title }}</h4>
                                    @endif
                                    <p class="text-gray-700 leading-relaxed">{{ $rev->body }}</p>

                                    <!-- Review Photos -->
                                    @if($rev->photos && count($rev->photos) > 0)
                                        <div class="mt-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                                            @foreach($rev->photos as $photo)
                                                <a href="{{ asset('storage/' . $photo) }}" class="review-photo group relative overflow-hidden rounded-lg" aria-label="Buka foto ulasan">
                                                    <img src="{{ asset('storage/' . $photo) }}" alt="Foto Ulasan" class="w-full h-32 object-cover group-hover:scale-110 transition-transform duration-300 cursor-pointer">
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Review Footer -->
                                    <div class="mt-4 flex items-center space-x-4 text-sm text-gray-500">
                                        <button class="flex items-center space-x-1 hover:text-green-600 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.646 7.098a2 2 0 01-1.789 1.106H5a2 2 0 01-2-2v-8a2 2 0 012-2h6.4a1 1 0 000-2h-6.4a4 4 0 00-4 4v8a4 4 0 004 4h8.228a4 4 0 003.578-2.212l3.646-7.098a4 4 0 00-3.578-5.79H18a1 1 0 100-2h.764a2 2 0 011.789 2.894l-3.646 7.098a2 2 0 01-1.789 1.106H5"></path></svg>
                                            <span>Berguna</span>
                                        </button>
                                        <button class="flex items-center space-x-1 hover:text-red-600 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.646-7.098a2 2 0 011.789-1.106h8.228a2 2 0 012 2v8a2 2 0 01-2 2H9.414a1 1 0 000 2h8.228a4 4 0 004-4v-8a4 4 0 00-4-4H6.236a4 4 0 00-3.578 2.212l-3.646 7.098a4 4 0 003.578 5.79h6.292a1 1 0 100-2z"></path></svg>
                                            <span>Tidak Berguna</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination (if needed) -->
                    @if($allReviews->count() > 20)
                        <div class="mt-8 text-center">
                            <button class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                                Muat Lebih Banyak Ulasan
                            </button>
                        </div>
                    @endif
                @else
                    <!-- Empty State -->
                    <div class="bg-white rounded-lg shadow-md p-12 text-center">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <p class="text-gray-600 font-medium mb-2">Belum ada ulasan</p>
                        <p class="text-gray-500 mb-6">Jadilah pembeli pertama yang memberi ulasan untuk produk ini</p>
                        <a href="{{ route('shop.show', $product->slug) }}" class="inline-flex items-center space-x-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14a2 2 0 012 2v7a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2z"></path></svg>
                            <span>Lihat Produk</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    /* Smooth scroll behavior */
    html {
        scroll-behavior: smooth;
    }
    /* Lightbox modal styles */
    .review-lightbox { display: none; }
    .review-lightbox.active { display: flex; }
    .review-lightbox .lb-backdrop { background: rgba(0,0,0,0.75); }
    .review-lightbox .lb-image { max-width: 90%; max-height: 85vh; border-radius: 8px; }
    .review-lightbox .lb-close { background: rgba(255,255,255,0.9); }
</style>

<div id="reviewLightbox" class="review-lightbox fixed inset-0 z-50 items-center justify-center p-4" aria-hidden="true" role="dialog" aria-label="Preview Foto Ulasan">
    <div class="lb-backdrop absolute inset-0"></div>
    <div class="relative z-10 max-w-5xl w-full flex items-center justify-center">
        <button id="lbClose" class="lb-close absolute top-3 right-3 rounded-full w-10 h-10 flex items-center justify-center shadow-md text-gray-800" aria-label="Tutup (X)">✕</button>
        <img id="lbImage" src="" alt="Preview Foto" class="lb-image object-contain shadow-lg" />
    </div>
</div>

<script>
    (function(){
        const links = document.querySelectorAll('.review-photo');
        const lightbox = document.getElementById('reviewLightbox');
        const lbImage = document.getElementById('lbImage');
        const lbClose = document.getElementById('lbClose');
        let lastFocused = null;

        if(!lightbox) return;

        function open(src, trigger) {
            lastFocused = trigger || document.activeElement;
            lbImage.src = src;
            lightbox.classList.add('active');
            lightbox.setAttribute('aria-hidden', 'false');
            lbClose.focus();
        }

        function close() {
            lightbox.classList.remove('active');
            lightbox.setAttribute('aria-hidden', 'true');
            lbImage.src = '';
            if(lastFocused) lastFocused.focus();
        }

        links.forEach(a => {
            a.addEventListener('click', function(e){
                e.preventDefault();
                const href = this.getAttribute('href');
                open(href, this);
            });
        });

        lbClose.addEventListener('click', close);

        // Close when clicking backdrop
        lightbox.addEventListener('click', function(e){
            if(e.target === lightbox || e.target.classList.contains('lb-backdrop')) close();
        });

        // Escape key
        document.addEventListener('keydown', function(e){ if(e.key === 'Escape') close(); });
    })();
</script>
@endsection
