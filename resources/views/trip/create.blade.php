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
                            <div class="w-full sm:w-1/2 mt-4">
                                <x-label for="trip_type" value="{{ __('Trip Type') }}" />
                                <x-input-dropdown class="trip_type" name="trip_type" :options="$type_option" :selected="[]"/>
                                <div class="invalid-feedback invalid-trip_type"></div>
                            </div>
                            <div class="w-full sm:w-1/2 mt-4">
                                <x-label for="mode_of_transport" value="{{ __('Mode of Transport') }}" />
                                <x-input-dropdown class="mode_of_transport" name="mode_of_transport" :options="$transport_type_option" :selected="[]"/>
                                <div class="invalid-feedback invalid-mode_of_transport"></div>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-full sm:w-1/2 mt-4">
                                <x-label for="from" value="{{ __('From') }}" />
                                <div class="relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 opacity-50 text-primary absolute left-3 top-1/2 transform -translate-y-1/2"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
                                    <x-input id="from" class="block mt-1 w-full ps-10" type="text" name="from" :value="old('from')" required autocomplete="from" />
                                </div>
                                <div class="invalid-feedback invalid-from"></div>
                            </div>
                            <div class="w-full sm:w-1/2 mt-4">
                                <x-label for="to" value="{{ __('To') }}" />
                                <div class="relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 opacity-50 text-primary absolute left-3 top-1/2 transform -translate-y-1/2"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
                                    <x-input id="to" class="block mt-1 w-full ps-10" type="text" name="to" :value="old('to')" required autofocus autocomplete="to" />
                                </div>
                                <div class="invalid-feedback invalid-to"></div>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-full sm:w-1/2 mt-4">
                                <x-label for="departure_date" value="{!! __('Date & Time of Departure') !!}" />
                                <div class="relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 opacity-50 text-primary absolute left-3 top-1/2 transform -translate-y-1/2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                    </svg>
                                    <x-input id="departure_date" class="block mt-1 w-full timepicker ps-10" type="text" name="departure_date" :value="old('departure_date')" required autofocus autocomplete="departure_date" />
                                </div>
                                <div class="invalid-feedback invalid-departure_date"></div>
                            </div>
                            <div class="w-full sm:w-1/2 mt-4">
                                <x-label for="arrival_date" value="{{ __('Estimated Time of Arrival') }}" />
                                <div class="relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 opacity-50 text-primary absolute left-3 top-1/2 transform -translate-y-1/2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                    </svg>
                                    <x-input id="arrival_date" class="block mt-1 w-full timepicker ps-10" type="text" name="arrival_date" :value="old('arrival_date')" required autofocus autocomplete="arrival_date" />
                                </div>
                                <div class="invalid-feedback invalid-arrival_date"></div>
                            </div>
                        </div>

                        <div class="mt-4" x-data="{ stops: [''] }">
                            <x-label for="stopovers" value="{{ __('Stopovers (If applicable)') }}" />
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 opacity-50 text-primary absolute left-3 top-1/2 transform -translate-y-1/2"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
                                <x-input id="stopovers" class="block mt-1 w-full ps-10" type="text" name="stopovers[]" :value="old('stopovers')" autofocus autocomplete="stopovers" />

                                <button type="button" class="absolute right-[1px] p-[11px] bg-primary text-white rounded-r top-1/2 transform -translate-y-1/2"
                                        x-on:click="stops.push('')">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                </button>
                            </div>
                            <div class="invalid-feedback invalid-stopovers"></div>
                        </div>

                        <h3 class="heading-5 mt-8 mb-4 heading-title">Luggage & Courier Details</h3>
                        <div class="flex gap-4">
                            <div class="w-full sm:w-1/2 mt-4">
                                <x-label for="available_space" value="{{ __('Available Space/Weight Limit (in kg/lbs)') }}" />
                                <x-input id="available_space" class="block mt-1 w-full" type="text" name="available_space" :value="old('available_space')" required autofocus autocomplete="available_space" />
                                <div class="invalid-feedback invalid-available_space"></div>
                            </div>
                            <div class="w-full sm:w-1/2 mt-4">
                                <x-label for="type_of_item" value="{{ __('Type of Items Allowed') }}" />
                                <x-input-dropdown class="type_of_item" name="type_of_item" :options="$item_type_option" :selected="[]"/>
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
                                <x-input id="price" class="block mt-1 w-full" type="text" name="price" :value="old('price')" required autofocus autocomplete="price" />
                                <div class="invalid-feedback invalid-price"></div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-photo name="photo" title="Upload Photo" />
                        </div>
                        <div class="flex flex-col items-center justify-center mt-8">
                            <button class="mb-4 bg-primary w-full text-black py-4 px-10 text-xl font-medium rounded-md hover:bg-gray-700 hover:text-white transition ease-in-out duration-150">
                                {{ __('Create') }}
                            </button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>


        </div>
    </div>
    @push('scripts')
        <script>


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
