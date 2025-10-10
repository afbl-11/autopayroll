@props(['name' => '', 'id' => '', 'value' => '','label' => '', 'labelOption' => '', 'options' => ''])

<div {{$attributes->merge(['class' => 'field-input'])}}>

    @if($label)
        <label for="{{ $id }}">{{ $label }}</label>
    @endif

    <select name="{{$name}}" id="{{$id}}">
        <option value="Select"></option>
        @foreach($options as $value => $labelOption)
            <option value="{{ $value }}" @selected($selected == $value)>{{ $labelOption }}</option>
        @endforeach
    </select>
</div>
