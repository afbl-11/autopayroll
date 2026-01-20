(function () {
    const style = document.createElement('style');
    style.textContent = `#filePreview {
    position: relative;
    }
    #previewContent {
    width: 100%;
    height: 100%;
    overflow: hidden;
    touch-action: none;
    }
    #previewContent img, #previewContent iframe {
    user-select: none;
    -webkit-user-drag: none;
    -webkit-user-select: none;
    pointer-events: auto;
    transform-origin: 0 0;
    will-change: transform;
    display: block;
    max-width: none;
    max-height: none;
    }
    .preview-controls {
    position: absolute;
    top: 8px;
    right: 8px;
    display: flex;
    gap: 6px;
    z-index: 9999;
    background: rgba(255,255,255,0.9);
    border-radius: 6px;
    padding: 6px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.12);
    align-items: center;
    }
    .preview-controls button {
    border: 0;
    background: transparent;
    padding: 6px 8px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    }
    .preview-controls button:hover {
    background: rgba(0,0,0,0.05);
    }`;
    document.head.appendChild(style);

    const dobEl = document.getElementById('date-Of-birth');
    const ageEl = document.getElementById('age');

    if (dobEl) {
        dobEl.addEventListener('blur', function () {
            const val = this.value;
            const dateOfbirth = new Date(val);
            if (isNaN(dateOfbirth)) return;

            const today = new Date();
            if (dateOfbirth > today) {
                if (ageEl) ageEl.value = '';
                alert("Date of birth cannot be in the future.");
                 return;
            }

            const diff = Date.now() - dateOfbirth.getTime();
            const ageDate = new Date(diff);
            const age = Math.abs(ageDate.getUTCFullYear() - 1970);
            if (ageEl) ageEl.value = age;

            if (age < 15) {
                this.value = '';
                if (ageEl) ageEl.value = '';
                alert("The hired employee does not meet the required minimum age standards for employment.");
                return;
            }

            if (age > 65) {
                this.value = '';
                if (ageEl) ageEl.value = '';
                alert("The hired employee is beyond the suitable age range for employment.");
                return;
            }
        });
    }
    if (ageEl) {
        ageEl.addEventListener('change', function() {
            const dateEl = document.getElementById('date-Of-birth');
            if (!dateEl || !dateEl.value.trim()) {
                alert("Please enter the employee's date of birth first.");
                this.value = '';
                if (dateEl) dateEl.focus();
                return;
            }
        });
    }

    function updateStepsForDiv(stepsDiv) {
        const currentStep = Number(stepsDiv.dataset.currentStep) || 1;
        const verified = stepsDiv.dataset.verifiedSrc || '/assets/employeeProfile/VerifiedAccount.png';

        const steps = stepsDiv.querySelectorAll('.steps');
        const lines = stepsDiv.querySelectorAll('.line');

        steps.forEach(step => {
            const stepNum = Number(step.dataset.step);
            const img = step.querySelector('img');
            if (img && stepNum <= currentStep){
                img.src = verified;
            }
            step.classList.toggle('active-step', stepNum <= currentStep);
        });

        lines.forEach(line => {
            const lineNum = Number(line.dataset.step);
            line.classList.toggle('active-line', lineNum <= currentStep);
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.steps-div').forEach(updateStepsForDiv);
        const empButtons = document.querySelectorAll('.emp-buttons .type');
        let selectedType = null;

            empButtons.forEach(button => {
                button.addEventListener('click', () => {

                    if (button.classList.contains('type-selected')) {
                        button.classList.remove('type-selected');
                        selectedType = null;
                        console.log('Deselected Employment Type');
                    } else {
                        empButtons.forEach(btn => btn.classList.remove('type-selected'));
                        button.classList.add('type-selected');
                        selectedType = button.textContent.trim();
                        console.log('Selected Employment Type:', selectedType);
                    }
                });
            });

        const browseButton = document.querySelector('.browse');
        const uploadInput = document.getElementById('uploadDocuments');
        const filePreview = document.getElementById('filePreview');
        const previewContent = document.getElementById('previewContent');
        const seenIndicator = document.getElementById('seenIndicator');
        const removeBtn = document.getElementById('removeFile');

        // Only set up file upload preview if elements exist
        if (!browseButton || !uploadInput || !filePreview || !previewContent) {
            console.log('File upload preview elements not found on this page, skipping...');
            return;
        }

        const hiddenFileInput = document.createElement('input');
        hiddenFileInput.type = 'file';
        hiddenFileInput.accept = ".pdf,.doc,.docx,.png,.jpg,.jpeg";
        hiddenFileInput.style.display = 'none';
        document.body.appendChild(hiddenFileInput);

        let uploadedFileURL = null;
        let activePreviewElement = null;
        let controlsWrapper = null;

        browseButton.addEventListener('click', () => {
          hiddenFileInput.click();
        });

        function createPreviewControls(container, targetEl) {
          if (controlsWrapper) controlsWrapper.remove();

          controlsWrapper = document.createElement('div');
          controlsWrapper.className = 'preview-controls';

          const btnZoomIn = document.createElement('button');
          btnZoomIn.title = 'Zoom In';
          btnZoomIn.textContent = '+';
          const btnZoomOut = document.createElement('button');
          btnZoomOut.title = 'Zoom Out';
          btnZoomOut.textContent = '-';
          const btnReset = document.createElement('button');
          btnReset.title = 'Reset';
          btnReset.textContent = '⟲';
          const btnDragToggle = document.createElement('button');
          btnDragToggle.title = 'Toggle Drag';
          btnDragToggle.textContent = '✋';

        controlsWrapper.append(btnZoomOut, btnZoomIn, btnReset, btnDragToggle);
        container.appendChild(controlsWrapper);

        const state = {
          scale: 1,
          minScale: 0.25,
          maxScale: 8,
          translateX: 0,
          translateY: 0,
          dragging: false,
          dragEnabled: false,
          lastClientX: 0,
          lastClientY: 0,
        };
        btnDragToggle.style.opacity = '0.5';

        function updateTransform() {
          targetEl.style.transform = `translate(${state.translateX}px, ${state.translateY}px) scale(${state.scale})`;
        }

        function clampScale(s) {
          return Math.max(state.minScale, Math.min(state.maxScale, s));
        }

        btnZoomIn.addEventListener('click', () => {
          state.scale = clampScale(state.scale * 1.15);
          updateTransform();
        });

        btnZoomOut.addEventListener('click', () => {
          state.scale = clampScale(state.scale / 1.15);
          updateTransform();
        });

        btnReset.addEventListener('click', () => {
          state.scale = 1;
          state.translateX = 0;
          state.translateY = 0;
          updateTransform();
        });

        btnDragToggle.addEventListener('click', () => {
          state.dragEnabled = !state.dragEnabled;
          if (targetEl.tagName.toLowerCase() === "iframe" || targetEl.querySelector("iframe")) {
              const iframe = targetEl.tagName.toLowerCase() === "iframe" ? targetEl : targetEl.querySelector("iframe");
              iframe.style.pointerEvents = state.dragEnabled ? 'none' : 'auto';
          }
          btnDragToggle.style.opacity = state.dragEnabled ? '1' : '0.5';
        });

        container.addEventListener('wheel', (ev) => {
          if (filePreview.hidden) return;
          ev.preventDefault();
          const delta = -ev.deltaY || ev.wheelDelta;
          const zoomFactor = delta > 0 ? 1.08 : 1 / 1.08;
          const rect = targetEl.getBoundingClientRect();
          const offsetX = ev.clientX - rect.left;
          const offsetY = ev.clientY - rect.top;
          const prevScale = state.scale;
          const nextScale = clampScale(prevScale * zoomFactor);
          state.translateX = (state.translateX - offsetX) * (nextScale / prevScale) + offsetX;
          state.translateY = (state.translateY - offsetY) * (nextScale / prevScale) + offsetY;
          state.scale = nextScale;
          updateTransform();
        }, { passive: false });

        targetEl.addEventListener('pointerdown', (ev) => {
          if (!state.dragEnabled) return;
          ev.preventDefault();
          state.dragging = true;
          targetEl.setPointerCapture(ev.pointerId);
          state.lastClientX = ev.clientX;
          state.lastClientY = ev.clientY;
        });

        targetEl.addEventListener('pointermove', (ev) => {
          if (!state.dragging) return;
          ev.preventDefault();
          const dx = ev.clientX - state.lastClientX;
          const dy = ev.clientY - state.lastClientY;
          state.lastClientX = ev.clientX;
          state.lastClientY = ev.clientY;
          state.translateX += dx;
          state.translateY += dy;
          updateTransform();
        });

        targetEl.addEventListener('pointerup', (ev) => {
          if (!state.dragging) return;
          state.dragging = false;
          try {
            targetEl.releasePointerCapture(ev.pointerId);
          } catch (e) {}
        });

        targetEl.addEventListener('dblclick', () => {
          state.scale = 1;
          state.translateX = 0;
          state.translateY = 0;
          updateTransform();
        });

       return {
        destroy() {
          controlsWrapper && controlsWrapper.remove();
          controlsWrapper = null;
        },
        state
       };
      }

      hiddenFileInput.addEventListener('change', () => {
          if (hiddenFileInput.files.length > 0) {
            const file = hiddenFileInput.files[0];
            const fileName = file.name;
            const fileType = file.type;

            if (uploadedFileURL) {
              URL.revokeObjectURL(uploadedFileURL);
            }
            uploadedFileURL = URL.createObjectURL(file);
            uploadInput.value = fileName;
            seenIndicator.hidden = false;
            seenIndicator.textContent = "Unseen";
            seenIndicator.classList.remove("seen");
            seenIndicator.classList.add("unseen");
            removeBtn.hidden = false;
            previewContent.innerHTML = "";
            filePreview.hidden = true;
            activePreviewElement = null;
            if (fileType.startsWith("image/")) {
              const img = document.createElement("img");
              img.src = uploadedFileURL;
              previewContent.appendChild(img);
              activePreviewElement = img;
            } else if (fileType === "application/pdf") {
              const wrapper = document.createElement("div");
              wrapper.className = "wrapper-iframe";
              const iframe = document.createElement("iframe");
              iframe.src = uploadedFileURL + "#toolbar=0";
              wrapper.appendChild(iframe);
              previewContent.appendChild(wrapper);
              activePreviewElement = wrapper;
            } else {
                const iframe = document.createElement("iframe");
                iframe.src="https://view.officeapps.live.com/op/embed.aspx?src=" + encodeURIComponent("https://yourdomain.com/uploads/" + fileName);
                previewContent.appendChild(iframe);
                activePreviewElement = iframe;
            }
            setTimeout (() => {
          if (activePreviewElement) {
            activePreviewElement.style.transform = 'translate(0px, 0px) scale(1)';
            activePreviewElement.style.transformOrigin = '0 0';
            const api = createPreviewControls(filePreview, activePreviewElement);
            activePreviewElement._previewApi = api;
          }
        }, 30);
        }
      });

        uploadInput.addEventListener('click', () => {
          if (!uploadedFileURL) return;

          if (filePreview.hidden) {
            filePreview.hidden = false;
            seenIndicator.textContent = "Seen";
            seenIndicator.classList.remove("unseen");
            seenIndicator.classList.add("seen");
            if (controlsWrapper) controlsWrapper.style.display = 'flex';
          } else {
            filePreview.hidden = true;
            seenIndicator.textContent = "Unseen";
            seenIndicator.classList.remove("seen");
            seenIndicator.classList.add("unseen");
            if (controlsWrapper) controlsWrapper.style.display = 'none';
          }
        });

        removeBtn.addEventListener('click', () => {
          uploadInput.value = "";
          hiddenFileInput.value = "";
          if (uploadedFileURL) {
            URL.revokeObjectURL(uploadedFileURL);
            uploadedFileURL = null;
          }
          if (activePreviewElement && activePreviewElement._previewApi) {
            activePreviewElement._previewApi.destroy();
          }
          activePreviewElement = null;
          seenIndicator.hidden = true;
          removeBtn.hidden = true;
          filePreview.hidden = true;
          previewContent.innerHTML = "";
        });
      })
})();

function togglePassword() {
    const passwordInput = document.getElementById("password");
    const icon = document.querySelector(".toggleEye");
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.textContent = "⌣";
        } else {
            passwordInput.type = "password";
            icon.textContent = "👁";
            }
        }

window.togglePassword = togglePassword;
