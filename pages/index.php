
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OGGE Travel | The Curated Escape</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/luxury.css">
    <script src="../assets/js/script.js"></script>
    <style>
        .lalibela-slideshow { position: absolute; inset: 0; }
        .lalibela-slide {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            animation: lalibelaFade 18s infinite;
        }
        .lalibela-slide.slide-1 { animation-delay: 0s; }
        .lalibela-slide.slide-2 { animation-delay: 6s; }
        .lalibela-slide.slide-3 { animation-delay: 12s; }

        @keyframes lalibelaFade {
            0% { opacity: 0; transform: scale(1); }
            5% { opacity: 1; transform: scale(1.03); }
            30% { opacity: 1; transform: scale(1.06); }
            40% { opacity: 0; transform: scale(1.06); }
            100% { opacity: 0; transform: scale(1); }
        }
    </style>
</head>
<body class="bg-gray-100">
<?php include("../includes/header.php");?>


    <!-- ============================================ -->
    <!-- CINEMATIC HERO SECTION -->
    <!-- ============================================ -->
    <section class="relative h-screen w-full overflow-hidden" id="home">
        <div class="absolute inset-0">
            <img src="../assets/images/ethiopianadventuretours_culture_2.jpg" 
                 alt="Ethiopia" 
                 class="w-full h-full object-cover animate-ken-burns opacity-90" loading="eager">
            <div class="absolute inset-0 bg-gradient-to-t from-[#0a0f1e] via-[#0a0f1e]/40 to-[#0a0f1e]/20"></div>
        </div>
    
        <!-- Content -->
        <div class="relative h-full flex flex-col justify-center pt-20">
            <div class="container mx-auto px-6 max-w-7xl relative z-10">
                <div class="max-w-4xl">
                    <span class="section-eyebrow reveal">The Land of Origins — የመነሻ ምድር</span>
                    <h1 class="text-4xl sm:text-5xl md:text-8xl text-white mb-6 leading-tight reveal" style="font-family:'Playfair Display',serif; font-weight:800;">
                        Discover the <span class="text-champagne-gradient">Cradle</span> of Humanity
                    </h1>
                    
                    <p class="text-xl md:text-2xl text-gray-300 mb-10 reveal" style="font-family:'Inter',sans-serif; max-w-2xl;">
                        A curated collection of extraordinary experiences across Ethiopia's ancient wonders and breathtaking landscapes.
                    </p>
    
                    <!-- Metrics -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-2xl mb-12 reveal">
                        <div class="border-l border-[#c9a96e]/30 pl-4">
                            <p class="text-3xl font-bold text-[#c9a96e]" style="font-family:'Playfair Display',serif;">9+</p>
                            <p class="text-xs text-gray-400 uppercase tracking-widest mt-1">UNESCO Sites</p>
                        </div>
                        <div class="border-l border-[#c9a96e]/30 pl-4">
                            <p class="text-3xl font-bold text-[#c9a96e]" style="font-family:'Playfair Display',serif;">80+</p>
                            <p class="text-xs text-gray-400 uppercase tracking-widest mt-1">Ethnic Groups</p>
                        </div>
                        <div class="border-l border-[#c9a96e]/30 pl-4">
                            <p class="text-3xl font-bold text-[#c9a96e]" style="font-family:'Playfair Display',serif;">3000+</p>
                            <p class="text-xs text-gray-400 uppercase tracking-widest mt-1">Years of History</p>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    
        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce z-10">
            <div class="w-6 h-10 rounded-full border-2 border-white/40 flex items-center justify-center">
                <div class="w-1 h-2 bg-white/60 rounded-full mt-1"></div>
            </div>
        </div>
    </section>

   

    <!-- ============================================ -->
    <!-- DESTINATION OF THE SEASON — Cinematic Spotlight -->
    <!-- ============================================ -->
    <section class="relative bg-[#0a0f1e] overflow-hidden">
        <div class="grid lg:grid-cols-2 min-h-[500px] md:min-h-[600px]">
            <div class="relative h-72 md:h-96 lg:h-auto overflow-hidden">
                <div class="lalibela-slideshow">
                    <img src="../assets/images/lalibela.jpg" alt="Lalibela" class="lalibela-slide slide-1" loading="lazy">
                    <img src="../assets/images/lalibela-3.jpg" alt="Lalibela" class="lalibela-slide slide-2" loading="lazy">
                    <img src="../assets/images/lalibela2.jfif" alt="Lalibela" class="lalibela-slide slide-3" loading="lazy">
                </div>
            </div>
            <div class="flex items-center p-10 lg:p-20 relative z-10">
                <div>
                    <span class="section-eyebrow reveal">Destination of the Season</span>
                    <h2 class="text-4xl lg:text-6xl text-white mb-8 leading-[1.1] reveal" style="font-family:'Playfair Display',serif; font-weight:800;">
                        This Season,<br>Discover <span class="text-champagne-gradient">Lalibela</span>
                    </h2>
                    <p class="text-gray-400 text-lg leading-relaxed mb-10 max-w-lg reveal" style="font-family:'Inter',sans-serif;">
                        Walk the corridors of rock-hewn churches carved eight centuries ago by hands that believed they were building a New Jerusalem. Lalibela doesn't belong to history — it <em style="font-family:'Cormorant Garamond',serif; font-size:1.2em;">is</em> history, still breathing.
                    </p>
                    <div class="flex flex-wrap gap-6 mb-10 reveal">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-[#c9a96e]" style="font-family:'Playfair Display',serif;">11</p>
                            <p class="text-xs text-gray-500 uppercase tracking-widest mt-1" style="font-family:'Inter',sans-serif;">Rock Churches</p>
                        </div>
                        <div class="w-px bg-white/10"></div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-[#c9a96e]" style="font-family:'Playfair Display',serif;">1978</p>
                            <p class="text-xs text-gray-500 uppercase tracking-widest mt-1" style="font-family:'Inter',sans-serif;">UNESCO Listed</p>
                        </div>
                        <div class="w-px bg-white/10"></div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-[#c9a96e]" style="font-family:'Playfair Display',serif;">2,500m</p>
                            <p class="text-xs text-gray-500 uppercase tracking-widest mt-1" style="font-family:'Inter',sans-serif;">Altitude</p>
                        </div>
                    </div>
                    <a href="destination-detail.php?id=8" class="btn-outline reveal">
                        Begin Your Pilgrimage
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================ -->
    <!-- WHERE HISTORY BREATHES — Editorial Destinations -->
    <!-- ============================================ -->
    <section class="bg-[#faf8f5] relative overflow-hidden" style="padding: clamp(5rem, 8vw, 8rem) 0;">
        <div class="container mx-auto px-6 max-w-7xl relative z-10">
            <div class="text-center mb-12 md:mb-20 reveal">
                <span class="section-eyebrow">Explore The Extraordinary</span>
                <h2 class="section-title text-3xl md:text-6xl mb-6">Where History <span class="text-champagne-gradient">Breathes</span></h2>
                <p class="text-gray-500 max-w-2xl mx-auto text-base md:text-lg" style="font-family:'Inter',sans-serif;">
                    Each destination is a chapter in Ethiopia's three-thousand-year story, waiting for you to turn the page.
                </p>
            </div>

            <!-- Magazine Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16" data-stagger>
                <!-- Lalibela — Feature Card -->
                <div class="editorial-card lg:row-span-2 reveal">
                    <a href="destination-detail.php?id=8" class="block relative h-full min-h-[500px] lg:min-h-full overflow-hidden">
                        <img src="../assets/images/lalibela.jpg" alt="Lalibela" class="absolute inset-0 w-full h-full object-cover" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0a0f1e] via-[#0a0f1e]/30 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-10">
                            <p class="text-[#c9a96e] text-xs font-semibold uppercase tracking-[0.2em] mb-3" style="font-family:'Inter',sans-serif;">UNESCO World Heritage</p>
                            <h3 class="text-3xl lg:text-4xl text-white mb-3" style="font-family:'Playfair Display',serif; font-weight:700;">Lalibela</h3>
                            <p class="text-gray-400 italic text-lg" style="font-family:'Cormorant Garamond',serif;">The 12th Century Rock-Hewn Churches</p>
                        </div>
                    </a>
                </div>

                <!-- Simien Mountains -->
                <div class="editorial-card reveal">
                    <a href="destination-detail.php?id=10" class="block relative h-72 overflow-hidden">
                        <img src="../assets/images/AdobeStock_178835854_Preview.jpeg" alt="Simien Mountains" class="absolute inset-0 w-full h-full object-cover" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0a0f1e] via-[#0a0f1e]/30 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-8">
                            <p class="text-[#c9a96e] text-xs font-semibold uppercase tracking-[0.2em] mb-2" style="font-family:'Inter',sans-serif;">Highland Trekking</p>
                            <h3 class="text-2xl text-white mb-1" style="font-family:'Playfair Display',serif; font-weight:700;">Simien Mountains</h3>
                            <p class="text-gray-400 italic" style="font-family:'Cormorant Garamond',serif;">Home of the Gelada Baboons</p>
                        </div>
                    </a>
                </div>

                <!-- Danakil -->
                <div class="editorial-card reveal">
                    <a href="destination-detail.php?id=11" class="block relative h-72 overflow-hidden">
                        <img src="../assets/images/OIP (1).jpg" alt="Danakil Depression" class="absolute inset-0 w-full h-full object-cover" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0a0f1e] via-[#0a0f1e]/30 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-8">
                            <p class="text-[#c9a96e] text-xs font-semibold uppercase tracking-[0.2em] mb-2" style="font-family:'Inter',sans-serif;">Geological Wonder</p>
                            <h3 class="text-2xl text-white mb-1" style="font-family:'Playfair Display',serif; font-weight:700;">Danakil Depression</h3>
                            <p class="text-gray-400 italic" style="font-family:'Cormorant Garamond',serif;">The Hottest Place on Earth</p>
                        </div>
                    </a>
                </div>

                <!-- Omo Valley -->
                <div class="editorial-card reveal">
                    <a href="destination-detail.php?id=12" class="block relative h-72 overflow-hidden">
                        <img src="../assets/images/omo-cultural.jpg" alt="Omo Valley" class="absolute inset-0 w-full h-full object-cover" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0a0f1e] via-[#0a0f1e]/30 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-8">
                            <p class="text-[#c9a96e] text-xs font-semibold uppercase tracking-[0.2em] mb-2" style="font-family:'Inter',sans-serif;">Cultural Immersion</p>
                            <h3 class="text-2xl text-white mb-1" style="font-family:'Playfair Display',serif; font-weight:700;">Omo Valley</h3>
                            <p class="text-gray-400 italic" style="font-family:'Cormorant Garamond',serif;">A living museum of humanity</p>
                        </div>
                    </a>
                </div>

                <!-- Gondar -->
                <div class="editorial-card reveal">
                    <a href="destination-detail.php?id=3" class="block relative h-72 overflow-hidden">
                        <img src="../assets/images/gonder.jpg" alt="Gondar" class="absolute inset-0 w-full h-full object-cover" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0a0f1e] via-[#0a0f1e]/30 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-8">
                            <p class="text-[#c9a96e] text-xs font-semibold uppercase tracking-[0.2em] mb-2" style="font-family:'Inter',sans-serif;">Royal Heritage</p>
                            <h3 class="text-2xl text-white mb-1" style="font-family:'Playfair Display',serif; font-weight:700;">Gondar</h3>
                            <p class="text-gray-400 italic" style="font-family:'Cormorant Garamond',serif;">The Camelot of Africa</p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="text-center reveal">
                <a href="Destination.php" class="btn-dark">
                    View All Destinations
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- ============================================ -->
    <!-- CURATED JOURNEYS — Horizontal Editorial Cards -->
    <!-- ============================================ -->
    <section class="bg-[#0a0f1e] relative overflow-hidden grain-overlay" style="padding: clamp(5rem, 8vw, 8rem) 0;">
        <div class="container mx-auto px-6 max-w-7xl relative z-10">
            <div class="text-center mb-20 reveal">
                <span class="section-eyebrow">Handcrafted Experiences</span>
                <h2 class="text-4xl md:text-6xl text-white mb-6" style="font-family:'Playfair Display',serif; font-weight:800;">Curated <span class="text-champagne-gradient">Journeys</span></h2>
                <p class="text-gray-500 max-w-2xl mx-auto text-lg" style="font-family:'Inter',sans-serif;">
                    Each itinerary is a narrative — designed not just to show you Ethiopia, but to let Ethiopia reveal itself to you.
                </p>
            </div>

            <div class="space-y-8">
                <!-- Journey 1: Historical Route -->
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl overflow-hidden hover:border-[#c9a96e]/20 transition-all duration-500 reveal">
                    <div class="grid md:grid-cols-5">
                        <div class="md:col-span-2 relative h-64 md:h-auto overflow-hidden">
                            <img src="../assets/images/AdobeStock_631464259_Preview.jpeg" alt="Historical Route" class="absolute inset-0 w-full h-full object-cover hover:scale-105 transition-transform duration-700" loading="lazy">
                        </div>
                        <div class="md:col-span-3 p-8 lg:p-12 flex flex-col justify-center">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="text-[#c9a96e] text-xs font-semibold uppercase tracking-[0.2em]" style="font-family:'Inter',sans-serif;">7 Days / 6 Nights</span>
                                <span class="w-1 h-1 rounded-full bg-[#c9a96e]/40"></span>
                                <span class="text-gray-500 text-xs font-semibold uppercase tracking-[0.2em]" style="font-family:'Inter',sans-serif;">Signature Journey</span>
                            </div>
                            <h3 class="text-2xl lg:text-3xl text-white mb-4" style="font-family:'Playfair Display',serif; font-weight:700;">Historical Route Journey</h3>
                            <p class="text-gray-400 leading-relaxed mb-6" style="font-family:'Inter',sans-serif;">
                                Traverse the ancient kingdoms of Axum, Gondar, and Lalibela — walking the same paths as emperors and pilgrims across millennia. Private sunrise access to the rock churches included.
                            </p>
                            <div class="flex items-end justify-between">
                                <div>
                                    <p class="text-gray-600 text-xs uppercase tracking-wider mb-1" style="font-family:'Inter',sans-serif;">From</p>
                                    <p class="text-2xl text-[#c9a96e]" style="font-family:'Playfair Display',serif; font-weight:700;">ETB 45,000</p>
                                </div>
                                <a href="book.php?package_id=15" class="btn-outline text-xs py-2.5 px-6">Request Itinerary →</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Journey 2: Simien Trek -->
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl overflow-hidden hover:border-[#c9a96e]/20 transition-all duration-500 reveal">
                    <div class="grid md:grid-cols-5">
                        <div class="md:col-span-2 relative h-64 md:h-auto overflow-hidden">
                            <img src="../assets/images/AdobeStock_250383512_Preview.jpeg" alt="Simien Trek" class="absolute inset-0 w-full h-full object-cover hover:scale-105 transition-transform duration-700" loading="lazy">
                        </div>
                        <div class="md:col-span-3 p-8 lg:p-12 flex flex-col justify-center">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="text-[#c9a96e] text-xs font-semibold uppercase tracking-[0.2em]" style="font-family:'Inter',sans-serif;">5 Days / 4 Nights</span>
                                <span class="w-1 h-1 rounded-full bg-[#c9a96e]/40"></span>
                                <span class="text-gray-500 text-xs font-semibold uppercase tracking-[0.2em]" style="font-family:'Inter',sans-serif;">Adventure</span>
                            </div>
                            <h3 class="text-2xl lg:text-3xl text-white mb-4" style="font-family:'Playfair Display',serif; font-weight:700;">Simien Mountains Trek</h3>
                            <p class="text-gray-400 leading-relaxed mb-6" style="font-family:'Inter',sans-serif;">
                                Trek through Africa's most dramatic mountain range at 4,533 meters. Camp under constellations, wake to Gelada baboons descending the cliffs, and summit Ras Dashen.
                            </p>
                            <div class="flex items-end justify-between">
                                <div>
                                    <p class="text-gray-600 text-xs uppercase tracking-wider mb-1" style="font-family:'Inter',sans-serif;">From</p>
                                    <p class="text-2xl text-[#c9a96e]" style="font-family:'Playfair Display',serif; font-weight:700;">ETB 32,000</p>
                                </div>
                                <a href="book.php?package_id=11" class="btn-outline text-xs py-2.5 px-6">Request Itinerary →</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Journey 3: Omo Valley -->
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl overflow-hidden hover:border-[#c9a96e]/20 transition-all duration-500 reveal">
                    <div class="grid md:grid-cols-5">
                        <div class="md:col-span-2 relative h-64 md:h-auto overflow-hidden">
                            <img src="../assets/images/omo-cultural.jpg" alt="Omo Valley" class="absolute inset-0 w-full h-full object-cover hover:scale-105 transition-transform duration-700" loading="lazy">
                        </div>
                        <div class="md:col-span-3 p-8 lg:p-12 flex flex-col justify-center">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="text-[#c9a96e] text-xs font-semibold uppercase tracking-[0.2em]" style="font-family:'Inter',sans-serif;">3 Days / 2 Nights</span>
                                <span class="w-1 h-1 rounded-full bg-[#c9a96e]/40"></span>
                                <span class="text-gray-500 text-xs font-semibold uppercase tracking-[0.2em]" style="font-family:'Inter',sans-serif;">Cultural</span>
                            </div>
                            <h3 class="text-2xl lg:text-3xl text-white mb-4" style="font-family:'Playfair Display',serif; font-weight:700;">Omo Valley Culture</h3>
                            <p class="text-gray-400 leading-relaxed mb-6" style="font-family:'Inter',sans-serif;">
                                Witness the Hamer bull-jumping ceremony, sit with Mursi elders, and discover body-painting traditions that have endured for 195,000 years in the cradle of humankind.
                            </p>
                            <div class="flex items-end justify-between">
                                <div>
                                    <p class="text-gray-600 text-xs uppercase tracking-wider mb-1" style="font-family:'Inter',sans-serif;">From</p>
                                    <p class="text-2xl text-[#c9a96e]" style="font-family:'Playfair Display',serif; font-weight:700;">ETB 28,000</p>
                                </div>
                                <a href="book.php?package_id=13" class="btn-outline text-xs py-2.5 px-6">Request Itinerary →</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-14 reveal">
                <a href="packages.php" class="btn-champagne">
                    Browse All Journeys
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- ============================================ -->
    <!-- THE LEGACY GALLERY — New Additions -->
    <!-- ============================================ -->
    <section class="bg-[#0a0f1e] py-24 relative overflow-hidden">
        <div class="container mx-auto px-6 max-w-7xl relative z-10">
            <div class="text-center mb-16 reveal">
                <span class="section-eyebrow">The Collective</span>
                <h2 class="text-4xl md:text-6xl text-white mb-6" style="font-family:'Playfair Display',serif; font-weight:800;">Visual <span class="text-champagne-gradient">Legacies</span></h2>
                <p class="text-gray-500 max-w-2xl mx-auto text-lg">A curated glimpse into the extraordinary moments captured by our private explorers.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="editorial-card h-[400px] reveal">
                    <img src="../assets/images/Ancient book.jpg" class="w-full h-full object-cover" loading="lazy">
                    <div class="absolute inset-0 bg-black/20 hover:bg-black/0 transition-colors"></div>
                    <div class="absolute bottom-6 left-6">
                        <p class="text-white text-xs font-bold uppercase tracking-widest">Ancient Chronicles</p>
                    </div>
                </div>
                <div class="editorial-card h-[400px] reveal">
                    <img src="../assets/images/Axum simien.jpg" class="w-full h-full object-cover" loading="lazy">
                    <div class="absolute inset-0 bg-black/20 hover:bg-black/0 transition-colors"></div>
                    <div class="absolute bottom-6 left-6">
                        <p class="text-white text-xs font-bold uppercase tracking-widest">Highland Spires</p>
                    </div>
                </div>
                <div class="editorial-card h-[400px] reveal">
                    <img src="../assets/images/Dallo deser.jpg" class="w-full h-full object-cover" loading="lazy">
                    <div class="absolute inset-0 bg-black/20 hover:bg-black/0 transition-colors"></div>
                    <div class="absolute bottom-6 left-6">
                        <p class="text-white text-xs font-bold uppercase tracking-widest">Alien Landscapes</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================ -->
    <!-- THE STORYTELLER — Testimonial Strip -->
    <!-- ============================================ -->
    <section class="bg-[#faf8f5] relative" style="padding: clamp(5rem, 8vw, 7rem) 0;">
        <div class="container mx-auto px-6 max-w-4xl text-center reveal">
            <div class="champagne-line-center"></div>
            <blockquote class="mt-10 mb-10">
                <p class="text-2xl md:text-4xl leading-relaxed text-[#0a0f1e]" style="font-family:'Cormorant Garamond',serif; font-style:italic; font-weight:400;">
                    "Ethiopia didn't just change my perspective — it rewrote my understanding of time. Standing in Lalibela, I realized these stones have witnessed eight centuries of prayer, and I was now part of that continuum."
                </p>
            </blockquote>
            <div class="flex items-center justify-center gap-4">
                <div class="w-12 h-12 bg-[#c9a96e]/20 rounded-full flex items-center justify-center text-[#c9a96e] font-bold" style="font-family:'Playfair Display',serif;">M</div>
                <div class="text-left">
                    <p class="font-semibold text-[#0a0f1e] text-sm" style="font-family:'Inter',sans-serif;">Maria Fernandez</p>
                    <p class="text-gray-500 text-xs" style="font-family:'Inter',sans-serif;">Barcelona, Spain — Historical Route, 2024</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include("../includes/footer.php");?>

    <script src="../assets/js/script.js"></script>
</body>
</html>
