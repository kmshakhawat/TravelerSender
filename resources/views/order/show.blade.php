<x-app-layout>
    <x-slot name="header" class="flex">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Order Details') }}
            </h2>
            <a class="btn-secondary" href="{{ route('order.index') }}">Back</a>
        </div>
    </x-slot>
    <div x-data="order" class="py-12">
        <div class="container">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white border border-gray-50 rounded shadow p-4 mb-8">
                    <h3 class="heading-5 mb-4 heading-title">Order Details</h3>
                    <table class="w-full table mb-8 whitespace-nowrap">
                        <tr>
                            <th class="w-64">Reference</th>
                            <td>
                                <div class="flex items-center gap-5">
                                    {{ $order->tracking_number }}
                                    <a target="_blank" href="{{ route('tracking', '?trackingNumber=' . $order->tracking_number) }}" class="btn-secondary">
                                        Tracking Details
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="w-64">Order By</th>
                            <td>
                                <div class="flex flex-col gap-2">
                                    <div class="flex gap-1 items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-primary">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                        {{ $order->user->name }}
                                    </div>
                                    <div class="flex gap-1 items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 text-primary">
                                            <path d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                                            <path d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
                                        </svg>
                                        {{ $order->user->email }}
                                    </div>
                                    <div class="flex gap-1 items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-primary">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                        </svg>
                                        {{ $order->user->phone }}
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
                                        {{ $order->sender_name }}
                                    </div>
                                    <div class="flex gap-1 items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 text-primary">
                                            <path d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                                            <path d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
                                        </svg>
                                        {{ $order->sender_email }}
                                    </div>
                                    <div class="flex gap-1 items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-primary">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                        </svg>
                                        {{ $order->sender_phone }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Collection Type</th>
                            <td>
                                {{ $order->collection_type }}
                            </td>
                        </tr>
                        @if($order->pickup_location)
                            <tr>
                                <th>Pickup</th>
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
                                        {{ $order->receiver_name }}
                                    </div>
                                    <div class="flex gap-1 items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 text-primary">
                                            <path d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                                            <path d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
                                        </svg>
                                        {{ $order->receiver_email }}
                                    </div>
                                    <div class="flex gap-1 items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-primary">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                        </svg>
                                        {{ $order->receiver_phone }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Delivery</th>
                            <td>
                                <div class="flex flex-col gap-2">
                                    <div class="flex gap-1 items-center">
                                        <span class="font-medium">Address:</span>
                                        {{ $order->delivery_address_1 }}
                                        {{ $order->delivery_address_2 ? ', '. $order->delivery_address_2 : '' }}
                                    </div>
                                    <div class="flex gap-1 items-center">
                                        <span class="font-medium">Country:</span>
                                        {{ $order->deliveryCountry->name ?? '' }}
                                    </div>
                                    <div class="flex gap-1 items-center">
                                        <span class="font-medium">State:</span>
                                        {{ $order->deliveryState->name ?? '' }}
                                    </div>
                                    <div class="flex gap-1 items-center">
                                        <span class="font-medium">City:</span>
                                        {{ $order->delivery_city }}
                                    </div>
                                    <div class="flex gap-1 items-center">
                                        <span class="font-medium">Postcode:</span>
                                        {{ $order->delivery_postcode }}
                                    </div>
                                    <div class="flex gap-1 items-center">
                                        <span class="font-medium">Location Type:</span>
                                        {{ $order->delivery_location_type }}
                                    </div>
                                    <div class="flex gap-1 items-center">
                                        <span class="font-medium">Date:</span>
                                        {{ getDateFormat($order->delivery_date) }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Note</th>
                            <td>{{ $order->note }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($order->status === 'Pending')
                                    <x-status :content="$order->status" :type="'info'" />
                                @elseif($order->status === 'Booked')
                                    <x-status :content="$order->status" :type="'success'" />
                                @elseif($order->status === 'Rejected')
                                    <x-status :content="$order->status" :type="'danger'" />
                                @endif
                            </td>
                        </tr>
                    </table>
{{-- auth()->user()->hasRole('admin') || auth()->user()->id === $order->trip->user_id --}}
                    @if(auth()->user()->hasRole('admin'))
                        <form id="update" method="POST" @submit.prevent="updateBooking">
                            @csrf
                            @method('PUT')
                            <table class="w-full table mb-4 whitespace-nowrap">
                                <tr>
                                    <th class="w-64">Admin Note</th>
                                    <td>
                                        <textarea rows="5" name="admin_note" id="admin_note" class="form-input">{{ $order->admin_note }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <x-input-dropdown class="status !w-64" name="status" :options="$order_status" :selected="[$order->status]"/>
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
                        @forelse($order->products as $product)
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
                <x-trip :trip="$order->trip" />
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('order', () => ({

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
                            url    : route('order.update', {{ $order->id }}),
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
                                window.location.href = route('order.index');
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
