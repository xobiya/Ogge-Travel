<?php
session_start();
include("../includes/db-connect.php");
$q = trim($_GET['search'] ?? '');
$where = $q ? "WHERE name LIKE '%" . $db->real_escape_string($q) . "%' OR description LIKE '%" . $db->real_escape_string($q) . "%'" : "";
$result = $db->query("SELECT * FROM destinations $where ORDER BY name ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Atlas of Wonders | OGGE Travel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/luxury.css">
</head>
<body class="bg-[#faf8f5]" style="font-family:'Inter',sans-serif;">
    <?php include("../includes/header.php"); ?>

    <!-- Page Header -->
    <section class="relative h-[60vh] flex items-center overflow-hidden bg-[#0a0f1e]">
        <div class="absolute inset-0 bg-[url('../assets/images/hero-luxury.png')] bg-cover bg-center opacity-30 animate-ken-burns"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-[#0a0f1e] via-[#0a0f1e]/80 to-transparent"></div>
        <div class="container mx-auto px-6 max-w-7xl relative z-10">
            <span class="section-eyebrow">Explore Ethiopia — ኢትዮጵያን ያስሱ</span>
            <h1 class="text-5xl md:text-8xl text-white mt-4" style="font-family:'Playfair Display',serif; font-weight:800;">The Atlas of <br><span class="text-champagne-gradient italic">Wonders</span></h1>
            
            <!-- Search Bar -->
            <div class="mt-12 max-w-2xl">
                <form method="GET" class="relative group">
                    <input type="text" name="search" value="<?= htmlspecialchars($q) ?>" placeholder="Search destinations..." class="w-full bg-white/5 border border-white/10 rounded-2xl px-8 py-5 text-white focus:outline-none focus:border-[#c9a96e] transition-all backdrop-blur-sm">
                    <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 bg-[#c9a96e] text-[#0a0f1e] px-6 py-2 rounded-xl font-bold uppercase text-[10px] tracking-widest hover:bg-[#b8985d] transition-colors">Find</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Destinations Grid -->
    <section class="py-24 relative overflow-hidden">
        <div class="container mx-auto px-6 max-w-7xl">
            <?php if ($result->num_rows > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                <?php while($dest = $result->fetch_assoc()): ?>
                <a href="destination-detail.php?id=<?= $dest['id'] ?>" class="group block bg-white rounded-[3rem] overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 border border-slate-100 reveal">
                    <div class="relative h-96 overflow-hidden">
                        <img src="<?= htmlspecialchars($dest['image_url']) ?>" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0a0f1e] via-transparent to-transparent opacity-60"></div>
                        <div class="absolute bottom-8 left-8 right-8">
                            <span class="text-[#c9a96e] text-[0.6rem] font-bold uppercase tracking-[0.3em] mb-2 block">Heritage Site</span>
                            <h3 class="text-3xl text-white font-bold mb-4" style="font-family:'Playfair Display'"><?= htmlspecialchars($dest['name']) ?></h3>
                            <div class="champagne-line w-0 group-hover:w-full transition-all duration-500"></div>
                        </div>
                    </div>
                </a>
                <?php endwhile; ?>
            </div>
            <?php else: ?>
                <div class="text-center py-20">
                    <p class="text-slate-400">No destinations found for "<?= htmlspecialchars($q) ?>"</p>
                    <a href="Destination.php" class="text-[#c9a96e] font-bold underline mt-4 inline-block">Clear Search</a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php include("../includes/footer.php"); ?>
</body>
</html>
