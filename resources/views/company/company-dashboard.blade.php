@vite('resources/css/company/dashboard.css')

<x-app :title="$title">
    <nav>
        <div class="btn-link">
            <x-button-link source="show.register.client" :noDefault="true">Add Company</x-button-link>
        </div>
    </nav>

    <section class="main-content">
        <select id="companySelect" class="company-select">
            <option value="">Select a company...</option>

            @foreach($companies as $company)
                <option 
                    value="{{ route('company.dashboard.detail', ['id' => $company->company_id]) }}"
                    data-name="{{ strtolower($company->company_name) }}"
                    data-industry="{{ strtolower($company->industry) }}">
                        {{ $company->company_name }}
                </option>
            @endforeach
        </select>

        <div id="companyList">
            <div class="company-header">
            <div class="h-col h-id">ID</div>
            <div class="h-col h-company">Company</div>
            <div class="h-col h-address">Address</div>
            <div class="h-col h-employees">Employees</div>
            </div>
            @foreach($companies as $company)
                <div class="company-item"
                     data-name="{{ strtolower($company->company_name) }}"
                     data-industry="{{ strtolower($company->industry) }}">

                    <x-company-cards
                        :id="$company->company_id"
                        :industry="$company->industry"
                        :address="$company->address"
                        :logo="'assets/company-pic.jpg'"
                        :name="$company->company_name"
                        :count="$company->employees_count"
                    ></x-company-cards>
                </div>
            @endforeach
        </div>

        @if($companies->isEmpty())
            <p class="no-results">No companies found.</p>
        @endif
    </section>
</x-app>

<script>
    const selectBox    = document.getElementById("companySelect");
    const companyItems = document.querySelectorAll(".company-item");

    (function removeDuplicates() {
        const seen = new Set();
        const options = [...selectBox.options]; 

        options.forEach(option => {
            const name = option.dataset?.name;
            if (!name) return;

            if (seen.has(name)) {
                option.remove(); 
            } else {
                seen.add(name); 
            }
        });
    })();
 
    selectBox.selectedIndex = 0;

    selectBox.addEventListener("change", function () {
        const selectedOption = this.selectedOptions[0];
        const selectedName   = selectedOption.dataset.name; 
        const selectedValue  = this.value;

        companyItems.forEach(item => {
            const itemName = item.dataset.name;

            if (selectedValue === "") {
                item.style.display = "block";
                return;
            }

            item.style.display = (itemName === selectedName) ? "block" : "none";
        });
    });

    window.addEventListener("pageshow", function (event) {
    if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
        selectBox.selectedIndex = 0;
        companyItems.forEach(item => item.style.display = "block");
    }
});
</script>



