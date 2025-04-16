<?php
session_start(); // Start session for user authentication
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | OGGE Travel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/custome.css">
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <?php include('../includes/header.php'); ?>

    <!-- About Us Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                    About OGGE Travel
                </h1>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Your Gateway to Ethiopia's Rich Heritage and Breathtaking Landscapes
                </p>
            </div>

            <!-- Mission and Vision -->
            <div class="grid md:grid-cols-2 gap-12 mb-16">
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Our Mission</h2>
                    <p class="text-gray-600 leading-relaxed">
                        At OGGE Travel, we are dedicated to providing unforgettable travel experiences that showcase the beauty, culture, and history of Ethiopia. Our mission is to connect travelers with the heart and soul of this incredible nation.
                    </p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Our Vision</h2>
                    <p class="text-gray-600 leading-relaxed">
                        We envision a world where everyone has the opportunity to explore Ethiopia's unique treasures, from the ancient rock-hewn churches of Lalibela to the stunning landscapes of the Simien Mountains.
                    </p>
                </div>
            </div>

            <!-- Why Choose Us -->
            <div class="bg-white rounded-lg shadow-md p-8 mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">
                    Why Choose OGGE Travel?
                </h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="bg-amber-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Local Expertise</h3>
                        <p class="text-gray-600">
                            Our team of local guides and experts ensures an authentic and immersive experience.
                        </p>
                    </div>
                    <div class="text-center">
                        <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Tailored Experiences</h3>
                        <p class="text-gray-600">
                            We customize every trip to match your interests, whether it's history, culture, or adventure.
                        </p>
                    </div>
                    <div class="text-center">
                        <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Sustainable Tourism</h3>
                        <p class="text-gray-600">
                            We are committed to preserving Ethiopia's natural and cultural heritage for future generations.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Ethiopia Highlights -->
            <div class="bg-gray-50 rounded-lg shadow-md p-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">
                    Discover Ethiopia
                </h2>
                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <img src="../assets/images/ethiopianadventuretours_history_3.jpg" 
                             alt="Ethiopia Highlights" 
                             class="w-full h-64 object-cover rounded-lg">
                    </div>
                    <div>
                        <p class="text-gray-600 leading-relaxed mb-4">
                            Ethiopia is a land of contrasts and wonders. From the ancient obelisks of Aksum to the vibrant markets of Addis Ababa, every corner of this country tells a story. Explore the rock-hewn churches of Lalibela, trek through the Simien Mountains, or witness the cultural diversity of the Omo Valley.
                        </p>
                        <a href="packages-1.php" 
                           class="inline-block bg-amber-600 text-white py-2 px-6 rounded-lg hover:bg-amber-700 transition-colors">
                            Explore Our Packages
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include('../includes/footer.php'); ?>
</body>
</html>