<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Tugas Kurir - Profesional</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Menggunakan font sistem untuk tampilan bersih */
        body { font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif; }
        /* Gaya untuk card tugas yang aktif */
        .task-card.active {
            @apply border-green-600 bg-green-50;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">

    <div class="container mx-auto p-0 sm:p-4 md:p-8">

        <header class="bg-white shadow-md p-4 md:p-6 mb-4 md:mb-6 rounded-lg">
            <h1 class="text-3xl font-extrabold text-gray-900">Dashboard Kurir Sampah</h1>
            <p class="text-lg text-gray-600">Wilayah Blok A Timur | <span class="font-semibold text-green-700">Bambang Wijaya, KS-001</span></p>
        </header>
        
        <main class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-1 bg-white shadow-xl rounded-xl overflow-hidden h-fit">
                
                <div class="p-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-xl font-semibold text-gray-800">Tugas Harian (3 Baru)</h2>
                </div>

                <div class="divide-y divide-gray-200 max-h-[80vh] overflow-y-auto">
                    
                    <div class="task-card active p-4 cursor-pointer border-l-4 border-transparent hover:bg-gray-50 transition duration-150">
                        <div class="flex justify-between items-center">
                            <p class="text-sm font-semibold text-gray-900">Penjemputan #101</p>
                            <span class="px-2 py-0.5 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">Baru</span>
                        </div>
                        <p class="text-xs text-gray-600 truncate">Siti Aisyah (Jl. Mawar No. 5)</p>
                        <p class="text-xs text-gray-500 mt-1">Perkiraan: 5 Kg</p>
                    </div>

                    <div class="task-card p-4 cursor-pointer border-l-4 border-transparent hover:bg-gray-50 transition duration-150">
                        <div class="flex justify-between items-center">
                            <p class="text-sm font-semibold text-gray-900">Penjemputan #102</p>
                            <span class="px-2 py-0.5 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">Baru</span>
                        </div>
                        <p class="text-xs text-gray-600 truncate">Warung Pojok (Pasar Tradisional)</p>
                        <p class="text-xs text-gray-500 mt-1">Perkiraan: 15 Kg</p>
                    </div>

                    <div class="task-card p-4 cursor-pointer border-l-4 border-transparent bg-white hover:bg-gray-50 transition duration-150 opacity-60">
                        <div class="flex justify-between items-center">
                            <p class="text-sm font-semibold text-gray-900 line-through">Penjemputan #099</p>
                            <span class="px-2 py-0.5 text-xs font-medium text-green-800 bg-green-100 rounded-full">Selesai</span>
                        </div>
                        <p class="text-xs text-gray-600 truncate">Keluarga Budi (Perumahan Indah)</p>
                        <p class="text-xs text-gray-500 mt-1">Aktual: 7.2 Kg</p>
                    </div>
                    
                </div>
            </div>
            
            <div class="lg:col-span-2 bg-white shadow-xl rounded-xl p-6">
                
                <h2 class="text-2xl font-bold text-gray-900 border-b pb-3 mb-4">Detail Tugas #101</h2>
                
                <div class="mb-6 p-4 border rounded-lg bg-gray-50">
                    <p class="text-sm text-gray-500">Informasi Pengguna</p>
                    <p class="text-xl font-semibold text-gray-800">Siti Aisyah</p>
                    <p class="text-md text-gray-700">Jl. Mawar No. 5, Blok A Timur</p>
                    <p class="text-sm text-gray-500 mt-2">Janji Temu: <span class="font-medium text-green-700">09:00 - 10:00</span></p>
                </div>

                <div class="space-y-6">
                    <h3 class="text-xl font-bold text-green-700">Konfirmasi Penjemputan</h3>
                    
                    <div>
                        <label for="berat-aktual" class="block text-sm font-medium text-gray-700">1. Berat Aktual Sampah Terkumpul (Kg)</label>
                        <input type="number" id="berat-aktual" placeholder="Contoh: 5.4" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 transition duration-150">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">2. Pilih Metode Insentif untuk Pengguna</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            
                            <label class="flex items-center p-4 border border-green-600 rounded-lg shadow-md bg-green-50 cursor-pointer">
                                <input type="radio" name="insentif" value="poin" checked class="h-5 w-5 text-green-600 border-green-300 focus:ring-green-500">
                                <span class="ml-3 text-sm font-medium text-green-900">Berikan Poin (Direkomendasikan)</span>
                            </label>

                            <label class="flex items-center p-4 border border-gray-300 rounded-lg shadow-sm bg-white hover:bg-gray-50 cursor-pointer">
                                <input type="radio" name="insentif" value="cash" class="h-5 w-5 text-green-600 border-gray-300 focus:ring-green-500">
                                <span class="ml-3 text-sm font-medium text-gray-900">Uang Tunai Langsung</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label for="catatan" class="block text-sm font-medium text-gray-700">3. Catatan (Opsional)</label>
                        <textarea id="catatan" rows="2" placeholder="Contoh: Sampah sudah dipilah rapi." class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"></textarea>
                    </div>

                    <button class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg text-lg shadow-lg transition duration-150 ease-in-out transform hover:scale-[1.01] focus:outline-none focus:ring-4 focus:ring-green-500 focus:ring-opacity-50">
                        <span class="flex items-center justify-center">
                             <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                             SELESAIKAN & CATAT TRANSAKSI INI
                        </span>
                    </button>
                    
                    <div class="text-center text-xs text-gray-500 pt-2">
                        Data akan otomatis dikirim ke sistem pencatatan poin.
                    </div>
                </div>

            </div>
            
        </main>
    </div>

</body>
</html>