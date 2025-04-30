<x-app-layout>
    <x-slot name="header" class="flex">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Booking Details') }}
            </h2>
            <a class="btn-secondary" href="{{ route('booking.index') }}">Back</a>
        </div>
    </x-slot>
    <div x-data="booking" class="py-12">
        <div class="container">
            <div class="flex gap-8">
                <div class="w-1/4">
                    <x-booking-sidebar />
                </div>
                <div class="w-3/4">
                    <x-trip :trip="$booking->trip" />
                    <div class="bg-white border border-gray-50 rounded shadow p-4">
                        <h3 class="heading-5 mb-4 heading-title">Booking Details</h3>
                        <table class="w-full table mb-8 whitespace-nowrap">
                            <tr>
                                <th class="w-64">Tracking Number</th>
                                <td>
                                    <div class="flex items-center gap-5">
                                        {{ $booking->tracking_number }}
                                        <a target="_blank" href="{{ route('tracking', '?trackingNumber=' . $booking->tracking_number) }}" class="btn-secondary">
                                            Tracking Details
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @if($package_products && count($package_products) > 0)
                                <tr>
                                    <th class="w-64">In Package Products</th>
                                    <td>
                                        <div class="flex flex-col">
                                            <table class="table bg-white text-sm text-gray-600">
                                                <tr>
                                                    <th class="w-6/12 border-0">Name</th>
                                                    <th class="w-3/12 border-0">Type</th>
                                                    <th class="w-3/12 !text-end">Qty</th>
                                                </tr>
                                                @foreach($package_products as $product)
                                                    <tr class="!bg-white">
                                                        <td>
                                                            <label for="product_{{ $product['id'] }}" class="flex items-center">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-primary">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                                                                </svg>
                                                                <span class="ms-1 text-sm text-gray-600">{{ $product['name'] }}</span>
                                                            </label>
                                                        </td>
                                                        <td>
                                                            {{ $product->type }}
                                                        </td>
                                                        <td class="!text-end">
                                                            {{ $product->quantity }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                            @if($condition_details)
                                                <div class="text-sm font-semibold mt-4">Details</div>
                                                <div class="text-sm text-gray-600">{{ $condition_details }}</div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <th class="w-64">Booked By</th>
                                <td>
                                    <div class="flex flex-col gap-2">
                                        <div class="flex gap-1 items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-primary">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                            </svg>
                                            {{ $booking->user->name }}
                                        </div>
                                        <div class="flex gap-1 items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 text-primary">
                                                <path d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                                                <path d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
                                            </svg>
                                            {{ $booking->user->email }}
                                        </div>
                                        <div class="flex gap-1 items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-primary">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                            </svg>
                                            {{ $booking->user->phone }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="w-64">Sender Details</th>
                                <td>
                                    <div class="flex flex-col gap-2">
                                        <div class="flex gap-1 items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-primary">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                            </svg>
                                            {{ $booking->sender_name }}
                                        </div>
                                        <div class="flex gap-1 items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 text-primary">
                                                <path d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                                                <path d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
                                            </svg>
                                            {{ $booking->sender_email }}
                                        </div>
                                        <div class="flex gap-1 items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-primary">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                            </svg>
                                            {{ $booking->sender_phone }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Collection Type</th>
                                <td>
                                    {{ $booking->collection_type }}
                                </td>
                            </tr>
                            @if($booking->collection_type == 'Collect from Address')
                                <tr>
                                    <th>Pickup Address</th>
                                    <td>
                                        <div class="flex flex-col gap-2">
                                            <div class="flex gap-1 items-center">
                                                <span class="font-medium">Address:</span>
                                                {{ $booking->pickup_address_1 }}
                                                {{ $booking->pickup_address_2 ? ', '. $booking->pickup_address_2 : '' }}
                                            </div>
                                            <div class="flex gap-1 items-center">
                                                <span class="font-medium">Country:</span>
                                                {{ $booking->pickupCountry->name ?? '' }}
                                            </div>
                                            <div class="flex gap-1 items-center">
                                                <span class="font-medium">State:</span>
                                                {{ $booking->pickupState->name ?? '' }}
                                            </div>
                                            <div class="flex gap-1 items-center">
                                                <span class="font-medium">City:</span>
                                                {{ $booking->pickup_city }}
                                            </div>
                                            <div class="flex gap-1 items-center">
                                                <span class="font-medium">Postcode:</span>
                                                {{ $booking->pickup_postcode }}
                                            </div>
                                            <div class="flex gap-1 items-center">
                                                <span class="font-medium">Location Type:</span>
                                                {{ $booking->pickup_location_type }}
                                            </div>
                                            <div class="flex gap-1 items-center">
                                                <span class="font-medium">Date:</span>
                                                {{ getDateFormat($booking->pickup_date) }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <th>Receiver Details</th>
                                <td>
                                    <div class="flex flex-col gap-2">
                                        <div class="flex gap-1 items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-primary">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                            </svg>
                                            {{ $booking->receiver_name }}
                                        </div>
                                        <div class="flex gap-1 items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 text-primary">
                                                <path d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                                                <path d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
                                            </svg>
                                            {{ $booking->receiver_email }}
                                        </div>
                                        <div class="flex gap-1 items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-primary">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                            </svg>
                                            {{ $booking->receiver_phone }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Delivery Address</th>
                                <td>
                                    <div class="flex flex-col gap-2">
                                        <div class="flex gap-1 items-center">
                                            <span class="font-medium">Address:</span>
                                            {{ $booking->delivery_address_1 }}
                                            {{ $booking->delivery_address_2 ? ', '. $booking->delivery_address_2 : '' }}
                                        </div>
                                        <div class="flex gap-1 items-center">
                                            <span class="font-medium">Country:</span>
                                            {{ $booking->deliveryCountry->name ?? '' }}
                                        </div>
                                        <div class="flex gap-1 items-center">
                                            <span class="font-medium">State:</span>
                                            {{ $booking->deliveryState->name ?? '' }}
                                        </div>
                                        <div class="flex gap-1 items-center">
                                            <span class="font-medium">City:</span>
                                            {{ $booking->delivery_city }}
                                        </div>
                                        <div class="flex gap-1 items-center">
                                            <span class="font-medium">Postcode:</span>
                                            {{ $booking->delivery_postcode }}
                                        </div>
                                        <div class="flex gap-1 items-center">
                                            <span class="font-medium">Location Type:</span>
                                            {{ $booking->delivery_location_type }}
                                        </div>
                                        <div class="flex gap-1 items-center">
                                            <span class="font-medium">Date:</span>
                                            {{ getDateFormat($booking->delivery_date) }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Note</th>
                                <td>{{ $booking->note }}</td>
                            </tr>
                            @if(!auth()->user()->hasRole('admin') || auth()->user()->id != $booking->trip->user_id)
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($booking->status === 'Pending')
                                            <x-status :content="$booking->status" :type="'info'" />
                                        @elseif($booking->status === 'Booked')
                                            <x-status :content="$booking->status" :type="'success'" />
                                        @elseif($booking->status === 'Rejected')
                                            <x-status :content="$booking->status" :type="'danger'" />
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        </table>

                        @if(auth()->user()->hasRole('admin') || auth()->user()->id === $booking->trip->user_id)
                            <form id="update" method="POST" @submit.prevent="updateBooking">
                                @csrf
                                @method('PUT')
                                <table class="w-full table mb-4 whitespace-nowrap">
                                    <tr>
                                        <th class="w-64">Admin Note</th>
                                        <td>
                                            <textarea rows="5" name="admin_note" id="admin_note" class="form-input">{{ $booking->admin_note }}</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            <x-input-dropdown class="status !w-64" name="status" :options="$booking_status" :selected="[$booking->status]"/>
                                        </td>
                                    </tr>
                                </table>
                                <div class="flex justify-end">
                                    <button class="btn-primary mb-5">Update</button>
                                </div>
                            </form>
                        @endif
                        <h3 class="heading-5 mb-4 heading-title">Product Information</h3>
                        <table class="w-full mb-8 whitespace-nowrap">
                            @forelse($booking->products as $product)
                                <div class="border-b py-5">
                                    <h5 class="heading-5 mb-4">Product {{ $loop->iteration }}</h5>
                                    <div class="flex">
                                        <div class="flex gap-2 flex-col w-full sm:w-1/2">
                                            <p><span class="font-medium">Name:</span> {{ $product->name }}</p>
                                            <p><span class="font-medium">Type:</span> {{ $product->type }}</p>
                                            <p><span class="font-medium">Quantity:</span> {{ $product->quantity }}</p>
                                            <p><span class="font-medium">Weight:</span> {{ $product->weight. ' '. $product->weight_type }}</p>
                                            <p><span class="font-medium">Length (cm):</span> {{ $product->length }}</p>
                                            <p><span class="font-medium">Width (cm):</span> {{ $product->width }}</p>
                                            <p><span class="font-medium">Height (cm):</span> {{ $product->height }}</p>
                                        </div>
                                        <div class="flex gap-2 flex-col w-full sm:w-1/2">
                                            <p><span class="font-medium">Box:</span> {{ $product->box }}</p>
                                            <p><span class="font-medium">Fragile:</span> {{ $product->fragile }}</p>
                                            <p><span class="font-medium">Insurance:</span> {{ $product->insurance }}</p>
                                            <p><span class="font-medium">Urgent:</span> {{ $product->urgent }}</p>
                                        </div>
                                    </div>
                                    <p><span class="font-medium">Note:</span> {{ $product->note }}</p>
                                    <div class="flex gap-3 my-4">
                                        @foreach($product->photos as $photo)
                                            <a href="{{ Storage::disk('public')->url($photo->photo_path) }}" data-lightbox="photo">
                                                <img src="{{ Storage::disk('public')->url($photo->photo_path) }}" alt="{{ $product->name }}" class="w-24 h-24 object-cover border p-1 rounded-lg">
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @empty
                                <tr class="bg-gray-100 align-top hover:bg-primary hover:bg-opacity-20 transition duration-200">
                                    <td colspan="10" class="text-center py-4">
                                        <div class="not-found">Data Not Found!!</div>
                                    </td>
                                </tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('booking', () => ({

                    updateBooking: function () {
                        const formData = new FormData(document.getElementById('update'));
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
                            url    : route('booking.update', {{ $booking->id }}),
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
                                window.location.href = route('booking.show', {{ $booking->id }});
                            })
                            .catch(error => {
                                window.showJsonErrorMessage(error);
                            });
                    },

                }));
            });

            {{--$(document).on('change', '.status', function () {--}}
            {{--    let status = $(this).val();--}}

            {{--    Swal.fire({--}}
            {{--        title: 'Are you sure?',--}}
            {{--        text: 'Do you want to change the booking status?',--}}
            {{--        icon: 'warning',--}}
            {{--        showCancelButton: true,--}}
            {{--        confirmButtonText: 'Yes, update it!',--}}
            {{--        cancelButtonText: 'Cancel'--}}
            {{--    }).then((result) => {--}}
            {{--        if (result.isConfirmed) {--}}
            {{--            $.ajax({--}}
            {{--                url: '{{ route('booking.update', $booking->id ) }}',--}}
            {{--                type: 'POST',--}}
            {{--                data: {--}}
            {{--                    booking_id: bookingId,--}}
            {{--                    status: status,--}}
            {{--                    _token: "{{ csrf_token() }}"--}}
            {{--                },--}}
            {{--                success: function(response) {--}}
            {{--                    Swal.fire({--}}
            {{--                        title: 'Updated!',--}}
            {{--                        text: 'Booking status has been updated.',--}}
            {{--                        icon: 'success',--}}
            {{--                        timer: 2000,--}}
            {{--                        showConfirmButton: false--}}
            {{--                    });--}}
            {{--                },--}}
            {{--                error: function() {--}}
            {{--                    Swal.fire({--}}
            {{--                        title: 'Error!',--}}
            {{--                        text: 'Failed to update the booking status.',--}}
            {{--                        icon: 'error'--}}
            {{--                    });--}}
            {{--                }--}}
            {{--            });--}}
            {{--        }--}}
            {{--    });--}}
            {{--});--}}

        </script>
    @endpush
</x-app-layout>
