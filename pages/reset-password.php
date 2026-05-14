<?php
require_once __DIR__ . '/../includes/auth-helpers.php';
ogge_start_secure_session();
$token = trim($_GET['token'] ?? '');
$csrfToken = ogge_csrf_token();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | OGGE Travel</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=1.4">
    <link rel="stylesheet" href="../assets/css/luxury.css?v=1.4">
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

            <?php if ($token === ''): ?>
                <h2 class="text-3xl text-white mb-2" style="font-family:'Playfair Display',serif; font-weight:800;">Invalid <span class="text-champagne-gradient">Link</span></h2>
                <p class="text-gray-500 mb-8 text-sm">This reset link is missing or invalid. Request a new one below.</p>
                <a href="forgot-password.php" class="w-full block text-center py-4 bg-[#c9a96e] text-[#0a0f1e] rounded-xl font-bold text-sm uppercase tracking-wider hover:bg-[#e8d5a8] transition-all hover:shadow-lg">Request New Link</a>
            <?php else: ?>
                <h2 class="text-3xl text-white mb-2" style="font-family:'Playfair Display',serif; font-weight:800;">Set a New <span class="text-champagne-gradient">Password</span></h2>
                <p class="text-gray-500 mb-8 text-sm">Choose a strong password with at least 8 characters, one letter, and one number.</p>

                <form method="POST" action="../includes/reset-password.php" class="space-y-6" novalidate>
                    <input type="hidden" name="token" value="<?= htmlspecialchars($token); ?>">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                    <div class="relative">
                        <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-[0.15em]">New Password</label>
                        <input type="password" name="password" class="w-full px-5 py-4 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-[#c9a96e]/50 transition-all text-white font-medium placeholder-gray-600 pr-12" placeholder="8+ characters with a number" autocomplete="new-password" required minlength="8" maxlength="72" pattern="(?=.*[A-Za-z])(?=.*\d).{8,72}">
                    </div>
                    <div class="relative">
                        <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-[0.15em]">Confirm Password</label>
                        <input type="password" name="confirm_password" class="w-full px-5 py-4 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-[#c9a96e]/50 transition-all text-white font-medium placeholder-gray-600 pr-12" placeholder="Re-enter password" autocomplete="new-password" required minlength="8" maxlength="72">
                    </div>
                    <button type="submit" class="w-full py-4 bg-[#c9a96e] text-[#0a0f1e] rounded-xl font-bold text-sm uppercase tracking-wider hover:bg-[#e8d5a8] transition-all hover:shadow-lg">Update Password</button>
                </form>
            <?php endif; ?>

            <div class="mt-6 text-center">
                <a href="Account.php" class="text-xs uppercase tracking-wider text-gray-500 hover:text-[#c9a96e] font-semibold">Return to Sign In</a>
            </div>
        </div>
    </div>
</body>
</html>
