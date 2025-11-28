<x-guest-layout>
    <div class="relative min-h-screen bg-gradient-to-br from-green-700 to-green-900 flex flex-col items-center justify-center p-4 sm:p-6 lg:p-8 overflow-hidden">

        <div class="absolute inset-0 z-0 opacity-20">
            <div class="w-96 h-96 bg-green-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob absolute top-0 left-0"></div>
            <div class="w-96 h-96 bg-green-400 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000 absolute top-0 right-0"></div>
            <div class="w-96 h-96 bg-green-600 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000 absolute bottom-0 left-1/4"></div>
        </div>

        <div class="w-full max-w-md mx-auto relative z-10">
            <div class="bg-white bg-opacity-95 shadow-lg p-8 sm:p-10 rounded-3xl border border-white border-opacity-30">

                <div class="flex flex-col items-center mb-6">
                    <img class="h-16 w-auto mb-2" src="{{ asset('image/logo.png') }}" alt="Logo">
                    <h2 class="text-2xl font-bold text-gray-800">Verifikasi Email</h2>
                    <p class="text-sm text-gray-500 mt-1">Silakan verifikasi alamat email Anda dengan menekan tautan yang kami kirimkan. Jika belum menerima, Anda dapat mengirim ulang tautan verifikasi.</p>
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ __('Tautan verifikasi baru telah dikirim ke alamat email yang Anda daftarkan.') }}
                    </div>
                @endif

                <div class="mt-4 flex flex-col space-y-3">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-md font-semibold hover:bg-green-700 transition">Kirim ulang Email Verifikasi</button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 border border-gray-200 text-gray-700 rounded-md hover:bg-gray-50">Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
