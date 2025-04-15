<x-app-layout>
    <x-slot name="header" class="flex">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tracking') }}
            </h2>
            <a class="btn-secondary" href="{{ route('booking.index') }}">Back</a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="container">
            <div class="max-w-5xl mx-auto bg-white border border-gray-50 rounded shadow p-4">

                <div class="flex justify-between items-top my-10">
                    @php
                        $steps = [
                            'Processing',
                            'Ready for Pickup',
                            'Picked Up',
                            'In Transit',
                            'Arrived at Destination',
                            'Attempt to Deliver',
                            'Delivered',
                        ];
                        $icons = [
                            '📦',
                            '🚚',
                            '🛒',
                            '🚚',
                            '🚚',
                            '🛵',
                            '🤲',
                        ];

                        $currentStatus = $currentStep; // 0-indexed: 0 = Accepted, 1 = Picked, etc.
                    @endphp


                    @foreach($steps as $index => $step)
                        <div class="flex flex-grow basis-full flex-col items-center relative">
                            <!-- Icon -->
                            <div class="w-16 h-16 relative z-20 bg-gray-100 rounded-full text-3xl flex justify-center items-center">
                                {{ $icons[$index] }}
{{--                                <img src="{{ $icons[$index] }}" alt="{{ $step }}" class="w-12 h-12">--}}
                            </div>

                            <!-- Checkmark Circle -->
                            @if ($index <= $currentStep)
                                <div class="relative z-20 w-6 h-6 rounded-full bg-green-500 flex items-center justify-center text-white text-xs font-bold mt-2">
                                    ✓
                                </div>
                            @else
                                <div class="relative z-10 w-6 h-6 rounded-full bg-gray-300 mt-2"></div>
                            @endif

                            <!-- Label -->
                            <div class="text-center text-sm mt-1 font-medium">
                                {{ $step }}
                            </div>

                            <!-- Dotted Line -->
                            @if ($index < count($steps) - 1)
                                <div class="absolute top-[35px] left-16 z-10 w-full h-1 border-t-2 border-dotted {{ $index < $currentStep ? 'border-green-500' : 'border-gray-300' }} z-0"></div>
                            @endif
                        </div>
                    @endforeach
                </div>



                @foreach ($tracking as $index => $track)
                    <div class="relative flex items-center space-x-4 py-6">
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

            </div>
        </div>
    </div>

</x-app-layout>
