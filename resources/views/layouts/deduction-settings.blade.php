{{-- layouts/deductions.blade.php --}}
<x-app :noHeader="true">
{{--    @vite(['resources/css/theme.css'])--}}
<main>

    <div class="container-fluid px-4 py-5" id="body">
        {{-- SHARED HEADER --}}
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h1 class="h3 fw-bold text-dark mb-1">Deduction Settings</h1>
                <p class="text-muted small mb-0">Manage statutory contributions and tax brackets for 2026 payroll.</p>
            </div>
        </div>

        {{-- NAVIGATION TABS --}}
        <div class="mb-4" >
            <ul class="nav nav-tabs border-bottom-0 custom-tabs">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('deductions.tax*') ? 'active' : '' }}"
                       href="{{ route('deductions.tax') }}">
                        <i class="bi bi-percent me-2"></i>Income Tax
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('deductions.sss*') ? 'active' : '' }}"
                       href="{{ route('deductions.sss') }}">
                        <i class="bi bi-shield-check me-2"></i>SSS
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('deductions.philhealth*') ? 'active' : '' }}"
                       href="{{ route('deductions.philhealth') }}">
                        <i class="bi bi-heart-pulse me-2"></i>PhilHealth
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('deductions.pagibig*') ? 'active' : '' }}"
                       href="{{ route('deductions.pagibig') }}">
                        <i class="bi bi-house-door me-2"></i>Pag-IBIG
                    </a>
                </li>
            </ul>
            <div class="tab-border-line"></div>
        </div>

        {{-- INJECTED CONTENT --}}
        <div class="deduction-body animate-fade-in">
            @yield('deduction_content')
        </div>
    </div>
</main>
</x-app>

<style>
    /* Force horizontal layout and prevent bunching */
    .custom-tabs {
        display: flex !important;
        flex-wrap: nowrap !important;
        overflow: hidden;
        gap: 100px; /* Space between tabs */
    }

    .custom-tabs .nav-item {
        white-space: nowrap; /* Prevents text from wrapping into two lines */
    }

    .custom-tabs .nav-link {
        border: none;
        color: #6c757d;
        font-weight: 500;
        padding: 12px 20px !important; /* Fixed padding for better click area */
        display: flex;
        align-items: center;
        /*gap: 100px;*/
        transition: all 0.2s ease;
        border-bottom: 3px solid transparent !important;
    }

    /* Active State Fix */
    .custom-tabs .nav-link.active {
        color: var(--clr-primary) !important;
        background: transparent !important;
        border-bottom-color: var(--clr-yellow)!important;
        font-weight: 700;
        width: auto;
    }

    .tab-border-line {
        height: 1px;
        background-color: #e3e6f0;
        width: 100%;
        margin-top: -1px; /* Bridges the gap to the tab border */
    }

    /* Clean up the card headers in inner views */
    .deduction-body .card-header {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
    }

    @media (max-width: 1150px) {
        #body {
            margin-left: 35px;
        }
    }

    @media (max-width: 800px) {
        #body {
            margin-left: 50px;
        }
    }

    @media (max-width: 700px) {
        #body {
            margin-left: 125px;
        }
    }

    @media (max-width: 620px) {
        #body {
            margin-left: 235px;
        }
    }

    @media (max-width: 600px) {
        #body {
            margin-left: 245px;
        }
    }

    @media (max-width: 550px) {
        #body {
            margin-left: 295px;
        }
    }

    @media (max-width: 480px) {
        #body {
            margin-left: 345px;
        }
    }

    @media (max-width: 450px) {
        #body {
            margin-left: 395px;
        }
    }

    @media (max-width: 400px) {
        #body {
            margin-left: 445px;
        }
    }

    @media (max-width: 350px) {
        #body {
            margin-left: 495px;
        }
    }
</style>
