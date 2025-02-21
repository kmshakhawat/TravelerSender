@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-lg text-[#444444]']) }}>
    {{ $value ?? $slot }}
</label>
