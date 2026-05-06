<?php
include(__DIR__ . '/../includes/db-connect.php');

echo "Adding GPS coordinates to destinations...\n";

$cols = $db->query("DESCRIBE destinations");
$fields = [];
while($c = $cols->fetch_assoc()) $fields[] = $c['Field'];

if (!in_array('latitude', $fields)) {
    $db->query("ALTER TABLE destinations ADD COLUMN latitude DECIMAL(10, 8) AFTER image_url");
}
if (!in_array('longitude', $fields)) {
    $db->query("ALTER TABLE destinations ADD COLUMN longitude DECIMAL(11, 8) AFTER latitude");
}

// Seed some sample coordinates for top destinations
$coords = [
    'Addis Ababa' => [9.0333, 38.7500],
    'Lalibela' => [12.0333, 39.0333],
    'Aksum' => [14.1333, 38.7167],
    'Gonder' => [12.6000, 37.4667],
    'Bahirdar' => [11.5947, 37.3877],
    'Simien Mountains' => [13.2333, 38.2500],
    'Omo Valley' => [5.4167, 36.3333],
    'Danakil Depression' => [14.2417, 40.2981],
    'Harer' => [9.3167, 42.1167]
];

foreach ($coords as $name => $pos) {
    $stmt = $db->prepare("UPDATE destinations SET latitude = ?, longitude = ? WHERE name LIKE ?");
    $stmt->bind_param("dds", $pos[0], $pos[1], $name);
    $name_param = "%$name%";
    $stmt->execute();
}

$db->close();
echo "GPS seeding complete.\n";
