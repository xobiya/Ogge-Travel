<?php
include 'includes/db-connect.php';
$res = $db->query('DESCRIBE bookings');
while($row = $res->fetch_assoc()) {
    echo $row['Field'] . " - " . $row['Type'] . " - Null: " . $row['Null'] . " - Default: " . $row['Default'] . "\n";
}
?>
