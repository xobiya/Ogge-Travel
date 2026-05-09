<?php 
if (session_status() == PHP_SESSION_NONE) { session_start(); }
include_once(__DIR__ . '/seo-lang.php'); 
?>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400;1,500&family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;0,800;1,400;1,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/luxury.css?v=1.2">
<?= generateSEO($page_title ?? 'The Curated Escape', $page_desc ?? 'Experience Ethiopia like never before with OGGE Travel.') ?>

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
                <a href="../pages/index.php" class="nav-link px-4 py-2 text-white/80 text-xs font-semibold tracking-[0.15em] uppercase rounded-lg hover:text-[#c9a96e] transition-colors" style="font-family:'Inter',sans-serif;"><?= __t('home') ?></a>
                <a href="../pages/Destination.php" class="nav-link px-4 py-2 text-white/80 text-xs font-semibold tracking-[0.15em] uppercase rounded-lg hover:text-[#c9a96e] transition-colors" style="font-family:'Inter',sans-serif;"><?= __t('destinations') ?></a>
                <a href="../pages/packages.php" class="nav-link px-4 py-2 text-white/80 text-xs font-semibold tracking-[0.15em] uppercase rounded-lg hover:text-[#c9a96e] transition-colors" style="font-family:'Inter',sans-serif;"><?= __t('packages') ?></a>
                <a href="../pages/about.php" class="nav-link px-4 py-2 text-white/80 text-xs font-semibold tracking-[0.15em] uppercase rounded-lg hover:text-[#c9a96e] transition-colors" style="font-family:'Inter',sans-serif;"><?= __t('explore') ?></a>
                <a href="../pages/journals.php" class="nav-link px-4 py-2 text-white/80 text-xs font-semibold tracking-[0.15em] uppercase rounded-lg hover:text-[#c9a96e] transition-colors" style="font-family:'Inter',sans-serif;"><?= __t('journal') ?></a>
                <a href="../pages/contact.php" class="nav-link px-4 py-2 text-white/80 text-xs font-semibold tracking-[0.15em] uppercase rounded-lg hover:text-[#c9a96e] transition-colors" style="font-family:'Inter',sans-serif;"><?= __t('contact') ?></a>
                
                <div class="w-px h-5 bg-white/20 mx-3"></div>

                <!-- Language Switcher -->
                <div class="flex items-center gap-2 mr-4">
                    <a href="?lang=en" class="text-[10px] font-bold <?= $lang==='en'?'text-[#c9a96e]':'text-white/40' ?> hover:text-white transition-colors">EN</a>
                    <span class="text-[10px] text-white/10">|</span>
                    <a href="?lang=am" class="text-[10px] font-bold <?= $lang==='am'?'text-[#c9a96e]':'text-white/40' ?> hover:text-white transition-colors">አማ</a>
                </div>
                
                <div class="w-px h-5 bg-white/20 mx-3"></div>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="relative group cursor-pointer">
                        <button class="flex items-center space-x-2 px-3 py-1.5 border border-white/20 rounded-full hover:border-[#c9a96e]/50 transition-colors bg-white/5">
                            <div class="w-7 h-7 bg-gradient-to-br from-[#c9a96e] to-[#e8d5a8] rounded-full flex items-center justify-center text-[#0a0f1e]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <span class="text-xs font-bold text-white uppercase tracking-wider px-1 hidden lg:block">
                                <?= htmlspecialchars(explode(' ', $_SESSION['user_name'] ?? 'Account')[0]) ?>
                            </span>
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

                <button onclick="toggleGlobalSearch()" class="p-2 text-white/60 hover:text-[#c9a96e] transition-colors ml-2" id="searchToggleBtn">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center">
                <button id="menuBtn" class="text-white p-2 focus:outline-none transition-transform duration-300">
                    <svg id="menuIcon" class="w-7 h-7 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg id="closeIcon" class="w-7 h-7 hidden transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
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
                    <div class="px-5 py-4 flex items-center gap-4 bg-white/5 rounded-xl mb-2">
                        <div class="w-10 h-10 bg-gradient-to-br from-[#c9a96e] to-[#e8d5a8] rounded-full flex items-center justify-center text-[#0a0f1e]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <p class="text-white text-sm font-bold"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Traveler') ?></p>
                            <p class="text-white/40 text-[10px] uppercase tracking-widest">Founding Member</p>
                        </div>
                    </div>
                    <a href="../pages/profile.php" class="px-5 py-3 text-white/80 text-xs font-semibold tracking-[0.15em] uppercase hover:text-[#c9a96e] hover:bg-white/5 rounded-xl transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-3 text-[#c9a96e]/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Dashboard
                    </a>
                    <a href="../includes/logout.php" class="px-5 py-3 text-red-400 text-xs font-semibold tracking-[0.15em] uppercase hover:bg-red-500/10 rounded-xl transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Sign Out
                    </a>
                <?php else: ?>
                    <a href="../pages/Account.php" class="mx-2 my-2 text-center py-3 border border-[#c9a96e] text-[#c9a96e] text-xs font-semibold tracking-[0.15em] uppercase rounded-full hover:bg-[#c9a96e] hover:text-[#0a0f1e] transition-all">Sign In</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>

<!-- Global Search Overlay -->
<div id="globalSearchOverlay" class="fixed inset-0 z-[100] bg-[#0a0f1e]/98 backdrop-blur-2xl hidden opacity-0 transition-all duration-500 flex flex-col items-center justify-center p-6">
    <button onclick="toggleGlobalSearch()" class="absolute top-10 right-10 text-white/40 hover:text-white transition-colors">
        <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
    </button>
    
    <div class="w-full max-w-3xl transform scale-95 transition-transform duration-500" id="searchContent">
        <h2 class="text-white text-3xl md:text-5xl text-center mb-12" style="font-family:'Playfair Display',serif;">Where do you wish to <span class="text-champagne-gradient italic">escape</span>?</h2>
        <form action="../pages/search.php" method="GET" class="relative">
            <input type="text" name="q" placeholder="<?= $lang==='am'?'መዳረሻዎችን ወይም ጥቅሎችን ይፈልጉ...':'Search destinations or packages...' ?>" class="w-full bg-transparent border-b-2 border-white/10 text-white text-2xl md:text-4xl py-6 focus:outline-none focus:border-[#c9a96e] transition-colors placeholder:text-white/10 text-center" style="font-family:'Inter',sans-serif;" autofocus>
            <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#c9a96e] hover:scale-110 transition-transform">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </button>
        </form>
        <div class="mt-12 flex flex-wrap justify-center gap-4">
            <p class="text-white/20 text-xs font-bold uppercase tracking-widest w-full text-center mb-2">Suggested</p>
            <a href="../pages/search.php?q=Lalibela" class="px-5 py-2 rounded-full border border-white/10 text-white/50 text-[10px] font-bold uppercase tracking-widest hover:border-[#c9a96e] hover:text-[#c9a96e] transition-all">Lalibela</a>
            <a href="../pages/search.php?q=Omo" class="px-5 py-2 rounded-full border border-white/10 text-white/50 text-[10px] font-bold uppercase tracking-widest hover:border-[#c9a96e] hover:text-[#c9a96e] transition-all">Omo Valley</a>
            <a href="../pages/search.php?q=Simien" class="px-5 py-2 rounded-full border border-white/10 text-white/50 text-[10px] font-bold uppercase tracking-widest hover:border-[#c9a96e] hover:text-[#c9a96e] transition-all">Simien Mountains</a>
        </div>
    </div>
</div>

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
    const menuIcon = document.getElementById('menuIcon');
    const closeIcon = document.getElementById('closeIcon');

    if(menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', () => {
            const isHidden = mobileMenu.classList.toggle('hidden');
            if (isHidden) {
                menuIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
                menuBtn.classList.remove('rotate-90');
            } else {
                menuIcon.classList.add('hidden');
                closeIcon.classList.remove('hidden');
                menuBtn.classList.add('rotate-90');
            }
        });
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

function toggleGlobalSearch() {
    const overlay = document.getElementById('globalSearchOverlay');
    const content = document.getElementById('searchContent');
    if (overlay.classList.contains('hidden')) {
        overlay.classList.remove('hidden');
        setTimeout(() => {
            overlay.classList.add('opacity-100');
            content.classList.remove('scale-95');
            overlay.querySelector('input').focus();
        }, 10);
    } else {
        overlay.classList.remove('opacity-100');
        content.classList.add('scale-95');
        setTimeout(() => overlay.classList.add('hidden'), 500);
    }
}
</script>
