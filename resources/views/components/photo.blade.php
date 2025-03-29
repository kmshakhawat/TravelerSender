@props(['file' => '', 'title' => '', 'name' => 'photo', 'show' => true, 'upload' => true, 'multiple' => false])

@if($show)
    <div class="flex flex-col bg-white">
{{--        <x-label for="{{ $name }}" value="{{ $title }}" />--}}
    @if($file)
            <a href="{{ Storage::disk('public')->url($file) }}" data-lightbox="photo">
                <img class="max-w-48 cursor-pointer" src="{{ Storage::disk('public')->url($file) }}" alt="{{ $name }}">
            </a>
    @endif
    @if($upload)
        <div class="flex justify-between items-center mt-2">
            <label for="{{ $name }}"
                   class="bg-white text-center rounded w-full max-w-sm py-4 px-4 flex flex-col items-center justify-center cursor-pointer border-2 border-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 mb-3 fill-gray-400" viewBox="0 0 24 24">
                    <path
                        d="M22 13a1 1 0 0 0-1 1v4.213A2.79 2.79 0 0 1 18.213 21H5.787A2.79 2.79 0 0 1 3 18.213V14a1 1 0 0 0-2 0v4.213A4.792 4.792 0 0 0 5.787 23h12.426A4.792 4.792 0 0 0 23 18.213V14a1 1 0 0 0-1-1Z"
                        data-original="#000000" />
                    <path
                        d="M6.707 8.707 11 4.414V17a1 1 0 0 0 2 0V4.414l4.293 4.293a1 1 0 0 0 1.414-1.414l-6-6a1 1 0 0 0-1.414 0l-6 6a1 1 0 0 0 1.414 1.414Z"
                        data-original="#000000" />
                </svg>
                <p class="text-gray-400 font-semibold text-sm">Drag & Drop or <span class="text-[#007bff]">Choose file</span> to
                    upload</p>
                <input type="file" name="{{ $name }}" id='{{ $name }}' class="hidden photo" @if($multiple) multiple @endif>
            </label>
        </div>
    @endif
</div>
@endif

