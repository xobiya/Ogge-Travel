<?php
session_start(); // Start session for user authentication
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Premium OGGE Travel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { font-family: 'Outfit', sans-serif; overflow-x: hidden; }
        .text-gradient {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px -5px rgba(0, 0, 0, 0.1);
            border-color: rgba(245, 158, 11, 0.3);
        }
        .blob {
            position: absolute;
            filter: blur(80px);
            z-index: -1;
            opacity: 0.4;
        }
    </style>
</head>
<body class="bg-slate-50 relative">
    <!-- Decorative Blobs -->
    <div class="blob bg-amber-300 w-96 h-96 rounded-full top-0 left-[-10%]"></div>
    <div class="blob bg-orange-300 w-96 h-96 rounded-full top-[40%] right-[-10%]"></div>

    <!-- Header -->
    <?php include('../includes/header.php'); ?>

    <!-- About Us Section -->
    <section class="py-20 relative">
        <div class="container mx-auto px-4 max-w-7xl">
            <!-- Section Header -->
            <div class="text-center mb-20">
                <span class="text-amber-600 font-bold tracking-wider uppercase text-sm mb-2 block">Discover Our Story</span>
                <h1 class="text-5xl md:text-7xl font-extrabold text-gray-900 mb-6 tracking-tight">
                    About <span class="text-gradient">OGGE</span> Travel
                </h1>
                <p class="text-gray-600 max-w-3xl mx-auto text-xl leading-relaxed">
                    Your luxury gateway to Ethiopia's rich heritage, breathless landscapes, and unforgettable adventures.
                </p>
            </div>

            <!-- Mission and Vision -->
            <div class="grid md:grid-cols-2 gap-10 mb-24">
                <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-lg p-10 border border-gray-100 card-hover relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-8 opacity-5 group-hover:opacity-10 transition-opacity">
                        <svg class="w-40 h-40 text-amber-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"></path></svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                        <span class="bg-amber-100 text-amber-600 p-4 rounded-2xl mr-4 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </span>
                        Our Mission
                    </h2>
                    <p class="text-gray-600 leading-relaxed text-lg relative z-10">
                        At OGGE Travel, we are dedicated to providing unforgettable travel experiences that showcase the beauty, culture, and history of Ethiopia. Our mission is to connect travelers with the heart and soul of this incredible nation through immersive, sustainable, and luxurious journeys.
                    </p>
                </div>
                <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-lg p-10 border border-gray-100 card-hover relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-8 opacity-5 group-hover:opacity-10 transition-opacity">
                        <svg class="w-40 h-40 text-amber-500" fill="currentColor" viewBox="0 0 24 24"><path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z"></path><path d="M2.45801 12C3.73228 7.94288 7.52257 5 12.0002 5C16.4778 5 20.2681 7.94291 21.5424 12C20.2681 16.0571 16.4778 19 12.0002 19C7.52256 19 3.73226 16.0571 2.45801 12Z"></path></svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                        <span class="bg-amber-100 text-amber-600 p-4 rounded-2xl mr-4 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </span>
                        Our Vision
                    </h2>
                    <p class="text-gray-600 leading-relaxed text-lg relative z-10">
                        We envision a world where everyone has the opportunity to explore Ethiopia's unique treasures. From the ancient rock-hewn churches of Lalibela to the stunning landscapes of the Simien Mountains, we aim to be the premier bridge between curious travelers and authentic Ethiopian wonders.
                    </p>
                </div>
            </div>

            <!-- Why Choose Us -->
            <div class="mb-24">
                <h2 class="text-4xl font-extrabold text-gray-900 mb-12 text-center">
                    Why Choose <span class="text-gradient">OGGE</span> Travel?
                </h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-white rounded-3xl p-10 shadow-sm hover:shadow-2xl transition-all duration-300 border border-gray-50 group">
                        <div class="bg-gradient-to-br from-amber-400 to-orange-500 rounded-2xl w-20 h-20 flex items-center justify-center mb-8 transform group-hover:-translate-y-3 transition-transform duration-300 shadow-lg mx-auto">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 text-center">Local Expertise</h3>
                        <p class="text-gray-600 leading-relaxed text-center">
                            Our seasoned team of local guides ensures a deeply authentic and immersive experience you won't find in guidebooks.
                        </p>
                    </div>
                    <!-- Feature 2 -->
                    <div class="bg-white rounded-3xl p-10 shadow-sm hover:shadow-2xl transition-all duration-300 border border-gray-50 group">
                        <div class="bg-gradient-to-br from-emerald-400 to-teal-500 rounded-2xl w-20 h-20 flex items-center justify-center mb-8 transform group-hover:-translate-y-3 transition-transform duration-300 shadow-lg mx-auto">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 text-center">Tailored Experiences</h3>
                        <p class="text-gray-600 leading-relaxed text-center">
                            We meticulously customize every journey to match your unique interests, blending history, culture, and pure adventure.
                        </p>
                    </div>
                    <!-- Feature 3 -->
                    <div class="bg-white rounded-3xl p-10 shadow-sm hover:shadow-2xl transition-all duration-300 border border-gray-50 group">
                        <div class="bg-gradient-to-br from-blue-400 to-indigo-500 rounded-2xl w-20 h-20 flex items-center justify-center mb-8 transform group-hover:-translate-y-3 transition-transform duration-300 shadow-lg mx-auto">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 text-center">Sustainable Tourism</h3>
                        <p class="text-gray-600 leading-relaxed text-center">
                            We are fiercely committed to preserving Ethiopia's natural and cultural heritage for generations to come.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Ethiopia Highlights -->
            <div class="bg-white rounded-[3rem] shadow-2xl overflow-hidden group">
                <div class="grid lg:grid-cols-2">
                    <div class="p-12 lg:p-20 flex flex-col justify-center">
                        <span class="text-amber-600 font-bold tracking-wider uppercase text-sm mb-4">The Land of Origins</span>
                        <h2 class="text-4xl lg:text-5xl font-extrabold text-gray-900 mb-6 leading-tight">
                            Experience the Magic of Ethiopia
                        </h2>
                        <p class="text-gray-600 leading-relaxed mb-10 text-lg">
                            Ethiopia is a land of contrasts and wonders. From the ancient obelisks of Aksum to the vibrant markets of Addis Ababa, every corner of this country tells a profound story. Let us guide you through the majestic rock-hewn churches of Lalibela, across the dramatic Simien Mountains, and into the cultural tapestry of the Omo Valley.
                        </p>
                        <div>
                            <a href="package-1.php" class="inline-flex items-center justify-center px-10 py-5 text-lg font-bold text-white transition-all duration-300 bg-gray-900 rounded-2xl hover:bg-amber-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 shadow-xl hover:shadow-2xl transform hover:-translate-y-2">
                                Explore Our Packages
                                <svg class="w-6 h-6 ml-3 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                    <div class="relative min-h-[400px] lg:h-auto overflow-hidden">
                        <img src="../assets/images/ethiopianadventuretours_history_3.jpg" 
                             alt="Ethiopia Highlights" 
                             class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-l from-transparent to-white/50 lg:to-white"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include('../includes/footer.php'); ?>
</body>
</html>