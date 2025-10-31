@vite('resources/css/company/modal.css')
@php
 $daysOfWeek = [
        'monday' => 'Mon',
        'tuesday' => 'Tues',
        'wednesday' => 'Wed',
        'thursday' => 'Thurs',
        'friday' => 'Fri',
        'saturday' => 'Sat',
        'sunday' => 'Sun']
@endphp

<div {{$attributes->class('modal-wrapper')}}   id="schedule-modal" >
    <form action="">
        <h6>Schedules</h6>
        <div class="checkbox-group">
            @foreach($daysOfWeek as $days => $daysLabel)
                <x-form-checkbox
                    :label="$daysLabel"
                    :name="$days"
                    :id="$days"
                    :value="$days"
                />
            @endforeach
        </div>

        <p>Set working hours</p>
        <div class="field-row">
            <x-form-input type="time"/>
            <x-form-input type="time" />

        </div>

        <div class="button-wrapper">
            <x-button-submit>Create</x-button-submit>
        </div>
    </form>
</div>

