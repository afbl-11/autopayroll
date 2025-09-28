(function () {
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
        const verified = stepsDiv.dataset.verifiedSrc || '/images/verified.png';

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

        const hiddenFileInput = document.createElement('input');
        hiddenFileInput.type = 'file';
        hiddenFileInput.accept = ".pdf,.doc,.docx,.png,.jpg,.jpeg";
        hiddenFileInput.style.display = 'none';
        document.body.appendChild(hiddenFileInput);

        let uploadedFileURL = null;

        browseButton.addEventListener('click', () => {
          hiddenFileInput.click();
        });

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
            if (fileType.startsWith("image/")) {
              const img = document.createElement("img");
              img.src = uploadedFileURL;
              previewContent.appendChild(img);
              previewContent.appendChild(dl);
            } else if (fileType === "application/pdf") {
              const iframe = document.createElement("iframe");
              iframe.src = uploadedFileURL + "#toolbar=0";
              previewContent.appendChild(iframe);
            } else {
                const iframe = document.createElement("iframe");
                iframe.src="https://view.officeapps.live.com/op/embed.aspx?src=" + encodeURIComponent("https://yourdomain.com/uploads/" + fileName);
                previewContent.appendChild(iframe);
            }
          }
        });  

        uploadInput.addEventListener('click', () => {
          if (!uploadedFileURL) return;

          if (filePreview.hidden) {
            filePreview.hidden = false;
            seenIndicator.textContent = "Seen";
            seenIndicator.classList.remove("unseen");
            seenIndicator.classList.add("seen");
          } else {
            filePreview.hidden = true;
            seenIndicator.textContent = "Unseen";
            seenIndicator.classList.remove("seen");
            seenIndicator.classList.add("unseen");
          }
        });

        removeBtn.addEventListener('click', () => {
          uploadInput.value = "";
          hiddenFileInput.value = "";
          if (uploadedFileURL) {
            URL.revokeObjectURL(uploadedFileURL);
            uploadedFileURL = null;
          }
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