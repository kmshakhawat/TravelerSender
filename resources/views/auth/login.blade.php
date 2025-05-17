<x-guest-layout>
    <div x-data="login" class="container mx-auto py-10">
        <div class="flex flex-col sm:flex-row items-center">
            <div class="w-full sm:w-1/2 lg:w-8/12 order-2 sm:order-1 mb-10">
                <img src="{{ asset('asset/img/register.jpg') }}" alt="Register" class="w-3/4 mx-auto">
            </div>
            <div class="w-full sm:w-1/2 lg:w-4/12 order-1 sm:order-2 mb-10">
                <h1 class="text-3xl font-bold mb-4">{{ __('Sign In') }}</h1>

                <form method="POST" id="login" @submit.prevent="userLogin">
                    @csrf
                    <div>
                        <x-label for="email" value="{{ __('Email') }}" />
                        <div class="relative">
                            <svg class="size-6 opacity-50 text-primary absolute left-3 top-1/2 transform -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                            <x-input id="email" class="block w-full ps-10" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <x-label for="password" value="{{ __('Password') }}" />
                        <div class="relative">
                            <svg class="size-6 opacity-50 text-primary absolute left-3 top-1/2 transform -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                            </svg>
                            <x-input id="password" class="block w-full ps-10" type="password" name="password" required autocomplete="current-password" />
                        </div>
                    </div>

                    <div class="block mt-4">
                        <label for="remember_me" class="flex items-center">
                            <x-checkbox id="remember_me" name="remember" />
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif

                        <x-button class="ms-4">
                            {{ __('Sign in') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('login', () => ({
                    userLogin: function () {
                        Swal.fire({
                            title: 'Login...',
                            allowOutsideClick: true,
                            icon: 'info',
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        axios({
                            method: 'POST',
                            url: route('login'),
                            data: new FormData(document.getElementById('login')),
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        })
                            .then(response => {
                                const intended = localStorage.getItem('intended_url');
                                localStorage.removeItem('intended_url');

                                // Auto redirect after short delay
                                Swal.fire({
                                    title: 'Login Successful',
                                    text: response.data.message,
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 1500, // Show success for 1.5 seconds
                                    willClose: () => {
                                        window.location.href = intended || '/dashboard'; // fallback to dashboard
                                    }
                                });
                            })
                            .catch(error => {
                                window.showJsonErrorMessage(error);
                            });
                    },
                }));
            });
        </script>
    @endpush
</x-guest-layout>
