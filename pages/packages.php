<?php
include("../includes/db-connect.php");
session_start();

$search = trim($_GET['search'] ?? '');
$query = "SELECT p.*, d.name as destination_name FROM packages p JOIN destinations d ON p.destination_id = d.id WHERE 1=1";
if (!empty($search)) {
    $search = mysqli_real_escape_string($db, $search);
    $query .= " AND (p.title LIKE '%$search%' OR p.description LIKE '%$search%' OR d.name LIKE '%$search%')";
}
$query .= " ORDER BY p.title ASC";
$result = mysqli_query($db, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curated Journeys | OGGE Travel</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=1.4">
    <link rel="stylesheet" href="../assets/css/luxury.css?v=1.4">
</head>
<body class="bg-[#faf8f5]" style="font-family:'Inter',sans-serif;">
    <?php include("../includes/header.php"); ?>

    <!-- Page Header -->
    <section class="relative h-[60vh] flex items-center overflow-hidden bg-[#0a0f1e]">
        <div class="absolute inset-0 bg-[url('../images/hero-luxury.png')] bg-cover bg-center opacity-20 scale-110 animate-ken-burns"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-[#0a0f1e]/80 via-[#0a0f1e]/90 to-[#0a0f1e]"></div>
        <div class="container mx-auto px-6 max-w-7xl relative z-10 text-center">
            <span class="section-eyebrow">Handcrafted Experiences</span>
            <h1 class="text-5xl md:text-8xl text-white mt-4" style="font-family:'Playfair Display',serif; font-weight:800;">Curated <span class="text-champagne-gradient italic">Journeys</span></h1>
            
            <div class="mt-12 max-w-2xl mx-auto">
                <form method="GET" class="relative group">
                    <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search itineraries or regions..." class="w-full bg-white/5 border border-white/10 rounded-2xl px-8 py-5 text-white focus:outline-none focus:border-[#c9a96e] transition-all backdrop-blur-sm text-center">
                    <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#c9a96e] hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Journeys Grid -->
    <section class="py-24 bg-[#faf8f5]">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-8">
                <div class="reveal">
                    <span class="text-champagne-gradient text-[10px] font-bold uppercase tracking-[0.4em] block mb-2">Our Collection</span>
                    <h2 class="text-4xl md:text-6xl text-navy-950" style="font-family:'Playfair Display',serif; font-weight:800;">Curated <span class="italic">Itineraries</span></h2>
                </div>
                <div class="flex items-center gap-6 reveal">
                    <div class="text-right">
                        <p class="text-navy-950 font-bold text-sm"><?= mysqli_num_rows($result) ?> Journeys Available</p>
                        <p class="text-gray-400 text-[10px] uppercase tracking-widest mt-1">Discover the heritage of Ethiopia</p>
                    </div>
                    <div class="h-12 w-px bg-gray-200"></div>
                    <button class="w-12 h-12 rounded-full border border-gray-200 flex items-center justify-center text-navy-950 hover:bg-navy-950 hover:text-white transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    </button>
                </div>
            </div>

            <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <?php while($package = mysqli_fetch_assoc($result)): ?>
                <div class="group bg-white rounded-[2.5rem] overflow-hidden border border-gray-100 transition-all duration-700 hover:shadow-[0_40px_80px_rgba(10,15,30,0.08)] hover:translate-y-[-10px] reveal">
                    <div class="relative h-[400px] overflow-hidden">
                        <img src="<?= htmlspecialchars($package['image_url']) ?>" class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0a0f1e]/80 via-transparent to-transparent"></div>
                        
                        <div class="absolute top-8 left-8">
                            <span class="bg-white/10 backdrop-blur-md border border-white/20 text-white px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-widest"><?= htmlspecialchars($package['duration']) ?></span>
                        </div>

                        <div class="absolute bottom-8 left-8 right-8">
                            <span class="text-[#c9a96e] text-[10px] font-bold uppercase tracking-[0.3em] block mb-2"><?= htmlspecialchars($package['destination_name']) ?></span>
                            <h3 class="text-3xl text-white mb-2" style="font-family:'Playfair Display',serif; font-weight:700;"><?= htmlspecialchars($package['title']) ?></h3>
                        </div>
                    </div>
                    
                    <div class="p-10">
                        <p class="text-gray-500 leading-relaxed mb-8 line-clamp-2 text-base font-light"><?= htmlspecialchars($package['description']) ?></p>
                        
                        <div class="flex items-center justify-between pt-8 border-t border-gray-50">
                            <div>
                                <p class="text-gray-400 text-[9px] uppercase tracking-widest mb-1 font-bold">Investment</p>
                                <div class="flex items-baseline gap-3">
                                    <span class="text-2xl text-navy-950 font-black" style="font-family:'Playfair Display',serif;">ETB <?= number_format($package['price']) ?></span>
                                    <span class="text-[11px] text-gray-400 font-medium">~$<?= number_format($package['price'] / 120, 0) ?> USD</span>
                                </div>
                            </div>
                            <a href="<?= BASE_URL ?>/booking?package_id=<?= $package['id'] ?>" 
                               class="h-14 px-10 rounded-2xl flex items-center justify-center transition-all hover:bg-[#c9a96e] active:scale-95 shadow-xl" 
                               style="background-color: #000 !important; color: #fff !important; font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.2em; min-width: 180px;">
                                <span style="color: #ffffff !important; opacity: 1 !important;">Book Journey</span>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            <?php else: ?>
                <div class="text-center py-24 bg-white rounded-[4rem] border border-slate-50 shadow-sm">
                    <div class="text-5xl mb-6">🏜️</div>
                    <h3 class="text-2xl font-bold text-slate-800" style="font-family:'Playfair Display'">No journeys match your search</h3>
                    <p class="text-slate-400 mt-2">Our concierge is mapping new routes every day. Try another term.</p>
                    <a href="<?= BASE_URL ?>/packages" class="mt-8 inline-block text-champagne font-bold underline decoration-2 underline-offset-4">Reset Atlas</a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php include("../includes/footer.php"); ?>
</body>
</html>
