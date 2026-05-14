<?php
require_once __DIR__ . '/../includes/auth-helpers.php';
ogge_start_secure_session();
require_once __DIR__ . '/../includes/db-connect.php';
require_once __DIR__ . '/../includes/mail-helper.php';
require_once __DIR__ . '/../includes/stripe-helper.php';
require_once __DIR__ . '/../includes/chapa-helper.php';

if (!isset($_SESSION['user_id'])) { ogge_redirect(BASE_URL . '/account'); }
$booking_id = (int)($_GET['booking_id'] ?? 0);
if ($booking_id < 1) { ogge_redirect(BASE_URL . '/home'); }

$bookingStmt = $db->prepare('SELECT b.*, p.title, p.price, p.image_url, u.email, u.name as user_name
    FROM bookings b
    JOIN packages p ON b.package_id = p.id
    JOIN users u ON b.user_id = u.id
    WHERE b.id = ? AND b.user_id = ? LIMIT 1');
$bookingStmt->bind_param('ii', $booking_id, $_SESSION['user_id']);
$bookingStmt->execute();
$booking = $bookingStmt->get_result()->fetch_assoc();
$bookingStmt->close();

if (!$booking) { ogge_flash('error', 'Booking not found.'); ogge_redirect(BASE_URL . '/my-bookings'); }

$total_amount = $booking['price'] * $booking['travelers'];
$exchange_rate = 120.0; // Fixed conversion rate for USD
$total_usd = round($total_amount / $exchange_rate, 2);

// Handle Stripe Success Callback
if (isset($_GET['stripe_success']) && isset($_GET['session_id'])) {
    $stripe = new StripeHelper($config);
    $session = $stripe->getSession($_GET['session_id']);
    
    if ($session && $session['payment_status'] === 'paid') {
        $tx_id = $session['payment_intent'] ?? $session['id'];
        
        $upd = $db->prepare("UPDATE bookings SET payment_status = 'paid', transaction_id = ?, status = 'confirmed' WHERE id = ? AND user_id = ?");
        $upd->bind_param('sii', $tx_id, $booking_id, $_SESSION['user_id']);
        $upd->execute();
        $upd->close();
        
        sendCustomerNotification($booking['email'], "Payment Received! #$booking_id", "Your payment of ETB $total_amount via Stripe has been received. Your journey is now confirmed! Transaction ID: $tx_id");
        
        ogge_flash('success', "Payment successful via Stripe! Your journey is confirmed.");
        ogge_redirect(BASE_URL . '/my-bookings');
    } else {
        error_log('Stripe Verification Failed for Session: ' . ($_GET['session_id'] ?? 'none'));
        ogge_flash('error', 'Could not verify payment. Please contact support with your booking ID.');
    }
}

// Handle Chapa Success Callback
if (isset($_GET['chapa_success']) && isset($_GET['tx_ref'])) {
    $chapa = new ChapaHelper($config);
    $verification = $chapa->verifyTransaction($_GET['tx_ref']);
    
    if ($verification && ($verification['status'] === 'success' || ($verification['data']['status'] ?? '') === 'success')) {
        $tx_id = $_GET['tx_ref'];
        
        $upd = $db->prepare("UPDATE bookings SET payment_status = 'paid', transaction_id = ?, status = 'confirmed' WHERE id = ? AND user_id = ?");
        $upd->bind_param('sii', $tx_id, $booking_id, $_SESSION['user_id']);
        $upd->execute();
        $upd->close();
        
        sendCustomerNotification($booking['email'], "Payment Received! #$booking_id", "Your payment of ETB $total_amount via Chapa has been received. Your journey is now confirmed! Transaction ID: $tx_id");
        
        ogge_flash('success', "Payment successful via Chapa! Your journey is confirmed.");
        ogge_redirect(BASE_URL . '/my-bookings');
    } else {
        error_log('Chapa Verification Failed: ' . json_encode($verification));
        ogge_flash('error', 'Could not verify Chapa payment. Please contact support.');
    }
}

// Handle Stripe Cancel
if (isset($_GET['stripe_cancel'])) {
    ogge_flash('warning', 'Payment was cancelled. You can try again.');
}

// Handle payment processing
if (isset($_POST['process_payment'])) {
    if (!ogge_validate_csrf($_POST['csrf_token'] ?? null)) {
        ogge_flash('error', 'Your session expired. Please try payment again.');
        ogge_redirect(BASE_URL . '/pay?booking_id=' . $booking_id);
    }
    $method = $_POST['payment_method'] ?? 'chapa';
    
    // ... (keeping the existing Stripe/Chapa initialization logic from the original file)
    // I will include the core processing block but focus the visual rewrite on the HTML/CSS.
    
    $prefixes = ['chapa' => 'CHAP_', 'telebirr' => 'TB_', 'stripe' => 'pi_3M', 'cbe' => 'FT_', 'card' => 'CARD_'];
    if (!array_key_exists($method, $prefixes)) { $method = 'chapa'; }

    if ($method === 'stripe') {
        if (empty($config['stripe_secret_key']) || strpos($config['stripe_secret_key'], 'YOUR_SECRET_KEY') !== false) {
            ogge_flash('error', 'Stripe payment is currently unavailable.');
            ogge_redirect(BASE_URL . '/pay?booking_id=' . $booking_id);
        }
        $stripe = new StripeHelper($config);
        // Ensure Stripe gets the USD amount if currency is USD
        $stripe_amount = ($config['stripe_currency'] ?? 'USD') === 'USD' ? $total_usd : $total_amount;
        $session = $stripe->createCheckoutSession($booking_id, $stripe_amount, $config['stripe_currency'] ?? 'USD', "Booking #$booking_id: " . $booking['title']);
        if (isset($session['url'])) { header("Location: " . $session['url']); exit(); }
    }

    if ($method === 'chapa') {
        if (empty($config['chapa_secret_key']) || strpos($config['chapa_secret_key'], 'YOUR_SECRET_KEY') !== false) {
            ogge_flash('error', 'Chapa payment is currently unavailable.');
            ogge_redirect(BASE_URL . '/pay?booking_id=' . $booking_id);
        }
        $chapa = new ChapaHelper($config);
        $tx_ref = 'OGGE_' . $booking_id . '_' . time();
        $nameParts = explode(' ', trim($booking['user_name'] ?? 'Guest User'));
        $init = $chapa->initializeTransaction([
            'amount' => $total_amount, 'currency' => 'ETB', 'email' => $booking['email'],
            'first_name' => $nameParts[0], 'last_name' => $nameParts[1] ?? 'User', 'tx_ref' => $tx_ref,
            'booking_id' => $booking_id, 'description' => "Booking #$booking_id: " . $booking['title']
        ]);
        if (isset($init['data']['checkout_url'])) { header("Location: " . $init['data']['checkout_url']); exit(); }
    }

    // Default mock processing for other methods
    $tx_id = $prefixes[$method] . strtoupper(substr(md5(time()), 0, 10));
    $upd = $db->prepare("UPDATE bookings SET payment_status = 'paid', transaction_id = ?, status = 'confirmed' WHERE id = ? AND user_id = ?");
    $upd->bind_param('sii', $tx_id, $booking_id, $_SESSION['user_id']);
    $upd->execute();
    $upd->close();
    
    sendCustomerNotification($booking['email'], "Payment Received! #$booking_id", "Your payment of ETB $total_amount has been received.");
    ogge_flash('success', "Payment successful! Your journey is confirmed.");
    ogge_redirect(BASE_URL . '/my-bookings');
}

$csrfToken = ogge_csrf_token();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Settlement | OGGE Travel</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=1.4">
    <link rel="stylesheet" href="../assets/css/luxury.css?v=1.4">
    <script src="../assets/js/script.js?v=1.3"></script>
    <style>
        .payment-card-active {
            @apply border-[#b69150] bg-[#b69150]/5 ring-1 ring-[#b69150];
        }
    </style>
</head>
<body class="bg-[#faf8f5] min-h-screen flex items-center justify-center p-4">
    <div class="max-w-6xl w-full bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-100 flex flex-col lg:flex-row min-h-[550px]">

        
        <!-- Left: Summary Panel -->
        <div class="lg:w-[45%] bg-[#0a0f1e] relative p-10 text-white flex flex-col overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <img src="<?= htmlspecialchars($booking['image_url'] ?? '../assets/images/historical.jpg') ?>" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0a0f1e] to-transparent"></div>
            </div>

            <div class="relative z-10 flex flex-col h-full">
                <div class="flex justify-between items-center mb-8">
                    <a href="my-booking.php" class="text-white/40 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <p class="text-champagne text-[10px] font-bold uppercase tracking-[0.2em]">OGGE-<?= str_pad($booking_id, 4, '0', STR_PAD_LEFT) ?></p>
                </div>

                <div class="w-10 h-10 bg-champagne rounded-xl mb-4 flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 text-navy-950" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                
                <h2 class="text-2xl mb-6" style="font-family:'Playfair Display',serif; font-weight:800;">Secure <br>Settlement</h2>

                <div class="space-y-4 flex-grow">
                    <div class="pb-4 border-b border-white/5">
                        <p class="text-white/40 text-[9px] font-bold uppercase tracking-widest mb-1">The Experience</p>
                        <p class="text-base font-medium" style="font-family:'Playfair Display',serif;"><?= htmlspecialchars($booking['title']) ?></p>
                    </div>
                    <div class="grid grid-cols-2 gap-4 pb-4 border-b border-white/5">
                        <div>
                            <p class="text-white/40 text-[9px] font-bold uppercase tracking-widest mb-1">Guests</p>
                            <p class="text-sm font-medium"><?= $booking['travelers'] ?></p>
                        </div>
                        <div>
                            <p class="text-white/40 text-[9px] font-bold uppercase tracking-widest mb-1">Departure</p>
                            <p class="text-sm font-medium"><?= !empty($booking['start_date']) ? date('M d, Y', strtotime($booking['start_date'])) : 'TBD' ?></p>
                        </div>
                    </div>
                    <div>
                        <p class="text-champagne text-[9px] font-bold uppercase tracking-widest mb-1">Total Investment</p>
                        <p class="text-3xl font-black text-white" style="font-family:'Playfair Display',serif;">ETB <?= number_format($total_amount, 0) ?></p>
                        <p class="text-white/40 text-[11px] font-medium mt-1">Approx. $<?= number_format($total_usd, 2) ?> USD</p>
                    </div>
                </div>

                <div class="mt-auto pt-6 flex items-center gap-3">
                    <div class="w-6 h-6 rounded-full bg-white/5 flex items-center justify-center">
                        <svg class="w-3 h-3 text-champagne" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                    </div>
                    <p class="text-[8px] text-white/40 uppercase tracking-[0.2em]">End-to-End Secure</p>
                </div>
            </div>
        </div>

        <!-- Right: Payment Methods Panel -->
        <div class="lg:w-[55%] p-10 flex flex-col justify-center">
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="mb-6 p-4 bg-red-50 border border-red-100 text-red-700 rounded-2xl flex items-center gap-3 animate-fade-up">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-xs font-semibold"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></p>
                </div>
            <?php endif; ?>

            <div class="mb-8">
                <span class="text-champagne-gradient text-[10px] font-bold uppercase tracking-[0.4em] block mb-2">Payment Gateway</span>
                <h2 class="text-2xl text-navy-950 mb-3" style="font-family:'Playfair Display',serif; font-weight:900;">Secure <span class="italic">Checkout</span></h2>
                <div class="h-0.5 w-10 bg-[#c9a96e] rounded-full"></div>
            </div>

            <form method="POST" class="space-y-6">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                
                <div class="space-y-4">
                    <!-- Chapa -->
                    <label class="relative group cursor-pointer block">
                        <input type="radio" name="payment_method" value="chapa" class="peer sr-only" checked>
                        <div class="p-5 border-2 border-gray-50 rounded-3xl bg-white transition-all duration-500 peer-checked:border-[#c9a96e] peer-checked:shadow-[0_20px_40px_rgba(201,169,110,0.1)] hover:shadow-xl hover:translate-y-[-2px]">
                            <div class="flex items-center gap-5">
                                <div class="w-14 h-14 bg-gray-50 rounded-2xl flex items-center justify-center p-2 transition-transform group-hover:scale-105">
                                    <img src="../assets/chapa.jpg" class="w-full h-full object-contain rounded-lg" alt="Chapa">
                                </div>
                                <div class="flex-grow">
                                    <h4 class="text-navy-950 font-bold text-base mb-0.5">Chapa</h4>
                                    <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">Local Pay: ETB <?= number_format($total_amount, 0) ?></p>
                                </div>
                                <div class="w-5 h-5 border-2 border-gray-200 rounded-full flex items-center justify-center peer-checked:border-[#c9a96e] transition-colors">
                                    <div class="w-2.5 h-2.5 bg-[#c9a96e] rounded-full scale-0 peer-checked:scale-100 transition-transform duration-300"></div>
                                </div>
                            </div>
                        </div>
                    </label>

                    <!-- Stripe -->
                    <label class="relative group cursor-pointer block">
                        <input type="radio" name="payment_method" value="stripe" class="peer sr-only">
                        <div class="p-5 border-2 border-gray-100 rounded-3xl bg-white transition-all duration-500 peer-checked:border-[#c9a96e] peer-checked:shadow-[0_20px_40px_rgba(201,169,110,0.1)] hover:shadow-xl hover:translate-y-[-2px]">
                            <div class="flex items-center gap-5">
                                <div class="w-14 h-14 bg-gray-50 rounded-2xl flex items-center justify-center p-2 transition-transform group-hover:scale-105">
                                    <img src="../assets/stripe.png" class="w-full h-full object-contain rounded-lg" alt="Stripe">
                                </div>
                                <div class="flex-grow">
                                    <h4 class="text-navy-950 font-bold text-base mb-0.5">Stripe</h4>
                                    <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">Global Pay: $<?= number_format($total_usd, 2) ?> USD</p>
                                </div>
                                <div class="w-5 h-5 border-2 border-gray-200 rounded-full flex items-center justify-center peer-checked:border-[#c9a96e] transition-colors">
                                    <div class="w-2.5 h-2.5 bg-[#c9a96e] rounded-full scale-0 peer-checked:scale-100 transition-transform duration-300"></div>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>


                <div class="pt-4">
                    <button type="submit" name="process_payment" class="btn-dark w-full py-5 text-base flex justify-center items-center gap-3 shadow-xl">
                        Confirm & Proceed
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </button>


                    
                    <div class="mt-8 flex flex-wrap items-center justify-center gap-6 grayscale opacity-30">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" alt="Visa" class="h-3">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="MasterCard" class="h-5">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal" class="h-3">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/c/cb/Stripe_Logo%2C_revised_2016.svg" alt="Stripe" class="h-5">
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
