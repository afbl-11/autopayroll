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
    
    <div class="supporting-doc">
        <a id="modal-doc-link" 
        target="_blank"
        style="display:none;"
        class="doc-link">
            View Supporting Document
        </a>

        <p id="modal-no-doc" class="no-doc">
            No supporting document uploaded.
        </p>
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
<style>
    a {
        color: #4B5563;
        text-decoration: none;
        font-size: 14px;
        transition: color 0.2s ease-in-out;
    }
    a:hover {
        color: #ceae43;
    }
    .no-doc {
        font-size: 14px;
    }
</style>