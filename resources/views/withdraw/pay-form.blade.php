<div x-data="travel">
    <form id="payment" x-ref="payForm" @submit.prevent="paymentAction({{ $payment->id }})" method="POST">
        @csrf
        @method('POST')
        <div class="bg-white p-6 rounded min-w-96">
            <h3 class="text-xl font-semibold capitalize mb-5 pb-4 border-b">Withdraw</h3>
            <div class="mt-6">
                <div class="mt-4">
                    <x-label for="status" value="{{ __('Bank Details') }}" />
                    @if($payment->tripUser->profile->bank_details)
                    <div class="mb-4 text-xs">
                        {{ $payment->tripUser->profile->bank_details }}
                    </div>
                    @else
                        <p class="mb-5">Please <a class="underline" href="{{ route('profile') }}">click here</a> to update your bank details.</p>
                    @endif
                    <x-label for="amount" value="{{ __('Amount') }}" />
                    <x-input id="amount" class="block w-full" type="text" name="amount" :value="getPrice($payment->currency, $payment->net_amount)" disabled autocomplete="amount" />
                    <div class="invalid-feedback invalid-amount"></div>
                </div>

                <div class="mt-4">
                    <x-label for="note" value="{{ __('Note') }}" />
                    <textarea name="note" id="note" class="form-input">{{ $payment->withdraw->note }}</textarea>
                </div>

                <div class="mt-4">
                    <x-label for="status" value="{{ __('Status') }}" />
                    <x-input-dropdown :search="false" class="w-full" name="status" :options="$statusOptions" :selected="[$payment->withdraw->status]"/>
                    <div class="invalid-feedback invalid-status"></div>
                </div>

                <div class="flex gap-2 mt-6">
                    <button type="button" @click.prevent="$store.app.showModal = false" class="btn-secondary">Cancel</button>
                    <button class="btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>
