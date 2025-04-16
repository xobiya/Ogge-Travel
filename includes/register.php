<?php
session_start();

include('db-connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $role = 'user';

    // Check if fields are empty
    if (empty($name) || empty($email) || empty($password)) {
        $_SESSION['error'] = "Please fill all fields!";
        header('Location: ../pages/Account.php');
        exit();
    }

    // Check if passwords match
    if ($password !== $confirmPassword) {
        $_SESSION['error'] = "Passwords do not match!";
        header('Location: ../pages/Account.php');
        exit();
    }



    // Check for existing email
    $checkEmail = mysqli_query($db, "SELECT email FROM users WHERE email = '$email'");
    
    if (mysqli_num_rows($checkEmail) > 0) {
        $_SESSION['error'] = "Email already exists!";
        header('Location: ../pages/Account.php');
        exit();
    }

    // Add new user
    $query = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
    
    if (mysqli_query($db, $query)) {
        $_SESSION['success'] = "Registration successful! Please login.";
        header('Location: ../pages/Account.php');
        exit();
    } else {
        $_SESSION['error'] = "Registration failed. Please try again.";
        header('Location: ../pages/Account.php');
        exit();
    }
}
?>