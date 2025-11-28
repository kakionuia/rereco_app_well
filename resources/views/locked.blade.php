<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Terkunci</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="max-w-lg bg-white p-10 rounded-2xl shadow-lg text-center">
        <div class="text-6xl mb-4">🔒</div>
        <h1 class="text-2xl font-bold mb-2">Halaman Terkunci</h1>
        <p class="text-gray-600 mb-6">{{ $reason ?? 'Anda perlu masuk untuk mengakses halaman ini.' }}</p>
        <div class="space-x-3">
            <a href="{{ route('login') }}" class="px-6 py-2 bg-green-700 text-white rounded-lg font-semibold">Masuk</a>
            <a href="{{ route('register') }}" class="px-6 py-2 border border-green-700 text-green-700 rounded-lg">Daftar</a>
            <a href="/" class="px-6 py-2 text-gray-600 rounded-lg">Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>