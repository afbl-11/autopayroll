@vite('resources/css/company/schedule-card.css')

<div
    {{$attributes->class('card-wrapper')}}
    data-id="{{$id}}"
    data-name="{{$name}}"
    data-start="{{formatTimeOrDash($start) ?? ''}}"
    data-end="{{formatTimeOrDash($end) ?? ''}}"
    data-description="{{$description ?? ''}}"
    data-labels="{{$labels ?? ''}}"
    onclick="selectScheduleCard(this)"
>
    <div class="profile">
        <div class="image-wrapper">
            <img src="{{asset($image)}}" alt="profile-pic">
        </div>
        <div class="name-wrapper">
            <p>{{$name}}</p>
            <small>{{$id}}</small>
        </div>
    </div>

    <div class="input-wrapper">
        <div class="shift-wrapper">
            <small>Starts at: {{ formatTimeOrDash($start) }}</small>
            <small>Ends at: {{ formatTimeOrDash($end) }}</small>
        </div>
        <div class="schedule-wrapper">
            <small>{{ $description ?: 'No schedule assigned' }}</small> <br>
            <small>{{ implode(', ',  json_decode($scheduleDays)) }}</small>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const cards = document.querySelectorAll('.card-wrapper');
        const form = document.querySelector('form');
        const startTime = document.getElementById('start_time');
        const endTime = document.getElementById('end_time');
        const dayCheckboxes = document.querySelectorAll('.checkbox-group input[type="checkbox"]');

        // hidden employee input
        let employeeInput = document.createElement('input');
        employeeInput.type = 'hidden';
        employeeInput.name = 'employee_id';
        employeeInput.id = 'selected_employee_id';
        form.appendChild(employeeInput);

        cards.forEach(card => {
            card.addEventListener('click', () => {
                // remove active from others
                cards.forEach(c => c.classList.remove('active'));
                card.classList.add('active');

                // extract schedule data
                const id = card.dataset.id;
                const start = card.dataset.start || '';
                const end = card.dataset.end || '';
                const days = card.dataset.days ? JSON.parse(card.dataset.days) : [];

                // populate fields
                startTime.value = start;
                endTime.value = end;
                employeeInput.value = id;

                // clear all day checkboxes
                dayCheckboxes.forEach(chk => chk.checked = false);

                // check the days that match
                days.forEach(day => {
                    const checkbox = document.getElementById(day.toLowerCase());
                    if (checkbox) checkbox.checked = true;
                });
            });
        });
    });
</script>
