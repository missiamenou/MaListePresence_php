<?php
require_once('data.php');

$name = $_POST['nomEvent'];
$date_event = $_POST['dateEvent'];

// Convertir la chaîne de date en objet DateTime
$date_de_event = DateTime::createFromFormat('Y-m-d', $date_event);
if ($date_de_event === false) {
    die("Invalid date format. Please use 'Y-m-d'.");
}
$date_de_event = $date_de_event->format('Y-m-d');

// Fonction pour générer un code unique basé sur la date, l'heure, la minute, la seconde et la tierce en UTC
function generateUniqueCode($name, $date_event) {
    $microtime = microtime(true);
    $utc_time = new DateTime('now', new DateTimeZone('UTC'));
    $current_time = $utc_time->format('H_i_s');
    $milliseconds = sprintf('%03d', ($microtime - floor($microtime)) * 1000);
    $date_formatted = str_replace('-', '_', $date_event);
    return $name . '_' . $date_formatted . '_' . $current_time . '_' . $milliseconds;
}

// Générer le code unique
$code_event_uniq = generateUniqueCode($name, $date_event);

// Préparer et lier la requête SQL
$stmt = $conn->prepare("INSERT INTO evenements (nom_event, date_event, code_event, dateHeureEnregistrement) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("sss", $name, $date_event, $code_event_uniq);

if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode(['message' => 'Enregistrement réussi', 'code_event' => $code_event_uniq]);
} else {
    http_response_code(500);
    echo json_encode(['message' => 'Erreur d\'enregistrement: ' . $stmt->error]);
}

// Fermer la connexion
$stmt->close();
$conn->close();
?>
