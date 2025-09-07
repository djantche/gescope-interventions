document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("interventionForm");
    if (!form) return;

    // Créer un élément d'erreur
    const createErrorElement = (message) => {
        const errorElement = document.createElement("div");
        errorElement.className = "form-error";
        errorElement.textContent = message;
        return errorElement;
    };

    // Supprimer les erreurs existantes
    const clearErrors = () => {
        const existingErrors = form.querySelectorAll(".form-error");
        existingErrors.forEach((error) => error.remove());

        const invalidInputs = form.querySelectorAll(".is-invalid");
        invalidInputs.forEach((input) => input.classList.remove("is-invalid"));
    };

    // Afficher une erreur sous un champ spécifique
    const showError = (inputName, message) => {
        const input = form.querySelector(`[name="${inputName}"]`);
        if (!input) return;

        input.classList.add("is-invalid");

        // Vérifier si l'erreur existe déjà
        let errorElement = input.nextElementSibling;
        if (!errorElement || !errorElement.classList.contains("form-error")) {
            errorElement = createErrorElement(message);
            input.parentNode.insertBefore(errorElement, input.nextSibling);
        } else {
            errorElement.textContent = message;
        }
    };

    form.addEventListener("submit", (e) => {
        clearErrors();
        let hasErrors = false;

        const email = form.querySelector('input[name="email"]').value;
        const phone = form.querySelector('input[name="phone"]').value;
        const scheduled = form.querySelector('input[name="scheduledAt"]').value;
        const firstName = form.querySelector('input[name="firstName"]').value;
        const lastName = form.querySelector('input[name="lastName"]').value;
        const address = form.querySelector('input[name="address"]').value;

        const reEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!reEmail.test(email)) {
            showError("email", "Email invalide");
            hasErrors = true;
        }

        if (!phone.match(/^[0-9+\s-]+$/)) {
            showError("phone", "Téléphone invalide");
            hasErrors = true;
        }

        if (!scheduled) {
            showError("scheduledAt", "Date/heure requise");
            hasErrors = true;
        }

        if (!firstName) {
            showError("firstName", "Prénom requis");
            hasErrors = true;
        }

        if (!lastName) {
            showError("lastName", "Nom requis");
            hasErrors = true;
        }

        if (!address) {
            showError("address", "Adresse requise");
            hasErrors = true;
        }

        if (hasErrors) {
            e.preventDefault();
        }
    });
});
