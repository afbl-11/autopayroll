@props(['name', 'value', 'label', 'selected' => null, 'id' => ''])

<label class="radio-btn {{ $selected === $value ? 'active' : '' }}">
    <input
        type="radio"
        name="{{ $name }}"
        value="{{ old($name, $value ?? '') }}"
        id="{{$id}}"
        {{ $selected === $value ? 'checked' : '' }}
        onclick="handleRadioSelect(event)"
    >
    {{ $label }}
    @error($id)
    <small class="error_message">{{ $message }}</small>
    @enderror
</label>

<script>
    function handleRadioSelect(e) {
        const group = document.querySelectorAll(`input[name='${e.target.name}']`);
        group.forEach(radio => radio.closest('.radio-btn').classList.remove('active'));
        e.target.closest('.radio-btn').classList.add('active');
    }
</script>
