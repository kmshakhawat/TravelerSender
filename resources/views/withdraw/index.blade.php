<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Earnings') }}
        </h2>
    </x-slot>
    <div x-data="travel" class="py-12">
        <div class="container">
            <div class="bg-white border border-gray-50 rounded shadow p-4">
                <div class="overflow-auto">
                    <table class="w-full table whitespace-nowrap">
                        <thead class="bg-secondary text-gray-100 font-bold">
                        <td class="py-2 pl-5 flex">
                            Trip
                        </td>
                        <td class="py-2 pl-2">
                            Amount
                        </td>
                        <td class="py-2 pl-2">
                            Net Amount
                        </td>
                        <td class="py-2 pl-2">
                            Commission
                        </td>
                        <td class="py-2 pl-2">
                            Status
                        </td>
                        <td class="py-2 pl-2 flex justify-end">
                            Payouts
                        </td>
                        </thead>
                        <tbody class="text-sm">
                        @forelse($withdraws as $withdraw)
                            <tr>
                                <td class="py-3 pl-5">
                                    <div class="flex flex-col">
                                        <a class="flex items-center gap-2" href="{{ route('trip.show', $withdraw->booking->trip->id) }}">
                                            {{ $withdraw->booking->trip->fromCountry->name ?? '' }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-right">
                                                <path d="M18 8L22 12L18 16"/>
                                                <path d="M2 12H22"/>
                                            </svg>
                                            {{ $withdraw->booking->trip->toCountry->name ?? '' }}
                                        </a>
                                        <div class="text-xs text-gray-500">{{ getDateFormat($withdraw->booking->trip->departure_date) }} to {{ getDateFormat($withdraw->booking->trip->arrival_date) }}</div>
                                    </div>
                                </td>
                                <td class="py-3 pl-5">
                                    {{ getPrice($withdraw->amount, $withdraw->booking->trip->currency) }}
                                </td>
                                <td class="py-3 pl-5">
                                    {{ getPrice($withdraw->net_amount, $withdraw->booking->trip->currency) }}
                                </td>
                                <td class="py-3 pl-5">
                                    {{ getPrice($withdraw->commission, $withdraw->booking->trip->currency) }}
                                </td>
                                <td class="py-3 pl-5">
                                    @if($withdraw->status === 'Pending')
                                        <x-status :content="$withdraw->status" :type="'info'" />
                                    @elseif($withdraw->status === 'Complete')
                                        <x-status :content="$withdraw->status" :type="'success'" />
                                    @elseif($withdraw->status === 'Failed')
                                        <x-status :content="$withdraw->status" :type="'error'" />
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="flex items-center justify-end space-x-3">
                                        @if($withdraw->withdraw)
                                            <button class="btn-primary">{{ $withdraw->withdraw->status }}</button>
                                            <button @click.prevent="submitPayment({{ $withdraw->id }})" class="btn-secondary">Pay Now!</button>
                                        @else
                                            <button @click.prevent="submitWithdraw({{ $withdraw->id }})" class="btn-primary">Withdraw</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-gray-100 align-top hover:bg-primary hover:bg-opacity-20 transition duration-200">
                                <td colspan="10" class="text-center py-4">
                                    <div class="not-found">Data Not Found!!</div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">
                    {{ $withdraws->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('travel', () => ({
                    submitWithdraw     : function (payment) {
                        axios.get(route('withdraw.request', payment))
                            .then(response => {
                                this.$nextTick(() => {
                                    flatpickr(".datepicker", {
                                        altInput: true,
                                        altFormat: "F j, Y",
                                        dateFormat: "Y-m-d",
                                    });
                                });
                                this.$store.app.showModal       = true;
                                this.$refs.modalContent.innerHTML = response.data.withdraw;
                            })
                            .catch(error => {
                                console.log(error);
                            });
                    },
                    withdrawAction    : function (payment) {
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
                            url    : route('withdraw.store', payment),
                            data   : new FormData(this.$refs.withdrawForm),
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
                                this.$store.app.showModal = false;
                                location.reload();
                            })
                            .catch(error => {
                                window.showJsonErrorMessage(error);
                            });
                    },
                    submitPayment     : function (payment) {
                        axios.get(route('withdraw.payment', payment))
                            .then(response => {
                                this.$nextTick(() => {
                                    flatpickr(".datepicker", {
                                        altInput: true,
                                        altFormat: "F j, Y",
                                        dateFormat: "Y-m-d",
                                    });
                                });
                                this.$store.app.showModal       = true;
                                this.$refs.modalContent.innerHTML = response.data.withdraw;
                            })
                            .catch(error => {
                                console.log(error);
                            });
                    },
                    paymentAction    : function (payment) {
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
                            url    : route('withdraw.store', payment),
                            data   : new FormData(this.$refs.payForm),
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
                                this.$store.app.showModal = false;
                                location.reload();
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
