<?php
include(__DIR__ . '/../includes/db-connect.php');
$r = $db->query("SHOW TABLES LIKE 'journals'");
if ($r->num_rows == 0) {
    echo "Table journals does not exist. Creating it...\n";
    $sql = "CREATE TABLE journals (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        title VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        image_url VARCHAR(255),
        status ENUM('pending', 'published', 'flagged') DEFAULT 'pending',
        is_featured TINYINT(1) DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )";
    $db->query($sql);
    echo "Table journals created.\n";
} else {
    echo "Table journals exists. Checking columns...\n";
    $cols = $db->query("DESCRIBE journals");
    $fields = [];
    while($c = $cols->fetch_assoc()) $fields[] = $c['Field'];
    
    if (!in_array('status', $fields)) {
        $db->query("ALTER TABLE journals ADD COLUMN status ENUM('pending', 'published', 'flagged') DEFAULT 'pending' AFTER content");
        echo "Added status column.\n";
    }
    if (!in_array('is_featured', $fields)) {
        $db->query("ALTER TABLE journals ADD COLUMN is_featured TINYINT(1) DEFAULT 0 AFTER status");
        echo "Added is_featured column.\n";
    }
}
$db->close();
