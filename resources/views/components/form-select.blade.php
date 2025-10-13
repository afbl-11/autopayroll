@props(['name' => '', 'id' => '', 'value' => '','label' => '', 'labelOption' => '', 'options' => [], 'selected' => '', 'noDefault' => false])

<div @if(!$noDefault){{ $attributes->merge(['class' => 'field-input']) }} @endif>

    @if($label)
        <label for="{{ $id }}">{{ $label }}</label>
    @endif

    <select name="{{$name}}" id="{{$id}}">
        <option value="">{{$slot}}</option>
        @foreach($options as $value => $labelOption)
            <option  value="{{ old($name, $value ?? '') }}" @selected($selected == $value)>{{ $labelOption }}</option>
        @endforeach
    </select>
        @error($id)
        <small class="error_message">{{ $message }}</small>
        @enderror
</div>
