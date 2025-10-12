@props([
    'type' => 'text',
    'name' => '',
    'id' => '',
    'label' => '',
    'placeholder' => '',
    'value' => '',
    'readonly' => false,
])


<div {{ $attributes->merge(['class' => 'field-input']) }}>

    @if($label)
        <label for="{{ $id }}">{{ $label }}</label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $id }}"
        placeholder="{{ $placeholder }}"
        value="{{ old($name, $value ?? '') }}"
        @if($readonly === true)
{{--        readonly--}}
        @endif
    >
            @error($id)
            <small class="error_message">{{ $message }}</small>
            @enderror
</div>
