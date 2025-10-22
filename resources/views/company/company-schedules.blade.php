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
<x-app :noHeader="true" :companyHeader="true" :company="$company">

    <section class="main-content">
        <div class="sched-wrapper">
            <div class="sidebar">
                <h6>Schedules</h6>
                <div class="sched-list">
                    <p></p>
                </div>
                <div class="sched-list">

                </div>
                <div class="sched-desc">
                    <div class="item-wrapper">
                        <p>working Days</p>
                    </div>

                    <div class="item-wrapper">
                        <p>days off</p>
                    </div>

                    <div class="item-wrapper">
                        <p>breaks</p>
                    </div>
                </div>
            </div>
            <div class="content">
                <nav>
{{--                    buttons should be here--}}
                </nav>
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
