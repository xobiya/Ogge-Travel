<?php
require_once __DIR__ . '/../includes/auth-helpers.php';
ogge_start_secure_session();
require_once __DIR__ . '/../includes/db-connect.php';

if (!isset($_SESSION['user_id'])) { 
    ogge_redirect(BASE_URL . '/account'); 
}

$user_id = $_SESSION['user_id'];
$stmt = $db->prepare("SELECT b.*, p.title, p.image_url, p.price, p.duration FROM bookings b JOIN packages p ON b.package_id = p.id WHERE b.user_id = ? ORDER BY b.created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Travel Portfolio | OGGE Travel</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=1.3">
    <link rel="stylesheet" href="../assets/css/luxury.css?v=1.3">
    <script src="../assets/js/script.js?v=1.3"></script>
</head>
<body class="bg-[#faf8f5]">
    <?php include('../includes/header.php'); ?>

    <!-- Header -->
    <section class="relative h-[40vh] flex items-end overflow-hidden bg-[#0a0f1e]">
        <div class="absolute inset-0 bg-gradient-to-t from-[#faf8f5] to-[#0a0f1e]/80"></div>
        <div class="container mx-auto px-6 max-w-7xl relative z-10 pb-16 reveal-left">
            <span class="section-eyebrow text-white">Your Legacy of Adventure</span>
            <h1 class="text-5xl md:text-8xl text-white" style="font-family:'Playfair Display',serif; font-weight:800;">My <span class="text-champagne-gradient">Journeys</span></h1>
        </div>
    </section>

    <div class="container mx-auto px-6 py-16 -mt-10 relative z-20 max-w-6xl pb-32">
        <?php if ($result->num_rows == 0): ?>
            <div class="text-center py-24 bg-white rounded-[3rem] shadow-xl border border-gray-100 reveal">
                <div class="w-24 h-24 bg-champagne/10 rounded-full flex items-center justify-center mx-auto mb-8">
                    <svg class="w-12 h-12 text-champagne" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <h2 class="text-3xl text-navy-950 mb-4" style="font-family:'Playfair Display',serif; font-weight:700;">A Blank Canvas</h2>
                <p class="text-gray-400 mb-10 max-w-md mx-auto">Your travel story hasn't begun. Let us curate your first masterpiece in the heart of Ethiopia.</p>
                <a href="<?= BASE_URL ?>/packages" class="btn-champagne">Explore Collections</a>
            </div>
        <?php else: ?>
            <div class="space-y-8">
                <?php while($booking = $result->fetch_assoc()): ?>
                <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-2xl shadow-navy-950/5 border border-gray-100 group hover:border-champagne/30 transition-all duration-500 reveal">
                    <div class="grid md:grid-cols-12 h-full">
                        <div class="md:col-span-4 relative h-64 md:h-auto overflow-hidden">
                            <img src="<?= htmlspecialchars($booking['image_url']) ?>" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000" loading="lazy">
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent to-white/10"></div>
                            
                            <?php
                            $statusColors = match($booking['status']) {
                                'confirmed' => 'bg-emerald-500 text-white',
                                'pending' => 'bg-champagne text-navy-950',
                                'cancelled' => 'bg-red-500 text-white',
                                default => 'bg-gray-500 text-white'
                            };
                            ?>
                            <div class="absolute top-6 left-6 <?= $statusColors ?> px-5 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-[0.2em] shadow-lg">
                                <?= htmlspecialchars($booking['status']) ?>
                            </div>
                        </div>
                        <div class="md:col-span-8 p-10 lg:p-14 flex flex-col justify-center">
                            <div class="flex flex-wrap items-center gap-4 mb-3">
                                <p class="text-champagne text-[10px] font-bold uppercase tracking-[0.2em]"><?= htmlspecialchars($booking['duration'] ?? '') ?></p>
                                <span class="w-1 h-1 rounded-full bg-gray-200"></span>
                                <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">ID: OGGE-<?= str_pad($booking['id'], 4, '0', STR_PAD_LEFT) ?></p>
                            </div>
                            
                            <h3 class="text-3xl lg:text-4xl text-navy-950 mb-8" style="font-family:'Playfair Display',serif; font-weight:800;"><?= htmlspecialchars($booking['title']) ?></h3>
                            
                            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                                <div class="space-y-1">
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Reserved On</p>
                                    <p class="text-sm text-navy-950 font-semibold"><?= date('M j, Y', strtotime($booking['created_at'])) ?></p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Departure</p>
                                    <p class="text-sm text-navy-950 font-semibold"><?= date('M j, Y', strtotime($booking['start_date'])) ?></p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Party Size</p>
                                    <p class="text-sm text-navy-950 font-semibold"><?= $booking['travelers'] ?> Guests</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Total Investment</p>
                                    <p class="text-sm text-champagne font-black">ETB <?= number_format($booking['price'] * $booking['travelers']) ?></p>
                                </div>
                            </div>

                            <?php if (!empty($booking['special_requests'])): ?>
                            <div class="bg-[#faf8f5] rounded-2xl p-6 border border-gray-100 relative overflow-hidden group-hover:bg-white transition-colors">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-2 flex items-center gap-2">
                                    <svg class="w-3 h-3 text-champagne" fill="currentColor" viewBox="0 0 20 20"><path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                    Concierge Directives
                                </p>
                                <p class="text-sm text-gray-600 leading-relaxed font-light italic" style="font-family:'Cormorant Garamond',serif; font-size:1.1rem;">"<?= htmlspecialchars($booking['special_requests']) ?>"</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php include('../includes/footer.php'); ?>
</body>
</html>
<?php $stmt->close(); $db->close(); ?>
