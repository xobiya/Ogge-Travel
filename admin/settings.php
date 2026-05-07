<?php
include('includes/admin-guard.php');
$page_title = 'Site Settings';

// Fetch all settings
$res = $db->query("SELECT * FROM site_settings");
$settings = [];
while($row = $res->fetch_assoc()) {
    $settings[$row['setting_key']] = $row['setting_value'];
}

include('includes/admin-header.php');
?>

<div class="max-w-4xl">
    <form action="includes/admin-actions.php?action=update_settings" method="POST" class="space-y-8">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($admin_csrf_token) ?>">
        <!-- General Settings -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/30">
                <h3 class="text-sm font-bold text-slate-800">General Identity</h3>
                <p class="text-[0.65rem] text-slate-400 mt-1 font-medium">Core branding and contact information</p>
            </div>
            <div class="p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[0.65rem] font-bold text-slate-400 uppercase tracking-widest mb-2">Site Name</label>
                        <input type="text" name="site_name" value="<?= htmlspecialchars($settings['site_name'] ?? '') ?>" class="w-full px-4 py-3 text-sm border border-slate-200 rounded-xl bg-slate-50 focus:ring-2 focus:ring-champagne/30 focus:border-champagne outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-[0.65rem] font-bold text-slate-400 uppercase tracking-widest mb-2">Site Email</label>
                        <input type="email" name="site_email" value="<?= htmlspecialchars($settings['site_email'] ?? '') ?>" class="w-full px-4 py-3 text-sm border border-slate-200 rounded-xl bg-slate-50 focus:ring-2 focus:ring-champagne/30 focus:border-champagne outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-[0.65rem] font-bold text-slate-400 uppercase tracking-widest mb-2">Support Phone</label>
                        <input type="text" name="site_phone" value="<?= htmlspecialchars($settings['site_phone'] ?? '') ?>" class="w-full px-4 py-3 text-sm border border-slate-200 rounded-xl bg-slate-50 focus:ring-2 focus:ring-champagne/30 focus:border-champagne outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-[0.65rem] font-bold text-slate-400 uppercase tracking-widest mb-2">Physical Address</label>
                        <input type="text" name="site_address" value="<?= htmlspecialchars($settings['site_address'] ?? '') ?>" class="w-full px-4 py-3 text-sm border border-slate-200 rounded-xl bg-slate-50 focus:ring-2 focus:ring-champagne/30 focus:border-champagne outline-none transition-all">
                    </div>
                </div>
            </div>
        </div>

        <!-- Social Media -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/30">
                <h3 class="text-sm font-bold text-slate-800">Social Connections</h3>
                <p class="text-[0.65rem] text-slate-400 mt-1 font-medium">Links to external profiles</p>
            </div>
            <div class="p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[0.65rem] font-bold text-slate-400 uppercase tracking-widest mb-2">Facebook URL</label>
                        <input type="url" name="social_fb" value="<?= htmlspecialchars($settings['social_fb'] ?? '') ?>" placeholder="https://" class="w-full px-4 py-3 text-sm border border-slate-200 rounded-xl bg-slate-50 focus:ring-2 focus:ring-champagne/30 focus:border-champagne outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-[0.65rem] font-bold text-slate-400 uppercase tracking-widest mb-2">Instagram URL</label>
                        <input type="url" name="social_ig" value="<?= htmlspecialchars($settings['social_ig'] ?? '') ?>" placeholder="https://" class="w-full px-4 py-3 text-sm border border-slate-200 rounded-xl bg-slate-50 focus:ring-2 focus:ring-champagne/30 focus:border-champagne outline-none transition-all">
                    </div>
                </div>
            </div>
        </div>

        <!-- Advanced Controls -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/30">
                <h3 class="text-sm font-bold text-slate-800">Advanced Controls</h3>
            </div>
            <div class="p-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-bold text-slate-700">Maintenance Mode</h4>
                        <p class="text-xs text-slate-400 mt-1">Temporarily disable the front-end for users</p>
                    </div>
                    <select name="maintenance_mode" class="px-4 py-2 text-xs font-bold border border-slate-200 rounded-xl bg-slate-50 outline-none">
                        <option value="off" <?= ($settings['maintenance_mode'] ?? 'off') === 'off' ? 'selected' : '' ?>>Deactivated (Live)</option>
                        <option value="on" <?= ($settings['maintenance_mode'] ?? 'off') === 'on' ? 'selected' : '' ?>>Activated (Under Maintenance)</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="px-10 py-4 bg-champagne text-slate-800 text-sm font-black uppercase tracking-widest rounded-2xl shadow-lg hover:bg-champagne-dark hover:-translate-y-0.5 transition-all active:scale-95">Save All Changes</button>
            <p class="text-[0.65rem] text-slate-400 font-bold uppercase tracking-widest italic animate-pulse">Changes will take effect immediately</p>
        </div>
    </form>
</div>

<?php include('includes/admin-footer.php'); ?>
