@props(['name' => '', 'id' => '', 'label' => '', 'accept' => [],'value' => '' ])

<div {{$attributes->merge(['class' => 'field-input'])}}>
    @if($label)
        <label for="{{$id}}">{{$label}}</label>
    @endif
    <input type="file" name="{{$name}}" id="{{$id}}" accept="{{$accept}}"  value="{{ old($name, $value ?? '') }}">
        @error($id)
        <small class="error_message">{{ $message }}</small>
        @enderror
</div>
