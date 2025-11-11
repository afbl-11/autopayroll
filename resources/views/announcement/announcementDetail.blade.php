@vite(['resources/css/announcement/detail.css'])

<x-app :nodefault="false" :title="$title">
    <section class="main-content">
        <div class="content-wrapper">
            <x-form-input
                id="title"
                :value="$announce->title"
                label="Announcement Title"
                :readOnly="true"
            />

            <div class="message-wrapper">
                {{$announce->message}}
            </div>
            <div class="action">
                <form action="{{route('delete.announcement', ['id'=> $announce->announcement_id])}}" method="post">
                    @csrf
                    <x-button-submit>Delete Post</x-button-submit>
                </form>
            </div>

        </div>
    </section>
</x-app>
