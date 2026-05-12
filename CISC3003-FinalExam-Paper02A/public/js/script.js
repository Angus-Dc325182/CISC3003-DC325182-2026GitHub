

document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('registrationForm');

    // ── Form Submit Validation ──────────────────────────────
    form.addEventListener('submit', function (e) {

        let valid   = true;
        const msgs  = [];

        // Validate Full Name
        const name = document.getElementById('full_name').value.trim();
        if (name === '') {
            valid = false;
            msgs.push('Full name is required.');
        }

        // Validate Email
        const email = document.getElementById('email').value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            valid = false;
            msgs.push('Please enter a valid email address.');
        }

        // Validate Country
        const country = document.getElementById('country').value;
        if (country === '') {
            valid = false;
            msgs.push('Please select a country.');
        }

        // Validate Message
        const msg = document.getElementById('message').value.trim();
        if (msg.length < 10) {
            valid = false;
            msgs.push('Message must be at least 10 characters.');
        }

        if (!valid) {
            e.preventDefault();
            alert('Please fix the following errors:\n\n' +
                  msgs.join('\n'));
        }
    });

    // ── Character Counter for Textarea ─────────────────────
    const textarea = document.getElementById('message');
    const counter  = document.createElement('small');
    counter.style.color = '#64748b';
    textarea.parentNode.appendChild(counter);

    function updateCounter() {
        const remaining = 1000 - textarea.value.length;
        counter.textContent = remaining + ' characters remaining';
    }

    textarea.addEventListener('input', updateCounter);
    updateCounter();
});