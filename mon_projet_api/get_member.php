<?php
require_once('data.php');

// Préparer et exécuter la requête SQL
$query = "SELECT * FROM members";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $members = [];
    while ($row = $result->fetch_assoc()) {
        $members[] = $row;
    }
    echo json_encode(['status' => 'success', 'members' => $members]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Aucun membre trouvé']);
}

$conn->close();
?>
