<?php
include("db_connect.php");

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = $_GET['id']; // Récupère l'ID passé en paramètre
            getUtilisateur($id); // Récupère l'utilisateur correspondant à cet ID
        } else {
            getUtilisateurs(); // Si pas d'ID, récupérer tous les utilisateurs
        }
        break;

    default:
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode(["message" => "Method Not Allowed. Only GET requests are allowed."]);
        break;
}

function getUtilisateurs()
{
    global $conn;
    $query = "SELECT * FROM utilisateur"; // Récupérer tous les utilisateurs
    try {
        $stmt = $conn->prepare($query);
        $stmt->execute();

        $response = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $response[] = $row;
        }

        // Vérifier si la réponse est vide
        if (empty($response)) {
            header("HTTP/1.0 404 Not Found");
            echo json_encode(["message" => "No users found."]);
        } else {
            header('Content-Type: application/json');
            echo json_encode($response, JSON_PRETTY_PRINT);
        }
    } catch (Exception $e) {
        header("HTTP/1.0 500 Internal Server Error");
        echo json_encode(["message" => "An error occurred while fetching users.", "error" => $e->getMessage()]);
    }
}

function getUtilisateur($id)
{
    global $conn;
    // Utiliser une condition WHERE pour récupérer l'utilisateur par son ID
    $query = "SELECT * FROM utilisateur WHERE idUtilisateur = :id"; 
    try {
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR); // Utilisation de PARAM_STR pour l'ID qui est une chaîne de caractères
        $stmt->execute();

        $response = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $response[] = $row;
        }

        // Si aucun utilisateur n'est trouvé
        if (empty($response)) {
            header("HTTP/1.0 404 Not Found");
            echo json_encode(["message" => "User not found."]);
        } else {
            header('Content-Type: application/json');
            echo json_encode($response, JSON_PRETTY_PRINT);
        }
    } catch (Exception $e) {
        header("HTTP/1.0 500 Internal Server Error");
        echo json_encode(["message" => "An error occurred while fetching the user.", "error" => $e->getMessage()]);
    }
}

?>
