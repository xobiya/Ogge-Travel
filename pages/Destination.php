<?php
session_start();
include("../includes/db-connect.php");
$result = $db->query("SELECT * FROM destinations ORDER BY name ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Atlas of Wonders | OGGE Travel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/luxury.css">
</head>
<body class="bg-[#faf8f5]" style="font-family:'Inter',sans-serif;">
    <?php include("../includes/header.php"); ?>

    <!-- Page Header -->
    <section class="relative h-[45vh] flex items-end overflow-hidden bg-[#0a0f1e]">
        <div class="absolute inset-0 bg-gradient-to-b from-[#0a0f1e]/60 to-[#0a0f1e]"></div>
        <div class="container mx-auto px-6 max-w-7xl relative z-10 pb-16">
            <span class="section-eyebrow">Explore Ethiopia — ኢትዮጵያን ያስሱ</span>
            <h1 class="text-5xl md:text-7xl text-white" style="font-family:'Playfair Display',serif; font-weight:800;">The Atlas of <span class="text-champagne-gradient">Wonders</span></h1>
            <p class="text-gray-400 mt-4 text-lg max-w-xl">Every destination is a doorway into millennia of culture, faith, and natural splendor.</p>
        </div>
    </section>

    <!-- Destinations Grid -->
    <section class="py-20">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" data-stagger>
                <?php while($dest = $result->fetch_assoc()): ?>
                <a href="destination-detail.php?id=<?= $dest['id'] ?>" class="editorial-card block reveal group">
                    <div class="relative h-72 overflow-hidden">
                        <img src="<?= htmlspecialchars($dest['image_url']) ?>" 
                             alt="<?= htmlspecialchars($dest['name']) ?>"
                             class="w-full h-full object-cover" loading="lazy"
                             onerror="this.src='../assets/images/default-dest.jpg'">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0a0f1e] via-[#0a0f1e]/20 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-8">
                            <h3 class="text-2xl text-white mb-1" style="font-family:'Playfair Display',serif; font-weight:700;"><?= htmlspecialchars($dest['name']) ?></h3>
                            <p class="text-gray-300 italic text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-500" style="font-family:'Cormorant Garamond',serif; font-size:1.05rem;">
                                <?= htmlspecialchars(substr($dest['description'], 0, 80)) ?>...
                            </p>
                        </div>
                    </div>
                </a>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <?php include("../includes/footer.php"); ?>
</body>
</html>
<?php $db->close(); ?>
