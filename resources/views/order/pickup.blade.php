<div x-data="travel">
    <form id="pickup" x-ref="pickupForm" @submit.prevent="pickupVerify({{ $booking->id }})" method="POST">
        @csrf
        @method('POST')
        <div class="bg-white p-6 rounded min-w-96">
            <h3 class="text-xl font-semibold capitalize mb-5 pb-4 border-b">Pickup Verify</h3>
            <div class="mt-6">
                <div class="mt-4">
                    <x-label for="status" value="{{ __('OTP') }}" />
                    <small class="text-primary">An email has been sent to {{ $booking->sender_email }}</small>
                    <x-input id="otp" class="block w-full" type="text" name="otp" :value="old('otp')" autocomplete="otp" />
                    <button @click.prevent="resendOTP({{ $booking->id }}, 'pickup')" class="mt-2 text-primary">Resend OTP</button>
                    <div class="invalid-feedback invalid-otp"></div>
                </div>

                <div class="flex gap-2 mt-6">
                    <button type="button" @click.prevent="$store.app.showModal = false" class="btn-secondary">Cancel</button>
                    <button class="btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>
