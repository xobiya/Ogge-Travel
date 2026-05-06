<?php
include 'includes/db-connect.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $stmt = $db->prepare("INSERT INTO bookings (user_id, package_id, start_date, travelers, special_requests, status) VALUES (?, ?, ?, ?, ?, 'pending')");
    $user_id = 1;
    $package_id = 1;
    $travel_date = '2030-01-01';
    $travelers = 2;
    $special_requests = 'Test request';

    $stmt->bind_param("iisis", $user_id, $package_id, $travel_date, $travelers, $special_requests);
    $stmt->execute();
    echo "Success. Insert ID: " . $stmt->insert_id . "\n";
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
