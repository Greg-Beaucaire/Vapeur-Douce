//J'ai fais le choix de ne déclencher le script que si la personne navigue sur tablette ou desktop parce que les dropdown menu sur mobile c'est éclaté au sol...
if (window.matchMedia("(min-width: 768px)").matches) {
    let input    = document.querySelector("#inputFormRecherche"), // On sélectionne l'input en ciblant son id
        datalist = document.querySelector("datalist"); // On sélectionne la datalist

    // On ajoute un addEventListener sur l'input
    input.addEventListener("keyup", (e) => {

        // Si 2 (ou plus) caractères sont entrés dans l'input, on ajoute l'id à la datalist ce qui la rend fonctionnelle.
        if (e.target.value.length >= 2) {
            //On ajoute l'id à la datalist
            datalist.setAttribute("id", "cuissonList");
        } else {
            //On laisse l'id vide ou on la supprime
            datalist.setAttribute("id", "");
        }
    });
}