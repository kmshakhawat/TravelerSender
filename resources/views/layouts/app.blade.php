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

{{--        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>--}}
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@24.7.0/build/css/intlTelInput.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">

        <!-- Styles -->
        @livewireStyles
    </head>
    <body x-data="verification" class="font-sans antialiased">
        @include('layouts.inc.header')
        <x-banner />

        <div x-data class="bg-gray-100">
{{--            @livewire('navigation-menu')--}}

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="container py-6">
                        {{ $header }}
                    </div>
                </header>
            @endif
            @if(session('success'))
                <div class="container mt-5">
                    <div class="w-full flex items-center justify-between rounded bg-green-100 px-6 py-2 my-8 border border-green-300">
                        <div class="flex items-center space-x-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <div class="flex flex-col justify-center">
                                <span class="text-green-600 font-bold">Successful!</span>
                                <span class="text-sm text-green-600">{{session('success')}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if(session('error'))
                <div class="container py-5">
                    <div class="w-full flex items-center justify-between rounded bg-red-100 px-6 py-2 border border-red-300">
                        <div class="flex items-center space-x-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            <div class="flex flex-col justify-center">
                                <span class="text-red-600 font-bold">Error</span>
                                <span class="text-sm text-red-600">{{ session('error') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (!Auth::user()->verified)
                <div class="container py-5">
                    <div class="flex justify-between items-center bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg" role="alert">
                        <div>
                            <h5 class="heading-5">{{ __('Account Not Verified') }}</h5>
                            {{ __('Please update your profile and complete the ID verification process to continue. You can update your details in your Profile and Account Verification Menu.') }}
                        </div>
                        <a class="btn-primary" href="{{ route('profile') }}">Update Now</a>
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}

                <div x-show="$store.app.showModal" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="fixed z-10 inset-0 overflow-y-auto" x-cloak>
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:flex sm:p-0">
                        <!-- Modal panel -->
                        <div class="w-full inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-5xl sm:w-auto" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <button class="absolute right-1 text-danger top-1" @click.prevent="$store.app.showModal = false">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </button>
                                <!-- Modal content -->
                                <div x-ref="modalContent"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
        @include('layouts.inc.footer')

        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@24.7.0/build/js/intlTelInput.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.store('app', {
                    showModal: false,
                })
            });

            function countryStateCityDropdown(countrySelector, stateSelector, citySelector, selectedStateId = null, selectedCityId = null) {
                async function loadStates(country_id, stateSelect) {
                    if (country_id) {
                        stateSelect.prop('disabled', false);
                        try {
                            const response = await axios.get(`/get-states/${country_id}`);
                            stateSelect.empty();
                            stateSelect.append('<option value="">Select State</option>');

                            response.data.forEach(function (state) {
                                let selected = (selectedStateId && state.id === selectedStateId) ? 'selected' : '';
                                stateSelect.append(`<option value="${state.id}" ${selected}>${state.name}</option>`);
                            });

                            stateSelect.trigger('change'); // This will trigger loading cities if state is preselected
                        } catch (error) {
                            alert('Unable to load states. Please try again.');
                        }
                    } else {
                        stateSelect.empty().append('<option value="">Select State</option>').prop('disabled', true);
                    }
                }

                async function loadCities(state_id, citySelect) {
                    if (state_id) {
                        citySelect.prop('disabled', false);
                        try {
                            const response = await axios.get(`/get-cities/${state_id}`);
                            citySelect.empty();
                            citySelect.append('<option value="">Select City</option>');

                            response.data.forEach(function (city) {
                                let selected = (selectedCityId && city.id === selectedCityId) ? 'selected' : '';
                                citySelect.append(`<option value="${city.id}" ${selected}>${city.name}</option>`);
                            });
                        } catch (error) {
                            alert('Unable to load cities. Please try again.');
                        }
                    } else {
                        citySelect.empty().append('<option value="">Select City</option>').prop('disabled', true);
                    }
                }

                $(document).ready(function () {
                    $(countrySelector).each(function () {
                        let countrySelect = $(this);
                        let stateSelect = $(stateSelector);
                        let citySelect = $(citySelector);

                        let selectedCountryId = countrySelect.val();
                        let selectedStateId = stateSelect.val();
                        let selectedCityId = citySelect.val();

                        countrySelect.on('change', function () {
                            let country_id = $(this).val();
                            loadStates(country_id, stateSelect);
                            citySelect.empty().append('<option value="">Select City</option>').prop('disabled', true);
                        });

                        stateSelect.on('change', function () {
                            let state_id = $(this).val();
                            loadCities(state_id, citySelect);
                        });

                        // Initial load
                        if (selectedCountryId) {
                            loadStates(selectedCountryId, stateSelect, selectedStateId);
                        }

                        if (selectedStateId) {
                            loadCities(selectedStateId, citySelect, selectedCityId);
                        }
                    });
                });
            }

            document.querySelectorAll(".phone").forEach((input, index) => {
                const hiddenInput = document.createElement("input");
                hiddenInput.type = "hidden";
                hiddenInput.name = input.name || `phone_${index}`;
                input.parentNode.insertBefore(hiddenInput, input.nextSibling);

                const iti = window.intlTelInput(input, {
                    initialCountry: "auto",
                    geoIpLookup: function (success, failure) {
                        $.get("https://ipinfo.io", function () {}, "jsonp").always(function (resp) {
                            let countryCode = (resp && resp.country) ? resp.country : "";
                            success(countryCode);
                        });
                    },
                    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@24.7.0/build/js/utils.js",
                });

                // Function to update the hidden input field
                function updateHiddenInput() {
                    hiddenInput.value = iti.getNumber();
                }

                // Update hidden input on country change or blur
                input.addEventListener("countrychange", updateHiddenInput);
                input.addEventListener("blur", updateHiddenInput);

                // Ensure the value is set before form submission
                input.form?.addEventListener("submit", updateHiddenInput);
            });

        </script>
        @stack('modals')
        @stack('scripts')
        @routes
        @include('sweetalert::alert')
        @livewireScripts
    </body>
</html>
