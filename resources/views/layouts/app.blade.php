<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- favicon -->
        <link rel="icon" href="{{ asset('asset/img/favicon.png') }}" type="image/x-icon">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@24.7.0/build/css/intlTelInput.css">

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        @include('layouts.inc.header')
        <x-banner />

        <div class="min-h-screen bg-gray-100">
{{--            @livewire('navigation-menu')--}}

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="container py-6">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        @include('layouts.inc.footer')

        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@24.7.0/build/js/intlTelInput.min.js"></script>
        <script>
            const input = document.querySelector("#phone");
            if(input) {
                window.intlTelInput(input, {
                    hiddenInput: function (telInputName) {
                        return {
                            phone: "phone"
                        };
                    },
                    initialCountry: "auto",
                    geoIpLookup: function (success, failure) {
                        $.get("https://ipinfo.io", function () {
                        }, "jsonp").always(function (resp) {
                            let countryCode = (resp && resp.country) ? resp.country : "";
                            success(countryCode);
                        });
                    },
                    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@24.7.0/build/js/utils.js",
                });
            }
        </script>
        @stack('modals')
        @stack('scripts')
        @routes
        @include('sweetalert::alert')
        @livewireScripts
    </body>
</html>
