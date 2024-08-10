<?php
// Connexion à la base de données (à configurer avec vos propres informations)
$servername = "localhost"; // Ou l'adresse IP de votre serveur MySQL
$username = "spcom1_komi";
$password = "SI8Z?Bihv8kg";
$database = "spcom1_komibd";

$conn = new mysqli($servername, $username, $password, $database);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}
?>
