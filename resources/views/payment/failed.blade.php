<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment Failed') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="bg-red-50 p-5 border-b border-red-100">
                <div class="flex items-center space-x-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h1 class="text-2xl font-bold text-red-600">Payment Failed</h1>
                </div>
            </div>

            <div class="p-6">
                <p class="text-gray-600 mb-6">We couldn't process your payment. This could be due to insufficient funds, an expired card, or a temporary issue with our payment processor.</p>

                <div class="bg-gray-50 p-4 rounded-md mb-6 border-l-4 border-blue-400">
                    <p class="text-sm text-gray-500">Your account has not been charged. You can try again or use a different payment method.</p>
                </div>

                <div class="flex space-x-4">
                    <a href="{{ route('payment') }}" class="btn-primary flex-1 text-center !py-4">
                        Try Again
                    </a>
                    <a href="{{ route('booking.index') }}" class="btn-secondary flex-1 text-center !py-4">
                        Back to Booking
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
