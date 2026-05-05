
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
    <section class="py-24 relative overflow-hidden bg-slate-50">
        <!-- Abstract background elements -->
        <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-amber-200/40 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/3 z-0 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-blue-200/40 rounded-full blur-[120px] translate-y-1/3 -translate-x-1/3 z-0 pointer-events-none"></div>

        <div class="container mx-auto px-4 max-w-7xl relative z-10">
            <!-- Section Header -->
            <div class="text-center mb-20">
                <span class="text-amber-600 font-extrabold tracking-widest uppercase text-sm mb-3 block">Discover The Extraordinary</span>
                <h2 class="text-4xl md:text-6xl font-extrabold text-gray-900 mb-6 tracking-tight">
                    Explore Ethiopia's <span class="bg-clip-text text-transparent bg-gradient-to-r from-amber-500 to-orange-600">Treasures</span>
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto text-xl leading-relaxed">
                    Immerse yourself in our curated selection of unforgettable experiences in the land of origins.
                </p>
            </div>
    
            <!-- Featured Destinations -->
            <div class="mb-28">
                <div class="flex items-center justify-between mb-10">
                    <h3 class="text-3xl font-extrabold text-gray-900 flex items-center">
                        <svg class="w-8 h-8 text-amber-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Popular Destinations
                    </h3>
                    <a href="Destination.php" class="hidden md:flex items-center text-amber-600 font-bold hover:text-amber-700 transition-colors group">
                        View All Destinations 
                        <svg class="w-5 h-5 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                    <!-- Lalibela Card -->
                    <div class="relative group overflow-hidden rounded-[2rem] shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 bg-white">
                        <div class="relative h-80 w-full overflow-hidden">
                            <img src="../assets/images/lalibela-3.jpg" 
                                 alt="Lalibela Rock Churches" 
                                 class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                            
                            <div class="absolute top-6 left-6 flex flex-col gap-2">
                                <span class="bg-white/20 backdrop-blur-md border border-white/30 text-white px-4 py-1.5 rounded-full text-xs font-bold shadow-lg">UNESCO Site</span>
                                <span class="bg-amber-500/80 backdrop-blur-md border border-amber-400/50 text-white px-4 py-1.5 rounded-full text-xs font-bold shadow-lg w-max">Historical</span>
                            </div>
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 p-8 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-500">
                            <h4 class="text-3xl font-extrabold text-white mb-2 drop-shadow-lg">Lalibela</h4>
                            <p class="text-gray-200 text-base font-medium opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">The 13th Century Rock-Hewn Churches</p>
                        </div>
                    </div>
    
                    <!-- Simien Mountains Card -->
                    <div class="relative group overflow-hidden rounded-[2rem] shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 bg-white">
                        <div class="relative h-80 w-full overflow-hidden">
                            <img src="../assets/images/AdobeStock_178835854_Preview.jpeg" 
                                 alt="Simien Mountains" 
                                 class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                            
                            <div class="absolute top-6 left-6 flex flex-col gap-2">
                                <span class="bg-green-500/80 backdrop-blur-md border border-green-400/50 text-white px-4 py-1.5 rounded-full text-xs font-bold shadow-lg">Trekking</span>
                                <span class="bg-white/20 backdrop-blur-md border border-white/30 text-white px-4 py-1.5 rounded-full text-xs font-bold shadow-lg w-max">Wildlife</span>
                            </div>
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 p-8 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-500">
                            <h4 class="text-3xl font-extrabold text-white mb-2 drop-shadow-lg">Simien Mountains</h4>
                            <p class="text-gray-200 text-base font-medium opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">Home of the Gelada Baboons</p>
                        </div>
                    </div>
    
                    <!-- Danakil Depression Card -->
                    <div class="relative group overflow-hidden rounded-[2rem] shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 bg-white">
                        <div class="relative h-80 w-full overflow-hidden">
                            <img src="../assets/images/OIP (1).jpg" 
                                 alt="Danakil Depression" 
                                 class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                            
                            <div class="absolute top-6 left-6 flex flex-col gap-2">
                                <span class="bg-red-500/80 backdrop-blur-md border border-red-400/50 text-white px-4 py-1.5 rounded-full text-xs font-bold shadow-lg">Adventure</span>
                                <span class="bg-white/20 backdrop-blur-md border border-white/30 text-white px-4 py-1.5 rounded-full text-xs font-bold shadow-lg w-max">Geological Wonder</span>
                            </div>
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 p-8 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-500">
                            <h4 class="text-3xl font-extrabold text-white mb-2 drop-shadow-lg">Danakil Depression</h4>
                            <p class="text-gray-200 text-base font-medium opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">The Hottest Place on Earth</p>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Featured Packages -->
            <div class="mb-28">
                <div class="flex items-center justify-between mb-10">
                    <h3 class="text-3xl font-extrabold text-gray-900 flex items-center">
                        <span class="bg-amber-100 p-2 rounded-xl mr-3">
                            <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                        </span>
                        Recommended Packages
                    </h3>
                    <a href="packages.php" class="hidden md:flex items-center text-amber-600 font-bold hover:text-amber-700 transition-colors group">
                        View All Packages 
                        <svg class="w-5 h-5 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
    
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                    <!-- Historical Tour Package -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-[2rem] shadow-lg border border-white/60 overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 group flex flex-col">
                        <div class="relative h-60 overflow-hidden">
                            <img src="../assets/images/AdobeStock_631464259_Preview.jpeg" 
                                 alt="Historical Tour" 
                                 class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent"></div>
                            <div class="absolute top-4 right-4 bg-white/20 backdrop-blur-md border border-white/30 text-white font-bold px-4 py-2 rounded-full text-sm flex items-center shadow-lg">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                7 Days / 6 Nights
                            </div>
                        </div>
                        <div class="p-8 flex flex-col flex-grow">
                            <h4 class="text-2xl font-extrabold text-gray-900 mb-2 group-hover:text-amber-600 transition-colors">Historical Route Journey</h4>
                            <p class="text-gray-500 font-medium mb-6">Axum, Gondar, Lalibela & Bahir Dar</p>
                            
                            <div class="flex items-end justify-between mb-8 pb-6 border-b border-gray-100">
                                <div>
                                    <span class="text-sm font-bold text-gray-400 uppercase tracking-wider block mb-1">Starting from</span>
                                    <span class="text-3xl font-black text-amber-500">ETB 45,000</span>
                                </div>
                            </div>
                            
                            <ul class="text-base text-gray-600 space-y-3 mb-8 flex-grow font-medium">
                                <li class="flex items-center">
                                    <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center mr-3 shrink-0">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    </div>
                                    All entrance fees included
                                </li>
                                <li class="flex items-center">
                                    <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center mr-3 shrink-0">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    </div>
                                    Professional local guide
                                </li>
                            </ul>
                            
                            <a href="book.php?package_id=15" class="w-full bg-gray-900 text-white font-bold text-lg py-4 rounded-xl hover:bg-amber-500 transition-colors block text-center shadow-lg hover:shadow-amber-500/30" onclick="openModal('15')">
                                Reserve Journey
                            </a>
                        </div>
                    </div>

                    <!-- Trekking Package -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-[2rem] shadow-lg border border-white/60 overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 group flex flex-col">
                        <div class="relative h-60 overflow-hidden">
                            <img src="../assets/images/AdobeStock_250383512_Preview.jpeg" 
                                 alt="Simien Trekking" 
                                 class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent"></div>
                            <div class="absolute top-4 right-4 bg-white/20 backdrop-blur-md border border-white/30 text-white font-bold px-4 py-2 rounded-full text-sm flex items-center shadow-lg">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                5 Days / 4 Nights
                            </div>
                        </div>
                        <div class="p-8 flex flex-col flex-grow">
                            <h4 class="text-2xl font-extrabold text-gray-900 mb-2 group-hover:text-green-600 transition-colors">Simien Mountains Trek</h4>
                            <p class="text-gray-500 font-medium mb-6">Including Ras Dashen Summit</p>
                            
                            <div class="flex items-end justify-between mb-8 pb-6 border-b border-gray-100">
                                <div>
                                    <span class="text-sm font-bold text-gray-400 uppercase tracking-wider block mb-1">Starting from</span>
                                    <span class="text-3xl font-black text-green-500">ETB 32,000</span>
                                </div>
                            </div>
                            
                            <ul class="text-base text-gray-600 space-y-3 mb-8 flex-grow font-medium">
                                <li class="flex items-center">
                                    <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center mr-3 shrink-0">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    </div>
                                    Camping equipment included
                                </li>
                                <li class="flex items-center">
                                    <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center mr-3 shrink-0">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    </div>
                                    Park fees & permits
                                </li>
                            </ul>
                            
                            <a href="book.php?package_id=11" class="w-full bg-gray-900 text-white font-bold text-lg py-4 rounded-xl hover:bg-green-500 transition-colors block text-center shadow-lg hover:shadow-green-500/30" onclick="openModal('11')">
                                Reserve Journey
                            </a>
                        </div>
                    </div>
    
                    <!-- Cultural Experience -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-[2rem] shadow-lg border border-white/60 overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 group flex flex-col">
                        <div class="relative h-60 overflow-hidden">
                            <img src="../assets/images/omo-cultural.jpg" 
                                 alt="Cultural Experience" 
                                 class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent"></div>
                            <div class="absolute top-4 right-4 bg-white/20 backdrop-blur-md border border-white/30 text-white font-bold px-4 py-2 rounded-full text-sm flex items-center shadow-lg">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                3 Days / 2 Nights
                            </div>
                        </div>
                        <div class="p-8 flex flex-col flex-grow">
                            <h4 class="text-2xl font-extrabold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">Omo Valley Culture</h4>
                            <p class="text-gray-500 font-medium mb-6">Tribal Communities Experience</p>
                            
                            <div class="flex items-end justify-between mb-8 pb-6 border-b border-gray-100">
                                <div>
                                    <span class="text-sm font-bold text-gray-400 uppercase tracking-wider block mb-1">Starting from</span>
                                    <span class="text-3xl font-black text-blue-500">ETB 28,000</span>
                                </div>
                            </div>
                            
                            <ul class="text-base text-gray-600 space-y-3 mb-8 flex-grow font-medium">
                                <li class="flex items-center">
                                    <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center mr-3 shrink-0">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    </div>
                                    Local guide included
                                </li>
                                <li class="flex items-center">
                                    <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center mr-3 shrink-0">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    </div>
                                    Traditional meals
                                </li>
                            </ul>
                            
                            <a href="book.php?package_id=13" class="w-full bg-gray-900 text-white font-bold text-lg py-4 rounded-xl hover:bg-blue-500 transition-colors block text-center shadow-lg hover:shadow-blue-500/30" onclick="openModal('13')">
                                Reserve Journey
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Southern Ethiopia Section -->
            <div>
                <div class="flex items-center justify-between mb-10">
                    <h3 class="text-3xl font-extrabold text-gray-900 flex items-center">
                        <span class="bg-blue-100 p-2 rounded-xl mr-3">
                            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </span>
                        Southern Wonders
                    </h3>
                </div>
    
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                    <!-- Rift Valley Explorer -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-[2rem] shadow-lg border border-white/60 overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 group flex flex-col">
                        <div class="relative h-60 overflow-hidden">
                            <img src="../assets/images/arbaminch.jpg" 
                                 alt="Rift Valley Lakes" 
                                 class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent"></div>
                            <div class="absolute top-4 right-4 bg-white/20 backdrop-blur-md border border-white/30 text-white font-bold px-4 py-2 rounded-full text-sm flex items-center shadow-lg">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                4 Days / 3 Nights
                            </div>
                        </div>
                        <div class="p-8 flex flex-col flex-grow">
                            <h4 class="text-2xl font-extrabold text-gray-900 mb-2 group-hover:text-green-600 transition-colors">Rift Valley Explorer</h4>
                            <p class="text-gray-500 font-medium mb-6">Arba Minch, Nechisar & Dorze Village</p>
                            
                            <div class="flex items-end justify-between mb-8 pb-6 border-b border-gray-100">
                                <div>
                                    <span class="text-sm font-bold text-gray-400 uppercase tracking-wider block mb-1">Starting from</span>
                                    <span class="text-3xl font-black text-green-500">ETB 35,000</span>
                                </div>
                            </div>
                            
                            <ul class="text-base text-gray-600 space-y-3 mb-8 flex-grow font-medium">
                                <li class="flex items-center">
                                    <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center mr-3 shrink-0">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    </div>
                                    Boat trip on Lake Chamo
                                </li>
                                <li class="flex items-center">
                                    <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center mr-3 shrink-0">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    </div>
                                    Cultural experience with Gamo
                                </li>
                            </ul>
                            
                            <a href="book.php?package_id=14" class="w-full bg-gray-900 text-white font-bold text-lg py-4 rounded-xl hover:bg-green-500 transition-colors block text-center shadow-lg hover:shadow-green-500/30" onclick="openModal('14')">
                                Reserve Journey
                            </a>
                        </div>
                    </div>
    
                    <!-- Lakes Circuit Package -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-[2rem] shadow-lg border border-white/60 overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 group flex flex-col">
                        <div class="relative h-60 overflow-hidden">
                            <img src="../assets/images/hawwasa.jpg" 
                                 alt="Hawassa Lake" 
                                 class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent"></div>
                            <div class="absolute top-4 right-4 bg-white/20 backdrop-blur-md border border-white/30 text-white font-bold px-4 py-2 rounded-full text-sm flex items-center shadow-lg">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                3 Days / 2 Nights
                            </div>
                        </div>
                        <div class="p-8 flex flex-col flex-grow">
                            <h4 class="text-2xl font-extrabold text-gray-900 mb-2 group-hover:text-cyan-600 transition-colors">Hawassa Lake Retreat</h4>
                            <p class="text-gray-500 font-medium mb-6">Fishing, Birding & Relaxation</p>
                            
                            <div class="flex items-end justify-between mb-8 pb-6 border-b border-gray-100">
                                <div>
                                    <span class="text-sm font-bold text-gray-400 uppercase tracking-wider block mb-1">Starting from</span>
                                    <span class="text-3xl font-black text-cyan-500">ETB 25,000</span>
                                </div>
                            </div>
                            
                            <ul class="text-base text-gray-600 space-y-3 mb-8 flex-grow font-medium">
                                <li class="flex items-center">
                                    <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center mr-3 shrink-0">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    </div>
                                    Morning fish market visit
                                </li>
                                <li class="flex items-center">
                                    <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center mr-3 shrink-0">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    </div>
                                    Boat ride on Lake Hawassa
                                </li>
                            </ul>
                            
                            <a href="book.php?package_id=2" class="w-full bg-gray-900 text-white font-bold text-lg py-4 rounded-xl hover:bg-cyan-500 transition-colors block text-center shadow-lg hover:shadow-cyan-500/30" onclick="openModal('2')">
                                Reserve Journey
                            </a>
                        </div>
                    </div>
    
                    <!-- Cultural Immersion Package -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-[2rem] shadow-lg border border-white/60 overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 group flex flex-col">
                        <div class="relative h-60 overflow-hidden">
                            <img src="../assets/images/arbaminch3.jpg" 
                                 alt="Gamo Culture" 
                                 class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent"></div>
                            <div class="absolute top-4 right-4 bg-white/20 backdrop-blur-md border border-white/30 text-white font-bold px-4 py-2 rounded-full text-sm flex items-center shadow-lg">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                5 Days / 4 Nights
                            </div>
                        </div>
                        <div class="p-8 flex flex-col flex-grow">
                            <h4 class="text-2xl font-extrabold text-gray-900 mb-2 group-hover:text-amber-600 transition-colors">Gamo-Gofa Cultural</h4>
                            <p class="text-gray-500 font-medium mb-6">Traditional Villages & Crafts</p>
                            
                            <div class="flex items-end justify-between mb-8 pb-6 border-b border-gray-100">
                                <div>
                                    <span class="text-sm font-bold text-gray-400 uppercase tracking-wider block mb-1">Starting from</span>
                                    <span class="text-3xl font-black text-amber-500">ETB 40,000</span>
                                </div>
                            </div>
                            
                            <ul class="text-base text-gray-600 space-y-3 mb-8 flex-grow font-medium">
                                <li class="flex items-center">
                                    <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center mr-3 shrink-0">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    </div>
                                    Visit to Chencha Village
                                </li>
                                <li class="flex items-center">
                                    <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center mr-3 shrink-0">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    </div>
                                    Traditional weaving demo
                                </li>
                            </ul>
                            
                            <a href="book.php?package_id=1" class="w-full bg-gray-900 text-white font-bold text-lg py-4 rounded-xl hover:bg-amber-500 transition-colors block text-center shadow-lg hover:shadow-amber-500/30" onclick="openModal('1')">
                                Reserve Journey
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
