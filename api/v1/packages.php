<?php
/**
 * OGGE Travel — REST API v1
 * Endpoint: /api/v1/packages.php
 */
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include('../../includes/db-connect.php');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $id = $_GET['id'] ?? null;
    
    if ($id) {
        $stmt = $db->prepare("SELECT p.*, d.name as destination_name FROM packages p JOIN destinations d ON p.destination_id = d.id WHERE p.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        echo json_encode($result);
    } else {
        $result = $db->query("SELECT p.*, d.name as destination_name FROM packages p JOIN destinations d ON p.destination_id = d.id ORDER BY p.title ASC");
        $packages = [];
        while($row = $result->fetch_assoc()) {
            $packages[] = $row;
        }
        echo json_encode([
            "status" => "success",
            "count" => count($packages),
            "data" => $packages
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
}

$db->close();
