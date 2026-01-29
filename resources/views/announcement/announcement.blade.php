@vite(['resources/css/announcement/announce.css'])
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<x-app :noHeader="false" :title="$title">
    <section class="main-content">
        <nav>
            <div class="button">

            <x-button-link
                :noDefault="true"
                source="create.announcement"
            >Create Announcement</x-button-link>
            </div>
        </nav>
        <ul class="nav filter-tabs mb-4" id="announcementTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link "  href="{{route('announcements')}}">All</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link "  href="{{route('announcements', ['type' => 'Payroll'])}}">Payroll</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link "  href="{{route('announcements', ['type' => 'Admin'])}}">Admin</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link "  href="{{route('announcements', ['type' => 'Memo'])}}">Memo</a>
            </li>
        </ul>
        <div class="announcement-list-wrapper">
            <div class="row g-4" id="announcementList">
                @foreach($announcement as $post)
                    <a href="{{route('announce.detail', ['id' => $post->announcement_id])}}" >
                        <div class="col-12 announcement-item" data-type="admin">
                            <div class="d-flex announcement-card align-items-start">
                                <div class="announcement-icon-wrapper me-4">
                                    <i class="bi bi-gear-fill icon-admin"></i>  
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-start justify-content-between gap-3 w-100">
                                        <h5 class="fw-bold mb-0 flex-grow-1">
                                            {{$post->title}}
                                        </h5>
                                    </div>
                                    <p class="text-muted small mb-3 text-uppercase fw-bold" style="font-size: 0.75rem;">
                                        {{$post->subject}}</p>
                                    <p class="mb-0 text-secondary">{{$post->message}}.</p>
                                </div>
                                    <span class="small text-muted text-end flex-shrink-0">
                                            {{ $post->created_at->format('F d, Y') }}
                                    </span>
                            </div>
                        </div>
                    </a>
                    {{--                    end of card--}}
                @endforeach
            </div>
        </div>
    </section>
</x-app>
<style>
:root {
    --sidebar-width-collapsed: 80px;
    --sidebar-width-expanded: 260px;
}

.main-content {
    margin-left: var(--sidebar-width-collapsed);
    width: calc(100% - var(--sidebar-width-collapsed));
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    background: var(--clr-background);
    padding: 2.5rem 3rem;
    transition: all 0.3s ease;
}

.sidebar-expanded .main-content {
    margin-left: var(--sidebar-width-expanded);
    width: calc(100% - var(--sidebar-width-expanded));
}

.announcement-card {
    background-color: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.02);
    transition: all 0.2s ease-in-out;
    display: flex;
    gap: 15px;
}

.announcement-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.08);
    border-color: var(--clr-yellow);
}

.announcement-icon-wrapper {
    width: 50px;
    height: 50px;
    flex-shrink: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #f8f9fa;
    border-radius: 12px;
    font-size: 1.4rem;
}

.announcement-card h5,
.announcement-card p {
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.filter-tabs {
    border-bottom: 2px solid #f0f0f0;
    margin-bottom: 2rem;
    display: flex;
    gap: 30px;
    flex-wrap: nowrap;
    overflow-x: auto;
    scrollbar-width: none;
}

.filter-tabs::-webkit-scrollbar {
    display: none;
}

.filter-tabs .nav-link {
    color: var(--clr-muted);
    font-weight: 600;
    padding: 10px 5px;
    border: none;
    background: transparent;
    position: relative;
    white-space: nowrap;
}

.filter-tabs .nav-link:hover {
    color: var(--clr-primary);
}

.filter-tabs .nav-link.active {
    color: var(--clr-primary);
}

.filter-tabs .nav-link.active::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 100%;
    height: 3px;
    background-color: var(--clr-yellow);
    border-radius: 2px 2px 0 0;
}

a {
    text-decoration: none !important;
    color: inherit;
}

.mb-3 {
    margin-top: 5px;
}

.icon-admin { color: var(--clr-primary); }
.icon-payroll { color: #2ecc71; }
.icon-memo { color: var(--clr-yellow); }
.icon-holiday { color: #e74c3c; }

@media (max-width: 992px) {
    .main-content {
        padding: 2rem;
    }
}

@media (max-width: 800px) {
    .main-content {
        margin-left: 50px;
        width: 85%;
        padding: 1.5rem;
    }

    .announcement-card {
        flex-direction: column;
        align-items: flex-start;
    }

    .announcement-icon-wrapper {
        margin-bottom: 8px;
    }

    h5 {
        font-size: 1rem;
    }

    span {
        margin-top: 10px;
        align-self: flex-end;
    }
}
@media (max-width: 600px) {
    .main-content {
        margin-left: 75px;
        width: 80%;
        padding: 1.5rem;
    }
}

@media (max-width: 480px) {
    .main-content {
        padding: 1rem;
        width: 75%;
    }

    .filter-tabs {
        gap: 20px;
    }

    .announcement-card {
        padding: 15px;
    }
}
</style>