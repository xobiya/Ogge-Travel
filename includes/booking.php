<?php

include("db-connect.php");


// Validate required fields
$required = ['package_id', 'user_id', 'travel_date', 'travelers'];
foreach ($required as $field) {
    if (empty($_POST[$field])) {
        $_SESSION['error'] = "Missing required information";
        header("Location: ../pages/book.php?package_id=" . ($_POST['package_id'] ?? ''));
        exit();
    }
}

// Validate package ID
$package_id = (int)$_POST['package_id'];
if ($package_id < 1) {
    $_SESSION['error'] = "Invalid package selection";
    header("Location: ../pages/package-1.php");
    exit();
}

// Validate travel date
if (strtotime($_POST['travel_date']) < strtotime('today')) {
    $_SESSION['error'] = "Travel date must be in the future";
    header("Location: ../pages/book.php?package_id=" . $package_id);
    exit();
}

// Validate travelers count
$travelers = (int)$_POST['travelers'];
if ($travelers < 1 || $travelers > 10) {
    $_SESSION['error'] = "Number of travelers must be between 1 and 10";
    header("Location: ../pages/book.php?package_id=" . $package_id);
    exit();
}

// Create booking
try {
    $stmt = $db->prepare("INSERT INTO bookings 
        (user_id, package_id, start_date, travelers, special_requests, status)
        VALUES (?, ?, ?, ?, ?, 'pending')");
    
    $special_requests = $_POST['special_requests'] ?? '';
    $stmt->bind_param("iisis",
        $_POST['user_id'],
        $package_id,
        $_POST['travel_date'],
        $travelers,
        $special_requests
    );
    
    $stmt->execute();
    $booking_id = $stmt->insert_id;
    $stmt->close();

    $_SESSION['success'] = "Booking #$booking_id confirmed successfully!";
    header("Location:conformation.php");
    exit();

} catch (Exception $e) {
    error_log("Booking Error: " . $e->getMessage());
    $_SESSION['error'] = "Error processing booking. Please try again.";
    header("Location: ../pages/book.php?package_id=" . $package_id);
    exit();
}