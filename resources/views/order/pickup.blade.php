<div x-data="travel">
    <form id="pickup" x-ref="pickupForm" @submit.prevent="pickupVerify({{ $booking->id }})" method="POST">

{{--        @dd($booking->products)--}}
        @csrf
        @method('POST')
        <div class="bg-white p-6 rounded min-w-96">
            <h3 class="text-xl font-semibold capitalize mb-5 pb-4 border-b">Pickup Verify</h3>
            <div class="mt-6">
                <div class="mt-4">
                    <x-label for="status" value="{{ __('OTP') }}" />
                    <small class="text-gray-500">An email has been sent to {{ $booking->sender_email }}</small>
                    <x-input id="otp" class="block w-full" type="text" name="otp" :value="old('otp')" autocomplete="otp" />
                    <button @click.prevent="resendOTP({{ $booking->id }}, 'pickup')" class="mt-2 text-primary">Resend OTP</button>
                    <div class="invalid-feedback invalid-otp"></div>
                </div>

                @if($booking->products)
                    <h4 class="text-lg font-semibold mt-6 mb-2">Received product in good condition</h4>
                    <div class="flex gap-1 mb-4 text-xs items-center text-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                        </svg>
                        Note: If you notice any issues with the product upon receipt, please provide details in the note.
                    </div>
                    @foreach($booking->products as $product)
                        <div class="flex items-center justify-between mt-2 text-sm text-gray-600">
                            <label for="product_{{ $product->id }}" class="flex w-6/12 items-center">
                                <x-checkbox id="product_{{ $product->id }}" name="products[]" value="{{ $product->id }}" />
                                <span class="ms-2 text-sm text-gray-600">{{ $product->name }}</span>
                            </label>
                            <div class="w-3/12">Type: {{ $product->type }}</div>
                            <div class="w-3/12">Qty: {{ $product->quantity }}</div>
                        </div>
                    @endforeach
                    <textarea name="condition_details" id="condition_details" class="form-input mt-4">{{ old('condition_details') }}</textarea>
                @else
                    <div class="mt-4">
                        <x-label for="status" value="{{ __('No products available') }}" />
                    </div>
                @endif

                <div class="flex gap-2 mt-6">
                    <button type="button" @click.prevent="$store.app.showModal = false" class="btn-secondary">Cancel</button>
                    <button class="btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>
