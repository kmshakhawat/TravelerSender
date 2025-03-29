<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment Successful') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">

            <div class="bg-green-50 p-5 border-b border-green-100">
                <div class="flex items-center space-x-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <h1 class="text-2xl font-bold text-green-600">Payment Successful</h1>
                </div>
            </div>
            <div class="p-6">
                <p class="text-gray-600 mb-6">Thank you for your payment! Your booking has been processed successfully and your booking is now confirmed.</p>

                <div class="bg-gray-50 p-4 rounded-md mb-6 border-l-4 border-green-400">
                    <p class="text-sm text-gray-500">A confirmation email with all the details has been sent to your registered email address.</p>
                </div>

                <div class="flex flex-col space-y-4">
                    <div class="grid grid-cols-2 gap-4 text-sm mb-2">
                        <div class="text-gray-500">Reference Number:</div>
                        <div class="font-medium text-gray-700">{{ $payment->trxref ?? '' }}</div>

                        <div class="text-gray-500">Amount Paid:</div>
                        <div class="font-medium text-gray-700">{{ $payment->amount ?? '' }}</div>

                        <div class="text-gray-500">Payment Date:</div>
                        <div class="font-medium text-gray-700">{{ $payment->created_at->format('M d, Y') }}</div>
                    </div>

                    <div class="flex space-x-4 pt-2">
                        <a href="{{ route('booking.show', $payment->booking->id) }}" class="flex-1 btn-primary text-center">
                            View Booking
                        </a>
                        <a href="{{ route('dashboard') }}" class="flex-1 btn-secondary text-center">
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
