<?php
require_once __DIR__ . '/../includes/auth-helpers.php';
ogge_start_secure_session();
$authMode = $_GET['mode'] ?? ($_SESSION['auth_mode'] ?? 'login');
$authMode = $authMode === 'register' ? 'register' : 'login';
unset($_SESSION['auth_mode']);
$csrfToken = ogge_csrf_token();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | OGGE Travel</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=1.2">
    <link rel="stylesheet" href="../assets/css/luxury.css?v=1.2">
</head>
<body class="bg-[#0a0f1e] min-h-screen flex flex-col" style="font-family:'Inter',sans-serif;">

    <!-- Minimal header -->
    <div class="p-6 flex justify-between items-center max-w-7xl mx-auto w-full">
        <a href="<?= BASE_URL ?>/" class="flex items-center gap-3">
            <div class="w-9 h-9 bg-gradient-to-br from-[#c9a96e] to-[#e8d5a8] rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-[#0a0f1e]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <span class="text-xl text-white tracking-wide" style="font-family:'Playfair Display',serif; font-weight:700;">OGGE <span class="text-[#c9a96e]">Travel</span></span>
        </a>
        <a href="<?= BASE_URL ?>/" class="text-gray-500 text-xs font-semibold uppercase tracking-wider hover:text-[#c9a96e] transition-colors">← Back Home</a>
    </div>

    <!-- Auth Forms -->
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

            <!-- Tab Switcher -->
            <div class="flex bg-white/5 rounded-xl p-1 mb-10 border border-white/10">
                <button id="loginTab" onclick="switchTab('login')" class="flex-1 py-3 text-xs font-bold uppercase tracking-[0.2em] rounded-lg transition-all duration-300 text-white bg-white/10">Sign In</button>
                <button id="registerTab" onclick="switchTab('register')" class="flex-1 py-3 text-xs font-bold uppercase tracking-[0.2em] rounded-lg transition-all duration-300 text-gray-500 hover:text-white">Create Account</button>
            </div>

            <!-- Login Form -->
            <div id="loginForm">
                <h2 class="text-3xl text-white mb-2" style="font-family:'Playfair Display',serif; font-weight:800;">Welcome <span class="text-champagne-gradient">Back</span></h2>
                <p class="text-gray-500 mb-8 text-sm">Sign in to continue your journey.</p>
                <form method="POST" action="../includes/login.php" class="space-y-6" novalidate>
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-[0.15em]">Email Address</label>
                        <input type="email" name="email" autocomplete="email" maxlength="255" class="w-full px-5 py-4 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-[#c9a96e]/50 transition-all text-white font-medium placeholder-gray-600" placeholder="you@example.com" required>
                    </div>
                    <div class="relative">
                        <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-[0.15em]">Password</label>
                        <input type="password" name="password" autocomplete="current-password" class="w-full px-5 py-4 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-[#c9a96e]/50 transition-all text-white font-medium placeholder-gray-600 pr-12" placeholder="••••••••" required>
                        <button type="button" onclick="togglePassword(this)" class="absolute right-4 top-[40px] text-gray-500 hover:text-[#c9a96e] transition-colors focus:outline-none">
                            <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            <svg class="w-5 h-5 eye-slash-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                        </button>
                    </div>
                    <div class="text-right">
                        <a href="<?= BASE_URL ?>/forgot-password" class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-500 hover:text-[#c9a96e]">Forgot password?</a>
                    </div>
                    <button type="submit" class="w-full py-4 rounded-xl font-bold text-sm uppercase tracking-[0.2em] transition-all hover:bg-[#c9a96e] hover:text-[#0a0f1e] shadow-xl" style="background-color: #000000 !important; color: #ffffff !important; border: 1px solid rgba(255,255,255,0.1);">Sign In</button>
                </form>
            </div>

            <!-- Register Form -->
            <div id="registerForm" class="hidden">
                <h2 class="text-3xl text-white mb-2" style="font-family:'Playfair Display',serif; font-weight:800;">Begin Your <span class="text-champagne-gradient">Legacy</span></h2>
                <p class="text-gray-500 mb-4 text-sm">Create an account to access curated journeys.</p>
                <div class="mb-8 rounded-xl border border-[#c9a96e]/20 bg-[#c9a96e]/10 p-4 text-xs text-gray-300 leading-relaxed">
                    Use at least 8 characters with one letter and one number. We will sign you in automatically after account creation.
                </div>
                <form method="POST" action="../includes/register.php" class="space-y-6" novalidate>
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-[0.15em]">Full Name</label>
                        <input type="text" name="name" autocomplete="name" minlength="2" maxlength="120" class="w-full px-5 py-4 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-[#c9a96e]/50 transition-all text-white font-medium placeholder-gray-600" placeholder="Your full name" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-[0.15em]">Email Address</label>
                        <input type="email" name="email" autocomplete="email" maxlength="255" class="w-full px-5 py-4 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-[#c9a96e]/50 transition-all text-white font-medium placeholder-gray-600" placeholder="you@example.com" required>
                    </div>
                    <div class="relative">
                        <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-[0.15em]">Password</label>
                        <input type="password" name="password" class="w-full px-5 py-4 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-[#c9a96e]/50 transition-all text-white font-medium placeholder-gray-600 pr-12" placeholder="8+ characters with a number" autocomplete="new-password" required minlength="8" maxlength="72" pattern="(?=.*[A-Za-z])(?=.*\d).{8,72}">
                        <button type="button" onclick="togglePassword(this)" class="absolute right-4 top-[40px] text-gray-500 hover:text-[#c9a96e] transition-colors focus:outline-none">
                            <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            <svg class="w-5 h-5 eye-slash-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                        </button>
                    </div>
                    <div class="relative">
                        <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-[0.15em]">Confirm Password</label>
                        <input type="password" name="confirm_password" class="w-full px-5 py-4 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-[#c9a96e]/50 transition-all text-white font-medium placeholder-gray-600 pr-12" placeholder="Re-enter password" autocomplete="new-password" required minlength="8" maxlength="72">
                        <button type="button" onclick="togglePassword(this)" class="absolute right-4 top-[40px] text-gray-500 hover:text-[#c9a96e] transition-colors focus:outline-none">
                            <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            <svg class="w-5 h-5 eye-slash-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                        </button>
                    </div>
                    <button type="submit" class="w-full py-4 rounded-xl font-bold text-sm uppercase tracking-[0.2em] transition-all hover:bg-[#c9a96e] hover:text-[#0a0f1e] shadow-xl" style="background-color: #000000 !important; color: #ffffff !important; border: 1px solid rgba(255,255,255,0.1);">Create Account</button>
                </form>
            </div>
        </div>
    </div>

    <script>
    const initialAuthMode = <?= json_encode($authMode) ?>;

    function switchTab(tab) {
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');
        const loginTab = document.getElementById('loginTab');
        const registerTab = document.getElementById('registerTab');
        if (tab === 'login') {
            loginForm.classList.remove('hidden');
            registerForm.classList.add('hidden');
            loginTab.classList.add('bg-white/10', 'text-white');
            loginTab.classList.remove('text-gray-500');
            registerTab.classList.remove('bg-white/10', 'text-white');
            registerTab.classList.add('text-gray-500');
        } else {
            loginForm.classList.add('hidden');
            registerForm.classList.remove('hidden');
            registerTab.classList.add('bg-white/10', 'text-white');
            registerTab.classList.remove('text-gray-500');
            loginTab.classList.remove('bg-white/10', 'text-white');
            loginTab.classList.add('text-gray-500');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        switchTab(initialAuthMode);
    });

    function togglePassword(button) {
        const input = button.parentElement.querySelector('input');
        const eyeIcon = button.querySelector('.eye-icon');
        const eyeSlashIcon = button.querySelector('.eye-slash-icon');
        
        if (input.type === 'password') {
            input.type = 'text';
            eyeIcon.classList.add('hidden');
            eyeSlashIcon.classList.remove('hidden');
        } else {
            input.type = 'password';
            eyeIcon.classList.remove('hidden');
            eyeSlashIcon.classList.add('hidden');
        }
    }
    </script>
</body>
</html>
