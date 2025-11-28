<header id="main-header" class="fixed inset-x-0 top-0 z-50 header-transition bg-white backdrop-blur-none transition-all duration-300 ease-in-out py-4">
    <nav aria-label="Global" class="flex items-center justify-between p-3 lg:px-8">
      <div class="flex lg:flex-1">
        <a href="/" class="-m-1.5 p-1.5">
          <div class="flex justify-center items-center">
          <img class="h-12 w-18" src="{{ asset('image/logo-2.png') }}" alt="">  
          <div class="flex flex-col justify-center items-center">
            <span class="mt-3 px-2 font-bold text-amber-400">Reuse Recycle.Co</span>
             <span class="text-sm text-amber-500"> Bank Sampah Digital</span>
          </div>
          </div>
        </a>
      </div>
      @if (Request::is('shop') || Request::is('shop/*') || Request::routeIs('shop.*'))
        <div class="hidden lg:hidden flex-1 justify-center px-3">
          <form method="GET" action="{{ route('shop.index') }}" class="w-full max-w-md">
            <div class="relative">
              <input name="q" value="{{ request('q') }}" placeholder="Cari produk..." class="w-full pl-3 pr-20 py-2 border border-gray-200 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-emerald-300" />
              <button type="submit" class="absolute right-1 top-1/2 -translate-y-1/2 px-3 py-1 bg-green-600 text-white rounded-full text-sm">Cari</button>
            </div>
          </form>
        </div>
      @endif
      <div class="flex lg:hidden">
        <button type="button" command="show-modal" commandfor="mobile-menu" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700" onclick="document.getElementById('mobile-menu').showModal()">
          <span class="sr-only">Open main menu</span>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
            <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </button>
      </div>
      <div class="hidden lg:flex lg:gap-x-12">
      <a href="/" class="-mx-3 block px-3 text-base/7 font-semibold text-amber-400 hover:text-amber-500 {{ request()->is('/') ? 'border-b-2 border-amber-400' : '' }}">Home</a>
      <a href="/recycle" class="-mx-3 block px-3  text-base/7 font-semibold text-amber-400 hover:text-amber-500 {{ request()->routeIs('recycle') || request()->is('recycle') ? 'border-b-2 border-amber-400' : '' }}">Pengajuan Sampah</a>
      <a href="/shop" class="-mx-3 block px-3 text-base/7 font-semibold text-amber-400 hover:text-amber-500 {{ request()->is('shop') || request()->routeIs('shop.*') ? 'border-b-2 border-amber-400' : '' }}">Belanja</a>
      <a href="/about" class="-mx-3 block px-3 text-base/7 font-semibold text-amber-400 hover:text-amber-500 {{ request()->routeIs('about') || request()->is('about') ? 'border-b-2 border-amber-400' : '' }}">About Us</a>
      </div>
    <div class="hidden lg:flex lg:flex-1 lg:justify-end lg:items-center">
    @if (Route::has('login'))
      @auth
        <x-dropdown align="right" width="48">
          <x-slot name="trigger">
            <button class="inline-flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-transparent transition">
              <img src="{{ Auth::user()->profile_photo_url ?? asset('image/default-avatar.png') }}" alt="avatar" class="w-8 h-8 rounded-full object-cover mr-2">
              <span class="mr-2 text-amber-400 font-bold">{{ Auth::user()->name }}</span>
              <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
          </x-slot>

          <x-slot name="content">
            <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
            <form method="POST" action="{{ route('logout') }}">@csrf
              <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link>
            </form>
          </x-slot>
        </x-dropdown>
      @else
        @if (Route::has('register'))
          <a href="{{ route('login') }}" class="ml-3 inline-flex items-center px-4 py-2 text-sm font-semibold bg-amber-400 hover:bg-amber-500 rounded-md">Login <span class="sr-only">Login</span></a>
          <a href="{{ route('register') }}" class="ml-3 inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-900 hover:bg-green-700 rounded-md">Register <span class="sr-only">Register</span></a>
        @endif
      @endauth
    @endif
    </div>
    </nav>
</header>


   <dialog id="mobile-menu" class="backdrop:bg-black/70 fixed inset-0 z-50 p-0 m-0 w-full h-full lg:hidden rounded-lg">
        <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white p-6 sm:max-w-sm sm:ring-1 sm:ring-gray-300">
            <div class="flex items-center justify-between">
                <a href="#" class="-m-1.5 p-1.5">
                    <span class="sr-only">Your Company</span>
                    <img class="h-12 w-18" src="{{ asset('image/logo-2.png') }}" alt="">        
                </a>
                <button type="button" onclick="document.getElementById('mobile-menu').close()" class="-m-2.5 rounded-md p-2.5 text-gray-700">
                    <span class="sr-only">Close menu</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
                        <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
            <div class="mt-6 flow-root">
                <div class="-my-6 divide-y divide-gray-200">
                    <div class="space-y-2 py-6">
                        <a href="/" class="-mx-3 block px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50 hover:text-green-600 {{ request()->routeIs('/') || request()->is('/') ? 'border-b-2 border-amber-400' : '' }}">Home</a>
                        <a href="/recycle" class="-mx-3 block px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50 hover:text-green-600 {{ request()->routeIs('recycle') || request()->is('recycle') ? 'border-b-2 border-amber-400' : '' }}">Pengajuan Sampah</a>
                        <a href="/shop" class="-mx-3 block px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50 hover:text-green-600 {{ request()->routeIs('shop') || request()->is('shop') ? 'border-b-2 border-amber-400' : '' }}">Belanja</a>
                        <a href="/about" class="-mx-3 block px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50 hover:text-green-600 {{ request()->routeIs('about') || request()->is('about') ? 'border-b-2 border-amber-400' : '' }}">About Us</a>
                    </div>
                    
                    <div class="py-6">
              @if (Route::has('login'))
                @auth
                  <a href="{{ route('profile.edit') }}" class="block w-full text-center py-2.5 bg-white text-black font-bold rounded-full shadow-sm hover:bg-gray-50 transition-colors mb-2">Profile</a>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-center py-2.5 bg-red-600 text-white font-bold rounded-full shadow-lg hover:bg-red-500 transition-colors">Log Out</button>
                  </form>
                @else
                  <a href="{{ route('login') }}" class="block w-full text-center py-2.5 bg-white text-black font-bold rounded-full shadow-sm hover:bg-gray-50 transition-colors mb-2">Log in</a>
                  @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="block w-full text-center py-2.5 bg-green-700 text-white font-bold rounded-full shadow-lg hover:bg-green-600 transition-colors">Register <span aria-hidden="true">&rarr;</span></a>
                  @endif
                @endauth
              @endif
                    </div>

                </div>
            </div>
        </div>
    </dialog>