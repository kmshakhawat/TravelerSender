<div>
    <div class="grid grid-cols-1 col-end-auto sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 items-end justify-end">
        <div class="flex w-full flex-col">
            <select wire:model.change="country_id" name="country_id" class="search-input">
                <option value="">Country</option>
                @foreach($countries as $country)
                    <option
                        value="{{ $country->id }}" @selected($country_id === $country->id)>{{ $country->name }}</option>
                @endforeach
            </select>
        </div>
        <input wire:model.live="city" type="text" name="city" value="{{ $city }}" placeholder="City"
               class="search-input">
        <input wire:model.live="search" type="text" name="search" value="{{ $search }}" placeholder="Keyword"
               class="search-input">
        <a class="btn-primary text-center xl:max-w-[120px]" href="{{ route('user.index') }}">Reset</a>
    </div>


    <div class="overflow-auto">
        <table class="w-full table my-8 whitespace-nowrap">
            <thead class="bg-secondary text-gray-100 font-bold">
            <td class="py-2 pl-5 flex">
                Photo
            </td>
            <td class="py-2 pl-2">
                Full Name
            </td>
            <td class="py-2 pl-2">
                Email Address
            </td>
            <td class="py-2 pl-2">
                Phone Number
            </td>
            <td class="py-2 pl-2">
                City
            </td>
            <td class="py-2 pl-2">
                Country
            </td>
            <td class="py-2 pl-2">
                Status
            </td>
            <td class="py-2 pl-2 flex justify-center">
                Action
            </td>
            </thead>
            <tbody class="text-sm">
            @forelse($users as $user)
                <tr class="odd:bg-white bg-gray-100 border-b hover:bg-primary hover:bg-opacity-20 transition duration-200">
                    <td class="py-3 pl-5">
                        <a href="{{ route('user.show', $user->id) }}">
                            <div
                                class="relative h-8 w-8 rounded-full ring-1 ring-primary overflow-hidden items-center justify-center flex">
                                <img class="h-auto w-8 rounded-full object-cover" src="{{ $user->profile_photo_url }}"
                                     alt="{{ $user->name }}"/>
                            </div>
                        </a>
                    </td>
                    <td class="py-3 pl-2">
                        <a class="flex gap-0.5" href="{{ route('user.show', $user->id) }}">
                            {{ $user->name }}
                            @if($user->verified)
                                <span title="Verified">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor" class="text-blue-600 w-4">
                                        <path fill-rule="evenodd"
                                              d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Zm7.007 6.387a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </span>
                            @endif
                        </a>
                    </td>
                    <td class="py-3 pl-2">
                        <a href="{{ route('user.show', $user->id) }}">{{ $user->email }}</a>
                    </td>
                    <td class="py-3 pl-2">
                        <a href="{{ route('user.show', $user->id) }}">{{ $user->phone }}</a>
                    </td>
                    <td class="py-3 pl-2">
                        <a href="{{ route('user.show', $user->id) }}">{{ $user->profile->city ?? '' }}</a>
                    </td>
                    <td class="py-3 pl-2">
                        <a href="{{ route('user.show', $user->id) }}">{{ $user->profile->country->name ?? '' }}</a>
                    </td>
                    <td class="py-3 pl-2">
                        <a href="{{ route('user.show', $user->id) }}">
                            @if($user->status === 'Active')
                                <x-status :content="$user->status" :type="'success'" />
                            @elseif($user->status === 'Inactive')
                                <x-status :content="$user->status" :type="'danger'" />
                            @endif
                        </a>
                    </td>
                    <td class="py-3 pl-2 flex items-center justify-center space-x-3">

                        <div x-data="verifyToggle({{ $user->id }}, {{ $user->verified ? 1 : 0 }})" class="flex gap-4 items-center">
                            <label @click.prevent="confirmToggle" class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="verified" @checked($user->verified) class="sr-only peer">
                                <div class="w-[45px] h-6 bg-gray-200 hover:bg-gray-300 peer-focus:outline-0 peer-focus:ring-transparent rounded-full peer transition-all ease-in-out duration-500 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#2563EB] hover:peer-checked:bg-primary"></div>
                            </label>
                        </div>

                        <a href="{{ route('user.show', $user->id) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="h-5 w-5 text-green-500 hover:text-green-800">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                        </a>
                        <a href="{{ route('user.edit', $user->id) }}">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5 text-yellow-500 hover:text-yellow-600" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                        </a>
                        <button type="button" @click.prevent="userDelete({{ $user->id }})">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 hover:text-red-600"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
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
        {{ $users->links() }}
    </div>
</div>
