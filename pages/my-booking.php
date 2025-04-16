<?php
session_start();
include('../includes/db-connect.php');

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: Account.php');
    exit();
}

// Get user's bookings
$user_id = $_SESSION['user_id'];
$query = "SELECT b.*, p.title, p.image_url, p.price 
          FROM bookings b 
          JOIN packages p ON b.package_id = p.id 
          WHERE b.user_id = $user_id 
          ORDER BY b.created_at DESC";
$result = mysqli_query($db, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - OGGE TRAVEL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .booking-card {
            transition: transform 0.2s;
        }
        .booking-card:hover {
            transform: translateY(-5px);
        }
        @media (max-width: 768px) {
            .booking-grid {
                grid-template-columns: 1fr;
            }
            .booking-details {
                flex-direction: column;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <?php include('../includes/header.php'); ?>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">My Bookings</h1>

        <?php if (mysqli_num_rows($result) == 0): ?>
            <!-- No bookings message -->
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <img src="../assets/images/no-bookings.png" alt="No bookings" 
                     class="w-32 h-32 mx-auto mb-4 opacity-50">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">No Bookings Found</h2>
                <p class="text-gray-600 mb-4">You haven't made any bookings yet.</p>
                <a href="packages.php" 
                   class="inline-block bg-amber-500 text-white px-6 py-2 rounded-lg hover:bg-amber-600">
                    Explore Packages
                </a>
            </div>
        <?php else: ?>
            <!-- Bookings grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php while($booking = mysqli_fetch_assoc($result)): ?>
                    <div class="booking-card bg-white rounded-lg shadow overflow-hidden">
                        <img src="<?= htmlspecialchars($booking['image_url']) ?>" 
                             alt="<?= htmlspecialchars($booking['title']) ?>"
                             class="w-full h-48 object-cover">
                        
                        <div class="p-4">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">
                                <?= htmlspecialchars($booking['title']) ?>
                            </h3>
                            
                            <div class="space-y-2 text-sm text-gray-600">
                                <div class="flex justify-between">
                                    <span>Booking Date:</span>
                                    <span class="font-medium">
                                        <?= date('M j, Y', strtotime($booking['created_at'])) ?>
                                    </span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span>Travel Date:</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span>Travelers:</span>
                                    <span class="font-medium"><?= $booking['travelers'] ?></span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span>Total Price:</span>
                                    <span class="font-medium text-amber-600">
                                        ETB <?= number_format($booking['price'] * $booking['travelers']) ?>
                                    </span>
                                </div>
                                
                                <div class="flex justify-between items-center">
                                    <span>Status:</span>
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        <?php
                                        echo match($booking['status']) {
                                            'confirmed' => 'bg-green-100 text-green-800',
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        };
                                        ?>">
                                        <?= ucfirst($booking['status']) ?>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="mt-4 pt-4 border-t">
                                <a href="booking-details.php?id=<?= $booking['id'] ?>"
                                   class="block w-full text-center bg-amber-500 text-white py-2 rounded-lg hover:bg-amber-600 transition-colors">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php include('../includes/footer.php'); ?>
</body>
</html>