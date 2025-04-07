<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Earnings') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="container">
            <div class="bg-white border border-gray-50 rounded shadow p-4">
                <div class="overflow-auto">
                    <table class="w-full table whitespace-nowrap">
                        <thead class="bg-secondary text-gray-100 font-bold">
                        <td class="py-2 pl-5 flex">
                            Trip
                        </td>
                        <td class="py-2 pl-2">
                            Amount
                        </td>
                        <td class="py-2 pl-2">
                            Net Amount
                        </td>
                        <td class="py-2 pl-2">
                            Status
                        </td>
                        <td class="py-2 pl-2 flex justify-end">
                            Action
                        </td>
                        </thead>
                        <tbody class="text-sm">
                        @forelse($earnings as $earning)
                        <tr>
                            <td class="py-3 pl-5">
                                <div class="flex flex-col">
                                    <a class="flex items-center gap-2" href="{{ route('trip.show', $earning->trip->id) }}">
                                        {{ $earning->trip->fromCountry->name ?? '' }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-right">
                                            <path d="M18 8L22 12L18 16"/>
                                            <path d="M2 12H22"/>
                                        </svg>
                                        {{ $earning->trip->toCountry->name ?? '' }}
                                    </a>
                                    <div class="text-xs text-gray-500">{{ getDateFormat($earning->trip->departure_date) }} to {{ getDateFormat($earning->trip->arrival_date) }}</div>
                                </div>
                            </td>
                            <td class="py-3 pl-5">
                                {{ getPrice($earning->trip->currency, $earning->trip->price) }}
                            </td>
                            <td class="py-3 pl-5">
                                {{ getPrice($earning->trip->currency, $earning->net_amount) }}
                            </td>
                            <td class="py-3 pl-5">
                                @if($earning->status === 'complete')
                                    <x-status :content="$earning->status" :type="'info'" />
                                @elseif($earning->status === 'complete')
                                    <x-status :content="$earning->status" :type="'success'" />
                                @elseif($earning->status === 'Failed')
                                    <x-status :content="$earning->status" :type="'error'" />
                                @endif
                            </td>
                            <td>
                                <button class="btn-primary">Withdrow</button>
                            </td>
                        </tr>
                        @empty
                            <tr class="bg-gray-100 align-top hover:bg-primary hover:bg-opacity-20 transition duration-200">
                                <td colspan="10" class="text-center py-4">
                                    <div class="not-found">Data Not Found!!</div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">
                    {{ $earnings->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
