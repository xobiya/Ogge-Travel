<?php
// Start the session if it hasn't already been started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OGGE TRAVEL</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/profile.css">
      
</head>
<body>
    <header class="sticky top-0 z-50 bg-gray-900 shadow-lg w-full">
        <nav class="px-4 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="#" class="text-2xl font-bold text-white flex items-center space-x-2">
                    <img src="../assets/images/image.png" alt="logo" class="w-10 h-10">
                    <span>OGGE TRAVEL</span>
                </a>


                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="../pages/index.php" class="nav-link text-gray-300 hover:text-white">Home</a>
                    <a href="../pages/Destination.php" class="nav-link text-gray-300 hover:text-white">Destinations</a>
                    <a href="../pages/package-1.php" class="nav-link text-gray-300 hover:text-white">Packages</a>
                    <a href="../pages/about.php" class="nav-link text-gray-300 hover:text-white">About</a>
                    <a href="../pages/contact.php" class="nav-link text-gray-300 hover:text-white">Contact</a>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Profile Dropdown -->
                        <div class="profile-dropdown">
                            <button class="flex items-center space-x-2 text-gray-300 hover:text-white">
                                <img src="../assets/images/profile.png" alt="Profile" class="w-8 h-8 rounded-full">
                                <span><?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'User'; ?></span>
                            </button>
                            <div class="profile-menu">
                                <a href="../pages/profile.php">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    My Profile
                                </a>
                                <a href="../pages/my-booking.php">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 4h-1V3a1 1 0 00-2 0v1H8V3a1 1 0 00-2 0v1H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2z"></path>
                                    </svg>
                                    My Bookings
                                </a>
                                <a href="../includes/logout.php" class="text-red-600">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Logout
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="../pages/Account.php" class="nav-link text-gray-300 hover:text-white">Login</a>
                    <?php endif; ?>
                </div>

                <!-- Mobile Menu Button -->
                <button id="menuBtn" class="md:hidden text-white focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>


            <!-- Mobile Menu -->
            <div id="mobileMenu" class="mobile-menu md:hidden mt-4 hidden">
                <div class="flex flex-col space-y-4">
                    <a href="../pages/index.php" class="text-gray-300 hover:text-white">Home</a>
                    <a href="../pages/Destination.php" class="text-gray-300 hover:text-white">Destinations</a>
                    <a href="../pages/package-1.php" class="text-gray-300 hover:text-white">Packages</a>
                    <a href="../pages/about.php" class="text-gray-300 hover:text-white">About</a>
                    <a href="../pages/contact.php" class="text-gray-300 hover:text-white">Contact</a>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="../pages/profile.php" class="text-gray-300 hover:text-white">My Profile</a>
                        <a href="../pages/my-booking.php" class="text-gray-300 hover:text-white">My Bookings</a>
                        <a href="../includes/logout.php" class="text-gray-300 hover:text-white">Logout</a>
                    <?php else: ?>
                        <a href="../pages/Account.php" class="text-gray-300 hover:text-white">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>
