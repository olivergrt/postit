document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const errorDiv = document.getElementById("client-error");

    form.addEventListener("submit", function (e) {
        // Réinitialisation
        email.classList.remove("input-error");
        password.classList.remove("input-error");
        errorDiv.textContent = "";

        let hasError = false;
        let messages = [];

        // Vérifie si email est vide
        if (email.value.trim() === "") {
            email.classList.add("input-error");
            messages.push("L'adresse email est requise.");
            hasError = true;
        } else {
            // Vérifie le format de l'email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email.value.trim())) {
                email.classList.add("input-error");
                messages.push("Le format de l'adresse email est invalide.");
                hasError = true;
            }
        }

        // Vérifie si le mot de passe est vide
        if (password.value.trim() === "") {
            password.classList.add("input-error");
            messages.push("Le mot de passe est requis.");
            hasError = true;
        }

        if (hasError) {
            e.preventDefault(); // Bloque l'envoi
            errorDiv.innerHTML = messages.map(msg => `<p>${msg}</p>`).join("");
        }
    });
});
