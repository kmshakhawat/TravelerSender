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
            <div class="max-w-md mx-auto bg-white border border-gray-50 rounded shadow p-4">

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
                            <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($track->status_update_at)->format('d M H:i') }}</p>
                            <p class="text-md text-gray-600">{{ $track->description }}</p>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

</x-app-layout>
