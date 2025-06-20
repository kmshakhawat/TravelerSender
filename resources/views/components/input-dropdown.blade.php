@props([
    'name',
    'options',
    'selected' => [],
    'placeholder' => 'Please Select',
    'multiple' => false,
    'search' => true,
    'class' => 'form-input'
])
<select
    wire:model.change="{{ $name }}"
    name="{{ $name }}"
    {{ $attributes->merge(['class' => 'form-input ' . ($search ? 'select2 ' : '') . $class]) }}
    {{ $multiple ? 'multiple' : '' }}>

    @if($search)
        <option value="" {{ $multiple ? 'disabled' : '' }}>{{ $placeholder }}</option>
    @endif

    @foreach ($options as $option)
        <option value="{{ $option->id }}" {{ in_array($option->id, $selected) ? 'selected' : '' }}>
            {{ $option->name }} {{ $option->symbol ?? '' }}
        </option>

        @if(isset($option->children))
            @foreach($option->children as $child)
                <option value="{{ $child->id }}" {{ in_array($child->id, $selected) ? 'selected' : '' }}>
                    -- {{ $child->name }}
                </option>
            @endforeach
        @endif
    @endforeach
</select>
