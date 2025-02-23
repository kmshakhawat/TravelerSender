<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div x-data="profile" class="py-12">
        <div class="container">
            <div class="flex gap-8">
                <div class="w-1/4">
                    <x-sidebar />
                </div>
                <div class="w-3/4">
                    <div class="bg-white border border-gray-50 rounded shadow p-4">
                        <h3 class="heading-5 mb-4">Profile</h3>
                        <form id="profile" name="profile" @submit.prevent="submitProfile">
                            @csrf
                            <div>
                                <x-profile-photo :url="$user->profile_photo_url" :name="$user->name"/>
                            </div>
                            <div class="mt-4">
                                <x-label for="name" value="{{ __('Full Name') }}" />
                                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$user->name" required autofocus autocomplete="name" />
                                <div class="invalid-feedback invalid-name"></div>
                            </div>
                            <div class="flex gap-4">
                                <div class="w-full sm:w-1/2 mt-4">
                                    <x-label for="email" value="{{ __('Email Address') }}" />
                                    <x-input disabled id="email" class="block mt-1 w-full" type="email" name="email" :value="$user->email" required autocomplete="username" />
                                    <div class="invalid-feedback invalid-email"></div>
                                </div>
                                <div class="w-full sm:w-1/2 mt-4">
                                    <x-label for="phone" value="{{ __('Phone Number') }}" />
                                    <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="$user->phone" required autofocus autocomplete="phone" />
                                    <div class="invalid-feedback invalid-phone"></div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <x-label for="address_1" value="{{ __('Address Line One') }}" />
                                <textarea
                                    name="address_1"
                                    id="address_1"
                                    class="form-input">{{ $user->profile->address_1 }}</textarea>
                                <div class="invalid-feedback invalid-address_1"></div>
                            </div>
                            <div class="mt-4">
                                <x-label for="address_2" value="{{ __('Address Line Two') }}" />
                                <textarea
                                    name="address_2"
                                    id="address_2"
                                    class="form-input">{{ $user->profile->address_2 }}</textarea>
                                <div class="invalid-feedback invalid-address_2"></div>
                            </div>
                            <div class="flex gap-4">
                                <div class="w-full sm:w-1/2 mt-4">
                                    <x-label for="city" value="{{ __('City') }}" />
                                    <x-input id="city" class="block mt-1 w-full" type="text" name="city" :value="$user->profile->city" required autofocus autocomplete="phone" />
                                    <div class="invalid-feedback invalid-city"></div>
                                </div>
                                <div class="w-full sm:w-1/2 mt-4">
                                    <x-label for="state" value="{{ __('State') }}" />
                                    <x-input id="state" class="block mt-1 w-full" type="text" name="state" :value="$user->profile->state" required autofocus autocomplete="phone" />
                                    <div class="invalid-feedback invalid-state"></div>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="w-full sm:w-1/2 mt-4">
                                    <x-label for="postcode" value="{{ __('Postcode') }}" />
                                    <x-input id="postcode" class="block mt-1 w-full" type="text" name="postcode" :value="$user->profile->postcode" required autofocus autocomplete="phone" />
                                    <div class="invalid-feedback invalid-postcode"></div>
                                </div>
                                <div class="w-full sm:w-1/2 mt-4">
                                    <x-label for="country_id" value="{{ __('Country') }}" />
                                    <x-input-dropdown name="country_id" :options="$countries" :selected="[$user->country_id]"/>
                                    <div class="invalid-feedback invalid-country_id"></div>
                                </div>
                            </div>
                            <button class="btn-primary mt-4">{{ __('Update Profile') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('profile', () => ({
                    submitProfile: function () {
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
                            url: route('profile.update'),
                            data: new FormData(document.getElementById('profile')),
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
