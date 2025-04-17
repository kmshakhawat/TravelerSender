<div x-data="travel">
    <form id="withdraw" x-ref="withdrawForm" @submit.prevent="withdrawAction({{ $payment->id }})" method="POST">
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
                    <x-label for="status" value="{{ __('Amount') }}" />
                    <x-input id="amount" class="block w-full" type="text" name="amount" :value="getPrice($payment->net_amount, $payment->currency)" disabled autocomplete="amount" />
                    <div class="invalid-feedback invalid-amount"></div>
                </div>

                <div class="flex gap-2 mt-6">
                    <button type="button" @click.prevent="$store.app.showModal = false" class="btn-secondary">Cancel</button>
                    <button class="btn-primary">Withdraw Now!</button>
                </div>
            </div>
        </div>
    </form>
</div>
