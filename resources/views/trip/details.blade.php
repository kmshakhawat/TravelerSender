<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Details') }}
            </h2>
            <a class="btn-secondary" href="{{ route('trip.search') }}">Back</a>
        </div>
    </x-slot>
    <div x-data="trip" class="py-12">
        <div class="container">
            <div class="flex flex-col lg:flex-row gap-8">
                <div class="w-full lg:w-2/3">
{{--                    <img class="rounded w-full " src="{{ $trip->photo ? Storage::disk('public')->url($trip->photo) : 'https://ui-avatars.com/api/?name='.urlencode($trip->user->name).'&color=7F9CF5&background=EBF4FF' }}" alt="{{ $trip->user->name }}">--}}
                    <div class="bg-white border border-gray-50 mb-8 rounded shadow p-4">
                        <div class="table-responsive">
                            <table class="w-full table mb-8 whitespace-nowrap">
                                <tr>
                                    <td>Trip Type</td>
                                    <td>{{ $trip->trip_type }}</td>
                                </tr>
                                <tr>
                                    <td>Mode of Transport</td>
                                    <td>{{ $trip->mode_of_transport }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5 class="heading-5">From</h5>
                                    </td>
                                    <td>
                                        <div class="flex flex-col gap-2">
                                            <div class="flex gap-1 items-center">
                                                <span class="font-medium">Address:</span>
                                                {{ $trip->from_address_1 }}
                                                {{ $trip->from_address_2 ? ', '. $trip->from_address_2 : '' }}
                                            </div>
                                            <div class="flex gap-1 items-center">
                                                <span class="font-medium">Country:</span>
                                                {{ $trip->fromCountry->name ?? '' }}
                                            </div>
                                            <div class="flex gap-1 items-center">
                                                <span class="font-medium">State:</span>
                                                {{ $trip->fromState->name ?? '' }}
                                            </div>
                                            <div class="flex gap-1 items-center">
                                                <span class="font-medium">City:</span>
                                                {{ $trip->from_city }}
                                            </div>
                                            <div class="flex gap-1 items-center">
                                                <span class="font-medium">Postcode:</span>
                                                {{ $trip->from_postcode }}
                                            </div>
                                            <div class="flex gap-1 items-center">
                                                <span class="font-medium">Phone:</span>
                                                {{ $trip->from_phone }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5 class="heading-5">To</h5>
                                    </td>
                                    <td>
                                        <div class="flex flex-col gap-2">
                                            <div class="flex gap-1 items-center">
                                                <span class="font-medium">Address:</span>
                                                {{ $trip->to_address_1 }}
                                                {{ $trip->to_address_2 ? ', '. $trip->to_address_2 : '' }}
                                            </div>
                                            <div class="flex gap-1 items-center">
                                                <span class="font-medium">Country:</span>
                                                {{ $trip->toCountry->name ?? '' }}
                                            </div>
                                            <div class="flex gap-1 items-center">
                                                <span class="font-medium">State:</span>
                                                {{ $trip->toState->name ?? '' }}
                                            </div>
                                            <div class="flex gap-1 items-center">
                                                <span class="font-medium">City:</span>
                                                {{ $trip->to_city }}
                                            </div>
                                            <div class="flex gap-1 items-center">
                                                <span class="font-medium">Postcode:</span>
                                                {{ $trip->to_postcode }}
                                            </div>
                                            <div class="flex gap-1 items-center">
                                                <span class="font-medium">Phone:</span>
                                                {{ $trip->to_phone }}
                                            </div>
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
                                        <td class="align-top">Stopovers</td>
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
                                        <h3 class="heading-5">Luggage & Courier Details</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Available Space/Weight Limit (in kg/lbs)</td>
                                    <td>{{ $trip->available_space . ' ' . $trip->weight_unit }}</td>
                                </tr>
                                <tr>
                                    <td>Type of Items Allowed</td>
                                    <td>{{ $trip->type_of_item }}</td>
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
                            </table>
                        </div>
                    </div>
                </div>
                <div class="w-full lg:w-1/3">
                    <div class="bg-white border border-gray-50 rounded shadow p-4">
                        <div class="overflow-auto">
                            <div class="rounded-full w-40 h-40 ring-2 my-2 ring-primary mx-auto overflow-hidden flex items-center justify-center ">
                                <img id="profilePhoto" src="{{ $trip->user->profile_photo_url ?: 'https://ui-avatars.com/api/?name='.urlencode($trip->user->name).'&color=7F9CF5&background=EBF4FF' }}" alt="{{ $trip->user->name }}" class="max-h-40">
                            </div>
                            <div class="font-medium text-center text-xl">{{ $trip->user->name }}</div>
                            <div class="flex gap-1 font-medium items-center justify-center text-lg mb-8">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 fill-primary">
                                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                                </svg>
                                {{ $trip->user->averageRating() }} rating
                            </div>
                            <div class="flex justify-between items-center py-3 border-t border-gray-100">
                                Price:
                                <span class="price">{{ getPrice($trip->price, $trip->currency) }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-t border-gray-100">
                                Departure Date:
                                <span>{{  getDateFormat($trip->departure_date) }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-t border-gray-100">
                                Arrival Date:
                                <span>{{  getDateFormat($trip->arrival_date) }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-t border-gray-100">
                                Available Space (in kg/lbs):
                                <span>{{ $trip->available_space . ' ' . $trip->weight_unit }}</span>
                            </div>
                            <div class="flex gap-4 mt-8">
                                @if(Auth::user()->id != $trip->user_id && $trip->status === 'Active')
                                    <a class="btn-primary"
                                       @if(Auth::user()->verified)
                                           href="{{ route('booking', $trip->id) }}"
                                       @else
                                           @click.prevent="verifiedAlert"
                                        @endif
                                    >
                                        Send my Parcel
                                    </a>
                                @endif
                                <a class="btn-secondary"
                                   @if(Auth::user()->verified)
                                       href="{{ route('message', $trip->user_id) }}"
                                   @else
                                       @click.prevent="verifiedAlert"
                                    @endif
                                >
                                    Contact
                                </a>
                            </div>
                        </div>
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
