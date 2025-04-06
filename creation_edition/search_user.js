
$(document).ready(function () {
    let selectedUsers = []; // Tableau pour stocker l'id des utilisateurs sélectionnés

    /* Autocomplétion AJAX */
    $("#search").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "API_search_user.php",
                dataType: "json",
                data: { term: request.term },
                success: function (data) {
                    response($.map(data, function (item) {
                        return {
                            label: item.pseudo,
                            value: item.pseudo,
                            id: item.id_utilisateur,
                            email: item.email,
                            prenom: item.prenom,
                            nom: item.nom
                        };
                    }));
                }
            });
        },
        minLength: 2, // Nombre de caractères min pour afficher l'autocomplétion
        select: function (event, ui) {
            if (!selectedUsers.some(user => user.id === ui.item.id)) {
                selectedUsers.push(ui.item);
                updateSelectedUsers();
            }
            $("#search").val(""); // Vider le champ après sélection
            return false;
        }
    }).autocomplete("instance")._renderItem = function (ul, item) {
        return $("<li>")
            .append("<div class='autocomplete-suggestion'>" +
                "<div><strong>" + item.label + "</strong> (" + item.prenom + " " + item.nom + ")</div>" +
                "<div class='autocomplete-email'>" + item.email + "</div>" +
                "</div>")
            .appendTo(ul);
    };

    /* Mettre à jour la liste des utilisateurs sélectionnés */
    function updateSelectedUsers() {
        $("#selected-list").empty();

        selectedUsers.forEach(user => {
            $("#selected-list").append(
                `<p>${user.prenom} ${user.nom}</p>`
            );
        });

        $("#selected-users-input").val(selectedUsers.map(user => user.id).join(",")); // Mise à jour du champ caché
    }

    /*A SUPPRIMER */
    /* Empêcher l'envoi si aucun utilisateur n'est sélectionné */
    $("#share-form").on("submit", function (e) {
        if (selectedUsers.length === 0) {
            alert("Veuillez sélectionner au moins un utilisateur avant de partager.");
            e.preventDefault();
        }
    });
});
