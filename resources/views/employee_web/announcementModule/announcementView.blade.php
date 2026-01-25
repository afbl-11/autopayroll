@vite(['resources/css/employee_web/announcement.css','resources/css/employee_web/announcementView.css', 'resources/css/theme.css'])

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<x-root>
    @include('layouts.employee-side-nav')

    <main class="main-content">
        <div class="row mb-5">
        <div class="col">
            <h2 class="fw-bold mb-2" style="color: var(--clr-primary);">Announcements</h2>
            <p class="text-muted mb-0">View all company-wide updates, memos, and payroll notices.</p>
        </div>
        </div>
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
                <button type="button" id="openAttachmentModal">
                    See attached photo
                </button>


                @if($announcement->attachments)
                    @php $files = json_decode($announcement->attachments, true); @endphp

                    @foreach($files as $file)
                        @php $ext = pathinfo($file, PATHINFO_EXTENSION); @endphp

                        @if(in_array(strtolower($ext), ['jpg','jpeg','png','gif']))
                            <!-- Modal Overlay -->
                            <div class="attachment-modal" id="attachmentModal">
                                <div class="attachment-modal-content">
                                    <button class="close-modal">&times;</button>
                                    <img src="{{ asset('storage/' . $file) }}" alt="Attachment">
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif

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
