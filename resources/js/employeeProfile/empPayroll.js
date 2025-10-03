let editHistory = {};
let lastEdited = {};
let suppressHistory = false;

function toggleEdit(sectionId) {
    const section = document.getElementById(sectionId);
    const inputs = section.querySelectorAll("input.amount-input");
    const isReadOnly = inputs[0].readOnly;

    if (isReadOnly) {
    editHistory[sectionId] = Array.from(inputs).map(input => ({
        input,
        history: [parseFloat(input.value.replace(/,/g, "")) || 0],
        pointer: 0
    }));

    inputs.forEach((input, idx) => {
        input.readOnly = false;

        input.addEventListener("blur", () => {
        formatInput(input);
        saveInputChange(sectionId, idx);
        lastEdited[sectionId] = idx;
        });

        input.addEventListener("keydown", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();
            formatInput(this);
            saveInputChange(sectionId, idx);
            lastEdited[sectionId] = idx;
            saveChanges(sectionId);
        }
        });

        input.addEventListener("input", function () {
        this.value = this.value.replace(/[^0-9.]/g, "");
        });
    });

    section.querySelector(".edit-btn").style.display = "none";
    toggleActionButtons(sectionId, true);
    toggleBottomButtons(sectionId, true);
    } else {
    saveChanges(sectionId);
    }
}

function saveInputChange(sectionId, idx) {
    if (suppressHistory) return;

    const record = editHistory[sectionId][idx];
    let num = parseFloat(record.input.value.replace(/,/g, "")) || 0;
    if (record.history[record.pointer] !== num) {
    record.history = record.history.slice(0, record.pointer + 1);
    record.history.push(num);
    record.pointer++;
    }

    record.modified = true;
    lastEdited[sectionId] = idx;
}

function saveChanges(sectionId) {
    const section = document.getElementById(sectionId);
    const inputs = section.querySelectorAll("input.amount-input");

    inputs.forEach(input => {
    formatInput(input);
    input.readOnly = true;
    });

    toggleActionButtons(sectionId, false);
    toggleBottomButtons(sectionId, false);
    section.querySelector(".edit-btn").style.display = "inline-block";
}

function cancelEdit(sectionId) {
    const section = document.getElementById(sectionId);
    const inputs = section.querySelectorAll("input.amount-input");
    const history = editHistory[sectionId];

    if (history) {
    inputs.forEach((input, idx) => {
        input.value = history[idx].history[0];
        formatInput(input);
        input.readOnly = true;
    });
    }

    toggleActionButtons(sectionId, false);
    toggleBottomButtons(sectionId, false);
    section.querySelector(".edit-btn").style.display = "inline-block";
}

function undoChange(sectionId, idxParam, shouldFocus = true) {
    const records = editHistory[sectionId];
    if (!records) return;

    let idx = typeof idxParam === "number" ? idxParam : lastEdited[sectionId] || 0;
    
    for (let i = 0; i < records.length; i++) {
        const record = records[idx];
        if (record && record.modified && record.pointer > 0) {
        record.pointer--;

        suppressHistory = true;
        record.input.value = "";
        record.input.value = record.history[record.pointer];
        formatInput(record.input);
        suppressHistory = false;

        if (shouldFocus) record.input.focus(); 
        lastEdited[sectionId] = idx;
        return;
        }
        idx = (idx + 1) % records.length;
    }
}

function redoChange(sectionId, idxParam, shouldFocus = true) {
    const records = editHistory[sectionId];
    if (!records) return;

    let idx = typeof idxParam === "number" ? idxParam : lastEdited[sectionId] || 0;
    
    for (let i = 0; i < records.length; i++) {
        const record = records[idx];
        if (record && record.modified && record.pointer < record.history.length - 1) {
        record.pointer++;

        suppressHistory = true;
        record.input.value = "";
        record.input.value = record.history[record.pointer];
        formatInput(record.input);
        suppressHistory = false;

        if (shouldFocus) record.input.focus();
        lastEdited[sectionId] = idx;
        return;
        }
        idx = (idx + 1) % records.length;
    }
}

function formatInput(input) {
    let num = parseFloat(input.value.toString().replace(/,/g, ""));
    if (!isNaN(num)) {
    input.value = num.toLocaleString("en-US", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
    } else {
    input.value = "0.00";
    }
}

function toggleActionButtons(sectionId, show) {
    const section = document.getElementById(sectionId);
    section.querySelector(".undo-btn").style.display = show ? "inline-block" : "none";
    section.querySelector(".redo-btn").style.display = show ? "inline-block" : "none";
    section.querySelector(".cancel-btn").style.display = show ? "inline-block" : "none";
}

function toggleBottomButtons(sectionId, show) {
    const section = document.getElementById(sectionId);
    const bottom = section.querySelector(".bottom-buttons");
    if (bottom) {
    bottom.style.display = show ? "flex" : "none";
    }
}

document.addEventListener("keydown", function (e) {
    const activeSection = e.target.closest(".list-card");
    if (!activeSection) return;
    const sectionId = activeSection.id;

    const inputs = activeSection.querySelectorAll("input.amount-input");
    const idx = Array.from(inputs).indexOf(e.target);
    if (idx === -1) return; 

    if (e.ctrlKey && e.key === "z") {
    e.preventDefault();
    undoChange(sectionId, idx);
    }
    if (e.ctrlKey && e.key === "y") {
    e.preventDefault();
    redoChange(sectionId, idx);
    }
    if (e.key === "ArrowUp") {
        e.preventDefault();
        if (idx > 0) {
            inputs[idx - 1].focus();
            let val = inputs[idx - 1].value;
            inputs[idx - 1].setSelectionRange(val.length, val.length);
        }
    }
    if (e.key === "ArrowDown") {
        e.preventDefault();
        if (idx < inputs.length - 1) {
            inputs[idx + 1].focus();
            let val = inputs[idx + 1].value;
            inputs[idx + 1].setSelectionRange(val.length, val.length);
        }
    }
});

window.toggleEdit = toggleEdit;
window.undoChange = undoChange;
window.redoChange = redoChange;
window.saveChanges = saveChanges;
window.cancelEdit = cancelEdit;