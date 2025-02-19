<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex gap-8">
                <div class="sidebar w-1/4">
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6">
                            <x-sidebar />
                        </div>
                    </div>
                </div>
                <div class="w-3/4">
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
