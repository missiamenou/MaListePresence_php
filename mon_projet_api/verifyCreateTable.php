

<?php
require_once('data.php');

// Liste des tables à vérifier
$tables = ['members', 'evenements','participants'];  // Remplacez par les noms de vos tables

// Vérification de chaque table
foreach ($tables as $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");

    if ($result->num_rows > 0) {
        echo "La table '$table' existe.\n";
    } else {
        echo "La table '$table' n'existe pas.\n";
    }
}

$conn->close();
?>
