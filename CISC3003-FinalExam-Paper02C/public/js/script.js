

document.addEventListener('DOMContentLoaded', function () {

    // ── Helper Functions ────────────────────────────────────

    function showFieldError(field, msg) {
        clearFieldError(field);
        const span = document.createElement('span');
        span.className   = 'field-error';
        span.textContent = msg;
        span.style.cssText =
            'color:#ef4444;font-size:.82rem;display:block;margin-top:4px;';
        field.parentNode.appendChild(span);
        field.style.borderColor = '#ef4444';
    }

    function clearFieldError(field) {
        const old = field.parentNode.querySelector('.field-error');
        if (old) old.remove();
        field.style.borderColor = '';
    }

    function showFieldSuccess(field, msg) {
        clearFieldError(field);
        const span = document.createElement('span');
        span.className   = 'field-ok';
        span.textContent = msg;
        span.style.cssText =
            'color:#22c55e;font-size:.82rem;display:block;margin-top:4px;';
        field.parentNode.appendChild(span);
        field.style.borderColor = '#22c55e';
    }

    // ── C.06: Ajax Email Availability Check ─────────────────
    const emailField  = document.getElementById('email');
    const emailStatus = document.getElementById('emailStatus');
    let emailTimer;

    if (emailField && emailStatus) {
        emailField.addEventListener('input', function () {
            clearTimeout(emailTimer);
            const val = this.value.trim();

            if (val === '') {
                emailStatus.textContent = '';
                return;
            }

            // Debounce: wait 600ms after typing stops
            emailTimer = setTimeout(function () {
                emailStatus.textContent = 'Checking...';
                emailStatus.style.color = '#64748b';

                fetch('check_email.php?email=' +
                      encodeURIComponent(val))
                    .then(res => res.json())
                    .then(data => {
                        if (data.available) {
                            emailStatus.textContent = '✔ ' + data.message;
                            emailStatus.style.color = '#22c55e';
                            emailField.style.borderColor = '#22c55e';
                        } else {
                            emailStatus.textContent = '✖ ' + data.message;
                            emailStatus.style.color = '#ef4444';
                            emailField.style.borderColor = '#ef4444';
                        }
                    })
                    .catch(() => {
                        emailStatus.textContent = 'Could not check email.';
                        emailStatus.style.color = '#f59e0b';
                    });
            }, 600);
        });
    }

    // ── C.05: Password Strength Meter ───────────────────────
    const passwordField = document.getElementById('password');
    const strengthBar   = document.getElementById('strengthBar');

    if (passwordField && strengthBar) {
        passwordField.addEventListener('input', function () {
            const val = this.value;
            let strength = 0;

            if (val.length >= 8)            strength++;
            if (/[A-Z]/.test(val))          strength++;
            if (/[0-9]/.test(val))          strength++;
            if (/[^A-Za-z0-9]/.test(val))   strength++;

            const labels = ['Too Short', 'Weak', 'Fair', 'Good', 'Strong'];
            const colors = ['#ef4444', '#f97316', '#eab308',
                            '#22c55e', '#10b981'];

            strengthBar.textContent = labels[strength] || '';
            strengthBar.style.color = colors[strength] || '';
        });
    }

    // ── Registration Form Validation ────────────────────────
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function (e) {
            let valid = true;

            const name     = document.getElementById('full_name');
            const email    = document.getElementById('email');
            const password = document.getElementById('password');
            const confirm  = document.getElementById('confirm');

            // Clear all
            [name, email, password, confirm].forEach(clearFieldError);

            // Name
            if (name.value.trim().length < 2) {
                showFieldError(name, 'Name must be at least 2 characters.');
                valid = false;
            }

            // Email
            const emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRe.test(email.value.trim())) {
                showFieldError(email, 'Enter a valid email address.');
                valid = false;
            }

            // Password
            if (password.value.length < 8) {
                showFieldError(password,
                    'Password must be at least 8 characters.');
                valid = false;
            }

            // Confirm
            if (password.value !== confirm.value) {
                showFieldError(confirm, 'Passwords do not match.');
                valid = false;
            }

            if (!valid) e.preventDefault();
        });
    }

    // ── Login Form Validation ────────────────────────────────
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            let valid = true;

            const email    = document.getElementById('email');
            const password = document.getElementById('password');

            [email, password].forEach(clearFieldError);

            const emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRe.test(email.value.trim())) {
                showFieldError(email, 'Enter a valid email address.');
                valid = false;
            }

            if (password.value.trim() === '') {
                showFieldError(password, 'Password is required.');
                valid = false;
            }

            if (!valid) e.preventDefault();
        });
    }

    // ── Contact Form Validation (Scenario B) ────────────────
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function (e) {
            let valid = true;

            const name    = document.getElementById('sender_name');
            const email   = document.getElementById('sender_email');
            const subject = document.getElementById('subject');
            const body    = document.getElementById('body');

            [name, email, subject, body].forEach(clearFieldError);

            if (name && name.value.trim() === '') {
                showFieldError(name, 'Name is required.');
                valid = false;
            }

            if (email) {
                const emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRe.test(email.value.trim())) {
                    showFieldError(email, 'Enter a valid email.');
                    valid = false;
                }
            }

            if (subject && subject.value.trim() === '') {
                showFieldError(subject, 'Subject is required.');
                valid = false;
            }

            if (body && body.value.trim().length < 10) {
                showFieldError(body, 'Message must be at least 10 chars.');
                valid = false;
            }

            if (!valid) e.preventDefault();
        });
    }
});