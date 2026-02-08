@props(['noDefault' => false, 'id' => '', 'status'=> ''])

@vite('resources/css/state.css')

@php
    if (empty($status)) {

    };

//    dd($status);
    $statusClass = 'state-inactive';
    $isActive = 'Absent';

    switch($status) {
        case 'A':
            $statusClass = 'state-inactive';
            $isActive  = 'Absent';
            break;
        case 'P':
            $statusClass = 'state-default';
            $isActive  = 'Present';
            break;
        case 'LT':
            $statusClass = 'state-warning';
            $isActive  = 'Late';
            break;
        case 'DO':
        case 'CDO':
            $statusClass = 'state-warning';
            $isActive = 'Day Off';
            break;
        case 'O':
            $statusClass = 'state-warning';
            $isActive = 'Overtime';
            break;
        case 'SH':
        case 'RH':
            $statusClass = 'state-warning';
            $isActive = 'Holiday';

            break;
        case 'CD':
            $statusClass = 'state-inactive';
            $isActive = 'Absent';
            break;
    }

@endphp

<div @if(!$noDefault) {{$attributes->class($statusClass)}} @endif id="{{$id}}" >
    <small>{{$isActive}}</small>
</div>


<style>
    .state-default {
        background-color: var(--clr-green);
        width: 70px;
        padding: 5px;
        border-radius: 16px;
        text-align: center;
        max-height: 25px;

    }

    .state-inactive {
        background-color: var(--clr-red);
        width: 70px;
        padding: 5px;
        border-radius: 16px;
        text-align: center;
        max-height: 25px;
    }
    .state-warning {
        background-color: var(--clr-light-mustart);
        width: 70px;
        padding: 5px;
        border-radius: 16px;
        text-align: center;
        max-height: 25px;
    }
    small {
        color: var(--clr-primary);
        font-size: 10px !important;
        margin-bottom: 0 !important;
        /*line-height: 0 !important;*/
        text-align: center !important;
    }


</style>
