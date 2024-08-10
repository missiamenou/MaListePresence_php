
<?php
require_once('data.php');
// SQL to create table evenements
$sql = "CREATE TABLE IF NOT EXISTS `evenements` (
  `id_event` int(11) NOT NULL AUTO_INCREMENT,
  `nom_event` varchar(255) NOT NULL,
  `date_event` date NOT NULL,
  `code_event` varchar(100) NOT NULL,
  `dateHeureEnregistrement` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_event`),
  UNIQUE KEY `code_event` (`code_event`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if ($conn->query($sql) === TRUE) {
    echo "Table evenements created successfully";
} else {
    echo "Error creating table evenements: " . $conn->error;
}

$conn->close();
?>
