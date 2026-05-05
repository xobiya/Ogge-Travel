<?php
session_start();
include("../includes/db-connect.php");
include("../includes/heritage-data.php");

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) { header("Location: Destination.php"); exit(); }

$stmt = $db->prepare("SELECT * FROM destinations WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$destination = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$destination) { header("Location: Destination.php"); exit(); }

// Fetch heritage data
$h = $heritage[$destination['name']] ?? null;

// Fetch related packages
$pkg_stmt = $db->prepare("SELECT * FROM packages WHERE title LIKE ? OR description LIKE ? LIMIT 3");
$search_term = '%' . $destination['name'] . '%';
$pkg_stmt->bind_param("ss", $search_term, $search_term);
$pkg_stmt->execute();
$packages = $pkg_stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$pkg_stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($destination['name']) ?> — The Heritage Suite | OGGE Travel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/luxury.css">
</head>
<body class="bg-[#faf8f5] min-h-screen" style="font-family:'Inter',sans-serif;">

    <?php include('../includes/header.php'); ?>

    <!-- ===== CINEMATIC HERO ===== -->
    <section class="relative h-[80vh] w-full overflow-hidden">
        <img src="<?= htmlspecialchars($destination['image_url']) ?>" alt="<?= htmlspecialchars($destination['name']) ?>" class="absolute inset-0 w-full h-full object-cover animate-ken-burns" loading="eager">
        <div class="absolute inset-0 bg-gradient-to-t from-[#0a0f1e] via-[#0a0f1e]/40 to-[#0a0f1e]/20"></div>
        <div class="absolute bottom-0 left-0 w-full pb-20 relative z-10">
            <div class="container mx-auto px-6 max-w-5xl">
                <?php if ($h): ?>
                    <p class="text-[#c9a96e] text-sm font-semibold uppercase tracking-[0.25em] mb-4" style="font-family:'Inter',sans-serif;"><?= htmlspecialchars($h['tagline']) ?></p>
                <?php endif; ?>
                <h1 class="text-6xl md:text-9xl text-white leading-none" style="font-family:'Playfair Display',serif; font-weight:800;"><?= htmlspecialchars($destination['name']) ?></h1>
                <?php if ($h && !empty($h['facts'])): ?>
                <div class="flex flex-wrap gap-8 mt-8">
                    <?php foreach($h['facts'] as $key => $val): ?>
                        <div>
                            <p class="text-[#c9a96e] text-xs font-bold uppercase tracking-[0.2em]"><?= ucfirst(str_replace('_', ' ', $key)) ?></p>
                            <p class="text-white text-lg font-medium mt-1" style="font-family:'Playfair Display',serif;"><?= htmlspecialchars($val) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- Scroll indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce z-10">
            <div class="w-6 h-10 rounded-full border-2 border-white/40 flex items-center justify-center">
                <div class="w-1 h-2 bg-white/60 rounded-full mt-1"></div>
            </div>
        </div>
    </section>

    <!-- ===== OVERVIEW BLOCK ===== -->
    <section class="relative z-20 -mt-20">
        <div class="container mx-auto px-6 max-w-5xl">
            <div class="bg-white rounded-[2rem] shadow-2xl p-10 md:p-16 border border-gray-100">
                <div class="grid md:grid-cols-5 gap-12">
                    <div class="md:col-span-3">
                        <span class="section-eyebrow">About This Destination</span>
                        <div class="champagne-line mt-4 mb-8"></div>
                        <p class="text-gray-600 text-lg leading-relaxed" style="font-family:'Inter',sans-serif;">
                            <?= nl2br(htmlspecialchars($destination['description'])) ?>
                        </p>
                    </div>
                    <?php if ($h && !empty($h['facts'])): ?>
                    <div class="md:col-span-2 bg-[#faf8f5] rounded-2xl p-8 border border-[#e2ddd5]">
                        <h3 class="text-lg mb-6 text-[#0a0f1e]" style="font-family:'Playfair Display',serif; font-weight:700;">Quick Facts</h3>
                        <dl class="space-y-4">
                            <?php foreach($h['facts'] as $key => $val): ?>
                            <div class="flex justify-between items-center pb-3 border-b border-[#e2ddd5]">
                                <dt class="text-xs font-bold text-gray-400 uppercase tracking-wider"><?= ucfirst(str_replace('_', ' ', $key)) ?></dt>
                                <dd class="text-sm font-semibold text-[#0a0f1e]"><?= htmlspecialchars($val) ?></dd>
                            </div>
                            <?php endforeach; ?>
                        </dl>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <?php if ($h && !empty($h['chronicle'])): ?>
    <!-- ===== CHRONICLES & LORE ===== -->
    <section class="py-24">
        <div class="container mx-auto px-6 max-w-4xl reveal">
            <div class="text-center mb-16">
                <span class="section-eyebrow">Chronicles & Lore</span>
                <h2 class="section-title text-4xl md:text-5xl">The Story of <span class="text-champagne-gradient"><?= htmlspecialchars($destination['name']) ?></span></h2>
            </div>
            
            <article class="prose prose-lg max-w-none">
                <?php 
                $paragraphs = explode("\n\n", $h['chronicle']);
                foreach($paragraphs as $i => $para): 
                    if ($i === 1): ?>
                        <div class="pull-quote reveal">"<?= htmlspecialchars(substr($para, 0, 180)) ?>..."</div>
                    <?php endif; ?>
                    <p class="text-gray-600 text-lg leading-[1.9] mb-8 reveal" style="font-family:'Inter',sans-serif;">
                        <?= nl2br(htmlspecialchars($para)) ?>
                    </p>
                <?php endforeach; ?>
            </article>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($h && !empty($h['insider_tips'])): ?>
    <!-- ===== THE INSIDER'S EDIT ===== -->
    <section class="bg-[#0a0f1e] relative overflow-hidden grain-overlay" style="padding: clamp(4rem, 6vw, 6rem) 0;">
        <div class="container mx-auto px-6 max-w-6xl relative z-10">
            <div class="text-center mb-14 reveal">
                <span class="section-eyebrow">The Insider's Edit</span>
                <h2 class="text-3xl md:text-5xl text-white" style="font-family:'Playfair Display',serif; font-weight:800;">Secrets Only <span class="text-champagne-gradient">Locals</span> Know</h2>
            </div>
            
            <div class="scroll-strip pb-4">
                <?php foreach($h['insider_tips'] as $tip): ?>
                <div class="w-[340px] bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-8 hover:border-[#c9a96e]/30 transition-all reveal">
                    <div class="text-4xl mb-5"><?= $tip['icon'] ?></div>
                    <h4 class="text-xl text-white mb-3" style="font-family:'Playfair Display',serif; font-weight:700;"><?= htmlspecialchars($tip['title']) ?></h4>
                    <p class="text-gray-400 text-sm leading-relaxed" style="font-family:'Inter',sans-serif;"><?= htmlspecialchars($tip['desc']) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($h && !empty($h['sensory']['sound'])): ?>
    <!-- ===== SENSORY PROFILE ===== -->
    <section class="py-24 bg-[#faf8f5]">
        <div class="container mx-auto px-6 max-w-5xl">
            <div class="text-center mb-16 reveal">
                <span class="section-eyebrow">Sensory Profile</span>
                <h2 class="section-title text-3xl md:text-5xl">Feel <span class="text-champagne-gradient"><?= htmlspecialchars($destination['name']) ?></span></h2>
                <p class="text-gray-500 mt-4 max-w-xl mx-auto">Close your eyes and let your senses travel first.</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8" data-stagger>
                <!-- Sound -->
                <div class="sensory-card reveal">
                    <div class="w-16 h-16 bg-[#c9a96e]/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-[#c9a96e]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                    </div>
                    <h4 class="text-lg mb-3 text-[#0a0f1e]" style="font-family:'Playfair Display',serif; font-weight:700;">Sounds</h4>
                    <p class="text-gray-500 text-sm leading-relaxed italic" style="font-family:'Cormorant Garamond',serif; font-size:1.1rem;"><?= htmlspecialchars($h['sensory']['sound']) ?></p>
                </div>
                <!-- Scent -->
                <div class="sensory-card reveal">
                    <div class="w-16 h-16 bg-[#c9a96e]/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-[#c9a96e]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h4 class="text-lg mb-3 text-[#0a0f1e]" style="font-family:'Playfair Display',serif; font-weight:700;">Scents</h4>
                    <p class="text-gray-500 text-sm leading-relaxed italic" style="font-family:'Cormorant Garamond',serif; font-size:1.1rem;"><?= htmlspecialchars($h['sensory']['scent']) ?></p>
                </div>
                <!-- Flavor -->
                <div class="sensory-card reveal">
                    <div class="w-16 h-16 bg-[#c9a96e]/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-[#c9a96e]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </div>
                    <h4 class="text-lg mb-3 text-[#0a0f1e]" style="font-family:'Playfair Display',serif; font-weight:700;">Flavors</h4>
                    <p class="text-gray-500 text-sm leading-relaxed italic" style="font-family:'Cormorant Garamond',serif; font-size:1.1rem;"><?= htmlspecialchars($h['sensory']['flavor']) ?></p>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if(count($packages) > 0): ?>
    <!-- ===== AVAILABLE TOURS ===== -->
    <section class="bg-white py-24">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="text-center mb-16 reveal">
                <span class="section-eyebrow">Begin Your Journey</span>
                <h2 class="section-title text-3xl md:text-5xl">Available <span class="text-champagne-gradient">Tours</span></h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" data-stagger>
                <?php foreach($packages as $pkg): ?>
                <a href="book.php?package_id=<?= $pkg['id'] ?>" class="editorial-card block reveal">
                    <div class="h-56 overflow-hidden relative">
                        <img src="<?= htmlspecialchars($pkg['image_url']) ?>" class="w-full h-full object-cover" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0a0f1e]/80 to-transparent"></div>
                        <div class="absolute bottom-6 left-6 right-6">
                            <h4 class="text-xl text-white" style="font-family:'Playfair Display',serif; font-weight:700;"><?= htmlspecialchars($pkg['title']) ?></h4>
                        </div>
                    </div>
                    <div class="p-6 flex justify-between items-center border-t border-gray-100">
                        <p class="text-xl text-[#c9a96e]" style="font-family:'Playfair Display',serif; font-weight:700;">ETB <?= number_format($pkg['price']) ?></p>
                        <span class="text-gray-400 text-xs font-semibold uppercase tracking-wider"><?= htmlspecialchars($pkg['duration']) ?></span>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Back Link -->
    <div class="bg-[#faf8f5] py-12 text-center">
        <a href="Destination.php" class="btn-dark">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to The Atlas
        </a>
    </div>

    <?php include('../includes/footer.php'); ?>
</body>
</html>
