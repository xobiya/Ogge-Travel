<?php
include("../includes/db-connect.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Please login to book packages";
    header("Location: Account.php");
    exit();
}

$package_id = $_GET['package_id'] ?? null;
if (!$package_id || !is_numeric($package_id)) {
    $_SESSION['error'] = "Invalid package selection";
    header("Location: packages.php");
    exit();
}

$stmt = $db->prepare("SELECT * FROM packages WHERE id = ?");
$stmt->bind_param("i", $package_id);
$stmt->execute();
$package = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$package) {
    $_SESSION['error'] = "Requested package not found";
    header("Location: packages.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seal Your Journey | <?= htmlspecialchars($package['title']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/luxury.css">
</head>
<body class="bg-[#faf8f5]" style="font-family:'Inter',sans-serif;">
    <?php include('../includes/header.php'); ?>

    <!-- Page Header -->
    <section class="relative h-[40vh] flex items-end overflow-hidden bg-[#0a0f1e]">
        <img src="<?= htmlspecialchars($package['image_url']) ?>" class="absolute inset-0 w-full h-full object-cover opacity-30" loading="eager">
        <div class="absolute inset-0 bg-gradient-to-t from-[#0a0f1e] via-[#0a0f1e]/60 to-[#0a0f1e]/30"></div>
        <div class="container mx-auto px-6 max-w-7xl relative z-10 pb-16">
            <span class="section-eyebrow">Secure Your Reservation</span>
            <h1 class="text-4xl md:text-6xl text-white" style="font-family:'Playfair Display',serif; font-weight:800;"><?= htmlspecialchars($package['title']) ?></h1>
        </div>
    </section>

    <div class="container mx-auto px-6 py-16 max-w-7xl">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="mb-8 max-w-4xl mx-auto bg-red-500/10 border border-red-500/20 text-red-600 px-6 py-4 rounded-2xl flex items-center">
                <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-semibold text-sm"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></span>
            </div>
        <?php endif; ?>

        <div class="flex flex-col lg:flex-row gap-10">
            <!-- Package Details -->
            <div class="lg:w-1/2">
                <div class="bg-white rounded-[2rem] shadow-xl overflow-hidden border border-gray-100">
                    <div class="relative h-72">
                        <img src="<?= htmlspecialchars($package['image_url']) ?>" class="w-full h-full object-cover" onerror="this.src='../assets/images/default.jpg'">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0a0f1e] via-transparent to-transparent"></div>
                        <div class="absolute top-6 left-6 bg-[#c9a96e] text-[#0a0f1e] font-bold px-4 py-1.5 rounded-full text-xs uppercase tracking-wider"><?= htmlspecialchars($package['duration']) ?></div>
                    </div>
                    <div class="p-10">
                        <div class="mb-8 pb-8 border-b border-gray-100">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Price Per Person</p>
                            <p class="text-4xl text-[#c9a96e]" style="font-family:'Playfair Display',serif; font-weight:800;">ETB <?= number_format($package['price'], 2) ?></p>
                        </div>
                        <div class="mb-8">
                            <h3 class="text-xl mb-4 text-[#0a0f1e]" style="font-family:'Playfair Display',serif; font-weight:700;">Journey Overview</h3>
                            <p class="text-gray-500 leading-relaxed"><?= htmlspecialchars($package['description']) ?></p>
                        </div>
                        <div class="bg-[#faf8f5] rounded-2xl p-6 border border-[#e2ddd5]">
                            <h3 class="text-sm font-bold text-[#0a0f1e] mb-4 uppercase tracking-wider">Premium Inclusions</h3>
                            <ul class="space-y-3">
                                <li class="flex items-center text-gray-600 text-sm"><div class="w-5 h-5 rounded-full bg-[#c9a96e]/10 flex items-center justify-center mr-3 shrink-0"><svg class="w-3 h-3 text-[#c9a96e]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></div>Luxury accommodations</li>
                                <li class="flex items-center text-gray-600 text-sm"><div class="w-5 h-5 rounded-full bg-[#c9a96e]/10 flex items-center justify-center mr-3 shrink-0"><svg class="w-3 h-3 text-[#c9a96e]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></div>Expert local guide</li>
                                <li class="flex items-center text-gray-600 text-sm"><div class="w-5 h-5 rounded-full bg-[#c9a96e]/10 flex items-center justify-center mr-3 shrink-0"><svg class="w-3 h-3 text-[#c9a96e]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg></div>24/7 Concierge support</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Form -->
            <div class="lg:w-1/2">
                <div class="bg-white rounded-[2rem] p-10 shadow-xl sticky top-28 border border-gray-100">
                    <h2 class="text-3xl text-[#0a0f1e] mb-2" style="font-family:'Playfair Display',serif; font-weight:800;">Seal Your Journey</h2>
                    <p class="text-gray-500 mb-8">Our concierge will reach out within 24 hours to personalize your itinerary.</p>
                    <div class="champagne-line mb-8"></div>

                    <form method="POST" action="../includes/booking.php" id="bookingForm" class="space-y-6">
                        <input type="hidden" name="package_id" value="<?= $package_id ?>">
                        <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 mb-2 uppercase tracking-[0.15em]">Travel Date</label>
                            <input type="date" name="travel_date" class="w-full px-5 py-4 bg-[#faf8f5] border border-[#e2ddd5] rounded-xl focus:outline-none focus:border-[#c9a96e] transition-all text-[#0a0f1e] font-medium" min="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 mb-2 uppercase tracking-[0.15em]">Number of Travelers</label>
                            <select name="travelers" class="w-full px-5 py-4 bg-[#faf8f5] border border-[#e2ddd5] rounded-xl focus:outline-none focus:border-[#c9a96e] transition-all text-[#0a0f1e] font-medium appearance-none" required>
                                <option value="">Select party size...</option>
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?> Traveler<?= $i > 1 ? 's' : '' ?></option>
                                <?php endfor; ?>
                            </select>
                            <div class="mt-4 p-4 bg-[#c9a96e]/10 rounded-xl border border-[#c9a96e]/20 flex justify-between items-center hidden" id="totalPriceBox">
                                <span class="font-bold text-gray-700 text-sm">Total Investment:</span>
                                <span class="font-bold text-xl text-[#c9a96e]" id="totalPriceDisplay" style="font-family:'Playfair Display',serif;"></span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 mb-2 uppercase tracking-[0.15em]">Special Requests <span class="text-gray-300 font-normal normal-case">(Optional)</span></label>
                            <textarea name="special_requests" class="w-full px-5 py-4 bg-[#faf8f5] border border-[#e2ddd5] rounded-xl focus:outline-none focus:border-[#c9a96e] transition-all text-[#0a0f1e] font-medium resize-none" rows="3" placeholder="Dietary needs, celebrations, accessibility..."></textarea>
                        </div>
                        <div class="flex items-center mt-6">
                            <input type="checkbox" name="terms" id="terms" class="w-5 h-5 text-[#c9a96e] border-gray-300 rounded focus:ring-[#c9a96e] cursor-pointer" required>
                            <label for="terms" class="ml-3 text-sm text-gray-500 cursor-pointer">I agree to the <a href="#" class="text-[#c9a96e] font-bold underline">terms and conditions</a></label>
                        </div>
                        <button type="submit" class="btn-dark w-full py-5 text-base mt-4">
                            Seal Your Journey
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include('../includes/footer.php'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const price = <?= $package['price']; ?>;
            const sel = document.querySelector('select[name="travelers"]');
            const box = document.getElementById('totalPriceBox');
            const disp = document.getElementById('totalPriceDisplay');
            sel.addEventListener('change', function() {
                if (this.value) {
                    disp.textContent = "ETB " + (price * this.value).toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2});
                    box.classList.remove('hidden');
                } else { box.classList.add('hidden'); }
            });
        });
    </script>
</body>
</html>