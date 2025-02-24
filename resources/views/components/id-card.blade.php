@props(['url' => '', 'name' => '', 'title' => '', 'upload' => true])
<div class="flex flex-col mb-8 bg-white">
    <div class="flex items-center justify-between">
        <div class="relative flex items-center justify-center max-w-96 overflow-hidden">
            <img id="profilePhoto" src="{{ $url ?: 'https://ui-avatars.com/api/?name='.urlencode('ID').'&size=120&color=7F9CF5&background=EBF4FF' }}" alt="{{ $name }}" class="w-full">
        </div>

        @if($upload)
            <div class="text-center mt-5">
                <label for="profile_photo_path"
                       class="cursor-pointer transition duration-500">
                    @if($title)
                        <span class="px-10 py-4 bg-primary rounded">{{ $title }}</span>
                    @else
                        <span class="px-10 py-4 bg-primary rounded">Change</span>
                    @endif
                    <input type="file" name="{{ $name }}" id='{{ $name }}' class="hidden">
                    <span class="text-xs text-gray-500 block mt-4">Max size 5MB (JPG, PNG, GIF)</span>
                </label>
            </div>
        @endif
    </div>
</div>
