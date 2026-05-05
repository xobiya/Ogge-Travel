<?php
session_start();
include("../includes/db-connect.php");

// Fetch destinations
$query = "SELECT * FROM destinations ORDER BY name ASC";
$result = mysqli_query($db, $query);
$destinations = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destinations | Premium OGGE Travel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { font-family: 'Outfit', sans-serif; overflow-x: hidden; }
        .text-gradient {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .dest-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.8);
        }
        .hover-lift { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .hover-lift:hover { transform: translateY(-12px); box-shadow: 0 30px 60px -15px rgba(0,0,0,0.15); }
    </style>
</head>
<body class="bg-slate-50 relative min-h-screen flex flex-col">
    <!-- Decorative background blobs -->
    <div class="absolute top-20 right-0 w-[600px] h-[600px] bg-amber-200 rounded-full blur-[120px] opacity-30 -z-10"></div>
    <div class="absolute top-[40%] left-[-10%] w-[500px] h-[500px] bg-blue-200 rounded-full blur-[120px] opacity-30 -z-10"></div>

    <!-- Header -->
    <?php include('../includes/header.php'); ?>

    <!-- Destinations Section -->
    <main class="flex-grow py-20 relative">
        <div class="container mx-auto px-4 max-w-7xl">
            <!-- Section Header -->
            <div class="text-center mb-20">
                <span class="text-amber-600 font-bold tracking-wider uppercase text-sm mb-3 block">Where Magic Happens</span>
                <h1 class="text-5xl md:text-7xl font-extrabold text-gray-900 mb-6 tracking-tight">
                    Iconic <span class="text-gradient">Destinations</span>
                </h1>
                <p class="text-gray-600 max-w-3xl mx-auto text-xl leading-relaxed">
                    Journey through the breathtaking landscapes, ancient kingdoms, and vibrant cultures of Ethiopia. Choose your next unforgettable adventure.
                </p>
            </div>

            <!-- Destinations Grid -->
            <?php if (empty($destinations)): ?>
                <div class="text-center py-20 bg-white rounded-3xl shadow-sm border border-gray-100">
                    <p class="text-gray-500 text-xl font-medium">No destinations found. Check back later!</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                    <?php foreach ($destinations as $dest): ?>
                        <div class="dest-card rounded-[2.5rem] overflow-hidden hover-lift group relative shadow-lg flex flex-col">
                            <div class="relative overflow-hidden h-72 w-full">
                                <img src="<?= htmlspecialchars($dest['image_url']) ?>" 
                                     alt="<?= htmlspecialchars($dest['name']) ?>" 
                                     class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110"
                                     onerror="this.src='../assets/images/default-dest.jpg'">
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/30 to-transparent"></div>
                                
                                <div class="absolute top-6 left-6 bg-white/20 backdrop-blur-md border border-white/30 text-white text-xs font-bold px-4 py-2 rounded-full z-10 shadow-lg flex items-center">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    Ethiopia
                                </div>
                                
                                <h2 class="absolute bottom-6 left-8 right-8 text-3xl font-extrabold text-white drop-shadow-lg leading-tight transform group-hover:-translate-y-2 transition-transform duration-300">
                                    <?= htmlspecialchars($dest['name']) ?>
                                </h2>
                            </div>
                            
                            <div class="p-8 flex flex-col flex-grow relative bg-white">
                                <!-- Abstract subtle decoration -->
                                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                                    <svg class="w-24 h-24 text-amber-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"></path></svg>
                                </div>
                                
                                <p class="text-gray-600 mb-8 leading-relaxed text-lg flex-grow relative z-10">
                                    <?= htmlspecialchars($dest['description']) ?>
                                </p>
                                
                                <div class="mt-auto relative z-10">
                                    <a href="destination-detail.php?id=<?= $dest['id'] ?>" 
                                       class="flex items-center justify-center w-full bg-gray-50 border-2 border-gray-100 text-gray-900 font-bold text-lg py-4 px-6 rounded-2xl hover:bg-gray-900 hover:text-white hover:border-gray-900 transition-all duration-300 group/btn shadow-sm">
                                        Discover Place
                                        <svg class="w-5 h-5 ml-2 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer -->
    <?php include('../includes/footer.php'); ?>
</body>
</html>
