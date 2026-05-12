

document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('contactForm');

    // ── Real-time field validation ──────────────────────────
    function showError(field, msg) {
        clearError(field);
        const err = document.createElement('span');
        err.className   = 'field-error';
        err.textContent = msg;
        err.style.color = '#ef4444';
        err.style.fontSize = '.85rem';
        field.parentNode.appendChild(err);
        field.style.borderColor = '#ef4444';
    }

    function clearError(field) {
        const existing = field.parentNode.querySelector('.field-error');
        if (existing) existing.remove();
        field.style.borderColor = '';
    }

    // ── Form submit validation ──────────────────────────────
    form.addEventListener('submit', function (e) {
        let valid = true;

        const name    = document.getElementById('sender_name');
        const email   = document.getElementById('sender_email');
        const subject = document.getElementById('subject');
        const body    = document.getElementById('body');

        // Clear previous errors
        [name, email, subject, body].forEach(clearError);

        if (name.value.trim() === '') {
            showError(name, 'Name is required.');
            valid = false;
        }

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email.value.trim())) {
            showError(email, 'Enter a valid email address.');
            valid = false;
        }

        if (subject.value.trim() === '') {
            showError(subject, 'Subject is required.');
            valid = false;
        }

        if (body.value.trim().length < 10) {
            showError(body, 'Message must be at least 10 characters.');
            valid = false;
        }

        if (!valid) e.preventDefault();
    });

    // ── Live character counter ──────────────────────────────
    const bodyField = document.getElementById('body');
    const counter   = document.createElement('small');
    counter.style.color = '#64748b';
    bodyField.parentNode.appendChild(counter);

    bodyField.addEventListener('input', function () {
        counter.textContent =
            (2000 - this.value.length) + ' characters remaining';
    });
});