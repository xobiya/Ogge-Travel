<?php
include("../includes/db-connect.php");
session_start();

// Get search parameters
$search = $_GET['search'] ?? '';
$date = $_GET['date'] ?? '';
$travelers = $_GET['travelers'] ?? '';

// Simple search query
$query = "SELECT * FROM packages WHERE 1=1";
if (!empty($search)) {
    $search = mysqli_real_escape_string($conn, $search);
    $query .= " AND (title LIKE '%$search%' OR description LIKE '%$search%')";
}

// Execute query
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <?php include("../includes/header.php"); ?>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Search Results</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php while($package = mysqli_fetch_assoc($result)): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="<?php echo $package['image_url']; ?>" 
                         alt="<?php echo $package['title']; ?>"
                         class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="text-xl font-bold mb-2"><?php echo $package['title']; ?></h2>
                        <p class="text-gray-600 mb-4"><?php echo $package['description']; ?></p>
                        <div class="flex justify-between items-center">
                            <span class="text-amber-600 font-bold">ETB <?php echo $package['price']; ?></span>
                            <span class="text-gray-500"><?php echo $package['duration']; ?></span>
                        </div>
                        <button onclick="openModal('<?php echo $package['id']; ?>')"
                                class="w-full mt-4 bg-amber-500 text-white py-2 rounded hover:bg-amber-600">
                            Book Now
                        </button>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <?php include("../includes/footer.php"); ?>
    <script src="../assets.js/script.js" > </script>
</body>
</html>

<?php
mysqli_close($conn);
?>