<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="flex gap-8">
                <div class="w-1/4">
                    <x-sidebar />
                </div>
                <div class="w-3/4">
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
