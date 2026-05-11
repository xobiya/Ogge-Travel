<?php
require_once __DIR__ . '/auth-helpers.php';
ogge_start_secure_session();
require_once __DIR__ . '/db-connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ogge_redirect(BASE_URL . '/account');
}

$_SESSION['auth_mode'] = 'login';

if (!ogge_validate_csrf($_POST['csrf_token'] ?? null)) {
    ogge_flash('error', 'Your session expired. Please sign in again.');
    ogge_redirect('../pages/Account.php');
}

$email = ogge_normalize_email($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($email === '' || $password === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    ogge_flash('error', 'Enter a valid email and password.');
    ogge_redirect('../pages/Account.php');
}

if (ogge_is_login_throttled($email)) {
    ogge_flash('error', 'Too many sign-in attempts. Please wait 15 minutes and try again.');
    ogge_redirect('../pages/Account.php');
}

$stmt = $db->prepare('SELECT id, name, email, password, role FROM users WHERE email = ? LIMIT 1');
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$isValid = false;

if ($user) {
    $storedPassword = $user['password'];

    if (password_verify($password, $storedPassword)) {
        $isValid = true;

        if (password_needs_rehash($storedPassword, PASSWORD_DEFAULT)) {
            $newHash = password_hash($password, PASSWORD_DEFAULT);
            $upd = $db->prepare('UPDATE users SET password = ? WHERE id = ?');
            $upd->bind_param('si', $newHash, $user['id']);
            $upd->execute();
            $upd->close();
        }
    } elseif (hash_equals((string)$storedPassword, $password)) {
        $newHash = password_hash($password, PASSWORD_DEFAULT);
        $upd = $db->prepare('UPDATE users SET password = ? WHERE id = ?');
        $upd->bind_param('si', $newHash, $user['id']);
        $upd->execute();
        $upd->close();
        $isValid = true;
    }
}

if (!$isValid) {
    ogge_record_failed_login($email);
    ogge_flash('error', 'Invalid email or password.');
    ogge_redirect('../pages/Account.php');
}

ogge_clear_failed_logins($email);
ogge_sign_in_user($user);

if (($_SESSION['user_role'] ?? 'user') === 'admin') {
    ogge_redirect(BASE_URL . '/admin');
}

ogge_flash('success', 'Welcome back!');
ogge_redirect(BASE_URL . '/');
?>
