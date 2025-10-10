@props([
    'type' => 'text',
    'name' => '',
    'id' => '',
    'label' => '',
    'placeholder' => ''
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
    >
</div>
