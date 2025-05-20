<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div x-data="profile" class="py-12">
        <div class="container">

            <div class="flex gap-8">
                <div class="w-1/4">
                    <x-profile-sidebar />
                </div>
                <div class="w-3/4">
                    <div class="bg-white border border-gray-50 rounded shadow p-4">
                        <h3 class="heading-5 mb-4 heading-title">{{ __('Profile') }}</h3>
                        <form id="profile" name="profile" @submit.prevent="submitProfile">
                            @csrf
                            <div>
                                <x-profile-photo :url="$user->profile_photo_url" :name="$user->name"/>
                            </div>
                            <div class="mt-4">
                                <x-label for="name" value="{{ __('Full Name') }}" />
                                <x-input id="name" class="block w-full" type="text" name="name" :value="$user->name" required autofocus autocomplete="name" />
                                <div class="invalid-feedback invalid-name"></div>
                            </div>
                            <div class="flex gap-4">
                                <div class="w-full sm:w-1/2 mt-4">
                                    <x-label for="email" value="{{ __('Email Address') }}" />
                                    <x-input disabled id="email" class="block w-full" type="email" name="email" :value="$user->email ?? '' " required autocomplete="username" />
                                    <div class="invalid-feedback invalid-email"></div>
                                </div>
                                <div class="w-full sm:w-1/2 mt-4">
                                    <x-label for="phone" value="{{ __('Phone Number') }}" />
                                    <x-input id="phone" class="block w-full phone" type="text" name="phone" :value="$user->phone ?? '' " required autocomplete="phone" />
                                    <div class="invalid-feedback invalid-phone"></div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <x-label for="address_1" value="{{ __('Address Line 1') }}" />
                                <x-input id="address_1" class="block w-full" type="text" name="address_1" :value="$user->profile->address_1 ?? '' " autocomplete="address_1" />
                                <div class="invalid-feedback invalid-address_1"></div>
                            </div>
                            <div class="mt-4">
                                <x-label for="address_2" value="{{ __('Address Line 2') }}" />
                                <x-input id="address_2" class="block w-full" type="text" name="address_2" :value="$user->profile->address_2 ?? '' " autocomplete="address_2" />
                                <div class="invalid-feedback invalid-address_2"></div>
                            </div>
                            <div class="flex gap-4">
                                <div class="w-full sm:w-1/2 mt-4">
                                    <x-label for="country_id" value="{{ __('Country') }}" />
                                    <x-input-dropdown id="country_id" class="country_id" name="country_id" :options="$countries" :selected="[$user->profile->country_id ?? '']"/>
                                    <div class="invalid-feedback invalid-country_id"></div>
                                </div>
                                <div class="w-full sm:w-1/2 mt-4">
                                    <x-label for="state_id" value="{{ __('State') }}" />
                                    <x-input-dropdown id="state_id" class="state_id" name="state_id" :options="[]" :selected="[$user->profile->state_id ?? '']" />
                                    <div class="invalid-feedback invalid-state"></div>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="w-full sm:w-1/2 mt-4">
                                    <x-label for="city_id" value="{{ __('City') }}" />
                                    <x-input-dropdown id="city_id" class="city_id" name="city_id" :options="[]" :selected="[$user->profile->city_id ?? '']" />
                                    <div class="invalid-feedback invalid-city_id"></div>
                                </div>
                                <div class="w-full sm:w-1/2 mt-4">
                                    <x-label for="postcode" value="{{ __('Postcode') }}" />
                                    <x-input id="postcode" class="block w-full" type="text" name="postcode" :value="$user->profile->postcode ?? '' " required autofocus autocomplete="postcode" />
                                    <div class="invalid-feedback invalid-postcode"></div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <x-label for="bank_details" value="{{ __('Bank Details') }}" />
                                <textarea name="bank_details" class="form-input" id="bank_details" cols="30" rows="5">{{ $user->profile->bank_details ?? '' }}</textarea>
                                <div class="invalid-feedback invalid-bank_details"></div>
                            </div>
{{--                            <div class="flex gap-4">--}}
{{--                                <div class="w-full sm:w-1/2 mt-4">--}}
{{--                                    <x-label for="currency_id" value="{{ __('Currency') }}" />--}}
{{--                                    <x-input-dropdown name="currency_id" :options="$currency_options" :selected="[$user->currency_id ?? '']"/>--}}
{{--                                    <div class="invalid-feedback invalid-currency_id"></div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            @if($user->hasRole('admin'))
                                <div class="flex gap-4 mt-4 items-center">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="verified" @checked($user->verified) class="sr-only peer">
                                        <div class="w-[53px] h-7 bg-gray-200 hover:bg-gray-300 peer-focus:outline-0 peer-focus:ring-transparent rounded-full peer transition-all ease-in-out duration-500 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-primary hover:peer-checked:bg-primary"></div>
                                    </label>
                                    <label class="inline-block">Verified</label>
                                </div>
                            @endif

                            <button class="btn-primary mt-4">{{ __('Update Profile') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                countryStateCityDropdown('.country_id', '.state_id', '.city_id', {{ $user->profile->state_id ?? '' }}, {{ $user->profile->city ?? '' }});
            });

            document.addEventListener('alpine:init', () => {
                Alpine.data('profile', () => ({
                    submitProfile: function () {
                        Swal.fire({
                            title: 'Updating...',
                            allowOutsideClick: true,
                            icon: 'info',
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        axios({
                            method: 'POST',
                            url: route('profile.update'),
                            data: new FormData(document.getElementById('profile')),
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
                                setTimeout(() => {
                                    if(response.data.redirect === 'No') {
                                        location.reload();
                                    } else {
                                        location.href = route('verification');
                                    }
                                }, 2000);
                            })
                            .catch(error => {
                                window.showJsonErrorMessage(error);
                            });
                    },
                }));
            });
        </script>
    @endpush
</x-app-layout>
