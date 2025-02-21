<div class="border-b border-gray-300">
    <div class="container mx-auto py-4">
        <div class="flex items-center justify-between">
            <div class="logo">
                <a href="/"><img src="{{ asset('asset/img/logo.png') }}" alt="{{ config('app.name') }}"></a>
            </div>
            <div class="flex items-center gap-6 text-lg font-medium">
                <a class="btn-secondary" href="{{ route('register') }}">Registration</a>
                <a class="btn-primary" href="{{ route('login') }}">Sign in</a>
            </div>
        </div>
    </div>
</div>
