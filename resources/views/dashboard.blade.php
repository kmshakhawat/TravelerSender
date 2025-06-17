<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="min-h-screen">
                <div class="font-medium text-5xl text-gray-700">
                    Welcome, <span class="text-primary">{{ Auth::user()->name }}</span>
                </div>
                <div class="my-10">
                    <h3 class="heading-5 mb-4">Dashboard Overview</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <div class="bg-white p-4 rounded">
                            <div class="flex gap-1 mb-4">
                                <svg class="size-6 text-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z"/>
                                </svg>
                                <h4 class="heading-5">Active Trips</h4>
                            </div>
                            <div class="text-3xl font-semibold text-primary">{{ $active_trips }}</div>
                        </div>
                        <div class="bg-white p-4 rounded">
                            <div class="flex items-center justify-between gap-1 mb-4">
                                <div class="flex gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 text-primary">
                                        <path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/><path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/>
                                    </svg>
                                    <h4 class="heading-5">Earnings</h4>
                                </div>
                                <div class="text-xl text-black">{{ getPrice($totals) }}</div>
                            </div>
                            <div class="text-3xl font-semibold text-primary">{{ getPrice($earnings) }}</div>
                        </div>
                        @if(!Auth::user()->hasRole('admin'))
                            <div class="bg-white p-4 rounded">
                                <div class="flex gap-1 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-primary">
                                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                                    </svg>
                                    <h4 class="heading-5">Rating</h4>
                                </div>
                                <div class="text-3xl font-semibold text-primary">{{ $avg_rating }}</div>
                            </div>
                        @endif
                        <div class="bg-white p-4 rounded">
                            <div class="flex gap-1 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-primary">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                </svg>
                                <h4 class="heading-5">Happy Customers</h4>
                            </div>
                            <div class="text-3xl font-semibold text-primary">{{ $customers }}</div>
                        </div>
                    </div>

                    <div class="mt-10">
                        <h3 class="heading-5 mb-4">Recent Bookings</h3>
                        <div class="overflow-auto">
                            <table class="w-full table whitespace-nowrap">
                                <thead class="bg-secondary text-gray-100 font-bold">
                                @if(Auth::user()->hasRole('admin'))
                                    <td class="py-2 pl-2">
                                        User
                                    </td>
                                @endif
                                <td class="py-2 pl-2">
                                    From → To / Date
                                </td>
                                <td class="py-2 pl-2">
                                    Sender
                                </td>
                                <td class="py-2 pl-2">
                                    Pickup
                                </td>
                                <td class="py-2 pl-2">
                                    Receiver
                                </td>
                                <td class="py-2 pl-2">
                                    Tracking
                                </td>
                                <td class="py-2 pl-2">
                                    Payment
                                </td>
                                <td class="py-2 pl-2 flex justify-end">
                                    Action
                                </td>
                                </thead>
                                <tbody class="text-sm">
                                @forelse($bookings as $booking)
                                    <tr>
                                        @if(Auth::user()->hasRole('admin'))
                                            <td class="py-3 pl-2">
                                                <img class="size-10 rounded-full object-cover" src="{{ $booking->trip->user->profile_photo_url ?: 'https://ui-avatars.com/api/?name='.urlencode($booking->trip->user->name).'&color=7F9CF5&background=EBF4FF' }}" alt="{{ $booking->trip->user->name }}" title="{{ $booking->trip->user->name }}" />
                                            </td>
                                        @endif
                                        <td class="py-3 pl-2">
                                            <div class="flex flex-col">
                                                <a class="flex items-center gap-2" href="{{ route('trip.show', $booking->trip->id) }}">
                                                    {{ $booking->trip->fromCity?->name ? $booking->trip->fromCity->name .', ' : '' }} {{ $booking->trip->fromCountry->name ?? '' }}
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-right">
                                                        <path d="M18 8L22 12L18 16"/>
                                                        <path d="M2 12H22"/>
                                                    </svg>
                                                    {{ $booking->trip->toCity?->name ? $booking->trip->toCity->name .', ' : '' }} {{ $booking->trip->toCountry->name ?? '' }}
                                                    @if($booking->status === 'Pending')
                                                        <x-status :content="$booking->status" :type="'info'" class="px-[4px] py-[2px] -mt-2 -ms-1" />
                                                    @elseif($booking->status === 'Booked')
                                                        <x-status :content="$booking->status" :type="'success'" class="px-[4px] py-[2px] -mt-2 -ms-1" />
                                                    @elseif($booking->status === 'Cancelled')
                                                        <x-status :content="$booking->status" :type="'danger'" class="px-[4px] py-[2px] -mt-2 -ms-1" />
                                                    @elseif($booking->status === 'Completed')
                                                        <x-status :content="$booking->status" :type="'verified'" class="px-[4px] py-[2px] -mt-2 -ms-1" />
                                                    @endif
                                                </a>

                                                <div class="text-xs text-gray-500">{{ getDateFormat($booking->trip->departure_date) }} to {{ getDateFormat($booking->trip->arrival_date) }}</div>
                                                @if($booking->tracking_number)
                                                    <div class="mt-1 text-[#E68C85]">
                                                        Tracking Number:
                                                        <a target="_blank" class="text-[#E68C85] hover:underline" href="{{ route('tracking', '?trackingNumber=' . $booking->tracking_number) }}">
                                                            {{ $booking->tracking_number }}
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-3 pl-25">
                                            <div class="flex flex-col">
                                                <a href="{{ route('booking.show', $booking->id) }}" class="flex gap-1 items-center">
                                                    {{ $booking->sender_name }}
                                                </a>
                                            </div>
                                        </td>
                                        <td class="py-3 pl-2">
                                            {{ $booking->collection_type }}
                                            @if($booking->pickup_location)
                                                <div class="flex flex-col">
                                                    <a href="{{ route('booking.show', $booking->id) }}" class="flex gap-1 items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-secondary">
                                                            <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
                                                        </svg>
                                                        {{ $booking->pickup_location }}
                                                    </a>
                                                    <a href="{{ route('booking.show', $booking->id) }}" class="flex gap-1 items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-secondary">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                                        </svg>
                                                        {{ $booking->pickup_date }}
                                                    </a>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="py-3 pl-2">
                                            <div class="flex flex-col">
                                                <a href="{{ route('booking.show', $booking->id) }}" class="flex gap-1 items-center">
                                                    {{ $booking->receiver_name }}
                                                </a>
                                            </div>
                                        </td>
                                        <td class="py-3 pl-2">
                                            @if($booking->latestTracking)
                                                <a class="btn-secondary !inline-flex gap-2" href="{{ route('tracking', '?trackingNumber=' . $booking->tracking_number) }}">
                                                    {{ $booking->latestTracking->status ?? '' }}
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                                    </svg>
                                                </a>
                                            @endif
                                        </td>
                                        <td class="py-3 pl-2">
                                            @if($booking->payment->payment_status === 'paid')
                                                <x-status :content="ucfirst($booking->payment->payment_status)" :type="'success'" />
                                            @elseif($booking->payment->payment_status === 'failed')
                                                <x-status :content="ucfirst($booking->payment->payment_status)" :type="'danger'" />
                                            @endif
                                        </td>
                                        <td class="py-3 pl-2">
                                            <div class="flex items-center justify-end space-x-3">
                                                <a class="flex gap-1 bg-primary text-white px-3 py-2 rounded" href="{{ route('booking.show', $booking->id) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                         stroke="currentColor" class="h-5 w-5 text-white">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                                    </svg>
                                                    Details
                                                </a>
                                            </div>
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
                    </div>

                    <div class="mt-10">
                        <h3 class="heading-5 mb-4">Recent Trips</h3>
                        <div class="overflow-auto">
                            <table class="w-full table whitespace-nowrap">
                                <thead class="bg-secondary text-gray-100 font-bold">
                                <tr>
                                    @if(Auth::user()->hasRole('admin'))
                                        <td class="py-2 pl-5">
                                            User
                                        </td>
                                    @endif
                                    <td class="py-2 pl-5">
                                        From → To / Date
                                    </td>
                                    <td class="py-2 pl-2">
                                        Transport
                                    </td>
                                    <td class="py-2 pl-2">
                                        Type of Items
                                    </td>
                                    <td class="py-2 pl-2">
                                        Price /Weight
                                    </td>
                                    <td class="py-2 pl-2">
                                        Status
                                    </td>
                                    <td class="py-2 pl-2 flex justify-end">
                                        Action
                                    </td>
                                </tr>
                                </thead>
                                <tbody class="text-sm">
                                @forelse ($trips as $trip)
                                    <tr class="odd:bg-white bg-gray-100 border-b hover:bg-primary hover:bg-opacity-20 transition duration-200">
                                        @if(Auth::user()->hasRole('admin'))
                                            <td class="py-3 pl-2">
                                                <img class="size-10 rounded-full object-cover" src="{{ $trip->user->profile_photo_url ?: 'https://ui-avatars.com/api/?name='.urlencode($trip->user->name).'&color=7F9CF5&background=EBF4FF' }}" alt="{{ $trip->user->name }}" title="{{ $trip->user->name }}" />
                                            </td>
                                        @endif
                                        <td class="py-3 pl-5">
                                            <div class="flex flex-col">
                                                <div class="flex items-center gap-2">
                                                    {{ $trip->fromCity?->name ? $trip->fromCity?->name .', ' : '' }} {{ $trip->fromCountry->name ?? '' }}
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-right">
                                                        <path d="M18 8L22 12L18 16"/>
                                                        <path d="M2 12H22"/>
                                                    </svg>
                                                    {{ $trip->toCity?->name ? $trip->toCity?->name .', ' : '' }} {{ $trip->toCountry->name ?? '' }}
                                                </div>
                                                <div class="text-xs text-gray-500">{{ getDateFormat($trip->departure_date) }} to {{ getDateFormat($trip->arrival_date) }}</div>
                                            </div>
                                        </td>
                                        <td class="py-3 pl-2">
                                            {{ $trip->mode_of_transport }}
                                        </td>
                                        <td class="py-3 pl-2">
                                            {{ $trip->type_of_item }}
                                        </td>
                                        <td class="py-3 pl-2">
                                            {{ getPrice($trip->price, $trip->currency) }}  / {{ $trip->available_space .' '. $trip->weight_unit }}
                                        </td>
                                        <td class="py-3 pl-2">
                                            @if($trip->status === 'Active')
                                                <x-status :content="$trip->status" :type="'warning'" />
                                            @elseif($trip->status === 'Confirmed')
                                                <x-status :content="$trip->status" :type="'verified'" />
                                            @elseif($trip->status === 'In Progress')
                                                <x-status :content="$trip->status" :type="'warning'" />
                                            @elseif($trip->status === 'Completed')
                                                <x-status :content="$trip->status" :type="'success'" />
                                            @elseif($trip->status === 'Cancelled')
                                                <x-status :content="$trip->status" :type="'error'" />
                                            @endif
                                        </td>
                                        <td class="py-3 pl-2">
                                            <div class="flex items-center justify-end space-x-3">
                                                <a class="flex gap-1 bg-primary text-white px-3 py-2 rounded" href="{{ route('trip.show', $trip->id) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                         stroke="currentColor" class="h-5 w-5 text-white">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                                    </svg>
                                                    Details
                                                </a>
                                            </div>
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
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
