@vite(['resources/css/theme.css'])

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<x-root>
    @include('layouts.side-nav')
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

                <div class="submit-div">
                    <form action="{{route('delete.announcement', ['id' => $announcement->announcement_id])}}" method="post">
                        @csrf
                        <button type="submit" class="submit">Delete Post</button>
                    </form>
                </div>
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
<style>

.attachment {
    border: none;
    background: none;
    justify-content: end;
    transition: color 0.3s ease-in-out;
}

.submit-div {
    display: flex;
    justify-content: center;
    align-items: center;
}

.form-contain{
    display: flex;
    align-items: center;
    justify-content: center;
}

.message-container {
    background: var(--clr-card-surface);
    border-radius: 16px;
    padding: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    display: flex;
    gap: 20px;
    flex-direction: column;
    width: 50%;
    height: 500px;
    margin-top: 125px;
}

input {
    pointer-events: none;
    border: none !important;
    border-bottom: 1px var(--clr-muted) solid !important;
    border-radius: 0 !important;
}

.message-area {
    display: flex;
    height: 90%;
    width: 100%;
    border: 2px solid var(--clr-muted);
    border-radius: 16px;
    padding: 10px;
}

img {
    max-width: 300px;
    max-height: 300px;
}

.submit {
    width: 150px;
    color: white;
    border: none;
    background-color: var(--clr-red);
    border-radius: 10px !important;
    padding: 10px 0;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.attachment:hover {
    color: #ceae43;
}

.submit:hover {
    background-color: var(--clr-indigo);
    color: white;
}

.attachment-modal {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.55);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.attachment-modal-content {
    background: #fff;
    border-radius: 16px;
    padding: 20px;
    max-width: 700px;
    width: 90%;
    max-height: 85vh;
    position: relative;
    animation: popIn 0.25s ease-out;
    box-shadow: 0 20px 40px rgba(0,0,0,0.25);
}

.attachment-modal-content img {
    width: 100%;
    height: auto;
    max-height: 70vh;
    object-fit: contain;
    border-radius: 12px;
}

.close-modal {
    position: absolute;
    top: 12px;
    right: 15px;
    font-size: 28px;
    background: none;
    border: none;
    cursor: pointer;
    color: #333;
}

@keyframes popIn {
    from {
        transform: scale(0.95);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}

@media (max-width: 1000px) {
    .message-container {
        margin-left: 100px;
        width: 55%;
    }
}

@media (max-width: 800px) {
    .message-container {
        margin-left: 75px;
        height: auto;
    }
}

@media (max-width: 600px) {
    .message-container {
        margin-left: 95px;
    }
}
</style>