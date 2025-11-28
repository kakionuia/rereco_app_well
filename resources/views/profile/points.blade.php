<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Poin Saya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 text-gray-800">
    <x-navbar></x-navbar>
    <section class="py-12 mt-10">
        <div class="max-w-3xl mx-auto px-6">
            <h1 class="text-3xl font-extrabold text-green-800">Poin Saya</h1>

            @if(session('success'))
                <div class="mt-4 p-3 bg-green-50 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mt-4 p-3 bg-red-50 text-red-800 rounded">{{ session('error') }}</div>
            @endif

            <div class="mt-6 bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Total Poin</p>
                        <div class="text-3xl font-bold text-amber-500">{{ number_format($points) }}</div>
                        <p class="text-xs text-gray-500 mt-1">1 poin = Rp 5</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-600">Estimasi Saldo</p>
                        <div class="text-lg font-semibold text-gray-900">Rp {{ number_format(($points * 5),0,',','.') }}</div>
                    </div>
                </div>

                <hr class="my-2 border-gray-300">

                    <div class="mt-2 text-sm text-gray-600">Nomor Handphone: <span class="font-medium text-gray-900">{{ $phone ?? auth()->user()->phone ?? '-' }}</span></div>

                {{-- Conversion form --}}
                <form action="{{ route('profile.points.convert') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-end">
                        <div class="sm:col-span-2">
                            <label class="text-sm text-gray-700">Jumlah poin yang ditukar</label>
                            <input type="number" name="points" min="1" max="{{ $points }}" value="{{ min(100, $points) }}" class="w-full mt-1 border border-gray-200 rounded-lg px-3 py-2 focus:outline-none" required />
                            <p class="text-xs text-gray-500 mt-1">Poin maksimal yang tersedia: {{ $points }}</p>
                        </div>

                        <div>
                            <label class="text-sm text-gray-700">Pilih E-Wallet</label>
                            <select name="provider" class="w-full mb-5 border border-gray-200 rounded-lg px-3 py-2" required>
                                <option value="dana">Dana</option>
                                <option value="gopay">GoPay</option>
                                <option value="ovo">OVO</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600">Total nilai (IDR): <span id="convertedAmount" class="font-semibold text-gray-900">Rp {{ number_format(($points * 5),0,',','.') }}</span></div>
                        <button type="submit" class="inline-flex items-center gap-2 bg-green-700 text-white font-semibold py-2 px-4 rounded-full shadow-sm hover:bg-emerald-700">Tukar Poin</button>
                    </div>
                </form>
            </div>

            <div class="mt-6 text-sm text-gray-600">Catatan: Penukaran poin akan mengurangi poin Anda segera. Pengiriman saldo e-wallet perlu divalidasi oleh tim kami—silakan siapkan bukti transfer atau konfirmasi bila diminta.</div>

                <div class="mt-6 bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800">Riwayat Permintaan Poin</h3>
                    <div class="mt-3 divide-y">
                        @forelse($requests as $req)
                            @php $d = $req->data ?? []; @endphp
                            <div class="py-3 flex justify-between items-start">
                                <div>
                                    <div class="text-sm font-medium">{{ ucfirst($d['provider'] ?? '-') }} — Rp {{ number_format($d['amount_idr'] ?? 0,0,',','.') }}</div>
                                    <div class="text-xs text-gray-500">{{ number_format($d['points'] ?? 0) }} poin • {{ $req->created_at->format('Y-m-d H:i') }}</div>
                                    <div class="text-xs text-gray-600 mt-1">Status: <strong>{{ ucfirst($d['status'] ?? 'pending') }}</strong></div>
                                    @if(($d['status'] ?? null) === 'completed')
                                        <div class="text-xs text-green-700 mt-1">Dikonfirmasi: {{ $d['completed_at'] ?? '—' }}</div>
                                    @endif
                                </div>
                                <div class="text-right text-xs text-gray-500">
                                    No. Telp: {{ $d['phone'] ?? auth()->user()->phone ?? '-' }}
                                </div>
                            </div>
                        @empty
                            <div class="py-4 text-gray-600">Belum ada riwayat penukaran poin.</div>
                        @endforelse
                    </div>
                </div>
        </div>
    </section>

    <x-footer></x-footer>

    <script>
        // Live calculation for converted amount
        (function(){
            const pointsInput = document.querySelector('input[name="points"]');
            const amountEl = document.getElementById('convertedAmount');
            const rate = 5; // IDR per point
            function update(){
                const p = parseInt(pointsInput.value) || 0;
                const amt = p * rate;
                amountEl.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(amt);
            }
            pointsInput.addEventListener('input', update);
            update();
        })();
    </script>
</body>
</html>
