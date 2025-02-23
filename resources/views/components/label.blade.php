@props(['value'])

<label {{ $attributes->merge(['class' => 'block mb-2 font-medium text-lg text-[#444444]']) }}>
    {{ $value ?? $slot }}
</label>
