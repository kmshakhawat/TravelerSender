<nav x-data="{menuOpen: false}" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="px-4 py-4">
        <div class="flex justify-between h-16 items-center">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/">
                        <img class="max-w-40 sm:max-w-52" src="{{ asset('asset/img/logo.svg') }}" alt="{{ config('app.name') }}">
                    </a>
                </div>
            </div>


            <!-- Menu -->

            <div class="flex gap-10">
                <div x-data="{ open: false }" class="z-20 flex-1">
                    <div :class="{ 'flex' : open, 'hidden' : open === false }" class="
                    fixed flex-col items-center justify-center z-40 bg-gray-200 text-white top-0 left-0 w-full h-screen leading-loose tracking-wider gap-8 hidden
                    lg:relative lg:w-auto lg:h-auto lg:flex lg:flex-row lg:justify-start lg:text-black lg:bg-transparent">
                        <a class="font-medium text-lg text-black hover:text-primary" href="/">Home</a>
                        <a class="font-medium text-lg text-black hover:text-primary" href="{{ route('about') }}">About</a>
                        <a class="font-medium text-lg text-black hover:text-primary" href="{{ route('trip.create') }}">List a Trip</a>
{{--                        <a class="font-medium text-lg text-black hover:text-primary" href="{{ route('trip.search') }}">Trip Search</a>--}}
                        <a class="font-medium text-lg text-black hover:text-primary" href="{{ route('contact') }}">Contact</a>

                        <div class="sm:hidden flex items-center gap-6 text-lg font-medium">
                            <a class="btn-secondary" href="{{ route('register') }}">Registration</a>
                            <a class="btn-primary" href="{{ route('login') }}">Sign in</a>
                        </div>

                        <button @click="open = false" type="button" :class="{ 'block' : open, 'hidden' : !open }" class="lg:hidden absolute top-0 right-0 leading-none text-black p-8 text-xl z-50 hidden">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="parentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>

                    </div>
                    <button @click="open = true" type="button" :class="{ 'hidden' : open, 'block' : !open }" class="block lg:hidden text-4xl font-thin">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- / Menu -->

            <!-- start::Black overlay -->
            <div :class="menuOpen ? '!block' : 'hidden'" @click="menuOpen = false"
                 class="fixed z-30 inset-0 bg-black opacity-40 transition-opacity hidden"></div>
            <!-- end::Black overlay -->


                @auth
                <div class="flex items-center">
                    <button
                        @click="menuOpen = true"
                        class="flex items-center text-base font-medium bg-gray-100 rounded-full focus:outline-none transition">
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <img class="size-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url ?: 'https://ui-avatars.com/api/?name='.urlencode($name).'&color=7F9CF5&background=EBF4FF' }}" alt="{{ Auth::user()->name }}" />
                        @endif
                        <div class="px-2 flex items-center">
                            <div class="hidden sm:block">{{ Auth::user()->name }}</div>
                            <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>
                    </button>
                    <aside
                        x-data="verification"
                        :class="menuOpen ? 'translate-x-0 ease-out !block' : 'translate-x-full ease-in'"
                        class="fixed z-30 inset-y-0 right-0 w-72 transition-opacity bg-white overflow-y-auto translate-x-0 duration-500 hidden"
                    >
                        <div :class="menuOpen ? '!block' : 'hidden'" @click="menuOpen = false"
                             class="fixed z-20 transition-opacity cursor-pointer right-2 top-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </div>

                        <div class="flex flex-col justify-between h-full">
                            <div class="mt-16">
                                <div class="border-t border-gray-200"></div>

                                <a class="nav-link" href="{{ route('profile') }}">
                                    {{ __('Profile') }}
                                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                        <img class="size-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url ?: 'https://ui-avatars.com/api/?name='.urlencode($name).'&color=7F9CF5&background=EBF4FF' }}" alt="{{ Auth::user()->name }}" />
                                    @endif
                                </a>

                                <div class="border-t border-gray-200"></div>

                                <a class="nav-link" href="{{ route('dashboard') }}">
                                    {{ __('Dashboard') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                                    </svg>
                                </a>
                                @if(Auth::user()->hasRole('admin'))
                                <a class="nav-link" href="{{ route('user.index') }}">
                                    {{ __('Users') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                    </svg>
                                </a>
                                @endif
                                <a class="nav-link"
                                   @if(Auth::user()->verified)
                                       href="{{ route('trip.index') }}"
                                   @else
                                       @click.prevent="verifiedAlert"
                                    @endif
                                >
                                    {{ __('Trips') }}

                                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 27 27" version="1.1">
                                        <path d="" stroke="none" fill="#989494" fill-rule="evenodd"/>
                                        <path d="M 19.992 1.509 C 18.383 3.449, 19.596 7.725, 22.223 9.374 C 24.559 10.841, 27.078 7.569, 26.745 3.500 C 26.549 1.096, 25.986 0.440, 23.914 0.199 C 22.442 0.028, 20.753 0.592, 19.992 1.509 M 22 3.941 C 22 5.009, 22.403 6.131, 22.895 6.435 C 23.970 7.099, 25.243 4.202, 24.444 2.910 C 23.459 1.316, 22 1.931, 22 3.941 M 15.250 9.250 C 15.479 9.938, 16.492 10.500, 17.500 10.500 C 18.508 10.500, 19.521 9.938, 19.750 9.250 C 20.014 8.458, 19.189 8, 17.500 8 C 15.811 8, 14.986 8.458, 15.250 9.250 M 11.667 9.667 C 10.680 10.653, 10.857 15, 11.883 15 C 12.665 15, 13.949 11.793, 13.986 9.750 C 14.003 8.820, 12.565 8.769, 11.667 9.667 M 1.200 15.200 C -1.339 17.739, 1.283 27, 4.540 27 C 6.202 27, 9.990 21.379, 9.996 18.905 C 10.005 15.172, 3.829 12.571, 1.200 15.200 M 14 16 C 14 16.550, 15.350 17, 17 17 C 18.650 17, 20 16.550, 20 16 C 20 15.450, 18.650 15, 17 15 C 15.350 15, 14 15.450, 14 16 M 22 16.042 C 22 17.952, 25.729 21.247, 26.492 20.012 C 26.879 19.386, 26.407 18.002, 25.443 16.937 C 23.520 14.812, 22 14.417, 22 16.042 M 3.044 17.448 C 2.236 18.421, 2.270 19.498, 3.170 21.475 C 4.313 23.983, 4.492 24.048, 5.700 22.396 C 6.415 21.418, 7 19.852, 7 18.916 C 7 16.694, 4.453 15.749, 3.044 17.448 M 23.655 23.829 C 20.772 27.014, 22.387 28.470, 25.429 25.429 C 27.137 23.720, 27.501 22, 26.155 22 C 25.690 22, 24.565 22.823, 23.655 23.829 M 8 26 C 8 26.550, 9.125 27, 10.500 27 C 11.875 27, 13 26.550, 13 26 C 13 25.450, 11.875 25, 10.500 25 C 9.125 25, 8 25.450, 8 26 M 14 26 C 14 26.550, 15.575 27, 17.500 27 C 19.425 27, 21 26.550, 21 26 C 21 25.450, 19.425 25, 17.500 25 C 15.575 25, 14 25.450, 14 26" stroke="none" fill="#949494" fill-rule="evenodd"/>
                                    </svg>
                                </a>
                                <a class="nav-link"
                                   @if(Auth::user()->verified)
                                       href="{{ route('booking.index') }}"
                                   @else
                                       @click.prevent="verifiedAlert"
                                   @endif
                                >
                                    {{ __('Booking') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                    </svg>
                                </a>
                                <a class="nav-link"
                                   @if(Auth::user()->verified)
                                       href="{{ route('order.index') }}"
                                   @else
                                       @click.prevent="verifiedAlert"
                                   @endif
                                >
                                    {{ __('Order') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                    </svg>
                                </a>
                                <a class="nav-link" href="{{ route('withdraw') }}">
                                    {{ __('Withdraw') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                                    </svg>
                                </a>
                                <a class="nav-link" href="{{ route('message') }}">
                                    <div>{{ __('Messages') }} {{ unReadMessage() }}</div>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                                    </svg>
                                </a>
{{--                                <a class="nav-link" href="{{ route('dashboard') }}">--}}
{{--                                    {{ __('Rating') }}--}}
{{--                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">--}}
{{--                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />--}}
{{--                                    </svg>--}}
{{--                                </a>--}}
                                <div class="border-t border-gray-200"></div>

                                <a class="nav-link" href="{{ route('profile.settings') }}">
                                    {{ __('Setting') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </a>
                            </div>
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <div class="border-t border-gray-200"></div>
                                <a class="nav-link !text-primary" href="{{ route('logout') }}"
                                   @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                    </svg>
                                </a>
                            </form>

                        </div>

                    </aside>
                </div>
                @else
                    <div class="hidden sm:flex items-center gap-6 text-lg font-medium">
                        <a class="btn-secondary" href="{{ route('register') }}">Registration</a>
                        <a class="btn-primary" href="{{ route('login') }}">Sign in</a>
                    </div>
                @endauth


        </div>
    </div>
</nav>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('verification', () => ({
                // subscribeAlert popup
                verifiedAlert: function () {
                    Swal.fire({
                        title: 'You Account Not Verified',
                        text: 'Please update your profile and complete the ID verification process to continue.',
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonText: 'Update Now',
                        cancelButtonText: 'Cancel',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#6E6E6E',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('verification') }}";
                        }
                    });
                },
                loginAlert: function () {
                    // Store intended route in localStorage
                    localStorage.setItem('intended_url', window.location.href);

                    Swal.fire({
                        title: 'Login Required',
                        icon: 'error',
                        html: `
                            <p>To proceed, please log in to your account or register for a new one.</p>
                            <div style="display: flex; justify-content: center; gap: 10px; margin-top: 15px;">
                                <button id="loginBtn" class="swal2-confirm swal2-styled" style="background-color: #3085d6;">Login</button>
                                <button id="registerBtn" class="swal2-confirm swal2-styled" style="background-color: #28a745;">Register</button>
                                <button id="cancelBtn" class="swal2-cancel swal2-styled" style="background-color: #6E6E6E;">Cancel</button>
                            </div>
                        `,
                        showConfirmButton: false,
                        didOpen: () => {
                            const loginRoute = "{{ route('login') }}";
                            const registerRoute = "{{ route('register') }}";

                            document.getElementById('loginBtn').addEventListener('click', () => {
                                window.location.href = loginRoute;
                            });

                            document.getElementById('registerBtn').addEventListener('click', () => {
                                window.location.href = registerRoute;
                            });

                            document.getElementById('cancelBtn').addEventListener('click', () => {
                                Swal.close();
                            });
                        }
                    });
                },
            }));
        });
    </script>
@endpush
