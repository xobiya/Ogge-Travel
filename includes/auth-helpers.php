<?php
/**
 * Shared authentication helpers for OGGE Travel.
 */

function ogge_start_secure_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => $isHttps,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

function ogge_flash(string $type, string $message): void
{
    $_SESSION[$type] = $message;
}

function ogge_redirect(string $location): never
{
    header('Location: ' . $location);
    exit();
}

function ogge_csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function ogge_validate_csrf(?string $token): bool
{
    return is_string($token)
        && isset($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $token);
}

function ogge_normalize_email(string $email): string
{
    return strtolower(trim($email));
}

function ogge_validate_password_strength(string $password): ?string
{
    if (strlen($password) < 8) {
        return 'Password must be at least 8 characters.';
    }

    if (strlen($password) > 72) {
        return 'Password must be 72 characters or fewer.';
    }

    if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password)) {
        return 'Password must include at least one letter and one number.';
    }

    return null;
}

function ogge_is_login_throttled(string $email): bool
{
    $key = 'login_attempts_' . hash('sha256', $email);
    $attempt = $_SESSION[$key] ?? ['count' => 0, 'first_attempt' => time()];

    if ((time() - ($attempt['first_attempt'] ?? time())) > 900) {
        unset($_SESSION[$key]);
        return false;
    }

    return ($attempt['count'] ?? 0) >= 5;
}

function ogge_record_failed_login(string $email): void
{
    $key = 'login_attempts_' . hash('sha256', $email);
    $attempt = $_SESSION[$key] ?? ['count' => 0, 'first_attempt' => time()];

    if ((time() - ($attempt['first_attempt'] ?? time())) > 900) {
        $attempt = ['count' => 0, 'first_attempt' => time()];
    }

    $attempt['count']++;
    $_SESSION[$key] = $attempt;
}

function ogge_clear_failed_logins(string $email): void
{
    unset($_SESSION['login_attempts_' . hash('sha256', $email)]);
}

function ogge_sign_in_user(array $user): void
{
    session_regenerate_id(true);
    $_SESSION['user_id'] = (int)$user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_role'] = $user['role'] ?? 'user';
    $_SESSION['authenticated_at'] = time();
    unset($_SESSION['csrf_token']);
}
