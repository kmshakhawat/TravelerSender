<div class="flex flex-col gap-4">
    <a href="{{ route('trip.index') }}"
       class="profile-link {{ request()->routeIs('trip.index') || request()->routeIs('trip.edit') ? 'active' : '' }}"
    >
        {{ __('Trips') }}
    </a>
    <a href="{{ route('trip.create') }}"
       class="profile-link {{ request()->routeIs('trip.create') ? 'active' : '' }}"
    >
        {{ __('Add New Trip') }}
    </a>
</div>
