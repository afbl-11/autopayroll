@vite('resources/css/company/company-schedule.css')

<x-app :noHeader="true" :companyHeader="true" :company="$company">

    <section class="main-content">
        <div class="sched-wrapper">
            <div class="sidebar">

            </div>
            <div class="content">
                <nav>

                </nav>
                @foreach($company->employees as $employee)
                    <div class="card-content-wrapper">
                        @if($employee->schedules->isNotEmpty())
                            @foreach($employee->schedules as $schedule)
                                <x-schedule-cards
                                    :image="'assets/profile-pic.png'"
                                    :name="$employee->first_name . ' ' . $employee->last_name"
                                    :id="$employee->employee_id"
                                    :options="$shift"
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
                                :options="$shift"
                                :start="''"
                                :end="''"
                                schedule="No schedule"
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
