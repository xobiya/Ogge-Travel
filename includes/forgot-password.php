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

$email = trim($_POST['email'] ?? '');
if ($email === '') {
    $_SESSION['error'] = 'Please enter your email address.';
    header('Location: ../pages/forgot-password.php');
    exit();
}

// Always return a generic success message to avoid user enumeration
$_SESSION['success'] = 'If an account exists for that email, a reset link has been sent.';

$stmt = $db->prepare('SELECT id, name, email FROM users WHERE email = ?');
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    header('Location: ../pages/forgot-password.php');
    exit();
}

ensure_password_resets_table($db);

$token = bin2hex(random_bytes(32));
$token_hash = hash('sha256', $token);
$expires_at = date('Y-m-d H:i:s', time() + 3600);

$del = $db->prepare('DELETE FROM password_resets WHERE user_id = ?');
$del->bind_param('i', $user['id']);
$del->execute();
$del->close();

$ins = $db->prepare('INSERT INTO password_resets (user_id, token_hash, expires_at) VALUES (?, ?, ?)');
$ins->bind_param('iss', $user['id'], $token_hash, $expires_at);
$ins->execute();
$ins->close();

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$basePath = '';
if (isset($_SERVER['REQUEST_URI'])) {
    $dir = rtrim(dirname($_SERVER['REQUEST_URI']), '/');
    if (str_ends_with($dir, '/includes')) {
        $dir = substr($dir, 0, -9);
    }
    $basePath = $dir;
}
$reset_link = $scheme . '://' . $host . $basePath . '/pages/reset-password.php?token=' . urlencode($token);

$subject = 'Reset your OGGE Travel password';
$message = "Hi " . $user['name'] . ",\n\n";
$message .= "We received a request to reset your password. Use the link below to set a new one:\n";
$message .= $reset_link . "\n\n";
$message .= "This link will expire in 60 minutes. If you did not request a reset, you can ignore this email.\n";
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type:text/plain;charset=UTF-8\r\n";
$headers .= "From: OGGE Travel <no-reply@oggetravel.local>\r\n";

$mail_sent = @mail($user['email'], $subject, $message, $headers);
$is_local_host = str_starts_with($host, 'localhost') || str_starts_with($host, '127.0.0.1');
if (!$mail_sent && $is_local_host) {
    $_SESSION['reset_link'] = $reset_link;
}

header('Location: ../pages/forgot-password.php');
exit();
?>