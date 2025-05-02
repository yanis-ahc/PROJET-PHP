<?php
// Définir les URLs de l'API
define('API_BASE_URL', 'http://localhost/php/api/');
$api_activites = API_BASE_URL . 'apiAct.php';
$api_utilisateurs = API_BASE_URL . 'apiUtil.php';
$api_inscriptions = API_BASE_URL . 'apiIns.php';

// Fonction pour appeler l'API
function callAPI($url, $postData = null) {
    if ($postData) {
        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($postData)
            ]
        ];
        $context = stream_context_create($options);
        $response = @file_get_contents($url, false, $context);
    } else {
        $response = @file_get_contents($url);
    }
    
    if ($response === FALSE) {
        return false;
    }
    return json_decode($response, true);
}

// Récupérer les données
$activites = callAPI($api_activites);
$utilisateurs = callAPI($api_utilisateurs);

// Vérification des données
if (!$activites || !is_array($activites)) {
    echo "<p class='text-center text-danger'>Erreur lors de la récupération des activités.</p>";
    exit;
}

if (!$utilisateurs || !is_array($utilisateurs)) {
    echo "<p class='text-center text-danger'>Erreur lors de la récupération des utilisateurs.</p>";
    exit;
}

// Traitement du formulaire
$message = '';
$messageClass = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUtilisateur = $_POST['idUtilisateur'] ?? '';
    $idActivite = $_POST['idActivite'] ?? '';
    
    if (empty($idUtilisateur) || empty($idActivite)) {
        $message = 'Veuillez sélectionner un utilisateur et une activité';
        $messageClass = 'text-danger';
    } else {
        $result = callAPI($api_inscriptions, [
            'idUtilisateur' => $idUtilisateur,
            'idActivite' => $idActivite
        ]);
        
        if ($result && isset($result['success'])) {
            if ($result['success']) {
                $message = $result['message'] ?? 'Inscription réussie !';
                $messageClass = 'text-success';
            } else {
                $message = $result['message'] ?? 'Erreur lors de l\'inscription';
                $messageClass = 'text-danger';
            }
        } else {
            $message = 'Erreur de connexion au serveur';
            $messageClass = 'text-danger';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activités - GSB</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&family=Inter:wght@400&display=swap" rel="stylesheet">
    <link href="vue/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }
        header {
            background-color: #0078d7;
            color: white;
            padding: 1rem 2rem;
            text-align: center;
        }
        header h1 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            margin: 0;
            font-size: 2rem;
        }
        nav {
            background-color: #005bb5;
            padding: 0.5rem 0;
        }
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            gap: 2rem;
        }
        nav li a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        nav li a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        h2 {
            color: #0078d7;
            font-family: 'Poppins', sans-serif;
            font-size: 2rem;
            margin-top: 2rem;
            margin-bottom: 1rem;
            text-align: center;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 1.5rem;
            margin: 0 auto;
            max-width: 1200px;
            padding: 0 1rem;
        }
        .col-md-4 {
            flex: 1 1 300px;
            max-width: 350px;
        }
        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            height: 100%;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        .card-title {
            color: #005bb5;
            font-family: 'Poppins', sans-serif;
            font-size: 1.25rem;
            margin-top: 0;
            margin-bottom: 1rem;
        }
        .card-text {
            font-size: 1rem;
            color: #555;
        }
        footer {
            background-color: #0078d7;
            color: white;
            text-align: center;
            padding: 1rem;
            margin-top: 3rem;
        }
        footer p {
            margin: 0;
            font-size: 0.9rem;
        }
        .text-success {
            color: #28a745;
        }
        .text-danger {
            color: #dc3545;
        }
        .text-center {
            text-align: center;
        }
        .mt-3 {
            margin-top: 1rem;
        }
        .mt-5 {
            margin-top: 3rem;
        }
        .d-flex {
            display: flex;
        }
        .justify-content-center {
            justify-content: center;
        }
        .bg-white {
            background-color: white;
        }
        .shadow-lg {
            box-shadow: 0 1rem 3rem rgba(0,0,0,.175);
        }
        .rounded-3 {
            border-radius: 0.3rem;
        }
        .p-5 {
            padding: 3rem;
        }
        .mb-3 {
            margin-bottom: 1rem;
        }
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
        }
        .form-select {
            display: block;
            width: 100%;
            padding: 0.375rem 2.25rem 0.375rem 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }
        .btn {
            display: inline-block;
            padding: 0.375rem 0.75rem;
            border-radius: 0.25rem;
            text-align: center;
        }
        .btn-primary {
            color: white;
            background-color: #007bff;
            border-color: #007bff;
        }
        .w-100 {
            width: 100%;
        }
        .fw-bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header>
        <h1>Laboratoire GSB</h1>
    </header>
    <nav>
        <ul>
            <li><a href="index.php?action=ACC">Accueil</a></li>
            <li><a href="index.php?action=MD">Médicaments</a></li>
            <li><a href="index.php?action=AC">Activité</a></li>
            <li><a href="index.php?action=ML">Mentions légales</a></li>
        </ul>
    </nav>

    <h2 class="text-center">Activités</h2>
    <p class="text-center">Découvrez nos activités récentes.</p>
    <div class="row" id="activitesContainer">
        <?php foreach ($activites as $activite): ?>
            <div class="col-md-4">
                <div class="card p-3 shadow">
                    <h5 class="card-title"><?= $activite['nom'] ?? 'Nom indisponible' ?></h5>
                    <p class="card-text"><?= $activite['description'] ?? 'Description indisponible' ?></p>
                    <p class="card-text"><strong>Date :</strong> <?= $activite['Dates'] ?? 'Date indisponible' ?></p>
                    <p class="card-text"><strong>Lieu :</strong> <?= $activite['lieu'] ?? 'Lieu indisponible' ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <h2 class="text-center mt-5">Inscription</h2>
    <div class="d-flex justify-content-center">
        <div class="bg-white shadow-lg rounded-3 p-5" style="max-width: 400px; width: 100%;">
            <h3 class="text-center text-primary">Rejoignez une activité</h3>
            <form method="POST" class="mt-4">
                <div class="mb-3">
                    <label for="idUtilisateur" class="form-label">Utilisateur</label>
                    <select id="idUtilisateur" name="idUtilisateur" required class="form-select">
                        <option value="">Sélectionner un utilisateur</option>
                        <?php foreach ($utilisateurs as $utilisateur): ?>
                            <option value="<?= $utilisateur['idUtilisateur'] ?>" 
                                <?= (isset($_POST['idUtilisateur']) && $_POST['idUtilisateur'] == $utilisateur['idUtilisateur']) ? 'selected' : '' ?>>
                                <?= $utilisateur['nom'] ?? 'Nom indisponible' ?> 
                                <?= $utilisateur['prenom'] ?? 'Prénom indisponible' ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div> 
                <div class="mb-3">
                    <label for="idActivite" class="form-label">Activité</label>
                    <select id="idActivite" name="idActivite" required class="form-select">
                        <option value="">Sélectionner une activité</option>
                        <?php foreach ($activites as $activite): ?>
                            <option value="<?= $activite['idActivite'] ?>"
                                <?= (isset($_POST['idActivite']) && $_POST['idActivite'] == $activite['idActivite']) ? 'selected' : '' ?>>
                                <?= $activite['nom'] ?? 'Nom indisponible' ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-bold">S'inscrire</button>
                <?php if ($message): ?>
                    <div class="mt-3 text-center <?= $messageClass ?>"><?= $message ?></div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Laboratoire GSB - Tous droits réservés</p>
    </footer>
</body>
</html>
