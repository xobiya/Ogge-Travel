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
    <link rel="stylesheet" href="../assets/css/style.css?v=1.2">
    <link rel="stylesheet" href="../assets/css/luxury.css?v=1.2">
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

    <!-- Packages -->
    <section class="py-24">
        <div class="container mx-auto px-6 max-w-6xl">
            <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="space-y-16">
                <?php $first = true; while($package = mysqli_fetch_assoc($result)): ?>
                <div class="bg-white rounded-[3rem] overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-700 border border-slate-100 reveal group">
                    <div class="grid md:grid-cols-5">
                        <div class="md:col-span-2 relative h-80 md:h-auto overflow-hidden">
                            <img src="<?= htmlspecialchars($package['image_url']) ?>" class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" loading="lazy">
                            <div class="absolute inset-0 bg-gradient-to-r from-black/20 to-transparent"></div>
                            <?php if($first): ?>
                            <div class="absolute top-6 left-6 bg-champagne text-slate-900 px-4 py-1.5 rounded-xl text-[0.6rem] font-black uppercase tracking-widest shadow-xl">Editor's Selection</div>
                            <?php $first = false; endif; ?>
                        </div>
                        <div class="md:col-span-3 p-10 lg:p-16 flex flex-col justify-center">
                            <div class="flex items-center gap-4 mb-4">
                                <span class="text-champagne text-[0.6rem] font-bold uppercase tracking-[0.3em]"><?= htmlspecialchars($package['destination_name']) ?></span>
                                <span class="w-8 h-px bg-slate-100"></span>
                                <span class="text-slate-400 text-[0.6rem] font-bold uppercase tracking-[0.2em]"><?= htmlspecialchars($package['duration']) ?></span>
                            </div>
                            <h3 class="text-3xl lg:text-4xl text-slate-800 mb-6" style="font-family:'Playfair Display',serif; font-weight:700;"><?= htmlspecialchars($package['title']) ?></h3>
                            <p class="text-slate-500 leading-relaxed mb-10 text-lg font-light"><?= htmlspecialchars($package['description']) ?></p>
                            <div class="flex items-center justify-between">
                                <div class="bg-slate-50 px-6 py-3 rounded-2xl">
                                    <p class="text-slate-400 text-[0.5rem] uppercase tracking-widest mb-1 font-bold">Starting At</p>
                                    <p class="text-2xl text-slate-800 font-black" style="font-family:'Playfair Display',serif;">ETB <?= number_format($package['price']) ?></p>
                                </div>
                                <a href="book.php?package_id=<?= $package['id'] ?>" class="px-8 py-4 bg-slate-900 text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-champagne hover:text-slate-900 transition-all shadow-lg hover:shadow-champagne/20 active:scale-95">
                                    Book Journey
                                </a>
                            </div>
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
                    <a href="packages.php" class="mt-8 inline-block text-champagne font-bold underline decoration-2 underline-offset-4">Reset Atlas</a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php include("../includes/footer.php"); ?>
</body>
</html>
