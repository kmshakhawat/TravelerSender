<x-app-layout>
    <x-slot name="header" class="flex">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Rate the Traveler') }}
            </h2>
            {{--            <a class="btn-secondary" href="{{ route('chat') }}">Back</a>--}}
        </div>
    </x-slot>
    <div class="container">
        <div class="max-w-7xl mx-auto my-4 sm:my-8 sm:px-6 lg:px-8">
            <form id="booking" method="POST" @submit.prevent="bookTrip">
                @csrf
                <input type="hidden" id="traveler_id" value="{{ $traveler->id }}">

            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('booking', () => ({

                    bookTrip: function () {
                        const formData = new FormData(document.getElementById('booking'));
                        Swal.fire({
                            title            : 'Processing...',
                            allowOutsideClick: true,
                            icon             : 'info',
                            didOpen          : () => {
                                Swal.showLoading();
                            }
                        });
                        axios({
                            method : 'POST',
                            url    : route('booking.store'),
                            data   : formData,
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        })
                            .then(response => {
                                Swal.fire({
                                    title            : 'Success!',
                                    text             : response.data.message,
                                    icon             : 'success',
                                    confirmButtonText: 'OK'
                                });
                                window.location.href = route('booking.index');
                            })
                            .catch(error => {
                                window.showJsonErrorMessage(error);
                            });
                    },

                }));
            });
        </script>
    @endpush
</x-app-layout>
