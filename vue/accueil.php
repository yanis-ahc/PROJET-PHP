<!DOCTYPE html>
<html lang="fr">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - GSB</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&family=Inter:wght@400&display=swap" rel="stylesheet">
    <link href="vue/bootstrap.min.css" rel="stylesheet">
</head>

<body>
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

h3 {
    color: #0078d7;
    font-family: 'Poppins', sans-serif;
    font-size: 1.5rem;
    margin-top: 2rem;
    margin-bottom: 1.5rem;
    text-align: center;
}

p {
    font-size: 1.1rem;
    margin-bottom: 1.5rem;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
}

.text-center {
    text-align: center;
}

.mt-5 {
    margin-top: 3rem;
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

/* Séparateur comme dans l'image */
hr {
    border: 0;
    height: 1px;
    background-color: #ddd;
    margin: 2rem auto;
    max-width: 800px;
}
footer p {
    margin: 0;
    font-size: 0.9rem;
    text-align: center; /* Ajout de cette ligne pour centrer le texte */
}
footer {
    background-color: #0078d7;
    color: white;
    text-align: center;
    padding: 1rem;
    margin-top: 3rem;
    display: flex; /* Ajout de cette ligne */
    justify-content: center; /* Ajout de cette ligne */
    align-items: center; /* Ajout de cette ligne pour centrer verticalement */
}


        
    </style>
    
    <header>
        <h1>Laboratoire GSB</h1>
    </header>
    <nav>
        <ul>
            <li><a href="index.php?action=ACC">Accueil</a></li>
            <li><a href="index.php?action=MD">Médicaments</a></li>
            <li><a href="index.php?action=AC">Actvité</a></li>
            <li><a href="index.php?action=ML">Mentions légale</a></li>
        </ul>
    </nav>
    <h2 class="text-center">Bienvenue sur le site du Laboratoire GSB</h2>
                        <p class="text-center">Explorez nos médicaments, activités et bien plus encore.</p>

                        <!-- Section "À propos de nous" -->
                        <div class="mt-5">
                            <h3 class="text-center">À propos de nous</h3>
                            <p class="text-center">
                                Le Laboratoire GSB  est un leader mondial dans le domaine de la recherche et du développement de médicaments innovants. 
                                Fondé en 1985, notre entreprise s'engage à améliorer la santé et le bien-être des patients à travers le monde en proposant des solutions thérapeutiques de pointe.
                            </p>
                            <p class="text-center">
                                Avec plus de 10 000 employés répartis dans 30 pays, nous combinons expertise scientifique, innovation technologique et éthique professionnelle pour répondre aux besoins médicaux non satisfaits.
                            </p>
                        </div>

                        <!-- Section "Nos missions" -->
                        <div class="mt-5">
                            <h3 class="text-center">Nos missions</h3>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card p-3 mb-4 shadow">
                                        <h5 class="card-title">Recherche et Développement</h5>
                                        <p class="card-text">
                                            Nous investissons massivement dans la recherche pour découvrir de nouveaux traitements et améliorer les thérapies existantes.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card p-3 mb-4 shadow">
                                        <h5 class="card-title">Santé Publique</h5>
                                        <p class="card-text">
                                            Nous collaborons avec les gouvernements et les organisations internationales pour promouvoir la santé publique.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card p-3 mb-4 shadow">
                                        <h5 class="card-title">Innovation Technologique</h5>
                                        <p class="card-text">
                                            Nous utilisons les dernières technologies pour accélérer le développement de médicaments et améliorer leur efficacité.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section "Nos valeurs" -->
                        <div class="mt-5">
                            <h3 class="text-center">Nos valeurs</h3>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card p-3 mb-4 shadow">
                                        <h5 class="card-title">Innovation</h5>
                                        <p class="card-text">
                                            Nous repoussons les limites de la science pour développer des traitements révolutionnaires.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card p-3 mb-4 shadow">
                                        <h5 class="card-title">Éthique</h5>
                                        <p class="card-text">
                                            Nous agissons avec intégrité et transparence dans toutes nos activités.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card p-3 mb-4 shadow">
                                        <h5 class="card-title">Engagement</h5>
                                        <p class="card-text">
                                            Nous nous engageons à améliorer la qualité de vie des patients à travers le monde.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
    <footer>
        <p>&copy; 2025 Laboratoire GSB - Tous droits réservés</p>
    </footer>
</body>
</html>