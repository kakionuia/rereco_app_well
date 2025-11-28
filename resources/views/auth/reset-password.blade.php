<x-guest-layout>
    <div class="relative min-h-screen bg-gradient-to-br from-green-700 to-green-900 flex items-center justify-center p-4 sm:p-6 lg:p-8 overflow-hidden">

        <div class="absolute inset-0 z-0 opacity-20">
            <div class="w-96 h-96 bg-green-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob absolute top-0 left-0"></div>
            <div class="w-96 h-96 bg-green-400 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000 absolute top-0 right-0"></div>
            <div class="w-96 h-96 bg-green-600 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000 absolute bottom-0 left-1/4"></div>
        </div>

        <div class="w-full max-w-md mx-auto relative z-10">
            <div class="bg-white bg-opacity-95 shadow-lg p-8 sm:p-10 rounded-3xl border border-white border-opacity-30">

                <div class="flex flex-col items-center mb-6">
                    <img class="h-16 w-auto mb-2" src="{{ asset('image/logo.png') }}" alt="Logo">
                    <h2 class="text-2xl font-bold text-gray-800">Reset password</h2>
                    <p class="text-sm text-gray-500 mt-1">Set a new password for your account.</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') ?? old('token') }}">

                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Email')" class="text-gray-700" />
                        <input id="email" name="email" type="email" required autofocus
                               class="w-full p-3 mt-1 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150" placeholder="you@example.com" value="{{ old('email', $request->email ?? '') }}">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="password" :value="__('Password')" class="text-gray-700" />
                        <input id="password" name="password" type="password" required
                               class="w-full p-3 mt-1 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150" placeholder="New password">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700" />
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                               class="w-full p-3 mt-1 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150" placeholder="Confirm new password">
                    </div>

                    <div class="mb-3">
                        <!-- removed duplicate empty token input to avoid overriding the valid token -->
                    </div>

                    <div class="mt-6">
                        <x-primary-button class="w-full py-3 rounded-xl">Reset password</x-primary-button>
                    </div>
                </form>

                <div class="text-center mt-6">
                    <a href="{{ route('login') }}" class="text-sm text-green-600 hover:underline">Back to login</a>
                </div>

            </div>
        </div>

    </div>
{{-- Duplicate Breeze block removed: the top stylized reset-password view is kept. --}}
</x-guest-layout>
