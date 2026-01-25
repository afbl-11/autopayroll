@vite(['resources/css/announcement/announce.css', 'resources/css/employee_web/announcement.css'])
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
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h5 class="fw-bold mb-0">{{$post->title}}</h5>
                                        <span class="small text-muted">{{ $post->created_at->format('F d, Y') }}</span>
                                    </div>
                                    <p class="text-muted small mb-3 text-uppercase fw-bold" style="font-size: 0.75rem;">
                                        {{$post->subject}}</p>
                                    <p class="mb-0 text-secondary">{{$post->message}}.</p>
                                </div>
                            </div>
                        </div>
                    </a>
                    {{--                    end of card--}}
                @endforeach
            </div>
        </div>
    </section>
</x-app>
