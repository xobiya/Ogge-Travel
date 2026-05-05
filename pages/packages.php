<?php
include("../includes/db-connect.php");
session_start();

$search = $_GET['search'] ?? '';
$query = "SELECT * FROM packages WHERE 1=1";
if (!empty($search)) {
    $search = mysqli_real_escape_string($db, $search);
    $query .= " AND (title LIKE '%$search%' OR description LIKE '%$search%')";
}
$result = mysqli_query($db, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curated Journeys | OGGE Travel</title>
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
            <span class="section-eyebrow">Handcrafted Experiences</span>
            <h1 class="text-5xl md:text-7xl text-white" style="font-family:'Playfair Display',serif; font-weight:800;">Curated <span class="text-champagne-gradient">Journeys</span></h1>
            <p class="text-gray-400 mt-4 text-lg max-w-xl">Each itinerary is a narrative — designed not just to show you Ethiopia, but to let Ethiopia reveal itself to you.</p>
        </div>
    </section>

    <!-- Packages -->
    <section class="py-20">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="space-y-8">
                <?php $first = true; while($package = mysqli_fetch_assoc($result)): ?>
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 reveal">
                    <div class="grid md:grid-cols-5">
                        <div class="md:col-span-2 relative h-64 md:h-auto overflow-hidden">
                            <img src="<?= htmlspecialchars($package['image_url']) ?>" 
                                 alt="<?= htmlspecialchars($package['title']) ?>"
                                 class="absolute inset-0 w-full h-full object-cover hover:scale-105 transition-transform duration-700" loading="lazy">
                            <?php if($first): ?>
                            <div class="absolute top-4 left-4 bg-[#c9a96e] text-[#0a0f1e] px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider">Concierge Pick</div>
                            <?php $first = false; endif; ?>
                        </div>
                        <div class="md:col-span-3 p-8 lg:p-12 flex flex-col justify-center">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="text-[#c9a96e] text-xs font-semibold uppercase tracking-[0.2em]"><?= htmlspecialchars($package['duration']) ?></span>
                            </div>
                            <h3 class="text-2xl lg:text-3xl text-[#0a0f1e] mb-4" style="font-family:'Playfair Display',serif; font-weight:700;"><?= htmlspecialchars($package['title']) ?></h3>
                            <p class="text-gray-500 leading-relaxed mb-8"><?= htmlspecialchars($package['description']) ?></p>
                            <div class="flex items-end justify-between">
                                <div>
                                    <p class="text-gray-400 text-xs uppercase tracking-wider mb-1">From</p>
                                    <p class="text-2xl text-[#c9a96e]" style="font-family:'Playfair Display',serif; font-weight:700;">ETB <?= number_format($package['price']) ?></p>
                                </div>
                                <a href="book.php?package_id=<?= $package['id'] ?>" class="btn-dark text-xs py-3 px-6">
                                    Request Itinerary
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <?php include("../includes/footer.php"); ?>
</body>
</html>
<?php mysqli_close($db); ?>