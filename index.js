
        // Permet de mettre en evidence les onglets "Mes post-its" ou  "Partagés" en fonction de la selection 
        const urlParams = new URLSearchParams(window.location.search);
        const partage = urlParams.get("partage");

        const AffichageMesPostit = document.getElementById("AfficheMesPostit");
        const AffichagePartage = document.getElementById("AfficheMesPartages");

        if (partage) {
            AffichagePartage.classList.add("active");
            AffichageMesPostit.classList.remove("active");
        } else {
            AffichageMesPostit.classList.add("active");
            AffichagePartage.classList.remove("active");
        }
        /*Afficher les detail du postit  lors du click*/
        function redirectToDetails(postitId) {
        window.location.href = "visualisation_postit/visualisation_postit.php?id=" + postitId;
    }

   