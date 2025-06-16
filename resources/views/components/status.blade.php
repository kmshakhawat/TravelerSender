@props(['content' => '', 'type' => 'success', 'class' => ''])

@switch($type)
    @case('info')
        <span {{ $attributes->merge(['class'=> $class . " px-3 py-1.5 bg-[#FFA500] text-black text-xs rounded"]) }}>{{ $content }}</span>
        @break
    @case('warning')
        <span {{ $attributes->merge(['class'=> $class . " px-3 py-1.5 bg-[#FFD44E] text-black text-xs rounded"]) }}>{{ $content }}</span>
        @break
    @case('error')
    @case('danger')
        <span {{ $attributes->merge(['class'=> $class . " px-3 py-1.5 bg-red-500 text-white text-xs rounded"]) }}>{{ $content }}</span>
        @break
    @case('verified')
        <span {{ $attributes->merge(['class'=> $class . " px-3 py-1.5 bg-blue-500 text-white text-xs rounded"]) }}>{{ $content }}</span>
        @break
    @default
        <span {{ $attributes->merge(['class'=> $class . " px-3 py-1.5 bg-[#28A745] text-white text-xs rounded"]) }}>{{ $content }}</span>
@endswitch
