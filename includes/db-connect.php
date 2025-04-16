<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "travel_agency";

// Create connection
$db = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Optional: Set default character set
$db->set_charset("utf8mb4");
?>