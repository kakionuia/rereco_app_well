<x-guest-layout>
    <div class="relative min-h-screen bg-gradient-to-br from-green-700 to-green-900 flex items-center justify-center p-4 sm:p-6 lg:p-8 overflow-hidden">

        <div class="absolute inset-0 z-0 opacity-20">
            <div class="w-96 h-96 bg-green-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob absolute top-0 left-0"></div>
            <div class="w-96 h-96 bg-green-400 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000 absolute top-0 right-0"></div>
            <div class="w-96 h-96 bg-green-600 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000 absolute bottom-0 left-1/4"></div>
        </div>

        <div class="absolute inset-0 z-0">
            <div class="w-full h-1/2 absolute top-0 bg-white bg-opacity-10 rounded-b-3xl shadow-inner"></div>
        </div>

        <div class="w-full max-w-md mx-auto relative z-10 perspective-1000">
            <div class="bg-white bg-opacity-95 shadow-lg shadow-cyan-950 p-8 sm:p-10 rounded-3xl shadow-3xl border border-white border-opacity-30 transform transition-all duration-700 ease-in-out hover:scale-[1.02] hover:rotate-y-3 hover:shadow-4xl animate-fade-in-up">

                <div class="flex flex-col items-center mb-8">
                    <img class="h-20 w-auto mb-4 animate-bounce-subtle" src="{{ asset('image/logo.png') }}" alt="Logo">
                    <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight animate-slide-in-right">Create Account</h1>
                    <p class="text-sm text-gray-500 mt-1 animate-slide-in-left animation-delay-200">Sign up to start earning from recycling.</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('register') }}" id="register-form">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Name')" class="text-gray-700 font-medium"/>
                        <div class="relative mt-1">
                            <x-text-input id="name" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-300 ease-in-out text-gray-800 placeholder-gray-400" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Full name" />
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="phone" :value="__('Phone')" class="text-gray-700 font-medium"/>
                        <div class="relative mt-1">
                            <x-text-input id="phone" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-300 ease-in-out text-gray-800 placeholder-gray-400" type="text" name="phone" :value="old('phone')" required autocomplete="tel" placeholder="08xx-xxxx-xxxx" />
                        </div>
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="adress" :value="__('Address')" class="text-gray-700 font-medium"/>
                        <div class="relative mt-1">
                            <x-text-input id="adress" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-300 ease-in-out text-gray-800 placeholder-gray-400" type="text" name="adress" :value="old('adress')" required autocomplete="street-address" placeholder="Your address" />
                        </div>
                        <x-input-error :messages="$errors->get('adress')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <label class="flex items-center space-x-3">
                            <input id="is_gunungputri" name="is_gunungputri" type="checkbox" value="1" class="h-4 w-4 text-green-600 border-gray-300 rounded">
                            <div class="flex flex-col p-0">
                            <span class="text-sm text-gray-700">Merasa tinggal di GunungPutri? </span>
                            <span class="text-xs">*Belum mencakup semua wilayah Gunungputri, apabila wilayahmu tidak ada, tidak usah diisi</span>
                            </div>
                        </label>
                    </div>

                    <div class="mb-4 hidden" id="village-wrap">
                        <x-input-label for="village" :value="__('Wilayah')" class="text-gray-700 font-medium"/>
                        <div class="relative mt-1">
                            <select id="village" name="village" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-300 ease-in-out text-gray-800">
                                <option value="">-- Pilih Wilayah --</option>
                                @foreach(\App\Models\Village::orderBy('name')->pluck('name') as $village)
                                    <option value="{{ $village }}" {{ old('village') == $village ? 'selected' : '' }}>{{ $village }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-input-error :messages="$errors->get('village')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-medium"/>
                        <div class="relative mt-1">
                            <x-text-input id="email" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-300 ease-in-out text-gray-800 placeholder-gray-400" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="name@example.com" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-medium"/>
                        <div class="relative mt-1">
                            <input id="password" name="password" autocomplete="new-password" required
                                   class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-300 ease-in-out text-gray-800 placeholder-gray-400 peer"
                                   type="password" placeholder="••••••••" />

                            <button type="button" id="password-toggle" aria-label="Toggle password visibility" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-green-600 transition duration-150">
                                <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.943-9.543-7a9.987 9.987 0 012.74-4.14M6.5 6.5L17.5 17.5" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700 font-medium"/>
                        <div class="relative mt-1">
                            <input id="password_confirmation" name="password_confirmation" autocomplete="new-password" required
                                   class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-300 ease-in-out text-gray-800 placeholder-gray-400 peer"
                                   type="password" placeholder="••••••••" />
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-primary-button id="register-button" class="w-full flex justify-center items-center py-3 text-lg rounded-xl bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white shadow-lg transition duration-300 transform hover:scale-[1.02] active:scale-95 active:shadow-sm">
                            <span id="register-button-text" class="font-semibold">{{ __('Register') }}</span>
                        </x-primary-button>
                    </div>
                </form>

                <div class="flex items-center my-6 animate-fade-in animation-delay-800">
                    <div class="flex-grow border-t border-gray-200"></div>
                    <span class="flex-shrink mx-4 text-gray-500 text-sm">Or sign up with</span>
                    <div class="flex-grow border-t border-gray-200"></div>
                </div>

                <div class="flex justify-center items-center space-x-4 animate-fade-in animation-delay-900">
                    <button class="flex-1 flex items-center justify-center p-3 rounded-xl bg-white border border-gray-200 text-gray-700 shadow-sm hover:bg-gray-50 transition duration-150 transform hover:-translate-y-1 hover:shadow-md">
                        <img class="h-6 w-6 mr-2" src="{{ asset('image/Google.svg') }}" alt="Google">
                        <span class="hidden sm:inline">Google</span>
                    </button>
                    <button class="flex-1 flex items-center justify-center p-3 rounded-xl bg-white border border-gray-200 text-gray-700 shadow-sm hover:bg-gray-50 transition duration-150 transform hover:-translate-y-1 hover:shadow-md">
                        <img class="h-6 w-6 mr-2" src="{{ asset('image/Facebook.svg') }}" alt="Facebook">
                        <span class="hidden sm:inline">Facebook</span>
                    </button>
                </div>
            </div>

            <div class="text-center mt-6 animate-fade-in animation-delay-1000">
                <p class="text-sm text-gray-200 drop-shadow">
                    Sudah punya akun? <a href="{{ route('login') }}" class="text-green-100 font-bold hover:text-white transition duration-150 hover:underline">Masuk Sekarang</a>
                </p>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Password visibility toggle (toggles both password fields)
            const pwd = document.getElementById('password');
            const pwdConfirm = document.getElementById('password_confirmation');
            const toggle = document.getElementById('password-toggle');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');
            if (toggle && pwd) {
                toggle.addEventListener('click', function () {
                    const isHidden = pwd.type === 'password';
                    const newType = isHidden ? 'text' : 'password';
                    if (pwd) pwd.type = newType;
                    if (pwdConfirm) pwdConfirm.type = newType;
                    if (isHidden) {
                        if (eyeOpen) eyeOpen.classList.add('hidden');
                        if (eyeClosed) eyeClosed.classList.remove('hidden');
                    } else {
                        if (eyeOpen) eyeOpen.classList.remove('hidden');
                        if (eyeClosed) eyeClosed.classList.add('hidden');
                    }
                });
            }

            // Submit loading spinner
            const form = document.getElementById('register-form');
            const btn = document.getElementById('register-button');
            const btnText = document.getElementById('register-button-text');
            if (form && btn && btnText) {
                form.addEventListener('submit', function () {
                    btn.disabled = true;
                    btn.classList.add('opacity-70', 'cursor-not-allowed');
                    btn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Processing...';
                    btnText.style.display = 'none';
                });
            }

            // Toggle village select when user indicates GunungPutri
            const gpCheckbox = document.getElementById('is_gunungputri');
            const villageWrap = document.getElementById('village-wrap');
            const villageSelect = document.getElementById('village');
            function toggleVillage() {
                if (gpCheckbox && gpCheckbox.checked) {
                    villageWrap.classList.remove('hidden');
                    if (villageSelect) villageSelect.required = true;
                } else {
                    villageWrap.classList.add('hidden');
                    if (villageSelect) { villageSelect.required = false; villageSelect.value = ''; }
                }
            }
            if (gpCheckbox) {
                gpCheckbox.addEventListener('change', toggleVillage);
                toggleVillage();
            }
        });
    </script>
</x-guest-layout>
