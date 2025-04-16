<?php
// includes/search.php
session_start();
include("db-connect.php");

try {
    $search = $_GET['search'] ?? '';
    $date = $_GET['date'] ?? '';
    $travelers = $_GET['travelers'] ?? '';

    $query = "SELECT * FROM packages WHERE 1=1";
    if($search) {
        $query .= " AND (title LIKE :search OR description LIKE :search)";
    }

    $stmt = $conn->prepare($query);
    if($search) {
        $searchTerm = "%$search%";
        $stmt->bindParam(':search', $searchTerm);
    }
    
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'data' => $results]);

} catch(PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Search failed']);
}
?>