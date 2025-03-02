<div class="flex flex-col gap-4">
    <a href="{{ route('trip.index') }}"
       class="profile-link {{ request()->routeIs('trip.index') ? 'active' : '' }}"
    >
        {{ __('Trips') }}
    </a>
    <a href="{{ route('trip.create') }}"
       class="profile-link {{ request()->routeIs('trip.create') ? 'active' : '' }}"
    >
        {{ __('Add New Trip') }}
    </a>
    <a href="" class="profile-link">{{ __('Setting') }}</a>
</div>
