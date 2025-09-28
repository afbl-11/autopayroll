let fileUrl = null;
let fileType = null;
let fileName = null;
let prevObjectUrl = null;

let fileInput, previewContainer, seenStatus, attachedLink;

function init() {
    fileInput = document.getElementById('file-input');
    previewContainer = document.getElementById('preview-container');
    seenStatus = document.getElementById('seen-status');
    attachedLink = document.getElementById('attached-link');

    if (!fileInput || !previewContainer || !attachedLink || !seenStatus) return;

    fileInput.addEventListener('change', setFilePreview);
    attachedLink.addEventListener('click', chooseOrViewFile);

    attachedLink.textContent = 'View Attached File';
    attachedLink.href = 'javascript:void(0)';
    previewContainer.style.display = 'none';
    seenStatus.textContent = '';

    moveAttachment();
}

function chooseOrViewFile(e) {
    e && e.preventDefault();
    if (!fileUrl) {
        alert('Employee did not attach a file here.')
        fileInput.click(); //for testing purposes 
        return;
    }

    const isHidden = previewContainer.style.display === 'none' || previewContainer.style.display === '';
    if (isHidden) {
        previewContainer.style.display = 'block';
        markSeen();
    } else {
        previewContainer.style.display = 'none';
        markUnseen();
    }
}

function setFilePreview(event) {
    const file = event.target.files && event.target.files[0];
    if (!file) return;

    if (prevObjectUrl) URL.revokeObjectURL(prevObjectUrl);

    fileUrl = URL.createObjectURL(file);
    prevObjectUrl = fileUrl;
    fileType = (file.name.split('.').pop() || '').toLowerCase();
    fileName = file.name;

    attachedLink.textContent = 'View Attached File';

    previewContainer.innerHTML = '';
    previewContainer.style.display = 'none';

    if (fileType === 'pdf') {
        const iframe = document.createElement('iframe');
        iframe.src = fileUrl;
        iframe.style.width = '100%';
        iframe.style.minHeight = '400px';
        iframe.style.height = '60vh';
        iframe.setAttribute('title', fileName + ' preview');
        previewContainer.appendChild(iframe);
    } else if (fileName.endsWith(".doc") || fileName.endsWith(".docx")) {
        const iframe = document.createElement('iframe');
        iframe.src = "https://view.officeapps.live.com/op/embed.aspx?src=" + encodeURIComponent("https://yourdomain.com/uploads/" + fileName);
        previewContainer.appendChild(iframe);
        const dl = document.createElement('a');
        dl.href = fileUrl;
        dl.download = fileName;
        dl.textContent = 'Download File';
        dl.className = 'download-btn';
    previewContainer.appendChild(dl);
    } else if (['png', 'jpg','jpeg','gif','bmp','webp'].includes(fileType)) {
        const img = document.createElement('img');
        img.src = fileUrl;
        img.alt = fileName;
        img.style.maxWidth = '100%';
        img.style.height = 'auto';
        img.style.maxHeight = '70vh';
        previewContainer.appendChild(img);
    }

    markUnseen();
}

function markSeen() {
    seenStatus.textContent = 'Seen';
    seenStatus.classList.remove('unseen');
    seenStatus.classList.add('seen');
}

function markUnseen() {
    seenStatus.textContent = 'Unseen';
    seenStatus.classList.remove('seen');
    seenStatus.classList.add('unseen');
}

function moveAttachment() {
    const attachedRow = document.querySelector(".attached-row");
    const detailsCard = document.querySelector(".leave-details-card");
    const leftColEl = document.querySelector(".left-col");

    if (!attachedRow || !detailsCard || !leftColEl) return;

    if (window.innerWidth <= 980) {
        detailsCard.insertAdjacentElement("afterend", attachedRow);
    } else {
        leftColEl.appendChild(attachedRow);
    }
}

window.addEventListener('DOMContentLoaded', init);
window.addEventListener('resize', moveAttachment);