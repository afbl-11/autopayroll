@vite('resources/css/company/company-schedule.css')
@php

$array = [
    'hello' => 'world',
    'hello2' => 'world',
    'hello3' => 'world',
    'hello4' => 'world',
    'hello5' => 'world',
]
@endphp
@push('scripts')
{{--    script for the checkboxes
   added here and in the root layout so that responses have no delay
--}}
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
        });
    </script>
@endpush

<x-app :noHeader="true" :companyHeader="true" :company="$company">

    <section class="main-content">
        <div class="sched-wrapper">
            <div class="content">
                <nav>
{{--                    buttons should be here--}}
                </nav>

{{--                <x-schedule-modal--}}
{{--                />--}}
                @foreach($company->employees as $employee)
                    <div class="card-content-wrapper">
                        @if($employee->employeeSchedule->isNotEmpty())
                            @foreach($employee->employeeSchedule as $schedule)
                                <x-schedule-cards
                                    :image="'assets/profile-pic.png'"
                                    :name="$employee->first_name . ' ' . $employee->last_name"
                                    :id="$employee->employee_id"
                                    :options="$array"
                                    :start="$schedule->start_time"
                                    :end="$schedule->end_time"
                                    schedule="afassa"
                                    :description="'dodn'"
                                    :labels="$schedule->shift_name"
                                />
                            @endforeach
                        @else
                            <x-schedule-cards
                                :image="'assets/profile-pic.png'"
                                :name="$employee->first_name . ' ' . $employee->last_name"
                                :id="$employee->employee_id"
                                :options="$array"
                                :start="''"
                                :end="''"
                                schedule="No schedule"
                                :description="'No schedule assigned'"
                                :labels="'dnassigned'"
                            />
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>


</x-app>


{{--todo:fetch the latest schedule of the employee--}}
