<x-app-layout>
    <x-slot name="header" class="flex">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Trips') }}
            </h2>
            <a class="btn-primary" href="{{ route('trip.create') }}">Add New Trip</a>
        </div>
    </x-slot>
    <div x-data="trip" class="py-12">
        <div class="container">
            <div class="flex flex-col md:flex-row gap-8">
                <div class="w-full md:w-1/4">
                    <x-trip-sidebar />
                </div>
                <div class="w-full md:w-3/4">
                    <div class="bg-white border border-gray-50 rounded shadow p-4">
                        <livewire:trips />
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>

            document.addEventListener('alpine:init', () => {
                Alpine.data('trip', () => ({
                    deleteTrip: function (trip) {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: 'You will not be able to recover this!',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, delete it!',
                            cancelButtonText: 'No, cancel!',
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                axios.post(route('trip.destroy', trip), {
                                    _method: 'DELETE',
                                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                })
                                    .then(response => {
                                        Swal.fire({
                                            title: 'Deleted!',
                                            text: response.data.message,
                                            icon: 'success',
                                            confirmButtonText: 'OK'
                                        });
                                        location.reload();
                                    })
                                    .catch(error => {
                                        Swal.fire({
                                            title: 'Error!',
                                            text: error.response.data.message || 'Something went wrong!',
                                            icon: 'error',
                                            confirmButtonText: 'OK'
                                        });
                                    });
                            }
                        });
                    }

                }));
            });
        </script>
    @endpush
</x-app-layout>
