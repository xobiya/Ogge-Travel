<?php
require_once __DIR__ . '/../includes/auth-helpers.php';
ogge_start_secure_session();
include("../includes/db-connect.php");

// Fetch all journals
$query = "SELECT j.*, u.name as author_name FROM journals j JOIN users u ON j.user_id = u.id ORDER BY j.created_at DESC";
$result = $db->query($query);
$journals = $result->fetch_all(MYSQLI_ASSOC);
$csrfToken = ogge_csrf_token();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traveler Journals | OGGE Travel</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=1.4">
    <link rel="stylesheet" href="../assets/css/luxury.css?v=1.4">
</head>
<body class="bg-[#faf8f5]" style="font-family:'Inter',sans-serif;">
    <?php include("../includes/header.php"); ?>

    <!-- Page Header -->
    <section class="relative h-[45vh] flex items-end overflow-hidden bg-[#0a0f1e]">
        <div class="absolute inset-0 bg-gradient-to-b from-[#0a0f1e]/60 to-[#0a0f1e]"></div>
        <div class="container mx-auto px-6 max-w-7xl relative z-10 pb-16">
            <span class="section-eyebrow">የተጓዦች ማስታወሻ</span>
            <h1 class="text-4xl sm:text-5xl md:text-7xl text-white" style="font-family:'Playfair Display',serif; font-weight:800;">Traveler <span class="text-champagne-gradient">Journals</span></h1>
            <p class="text-gray-400 mt-4 text-lg max-w-xl">Read personal stories, reflections, and adventures from those who have walked the ancient paths of Ethiopia.</p>
        </div>
    </section>

    <!-- Journals Feed -->
    <section class="py-20">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="grid lg:grid-cols-3 gap-12">
                
                <!-- Stories List -->
                <div class="lg:col-span-2 space-y-12">
                    <?php if (empty($journals)): ?>
                        <div class="bg-white p-10 rounded-2xl border border-gray-100 text-center shadow-lg">
                            <h3 class="text-2xl text-[#0a0f1e] mb-3" style="font-family:'Playfair Display',serif; font-weight:700;">No Stories Yet</h3>
                            <p class="text-gray-500">Be the first to share your Ethiopian journey.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach($journals as $j): ?>
                        <article class="bg-white rounded-[2rem] overflow-hidden shadow-xl border border-gray-100 reveal group">
                            <?php if (!empty($j['image_url'])): ?>
                            <div class="relative h-72 overflow-hidden">
                                <img src="<?= htmlspecialchars($j['image_url']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="" onerror="this.src='../assets/images/lalibela.jpg'">
                            </div>
                            <?php endif; ?>
                            <div class="p-10">
                                <div class="flex items-center gap-3 mb-4">
                                    <span class="text-[#c9a96e] text-xs font-semibold uppercase tracking-[0.2em]"><?= htmlspecialchars($j['location']) ?></span>
                                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                    <span class="text-gray-400 text-xs font-medium uppercase tracking-wider"><?= date('M j, Y', strtotime($j['created_at'])) ?></span>
                                </div>
                                <h3 class="text-3xl text-[#0a0f1e] mb-4" style="font-family:'Playfair Display',serif; font-weight:700;"><?= htmlspecialchars($j['title']) ?></h3>
                                <p class="text-gray-600 leading-relaxed mb-6 text-lg">
                                    <?= nl2br(htmlspecialchars($j['content'])) ?>
                                </p>
                                <div class="flex items-center pt-6 border-t border-gray-100">
                                    <div class="w-10 h-10 bg-[#0a0f1e] text-[#c9a96e] rounded-full flex items-center justify-center font-bold font-serif text-sm mr-3">
                                        <?= strtoupper(substr($j['author_name'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Penned By</p>
                                        <p class="text-sm font-semibold text-[#0a0f1e]"><?= htmlspecialchars($j['author_name']) ?></p>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Sidebar Form -->
                <div class="lg:col-span-1">
                    <div class="sticky top-28 bg-[#0a0f1e] rounded-[2rem] p-8 shadow-2xl grain-overlay relative overflow-hidden reveal">
                        <div class="relative z-10">
                            <h3 class="text-2xl text-white mb-2" style="font-family:'Playfair Display',serif; font-weight:700;">Share Your <span class="text-[#c9a96e]">Story</span></h3>
                            <p class="text-gray-400 text-sm mb-8">Did you journey with us? Add your voice to the traveler chronicles.</p>
                            
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <form action="../includes/journal-submit.php" method="POST" enctype="multipart/form-data" class="space-y-5" novalidate>
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                                    <div>
                                        <input type="text" name="title" maxlength="255" class="w-full px-5 py-3 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-[#c9a96e] transition-colors text-white placeholder-gray-500 text-sm" placeholder="Title of your story" required>
                                    </div>
                                    <div>
                                        <input type="text" name="location" maxlength="120" class="w-full px-5 py-3 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-[#c9a96e] transition-colors text-white placeholder-gray-500 text-sm" placeholder="Location (e.g., Lalibela)" required>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Upload Photo <span class="text-gray-600 normal-case font-normal">(Optional)</span></label>
                                        <input type="file" name="image" accept="image/jpeg,image/png,image/webp" class="w-full px-5 py-3 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-[#c9a96e] transition-colors text-white placeholder-gray-500 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-[#c9a96e] file:text-[#0a0f1e] hover:file:bg-[#e8d5a8] file:transition-colors file:cursor-pointer cursor-pointer">
                                    </div>
                                    <div>
                                        <textarea name="content" maxlength="10000" rows="6" class="w-full px-5 py-3 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-[#c9a96e] transition-colors text-white placeholder-gray-500 text-sm resize-none" placeholder="Write your experience here..." required></textarea>
                                    </div>
                                    <button type="submit" class="w-full py-4 bg-black text-white border border-white/10 rounded-xl font-bold text-xs uppercase tracking-[0.2em] hover:bg-[#c9a96e] hover:text-black transition-all shadow-xl">Publish Story</button>
                                </form>
                            <?php else: ?>
                                <div class="bg-white/5 border border-white/10 rounded-xl p-6 text-center">
                                    <p class="text-gray-300 text-sm mb-4">Please sign in to share your journey.</p>
                                    <a href="Account.php" class="inline-flex items-center justify-center px-8 py-3 bg-black text-white text-[10px] font-bold uppercase tracking-[0.2em] rounded-xl hover:bg-[#c9a96e] hover:text-black transition-all">Sign In</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <?php include("../includes/footer.php"); ?>
</body>
</html>
