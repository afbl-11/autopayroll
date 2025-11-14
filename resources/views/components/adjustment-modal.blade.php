@vite('resources/css/components/adjustment-modal.css')

<div class="adjustment-modal">
    <div class="employee-info">
        <div class="name-wrapper">
            <h6 id="modal-name"></h6>
            <small id="modal-type"></small>
        </div>
    </div>
    <div class="dates">
        <x-form-input
            type="text"
            label="Affected Date"
            name="affected_date"
            id="modal-affected-date"
            :readOnly="true"
        />

        <x-form-input
            type="text"
            label="Start Date"
            name="end_date"
            id="modal-start-date"
            :readOnly="true"
        />

        <x-form-input
            type="text"
            label="End Date"
            name="end_date"
            id="modal-end-date"
            :readOnly="true"
        />

    </div>
    <div class="message" id="modal-message">
    </div>
    <div class="buttons">
        <form action="{{ route('reject.adjustment') }}" method="post">
            @csrf
            <input type="hidden" name="adjustment_id" id="modal-reject-id">
            <x-button-submit>Reject</x-button-submit>
        </form>
        <form action="{{route('approve.adjustment')}}" method="post">
            @csrf
            <input type="hidden" name="adjustment_id" id="modal-approve-id">
            <x-button-submit>Approve</x-button-submit>
        </form>
    </div>
</div>
