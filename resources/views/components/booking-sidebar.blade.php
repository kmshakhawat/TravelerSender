<div class="flex flex-col gap-4">
    <a href="{{ route('booking.index') }}"
       class="profile-link {{ request()->routeIs('booking.index') || request()->routeIs('booking.index') ? 'active' : '' }}"
    >
        {{ __('Booking') }}
    </a>
</div>
