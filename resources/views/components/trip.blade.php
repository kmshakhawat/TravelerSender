@props(['trip', 'booking' => false])
@if($trip)
    <div class="bg-white border border-gray-10 rounded-lg p-4 mb-4">
    <div class="flex flex-col sm:flex-row items-center gap-8">
        <div class="w-full sm:w-1/4">
            <a href="{{ route('trip.details', $trip->id) }}">
                <img class="rounded-lg w-full" src="{{ $trip->user->profile_photo_path ? Storage::disk('public')->url($trip->user->profile_photo_path) : 'https://ui-avatars.com/api/?name='.urlencode($trip->user->name).'&color=7F9CF5&background=EBF4FF' }}" alt="{{ $trip->user->name }}">
            </a>
        </div>
        <div class="w-full sm:w-3/4 text-[#888888]">
            <div class="flex flex-col sm:flex-row">
                <div class="flex-1">
                    <h3 class="font-bold text-2xl text-black mb-1"><a href="{{ route('trip.details', $trip->id) }}">{{ $trip->user->name }}</a></h3>
                    <div class="flex gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 fill-primary">
                            <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                        </svg>
                        {{ $trip->user->averageRating() }} rating
                    </div>
                </div>
                <div class="flex-1 sm:text-right">
                    <div class="price">{{ getPrice($trip->price, $trip->currency) }}</div>
                </div>
            </div>
            <div class="my-4 border-b border-gray-100"></div>
            <div class="flex gap-2 mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-primary">
                    <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
                </svg>
                {{ $trip->fromCity?->name ? $trip->fromCity?->name.', ' : '' }}
                {{ $trip->fromCountry->name }}
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-right">
                    <path d="M18 8L22 12L18 16"/>
                    <path d="M2 12H22"/>
                </svg>
                {{ $trip->fromCity?->name ? $trip->toCity?->name . ', ' : '' }}
                {{ $trip->toCountry->name }}
            </div>
            <div class="flex gap-2 mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-primary">
                    <path d="M12.75 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM7.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8.25 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM9.75 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM10.5 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM12.75 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM14.25 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 13.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" />
                    <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd" />
                </svg>
                {{ getDateFormat($trip->departure_date) }}
            </div>
            <div class="flex gap-2 mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-primary">
                    <path d="M12.378 1.602a.75.75 0 0 0-.756 0L3 6.632l9 5.25 9-5.25-8.622-5.03ZM21.75 7.93l-9 5.25v9l8.628-5.032a.75.75 0 0 0 .372-.648V7.93ZM11.25 22.18v-9l-9-5.25v8.57a.75.75 0 0 0 .372.648l8.628 5.033Z" />
                </svg>
                {{ $trip->available_space.' '. $trip->weight_unit }}
            </div>
            <div class="my-4 border-b border-gray-100"></div>
            <div class="flex flex-col text-center sm:flex-row gap-4">
                @if($booking)
                    <a class="btn-primary"
                       @if(Auth::user() && Auth::user()->verified)
                           href="{{ route('booking', $trip->id) }}"
                       @elseif(Auth::user() && !Auth::user()->verified)
                           @click.prevent="verifiedAlert"
                        @else
                            @click.prevent="loginAlert"
                        @endif
                    >
                        Send my Parcel
                    </a>
                @endif
                <a class="btn-primary"
                   @if(Auth::user() && Auth::user()->verified)
                       href="{{ route('message', $trip->user_id) }}"
                   @elseif(Auth::user() && !Auth::user()->verified)
                       @click.prevent="verifiedAlert"
                   @else
                       @click.prevent="loginAlert"
                    @endif
                >
                    Message
                </a>
                <a class="btn-secondary" href="{{ route('trip.details', $trip->id) }}">Trip Details</a>
            </div>
        </div>
    </div>
</div>
@endif
