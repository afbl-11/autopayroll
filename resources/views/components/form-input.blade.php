@props([
    'type' => 'text',
    'name' => '',
    'id' => '',
    'label' => '',
    'placeholder' => '',
    'value' => '',
    'noDefault' => false,
])


<div @if(!$noDefault){{ $attributes->merge(['class' => 'field-input']) }} @endif>

    @if($label)
        <label for="{{ $id }}">{{ $label }}</label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $id }}"
        placeholder="{{ $placeholder }}"
        value="{{ old($name, $value ?? '') }}"
    >
            @error($id)
            <small class="error_message">{{ $message }}</small>
            @enderror
</div>
