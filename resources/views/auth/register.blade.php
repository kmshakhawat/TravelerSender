<x-guest-layout>
{{--    <x-authentication-card>--}}

    <div x-data="register" class="container mx-auto py-10">

        <div class="flex items-center">

            <div class="w-7/12">
                <img src="{{ asset('asset/img/register.jpg') }}" alt="Register" class="w-3/4 mx-auto">
            </div>

            <div class="w-5/12">
                <h1 class="text-3xl font-bold mb-4">{{ __('Traveller profile') }}</h1>

                <form id="registrationForm" method="POST" @submit.prevent="userRegister">
                    @csrf

                    <div>
                        <x-label for="name" value="{{ __('Full Name') }}" />
                        <div class="relative">
                            <svg class="size-6 opacity-50 text-primary absolute left-3 top-1/2 transform -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            <x-input id="name" class="block w-full ps-10" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        </div>
                        <div class="invalid-feedback invalid-name"></div>
                    </div>

                    <div class="mt-4">
                        <x-label for="email" value="{{ __('Email Address') }}" />
                        <div class="relative">
                            <svg class="size-6 opacity-50 text-primary absolute left-3 top-1/2 transform -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                            <x-input id="email" class="block w-full ps-10" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        </div>
                        <div class="invalid-feedback invalid-email"></div>
                    </div>

                    <div class="mt-4">
                        <x-label for="phone" value="{{ __('Phone Number') }}" />
                        <div class="relative">
                            <svg class="size-6 opacity-50 text-primary absolute left-3 top-1/2 transform -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                            </svg>
                            <x-input id="phone" class="block w-full ps-10 phone" type="text" name="phone" :value="old('phone')" required autofocus autocomplete="phone" />
                        </div>

                        <div class="invalid-feedback invalid-phone"></div>
                    </div>

                    <div class="mt-4">
                        <x-label for="password" value="{{ __('Password') }}" />
                        <div class="relative">
                            <svg class="size-6 opacity-50 text-primary absolute left-3 top-1/2 transform -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                            </svg>
                            <x-input id="password" class="block w-full ps-10" type="password" name="password" required autocomplete="new-password" />
                        </div>
                        <div class="invalid-feedback invalid-password"></div>
                    </div>

                    <div class="mt-4">
                        <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                        <div class="relative">
                            <svg class="size-6 opacity-50 text-primary absolute left-3 top-1/2 transform -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                            </svg>
                            <x-input id="password_confirmation" class="block w-full ps-10" type="password" name="password_confirmation" required autocomplete="new-password" />
                        </div>
                        <div class="invalid-feedback invalid-password_confirmation"></div>
                    </div>

                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="mt-4">
                            <x-label for="terms">
                                <div class="flex items-center">
                                    <x-checkbox name="terms" id="terms" required />

                                    <div class="ms-2">
                                        {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                        ]) !!}
                                    </div>
                                </div>
                            </x-label>
                        </div>
                    @endif

                    <div class="flex flex-col items-center justify-center mt-4">
                        <button class="mb-4 btn-full">
                            {{ __('Register') }}
                        </button>
                        <a class="underline text-md text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>
                    </div>
                </form>

            </div>

        </div>
    </div>


    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('register', () => ({
                    userRegister: function () {
                        Swal.fire({
                            title: 'Creating...',
                            allowOutsideClick: true,
                            icon: 'info',
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        axios({
                            method: 'POST',
                            url: route('register'),
                            data: new FormData(document.getElementById('registrationForm')),
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        })
                            .then(response => {
                                Swal.fire({
                                    title: 'Success!',
                                    text: response.data.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                                window.location.href = route('login');
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
