@vite('resources/css/company/company-schedule.css')

@php
    $daysOfWeek = [
           'Mon' => 'Mon',
           'Tues' => 'Tues',
           'Wed' => 'Wed',
           'Thurs' => 'Thurs',
           'Fri' => 'Fri',
           'Sat' => 'Sat',
           'Sun' => 'Sun']
@endphp
{{--    script for the checkboxes
   added here and in the root layout so that responses have no delay
--}}
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const checkboxes = document.querySelectorAll('.custom-checkbox');

            checkboxes.forEach(label => {
                label.addEventListener('click', e => {
                    const input = label.querySelector('input[type="checkbox"]');
                    if (!input) return;

                    input.checked = !input.checked;
                    label.classList.toggle('active', input.checked);
                    e.preventDefault();
                });
            });

            const cards = document.querySelectorAll('.card-wrapper');
            const employeeIdInput = document.querySelector('#employee_id');
            const startTimeInput = document.querySelector('#custom_start');
            const endTimeInput = document.querySelector('#custom_end');

            cards.forEach(card => {
                card.addEventListener('click', () => {
                    const employeeId = card.dataset.id;
                    const start = card.dataset.start || '';
                    const end = card.dataset.end || '';

                    // populate hidden field
                    employeeIdInput.value = employeeId;

                    startTimeInput.value = start ? start.slice(0,5) : '';
                    endTimeInput.value = end ? end.slice(0,5) : '';
                    // populate time fields
                    startTimeInput.value = start;
                    endTimeInput.value = end;

                    // highlight selected card
                    cards.forEach(c => c.classList.remove('active'));
                    card.classList.add('active');

                    console.log(`Selected Employee ID: ${employeeId}`);
                });
            });
        });
    </script>
@endpush

<x-app :noHeader="true" :navigation="true" :company="$company">

    <section class="main-content">
        <div class="content-wrapper">
            <div class="schedule-wrapper">
                <form action="{{ route('company.create.schedule') }}" method="post">
                    @csrf
                    <input type="hidden" name="employee_id" id="employee_id">

                    <h6>Schedules</h6>
                    <div class="checkbox-group">
                        @foreach($daysOfWeek as $days => $daysLabel)
                            <x-form-checkbox
                                :label="$daysLabel"
                                name="working_days[]"
                                :id="$days"
                                :value="$days"
                            />
                        @endforeach
                    </div>

                    <p>Set working hours</p>
                    <div class="field-row">
                        <x-form-input type="time" id="start_time" name="start_time" label="Start Time" />
                        <x-form-input type="time" id="end_time" name="end_time" label="End Time " />
                    </div>

                    <div class="button-wrapper">
                        <x-button-submit>Save</x-button-submit>
                    </div>

            </form>
            </div>
                <div class="employee-card-wrapper">
                    @foreach($company->employees as $employee)
                        <div class="card-content-wrapper">
                            @if($employee->employeeSchedule->isNotEmpty())
                                @foreach($employee->employeeSchedule as $schedule)
                                    <x-schedule-cards
                                        :image="'assets/default_profile.png'"
                                        :name="$employee->first_name . ' ' . $employee->last_name"
                                        :id="$employee->employee_id"
                                        :start="$schedule->start_time"
                                        :end="$schedule->end_time"
                                        :scheduleDays="$schedule->working_days"
                                        :description="'Current shift'"
                                        :labels="$schedule->shift_name"
                                    />
                                @endforeach
                            @else
                                <x-schedule-cards
                                    :image="'assets/default_profile.png'"
                                    :name="$employee->first_name . ' ' . $employee->last_name"
                                    :id="$employee->employee_id"
                                    :start="''"
                                    :end="''"
                                    :scheduleDays="json_encode([])" {{-- empty array --}}
                                    :description="'No schedule assigned'"
                                    :labels="'Unassigned'"
                                />
                            @endif
                        </div>
                    @endforeach
                </div>
        </div>
    </section>
</x-app>


{{--todo:fetch the latest schedule of the employee--}}
