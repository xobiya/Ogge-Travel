<?php
/**
 * OGGE Travel - Front Controller / Router
 * This file handles clean URLs like /home, /contact, etc.
 */

// Get the request path and strip query strings
$request = $_SERVER['REQUEST_URI'];
$base_path = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
if ($base_path !== '/' && strpos($request, $base_path) === 0) {
    $request = substr($request, strlen($base_path));
}
$url = parse_url($request, PHP_URL_PATH);
$url = trim($url, '/');

// Define route mapping (URL => Page File)
$routes = [
    '' => 'index.php',
    'home' => 'index.php',
    'destinations' => 'Destination.php',
    'destination-detail' => 'destination-detail.php',
    'about' => 'about.php',
    'contact' => 'contact.php',
    'packages' => 'packages.php',
    'booking' => 'book.php',
    'journal' => 'journals.php',
    'account' => 'Account.php',
    'profile' => 'profile.php',
    'my-bookings' => 'my-booking.php',
    'pay' => 'pay.php',
    'payment-result' => 'payment-result.php',
    'search' => 'search.php',
    'forgot-password' => 'forgot-password.php',
    'reset-password' => 'reset-password.php'
];

// Check if route exists
if (isset($routes[$url])) {
    $page = $routes[$url];
    $page_path = __DIR__ . '/pages/' . $page;

    if (file_exists($page_path)) {
        // Change directory to pages so relative includes (../includes/...) still work
        chdir(__DIR__ . '/pages');
        include($page_path);
        exit();
    }
}

// Fallback for direct file access or 404
if ($url && file_exists(__DIR__ . '/pages/' . $url . '.php')) {
    $page_path = __DIR__ . '/pages/' . $url . '.php';
    chdir(__DIR__ . '/pages');
    include($page_path);
    exit();
}

// 404 Not Found
http_response_code(404);
echo "<h1>404 - Page Not Found</h1>";
echo "<p>The page you are looking for does not exist. <a href='./home'>Return Home</a></p>";
?>

