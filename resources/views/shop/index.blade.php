<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Belanja Recycle</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
            <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        input[type="search"]::-webkit-search-decoration,
        input[type="search"]::-webkit-search-cancel-button,
        input[type="search"]::-webkit-search-results-button,
        input[type="search"]::-webkit-search-results-decoration {
            display: none;
        }
        input[type="search"] {
            -ms-clear: none;
        }
        .product-card-img {
            height: 120px; 
            object-fit: contain; 
        }
        .clickable-card:hover { transform: translateY(-6px) scale(1.01); box-shadow: 0 12px 30px rgba(2,6,23,0.08); }
        .buy-btn { transition: transform 160ms ease, background-color 160ms; }
        .buy-btn:hover { transform: scale(1.06); }
        @media (max-width: 767px) {
            .product-card-img { height: 140px; }
        }
        .rating-stars {
            color: #ffc107; /* Warna bintang kuning */
        }
        .rating-stars .far { /* Untuk bintang kosong */
            color: #ddd;
        }

    .swiper-button-next, .swiper-button-prev {
        color: white; /* Mengubah warna panah */
        background-color: rgba(0, 0, 0, 0.4); /* Background semi-transparan */
        width: 40px;
        height: 40px;
        border-radius: 50%;
        transition: background-color 0.3s;
        transform: scale(0.8);
    }
    .swiper-button-next:hover, .swiper-button-prev:hover {
        background-color: rgba(0, 0, 0, 0.7);
    }
    .swiper-button-next::after, .swiper-button-prev::after {
        font-size: 18px;
        font-weight: bold;
    }
    .swiper-pagination-bullet {
        background: #fff; /* Warna default titik */
        opacity: 0.5;
    }
    .swiper-pagination-bullet-active {
        background: #fff; /* Warna titik yang aktif */
        opacity: 1;
    }
    /* Additional styling for nicer slides */
    .bootstrapCarousel .swiper-slide > div {
        min-height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .bootstrapCarousel .swiper-slide .bg-black\/50 {
        background: rgba(0,0,0,0.45) !important;
    }
    .bootstrapCarousel .swiper-pagination-bullet {
        width: 10px;
        height: 10px;
    }
    .bootstrapCarousel .swiper-button-next,
    .bootstrapCarousel .swiper-button-prev{
        display:flex; align-items:center; justify-content:center;
    }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(25px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeInUp {
      animation: fadeInUp 1s ease forwards;
    }
    .delay-100 { animation-delay: 0.2s; }
    .delay-200 { animation-delay: 0.4s; }
    </style>
</head>
<body class="bg-gray-100">
<x-navbar></x-navbar>
<!-- Small-screen search & category toolbar -->
<div class="md:hidden bg-white/70 backdrop-blur-sm border-b border-gray-100 sticky top-21 z-40">
        <div class="px-4 py-3 flex items-center space-x-3">
        <form method="GET" action="{{ route('shop.index') }}" class="flex-1">
            <div class="relative">
                <input name="q" value="{{ $q ?? '' }}" placeholder="Cari produk..." class="w-full pl-3 pr-20 py-2 border border-gray-200 rounded-full text-sm focus:outline-none focus:ring-1 focus:ring-emerald-300" />
                <button type="submit" class="absolute right-1 top-1/2 -translate-y-1/2 px-3 py-1 bg-green-600 text-white rounded-full text-sm">Cari</button>
            </div>
        </form>
        <div>
            <select onchange="location = this.value" class="border border-gray-300 rounded-md px-3 py-1 text-sm">
                <option value="{{ route('shop.index') }}" {{ empty($category) ? 'selected' : '' }}>Semua</option>
                <option value="{{ route('shop.index', ['category' => 'organik']) }}">Organik</option>
                <option value="{{ route('shop.index', ['category' => 'elektronik']) }}">Elektronik</option>
                    <option value="{{ route('shop.index', ['category' => 'anorganik']) }}">Anorganik</option>
            </select>
        </div>
    </div>
</div>

<section class="pt-6 md:pt-25">
    <div class="mx-auto w-full max-w-[1400px] relative">
      <div class="swiper promoCarousel h-[400px] md:h-[520px] lg:h-[600px] rounded-2xl overflow-hidden shadow-2xl">

        <div class="swiper-wrapper">

          <!-- SLIDE 1 -->
          <div class="swiper-slide">
            <div class="relative w-full h-full">
              <img src="{{ asset('image/Recycling_Thumbnail.jpg') }}"
                   alt="Promo Tas" class="absolute inset-0 w-full h-full object-cover" />
              <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>

              <div class="relative z-10 flex flex-col justify-center items-start h-full p-10 md:p-16 text-white max-w-lg">
                <h2 class="text-3xl md:text-5xl font-extrabold mb-3 animate-fadeInUp">Promo Akhir Tahun 🎉</h2>
                <p class="text-lg md:text-xl mb-6 animate-fadeInUp delay-100">
                  Diskon hingga <span class="text-yellow-400 font-bold">50%</span> untuk semua produk kami!
                </p>
                <a href="#produk"
                   class="bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-6 py-3 rounded-full shadow-md animate-fadeInUp delay-200">
                  Belanja Sekarang
                </a>
              </div>
            </div>
          </div>

          <!-- SLIDE 2 -->
          <div class="swiper-slide">
            <div class="relative w-full h-full">
              <img src="{{ asset('image/natal.jpg') }}"
                   alt="Promo Tas" class="absolute inset-0 w-full h-full object-cover" />
              <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>

              <div class="relative z-10 flex flex-col justify-center items-start h-full p-10 md:p-16 text-white max-w-lg">
                <h2 class="text-3xl md:text-5xl font-extrabold mb-3 animate-fadeInUp">Diskon Malam Natal</h2>
                <p class="text-lg md:text-xl mb-6 animate-fadeInUp delay-100">
                    Special harga untuk malam yang spesial. Dapatkan hadiah dari Santa, hohohoho!
                </p>
                <a href="#produk"
                   class="bg-white hover:bg-gray-200 text-black font-semibold px-6 py-3 rounded-full shadow-md animate-fadeInUp delay-200">
                  Coming Soon
                </a>
              </div>
            </div>
          </div>

          <!-- SLIDE 3 -->
          <div class="swiper-slide">
            <div class="relative w-full h-full">
             <img src="{{ asset('image/ramadhan.jpg') }}"
                   alt="Promo Tas" class="absolute inset-0 w-full h-full object-fit" />
              <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>

              <div class="relative z-10 flex flex-col justify-center items-start h-full p-10 md:p-16 text-white max-w-lg">
                <h2 class="text-3xl md:text-5xl font-extrabold mb-3 animate-fadeInUp">Marhaban Ya Ramadhan!</h2>
                <p class="text-lg md:text-xl mb-6 animate-fadeInUp delay-100">
                  Spesial Ramadhan, temukan diskon menarik dan takjil gratis. Lesgoooo!
                </p>
                <a href="#produk"
                   class="bg-green-800 hover:bg-green-600 text-white font-semibold px-6 py-3 rounded-full shadow-md animate-fadeInUp delay-200">
                  Beli Sekarang
                </a>
              </div>
            </div>
          </div>

        </div>

        <!-- Pagination & Navigation -->
        <div class="swiper-pagination !bottom-5"></div>
        <div class="swiper-button-next !text-white"></div>
        <div class="swiper-button-prev !text-white"></div>
      </div>
    </div>
  </section>

    <main class="container mt-20 mx-auto px-4 md:px-8 lg:px-12">
        
        <section class="mb-12">
            <div class="flex items-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">All Products</h2>
            <div class="flex items-center mb-6">
                        <a href="{{ route('shop.orders') }}" class="ml-2 inline-flex items-center px-3 py-1 bg-green-700 text-white border font-medium rounded-md text-sm hover:bg-green-700">Riwayat</a>
            </div>
            </div>
            {{-- Voucher claim section: show if there's a voucher for user's tier and stock available --}}
            @if(isset($tierVoucher) && $tierVoucher)
                <div class="mb-6 bg-green-100 border border-green-100 rounded-lg p-4 flex items-center justify-between">
                    <div>
                        <div class="text-sm font-semibold">Voucher untuk level Anda: {{ ucfirst($tierVoucher->tier) }}</div>
                        <div class="text-xs font-semibold">Kode: <span class="font-mono">{{ $tierVoucher->code }}</span> — Diskon: @if($tierVoucher->discount_type === 'percent') {{ $tierVoucher->discount_value }}% @else Rp {{ number_format($tierVoucher->discount_value,0,',','.') }} @endif</div>
                        <div class="text-xs  mt-1">Sisa kuota: {{ $tierVoucher->stock }}</div>
                    </div>
                    <div class="">
                        @auth
                            @if($userClaimed)
                                <div class="text-sm">Anda sudah mengklaim voucher ini.</div>
                            @else
                                <form action="{{ route('voucher.claim', $tierVoucher->id) }}" method="POST">
                                    @csrf
                                    <button class="px-4 py-2 bg-green-600 text-white rounded">Klaim Voucher</button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 bg-green-800 text-white rounded">Masuk untuk klaim</a>
                        @endauth
                    </div>
                </div>
            @endif

            <div class="hidden md:flex lg:flex justify-between items-center bg-white p-4 rounded-lg shadow-sm mb-6">
                <div class="flex-1 flex flex-col md:flex-row md:items-center md:space-x-4">
                    <form method="GET" action="{{ route('shop.index') }}" class="flex-1 justify-between flex items-center space-x-2">
                        <input name="q" value="{{ $q ?? '' }}" placeholder="Cari produk..." class="w-1/2 pl-3 pr-20 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-green-700" />
                        <button type="submit" class=" justify-start px-3 py-1 bg-green-600 text-white rounded-lg text-sm">Cari</button>
                    </form>

                    <div class="md:mt-0">
                        <select onchange="location = this.value" class="border border-gray-300 rounded-md px-3 py-1 text-sm focus:outline-none focus:ring-1 focus:ring-green-700">
                            <option value="{{ route('shop.index') }}" {{ empty($category) ? 'selected' : '' }}>Semua Kategori</option>
                            <option value="{{ route('shop.index', ['category' => 'organik']) }}" {{ (isset($category) && $category == 'organik') ? 'selected' : '' }}>Organik</option>
                            <option value="{{ route('shop.index', ['category' => 'elektronik']) }}" {{ (isset($category) && $category == 'elektronik') ? 'selected' : '' }}>Elektronik</option>
                            <option value="{{ route('shop.index', ['category' => 'anorganik']) }}" {{ (isset($category) && $category == 'anorganik') ? 'selected' : '' }}>Anorganik</option>
                        </select>
                    </div>
                </div>

               
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                @foreach($products as $product)
                    @php $available = ($product->stock ?? 0) > 0 && ($product->is_active ?? true); @endphp
                    @php
                        $catName = strtolower($product->category?->slug ?? $product->category?->name ?? '');
                        $isReward = ($catName === 'rewards' || $catName === 'reward');
                    @endphp
                    @if(!$isReward)
                    <div class="bg-white rounded-lg shadow-sm p-4 text-center relative hover:shadow-md transition duration-200 clickable-card" data-href="{{ route('shop.show', $product->slug) }}" style="cursor:pointer;">
                        @if($available)
                            <span class="absolute top-2 left-2 bg-green-600 text-white text-xs px-2 py-1 rounded-full">Tersedia</span>
                        @else
                            <span class="absolute top-2 left-2 bg-gray-400 text-white text-xs px-2 py-1 rounded-full">Stok Habis</span>
                        @endif
                        <a href="{{ route('shop.show', $product->slug) }}">
                            @php
                                // Determine image URL: admin stores '/storage/...' in DB, so if image already contains '/storage' use it directly.
                                $img = '/image/tutup.jpg';
                                if (!empty($product->image)) {
                                    $pimg = (string) $product->image;
                                    if (str_starts_with($pimg, '/storage') || str_starts_with($pimg, 'storage') || str_starts_with($pimg, '/image')) {
                                        $img = $pimg;
                                    } else {
                                        $img = Storage::url(ltrim($pimg, '/'));
                                    }
                                }
                            @endphp
                            <img src="{{ $img }}" alt="{{ $product->name }}" class="mx-auto mb-2 product-card-img">
                            <h3 class="text-sm font-semibold text-gray-800 line-clamp-2 mb-1">{{ $product->name }}</h3>
                        </a>
                        <p class="text-xs text-gray-500 mb-2">{{ $product->category?->name ?? '' }}</p>
                        <div class="flex items-center justify-center text-xs text-gray-600 mb-2">
                            <div class="rating-stars">
                                @php
                                    try { $avg = (float) $product->reviews()->avg('rating'); } catch (\Exception $e) { $avg = null; }
                                @endphp
                                @if($avg)
                                    @php $full = floor($avg); $half = ($avg - $full) >= 0.5; @endphp
                                    @for($i=1;$i<=5;$i++)
                                        @if($i <= $full)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                @else
                                    <i class="fas fa-star"></i> <span class="text-xs ml-1">N/A</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex justify-between items-center mt-2">
                            <p class="text-lg font-bold text-gray-900">{{ number_format($product->price,2) }}</p>
                            <div class="flex items-center space-x-2">
                                @auth
                                    <a href="{{ route('shop.buy', $product->slug) }}" class="buy-btn bg-green-700 text-white rounded-full h-8 w-8 flex items-center justify-center hover:bg-green-600 transition duration-200" aria-label="Beli {{ $product->name }}">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                    @if(auth()->user()->is_admin ?? false)
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="text-xs text-gray-600 hover:underline">Edit</a>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}?redirect={{ urlencode(route('shop.buy', $product->slug)) }}" class="buy-btn bg-green-700 text-white rounded-full h-8 w-8 flex items-center justify-center hover:bg-green-600 transition duration-200" aria-label="Login untuk beli">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>

            <div class="mt-6 flex justify-center">
                {{ $products->links() }}
            </div>
        </section>
    </main>

</body>

<!-- Swiper JS -->
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('click', function(e){
        var card = e.target.closest('.clickable-card');
        if (!card) return;
        // if click happened on an anchor inside the card, allow default anchor behavior
        if (e.target.closest('a')) return;
        var href = card.getAttribute('data-href');
        if (href) {
            window.location.href = href;
        }
    });

   document.addEventListener('DOMContentLoaded', () => {
      new Swiper('.promoCarousel', {
        loop: true,
        effect: 'fade',
        speed: 800,
        autoplay: {
          delay: 4000,
          disableOnInteraction: false,
        },
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
        },
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },
      });
    });
</script>
</html>