<?php
require_once __DIR__ . '/auth-helpers.php';
ogge_start_secure_session();
require_once __DIR__ . '/db-connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ogge_redirect(BASE_URL . '/account?mode=register');
}

$_SESSION['auth_mode'] = 'register';

if (!ogge_validate_csrf($_POST['csrf_token'] ?? null)) {
    ogge_flash('error', 'Your session expired. Please try creating your account again.');
    ogge_redirect(BASE_URL . '/account?mode=register');
}

$name = trim(preg_replace('/\s+/', ' ', $_POST['name'] ?? ''));
$email = ogge_normalize_email($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';
$role = 'user';

if ($name === '' || $email === '' || $password === '' || $confirmPassword === '') {
    ogge_flash('error', 'Please fill all fields.');
    ogge_redirect(BASE_URL . '/account?mode=register');
}

if (strlen($name) < 2 || strlen($name) > 120) {
    ogge_flash('error', 'Full name must be between 2 and 120 characters.');
    ogge_redirect(BASE_URL . '/account?mode=register');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 255) {
    ogge_flash('error', 'Please enter a valid email address.');
    ogge_redirect(BASE_URL . '/account?mode=register');
}

if ($password !== $confirmPassword) {
    ogge_flash('error', 'Passwords do not match.');
    ogge_redirect(BASE_URL . '/account?mode=register');
}

$passwordError = ogge_validate_password_strength($password);
if ($passwordError !== null) {
    ogge_flash('error', $passwordError);
    ogge_redirect(BASE_URL . '/account?mode=register');
}

$stmt = $db->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->close();
    ogge_flash('error', 'An account with this email already exists. Please sign in or reset your password.');
    ogge_redirect(BASE_URL . '/account?mode=login');
}
$stmt->close();

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$stmt = $db->prepare('INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)');
$stmt->bind_param('ssss', $name, $email, $hashedPassword, $role);

try {
    $stmt->execute();
    $userId = $stmt->insert_id;
    $stmt->close();

    ogge_sign_in_user([
        'id' => $userId,
        'name' => $name,
        'email' => $email,
        'role' => $role,
    ]);
    ogge_flash('success', 'Your account is ready. Welcome to OGGE Travel!');
    ogge_redirect(BASE_URL . '/profile');
} catch (mysqli_sql_exception $exception) {
    $stmt->close();
    error_log('Registration failed: ' . $exception->getMessage());
    ogge_flash('error', 'Registration failed. Please try again.');
    ogge_redirect(BASE_URL . '/account?mode=register');
}
?>
