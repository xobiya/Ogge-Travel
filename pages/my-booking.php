<?php
session_start();
include('../includes/db-connect.php');

if (!isset($_SESSION['user_id'])) { header('Location: Account.php'); exit(); }

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
    <title>My Journeys | OGGE Travel</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=1.1">
    <link rel="stylesheet" href="../assets/css/luxury.css">
</head>
<body class="bg-[#faf8f5]" style="font-family:'Inter',sans-serif;">
    <?php include('../includes/header.php'); ?>

    <section class="relative h-[35vh] flex items-end overflow-hidden bg-[#0a0f1e]">
        <div class="absolute inset-0 bg-gradient-to-b from-[#0a0f1e]/60 to-[#0a0f1e]"></div>
        <div class="container mx-auto px-6 max-w-7xl relative z-10 pb-16">
            <span class="section-eyebrow">Your Travel Portfolio</span>
            <h1 class="text-5xl md:text-7xl text-white" style="font-family:'Playfair Display',serif; font-weight:800;">My <span class="text-champagne-gradient">Journeys</span></h1>
        </div>
    </section>

    <div class="container mx-auto px-6 py-16 max-w-6xl">
        <?php if ($result->num_rows == 0): ?>
            <div class="text-center py-20 reveal">
                <div class="w-20 h-20 bg-[#c9a96e]/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-[#c9a96e]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <h2 class="text-2xl text-[#0a0f1e] mb-3" style="font-family:'Playfair Display',serif; font-weight:700;">No Journeys Yet</h2>
                <p class="text-gray-500 mb-8">Your travel story hasn't begun — let us write the first chapter.</p>
                <a href="packages.php" class="btn-champagne">Explore Curated Journeys</a>
            </div>
        <?php else: ?>
            <div class="space-y-6">
                <?php while($booking = $result->fetch_assoc()): ?>
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100 hover:shadow-xl transition-all reveal">
                    <div class="grid md:grid-cols-5">
                        <div class="md:col-span-2 relative h-52 md:h-auto overflow-hidden">
                            <img src="<?= htmlspecialchars($booking['image_url']) ?>" class="absolute inset-0 w-full h-full object-cover" loading="lazy">
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent to-white/10 md:bg-none"></div>
                            <?php
                            $statusStyle = match($booking['status']) {
                                'confirmed' => 'bg-green-500/90 text-white',
                                'pending' => 'bg-[#c9a96e]/90 text-[#0a0f1e]',
                                'cancelled' => 'bg-red-500/90 text-white',
                                default => 'bg-gray-500/90 text-white'
                            };
                            ?>
                            <div class="absolute top-4 left-4 <?= $statusStyle ?> px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider"><?= ucfirst($booking['status']) ?></div>
                        </div>
                        <div class="md:col-span-3 p-8 lg:p-10 flex flex-col justify-center">
                            <p class="text-[#c9a96e] text-xs font-semibold uppercase tracking-[0.2em] mb-2"><?= htmlspecialchars($booking['duration'] ?? '') ?></p>
                            <h3 class="text-2xl text-[#0a0f1e] mb-4" style="font-family:'Playfair Display',serif; font-weight:700;"><?= htmlspecialchars($booking['title']) ?></h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                                <div>
                                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Booked</p>
                                    <p class="text-sm text-[#0a0f1e] font-semibold mt-1"><?= date('M j, Y', strtotime($booking['created_at'])) ?></p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Travel Date</p>
                                    <p class="text-sm text-[#0a0f1e] font-semibold mt-1"><?= date('M j, Y', strtotime($booking['start_date'])) ?></p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Travelers</p>
                                    <p class="text-sm text-[#0a0f1e] font-semibold mt-1"><?= $booking['travelers'] ?> Guest<?= $booking['travelers'] > 1 ? 's' : '' ?></p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Investment</p>
                                    <p class="text-sm text-[#c9a96e] font-bold mt-1" style="font-family:'Playfair Display',serif;">ETB <?= number_format($booking['price'] * $booking['travelers']) ?></p>
                                </div>
                            </div>
                            <?php if (!empty($booking['special_requests'])): ?>
                            <div class="bg-[#faf8f5] rounded-xl p-4 border border-[#e2ddd5]">
                                <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-1">Concierge Notes</p>
                                <p class="text-sm text-gray-600"><?= htmlspecialchars($booking['special_requests']) ?></p>
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
