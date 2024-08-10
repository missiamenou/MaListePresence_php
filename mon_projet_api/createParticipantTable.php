<?php
require_once('data.php');

// SQL to create table participants
$sql = "CREATE TABLE IF NOT EXISTS `participants` (
  `id_participants` int(11) NOT NULL AUTO_INCREMENT,
  `id_members` int(10) DEFAULT NULL,
  `code_event` varchar(100) NOT NULL,
  PRIMARY KEY (`id_participants`),
  KEY `Etrangère` (`id_members`),
  KEY `EventParticipants` (`code_event`),
  CONSTRAINT `EventParticipants` FOREIGN KEY (`code_event`) REFERENCES `evenements` (`code_event`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `MembersParticipants` FOREIGN KEY (`id_members`) REFERENCES `members` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if ($conn->query($sql) === TRUE) {
    echo "Table participants created successfully";
} else {
    echo "Error creating table participants: " . $conn->error;
}

// Check if the table exists and list it
$result = $conn->query("SHOW TABLES LIKE 'participants'");
if ($result->num_rows > 0) {
    echo "Table 'participants' exists.";
} else {
    echo "Table 'participants' does not exist.";
}

$conn->close();
?>

