<x-app-layout>
    <x-slot name="header" class="flex">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Trips') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="container">
            <div class="flex gap-8">
                <div class="w-1/4">
                    <x-trip-sidebar />
                </div>
                <div class="w-3/4">
                    <div class="bg-white border border-gray-50 rounded shadow p-4">
                        <div class="flex justify-end">
                            <a class="btn-primary" href="{{ route('trip.create') }}">Add New Trip</a>
                        </div>

                        <livewire:trips />
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>

            document.addEventListener('alpine:init', () => {
                Alpine.data('talent', () => ({
                    addTalent: function () {
                        axios.get(route('admin.talent.create'))
                            .then(response => {
                                this.$nextTick(() => {
                                    $('.select2').select2();
                                });
                                this.$store.admin.showModal = true;
                                this.$refs.modalContent.innerHTML = response.data.create;
                            })
                            .catch(error => {
                                console.log(error);
                            });
                    },
                    storeTalent: function () {
                        Swal.fire({
                            title: 'Creating...',
                            allowOutsideClick: true,
                            icon: 'info',
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        axios({
                            method: 'POST',
                            url: route('admin.talent.store'),
                            data: new FormData(this.$refs.talentForm),
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        })
                            .then(response => {
                                Swal.fire({
                                    title: 'Success!',
                                    text: response.data.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                                this.$store.admin.showModal = false;
                                location.reload();
                            })
                            .catch(error => {
                                window.showJsonErrorMessage(error);
                            });
                    },
                    showTalentDetails: function (talent) {
                        axios.get(route('admin.talent.show', talent))
                            .then(response => {
                                this.$store.admin.showModal = true;
                                this.$refs.modalContent.innerHTML = response.data.show;
                            })
                            .catch(error => {
                                console.log(error);
                            });
                    },
                    showTalentEdit: function (talent) {
                        axios.get(route('admin.talent.edit', talent))
                            .then(response => {
                                this.$nextTick(() => {
                                    $('.select2').select2();
                                });
                                this.$store.admin.showModal = true;
                                this.$refs.modalContent.innerHTML = response.data.edit;
                            })
                            .catch(error => {
                                console.log(error);
                            });
                    },
                    editTalent: function ( talent ) {
                        Swal.fire({
                            title: 'Updating...',
                            allowOutsideClick: true,
                            icon: 'info',
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        axios({
                            method: 'POST',
                            url: route('admin.talent.update', talent),
                            data: new FormData(this.$refs.talentEditForm),
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        })
                            .then(response => {
                                Swal.fire({
                                    title: 'Success!',
                                    text: response.data.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                                this.$store.admin.showModal = false;
                                location.reload();
                            })
                            .catch(error => {
                                window.showJsonErrorMessage(error);
                            });
                    },
                    deleteTalent: function (talent) {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: 'You will not be able to recover this talent!',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, delete it!',
                            cancelButtonText: 'No, cancel!',
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                axios.post(route('admin.talent.destroy', talent), {
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
