<x-guest-layout>
{{--    <x-authentication-card>--}}

    <div class="container mx-auto py-10">

        <div class="flex items-center">

            <div class="w-7/12">
                <img src="{{ asset('asset/img/register.jpg') }}" alt="Register" class="w-3/4 mx-auto">
            </div>

            <div class="w-5/12">
                <h1 class="text-3xl font-bold mb-4">{{ __('Traveller profile') }}</h1>

                <x-validation-errors class="mb-4" />

                <form id="registrationForm" method="POST" action="{{ route('register') }}">
                    @csrf

                    <div>
                        <x-label for="name" value="{{ __('Full Name') }}" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <div class="invalid-feedback invalid-name"></div>
                    </div>

                    <div class="mt-4">
                        <x-label for="email" value="{{ __('Email Address') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <div class="invalid-feedback invalid-email"></div>
                    </div>

                    <div class="mt-4">
                        <x-label for="phone" value="{{ __('Phone Number') }}" />
                        <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required autofocus autocomplete="phone" />
                        <div class="invalid-feedback invalid-phone"></div>
                    </div>

                    <div class="mt-4">
                        <x-label for="password" value="{{ __('Password') }}" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                        <div class="invalid-feedback invalid-password"></div>
                    </div>

                    <div class="mt-4">
                        <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                        <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
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
                        <button class="mb-4 bg-primary w-full text-black py-4 px-10 text-xl font-medium rounded-md hover:bg-gray-700 hover:text-white transition ease-in-out duration-150">
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

{{--    </x-authentication-card>--}}


    @push('scripts')

        <script>
            document.getElementById('registrationForm').addEventListener('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(this);
                const jsonData = Object.fromEntries(formData.entries());

                axios({
                    method: 'POST',
                    url: 'api/signup',
                    data: jsonData,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    }
                })
                    .then(response => {
                        Swal.fire({
                            title: 'Success!',
                            text: response.data.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                        setTimeout(() => {
                            window.location.href = route('login');
                        }, 2000);
                    })
                    .catch(error => {
                        window.showJsonErrorMessage(error);
                    });


            });
        </script>
    @endpush
</x-guest-layout>
