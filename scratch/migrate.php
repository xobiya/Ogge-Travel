<?php
include(__DIR__ . '/../includes/db-connect.php');

// 1. Add is_read to contacts
$db->query("ALTER TABLE contacts ADD COLUMN is_read TINYINT(1) DEFAULT 0");
echo "1. contacts.is_read added\n";

// 2. Create admin_logs table
$db->query("CREATE TABLE IF NOT EXISTS admin_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT NOT NULL,
    action VARCHAR(100) NOT NULL,
    target_type VARCHAR(50),
    target_id INT,
    details TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
echo "2. admin_logs table created\n";

// 3. Create site_settings table
$db->query("CREATE TABLE IF NOT EXISTS site_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
echo "3. site_settings table created\n";

// 4. Promote admin
$db->query("UPDATE users SET role = 'admin' WHERE email = 'eshetufeleke21@gmail.com'");
echo "4. Admin user promoted\n";

echo "\nAll migrations complete!\n";
$db->close();
