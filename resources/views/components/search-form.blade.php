<form method="GET" action="{{ route('trip.search') }}" class="w-full">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 md:gap-10">
        <div class="autocomplete-wrapper relative w-full">
            <span class="absolute top-[8px] text-gray-300 ps-10 text-sm">From</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 opacity-50 text-primary absolute left-3 top-1/2 transform -translate-y-1/2"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
            <input wire:model="from" type="text" autocomplete="off" id="from-location" class="block w-full ps-10 form-input !py-4" name="from" />
            <div id="from-location-results" class="absolute z-50 bg-white border rounded shadow w-full hidden"></div>
        </div>
        <div class="autocomplete-wrapper relative w-full">
            <span class="absolute top-[8px] text-gray-300 ps-10 text-sm">To</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 opacity-50 text-primary absolute left-3 top-1/2 transform -translate-y-1/2"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
            <input wire:model="to" type="text" autocomplete="off" id="to-location" class="block w-full ps-10 form-input !py-4" name="to" />
            <div id="to-location-results" class="absolute z-50 bg-white border rounded shadow w-full hidden"></div>
        </div>
        <div class="relative w-full">
            <span class="absolute top-[8px] text-gray-300 ps-10 text-sm">Departure</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 opacity-50 text-primary absolute left-3 top-1/2 transform -translate-y-1/2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
            </svg>
            <input wire:model="departure_date" type="text" id="departure_date" class="block w-full ps-10 form-input !py-4 relative bg-transparent datepicker" name="departure_date" autocomplete="off" />
        </div>
        <div class="relative w-full flex gap-4">
            <button wire:click="$refresh" type="submit" class="w-full px-8 py-4 bg-primary text-white rounded font-medium transition ease-in-out duration-300 hover:bg-secondary">
                Send a Parcel
            </button>
        </div>
    </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/algoliasearch@4.22.0/dist/algoliasearch-lite.umd.js"></script>
@push('scripts')
    <script>
    const client = algoliasearch('1OAJBF46K2', '66dd053667d06c7f205701f7b48e3ec9');

    // Reference each index
    const countriesIndex = client.initIndex('countries');
    const statesIndex = client.initIndex('states');
    const citiesIndex = client.initIndex('cities');

    function setupAlgoliaCustomDropdown(inputId, resultsId) {
        const input = document.getElementById(inputId);
        const resultsContainer = document.getElementById(resultsId);
        let activeIndex = -1;
        let results = [];

        input.addEventListener('input', function () {
            const query = this.value.trim();
            if (query.length < 3) {
                resultsContainer.classList.add('hidden');
                return;
            }

            Promise.all([
                countriesIndex.search(query, { hitsPerPage: 5 }),
                statesIndex.search(query, { hitsPerPage: 5 }),
                citiesIndex.search(query, { hitsPerPage: 5 }),
            ]).then(([countries, states, cities]) => {
                results = [
                    ...countries.hits.map(hit => ({ ...hit, type: 'Country' })),
                    ...states.hits.map(hit => ({ ...hit, type: 'State' })),
                    ...cities.hits.map(hit => ({ ...hit, type: 'City' })),
                ];

                if (results.length === 0) {
                    resultsContainer.innerHTML = '<div class="p-2 text-sm text-gray-500">No results found</div>';
                } else {
                    resultsContainer.innerHTML = results
                        .map((hit, index) => `
                        <div class="p-2 hover:bg-gray-100 cursor-pointer" data-name="${hit.name}" data-index="${index}">
                            <span class="font-medium">${hit.name}</span>
                            <span class="text-xs text-gray-500 ml-2">${hit.type}</span>
                        </div>
                    `).join('');
                }

                resultsContainer.classList.remove('hidden');
                activeIndex = -1;

                // Enable mouse click selection
                resultsContainer.querySelectorAll('[data-name]').forEach(el => {
                    el.addEventListener('click', () => {
                        selectValue(el.getAttribute('data-name'));
                    });
                });
            });
        });

        // Keyboard navigation
        input.addEventListener('keydown', function (e) {
            const items = resultsContainer.querySelectorAll('[data-index]');
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                if (activeIndex < items.length - 1) {
                    activeIndex++;
                    updateActiveItem(items);
                }
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                if (activeIndex > 0) {
                    activeIndex--;
                    updateActiveItem(items);
                }
            } else if (e.key === 'Enter') {
                e.preventDefault();
                if (activeIndex >= 0 && activeIndex < results.length) {
                    const selected = results[activeIndex].name;
                    selectValue(selected);
                }
            }
        });

        function updateActiveItem(items) {
            items.forEach((el, idx) => {
                el.classList.toggle('bg-gray-200', idx === activeIndex);
            });
        }

        let userSelected = false;

        function selectValue(value) {
            userSelected = true;
            input.value = value;

            // Always dispatch a native InputEvent for compatibility (Livewire or not)
            input.dispatchEvent(new InputEvent('input', { bubbles: true, composed: true }));

            // Check if Livewire exists and apply Livewire-specific update
            if (window.Livewire && typeof Livewire.find === 'function') {
                const el = input.closest('[wire\\:id]');
                if (el) {
                    const component = Livewire.find(el.getAttribute('wire:id'));
                    const fieldName = input.getAttribute('wire:model');

                    if (component && fieldName) {
                        component.set(fieldName, value);
                    }
                }
            }

            // Defer hiding the dropdown to avoid UI conflicts
            requestAnimationFrame(() => {
                resultsContainer.classList.add('hidden');
                resultsContainer.style.display = 'none';
                resultsContainer.innerHTML = '';
            });

            input.blur(); // Optional: close mobile keyboard
        }

        document.addEventListener('click', function (e) {
            if (!resultsContainer.contains(e.target) && e.target !== input) {
                resultsContainer.classList.add('hidden');
            }
        });

        input.addEventListener('focus', () => {
            if (userSelected) {
                resultsContainer.classList.add('hidden');
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        setupAlgoliaCustomDropdown('from-location', 'from-location-results');
        setupAlgoliaCustomDropdown('to-location', 'to-location-results');
    });

</script>
@endpush
