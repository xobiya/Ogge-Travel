<?php
session_start();
include '../includes/db-connect.php';

// Fetch all packages from the database
$query = "SELECT * FROM packages";
$result = $db->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select a Package</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/custome.css">
</head>
<body class="bg-gray-100">
    <?php include('../includes/header.php'); ?>

    <div class="container mx-auto px-4 py-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-8 text-center">Select a Travel Package</h1>

        <!-- Package Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php while ($package = $result->fetch_assoc()): ?>
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="relative">
                        <img src="<?php echo htmlspecialchars($package['image_url']); ?>" 
                             alt="<?php echo htmlspecialchars($package['title']); ?>" 
                             class="w-full h-48 object-cover">
                        <div class="absolute top-4 right-4 bg-blue-500 text-white px-3 py-1 rounded-full text-sm">
                            <?php echo htmlspecialchars($package['duration']); ?>
                        </div>
                    </div>
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-2"><?php echo htmlspecialchars($package['title']); ?></h2>
                        <p class="text-gray-600 text-sm mb-4"><?php echo htmlspecialchars($package['description']); ?></p>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-2xl font-bold text-blue-600">ETB <?php echo number_format($package['price'], 2); ?></span>
                            <span class="text-sm text-gray-500">per person</span>
                        </div>
                        <a href="book.php?package_id=<?php echo $package['id']; ?>" 
                           class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors block text-center">
                            Book Now
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <?php include('../includes/footer.php'); ?>
</body>
</html>