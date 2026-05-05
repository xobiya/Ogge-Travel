<?php
session_start();
include('db-connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    $role = 'user';

    if (empty($name) || empty($email) || empty($password)) {
        $_SESSION['error'] = "Please fill all fields!";
        header('Location: ../pages/Account.php');
        exit();
    }

    if ($password !== $confirmPassword) {
        $_SESSION['error'] = "Passwords do not match!";
        header('Location: ../pages/Account.php');
        exit();
    }

    // Use prepared statements to prevent SQL Injection
    $stmt = $db->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = "Email already exists!";
        $stmt->close();
        header('Location: ../pages/Account.php');
        exit();
    }
    $stmt->close();

    // Securely hash the password before saving
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $db->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $hashed_password, $role);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Registration successful! Please login.";
    } else {
        $_SESSION['error'] = "Registration failed. Please try again.";
    }
    $stmt->close();
    header('Location: ../pages/Account.php');
    exit();
}
?>