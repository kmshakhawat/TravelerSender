@props(['url' => '', 'name' => '', 'title' => '', 'upload' => true])
<div class="flex flex-col mb-8 bg-white">
    <div class="flex items-center justify-between">
        <div class="relative flex items-center justify-center w-64 h-48 overflow-hidden">
            <img id="backID" src="{{ Storage::disk('public')->url($url) ?: 'https://ui-avatars.com/api/?name='.urlencode('ID').'&size=120&color=7F9CF5&background=EBF4FF' }}" alt="{{ $name }}" class="w-full">
        </div>

        @if($upload)
            <div class="text-center mt-5">
                <label for="id_back"
                       class="cursor-pointer transition duration-500">
                    @if($title)
                        <span class="px-4 py-2 bg-gray-200 rounded hover:bg-primary">{{ $title }}</span>
                    @else
                        <span class="px-4 py-2 bg-gray-200 rounded hover:bg-primary">Change</span>
                    @endif
                    <input type="file" name="id_back" id="id_back" class="hidden id_back">
                    <span class="text-xs text-gray-500 block mt-4">Max size 5MB (JPG, PNG, GIF)</span>
                </label>
            </div>
        @endif
    </div>
</div>
