@vite(['resources/css/creditAdjustment/creditAdjustment.css'])

<x-app :noDefault="true" :noHeader="true">
    <div class="content-wrapper">
        <section class="main-content">
            @include('components.header', ['title' => $title, 'source' => 'admin.profile'])
            @foreach($employees as $employee)
                @foreach($employee->creditAdjustments as $requests)
                    <x-adjustment-card
                        :image="$employee->profile_photo"
                        :name="$employee->first_name . ' ' . $employee->last_name"
                        :type="$requests->adjustment_type"
                        :message="$requests->reason"
                        :employeeId="$employee->employee_id"
                        :requestId="$requests->adjustment_id"
                        :date="$requests->affected_date"
                        :startDate="$requests->start_date"
                        :endDate="$requests->end_date"
                        data-name="{{$employee->first_name . ' ' . $employee->last_name}}"
                        data-type="{{$requests->adjustment_type}}"
                        data-message="{{$requests->reason}}"
                    />
                    @if($requests->count() === 0)

                    @endif
                @endforeach
            @endforeach

        </section>

        <!-- Right: Side Content Accordion -->
        <section class="side-content">
            <div id="adjustmentFormContainer">

                <!-- Attendance Accordion -->
                <div class="accordion-group" data-type="attendance">
                    <div class="accordion-header">Attendance Adjustments</div>
                    <div class="accordion-body">

                        <!-- Clock In -->
                        <div class="sub-accordion">
                            <div class="sub-header">Clock In</div>
                            <div class="sub-body">
                                <form class="adjustment-form" data-action="clock-in" onsubmit="submitForm(event)" action="{{route('alter.clock-in')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="employee_id" class="employee_id">
                                    <input type="hidden" name="request_id" class="request_id">
                                    <x-form-input type="text" name="affected_date" class="affected_date" label="Log Date Affected"/>

                                    <x-form-input
                                        type="time"
                                        name="clock_in_time"
                                        label="Time in"
                                    />

                                    <x-button-submit>Apply</x-button-submit>
                                </form>
                            </div>
                        </div>

                        <!-- Clock Out -->
                        <div class="sub-accordion">
                            <div class="sub-header">Clock Out</div>
                            <div class="sub-body">
                                <form class="adjustment-form" data-action="clock-out" onsubmit="submitForm(event)" action="{{route('alter.clock-out')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="employee_id" class="employee_id">
                                    <input type="hidden" name="request_id" class="request_id">
                                    <x-form-input type="text" name="affected_date" class="affected_date" label="Log Date Affected"/>

                                   <x-form-input
                                        label="Time out"
                                        name="clock_out_time"
                                        id="clock_out_time"
                                        type="time"
                                   />

                                    <x-button-submit>Apply</x-button-submit>
                                </form>
                            </div>
                        </div>

                        <!-- clock in and out -->
                        <div class="sub-accordion">
                            <div class="sub-header">Clock in & out</div>
                            <div class="sub-body">
                                <form class="adjustment-form" data-action="mark-present" onsubmit="submitForm(event)" action="{{route('alter.clock.in.out')}}" method="post" >
                                    @csrf
                                    <input type="hidden" name="employee_id" class="employee_id">
                                    <input type="hidden" name="request_id" class="request_id">
                                    <x-form-input type="text" name="affected_date" class="affected_date" label="Log Date Affected"/>

                                    <x-form-input
                                        label="Time in"
                                        name="clock_in_time"
                                        id="clock_in_time"
                                        type="time"
                                    />

                                    <x-form-input
                                        label="Time out"
                                        name="clock_out_time"
                                        id="clock_out_time"
                                        type="time"
                                    />

                                    <x-button-submit>Apply</x-button-submit>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>

{{--                <!-- Payroll Accordion -->--}}
{{--                <div class="accordion-group" data-type="payroll">--}}
{{--                    <div class="accordion-header">Payroll Adjustments</div>--}}
{{--                    <div class="accordion-body">--}}


{{--                       <div class="sub-accordion">--}}
{{--                           <div class="sub-header"></div>--}}
{{--                       </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

                <!-- Leave Accordion -->
                <div class="accordion-group" data-type="leave">
                    <div class="accordion-header">Leave Adjustments</div>
                    <div class="accordion-body">


                        <div class="sub-accordion">
                            <div class="sub-header">Adjust Leave Dates</div>
                            <div class="sub-body">
                                <form action="" class="adjustment-form" action="{{route('alter.leave')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="employee_id" class="employee_id">
                                    <input type="hidden" name="request_id" class="request_id">
                                    <x-form-input type="text" name="start_date" class="start_date" label="Start Date Affected"/>
                                    <x-form-input type="text" name="end_date" class="end_date" label="End Date Affected"/>

                                    <x-form-input
                                        label="Start Date"
                                        name="new_start_date"
                                        id="new_start_date"
                                        type="date"
                                    />

                                    <x-form-input
                                        label="End date"
                                        name="new_end_date"
                                        id="new_end_date"
                                        type="date"
                                    />

                                    <x-button-submit>Apply</x-button-submit>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Official Business Accordion -->
                <div class="accordion-group" data-type="official-business">
                    <div class="accordion-header">Official Business Adjustments</div>
                    <div class="accordion-body">
                        <form class="adjustment-form" action="{{route('alter.attendance')}}" method="post">
                            @csrf
                            <input type="hidden" name="employee_id" class="employee_id">
                            <input type="hidden" name="request_id" class="request_id">
                            <x-form-input type="text" name="affected_date" class="affected_date" label="Log Date Affected"/>

                            <x-form-input
                                label="Date"
                                type="date"
                                name="log_date"
                                id="log_date"
                            />
                            <x-button-submit >Apply</x-button-submit>
                        </form>
                    </div>
                </div>

            </div>
        </section>

    </div>
    <div id="adjustment-modal" class="adjustment-modal hidden">
        <div id="adjustment-modal-container">
            @include('components.adjustment-modal')
        </div>
    </div>
</x-app>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        // ----------------------------
        // Main accordion toggle
        // ----------------------------
        document.querySelectorAll('.accordion-header').forEach(header => {
            header.addEventListener('click', () => {
                const body = header.nextElementSibling;
                const isOpen = body.classList.contains('open');

                // Close all other accordion bodies
                document.querySelectorAll('.accordion-body').forEach(b => b.classList.remove('open'));

                // Toggle current one
                if (!isOpen) body.classList.add('open');
            });
        });

        // ----------------------------
        // Sub-accordion toggle
        // ----------------------------
        document.querySelectorAll('.sub-header').forEach(subHeader => {
            subHeader.addEventListener('click', () => {
                const body = subHeader.nextElementSibling;
                const parent = subHeader.closest('.accordion-body');

                // Close other sub-bodies in the same accordion
                parent.querySelectorAll('.sub-body').forEach(b => b.classList.remove('open'));

                // Toggle current sub-body
                body.classList.toggle('open');
            });
        });

        // ----------------------------
        // Employee card click
        // ----------------------------
        document.querySelectorAll('.adjustment-card').forEach(card => {
            card.addEventListener('click', () => {

                // Highlight active card
                document.querySelectorAll('.adjustment-card').forEach(c => c.classList.remove('active'));
                card.classList.add('active');

                // Get employee and request IDs
                const employeeId = card.dataset.employee;
                const requestId = card.dataset.request;
                const date = card.dataset.affectedDate;
                const startDate = card.dataset.startDate;
                const endDate = card.dataset.endDate;

                // Prefill hidden inputs in all forms
                document.querySelectorAll('.adjustment-form input.employee_id').forEach(input => input.value = employeeId);
                document.querySelectorAll('.adjustment-form input.request_id').forEach(input => input.value = requestId);
                document.querySelectorAll('.adjustment-form input.affected_date').forEach(input => input.value = date);
                document.querySelectorAll('.adjustment-form input.start_date').forEach(input => input.value = startDate);
                document.querySelectorAll('.adjustment-form input.end_date').forEach(input => input.value = endDate);
            });
        });

    });

    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('adjustment-modal');

        document.querySelectorAll('.adjustment-card').forEach(card => {
            card.addEventListener('click', () => {
                const name = card.dataset.name;
                const type = card.dataset.type;
                const message = card.dataset.message;
                const affectedDate = card.dataset.affectedDate || '';
                const startDate = card.dataset.startDate || '';
                const endDate = card.dataset.endDate || '';
                const requestId = card.dataset.request;

                // Fill hidden inputs for forms
                document.getElementById('modal-reject-id').value = requestId;
                document.getElementById('modal-approve-id').value = requestId;



                const modal = document.getElementById('adjustment-modal');

                // Fill modal fields
                document.getElementById('modal-name').textContent = name;
                document.getElementById('modal-type').textContent = type;
                document.getElementById('modal-message').textContent = message;
                document.getElementById('modal-affected-date').value = affectedDate;
                document.getElementById('modal-start-date').value = startDate;
                document.getElementById('modal-end-date').value = endDate;

                // Show modal
                modal.classList.remove('hidden');
            });
        });

        // Close modal on click outside
        modal.addEventListener('click', e => {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });
    });

//todo: error
</script>
