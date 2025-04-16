<?php
session_start();
include("../includes/db-connect.php");

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: Account.php");
    exit();
}

// Get user details
$user_id = $_SESSION['user_id'];
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Get user bookings
$bookings = [];
$stmt = $db->prepare("SELECT b.*, p.title, p.image_url 
                     FROM bookings b
                     JOIN packages p ON b.package_id = p.id
                     WHERE b.user_id = ?
                     ORDER BY b.created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$bookings = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/custome.css">

</head>
<body class="bg-gray-100">
    <?php include('../includes/header.php'); ?>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto">
            <!-- Profile Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-4">Welcome, <?= htmlspecialchars($user['name']) ?></h1>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- User Information -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-700 mb-3">Account Details</h2>
                        <dl class="space-y-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                                <dd class="text-gray-700"><?= htmlspecialchars($user['name']) ?></dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email Address</dt>
                                <dd class="text-gray-700"><?= htmlspecialchars($user['email']) ?></dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
                                <dd class="text-gray-700"><?= htmlspecialchars($user['phone'] ?? 'Not provided') ?></dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Account Actions -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-700 mb-3">Quick Actions</h2>
                        <div class="space-y-3">
                            <a href="edit-profile.php" 
                               class="block w-full bg-blue-600 text-white py-2 px-4 rounded-lg text-center hover:bg-blue-700 transition-colors">
                                Edit Profile
                            </a>
                            <a href="change-password.php" 
                               class="block w-full bg-gray-200 text-gray-700 py-2 px-4 rounded-lg text-center hover:bg-gray-300 transition-colors">
                                Change Password
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking History -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Booking History</h2>
                
                <?php if (empty($bookings)): ?>
                    <div class="text-center py-8">
                        <p class="text-gray-500">You haven't made any bookings yet.</p>
                        <a href="packages.php" class="text-blue-600 hover:text-blue-700 mt-4 inline-block">
                            Browse Packages →
                        </a>
                    </div>
                <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Package</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Travel Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Travelers</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($bookings as $booking): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12">
                                                <img class="h-12 w-12 rounded-lg object-cover" 
                                                     src="<?= htmlspecialchars($booking['image_url']) ?>" 
                                                     alt="<?= htmlspecialchars($booking['title']) ?>">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    <?= htmlspecialchars($booking['title']) ?>
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    Booked on <?= date('M j, Y', strtotime($booking['created_at'])) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?= date('M j, Y', strtotime($booking['start_date'])) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?= $booking['travelers'] ?> travelers
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            <?= $booking['status'] === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                               ($booking['status'] === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') ?>">
                                            <?= ucfirst($booking['status']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="booking-details.php?id=<?= $booking['id'] ?>" 
                                           class="text-blue-600 hover:text-blue-900">View Details</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include('../includes/footer.php'); ?>
</body>
</html>