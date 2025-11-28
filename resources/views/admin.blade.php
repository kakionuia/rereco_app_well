<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | RRCO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            width: 256px; 
        }
        .main-content {
            overflow-y: auto;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex">

    <aside class="sidebar bg-gray-800 text-white flex-shrink-0 flex flex-col fixed h-full z-30">
        <div class="p-6 border-b border-gray-700">
            <h1 class="text-2xl font-bold text-amber-400">RRCO Admin</h1>
        </div>

        <nav class="flex-grow p-4 space-y-2">
            <a href="#" class="flex items-center p-3 rounded-lg bg-gray-700 text-amber-400 font-semibold transition duration-200">
                <i class="fas fa-tachometer-alt mr-3"></i>
                Dashboard
            </a>
            <a href="#" class="flex items-center p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition duration-200">
                <i class="fas fa-newspaper mr-3"></i>
                Kelola Artikel
            </a>
            <a href="#" class="flex items-center p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition duration-200">
                <i class="fas fa-users mr-3"></i>
                Anggota Tim
            </a>
            <a href="#" class="flex items-center p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition duration-200">
                <i class="fas fa-shopping-cart mr-3"></i>
                Produk
            </a>
            <a href="#" class="flex items-center p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition duration-200">
                <i class="fas fa-cogs mr-3"></i>
                Pengaturan
            </a>
        </nav>

        <div class="p-4 border-t border-gray-700">
            <a href="#" class="flex items-center p-3 rounded-lg text-red-400 hover:bg-gray-700 transition duration-200">
                <i class="fas fa-sign-out-alt mr-3"></i>
                Keluar
            </a>
        </div>
    </aside>

    <div class="flex-1 flex flex-col ml-64 min-h-screen"> <header class="bg-white shadow-md p-4 flex justify-between items-center sticky top-0 z-20">
            <h2 class="text-xl font-semibold text-gray-900">Selamat Datang, Admin!</h2>
            <div class="flex items-center space-x-4">
                <span class="text-gray-600">Admin Utama</span>
                <img class="h-10 w-10 rounded-full object-cover" src="https://via.placeholder.com/150/0000FF/FFFFFF?text=A" alt="Foto Admin">
            </div>
        </header>

        <main class="main-content flex-1 p-6 space-y-8">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <div class="bg-white p-5 rounded-lg shadow-lg flex items-center justify-between border-l-4 border-green-500">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Artikel</p>
                        <p class="text-2xl font-bold text-gray-900">145</p>
                    </div>
                    <i class="fas fa-book-open text-3xl text-green-500 opacity-50"></i>
                </div>

                <div class="bg-white p-5 rounded-lg shadow-lg flex items-center justify-between border-l-4 border-amber-500">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Pengunjung Bulan Ini</p>
                        <p class="text-2xl font-bold text-gray-900">12,450</p>
                    </div>
                    <i class="fas fa-chart-line text-3xl text-amber-500 opacity-50"></i>
                </div>

                <div class="bg-white p-5 rounded-lg shadow-lg flex items-center justify-between border-l-4 border-blue-500">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Produk Terjual</p>
                        <p class="text-2xl font-bold text-gray-900">85</p>
                    </div>
                    <i class="fas fa-hand-holding-usd text-3xl text-blue-500 opacity-50"></i>
                </div>
                
                <div class="bg-white p-5 rounded-lg shadow-lg flex items-center justify-between border-l-4 border-red-500">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Laporan Pending</p>
                        <p class="text-2xl font-bold text-gray-900">4</p>
                    </div>
                    <i class="fas fa-exclamation-triangle text-3xl text-red-500 opacity-50"></i>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Artikel Terbaru</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penulis</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Inovasi Sampah Plastik</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Tim Peneliti RRCO</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Published
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>
                                    <a href="#" class="text-red-600 hover:text-red-900">Hapus</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Kampanye Pantai Bersih</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Lina Susanti</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Draft
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>
                                    <a href="#" class="text-red-600 hover:text-red-900">Hapus</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </main>
        
        <footer class="p-4 text-center text-sm text-gray-500 border-t bg-white">
            &copy; 2025 RRCO Admin Dashboard. Hak Cipta Dilindungi.
        </footer>
    </div>

</body>
</html>