@vite(['resources/css/announcement/announce.css'])

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
        <div class="announcement-wrapper">
            @forelse($announcement as $announce)
                <x-announcement-card
                    :title="$announce->title"
                    :id="$announce->announcement_id"
                    :message="$announce->message"
                    :date="$announce->created_at->format('Y-m-d')"
                />
                @empty
                   <p id="emptyNotif">No Announcements Found</p>
            @endforelse
        </div>
    </section>
</x-app>
