window.addEventListener("load", function () {
    // Select all highlightable fields
    const highlightableFields = document.querySelectorAll(".hilightable");

    // Add focus and blur handlers
    for (let field of highlightableFields) {
        field.addEventListener("focus", function () {
            this.classList.add("highlight");
        });

        field.addEventListener("blur", function () {
            this.classList.remove("highlight");
        });
    }

    // Select all required fields
    const requiredFields = document.querySelectorAll(".required");

    // Remove error class when user changes content
    for (let field of requiredFields) {
        field.addEventListener("input", function () {
            if (this.value.trim() !== "") {
                this.classList.remove("error");
            }
        });
    }

    // Form submit validation
    const form = document.getElementById("mainForm");

    form.addEventListener("submit", function (event) {
        let hasError = false;

        for (let field of requiredFields) {
            if (field.value.trim() === "") {
                field.classList.add("error");
                hasError = true;
            } else {
                field.classList.remove("error");
            }
        }

        if (hasError) {
            event.preventDefault();
        }
    });
});