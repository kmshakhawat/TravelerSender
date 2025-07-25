<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div x-data="profile" class="py-12">
        <div class="container">
            <div class="flex flex-col md:flex-row gap-8">
                <div class="w-full md:w-1/4">
                    <x-profile-sidebar />
                </div>
                <div class="w-full md:w-3/4">
                    <div class="bg-white border border-gray-50 rounded shadow p-4">
                        <h3 class="heading-5 mb-4 heading-title">{{ __('Account Verification') }}</h3>
                        <form id="verification" name="profile" @submit.prevent="submitVerification">
                            @csrf
                            <div class="flex flex-col sm:flex-row sm:gap-4">
                                <div class="w-full sm:w-1/2 mt-4">
                                    <x-label for="id_type" value="{{ __('ID Type') }}" />
                                    <x-input-dropdown class="id_type" name="id_type" :options="$id_type_options" :selected="[$user->profile->id_type ?? '']"/>
                                    <div class="invalid-feedback invalid-id_type"></div>
                                </div>
                                <div class="w-full sm:w-1/2 mt-4">
                                    <x-label for="id_number" value="{{ __('ID Number') }}" />
                                    <x-input id="id_number" class="block mt-1 w-full" type="text" name="id_number" :value="$user->profile->id_number ?? ''" required autofocus autocomplete="id_number" />
                                    <div class="invalid-feedback invalid-id_number"></div>
                                </div>
                            </div>
                            <div id="additional_date" style="display: none">
                                <div class="flex flex-col sm:flex-row sm:gap-4">
                                    <div class="w-full sm:w-1/2 mt-4">
                                        <x-label for="id_issue" value="{{ __('Issue Date') }}" />
                                        <x-input id="id_issue" class="block mt-1 w-full datepicker" type="text" name="id_issue" :value="$user->profile->id_issue ?? '' " autofocus autocomplete="id_issue" />
                                        <div class="invalid-feedback invalid-id_issue"></div>
                                    </div>
                                    <div class="w-full sm:w-1/2 mt-4">
                                        <x-label for="id_expiry" value="{{ __('Expiry Date') }}" />
                                        <x-input id="id_expiry" class="block mt-1 w-full datepicker" type="text" name="id_expiry" :value="$user->profile->id_expiry ?? '' " autofocus autocomplete="id_expiry" />
                                        <div class="invalid-feedback invalid-id_expiry"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <x-label for="dob" value="{{ __('Date of Birth') }}" />
                                <x-input id="dob" class="block mt-1 w-full datepicker" type="text" name="dob" :value="$user->profile->dob ?? '' " required autofocus autocomplete="dob" />
                                <div class="invalid-feedback invalid-dob"></div>
                            </div>

                            <h5 class="heading-5 mt-10 heading-title">{{ __('Upload your ID Card') }}</h5>
                            <div class="flex flex-col lg:flex-row mt-4 lg:gap-10">
                                <div class="w-full lg:w-2/3">
                                    <x-id-front :title="__('Upload Font Side')" :url="$user->profile->id_front ?? ''"/>
                                    <div class="border mb-8"></div>
                                    <x-id-back :title="__('Upload Back Side')" :url="$user->profile->id_back ?? ''"/>
                                </div>
                                <div class="border"></div>
                                <div class="w-full lg:w-1/3">
                                    <h3 class="heading-5 mb-4">Profile Photo</h3>
                                    <x-profile-photo :url="$user->profile_photo_url ?? ''" :name="$user->name"/>
                                </div>
                            </div>
                            <button class="btn-primary mt-4">{{ __('Update Verification Data') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                function toggleAdditionalDate() {
                    let id_type = $('.id_type').val();
                    if (id_type !== 'National ID') {
                        $('#additional_date').slideDown(100);
                    } else {
                        $('#additional_date').slideUp(100);
                    }
                }
                toggleAdditionalDate();
                $('.id_type').on('change', toggleAdditionalDate);
            });

            document.addEventListener('alpine:init', () => {
                Alpine.data('profile', () => ({
                    submitVerification: function () {
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
                            url: route('verification.update'),
                            data: new FormData(document.getElementById('verification')),
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
                                setTimeout(() => {
                                    window.location.reload();
                                }, 2000);
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
