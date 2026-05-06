<?php
include('includes/admin-guard.php');
$page_title = 'Concierge Enquiries';

$messages = $db->query("SELECT * FROM contacts ORDER BY is_read ASC, created_at DESC");
$msg_count_res = $db->query("SELECT COUNT(*) as c FROM contacts");
$msg_count = ($msg_count_res) ? $msg_count_res->fetch_assoc()['c'] : 0;
$unread_count_res = $db->query("SELECT COUNT(*) as c FROM contacts WHERE is_read = 0");
$unread_count = ($unread_count_res) ? $unread_count_res->fetch_assoc()['c'] : 0;

include('includes/admin-header.php');
?>

<div class="flex flex-col gap-8">
    <!-- Header Section -->
    <div class="flex items-center justify-between bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Concierge Inbox</h3>
            <p class="text-xs text-slate-400 font-medium">Manage private enquiries and heritage requests</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="text-right">
                <p class="text-2xl font-black text-slate-800"><?= $unread_count ?></p>
                <p class="text-[0.6rem] font-bold text-blue-500 uppercase tracking-widest">Unread Messages</p>
            </div>
            <div class="w-px h-8 bg-slate-100"></div>
            <div class="text-right">
                <p class="text-2xl font-black text-slate-400"><?= $msg_count ?></p>
                <p class="text-[0.6rem] font-bold text-slate-400 uppercase tracking-widest">Total Archive</p>
            </div>
        </div>
    </div>

    <!-- Messages List -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-left text-[0.65rem] font-black uppercase tracking-[0.15em] text-slate-400">Status</th>
                        <th class="px-8 py-5 text-left text-[0.65rem] font-black uppercase tracking-[0.15em] text-slate-400">Enquirer</th>
                        <th class="px-8 py-5 text-left text-[0.65rem] font-black uppercase tracking-[0.15em] text-slate-400">Message Snippet</th>
                        <th class="px-8 py-5 text-left text-[0.65rem] font-black uppercase tracking-[0.15em] text-slate-400 text-center">Received</th>
                        <th class="px-8 py-5 text-right text-[0.65rem] font-black uppercase tracking-[0.15em] text-slate-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php while ($messages && $m = $messages->fetch_assoc()): ?>
                    <tr class="hover:bg-slate-50/80 transition-colors group <?= !$m['is_read'] ? 'bg-blue-50/10' : '' ?>">
                        <td class="px-8 py-6">
                            <?php if (!$m['is_read']): ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[0.6rem] font-black bg-blue-500 text-white shadow-sm shadow-blue-200">NEW</span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[0.6rem] font-black bg-slate-100 text-slate-400">ARCHIVED</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-sm font-black text-slate-800"><?= htmlspecialchars($m['name']) ?></span>
                                <span class="text-[0.65rem] text-slate-400 font-medium"><?= htmlspecialchars($m['email']) ?></span>
                            </div>
                        </td>
                        <td class="px-8 py-6 max-w-md">
                            <details class="cursor-pointer group/msg">
                                <summary class="text-sm text-slate-600 font-medium list-none flex items-center gap-2">
                                    <span class="truncate"><?= htmlspecialchars(mb_strimwidth($m['message'], 0, 60, '...')) ?></span>
                                    <svg class="w-3 h-3 text-slate-300 group-open/msg:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                                </summary>
                                <div class="mt-4 p-6 bg-slate-50 rounded-2xl border border-slate-100 text-sm text-slate-600 leading-relaxed shadow-inner">
                                    <?= nl2br(htmlspecialchars($m['message'])) ?>
                                </div>
                            </details>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <p class="text-sm font-black text-slate-700"><?= date('M d', strtotime($m['created_at'])) ?></p>
                            <p class="text-[0.6rem] font-bold text-slate-400 uppercase tracking-widest"><?= date('H:i', strtotime($m['created_at'])) ?></p>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <?php if (!$m['is_read']): ?>
                                    <a href="includes/admin-actions.php?action=mark_contact_read&id=<?= $m['id'] ?>" class="px-4 py-2 text-[0.65rem] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 rounded-xl hover:bg-emerald-600 hover:text-white transition-all">Mark Read</a>
                                <?php endif; ?>
                                <button onclick="confirmDelete('includes/admin-actions.php?action=delete_contact&id=<?= $m['id'] ?>','enquiry from <?= htmlspecialchars(addslashes($m['name'])) ?>')" class="p-2.5 text-slate-300 hover:text-red-500 hover:bg-red-50 transition-all rounded-xl">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php if ($msg_count == 0): ?>
                        <tr><td colspan="5" class="px-8 py-20 text-center text-slate-400 font-medium">No active enquiries found in the inbox.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('includes/admin-footer.php'); ?>
