<?php
session_start();
include("db-connect.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/Account.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $title = trim($_POST['title'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $content = trim($_POST['content'] ?? '');
    
    $image_url = '../assets/images/ethiopianadventuretours_culture_2.jpg'; // default

    // Handle File Upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../assets/images/journals/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_info = pathinfo($_FILES['image']['name']);
        $ext = strtolower($file_info['extension']);
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($ext, $allowed)) {
            $new_filename = uniqid('journal_') . '.' . $ext;
            $destination = $upload_dir . $new_filename;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                $image_url = $destination;
            }
        }
    }

    if (!empty($title) && !empty($content) && !empty($location)) {
        $stmt = $db->prepare("INSERT INTO journals (user_id, title, content, location, image_url) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $user_id, $title, $content, $location, $image_url);
        $stmt->execute();
        $stmt->close();
    }
}

header("Location: ../pages/journals.php");
exit();
?>
