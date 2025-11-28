<x-app-layout>
    <x-navbar></x-navbar> 
    
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800 dark:text-gray-100 leading-snug tracking-wider">
            {{ __('My Profile') }}
        </h2>
    </x-slot>
<div class="py-10 primary min-h-screen flex items-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 w-full">
            <div class="w-full max-w-6xl mx-auto">
                
                <div class="p-8 grid grid-cols-1 mt-20 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-6">
                         <div class=" rounded-2xl p-6">
                            <div class="flex flex-col items-center text-center">
                                
                                <img 
                                    src="{{ Auth::user()->profile_photo_url ?? asset('image/default-avatar.png') }}" 
                                    alt="{{ Auth::user()->name }}" 
                                    class="h-28 w-28 rounded-full ring-4 ring-white shadow-lg object-cover mb-4"
                                >
                                
                                <h4 class="text-2xl font-extrabold text-amber-300 tracking-wide mb-1">{{ Auth::user()->name }}</h4>
                                <p class="text-base font-medium text-white opacity-85 mb-4">{{ Auth::user()->email }}</p>
                                
                            </div>
                        </div>

                        <div class="bg-white p-8 shadow-xl rounded-2xl">
                            <h3 class="text-2xl font-bold text-green-700 mb-6 border-b pb-3 border-gray-100">
                                Personal Details
                            </h3>
                            <div class="space-y-6">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                        </div>

                        <div class="bg-white p-8 shadow-xl rounded-2xl">
                            <h3 class="text-2xl font-bold text-green-700 mb-6 border-b pb-3 border-gray-100">
                                Change Password
                            </h3>
                            @include('profile.partials.update-password-form')
                        </div>

                        <div class="bg-white p-8 shadow-xl rounded-2xl border border-red-200">
                            <h3 class="text-2xl font-bold text-red-600 dark:text-red-500 mb-6 border-b pb-3 border-red-100 dark:border-red-800">
                                Danger Zone
                            </h3>
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>

                    <aside class="lg:col-span-1 space-y-8">
                        @if(Auth::user() && (Auth::user()->is_admin ?? false))
                            <div class="bg-amber-50 p-6 rounded-2xl shadow-md border border-amber-100">
                                <h3 class="text-lg font-semibold text-amber-700">Admin Panel</h3>
                                <p class="text-sm text-amber-600 mt-2">Anda terdaftar sebagai admin. Kelola pengguna, produk, dan pengaturan situs dari dashboard admin.</p>
                                <a href="{{ route('admin.dashboard') }}" class="mt-4 inline-block w-full text-center px-4 py-2 bg-amber-600 text-white rounded-lg font-semibold hover:bg-amber-700">Buka Dashboard Admin</a>
                            </div>
                        @endif

                        
{{-- Card Penjabaran Level dan Keuntungan --}}
<div class="bg-white p-6 shadow-xl rounded-2xl">
    <h3 class="text-xl font-bold text-gray-800 mb-2">💰 Total Poin Anda</h3>
    <div class="flex justify-between">
    <div class="text-4xl font-extrabold text-emerald-600 mb-4">{{ Auth::user()->points ?? 0 }}</div>
    <a href="{{ route('profile.points') }}" class="inline-flex items-center p-3 bg-gradient-to-r from-green-700 to-green-800 font-bold text-white rounded-full shadow hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-400">Cek Poin Saya</a>
    </div>
    <p class="text-sm text-gray-500 mb-2 border-b pb-4">Total poin yang Anda terima dari pengajuan sampah. Klik tombol cek poin saya dan tukarkan poinmu menjadi saldo E-Wallet atau uang.</p>
    
    {{-- Bagian Level Keanggotaan dan Keuntungan --}}
    <h3 class="text-xl font-bold text-gray-800 mb-4">Level Poin</h3>
    <p class="text-sm mb-6 text-gray-600">Selain ditukarkan menjadi saldo E-Wallet dan uang, kamu juga bisa mengklaim voucher belanja toko online kami sesuai dengan kategori level yang kamu punya.</p>

    <div class="space-y-4">
        
        {{-- Bronze --}}
        <div class="flex justify-between items-center p-3 rounded-lg bg-yellow-50">
            <div>
                <span class="font-bold text-sm text-yellow-800">Bronze (Pengguna Baru)</span>
                <p class="text-xs text-gray-600">Poin: 1,900 - 2,800</p>
            </div>
            <span class="font-extrabold text-lg text-green-700">10% DISKON</span>
        </div>

        {{-- Silver --}}
        <div class="flex justify-between items-center p-3 rounded-lg bg-gray-100">
            <div>
                <span class="font-bold text-sm text-gray-700">Silver (Pengguna Veteran)</span>
                <p class="text-xs text-gray-600">Poin: 2,800 - 12,900</p>
            </div>
            <span class="font-extrabold text-lg text-green-700">20% DISKON</span>
        </div>

        {{-- Gold --}}
        <div class="flex justify-between items-center p-3 rounded-lg bg-amber-50">
            <div>
                <span class="font-bold text-sm text-amber-800">Gold (Pengguna Premium)</span>
                <p class="text-xs text-gray-600">Poin: 12,900 - 39,900</p>
            </div>
            <span class="font-extrabold text-lg text-green-700">30% DISKON</span>
        </div>

        {{-- Diamond --}}
        <div class="flex justify-between items-center p-3 rounded-lg bg-blue-50">
            <div>
                <span class="font-bold text-sm text-blue-800">Diamond (Pengguna Setia)</span>
                <p class="text-xs text-gray-600">Poin: 39,900 - 89,900</p>
            </div>
            <span class="font-extrabold text-lg text-green-700">40% DISKON</span>
        </div>
        
        {{-- Obsidian --}}
        <div class="flex justify-between items-center p-3 rounded-lg bg-slate-100 border border-slate-300">
            <div>
                <span class="font-bold text-sm text-slate-900">Obsidian (Sayang Bumi)</span>
                <p class="text-xs text-gray-600">Poin: 89,900 - 100,000</p>
            </div>
            <span class="font-extrabold text-lg text-green-700">50% DISKON</span>
        </div>
        
    </div>
    
</div>

                        <div class="bg-white p-6 shadow-xl rounded-2xl">
                            <h3 class="text-xl font-bold text-gray-800 mb-5">Recent Activity</h3>
                            <p class="mb-4 text-sm opacity-50">Acivities akan hilang saat kamu log-out/keluar akun</p>
                            @php $activities = $activities ?? session('activities', []);
                                $actCount = count($activities);
                                $scrollClass = $actCount > 5 ? 'max-h-56 overflow-y-auto pr-2' : '';
                            @endphp

                            @if ($actCount === 0)
                                <div class="p-4 bg-gray-50 rounded-lg text-center">
                                    <p class="text-sm text-black">No recent activity recorded.</p>
                                </div>
                            @else
                                <ul class="space-y-4 {{ $scrollClass }}">
                                    @foreach ($activities as $act)
                                        <li class="flex items-start border-b border-gray-100 pb-3 last:border-b-0 last:pb-0">
                                            <div class="w-2 h-8 bg-green-500 rounded-full mr-3 mt-1 flex-shrink-0"></div>
                                            <div>
                                                <div class="text-base font-medium text-gray-800">{{ $act['action'] }}</div>
                                                <div class="text-xs text-gray-500">{{ $act['when'] }}</div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                        </div>
                    </aside>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>