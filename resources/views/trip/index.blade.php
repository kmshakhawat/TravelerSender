<x-app-layout>
    <x-slot name="header" class="flex">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Trips') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="container">
            <div class="flex justify-end">
                <a class="btn-primary" href="#">Add New Trip</a>
            </div>
            <div class="overflow-auto">
                <table class="w-full table my-8 whitespace-nowrap">
                    <thead class="bg-secondary text-gray-100 font-bold">
                        <td class="py-2 pl-5">
                            From → To / Date
                        </td>
                        <td class="py-2 pl-2">
                            Transport
                        </td>
                        <td class="py-2 pl-2">
                            Type of Items
                        </td>
                        <td class="py-2 pl-2">
                            Price /Weight
                        </td>
                        <td class="py-2 pl-2">
                            Status
                        </td>
                        <td class="py-2 pl-2 text-end">
                            Action
                        </td>
                    </thead>
                    <tbody class="text-sm">
{{--                    @forelse($talents as $talent)--}}
<tr class="odd:bg-white bg-gray-100 border-b hover:bg-primary hover:bg-opacity-20 transition duration-200">
    <td class="py-3 pl-5">
        <div class="flex flex-col">
            <div class="flex items-center gap-2">London
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-right">
                    <path d="M18 8L22 12L18 16"/>
                    <path d="M2 12H22"/>
                </svg>
                Manchester
            </div>
            <div class="text-xs text-gray-500">15 Apr 25 to 20 Apr 25</div>
        </div>
    </td>
    <td class="py-3 pl-2">
        Flight
    </td>
    <td class="py-3 pl-2">
        Document
    </td>
    <td class="py-3 pl-2">
        £50  / 10 kg max
    </td>
    <td class="py-3 pl-2">
        Available
    </td>
    <td class="py-3 pl-2">
        <div class="flex items-center justify-center space-x-3">
            <a href="#">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="h-5 w-5 text-green-500 hover:text-green-800">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                </svg>
            </a>
            <a href="#">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5 text-yellow-500 hover:text-yellow-600" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
            </a>
            <button type="button" @click.prevent="deleteTalent(1)">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 hover:text-red-600"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </button>
        </div>
    </td>
</tr>
<tr class="odd:bg-white bg-gray-100 border-b hover:bg-primary hover:bg-opacity-20 transition duration-200">
    <td class="py-3 pl-5">
        <div class="flex flex-col">
            <div class="flex items-center gap-2">London
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-right">
                    <path d="M18 8L22 12L18 16"/>
                    <path d="M2 12H22"/>
                </svg>
                Manchester
            </div>
            <div class="text-xs text-gray-500">15 Apr 25 to 20 Apr 25</div>
        </div>
    </td>
    <td class="py-3 pl-2">
        Flight
    </td>
    <td class="py-3 pl-2">
        Document
    </td>
    <td class="py-3 pl-2">
        £50  / 10 kg max
    </td>
    <td class="py-3 pl-2">
        Available
    </td>
    <td class="py-3 pl-2">
        <div class="flex items-center justify-center space-x-3">
            <a href="#">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="h-5 w-5 text-green-500 hover:text-green-800">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                </svg>
            </a>
            <a href="#">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5 text-yellow-500 hover:text-yellow-600" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
            </a>
            <button type="button" @click.prevent="deleteTalent(1)">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 hover:text-red-600"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
        </div>
    </td>
</tr>
<tr class="odd:bg-white bg-gray-100 border-b hover:bg-primary hover:bg-opacity-20 transition duration-200">
    <td class="py-3 pl-5">
        <div class="flex flex-col">
            <div class="flex items-center gap-2">London
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-right">
                    <path d="M18 8L22 12L18 16"/>
                    <path d="M2 12H22"/>
                </svg>
                Manchester
            </div>
            <div class="text-xs text-gray-500">15 Apr 25 to 20 Apr 25</div>
        </div>
    </td>
    <td class="py-3 pl-2">
        Flight
    </td>
    <td class="py-3 pl-2">
        Document
    </td>
    <td class="py-3 pl-2">
        £50  / 10 kg max
    </td>
    <td class="py-3 pl-2">
        Available
    </td>
    <td class="py-3 pl-2">
        <div class="flex items-center justify-center space-x-3">
            <a href="#">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="h-5 w-5 text-green-500 hover:text-green-800">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                </svg>
            </a>
            <a href="#">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5 text-yellow-500 hover:text-yellow-600" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
            </a>
            <button type="button" @click.prevent="deleteTalent(1)">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 hover:text-red-600"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
        </div>
    </td>
</tr>
<tr class="odd:bg-white bg-gray-100 border-b hover:bg-primary hover:bg-opacity-20 transition duration-200">
    <td class="py-3 pl-5">
        <div class="flex flex-col">
            <div class="flex items-center gap-2">London
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-right">
                    <path d="M18 8L22 12L18 16"/>
                    <path d="M2 12H22"/>
                </svg>
                Manchester
            </div>
            <div class="text-xs text-gray-500">15 Apr 25 to 20 Apr 25</div>
        </div>
    </td>
    <td class="py-3 pl-2">
        Flight
    </td>
    <td class="py-3 pl-2">
        Document
    </td>
    <td class="py-3 pl-2">
        £50  / 10 kg max
    </td>
    <td class="py-3 pl-2">
        Available
    </td>
    <td class="py-3 pl-2">
        <div class="flex items-center justify-center space-x-3">
            <a href="#">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="h-5 w-5 text-green-500 hover:text-green-800">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                </svg>
            </a>
            <a href="#">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5 text-yellow-500 hover:text-yellow-600" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
            </a>
            <button type="button" @click.prevent="deleteTalent(1)">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 hover:text-red-600"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
        </div>
    </td>
</tr>
<tr class="odd:bg-white bg-gray-100 border-b hover:bg-primary hover:bg-opacity-20 transition duration-200">
    <td class="py-3 pl-5">
        <div class="flex flex-col">
            <div class="flex items-center gap-2">London
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-right">
                    <path d="M18 8L22 12L18 16"/>
                    <path d="M2 12H22"/>
                </svg>
                Manchester
            </div>
            <div class="text-xs text-gray-500">15 Apr 25 to 20 Apr 25</div>
        </div>
    </td>
    <td class="py-3 pl-2">
        Flight
    </td>
    <td class="py-3 pl-2">
        Document
    </td>
    <td class="py-3 pl-2">
        £50  / 10 kg max
    </td>
    <td class="py-3 pl-2">
        Available
    </td>
    <td class="py-3 pl-2">
        <div class="flex items-center justify-center space-x-3">
            <a href="#">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="h-5 w-5 text-green-500 hover:text-green-800">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                </svg>
            </a>
            <a href="#">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5 text-yellow-500 hover:text-yellow-600" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
            </a>
            <button type="button" @click.prevent="deleteTalent(1)">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 hover:text-red-600"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
        </div>
    </td>
</tr>
{{--                    @empty--}}
{{--                        <tr class="bg-gray-100 align-top hover:bg-primary hover:bg-opacity-20 transition duration-200">--}}
{{--                            <td colspan="10" class="text-center py-4">--}}
{{--                                <div class="not-found">Data Not Found!!</div>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @endforelse--}}
                    </tbody>
                </table>
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
