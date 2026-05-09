<?php
session_start();
include("../includes/db-connect.php");

$q = trim($_GET['q'] ?? '');
$destinations = [];
$packages = [];

if ($q) {
    $search = "%$q%";
    
    // Search Destinations
    $stmt = $db->prepare("SELECT * FROM destinations WHERE name LIKE ? OR description LIKE ?");
    $stmt->bind_param("ss", $search, $search);
    $stmt->execute();
    $destinations = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Search Packages
    $stmt = $db->prepare("SELECT p.*, d.name as destination_name FROM packages p JOIN destinations d ON p.destination_id = d.id WHERE p.title LIKE ? OR p.description LIKE ? OR d.name LIKE ?");
    $stmt->bind_param("sss", $search, $search, $search);
    $stmt->execute();
    $packages = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

$page_title = $q ? "Search Results for '$q'" : "Discover Heritage";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/luxury.css">
</head>
<body class="bg-[#faf8f5]" style="font-family:'Inter',sans-serif;">
    <?php include("../includes/header.php"); ?>

    <section class="pt-32 pb-20 bg-[#0a0f1e] text-center">
        <div class="container mx-auto px-6">
            <span class="section-eyebrow">Search Intelligence</span>
            <h1 class="text-4xl md:text-6xl text-white mt-4" style="font-family:'Playfair Display',serif; font-weight:800;">
                <?= $q ? 'Results for <span class="text-champagne-gradient">"' . htmlspecialchars($q) . '"</span>' : 'Discover Your Next <span class="text-champagne-gradient">Escape</span>' ?>
            </h1>
            <?php if (!$q): ?>
            <div class="max-w-2xl mx-auto mt-8">
                <form method="GET" class="relative">
                    <input type="text" name="q" placeholder="Where do you wish to go?" class="w-full bg-white/5 border border-white/10 rounded-2xl px-8 py-5 text-white focus:outline-none focus:border-[#c9a96e] transition-all">
                    <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 bg-[#c9a96e] text-[#0a0f1e] px-6 py-2 rounded-xl font-bold">Search</button>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <div class="container mx-auto px-6 py-20 max-w-7xl">
        <?php if ($q && empty($destinations) && empty($packages)): ?>
            <div class="text-center py-20 bg-white rounded-[3rem] border border-slate-100 shadow-sm">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-800" style="font-family:'Playfair Display'">No matches found</h3>
                <p class="text-slate-400 mt-2">Try searching for broader terms like "Lalibela" or "Mountains".</p>
                <button onclick="toggleGlobalSearch()" class="mt-8 text-[#c9a96e] font-bold underline">Try another search</button>
            </div>
        <?php endif; ?>

        <?php if (!empty($destinations)): ?>
        <div class="mb-20">
            <h2 class="text-2xl text-slate-800 mb-8" style="font-family:'Playfair Display'; font-weight:800;">Destinations (<?= count($destinations) ?>)</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach($destinations as $dest): ?>
                <a href="destination-detail.php?id=<?= $dest['id'] ?>" class="group block bg-white rounded-[2rem] overflow-hidden shadow-md hover:shadow-xl transition-all border border-slate-100">
                    <div class="relative h-60">
                        <img src="<?= htmlspecialchars($dest['image_url']) ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0a0f1e]/80 via-transparent to-transparent"></div>
                        <div class="absolute bottom-6 left-6">
                            <h4 class="text-xl text-white font-bold" style="font-family:'Playfair Display'"><?= htmlspecialchars($dest['name']) ?></h4>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($packages)): ?>
        <div>
            <h2 class="text-2xl text-slate-800 mb-8" style="font-family:'Playfair Display'; font-weight:800;">Travel Packages (<?= count($packages) ?>)</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach($packages as $pkg): ?>
                <a href="book.php?package_id=<?= $pkg['id'] ?>" class="bg-white rounded-[2rem] overflow-hidden shadow-md hover:shadow-xl transition-all border border-slate-100 block">
                    <div class="h-56 relative">
                        <img src="<?= htmlspecialchars($pkg['image_url']) ?>" class="w-full h-full object-cover">
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-[10px] font-black uppercase text-slate-800 tracking-widest"><?= htmlspecialchars($pkg['duration']) ?></div>
                    </div>
                    <div class="p-8">
                        <p class="text-[0.6rem] font-bold text-[#c9a96e] uppercase tracking-widest mb-2"><?= htmlspecialchars($pkg['destination_name']) ?></p>
                        <h4 class="text-lg font-bold text-slate-800 mb-4" style="font-family:'Playfair Display'"><?= htmlspecialchars($pkg['title']) ?></h4>
                        <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                            <span class="text-lg font-black text-slate-800">ETB <?= number_format($pkg['price']) ?></span>
                            <span class="text-[#c9a96e] text-xs font-bold uppercase tracking-widest">Book Now →</span>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <?php include("../includes/footer.php"); ?>
</body>
</html>
