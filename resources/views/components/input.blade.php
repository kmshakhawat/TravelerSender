@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'min-h-12 focus:border-primary focus:ring-primary rounded-md shadow-sm']) !!}>
