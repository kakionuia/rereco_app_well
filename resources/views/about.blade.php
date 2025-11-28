@extends('layouts.app')
@section('content')

<style>
    /* Reusable keyframes and utility classes for the About page */
    @keyframes fadeUp { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes float { 0%{ transform: translateY(0) } 50%{ transform: translateY(-8px) } 100%{ transform: translateY(0) } }
    .reveal { opacity: 0; transform: translateY(18px); }
    .reveal.in-view { opacity: 1; transform: translateY(0); transition: all 700ms cubic-bezier(.2,.9,.2,1); }
    .float { animation: float 4s ease-in-out infinite; }
    .tilt { transform: rotate(-2deg); }
    .stat-num { font-variant-numeric: tabular-nums; }
    @keyframes pulse { 0% { transform: scale(1); opacity: 1 } 50% { transform: scale(1.04); opacity: .9 } 100% { transform: scale(1); opacity: 1 } }
    .pulse { animation: pulse 3s ease-in-out infinite; }
    @keyframes shimmer { 0% { background-position: -200% 0 } 100% { background-position: 200% 0 } }
    .shimmer { background-image: linear-gradient(90deg, rgba(255,255,255,0.06) 0%, rgba(255,255,255,0.14) 50%, rgba(255,255,255,0.06) 100%); background-size: 200% 100%; animation: shimmer 3s linear infinite; }
    .slide-left { transform: translateX(-18px); opacity: 0; transition: all 600ms cubic-bezier(.2,.9,.2,1); }
    .slide-left.in-view { transform: translateX(0); opacity: 1; }
    /* FAQ panel smooth height */
    .faq-panel { max-height: 0; overflow: hidden; transition: max-height 420ms ease; }
    /* Prevent ANY absolute blobs from causing horizontal overflow */
    section [class*="absolute"] {
    max-width: 100%;
    overflow-x: hidden;
}
html, body {
    overflow-x: hidden !important;
}

    /* subtle focus outline for keyboard users */
    .focus-ring:focus { outline: 3px solid rgba(34,197,94,0.25); outline-offset: 3px; }
</style>
<x-navbar></x-navbar>
<div class="overflow-hidden">

<!-- HERO -->
<section class="relative overflow-hidden bg-gradient-to-br from-green-800 to-green-700 text-white overflow-hidden">
    <div class="absolute inset-0 overflow-y-hidden pointer-events-none opacity-30">
        <img src="{{ asset('image/daun.png') }}" class="w-full h-full object-cover" alt="pattern"/>
    </div>

    <div class="relative max-w-7xl mx-auto px-6 py-28">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
            <div class="lg:pr-12">
                <h1 class="text-4xl md:text-5xl font-extrabold leading-tight reveal" data-delay="0">Tentang Reuse Recycle.CO</h1>
                <p class="mt-4 text-lg text-green-100 max-w-2xl reveal" data-delay="120">Platform daur ulang terpadu yang mengubah sampah layak pakai menjadi produk bernilai—efisien, menguntungkan, dan memberikan reward nyata bagi setiap kontribusi pengguna.</p>

                <div class="mt-8 flex flex-wrap gap-3 reveal" data-delay="240">
                    <a href="{{ route('recycle') }}" class="inline-flex items-center px-5 py-3 bg-amber-400 text-green-900 rounded-md font-semibold shadow focus-ring">Mulai Daur Ulang</a>
                    <a href="{{ route('shop.index') }}" class="inline-flex items-center px-5 py-3 border border-white/30 text-white rounded-md font-semibold hover:bg-white/5 focus-ring">Lihat Produk Kami</a>
                </div>
                <div class="mt-4">
                </div>

                @php
                    $totalKg = (float) \App\Models\SampahSubmission::where('status','completed')->sum('berat_aktual');
                    $productCount = (int) \App\Models\Product::count();
                @endphp
                <div class="mt-8 flex flex-wrap gap-6 text-sm text-green-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-amber-400/30 rounded-lg flex items-center justify-center float">♻️</div>
                        <div>
                            <div class="text-xs">Sampah yang berhasil kami daur ulang</div>
                            <div class="text-xl font-bold stat-num" data-target="{{ (int) $totalKg }}">{{ number_format($totalKg, 0) }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-amber-400/30 rounded-lg flex items-center justify-center float">🏭</div>
                        <div>
                            <div class="text-xs">Produk yang kami hasilkan</div>
                            <div class="text-xl font-bold stat-num" data-target="{{ $productCount }}">{{ $productCount }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-amber-400/10 rounded-lg flex items-center justify-center float">🤝</div>
                        <div>
                            <div class="text-xs">Partnership with</div>
                            <div class="text-xl font-bold stat-num">-</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative flex justify-center lg:justify-end">
                <div class="w-full sm:max-w-md rounded-2xl p-6 transform tilt reveal" data-delay="500">
                    <img src="{{ asset('image/cewek.png') }}" alt="illustration" class="w-full h-auto rounded-lg float" />
                </div>
            </div>
        </div>
    </div>

    <div class="absolute inset-x-0 bottom-0 z-10 pointer-events-none">
        <div class="relative -scroll-mb-20">
      <svg class="w-full h-20 wave-divider" viewBox="0 0 1440 120" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,32 C180,120 360,8 720,40 C1080,72 1260,0 1440,48 L1440 120 L0 120 Z" fill="#FDBA74" opacity="0.3"></path> 
        
        <path d="M0,48 C200,0 400,96 720,64 C1040,32 1240,80 1440,32 L1440 120 L0 120 Z" fill="#FBBF24"></path>
      </svg>
</div>
    </div>
</div>

</section>

<!-- LATAR BELAKANG -->
<section class="py-20 bg-linear-to-br from-green-50 to-white overflow-hidden">
    <div class="absolute inset-0 pointer-events-none opacity-10">
        <div class="w-72 h-72 bg-amber-50 rounded-full blur-3xl absolute -left-8 sm:-left-24 -top-16"></div>
        <div class="w-56 h-56 bg-green-50 rounded-full blur-2xl absolute right-0 sm:-right-12 -bottom-12"></div>
    </div>

    <div class="relative max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-10 items-center">
        <div class="reveal slide-left" data-delay="80">
            <h2 class="text-3xl font-bold text-green-800">Latar Belakang</h2>
            <p class="mt-4 text-gray-700 leading-relaxed">
Sampah layak pakai sering terbuang percuma, sementara kebutuhan akan produk ramah lingkungan terus meningkat. Untuk menjembatani hal ini, kami menghadirkan aplikasi hybrid yang menggabungkan <b>toko online produk daur ulang berkualitas</b> dengan <b>bank sampah digital.</b><br>

Pengguna dapat mengirimkan sampah sebagai bahan baku dan memperoleh poin reward yang dapat ditukar dengan voucher, diskon, atau belanja di aplikasi. Model ini menciptakan ekosistem yang saling menguntungkan—mengurangi limbah, menyediakan bahan baku, dan memberi manfaat nyata bagi pengguna.            <ul class="mt-6 space-y-3 text-gray-700">
                <li>• Menyediakan akses penjemputan bagi pengguna.</li>
                <li>• Membangun ekosistem poin yang transparan dan dapat ditukar.</li>
            </ul>
        </div>

        <div class="relative reveal" data-delay="160">
            <div class="rounded-2xl p-8 bg-white shadow-lg shimmer">
                <h3 class="font-semibold text-green-800">Mengapa ini penting?</h3>
                <p class="mt-3 text-gray-600">Sampah yang terkelola dapat menjadi bisnis, membuka lapangan kerja, dan menyediakan bahan baku untuk industri lokal/kami.</p>
                <div class="mt-6 grid grid-cols-2 gap-4">
                    <div class="p-4 bg-green-50 rounded-lg text-center">
                        <div class="text-2xl font-bold text-green-800">50%</div>
                        <div class="text-sm text-gray-600">Pengurangan limbah</div>
                    </div>
                    <div class="p-4 bg-amber-50 rounded-lg text-center">
                        <div class="text-2xl font-bold text-amber-400">50%</div>
                        <div class="text-sm text-gray-600">Mendapat Keuntungan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- OUR STORY -->
<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
        <div class="reveal" data-delay="80">
            <h2 class="text-3xl font-bold text-green-800">Cerita Kami</h2>
            <p class="mt-4 text-gray-600 leading-relaxed">Recycle Hub lahir dari kepedulian terhadap lingkungan dan keinginan kuat untuk menciptakan ekosistem daur ulang yang lebih mudah, modern, dan menguntungkan bagi semua. Dengan pendekatan teknologi, kami mengubah aktivitas baik menjadi nilai nyata.</p>
            <ul class="mt-6 space-y-3 text-gray-700">
                <li>• Jemput & dropoff yang fleksibel</li>
                <li>• Poin yang bisa ditukar</li>
            </ul>
        </div>

        <div class="relative reveal" data-delay="160">
            <div class="rounded-xl overflow-hidden shadow-lg">
                <img src="{{ asset('image/cewek.png') }}" class="w-full h-64 object-cover" alt="team" />
            </div>
            <div class="absolute -top-4 -left-4 bg-amber-400 text-green-900 font-semibold px-4 py-2 rounded-lg shadow">Komunitas Hijau</div>
        </div>
    </div>
</section>

<!-- VISI MISI + FEATURES -->
<section class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold text-green-800 reveal" data-delay="40">Visi & Misi</h2>
        <p class="mt-3 max-w-2xl mx-auto text-gray-600 reveal" data-delay="120">Menciptakan sistem daur ulang modern yang inklusif dan berdampak sosial, dengan pengalaman mudah bagi pengguna.</p>

        <div class="mt-12 grid md:grid-cols-3 gap-8">
            <div class="bg-white shadow p-8 rounded-xl border-t-4 border-green-700 hover:scale-105 transition transform reveal" data-delay="180">
                <h3 class="font-bold text-green-800 text-xl">1. Membangun ekosistem daur ulang modern yang bernilai ekonomi</h3>
                <p class="mt-3 text-gray-600">
Mengubah sampah layak pakai menjadi produk berkualitas dan fungsional yang dapat digunakan sehari-hari, sambil menghadirkan platform hybrid yang menggabungkan bank sampah digital dan toko online untuk mendorong ekonomi sirkular yang berkelanjutan.                </p>
            </div>

            <div class="bg-white shadow p-8 rounded-xl border-t-4 border-amber-400 hover:scale-105 transition transform reveal" data-delay="240">
                <h3 class="font-bold text-green-800 text-xl">
2. Memberdayakan pengguna melalui sistem bank sampah digital yang menguntungkan                
</h3>
                <p class="mt-3 text-gray-600">
Mempermudah masyarakat mengirimkan sampah yang masih layak proses dan memperoleh poin sebagai imbalan. Poin ini dapat ditukar menjadi voucher, diskon keanggotaan, e-money, atau pembelian produk—sehingga daur ulang tidak hanya ramah lingkungan, tetapi juga memberikan nilai finansial nyata.                </p>
            </div>

            <div class="bg-white shadow p-8 rounded-xl border-t-4 border-green-700 hover:scale-105 transition transform reveal" data-delay="300">
                <h3 class="font-bold text-green-800 text-xl">
3. Menciptakan pengalaman belanja dan daur ulang yang saling menguatkan                </h3>
                <p class="mt-3 text-gray-600">
Menyediakan produk daur ulang yang berkualitas, estetis, aman, dan sesuai kebutuhan harian, sekaligus memberikan penghargaan lebih besar bagi pengguna aktif melalui sistem level keanggotaan, potongan harga eksklusif, dan manfaat berkelanjutan berdasarkan kontribusi mereka dalam mengurangi sampah.                </p>
            </div>
        </div>
    </div>
</section>


<!-- ANGGOTA (TEAM) -->
<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-green-800 text-center reveal" data-delay="40">Anggota Tim</h2>
        <p class="mt-3 text-center text-gray-600 reveal" data-delay="80">Tim inti yang merancang dan menjalankan RRCO.</p>

        <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <!-- Member 1 -->
            <div class="bg-white rounded-xl shadow p-6 text-center reveal" data-delay="120">
                <div class="w-28 h-28 mx-auto rounded-full overflow-hidden shadow-lg mb-4 transform hover:scale-105 transition"><img src="{{ asset('image/aurel.JPG') }}" alt="Anggota 1" class="w-full h-full object-cover"></div>
                <h4 class="font-semibold text-green-800">Aurel Filza</h4>
                <div class="text-sm text-gray-600">Fullstack Developer (Frontend & Backend)</div>
            </div>

            <!-- Member 2 -->
            <div class="bg-white rounded-xl shadow p-6 text-center reveal" data-delay="140">
                <div class="w-28 h-28 mx-auto rounded-full overflow-hidden shadow-lg mb-4 transform hover:scale-105 transition"><img src="{{ asset('image/wilan.JPG') }}" alt="Anggota 2" class="w-full h-full object-cover"></div>
                <h4 class="font-semibold text-green-800">Wilanda Adrianti</h4>
                <div class="text-sm text-gray-600">UI Designer & UX Writer</div>
            </div>

            <!-- Member 3 -->
            <div class="bg-white rounded-xl shadow p-6 text-center reveal" data-delay="160">
                <div class="w-28 h-28 mx-auto rounded-full overflow-hidden shadow-lg mb-4 transform hover:scale-105 transition"><img src="{{ asset('image/rapi.JPG') }}" alt="Anggota 3" class="w-full h-full object-cover"></div>
                <h4 class="font-semibold text-green-800">Raffi Herdiansyah</h4>
                <div class="text-sm text-gray-600">UI Designer & UX Writer</div>
            </div>

            <!-- Member 4 -->
            <div class="bg-white rounded-xl shadow p-6 text-center reveal" data-delay="180">
                <div class="w-28 h-28 mx-auto rounded-full overflow-hidden shadow-lg mb-4 transform hover:scale-105 transition"><img src="{{ asset('image/najril.JPG') }}" alt="Anggota 4" class="w-full h-full object-cover"></div>
                <h4 class="font-semibold text-green-800">M. Nazriel</h4>
                <div class="text-sm text-gray-600">Database Planner & UX Designer</div>
            </div>

            <!-- Member 5 -->
            <div class="bg-white rounded-xl shadow p-6 text-center reveal" data-delay="200">
                <div class="w-28 h-28 mx-auto rounded-full overflow-hidden shadow-lg mb-4 transform hover:scale-105 transition"><img src="{{ asset('image/shafa.JPG') }}" alt="Anggota 5" class="w-full h-full object-cover"></div>
                <h4 class="font-semibold text-green-800">Shafa Ilmira</h4>
                <div class="text-sm text-gray-600">UX Designer</div>
            </div>

            <!-- Member 6 -->
            <div class="bg-white rounded-xl shadow p-6 text-center reveal" data-delay="220">
                <div class="w-28 h-28 mx-auto rounded-full overflow-hidden shadow-lg mb-4 transform hover:scale-105 transition"><img src="{{ asset('image/siti.JPG') }}" alt="Anggota 6" class="w-full h-full object-cover"></div>
                <h4 class="font-semibold text-green-800">Siti Buraedah</h4>
                <div class="text-sm text-gray-600">Tester</div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ (replaces timeline) -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-green-800 text-center reveal" data-delay="40">Pertanyaan Umum (FAQ)</h2>
        <p class="mt-4 text-center text-gray-600 reveal" data-delay="120">Aplikasi baru saja diluncurkan — berikut jawaban atas pertanyaan yang sering muncul.</p>

        <div class="mt-8 space-y-4">
            <div class="bg-gray-50 rounded-xl shadow p-4 reveal" data-delay="160">
                <button class="w-full text-left flex items-center justify-between gap-4" aria-expanded="false" onclick="toggleFaq(this)">
                    <span class="font-semibold text-green-800">Bagaimana cara saya menjadwalkan penjemputan?</span>
                    <span class="text-amber-400">+</span>
                </button>
                <div class="mt-3 text-gray-600 faq-panel">Masuk ke halaman formulir pengajuan sampah di halaman pengajuan sampah dan otomatis akan diminta untuk mengisi penjadwalan penjemputan sampah.</div>
            </div>

            <div class="bg-gray-50 rounded-xl shadow p-4 reveal" data-delay="200">
                <button class="w-full text-left flex items-center justify-between gap-4" aria-expanded="false" onclick="toggleFaq(this)">
                    <span class="font-semibold text-green-800">Apa yang bisa saya tukarkan dengan poin?</span>
                    <span class="text-amber-400">+</span>
                </button>
                <div class="mt-3 text-gray-600 faq-panel">Kamu bisa menukarkan poin kamu menjadi saldo E-Wallet atau uang tunai dan mendapat diskon untuk berbelanja di halaman toko online kami.</div>
            </div>

            <div class="bg-gray-50 rounded-xl shadow p-4 reveal" data-delay="240">
                <button class="w-full text-left flex items-center justify-between gap-4" aria-expanded="false" onclick="toggleFaq(this)">
                    <span class="font-semibold text-green-800">Bagaimana saya melaporkan masalah?</span>
                    <span class="text-amber-400">+</span>
                </button>
                <div class="mt-3 text-gray-600 faq-panel">Gunakan fitur Whatsapp yang loncat-locat atau kirim email ke support@recyclehub.example. Kami akan menindaklanjuti secepatnya.</div>
            </div>
        </div>

    </div>
</section>

<a href="https://wa.me/6282113149076" 
   target="_blank"
   class="fixed bottom-5 right-5 z-50 bg-green-600 hover:bg-green-600 text-white 
          w-14 h-14 flex items-center justify-center rounded-full shadow-xl 
          transition-all duration-200 animate-bounce">
    
    <!-- WhatsApp Icon (SVG) -->
    <svg xmlns="http://www.w3.org/2000/svg" 
         width="28" height="28" fill="currentColor"
         viewBox="0 0 24 24">
        <path d="M20.52 3.48A11.8 11.8 0 0 0 12 0C5.37 0 0 5.37 0 12c0 2.11.55 4.17 1.6 6L0 24l6.26-1.64A11.94 11.94 0 0 0 12 24c6.63 0 12-5.37 12-12 0-3.19-1.24-6.2-3.48-8.52zM12 21.82a9.77 9.77 0 0 1-4.98-1.38l-.36-.21-3.72.97 1-3.62-.24-.37A9.8 9.8 0 1 1 12 21.82zm5.33-7.47c-.29-.15-1.7-.84-1.96-.94-.26-.1-.45-.15-.64.15-.19.29-.74.94-.9 1.13-.17.19-.33.22-.62.07-.29-.15-1.23-.45-2.34-1.44-.86-.76-1.44-1.7-1.61-1.99-.17-.29-.02-.45.13-.6.13-.13.29-.33.43-.5.15-.17.19-.29.29-.48.1-.19.05-.36-.02-.51-.07-.15-.64-1.54-.88-2.11-.23-.55-.47-.47-.64-.47h-.55c-.19 0-.51.07-.77.36-.26.29-1.02 1-1.02 2.45 0 1.44 1.05 2.83 1.2 3.02.15.19 2.07 3.16 5.02 4.43.7.3 1.25.48 1.68.62.7.22 1.34.19 1.84.12.56-.08 1.7-.7 1.94-1.38.24-.67.24-1.25.17-1.38-.07-.12-.26-.19-.55-.33z"/>
    </svg>
</a>

<x-footer></x-footer>

<!-- Scripts: scroll reveal, counters, simple parallax -->
<script>
    (function(){
        // Reveal on scroll
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    const el = e.target;
                    const delay = parseInt(el.getAttribute('data-delay') || 0, 10);
                    setTimeout(() => el.classList.add('in-view'), delay);
                    obs.unobserve(el);
                }
            });
        }, { threshold: 0.12 });

        document.querySelectorAll('.reveal').forEach(el => obs.observe(el));

        // Animated counters
        document.querySelectorAll('.stat-num').forEach(el => {
            const target = parseInt(el.getAttribute('data-target') || el.textContent || 0, 10);
            let current = 0;
            const step = Math.max(1, Math.floor(target / 120));
            const id = setInterval(() => {
                current += step;
                if (current >= target) { el.textContent = target.toLocaleString(); clearInterval(id); }
                else el.textContent = current.toLocaleString();
            }, 12);
        });

        // Simple parallax on mouse move for hero image (small subtle effect)
        const hero = document.querySelector('section.bg-gradient-to-br');
        const img = hero ? hero.querySelector('img[alt="pattern"]') : null;
        if (hero && img) {
            hero.addEventListener('mousemove', (ev) => {
                const rect = hero.getBoundingClientRect();
                const x = (ev.clientX - rect.left) / rect.width - 0.5;
                const y = (ev.clientY - rect.top) / rect.height - 0.5;
                img.style.transform = `translate(${x * 12}px, ${y * 8}px) scale(1.02)`;
            });
            hero.addEventListener('mouseleave', () => img.style.transform = 'translate(0,0) scale(1)');
        }
    })();

    // FAQ toggle helper with smooth height animation
    window.toggleFaq = function(btn) {
        try {
            const panel = btn.nextElementSibling;
            const isOpen = btn.getAttribute('aria-expanded') === 'true';
            const signEl = btn.querySelector('.text-amber-400');
            if (!panel) return;

            if (isOpen) {
                // close
                btn.setAttribute('aria-expanded', 'false');
                panel.style.maxHeight = panel.scrollHeight + 'px';
                // allow frame then collapse to 0
                requestAnimationFrame(() => { panel.style.maxHeight = '0'; });
                if (signEl) signEl.textContent = '+';
            } else {
                // open
                btn.setAttribute('aria-expanded', 'true');
                panel.style.maxHeight = panel.scrollHeight + 'px';
                if (signEl) signEl.textContent = '−';
                // after transition, remove maxHeight to allow responsive content changes
                panel.addEventListener('transitionend', function handler() {
                  panel.style.maxHeight = 'none';
                  panel.removeEventListener('transitionend', handler);
                });
            }
        } catch (err) {
            console.error('toggleFaq error', err);
        }
    };
</script>

@endsection
