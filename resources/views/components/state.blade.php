@props(['noDefault' => false, 'id' => '', 'status'=> false])

@vite('resources/css/state.css')
@php
    $statusClass = $status ? 'state-default' : 'state-inactive';
    $isActive = $status ?  'Active' : 'Inactive';
@endphp


<div @if(!$noDefault) {{$attributes->class($statusClass)}} @endif id="{{$id}}" >
    <small>{{$isActive}}</small>
</div>
