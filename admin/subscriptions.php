<?php
include('includes/admin-guard.php');
$page_title = 'The Collective (Subscribers)';

$subs = $db->query("SELECT * FROM subscriptions ORDER BY created_at DESC");
$count = $db->query("SELECT COUNT(*) as c FROM subscriptions")->fetch_assoc()['c'];

include('includes/admin-header.php');
?>

<div class="flex flex-col gap-8">
    <div class="flex items-center justify-between bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">
        <div>
            <h3 class="text-xl font-bold text-slate-800">The Collective</h3>
            <p class="text-xs text-slate-400 font-medium">Manage heritage newsletter subscribers and community members</p>
        </div>
        <div class="text-right">
            <p class="text-2xl font-black text-slate-800"><?= $count ?></p>
            <p class="text-[0.6rem] font-bold text-emerald-500 uppercase tracking-widest">Active Members</p>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-left text-[0.65rem] font-black uppercase tracking-[0.15em] text-slate-400">Subscriber Identity</th>
                        <th class="px-8 py-5 text-left text-[0.65rem] font-black uppercase tracking-[0.15em] text-slate-400">Status</th>
                        <th class="px-8 py-5 text-left text-[0.65rem] font-black uppercase tracking-[0.15em] text-slate-400 text-center">Joined At</th>
                        <th class="px-8 py-5 text-right text-[0.65rem] font-black uppercase tracking-[0.15em] text-slate-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php while ($s = $subs->fetch_assoc()): ?>
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <span class="text-sm font-black text-slate-800"><?= htmlspecialchars($s['email']) ?></span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[0.6rem] font-black bg-emerald-100 text-emerald-700">SUBSCRIBED</span>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <p class="text-sm font-black text-slate-700"><?= date('M d, Y', strtotime($s['created_at'])) ?></p>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <button onclick="confirmDelete('includes/admin-actions.php?action=delete_subscription&id=<?= $s['id'] ?>','subscription for <?= htmlspecialchars(addslashes($s['email'])) ?>')" class="p-2.5 text-slate-300 hover:text-red-500 hover:bg-red-50 transition-all rounded-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php if ($count == 0): ?>
                        <tr><td colspan="4" class="px-8 py-20 text-center text-slate-400 font-medium">The newsletter registry is currently empty.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('includes/admin-footer.php'); ?>
