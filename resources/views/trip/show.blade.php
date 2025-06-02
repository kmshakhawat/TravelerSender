<x-app-layout>
    <x-slot name="header" class="flex">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Trip Details') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="container">
            <div class="flex gap-8">
                <div class="w-1/4">
                    <x-trip-sidebar />
                </div>
                <div class="w-3/4">
                    <div class="bg-white border border-gray-50 rounded shadow p-4">
                        <div class="flex items-center justify-between heading-title">
                            <h3 class="heading-5 mb-4">Trip Information</h3>
                            <a class="btn-secondary" href="{{ route('trip.index') }}">Back</a>
                        </div>
                        <div class="overflow-auto">
                            <table class="w-full table mb-8 whitespace-nowrap">
{{--                                <tr>--}}
{{--                                    <td>Trip Type</td>--}}
{{--                                    <td>{{ $trip->trip_type }}</td>--}}
{{--                                </tr>--}}
                                <tr>
                                    <td>Mode of Transport</td>
                                    <td>{{ $trip->mode_of_transport }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5 class="heading-5">From</h5>
                                    </td>
                                    <td>
                                        <div>
                                            <p>Address Line 1: {{ $trip->from_address_1 }}</p>
                                            <p>Address Line 2: {{ $trip->from_address_2 }}</p>
                                            <p>Country: {{ $trip->fromCountry->name ?? '' }}</p>
                                            <p>State: {{ $trip->fromState->name ?? '' }}</p>
                                            <p>City: {{ $trip->fromCity?->name }}</p>
                                            <p>Postcode: {{ $trip->from_postcode }}</p>
                                            <p>Phone: {{ $trip->from_phone }}</p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5 class="heading-5">To</h5>
                                    </td>
                                    <td>
                                        <div>
                                            <p>Address Line 1: {{ $trip->to_address_1 }}</p>
                                            <p>Address Line 2: {{ $trip->to_address_2 }}</p>
                                            <p>Country: {{ $trip->toCountry->name ?? '' }}</p>
                                            <p>State: {{ $trip->toState->name ?? '' }}</p>
                                            <p>City: {{ $trip->toCity?->name }}</p>
                                            <p>Postcode: {{ $trip->to_postcode }}</p>
                                            <p>Phone: {{ $trip->to_phone }}</p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Date & Time of Departure</td>
                                    <td>{{ getDateFormat($trip->departure_date) }}</td>
                                </tr>
                                <tr>
                                    <td>Estimated Time of Arrival</td>
                                    <td>{{ getDateFormat($trip->arrival_date) }}</td>
                                </tr>
                                @if($trip->stopovers)
                                <tr>
                                    <td class="align-top">Stopovers (If applicable)</td>
                                    <td>
                                        <div class="flex flex-col">
                                        @foreach($trip->stopovers as $stopover)
                                               <div class="font-medium">
                                                   {{ $stopover->location }}
                                               </div>
                                                @unless ($loop->last)
                                               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-primary">
                                                   <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25 12 21m0 0-3.75-3.75M12 21V3" />
                                               </svg>
                                                @endunless
                                        @endforeach
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="2">
                                        <h5 class="heading-5">Luggage & Courier Details</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Available Space/Weight Limit (in kg/lbs)</td>
                                    <td>{{ $trip->available_space }} {{ $trip->weight_unit }}</td>
                                </tr>
                                <tr>
                                    <td>Type of Items Allowed</td>
                                    <td>{!! is_array($trip->type_of_item) ? implode(', ', $trip->type_of_item) : $trip->type_of_item !!}</td>
                                </tr>
                                <tr>
                                    <td>Packaging Requirements</td>
                                    <td>{{ $trip->packaging_requirement }}</td>
                                </tr>
                                <tr>
                                    <td>Handling Instructions</td>
                                    <td>{{ $trip->handling_instruction }}</td>
                                </tr>
                                <tr>
                                    <td>Note</td>
                                    <td>{{ $trip->note }}</td>
                                </tr>
                                @if(Auth::user()->hasRole('admin'))
                                    <tr>
                                        <td>Admin Note</td>
                                        <td>{{ $trip->admin_note }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td>Price</td>
                                    <td>{{ getPrice($trip->price, $trip->currency) }}</td>
                                </tr>
{{--                                @if($trip->photo)--}}
{{--                                    <tr>--}}
{{--                                        <td class="align-top">Photo</td>--}}
{{--                                        <td>--}}
{{--                                            <x-photo :file="$trip->photo" :title="'Photo'" :name="'photo'" :show="true" :upload="false" />--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                @endif--}}
                                <tr>
                                    <td>Status</td>
                                    <td>
                                        @if($trip->status === 'Active')
                                            <x-status :content="$trip->status" :type="'info'" />
                                        @elseif($trip->status === 'Confirmed')
                                            <x-status :content="$trip->status" :type="'success'" />
                                        @elseif($trip->status === 'In Progress')
                                            <x-status :content="$trip->status" :type="'warning'" />
                                        @elseif($trip->status === 'Completed')
                                            <x-status :content="$trip->status" :type="'success'" />
                                        @elseif($trip->status === 'Cancelled')
                                            <x-status :content="$trip->status" :type="'danger'" />
                                        @endif
                                    </td>
                                </tr>
                            </table>
                            <div class="flex gap-3">
                                <a class="btn-primary" href="{{ route('trip.edit', $trip->id) }}">Edit</a>
                                <a class="btn-secondary" href="{{ route('trip.index') }}">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</x-app-layout>
