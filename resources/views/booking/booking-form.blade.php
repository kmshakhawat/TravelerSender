<x-app-layout>
    <x-slot name="header" class="flex">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Book a trip to send a parcel') }}
            </h2>
            <a class="btn-secondary" href="{{ route('trip.search') }}">Back</a>
        </div>
    </x-slot>
    <div x-data="booking" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-trip :trip="$trip" />

            <div class="bg-white border border-gray-50 rounded shadow p-4">
                <form id="booking" method="POST" @submit.prevent="bookTrip">
                    @csrf
                    <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                    <h3 class="heading-5 mb-4">Booking Information</h3>
                    <div id="product-container">
                        <!-- Products will be injected here dynamically -->
                    </div>
                    <button type="button" class="btn-secondary" onclick="addProduct()">+ Add New Product</button>

                    <h3 class="heading-5 mt-8 mb-4 heading-title">Sender Details</h3>
                    <div class="flex flex-col sm:flex-row sm:gap-4">
                        <div class="w-full sm:w-1/3 mt-4">
                            <x-label for="sender_name" value="{{ __('Name') }}" />
                            <div class="relative">
                                <svg class="size-6 opacity-50 text-primary absolute left-3 top-1/2 transform -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                                <x-input id="sender_name" class="block w-full ps-10" type="text" name="sender_name" :value="old('sender_name')" required autocomplete="sender_name" />
                            </div>
                            <div class="invalid-feedback invalid-sender_name"></div>
                        </div>
                        <div class="w-full sm:w-1/3 mt-4">
                            <x-label for="sender_email" value="{{ __('Email') }}" />
                            <div class="relative">
                                <svg class="size-6 opacity-50 text-primary absolute left-3 top-1/2 transform -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                </svg>
                                <x-input id="sender_email" class="block w-full ps-10" type="email" name="sender_email" :value="old('sender_email')" required autocomplete="sender_email" />
                            </div>
                            <div class="invalid-feedback invalid-sender_email"></div>
                        </div>
                        <div class="w-full sm:w-1/3 mt-4">
                            <x-label for="sender_phone" value="{{ __('Phone') }}" />
                            <div class="relative">
                                <svg class="size-6 opacity-50 text-primary absolute left-3 top-1/2 transform -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                </svg>
                                <x-input id="sender_phone" class="block w-full ps-10 phone" type="text" name="sender_phone" :value="old('sender_phone')" required autocomplete="sender_phone" />
                            </div>
                            <div class="invalid-feedback invalid-sender_phone"></div>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:gap-4">
                        <div class="w-full sm:w-1/2 mt-4">
                            <x-label for="collection_type" value="{{ __('Convenient Parcel Collection') }}" />
                            <x-input-dropdown class="collection_type !w-64" name="collection_type" :options="$collection_type_options" :selected="[]"/>
                            <div class="invalid-feedback invalid-collection_type"></div>
                        </div>
                    </div>
                    <div id="pickup_address" style="display: none">
                        <div class="flex gap-4">
                            <div class="w-full sm:w-1/2 mt-4">
                                <x-label for="pickup_address_1" value="{{ __('Address Line 1') }}" />
                                <x-input id="pickup_address_1" class="block w-full" type="text" name="pickup_address_1" :value="old('pickup_address_1')" autocomplete="pickup_address_1" />
                                <div class="invalid-feedback invalid-pickup_address_1"></div>
                            </div>
                            <div class="w-full sm:w-1/2 mt-4">
                                <x-label for="pickup_address_2" value="{{ __('Address Line 2') }}" />
                                <x-input id="pickup_address_2" class="block w-full" type="text" name="pickup_address_2" :value="old('pickup_address_2')" autocomplete="pickup_address_2" />
                                <div class="invalid-feedback invalid-pickup_address_2"></div>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-full sm:w-1/2 mt-4">
                                <x-label for="pickup_country_id" value="{{ __('Country') }}" />
                                <x-input-dropdown id="pickup_country_id" class="w-full pickup_country_id" name="pickup_country_id" :options="$countries" :selected="[]"/>
                                <div class="invalid-feedback invalid-pickup_country_id"></div>
                            </div>
                            <div class="w-full sm:w-1/2 mt-4">
                                <x-label for="pickup_state_id" value="{{ __('State') }}" />
                                <x-input-dropdown id="pickup_state_id" class="w-full pickup_state_id" name="pickup_state_id" :options="[]" :selected="[]" />
                                <div class="invalid-feedback invalid-pickup_state_id"></div>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-full sm:w-1/2 mt-4">
                                <x-label for="pickup_city_id" value="{{ __('City') }}" />
                                <x-input-dropdown id="pickup_city_id" class="w-full pickup_city_id" name="pickup_city_id" :options="[]" :selected="[]" />
                                <div class="invalid-feedback invalid-pickup_city"></div>
                            </div>
                            <div class="w-full sm:w-1/2 mt-4">
                                <x-label for="pickup_postcode" value="{{ __('Postcode') }}" />
                                <x-input id="pickup_postcode" class="block w-full" type="text" name="pickup_postcode" :value="old('pickup_postcode')" autocomplete="pickup_postcode" />
                                <div class="invalid-feedback invalid-pickup_postcode"></div>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:gap-4">
                            <div class="w-full sm:w-1/2 mt-4">
                                <x-label for="pickup_location_type" value="{{ __('Pickup Location Type') }}" />
                                <x-input-dropdown :search="false" class="w-full" name="pickup_location_type" :options="$location_type_options" :selected="[]"/>
                                <div class="invalid-feedback invalid-pickup_location_type"></div>
                            </div>
                            <div class="w-full sm:w-1/2 mt-4">
                                <x-label for="pickup_date" value="{{ __('Pickup Date') }}" />
                                <div class="relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 opacity-50 text-primary absolute left-3 top-1/2 transform -translate-y-1/2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                    </svg>
                                    <x-input id="pickup_date" class="block w-full timepicker ps-10" type="text" name="pickup_date" :value="old('pickup_date')" autocomplete="pickup_date" />
                                </div>
                                <div class="invalid-feedback invalid-pickup_date"></div>
                            </div>
                        </div>
                    </div>
                    <div id="flexible" style="display: none">
                        <div class="mt-4">
                            <x-label for="flexible_place" value="{{ __('Flexible Place Details (malls or restaurants)') }}" />
                            <textarea name="flexible_place" id="flexible_place" class="form-input">{{ old('flexible_place') }}</textarea>
                            <div class="invalid-feedback invalid-flexible_place"></div>
                        </div>
                    </div>
                    <div id="by_friend" style="display: none">
                        <div class="flex flex-col sm:flex-row sm:gap-4">
                            <div class="w-full sm:w-1/3 mt-4">
                                <x-label for="friend_name" value="{{ __('Name') }}" />
                                <div class="relative">
                                    <svg class="size-6 opacity-50 text-primary absolute left-3 top-1/2 transform -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                    <x-input id="friend_name" class="block w-full ps-10" type="text" name="friend_name" :value="old('friend_name')" required autocomplete="friend_name" />
                                </div>
                                <div class="invalid-feedback invalid-friend_name"></div>
                            </div>
                            <div class="w-full sm:w-1/3 mt-4">
                                <x-label for="friend_email" value="{{ __('Email') }}" />
                                <div class="relative">
                                    <svg class="size-6 opacity-50 text-primary absolute left-3 top-1/2 transform -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                    </svg>
                                    <x-input id="friend_email" class="block w-full ps-10" type="email" name="friend_email" :value="old('friend_email')" required autocomplete="friend_email" />
                                </div>
                                <div class="invalid-feedback invalid-friend_email"></div>
                            </div>
                            <div class="w-full sm:w-1/3 mt-4">
                                <x-label for="friend_phone" value="{{ __('Phone') }}" />
                                <div class="relative">
                                    <svg class="size-6 opacity-50 text-primary absolute left-3 top-1/2 transform -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                    </svg>
                                    <x-input id="friend_phone" class="block w-full ps-10 phone" type="text" name="friend_phone" :value="old('friend_phone')" required autocomplete="friend_phone" />
                                </div>
                                <div class="invalid-feedback invalid-friend_phone"></div>
                            </div>
                        </div>
                    </div>

                    <h3 class="heading-5 mt-8 mb-4 heading-title">Receiver Details</h3>
                    <div class="flex flex-col sm:flex-row sm:gap-4">
                        <div class="w-full sm:w-1/3 mt-4">
                            <x-label for="receiver_name" value="{{ __('Name') }}" />
                            <div class="relative">
                                <svg class="size-6 opacity-50 text-primary absolute left-3 top-1/2 transform -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                                <x-input id="receiver_name" class="block w-full ps-10" type="text" name="receiver_name" :value="old('receiver_name')" required autocomplete="receiver_name" />
                            </div>
                            <div class="invalid-feedback invalid-receiver_name"></div>
                        </div>
                        <div class="w-full sm:w-1/3 mt-4">
                            <x-label for="receiver_email" value="{{ __('Email') }}" />
                            <div class="relative">
                                <svg class="size-6 opacity-50 text-primary absolute left-3 top-1/2 transform -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                </svg>
                                <x-input id="receiver_email" class="block w-full ps-10" type="email" name="receiver_email" :value="old('receiver_email')" required autocomplete="receiver_email" />
                            </div>
                            <div class="invalid-feedback invalid-receiver_email"></div>
                        </div>
                        <div class="w-full sm:w-1/3 mt-4">
                            <x-label for="receiver_phone" value="{{ __('Phone') }}" />
                            <div class="relative">
                                <svg class="size-6 opacity-50 text-primary absolute left-3 top-1/2 transform -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                </svg>
                                <x-input id="receiver_phone" class="block w-full ps-10 phone" type="text" name="receiver_phone" :value="old('receiver_phone')" required autocomplete="receiver_phone" />
                            </div>
                            <div class="invalid-feedback invalid-receiver_phone"></div>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:gap-4">
                        <div class="w-full sm:w-1/2 mt-4">
                            <x-label for="delivery_type" value="{{ __('Convenient Parcel Delivery') }}" />
                            <x-input-dropdown class="delivery_type !w-64" name="delivery_type" :options="$delivery_type_options" :selected="[]"/>
                            <div class="invalid-feedback invalid-delivery_type"></div>
                        </div>
                    </div>
                    <div id="delivery_address" style="display: none">
                        <div class="flex gap-4">
                            <div class="w-full sm:w-1/2 mt-4">
                                <x-label for="delivery_address_1" value="{{ __('Address Line 1') }}" />
                                <x-input id="delivery_address_1" class="block w-full" type="text" name="delivery_address_1" :value="old('delivery_address_1')" autocomplete="delivery_address_1" />
                                <div class="invalid-feedback invalid-delivery_address_1"></div>
                            </div>
                            <div class="w-full sm:w-1/2 mt-4">
                                <x-label for="delivery_address_2" value="{{ __('Address Line 2') }}" />
                                <x-input id="delivery_address_2" class="block w-full" type="text" name="delivery_address_2" :value="old('delivery_address_2')" autocomplete="delivery_address_2" />
                                <div class="invalid-feedback invalid-delivery_address_2"></div>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-full sm:w-1/2 mt-4">
                                <x-label for="delivery_country_id" value="{{ __('Country') }}" />
                                <x-input-dropdown id="delivery_country_id" class="delivery_country_id" name="delivery_country_id" :options="$countries" :selected="[]"/>
                                <div class="invalid-feedback invalid-delivery_country_id"></div>
                            </div>
                            <div class="w-full sm:w-1/2 mt-4">
                                <x-label for="delivery_state_id" value="{{ __('State') }}" />
                                <x-input-dropdown id="delivery_state_id" class="delivery_state_id" name="delivery_state_id" :options="[]" :selected="[]" />
                                <div class="invalid-feedback invalid-delivery_state_id"></div>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-full sm:w-1/2 mt-4">
                                <x-label for="delivery_city_id" value="{{ __('City') }}" />
                                <x-input-dropdown id="delivery_city_id" class="delivery_city_id" name="delivery_city_id" :options="[]" :selected="[]" />
                                <div class="invalid-feedback invalid-delivery_city"></div>
                            </div>
                            <div class="w-full sm:w-1/2 mt-4">
                                <x-label for="delivery_postcode" value="{{ __('Postcode') }}" />
                                <x-input id="delivery_postcode" class="block w-full" type="text" name="delivery_postcode" :value="old('delivery_postcode')" autocomplete="delivery_postcode" />
                                <div class="invalid-feedback invalid-delivery_postcode"></div>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:gap-4">
                            <div class="w-full sm:w-1/2 mt-4">
                                <x-label for="delivery_location_type" value="{{ __('Delivery Location Type') }}" />
                                <x-input-dropdown :search="false" class="w-full" name="delivery_location_type" :options="$location_type_options" :selected="[]"/>
                                <div class="invalid-feedback invalid-delivery_location_type"></div>
                            </div>
                            <div class="w-full sm:w-1/2 mt-4">
                                <x-label for="delivery_date" value="{{ __('Delivery Date') }}" />
                                <div class="relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 opacity-50 text-primary absolute left-3 top-1/2 transform -translate-y-1/2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                    </svg>
                                    <x-input id="delivery_date" class="block w-full timepicker ps-10" type="text" name="delivery_date" :value="old('delivery_date')" required autocomplete="delivery_date" />
                                </div>
                                <div class="invalid-feedback invalid-delivery_date"></div>
                            </div>
                        </div>
                    </div>
                    <div id="flexible_delivery" style="display: none">
                        <div class="mt-4">
                            <x-label for="flexible_delivery_place" value="{{ __('Flexible Place Details (malls or restaurants)') }}" />
                            <textarea name="flexible_delivery_place" id="flexible_delivery_place" class="form-input">{{ old('flexible_delivery_place') }}</textarea>
                            <div class="invalid-feedback invalid-flexible_delivery_place"></div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <x-label for="note" value="{{ __('Note') }}" />
                        <textarea name="note" id="note" class="form-input">{{ old('note') }}</textarea>
                    </div>
                    @if(Auth::user()->hasRole('admin'))
                        <div class="mt-4">
                            <x-label for="admin_note" value="{{ __('Admin Note') }}" />
                            <textarea name="admin_note" id="admin_note" class="form-input"></textarea>
                        </div>
                    @endif
                    <button class="my-4 btn-primary">
                        {{ __('Request to Book') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function () {
                function toggleParcelCollection() {
                    let collection_type = $('.collection_type').val();
                    if (collection_type === 'Collect from Address') {
                        $('#pickup_address').slideDown(100);
                    } else {
                        $('#pickup_address').slideUp(100);
                    }
                    if( collection_type === 'Flexible Meet') {
                        $('#flexible').slideDown(100);
                    } else {
                        $('#flexible').slideUp(100);
                    }
                    if( collection_type === 'Send by Friend') {
                        $('#by_friend').slideDown(100);
                    } else {
                        $('#by_friend').slideUp(100);
                    }
                }
                toggleParcelCollection();

                $('.collection_type').on('change', toggleParcelCollection);

                function toggleParcelDelivery() {
                    let delivery_type = $('.delivery_type').val();
                    if (delivery_type === 'Deliver to Address') {
                        $('#delivery_address').slideDown(100);
                    } else {
                        $('#delivery_address').slideUp(100);
                    }
                    if( delivery_type === 'Flexible Meet') {
                        $('#flexible_delivery').slideDown(100);
                    } else {
                        $('#flexible_delivery').slideUp(100);
                    }
                }
                toggleParcelDelivery();
                $('.delivery_type').on('change', toggleParcelDelivery);

                countryStateCityDropdown('.pickup_country_id', '.pickup_state_id','.pickup_city_id');
                countryStateCityDropdown('.delivery_country_id', '.delivery_state_id', '.delivery_city_id');
            });


            let productIndex = 0; // Start the product index

            // Add a new product entry
            function renderProduct(index) {
                return `
            <div class="border p-3 mb-3 product" data-index="${index}">
                <h5 class="text-lg font-medium mb-4 heading-title">Product <span>${index + 1}</span></h5>
                <div class="flex flex-col sm:flex-row sm:gap-4">
                    <div class="w-full sm:w-1/2 mt-4">
                        <x-label value="{{ __('Name') }}" />
                        <x-input class="block w-full" type="text" name="products[${index}][name]" required />
                        <div class="invalid-feedback invalid-products[${index}][name]"></div>
                    </div>
                    <div class="w-full sm:w-1/2 mt-4">
                        <x-label value="{{ __('Type') }}" />
                        <x-input-dropdown class="type_of_item" name="products[${index}][type]" :options="$item_type_option" :selected="[]"/>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row sm:gap-4">
                    <div class="w-full sm:w-1/5 mt-4">
                        <x-label value="{{ __('Quantity') }}" />
                        <x-input class="block w-full" type="text" name="products[${index}][quantity]" required />
                    </div>
                    <div class="w-full sm:w-1/5 mt-4">
                        <x-label value="{{ __('Weight') }}" />
                        <div class="flex relative">
                            <x-input class="block w-full" type="text" name="products[${index}][weight]" required />
                            <select class="form-input absolute right-0 top-0 !w-20 border-l-0" name="products[${index}][weight_type]">
                                <option value="KG">KG</option>
                                <option value="LBS">LBS</option>
                            </select>
                        </div>
                    </div>
                    <div class="w-full sm:w-1/5 mt-4">
                        <x-label value="{{ __('Length (cm)') }}" />
                        <x-input class="block w-full" type="text" name="products[${index}][length]" required />
                    </div>
                    <div class="w-full sm:w-1/5 mt-4">
                        <x-label value="{{ __('Width (cm)') }}" />
                        <x-input class="block w-full" type="text" name="products[${index}][width]" required />
                    </div>
                    <div class="w-full sm:w-1/5 mt-4">
                        <x-label value="{{ __('Height (cm)') }}" />
                        <x-input class="block w-full" type="text" name="products[${index}][height]" required />
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row sm:gap-4">
                    <div class="w-full sm:w-1/4 mt-4">
                        <x-label value="{{ __('Bag/Box') }}" />
                        <select class="form-input" name="products[${index}][box]">
                            <option value="">Select</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="w-full sm:w-1/4 mt-4">
                        <x-label value="{{ __('Fragile') }}" />
                        <select class="form-input" name="products[${index}][fragile]">
                            <option value="">Select</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="w-full sm:w-1/4 mt-4">
                        <x-label value="{{ __('Insurance') }}" />
                        <select class="form-input" name="products[${index}][insurance]">
                            <option value="">Select</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="w-full sm:w-1/4 mt-4">
                        <x-label value="{{ __('Urgent') }}" />
                        <select class="form-input" name="products[${index}][urgent]">
                            <option value="">Select</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4">
                    <x-label for="note" value="{{ __('Note') }}" />
                    <textarea class="form-input" name="products[${index}][note]"></textarea>
                </div>

                <div class="mt-4">
                    <x-label value="{{ __('Upload Image') }}" />
                    <x-photo name="products[${index}][images][]" :multiple="true" />
                </div>

                <div class="mt-4">
                    ${index > 0 ? `<button type="button" class="btn btn-danger btn-sm" onclick="removeProduct(${index})">Remove Product</button>` : ''}
                </div>
            </div>
        `;
            }

            // Initial product rendering
            document.getElementById("product-container").innerHTML = renderProduct(productIndex);

            // Add a new product entry
            function addProduct() {
                productIndex++;
                const container = document.getElementById("product-container");
                container.insertAdjacentHTML('beforeend', renderProduct(productIndex));
            }

            // Remove a product entry
            function removeProduct(index) {
                const product = document.querySelector(`.product[data-index="${index}"]`);
                if (product) {
                    product.remove();
                }
            }


            document.addEventListener('alpine:init', () => {
                Alpine.data('booking', () => ({

                    bookTrip: function () {
                        const formData = new FormData(document.getElementById('booking'));
                        Swal.fire({
                            title            : 'Processing...',
                            allowOutsideClick: true,
                            icon             : 'info',
                            didOpen          : () => {
                                Swal.showLoading();
                            }
                        });
                        axios({
                            method : 'POST',
                            url    : route('booking.store'),
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
                                setTimeout(() => {
                                    window.location.href = response.data.checkout_url;
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
