<?php
require_once('data.php');

// Lire les données POST
$data = json_decode(file_get_contents('php://input'), true);
$code_event = $data['code_event'];
$participants = $data['participants'];

if (!$code_event || !$participants) {
    http_response_code(400);
    echo json_encode(['message' => 'Données invalides']);
    exit;
}

foreach ($participants as $participant) {
    // Préparer et lier la requête SQL
    $stmt = $conn->prepare("INSERT INTO participants (id_members, code_event) VALUES (?, ?)");
    $stmt->bind_param("ss", $participant, $code_event);

    if (!$stmt->execute()) {
        http_response_code(500);
        echo json_encode(['message' => 'Erreur d\'enregistrement: ' . $stmt->error]);
        $stmt->close();
        $conn->close();
        exit;
    }

    $stmt->close();
}

$conn->close();
http_response_code(200);
echo json_encode(['message' => 'Participants enregistrés avec succès']);
?>
