<?php
session_start();
include("../includes/db-connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Validate inputs
    if (empty($name) || empty($email) || empty($message)) {
        $_SESSION['error'] = "Please fill out all fields.";
        header("Location: ../pages/contact.php");
        exit();
    }

    // Insert into database
    $stmt = $db->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Your message has been sent!";
    } else {
        $_SESSION['error'] = "Failed to send message. Please try again.";
    }

    header("Location: ../pages/contact.php");
    exit();
}
?>