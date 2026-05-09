<?php
session_start();
include("../includes/db-connect.php");

if (!isset($_SESSION['user_id'])) { header("Location: Account.php"); exit(); }

$user_id = $_SESSION['user_id'];
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

$stmt = $db->prepare("SELECT b.*, p.title, p.image_url, p.price, p.duration FROM bookings b JOIN packages p ON b.package_id = p.id WHERE b.user_id = ? ORDER BY b.created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$bookings = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Private Dashboard | OGGE Travel</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=1.2">
    <link rel="stylesheet" href="../assets/css/luxury.css?v=1.2">
</head>
<body class="bg-[#0a0f1e] min-h-screen grain-overlay" style="font-family:'Inter',sans-serif;">
    <?php include('../includes/header.php'); ?>

    <!-- Deep Navy Background Glows -->
    <div class="fixed top-0 right-0 w-[600px] h-[600px] bg-[#c9a96e] rounded-full blur-[150px] opacity-[0.08] pointer-events-none z-0 -translate-y-1/2 translate-x-1/3"></div>
    <div class="fixed bottom-0 left-0 w-[500px] h-[500px] bg-blue-500 rounded-full blur-[150px] opacity-[0.05] pointer-events-none z-0 translate-y-1/3 -translate-x-1/3"></div>

    <!-- Page Header -->
    <section class="relative pt-40 pb-16 z-10">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 reveal">
                <div>
                    <span class="text-[#c9a96e] text-xs font-bold uppercase tracking-[0.25em] block mb-4">Member Portal</span>
                    <h1 class="text-5xl md:text-7xl text-white" style="font-family:'Playfair Display',serif; font-weight:800;">
                        Welcome, <span class="text-champagne-gradient"><?= htmlspecialchars(explode(' ', $user['name'])[0]) ?></span>
                    </h1>
                </div>
                <div class="flex gap-4">
                    <a href="edit-profile.php" class="btn-outline px-6 py-3 text-xs flex items-center bg-[#0a0f1e] hover:bg-[#c9a96e] hover:text-[#0a0f1e] hover:border-[#c9a96e] transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit Profile
                    </a>
                    <a href="../includes/logout.php" class="px-6 py-3 text-xs text-white border border-white/20 rounded-full uppercase tracking-wider font-bold hover:bg-white/10 transition-colors flex items-center">
                        Sign Out
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container mx-auto px-6 pb-24 max-w-7xl relative z-10">
        <div class="grid lg:grid-cols-12 gap-10">
            
            <!-- Sidebar -->
            <div class="lg:col-span-4 space-y-8">
                <!-- Profile Card -->
                <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-[2rem] p-10 reveal shadow-2xl relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#c9a96e]/10 to-transparent opacity-50"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-6 mb-10">
                            <div class="w-20 h-20 bg-gradient-to-br from-[#c9a96e] to-[#e8d5a8] rounded-[1.5rem] flex items-center justify-center shadow-[0_0_30px_rgba(201,169,110,0.3)]">
                                <span class="text-3xl font-bold text-[#0a0f1e]" style="font-family:'Playfair Display',serif;"><?= strtoupper(substr($user['name'], 0, 1)) ?></span>
                            </div>
                            <div>
                                <p class="text-white text-xl font-bold" style="font-family:'Playfair Display',serif;"><?= htmlspecialchars($user['name']) ?></p>
                                <p class="text-[#c9a96e] text-xs font-semibold uppercase tracking-wider mt-1">Founding Member</p>
                            </div>
                        </div>
                        
                        <div class="space-y-6 pt-6 border-t border-white/10">
                            <div>
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Email</p>
                                <p class="text-gray-300 font-medium break-all"><?= htmlspecialchars($user['email']) ?></p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Member Since</p>
                                <p class="text-gray-300 font-medium"><?= date('F Y', strtotime($user['created_at'])) ?></p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Journeys Booked</p>
                                <p class="text-[#c9a96e] text-2xl font-bold" style="font-family:'Playfair Display',serif;"><?= count($bookings) ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Concierge Access -->
                <div class="bg-[#c9a96e] rounded-[2rem] p-10 shadow-[0_0_40px_rgba(201,169,110,0.15)] relative overflow-hidden reveal">
                    <div class="absolute -right-10 -bottom-10 opacity-10">
                        <svg class="w-64 h-64 text-[#0a0f1e]" fill="currentColor" viewBox="0 0 100 100"><path d="M50 10L60 30H40L50 10M50 90L40 70H60L50 90M90 50L70 60V40L90 50M10 50L30 40V60L10 50M50 30L60 50H40L50 30M50 70L40 50H60L50 70M30 50L50 40V60L30 50M70 50L50 60V40L70 50"/></svg>
                    </div>
                    <div class="relative z-10 text-[#0a0f1e]">
                        <h3 class="text-2xl mb-4" style="font-family:'Playfair Display',serif; font-weight:800;">Private Concierge</h3>
                        <p class="text-sm font-medium mb-8 leading-relaxed">Your personal travel designer is ready to assist with custom itineraries, private flights, and exclusive access.</p>
                        <a href="https://wa.me/251911234567?text=Hello%20Concierge,%20I%20am%20a%20member%20looking%20for%20assistance." target="_blank" class="bg-[#0a0f1e] text-white w-full py-4 rounded-xl flex items-center justify-center text-sm font-bold uppercase tracking-wider hover:bg-black transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                            Message Concierge
                        </a>
                    </div>
                </div>
            </div>

            <!-- Booking List -->
            <div class="lg:col-span-8">
                <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-[2rem] p-10 reveal shadow-2xl h-full">
                    <h2 class="text-3xl text-white mb-10 pb-6 border-b border-white/10" style="font-family:'Playfair Display',serif; font-weight:700;">Journey Folio</h2>
                    
                    <?php if (empty($bookings)): ?>
                        <div class="text-center py-20">
                            <div class="w-24 h-24 bg-[#c9a96e]/10 border border-[#c9a96e]/20 rounded-full flex items-center justify-center mx-auto mb-8 shadow-[0_0_20px_rgba(201,169,110,0.1)]">
                                <svg class="w-10 h-10 text-[#c9a96e]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            </div>
                            <h3 class="text-2xl text-white mb-3" style="font-family:'Playfair Display',serif; font-weight:700;">No adventures yet</h3>
                            <p class="text-gray-400 mb-10 max-w-sm mx-auto text-sm leading-relaxed">Your journey folio is currently empty. The extraordinary awaits.</p>
                            <a href="packages.php" class="btn-champagne">
                                Discover the Extraordinary
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="space-y-6">
                            <?php foreach ($bookings as $booking): ?>
                            <div class="group bg-white/5 border border-white/10 rounded-2xl p-6 hover:bg-white/10 transition-all duration-500 hover:border-[#c9a96e]/30 flex flex-col md:flex-row gap-6 relative overflow-hidden">
                                <!-- Status Edge Accent -->
                                <?php
                                $accentColor = match($booking['status']) {
                                    'confirmed' => 'bg-green-500',
                                    'cancelled' => 'bg-red-500',
                                    default => 'bg-[#c9a96e]'
                                };
                                ?>
                                <div class="absolute left-0 top-0 bottom-0 w-1 <?= $accentColor ?>"></div>

                                <!-- Image -->
                                <div class="w-full md:w-48 h-32 shrink-0 rounded-xl overflow-hidden relative">
                                    <img src="<?= htmlspecialchars($booking['image_url']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="">
                                </div>

                                <!-- Content -->
                                <div class="flex-grow flex flex-col justify-between">
                                    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                                        <div>
                                            <p class="text-[#c9a96e] text-xs font-semibold uppercase tracking-[0.2em] mb-1">
                                                <?= htmlspecialchars($booking['duration'] ?? 'Curated Journey') ?>
                                            </p>
                                            <h4 class="text-xl text-white font-bold" style="font-family:'Playfair Display',serif;">
                                                <?= htmlspecialchars($booking['title']) ?>
                                            </h4>
                                        </div>
                                        <div class="text-left md:text-right">
                                            <?php
                                            $badgeStyle = match($booking['status']) {
                                                'confirmed' => 'text-green-400 bg-green-400/10 border-green-400/20',
                                                'cancelled' => 'text-red-400 bg-red-400/10 border-red-400/20',
                                                default => 'text-[#c9a96e] bg-[#c9a96e]/10 border-[#c9a96e]/20'
                                            };
                                            ?>
                                            <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-widest rounded-full border <?= $badgeStyle ?>">
                                                <?= ucfirst($booking['status']) ?>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                                        <div>
                                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Travel Date</p>
                                            <p class="text-sm font-semibold text-gray-200 mt-1"><?= date('M j, Y', strtotime($booking['start_date'])) ?></p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Guests</p>
                                            <p class="text-sm font-semibold text-gray-200 mt-1"><?= $booking['travelers'] ?></p>
                                        </div>
                                        <div class="md:col-span-2 md:text-right">
                                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Investment</p>
                                            <p class="text-lg font-bold text-[#c9a96e] mt-0.5" style="font-family:'Playfair Display',serif;">ETB <?= number_format($booking['price'] * $booking['travelers']) ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

    <?php include('../includes/footer.php'); ?>
</body>
</html>
