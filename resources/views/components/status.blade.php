@props(['content' => '', 'type' => 'success'])

@switch($type)
    @case('info')
        <span class="px-3 py-1.5 bg-[#FFA500] text-black text-xs rounded">{{ $content }}</span>
        @break

    @case('warning')
        <span class="px-3 py-1.5 bg-[#FFD44E] text-black text-xs rounded">{{ $content }}</span>
        @break

    @case('error')
    @case('danger')
        <span class="px-3 py-1.5 bg-red-500 text-white text-xs rounded">{{ $content }}</span>
        @break

    @case('verified')
        <span class="px-3 py-1.5 bg-blue-500 text-white text-xs rounded">{{ $content }}</span>
        @break

    @default
        <span class="px-3 py-1.5 bg-[#28A745] text-white text-xs rounded">{{ $content }}</span>
@endswitch
