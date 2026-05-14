<?php
require_once __DIR__ . '/../includes/auth-helpers.php';
ogge_start_secure_session();
require_once __DIR__ . '/../includes/db-connect.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Please login to book packages";
    ogge_redirect(BASE_URL . "/account");
}

$package_id = $_GET['package_id'] ?? null;
if (!$package_id || !is_numeric($package_id)) {
    $_SESSION['error'] = "Invalid package selection";
    ogge_redirect(BASE_URL . "/packages");
}

$stmt = $db->prepare("SELECT * FROM packages WHERE id = ?");
$stmt->bind_param("i", $package_id);
$stmt->execute();
$package = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$package) {
    $_SESSION['error'] = "Requested package not found";
    ogge_redirect(BASE_URL . "/packages");
}
$csrfToken = ogge_csrf_token();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seal Your Journey | <?= htmlspecialchars($package['title']) ?></title>
    <link rel="stylesheet" href="../assets/css/style.css?v=1.4">
    <link rel="stylesheet" href="../assets/css/luxury.css?v=1.4">
    <script src="../assets/js/script.js?v=1.3"></script>
    <style>
        .booking-gradient {
            background: radial-gradient(circle at top right, rgba(182, 145, 80, 0.05), transparent 40%),
                        radial-gradient(circle at bottom left, rgba(10, 15, 30, 0.02), transparent 40%);
        }
        .form-input-luxury {
            @apply w-full px-6 py-5 bg-white border border-gray-100 rounded-2xl focus:outline-none focus:border-[#b69150] transition-all text-[#0a0f1e] font-medium shadow-sm;
        }
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(0.6) sepia(1) saturate(5) hue-rotate(10deg);
            cursor: pointer;
        }
    </style>
</head>
<body class="bg-[#faf8f5] booking-gradient">
    <?php include('../includes/header.php'); ?>
    
    <!-- Dark Header Spacer for Fixed Nav -->
    <div class="h-20 md:h-24 bg-[#0a0f1e]"></div>

    <!-- Cinematic Header -->
    <section class="hero-section relative h-[50vh] flex items-end overflow-hidden">
        <div class="absolute inset-0">
            <img src="<?= htmlspecialchars($package['image_url']) ?>" class="w-full h-full object-cover animate-ken-burns" onerror="this.src='../assets/images/default.jpg'">
            <div class="absolute inset-0 bg-gradient-to-t from-[#faf8f5] via-[#0a0f1e]/60 to-[#0a0f1e]/30"></div>
        </div>
        <div class="container mx-auto px-6 max-w-7xl relative z-10 pb-24">
            <div class="max-w-3xl reveal-left">
                <span class="section-eyebrow text-white">The Curated Escape</span>
                <h1 class="text-4xl md:text-7xl text-white mb-4" style="font-family:'Playfair Display',serif; font-weight:800;"><?= htmlspecialchars($package['title']) ?></h1>
                <p class="text-white/80 text-lg md:text-xl font-light italic" style="font-family:'Cormorant Garamond',serif;">Your journey towards extraordinary begins here.</p>
            </div>
        </div>
    </section>

    <main class="container mx-auto px-6 pt-16 relative z-20 pb-24 max-w-7xl">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="mb-10 max-w-5xl mx-auto glass-luxury border-red-500/20 text-red-600 px-8 py-5 rounded-2xl flex items-center animate-fade-up">
                <svg class="w-6 h-6 mr-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-medium"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></span>
            </div>
        <?php endif; ?>

        <div class="flex flex-col lg:flex-row gap-12 items-start">
            <!-- Left Side: Summary & Trust -->
            <div class="lg:w-5/12 space-y-8 reveal-left">
                <!-- Summary Card -->
                <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] shadow-2xl shadow-navy-950/5 overflow-hidden border border-gray-100">
                    <div class="p-6 sm:p-10">
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mb-1">Package Reference</p>
                                <p class="text-navy-950 font-medium font-mono text-xs">OGGE-<?= str_pad($package_id, 4, '0', STR_PAD_LEFT) ?></p>
                            </div>
                            <div class="bg-champagne/10 text-champagne px-4 py-2 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                <?= htmlspecialchars($package['duration']) ?>
                            </div>
                        </div>

                        <h3 class="text-2xl text-navy-950 mb-6" style="font-family:'Playfair Display',serif; font-weight:700;">Journey Highlights</h3>
                        <p class="text-gray-500 leading-relaxed mb-8 italic" style="font-family:'Cormorant Garamond',serif; font-size:1.15rem;">
                            "<?= htmlspecialchars(substr($package['description'], 0, 150)) ?>..."
                        </p>

                        <div class="space-y-6">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-navy-950 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-champagne" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-navy-950 uppercase tracking-wider mb-1">Elite Lodging</h4>
                                    <p class="text-xs text-gray-500">Hand-picked boutique hotels & lodges.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-navy-950 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-champagne" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-navy-950 uppercase tracking-wider mb-1">Private Guide</h4>
                                    <p class="text-xs text-gray-500">Multi-lingual historian accompanying you.</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-12 pt-8 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-gray-400 text-sm">Investment per guest</span>
                            <span class="text-3xl text-champagne" style="font-family:'Playfair Display',serif; font-weight:800;">ETB <?= number_format($package['price'], 0) ?></span>
                        </div>
                    </div>
                </div>

                <!-- Trust Pilot Mockup -->
                <div class="glass-luxury p-8 rounded-3xl border-white/40">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="flex gap-1 text-champagne">
                            <?php for($i=0;$i<5;$i++): ?><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg><?php endfor; ?>
                        </div>
                        <span class="text-navy-950 font-bold text-xs uppercase tracking-widest">Exceptional</span>
                    </div>
                    <p class="text-gray-500 text-sm italic mb-4">"The attention to detail was beyond anything I've experienced in luxury travel. Truly bespoke."</p>
                    <p class="text-navy-950 text-[10px] font-bold uppercase tracking-widest">— Julian R., Zurich</p>
                </div>
            </div>

            <!-- Right Side: Booking Form -->
            <div class="lg:w-7/12 reveal-right">
                <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-12 shadow-2xl shadow-navy-950/5 border border-gray-100">
                    <div class="mb-12">
                        <h2 class="text-4xl text-navy-950 mb-3" style="font-family:'Playfair Display',serif; font-weight:800;">Initiate Your Escape</h2>
                        <p class="text-gray-400">Complete the details below to begin your personalized journey curation.</p>
                        <div class="w-20 h-1 bg-champagne mt-6"></div>
                    </div>

                    <form method="POST" action="../includes/booking.php" id="bookingForm" class="space-y-8">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                        <input type="hidden" name="package_id" value="<?= $package_id ?>">

                        <div class="grid md:grid-cols-2 gap-6 sm:gap-8">
                            <div class="group">
                                <label class="block text-[10px] font-bold text-gray-400 mb-3 uppercase tracking-[0.2em] group-focus-within:text-champagne transition-colors">Desired Departure</label>
                                <input type="date" name="travel_date" 
                                       class="w-full px-6 py-5 bg-[#faf8f5] border border-gray-100 rounded-2xl focus:outline-none focus:border-champagne focus:bg-white transition-all text-navy-950 font-medium shadow-sm" 
                                       min="<?= date('Y-m-d') ?>" required>
                            </div>
                            <div class="group">
                                <label class="block text-[10px] font-bold text-gray-400 mb-3 uppercase tracking-[0.2em] group-focus-within:text-champagne transition-colors">Number of Guests</label>
                                <div class="relative">
                                    <input type="number" name="travelers" min="1" max="50" placeholder="e.g. 2"
                                           class="w-full px-6 py-5 bg-[#faf8f5] border border-gray-100 rounded-2xl focus:outline-none focus:border-champagne focus:bg-white transition-all text-navy-950 font-medium shadow-sm" 
                                           required>
                                    <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="group">
                            <label class="block text-[10px] font-bold text-gray-400 mb-3 uppercase tracking-[0.2em] group-focus-within:text-champagne transition-colors">Bespoke Requests</label>
                            <textarea name="special_requests" maxlength="1000" 
                                      class="w-full px-6 py-5 bg-[#faf8f5] border border-gray-100 rounded-2xl focus:outline-none focus:border-champagne focus:bg-white transition-all text-navy-950 font-medium shadow-sm resize-none" 
                                      rows="4" placeholder="Any specific requirements, dietary preferences, or celebratory milestones?"></textarea>
                        </div>

                        <!-- Price Breakdown -->
                        <div class="bg-white border-2 border-champagne/10 rounded-3xl p-8 transition-all duration-500 opacity-0 transform translate-y-4 pointer-events-none" id="pricePanel">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div>
                                    <p class="text-champagne text-[10px] font-bold uppercase tracking-[0.2em] mb-1">Estimated Total Investment</p>
                                    <p class="text-3xl text-navy-950" id="totalPriceDisplay" style="font-family:'Playfair Display',serif; font-weight:700;">ETB 0.00</p>
                                </div>
                                <div class="text-left md:text-right">
                                    <p class="text-gray-400 text-[10px] uppercase tracking-widest">Fully inclusive of</p>
                                    <p class="text-navy-950/60 text-xs mt-1">VAT, Luxury Transport & Private Guiding</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-6">
                            <div class="flex items-center">
                            <div class="flex items-start">
                                <label class="luxury-checkbox-wrapper">
                                    <input type="checkbox" name="terms" id="terms" required>
                                    <span class="luxury-checkbox-box"></span>
                                </label>
                                <div class="ml-4 text-sm">
                                    <label for="terms" class="text-gray-500 cursor-pointer">
                                        I agree to the <a href="#" class="text-navy-950 font-bold hover:text-champagne transition-colors underline underline-offset-4 relative z-20">Luxury Booking Protocol</a>.
                                    </label>
                                </div>
                            </div>
                            </div>

                            <button type="submit" class="w-full py-6 text-lg group overflow-hidden relative rounded-2xl transition-all hover:bg-[#c9a96e] hover:text-[#0a0f1e]" style="background-color: #000000 !important; color: #ffffff !important; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; border: 1px solid rgba(255,255,255,0.1);">
                                <span class="relative z-10 flex items-center justify-center">
                                    Finalize Reservation
                                    <svg class="w-5 h-5 ml-3 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>

                <p class="text-center mt-8 text-gray-400 text-xs uppercase tracking-widest">Secure 256-bit Encrypted Reservation System</p>
            </div>
        </div>
    </main>

    <?php include('../includes/footer.php'); ?>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const price = <?= (float)$package['price']; ?>;
            const inputTravelers = document.querySelector('input[name="travelers"]');
            const pricePanel = document.getElementById('pricePanel');
            const totalPriceDisplay = document.getElementById('totalPriceDisplay');

            const updatePrice = () => {
                const val = parseInt(inputTravelers.value);
                if (val > 0) {
                    const total = price * val;
                    totalPriceDisplay.textContent = "ETB " + total.toLocaleString(undefined, {minimumFractionDigits:0, maximumFractionDigits:0});
                    
                    pricePanel.classList.remove('opacity-0', 'translate-y-4', 'pointer-events-none');
                    pricePanel.classList.add('opacity-100', 'translate-y-0');
                } else {
                    pricePanel.classList.add('opacity-0', 'translate-y-4', 'pointer-events-none');
                    pricePanel.classList.remove('opacity-100', 'translate-y-0');
                }
            };

            inputTravelers.addEventListener('input', updatePrice);
            inputTravelers.addEventListener('change', updatePrice);

            // Smooth reveal for form elements
            document.querySelectorAll('.group').forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(10px)';
                el.style.transition = `all 0.5s ease-out ${0.1 * index}s`;
                
                setTimeout(() => {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, 100);
            });
        });
    </script>
</body>
</html>
