<?php
function selectMedicament(){
    $url='http://localhost/php/apiMed.php';
    $options = array(
        'http' => array(
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method' => 'GET'
        )
    );
    $context = stream_context_create($options);
    $medicament = file_get_contents($url, false, $context);
    $medicament=substr($medicament,1);
    return $medicament;
}
function selectActivite() {
    $url = 'http://localhost/php/apiAct.php';
    
    // Configuration du contexte pour la requête HTTP
    $options = array(
        'http' => array(
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method' => 'GET',
            'ignore_errors' => true // Permet de récupérer les erreurs HTTP
        )
    );
    
    $context = stream_context_create($options);
    
    // Tenter de récupérer les données de l'API
    $activite = @file_get_contents($url, false, $context);
    
    // Vérifier si la récupération a échoué
    if ($activite === FALSE) {
        return json_encode(["message" => "Erreur lors de la récupération des activités."]);
    }
    
    // Vérifier la réponse HTTP
    $http_response = $http_response_header;
    if (isset($http_response[0]) && strpos($http_response[0], "200") === false) {
        return json_encode(["message" => "Erreur de serveur ou ressource non trouvée."]);
    }
    
    // Enlève un caractère inutile s'il y en a (par exemple un ' \r\n ' au début)
    $activite = ltrim($activite, "\r\n");
    
    return $activite;
}
function insertInscription($idUtilisateur, $idActivite) {
    $url = 'http://localhost/php/apiIns.php';  // L'URL de l'API

    // Préparer les données à envoyer via POST
    $data = array(
        'idUtilisateur' => $idUtilisateur,
        'idActivite' => $idActivite
    );

    // Encoder les données en une chaîne URL-encodée
    $data_string = http_build_query($data);

    // Définir les options HTTP pour la requête POST
    $options = array(
        'http' => array(
            'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => $data_string  // Les données envoyées dans la requête POST
        )
    );

    // Créer le contexte avec les options spécifiées
    $context = stream_context_create($options);

    // Envoyer la requête et capturer la réponse
    $response = file_get_contents($url, false, $context);

    // Si la requête échoue, retourner un message d'erreur
    if ($response === FALSE) {
        return json_encode(array('status' => 'error', 'message' => 'Erreur lors de l\'inscription.'));
    }

    // Retourner la réponse du serveur (qui devrait être au format JSON)
    return $response;
}


function selectUtil() {
    $url = 'http://localhost/php/apiUtil.php';
    
    // Configuration du contexte pour la requête HTTP
    $options = array(
        'http' => array(
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method' => 'GET',
            'ignore_errors' => true // Permet de récupérer les erreurs HTTP
        )
    );
    
    $context = stream_context_create($options);
    
    // Tenter de récupérer les données de l'API
    $utilisateur = @file_get_contents($url, false, $context);
    
    // Vérifier si la récupération a échoué
    if ($utilisateur === FALSE) {
        return json_encode(["message" => "Erreur lors de la récupération des activités."]);
    }
    
    // Vérifier la réponse HTTP
    $http_response = $http_response_header;
    if (isset($http_response[0]) && strpos($http_response[0], "200") === false) {
        return json_encode(["message" => "Erreur de serveur ou ressource non trouvée."]);
    }
    
    // Enlève un caractère inutile s'il y en a (par exemple un ' \r\n ' au début)
    $utilisateur = ltrim($utilisateur, "\r\n");
    
    return $utilisateur;
}
?>