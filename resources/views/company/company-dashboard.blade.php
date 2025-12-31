@vite('resources/css/company/dashboard.css')

<x-app :title="$title">
    <nav>
        <div class="btn-link">
            <x-button-link source="show.register.client" :noDefault="true">Add Company</x-button-link>
        </div>
    </nav>

    <section class="main-content">
        <div class="search-filter-container">
        <input type="text" id="companySearch" placeholder="Search company..." class="company-search">
        <select id="industrySelect" class="industry-select">
            <option value="">All Industries</option>
            @php
                $industries = $companies->pluck('industry')->map(fn($i) => strtolower($i))->unique()->sort();
            @endphp
            @foreach($industries as $industry)
                <option value="{{ $industry }}">{{ ucwords($industry) }}</option>
            @endforeach
        </select>
        </div>

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
                        :logo="$company->company_logo"
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

    <script>
        const industrySelect = document.getElementById("industrySelect");
        const companySearch  = document.getElementById("companySearch");
        const companyItems   = document.querySelectorAll(".company-item");

        industrySelect.addEventListener("change", function () {
            const selectedIndustry = this.value;

            companyItems.forEach(item => {
                const itemIndustry = item.dataset.industry;
                const matchesIndustry = selectedIndustry === "" || itemIndustry === selectedIndustry;
                const matchesSearch = item.dataset.name.includes(companySearch.value.toLowerCase());
                item.style.display = (matchesIndustry && matchesSearch) ? "block" : "none";
            });
        });

        companySearch.addEventListener("input", function () {
            const query = this.value.toLowerCase();
            const selectedIndustry = industrySelect.value;

            companyItems.forEach(item => {
                const itemName = item.dataset.name;
                const itemIndustry = item.dataset.industry;
                const matchesSearch = itemName.includes(query);
                const matchesIndustry = selectedIndustry === "" || itemIndustry === selectedIndustry;
                item.style.display = (matchesSearch && matchesIndustry) ? "block" : "none";
            });
        });

        window.addEventListener("pageshow", function (event) {
            if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
                industrySelect.selectedIndex = 0;
                companySearch.value = "";
                companyItems.forEach(item => item.style.display = "block");
            }
        });
    </script>
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function showCustomAlert(message) {
                const alert = document.createElement("div");
                alert.className = "custom-alert";
                alert.textContent = message;
                document.body.appendChild(alert);
                setTimeout(() => alert.remove(), 3500);
            }
            showCustomAlert(@json(session('success')));
        });
    </script>
    @endif
</x-app>
<style>
    .custom-alert {
        position: fixed;
        top: 20px;
        right: 20px;
        background: #FFD858;
        color: black;
        padding: 14px 20px;
        border-radius: 8px;
        font-size: 14px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        z-index: 9999;
        animation: slideIn 0.4s ease, fadeOut 0.4s ease 3s forwards;
    }

    @keyframes slideIn {
        from { transform: translateX(30px); opacity: 0; }
        to   { transform: translateX(0); opacity: 1; }
    }

    @keyframes fadeOut {
        to { opacity: 0; transform: translateX(30px); }
    }
</style>