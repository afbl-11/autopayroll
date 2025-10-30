@vite('resources/css/company/dashboard.css')

<x-app :title="$title">
        <nav>
            <div class="btn-link">
                <x-button-link source="show.register.client" :noDefault="true">Add Company</x-button-link>
            </div>
        </nav>

    <section class="main-content">
        <div id="cards-container">
            @foreach($companies as $company)
                <x-company-cards
                    :id="$company->company_id"
                    :industry="$company->industry"
                    :address="$company->address"
                    :logo="'assets/company-pic.jpg'"
                    :name="$company->company_name"
                    :count="$company->employees_count"
                ></x-company-cards>
            @endforeach
        </div>
        @if($companies->isEmpty())
            <p class="no-results">No companies found.</p>
        @endif
    </section>
</x-app>
