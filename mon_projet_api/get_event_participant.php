



<?php
require_once('data.php'); // Fichier de connexion à la base de données

// Requête SQL pour récupérer les événements, les participants, ainsi que le nombre total d'hommes et de femmes
$query = "
    SELECT
        e.nom_event,
        e.date_event,
        e.dateHeureEnregistrement,
        m.nom,
        m.prenom,
        m.sexe,
        m.date_de_naissance,
        m.photo_url,
        SUM(CASE WHEN m.sexe = 'M' THEN 1 ELSE 0 END) OVER (PARTITION BY e.nom_event, e.date_event) AS nombre_hommes,
        SUM(CASE WHEN m.sexe = 'F' THEN 1 ELSE 0 END) OVER (PARTITION BY e.nom_event, e.date_event) AS nombre_femmes
    FROM participants p
    JOIN evenements e ON p.code_event = e.code_event
    JOIN members m ON p.id_members = m.id
    ORDER BY e.dateHeureEnregistrement DESC
";

// Exécution de la requête
$result = $conn->query($query);

// Tableau pour stocker les résultats
$events = [];

// Traitement des résultats
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $eventKey = $row["nom_event"] . ' - ' . $row["date_event"];
        
        // Vérifie si l'événement existe déjà dans le tableau
        if (!isset($events[$eventKey])) {
            $events[$eventKey] = [
                "nom_event" => $row["nom_event"],
                "date_event" => $row["date_event"],
                "participants" => [],
                "nombre_hommes" => $row["nombre_hommes"],
                "nombre_femmes" => $row["nombre_femmes"],
            ];
        }
        
        // Ajouter le participant à l'événement
        $events[$eventKey]["participants"][] = [
            "nom" => $row["nom"],
            "prenom" => $row["prenom"],
            "sexe" => $row["sexe"],
            "date_de_naissance" => $row["date_de_naissance"],
            "photo_url" => $row["photo_url"]
        ];
    }
}

// Conversion du tableau en JSON
$jsonEvents = json_encode($events, JSON_PRETTY_PRINT);

// Affichage du JSON
header('Content-Type: application/json');
echo $jsonEvents;

$conn->close();
?>
