<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | OGGE Travel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/luxury.css">
</head>
<body class="bg-[#0a0f1e] min-h-screen flex flex-col" style="font-family:'Inter',sans-serif;">

    <!-- Minimal header -->
    <div class="p-6 flex justify-between items-center max-w-7xl mx-auto w-full">
        <a href="index.php" class="flex items-center gap-3">
            <div class="w-9 h-9 bg-gradient-to-br from-[#c9a96e] to-[#e8d5a8] rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-[#0a0f1e]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <span class="text-xl text-white tracking-wide" style="font-family:'Playfair Display',serif; font-weight:700;">OGGE <span class="text-[#c9a96e]">Travel</span></span>
        </a>
        <a href="index.php" class="text-gray-500 text-xs font-semibold uppercase tracking-wider hover:text-[#c9a96e] transition-colors">← Back Home</a>
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
                <form method="POST" action="../includes/login.php" class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-[0.15em]">Email Address</label>
                        <input type="email" name="email" class="w-full px-5 py-4 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-[#c9a96e]/50 transition-all text-white font-medium placeholder-gray-600" placeholder="you@example.com" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-[0.15em]">Password</label>
                        <input type="password" name="password" class="w-full px-5 py-4 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-[#c9a96e]/50 transition-all text-white font-medium placeholder-gray-600" placeholder="••••••••" required>
                    </div>
                    <button type="submit" class="w-full py-4 bg-[#c9a96e] text-[#0a0f1e] rounded-xl font-bold text-sm uppercase tracking-wider hover:bg-[#e8d5a8] transition-all hover:shadow-lg">Sign In</button>
                </form>
            </div>

            <!-- Register Form -->
            <div id="registerForm" class="hidden">
                <h2 class="text-3xl text-white mb-2" style="font-family:'Playfair Display',serif; font-weight:800;">Begin Your <span class="text-champagne-gradient">Legacy</span></h2>
                <p class="text-gray-500 mb-8 text-sm">Create an account to access curated journeys.</p>
                <form method="POST" action="../includes/register.php" class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-[0.15em]">Full Name</label>
                        <input type="text" name="name" class="w-full px-5 py-4 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-[#c9a96e]/50 transition-all text-white font-medium placeholder-gray-600" placeholder="Your full name" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-[0.15em]">Email Address</label>
                        <input type="email" name="email" class="w-full px-5 py-4 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-[#c9a96e]/50 transition-all text-white font-medium placeholder-gray-600" placeholder="you@example.com" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-[0.15em]">Password</label>
                        <input type="password" name="password" class="w-full px-5 py-4 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-[#c9a96e]/50 transition-all text-white font-medium placeholder-gray-600" placeholder="Minimum 6 characters" required minlength="6">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-[0.15em]">Confirm Password</label>
                        <input type="password" name="confirm_password" class="w-full px-5 py-4 bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:border-[#c9a96e]/50 transition-all text-white font-medium placeholder-gray-600" placeholder="Re-enter password" required minlength="6">
                    </div>
                    <button type="submit" class="w-full py-4 bg-[#c9a96e] text-[#0a0f1e] rounded-xl font-bold text-sm uppercase tracking-wider hover:bg-[#e8d5a8] transition-all hover:shadow-lg">Create Account</button>
                </form>
            </div>
        </div>
    </div>

    <script>
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
    </script>
</body>
</html>