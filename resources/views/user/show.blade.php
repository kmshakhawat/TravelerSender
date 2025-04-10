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
                        <div class="flex items-center justify-between heading-title">
                            <h3 class="heading-5 mb-4">{{ $user->name }} Information</h3>
                            <a class="btn-secondary" href="{{ route('user.index') }}">Back</a>
                        </div>
                        <div class="overflow-auto">
                            <table class="w-full table mb-8 whitespace-nowrap">
                                <tr>
                                    <td>Full Name</td>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <td>Email Address</td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td>Phone Number</td>
                                    <td>{{ $user->phone }}</td>
                                </tr>
                                <tr>
                                    <td>Address Line One</td>
                                    <td>{{ $user->profile->address_1 ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>Address Line Two</td>
                                    <td>{{ $user->profile->address_2 ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>City</td>
                                    <td>{{ $user->profile->city ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>State</td>
                                    <td>{{ $user->profile->state ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>Postcode</td>
                                    <td>{{ $user->profile->postcode ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>Country</td>
                                    <td>{{ $user->profile->country->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>Bank Details</td>
                                    <td>{{ $user->profile->bank_details ?? '' }}</td>
                                </tr>
                                @if($user->photo)
                                    <tr>
                                        <td class="align-top">Photo</td>
                                        <td>
                                            <x-photo :file="$user->photo" :title="'Photo'" :name="'photo'" :show="true" :upload="false" />
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td>Status</td>
                                    <td>
                                        @if($user->status === 'Active')
                                            <x-status :content="$user->status" :type="'success'" />
                                        @elseif($user->status === 'Inactive')
                                            <x-status :content="$user->status" :type="'danger'" />
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <h3 class="heading-5">Verification Details</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td>ID Type</td>
                                    <td>{{ $user->profile->id_type ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>ID Number</td>
                                    <td>{{ $user->profile->id_number ?? '' }}</td>
                                </tr>
                                @if(isset($user->profile->id_issue))
                                    <tr>
                                        <td>Issue Date</td>
                                        <td>{{ getDateFormat($user->profile->id_issue, 'd-M-Y') }}</td>
                                    </tr>
                                @endif
                                @if(isset($user->profile->id_expiry))
                                    <tr>
                                        <td>Expiry Date</td>
                                        <td>{{ getDateFormat($user->profile->id_expiry, 'd-M-Y') }}</td>
                                    </tr>
                                @endif
                                @if(isset($user->profile->dob))
                                    <tr>
                                        <td>Date of Birth</td>
                                        <td>{{ getDateFormat($user->profile->dob, 'd-M-Y') }}</td>
                                    </tr>
                                @endif
                                @if(isset($user->profile->id_front) && $user->profile->id_front)
                                    <tr>
                                        <td class="align-top">ID Front</td>
                                        <td>
                                            <a href="{{ Storage::disk('public')->url($user->profile->id_front) }}" data-lightbox="id-front">
                                                <img class="max-w-48 cursor-pointer" src="{{ Storage::disk('public')->url($user->profile->id_front) }}" alt="{{ $user->name }}">
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                                @if(isset($user->profile->id_back) && $user->profile->id_back)
                                    <tr>
                                        <td class="align-top">ID Back</td>
                                        <td>
                                            <a href="{{ Storage::disk('public')->url($user->profile->id_back) }}" data-lightbox="id-back">
                                                <img class="max-w-48 cursor-pointer" src="{{ Storage::disk('public')->url($user->profile->id_back) }}" alt="{{ $user->name }}">
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                                @if(isset($user->profile->photo))
                                    <tr>
                                        <td class="align-top">Photo</td>
                                        <td>
                                            <a href="{{ Storage::disk('public')->url($user->profile->photo) }}" data-lightbox="photo">
                                                <img class="max-w-48 cursor-pointer" src="{{ Storage::disk('public')->url($user->profile->photo) }}" alt="{{ $user->name }}">
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                            </table>
                            <form id="update" name="profile" x-data="users({{ $user->id }}, {{ $user->verified ? 'true' : 'false' }})">
                                @csrf
                                @method('PUT')

                                <div class="flex gap-4 my-4 items-center">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="verified" x-model="verified" @change="updateUserVerification" class="sr-only peer">
                                        <div class="w-[53px] h-7 bg-gray-200 hover:bg-gray-300 peer-focus:outline-0 peer-focus:ring-transparent rounded-full peer transition-all ease-in-out duration-500 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-primary hover:peer-checked:bg-primary"></div>
                                    </label>
                                    <label class="inline-block">Verified</label>
                                </div>
                            </form>
                            <div class="flex gap-3">
                                <a class="btn-primary" href="{{ route('user.edit', $user->id) }}">Edit</a>
                                <a class="btn-secondary" href="{{ route('user.index') }}">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('users', (userId, isVerified) => ({
                    verified: isVerified,

                    async updateUserVerification() {
                        Swal.fire({
                            title: 'Updating...',
                            allowOutsideClick: false,
                            icon: 'info',
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        try {
                            let formData = new FormData();
                            formData.append('_method', 'PUT');
                            formData.append('_token', document.querySelector('input[name=_token]').value);
                            formData.append('verified', this.verified ? 1 : 0);

                            let response = await axios.post(route('user.update.verification', userId), formData, {
                                headers: { 'Content-Type': 'multipart/form-data' }
                            });

                            if (response.data.success) {
                                Swal.fire({
                                    title: 'Updated!',
                                    text: 'Verification status has been updated.',
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            }
                        } catch (error) {
                            console.error('Error updating verification:', error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to update verification status.',
                                icon: 'error'
                            });
                        }
                    }
                }));
            });
        </script>
    @endpush
</x-app-layout>
