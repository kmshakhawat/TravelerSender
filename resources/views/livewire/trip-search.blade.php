<div>
    <div class="bg-white shadow">
        <div class="container py-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 md:gap-10">
                <div class="relative w-full">
                    <span class="absolute top-[8px] text-gray-300 ps-10 text-sm">From</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 opacity-50 text-primary absolute left-3 top-1/2 transform -translate-y-1/2"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
                    <input wire:model="from" type="text" id="from" class="block w-full ps-10 form-input !py-4" name="from" />
                </div>
                <div class="relative w-full">
                    <span class="absolute top-[8px] text-gray-300 ps-10 text-sm">To</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 opacity-50 text-primary absolute left-3 top-1/2 transform -translate-y-1/2"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
                    <input wire:model="to" type="text" id="to" class="block w-full ps-10 form-input !py-4" name="to" />
                </div>
                <div class="relative w-full">
                    <span class="absolute top-[8px] text-gray-300 ps-10 text-sm">Departure</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 opacity-50 text-primary absolute left-3 top-1/2 transform -translate-y-1/2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                    </svg>
                    <input wire:model="departure_date" type="text" id="departure_date" class="block w-full ps-10 form-input !py-4 datepicker" name="departure_date" autocomplete="off" />
                </div>
                <div class="relative w-full flex gap-4">
                    <button wire:click="$refresh" type="button" class="mt-1 w-full px-8 py-4 bg-primary text-white rounded font-medium transition ease-in-out duration-300 hover:bg-secondary">
                        Search
                    </button>
{{--                    <button type="button" class="mt-1 w-full px-8 py-4 bg-[#E63124] text-white rounded font-medium" wire:click="resetForm">Reset</button>--}}
                </div>
            </div>
        </div>
    </div>
    <div class="py-12 bg-[#F3F4F6]">
        <div class="container">
            <div class="flex flex-col md:flex-row gap-8">
                <div class="w-full md:w-1/4">
                    <div class="bg-white border border-gray-10 rounded-lg p-4 mb-4">
                        <label for="shorting" class="block mb-2 font-medium text-gray-700">Sorting</label>
                        <select wire:model.live="shorting" id="shorting" name="shorting" class="form-input">
                            <option value="">-- Select --</option>
{{--                            <option value="most_recent">Most Recent</option>--}}
                            <option value="lowest_price">Price (Low > High)</option>
                            <option value="highest_price">Price (High > Low)</option>
{{--                            <option value="highest_reward">Highest Reward</option>--}}
                        </select>
                    </div>
                    <div class="bg-white border border-gray-10 rounded-lg p-4 mb-4">
                        <label for="departure_filter" class="block mb-2 font-medium text-gray-700">Departure Date</label>
                        <select wire:model.live="departure_filter" name="departure_filter" class="form-input">
                            <option value="">-- Select --</option>
                            <option value="today">Today</option>
                            <option value="tomorrow">Tomorrow</option>
                            <option value="this_week">This Week</option>
                            <option value="15_days">Within 15 Days</option>
                            <option value="this_month">Within 1 Month</option>
                        </select>
                    </div>
                    <div class="bg-white border border-gray-10 rounded-lg p-4 mb-4">
                        <label for="review" class="block mb-2 font-medium text-gray-700">Review Score</label>
                        <select wire:model.live="review" name="review" class="form-input">
                            <option>-- Select --</option>
                            <option value="5">5 Star</option>
                            <option value="4">4 Star</option>
                            <option value="3">3 Star</option>
                            <option value="2">2 Star</option>
                            <option value="1">1 Star</option>
                            <option value="0">Unrated</option>
                        </select>
                    </div>
                </div>
                <div class="w-full md:w-3/4">
                    {{--                    @dd($trips)--}}
                    @forelse($trips as $trip)
                        <x-trip :trip="$trip" :booking="true" />
                    @empty
                        <div class="bg-white border border-gray-10 rounded-lg p-4">
                            <div class="not-found">Data Not Found!!</div>
                        </div>
                    @endforelse
                    <div class="my-4">
                        {{ $trips->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function initFlatpickr() {
            flatpickr("#departure_date", {
                enableTime: false,
                dateFormat: "Y-m-d",
            });
        }

        document.addEventListener("DOMContentLoaded", function () {
            initFlatpickr(); // Initialize on page load
        });

        window.addEventListener('init-flatpickr', event => {
            initFlatpickr();
        });
    </script>
@endpush
