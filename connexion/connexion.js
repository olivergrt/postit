document.querySelector("form").addEventListener("submit", function (e) {
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    
    // Reset styles
    email.classList.remove("input-error");
    password.classList.remove("input-error");

    let hasError = false;

    if (email.value.trim() === "") {
        email.classList.add("input-error");
        hasError = true;
    }

    if (password.value.trim() === "") {
        password.classList.add("input-error");
        hasError = true;
    }

    if (hasError) {
        e.preventDefault(); // Empêche l'envoi du formulaire
    }
});