@props(['url' => '', 'name' => '', 'upload' => true])
<div class="flex flex-col mb-8 bg-white p-6 rounded">
    <div class="flex flex-col justify-between border-b pb-4 mb-5">
        <h3 class="text-xl">Profile Photo</h3>
    </div>
    <div class="flex items-center justify-between">
        <div class="relative flex items-center justify-center w-40 h-40 overflow-hidden ring-2 ring-primary rounded-full bg-gray-50">
            <img id="profilePhoto" src="{{ $url ?: 'https://ui-avatars.com/api/?name='.urlencode($name).'&color=7F9CF5&background=EBF4FF' }}" alt="{{ $name }}" class="max-h-40">
        </div>

        @if($upload)
            <div class="text-center mt-5">
                <label for="profile_photo_path"
                       class="cursor-pointer transition duration-500">
                    <span class="px-10 py-4 bg-primary rounded">Change Photo</span>
                    <input type="file" name="profile_photo_path" id='profile_photo_path' class="hidden">
                    <span class="text-xs text-gray-500 block mt-4">Max size 5MB (JPG, PNG, GIF)</span>
                </label>
            </div>
        @endif
    </div>
</div>
