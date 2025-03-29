<div class="flex flex-col gap-4">
    <a href="{{ route('user.index') }}"
       class="profile-link {{ request()->routeIs('user.index') || request()->routeIs('user.edit') ? 'active' : '' }}"
    >
        {{ __('Users') }}
    </a>
    <a href="{{ route('user.create') }}"
       class="profile-link {{ request()->routeIs('user.create') ? 'active' : '' }}"
    >
        {{ __('Add New User') }}
    </a>
</div>
