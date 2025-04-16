
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OGGE  Travel  | Explore the World</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/custome.css">
    <script src="../assets/js/script.js"></script>
</head>
<body class="bg-gray-100">
<?php include("../includes/header.php");?>


    <section class="relative h-screen" id="home">
        <div class="absolute inset-0">
            <img src="../assets/images/ethiopianadventuretours_culture_2.jpg" 
                 alt=" Ethiopia" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/40"></div>
        </div>
    
        <!-- Content -->
        <div class="relative h-full flex items-center pt-20">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl text-center md:text-left">
                    <!-- Ethiopian Cross Decoration -->
                    <div class="hidden md:block absolute top-24 right-24 opacity-20">
                        <svg class="w-32 h-32 text-amber-500" viewBox="0 0 100 100">
                            <path fill="currentColor" d="M50 10L60 30H40L50 10M50 90L40 70H60L50 90M90 50L70 60V40L90 50M10 50L30 40V60L10 50M50 30L60 50H40L50 30M50 70L40 50H60L50 70M30 50L50 40V60L30 50M70 50L50 60V40L70 50"/>
                        </svg>
                    </div>
    
                    <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 animate-fade-in-up">
                        Discover the Cradle of Humanity
                    </h1>
                    
                    <p class="text-xl md:text-2xl text-gray-200 mb-8 animate-fade-in-up delay-100">
                        Explore Ethiopia's Ancient Wonders, Breathtaking Landscapes & Rich Cultural Heritage
                    </p>
    
                   
                    <div class="grid grid-cols-3 gap-4 max-w-2xl mb-12 mx-auto animate-slide-up delay-200">
    <div class="text-center p-4 bg-white/10 backdrop-blur-sm rounded-lg">
        <p class="text-2xl font-bold text-amber-400" id="unesco-counter">9+</p>
        <p class="text-sm text-gray-200">UNESCO World Heritage Sites</p>
    </div>
    <div class="text-center p-4 bg-white/10 backdrop-blur-sm rounded-lg">
        <p class="text-2xl font-bold text-green-400" id="ethnic-counter">80+</p>
        <p class="text-sm text-gray-200">Ethnic Groups</p>
    </div>
    <div class="text-center p-4 bg-white/10 backdrop-blur-sm rounded-lg">
        <p class="text-2xl font-bold text-blue-400" id="history-counter">3000+</p>
        <p class="text-sm text-gray-200">Years of History</p>
    </div>
</div>
                    <!-- Search Bar -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-2">
    <input type="text" 
           id="searchInput"
           class="p-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500"
           placeholder="Search Ethiopian Destinations">
    <input type="date" 
           id="dateInput"
           class="p-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
    <select id="travelersInput"
            class="p-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
        <option>Travelers</option>
        <option>1 Person</option>
        <option>2-4 People</option>
        <option>5+ People</option>
    </select>
    <button onclick="searchPackages()" 
            class="bg-amber-600 text-white p-3 rounded-lg hover:bg-amber-700 transition-colors">
        Explore Ethiopia
    </button>
</div>
<div id="resultsContainer" class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8"></div>
                </div>
            </div>
        </div>
    
        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
            <div class="w-8 h-14 rounded-full border-2 border-white flex items-center justify-center">
                <div class="w-1 h-3 bg-white rounded-full mt-2"></div>
            </div>
        </div>
    </section>

   

    <!-- Popular Destinations Section -->
    <section class="py-16 bg-gradient-to-b from-amber-50 to-white">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    Explore Ethiopia's Treasures
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Discover our curated selection of unforgettable experiences in the land of origins
                </p>
            </div>
    
            <!-- Featured Destinations -->
            <div class="mb-20">
                <h3 class="text-2xl font-bold text-gray-800 mb-8 text-center">
                    Popular Destinations
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Lalibela Card -->
                    <div class="relative group overflow-hidden rounded-2xl shadow-lg hover:shadow-xl transition-shadow">
                        <img src="../assets/images/lalibela-3.jpg" 
                             alt="Lalibela Rock Churches" 
                             class="w-full h-64 object-cover transform group-hover:scale-105 transition-transform">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6">
                            <h4 class="text-xl font-bold text-white mb-2">Lalibela</h4>
                            <p class="text-gray-200 text-sm mb-4">The 13th Century Rock-Hewn Churches</p>
                            <div class="flex flex-wrap gap-2">
                                <span class="bg-amber-500/80 text-white px-3 py-1 rounded-full text-xs">UNESCO Site</span>
                                <span class="bg-green-500/80 text-white px-3 py-1 rounded-full text-xs">Historical</span>
                            </div>
                        </div>
                      
                    </div>
    
                    <!-- Simien Mountains Card -->
                    <div class="relative group overflow-hidden rounded-2xl shadow-lg hover:shadow-xl transition-shadow">
                        <img src="../assets/images/AdobeStock_178835854_Preview.jpeg" 
                             alt="Simien Mountains" 
                             class="w-full h-64 object-cover transform group-hover:scale-105 transition-transform">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6">
                            <h4 class="text-xl font-bold text-white mb-2">Simien Mountains</h4>
                            <p class="text-gray-200 text-sm mb-4">Home of the Gelada Baboons</p>
                            <div class="flex flex-wrap gap-2">
                                <span class="bg-green-500/80 text-white px-3 py-1 rounded-full text-xs">Trekking</span>
                                <span class="bg-blue-500/80 text-white px-3 py-1 rounded-full text-xs">Wildlife</span>
                            </div>
                        </div>
                    </div>
    
                    <!-- Danakil Depression Card -->
                    <div class="relative group overflow-hidden rounded-2xl shadow-lg hover:shadow-xl transition-shadow">
                        <img src="../assets/images/OIP (1).jpg" 
                             alt="Danakil Depression" 
                             class="w-full h-64 object-cover transform group-hover:scale-105 transition-transform">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6">
                            <h4 class="text-xl font-bold text-white mb-2">Danakil Depression</h4>
                            <p class="text-gray-200 text-sm mb-4">The Hottest Place on Earth</p>
                            <div class="flex flex-wrap gap-2">
                                <span class="bg-red-500/80 text-white px-3 py-1 rounded-full text-xs">Adventure</span>
                                <span class="bg-purple-500/80 text-white px-3 py-1 rounded-full text-xs">Geological Wonder</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Featured Packages -->
            <div class="pt-12">
                <h3 class="text-2xl font-bold text-gray-800 mb-8 text-center">
                    Recommended Packages
                </h3>
    
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Historical Tour Package -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="relative">
                            <img src="../assets/images/AdobeStock_631464259_Preview.jpeg" 
                                 alt="Historical Tour" 
                                 class="w-full h-48 object-cover">
                            <div class="absolute top-4 right-4 bg-amber-500 text-white px-3 py-1 rounded-full text-sm">
                                7 Days / 6 Nights
                            </div>
                        </div>
                        <div class="p-6">
                            <h4 class="text-xl font-bold text-gray-800 mb-2">Historical Route Journey</h4>
                            <p class="text-gray-600 text-sm mb-4">Axum, Gondar, Lalibela & Bahir Dar</p>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-2xl font-bold text-amber-600">ETB 45,000</span>
                                <span class="text-sm text-gray-500">per person</span>
                            </div>
                            <ul class="text-sm text-gray-600 space-y-2 mb-6">
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                                    </svg>
                                    All entrance fees included
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                                    </svg>
                                    Professional guide
                                </li>
                            </ul>
                            <a href="book.php?package_id=15" 
                                class="w-full bg-amber-500 text-white py-2 rounded-lg hover:bg-amber-600 transition-colors block text-center" onclick="openModal('15')">
                                Book Now
                             </a>
                        </div>
                    </div>

   
     <!-- Trekking Package -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="relative">
                            <img src="../assets/images/AdobeStock_250383512_Preview.jpeg" 
                                 alt="Simien Trekking" 
                                 class="w-full h-48 object-cover">
                            <div class="absolute top-4 right-4 bg-green-500 text-white px-3 py-1 rounded-full text-sm">
                                5 Days / 4 Nights
                            </div>
                        </div>
                        <div class="p-6">
                            <h4 class="text-xl font-bold text-gray-800 mb-2">Simien Mountains Trek</h4>
                            <p class="text-gray-600 text-sm mb-4">Including Ras Dashen Summit</p>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-2xl font-bold text-green-600">ETB 32,000</span>
                                <span class="text-sm text-gray-500">per person</span>
                            </div>
                            <ul class="text-sm text-gray-600 space-y-2 mb-6">
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                                    </svg>
                                    Camping equipment included
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                                    </svg>
                                    Park fees & permits
                                </li>
                            </ul>
                            <a href="book.php?package_id=11" 
                                class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600 transition-colors block text-center" onclick="openModal('11')">
                                Book Now
                             </a>
                        </div>
                    </div>
    
                    <!-- Cultural Experience -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="relative">
                            <img src="../assets/images/omo-cultural.jpg" 
                                 alt="Cultural Experience" 
                                 class="w-full h-48 object-cover">
                            <div class="absolute top-4 right-4 bg-blue-500 text-white px-3 py-1 rounded-full text-sm">
                                3 Days / 2 Nights
                            </div>
                        </div>
                        <div class="p-6">
                            <h4 class="text-xl font-bold text-gray-800 mb-2">Omo Valley Culture Tour</h4>
                            <p class="text-gray-600 text-sm mb-4">Tribal Communities Experience</p>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-2xl font-bold text-blue-600">ETB 28,000</span>
                                <span class="text-sm text-gray-500">per person</span>
                            </div>
                            <ul class="text-sm text-gray-600 space-y-2 mb-6">
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                                    </svg>
                                    Local guide included
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                                    </svg>
                                    Traditional meals
                                </li>
                            </ul>
                            <a href="book.php?package_id=13" 
                                class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition-colors block text-center" onclick="openModal('13')">
                                Book Now
                             </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-12">
                <h3 class="text-2xl font-bold text-gray-800 mb-8 text-center">
                    Southern Ethiopia Packages
                </h3>
    
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Rift Valley Explorer -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="relative">
                            <img src="../assets/images/arbaminch.jpg" 
                                 alt="Rift Valley Lakes" 
                                 class="w-full h-48 object-cover">
                            <div class="absolute top-4 right-4 bg-green-500 text-white px-3 py-1 rounded-full text-sm">
                                4 Days / 3 Nights
                            </div>
                        </div>
                        <div class="p-6">
                            <h4 class="text-xl font-bold text-gray-800 mb-2">Rift Valley Explorer</h4>
                            <p class="text-gray-600 text-sm mb-4">Arba Minch, Nechisar Park & Dorze Village</p>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-2xl font-bold text-green-600">ETB 35,000</span>
                                <span class="text-sm text-gray-500">per person</span>
                            </div>
                            <ul class="text-sm text-gray-600 space-y-2 mb-6">
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                                    </svg>
                                    Boat trip on Lake Chamo
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                                    </svg>
                                    Cultural experience with Gamo people
                                </li>
                            </ul>
                            </ul>
                            <a href="book.php?package_id=14" 
                                class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600 transition-colors block text-center" onclick="openModal('14')">
                                Book Now
                             </a>
                        </div>
                    </div>
    
                    <!-- Lakes Circuit Package -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="relative">
                            <img src="../assets/images/hawwasa.jpg" 
                                 alt="Hawassa Lake" 
                                 class="w-full h-48 object-cover">
                            <div class="absolute top-4 right-4 bg-blue-500 text-white px-3 py-1 rounded-full text-sm">
                                3 Days / 2 Nights
                            </div>
                        </div>
                        <div class="p-6">
                            <h4 class="text-xl font-bold text-gray-800 mb-2">Hawassa Lake Retreat</h4>
                            <p class="text-gray-600 text-sm mb-4">Fishing, Birding & Relaxation</p>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-2xl font-bold text-blue-600">ETB 25,000</span>
                                <span class="text-sm text-gray-500">per person</span>
                            </div>
                            <ul class="text-sm text-gray-600 space-y-2 mb-6">
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                                    </svg>
                                    Morning fish market visit
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                                    </svg>
                                    Boat ride on Lake Hawassa
                                </li>
                            </ul>
                            </ul>
                            </ul>
                            <a href="book.php?package_id=2" 
                                class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition-colors block text-center" onclick="openModal('2')">
                                Book Now
                             </a>
                        </div>
                    </div>
    
                    <!-- Cultural Immersion Package -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="relative">
                            <img src="../assets/images/arbaminch3.jpg" 
                                 alt="Gamo Culture" 
                                 class="w-full h-48 object-cover">
                            <div class="absolute top-4 right-4 bg-amber-500 text-white px-3 py-1 rounded-full text-sm">
                                5 Days / 4 Nights
                            </div>
                        </div>
                        <div class="p-6">
                            <h4 class="text-xl font-bold text-gray-800 mb-2">Gamo-Gofa Cultural Journey</h4>
                            <p class="text-gray-600 text-sm mb-4">Traditional Villages & Crafts</p>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-2xl font-bold text-amber-600">ETB 40,000</span>
                                <span class="text-sm text-gray-500">per person</span>
                            </div>
                            <ul class="text-sm text-gray-600 space-y-2 mb-6">
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                                    </svg>
                                    Visit to Chencha Village
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                                    </svg>
                                    Traditional weaving demonstration
                                </li>
                            </ul>
                            <a href="book.php?package_id=1" 
                                class="w-full bg-amber-500 text-white py-2 rounded-lg hover:bg-amber-600 transition-colors block text-center" onclick="openModal('1')">
                                Book Now
                             </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       


    </section>
    <!-- Footer -->
    <?php include("../includes/footer.php");?>

    <script src="../assets/js/script.js">    </script>
</body>
</html>
