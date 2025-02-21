<x-guest-layout>
    <div class="container mx-auto py-10">
        <div class="flex items-center">
            <div class="w-8/12">
                <img src="{{ asset('asset/img/register.jpg') }}" alt="Register" class="w-3/4 mx-auto">
            </div>
            <div class="w-4/12">
                <h1 class="text-3xl font-bold mb-4">{{ __('Sign In') }}</h1>
                <x-validation-errors class="mb-4" />

                @session('status')
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ $value }}
                </div>
                @endsession

                <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
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
</x-guest-layout>
