<?php
session_start();
include("db-connect.php");
include("mail-helper.php");

// Enable strict error reporting for Database
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

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
    header("Location: ../pages/packages.php");
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
    $user_id = (int)$_POST['user_id'];
    
    $stmt->bind_param("iisis",
        $user_id,
        $package_id,
        $_POST['travel_date'],
        $travelers,
        $special_requests
    );
    
    $stmt->execute();
    $booking_id = $stmt->insert_id;
    $stmt->close();

    // Safely Fetch Customer Email
    $user_res = $db->query("SELECT email FROM users WHERE id = $user_id");
    $user_data = $user_res->fetch_assoc();
    
    if (!$user_data) {
        throw new Exception("Critical: User record missing during booking for ID: $user_id");
    }
    $cust_email = $user_data['email'];

    // Send Notifications
    sendCustomerNotification($cust_email, "Booking Received #$booking_id", "We have received your booking request for package #$package_id. Please complete payment to confirm.");
    sendAdminNotification("New Booking Alert #$booking_id", "A new booking has been placed by user #$user_id. Waiting for payment.");

    // Redirect to Payment Simulation
    header("Location: ../pages/pay.php?booking_id=$booking_id");
    exit();

} catch (Throwable $e) {
    error_log("Booking System Error: " . $e->getMessage());
    $_SESSION['error'] = "A technical error occurred while securing your reservation. Please contact support.";
    header("Location: ../pages/book.php?package_id=" . $package_id);
    exit();
}
