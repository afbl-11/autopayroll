@vite('resources/css/components/checkbox.css')
@props(['name' => '', 'value' => '', 'label' => '', 'selected' => [], 'id' => ''])

<label
    for="{{ $id }}"
    class="custom-checkbox {{ in_array($value, $selected) ? 'active' : '' }}"
    data-value="{{ $value }}"
>
    <input
        type="checkbox"
        name="{{ $name }}[]"
        id="{{ $id }}"
        value="{{ $value }}"
        {{ in_array($value, $selected) ? 'checked' : '' }}
    >
    <span>{{ $label }}</span>
</label>


