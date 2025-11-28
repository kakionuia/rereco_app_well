<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Memuat — RRCO</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-b from-green-50 to-white text-gray-800">
    <x-navbar />

    <main class="min-h-[60vh] flex items-center justify-center px-6">
        <div class="max-w-xl w-full text-center">
            <x-loading class="mx-auto" >
                Memuat konten — harap tunggu
            </x-loading>
            <p class="mt-6 text-sm text-gray-500">Jika halaman terasa lama, periksa koneksi atau muat ulang.</p>
            <div class="mt-6">
                <a href="/" class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-green-700 text-white font-semibold shadow hover:bg-green-600">Kembali ke Beranda</a>
            </div>
        </div>
    </main>

    <x-footer />
</body>
</html>
