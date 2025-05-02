<?php
include("db_connect.php");

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = $_GET['id']; // Récupère l'ID passé en paramètre
            getActivite($id); // Récupère l'activité correspondant à cet ID
        } else {
            getActivites(); // Si pas d'ID, récupérer toutes les activités
        }
        break;

    default:
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode(["message" => "Method Not Allowed. Only GET requests are allowed."]);
        break;
}

function getActivites()
{
    global $conn;
    $query = "SELECT * FROM activite"; // Récupérer toutes les activités
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
            echo json_encode(["message" => "No activities found."]);
        } else {
            header('Content-Type: application/json');
            echo json_encode($response, JSON_PRETTY_PRINT);
        }
    } catch (Exception $e) {
        header("HTTP/1.0 500 Internal Server Error");
        echo json_encode(["message" => "An error occurred while fetching activities.", "error" => $e->getMessage()]);
    }
}

function getActivite($id)
{
    global $conn;
    // Utiliser une condition WHERE pour récupérer l'activité par son ID
    $query = "SELECT * FROM activite WHERE id = :id"; 
    try {
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();

        $response = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $response[] = $row;
        }

        // Si aucune activité n'est trouvée
        if (empty($response)) {
            header("HTTP/1.0 404 Not Found");
            echo json_encode(["message" => "Activity not found."]);
        } else {
            header('Content-Type: application/json');
            echo json_encode($response, JSON_PRETTY_PRINT);
        }
    } catch (Exception $e) {
        header("HTTP/1.0 500 Internal Server Error");
        echo json_encode(["message" => "An error occurred while fetching the activity.", "error" => $e->getMessage()]);
    }
}
?>
