<?php
require_once __DIR__ . '/../includes/auth-helpers.php';
ogge_start_secure_session();
require_once __DIR__ . '/../includes/db-connect.php';

if (!isset($_SESSION['user_id'])) { ogge_redirect('Account.php'); }

$booking_id = (int)($_GET['booking_id'] ?? 0);
$status     = $_GET['status'] ?? 'failed';   // 'success' | 'failed'
$reason     = $_GET['reason'] ?? '';

if ($booking_id < 1) { ogge_redirect('my-booking.php'); }

// Always re-query the booking so we reflect the real DB state
$stmt = $db->prepare('SELECT b.*, p.title, p.price, p.image_url, u.email, u.name AS user_name
    FROM bookings b
    JOIN packages p ON b.package_id = p.id
    JOIN users u    ON b.user_id    = u.id
    WHERE b.id = ? AND b.user_id = ? LIMIT 1');
$stmt->bind_param('ii', $booking_id, $_SESSION['user_id']);
$stmt->execute();
$booking = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$booking) { ogge_redirect('my-booking.php'); }

// Trust the DB as source of truth; override URL param when booking is confirmed
if ($booking['payment_status'] === 'paid' && $booking['status'] === 'confirmed') {
    $status = 'success';
}

$total_amount  = $booking['price'] * $booking['travelers'];
$booking_ref   = str_pad($booking_id, 3, '0', STR_PAD_LEFT);
$tx_id         = htmlspecialchars($booking['transaction_id'] ?? '');
$is_success    = ($status === 'success');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $is_success ? 'Payment Confirmed' : 'Payment Failed' ?> | OGGE Travel</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=1.2">
    <link rel="stylesheet" href="../assets/css/luxury.css?v=1.2">
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes scaleIn {
            from { transform: scale(0.7); opacity: 0; }
            to   { transform: scale(1);   opacity: 1; }
        }
        .animate-fadeInUp { animation: fadeInUp 0.6s ease both; }
        .animate-scaleIn  { animation: scaleIn  0.5s cubic-bezier(.34,1.56,.64,1) both; }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
    </style>
</head>
<body class="bg-[#faf8f5] min-h-screen flex items-center justify-center p-4 md:p-8" style="font-family:'Inter',sans-serif;">

    <div class="max-w-2xl w-full">

        <?php if ($is_success): ?>
        <!-- ==================== SUCCESS STATE ==================== -->
        <div class="bg-white rounded-[2.5rem] shadow-2xl border border-slate-100 overflow-hidden animate-fadeInUp">

            <!-- Top accent bar -->
            <div class="h-1.5 bg-gradient-to-r from-emerald-400 via-emerald-500 to-teal-400"></div>

            <div class="p-10 md:p-14 text-center">

                <!-- Animated checkmark badge -->
                <div class="animate-scaleIn delay-100 w-24 h-24 mx-auto mb-8 rounded-full bg-gradient-to-br from-emerald-50 to-teal-50 flex items-center justify-center ring-8 ring-emerald-50">
                    <svg class="w-12 h-12 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>

                <p class="animate-fadeInUp delay-100 text-[0.65rem] font-black uppercase tracking-widest text-emerald-600 mb-2">Payment Confirmed</p>
                <h1 class="animate-fadeInUp delay-200 text-3xl md:text-4xl font-black text-[#0a0f1e] mb-3" style="font-family:'Playfair Display',serif;">
                    Your Journey is <span style="background:linear-gradient(135deg,#c9a96e,#e8d5a8);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">Confirmed!</span>
                </h1>
                <p class="animate-fadeInUp delay-300 text-slate-500 text-sm leading-relaxed mb-8 max-w-md mx-auto">
                    Thank you, <strong><?= htmlspecialchars($booking['user_name']) ?></strong>. Your booking has been confirmed and a confirmation email has been sent to <strong><?= htmlspecialchars($booking['email']) ?></strong>.
                </p>

                <!-- Booking summary card -->
                <div class="animate-fadeInUp delay-400 bg-[#0a0f1e] rounded-2xl overflow-hidden mb-8 text-left">
                    <?php if (!empty($booking['image_url'])): ?>
                    <div class="relative h-36 overflow-hidden">
                        <img src="<?= htmlspecialchars($booking['image_url']) ?>" class="w-full h-full object-cover opacity-60" alt="<?= htmlspecialchars($booking['title']) ?>">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0a0f1e] to-transparent"></div>
                        <p class="absolute bottom-4 left-6 text-white font-bold text-lg" style="font-family:'Playfair Display',serif;"><?= htmlspecialchars($booking['title']) ?></p>
                    </div>
                    <?php endif; ?>

                    <div class="p-6 grid grid-cols-2 gap-x-6 gap-y-4">
                        <div>
                            <p class="text-white/40 text-[0.6rem] uppercase tracking-widest font-bold mb-1">Booking Ref</p>
                            <p class="text-white font-bold">#<?= $booking_ref ?></p>
                        </div>
                        <div>
                            <p class="text-white/40 text-[0.6rem] uppercase tracking-widest font-bold mb-1">Travelers</p>
                            <p class="text-white font-bold"><?= (int)$booking['travelers'] ?> Pax</p>
                        </div>
                        <div>
                            <p class="text-white/40 text-[0.6rem] uppercase tracking-widest font-bold mb-1">Status</p>
                            <span class="inline-flex items-center gap-1.5 text-emerald-400 font-bold text-sm">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 inline-block"></span> Confirmed
                            </span>
                        </div>
                        <div>
                            <p class="text-white/40 text-[0.6rem] uppercase tracking-widest font-bold mb-1">Amount Paid</p>
                            <p class="text-[#c9a96e] font-black text-lg" style="font-family:'Playfair Display',serif;">ETB <?= number_format($total_amount, 2) ?></p>
                        </div>
                        <?php if ($tx_id): ?>
                        <div class="col-span-2">
                            <p class="text-white/40 text-[0.6rem] uppercase tracking-widest font-bold mb-1">Transaction ID</p>
                            <p class="text-white/70 text-xs font-mono break-all"><?= $tx_id ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Action buttons -->
                <div class="flex flex-col sm:flex-row gap-3 justify-center animate-fadeInUp delay-400">
                    <a href="my-booking.php" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-[#0a0f1e] text-white font-bold rounded-xl hover:bg-[#151e32] transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 text-sm">
                        <svg class="w-4 h-4 text-[#c9a96e]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        View My Bookings
                    </a>
                    <a href="packages.php" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
                        Explore More Packages
                    </a>
                </div>

            </div>
        </div>

        <?php else: ?>
        <!-- ==================== FAILURE STATE ==================== -->
        <div class="bg-white rounded-[2.5rem] shadow-2xl border border-slate-100 overflow-hidden animate-fadeInUp">

            <!-- Top accent bar -->
            <div class="h-1.5 bg-gradient-to-r from-rose-400 via-red-500 to-orange-400"></div>

            <div class="p-10 md:p-14 text-center">

                <!-- Warning badge -->
                <div class="animate-scaleIn delay-100 w-24 h-24 mx-auto mb-8 rounded-full bg-gradient-to-br from-red-50 to-rose-50 flex items-center justify-center ring-8 ring-red-50">
                    <svg class="w-12 h-12 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                </div>

                <p class="animate-fadeInUp delay-100 text-[0.65rem] font-black uppercase tracking-widest text-rose-600 mb-2">Payment Verification Failed</p>
                <h1 class="animate-fadeInUp delay-200 text-3xl md:text-4xl font-black text-[#0a0f1e] mb-3" style="font-family:'Playfair Display',serif;">
                    We Couldn't Confirm<br>Your Payment
                </h1>
                <p class="animate-fadeInUp delay-300 text-slate-500 text-sm leading-relaxed mb-8 max-w-md mx-auto">
                    Your payment was not verified successfully. If funds were deducted from your account, <strong>please do not pay again</strong> — contact our support team with your booking reference.
                </p>

                <!-- Booking reference card -->
                <div class="animate-fadeInUp delay-400 bg-slate-50 border border-slate-200 rounded-2xl p-6 mb-8 text-left space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-400 text-[0.6rem] uppercase tracking-widest font-bold mb-1">Booking Reference</p>
                            <p class="text-[#0a0f1e] font-black text-xl">#<?= $booking_ref ?></p>
                        </div>
                        <div class="text-right">
                            <p class="text-slate-400 text-[0.6rem] uppercase tracking-widest font-bold mb-1">Amount</p>
                            <p class="text-[#0a0f1e] font-black text-xl">ETB <?= number_format($total_amount, 2) ?></p>
                        </div>
                    </div>
                    <div class="border-t border-slate-200 pt-4">
                        <p class="text-slate-400 text-[0.6rem] uppercase tracking-widest font-bold mb-1">Package</p>
                        <p class="text-[#0a0f1e] font-bold text-sm"><?= htmlspecialchars($booking['title']) ?></p>
                    </div>
                    <div class="border-t border-slate-200 pt-4">
                        <p class="text-slate-400 text-[0.6rem] uppercase tracking-widest font-bold mb-1">Payment Status</p>
                        <span class="inline-flex items-center gap-1.5 text-amber-600 font-bold text-sm">
                            <span class="w-2 h-2 rounded-full bg-amber-400 inline-block"></span>
                            Pending — Awaiting Verification
                        </span>
                    </div>
                </div>

                <!-- What to do next -->
                <div class="animate-fadeInUp delay-400 bg-amber-50 border border-amber-100 rounded-2xl p-5 mb-8 text-left">
                    <p class="text-amber-900 font-black text-xs uppercase tracking-widest mb-3">What to do next</p>
                    <ul class="space-y-2">
                        <li class="flex items-start gap-2 text-amber-800 text-sm">
                            <svg class="w-4 h-4 mt-0.5 shrink-0 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Wait a few minutes and check your booking status — payments can sometimes take time to propagate.
                        </li>
                        <li class="flex items-start gap-2 text-amber-800 text-sm">
                            <svg class="w-4 h-4 mt-0.5 shrink-0 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            If funds were deducted, email us at <a href="mailto:support@oggetravel.com" class="underline font-semibold">support@oggetravel.com</a> with booking reference <strong>#<?= $booking_ref ?></strong>.
                        </li>
                        <li class="flex items-start gap-2 text-amber-800 text-sm">
                            <svg class="w-4 h-4 mt-0.5 shrink-0 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            If no funds were deducted, you can safely try the payment again using the button below.
                        </li>
                    </ul>
                </div>

                <!-- Action buttons -->
                <div class="flex flex-col sm:flex-row gap-3 justify-center animate-fadeInUp delay-400">
                    <a href="pay.php?booking_id=<?= $booking_id ?>" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-[#0a0f1e] text-white font-bold rounded-xl hover:bg-[#151e32] transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 text-sm">
                        <svg class="w-4 h-4 text-[#c9a96e]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        Try Payment Again
                    </a>
                    <a href="my-booking.php" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        View My Bookings
                    </a>
                </div>

            </div>
        </div>
        <?php endif; ?>

        <!-- Footer note -->
        <p class="text-center text-[0.6rem] text-slate-400 uppercase tracking-widest font-bold mt-6 flex items-center justify-center gap-1.5">
            <svg class="w-3 h-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
            Secured by 256-bit SSL &mdash; OGGE Travel &copy; <?= date('Y') ?>
        </p>

    </div>
</body>
</html>
