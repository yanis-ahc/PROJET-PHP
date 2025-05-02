<?php
function getMedicament(){
    $medicament=selectMedicament();
    include "api/apiMed.php";
}
function accueil()
{
include "vue/accueil.php";
}
function medicament()
{
include "vue/medicament.php";
}
function activite()
{
include "vue/activite.php";
}
function ml()
{
include "vue/ml.php";
}



function getActivite() {
    $activite = selectActivite();
    // Assurez-vous que l'activité est sous forme JSON avant de l'inclure dans la vue
    $activite_data = json_decode($activite, true);  // Décoder la réponse JSON en tableau PHP
    
    include "api/apiAct.php";  // Assurez-vous que cette vue est configurée pour afficher les données
}
function getUtilisateur() {
    $util = selectUtil();
    // Assurez-vous que l'activité est sous forme JSON avant de l'inclure dans la vue
    $util_data = json_decode($util, true);  // Décoder la réponse JSON en tableau PHP
    
    include "api/apiUtil.php";  // Assurez-vous que cette vue est configurée pour afficher les données
}

function insInscription($idUtilisateur, $idActivite) {
    // Appel de la fonction qui insère l'inscription via l'API
    $inscription = insertInscription($idUtilisateur, $idActivite);

    // Décoder la réponse JSON
    $Inscription_data = json_decode($inscription, true);

    // Vérifier le statut de la réponse
    if ($Inscription_data['status'] == 'success') {
        // Si l'inscription a réussi, rediriger ou afficher un message de succès
        header("Location: index.php?action=AC&message=Inscription réussie !");
    } else {
        // Si l'inscription échoue, afficher l'erreur
        $message = $Inscription_data['message'];
        header("Location: index.php?action=AC&message=" . urlencode($message));
    }
    exit;
}


?>  