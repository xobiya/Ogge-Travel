<?php

$servername = getenv('OGGE_DB_HOST') ?: 'localhost';
$username = getenv('OGGE_DB_USER') ?: 'root';
$password = getenv('OGGE_DB_PASSWORD') ?: '';
$dbname = getenv('OGGE_DB_NAME') ?: 'travel_agency';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $db = new mysqli($servername, $username, $password, $dbname);
    $db->set_charset('utf8mb4');
} catch (mysqli_sql_exception $exception) {
    error_log('Database connection failed: ' . $exception->getMessage());
    http_response_code(500);
    exit('Service temporarily unavailable. Please try again later.');
}
?>
