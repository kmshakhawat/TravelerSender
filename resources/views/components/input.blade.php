@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'min-h-12 border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm']) !!}>
