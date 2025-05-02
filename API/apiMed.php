<?php
include("db_connect.php");
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (isset($_GET['type'])) {
            $type = $_GET['type'];

            if ($type === 'medicaments') {
                if (!empty($_GET["id"])) {
                    $id = $_GET["id"];  // VARCHAR, pas besoin de intval()
                    getMedicament($id);
                } else {
                    getMedicament();
                }
            } elseif ($type === 'interactions') {
                if (!empty($_GET["idMedicament"])) {
                    $id = $_GET["idMedicament"];  // VARCHAR, pas besoin de intval()
                    getInteractions($id);
                } else {
                    getInteractions();
                }
            } else {
                header("HTTP/1.0 404 Not Found");
                echo json_encode(["error" => "Type not found"]);
            }
        } else {
            header("HTTP/1.0 400 Bad Request");
            echo json_encode(["error" => "Missing type parameter"]);
        }
        break;

    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function getMedicament($id = null)
{
    global $conn;

    if ($id) {
        // Vérifier si l'idMedicament existe dans la base de données
        $query = "SELECT * FROM medicament WHERE idMedicament = :idMedicament";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':idMedicament', $id, PDO::PARAM_STR);
        $stmt->execute();

        $medicament = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$medicament) {
            echo json_encode(["error" => "Médicament non trouvé"]);
            return;
        }

        // Récupération des interactions associées
        $queryInteractions = "
            SELECT i.nom, m1.nom AS medicament1, m2.nom AS medicament2
            FROM interactions i
            JOIN medicament m1 ON i.idMedicament = m1.idMedicament
            JOIN medicament m2 ON i.idMedicament_1 = m2.idMedicament
            WHERE i.idMedicament = :idMedicament OR i.idMedicament_1 = :idMedicament
        ";
        $stmtInteractions = $conn->prepare($queryInteractions);
        $stmtInteractions->bindParam(':idMedicament', $id, PDO::PARAM_STR);
        $stmtInteractions->execute();

        $interactions = $stmtInteractions->fetchAll(PDO::FETCH_ASSOC);

        if (!$interactions) {
            $medicament['interactions'] = 'Aucune interaction trouvée';
        } else {
            $medicament['interactions'] = $interactions;
        }

        echo json_encode($medicament, JSON_PRETTY_PRINT);
    } else {
        // Sélection de tous les médicaments
        $query = "SELECT * FROM medicament";
        $stmt = $conn->query($query);
        $medicaments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($medicaments, JSON_PRETTY_PRINT);
    }
}

function getInteractions($id = null)
{
    global $conn;

    if ($id) {
        // Vérifier si l'idMedicament existe dans la base de données
        $query = "
            SELECT i.nom, m1.nom AS medicament1, m2.nom AS medicament2
            FROM interactions i
            JOIN medicament m1 ON i.idMedicament = m1.idMedicament
            JOIN medicament m2 ON i.idMedicament_1 = m2.idMedicament
            WHERE i.idMedicament = :idMedicament OR i.idMedicament_1 = :idMedicament
        ";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':idMedicament', $id, PDO::PARAM_STR);
        $stmt->execute();
    } else {
        // Récupérer toutes les interactions
        $query = "
            SELECT i.nom, m1.nom AS medicament1, m2.nom AS medicament2
            FROM interactions i
            JOIN medicament m1 ON i.idMedicament = m1.idMedicament
            JOIN medicament m2 ON i.idMedicament_1 = m2.idMedicament
        ";
        $stmt = $conn->query($query);
    }

    $interactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$interactions) {
        echo json_encode(["error" => "Aucune interaction trouvée"]);
    } else {
        echo json_encode($interactions, JSON_PRETTY_PRINT);
    }
}
?>
