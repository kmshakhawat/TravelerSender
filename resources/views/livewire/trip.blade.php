<div>
    <div class="grid grid-cols-1 col-end-auto sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 items-end justify-end">
        <select wire:model.change="from_country" name="from_country" class="search-input">
            <option value="">From</option>
            @foreach($countries as $country)
                <option
                    value="{{ $country->id }}" @selected($from_country === $country->id)>{{ $country->name }}</option>
            @endforeach
        </select>
        <select wire:model.change="to_country" name="to_country" class="search-input">
            <option value="">To</option>
            @foreach($countries as $country)
                <option
                    value="{{ $country->id }}" @selected($to_country === $country->id)>{{ $country->name }}</option>
            @endforeach
        </select>
        <input wire:model.live="city" type="text" name="city" value="{{ $city }}" placeholder="City"
               class="search-input">
        <select wire:model.change="status" name="status" class="search-input">
            <option value="">Status</option>
            @foreach($status_options as $key => $value)
                <option
                    value="{{ $key }}" @selected($status === $value)>{{ $value }}</option>
            @endforeach
        </select>
        <a class="btn-primary text-center xl:max-w-[120px]" href="{{ route('trip.index') }}">Reset</a>
    </div>
    <div class="overflow-auto">
        <table class="w-full table my-8 whitespace-nowrap">
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
                <td class="py-2 pl-2 text-end">
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
                            <x-status :content="$trip->status" :type="'info'" />
                        @elseif($trip->status === 'Confirmed')
                            <x-status :content="$trip->status" :type="'success'" />
                        @elseif($trip->status === 'In Progress')
                            <x-status :content="$trip->status" :type="'warning'" />
                        @elseif($trip->status === 'Completed')
                            <x-status :content="$trip->status" :type="'success'" />
                        @elseif($trip->status === 'Cancelled')
                            <x-status :content="$trip->status" :type="'error'" />
                        @endif
                    </td>
                    <td class="py-3 pl-2">
                        <div class="flex items-center justify-center space-x-3">
                            <a href="{{ route('trip.show', $trip->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                     stroke="currentColor" class="h-5 w-5 text-green-500 hover:text-green-800">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                </svg>
                            </a>
                            <a href="{{ route('trip.edit', $trip->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-5 w-5 text-yellow-500 hover:text-yellow-600" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                            </a>
                            <button type="button" @click.prevent="deleteTrip({{ $trip->id }})">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 hover:text-red-600"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
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
    <div class="mt-6">
        {{ $trips->links() }}
    </div>
</div>
