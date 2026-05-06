<?php
session_start();
include('db-connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Prepared statement to prevent SQL Injection
    $stmt = $db->prepare("SELECT id, name, email, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($user = $result->fetch_assoc()) {
        $stored_password = $user['password'];
        $is_valid = false;

        // Secure password verification with a legacy fallback to automatically migrate any unhashed development accounts
        if (password_verify($password, $stored_password)) {
            $is_valid = true;
        } elseif ($password === $stored_password) {
            // Legacy fallback for plain text dummy data: auto-upgrade it!
            $new_hash = password_hash($password, PASSWORD_DEFAULT);
            $upd = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
            $upd->bind_param("si", $new_hash, $user['id']);
            $upd->execute();
            $upd->close();
            $is_valid = true;
        }

        if ($is_valid) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'] ?? 'user';
            
            // Redirect admins to admin dashboard
            if (($user['role'] ?? 'user') === 'admin') {
                header("Location: ../admin/index.php");
                exit();
            }
            
            $_SESSION['success'] = "Welcome back!";
            header("Location: ../pages/index.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid email or password.";
            header("Location: ../pages/Account.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Invalid email or password.";
        header("Location: ../pages/Account.php");
        exit();
    }
    $stmt->close();
}
?>
