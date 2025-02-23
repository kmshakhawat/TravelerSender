@props(['name', 'options', 'selected' => [], 'placeholder'=> 'Please Select', 'multiple' => false, 'class' => 'form-input'])

<select wire:model.change="{{ $name }}" name="{{ $name }}" {{ $attributes->merge(['class' => 'form-input select2']) }} {{ $multiple ? 'multiple' : '' }}>
    <option value="" {{ $multiple ? 'disabled' : '' }}>{{ $placeholder }}</option>
    @foreach ($options as $option)
        <option value="{{ $option->id }}" {{ in_array($option->id, $selected) ? 'selected' : '' }}> {{ $option->name }}</option>
        @if(isset($option->children))
            @foreach($option->children as $child)
                <option value="{{ $child->id }}" {{ in_array($child->id, $selected) ? 'selected' : '' }}>-- {{ $child->name }}</option>
            @endforeach
        @endif
    @endforeach
</select>
