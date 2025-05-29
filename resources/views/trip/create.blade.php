<x-app-layout>
    <x-slot name="header" class="flex">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Trip') }}
        </h2>
    </x-slot>
    <div x-data="trip" class="py-12">
        <div class="container">
            <div class="flex gap-8">
                <div class="w-1/4">
                    <x-trip-sidebar />
                </div>
                <div class="w-3/4">
                    <div class="bg-white border border-gray-50 rounded shadow p-4">
                        <form id="create" method="POST" @submit.prevent="storeTrip">
                            @csrf
                            <h3 class="heading-5 mb-4 heading-title">Trip Information</h3>
                            <div class="flex gap-4">
{{--                                <div class="w-full sm:w-1/2 mt-4">--}}
{{--                                    <x-label for="trip_type" value="{{ __('Trip Type') }}" />--}}
{{--                                    <x-input-dropdown class="trip_type" name="trip_type" :options="$type_option" :selected="[]"/>--}}
{{--                                    <div class="invalid-feedback invalid-trip_type"></div>--}}
{{--                                </div>--}}
                                <div class="w-full sm:w-1/2 mt-4">
                                    <x-label for="mode_of_transport" value="{{ __('Mode of Transport') }}" />
                                    <x-input-dropdown class="mode_of_transport" name="mode_of_transport" :options="$transport_type_option" :selected="[]"/>
                                    <div class="invalid-feedback invalid-mode_of_transport"></div>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="w-full sm:w-full mt-4">
                                    <x-label for="vehicle_details" value="{{ __('Vehicle Details') }}" />
                                    <textarea
                                        name="vehicle_details"
                                        id="vehicle_details"
                                        class="form-input">{{ old('vehicle_details') }}</textarea>
                                    <div class="invalid-feedback invalid-vehicle_details"></div>
                                </div>
                            </div>
                            <div class="p-4 bg-gray-50 rounded my-5 border border-primary border-opacity-50">
                                <h5 class="heading-5">From</h5>
                                <div class="flex gap-4">
                                    <div class="w-full sm:w-1/2 mt-4">
                                        <x-label for="from_country_id" value="{{ __('Country') }}" />
                                        <x-input-dropdown id="from_country_id" class="from_country_id" name="from_country_id" :options="$countries" :selected="[]"/>
                                        <div class="invalid-feedback invalid-from_country_id"></div>
                                    </div>
                                    <div class="w-full sm:w-1/2 mt-4">
                                        <x-label for="from_state_id" value="{{ __('State') }}" />
                                        <x-input-dropdown id="from_state_id" class="from_state_id" name="from_state_id" :options="[]" :selected="[]" />
                                        <div class="invalid-feedback invalid-from_state_id"></div>
                                    </div>
                                </div>
                                <div class="flex gap-4">
                                    <div class="w-full sm:w-1/2 mt-4">
                                        <x-label for="from_city_id" value="{{ __('City') }}" />
                                        <x-input-dropdown id="from_city_id" class="from_city_id" name="from_city_id" :options="[]" :selected="[]" />
                                        <div class="invalid-feedback invalid-from_city_id"></div>
                                    </div>
                                    <div class="w-full sm:w-1/2 mt-4">
                                        <x-label for="from_phone" value="{{ __('Phone') }}" />
                                        <x-input id="from_phone" class="block w-full phone" type="text" name="from_phone" :value="old('from_phone')" required autocomplete="from_phone" />
                                        <div class="invalid-feedback invalid-from_phone"></div>
                                    </div>
                                </div>
                                <div class="flex gap-4">
                                    <div class="w-full sm:w-1/2 mt-4">
                                        <x-label for="from_address_1" value="{{ __('Address Line 1') }}" />
                                        <x-input id="from_address_1" class="block w-full" type="text" name="from_address_1" :value="''" autocomplete="from_address_1" />
                                        <div class="invalid-feedback invalid-from_address_1"></div>
                                    </div>
                                    <div class="w-full sm:w-1/2 mt-4">
                                        <x-label for="from_address_2" value="{{ __('Address Line 2') }}" />
                                        <x-input id="from_address_2" class="block w-full" type="text" name="from_address_2" :value="''" autocomplete="from_address_2" />
                                        <div class="invalid-feedback invalid-from_address_2"></div>
                                    </div>
                                </div>
                                <div class="flex gap-4">
                                    <div class="w-full sm:w-1/2 mt-4">
                                        <x-label for="from_postcode" value="{{ __('Postcode') }}" />
                                        <x-input id="from_postcode" class="block w-full" type="text" name="from_postcode" :value="''" required autocomplete="from_postcode" />
                                        <div class="invalid-feedback invalid-from_postcode"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 bg-gray-50 rounded my-5 border border-primary border-opacity-50">
                                <h5 class="heading-5">To</h5>
                                <div class="flex gap-4">
                                    <div class="w-full sm:w-1/2 mt-4">
                                        <x-label for="to_country_id" value="{{ __('Country') }}" />
                                        <x-input-dropdown id="to_country_id" class="to_country_id" name="to_country_id" :options="$countries" :selected="[]"/>
                                        <div class="invalid-feedback invalid-to_country_id"></div>
                                    </div>
                                    <div class="w-full sm:w-1/2 mt-4">
                                        <x-label for="to_state_id" value="{{ __('State') }}" />
                                        <x-input-dropdown id="to_state_id" class="to_state_id" name="to_state_id" :options="[]" :selected="[]" />
                                        <div class="invalid-feedback invalid-to_state_id"></div>
                                    </div>
                                </div>
                                <div class="flex gap-4">
                                    <div class="w-full sm:w-1/2 mt-4">
                                        <x-label for="to_city_id" value="{{ __('City') }}" />
                                        <x-input-dropdown id="to_city_id" class="to_city_id" name="to_city_id" :options="[]" :selected="[]" />
                                        <div class="invalid-feedback invalid-to_city_id"></div>
                                    </div>
                                    <div class="w-full sm:w-1/2 mt-4">
                                        <x-label for="to_phone" value="{{ __('Phone') }}" />
                                        <x-input id="to_phone" class="block w-full phone" type="text" name="to_phone" :value="old('to_phone')" required autocomplete="to_phone" />
                                        <div class="invalid-feedback invalid-to_phone"></div>
                                    </div>
                                </div>
                                <div class="flex gap-4">
                                    <div class="w-full sm:w-1/2 mt-4">
                                        <x-label for="to_address_1" value="{{ __('Address Line 1') }}" />
                                        <x-input id="to_address_1" class="block w-full" type="text" name="to_address_1" :value="''" autocomplete="to_address_1" />
                                        <div class="invalid-feedback invalid-to_address_1"></div>
                                    </div>
                                    <div class="w-full sm:w-1/2 mt-4">
                                        <x-label for="to_address_2" value="{{ __('Address Line 2') }}" />
                                        <x-input id="to_address_2" class="block w-full" type="text" name="to_address_2" :value="''" autocomplete="to_address_2" />
                                        <div class="invalid-feedback invalid-to_address_2"></div>
                                    </div>
                                </div>
                                <div class="flex gap-4">
                                    <div class="w-full sm:w-1/2 mt-4">
                                        <x-label for="to_postcode" value="{{ __('Postcode') }}" />
                                        <x-input id="to_postcode" class="block w-full" type="text" name="to_postcode" :value="''" required autocomplete="to_postcode" />
                                        <div class="invalid-feedback invalid-to_postcode"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <div class="w-full sm:w-1/2 mt-4">
                                    <x-label for="departure_date" value="{!! __('Date & Time of Departure') !!}" />
                                    <div class="relative">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 opacity-50 text-primary absolute left-3 top-1/2 transform -translate-y-1/2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                        </svg>
                                        <x-input id="departure_date" class="block w-full timepicker ps-10" type="text" name="departure_date" :value="old('departure_date')" required autofocus autocomplete="departure_date" />
                                    </div>
                                    <div class="invalid-feedback invalid-departure_date"></div>
                                </div>
                                <div class="w-full sm:w-1/2 mt-4">
                                    <x-label for="arrival_date" value="{{ __('Estimated Time of Arrival') }}" />
                                    <div class="relative">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 opacity-50 text-primary absolute left-3 top-1/2 transform -translate-y-1/2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                        </svg>
                                        <x-input id="arrival_date" class="block w-full timepicker ps-10" type="text" name="arrival_date" :value="old('arrival_date')" required autocomplete="arrival_date" />
                                    </div>
                                    <div class="invalid-feedback invalid-arrival_date"></div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <div x-data="{ stopovers: [''] }">
                                    <x-label for="stopovers" value="{{ __('Stopovers (If applicable)') }}" />
                                    <template x-for="(stopover, index) in stopovers" :key="index">
                                        <div class="relative mt-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 opacity-50 text-primary absolute left-3 top-1/2 transform -translate-y-1/2">
                                                <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/>
                                                <circle cx="12" cy="10" r="3"/>
                                            </svg>
                                            <x-input id="stopovers" class="block w-full ps-10" type="text" name="stopovers[]" :value="old('stopovers')" autofocus autocomplete="stopovers" />
                                            <button type="button" class="absolute right-[1px] p-[11px] bg-red-500 text-white rounded-r top-1/2 transform -translate-y-1/2" @click="stopovers.splice(index, 1)" x-show="stopovers.length > 1">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </template>

                                    <!-- Add Button -->
                                    <button type="button" class="mt-3 btn-secondary" @click="stopovers.push('')">
                                        Add Stopover
                                    </button>
                                </div>
                                <div class="invalid-feedback invalid-stopovers"></div>
                            </div>

                            <h3 class="heading-5 mt-8 mb-4 heading-title">Luggage & Courier Details</h3>
                            <div class="flex gap-4">
                                <div class="w-full sm:w-1/2 mt-4">
                                    <x-label for="available_space" value="{{ __('Available Space/Weight Limit (in kg/lbs)') }}" />
                                    <div class="flex relative">
                                        <x-input id="available_space" class="block w-full" type="text" name="available_space" :value="old('available_space')" required autocomplete="available_space" />
                                        <x-input-dropdown :search="false" class="absolute right-0 top-0 !w-16 border-l-0" name="weight_unit" :options="$weight_unit_options" :selected="[]"/>
                                    </div>
                                    <div class="invalid-feedback invalid-available_space"></div>
                                </div>
                                <div class="w-full sm:w-1/2 mt-4">
                                    <x-label for="type_of_item" value="{{ __('Type of Items Allowed') }}" />
                                    <x-input-dropdown class="type_of_item" name="type_of_item[]" :options="$item_type_option" :selected="[]" multiple/>
                                    <small class="text-xs text-gray-500">You can select multiple items</small>
                                    <div class="invalid-feedback invalid-type_of_item"></div>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <div class="w-full sm:w-1/2 mt-4">
                                    <x-label for="packaging_requirement" value="{{ __('Packaging Requirements') }}" />
                                    <x-input-dropdown class="packaging_requirement" name="packaging_requirement" :options="$packaging_requirement_options" :selected="[]"/>
                                    <div class="invalid-feedback invalid-packaging_requirement"></div>
                                </div>
                                <div class="w-full sm:w-1/2 mt-4">
                                    <x-label for="handling_instruction" value="{{ __('Handling Instructions') }}" />
                                    <x-input-dropdown class="handling_instruction" name="handling_instruction" :options="$handling_instruction_options" :selected="[]"/>
                                    <div class="invalid-feedback invalid-handling_instruction"></div>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="w-full sm:w-1/2 mt-4">
                                    <x-label for="price" value="{{ __('Price') }}" />
                                    <div class="relative">
                                        <div class="size-6 text-primary absolute left-3 top-1/2 transform -translate-y-1/2">
                                            {{ auth()->user()->currency->symbol ?? '₦' }}
                                        </div>
                                        <x-input id="price" class="block w-full ps-10" type="text" name="price" :value="old('price')" required autofocus autocomplete="price" />
                                    </div>
                                    <div class="invalid-feedback invalid-price"></div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <x-label for="note" value="{{ __('Note') }}" />
                                <textarea
                                    name="note"
                                    id="note"
                                    class="form-input">{{ old('note') }}</textarea>
                            </div>
                            @if(Auth::user()->hasRole('admin'))
                                <div class="mt-4">
                                    <x-label for="admin_note" value="{{ __('Admin Note') }}" />
                                    <textarea
                                        name="admin_note"
                                        id="admin_note"
                                        class="form-input">{{ old('admin_note') }}</textarea>
                                </div>
                            @endif
{{--                        <div class="mt-4">--}}
{{--                            <x-photo name="photo" title="Upload Photo" />--}}
{{--                        </div>--}}
                            <button class="my-4 btn-primary">
                                {{ __('Create') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                countryStateCityDropdown('.from_country_id', '.from_state_id', '.from_city_id');
                countryStateCityDropdown('.to_country_id', '.to_state_id', '.to_city_id');
            });

            document.addEventListener('alpine:init', () => {
                Alpine.data('trip', () => ({
                    storeTrip: function () {
                        const formData = new FormData(document.getElementById('create'));
                        Swal.fire({
                            title            : 'Creating...',
                            allowOutsideClick: true,
                            icon             : 'info',
                            didOpen          : () => {
                                Swal.showLoading();
                            }
                        });
                        axios({
                            method : 'POST',
                            url    : route('trip.store'),
                            data   : formData,
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        })
                            .then(response => {
                                Swal.fire({
                                    title            : 'Success!',
                                    text             : response.data.message,
                                    icon             : 'success',
                                    confirmButtonText: 'OK'
                                });
                                window.location.href = route('trip.index');
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
