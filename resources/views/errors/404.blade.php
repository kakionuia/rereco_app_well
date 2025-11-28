<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 — Halaman Tidak Ditemukan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white text-gray-800 flex flex-col">
    <x-navbar />

    <main class="flex-1 flex items-center justify-center px-6 py-12 mt-20">
        <div class="max-w-4xl w-full grid grid-cols-1 md:grid-cols-1 gap-8 items-center">
            <div class="space-y-6">
                <h1 class="text-6xl font-extrabold text-green-700">404</h1>
                <h2 class="text-2xl sm:text-3xl font-bold">Ups — Halaman tidak ditemukan</h2>
                <p class="text-gray-600">Maaf, tautan yang Anda coba akses tidak tersedia atau mungkin telah dipindahkan.
                Coba salah satu opsi berikut untuk melanjutkan.</p>

                <div class="flex flex-wrap gap-3 mt-4">
                    <a href="/" class="inline-block px-5 py-3 bg-green-700 text-white rounded-lg font-semibold shadow hover:bg-green-600">Kembali ke Beranda</a>
                    <a href="/posts" class="inline-block px-4 py-3 border border-green-700 text-green-700 rounded-lg font-semibold hover:bg-green-50">Baca Artikel</a>
                    <a href="/shop" class="inline-block px-4 py-3 border border-amber-500 text-amber-700 rounded-lg font-semibold hover:bg-amber-50">Lihat Toko</a>
                </div>

                <p class="mt-6 text-sm text-gray-500">Jika masalah berlanjut, hubungi dukungan di <a href="mailto:admin@example.com" class="text-green-700 underline">admin@example.com</a>.</p>
            </div>
        </div>
    </main>

    <x-footer />
</body>
</html>
