document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const email = document.getElementById("email");
    const password = document.getElementById("password");

    const errorEmail = document.getElementById("error-email");
    const errorPassword = document.getElementById("error-password");
    const errorGlobal = document.getElementById("error-global");

    form.addEventListener("submit", function (e) {
        // Réinitialisation
        errorEmail.textContent = "";
        errorPassword.textContent = "";
        errorGlobal.textContent = "";
        email.classList.remove("input-error");
        password.classList.remove("input-error");

        let hasError = false;

        // Vérifie si email est vide
        if (email.value.trim() === "") {
            email.classList.add("input-error");
            errorEmail.textContent = "L'adresse email est requise.";
            hasError = true;
        } else {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email.value.trim())) {
                email.classList.add("input-error");
                errorEmail.textContent = "Le format de l'adresse email est invalide.";
                hasError = true;
            }
        }

        // Vérifie si le mot de passe est vide
        if (password.value.trim() === "") {
            password.classList.add("input-error");
            errorPassword.textContent = "Le mot de passe est requis.";
            hasError = true;
        }

        if (hasError) {
            e.preventDefault();
        }
    });
});
