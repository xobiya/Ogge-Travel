<?php
include(__DIR__ . '/../includes/db-connect.php');
$r = $db->query("SELECT COUNT(*) as c FROM site_settings");
$count = $r->fetch_assoc()['c'];
echo "Total settings: $count\n";

if ($count == 0) {
    echo "Reseeding default settings...\n";
    $defaults = [
        ['site_name', 'OGGE Travel'],
        ['site_email', 'info@oggetravel.com'],
        ['site_phone', '+251 911 234 567'],
        ['site_address', 'Addis Ababa, Ethiopia'],
        ['social_fb', 'https://facebook.com/oggetravel'],
        ['social_ig', 'https://instagram.com/oggetravel'],
        ['maintenance_mode', 'off']
    ];
    $stmt = $db->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?)");
    foreach ($defaults as $d) {
        $stmt->bind_param("ss", $d[0], $d[1]);
        $stmt->execute();
    }
} else {
    $r = $db->query("SELECT * FROM site_settings");
    while($row = $r->fetch_assoc()) {
        echo $row['setting_key'] . " = " . $row['setting_value'] . "\n";
    }
}
$db->close();
