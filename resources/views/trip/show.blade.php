<x-app-layout>
    <x-slot name="header" class="flex">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Trip') }}
        </h2>
    </x-slot>
    <div x-data="trip" class="py-12">
        <div class="container">
            <div class="flex gap-8">
                <div class="w-1/4">
                    <x-trip-sidebar />
                </div>
                <div class="w-3/4">
                    <div class="bg-white border border-gray-50 rounded shadow p-4">
                        <h3 class="heading-5 mb-4 heading-title">Trip Information</h3>
                        <div class="overflow-auto">
                            <table class="w-full table my-8 whitespace-nowrap">
                                <tr>
                                    <td>Trip Type</td>
                                    <td>{{ $trip->trip_type }}</td>
                                </tr>
                                <tr>
                                    <td>Mode of Transport</td>
                                    <td>{{ $trip->mode_of_transport }}</td>
                                </tr>
                                <tr>
                                    <td>From</td>
                                    <td>{{ $trip->from }}</td>
                                </tr>
                                <tr>
                                    <td>To</td>
                                    <td>{{ $trip->to }}</td>
                                </tr>
                                <tr>
                                    <td>Date & Time of Departure</td>
                                    <td>{{ $trip->departure_date }}</td>
                                </tr>
                                <tr>
                                    <td>Estimated Time of Arrival</td>
                                    <td>{{ $trip->arrival_date }}</td>
                                </tr>
                                <tr>
                                    <td>Stopovers (If applicable)</td>
                                    <td>{{ $trip->stopovers }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <h3 class="heading-5">Luggage & Courier Details</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Available Space/Weight Limit (in kg/lbs)</td>
                                    <td>{{ $trip->available_space }}</td>
                                </tr>
                                <tr>
                                    <td>Type of Items Allowed</td>
                                    <td>{{ $trip->type_of_item }}</td>
                                </tr>
                                <tr>
                                    <td>Packaging Requirements</td>
                                    <td>{{ $trip->packaging_requirement }}</td>
                                </tr>
                                <tr>
                                    <td>Handling Instructions</td>
                                    <td>{{ $trip->handling_instruction }}</td>
                                </tr>
                                <tr>
                                    <td>Price {{ $user->profile->currency->symbol}}</td>
                                    <td>{{$trip->converted_price }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('trip', () => ({
                    storeTrip: function () {
                        const formData = new FormData(document.getElementById('create'));
                        Swal.fire({
                            title            : 'Creating...',
                            allowOutsideClick: true,
                            icon             : 'info',
                            didOpen          : () => {
                                Swal.showLoading();
                            }
                        });
                        axios({
                            method : 'POST',
                            url    : route('trip.store'),
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
                                window.location.href = route('trip.index');
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
