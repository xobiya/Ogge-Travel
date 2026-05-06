<?php
include('includes/admin-guard.php');
$page_title = 'Guest Testimonials';

$reviews = $db->query("SELECT r.*, u.name as user_name, u.email as user_email, p.title as package_title FROM reviews r JOIN users u ON r.user_id=u.id JOIN packages p ON r.package_id=p.id ORDER BY r.created_at DESC");
$count = $db->query("SELECT COUNT(*) as c FROM reviews")->fetch_assoc()['c'];

include('includes/admin-header.php');
?>

<div class="flex flex-col gap-8">
    <div class="flex items-center justify-between bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Guest Feedback</h3>
            <p class="text-xs text-slate-400 font-medium">Monitor and manage traveler reviews and ratings</p>
        </div>
        <div class="text-right">
            <p class="text-2xl font-black text-slate-800"><?= $count ?></p>
            <p class="text-[0.6rem] font-bold text-amber-500 uppercase tracking-widest">Verified Reviews</p>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-left text-[0.65rem] font-black uppercase tracking-[0.15em] text-slate-400">Traveler</th>
                        <th class="px-8 py-5 text-left text-[0.65rem] font-black uppercase tracking-[0.15em] text-slate-400">Experience</th>
                        <th class="px-8 py-5 text-left text-[0.65rem] font-black uppercase tracking-[0.15em] text-slate-400">Rating</th>
                        <th class="px-8 py-5 text-left text-[0.65rem] font-black uppercase tracking-[0.15em] text-slate-400">Review</th>
                        <th class="px-8 py-5 text-right text-[0.65rem] font-black uppercase tracking-[0.15em] text-slate-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php while ($r = $reviews->fetch_assoc()): ?>
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-slate-900 text-champagne rounded-full flex items-center justify-center font-black text-xs">
                                    <?= strtoupper(substr($r['user_name'], 0, 1)) ?>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-slate-800"><?= htmlspecialchars($r['user_name']) ?></span>
                                    <span class="text-[0.65rem] text-slate-400 font-medium"><?= htmlspecialchars($r['user_email']) ?></span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-xs font-bold text-slate-600 bg-slate-100 px-3 py-1 rounded-lg"><?= htmlspecialchars($r['package_title']) ?></span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex gap-0.5">
                                <?php for ($i=1; $i<=5; $i++): ?>
                                    <svg class="w-3.5 h-3.5 <?= $i<=$r['rating']?'text-amber-400':'text-slate-200' ?>" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <?php endfor; ?>
                            </div>
                        </td>
                        <td class="px-8 py-6 max-w-xs">
                            <p class="text-sm text-slate-500 italic font-medium leading-relaxed">"<?= htmlspecialchars($r['review']) ?>"</p>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <button onclick="confirmDelete('includes/admin-actions.php?action=delete_review&id=<?= $r['id'] ?>','review by <?= htmlspecialchars(addslashes($r['user_name'])) ?>')" class="p-2.5 text-slate-300 hover:text-red-500 hover:bg-red-50 transition-all rounded-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('includes/admin-footer.php'); ?>
