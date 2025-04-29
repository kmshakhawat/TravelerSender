<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Order') }}
        </h2>
    </x-slot>

    <div x-data="travel" class="py-12">
        <div class="container">
            <div class="bg-white border border-gray-50 rounded shadow p-4">
                <div class="overflow-auto">
                    <table class="w-full table whitespace-nowrap">
                        <thead class="bg-secondary text-gray-100 font-bold">
                        <td class="py-2 pl-2">
                            Trip
                        </td>
                        <td class="py-2 pl-2">
                            Tracking Number
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
                            Status
                        </td>
                        <td class="py-2 pl-2">
                            Tracking
                        </td>
                        <td class="py-2 pl-2">
                            Created At
                        </td>
                        <td class="py-2 pl-2 flex justify-end">
                            Action
                        </td>
                        </thead>
                        <tbody class="text-sm">
                        @forelse($orders as $order)
                            <tr>
                                <td class="py-3 pl-2">
                                    <div class="flex flex-col">
                                        <a class="flex items-center gap-2" href="{{ route('trip.show', $order->trip->id) }}">
                                            {{ $order->trip->fromCountry->name ?? '' }} {{ $order->trip->from_city ? '('. $order->trip->from_city .')' : '' }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-right">
                                                <path d="M18 8L22 12L18 16"/>
                                                <path d="M2 12H22"/>
                                            </svg>
                                            {{ $order->trip->toCountry->name ?? '' }} {{ $order->trip->to_city ? '('. $order->trip->to_city .')' : '' }}
                                        </a>
                                        <div class="text-xs text-gray-500">{{ getDateFormat($order->trip->departure_date) }} to {{ getDateFormat($order->trip->arrival_date) }}</div>
                                    </div>
                                </td>
                                <td class="py-3 pl-2">
                                    {{ $order->tracking_number }}
                                </td>
                                <td class="py-3 pl-2">
                                    <div class="flex flex-col">
                                        <a href="{{ route('order.show', $order->id) }}" class="flex gap-1 items-center">
{{--                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-secondary">--}}
{{--                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />--}}
{{--                                            </svg>--}}
                                            {{ $order->sender_name }}
                                        </a>
{{--                                        <a href="{{ route('order.show', $order->id) }}" class="flex gap-1 items-center">--}}
{{--                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-secondary">--}}
{{--                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />--}}
{{--                                            </svg>--}}
{{--                                            {{ $order->sender_email }}--}}
{{--                                        </a>--}}
{{--                                        <a href="{{ route('order.show', $order->id) }}" class="flex gap-1 items-center">--}}
{{--                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-secondary">--}}
{{--                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />--}}
{{--                                            </svg>--}}
{{--                                            {{ $order->sender_phone }}--}}
{{--                                        </a>--}}
                                    </div>
                                </td>
                                <td class="py-3 pl-2">
                                    {{ $order->collection_type }}
                                    @if($order->pickup_location)
                                        <div class="flex flex-col">
                                            <a href="{{ route('order.show', $order->id) }}" class="flex gap-1 items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-secondary">
                                                    <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
                                                </svg>
                                                {{ $order->pickup_location }}
                                            </a>
                                            <a href="{{ route('order.show', $order->id) }}" class="flex gap-1 items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-secondary">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                                </svg>
                                                {{ $order->pickup_date }}
                                            </a>
                                        </div>
                                    @endif
                                </td>
                                <td class="py-3 pl-2">
                                    <div class="flex flex-col">
                                        <a href="{{ route('order.show', $order->id) }}" class="flex gap-1 items-center">
{{--                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-secondary">--}}
{{--                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />--}}
{{--                                            </svg>--}}
                                            {{ $order->receiver_name }}
                                        </a>
{{--                                        <a href="{{ route('order.show', $order->id) }}" class="flex gap-1 items-center">--}}
{{--                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-secondary">--}}
{{--                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />--}}
{{--                                            </svg>--}}
{{--                                            {{ $order->receiver_email }}--}}
{{--                                        </a>--}}
{{--                                        <a href="{{ route('order.show', $order->id) }}" class="flex gap-1 items-center">--}}
{{--                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-secondary">--}}
{{--                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />--}}
{{--                                            </svg>--}}
{{--                                            {{ $order->receiver_phone }}--}}
{{--                                        </a>--}}
                                    </div>
                                </td>

                                <td class="py-3 pl-2">
                                    <a href="{{ route('order.show', $order->id) }}">
                                        @if($order->status === 'Pending')
                                            <x-status :content="$order->status" :type="'info'" />
                                        @elseif($order->status === 'Booked')
                                            <x-status :content="$order->status" :type="'success'" />
                                        @elseif($order->status === 'Cancelled')
                                            <x-status :content="$order->status" :type="'danger'" />
                                        @elseif($order->status === 'Completed')
                                            <x-status :content="$order->status" :type="'verified'" />
                                        @endif
                                    </a>
                                </td>
                                <td class="py-3 pl-2">
                                    @if($order->latestTracking)
                                        <button @click.prevent="editTracking({{ $order->latestTracking->id }})" class="btn-secondary">
                                           {{ $order->latestTracking->status }}
                                        </button>
                                    @endif
                                </td>
                                <td class="py-3 pl-2">
                                    <a class="flex flex-col" href="{{ route('order.show', $order->id) }}">
                                        <span>{{ $order->created_at->diffForHumans() }}</span>
                                        {{ getDateFormat($order->created_at) }}
                                    </a>
                                </td>
                                <td class="py-3 pl-2">
                                    <div class="flex items-center justify-end space-x-3">

                                        @if($order->latestTracking && $order->latestTracking->status != 'Delivered')
                                            @if ($order->latestTracking && in_array($order->latestTracking->status, ['Processing', 'Ready for Pickup', 'Delivered']))
                                                <button @click.prevent="bookingPickup({{ $order->id }})" class="!flex gap-1 btn-secondary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                         stroke="currentColor" class="h-5 w-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                                                    </svg>
                                                    Pickup
                                                </button>
                                            @endif
                                            @if ($order->latestTracking && !in_array($order->latestTracking->status, ['Processing', 'Ready for Pickup', 'Delivered']))
                                                <button @click.prevent="bookingDelivery({{ $order->id }})" class="!flex gap-1 btn-secondary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                         stroke="currentColor" class="h-5 w-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                                                    </svg>
                                                    Delivery
                                                </button>
                                            @endif
                                        @endif
                                        <a class="!flex gap-1 btn-primary" href="{{ route('order.show', $order->id) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                 stroke="currentColor" class="h-5 w-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                            </svg>
                                            Details
                                        </a>
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
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>



    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('travel', () => ({
                    editTracking     : function (order) {
                        axios.get(route('tracking.edit', order))
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
