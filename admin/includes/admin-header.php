<?php
$current_page = basename($_SERVER['PHP_SELF'], '.php');
$admin_csrf_token = ogge_csrf_token();
$pending_bookings_res = $db->query("SELECT COUNT(*) as c FROM bookings WHERE status = 'pending'");
$pending_bookings = ($pending_bookings_res) ? $pending_bookings_res->fetch_assoc()['c'] : 0;
$unread_messages_res = $db->query("SELECT COUNT(*) as c FROM contacts WHERE is_read = 0");
$unread_messages = ($unread_messages_res) ? $unread_messages_res->fetch_assoc()['c'] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title ?? 'Admin') ?> — OGGE Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    champagne: { DEFAULT: '#c9a96e', light: '#e8d5a8', dark: '#a88b4a' },
                    sidebar: { DEFAULT: '#0f172a', hover: '#1e293b' }
                }
            }
        }
    }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-scrollbar::-webkit-scrollbar { width: 4px; }
        .sidebar-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }
        @keyframes slideIn { from { transform: translateX(120%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        @keyframes fadeOut { to { opacity: 0; transform: translateY(-10px); pointer-events: none; } }
        .toast-animate { animation: slideIn 0.35s ease, fadeOut 0.35s ease 3s forwards; }
        .stat-card:hover { transform: translateY(-2px); }
        
        /* Premium Image Enhancements */
        .enhanced-img {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            filter: saturate(1.1) contrast(1.05);
        }
        .enhanced-img:hover {
            transform: scale(1.08);
            filter: saturate(1.2) contrast(1.1);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen">

<!-- Mobile Overlay -->
<div class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<aside class="fixed top-0 left-0 w-[260px] h-screen bg-sidebar z-50 flex flex-col transition-transform duration-300 -translate-x-full lg:translate-x-0 sidebar-scrollbar overflow-y-auto" id="adminSidebar">
    
    <!-- Logo -->
    <div class="px-5 py-5 border-b border-white/[0.06] flex items-center gap-3">
        <div class="w-9 h-9 bg-gradient-to-br from-champagne to-champagne-light rounded-lg flex items-center justify-center flex-shrink-0">
            <svg class="w-[18px] h-[18px] text-sidebar" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <span class="text-xl tracking-wide" style="font-family:'Playfair Display',serif;">
            <span class="font-bold text-white">OGGE</span>
            <span class="font-light text-champagne">Admin</span>
        </span>
    </div>

    <!-- Nav -->
    <nav class="flex-1 px-3 py-4">
        <p class="text-[0.65rem] font-bold uppercase tracking-[0.15em] text-white/25 px-3 pt-3 pb-2">Main</p>
        
        <a href="index.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[0.8rem] font-medium mb-0.5 transition-all <?= $current_page === 'index' ? 'bg-champagne/[0.12] text-champagne' : 'text-white/55 hover:bg-sidebar-hover hover:text-white' ?>">
            <svg class="w-5 h-5 flex-shrink-0 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
            Dashboard
        </a>

        <p class="text-[0.65rem] font-bold uppercase tracking-[0.15em] text-white/25 px-3 pt-5 pb-2">Content</p>

        <a href="destinations.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[0.8rem] font-medium mb-0.5 transition-all <?= ($current_page === 'destinations' || $current_page === 'destination-form') ? 'bg-champagne/[0.12] text-champagne' : 'text-white/55 hover:bg-sidebar-hover hover:text-white' ?>">
            <svg class="w-5 h-5 flex-shrink-0 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Destinations
        </a>
        <a href="packages.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[0.8rem] font-medium mb-0.5 transition-all <?= ($current_page === 'packages' || $current_page === 'package-form') ? 'bg-champagne/[0.12] text-champagne' : 'text-white/55 hover:bg-sidebar-hover hover:text-white' ?>">
            <svg class="w-5 h-5 flex-shrink-0 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            Packages
        </a>
        <a href="media.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[0.8rem] font-medium mb-0.5 transition-all <?= $current_page === 'media' ? 'bg-champagne/[0.12] text-champagne' : 'text-white/55 hover:bg-sidebar-hover hover:text-white' ?>">
            <svg class="w-5 h-5 flex-shrink-0 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Media Library
        </a>

        <p class="text-[0.65rem] font-bold uppercase tracking-[0.15em] text-white/25 px-3 pt-5 pb-2">Operations</p>

        <a href="bookings.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[0.8rem] font-medium mb-0.5 transition-all <?= ($current_page === 'bookings' || $current_page === 'booking-detail') ? 'bg-champagne/[0.12] text-champagne' : 'text-white/55 hover:bg-sidebar-hover hover:text-white' ?>">
            <svg class="w-5 h-5 flex-shrink-0 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Bookings
            <?php if ($pending_bookings > 0): ?><span class="ml-auto bg-red-500 text-white text-[0.65rem] font-bold px-2 py-0.5 rounded-full"><?= $pending_bookings ?></span><?php endif; ?>
        </a>
        <a href="users.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[0.8rem] font-medium mb-0.5 transition-all <?= $current_page === 'users' ? 'bg-champagne/[0.12] text-champagne' : 'text-white/55 hover:bg-sidebar-hover hover:text-white' ?>">
            <svg class="w-5 h-5 flex-shrink-0 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            Users
        </a>
        <a href="contacts.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[0.8rem] font-medium mb-0.5 transition-all <?= $current_page === 'contacts' ? 'bg-champagne/[0.12] text-champagne' : 'text-white/55 hover:bg-sidebar-hover hover:text-white' ?>">
            <svg class="w-5 h-5 flex-shrink-0 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            Messages
            <?php if ($unread_messages > 0): ?><span class="ml-auto bg-blue-500 text-white text-[0.65rem] font-bold px-2 py-0.5 rounded-full"><?= $unread_messages ?></span><?php endif; ?>
        </a>
        <a href="reviews.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[0.8rem] font-medium mb-0.5 transition-all <?= $current_page === 'reviews' ? 'bg-champagne/[0.12] text-champagne' : 'text-white/55 hover:bg-sidebar-hover hover:text-white' ?>">
            <svg class="w-5 h-5 flex-shrink-0 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
            Reviews
        </a>
        <a href="subscriptions.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[0.8rem] font-medium mb-0.5 transition-all <?= $current_page === 'subscriptions' ? 'bg-champagne/[0.12] text-champagne' : 'text-white/55 hover:bg-sidebar-hover hover:text-white' ?>">
            <svg class="w-5 h-5 flex-shrink-0 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            Subscribers
        </a>
        <a href="journals.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[0.8rem] font-medium mb-0.5 transition-all <?= $current_page === 'journals' ? 'bg-champagne/[0.12] text-champagne' : 'text-white/55 hover:bg-sidebar-hover hover:text-white' ?>">
            <svg class="w-5 h-5 flex-shrink-0 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2zM14 4v4h4"/></svg>
            Journals
        </a>

        <p class="text-[0.65rem] font-bold uppercase tracking-[0.15em] text-white/25 px-3 pt-5 pb-2">System</p>

        <a href="logs.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[0.8rem] font-medium mb-0.5 transition-all <?= $current_page === 'logs' ? 'bg-champagne/[0.12] text-champagne' : 'text-white/55 hover:bg-sidebar-hover hover:text-white' ?>">
            <svg class="w-5 h-5 flex-shrink-0 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Activity Logs
        </a>
        <a href="settings.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[0.8rem] font-medium mb-0.5 transition-all <?= $current_page === 'settings' ? 'bg-champagne/[0.12] text-champagne' : 'text-white/55 hover:bg-sidebar-hover hover:text-white' ?>">
            <svg class="w-5 h-5 flex-shrink-0 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Site Settings
        </a>
    </nav>

    <!-- User -->
    <div class="px-5 py-4 border-t border-white/[0.06] flex items-center gap-3">
        <div class="w-9 h-9 bg-gradient-to-br from-champagne to-champagne-light rounded-full flex items-center justify-center flex-shrink-0">
            <svg class="w-[18px] h-[18px] text-sidebar" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>
        <div>
            <p class="text-sm text-white font-semibold"><?= htmlspecialchars($admin_name) ?></p>
            <p class="text-[0.65rem] text-white/35">Administrator</p>
        </div>
    </div>
</aside>

<!-- Main -->
<div class="lg:ml-[260px] min-h-screen transition-all">
    <!-- Topbar -->
    <div class="sticky top-0 z-30 bg-white/90 backdrop-blur-xl border-b border-slate-200 px-4 sm:px-8 py-3 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <button class="lg:hidden text-slate-600 p-1.5 hover:bg-slate-100 rounded-lg" onclick="toggleSidebar()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <p class="text-sm text-slate-400">Admin / <span class="text-slate-700 font-semibold"><?= htmlspecialchars($page_title ?? 'Dashboard') ?></span></p>
        </div>
        <div class="flex items-center gap-2">
            <a href="../pages/index.php" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                View Site
            </a>
            <a href="../includes/logout.php" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Logout
            </a>
        </div>
    </div>

    <!-- Content -->
    <div class="p-4 sm:p-8">
        <?php if (isset($_SESSION['admin_success'])): ?>
        <div class="fixed top-5 right-5 z-[999] flex items-center gap-2 bg-emerald-600 text-white px-5 py-3 rounded-xl shadow-2xl text-sm font-semibold toast-animate">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <?= htmlspecialchars($_SESSION['admin_success']); unset($_SESSION['admin_success']); ?>
        </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['admin_error'])): ?>
        <div class="fixed top-5 right-5 z-[999] flex items-center gap-2 bg-red-600 text-white px-5 py-3 rounded-xl shadow-2xl text-sm font-semibold toast-animate">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <?= htmlspecialchars($_SESSION['admin_error']); unset($_SESSION['admin_error']); ?>
        </div>
        <?php endif; ?>
