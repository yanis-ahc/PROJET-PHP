<?php
// Définir l'URL de base de l'API
define('API_BASE_URL', 'http://localhost/php/api/apiMed.php');

// URL pour récupérer les médicaments
$api_url = API_BASE_URL . "?type=medicaments";

// Récupérer les données de l'API
$response = @file_get_contents($api_url);
if ($response === FALSE) {
    echo "<p class='text-center text-danger'>Erreur lors de la connexion à l'API.</p>";
    exit;
}

$medicaments = json_decode($response, true);

if (!$medicaments || !is_array($medicaments)) {
    echo "<p class='text-center text-danger'>Erreur lors de la récupération des médicaments.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Médicaments - GSB</title>
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

        .interaction-list {
            margin-top: 0.5rem;
            padding-left: 1.2rem;
        }

        .interaction-list li {
            margin-bottom: 0.3rem;
        }

        .text-muted {
            color: #6c757d;
            font-style: italic;
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

        hr {
            border: 0;
            height: 1px;
            background-color: #ddd;
            margin: 2rem auto;
            max-width: 800px;
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

    <h2 class="text-center">Médicaments</h2>
    <div class="row" id="medicaments-list">
        <?php foreach ($medicaments as $medicament): ?>
            <div class="col-md-4">
                <div class="card p-3 mb-4 shadow" style="height: 100%;">
                    <h5 class="card-title"><?= htmlspecialchars($medicament['nom'] ?? 'Nom indisponible') ?></h5>
                    <p class="card-text"><?= htmlspecialchars($medicament['description'] ?? 'Description indisponible') ?></p>
                    <h5 class="card-title">Effets thérapeutiques :</h5>
                    <p class="card-text"><?= htmlspecialchars($medicament['effets_therapeutiques'] ?? 'Effets thérapeutiques indisponibles') ?></p>
                    <h5 class="card-title">Effets secondaires :</h5>
                    <p class="card-text"><?= htmlspecialchars($medicament['effets_secondaires'] ?? 'Effets secondaires indisponibles') ?></p>
                    <h5 class="card-title">Interactions</h5>
                    
                    <?php
                    // Récupérer les interactions pour ce médicament
                    if (isset($medicament['idMedicament'])) {
                        $idMedicament = $medicament['idMedicament'];
                        $interactions_url = API_BASE_URL . "?type=interactions&idMedicament=" . urlencode($idMedicament);
                        $response_interactions = @file_get_contents($interactions_url);

                        if ($response_interactions === FALSE) {
                            echo '<div class="text-muted">Erreur lors de la récupération des interactions.</div>';
                        } else {
                            $interactions = json_decode($response_interactions, true);
                            if ($interactions && is_array($interactions)) {
                                if (count($interactions) > 0) {
                                    echo '<ul class="interaction-list">';
                                    foreach ($interactions as $interaction) {
                                        if (isset($interaction['nom'])) {
                                            echo '<li>' . htmlspecialchars($interaction['nom']) . '</li>';
                                        }
                                    }
                                    echo '</ul>';
                                } else {
                                    echo '<div class="text-muted">Aucune interaction connue.</div>';
                                }
                            } else {
                                echo '<div class="text-muted">Format de réponse inattendu.</div>';
                            }
                        }
                    } else {
                        echo '<div class="text-muted">ID médicament manquant.</div>';
                    }
                    ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <footer>
        <p>&copy; 2025 Laboratoire GSB - Tous droits réservés</p>
    </footer>
</body>
</html>