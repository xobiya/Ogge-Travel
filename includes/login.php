<?php
session_start();
include('db-connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if user exists
    $query = "SELECT * FROM users where email = '$email' AND password = '$password'";
    $result = mysqli_query($db, $query);

    if ($result) {
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
        if ($user) {
            // Store user session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            // Redirect to index.php
            header("Location: ../pages/index.php");
            echo 'Login Success';
        } else {
            echo "<script>alert('Either username or password is incorrect.');
            window.location.href = '../pages/account.php';
            </script>";
        }
    } else {
        echo "Error: " . mysqli_error($db);
    }
}
?>
