<?php
// Start the session if it hasn't already been started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="sticky top-0 z-50 bg-white/90 backdrop-blur-xl border-b border-gray-100 shadow-sm w-full transition-all duration-300" id="mainHeader">
    <nav class="container mx-auto px-4 py-4 max-w-7xl">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <a href="../pages/index.php" class="text-2xl font-extrabold text-gray-900 flex items-center space-x-3 group">
                <div class="bg-gradient-to-br from-amber-400 to-orange-500 p-2 rounded-xl shadow-md transform group-hover:rotate-6 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="tracking-tight">OGGE <span class="text-amber-500">TRAVEL</span></span>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-2">
                <a href="../pages/index.php" class="px-4 py-2 text-gray-600 font-bold rounded-xl hover:text-gray-900 hover:bg-gray-50 transition-all">Home</a>
                <a href="../pages/Destination.php" class="px-4 py-2 text-gray-600 font-bold rounded-xl hover:text-gray-900 hover:bg-gray-50 transition-all">Destinations</a>
                <a href="../pages/packages.php" class="px-4 py-2 text-gray-600 font-bold rounded-xl hover:text-gray-900 hover:bg-gray-50 transition-all">Packages</a>
                <a href="../pages/about.php" class="px-4 py-2 text-gray-600 font-bold rounded-xl hover:text-gray-900 hover:bg-gray-50 transition-all">About</a>
                <a href="../pages/contact.php" class="px-4 py-2 text-gray-600 font-bold rounded-xl hover:text-gray-900 hover:bg-gray-50 transition-all">Contact</a>
                
                <div class="w-px h-6 bg-gray-200 mx-2"></div> <!-- Divider -->

                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Profile Dropdown -->
                    <div class="relative group cursor-pointer ml-2">
                        <button class="flex items-center space-x-3 px-3 py-2 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors border border-gray-100">
                            <div class="w-8 h-8 bg-gradient-to-br from-amber-400 to-orange-500 rounded-[0.7rem] flex items-center justify-center text-white font-bold shadow-sm">
                                <?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?>
                            </div>
                            <span class="font-bold text-gray-700"><?= htmlspecialchars(explode(' ', $_SESSION['user_name'] ?? 'User')[0]) ?></span>
                            <svg class="w-4 h-4 text-gray-500 group-hover:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top-right scale-95 group-hover:scale-100 overflow-hidden z-50">
                            <div class="p-2 space-y-1">
                                <a href="../pages/profile.php" class="flex items-center px-4 py-3 text-sm font-bold text-gray-700 hover:bg-amber-50 hover:text-amber-600 rounded-xl transition-colors">
                                    <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    My Dashboard
                                </a>
                            </div>
                            <div class="p-2 bg-gray-50 border-t border-gray-100">
                                <a href="../includes/logout.php" class="flex items-center px-4 py-3 text-sm font-bold text-red-600 hover:bg-red-50 hover:text-red-700 rounded-xl transition-colors">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Sign Out
                                </a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="../pages/Account.php" class="ml-2 bg-gray-900 text-white font-bold px-6 py-2.5 rounded-xl hover:bg-amber-500 transition-colors duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 inline-block">Sign In</a>
                <?php endif; ?>
            </div>

            <!-- Mobile Menu Button -->
            <button id="menuBtn" class="md:hidden text-gray-900 focus:outline-none p-2 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="md:hidden hidden bg-white/95 backdrop-blur-xl rounded-[2rem] shadow-2xl mt-4 border border-gray-100 absolute left-4 right-4 z-50 overflow-hidden transition-all duration-300 transform origin-top">
            <div class="flex flex-col p-4 space-y-2">
                <a href="../pages/index.php" class="px-5 py-3 text-gray-800 font-extrabold hover:bg-gray-50 hover:text-amber-500 rounded-xl transition-colors">Home</a>
                <a href="../pages/Destination.php" class="px-5 py-3 text-gray-800 font-extrabold hover:bg-gray-50 hover:text-amber-500 rounded-xl transition-colors">Destinations</a>
                <a href="../pages/packages.php" class="px-5 py-3 text-gray-800 font-extrabold hover:bg-gray-50 hover:text-amber-500 rounded-xl transition-colors">Packages</a>
                <a href="../pages/about.php" class="px-5 py-3 text-gray-800 font-extrabold hover:bg-gray-50 hover:text-amber-500 rounded-xl transition-colors">About</a>
                <a href="../pages/contact.php" class="px-5 py-3 text-gray-800 font-extrabold hover:bg-gray-50 hover:text-amber-500 rounded-xl transition-colors">Contact</a>
                
                <div class="h-px bg-gray-100 my-2 mx-4"></div>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="../pages/profile.php" class="px-5 py-3 text-gray-800 font-extrabold hover:bg-gray-50 hover:text-amber-500 rounded-xl flex items-center transition-colors">
                        <svg class="w-5 h-5 mr-3 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Dashboard
                    </a>
                    <a href="../includes/logout.php" class="px-5 py-3 text-red-600 font-extrabold hover:bg-red-50 rounded-xl flex items-center transition-colors">
                        <svg class="w-5 h-5 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Sign Out
                    </a>
                <?php else: ?>
                    <a href="../pages/Account.php" class="px-5 py-4 bg-gray-900 text-white font-extrabold text-center rounded-xl mx-2 my-2 hover:bg-amber-500 transition-colors shadow-lg shadow-gray-200">Sign In to Portal</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Mobile menu toggle
        const menuBtn = document.getElementById('menuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        if(menuBtn && mobileMenu) {
            menuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
                menuBtn.classList.toggle('bg-gray-100');
            });
        }
    });
</script>
