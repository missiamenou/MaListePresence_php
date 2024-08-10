<?php
require_once('data.php');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID manquant']);
    exit();
}

$id = $data['id'];

$sql = "DELETE FROM members WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Erreur de préparation de la requête: ' . $conn->error]);
    exit();
}

$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Membre supprimé avec succès']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression du membre: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
