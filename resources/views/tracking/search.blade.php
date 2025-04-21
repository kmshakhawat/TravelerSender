<x-guest-layout>
    <x-slot name="header" class="flex">
        <div class="flex justify-between items-center">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tracking') }}
            </h1>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="container">

            <div class="max-w-5xl mx-auto bg-white border border-gray-50 rounded shadow p-4">

                <div class="text-center">
                    <form name="tracking" method="GET" action="{{ route('tracking.search') }}">
                        <input class="form-input mb-4 !text-xl !text-center !min-h-16" type="text" name="trackingNumber" value="{{ request('trackingNumber') }}" placeholder="Enter Tracking Number" required autocomplete="off" />
                        <button class="btn-primary" type="submit">Search</button>
                    </form>
                </div>

                @if($tracking->isNotEmpty())
                    <div class="flex flex-col sm:flex-row justify-between items-top my-10">
                        @php
                            $icons_old = [
                                '📦',
                                '🚚',
                                '🛒',
                                '🚚',
                                '🚚',
                                '🛵',
                                '🤲',
                            ];
                            $icons = [
                                '🔄', // Processing
                                '📍', // Ready for Pickup
                                '🚚', // Picked Up
                                '🛣️', // In Transit
                                '📦', // Arrived at Destination
                                '📬', // Attempt to Deliver
                                '📦', // Delivered
                            ];
                            $currentStatus = $currentStep;
                        @endphp

                        @foreach($steps as $index => $step)
                            <div class="flex flex-grow basis-full flex-col items-center relative">
                                <div class="w-16 h-16 relative z-20 rounded-full text-3xl flex justify-center items-center
                                    {{ $index === $currentStep ? 'bg-yellow-300 animate-bounce shadow-lg' : 'bg-gray-100' }}">
                                    {!! $icons[$index] !!}
                                </div>
                                @if(in_array($step, $completedStatuses))
                                    <div class="relative z-20 w-6 h-6 rounded-full bg-green-500 flex items-center justify-center text-white text-xs font-bold mt-2">
                                        ✓
                                    </div>
                                @else
                                    <div class="relative z-10 w-6 h-6 rounded-full bg-gray-300 mt-2"></div>
                                @endif

                                <div class="text-center text-sm mt-1 font-medium">
                                    {{ $step }}
                                    @if($index === $currentStep)
                                        <div class="text-xs text-yellow-700 font-semibold mt-1">You are here</div>
                                    @endif
                                </div>

                                @if ($index < count($steps) - 1)
                                    <div class="absolute top-[35px] left-0 sm:left-16 z-10 w-full h-1 border-t-2 border-dotted
                {{ in_array($steps[$index + 1], $completedStatuses) ? 'border-green-500' : 'border-gray-300' }} z-0">
                                    </div>
                                @endif
                            </div>
                        @endforeach

                    </div>

                    @foreach ($tracking as $index => $track)
                        <div class="hidden sm:flex relative items-center space-x-4 py-6">
                            <!-- Step Icon -->
                            <div class="relative z-50">
                                <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white text-lg font-semibold">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                    </svg>

                                </div>

                            </div>
                            @if ($index !== count($tracking) - 1)
                                <div style="width: 2px;top: 40px;" class="absolute z-10 left-0 transform -translate-x-1/2 h-full  bg-gray-100"></div>
                            @endif
                            <div class="flex-1">
                                <h3 class="font-semibold text-sm text-gray-800">{{ $track->status }}</h3>
                                <p class="text-xs text-gray-400">{{ getDateFormat($track->status_update_at, 'd M H:i') }}</p>
                                <p class="text-md text-gray-600">{{ $track->description }}</p>
                                @if($track->estimated_delivery)
                                    <p class="text-md text-gray-600">Estimated Delivery {{ getDateFormat($track->estimated_delivery, 'd M Y') }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach

                @else
                    <div class="flex flex-col items-center justify-center my-10">
                        <div class="text-red-500 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01M12 3C7.03 3 3 7.03 3 12s4.03 9 9 9 9-4.03 9-9-4.03-9-9-9z" />
                            </svg>
                        </div>
                        <h2 class="text-lg font-semibold text-red-600 mb-1">No Tracking Information Found</h2>
                        <p class="text-sm text-gray-500 text-center">
                            We couldn't find any tracking updates for this number. Please double-check and try again.
                        </p>
                    </div>
                @endif

            </div>
        </div>
    </div>

</x-guest-layout>
