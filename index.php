<?php
/**
 * OGGE Travel - Front Controller / Router
 * This file handles clean URLs like /home, /contact, etc.
 */

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database and shared configuration (defines BASE_URL)
require_once __DIR__ . '/includes/db-connect.php';

// If running via PHP's built-in web server, serve existing static files as-is
if (php_sapi_name() === 'cli-server') {
    $requested_file = __DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (is_file($requested_file) && file_exists($requested_file) && !str_ends_with($requested_file, '.php')) {
        return false;
    }
}

// Get the request path and strip query strings
$request_uri = $_SERVER['REQUEST_URI'];

// Calculate the relative URL from the BASE_URL
$url = parse_url($request_uri, PHP_URL_PATH);
if (BASE_URL !== '' && strpos($url, BASE_URL) === 0) {
    $url = substr($url, strlen(BASE_URL));
}
$url = trim($url, '/');

// Strip .php extension if present (for backward compatibility)
if (substr($url, -4) === '.php') {
    $url = substr($url, 0, -4);
}


// Define route mapping (URL => Page File)
$routes = [
    '' => 'index.php',
    'index' => 'index.php',
    'home' => 'index.php',
    'destinations' => 'Destination.php',
    'destination' => 'Destination.php',
    'destination-detail' => 'destination-detail.php',
    'about' => 'about.php',
    'contact' => 'contact.php',
    'packages' => 'packages.php',
    'package' => 'packages.php',
    'booking' => 'book.php',
    'book' => 'book.php',
    'journal' => 'journals.php',
    'journals' => 'journals.php',
    'account' => 'Account.php',
    'profile' => 'profile.php',
    'my-bookings' => 'my-booking.php',
    'pay' => 'pay.php',
    'payment-result' => 'payment-result.php',
    'search' => 'search.php',
    'forgot-password' => 'forgot-password.php',
    'reset-password' => 'reset-password.php'
];


// Check if route exists in map
if (isset($routes[$url])) {
    $page = $routes[$url];
    $page_path = __DIR__ . '/pages/' . $page;

    if (file_exists($page_path)) {
        chdir(__DIR__ . '/pages');
        include($page_path);
        exit();
    }
}

// Special handling for Admin routes
if ($url === 'admin' || strpos($url, 'admin/') === 0) {
    $admin_url = $url === 'admin' ? '' : substr($url, 6); // Strip 'admin/'
    $admin_url = trim($admin_url, '/');
    $admin_file = $admin_url === '' ? 'index.php' : $admin_url;
    if (substr($admin_file, -4) !== '.php') $admin_file .= '.php';
    
    $admin_path = __DIR__ . '/admin/' . $admin_file;

    if (file_exists($admin_path)) {
        chdir(__DIR__ . '/admin');
        include($admin_path);
        exit();
    }
}

// Fallback for direct file access
if ($url && file_exists(__DIR__ . '/pages/' . $url . '.php')) {
    $page_path = __DIR__ . '/pages/' . $url . '.php';
    chdir(__DIR__ . '/pages');
    include($page_path);
    exit();
}

// 404 Not Found
http_response_code(404);
echo "<h1>404 - Page Not Found</h1>";
echo "<p>The page you are looking for does not exist. <a href='".BASE_URL."/home'>Return Home</a></p>";

?>

