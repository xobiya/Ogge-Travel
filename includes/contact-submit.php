<?php
require_once __DIR__ . '/auth-helpers.php';
ogge_start_secure_session();
require_once __DIR__ . '/db-connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ogge_redirect('../pages/contact.php');
}

if (!ogge_validate_csrf($_POST['csrf_token'] ?? null)) {
    ogge_flash('error', 'Your session expired. Please send your message again.');
    ogge_redirect('../pages/contact.php');
}

if (!empty($_POST['website'] ?? '')) {
    ogge_flash('success', 'Your message has been sent!');
    ogge_redirect('../pages/contact.php');
}

$name = trim(preg_replace('/\s+/', ' ', $_POST['name'] ?? ''));
$email = ogge_normalize_email($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || $message === '') {
    ogge_flash('error', 'Please fill out all fields.');
    ogge_redirect('../pages/contact.php');
}

if (strlen($name) > 120 || strlen($message) > 3000 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    ogge_flash('error', 'Please enter a valid name, email, and message.');
    ogge_redirect('../pages/contact.php');
}

$stmt = $db->prepare('INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)');
$stmt->bind_param('sss', $name, $email, $message);

if ($stmt->execute()) {
    ogge_flash('success', 'Your message has been sent!');
} else {
    ogge_flash('error', 'Failed to send message. Please try again.');
}
$stmt->close();

ogge_redirect('../pages/contact.php');
