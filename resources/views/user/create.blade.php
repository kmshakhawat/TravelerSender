<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create User') }}
        </h2>
    </x-slot>

    <div x-data="user" class="py-12">
        <div class="container">
            <div class="flex flex-col md:flex-row gap-8">
                <div class="w-full md:w-1/4">
                    <x-user-sidebar />
                </div>
                <div class="w-full md:w-3/4">
                    <div class="bg-white border border-gray-50 rounded shadow p-4">
                        <h3 class="heading-5 mb-4 heading-title">{{ __('Create User') }}</h3>
                        <form id="create" name="create" @submit.prevent="createUser()">
                            @csrf
                            <div>
                                <x-profile-photo />
                            </div>
                            <div class="mt-4">
                                <x-label for="name" value="{{ __('Full Name') }}" />
                                <x-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
                                <div class="invalid-feedback invalid-name"></div>
                            </div>
                            <div class="flex gap-4">
                                <div class="w-full sm:w-1/2 mt-4">
                                    <x-label for="email" value="{{ __('Email Address') }}" />
                                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" />
                                    <div class="invalid-feedback invalid-email"></div>
                                </div>
                                <div class="w-full sm:w-1/2 mt-4">
                                    <x-label for="phone" value="{{ __('Phone Number') }}" />
                                    <x-input id="phone" class="block mt-1 w-full phone" type="text" name="phone" required autofocus autocomplete="phone" />
                                    <div class="invalid-feedback invalid-phone"></div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <x-label for="password" value="{{ __('Password') }}" />
                                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                                <div class="invalid-feedback invalid-password"></div>
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
                                    <x-label for="city" value="{{ __('City') }}" />
                                    <x-input id="city" class="block w-full" type="text" name="city" :value="$user->profile->city ?? ''" required autofocus autocomplete="city" />
                                    <div class="invalid-feedback invalid-city"></div>
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
                            <div class="flex gap-4">
                                <div class="w-full sm:w-1/2 mt-4">
                                    <x-label for="id_type" value="{{ __('ID Type') }}" />
                                    <x-input-dropdown class="id_type" name="id_type" :options="$id_type_options" :selected="[]"/>
                                    <div class="invalid-feedback invalid-id_type"></div>
                                </div>
                                <div class="w-full sm:w-1/2 mt-4">
                                    <x-label for="id_number" value="{{ __('ID Number') }}" />
                                    <x-input id="id_number" class="block mt-1 w-full" type="text" name="id_number" :value="$user->profile->id_number ?? ''" required autofocus autocomplete="id_number" />
                                    <div class="invalid-feedback invalid-id_number"></div>
                                </div>
                            </div>
                            <div id="additional_date" class="flex gap-4">
                                <div class="w-full sm:w-1/2 mt-4">
                                    <x-label for="id_issue" value="{{ __('Issue Date') }}" />
                                    <x-input id="id_issue" class="block mt-1 w-full datepicker" type="text" name="id_issue" autofocus autocomplete="id_issue" />
                                    <div class="invalid-feedback invalid-id_issue"></div>
                                </div>
                                <div class="w-full sm:w-1/2 mt-4">
                                    <x-label for="id_expiry" value="{{ __('Expiry Date') }}" />
                                    <x-input id="id_expiry" class="block mt-1 w-full datepicker" type="text" name="id_expiry" :value="$user->profile->id_expiry ?? '' " autofocus autocomplete="id_expiry" />
                                    <div class="invalid-feedback invalid-id_expiry"></div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <x-label for="dob" value="{{ __('Date of Birth') }}" />
                                <x-input id="dob" class="block mt-1 w-full datepicker" type="text" name="dob" required autofocus autocomplete="dob" />
                                <div class="invalid-feedback invalid-dob"></div>
                            </div>

                            <h5 class="heading-5 mt-10 heading-title">{{ __('Upload your ID Card') }}</h5>
                            <div class="flex flex-col lg:flex-row mt-4 gap-10">
                                <div class="w-full lg:w-2/3">
                                    <x-id-front :title="__('Upload Font Side')" />
                                    <div class="border mb-8"></div>
                                    <x-id-back :title="__('Upload Back Side')" />
                                </div>
                                <div class="border"></div>
                                <div class="w-full lg:w-1/3">
                                    <x-user-photo />
                                </div>
                            </div>
                            <div class="w-full sm:w-1/2 mt-4">
                                <x-label for="status" value="{{ __('Status') }}" />
                                <x-input-dropdown class="status !w-64" name="status" :options="$user_status_options" :selected="[]"/>
                                <div class="invalid-feedback invalid-status"></div>
                            </div>
                            <div class="flex gap-4 mt-4 items-center">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="verified" class="sr-only peer">
                                    <div class="w-[53px] h-7 bg-gray-200 hover:bg-gray-300 peer-focus:outline-0 peer-focus:ring-transparent rounded-full peer transition-all ease-in-out duration-500 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-primary hover:peer-checked:bg-primary"></div>
                                </label>
                                <label class="inline-block">Verified</label>
                            </div>
                            <div class="mt-4">
                                <x-label for="note" value="{{ __('Admin Note') }}" />
                                <textarea name="note" class="form-input" id="note" rows="2">{{ $user->profile->note ?? '' }}</textarea>
                                <div class="invalid-feedback invalid-note"></div>
                            </div>
                            <button class="btn-primary mt-4">{{ __('Create User') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                countryStateDropdown('.country_id', '.state_id', {{ $user->profile->state_id ?? '' }});

                function toggleAdditionalDate() {
                    let id_type = $('.id_type').val();
                    if (id_type !== 'National ID') {
                        $('#additional_date').slideDown(100);
                    } else {
                        $('#additional_date').slideUp(100);
                    }
                }
                toggleAdditionalDate();
                $('.id_type').on('change', toggleAdditionalDate);
            });
            document.addEventListener('alpine:init', () => {
                Alpine.data('user', () => ({
                    createUser: function () {
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
                            url: route('user.store'),
                            data: new FormData(document.getElementById('create')),
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
                                    window.location.href = route('user.index');
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
