<x-app-layout>
    <x-slot name="header" class="flex">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Users') }}
            </h2>
            <a class="btn-primary" href="{{ route('user.create') }}">Add New User</a>
        </div>
    </x-slot>
    <div x-data="users" class="py-12">
        <div class="container">
            <div class="flex flex-col md:flex-row gap-8">
                <div class="w-full md:w-1/4">
                    <x-user-sidebar />
                </div>
                <div class="w-full md:w-3/4">
                    <div class="bg-white border border-gray-50 rounded shadow p-4">
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
                    },
                }));
                Alpine.data('verifyToggle', (userId, initialVerified) => ({
                    userId: userId,
                    verified: initialVerified,
                    confirmToggle() {
                        const newStatus = !this.verified;
                        Swal.fire({
                            title: 'Are you sure?',
                            text: `You are about to ${newStatus ? 'verify' : 'unverified'} this user.`,
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Yes',
                            cancelButtonText: 'Cancel'
                        }).then(result => {
                            if (result.isConfirmed) {
                                this.updateVerifiedStatus(newStatus);
                            }
                        });
                    },
                    updateVerifiedStatus(status) {
                        Swal.fire({ title: 'Updating...', didOpen: () => Swal.showLoading() });
                        axios.post(route('user.update.verification', { user: this.userId }), {
                            verified: status ? 1 : 0,
                            _method: 'PUT',
                            _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        })
                            .then(res => {
                                this.verified = status;
                                Swal.fire({ title: 'Updated!', icon: 'success', timer: 1500 });
                                location.reload();
                            })
                            .catch(err => {
                                Swal.fire({ title: 'Error', text: 'Could not update status.', icon: 'error' });
                                location.reload();
                            });
                    }
                }));
            });
        </script>
    @endpush
</x-app-layout>
