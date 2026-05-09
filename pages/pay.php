<?php
require_once __DIR__ . '/../includes/auth-helpers.php';
ogge_start_secure_session();
require_once __DIR__ . '/../includes/db-connect.php';
require_once __DIR__ . '/../includes/mail-helper.php';

if (!isset($_SESSION['user_id'])) { ogge_redirect('Account.php'); }
$booking_id = (int)($_GET['booking_id'] ?? 0);
if ($booking_id < 1) { ogge_redirect('index.php'); }

$bookingStmt = $db->prepare('SELECT b.*, p.title, p.price, u.email
    FROM bookings b
    JOIN packages p ON b.package_id = p.id
    JOIN users u ON b.user_id = u.id
    WHERE b.id = ? AND b.user_id = ? LIMIT 1');
$bookingStmt->bind_param('ii', $booking_id, $_SESSION['user_id']);
$bookingStmt->execute();
$booking = $bookingStmt->get_result()->fetch_assoc();
$bookingStmt->close();

if (!$booking) { ogge_flash('error', 'Booking not found.'); ogge_redirect('my-booking.php'); }

$total_amount = $booking['price'] * $booking['travelers'];

// Handle Stripe success redirect: ?stripe_success=1&session_id=...
if (isset($_GET['stripe_success']) && (int)$_GET['stripe_success'] === 1) {
    $session_id = preg_replace('/[^A-Za-z0-9_\-]/', '', $_GET['session_id'] ?? '');
    $tx_id = $session_id ?: ('STRIPE_' . strtoupper(substr(md5(time()), 0, 10)));

    $upd = $db->prepare("UPDATE bookings SET payment_status = 'paid', transaction_id = ?, status = 'confirmed' WHERE id = ? AND user_id = ? AND payment_status != 'paid'");
    $upd->bind_param('sii', $tx_id, $booking_id, $_SESSION['user_id']);
    $upd->execute();
    $upd->close();

    sendCustomerNotification($booking['email'], "Payment Received! #$booking_id", "Your payment of ETB $total_amount via Stripe has been received. Your journey is now confirmed! Transaction ID: $tx_id");

    ogge_flash('success', 'Payment successful via Stripe! Your journey is confirmed.');
    ogge_redirect('my-booking.php');
}

// Handle simulated callback
if (isset($_POST['simulate_payment'])) {
    if (!ogge_validate_csrf($_POST['csrf_token'] ?? null)) {
        ogge_flash('error', 'Your session expired. Please try payment again.');
        ogge_redirect('pay.php?booking_id=' . $booking_id);
    }
    $method = $_POST['payment_method'] ?? 'chapa';
    
    // Generate gateway-specific transaction prefix
    $prefixes = [
        'chapa' => 'CHAP_',
        'telebirr' => 'TB_',
        'stripe' => 'pi_3M',
        'cbe' => 'FT_',
        'card' => 'CARD_'
    ];
    if (!array_key_exists($method, $prefixes)) { $method = 'chapa'; }
    $prefix = $prefixes[$method];
    $tx_id = $prefix . strtoupper(substr(md5(time()), 0, 10));
    
    $method_names = [
        'chapa' => 'Chapa',
        'telebirr' => 'Telebirr',
        'stripe' => 'Stripe',
        'cbe' => 'CBE Birr',
        'card' => 'Credit/Debit Card'
    ];
    $method_name = $method_names[$method] ?? 'Gateway';

    $upd = $db->prepare("UPDATE bookings SET payment_status = 'paid', transaction_id = ?, status = 'confirmed' WHERE id = ? AND user_id = ?");
    $upd->bind_param('sii', $tx_id, $booking_id, $_SESSION['user_id']);
    $upd->execute();
    $upd->close();
    
    sendCustomerNotification($booking['email'], "Payment Received! #$booking_id", "Your payment of ETB $total_amount via $method_name has been received. Your journey is now confirmed! Transaction ID: $tx_id");
    
    $_SESSION['success'] = "Payment successful via $method_name! Your journey is confirmed.";
    header("Location: my-booking.php");
    exit();
}
$csrfToken = ogge_csrf_token();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Secure Payment | OGGE Travel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/luxury.css">
</head>
<body class="bg-[#faf8f5] min-h-screen flex items-center justify-center p-4 md:p-8" style="font-family:'Inter',sans-serif;">
    <div class="max-w-5xl w-full bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-slate-100 flex flex-col lg:flex-row">
        
        <!-- Left Column: Order Summary -->
        <div class="lg:w-[45%] bg-[#0a0f1e] relative overflow-hidden flex flex-col justify-between p-10 lg:p-12 text-white">
            <!-- Background Image -->
            <div class="absolute inset-0 opacity-20">
                <img src="<?= htmlspecialchars($booking['image_url'] ?? '../assets/images/default.jpg') ?>" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0a0f1e] via-[#0a0f1e]/80 to-transparent"></div>
            </div>

            <div class="relative z-10">
                <div class="w-14 h-14 bg-gradient-to-br from-[#c9a96e] to-[#e8d5a8] rounded-2xl mb-8 flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-slate-900" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <h2 class="text-3xl font-bold mb-2" style="font-family:'Playfair Display',serif;">Secure Checkout</h2>
                <p class="text-white/50 text-xs uppercase tracking-widest font-bold">Booking #<?= str_pad($booking_id, 3, '0', STR_PAD_LEFT) ?></p>
            </div>

            <div class="relative z-10 mt-12 space-y-6">
                <div class="pb-6 border-b border-white/10">
                    <p class="text-white/40 text-[0.65rem] font-bold uppercase tracking-widest mb-1">Curated Journey</p>
                    <p class="text-lg font-bold text-white"><?= htmlspecialchars($booking['title']) ?></p>
                </div>
                <div class="flex justify-between items-end pb-6 border-b border-white/10">
                    <div>
                        <p class="text-white/40 text-[0.65rem] font-bold uppercase tracking-widest mb-1">Travelers</p>
                        <p class="text-base font-bold text-white"><?= $booking['travelers'] ?> Pax</p>
                    </div>
                </div>
                <div class="pt-2">
                    <p class="text-white/40 text-[0.65rem] font-bold uppercase tracking-widest mb-2">Total Investment</p>
                    <p class="text-4xl text-[#c9a96e] font-black" style="font-family:'Playfair Display',serif;">ETB <?= number_format($total_amount, 2) ?></p>
                </div>
            </div>
        </div>

        <!-- Right Column: Payment Methods -->
        <div class="lg:w-[55%] p-10 lg:p-12 flex flex-col justify-center bg-white">
            
            <div class="bg-amber-50 border border-amber-100 p-5 rounded-2xl flex gap-4 mb-8">
                <div class="w-8 h-8 rounded-full bg-amber-200/50 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-amber-700" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h4 class="text-xs font-black uppercase tracking-widest text-amber-900 mb-1">Simulation Mode</h4>
                    <p class="text-[0.7rem] text-amber-800/80 leading-relaxed font-medium">Select your preferred payment gateway below. No real funds will be deducted during this test phase.</p>
                </div>
            </div>

            <form method="POST" class="space-y-8">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                <div class="space-y-4">
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Select Gateway</p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label class="relative flex items-center p-4 border border-slate-200 rounded-2xl cursor-pointer hover:bg-slate-50 transition-all has-[:checked]:border-[#c9a96e] has-[:checked]:bg-[#c9a96e]/5 has-[:checked]:ring-1 has-[:checked]:ring-[#c9a96e] group">
                            <input type="radio" name="payment_method" value="chapa" class="absolute opacity-0" checked>
                            <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center font-black text-[0.65rem] text-slate-400 group-has-[:checked]:text-[#c9a96e] group-has-[:checked]:bg-white shadow-sm transition-all mr-4">CH</div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">Chapa</p>
                                <p class="text-[0.6rem] font-medium text-slate-400 mt-0.5">Mobile & Cards</p>
                            </div>
                        </label>

                        <label class="relative flex items-center p-4 border border-slate-200 rounded-2xl cursor-pointer hover:bg-slate-50 transition-all has-[:checked]:border-[#c9a96e] has-[:checked]:bg-[#c9a96e]/5 has-[:checked]:ring-1 has-[:checked]:ring-[#c9a96e] group">
                            <input type="radio" name="payment_method" value="telebirr" class="absolute opacity-0">
                            <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center font-black text-[0.65rem] text-slate-400 group-has-[:checked]:text-[#c9a96e] group-has-[:checked]:bg-white shadow-sm transition-all mr-4">TB</div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">Telebirr</p>
                                <p class="text-[0.6rem] font-medium text-slate-400 mt-0.5">Ethio Telecom</p>
                            </div>
                        </label>

                        <label class="relative flex items-center p-4 border border-slate-200 rounded-2xl cursor-pointer hover:bg-slate-50 transition-all has-[:checked]:border-[#c9a96e] has-[:checked]:bg-[#c9a96e]/5 has-[:checked]:ring-1 has-[:checked]:ring-[#c9a96e] group">
                            <input type="radio" name="payment_method" value="stripe" class="absolute opacity-0">
                            <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center font-black text-[0.65rem] text-slate-400 group-has-[:checked]:text-[#c9a96e] group-has-[:checked]:bg-white shadow-sm transition-all mr-4">ST</div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">Stripe</p>
                                <p class="text-[0.6rem] font-medium text-slate-400 mt-0.5">Global Cards</p>
                            </div>
                        </label>

                        <label class="relative flex items-center p-4 border border-slate-200 rounded-2xl cursor-pointer hover:bg-slate-50 transition-all has-[:checked]:border-[#c9a96e] has-[:checked]:bg-[#c9a96e]/5 has-[:checked]:ring-1 has-[:checked]:ring-[#c9a96e] group">
                            <input type="radio" name="payment_method" value="cbe" class="absolute opacity-0">
                            <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center font-black text-[0.65rem] text-slate-400 group-has-[:checked]:text-[#c9a96e] group-has-[:checked]:bg-white shadow-sm transition-all mr-4">CBE</div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">CBE Birr</p>
                                <p class="text-[0.6rem] font-medium text-slate-400 mt-0.5">Direct Transfer</p>
                            </div>
                        </label>

                        <label class="relative flex items-center p-4 border border-slate-200 rounded-2xl cursor-pointer hover:bg-slate-50 transition-all has-[:checked]:border-[#c9a96e] has-[:checked]:bg-[#c9a96e]/5 has-[:checked]:ring-1 has-[:checked]:ring-[#c9a96e] group sm:col-span-2">
                            <input type="radio" name="payment_method" value="card" class="absolute opacity-0">
                            <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center font-black text-[0.65rem] text-slate-400 group-has-[:checked]:text-[#c9a96e] group-has-[:checked]:bg-white shadow-sm transition-all mr-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">Direct Credit / Debit Card</p>
                                <p class="text-[0.65rem] font-medium text-slate-400 mt-0.5">Visa, MasterCard, American Express Supported</p>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100">
                    <button type="submit" name="simulate_payment" class="w-full py-4 bg-[#0a0f1e] text-white font-black rounded-xl shadow-xl hover:shadow-2xl hover:bg-[#151e32] hover:-translate-y-0.5 transition-all active:scale-95 flex justify-center items-center gap-3">
                        <svg class="w-5 h-5 text-[#c9a96e]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Confirm & Process Payment
                    </button>
                    
                    <p class="text-center text-[0.65rem] font-bold text-slate-400 flex items-center justify-center gap-1.5 mt-5 uppercase tracking-widest">
                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                        Secured by 256-bit SSL Encryption
                    </p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
