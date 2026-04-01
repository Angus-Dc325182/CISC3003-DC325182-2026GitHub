window.addEventListener('load', function() {
    
    // 1. Handle Field Highlighting (Focus/Blur)
    const highlightableElements = document.querySelectorAll('.hilightable');

    highlightableElements.forEach(function(element) {
        element.addEventListener('focus', function() {
            this.classList.add('highlight');
        });

        element.addEventListener('blur', function() {
            this.classList.remove('highlight');
        });
    });

    // 2. Handle Form Submission and Validation
    const mainForm = document.getElementById('mainForm');

    mainForm.addEventListener('submit', function(e) {
        const requiredElements = document.querySelectorAll('.required');
        let hasError = false;

        requiredElements.forEach(function(element) {
            if (element.value.trim() === "") {
                element.classList.add('error');
                hasError = true;
            } else {
                element.classList.remove('error');
            }
        });

        if (hasError) {
            e.preventDefault();
        }
    });

    // 3. Real-time Error Removal
    const requiredInputs = document.querySelectorAll('.required');
    requiredInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            if (this.value.trim() !== "") {
                this.classList.remove('error');
            }
        });
    });

});