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
                            <th class="w-64">Sender Details</th>
                            <td>
                                <div class="flex flex-col gap-2">
                                    <div class="flex gap-1 items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-secondary">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                        {{ $order->sender_name }}
                                    </div>
                                    <div class="flex gap-1 items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-secondary">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                        </svg>
                                        {{ $order->sender_email }}
                                    </div>
                                    <div class="flex gap-1 items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-secondary">
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
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-secondary">
                                                <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $order->pickup_location }}
                                        </div>
                                        <div class="flex gap-1 items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-secondary">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z" />
                                            </svg>
                                            {{ $order->pickup_location_type }}
                                        </div>
                                        <div class="flex gap-1 items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-secondary">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                            </svg>
                                            {{ $order->pickup_date }}
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
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-secondary">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                        {{ $order->receiver_name }}
                                    </div>
                                    <div class="flex gap-1 items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-secondary">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                        </svg>
                                        {{ $order->receiver_email }}
                                    </div>
                                    <div class="flex gap-1 items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-secondary">
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
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-secondary">
                                            <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $order->delivery_location }}
                                    </div>
                                    <div class="flex gap-1 items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-secondary">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z" />
                                        </svg>
                                        {{ $order->delivery_location_type }}
                                    </div>
                                    <div class="flex gap-1 items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-secondary">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                        </svg>
                                        {{ $order->delivery_date }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Note</th>
                            <td>{{ $order->note }}</td>
                        </tr>
                        @if(!auth()->user()->hasRole('admin') || auth()->user()->id != $order->trip->user_id)
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($order->status === 'Pending')
                                        <x-status :content="$order->status" :type="'info'" />
                                    @elseif($order->status === 'Approved')
                                        <x-status :content="$order->status" :type="'success'" />
                                    @elseif($order->status === 'Rejected')
                                        <x-status :content="$order->status" :type="'danger'" />
                                    @endif
                                </td>
                            </tr>
                        @endif
                    </table>

                    @if(auth()->user()->hasRole('admin') || auth()->user()->id === $order->trip->user_id)
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
