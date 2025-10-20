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
                        @foreach($employee->schedules as $schedule)

                        <x-schedule-cards
                            :image="'assets/profile-pic.png'"
                            :name="$employee->first_name . ' ' . $employee->last_name"
                            :id="$employee->employee_id"
                            :shift="$schedule->shift_name"
                            :start="$schedule->start_time"
                            :end="$schedule->end_time"
                            :schedule="'ij'"
                            :description="'dodn'"
                        />
                        @endforeach
                    </div>
                @endforeach
            </div>

        </div>
    </section>


</x-app>
