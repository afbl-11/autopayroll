@vite(['resources/css/employee_web/announcementView.css', 'resources/css/theme.css'])

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<x-root>
    @include('layouts.employee-side-nav')

    <main class="main-content">
        <div class="form-contain">

            <div class="message-container">
                <x-form-input
                    :value="$announcement->title"
                    label="Title"
                    :readOnly="true"
                />
                <x-form-input
                    :value="$announcement->subject"
                    label="Subject"
                    :readOnly="true"
                />

                <div class="message-area">
                    {{$announcement->message}}
                </div>

                @php
                    $files = $announcement->attachments 
                        ? json_decode($announcement->attachments, true) 
                        : [];

                    $imageFile = null;
                    foreach ($files as $file) {
                        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                        if (in_array($ext, ['jpg','jpeg','png','gif'])) {
                            $imageFile = $file;
                            break;
                        }
                    }
                @endphp

                @if($imageFile)
                    <!-- If image exists -->
                    <div class="attachment-div">
                        <button type="button" id="openAttachmentModal" class="attachment">
                            See attached photo
                        </button>
                    </div>

                    <div class="attachment-modal" id="attachmentModal">
                        <div class="attachment-modal-content">
                            <button class="close-modal">&times;</button>
                            <img src="{{ asset('storage/' . $imageFile) }}" alt="Attachment">
                        </div>
                    </div>
                @else
                    <!-- If no image -->
                    <div class="attachment-div">
                        <span class="text-muted">No attached photo</span>
                    </div>
                @endif
{{--                <div class="submit-div">--}}
{{--                    <form action="{{route('employee.delete.announcement', ['id' => $announcement->announcement_id])}}" method="post">--}}
{{--                        @csrf--}}
{{--                        <button type="submit" class="submit">Delete Post</button>--}}
{{--                    </form>--}}
{{--                </div>--}}
            </div>
        </div>


    </main>

</x-root>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const openBtn = document.getElementById('openAttachmentModal');
        const modal = document.getElementById('attachmentModal');
        const closeBtn = modal?.querySelector('.close-modal');

        if (!openBtn || !modal) return;

        openBtn.addEventListener('click', () => {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });

        closeBtn.addEventListener('click', closeModal);

        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });

        function closeModal() {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    });
</script>
