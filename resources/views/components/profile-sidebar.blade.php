<div class="flex flex-col gap-4">
    <a href="{{ route('profile') }}"
       class="profile-link {{ request()->routeIs('profile') ? 'active' : '' }}"
    >
        {{ __('Profile') }}
    </a>
    <a href="{{ route('verification') }}"
       class="profile-link {{ request()->routeIs('verification') ? 'active' : '' }}"
    >
        {{ __('Account Verification') }}
    </a>
    <a href="" class="profile-link">{{ __('Setting') }}</a>
</div>
