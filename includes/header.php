<?php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
?>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400;1,500&family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;0,800;1,400;1,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/luxury.css">

<header class="fixed top-0 w-full z-50 transition-all duration-500 bg-transparent" id="mainHeader">
    <nav class="container mx-auto px-6 py-5 max-w-7xl">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <a href="../pages/index.php" class="flex items-center space-x-3 group">
                <div class="w-10 h-10 bg-gradient-to-br from-[#c9a96e] to-[#e8d5a8] rounded-lg flex items-center justify-center shadow-md group-hover:shadow-lg transition-shadow">
                    <svg class="w-5 h-5 text-[#0a0f1e]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-2xl tracking-wide" style="font-family:'Playfair Display',serif;">
                    <span class="font-bold text-white header-logo-text">OGGE</span>
                    <span class="font-light text-[#c9a96e]">Travel</span>
                </span>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-1">
                <a href="../pages/index.php" class="nav-link px-4 py-2 text-white/80 text-xs font-semibold tracking-[0.15em] uppercase rounded-lg hover:text-[#c9a96e] transition-colors" style="font-family:'Inter',sans-serif;">Home</a>
                <a href="../pages/Destination.php" class="nav-link px-4 py-2 text-white/80 text-xs font-semibold tracking-[0.15em] uppercase rounded-lg hover:text-[#c9a96e] transition-colors" style="font-family:'Inter',sans-serif;">Destinations</a>
                <a href="../pages/packages.php" class="nav-link px-4 py-2 text-white/80 text-xs font-semibold tracking-[0.15em] uppercase rounded-lg hover:text-[#c9a96e] transition-colors" style="font-family:'Inter',sans-serif;">Journeys</a>
                <a href="../pages/about.php" class="nav-link px-4 py-2 text-white/80 text-xs font-semibold tracking-[0.15em] uppercase rounded-lg hover:text-[#c9a96e] transition-colors" style="font-family:'Inter',sans-serif;">Heritage</a>
                <a href="../pages/journals.php" class="nav-link px-4 py-2 text-white/80 text-xs font-semibold tracking-[0.15em] uppercase rounded-lg hover:text-[#c9a96e] transition-colors" style="font-family:'Inter',sans-serif;">Journals</a>
                <a href="../pages/contact.php" class="nav-link px-4 py-2 text-white/80 text-xs font-semibold tracking-[0.15em] uppercase rounded-lg hover:text-[#c9a96e] transition-colors" style="font-family:'Inter',sans-serif;">Enquire</a>
                
                <div class="w-px h-5 bg-white/20 mx-3"></div>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="relative group cursor-pointer">
                        <button class="flex items-center space-x-2 px-3 py-2 border border-white/20 rounded-full hover:border-[#c9a96e]/50 transition-colors">
                            <div class="w-7 h-7 bg-[#c9a96e] rounded-full flex items-center justify-center text-[#0a0f1e] text-xs font-bold">
                                <?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?>
                            </div>
                            <svg class="w-3.5 h-3.5 text-white/60 group-hover:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div class="absolute right-0 mt-3 w-52 bg-[#0a0f1e] rounded-xl shadow-2xl border border-white/10 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top-right scale-95 group-hover:scale-100 overflow-hidden z-50">
                            <div class="p-2">
                                <a href="../pages/profile.php" class="flex items-center px-4 py-3 text-xs font-semibold tracking-wider uppercase text-white/70 hover:text-[#c9a96e] hover:bg-white/5 rounded-lg transition-colors" style="font-family:'Inter',sans-serif;">
                                    <svg class="w-4 h-4 mr-3 text-[#c9a96e]/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    My Dashboard
                                </a>
                                <a href="../pages/my-booking.php" class="flex items-center px-4 py-3 text-xs font-semibold tracking-wider uppercase text-white/70 hover:text-[#c9a96e] hover:bg-white/5 rounded-lg transition-colors" style="font-family:'Inter',sans-serif;">
                                    <svg class="w-4 h-4 mr-3 text-[#c9a96e]/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                    My Journeys
                                </a>
                            </div>
                            <div class="p-2 border-t border-white/10">
                                <a href="../includes/logout.php" class="flex items-center px-4 py-3 text-xs font-semibold tracking-wider uppercase text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-lg transition-colors" style="font-family:'Inter',sans-serif;">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Sign Out
                                </a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="../pages/Account.php" class="btn-outline ml-2 text-xs py-2 px-5" style="font-family:'Inter',sans-serif;">Sign In</a>
                <?php endif; ?>
            </div>

            <!-- Mobile Menu Button -->
            <button id="menuBtn" class="md:hidden text-white p-2 rounded-lg hover:bg-white/10 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="md:hidden hidden mt-4 bg-[#0a0f1e] rounded-2xl border border-white/10 shadow-2xl overflow-hidden">
            <div class="flex flex-col p-4 space-y-1" style="font-family:'Inter',sans-serif;">
                <a href="../pages/index.php" class="px-5 py-3 text-white/80 text-xs font-semibold tracking-[0.15em] uppercase hover:text-[#c9a96e] hover:bg-white/5 rounded-xl transition-colors">Home</a>
                <a href="../pages/Destination.php" class="px-5 py-3 text-white/80 text-xs font-semibold tracking-[0.15em] uppercase hover:text-[#c9a96e] hover:bg-white/5 rounded-xl transition-colors">Destinations</a>
                <a href="../pages/packages.php" class="px-5 py-3 text-white/80 text-xs font-semibold tracking-[0.15em] uppercase hover:text-[#c9a96e] hover:bg-white/5 rounded-xl transition-colors">Journeys</a>
                <a href="../pages/about.php" class="px-5 py-3 text-white/80 text-xs font-semibold tracking-[0.15em] uppercase hover:text-[#c9a96e] hover:bg-white/5 rounded-xl transition-colors">Heritage</a>
                <a href="../pages/journals.php" class="px-5 py-3 text-white/80 text-xs font-semibold tracking-[0.15em] uppercase hover:text-[#c9a96e] hover:bg-white/5 rounded-xl transition-colors">Journals</a>
                <a href="../pages/contact.php" class="px-5 py-3 text-white/80 text-xs font-semibold tracking-[0.15em] uppercase hover:text-[#c9a96e] hover:bg-white/5 rounded-xl transition-colors">Enquire</a>
                <div class="h-px bg-white/10 my-2 mx-4"></div>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="../pages/profile.php" class="px-5 py-3 text-white/80 text-xs font-semibold tracking-[0.15em] uppercase hover:text-[#c9a96e] hover:bg-white/5 rounded-xl transition-colors">Dashboard</a>
                    <a href="../includes/logout.php" class="px-5 py-3 text-red-400 text-xs font-semibold tracking-[0.15em] uppercase hover:bg-red-500/10 rounded-xl transition-colors">Sign Out</a>
                <?php else: ?>
                    <a href="../pages/Account.php" class="mx-2 my-2 text-center py-3 border border-[#c9a96e] text-[#c9a96e] text-xs font-semibold tracking-[0.15em] uppercase rounded-full hover:bg-[#c9a96e] hover:text-[#0a0f1e] transition-all">Sign In</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>

<style>
    /* Header scroll states */
    #mainHeader.header-scrolled {
        background: rgba(10, 15, 30, 0.95) !important;
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-bottom: 1px solid rgba(201, 169, 110, 0.1);
        padding-top: 0; padding-bottom: 0;
    }
    #mainHeader.header-scrolled nav { padding-top: 0.75rem; padding-bottom: 0.75rem; }
    .header-scrolled .header-logo-text { color: #fff; }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const menuBtn = document.getElementById('menuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    if(menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));
    }
    // Auto-scroll header
    const header = document.getElementById('mainHeader');
    if (header) {
        const checkScroll = () => {
            if (window.scrollY > 60) header.classList.add('header-scrolled');
            else header.classList.remove('header-scrolled');
        };
        window.addEventListener('scroll', checkScroll, { passive: true });
        checkScroll();
    }
});
</script>
