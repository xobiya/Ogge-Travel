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
    header("Location: package-1.php");
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
    header("Location: package-1.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book <?= htmlspecialchars($package['title']) ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/custome.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <?php include('../includes/header.php'); ?>

    <div class="container mx-auto px-4 py-12">
        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Package Header -->
            <div class="bg-gray-50 p-2 border-b border-gray-200">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">
                    <?= htmlspecialchars($package['title']) ?>
                </h1>
                <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden">
                    <img src="<?= htmlspecialchars($package['image_url']) ?>" 
                         alt="<?= htmlspecialchars($package['title']) ?>"
                         class="w-full h-96 object-cover transition-opacity duration-300 hover:opacity-90"
                         onerror="this.src='../assets/images/default.jpg'">
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid md:grid-cols-2 gap-8 p-8">
                <!-- Package Details -->
                <div class="space-y-6">
                    <div class="prose max-w-none">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Package Details</h2>
                        <p class="text-gray-600 leading-relaxed">
                            <?= htmlspecialchars($package['description']) ?>
                        </p>
                    </div>
                    
                    <div class="mt-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Package Price</h3>
                        <p class="text-2xl font-bold text-blue-600">
                            ETB <?= number_format($package['price'], 2) ?>
                            <span class="text-sm font-normal text-gray-500">per person</span>
                        </p>
                    </div>

                    <div class="bg-blue-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-blue-800 mb-3">What's Included</h3>
                        <ul class="space-y-2 text-blue-700">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                                </svg>
                                Luxury accommodations
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                                </svg>
                                Guided tours and activities
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                                </svg>
                                24/7 Customer support
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Booking Form -->
                <div class="bg-gray-50 p-6 rounded-lg shadow-inner">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Booking Details</h2>
                    
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <?= htmlspecialchars($_SESSION['error']) ?>
                            <?php unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="../includes/booking.php" id="bookingForm">
                        <input type="hidden" name="package_id" value="<?= $package_id ?>">
                        <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                        

                        <div class="space-y-5">
                            <!-- Travel Date -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Travel Date</label>
                                <input type="date" name="travel_date" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       min="<?= date('Y-m-d') ?>" 
                                       required>
                            </div>

                            <!-- Number of Travelers -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Number of Travelers</label>
                                <select name="travelers" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                    <option value="">Select travelers...</option>
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?= $i ?>"><?= $i ?> Traveler<?= $i > 1 ? 's' : '' ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <!-- Special Requests -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Special Requests</label>
                                <textarea name="special_requests" 
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          rows="3"
                                          placeholder="Dietary requirements, accessibility needs, etc..."></textarea>
                            </div>

                            <!-- Terms Agreement -->
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" name="terms" id="terms" 
                                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                           required>
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="terms" class="font-medium text-gray-700">
                                        I agree to the <a href="#" class="text-blue-600 hover:text-blue-500">terms and conditions</a>
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" 
                                    class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors duration-200 font-medium">
                                Confirm Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include('../includes/footer.php'); ?>

    <!-- Simple JavaScript Validation -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Set minimum date for travel date input
            const dateInput = document.querySelector('input[name="travel_date"]');
            dateInput.min = new Date().toISOString().split('T')[0];

            // Basic form validation
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
        document.addEventListener('DOMContentLoaded', function () {
            const pricePerPerson = <?php echo $package['price']; ?>;
            const travelersSelect = document.querySelector('select[name="travelers"]');
            const totalPriceDisplay = document.createElement('div');
            totalPriceDisplay.className = 'mt-4 text-lg font-semibold text-gray-800';
            travelersSelect.parentElement.appendChild(totalPriceDisplay);

            travelersSelect.addEventListener('change', function () {
                const travelers = this.value;
                const totalPrice = pricePerPerson * travelers;
                totalPriceDisplay.textContent = `Total Price: ETB ptotalPrice.toFixed(2)}`;
            });
        });
    </script>
</body>
</html>