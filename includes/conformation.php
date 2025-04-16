<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: Account.php");
    exit();
}

if (!isset($_SESSION['success'])) {
    header("Location: packages.php");
    exit();
}

$success_message = $_SESSION['success'];
unset($_SESSION['success']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Success</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <?php include('../includes/header.php'); ?>

    <div class="container mx-auto px-4 py-12">
        <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-8 text-center">
            <h1 class="text-3xl font-bold text-green-600 mb-4">Booking Successful!</h1>
            <p class="text-lg text-gray-700 mb-6"><?php echo htmlspecialchars($success_message); ?></p>
            <a href="../pages/package-1.php" 
               class="inline-block bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition-colors duration-200 font-medium">
                Browse More Packages
            </a>
        </div>
    </div>

    <?php include('../includes/footer.php'); ?>
</body>
</html>