<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="https://unpkg.com/swiper@11/swiper-bundle.min.css"/>
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <style>
        body {
            /* Subtle light gradient for a fresher, modern look */
            background: linear-gradient(180deg, #f8faf5 0%, #ffffff 40%, #f7fff7 100%);
        }

        @keyframes float {
    0% {
        transform: translate(0, 0) rotate(0deg);
    }
    33% {
        transform: translate(15px, -15px) rotate(5deg);
    }
    66% {
        transform: translate(-15px, 10px) rotate(-5deg);
    }
    100% {
        transform: translate(0, 0) rotate(0deg);
    }
}

/* Penerapan Animasi pada Elemen */
.custom-float-1 {
    animation: float 10s ease-in-out infinite alternate;
}

.custom-float-2 {
    animation: float 12s ease-in-out infinite alternate;
}

.custom-float-3 {
    animation: float 8s ease-in-out infinite alternate;
}

        .bg-custom-green-gradient {
            background: linear-gradient(to right, #10B981, #34D399); /* Tailwind green-500 to green-400 */
        }

        /* Decorative wave + infographic helpers */
        .wave-svg { opacity: 0.95; filter: drop-shadow(0 8px 24px rgba(34,197,94,0.06)); }
        .infographic-card { background: linear-gradient(180deg,#ffffff,#f8fff9); border: 1px solid rgba(72,187,120,0.06); }

        .coklat {
            color: #b45f06; 
        }

        .swiper {
            width: full; /* Lebar karusel */
            height: 300px; /* Tinggi karusel */
            margin: 0px auto;
            overflow: hidden; /* Penting untuk border-radius */
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* Sedikit bayangan */
            
        }

        .swiper-slide {
            text-align: center;
            font-size: 24px; /* Sedikit lebih besar untuk keterbacaan */

            display: flex;
            justify-content: center;
            align-items: center;
            color: #ffffff; /* Warna teks di slide: Putih */
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3); /* Bayangan teks agar lebih menonjol */
        }

        .slide-1 {
            background-image: url('/image/landing.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }        .slide-2 { background-color: #66BB6A; } /* Hijau lebih muda */
        .slide-3 { background-color: #81C784; } /* Hijau lebih muda lagi */

        .swiper-pagination-bullet {
            background-color: #81C784; /* Warna titik non-aktif */
            opacity: 0.7;
        }

        .swiper-pagination-bullet-active {
            background-color: #4CAF50; /* Warna titik aktif */
            opacity: 1;
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: #4CAF50; /* Warna panah */
            --swiper-navigation-size: 30px; 
        }
        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            color: #388E3C; 
        }

        /* Reusable reveal / motion utilities */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px) scale(.995); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        .reveal {
            opacity: 0;
            transform: translateY(18px) scale(.995);
            transition: opacity .6s cubic-bezier(.2,.9,.2,1), transform .6s cubic-bezier(.2,.9,.2,1);
            will-change: opacity, transform;
        }

        .reveal.in-view {
            opacity: 1;
            transform: none;
        }

        .fade-up {
            animation: fadeUp .6s ease both;
        }

        .zoom-in {
            transform-origin: center center;
            transition: transform .45s ease, box-shadow .3s ease;
        }

        .zoom-in.in-view { transform: scale(1); }

        .shimmer {
            background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.6) 50%, rgba(255,255,255,0) 100%);
            background-size: 200% 100%;
            animation: shimmer 1.6s linear infinite;
        }

        /* subtle product hover lift (already present, keep consistent) */
        [data-product-card].reveal { transform: translateY(8px) scale(.998); }
        [data-product-card].reveal.in-view { transform: translateY(0) scale(1); opacity: 1; }

        </style>
    
    </head>
    <body>
    <x-navbar></x-navbar>
                

<div id="landing-page" class="relative isolate px-4 sm:px-6 lg:px-8 pt-14 overflow-hidden min-h-screen flex items-center bg-cover bg-center" style="background-image: url('{{ asset('images/backgorund.webp') }}'); background-position: center; background-size: cover;">
    
    <div class="absolute inset-0 bg-gradient-to-br from-green-900 to-green-800 z-0"></div>

    <div class="absolute top-1/4 left-1/4 -translate-x-1/2 -translate-y-1/2 text-green-900 opacity-20 text-8xl rotate-12 z-10 hidden md:block">
        🌿
    </div>
    <div class="absolute top-1/3 right-1/4 translate-x-1/2 translate-y-1/2 text-amber-300 opacity-20 text-7xl -rotate-45 z-10 hidden md:block">
        ♻️
    </div>

    <div aria-hidden="true" class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
      <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-amber-400 opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"></div>
    </div>

    <div class="mx-auto max-w-7xl w-full py-12 sm:py-16 lg:py-20 grid grid-cols-1 lg:grid-cols-2 gap-8 items-center relative z-20">
        <div class="px-2 sm:px-0 text-center lg:text-left">
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight text-amber-300 leading-tight" data-aos="fade-in" data-aos-delay="400">
                Ubah Sampah Jadi Rupiah di Bank Sampah Digital Kami!
            </h1>
            <p class="mt-4 sm:mt-6 text-sm sm:text-base md:text-lg text-white/90 max-w-2xl mx-auto lg:mx-0 leading-relaxed" data-aos="fade-right" data-aos-delay="800">
                Bergabunglah untuk menjadi nasabah kami dalam platform bank sampah digital ini, ubah sampahmu menjadi saldo E-Wallet
            </p>
            <div class="mt-8 sm:mt-10 flex items-center justify-center lg:justify-start">
                <a href="/recycle" class="inline-flex items-center gap-3 rounded-full bg-gradient-to-r from-amber-400 to-amber-500 px-4 py-2 sm:px-5 sm:py-3 text-sm sm:text-base font-semibold text-gray-900 shadow-lg hover:from-amber-500 hover:to-amber-400 transition duration-200" data-aos="fade-right" data-aos-delay="400">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    Cari Tahu Bank Sampah Digital
                </a>
            </div>
        </div>

        <div class="mt-8 lg:mt-0 flex justify-center relative z-20" data-aos="fade-up" data-aos-delay="300">
            <div class="w-full max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg rounded-t-full bg-gradient-to-br from-amber-300 to-amber-500 relative overflow-hidden p-6 shadow-2xl">
              <img class="w-full h-auto object-contain mx-5" src="{{ asset('image/bumi.png') }}" alt="Recycling and money illustration">
            </div>
        </div>
    </div>

    <div aria-hidden="true" class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]">
      <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-green-900 opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]"></div>
    </div>

<div class="absolute inset-x-0 bottom-0 z-10 pointer-events-none">
        <div class="relative">
      <svg class="w-full h-20 wave-divider" viewBox="0 0 1440 120" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,32 C180,120 360,8 720,40 C1080,72 1260,0 1440,48 L1440 120 L0 120 Z" fill="#FDBA74" opacity="0.3"></path> 
        
        <path d="M0,48 C200,0 400,96 720,64 C1040,32 1240,80 1440,32 L1440 120 L0 120 Z" fill="#FBBF24"></path>
      </svg>
</div>
    </div>
</div>

<section id="what-we-offer" class="py-24 sm:py-32 bg-grey-100 relative overflow-hidden">
    <div class="absolute inset-0 z-0 pointer-events-none opacity-15">
        <img 
            src="{{ asset('image/botol.png') }}" 
            alt="Floating Decoration" 
            class="absolute top-[10%] left-[5%] w-24 h-24 object-cover custom-float-1" 
        >
        <img 
            src="{{ asset('image/botol.png') }}" 
            alt="Floating Decoration" 
            class="absolute bottom-[10%] right-[80%] w-22 h-22 object-cover rounded-lg custom-float-2"
        >
        <img 
            src="{{ asset('image/botol.png') }}" 
            alt="Floating Decoration" 
            class="absolute top-[50%] right-[30%] w-12 h-12 object-cover rounded-full custom-float-3"
        >
    </div>
    <div class="mx-auto max-w-7xl px-6 lg:px-8 relative z-10">
        <div class="mx-auto max-w-3xl text-center pb-12">
            <p class="text-base font-semibold leading-7 text-green-700 uppercase tracking-widest" data-aos="fade-down" data-aos-delay="500">
                Apa fitur kami?
            </p>
            <h2 class="mt-2 text-4xl font-extrabold tracking-tight text-gray-900 sm:text-6xl" data-aos="fade-up" data-aos-delay="700">
                Bank Sampah Digital, Solusi Daur Ulang Anti-Ribet!
            </h2>
            <p class="mt-4 text-xl text-gray-600" data-aos="fade-up" data-aos-delay="900">
                Kami hadir sebagai platform yang mengusung tema aplikasi daur ulang yang menggabungkan konsep <b>Bank Sampah Digital</b> dilengkapi <b>Toko Online Produk Bank Sampah</b>.
            </p>
        </div>

        <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-20">
            
            <div class="p-0 w-full h-full mb-12 lg:mb-0 lg:order-1" data-aos="fade-right" data>
                <img 
                    src="{{ asset('image/tutup.jpg') }}" 
                    alt="Aplikasi Daur Ulang Mobile Mockup" 
                    class="w-full h-auto max-h-[600px] object-cover rounded-xl shadow-2xl transform hover:scale-[1.01] transition duration-500"
                >
            </div>
            
            <div class="space-y-8 lg:space-y-12 lg:order-2">

                <div class="flex gap-4 p-4 border-b border-gray-100 hover:bg-gray-50 rounded-lg transition duration-200" data-aos="fade-left" data-aos-delay="200">
                    <div class="flex-shrink-0 flex items-start justify-center w-10 h-10 mt-1 rounded-full bg-green-700 text-white shadow-md">
                        <p class="text-center font-bold text-xl">1.</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Ajukan Sampahmu ke Bank Sampah Kami</h3>
                        <p class="mt-1 text-gray-600">
                            Tukarkan sampahmu kepada kami. Kamu cuma perlu mengisi form sampah yang kami sediakan di website kami dan jadwalkan penjemputan sampah. Tim kurir sampah kami akan datang ke lokasi yang kamu tentukan untuk mengambil sampahmu. (Mereka akan menimbang, memverifikasi, dan memberikan kamu poin)
                        </p>
                    </div>
                </div>

                <div class="flex gap-4 p-4 border-b border-gray-100 hover:bg-gray-50 rounded-lg transition duration-200" data-aos="fade-left" data-aos-delay="400">
                    <div class="flex-shrink-0 flex items-start justify-center w-10 h-10 mt-1 rounded-full bg-amber-400 text-gray-900 shadow-md">
                        <p class="text-center font-bold text-xl">2.</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Sistem Poin</h3>
                        <p class="mt-1 text-gray-600">
                            Poin bank sampah kami bisa dikonversikan menjadi uang yang dapat ditukarkan menjadi saldo E-Money. Apabila kamu menginginkan uang fisik tanpa harus melibatkan poin, beritahu kurir sampah kami saja. 
                        </p>
                    </div>
                </div>

                <div class="flex gap-4 p-4 border-b border-gray-100 hover:bg-gray-50 rounded-lg transition duration-200" data-aos="fade-left" data-aos-delay="600">
                    <div class="flex-shrink-0 flex items-start justify-center items-center w-10 h-10 mt-1 rounded-full bg-green-700 text-white shadow-md">
                        <p class="text-center font-bold text-xl">3.</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Belanja Hasil Daur Ulang(Toko Online)</h3>
                        <p class="mt-1 text-gray-600">
                            Sampah yang kamu kirim selain kami olah untuk menjadi bahan baku yang kami pasok untuk industri, tim kreasi kami yang professional juga daat mengubahnya menjadi barang yang bernilai jual.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        
    </div>
</section>

<div id="label-info" class="bg-green-700 text-white py-16 px-6 lg:px-8">
    <div class="mx-auto max-w-7xl grid grid-cols-1 lg:grid-cols-3 gap-8 items-center text-center lg:text-left lg:divide-x lg:divide-green-500/50">
        <div class="lg:pr-8">
            <p class="text-lg font-medium">
                <span class="font-bold block mb-2 text-xl">Solusi Untukmu:</span> Kamu dapat mengirim sampahmu yang masih layak kepada kami dan mendapat poin yang bisa ditukarkan menjadi uang atau saldo E-Wallet. <span class="font-bold bg-amber-300 text-neutral-900">Uang dan barang dari hasil mengirim sampah, kenapa tidak?!</span>
            </p>
        </div>

        <div class="flex justify-center items-center lg:px-8">
            <div class="relative w-64 h-64 flex justify-center items-center">
                <div class="w-64 h-64 bg-neutral-900 rounded-full shadow-2xl shadow-neutral-900/50 flex justify-center items-center p-4">
                    <img class="w-full h-full object-contain" src="{{ asset('image/botol.png') }}" alt="Recycled bottle illustration large">
                </div>

                <div class="absolute bottom-0 right-0 w-32 h-32 bg-amber-300 rounded-full shadow-xl shadow-amber-300/50 flex justify-center items-center p-2 transform translate-x-1/4 translate-y-1/4">
                    <img class="w-full h-full object-contain" src="{{ asset('image/botol.png') }}" alt="Recycled bottle illustration small">
                </div>
            </div>
        </div>

        <div class="lg:text-right lg:pl-8">
             <p class="text-lg font-medium mb-6">
                <span class="font-bold block mb-2 text-xl">Solusi Untuk Kami:</span> Kami mendapat bahan baku untuk kami jadikan sebagai pasokan yang bisa kami salurkan kepada industri atau kami ubah menjadi produk dengan tim kreasi kami. <span class="bg-amber-300 text-neutral-900 font-bold">Kamu membantu kami dalam menghasilkan karya!</span>
            </p>
            <div class="flex justify-end items-end">
            <button class="px-5 gap-2 py-2 flex bg-amber-300 text-neutral-900 font-bold rounded-full hover:bg-amber-400 transition duration-300 shadow-lg">
                <div class="h-6 w-6 border-2 border-b-gray-900 rounded-full"><img src="{{ asset('image/arrow-r.svg') }}" alt=""></div><a href="">Ajukan Sampah!</a>
            </button>
            </div>
        </div>
    </div>
</div>


<section id="products-highlight" class=" min-h-screen py-0 sm:py-32 px-6 lg:px-8">
    
    <div class="mx-auto max-w-7xl">
        <div class="text-center mb-16">
            <p class="text-base font-semibold leading-7 text-amber-600 uppercase tracking-widest">
                Katalog Produk Daur Ulang
            </p>
            <h2 class="mt-2 text-4xl md:text-5xl font-extrabold text-amber-400">
                Produk Kami ♻️
            </h2>
            <p class="text-xl text-neutral-800 mt-4 max-w-2xl mx-auto">
                Ga percaya kalau sampah bisa jadi produk seperti yang kamu pakai sehari-hari? Buktikan saja sendiri dan komplain pada kami jika produk kami tidak berkualitas!
            </p>
        </div>
        
<div class="flex justify-center mb-16 px-4">
    <div class="flex flex-wrap justify-center p-1 rounded-full border-2 border-green-900 bg-green-50 shadow-2xl max-w-full">

        <button 
            id="buttonOrganik" 
            data-target-category="organik" 
            class="category-button px-6 py-2 m-1 text-sm md:text-base font-bold rounded-full 
                   transition-all text-white duration-300 ease-in-out 
                   text-white bg-green-700 /* Mulai sebagai Non-Aktif */
                   hover:bg-green-600 hover:shadow-md 
                   focus:outline-none focus:ring-4 focus:ring-amber-200">
            Organik
        </button>

        <button 
            id="buttonElektronik" 
            data-target-category="elektronik" 
            class="category-button px-6 py-2 m-1 text-sm md:text-base font-bold rounded-full 
                   transition-all duration-300 text-white ease-in-out 
                   text-white bg-green-700 /* Mulai sebagai Non-Aktif */
                   hover:bg-green-600 hover:shadow-md 
                   focus:outline-none focus:ring-4 focus:ring-amber-200">
            Elektronik
        </button>

        <button 
            id="buttonAnorganik" 
            data-target-category="anorganik" 
            class="category-button px-6 py-2 m-1 text-white text-sm md:text-base font-bold rounded-full 
                   transition-all duration-300 ease-in-out 
                   text-white bg-green-700 /* Mulai sebagai Non-Aktif */
                   hover:bg-green-600 hover:shadow-md 
                   focus:outline-none focus:ring-4 focus:ring-amber-200">
            Anorganik
        </button>
        
    </div>
</div>
        <div class="flex justify-center">
            <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl w-full">
                
                <div data-product-card data-category="organik" class="bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-500 hover:shadow-2xl hover:scale-[1.03] cursor-pointer">
                    <div class="relative h-48 overflow-hidden">
                        <img class="w-full h-full object-cover transition-transform duration-500 hover:scale-110" src="{{ asset('image/sabun.jpg') }}" alt="Sabun Minyak Jelantah">
                        <span class="absolute top-3 left-3 bg-green-700 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">Eco-Friendly</span>
                    </div>
                    <div class="p-5">
                        <h3 class="text-xl font-extrabold text-gray-900 truncate">Sabun Minyak Jelantah</h3>
                        <p class="mt-1 text-sm text-gray-500 line-clamp-2" data-detail="Produk sabun tangan ramah lingkungan yang dibuat dari minyak jelantah bekas (Used Cooking Oil). Sangat efektif membersihkan tanpa merusak lingkungan.">Produk sabun tangan ramah lingkungan yang dibuat dari minyak jelantah bekas.</p>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-2xl font-black text-amber-600">Rp 7.000</span>
                            <button data-product-detail data-title="Sabun Minyak Jelantah" data-image="{{ asset('image/sabun.jpg') }}" data-price="Rp 7.000" data-description="Produk sabun tangan ramah lingkungan yang dibuat dari minyak jelantah bekas (Used Cooking Oil). Sangat efektif membersihkan tanpa merusak lingkungan." class="btn-detail bg-green-600 text-white px-5 py-2 font-bold rounded-full transition-colors duration-300 shadow-lg transform hover:scale-105 hover:bg-amber-500 focus:outline-none focus:ring-4 focus:ring-green-300">Detail</button>
                        </div>
                    </div>
                </div>

                <div data-product-card data-category="organik" class="bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-500 hover:shadow-2xl hover:scale-[1.03] cursor-pointer">
                    <div class="relative h-48 overflow-hidden">
                        <img class="w-full h-full object-cover transition-transform duration-500 hover:scale-110" src="{{ asset('image/pupuk.jpeg') }}" alt="Pupuk Kompos Organik">
                        <span class="absolute top-3 left-3 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">Best Seller</span>
                    </div>
                    <div class="p-5">
                        <h3 class="text-xl font-extrabold text-gray-900 truncate">Pupuk Kompos Organik</h3>
                        <p class="mt-1 text-sm text-gray-500 line-clamp-2" data-detail="Pupuk alami hasil daur ulang sampah sisa makanan rumah tangga (food waste) dan daun kering untuk kesuburan tanaman. Kaya nutrisi dan bebas bahan kimia.">Pupuk alami hasil daur ulang sampah rumah tangga untuk kesuburan tanaman.</p>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-2xl font-black text-amber-600">Rp 5.000</span>
                            <button data-product-detail data-title="Pupuk Kompos Organik" data-image="{{ asset('image/pupuk.jpeg') }}" data-price="Rp 5.000" data-description="Pupuk alami hasil daur ulang sampah sisa makanan rumah tangga (food waste) dan daun kering untuk kesuburan tanaman. Kaya nutrisi dan bebas bahan kimia." class="btn-detail bg-green-600 text-white px-5 py-2 font-bold rounded-full transition-colors duration-300 shadow-lg transform hover:scale-105 hover:bg-amber-500 focus:outline-none focus:ring-4 focus:ring-green-300">Detail</button>
                        </div>
                    </div>
                </div>

                <div data-product-card data-category="organik" class="bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-500 hover:shadow-2xl hover:scale-[1.03] cursor-pointer">
                    <div class="relative h-48 overflow-hidden">
                        <img class="w-full h-full object-cover transition-transform duration-500 hover:scale-110" src="{{ asset('image/Pembersih_lantai.jpeg') }}" alt="Bio-enzim Pembersih Lantai">
                        <span class="absolute top-3 left-3 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">New Arrival</span>
                    </div>
                    <div class="p-5">
                        <h3 class="text-xl font-extrabold text-gray-900 truncate">Bio-enzim Pembersih Lantai</h3>
                        <p class="mt-1 text-sm text-gray-500 line-clamp-2" data-detail="Cairan pembersih serbaguna yang difermentasi dari sisa kulit buah dan gula. Non-toksik, aman untuk kulit, dan membersihkan secara efektif.">Cairan pembersih serbaguna yang difermentasi dari sisa kulit buah.</p>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-2xl font-black text-amber-600">Rp 10.000</span>
                            <button data-product-detail data-title="Bio-enzim Pembersih Lantai" data-image="{{ asset('image/Pembersih_lantai.jpeg') }}" data-price="Rp 10.000" data-description="Cairan pembersih serbaguna yang difermentasi dari sisa kulit buah dan gula. Non-toksik, aman untuk kulit, dan membersihkan secara efektif." class="btn-detail bg-green-600 text-white px-5 py-2 font-bold rounded-full transition-colors duration-300 shadow-lg transform hover:scale-105 hover:bg-amber-500 focus:outline-none focus:ring-4 focus:ring-green-300">Detail</button>
                        </div>
                    </div>
                </div>
                
                <div data-product-card data-category="elektronik" class="bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-500 hover:shadow-2xl hover:scale-[1.03] cursor-pointer hidden">
                    <div class="relative h-48 overflow-hidden">
                        <img class="w-full h-full object-cover transition-transform duration-500 hover:scale-110" src="{{ asset('image/Laptop.jpeg') }}" alt="Laptop Rakitan E-Waste">
                        <span class="absolute top-3 left-3 bg-green-700 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">Daur Ulang</span>
                    </div>
                    <div class="p-5">
                        <h3 class="text-xl font-extrabold text-gray-900 truncate">Laptop Rakitan E-Waste</h3>
                        <p class="mt-1 text-sm text-gray-500 line-clamp-2" data-detail="Produk laptop yang dirakit ulang dari komponen elektronik bekas (E-Waste) yang masih berfungsi. Pilihan hemat dan ramah lingkungan.">Produk hasil rakitan dari komponen daur ulang.</p>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-2xl font-black text-amber-600">Rp 200.000</span>
                            <button data-product-detail data-title="Laptop Rakitan E-Waste" data-image="{{ asset('image/Laptop.jpeg') }}" data-price="Rp 200.000" data-description="Produk laptop yang dirakit ulang dari komponen elektronik bekas (E-Waste) yang masih berfungsi. Pilihan hemat dan ramah lingkungan." class="btn-detail bg-green-600 text-white px-5 py-2 font-bold rounded-full transition-colors duration-300 shadow-lg transform hover:scale-105 hover:bg-amber-500 focus:outline-none focus:ring-4 focus:ring-green-300">Detail</button>
                        </div>
                    </div>
                </div>

                <div data-product-card data-category="elektronik" class="bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-500 hover:shadow-2xl hover:scale-[1.03] cursor-pointer hidden">
                    <div class="relative h-48 overflow-hidden">
                        <img class="w-full h-full object-cover transition-transform duration-500 hover:scale-110" src="{{ asset('image/PLC.jpg') }}" alt="Monitor Restorasi Industri">
                        <span class="absolute top-3 left-3 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">Tersedia</span>
                    </div>
                    <div class="p-5">
                        <h3 class="text-xl font-extrabold text-gray-900 truncate">PLC Copotan Industri</h3>
                        <p class="mt-1 text-sm text-gray-500 line-clamp-2" data-detail="Perangkat monitor bekas industri (PLC/HMI) yang direstorasi penuh untuk penggunaan kembali. Cocok untuk industri ringan atau proyek hobi.">Perangkat monitor bekas yang direstorasi untuk penggunaan industri ringan.</p>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-2xl font-black text-amber-600">Rp 1.250.000</span>
                            <button data-product-detail data-title="Monitor Restorasi Industri" data-image="{{ asset('image/PLC.jpg') }}" data-price="Rp 1.250.000" data-description="Perangkat monitor bekas industri (PLC/HMI) yang direstorasi penuh untuk penggunaan kembali. Cocok untuk industri ringan atau proyek hobi." class="btn-detail bg-green-600 text-white px-5 py-2 font-bold rounded-full transition-colors duration-300 shadow-lg transform hover:scale-105 hover:bg-amber-500 focus:outline-none focus:ring-4 focus:ring-green-300">Detail</button>
                        </div>
                    </div>
                </div>
                
                <div data-product-card data-category="elektronik" class="bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-500 hover:shadow-2xl hover:scale-[1.03] cursor-pointer hidden">
                    <div class="relative h-48 overflow-hidden">
                        <img class="w-full h-full object-cover transition-transform duration-500 hover:scale-110" src="{{ asset('image/Powerbank.jpeg') }}" alt="Powerbank Daur Ulang">
                        <span class="absolute top-3 left-3 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">Stok Terbatas</span>
                    </div>
                    <div class="p-5">
                        <h3 class="text-xl font-extrabold text-gray-900 truncate">Powerbank Daur Ulang</h3>
                        <p class="mt-1 text-sm text-gray-500 line-clamp-2" data-detail="Powerbank yang dirakit menggunakan baterai bekas laptop (Li-ion 18650) yang masih dalam kondisi baik. Kapasitas 10.000 mAh.">Powerbank yang dirakit menggunakan baterai bekas laptop.</p>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-2xl font-black text-amber-600">Rp 40.000</span>
                            <button data-product-detail data-title="Powerbank Daur Ulang" data-image="{{ asset('image/Powerbank.jpeg') }}" data-price="Rp 40.000" data-description="Powerbank yang dirakit menggunakan baterai bekas laptop (Li-ion 18650) yang masih dalam kondisi baik. Kapasitas 10.000 mAh." class="btn-detail bg-green-600 text-white px-5 py-2 font-bold rounded-full transition-colors duration-300 shadow-lg transform hover:scale-105 hover:bg-amber-500 focus:outline-none focus:ring-4 focus:ring-green-300">Detail</button>
                        </div>
                    </div>
                </div>

                <div data-product-card data-category="anorganik" class="bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-500 hover:shadow-2xl hover:scale-[1.03] cursor-pointer hidden">
                    <div class="relative h-48 overflow-hidden">
                        <img class="w-full h-full object-cover transition-transform duration-500 hover:scale-110" src="{{ asset('image/Selimut.jpeg') }}" alt="Selimut Perca">
                        <span class="absolute top-3 left-3 bg-green-700 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">Upcycle Tekstil</span>
                    </div>
                    <div class="p-5">
                        <h3 class="text-xl font-extrabold text-gray-900 truncate">Selimut Perca Motif</h3>
                        <p class="mt-1 text-sm text-gray-500 line-clamp-2" data-detail="Selimut hangat yang dijahit dari berbagai kain perca sisa pabrik garmen. Masing-masing memiliki motif unik dan dibuat secara handmade.">Selimut hangat yang dijahit dari berbagai kain perca.</p>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-2xl font-black text-amber-600">Rp 100.000</span>
                            <button data-product-detail data-title="Selimut Perca Motif" data-image="{{ asset('image/Selimut.jpeg') }}" data-price="Rp 100.000" data-description="Selimut hangat yang dijahit dari berbagai kain perca sisa pabrik garmen. Masing-masing memiliki motif unik dan dibuat secara handmade." class="btn-detail bg-green-600 text-white px-5 py-2 font-bold rounded-full transition-colors duration-300 shadow-lg transform hover:scale-105 hover:bg-amber-500 focus:outline-none focus:ring-4 focus:ring-green-300">Detail</button>
                        </div>
                    </div>
                </div>

                <div data-product-card data-category="anorganik" class="bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-500 hover:shadow-2xl hover:scale-[1.03] cursor-pointer hidden">
                    <div class="relative h-48 overflow-hidden">
                        <img class="w-full h-full object-cover transition-transform duration-500 hover:scale-110" src="{{ asset('image/Kandang.jpeg') }}" alt="Kandang Ayam Reuse">
                        <span class="absolute top-3 left-3 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">Custom Order</span>
                    </div>
                    <div class="p-5">
                        <h3 class="text-xl font-extrabold text-gray-900 truncate">Kandang Ayam Reuse</h3>
                        <p class="mt-1 text-sm text-gray-500 line-clamp-2" data-detail="Kandang ayam ramah lingkungan yang dibuat dari palet kayu bekas atau bingkai logam tak terpakai. Dapat dipesan sesuai ukuran.">Kandang ayam dari palet kayu bekas.</p>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-2xl font-black text-amber-600">Rp 40.000</span>
                            <button data-product-detail data-title="Kandang Ayam Reuse" data-image="{{ asset('image/Kandang.jpeg') }}" data-price="Rp 40.000" data-description="Kandang ayam ramah lingkungan yang dibuat dari palet kayu bekas atau bingkai logam tak terpakai. Dapat dipesan sesuai ukuran." class="btn-detail bg-green-600 text-white px-5 py-2 font-bold rounded-full transition-colors duration-300 shadow-lg transform hover:scale-105 hover:bg-amber-500 focus:outline-none focus:ring-4 focus:ring-green-300">Detail</button>
                        </div>
                    </div>
                </div>
                
                <div data-product-card data-category="anorganik" class="bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-500 hover:shadow-2xl hover:scale-[1.03] cursor-pointer hidden">
                    <div class="relative h-48 overflow-hidden">
                        <img class="w-full h-full object-cover transition-transform duration-500 hover:scale-110" src="{{ asset('image/Pencilcase.jpeg') }}" alt="Tempat Pensil Kaleng">
                        <span class="absolute top-3 left-3 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">Limited Edition</span>
                    </div>
                    <div class="p-5">
                        <h3 class="text-xl font-extrabold text-gray-900 truncate">Tempat Pensil Kaleng Dekoratif</h3>
                        <p class="mt-1 text-sm text-gray-500 line-clamp-2" data-detail="Tempat pensil unik yang dibuat dari kaleng bekas minuman yang didesain dan dicat ulang. Cocok untuk hadiah atau dekorasi meja kerja.">Tempat pensil dari kaleng bekas minuman.</p>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-2xl font-black text-amber-600">Rp 9.000</span>
                            <button data-product-detail data-title="Tempat Pensil Kaleng Dekoratif" data-image="{{ asset('image/Pencilcase.jpeg') }}" data-price="Rp 9.000" data-description="Tempat pensil unik yang dibuat dari kaleng bekas minuman yang didesain dan dicat ulang. Cocok untuk hadiah atau dekorasi meja kerja." class="btn-detail bg-green-600 text-white px-5 py-2 font-bold rounded-full transition-colors duration-300 shadow-lg transform hover:scale-105 hover:bg-amber-500 focus:outline-none focus:ring-4 focus:ring-green-300">Detail</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

<div id="product-modal" 
     class="fixed inset-0 z-50 flex items-center justify-center 
            bg-gray-900/70 backdrop-blur-sm opacity-0 
            transition-opacity duration-300 p-4 overflow-y-auto hidden">
    <div id="modal-content" 
         class="bg-white rounded-2xl shadow-2xl max-w-lg w-full mx-4 z-10 
                transform scale-90 opacity-0 transition-all duration-300 ease-out">
        <div class="p-6">
            <div class="flex items-start justify-between pb-3 mb-4">
                <h3 id="modal-title" class="text-2xl font-extrabold text-gray-900">Product Title</h3>
                <button id="modal-close" class="text-gray-500 hover:text-gray-900 text-3xl leading-none transition">&times;</button>
            </div>
            <img id="modal-image" src="" alt="Detail Produk" class="w-full h-56 object-cover rounded-xl mb-6 shadow-md">
            <p id="modal-description" class="text-base text-gray-700 mb-4"></p>
            <div class="flex items-center justify-between pt-4">
                <div class="flex flex-col">
                    <span class="text-sm font-semibold text-gray-500">Harga:</span>
                    <div id="modal-price" class="text-3xl font-black text-amber-600">Rp 0</div>
                </div>
                <a id="modal-buy" href="/shop" class="px-6 py-3 bg-green-700 text-white font-bold rounded-xl shadow-lg transition-colors duration-300 hover:bg-green-600 transform hover:scale-[1.03] focus:ring-4 focus:ring-green-300">
                    Tukar & Beli Sekarang!
                </a>
            </div>
        </div>
    </div>
</div>
</section>

<section id="how-it-works" class="py-0 sm:py-32 bg-gradient-to-b from-green-800 to-green-900 ">
    <div class="relative bottom-32">
    <svg class="w-full h-32 wave-divider" viewBox="0 0 1440 120" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,40 C180,-20 360,112 720,80 C1080,48 1260,120 1440,72 L1440 0 L0 0 Z" 
              fill="#FDBA74" opacity="0.3"></path>

        <path d="M0,60 C200,108 400,24 720,56 C1040,88 1240,40 1440,88 L1440 0 L0 0 Z" 
              fill="#FBBF24"></path>
    </svg>
</div>
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-3xl text-center pb-16">
            <p class="text-base font-semibold leading-7 text-amber-600 uppercase tracking-widest">LANGKAH MUDAH</p>
            <h2 class="mt-2 text-4xl font-extrabold tracking-tight text-amber-400 sm:text-6xl" data-aos="fade-in" data-aos-delay="200">Daur Ulang Cerdas, Untung Maksimal</h2>
            <p class="mt-4 text-xl text-white" data-aos="fade-in" data-aos-delay="100">Ikuti 3 langkah sederhana kami untuk mengubah sampah Anda menjadi Poin yang menguntungkan!</p>
        </div>

        <div class="mx-auto grid max-w-2xl grid-cols-1 gap-x-12 gap-y-8 text-base leading-7 sm:grid-cols-1 lg:mx-0 lg:max-w-none lg:grid-cols-3">
            <div class="relative flex flex-col p-8 bg-amber-300 border border-amber-300 rounded-2xl shadow-xl hover:shadow-2xl transition duration-300 transform hover:translate-y-1" data-aos="fade-down" data-aos-delay="600">
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 flex items-center justify-center w-10 h-10 rounded-full bg-green-700 text-white font-bold text-lg ring-4 ring-white">1</div>
                <div class="w-20 h-20 text-green-700 mx-auto"><img src="{{ asset('image/recycle.png') }}" alt=""></div>
                <h3 class="text-2xl text-center font-extrabold tracking-tight text-green-900 mb-4 mt-2">Kumpulkan & Kirim Sampah</h3>
                <p class="text-black text-center">Pilah sampahmu sesuai kategori yang kami sediakan dan jadwalkan penjemputan via aplikasi dan tunggu tim kurir kami akan datang kesana.</p>
            </div>

            <div class="relative flex flex-col p-8 bg-amber-300 border border-amber-300 rounded-2xl shadow-xl hover:shadow-2xl transition duration-300 transform hover:translate-y-1" data-aos="fade-up" data-aos-delay="800">
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 flex items-center justify-center w-10 h-10 rounded-full bg-green-700 text-white font-bold text-lg ring-4 ring-white">2</div>
               <div class="w-20 h-20 text-green-700 mx-auto"><img src="{{ asset('image/uang.png') }}" alt=""></div>
                <h3 class="text-2xl text-center font-extrabold tracking-tight text-green-900 mb-4 mt-2">Dapatkan Poin Instan</h3>
                <p class="text-black text-center">Setelah sampah Anda diverifikasi (berat dan jenis), Poin Pengajuan Sampah akan langsung masuk ke akun kamu, kamu juga bisa memilih mau jadi poin yang bisa ditukarkan menjadi saldo atau uang tunai saat tim kurir datang.</p>
            </div>

            <div class="relative flex flex-col p-8 bg-amber-300 border border-amber-300 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:translate-y-1" data-aos="fade-down" data-aos-delay="1000">
                 <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 flex items-center justify-center w-10 h-10 rounded-full bg-green-700 text-white font-bold text-lg ring-4 ring-white">3</div>
                <div class="w-20 h-20 text-green-700 mx-auto"><img src="{{ asset('image/diskon.png') }}" alt=""></div>
                <h3 class="text-2xl text-center font-extrabold tracking-tight text-green-900 mb-4 mt-2">Kumpulkan Poin Tukar Jadi Saldo E-Wallet</h3>
                <p class="text-black text-center">Poin yang kamu dapat bisa kamu kumpulkan di aplikasi kami dan dapat kamu tukarkan menjadi saldo E-Wallet</p>
            </div>
        </div>
    </div>
</section>

<section id="accepted-waste" class="relative py-10 sm:py-20 bg-gradient-to-b from-green-900 via-green-800 to-green-700 overflow-hidden">
  <!-- top decorative circle -->

  <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
    <div class="max-w-3xl mx-auto text-center">
      <p class="text-sm font-semibold tracking-wide text-amber-300 uppercase">Pengajuan Sampah Tepat, Poin Hebat</p>
      <h1 class="mt-3 text-4xl sm:text-5xl font-extrabold text-white">Sampah Apa Saja yang Kami Terima?</h1>
      <p class="mt-4 text-lg text-green-100/90">Pilih kategori di bawah untuk melihat daftar lengkap, contoh gambar, dan panduan pemilahan yang benar.</p>
    </div>
    <!-- card grid -->
    <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

      <!-- Card: Plastic -->
      <button data-modal-target="modal-plastik" class="group relative overflow-hidden rounded-2xl shadow-2xl bg-white border border-gray-100 p-4 text-left hover:scale-[1.02] transition">
        <div class="h-40 rounded-xl card-img" style="background-image: url('image/komputer.jpg')"></div>
        <div class="mt-4 flex items-center justify-between">
          <div>
            <h3 class="text-lg font-extrabold text-gray-900 group-hover:text-green-700">Barang Elektronik</h3>
            <p class="text-sm text-gray-500">Barang elektronik bekas atau sparepart-nya</p>
          </div>
          <div class="flex-shrink-0">
            <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-green-600 text-white shadow">♻️</span>
          </div>
        </div>
      </button>

      <!-- Card: Paper -->
      <button data-modal-target="modal-kertas" class="group relative overflow-hidden rounded-2xl shadow-2xl bg-white border border-gray-100 p-4 text-left hover:scale-[1.02] transition">
        <div class="h-40 rounded-xl card-img" style="background-image: url('image/botol.png')"></div>
        <div class="mt-4 flex items-center justify-between">
          <div>
            <h3 class="text-lg font-extrabold text-gray-900 group-hover:text-amber-700">Plastik</h3>
            <p class="text-sm text-gray-500">Botol Plastik</p>
          </div>
          <div class="flex-shrink-0">
            <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-amber-500 text-white shadow">📄</span>
          </div>
        </div>
      </button>

      <!-- Card: Metal -->
      <button data-modal-target="modal-logam" class="group relative overflow-hidden rounded-2xl shadow-2xl bg-white border border-gray-100 p-4 text-left hover:scale-[1.02] transition">
        <div class="h-40 rounded-xl card-img" style="background-image: url('image/kertas.jpeg')"></div>
        <div class="mt-4 flex items-center justify-between">
          <div>
            <h3 class="text-lg font-extrabold text-gray-900 group-hover:text-blue-700">Kertas</h3>
            <p class="text-sm text-gray-500">Kertas Bekas</p>
          </div>
          <div class="flex-shrink-0">
            <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-blue-600 text-white shadow">🔩</span>
          </div>
        </div>
      </button>

      <button data-modal-target="modal-kaca" class="group relative overflow-hidden rounded-2xl shadow-2xl bg-white border border-gray-100 p-4 text-left hover:scale-[1.02] transition">
        <div class="h-40 rounded-xl card-img" style="background-image: url('image/minyak.jpeg')"></div>
        <div class="mt-4 flex items-center justify-between">
          <div>
            <h3 class="text-lg font-extrabold text-gray-900 group-hover:text-red-700">Minyak Jelantah</h3>
            <p class="text-sm text-gray-500">Minyak bekas penggorengan atau minyak lama</p>
          </div>
          <div class="flex-shrink-0">
            <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-red-600 text-white shadow">🍾</span>
          </div>
        </div>
      </button>

    </div>
    
    <div class="mt-6 bg-amber-50 rounded-2xl border-2 border-amber-600 shadow-xl p-6 flex flex-col justify-center items-center gap-4">
      <div class="flex-1 text-center justify-center items-center">
        <h2 class="text-xl font-extrabold text-amber-700">Pastikan Sampah Anda: <span class="text-gray-800">Aman • Terpilah • Tidak Berbahaya</span></h2>
        <p class="mt-2 text-sm text-amber-900/80">Pemilahan yang tepat akan memaksimalkan Poin Daur Ulang Anda dan mempercepat proses pengolahan.</p>
      </div>
    </div>

  </div>
    
  <!-- background recycled symbol -->
  <div aria-hidden class="hidden lg:block absolute bottom-4 left-6 text-green-900 opacity-10 text-[9rem] -rotate-45">♻️</div>

    <div class="mt-12 relative bottom-0 top-20">
      <svg class="w-full h-20 wave-divider" viewBox="0 0 1440 120" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,32 C180,120 360,8 720,40 C1080,72 1260,0 1440,48 L1440 120 L0 120 Z" fill="#FDE68A" opacity="0.12"></path>
        <path d="M0,48 C200,0 400,96 720,64 C1040,32 1240,80 1440,32 L1440 120 L0 120 Z" fill="#FDE68A" opacity="0.18"></path>
      </svg>
    </div>

</section>

<div id="modal-container" aria-hidden="true">
  <!-- single modal structure -- will be populated by JS cloning -->
</div>

<template id="modal-template">
  <div class="modal-dialog fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="modal-content bg-white rounded-2xl shadow-2xl max-w-2xl w-full mx-4 transform scale-95 opacity-0 transition-all duration-300">
      <div class="p-6">
        <div class="flex items-start gap-4">
          <div class="h-12 w-12 flex items-center justify-center rounded-lg text-white"></div>
          <div class="flex-1">
            <h3 class="text-2xl font-extrabold modal-title"></h3>
            <p class="mt-2 text-sm text-gray-600 modal-sub"></p>
          </div>
          <button class="close-modal ml-4 rounded-full p-2 hover:bg-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
          </button>
        </div>

        <div class="mt-4 modal-body text-sm text-gray-700"></div>
      </div>
      <div class="bg-gray-50 px-6 py-4 rounded-b-2xl text-right">
        <button class="close-modal inline-flex items-center rounded-xl px-6 py-2 bg-green-600 text-white font-bold">Saya Mengerti</button>
      </div>
    </div>
  </div>
</template>

    <div class="bg-white w-3/4 rounded-lg top-10 swiper mySwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide slide-1"></div>
            <div class="swiper-slide slide-2">Slide Ini Penuh Kedamaian 🌳</div>
            <div class="swiper-slide slide-3">Segar dan Asri 🌿</div>
        </div>

        <div class="swiper-pagination"></div>

        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>

    </div>

<section id="article" class="py-18 sm:py-24 px-4 sm:px-6 lg:px-8 bg-grey-100 relative overflow-hidden">
    
    <div class="mt-10 max-w-7xl mx-auto relative z-10"> 
        <div class="flex justify-between items-end mb-12">
            <div class="flex-col">
                <p class="font-extrabold text-4xl text-green-700 sm:text-5xl">Artikel kami</p>
                <p class="mt-2 text-xl text-amber-600">Temukan artikel menarik dari RRCO dan dunia digital hijau</p>
            </div>
        </div>

        <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-20">
            
            <div class="p-0 w-full h-full lg:mb-0 lg:order-1 bg-green-700 shadow-md shadow-neutral-300 rounded-lg overflow-hidden">
                <!-- Article image carousel (full-width) -->
                <div class="swiper articleSlider w-full h-auto">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="{{ asset('image/kita.jpeg') }}" alt="Ilustrasi Artikel 1" class="w-full h-[320px] sm:h-[400px] md:h-[500px] lg:h-[600px] object-contain bg-white">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ asset('image/pot.jpeg') }}" alt="Ilustrasi Artikel 2" class="w-full h-[320px] sm:h-[400px] md:h-[500px] lg:h-[600px] object-contain bg-white">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ asset('image/rt.jpeg') }}" alt="Ilustrasi Artikel 3" class="w-full h-[320px] sm:h-[400px] md:h-[500px] lg:h-[600px] object-contain bg-white">
                        </div>
                    </div>
                    <div class="swiper-pagination mt-3 flex justify-center"></div>
                </div>
                <div class="mt-6 p-4">
                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-md font-medium bg-amber-400 text-white">Honored Mention</span>
                    <h3 class="mt-2 text-3xl font-extrabold text-white leading-tight">
                        <a href="#" class="hover:text-amber-400  transition duration-200">
                            Perum. Villa Asri 2: Komunitas Daur Ulang yang Menginspirasi
                        </a>
                    </h3>
                    <p class="mt-3 text-lg text-white">
                        Penelitian terbaru menunjukkan potensi besar daur ulang plastik tidak hanya mengurangi limbah, tetapi juga menghasilkan sumber energi yang bersih dan berkelanjutan. Simak selengkapnya.
                    </p>
                    <p class="mt-4 text-sm text-amber-400">
                        Diposting pada 20 Mei 2024
                    </p>
                </div>
            </div>
            
            <div class="space-y-6 md:space-y-4 lg:space-y-8 mt-8 lg:mt-0 lg:order-2 mt-20">
                @foreach ($posts as $post)
                    @php
                        $thumb = isset($post['image']) && $post['image'] ? asset($post['image']) : asset('image/tutup.jpg');
                    @endphp

                    <article class="w-full bg-green-700 border border-green-600 rounded-2xl shadow-sm hover:shadow-lg transition transform hover:-translate-y-1 duration-300 overflow-hidden">
    
            <div class="px-4 pt-3"> 
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-400 text-white mb-2">
                {{ $post['label'] }}
                </span>
            </div>

    <div class="grid grid-cols-1 sm:grid-cols-6 gap-4 px-4 pb-4 items-center">
        
        <div class="col-span-1 sm:col-span-2">
            <img src="{{ asset('image/' . $post['image_url']) }}" 
                alt="{{ $post['title'] }}" 
                class="w-full h-36 sm:h-24 object-cover rounded-lg shadow-sm" />
        </div>

        <div class="col-span-1 sm:col-span-3 min-w-0">
            <h3 class="text-lg font-semibold text-white truncate">
                <a href="/posts/{{ $post['slug']}}" class="hover:text-amber-400 transition duration-150">
                    {{ $post['title'] }}
                </a>
            </h3>

            <div class="mt-2 flex items-center text-xs text-amber-400 space-x-3">
                <span class="truncate">{{ $post['author'] }}</span>
                <span class="text-gray-300">•</span>
                <time>
                    @if(!empty($post['created_at']))
                        {{ \Illuminate\Support\Carbon::parse($post['created_at'])->format('j M Y') }}
                    @else
                        mboh
                    @endif
                </time>
            </div>

            <p class="mt-2 text-sm text-white line-clamp-3">
                {{ Str::limit($post['body'], 140) }}
            </p>
        </div>

        <div class="col-span-1 sm:col-span-1 flex flex-row-reverse sm:flex-col sm:items-end items-center justify-between sm:justify-center">
            
            @if(!empty($post['category']))
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-100 whitespace-nowrap">
                    {{ $post['category'] }}
                </span>
            @endif

            <a href="/posts/{{ $post['slug'] }}" class="mt-0 sm:mt-3 inline-flex items-center gap-2 px-3 py-2 rounded-full bg-green-600 text-white text-sm font-semibold hover:bg-green-900 transition">
                Read
            </a>
        </div>
    </div>
</article>
                @endforeach
            </div>
     
            </div>
            
        </div>
    </div>
</section>

<div class="mt-12 relative bottom-0">
      <svg class="w-full h-20 wave-divider" viewBox="0 0 1440 120" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,32 C180,120 360,8 720,40 C1080,72 1260,0 1440,48 L1440 120 L0 120 Z" fill="#FDBA74" opacity="0.3"></path> 
        
        <path d="M0,48 C200,0 400,96 720,64 C1040,32 1240,80 1440,32 L1440 120 L0 120 Z" fill="#FBBF24"></path>
      </svg>
</div>

<a href="https://wa.me/6282113149076" 
   target="_blank"
   class="fixed bottom-5 right-5 z-50 bg-green-600 hover:bg-green-600 text-white 
          w-14 h-14 flex items-center justify-center rounded-full shadow-xl 
          transition-all duration-200 animate-bounce">
    
    <svg xmlns="http://www.w3.org/2000/svg" 
         width="28" height="28" fill="currentColor"
         viewBox="0 0 24 24">
        <path d="M20.52 3.48A11.8 11.8 0 0 0 12 0C5.37 0 0 5.37 0 12c0 2.11.55 4.17 1.6 6L0 24l6.26-1.64A11.94 11.94 0 0 0 12 24c6.63 0 12-5.37 12-12 0-3.19-1.24-6.2-3.48-8.52zM12 21.82a9.77 9.77 0 0 1-4.98-1.38l-.36-.21-3.72.97 1-3.62-.24-.37A9.8 9.8 0 1 1 12 21.82zm5.33-7.47c-.29-.15-1.7-.84-1.96-.94-.26-.1-.45-.15-.64.15-.19.29-.74.94-.9 1.13-.17.19-.33.22-.62.07-.29-.15-1.23-.45-2.34-1.44-.86-.76-1.44-1.7-1.61-1.99-.17-.29-.02-.45.13-.6.13-.13.29-.33.43-.5.15-.17.19-.29.29-.48.1-.19.05-.36-.02-.51-.07-.15-.64-1.54-.88-2.11-.23-.55-.47-.47-.64-.47h-.55c-.19 0-.51.07-.77.36-.26.29-1.02 1-1.02 2.45 0 1.44 1.05 2.83 1.2 3.02.15.19 2.07 3.16 5.02 4.43.7.3 1.25.48 1.68.62.7.22 1.34.19 1.84.12.56-.08 1.7-.7 1.94-1.38.24-.67.24-1.25.17-1.38-.07-.12-.26-.19-.55-.33z"/>
    </svg>
</a>



<x-footer></x-footer>

<script>

    document.addEventListener('DOMContentLoaded', function(){
        if(typeof Swiper !== 'undefined'){
            new Swiper('.mySwiper', {
                loop: true,
                slidesPerView: 1,
                spaceBetween: 20,
                pagination: { el: '.swiper-pagination', clickable: true },
                navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
                autoplay: { delay: 3500, disableOnInteraction: false },
                breakpoints: {
                    640: { slidesPerView: 1 },
                    768: { slidesPerView: 2 },
                    1024: { slidesPerView: 3 }
                }
            });
        }
    });

        document.addEventListener('DOMContentLoaded', function() {
        const productCards = document.querySelectorAll('[data-product-card]');
        const categoryButtons = document.querySelectorAll('.category-button');
        const modal = document.getElementById('product-modal');
        const modalContent = document.getElementById('modal-content');
        const modalClose = document.getElementById('modal-close');
        const modalTitle = document.getElementById('modal-title');
        const modalImage = document.getElementById('modal-image');
        const modalDescription = document.getElementById('modal-description');
        const modalPrice = document.getElementById('modal-price');
        const modalBuy = document.getElementById('modal-buy');

        // --- 1. Category Filtering Logic ---
        function filterProducts(category) {
            productCards.forEach(card => {
                if (card.getAttribute('data-category') === category) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });
        }

        function setActiveButton(activeButton) {
            categoryButtons.forEach(btn => {
                btn.classList.remove('active-category', 'bg-green-700', 'text-white');
                btn.classList.add('text-gray-700', 'hover:bg-green-100');
            });
            activeButton.classList.add('active-category', 'bg-green-700', 'text-white');
            activeButton.classList.remove('text-gray-700', 'hover:bg-green-100');
        }

        categoryButtons.forEach(button => {
            button.addEventListener('click', function() {
                const category = this.getAttribute('data-target-category');
                filterProducts(category);
                setActiveButton(this);
            });
        });

        // Initialize: Show 'Organik' products and set its button as active
        filterProducts('organik');
        setActiveButton(document.getElementById('buttonOrganik'));


        // --- 2. Modal Open/Close Logic ---
        function openModal(title, image, description, price) {
            modalTitle.textContent = title;
            modalImage.src = image;
            modalDescription.textContent = description;
            modalPrice.textContent = price;
            // You might want to update the Buy link with product ID or name here:
            // modalBuy.href = '#'; 

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; 
            
            // Animation start
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalContent.classList.remove('opacity-0', 'scale-90');
                modalContent.classList.add('scale-100');
            }, 10);
        }

        function closeModal() {
            // Animation end
            modal.classList.add('opacity-0');
            modalContent.classList.add('opacity-0', 'scale-90');
            modalContent.classList.remove('scale-100');

            // Wait for transition to finish before hiding (300ms)
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }, 300);
        }

        // Open Modal Listener (attached to 'Detail' buttons)
        document.querySelectorAll('[data-product-detail]').forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation(); // Prevent the card click event if any
                const title = this.getAttribute('data-title');
                const image = this.getAttribute('data-image');
                const description = this.getAttribute('data-description');
                const price = this.getAttribute('data-price');
                openModal(title, image, description, price);
            });
        });

        // Close Modal Listeners
        modalClose.addEventListener('click', closeModal);
        modal.addEventListener('click', function(e) {
            if (e.target.id === 'product-modal') {
                closeModal();
            }
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                closeModal();
            }
        });
    });

        document.addEventListener('DOMContentLoaded', () => {
    const openModalBtns = document.querySelectorAll('.open-modal-btn');
    const closeModalBtns = document.querySelectorAll('.close-modal-btn');

    const openModal = (id) => {
      const modal = document.getElementById(id);
      if (!modal) return;
      modal.classList.remove('hidden');
      setTimeout(() => {
        modal.classList.remove('opacity-0', 'scale-95');
        const content = modal.querySelector('.modal-content');
        content.classList.remove('opacity-0', 'scale-95');
      }, 10);
      document.body.style.overflow = 'hidden';
    };

    const closeModal = (modal) => {
      if (!modal) return;
      const content = modal.querySelector('.modal-content');
      modal.classList.add('opacity-0', 'scale-95');
      content.classList.add('opacity-0', 'scale-95');
      setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
      }, 200);
    };

    openModalBtns.forEach((btn) => {
      btn.addEventListener('click', () => openModal(btn.dataset.modalTarget));
    });

    closeModalBtns.forEach((btn) => {
      btn.addEventListener('click', () => closeModal(btn.closest('.modal-dialog')));
    });

    document.querySelectorAll('.modal-dialog').forEach((modal) => {
      modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal(modal);
      });
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        const openModal = document.querySelector('.modal-dialog:not(.hidden)');
        if (openModal) closeModal(openModal);
      }
    });
  });

    document.addEventListener('DOMContentLoaded', function() {
        const productCards = document.querySelectorAll('[data-product-card]');
        const categoryButtons = document.querySelectorAll('.category-button');
        // ... (Logika Category Filtering dan Modal Anda) ...

        // Tambahkan inisialisasi Swiper di SINI
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });

        // Article slider (full-width autoplay)
        if (typeof Swiper !== 'undefined') {
            var articleSlider = new Swiper('.articleSlider', {
                slidesPerView: 1,
                spaceBetween: 0,
                loop: true,
                autoplay: {
                    delay: 3500,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.articleSlider .swiper-pagination',
                    clickable: true,
                    dynamicBullets: true,
                },
                effect: 'slide',
                allowTouchMove: true,
            });
        }
    });

    const MODAL_DATA = {
    'modal-plastik': {
      title: 'Plastik',
      sub: 'Semua Jenis Kode 1-7 — contoh gambar & kondisi',
      body: `
        <ul class=\"list-disc list-inside space-y-2 pl-2\">
          <li><strong>PET (Kode 1):</strong> Botol air mineral, botol soda. <em>Kondisi:</em> Kosong, dibilas, tutup dilepas.</li>
          <li><strong>HDPE (Kode 2):</strong> Botol susu, wadah sampo, deterjen. <em>Kondisi:</em> Kosong, dibilas.</li>
          <li><strong>PP (Kode 5):</strong> Wadah makanan tebal, tutup botol. <em>Kondisi:</em> Bersih dari sisa makanan.</li>
          <li><strong>Plastik Film:</strong> Kresek bersih, bungkus sachet (dicuci).</li>
        </ul>
        <p class=\"mt-3 text-xs text-red-500 italic bg-red-50 p-2 rounded border border-red-200\">Kami <strong>tidak</strong> menerima Styrofoam, kemasan obat, atau plastik sangat berminyak.</p>
      `,
      colorClass: 'bg-green-500'
    },
    'modal-kertas': {
      title: 'Kertas & Karton',
      sub: 'Kardus, HVS, Koran — contoh dan cara rapikan',
      body: `
        <ul class=\"list-disc list-inside space-y-2 pl-2\">
          <li><strong>Kardus:</strong> Lipat dan lepaskan lakban. Tidak basah/berminyak.</li>
          <li><strong>Kertas Putih:</strong> HVS, buku, print kantor. Pisahkan dari klip.</li>
          <li><strong>Koran & Majalah:</strong> Kering dan dilipat.</li>
        </ul>
        <p class=\"mt-3 text-xs text-red-500 italic bg-red-50 p-2 rounded border border-red-200\">Tidak menerima kertas tisu, kertas foto, atau kertas basah.</p>
      `,
      colorClass: 'bg-amber-500'
    },
    'modal-logam': {
      title: 'Logam & Kaleng',
      sub: 'Aluminium, besi, perkakas kecil',
      body: `
        <ul class=\"list-disc list-inside space-y-2 pl-2\">
          <li><strong>Aluminium:</strong> Kaleng minuman, foil. Dibilas dan dipipihkan bila perlu.</li>
          <li><strong>Besi/Timah:</strong> Kaleng makanan, perkakas kecil (tanpa listrik).</li>
          <li><strong>Logam Lain:</strong> Kabel tembaga bersih, kawat.</li>
        </ul>
        <p class=\"mt-3 text-xs text-red-500 italic bg-red-50 p-2 rounded border border-red-200\">Tidak menerima baterai atau komponen elektronik besar.</p>
      `,
      colorClass: 'bg-blue-500'
    },
    'modal-kaca': {
      title: 'Kaca',
      sub: 'Botol & stoples — kondisi yang diterima',
      body: `
        <ul class=\"list-disc list-inside space-y-2 pl-2\">
          <li><strong>Botol Minuman:</strong> Kosong, dibilas, tutup dilepas.</li>
          <li><strong>Stoples:</strong> Bersih, label boleh dibiarkan.</li>
          <li><strong>Kaca Bening/Warna:</strong> Diterima selama tidak pecah.</li>
        </ul>
        <p class=\"mt-3 text-xs text-red-500 italic bg-red-50 p-2 rounded border border-red-200\">Tidak menerima keramik, bohlam, atau kaca pecah.</p>
      `,
      colorClass: 'bg-red-500'
    }
  };

  // Helper to create and show modal
  function openModal(key) {
    const data = MODAL_DATA[key];
    if (!data) return;

    // clone template
    const tpl = document.getElementById('modal-template');
    const clone = tpl.content.cloneNode(true);
    const dialog = clone.querySelector('.modal-dialog');
    const titleEl = clone.querySelector('.modal-title');
    const subEl = clone.querySelector('.modal-sub');
    const bodyEl = clone.querySelector('.modal-body');
    const accent = clone.querySelector('.h-12.w-12');

    titleEl.innerHTML = data.title;
    subEl.innerHTML = data.sub;
    bodyEl.innerHTML = data.body;
    accent.className += ' ' + data.colorClass;

    // append to container
    const container = document.getElementById('modal-container');
    container.appendChild(clone);

    // small timeout to trigger transitions
    requestAnimationFrame(() => {
      dialog.classList.add('modal-open');
      dialog.style.opacity = '1';
      dialog.querySelector('.modal-content').style.transform = 'scale(1)';
      dialog.querySelector('.modal-content').style.opacity = '1';
      dialog.querySelector('.modal-content').style.transition = 'transform 220ms ease, opacity 220ms ease';
      dialog.querySelector('.modal-content').style.transform = 'translateY(0) scale(1)';
      dialog.classList.remove('pointer-events-none');
    });

    // close handlers
    function removeModal() {
      // reverse animation
      dialog.querySelector('.modal-content').style.transform = 'scale(.95) translateY(6px)';
      dialog.querySelector('.modal-content').style.opacity = '0';
      dialog.style.opacity = '0';
      setTimeout(() => dialog.remove(), 260);
    }

    dialog.querySelectorAll('.close-modal').forEach(btn => btn.addEventListener('click', removeModal));
    dialog.addEventListener('click', (e) => {
      if (e.target === dialog) removeModal();
    });
  }

  // wire up card buttons
  document.querySelectorAll('[data-modal-target]').forEach(btn => {
    btn.addEventListener('click', () => {
      const target = btn.getAttribute('data-modal-target');
      openModal(target);
    });
  });

</script>

<script>
// Small reveal script: adds `.reveal` then `.in-view` when elements enter viewport
document.addEventListener('DOMContentLoaded', function () {
    const revealSelector = '[data-aos], [data-product-card], .infographic-card, .swiper, #landing-page .max-w-7xl, #article .w-full';
    const items = Array.from(document.querySelectorAll(revealSelector));

    items.forEach((el) => {
        // don't override if already has explicit reveal
        if (!el.classList.contains('reveal')) el.classList.add('reveal');
        // allow optional data-delay in ms
        const delay = el.getAttribute('data-aos-delay') || el.dataset.delay;
        if (delay) el.style.transitionDelay = (parseInt(delay) || 0) + 'ms';
    });

    const io = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            const el = entry.target;
            if (entry.isIntersecting) {
                // stagger product cards slightly when a group appears
                if (el.hasAttribute('data-product-card') === false && el.querySelectorAll && el.querySelectorAll('[data-product-card]').length) {
                    const cards = el.querySelectorAll('[data-product-card]');
                    cards.forEach((c, i) => setTimeout(() => c.classList.add('in-view'), i * 80));
                }

                // normal reveal
                el.classList.add('in-view');

                // if element has data-aos-once='false', keep observing; otherwise unobserve
                if (el.getAttribute('data-aos-once') === 'false') return;
                obs.unobserve(el);
            }
        });
    }, { threshold: 0.12 });

    items.forEach(i => io.observe(i));

    // small enhancement: stagger visible top product cards on initial load
    const topProductRow = document.querySelectorAll('[data-product-card]');
    if (topProductRow && topProductRow.length) {
        topProductRow.forEach((c, i) => setTimeout(() => c.classList.add('in-view'), 180 + i * 60));
    }
});
</script>

    </body>
</html>
