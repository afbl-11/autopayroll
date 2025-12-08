@vite('resources/css/company/company-cards.css')

<a href="{{ route('company.dashboard.detail', ['id'=> $id]) }}">
    <table class="company-table-row">

        {{-- LOGO + NAME + INDUSTRY --}}
        <tr>
            <th>Company</th>
            <td class="company-info-cell">
                <img src="{{ asset($logo) }}" alt="Company Logo" class="table-logo">
                <div class="company-info-text">
                    <p class="company-name">{{ $name }}</p>
                    <small class="company-industry">{{ $industry }}</small>
                </div>
            </td>
        </tr>

        {{-- COMPANY ID --}}
        <tr>
            <th>Company ID</th>
            <td>#{{ $id }}</td>
        </tr>

        {{-- ADDRESS --}}
        <tr>
            <th>Address</th>
            <td>{{ $address }}</td>
        </tr>

        {{-- EMPLOYEE COUNT --}}
        <tr>
            <th>Employees</th>
            <td>{{ $count }}</td>
        </tr>

    </table>
</a>