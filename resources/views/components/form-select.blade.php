@props([
    'name' => '',
    'id' => '',
    'value' => '',
    'label' => '',
    'labelOption' => '',
    'options' => [],
    'selected' => '',
    'noDefault' => false,
    'default' => ' ',
    'useValue' => false,
])

<div @if(!$noDefault) {{ $attributes->merge(['class' => 'field-input']) }} @endif>

    @if($label)
        <label for="{{ $id }}">{{ $label }}</label>
    @endif

    <select name="{{ $name }}" id="{{ $id }}">
        <option value="">{{ $default }}</option>

        @foreach ($options as $optionValue => $labelOption)
            <option value="{{ $optionValue }}"
                @if($useValue)
                    {{ old($name, $value) == $optionValue ? 'selected' : '' }}
                @else
                    {{ $selected == $optionValue ? 'selected' : '' }}
                @endif
            >
                {{ $labelOption }}
            </option>
        @endforeach
    </select>

    @error($id)
        <small class="error_message">{{ $message }}</small>
    @enderror
</div>
