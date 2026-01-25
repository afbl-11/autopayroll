@vite('resources/css/announcement/create.css')

<x-app :title="$title" :noDefault="false">
    <section class="main-content">
        <div class="content-wrapper">
            <form action="{{ route('post.announcement') }}" method="post" enctype="multipart/form-data">
                @csrf

                <x-form-input
                    id="title"
                    name="title"
                    label="Announcement Title"
                />

                <x-form-input
                    id="subject"
                    name="subject"
                    label="Subject"
                />

                <x-form-select
                    name="type"
                    id="type"
                    label="Type"
                    :options="$types"
                ></x-form-select>

                <textarea name="message" id="message" cols="30" rows="10" class="cstmTextarea"></textarea>

                <!-- File attachment -->
                <div class="mb-4">
                    <label for="attachment" class="w-100 cursor-pointer">
                        <div class="btn w-100 d-flex align-items-center justify-content-center py-2 text-dark"
                             style="border-radius: 25px; border: 1px solid #ced4da; background-color: white;">
                            <i class="bi bi-paperclip me-2 fs-5"></i>
                            <span id="fileName" class="fw-normal">Attach Image / File</span>
                        </div>
                        <input type="file" id="attachment" name="attachment" class="d-none" onchange="updateFileName(this)">
                    </label>
                </div>

                <div class="action">
                    <x-button-submit>Post Announcement</x-button-submit>
                </div>
            </form>
        </div>
    </section>
</x-app>

<script>
    // Update file name display when user selects a file
    function updateFileName(input) {
        if (input.files && input.files.length > 0) {
            document.getElementById('fileName').innerText = input.files[0].name;
        }
    }
</script>
