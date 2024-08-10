<?php
require_once('data.php');

// Lire les données envoyées par la requête POST
$data = json_decode(file_get_contents("php://input"), true);

// Valider les données
if (!isset($data['id'], $data['nom'], $data['prenom'], $data['dateDeNaissance'], $data['sexe'])) {
    echo json_encode(['success' => false, 'message' => 'Données manquantes']);
    exit();
}

$id = $data['id'];
$nom = $data['nom'];
$prenom = $data['prenom'];
$dateDeNaissance = $data['dateDeNaissance'];
$sexe = $data['sexe'];

// Log pour vérifier la date reçue
error_log("Date reçue: " . $dateDeNaissance);

// Préparer la requête SQL pour mettre à jour le membre
$sql = "UPDATE members SET nom = ?, prenom = ?, date_de_naissance = ?, sexe = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Erreur de préparation de la requête: ' . $conn->error]);
    exit();
}

// Lier les paramètres
if (!$stmt->bind_param("ssssi", $nom, $prenom, $dateDeNaissance, $sexe, $id)) {
    echo json_encode(['success' => false, 'message' => 'Erreur de liaison des paramètres: ' . $stmt->error]);
    exit();
}

// Exécuter la requête
if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Membre mis à jour avec succès']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Aucun changement effectué. Assurez-vous que les données sont correctes.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour du membre: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
