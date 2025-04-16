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
                    <div class="grid grid-cols-4 gap-6">
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
                            <div class="flex gap-1 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 text-primary">
                                    <path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/><path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/>
                                </svg>
                                <h4 class="heading-5">Total Earnings</h4>
                            </div>
                            <div class="text-3xl font-semibold text-primary">{{ getPrice($earnings) }}</div>
                        </div>
                        <div class="bg-white p-4 rounded">
                            <div class="flex gap-1 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-primary">
                                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                                </svg>
                                <h4 class="heading-5">Rating</h4>
                            </div>
                            <div class="text-3xl font-semibold text-primary">{{ $avg_rating }}</div>
                        </div>
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
                        <h3 class="heading-5 mb-4">Recent Order</h3>
                    </div>

                    <div class="mt-10">
                        <h3 class="heading-5 mb-4">Recent Trips</h3>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
