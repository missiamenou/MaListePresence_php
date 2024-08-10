<?php
require_once('data.php');

// // Assurez-vous que la connexion à la base de données est correcte
// $conn = new mysqli($servername, $username, $password, $dbname);

// // Vérifiez la connexion
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

$name = $_POST['nom'];
$prenom = $_POST['prenom'];
$sexe = $_POST['sexe'];
$date_de_naissanc = $_POST['date_de_naissance'];

// Convertir la chaîne de date en objet DateTime
$date_de_naissance = DateTime::createFromFormat('Y-m-d', $date_de_naissanc);
if ($date_de_naissance === false) {
    die("Invalid date format. Please use 'Y-m-d'.");
}
$date_de_naissance = $date_de_naissance->format('Y-m-d');

$photo_base64 = $_POST['photo_url'];
$photo_data = base64_decode($photo_base64);
$photo_name = uniqid() . '.jpg';
$photo_path = 'images/' . $photo_name;
file_put_contents($photo_path, $photo_data);

// Préparer et lier la requête SQL
$stmt = $conn->prepare("INSERT INTO members (nom, prenom, sexe, date_de_naissance, photo_url) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $prenom, $sexe, $date_de_naissance, $photo_path);

if ($stmt->execute()) {
    http_response_code(200);
    echo "Enregistrement réussi";
} else {
    http_response_code(500);
    echo "Erreur d'enregistrement: " . $stmt->error;
}

// Fermer la connexion
$stmt->close();
$conn->close();
?>
