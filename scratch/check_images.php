<?php
include(__DIR__ . '/../includes/db-connect.php');

// Show current destinations
$r = $db->query('SELECT id, name, image_url FROM destinations ORDER BY name');
echo "=== CURRENT DESTINATIONS ===\n";
while($d = $r->fetch_assoc()) {
    $path = str_replace('../', '', $d['image_url']);
    $exists = file_exists(__DIR__ . '/../' . $path) ? 'OK' : 'BROKEN';
    echo $d['id'] . ' | ' . $d['name'] . ' | ' . $d['image_url'] . ' | ' . $exists . "\n";
}

echo "\n=== CURRENT PACKAGES ===\n";
$r = $db->query('SELECT id, title, image_url FROM packages ORDER BY title');
while($p = $r->fetch_assoc()) {
    $path = str_replace('../', '', $p['image_url']);
    $exists = file_exists(__DIR__ . '/../' . $path) ? 'OK' : 'BROKEN';
    echo $p['id'] . ' | ' . $p['title'] . ' | ' . $p['image_url'] . ' | ' . $exists . "\n";
}
$db->close();
