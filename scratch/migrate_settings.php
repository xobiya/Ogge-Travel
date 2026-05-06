<?php
include(__DIR__ . '/../includes/db-connect.php');
$r = $db->query("SHOW TABLES LIKE 'site_settings'");
if ($r->num_rows == 0) {
    echo "Creating site_settings table...\n";
    $db->query("CREATE TABLE site_settings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        setting_key VARCHAR(100) UNIQUE NOT NULL,
        setting_value TEXT,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");
    
    // Seed default settings
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
    echo "Default settings seeded.\n";
}
$db->close();
