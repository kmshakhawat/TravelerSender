<nav x-data="{ open: false, menuOpen: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="px-4 py-4">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/">
                        <img class="max-w-52" src="{{ asset('asset/img/logo.svg') }}" alt="{{ config('app.name') }}">
                    </a>
                </div>
            </div>

            <!-- start::Black overlay -->
            <div :class="menuOpen ? 'block' : 'hidden'" @click="menuOpen = false"
                 class="fixed z-20 inset-0 bg-black opacity-50 transition-opacity"></div>
            <!-- end::Black overlay -->

            <div class="flex items-center">
                <button
                    @click="menuOpen = true"
                    class="flex items-center text-base font-medium bg-gray-100 rounded-full focus:outline-none transition">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <img class="size-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    @endif
                    <div class="px-2 flex items-center">
                        {{ Auth::user()->name }}
                        <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </button>
            </div>

            <aside
                :class="menuOpen ? 'translate-x-0 ease-out' : 'translate-x-full ease-in'"
                class="fixed z-30 inset-y-0 right-0 w-64 transition duration-300 bg-secondary overflow-y-auto translate-x-0"
            >
                <!-- Account Management -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                    {{ __('Manage Account') }}
                </div>

                <x-dropdown-link href="{{ route('dashboard') }}">
                    {{ __('Dashboard') }}
                </x-dropdown-link>

                <x-dropdown-link href="{{ route('profile') }}">
                    {{ __('Profile') }}
                </x-dropdown-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-dropdown-link href="{{ route('api-tokens.index') }}">
                        {{ __('API Tokens') }}
                    </x-dropdown-link>
                @endif

                <div class="border-t border-gray-200"></div>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-dropdown-link href="{{ route('logout') }}"
                                     @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </aside>

        </div>
    </div>
</nav>
