<?php
include 'includes/db-connect.php';
$res = $db->query('DESCRIBE users');
while($row = $res->fetch_assoc()) {
    echo $row['Field'] . " - " . $row['Type'] . "\n";
}
?>
