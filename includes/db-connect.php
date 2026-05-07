<?php

$config = [];
$configFile = __DIR__ . '/config.php';

if (is_file($configFile)) {
    $loadedConfig = require $configFile;

    if (is_array($loadedConfig)) {
        $config = $loadedConfig;
    }
}

if (!function_exists('ogge_db_config_value')) {
    function ogge_db_config_value(
        array $config,
        string $configKey,
        string $envKey,
        string $default
    ): string {
        $envValue = getenv($envKey);

        if ($envValue !== false && $envValue !== '') {
            return $envValue;
        }

        if (array_key_exists($configKey, $config)) {
            return (string) $config[$configKey];
        }

        return $default;
    }
}

$servername = ogge_db_config_value(
    $config,
    'db_host',
    'OGGE_DB_HOST',
    'localhost'
);

$username = ogge_db_config_value(
    $config,
    'db_user',
    'OGGE_DB_USER',
    'root'
);

$password = ogge_db_config_value(
    $config,
    'db_password',
    'OGGE_DB_PASSWORD',
    ''
);

$dbname = ogge_db_config_value(
    $config,
    'db_name',
    'OGGE_DB_NAME',
    'travel_agency'
);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $db = new mysqli($servername, $username, $password, $dbname);
    $db->set_charset('utf8mb4');

} catch (mysqli_sql_exception $exception) {

    error_log('Database connection failed: ' . $exception->getMessage());

    // Optional database mode
    if (defined('OGGE_DB_OPTIONAL') && OGGE_DB_OPTIONAL) {
        $db = null;
        $db_connection_error = $exception->getMessage();
        return;
    }

    http_response_code(500);
    exit('Service temporarily unavailable. Please try again later.');
}

?>