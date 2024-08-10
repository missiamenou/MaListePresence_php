<?php
// Connexion à la base de données
require_once('data.php');

// Fonction pour formater les dates en dd-MM-yyyy
function formatDate($date) {
    $dateTime = DateTime::createFromFormat('Y-m-d', $date);
    return $dateTime ? $dateTime->format('d-m-Y') : $date;
}

// Requête pour récupérer les membres
$sql_members = "SELECT * FROM members";
$result_members = $conn->query($sql_members);

$members = array();
if ($result_members->num_rows > 0) {
    while ($row = $result_members->fetch_assoc()) {
        // Formater la date de naissance
        if (isset($row['date_de_naissance'])) {
            $row['date_de_naissance'] = formatDate($row['date_de_naissance']);
        }
        $members[] = $row;
    }
}

// Requête pour récupérer les statistiques des événements
$sql_event_stats = "
    SELECT
        SUM(CASE WHEN sexe = 'M' THEN 1 ELSE 0 END) AS nombreHommes,
        SUM(CASE WHEN sexe = 'F' THEN 1 ELSE 0 END) AS nombreFemmes,
        COUNT(*) AS totalParticipants
    FROM members
";
$result_event_stats = $conn->query($sql_event_stats);

$event_stats = array();
if ($result_event_stats->num_rows > 0) {
    $event_stats = $result_event_stats->fetch_assoc();
} else {
    $event_stats = [
        'nombreHommes' => 0,
        'nombreFemmes' => 0,
        'totalParticipants' => 0
    ];
}

// Fermer la connexion à la base de données
$conn->close();

// Retourner les membres et les statistiques au format JSON
header('Content-Type: application/json');
echo json_encode([
    'members' => $members,
    'eventStats' => $event_stats
]);
?>
