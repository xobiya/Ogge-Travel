<?php
session_start();
define('OGGE_DB_OPTIONAL', true);
include("../includes/db-connect.php");

$q = trim($_GET['search'] ?? '');
$dbUnavailable = !($db instanceof mysqli);

$fallbackDestinations = [
    ['id' => 1, 'name' => 'Arba Minch', 'description' => 'Known for its breathtaking landscapes and the famous Nechisar National Park.', 'image_url' => '../assets/images/arbaminch.jpg'],
    ['id' => 2, 'name' => 'Hawassa', 'description' => 'A stunning lakeside city known for its vibrant fish market and natural beauty.', 'image_url' => '../assets/images/hawassa.jpg'],
    ['id' => 3, 'name' => 'Gonder', 'description' => 'Famous for its historical castles and being the Camelot of Africa.', 'image_url' => '../assets/images/gonder.jpg'],
    ['id' => 4, 'name' => 'Bahirdar', 'description' => 'A beautiful city near Lake Tana and the Blue Nile Falls.', 'image_url' => '../assets/images/bahirdar.jpg'],
    ['id' => 5, 'name' => 'Mekelle', 'description' => 'A cultural hub known for its historical significance and rock-hewn churches.', 'image_url' => '../assets/images/mekelle.jpg'],
    ['id' => 6, 'name' => 'Aksum', 'description' => 'An ancient city famous for its obelisks and ties to the Ark of the Covenant.', 'image_url' => '../assets/images/aksum.jpg'],
    ['id' => 7, 'name' => 'Harer', 'description' => 'A walled city known for its rich Islamic heritage and vibrant markets.', 'image_url' => '../assets/images/harer.jpg'],
    ['id' => 8, 'name' => 'Lalibela', 'description' => 'Home to the incredible rock-hewn churches and a UNESCO World Heritage site.', 'image_url' => '../assets/images/lalibela.jpg'],
    ['id' => 9, 'name' => 'Jimma', 'description' => 'Known as the birthplace of coffee and surrounded by lush green landscapes.', 'image_url' => '../assets/images/jimma.jpg'],
    ['id' => 10, 'name' => 'Simien Mountains', 'description' => 'Dramatic mountain landscape with unique wildlife.', 'image_url' => '../assets/images/simien.jpg'],
    ['id' => 11, 'name' => 'Danakil Depression', 'description' => 'One of the hottest places on Earth with alien landscapes.', 'image_url' => '../assets/images/danakil.jpg'],
    ['id' => 12, 'name' => 'Omo Valley', 'description' => 'Cultural hub of diverse ethnic communities.', 'image_url' => '../assets/images/omo.jpg'],
    ['id' => 13, 'name' => 'Axum', 'description' => 'Ancient city with historic obelisks.', 'image_url' => '../assets/images/aksum.jpg'],
    ['id' => 14, 'name' => 'Addis Ababa', 'description' => 'The vibrant capital city of Ethiopia, rich in history and culture.', 'image_url' => '../assets/images/Addis ababa.jpg'],
    ['id' => 17, 'name' => 'Tiya', 'description' => 'A UNESCO World Heritage Site with ancient stelae and archaeological significance.', 'image_url' => '../assets/images/tiya.jpg'],
    ['id' => 25, 'name' => 'Dire Dawa', 'description' => 'A vibrant city with a mix of modern and traditional Ethiopian culture.', 'image_url' => '../assets/images/dire.jpg'],
];

$destinations = [];
if (!$dbUnavailable) {
    try {
        if ($q !== '') {
            $term = '%' . $q . '%';
            $stmt = $db->prepare('SELECT * FROM destinations WHERE name LIKE ? OR description LIKE ? ORDER BY name ASC');
            $stmt->bind_param('ss', $term, $term);
        } else {
            $stmt = $db->prepare('SELECT * FROM destinations ORDER BY name ASC');
        }
        $stmt->execute();
        $destinations = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    } catch (Throwable $exception) {
        error_log('Destination query failed: ' . $exception->getMessage());
        $dbUnavailable = true;
    }
}

if ($dbUnavailable) {
    $destinations = array_values(array_filter($fallbackDestinations, function ($destination) use ($q) {
        if ($q === '') {
            return true;
        }

        return stripos($destination['name'], $q) !== false || stripos($destination['description'], $q) !== false;
    }));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Atlas of Wonders | OGGE Travel</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=1.2">
    <link rel="stylesheet" href="../assets/css/luxury.css?v=1.2">
</head>
<body class="bg-[#faf8f5]" style="font-family:'Inter',sans-serif;">
    <?php include("../includes/header.php"); ?>

    <!-- Page Header -->
    <section class="relative h-[60vh] flex items-center overflow-hidden bg-[#0a0f1e]">
        <div class="absolute inset-0 bg-[url('../images/hero-luxury.png')] bg-cover bg-center opacity-30 animate-ken-burns"></div>
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
            <?php if ($dbUnavailable): ?>
                <div class="mb-8 rounded-2xl border border-amber-200 bg-amber-50 px-6 py-4 text-sm text-amber-900">
                    Live database content is temporarily unavailable, so curated destination highlights are being shown. Please check the database credentials in <code>includes/config.php</code>.
                </div>
            <?php endif; ?>
            <?php if (count($destinations) > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                <?php foreach($destinations as $dest): ?>
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
                <?php endforeach; ?>
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
