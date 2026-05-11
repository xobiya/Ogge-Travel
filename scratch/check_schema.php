<?php
$db = new mysqli('localhost', 'root', '', 'travel_agency');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
$res = $db->query('DESCRIBE bookings');
while($row = $res->fetch_assoc()) {
    echo $row['Field'] . "\n";
}
