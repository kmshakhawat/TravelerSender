<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Booking List') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="container">
            <div class="bg-white border border-gray-50 rounded shadow p-4">
                <div class="overflow-auto">
                    <table class="w-full table whitespace-nowrap">
                        <thead class="bg-secondary text-gray-100 font-bold">
                        <td class="py-2 pl-2">
                            User
                        </td>
                        <td class="py-2 pl-2">
                            Trip
                        </td>
                        <td class="py-2 pl-2">
                            Sender
                        </td>
                        <td class="py-2 pl-2">
                            Pickup
                        </td>
                        <td class="py-2 pl-2">
                            Receiver
                        </td>
                        <td class="py-2 pl-2">
                            Tracking
                        </td>
                        <td class="py-2 pl-2">
                            Payment
                        </td>
                        <td class="py-2 pl-2">
                            Created At
                        </td>
                        <td class="py-2 pl-2 flex justify-end">
                            Action
                        </td>
                        </thead>
                        <tbody class="text-sm">
                        @forelse($bookings as $booking)
                            <tr>
                                @if(Auth::user()->hasRole('admin'))
                                    <td class="py-3 pl-2">
                                        <img class="size-10 rounded-full object-cover" src="{{ $booking->trip->user->profile_photo_url ?: 'https://ui-avatars.com/api/?name='.urlencode($booking->trip->user->name).'&color=7F9CF5&background=EBF4FF' }}" alt="{{ $booking->trip->user->name }}" title="{{ $booking->trip->user->name }}" />
                                    </td>
                                @endif
                                <td class="py-3 pl-2">
                                    <div class="flex flex-col">
                                        <a class="flex items-center gap-2" href="{{ route('trip.show', $booking->trip->id) }}">
                                            {{ $booking->trip->fromCity?->name ? $booking->trip->fromCity?->name .', ' : '' }} {{ $booking->trip->fromCountry->name ?? '' }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-right">
                                                <path d="M18 8L22 12L18 16"/>
                                                <path d="M2 12H22"/>
                                            </svg>
                                            {{ $booking->trip->toCity?->name ? $booking->trip->toCity?->name .', ' : '' }} {{ $booking->trip->toCountry->name ?? '' }}
                                            @if($booking->status === 'Pending')
                                                <x-status :content="$booking->status" :type="'info'" class="px-[4px] py-[2px] -mt-2 -ms-1" />
                                            @elseif($booking->status === 'Booked')
                                                <x-status :content="$booking->status" :type="'success'" class="px-[4px] py-[2px] -mt-2 -ms-1" />
                                            @elseif($booking->status === 'Cancelled')
                                                <x-status :content="$booking->status" :type="'danger'" class="px-[4px] py-[2px] -mt-2 -ms-1" />
                                            @elseif($booking->status === 'Completed')
                                                <x-status :content="$booking->status" :type="'verified'" class="px-[4px] py-[2px] -mt-2 -ms-1" />
                                            @endif
                                        </a>
                                        <div class="text-xs text-gray-500">{{ getDateFormat($booking->trip->departure_date) }} to {{ getDateFormat($booking->trip->arrival_date) }}</div>
                                        @if($booking->tracking_number)
                                            <div class="mt-1 text-[#E68C85]">
                                                Tracking Number:
                                                <a target="_blank" class="text-[#E68C85] hover:underline" href="{{ route('tracking', '?trackingNumber=' . $booking->tracking_number) }}">
                                                    {{ $booking->tracking_number }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 pl-25">
                                    <div class="flex flex-col">
                                        <a href="{{ route('booking.show', $booking->id) }}" class="flex gap-1 items-center">
                                            {{ $booking->sender_name }}
                                        </a>
                                    </div>
                                </td>
                                <td class="py-3 pl-2">
                                    {{ $booking->collection_type }}
                                    @if($booking->pickup_location)
                                    <div class="flex flex-col">
                                        <a href="{{ route('booking.show', $booking->id) }}" class="flex gap-1 items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-secondary">
                                                <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $booking->pickup_location }}
                                        </a>
                                        <a href="{{ route('booking.show', $booking->id) }}" class="flex gap-1 items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-secondary">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                            </svg>
                                            {{ $booking->pickup_date }}
                                        </a>
                                    </div>
                                    @endif
                                </td>
                                <td class="py-3 pl-2">
                                    <div class="flex flex-col">
                                        <a href="{{ route('booking.show', $booking->id) }}" class="flex gap-1 items-center">
                                            {{ $booking->receiver_name }}
                                        </a>
                                    </div>
                                </td>
                                <td class="py-3 pl-2">
                                    @if($booking->latestTracking)
                                        <a target="_blank" class="btn-secondary !inline-flex gap-2" href="{{ route('tracking', '?trackingNumber=' . $booking->tracking_number) }}">
                                            {{ $booking->latestTracking->status ?? '' }}
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                            </svg>
                                        </a>
                                    @endif
                                </td>
                                <td class="py-3 pl-2">
                                    @if($booking->payment && $booking->payment->payment_status === 'paid')
                                        <x-status :content="ucfirst($booking->payment->payment_status)" :type="'success'" />
                                    @elseif($booking->payment && $booking->payment->payment_status === 'failed')
                                        <x-status :content="ucfirst($booking->payment->payment_status)" :type="'danger'" />
                                    @endif
                                </td>
                                <td class="py-3 pl-2">
                                    <a class="flex flex-col" href="{{ route('booking.show', $booking->id) }}">
                                        <span>{{ $booking->created_at->diffForHumans() }}</span>
                                        {{ getDateFormat($booking->created_at) }}
                                    </a>
                                </td>
                                <td class="py-3 pl-2">
                                    <div class="flex items-center justify-end space-x-3">
                                        @if($booking->latestTracking && $booking->latestTracking->status === 'Delivered')
                                            @if(!$booking->rating)
                                                <a class="!flex gap-1 btn-secondary" href="{{ route('rating.create', $booking->id) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                         stroke="currentColor" class="size-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                                    </svg>
                                                    Review
                                                </a>
                                            @endif
                                        @endif

                                        <a class="flex gap-1 bg-primary text-white px-3 py-2 rounded" href="{{ route('booking.show', $booking->id) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                 stroke="currentColor" class="size-4 text-white">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                            </svg>
                                            Details
                                        </a>
{{--                                        <a href="{{ route('booking.edit', $booking->id) }}">--}}
{{--                                            <svg xmlns="http://www.w3.org/2000/svg"--}}
{{--                                                 class="h-5 w-5 text-yellow-500 hover:text-yellow-600" fill="none" viewBox="0 0 24 24"--}}
{{--                                                 stroke="currentColor">--}}
{{--                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
{{--                                                      d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>--}}
{{--                                            </svg>--}}
{{--                                        </a>--}}
{{--                                        <button type="button" @click.prevent="userDelete({{ $booking->id }})">--}}
{{--                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 hover:text-red-600"--}}
{{--                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
{{--                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
{{--                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>--}}
{{--                                            </svg>--}}
{{--                                        </button>--}}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-gray-100 align-top hover:bg-primary hover:bg-opacity-20 transition duration-200">
                                <td colspan="10" class="text-center py-4">
                                    <div class="not-found">Data Not Found!!</div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">
                    {{ $bookings->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('travel', () => ({
                    cancelBooking     : function (booking) {
                        axios.get(route('booking.cancel', booking))
                            .then(response => {
                                this.$nextTick(() => {
                                    flatpickr(".datepicker", {
                                        altInput: true,
                                        altFormat: "F j, Y",
                                        dateFormat: "Y-m-d",
                                    });
                                });
                                this.$store.app.showModal       = true;
                                this.$refs.modalContent.innerHTML = response.data.edit;
                            })
                            .catch(error => {
                                console.log(error);
                            });
                    },
                    updateTracking    : function () {
                        Swal.fire({
                            title            : 'Updating...',
                            allowOutsideClick: true,
                            icon             : 'info',
                            didOpen          : () => {
                                Swal.showLoading();
                            }
                        });
                        axios({
                            method : 'POST',
                            url    : route('tracking.store'),
                            data   : new FormData(this.$refs.trackingForm),
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
                                this.$store.app.showModal = false;
                                location.reload();
                            })
                            .catch(error => {
                                window.showJsonErrorMessage(error);
                            });
                    },
                    bookingPickup     : function (booking) {
                        axios.get(route('booking.pickup', booking))
                            .then(response => {
                                this.$nextTick(() => {
                                    flatpickr(".datepicker", {
                                        altInput: true,
                                        altFormat: "F j, Y",
                                        dateFormat: "Y-m-d",
                                    });
                                });
                                this.$store.app.showModal       = true;
                                this.$refs.modalContent.innerHTML = response.data.pickup;
                            })
                            .catch(error => {
                                console.log(error);
                            });
                    },
                    pickupVerify    : function (booking) {
                        Swal.fire({
                            title            : 'Updating...',
                            allowOutsideClick: true,
                            icon             : 'info',
                            didOpen          : () => {
                                Swal.showLoading();
                            }
                        });
                        axios({
                            method : 'POST',
                            url    : route('booking.pickup-otp', booking),
                            data   : new FormData(this.$refs.pickupForm),
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
                                this.$store.app.showModal = false;
                                setTimeout(() => {
                                    location.reload();
                                }, 2000);
                            })
                            .catch(error => {
                                window.showJsonErrorMessage(error);
                            });
                    },
                    resendOTP: function(booking, type) {
                        Swal.fire({
                            title: 'Resending OTP...',
                            allowOutsideClick: true,
                            icon: 'info',
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        let formData = new FormData();
                        formData.append('type', type);

                        axios({
                            method: 'POST',
                            url: route('booking.resend-otp', booking),
                            data: formData,
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
                            })
                            .catch(error => {
                                window.showJsonErrorMessage(error);
                            });
                    },
                    bookingDelivery     : function (booking) {
                        axios.get(route('booking.delivery', booking))
                            .then(response => {
                                this.$nextTick(() => {
                                    flatpickr(".datepicker", {
                                        altInput: true,
                                        altFormat: "F j, Y",
                                        dateFormat: "Y-m-d",
                                    });
                                });
                                this.$store.app.showModal       = true;
                                this.$refs.modalContent.innerHTML = response.data.delivery;
                            })
                            .catch(error => {
                                console.log(error);
                            });
                    },
                    deliveryVerify   : function (booking) {
                        Swal.fire({
                            title            : 'Updating...',
                            allowOutsideClick: true,
                            icon             : 'info',
                            didOpen          : () => {
                                Swal.showLoading();
                            }
                        });
                        axios({
                            method : 'POST',
                            url    : route('booking.delivery-otp', booking),
                            data   : new FormData(this.$refs.deliveryForm),
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
                                this.$store.app.showModal = false;
                                setTimeout(() => {
                                    location.reload();
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
