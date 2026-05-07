<?php
require_once __DIR__ . '/auth-helpers.php';
ogge_start_secure_session();
require_once __DIR__ . '/db-connect.php';

if (!isset($_SESSION['user_id'])) {
    ogge_redirect('../pages/Account.php');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ogge_redirect('../pages/journals.php');
}

if (!ogge_validate_csrf($_POST['csrf_token'] ?? null)) {
    ogge_flash('error', 'Your session expired. Please submit your journal again.');
    ogge_redirect('../pages/journals.php');
}

$user_id = (int)$_SESSION['user_id'];
$title = trim($_POST['title'] ?? '');
$location = trim($_POST['location'] ?? '');
$content = trim($_POST['content'] ?? '');
$image_url = '../assets/images/ethiopianadventuretours_culture_2.jpg';

if ($title === '' || $content === '' || $location === '') {
    ogge_flash('error', 'Title, location, and story are required.');
    ogge_redirect('../pages/journals.php');
}

if (strlen($title) > 255 || strlen($location) > 120 || strlen($content) > 10000) {
    ogge_flash('error', 'Please shorten your journal title, location, or story.');
    ogge_redirect('../pages/journals.php');
}

if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK || $_FILES['image']['size'] > 3 * 1024 * 1024) {
        ogge_flash('error', 'Journal image must be under 3 MB.');
        ogge_redirect('../pages/journals.php');
    }

    $upload_dir = '../assets/images/journals/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($_FILES['image']['tmp_name']);
    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];

    if (!isset($allowed[$mime])) {
        ogge_flash('error', 'Journal image must be JPG, PNG, or WebP.');
        ogge_redirect('../pages/journals.php');
    }

    $new_filename = bin2hex(random_bytes(16)) . '.' . $allowed[$mime];
    $destination = $upload_dir . $new_filename;

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
        ogge_flash('error', 'Unable to upload image. Please try again.');
        ogge_redirect('../pages/journals.php');
    }

    $image_url = $destination;
}

$stmt = $db->prepare('INSERT INTO journals (user_id, title, content, location, image_url) VALUES (?, ?, ?, ?, ?)');
$stmt->bind_param('issss', $user_id, $title, $content, $location, $image_url);
$stmt->execute();
$stmt->close();

ogge_flash('success', 'Your journal has been submitted for review.');
ogge_redirect('../pages/journals.php');
