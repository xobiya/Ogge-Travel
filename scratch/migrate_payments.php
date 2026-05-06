<?php
include(__DIR__ . '/../includes/db-connect.php');

echo "Updating bookings table for payment support...\n";

// Add payment columns if they don't exist
$cols = $db->query("DESCRIBE bookings");
$fields = [];
while($c = $cols->fetch_assoc()) $fields[] = $c['Field'];

if (!in_array('payment_status', $fields)) {
    $db->query("ALTER TABLE bookings ADD COLUMN payment_status ENUM('unpaid', 'pending', 'paid', 'failed') DEFAULT 'unpaid' AFTER status");
    echo "Added payment_status column.\n";
}
if (!in_array('transaction_id', $fields)) {
    $db->query("ALTER TABLE bookings ADD COLUMN transaction_id VARCHAR(100) AFTER payment_status");
    echo "Added transaction_id column.\n";
}

$db->close();
echo "Migration complete.\n";
