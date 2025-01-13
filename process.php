<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $civilite = htmlspecialchars($_POST['civilite']);
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $adresse = htmlspecialchars($_POST['adresse']);
    $date_naissance = htmlspecialchars($_POST['date_naissance']);
    $email = htmlspecialchars($_POST['email']);
    $sport = htmlspecialchars($_POST['sport']);
    $lieu = $_POST['lieu']; // Les coordonnées envoyées en JSON

    // Vérifier si le champ "lieu" est vide ou non valide
    if (empty($lieu)) {
        echo "Erreur : Les coordonnées de la station sont manquantes.";
        exit;
    }

    // Décoder les coordonnées (JSON)
    $coords = json_decode($lieu, true);

    // Vérifier si la décodification a réussi
    if (!$coords || !isset($coords['lat']) || !isset($coords['lon'])) {
        echo "Erreur : Les coordonnées sont invalides.";
        exit;
    }

    // Extraire les valeurs de latitude et longitude
    $lat = $coords['lat'];
    $lon = $coords['lon'];

    // Liste des stations pour afficher le nom
    $stations = [
        // Alpes
        "Chamonix" => [45.9237, 6.8694],
        "Méribel" => [45.3983, 6.5651],
        "Les Arcs" => [45.5726, 6.7785],
        "Val Thorens" => [45.2979, 6.5800],
        "La Plagne" => [45.5075, 6.6773],
        "Tignes" => [45.4684, 6.9054],
        "Alpe d'Huez" => [45.0910, 6.0675],
        "Courchevel" => [45.4152, 6.6344],
        "Les Deux Alpes" => [45.0105, 6.1278],
        "Avoriaz" => [46.1912, 6.7758],
        "Serre Chevalier" => [44.9474, 6.5708],
        "La Clusaz" => [45.9043, 6.4230],
        "Val d'Isère" => [45.4492, 6.9773],
        "Les Menuires" => [45.3244, 6.5388],
        "Flaine" => [46.0058, 6.6929],
        "Megève" => [45.8577, 6.6135],
        "Samoëns" => [46.0836, 6.7284],
        "Le Grand-Bornand" => [45.9415, 6.4274],
    
        // Pyrénées
        "Saint-Lary-Soulan" => [42.8167, 0.3167],
        "Cauterets" => [42.8917, -0.1167],
        "Font-Romeu" => [42.5048, 2.0376],
        "Ax 3 Domaines" => [42.7205, 1.8411],
        "Gourette" => [42.9589, -0.3336],
    
        // Massif Central
        "Le Mont-Dore" => [45.5776, 2.8099],
        "Super Besse" => [45.5086, 2.8494],
    
        // Vosges
        "La Bresse" => [47.9990, 6.8704],
        "Gérardmer" => [48.0724, 6.8757],
    
        // Jura
        "Les Rousses" => [46.4833, 6.0667],
    
        // Corse
        "Ghisoni" => [42.0823, 9.2270],
    ];

    // Trouver le nom de la station en fonction des coordonnées
    $stationName = "Station inconnue"; // Valeur par défaut
    foreach ($stations as $name => $coordinates) {
        if ($coordinates[0] == $lat && $coordinates[1] == $lon) {
            $stationName = $name;
            break;
        }
    }

    // Appeler l'API météo
    $apiKey = 'ae0c9f8b1f38d30676849bbb1f4194ca'; // Remplacer par votre propre clé API
    $weatherUrl = "https://api.openweathermap.org/data/2.5/weather?lat=$lat&lon=$lon&appid=$apiKey&units=metric";
    $weatherData = @file_get_contents($weatherUrl);  // Ajouter '@' pour ne pas afficher d'erreurs de connexion
    if (!$weatherData) {
        echo "Erreur : Impossible de récupérer les données météo.";
        exit;
    }
    $weather = json_decode($weatherData, true);

    // Afficher les résultats
    echo "<h1>Récapitulatif</h1>";
    echo "<p><strong>Civilité :</strong> $civilite</p>";
    echo "<p><strong>Nom :</strong> $nom</p>";
    echo "<p><strong>Prénom :</strong> $prenom</p>";
    echo "<p><strong>Adresse :</strong> $adresse</p>";
    echo "<p><strong>Date de naissance :</strong> $date_naissance</p>";
    echo "<p><strong>Email :</strong> $email</p>";
    echo "<p><strong>Sport :</strong> $sport</p>";
    echo "<p><strong>Lieu :</strong> $stationName</p>";
    echo "<h2>Météo</h2>";
    echo "<p><strong>Température :</strong> " . $weather['main']['temp'] . "°C</p>";
    echo "<p><strong>Description :</strong> " . $weather['weather'][0]['description'] . "</p>";
}
?>