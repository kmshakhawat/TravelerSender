<div x-data="travel">
    <form id="update" x-ref="trackingForm" @submit.prevent="updateTracking()" method="POST">
        @csrf
        @method('POST')
        <div class="bg-white p-6 rounded min-w-96">
            <h1 class="text-xl font-semibold capitalize mb-5 pb-4 border-b">Update Tracking Status</h1>
            <input type="hidden" name="booking_id" value="{{ $tracking->booking_id }}">
            <div class="mt-6">
                <div class="mt-4">
                    <x-label for="status" value="{{ __('Status') }}" />
                    <x-input-dropdown class="status" name="status" :options="$tracking_status" :selected="[$latest->status]"/>
                    <div class="invalid-feedback invalid-status"></div>
                </div>

                <div class="mt-4">
                    <x-label for="description" value="{{ __('Description') }}" />
                    <textarea id="description" name="description" class="form-input" rows="3"></textarea>
                    <div class="invalid-feedback invalid-description"></div>
                </div>

                <div class="mt-4">
                    <x-label for="estimated_delivery" value="{{ __('Estimated Delivery (Optional)') }}" />
                    <x-input id="estimated_delivery" class="block w-full datepicker" type="text" name="estimated_delivery" :value="old('estimated_delivery')" autocomplete="estimated_delivery" />
                    <div class="invalid-feedback invalid-estimated_delivery"></div>
                </div>

                <div class="flex gap-2 mt-6">
                    <button type="button" @click.prevent="$store.app.showModal = false" class="btn-secondary">Cancel</button>
                    <button class="btn-primary">Update</button>
                </div>
            </div>
        </div>
    </form>
</div>
