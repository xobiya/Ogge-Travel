<?php
session_start();
include('db-connect.php');

function ensure_password_resets_table($db)
{
    $sql = "CREATE TABLE IF NOT EXISTS password_resets ("
        . "id int(11) NOT NULL AUTO_INCREMENT,"
        . "user_id int(11) NOT NULL,"
        . "token_hash varchar(255) NOT NULL,"
        . "expires_at datetime NOT NULL,"
        . "used_at datetime DEFAULT NULL,"
        . "created_at timestamp NOT NULL DEFAULT current_timestamp(),"
        . "PRIMARY KEY (id),"
        . "KEY user_id (user_id),"
        . "KEY token_hash (token_hash),"
        . "CONSTRAINT password_resets_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE"
        . ") ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci";
    $db->query($sql);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/forgot-password.php');
    exit();
}

$token = trim($_POST['token'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

if ($token === '' || $password === '' || $confirm_password === '') {
    $_SESSION['error'] = 'Please fill all fields.';
    header('Location: ../pages/reset-password.php?token=' . urlencode($token));
    exit();
}

if (strlen($password) < 6) {
    $_SESSION['error'] = 'Password must be at least 6 characters.';
    header('Location: ../pages/reset-password.php?token=' . urlencode($token));
    exit();
}

if ($password !== $confirm_password) {
    $_SESSION['error'] = 'Passwords do not match.';
    header('Location: ../pages/reset-password.php?token=' . urlencode($token));
    exit();
}

ensure_password_resets_table($db);

$token_hash = hash('sha256', $token);

$stmt = $db->prepare('SELECT id, user_id, expires_at, used_at FROM password_resets WHERE token_hash = ? LIMIT 1');
$stmt->bind_param('s', $token_hash);
$stmt->execute();
$result = $stmt->get_result();
$reset = $result->fetch_assoc();
$stmt->close();

if (!$reset) {
    $_SESSION['error'] = 'This reset link is invalid or expired.';
    header('Location: ../pages/forgot-password.php');
    exit();
}

if (!empty($reset['used_at']) || strtotime($reset['expires_at']) < time()) {
    $_SESSION['error'] = 'This reset link is invalid or expired.';
    header('Location: ../pages/forgot-password.php');
    exit();
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$upd = $db->prepare('UPDATE users SET password = ? WHERE id = ?');
$upd->bind_param('si', $hashed_password, $reset['user_id']);
$upd->execute();
$upd->close();

$mark = $db->prepare('UPDATE password_resets SET used_at = NOW() WHERE id = ?');
$mark->bind_param('i', $reset['id']);
$mark->execute();
$mark->close();

$_SESSION['success'] = 'Password updated. Please sign in.';
header('Location: ../pages/Account.php');
exit();
?>