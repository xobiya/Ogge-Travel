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
    <title>User Profile | Premium OGGE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/profile.css">
    <style>
        body { font-family: 'Outfit', sans-serif; overflow-x: hidden; }
        .dashboard-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.05);
            border-radius: 2rem;
        }
        .text-gradient {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .table-row-hover {
            transition: all 0.3s ease;
        }
        .table-row-hover:hover {
            background-color: #f8fafc;
            transform: scale(1.01);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="bg-slate-50 relative min-h-screen">
    <!-- Decorative background blobs -->
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-amber-200 rounded-full blur-[100px] opacity-30 -z-10"></div>
    <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-blue-200 rounded-full blur-[100px] opacity-30 -z-10"></div>

    <?php include('../includes/header.php'); ?>

    <div class="container mx-auto px-4 py-16 max-w-7xl">
        
        <div class="mb-10">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight">
                Welcome back, <span class="text-gradient"><?= htmlspecialchars(explode(' ', $user['name'])[0]) ?></span>
            </h1>
            <p class="text-gray-500 mt-2 text-lg">Manage your premium travel experiences and account details.</p>
        </div>

        <div class="grid lg:grid-cols-3 gap-10">
            <!-- Profile Sidebar -->
            <div class="lg:col-span-1 space-y-8">
                <!-- User Info Card -->
                <div class="dashboard-card p-10 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-6 opacity-10">
                        <svg class="w-32 h-32 text-amber-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <div class="w-24 h-24 bg-gradient-to-br from-amber-400 to-orange-500 rounded-[2rem] flex items-center justify-center shadow-xl mb-8 transform rotate-3">
                            <span class="text-4xl font-extrabold text-white -rotate-3"><?= strtoupper(substr($user['name'], 0, 1)) ?></span>
                        </div>
                        
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Account Details</h2>
                        
                        <dl class="space-y-6">
                            <div>
                                <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Full Name</dt>
                                <dd class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($user['name']) ?></dd>
                            </div>
                            <div>
                                <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Email Address</dt>
                                <dd class="text-lg font-semibold text-gray-800 break-all"><?= htmlspecialchars($user['email']) ?></dd>
                            </div>
                            <div>
                                <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Phone Number</dt>
                                <dd class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($user['phone'] ?? 'Not provided') ?></dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="dashboard-card p-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Quick Actions</h2>
                    <div class="space-y-4">
                        <a href="edit-profile.php" 
                           class="flex items-center justify-center w-full bg-gray-900 text-white font-bold py-4 px-6 rounded-2xl hover:bg-amber-500 transition-colors duration-300 shadow-md hover:shadow-xl group">
                            <svg class="w-5 h-5 mr-3 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Edit Profile
                        </a>
                        <a href="change-password.php" 
                           class="flex items-center justify-center w-full bg-white text-gray-900 font-bold border-2 border-gray-200 py-4 px-6 rounded-2xl hover:border-gray-900 transition-colors duration-300">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Change Password
                        </a>
                    </div>
                </div>
            </div>

            <!-- Booking History -->
            <div class="lg:col-span-2">
                <div class="dashboard-card p-10 h-full">
                    <div class="flex justify-between items-center mb-10">
                        <h2 class="text-3xl font-extrabold text-gray-900 flex items-center">
                            <svg class="w-8 h-8 text-amber-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            Journey History
                        </h2>
                        <?php if (!empty($bookings)): ?>
                        <span class="bg-gray-100 text-gray-800 text-sm font-bold px-4 py-2 rounded-xl"><?= count($bookings) ?> Bookings</span>
                        <?php endif; ?>
                    </div>
                    
                    <?php if (empty($bookings)): ?>
                        <div class="text-center py-20 bg-gray-50 rounded-3xl border border-dashed border-gray-300">
                            <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-3">No adventures yet</h3>
                            <p class="text-gray-500 mb-8 max-w-sm mx-auto">Your booking history is empty. It's time to start exploring the wonders of Ethiopia!</p>
                            <a href="package-1.php" class="inline-flex items-center justify-center bg-gray-900 text-white font-bold py-4 px-8 rounded-2xl hover:bg-amber-500 transition-colors duration-300 shadow-lg transform hover:-translate-y-1">
                                Discover Packages
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="overflow-hidden rounded-2xl border border-gray-100">
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-8 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Package</th>
                                        <th class="px-8 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Travel Date</th>
                                        <th class="px-8 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-8 py-5 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-50">
                                    <?php foreach ($bookings as $booking): ?>
                                    <tr class="table-row-hover">
                                        <td class="px-8 py-6 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-16 w-16">
                                                    <img class="h-16 w-16 rounded-2xl object-cover shadow-sm" 
                                                         src="<?= htmlspecialchars($booking['image_url']) ?>" 
                                                         alt="<?= htmlspecialchars($booking['title']) ?>">
                                                </div>
                                                <div class="ml-5">
                                                    <div class="text-base font-bold text-gray-900 mb-1">
                                                        <?= htmlspecialchars($booking['title']) ?>
                                                    </div>
                                                    <div class="text-sm font-medium text-gray-500 flex items-center">
                                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                                        <?= $booking['travelers'] ?> <?= $booking['travelers'] == 1 ? 'traveler' : 'travelers' ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-900"><?= date('M j, Y', strtotime($booking['start_date'])) ?></div>
                                            <div class="text-xs font-medium text-gray-500">Booked: <?= date('M j', strtotime($booking['created_at'])) ?></div>
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap">
                                            <span class="px-4 py-1.5 inline-flex text-xs font-bold uppercase tracking-wider rounded-full shadow-sm
                                                <?= $booking['status'] === 'confirmed' ? 'bg-green-100 text-green-800 border border-green-200' : 
                                                   ($booking['status'] === 'cancelled' ? 'bg-red-100 text-red-800 border border-red-200' : 'bg-amber-100 text-amber-800 border border-amber-200') ?>">
                                                <?= ucfirst($booking['status']) ?>
                                            </span>
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap text-center text-sm font-medium">
                                            <a href="booking-details.php?id=<?= $booking['id'] ?>" 
                                               class="inline-flex items-center justify-center p-2 rounded-xl bg-gray-50 text-gray-600 hover:bg-gray-900 hover:text-white transition-colors duration-200">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
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
    </div>

    <?php include('../includes/footer.php'); ?>
</body>
</html>