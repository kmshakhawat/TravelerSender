<x-guest-layout>
    <livewire:trip-search />

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
</x-guest-layout>
