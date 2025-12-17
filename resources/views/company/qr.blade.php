@vite(['resources/css/company/qr.css'])

<x-app :noHeader="true" :navigation="true" :company="$company">
    <div class="main-content">
        <div class="qr-wrapper" id="qrWrapper">
            <h4 id="companyName">{{ $company->company_name }}</h4>
            
            {!! $qrCode !!}

            <button type="button" class="btn-download" onclick="downloadDecoratedQR()">
                Download QR Code
            </button>
        </div>
    </div>
</x-app>
<script>
function downloadDecoratedQR() {
    const wrapper = document.getElementById('qrWrapper');
    const companyName = document.getElementById('companyName').innerText;

    const svg = wrapper.querySelector('svg');
    const img = wrapper.querySelector('img');

    if (!svg && !img) {
        alert('QR not found');
        return;
    }

    const testCanvas = document.createElement('canvas');
    const testCtx = testCanvas.getContext('2d');
    testCtx.font = 'bold 30px Arial';

    const qrSize = 450;
    const padding = 40;
    const textPaddingTop = 20;
    const textPaddingBottom = 20;
    const lineHeight = 35;
    const maxWidth = qrSize + padding * 2 - 40;
    const words = companyName.split(' ');
    const lines = [];
    let currentLine = words[0];

    for (let i = 1; i < words.length; i++) {
        const word = words[i];
        const width = testCtx.measureText(currentLine + ' ' + word).width;
        if (width < maxWidth) {
            currentLine += ' ' + word;
        } else {
            lines.push(currentLine);
            currentLine = word;
        }
    }
    lines.push(currentLine);

    const textHeight = lines.length * lineHeight;
    const totalHeight = qrSize + padding * 2 + textPaddingTop + textPaddingBottom + textHeight;
    const totalWidth = qrSize + padding * 2;

    const canvas = document.createElement('canvas');
    canvas.width = totalWidth;
    canvas.height = totalHeight;
    const ctx = canvas.getContext('2d');

    ctx.fillStyle = '#ffffff';
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    ctx.fillStyle = '#000000';
    ctx.font = 'bold 30px Arial';
    ctx.textAlign = 'center';
    ctx.textBaseline = 'top';

    const textStartY = textPaddingTop;
    lines.forEach((line, index) => {
        const y = textStartY + (index * lineHeight);
        ctx.fillText(line, canvas.width / 2, y);
    });

    const drawQR = (image) => {
        const qrX = (canvas.width - qrSize) / 2;
        const qrY = textPaddingTop + textHeight + textPaddingBottom;
        
        ctx.drawImage(image, qrX, qrY, qrSize, qrSize);

        canvas.toBlob(blob => {
            const url = URL.createObjectURL(blob);
            triggerDownload(url, `${companyName}-QR.png`);
        });
    };

    if (svg) {
        const serializer = new XMLSerializer();
        const svgData = serializer.serializeToString(svg);
        const svgBlob = new Blob([svgData], { type: 'image/svg+xml;charset=utf-8' });
        const url = URL.createObjectURL(svgBlob);

        const image = new Image();
        image.onload = () => {
            URL.revokeObjectURL(url);
            drawQR(image);
        };
        image.src = url;
        return;
    }

    if (img) {
        const image = new Image();
        image.crossOrigin = 'anonymous';
        image.onload = () => drawQR(image);
        image.src = img.src;
    }
}

function triggerDownload(url, filename) {
    const a = document.createElement('a');
    a.href = url;
    a.download = filename.replace(/\s+/g, '_');
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}
</script> 