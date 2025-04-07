<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
{{--            <x-authentication-card-logo />--}}
        </x-slot>

        <div class="mb-4 text-base text-gray-600 dark:text-gray-400">
            <p>{{ __('Please confirm access to your account by entering the OTP code sent to your email.') }}</p>
            <p class="text-sm text-danger">{{ __('Please check your spam mail if the email is not in your inbox.') }}</p>
        </div>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('otp.verify') }}">
            @csrf
            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ old('email', auth()->user()->email ) }}" disabled />
            </div>
            <div class="mt-4">
                <x-label for="otp" value="{{ __('Code') }}" />
                <x-input id="otp" class="block mt-1 w-full" type="text" inputmode="numeric" name="otp" autofocus x-ref="otp" autocomplete="one-time-code" />
            </div>

            <div class="flex flex-col sm:flex-row gap-3 justify-between items-center mt-4">

                <div class="reset_time text-sm font-medium"></div>
                <x-button class="whitespace-nowrap">
                    {{ __('Verify Now') }}
                </x-button>
            </div>
        </form>

        <div class="text-center sm:text-start">
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf

                <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </x-authentication-card>

    @push('scripts')
        <script>

            @if(auth()->user()->otp_expiry > now())
                let count =  Math.floor({{ now()->diffInSeconds(auth()->user()->otp_expiry) }});
            @else
                let count = 0;
            @endif

            let counter = setInterval(timer, 1000);
            function timer() {
                count--;
                let minutes = Math.floor(count / 60);
                let seconds = count % 60;

                if (count <= 0) {
                    clearInterval(counter);
                    document.querySelector('.reset_time').innerHTML = '<a href="{{ route('otp.resend') }}" class="text-indigo-600 hover:text-indigo-900">Resend OTP</a>';
                    return;
                }
                document.querySelector('.reset_time').innerHTML = 'Not received your OTP? Resend OTP <span class="text-red-500">' + minutes + ':' + (seconds < 10 ? '0' : '') + seconds + 's</span>';
            }
        </script>
    @endpush
</x-guest-layout>
