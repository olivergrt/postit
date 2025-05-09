<script defer>
document.addEventListener("DOMContentLoaded", function() {
  // On récupère le formulaire
  var form = document.getElementById("inscriptionForm");

  // Fonctions de validation
  function valideChampsObligatoires() {
    var ok = true;
    var prenom = document.getElementsByName("prenom")[0];
    if (prenom.value.trim() === "") {
      afficherErreur(prenom, "Prénom requis.");
      ok = false;
    } else {
      supprimerErreur(prenom);
    }

    var nom = document.getElementsByName("nom")[0];
    if (nom.value.trim() === "") {
      afficherErreur(nom, "Nom requis.");
      ok = false;
    } else {
      supprimerErreur(nom);
    }

    var pseudo = document.getElementsByName("pseudo")[0];
    if (pseudo.value.trim() === "") {
      afficherErreur(pseudo, "Pseudo requis.");
      ok = false;
    } else {
      supprimerErreur(pseudo);
    }

    var email = document.getElementsByName("email")[0];
    // Expression régulière basique pour email
    var motifEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!motifEmail.test(email.value.trim())) {
      afficherErreur(email, "Email invalide.");
      ok = false;
    } else {
      supprimerErreur(email);
    }

    return ok;
  }

  function valideMotDePasse() {
    var mdp = document.getElementsByName("password")[0];
    var mdpConfirm = document.getElementsByName("password_confirm")[0];
    var passeCorrect = true;

    if (mdp.value.length < 8) {
      afficherErreur(mdp, "Minimum 8 caractères.");
      passeCorrect = false;
    } else {
      supprimerErreur(mdp);
    }

    if (mdpConfirm.value !== mdp.value) {
      afficherErreur(mdpConfirm, "Mots de passe différents.");
      passeCorrect = false;
    } else {
      supprimerErreur(mdpConfirm);
    }

    return passeCorrect;
  }

  function valideDateDeNaissance() {
    var jour = document.getElementsByName("jour")[0];
    var mois = document.getElementsByName("mois")[0];
    var annee = document.getElementsByName("annee")[0];
    var dateOK = true;

    if (jour.value === "" || mois.value === "" || annee.value === "") {
      afficherErreur(jour, "Date requise.");
      afficherErreur(mois, "");
      afficherErreur(annee, "");
      dateOK = false;
    } else {
      supprimerErreur(jour);
      supprimerErreur(mois);
      supprimerErreur(annee);
    }

    return dateOK;
  }

  function valideAcceptation() {
    var checkbox = document.getElementById("accept");
    if (!checkbox.checked) {
      afficherErreur(checkbox, "Veuillez accepter les conditions.");
      return false;
    } else {
      supprimerErreur(checkbox);
      return true;
    }
  }

  // Affiche un message sous le champ et ajoute la classe is-invalid
  function afficherErreur(champ, message) {
    champ.classList.add("is-invalid");
    // On cherche un sibling .js-error-message existant
    var suivant = champ.nextSibling;
    // Supprimer les anciens messages texte vides
    while (suivant && suivant.nodeType !== 1) {
      suivant = suivant.nextSibling;
    }
    if (!suivant || !suivant.classList.contains("js-error-message")) {
      var erreurDiv = document.createElement("div");
      erreurDiv.className = "js-error-message";
      champ.parentNode.insertBefore(erreurDiv, champ.nextSibling);
      suivant = erreurDiv;
    }
    suivant.textContent = message;
  }

  // Supprime la classe is-invalid et le message si présent
  function supprimerErreur(champ) {
    champ.classList.remove("is-invalid");
    var suivant = champ.nextSibling;
    while (suivant && suivant.nodeType !== 1) {
      suivant = suivant.nextSibling;
    }
    if (suivant && suivant.classList.contains("js-error-message")) {
      suivant.parentNode.removeChild(suivant);
    }
  }

  // Gestionnaire de soumission
  form.addEventListener("submit", function(event) {
    var valide = true;

    if (!valideChampsObligatoires()) {
      valide = false;
    }
    if (!valideMotDePasse()) {
      valide = false;
    }
    if (!valideDateDeNaissance()) {
      valide = false;
    }
    if (!valideAcceptation()) {
      valide = false;
    }

    if (!valide) {
      event.preventDefault(); 
    }
  });

  // Nettoyage du message dès qu’on modifie le champ
  var tousChamps = form.querySelectorAll("input, select");
  for (var i = 0; i < tousChamps.length; i++) {
    tousChamps[i].addEventListener("input", function() {
      supprimerErreur(this);
    });
    tousChamps[i].addEventListener("change", function() {
      supprimerErreur(this);
    });
  }

});
</script>