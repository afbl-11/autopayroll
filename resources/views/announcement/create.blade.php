@vite('resources/css/announcement/create.css')

<x-app :title="$title" :noDefault="false">
    <section class="main-content">
        <div class="content-wrapper">
            <form action="{{route("post.announcement")}}" method="post">
                @csrf
                <x-form-input
                    id="title"
                    name="title"
                    label="Announcement Title"
                />
                    <textarea name="message" id="message" cols="30" rows="10" class="cstmTextarea"></textarea>
                <div class="action">
                        <x-button-submit>Post Announcement</x-button-submit>
                </div>
            </form>
        </div>
    </section>
</x-app>
