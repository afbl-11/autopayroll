@vite(['resources/css/company/qr.css'])

<x-app :noHeader="true" :navigation="true" :company="$company">
    <div class="main-content">
        <div class="qr-wrapper">
            <h4>{{$company->company_name}}</h4>
            {!! $qrCode !!}

            <form action="{{ route('company.qr.download', $company->company_id) }}" method="POST">
                @csrf
                <x-button-submit>Save</x-button-submit>
            </form>
        </div>
    </div>
</x-app>
