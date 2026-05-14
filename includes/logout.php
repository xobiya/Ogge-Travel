<?php
require_once __DIR__ . '/auth-helpers.php';
require_once __DIR__ . '/db-connect.php';
ogge_start_secure_session();
$_SESSION = [];

if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
}

session_destroy();
ogge_redirect(BASE_URL . '/account');
?>
