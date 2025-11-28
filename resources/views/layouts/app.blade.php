<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="https://unpkg.com/swiper@11/swiper-bundle.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
        .rating-stars {
            color: #ffc107; /* Warna bintang kuning */
        }
        .rating-stars .far { /* Untuk bintang kosong */
            color: #ddd;
        }


        .swiper {
            width: 80%; /* Lebar karusel */
            height: 300px; /* Tinggi karusel */
            margin: 50px auto;
            border-radius: 10px; /* Sedikit lengkungan pada sudut karusel */
            overflow: hidden; /* Penting untuk border-radius */
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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
        /* Make UI cleaner: remove visible borders used by Tailwind utilities to achieve a more professional, card-like look */
        .border, .border-t, .border-b, .border-l, .border-r,
        .border-gray-50, .border-gray-100, .border-gray-200, .border-gray-300, .border-gray-400, .border-gray-700,
        .border-red-200, .border-yellow-200, .border-amber-100, .border-emerald-100 {
            border: none !important;
        }
        /* Remove small card outlines/shadows where border classes were used */
        .ring-1, .ring-2 { box-shadow: none !important; }
        /* Buttons and inputs keep their outlines for accessibility; only remove layout borders */
        </style>
    </head>
    <body class="bg-gradient-to-br from-green-700 to-green-900 bg-no-repeat w-full min-h-screen">
        {{-- Flash notifications (success / error / info) --}}
        @if(session('success') || session('error') || session('info'))
            <div aria-live="polite" class="fixed top-5 right-5 z-50 space-y-2">
                @if(session('success'))
                    <div id="flash-success" class="px-4 py-2 bg-green-600 text-white rounded shadow">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div id="flash-error" class="px-4 py-2 bg-red-600 text-white rounded shadow">{{ session('error') }}</div>
                @endif
                @if(session('info'))
                    <div id="flash-info" class="px-4 py-2 bg-blue-600 text-white rounded shadow">{{ session('info') }}</div>
                @endif
            </div>

            <script>
                // auto-dismiss after 5s
                setTimeout(() => {
                    const s = document.getElementById('flash-success');
                    const e = document.getElementById('flash-error');
                    const i = document.getElementById('flash-info');
                    [s,e,i].forEach(el => { if(el) el.style.display = 'none'; });
                }, 5000);
            </script>
        @endif
            <main>
                @isset($slot)
                    {{ $slot }}
                @else
                    @yield('content')
                @endisset
            </main>
    </body>
</html>
