<?php
require_once __DIR__ . '/../includes/auth-helpers.php';
ogge_start_secure_session();
$csrfToken = ogge_csrf_token();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | OGGE Travel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/luxury.css">
</head>
<body class="bg-[#0a0f1e] min-h-screen flex flex-col" style="font-family:'Inter',sans-serif;">

    <div class="p-6 flex justify-between items-center max-w-7xl mx-auto w-full">
        <a href="index.php" class="flex items-center gap-3">
            <div class="w-9 h-9 bg-gradient-to-br from-[#c9a96e] to-[#e8d5a8] rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-[#0a0f1e]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <span class="text-xl text-white tracking-wide" style="font-family:'Playfair Display',serif; font-weight:700;">OGGE <span class="text-[#c9a96e]">Travel</span></span>
        </a>
        <a href="Account.php" class="text-gray-500 text-xs font-semibold uppercase tracking-wider hover:text-[#c9a96e] transition-colors"><- Back to Sign In</a>
    </div>

    <div class="flex-1 flex items-center justify-center px-6 pb-12">
        <div class="w-full max-w-md">

            <?php if (isset($_SESSION['error'])): ?>
            <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-400 px-5 py-4 rounded-xl flex items-center text-sm font-medium">
                <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
            <div class="mb-6 bg-green-500/10 border border-green-500/20 text-green-400 px-5 py-4 rounded-xl flex items-center text-sm font-medium">
                <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
            </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['reset_link'])): ?>
            <div class="mb-6 bg-white/5 border border-white/10 text-gray-300 px-5 py-4 rounded-xl text-sm">
                <p class="font-semibold text-white mb-2">Email delivery is not configured.</p>
                <p class="break-all">Use this reset link: <a href="<?= htmlspecialchars($_SESSION['reset_link']); ?>" class="text-[#c9a96e] hover:underline"><?= htmlspecialchars($_SESSION['reset_link']); ?></a></p>
                <?php unset($_SESSION['reset_link']); ?>
            </div>
            <?php endif; ?>

            <h2 class="text-3xl text-white mb-2" style="font-family:'Playfair Display',serif; font-weight:800;">Reset Your <span class="text-champagne-gradient">Password</span></h2>
            <p class="text-gray-500 mb-8 text-sm">Enter your email and we will send a secure reset link.</p>

            <form method="POST" action="../includes/forgot-password.php" class="space-y-6" novalidate>
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-[0.15em]">Email Address</label>
                    <input type="email" name="email" autocomplete="email" maxlength="255" class="w-full px-5 py-4 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-[#c9a96e]/50 transition-all text-white font-medium placeholder-gray-600" placeholder="you@example.com" required>
                </div>
                <button type="submit" class="w-full py-4 bg-[#c9a96e] text-[#0a0f1e] rounded-xl font-bold text-sm uppercase tracking-wider hover:bg-[#e8d5a8] transition-all hover:shadow-lg">Send Reset Link</button>
            </form>

            <div class="mt-6 text-center">
                <a href="Account.php" class="text-xs uppercase tracking-wider text-gray-500 hover:text-[#c9a96e] font-semibold">Return to Sign In</a>
            </div>
        </div>
    </div>
</body>
</html>
