@vite(['resources/css/employee_web/announcement.css', 'resources/css/theme.css', 'resources/css/includes/sidebar.css'])

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<x-root>
    @include('layouts.employee-side-nav')

    <main class="main-content">
        <div class="container-fluid p-0">
            <div class="row mb-5">
                <div class="col">
                    <h2 class="fw-bold mb-2" style="color: var(--clr-primary);">Announcements</h2>
                    <p class="text-muted mb-0">View all company-wide updates, memos, and payroll notices.</p>
                </div>
            </div>

            <ul class="nav filter-tabs mb-4" id="announcementTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link "  href="{{route('employee_web.announcement')}}">All</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link "  href="{{route('employee_web.announcement', ['type' => 'Payroll'])}}">Payroll</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link "  href="{{route('employee_web.announcement', ['type' => 'Admin'])}}">Admin</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link "  href="{{route('employee_web.announcement', ['type' => 'Memo'])}}">Memo</a>
                </li>
            </ul>


            <div class="announcement-list-wrapper">
                <div class="row g-4" id="announcementList">
{{--                                announcement card--}}
                @foreach($announcements as $post)
                        <a href="{{route('new.announcement.view', ['id' => $post->announcement_id])}}" >
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

        </div>
    </main>
</x-root>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('#announcementTabs button');
        const announcementItems = document.querySelectorAll('.announcement-item');

        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                const filterType = this.getAttribute('data-filter');

                announcementItems.forEach(item => {
                    const itemType = item.getAttribute('data-type');

                    if (filterType === 'all' || itemType === filterType) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
