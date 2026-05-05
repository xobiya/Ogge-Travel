<?php
include("../includes/db-connect.php");
session_start();

// Check authentication
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Please login to book packages";
    header("Location: Account.php");
    exit();
}

// Validate package ID
$package_id = $_GET['package_id'] ?? null;
if (!$package_id || !is_numeric($package_id)) {
    $_SESSION['error'] = "Invalid package selection";
    header("Location: packages.php");
    exit();
}

// Fetch package details
$stmt = $db->prepare("SELECT * FROM packages WHERE id = ?");
$stmt->bind_param("i", $package_id);
$stmt->execute();
$result = $stmt->get_result();
$package = $result->fetch_assoc();
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
    <title>Secure Booking | <?= htmlspecialchars($package['title']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { font-family: 'Outfit', sans-serif; overflow-x: hidden;}
        .glass-panel {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.6);
        }
        .form-input {
            transition: all 0.3s ease;
        }
        .form-input:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(245, 158, 11, 0.2);
            border-color: #f59e0b;
        }
    </style>
</head>
<body class="bg-slate-50 relative min-h-screen">
    <!-- Decorative Blobs -->
    <div class="fixed top-0 left-0 w-[800px] h-[800px] bg-amber-200/40 rounded-full blur-[120px] -translate-x-1/2 -translate-y-1/2 -z-10 pointer-events-none"></div>
    <div class="fixed bottom-0 right-0 w-[600px] h-[600px] bg-blue-200/40 rounded-full blur-[120px] translate-x-1/3 translate-y-1/3 -z-10 pointer-events-none"></div>

    <?php include('../includes/header.php'); ?>

    <div class="container mx-auto px-4 py-16 max-w-7xl">
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="mb-8 max-w-4xl mx-auto bg-red-500/10 border border-red-500/20 text-red-600 px-6 py-4 rounded-2xl flex items-center backdrop-blur-md">
                <svg class="w-6 h-6 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-bold"><?= htmlspecialchars($_SESSION['error']) ?></span>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="flex flex-col lg:flex-row gap-10">
            <!-- Left Side: Package Details -->
            <div class="lg:w-1/2 space-y-8">
                <div class="glass-panel rounded-[2rem] overflow-hidden shadow-xl">
                    <div class="relative h-80">
                        <img src="<?= htmlspecialchars($package['image_url']) ?>" 
                             alt="<?= htmlspecialchars($package['title']) ?>"
                             class="w-full h-full object-cover"
                             onerror="this.src='../assets/images/default.jpg'">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/20 to-transparent"></div>
                        <div class="absolute top-6 left-6 bg-amber-500 text-white font-bold px-4 py-1.5 rounded-full text-sm shadow-lg">
                            <?= htmlspecialchars($package['duration']) ?>
                        </div>
                        <h1 class="absolute bottom-6 left-8 right-8 text-3xl font-extrabold text-white drop-shadow-md">
                            <?= htmlspecialchars($package['title']) ?>
                        </h1>
                    </div>
                    
                    <div class="p-8">
                        <div class="mb-8 pb-8 border-b border-gray-100">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Price Per Person</h3>
                            <p class="text-4xl font-black text-amber-500">
                                ETB <?= number_format($package['price'], 2) ?>
                            </p>
                        </div>
                        
                        <div class="mb-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Journey Overview
                            </h3>
                            <p class="text-gray-600 leading-relaxed font-medium">
                                <?= htmlspecialchars($package['description']) ?>
                            </p>
                        </div>
                        
                        <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Premium Inclusions</h3>
                            <ul class="space-y-3">
                                <li class="flex items-center text-gray-700 font-medium">
                                    <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center mr-3 shrink-0">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    </div>
                                    Luxury accommodations
                                </li>
                                <li class="flex items-center text-gray-700 font-medium">
                                    <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center mr-3 shrink-0">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    </div>
                                    Guided tours and activities
                                </li>
                                <li class="flex items-center text-gray-700 font-medium">
                                    <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center mr-3 shrink-0">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    </div>
                                    24/7 Concierge support
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Booking Form -->
            <div class="lg:w-1/2">
                <div class="glass-panel rounded-[2rem] p-10 shadow-xl sticky top-28">
                    <div class="mb-8">
                        <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Complete Reservation</h2>
                        <p class="text-gray-500 font-medium">Secure your spot for this unforgettable journey.</p>
                    </div>

                    <form method="POST" action="../includes/booking.php" id="bookingForm" class="space-y-6">
                        <input type="hidden" name="package_id" value="<?= $package_id ?>">
                        <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                        
                        <!-- Travel Date -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Travel Date</label>
                            <input type="date" name="travel_date" 
                                   class="form-input w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none text-gray-900 font-medium"
                                   min="<?= date('Y-m-d') ?>" 
                                   required>
                        </div>

                        <!-- Number of Travelers -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Number of Travelers</label>
                            <select name="travelers" 
                                    class="form-input w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none text-gray-900 font-medium appearance-none"
                                    required>
                                <option value="">Select party size...</option>
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?> Traveler<?= $i > 1 ? 's' : '' ?></option>
                                <?php endfor; ?>
                            </select>
                            
                            <!-- Dynamic Total Price -->
                            <div class="mt-4 p-4 bg-amber-50 rounded-xl border border-amber-100 flex justify-between items-center hidden" id="totalPriceBox">
                                <span class="font-bold text-gray-700">Total Investment:</span>
                                <span class="font-black text-xl text-amber-600" id="totalPriceDisplay"></span>
                            </div>
                        </div>

                        <!-- Special Requests -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Special Requests <span class="text-gray-400 font-normal">(Optional)</span></label>
                            <textarea name="special_requests" 
                                      class="form-input w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none text-gray-900 font-medium resize-none"
                                      rows="3"
                                      placeholder="Dietary requirements, accessibility needs, celebrations..."></textarea>
                        </div>

                        <!-- Terms Agreement -->
                        <div class="flex items-center mt-6">
                            <input type="checkbox" name="terms" id="terms" 
                                   class="w-5 h-5 text-amber-500 border-gray-300 rounded focus:ring-amber-500 cursor-pointer"
                                   required>
                            <label for="terms" class="ml-3 text-sm font-medium text-gray-600 cursor-pointer">
                                I agree to the <a href="#" class="text-amber-600 hover:text-amber-700 font-bold underline">terms and conditions</a>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full bg-gray-900 text-white font-extrabold text-lg py-5 px-6 rounded-xl hover:bg-amber-500 transition-colors duration-300 shadow-lg hover:shadow-amber-500/30 mt-8 flex items-center justify-center group">
                            Confirm Reservation
                            <svg class="w-6 h-6 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include('../includes/footer.php'); ?>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dateInput = document.querySelector('input[name="travel_date"]');
            dateInput.min = new Date().toISOString().split('T')[0];

            const pricePerPerson = <?= $package['price']; ?>;
            const travelersSelect = document.querySelector('select[name="travelers"]');
            const totalPriceBox = document.getElementById('totalPriceBox');
            const totalPriceDisplay = document.getElementById('totalPriceDisplay');

            travelersSelect.addEventListener('change', function () {
                const travelers = this.value;
                if (travelers) {
                    const totalPrice = pricePerPerson * travelers;
                    totalPriceDisplay.textContent = "ETB " + totalPrice.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    totalPriceBox.classList.remove('hidden');
                } else {
                    totalPriceBox.classList.add('hidden');
                }
            });

            document.getElementById('bookingForm').addEventListener('submit', function(e) {
                const travelers = document.querySelector('select[name="travelers"]');
                const terms = document.getElementById('terms');
                if (!travelers.value) {
                    alert('Please select number of travelers');
                    e.preventDefault();
                }
                if (!terms.checked) {
                    alert('You must agree to the terms and conditions');
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>