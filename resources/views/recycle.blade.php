<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home - Proyek_Tim</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <style>
        /* Small set of page-specific enhancements while leveraging Tailwind for most styling */
        .hero-bg { background-image: linear-gradient(180deg, rgba(6, 95, 21, 0.72), rgba(4,120,87,0.5)), url('/image/backgorund.webp'); background-size: cover; background-position: center; position: sticky; background-attachment: fixed;}
        .progress-ring circle { transition: stroke-dashoffset 0.9s cubic-bezier(.2,.9,.3,1); transform: rotate(-90deg); transform-origin: 50% 50%; }
        .float-blob { filter: blur(10px); opacity: 0.12; }
        .slider-scroll { scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch; }
        .card-surface { backdrop-filter: blur(6px); }

        /* Small helpers to visually match welcome.blade styles */
        .bg-custom-green-gradient { background: linear-gradient(to right, #10B981, #34D399); }
        .infographic-card { background: linear-gradient(180deg,#ffffff,#f8fff9); border: 1px solid rgba(72,187,120,0.06); }
    </style>
</head>
<body class="antialiased text-gray-800 bg-gray-50 font-sans">

    <x-navbar />

    <section class="hero-bg relative text-white pt-34 pb-20">
        <div class="absolute inset-0 bg-linear-to-b from-black/30 to-black/10"></div>
        <div class="relative max-w-6xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div class="space-y-6">
                    <h1 class="text-4xl sm:text-5xl font-extrabold leading-tight">Setor Sampah Jadi Saldo dan Uang</h1>
                    <p class="text-lg text-amber-100 max-w-xl">Bergabung jadi nasabah kami, kamu tidak perlu repot-repot setorkan sampahmu karena sudah ada bank sampah digital!.</p>
                    <div class="flex items-center space-x-4">
                        <a href="#pengajuan" class="inline-flex items-center px-6 py-3 bg-linear-to-r from-amber-500 to-amber-400 hover:bg-amber-300 text-emerald-900 font-semibold rounded-full shadow">Isi Form Pengajuan</a>
                        <a href="#bagaimana" class="text-sm text-amber-100 hover:underline">Pelajari Proses →</a>
                    </div>
                    <div class="mt-4 flex items-center gap-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 rounded-full bg-green-700"></div>
                            <div class="text-sm">Terdaftar: <span class="font-semibold">{{ number_format(\App\Models\User::count()) }}</span></div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 rounded-full bg-amber-300"></div>
                            <div class="text-sm">Target komunitas: <span class="font-semibold">1.000</span></div>
                        </div>
                    </div>
                </div>

                @php
                    $engagedCount = \App\Models\User::count();
                    $targetCount = 1000;
                    $percentage = min(100, ($targetCount>0) ? ($engagedCount / $targetCount) * 100 : 0);
                    $radius = 44; $circ = 2 * 3.14159 * $radius;
                    $offset = $circ - ($percentage/100) * $circ;
                @endphp
                <div class="relative">
                    <div class="bg-white/6 rounded-2xl p-6 w-full sm:w-80 card-surface shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm text-green-100 font-bold uppercase tracking-wide">Progress Komunitas</h3>
                                <p class="text-xs text-green-200">Menuju target pendaftar</p>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-amber-400">{{ number_format($engagedCount) }} / {{ number_format($targetCount) }}</div>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center justify-center">
                            <svg width="120" height="120" viewBox="0 0 100 100" class="progress-ring" role="img" aria-label="Progress komunitas">
                                <circle cx="50" cy="50" r="44" stroke="rgba(255,255,255,1.0)" stroke-width="10" fill="none"></circle>
                                <circle cx="50" cy="50" r="44" stroke="#047857" stroke-width="10" stroke-dasharray="{{ $circ }}" stroke-dashoffset="{{ $offset }}" stroke-linecap="round" fill="none"></circle>
                                <text x="50" y="54" text-anchor="middle" font-size="14" fill="#fef3c7" font-weight="700">{{ number_format($percentage, 2, ',', '.') }}%</text>
                            </svg>
                        </div>
                        <p class="mt-3 text-xs text-amber-400 font-bold text-center">Ayo ajak teman — setiap pendaftaran mendekatkan kita ke target!</p>
                    </div>
                    <!-- decorative accents similar to welcome page -->
                    <div class="absolute -top-8 -left-10 text-7xl text-green-900 opacity-10 hidden md:block">🌿</div>
                    <div class="absolute -bottom-6 right-6 text-6xl text-amber-300 opacity-10 hidden md:block">♻️</div>
                </div>
            </div>
        </div>
    </section>
<section id="bank-sampah" class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-8">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-green-900">Bank Sampah Digital — Solusi Daur Ulang Modern</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto mt-3">Menjadi nasabah Bank Sampah Digital berarti mengubah sampah menjadi nilai — dapatkan poin, laporan transaksi, dan kemudahan penjemputan melalui aplikasi atau situs ini.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <div class="p-6 border border-neutral-200 rounded-lg shadow-sm">
                    <h4 class="text-lg font-semibold text-green-800">Apa itu Bank Sampah Digital?</h4>
                    <p class="text-sm text-gray-600 mt-2">Bank Sampah Digital adalah layanan yang memfasilitasi masyarakat untuk menyetorkan sampah terpilah dan mendapatkan poin yang dapat ditukar menjadi saldo, voucher, atau tunai. Semua tercatat secara elektronik sehingga transparan.</p>
                </div>
                <div class="p-6 border border-neutral-200 rounded-lg shadow-sm">
                    <h4 class="text-lg font-semibold text-green-800">Keuntungan Jadi Nasabah</h4>
                    <ul class="mt-2 text-sm text-gray-600 list-disc list-inside space-y-1">
                        <li>Rekap transaksi otomatis dan riwayat penyerahan.</li>
                        <li>Poin dapat dikonversi jadi saldo E-Wallet atau uang tunai.</li>
                        <li>Jadwal penjemputan fleksibel dan prioritas untuk nasabah aktif.</li>
                        <li>Insentif komunitas dan program loyalitas.</li>
                    </ul>
                </div>
                <div class="p-6 border border-neutral-200 rounded-lg shadow-sm">
                    <h4 class="text-lg font-semibold text-green-800">Bagaimana Cara Bergabung</h4>
                    <ol class="mt-2 text-sm text-gray-600 list-decimal list-inside space-y-1">
                        <li>Buat akun atau masuk (klik tombol Daftar / Masuk).</li>
                        <li>Isi form pengajuan sampah pertama kali sebagai nasabah.</li>
                        <li>Jadwalkan penjemputan — tim kami akan menimbang dan mencatat transaksi.</li>
                        <li>Dapatkan poin dan cek riwayat di halaman profil Anda.</li>
                    </ol>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-700 to-green-500 text-white rounded-2xl p-6 flex flex-col md:flex-row items-center justify-between gap-4">
                <div>
                    <h3 class="text-xl font-bold">Siap jadi nasabah Bank Sampah Digital?</h3>
                    <p class="text-sm mt-1 opacity-90">Daftar sekarang dan kirim sampahmu pada kami.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('sampah.form') }}" class="inline-flex items-center px-5 py-3 bg-white text-green-800 font-semibold rounded-lg shadow hover:opacity-95">Ajukan Sampah</a>
                    @if(auth()->check())
                        <a href="{{ route('profile.points') }}" class="inline-flex items-center px-5 py-3 bg-white/20 text-white border border-white/30 font-semibold rounded-lg">Lihat Poin Saya</a>
                    @else
                        <a href="{{ route('register') }}" class="inline-flex items-center px-5 py-3 bg-white/20 text-white border border-white/30 font-semibold rounded-lg">Daftar Jadi Nasabah</a>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- KRITERIA SAMPAH -->
    <section id="kriteria" class="py-12 bg-gray-50">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-extrabold text-green-800">Kriteria Sampah yang Kami Terima</h2>
                    <p class="text-sm text-gray-600">Pastikan sampah Anda memenuhi syarat agar mendapatkan poin maksimal dan proses cepat.</p>
                </div>
                <div>
                    <button id="open-criteria" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-400 hover:bg-amber-300 text-black rounded-md font-semibold shadow">Lihat Kriteria</button>
                </div>
            </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition">
                    <h4 class="font-semibold text-green-800">Aman</h4>
                    <p class="text-sm text-gray-600 mt-2">
                        Sampah yang dikirim harus aman untuk ditangani, tanpa risiko cedera bagi petugas kami(Dalam keadaan akan meledak, terbakar, atau berbahaya misalnya).
                    </p>
                </div>
                <div class="p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition">
                    <h4 class="font-semibold text-green-800">Terpilah</h4>
                    <p class="text-sm text-gray-600 mt-2">
                        Pisahkan jenis sampah (Barang Elektronik, Mesin, Besi, Sampah Organik, Minyak Jelantah, Kertas) agar proses verifikasi lebih cepat.
                    </p>
                </div>
                <div class="p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition">
                    <h4 class="font-semibold text-green-800">Masih ada kelayakan</h4>
                    <p class="text-sm text-gray-600 mt-2">
                        Kami tidak menerima sampah dalam kondisi asal-asalan, misalnya sampah organik yang sudah basi dan membusuk(Pastikan jangan sampai sudah dihinggapi serangga), hancur berkeping-keping sampai tidak berbentuk dan sejenisnya.

                    </p>
                </div>
            </div>

            <!-- Jenis Sampah + Kondisi Panel (styling closer to welcome) -->
            <div class="mt-10 bg-white rounded-2xl p-6 shadow-md infographic-card">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-extrabold text-green-800">Jenis Sampah</h3>
                        <p class="text-sm text-gray-600">Empat jenis sampah yang sering kami terima dan contoh barangnya</p>
                    </div>
                    <div class="text-sm text-gray-500 text-right">
                        <div class="font-semibold">Kondisi Sampah yang Kami Terima</div>
                        <div class="mt-1 text-xs">Aman • Terpilah • Ada Kelayakan</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <button class="group relative overflow-hidden rounded-2xl shadow hover:shadow-lg bg-white border border-gray-100 p-6 text-left hover:scale-[1.02] transition transform focus:outline-none focus:ring-2 focus:ring-amber-200">
                        <div class="flex items-start gap-4">
                            <div class="text-4xl"></div>
                            <div>
                                <div class="font-semibold text-green-800">Barang Elektronik</div>
                                <div class="text-xs text-gray-600 mt-1">HP bekas(Baterai dilepas), PCB, prosessor, RAM, bagian-bagian komputer(mouse, keyboard, layer, monitor, PC), remote rusak, charger rusak + kabel, TV Rusak.</div>
                            </div>
                        </div>
                        <div class="mt-4 text-xs text-gray-700">
                        </div>
                    </button>

                    <button class="group relative overflow-hidden rounded-2xl shadow hover:shadow-lg bg-white border border-gray-100 p-6 text-left hover:scale-[1.02] transition transform focus:outline-none focus:ring-2 focus:ring-amber-200">
                        <div class="flex items-start gap-4">
                            <div class="text-4xl"></div>
                            <div>
                                <div class="font-semibold text-green-800">Besi</div>
                                <div class="text-xs text-gray-600 mt-1">Besi bekas, besi tua, stainless, aluminium, tembaga(kabel kupasan/kabel utuh nanti kami kupas).</div>
                            </div>
                        </div>
                        <div class="mt-4 text-xs text-gray-700">
                        </div>
                    </button>

                    <button class="group relative overflow-hidden rounded-2xl shadow hover:shadow-lg bg-white border border-gray-100 p-6 text-left hover:scale-[1.02] transition transform focus:outline-none focus:ring-2 focus:ring-amber-200">
                        <div class="flex items-start gap-4">
                            <div class="text-4xl"></div>
                            <div>
                                <div class="font-semibold text-green-800">Plastik</div>
                                <div class="text-xs text-gray-600 mt-1">Botol minum plastik, gelas plastik, jerigen bersih. *Jangan ada air dan minyak di dalamnya</div>
                            </div>
                        </div>
                        <div class="mt-4 text-xs text-gray-700">
                        </div>
                    </button>

                    <button class="group relative overflow-hidden rounded-2xl shadow hover:shadow-lg bg-white border border-gray-100 p-6 text-left hover:scale-[1.02] transition transform focus:outline-none focus:ring-2 focus:ring-amber-200">
                        <div class="flex items-start gap-4">
                            <div class="text-4xl"></div>
                            <div>
                                <div class="font-semibold text-green-800">Sampah Organik</div>
                                <div class="text-xs text-gray-600 mt-1">Daun, sisa sampah dapur rumah tangga(makanan). *Jangan sampai sudah busuk duluan, berbau menyengat dan dihinggapi serangga</div>
                            </div>
                        </div>
                        <div class="mt-4 text-xs text-gray-700">
                        </div>
                    </button>

                    <button class="group relative overflow-hidden rounded-2xl shadow hover:shadow-lg bg-white border border-gray-100 p-6 text-left hover:scale-[1.02] transition transform focus:outline-none focus:ring-2 focus:ring-amber-200">
                        <div class="flex items-start gap-4">
                            <div class="text-4xl"></div>
                            <div>
                                <div class="font-semibold text-green-800">Minyak Jelantah</div>
                                <div class="text-xs text-gray-600 mt-1">Minyak bekas penggorengan, minyak lama.</div>
                            </div>
                        </div>
                        <div class="mt-4 text-xs text-gray-700">
                        </div>
                    </button>

                    <button class="group relative overflow-hidden rounded-2xl shadow hover:shadow-lg bg-white border border-gray-100 p-6 text-left hover:scale-[1.02] transition transform focus:outline-none focus:ring-2 focus:ring-amber-200">
                        <div class="flex items-start gap-4">
                            <div class="text-4xl"></div>
                            <div>
                                <div class="font-semibold text-green-800">Kertas</div>
                                <div class="text-xs text-gray-600 mt-1">Kertas/kardus kering, bebas minyak/makanan, tidak sobek parah; pisahkan jenis (karton vs kertas halus).</div>
                            </div>
                        </div>
                        <div class="mt-4 text-xs text-gray-700">
                        </div>
                    </button>

                </div>
            </div>
        </div>
    </section>

    <!-- BANK SAMPAH DIGITAL (New Professional Section) -->
    

    <!-- Reward Card (below Kriteria & Jenis) -->
    {{-- <section id="reward-card" class="max-w-6xl mx-auto px-6 mt-8">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-100">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-0">
                <div class="lg:col-span-1">
                    <img src="/image/haduah.webp" alt="Reward Foto" class="w-full h-48 lg:h-full object-cover">
                </div>
                <div class="p-6 lg:col-span-2">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-2xl font-extrabold text-green-800">Reward Spesial — Tukarkan Poin Anda</h3>
                            <p class="text-sm text-gray-600 mt-2">Gunakan poin hasil daur ulang untuk menukar voucher dan merchandise ramah lingkungan. Pastikan Anda memenuhi kriteria sampah untuk mendapatkan poin maksimal.</p>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-gray-500">Estimasi</div>
                            <div class="text-xl font-bold text-amber-500">Mulai 500 Poin</div>
                        </div>
                    </div>

                    <div class="mt-4 flex items-center gap-4">
                        <a href="{{ route('rewards.index') }}" class="inline-flex items-center px-5 py-2 bg-linear-to-r from-amber-400 to-amber-500 text-black font-semibold rounded-full shadow hover:scale-[1.02] transition focus:outline-none focus:ring-2 focus:ring-amber-300">Lihat Hadiah</a>
                        <a href="{{ route('profile.points') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-700 to-green-800 font-bold text-white rounded-full shadow hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-400">Cek Poin Saya</a>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <div id="criteria-modal" class="fixed mt-10 overflow-y-scroll flex justify-center items-center inset-0 z-50 hidden items-center justify-center px-4 py-6">
        <div id="criteria-backdrop" class="absolute backdrop-blur-sm"></div>
        <div class="relative max-w-3xl w-full bg-white rounded-lg shadow-xl z-10">
            <div class="flex items-start justify-between p-6 ">
                <div>
                    <h3 class="text-lg font-bold text-green-800">Kriteria Sampah yang Diterima</h3>
                    <p class="text-sm text-gray-600 mt-1">Petunjuk singkat agar pengajuan Anda diterima dan mendapat poin maksimal.</p>
                </div>
                <button id="close-criteria" class="text-gray-500 hover:text-gray-800 rounded-md">&times;</button>
            </div>
            <div class="p-6 space-y-4">
                <section>
                    <h4 class="font-semibold">Persyaratan Umum</h4>
                    <ul class="list-disc list-inside text-sm text-gray-700 mt-2 space-y-1">
                        <li>Sampah yang dikirim sesuai dengan kategori yang kami sediakan, bukan sampah yang asal ada.</li>
                        <li>Pastikan sampah dalam kondisi yang aman (Misalnya, jika barang elektro jangan dalam keadaan menggembung atau dalam kondisi mudah meledak, rusak total, hangus).</li>
                        <li>Bila sampah organik, jangan kirim sampah dengan keadaan seperti berikut: Basah, membusuk, dipenuhi serangga, tercampur dengan bahan berbahaya.</li>
                    </ul>
                </section>

                <section>
                    <h4 class="font-semibold">Jenis yang Tidak Diterima</h4>
                    <p class="text-sm text-gray-700 mt-2">Barang yang benar-benar hancur(hangus, meledak) sehingga tidak bisa diapa-apakan lagi, barang berbahaya, barang aneh yang tidak sesuai ketentuan.</p>
                </section>

                <section>
                    <h4 class="font-semibold">Tips Pengemasan</h4>
                    <ul class="list-disc list-inside text-sm text-gray-700 mt-2 space-y-1">
                        <li>Gunakan kantong tertutup untuk mencegah tumpahan dan barang berserakan.</li>
                        <li>Labeli paket jika berisi jenis berbeda untuk memudahkan verifikasi.</li>
                    </ul>
                </section>

                <div class="pt-4 flex items-center justify-end gap-3">
                    <button id="close-criteria-2" class="px-4 py-2 bg-gray-100 rounded-md">Tutup</button>
                    <a href="{{ route('sampah.form') }}" class="px-4 py-2 bg-green-700 text-white rounded-md">Ajukan Sekarang</a>
                </div>
            </div>
        </div>
    </div>


    <!-- HOW IT WORKS + SLIDER -->
    <section id="bagaimana" class="py-16">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-8">
                <h2 class="text-4xl font-extrabold text-green-800">Bagaimana Cara Kerjanya</h2>
                <p class="text-sm text-gray-600">Alur singkat proses — cepat, transparan, dan dapat dipertanggungjawabkan.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-12">
                <div class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition">
                    <div class="text-xl font-bold text-amber-500">1.</div>
                    <h4 class="mt-3 font-semibold">Kirim Pengajuan</h4>
                    <p class="text-sm text-gray-600 mt-1">Isi detail jenis & jumlah sampah, pilih hari dan jam sampahmu akan diambil. Nanti akan ada petugas kurir sampah kami yang datang ke rumahmu.<br> 
                {{-- <br> <span class="font-bold text-black">Lihat daftar petugas kami</span></p> --}}
                </div>
                <div class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition">
                    <div class="text-xl font-bold text-green-900">2.</div>
                    <h4 class="mt-3 font-semibold">Verifikasi & Penghitungan Sampah</h4>
                    <p class="text-sm text-gray-600 mt-1">Tim kurir kami yang datang ke rumahmu akan membawa timbangan dan menghitung barangmu, kamu akan dibayar secara langsung menggunakan poin atau uang tunai<br>
                    <span class="font-bold text-black">Pastikan Sampamu: </span><span class="text-green-900 font-bold">Aman • Terpilah • Masih Ada Kelayakan</span> supaya poin yang kamu dapatkan banyak!.
                    </p>
                </div>
                <div class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition">
                    <div class="text-xl text-amber-500 font-bold">3.</div>
                    <h4 class="mt-3 font-semibold">Kumpulkan Poin</h4>
                    <p class="text-sm text-gray-600 mt-1">Kamu akan mendapatkan poin setelah petugas kami selesai menimbang. Kumpulkan poin untuk jadi saldo E-Wallet. *Cek akumulasi berapa rupiah yang anda dapatkan untuk 1 poin.<br>
                    <button class="p-3 mt-2 rounded-full bg-linear-to-r from-amber-400 to-amber-500 text-black font-semibold"><a href="{{ route('profile.edit') }}">Cek Keuntungan Poin</a></button></p>
                </div>
            </div>

            <div class="relative">
                <div class="overflow-x-auto slider-scroll -mx-4 px-4 pb-4" id="recycle-slider">
                    <div class="flex gap-4 w-max">
                        @php
                            $items = [
                                ['emoji'=>'','title'=>'Brg Elektro','value'=>'start 900 Poin','bg'=>'bg-green-700'],
                                ['emoji'=>'','title'=>'Besi','value'=>'350 Poin/kg','bg'=>'bg-amber-500'],
                                ['emoji'=>'','title'=>'Plastik','value'=>'500 poin/kg','bg'=>'bg-green-700'],
                                ['emoji'=>'','title'=>'Minyak Jelantah','value'=>'400 Poin/kg','bg'=>'bg-amber-500'],
                                ['emoji'=>'','title'=>'Smph Organik','value'=>'Start 100 poin','bg'=>'bg-green-700'],
                                ['emoji'=>'','title'=>'Kertas','value'=>'200 Poin/kg','bg'=>'bg-amber-500'],
                            ];
                        @endphp
                        @foreach($items as $it)
                            <div class="min-w-[260px] snap-center rounded-2xl p-6 text-white {{ $it['bg'] }} shadow-lg flex flex-col justify-between">
                                <div class="flex items-start justify-between">
                                    <div class="text-4xl">{!! $it['emoji'] !!}</div>
                                    <div class="text-xs uppercase font-semibold opacity-90">Estimasi Poin</div>
                                </div>
                                <div class="mt-6">
                                    <div class="text-2xl font-bold">{{ $it['title'] }}</div>
                                    <div class="text-3xl font-extrabold">{{ $it['value'] }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="mt-4 flex items-center justify-center space-x-2" id="slider-dots" aria-hidden="false"></div>
            </div>
        </div>
    </section>


    <!-- CTA FORM -->
    <section id="pengajuan" class="py-16 hero-bg">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h3 class="text-2xl text-white font-bold">Punya barang nganggur atau sampah layak?</h3>
            <p class="text-sm text-green-100 mt-2">Mulai kirim sampah Anda dan dapatkan poin yang bisa ditukar.</p>
            <div class="mt-6">
                <a href="{{ route('sampah.form') }}" class="inline-flex items-center px-6 py-3 bg-green-800 hover:bg-green-700 text-white font-semibold rounded-full shadow">Isi Form Pengajuan</a>
            </div>
        </div>
    </section>

    <!-- USER SUBMISSIONS (AUTH) -->
    @if(auth()->check())
    <section class="py-12">
        <div class="max-w-6xl mx-auto px-6">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            <h3 class="text-xl font-bold mb-4">Status Pengajuan Anda</h3>

            @if($submissions->isEmpty())
                <div class="p-6 bg-white rounded shadow text-center">Anda belum mengajukan sampah. <a href="{{ route('sampah.form') }}" class="text-emerald-700 underline">Ajukan sekarang</a>.</div>
            @else
                <div class="space-y-4">
                    @foreach($submissions as $s)
                        <div class="bg-white p-4 rounded-xl shadow flex flex-col sm:flex-row items-start sm:items-center gap-4">
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <div class="text-sm text-gray-500">#{{ $s->id }} — {{ $s->created_at->format('d M Y H:i') }}</div>
                                    <div class="text-xs px-3 py-1 rounded-full font-semibold {{ $s->status === 'rejected' ? 'bg-red-50 text-red-700' : 'bg-green-50 text-green-700' }}">{{ ucfirst($s->status) }}</div>
                                </div>
                                <div class="mt-2 font-semibold text-gray-800">{{ ucfirst($s->jenis) }} — {{ ucfirst($s->metode) }}</div>
                                <div class="text-sm text-gray-600 mt-2">Poin: <span class="font-medium">{{ $s->points_awarded ?? 0 }}</span></div>

                                @if($s->metode === 'pickup')
                                    <div class="mt-2 text-sm text-gray-600">
                                        Jadwal penjemputan: <span class="font-medium">{{ $s->tanggal_pickup ?? '-' }} {{ $s->waktu_pickup ? 'pukul ' . $s->waktu_pickup : '' }}</span>
                                    </div>
                                @endif

                                @if(($s->status === 'rejected' && $s->reject_reason) || ($s->admin_message && $s->status === 'rejected'))
                                    <div class="mt-3 p-3 bg-red-50 border border-red-100 rounded">
                                        <div class="text-sm text-red-700 font-semibold">Alasan ditolak:</div>
                                        <div class="text-sm text-red-700 mt-1">{{ Str::limit($s->reject_reason ?? $s->admin_message, 250) }}</div>
                                    </div>
                                @elseif($s->status === 'accepted' && $s->admin_message)
                                    <div class="mt-3 p-3 bg-green-50 border border-green-100 rounded">
                                        <div class="text-sm text-green-700 font-semibold">Pesan dari admin:</div>
                                        <div class="text-sm text-green-700 mt-1">{{ Str::limit($s->admin_message, 250) }}</div>
                                    </div>
                                @endif
                            </div>
                            @if($s->foto_path)
                                <img src="{{ $s->foto_path }}" alt="foto" class="w-36 h-24 object-cover rounded-lg">
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
    @endif


    <!-- Forum Diskusi (widget) -->
    <section id="forum-widget" class="py-6 bg-gray-50">
        <div class="max-w-6xl mx-auto px-6">
            <div class="bg-white rounded-2xl p-6 shadow-md">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-green-800">Forum Diskusi</h3>
                        <p class="text-sm text-gray-600 mt-1">Masih punya pertanyaan? Kurang ngerti dengan alur kerjanya? Tanyakan saja! Ga akan kami kacangin!</p>
                    </div>
                    <a href="{{ route('forum.index') }}" class="text-sm font-bold text-white bg-green-600 p-2 rounded-md">Buka forum →</a>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <form action="{{ route('forum.store') }}" method="POST" class="space-y-3">
                            @csrf
                            <input type="text" name="title" placeholder="Judul singkat" class="w-full rounded-md bg-gray-50 px-3 py-2 focus:ring-2 focus:ring-emerald-300 focus:outline-none" required>
                            <textarea name="body" rows="3" placeholder="Tulis pertanyaan Anda di sini..." class="w-full rounded-md bg-gray-50 px-3 py-2 focus:ring-2 focus:ring-emerald-300 focus:outline-none" required></textarea>
                            {{-- @guest
                                <div class="grid grid-cols-2 gap-2">
                                    <input name="name" placeholder="Nama (opsional)" class="rounded-md bg-gray-50 px-3 py-2 focus:ring-0 focus:outline-none" />
                                    <input name="email" placeholder="Email (opsional)" class="rounded-md bg-gray-50 px-3 py-2 focus:ring-0 focus:outline-none" />
                                </div>
                            @endguest --}}
                            <div class="mt-3 text-right">
                                <button class="inline-flex items-center gap-2 bg-green-600 text-white py-2 px-4 rounded-full shadow hover:bg-green-700">Kirim</button>
                            </div>
                        </form>
                    </div>

                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-3">Pertanyaan Terbaru</h4>
                        <div class="space-y-3">
                            @php $recent = \App\Models\ForumThread::orderBy('created_at','desc')->take(2)->get(); @endphp
                            @forelse($recent as $r)
                                <a href="{{ route('forum.show', $r->id) }}" class="block p-3 rounded-lg border-neutral-200 border-1 hover:bg-gray-50">
                                    <div class="font-medium text-sm">{{ $r->title }}</div>
                                    <div class="text-xs text-gray-500 mt-1">{{ $r->created_at->diffForHumans() }} • {{ $r->name ?? 'Pengguna' }}</div>
                                </a>
                            @empty
                                <div class="text-sm text-gray-500">Belum ada pertanyaan — jadilah yang pertama.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

        <x-footer />

    <script>
        // Slider dots + active tracking (simple, performant)
        (function(){
            const slider = document.getElementById('recycle-slider');
            if(!slider) return;
            const container = slider.querySelector('div.flex');
            const cards = Array.from(container.children);
            const dots = document.getElementById('slider-dots');

            cards.forEach((c,i)=>{
                const btn = document.createElement('button');
                btn.className = 'w-2 h-2 rounded-full bg-gray-300';
                btn.setAttribute('aria-label','Slide '+(i+1));
                btn.addEventListener('click', ()=>{
                    c.scrollIntoView({behavior:'smooth', inline:'center'});
                });
                dots.appendChild(btn);
            });

            const dotEls = Array.from(dots.children);
            function update(){
                const rect = slider.getBoundingClientRect();
                let closest = 0; let mind = Infinity;
                cards.forEach((c,i)=>{
                    const r = c.getBoundingClientRect();
                    const center = r.left + r.width/2;
                    const d = Math.abs(center - (rect.left + rect.width/2));
                    if(d < mind){ mind = d; closest = i; }
                });
                dotEls.forEach((d,idx)=> d.classList.toggle('bg-green-700', idx===closest));
            }
            slider.addEventListener('scroll', ()=> requestAnimationFrame(update), {passive:true});
            setTimeout(update, 120);
        })();

    (function(){
        const openBtn = document.getElementById('open-criteria');
        const modal   = document.getElementById('criteria-modal');
        const backdrop = document.getElementById('criteria-backdrop');
        const closeBtn = document.getElementById('close-criteria');
        const closeBtn2 = document.getElementById('close-criteria-2');

        if (!openBtn || !modal) return;

        function openModal() {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeModal() {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        openBtn.addEventListener('click', openModal);
        backdrop.addEventListener('click', closeModal);
        closeBtn.addEventListener('click', closeModal);
        closeBtn2.addEventListener('click', closeModal);

        // Escape key support
        document.addEventListener('keydown', function(e){
            if(e.key === 'Escape') closeModal();
        });
    })();

    </script>

</body>
</html>