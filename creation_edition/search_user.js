$(document).ready(function () {
    // Tableau qui contiendra les utilisateurs sélectionnés
    let utilisateursSelectionnes = [];

    // Initialisation de l'autocomplétion sur le champ de recherche
    $("#search").autocomplete({

        // Fonction pour récupérer les suggestions depuis le serveur
        source: function (requete, repondre) {
            $.ajax({
                url: "API_search_user.php",          // Fichier qui fournit les données
                dataType: "json",                    // Format attendu
                data: { term: requete.term },        // Terme saisi par l'utilisateur
                success: function (donnees) {
                    // Transformation des données pour l'affichage
                    let suggestions = $.map(donnees, function (utilisateur) {
                        return {
                            label: utilisateur.pseudo,
                            id: utilisateur.id_utilisateur,
                            email: utilisateur.email,
                            prenom: utilisateur.prenom,
                            nom: utilisateur.nom
                        };
                    });
                    repondre(suggestions); // Envoi des suggestions à l'autocomplétion
                }
            });
        },

        // Lorsqu'on sélectionne un utilisateur
        select: function (evenement, selection) {
            let utilisateur = selection.item;

            // Vérifie si l'utilisateur n'est pas déjà dans la liste
            let dejaPresent = utilisateursSelectionnes.some(function (u) {
                return u.id === utilisateur.id;
            });

            if (!dejaPresent) {
                utilisateursSelectionnes.push(utilisateur);
                mettreAJourListeSelectionnee();
            }

            // Efface le champ de recherche après sélection
            $("#search").val("");
            return false; // Empêche la valeur de s'afficher dans le champ
        }
    })

    // Personnalisation de l'affichage des résultats
    .autocomplete("instance")._renderItem = function (liste, item) {
        return $("<li>")
            .append(`
                <div class="suggestion">
                    <div><strong>${item.label}</strong> (${item.prenom} ${item.nom})</div>
                    <div class="email">${item.email}</div>
                </div>
            `)
            .appendTo(liste);
    };

    // Met à jour l'affichage des utilisateurs sélectionnés
    function mettreAJourListeSelectionnee() {
        // Vide la liste HTML
        $("#selected-list").empty();

        // Pour chaque utilisateur sélectionné, on l'affiche
        utilisateursSelectionnes.forEach(function (utilisateur) {
            $("#selected-list").append(
                `<p>${utilisateur.prenom} ${utilisateur.nom}</p>`
            );
        });

        // Met à jour le champ caché avec les IDs des utilisateurs sélectionnés
        let ids = utilisateursSelectionnes.map(function (u) {
            return u.id;
        });

        $("#selected-users-input").val(ids.join(","));
    }
});
