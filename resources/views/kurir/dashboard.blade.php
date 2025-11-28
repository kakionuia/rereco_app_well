<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Tugas Kurir - Profesional</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif; }
        .task-card.active {
            @apply border-green-600 bg-green-50;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen p-8">
    <div class="container mx-auto p-0 sm:p-4 md:p-8">
        <header class="bg-white shadow-md p-4 md:p-6 mb-4 md:mb-6 rounded-lg p-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">Dashboard Kurir Sampah</h1>
                    <p class="text-lg text-gray-600">Wilayah {{ $kurir->adress }} | <span class="font-semibold text-green-700"><a href="{{ route('kurir.history') }}">{{ $kurir->name }}, {{ $kurir->email }}</a></span></p>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-4 md:mt-0">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg shadow transition">Logout</button>
                </form>
            </div>
        </header>
        <main class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-1 bg-white shadow-xl rounded-xl overflow-hidden h-fit">
                <div class="p-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-semibold text-gray-800">Tugas Harian ({{ $tasks->count() }})</h2>
                    </div>
                    <div class="relative mt-4" id="estimasi-slider">
                        <div class="overflow-x-auto slider-scroll -mx-4 px-4 pb-4">
                            <div class="flex gap-4 w-max">
                                @php
                                    $items = [
                                        ['emoji'=>'','title'=>'Brg Elektro','value'=>'Mulai 900 Poin','bg'=>'bg-green-700'],
                                        ['emoji'=>'','title'=>'Besi','value'=>'350 Poin/kg','bg'=>'bg-amber-500'],
                                        ['emoji'=>'','title'=>'Plastik','value'=>'500 Poin/kg','bg'=>'bg-green-700'],
                                        ['emoji'=>'','title'=>'Minyak Jelantah','value'=>'400 Poin/kg','bg'=>'bg-amber-500'],
                                        ['emoji'=>'','title'=>'Smph Organik','value'=>'Mulai 100 Poin','bg'=>'bg-green-700'],
                                        ['emoji'=>'','title'=>'Kertas','value'=>'200 Poin/kg','bg'=>'bg-amber-500'],
                                    ];
                                @endphp
                                @foreach($items as $it)
                                    <div class="min-w-[220px] snap-center rounded-2xl p-4 text-white {{ $it['bg'] }} shadow-lg flex flex-col justify-between">
                                        <div class="flex items-start justify-between">
                                            <div class="text-xs uppercase font-semibold opacity-90">Estimasi Poin</div>
                                        </div>
                                        <div class="mt-3">
                                            <div class="text-lg font-bold">{{ $it['title'] }}</div>
                                            <div class="text-xl font-extrabold">{{ $it['value'] }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="divide-y divide-gray-200 h-56 overflow-y-auto snap-y snap-mandatory scroll-smooth">
                    @forelse($tasks as $task)
                        <a href="{{ route('kurir.dashboard', ['task' => $task->id]) }}" class="block">
                        <div class="task-card snap-start {{ (isset($selectedTask) && $selectedTask && $selectedTask->id == $task->id) || (!$selectedTask && $loop->first) ? 'active' : '' }} p-4 cursor-pointer border-l-4 border-transparent hover:bg-gray-50 transition duration-150">
                            <div class="flex justify-between items-center">
                                <p class="text-sm font-semibold text-gray-900">Penjemputan #{{ $task->id }}</p>
                                <span class="px-2 py-0.5 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">Baru</span>
                            </div>
                            <p class="text-xs text-gray-600 truncate font-semibold">{{ $task->user->name ?? '-' }}</p>
                            <p class="text-xs text-gray-600">Email: {{ $task->user->email ?? '-' }}</p>
                            <p class="text-xs text-gray-600">Telepon: {{ $task->user->phone ?? '-' }}</p>
                            <p class="text-xs text-gray-600">Alamat: {{ $task->user->adress ?? '-' }}</p>
                            <p class="text-xs text-gray-600">Jenis: <span class="font-medium">{{ $task->jenis ?? '-' }}</span></p>
                            <p class="text-xs text-gray-600">Wilayah: {{ $task->user->village ?? '-' }}</p>
                            <p class="text-xs text-gray-500 mt-1">Perkiraan: {{ $task->estimated_weight ?? '-' }} Kg</p>
                            {{-- Estimasi poin: lihat slider Estimasi Poin di atas jika perlu --}}
                            <p class="text-xs text-gray-500 mt-1">Janji: <span class="font-medium">{{ $task->tanggal_pickup ? $task->tanggal_pickup->format('d M Y') : '-' }}</span>@if($task->waktu_pickup) , <span class="font-medium">{{ $task->waktu_pickup }}</span>@endif</p>
                        </div>
                        </a>
                    @empty
                        <div class="p-4 text-gray-500 text-center">Belum ada tugas hari ini.</div>
                    @endforelse
                </div>
            </div>
            <div class="lg:col-span-2 bg-white shadow-xl rounded-xl p-6">
                @if($tasks->count())
                    @php $task = $selectedTask ?? $tasks->first(); @endphp
                    <h2 class="text-2xl font-bold text-gray-900 border-b pb-3 mb-4">Detail Tugas #{{ $task->id }}</h2>
                    <div class="mb-6 p-4 border rounded-lg bg-gray-50">
                        <p class="text-sm text-gray-500">Informasi Pengguna</p>
                        <p class="text-xl font-semibold text-gray-800">{{ $task->user->name ?? '-' }}</p>
                        <p class="text-sm text-gray-600">Jenis Sampah: <span class="font-medium text-gray-800">{{ $task->jenis ?? '-' }}</span></p>
                        <p class="text-md text-gray-700">{{ $task->alamat_pickup }}</p>
                        <p class="text-sm text-gray-500 mt-2">Janji Temu: <span class="font-medium text-green-700">{{ $task->tanggal_pickup ? $task->tanggal_pickup->format('d M Y') : '-' }}</span>@if($task->waktu_pickup) <span class="text-green-700">pukul {{ $task->waktu_pickup }}</span>@endif</p>
                        <p class="text-sm text-gray-500 mt-2">Telepon: <span class="font-medium text-green-700">{{ $task->user->phone ?? '-' }}</span></p>
                    </div>
                    @if($task->status === 'completed')
                        <div class="p-4 bg-green-50 border border-green-200 rounded-lg text-green-800 font-semibold text-center">
                            Status: Selesai
                        </div>
                    @else
                    <form method="POST" action="{{ route('kurir.sampah.points', $task->id) }}" class="space-y-6" id="formKonfirmasi">
                        @csrf
                        <h3 class="text-xl font-bold text-green-700">Konfirmasi Penyerahan</h3>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Metode Insentif</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <label class="flex items-center p-4 border border-green-600 rounded-lg shadow-md bg-green-50 cursor-pointer">
                                    <input type="radio" name="insentif" value="poin" checked class="h-5 w-5 text-green-600 border-green-300 focus:ring-green-500" onchange="togglePoinInput()">
                                    <span class="ml-3 text-sm font-medium text-green-900">Berikan Poin</span>
                                </label>
                                <label class="flex items-center p-4 border border-gray-300 rounded-lg shadow-sm bg-white hover:bg-gray-50 cursor-pointer">
                                    <input type="radio" name="insentif" value="cash" class="h-5 w-5 text-green-600 border-gray-300 focus:ring-green-500" onchange="togglePoinInput()">
                                    <span class="ml-3 text-sm font-medium text-gray-900">Uang Tunai</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <label for="berat_aktual" class="block text-sm font-medium text-gray-700">Berat Aktual Barang (Kg)</label>
                            <input type="number" id="berat_aktual" name="berat_aktual" min="0" step="0.01" required placeholder="Masukkan berat aktual" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 transition duration-150">
                        </div>
                        <div id="poinInputWrap">
                            <label for="points" class="block text-sm font-medium text-gray-700">Jumlah Poin untuk Pengguna</label>
                            <input type="number" id="points" name="points" min="0" step="1" placeholder="Masukkan poin" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 transition duration-150">
                        </div>
                        <div>
                            <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                            <textarea id="catatan" name="catatan" rows="2" placeholder="Contoh: Sampah sudah dipilah rapi." class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg text-lg shadow-lg transition duration-150 ease-in-out transform hover:scale-[1.01] focus:outline-none focus:ring-4 focus:ring-green-500 focus:ring-opacity-50">
                            <span class="flex items-center justify-center">
                                 <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                 SELESAIKAN & CATAT TRANSAKSI INI
                            </span>
                        </button>
                        <div class="text-center text-xs text-gray-500 pt-2">
                            Data akan otomatis dikirim ke sistem pencatatan.
                        </div>
                    </form>
                    <script>
                    function togglePoinInput() {
                        var poinInput = document.getElementById('poinInputWrap');
                        var insentif = document.querySelector('input[name="insentif"]:checked').value;
                        if (insentif === 'poin') {
                            poinInput.style.display = 'block';
                            document.getElementById('points').setAttribute('required', 'required');
                        } else {
                            poinInput.style.display = 'none';
                            document.getElementById('points').removeAttribute('required');
                            document.getElementById('points').value = '';
                        }
                    }
                    document.addEventListener('DOMContentLoaded', function() {
                        togglePoinInput();
                    });
                    </script>
                    @endif
                @else
                    <h2 class="text-2xl font-bold text-gray-900 border-b pb-3 mb-4">Tidak ada tugas aktif</h2>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
