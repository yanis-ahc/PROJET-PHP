<?php
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Vérification méthode HTTP
$request_method = $_SERVER["REQUEST_METHOD"];
if ($request_method !== 'POST') {
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode(["message" => "Méthode non autorisée. Seules les requêtes POST sont autorisées."]);
    exit;
}

// Mode test
if (isset($_GET['test'])) {
    die(json_encode([
        'success' => true,
        'message' => 'API fonctionnelle',
        'request_method' => $request_method,
        'post_data' => $_POST,
        'input_data' => file_get_contents('php://input')
    ]));
}

include("db_connect.php");

// Test connexion DB
try {
    $conn->query("SELECT 1");
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Échec de la connexion à la base de données',
        'error' => $e->getMessage()
    ]);
    exit;
}

// Traitement des données
try {
    // Récupération des données
    if (!empty($_POST)) {
        $data = $_POST;
    } else {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
    }

    // Validation
    if (empty($data)) {
        throw new Exception("Aucune donnée reçue");
    }

    if (empty($data['idUtilisateur']) || empty($data['idActivite'])) {
        throw new Exception("Champs requis manquants : idUtilisateur et idActivite");
    }

    // Vérification existence
    $check = $conn->prepare("SELECT id FROM inscription WHERE idUtilisateur = ? AND idActivite = ?");
    $check->execute([$data['idUtilisateur'], $data['idActivite']]);
    
    if ($check->fetch()) {
        throw new Exception("Vous êtes déjà inscrit à cette activité");
    }

    // Insertion
    $stmt = $conn->prepare("INSERT INTO inscription (idUtilisateur, idActivite, date_inscription) VALUES (?, ?, NOW())");
    
    if ($stmt->execute([$data['idUtilisateur'], $data['idActivite']])) {
        echo json_encode([
            'success' => true,
            'message' => 'Inscription à l\'activité réussie !',
            'registration_id' => $conn->lastInsertId()
        ]);
    } else {
        throw new Exception("Erreur lors de l'inscription");
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'received_data' => $data ?? null
    ]);
}
