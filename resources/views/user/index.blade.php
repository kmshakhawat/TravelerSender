<x-app-layout>
    <x-slot name="header" class="flex">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>
    <div x-data="users" class="py-12">
        <div class="container">
            <div class="flex gap-8">
                <div class="w-1/4">
                    <x-user-sidebar />
                </div>
                <div class="w-3/4">
                    <div class="bg-white border border-gray-50 rounded shadow p-4">
                        <div class="flex justify-end">
                            <a class="btn-primary" href="{{ route('user.create') }}">Add New User</a>
                        </div>

                        <livewire:users />
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>

            document.addEventListener('alpine:init', () => {
                Alpine.data('users', () => ({
                    userDelete: function (user) {
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
                                axios.post(route('user.destroy', user), {
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
