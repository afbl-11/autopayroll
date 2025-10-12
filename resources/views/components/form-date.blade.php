@props(['name' => '', 'id' => '', 'label' => ''])

<div {{$attributes->merge(['class'=>'field-input'])}}>
    @if($label)
        <label for="{{$id}}">{{$label}}</label>
    @endif
    <input type="date" name="{{$name}}" id="{{$id}}" class="form-date"  value="{{ old($name, $value ?? '') }}">
        @error($id)
        <small class="error_message">{{ $message }}</small>
        @enderror
</div>
