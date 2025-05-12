document.querySelector("form").addEventListener("submit", function (e) {
    const title = document.querySelector('input[name="title"]');
    const content = document.querySelector('textarea[name="content"]');
    const couleur = document.querySelector('select[name="couleur"]');

    // Supprimer les erreurs précédentes
    document.querySelectorAll('.error-message').forEach(el => el.remove());
    title.classList.remove("input-error");
    content.classList.remove("input-error");
    couleur.classList.remove("input-error");

    let hasError = false;

    // Vérif titre
    if (title.value.trim() === "") {
        showError(title, "Le titre est requis.");
        hasError = true;
    } else if (title.value.length > 150) {
        showError(title, "Le titre ne doit pas dépasser 150 caractères.");
        hasError = true;
    }

    // Vérif contenu
    if (content.value.trim() === "") {
        showError(content, "Le contenu est requis.");
        hasError = true;
    } else if (content.value.length > 600) {
        showError(content, "Le contenu ne doit pas dépasser 600 caractères.");
        hasError = true;
    }

    // Vérif couleur
    if (couleur.value.trim() === "") {
        showError(couleur, "La couleur est requise.");
        hasError = true;
    }

    if (hasError) {
        e.preventDefault();
    }

    function showError(element, message) {
        element.classList.add("input-error");
        const error = document.createElement("div");
        error.classList.add("error-message");
        error.style.color = "red";
        error.style.marginTop = "5px";
        error.textContent = message;
        element.parentNode.appendChild(error);
    }
});