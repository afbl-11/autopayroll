@props([
    'type' => 'text',
    'name' => '',
    'id' => '',
    'label' => '',
    'placeholder' => '',
    'value' => '',
    'noDefault' => false,
    'readOnly' => false,
])


<div @if(!$noDefault){{ $attributes->class('field-input') }} @endif>

    @if($label)
        <label for="{{ $id }}">{{ $label }}</label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $id }}"
        placeholder="{{ $placeholder }}"
        value="{{ old($name, $value ?? '') }}"
        @if($readOnly)
           readonly
        @endif

    >
            @error($id)
            <small class="error_message">{{ $message }}</small>
            @enderror
</div>
