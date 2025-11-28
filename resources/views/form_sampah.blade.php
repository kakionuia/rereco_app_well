<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengajuan Pengelolaan Sampah</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>

        .radio-card {
            transition: all 0.2s ease;
        }
        .radio-card:hover {
            box-shadow: 0 4px 10px rgba(4, 120, 87, 0.1);
        }
        input[type="radio"]:checked + .radio-card {
            border-color: #047857; /* Hijau utama */
            background-color: #ecfdf5; /* Hijau sangat muda */
            box-shadow: 0 4px 12px rgba(4, 120, 87, 0.2);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-green-700 to-green-900 p-4 md:p-8 flex items-center justify-center min-h-screen">
<x-app-layout>
    <div class="w-full max-w-xl bg-white rounded-xl shadow-2xl p-6 md:p-10 border border-primary-green/20">
        <header class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-primary-green">Pengajuan Daur Ulang</h1>
            <p class="text-gray-500 mt-2">Isi detail sampah dan pilih metode penyerahan yang Anda inginkan.</p>
        </header>

        <form id="formSampah" class="space-y-6" action="{{ route('sampah.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- 1. Jenis Sampah -->
            <div>
                <label for="jenisSampah" class="block text-sm font-medium text-gray-700 mb-1">
                    Jenis Sampah yang Diajukan:
                </label>
                    <select id="jenisSampah" name="jenisSampah" required 
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-green focus:ring-primary-green p-3 border">
                    <option value="">-- Pilih Jenis Sampah --</option>
                    <option value="Barang Elektronik">Barang Elektronik</option>
                    <option value="Besi">Besi</option>
                    <option value="Plastik">Plastik</option>
                    <option value="Minyak Jelantah">Minyak Jelantah</option>
                    <option value="Kertas">Kertas</option>
                    <option value="Sampah Organik">Sampah Organik</option>
                </select>
            </div>

            <!-- 2. Foto Sampah -->
            <div>
                <label for="fotoSampah" class="block text-sm font-medium text-gray-700 mb-1">
                    Unggah Foto Sampah (Max 5MB):
                </label>
                <input type="file" id="fotoSampah" name="fotoSampah" accept="image/*" required
                       class="mt-1 block w-full text-sm text-gray-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-full file:border-0
                              file:text-sm file:font-semibold
                              file:bg-primary-green/10 file:text-primary-green
                              hover:file:bg-primary-green/20"
                >
            </div>

            <!-- 3. Deskripsi Kerusakan Sampah -->
            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">
                    Deskripsi Detail Kondisi Sampah:
                </label>
                <textarea id="deskripsi" name="deskripsi" rows="3" required
                          placeholder="Jelaskan kondisi sampah (misalnya: 'Plastik bekas minyak, sudah dibilas', 'Kardus basah, harus dikeringkan')"
                          class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-green focus:ring-primary-green p-3 border"></textarea>
            </div>

            <!-- 3b. Perkiraan Berat -->
            <div>
                <label for="estimated_weight" class="block text-sm font-medium text-gray-700 mb-1">Perkiraan Berat (kg):</label>
                <input type="number" id="estimated_weight" name="estimated_weight" step="0.1" min="0" placeholder="Contoh: 2.5"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-green focus:ring-primary-green p-3 border">
                <p class="text-sm text-gray-500 mt-1">Masukkan perkiraan berat sampah dalam kilogram (kg). Gunakan titik untuk desimal.</p>
            </div>

            <!-- 4. Metode Penyerahan - Pickup only -->
            <div class="pt-4">
                <label class="block text-lg font-bold text-gray-800 mb-3">Metode Penyerahan</label>
                <div class="p-4 rounded-lg bg-green-50 border border-primary-green/30">
                    <div class="font-semibold text-gray-800">Pickup (Dijemput)</div>
                    <div class="text-sm text-gray-600 mt-1">Tim kami akan menghampirimu berdasarkan jadwal penjemputan. Silakan pilih tanggal dan jam yang diinginkan untuk penjemputan.</div>
                </div>
                <input type="hidden" name="metode" value="pickup">
            </div>

            <!-- Input Detail Pickup (Conditional) -->
            <div id="pickupOptions" class="p-6 bg-green-50 rounded-lg border border-primary-green/50 space-y-4 transition-all duration-300" style="display: block;">
                <h3 class="text-xl font-bold text-primary-green border-b pb-2 mb-3">Detail Penjemputan</h3>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap:</label>
                    <div class="mt-1 text-gray-900 font-medium">{{ auth()->user()?->name ?? '' }}</div>
                    <input type="hidden" id="namaPickup" name="namaPickup" value="{{ auth()->user()?->name ?? '' }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap Pickup:</label>
                    <div class="mt-1 text-gray-900">{{ auth()->user()?->adress ?? '' }}</div>
                    <input type="hidden" id="alamatPickup" name="alamatPickup" value="{{ auth()->user()?->adress ?? '' }}">
                    @if(auth()->user()?->village && in_array(auth()->user()->village, ['Wanaherang','Cicadas','Cikeas Udik']))
                        <div class="text-xs text-gray-600 mt-1">Wilayah: <span class="font-semibold text-gray-800">{{ auth()->user()->village }}</span></div>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="tanggalPickup" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Rencana Pickup:</label>
                        <input type="date" id="tanggalPickup" name="tanggalPickup" required
                               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-accent-teal focus:ring-accent-teal p-3 border">
                    </div>
                    <div>
                        <label for="jamPickup" class="block text-sm font-medium text-gray-700 mb-1">Jam yang Diinginkan (HH:MM):</label>
                        <input type="time" id="jamPickup" name="jamPickup" required
                               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-accent-teal focus:ring-accent-teal p-3 border">
                    </div>
                </div>

            </div>

            <!-- Input Detail Dropoff (Conditional) -->
            <div id="dropoffOptions" class="p-6 bg-emerald-50 rounded-lg border border-accent-teal/50 space-y-4 transition-all duration-300" style="display: none;">
                <h3 class="text-xl font-bold text-accent-teal border-b pb-2 mb-3">Detail Dropoff</h3>

                <div>
                    <label for="dropoffLocation" class="block text-sm font-medium text-gray-700 mb-1">Lokasi Dropoff</label>
                    <select id="dropoffLocation" name="dropoffLocation"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-accent-teal focus:ring-accent-teal p-3 border">
                        <option value="SMKN 1 Gunungputri, Jl.Barokah No 6, Gunungputri, Bogor">SMKN 1 Gunungputri, Jl.Barokah No 6, Gunungputri, Bogor</option>
                    </select>
                </div>

                <p class="text-sm text-gray-600">Catatan: Jika memilih Dropoff, harap datang ke lokasi yang tertera dalam waktu 3 hari kerja agar admin dapat mengonfirmasi. Jika tidak dikonfirmasi oleh admin dalam 3 hari, pengajuan akan dihapus.</p>
            </div>

            <div class="pt-4">
                <button type="submit"
                        class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-full shadow-lg text-lg font-bold text-white bg-green-900 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-primary-green/50 transition duration-300">
                    Kirim Pengajuan Daur Ulang
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

    <script>
        function togglePickupOptions(metode) {
            const pickupDiv = document.getElementById('pickupOptions');
            const pickupInputs = pickupDiv.querySelectorAll('input, textarea, select');
            const dropoffDiv = document.getElementById('dropoffOptions');
            const dropoffInputs = dropoffDiv ? dropoffDiv.querySelectorAll('input, textarea, select') : [];

            if (metode === 'pickup') {
                pickupDiv.style.display = 'block';
                if (dropoffDiv) dropoffDiv.style.display = 'none';
                pickupInputs.forEach(input => input.setAttribute('required', 'required'));
                dropoffInputs.forEach(input => { input.removeAttribute('required'); input.value = ''; });
            } else if (metode === 'dropoff') {
                pickupDiv.style.display = 'none';
                if (dropoffDiv) dropoffDiv.style.display = 'block';
                dropoffInputs.forEach(input => input.setAttribute('required', 'required'));
                pickupInputs.forEach(input => { input.removeAttribute('required'); input.value = ''; });
            } else {
                pickupDiv.style.display = 'none';
                if (dropoffDiv) dropoffDiv.style.display = 'none';
                pickupInputs.forEach(input => { input.removeAttribute('required'); input.value = ''; });
                dropoffInputs.forEach(input => { input.removeAttribute('required'); input.value = ''; });
            }
        }

        // Note: we now submit the form to the server. The previous client-side modal was removed
        // so that server-side validation and redirects / flash messages work normally.
    </script>

</body>
</html>
