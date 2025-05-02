<?php
require_once "modele/modele.php";
require_once "controleur/controleur.php";

if (!isset($_GET["action"])) {
    // cas de la consultation : page de départ
    accueil();
}elseif ($_GET["action"] == 'MD') {
    // cas du formulaire d'ajout
    medicament();
}
elseif ($_GET["action"] == 'AC') {
    // cas du formulaire d'ajout
    activite();
}
elseif ($_GET["action"] == 'ML') {
    // cas du formulaire d'ajout
    ml();
}
elseif ($_GET["action"] == 'ACC') {
    // cas du formulaire d'ajout
    accueil();
}


?>