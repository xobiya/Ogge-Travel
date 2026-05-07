<?php
require_once __DIR__ . '/auth-helpers.php';
ogge_start_secure_session();
require_once __DIR__ . '/db-connect.php';
require_once __DIR__ . '/mail-helper.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ogge_redirect('../pages/packages.php');
}

if (!isset($_SESSION['user_id'])) {
    ogge_flash('error', 'Please login to book packages.');
    ogge_redirect('../pages/Account.php');
}

$package_id = (int)($_POST['package_id'] ?? 0);
$bookingRedirect = $package_id > 0 ? '../pages/book.php?package_id=' . $package_id : '../pages/packages.php';

if (!ogge_validate_csrf($_POST['csrf_token'] ?? null)) {
    ogge_flash('error', 'Your session expired. Please try booking again.');
    ogge_redirect($bookingRedirect);
}

$travelDate = trim($_POST['travel_date'] ?? '');
$travelers = (int)($_POST['travelers'] ?? 0);
$specialRequests = trim($_POST['special_requests'] ?? '');
$termsAccepted = isset($_POST['terms']);
$user_id = (int)$_SESSION['user_id'];

if ($package_id < 1) {
    ogge_flash('error', 'Invalid package selection.');
    ogge_redirect('../pages/packages.php');
}

if ($travelDate === '' || $travelers < 1) {
    ogge_flash('error', 'Please choose a travel date and party size.');
    ogge_redirect($bookingRedirect);
}

$date = DateTime::createFromFormat('Y-m-d', $travelDate);
$today = new DateTime('today');
if (!$date || $date->format('Y-m-d') !== $travelDate || $date < $today) {
    ogge_flash('error', 'Travel date must be today or later.');
    ogge_redirect($bookingRedirect);
}

if ($travelers < 1 || $travelers > 10) {
    ogge_flash('error', 'Number of travelers must be between 1 and 10.');
    ogge_redirect($bookingRedirect);
}

if (!$termsAccepted) {
    ogge_flash('error', 'Please accept the terms and conditions before booking.');
    ogge_redirect($bookingRedirect);
}

if (strlen($specialRequests) > 1000) {
    ogge_flash('error', 'Special requests must be 1000 characters or fewer.');
    ogge_redirect($bookingRedirect);
}

try {
    $pkg = $db->prepare('SELECT id FROM packages WHERE id = ? LIMIT 1');
    $pkg->bind_param('i', $package_id);
    $pkg->execute();
    $packageExists = $pkg->get_result()->fetch_assoc();
    $pkg->close();

    if (!$packageExists) {
        ogge_flash('error', 'Requested package not found.');
        ogge_redirect('../pages/packages.php');
    }

    $stmt = $db->prepare('INSERT INTO bookings (user_id, package_id, start_date, travelers, special_requests, status) VALUES (?, ?, ?, ?, ?, \'pending\')');
    $stmt->bind_param('iisis', $user_id, $package_id, $travelDate, $travelers, $specialRequests);
    $stmt->execute();
    $booking_id = $stmt->insert_id;
    $stmt->close();

    $userStmt = $db->prepare('SELECT email FROM users WHERE id = ? LIMIT 1');
    $userStmt->bind_param('i', $user_id);
    $userStmt->execute();
    $user_data = $userStmt->get_result()->fetch_assoc();
    $userStmt->close();

    if (!$user_data) {
        throw new RuntimeException('User record missing during booking for ID: ' . $user_id);
    }

    sendCustomerNotification($user_data['email'], "Booking Received #$booking_id", "We have received your booking request for package #$package_id. Please complete payment to confirm.");
    sendAdminNotification("New Booking Alert #$booking_id", "A new booking has been placed by user #$user_id. Waiting for payment.");

    ogge_redirect("../pages/pay.php?booking_id=$booking_id");
} catch (Throwable $e) {
    error_log('Booking System Error: ' . $e->getMessage());
    ogge_flash('error', 'A technical error occurred while securing your reservation. Please contact support.');
    ogge_redirect($bookingRedirect);
}
