const passwordInput = document.getElementById('password');
const confirmInput = document.getElementById('password_confirmation');
const confirmMessage = document.getElementById('confirm-message');
const passwordRules = document.getElementById('password-rules');

const rules = {
    length: document.getElementById('rule-length'),
    upper: document.getElementById('rule-upper'),
    lower: document.getElementById('rule-lower'),
    number: document.getElementById('rule-number'),
    special: document.getElementById('rule-special')
};
function validatePassword(val) {
    let valid = true;

    if (val.length >= 8) {
        rules.length.className = "valid";
        rules.length.textContent = "✅ At least 8 characters";
    } else {
        rules.length.className = "invalid";
        rules.length.textContent = "❌ At least 8 characters";
        valid = false;
    }

    if (/[A-Z]/.test(val)) {
        rules.upper.className = "valid";
        rules.upper.textContent = "✅ One uppercase letter";
    } else {
        rules.upper.className = "invalid";
        rules.upper.textContent = "❌ One uppercase letter";
        valid = false;
    }

    if (/[a-z]/.test(val)) {
        rules.lower.className = "valid";
        rules.lower.textContent = "✅ One lowercase letter";
    } else {
        rules.lower.className = "invalid";
        rules.lower.textContent = "❌ One lowercase letter";
        valid = false;
    }

    if (/[0-9]/.test(val)) {
        rules.number.className = "valid";
        rules.number.textContent = "✅ One number";
    } else {
        rules.number.className = "invalid";
        rules.number.textContent = "❌ One number";
        valid = false;
    }

    if (/[^A-Za-z0-9]/.test(val)) {
        rules.special.className = "valid";
        rules.special.textContent = "✅ One special character";
    } else {
        rules.special.className = "invalid";
        rules.special.textContent = "❌ One special character";
        valid = false;
    }

    return valid;
}

passwordInput.addEventListener('focus', () => {
    passwordRules.style.display = 'block';
});

passwordInput.addEventListener('input', () => {
    validatePassword(passwordInput.value);
});

confirmInput.addEventListener('input', () => {
    if (confirmInput.value === passwordInput.value) {
        confirmMessage.textContent = "✅ Passwords match";
        confirmMessage.className = "valid";
    } else {
        confirmMessage.textContent = "❌ Passwords do not match";
        confirmMessage.className = "invalid";
    }
});

document.getElementById('registerForm').addEventListener('submit', (e) => {
    if (!validatePassword(passwordInput.value) || confirmInput.value !== passwordInput.value) {
        e.preventDefault();
        alert("Please fix the password requirements before submitting.");
    }
});
