<?php
include('includes/admin-guard.php');
$page_title = 'Journals Moderation';

$search = trim($_GET['search'] ?? '');
$status_filter = $_GET['status'] ?? '';
$page = max(1, (int)($_GET['page'] ?? 1)); $per_page = 10; $offset = ($page - 1) * $per_page;

$wp = [];
if ($status_filter) $wp[] = "j.status = '" . $db->real_escape_string($status_filter) . "'";
if ($search) $wp[] = "(j.title LIKE '%" . $db->real_escape_string($search) . "%' OR u.name LIKE '%" . $db->real_escape_string($search) . "%')";
$where = $wp ? 'WHERE ' . implode(' AND ', $wp) : '';

$total_res = $db->query("SELECT COUNT(*) as c FROM journals j JOIN users u ON j.user_id = u.id $where");
$total = ($total_res) ? $total_res->fetch_assoc()['c'] : 0;
$total_pages = ceil($total / $per_page);
$journals = $db->query("SELECT j.*, u.name as user_name FROM journals j JOIN users u ON j.user_id = u.id $where ORDER BY j.created_at DESC LIMIT $per_page OFFSET $offset");

include('includes/admin-header.php');
?>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <h3 class="text-sm font-bold text-slate-800">Journal Posts (<?= $total ?>)</h3>
        <div class="flex items-center gap-3 w-full sm:w-auto">
            <form method="GET" class="flex gap-2 flex-1 sm:flex-initial">
                <select name="status" onchange="this.form.submit()" class="px-3 py-2 text-xs font-semibold border border-slate-200 rounded-lg bg-slate-50 focus:outline-none focus:ring-2 focus:ring-champagne/30">
                    <option value="">All Status</option>
                    <option value="pending" <?= $status_filter==='pending'?'selected':'' ?>>Pending</option>
                    <option value="published" <?= $status_filter==='published'?'selected':'' ?>>Published</option>
                    <option value="flagged" <?= $status_filter==='flagged'?'selected':'' ?>>Flagged</option>
                </select>
                <div class="relative flex-1 sm:flex-initial">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" placeholder="Search..." value="<?= htmlspecialchars($search) ?>" class="pl-9 pr-3 py-2 text-sm border border-slate-200 rounded-lg bg-slate-50 focus:outline-none focus:ring-2 focus:ring-champagne/30 w-full sm:w-44">
                </div>
            </form>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead><tr class="bg-slate-50">
                <th class="px-5 py-3 text-left text-[0.68rem] font-bold uppercase tracking-wider text-slate-400">Author</th>
                <th class="px-5 py-3 text-left text-[0.68rem] font-bold uppercase tracking-wider text-slate-400">Title</th>
                <th class="px-5 py-3 text-left text-[0.68rem] font-bold uppercase tracking-wider text-slate-400">Status</th>
                <th class="px-5 py-3 text-center text-[0.68rem] font-bold uppercase tracking-wider text-slate-400">Featured</th>
                <th class="px-5 py-3 text-left text-[0.68rem] font-bold uppercase tracking-wider text-slate-400">Date</th>
                <th class="px-5 py-3 text-right text-[0.68rem] font-bold uppercase tracking-wider text-slate-400">Actions</th>
            </tr></thead>
            <tbody>
                <?php while ($journals && $j = $journals->fetch_assoc()): ?>
                <tr class="border-b border-slate-50 hover:bg-slate-50/50">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-slate-100 flex items-center justify-center text-[0.6rem] font-bold text-slate-400"><?= strtoupper(substr($j['user_name'],0,1)) ?></div>
                            <span class="text-sm font-semibold text-slate-700"><?= htmlspecialchars($j['user_name']) ?></span>
                        </div>
                    </td>
                    <td class="px-5 py-3">
                        <p class="text-sm font-bold text-slate-800"><?= htmlspecialchars(mb_strimwidth($j['title'],0,40,'...')) ?></p>
                        <p class="text-xs text-slate-400 truncate max-w-[200px]"><?= htmlspecialchars(strip_tags(mb_strimwidth($j['content'],0,60,'...'))) ?></p>
                    </td>
                    <td class="px-5 py-3">
                        <span class="inline-block px-2 py-1 rounded-full text-[0.62rem] font-bold <?= $j['status']==='published'?'bg-emerald-50 text-emerald-700':($j['status']==='pending'?'bg-amber-50 text-amber-700':'bg-red-50 text-red-600') ?> capitalize"><?= $j['status'] ?></span>
                    </td>
                    <td class="px-5 py-3 text-center">
                        <a href="includes/admin-actions.php?action=toggle_journal_featured&id=<?= $j['id'] ?>" class="text-lg <?= $j['is_featured']?'text-amber-400':'text-slate-200' ?> hover:scale-110 transition-transform inline-block">★</a>
                    </td>
                    <td class="px-5 py-3 text-xs text-slate-400"><?= date('M d, Y', strtotime($j['created_at'])) ?></td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex items-center justify-end gap-1.5">
                            <form method="POST" action="includes/admin-actions.php?action=update_journal_status" class="flex gap-1">
                                <input type="hidden" name="id" value="<?= $j['id'] ?>">
                                <select name="status" class="px-2 py-1.5 text-xs font-semibold border border-slate-200 rounded-lg bg-slate-50 focus:outline-none">
                                    <option value="pending" <?= $j['status']==='pending'?'selected':'' ?>>Pending</option>
                                    <option value="published" <?= $j['status']==='published'?'selected':'' ?>>Publish</option>
                                    <option value="flagged" <?= $j['status']==='flagged'?'selected':'' ?>>Flag</option>
                                </select>
                                <button type="submit" class="px-2 py-1.5 text-xs font-bold text-emerald-700 bg-emerald-50 rounded-lg">Save</button>
                            </form>
                            <button onclick="confirmDelete('includes/admin-actions.php?action=delete_journal&id=<?= $j['id'] ?>', '<?= htmlspecialchars(addslashes($j['title'])) ?>')" class="px-2 py-1.5 text-xs font-bold text-red-600 bg-red-50 rounded-lg">Delete</button>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php if ($total == 0): ?><tr><td colspan="6" class="px-5 py-12 text-center text-sm text-slate-400">No journals found.</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if ($total_pages > 1): ?>
    <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between text-sm text-slate-400">
        <span>Showing <?= $offset+1 ?>–<?= min($offset+$per_page, $total) ?></span>
        <div class="flex gap-1"><?php for ($i = 1; $i <= $total_pages; $i++): ?><a href="?page=<?= $i ?>&status=<?= urlencode($status_filter) ?>&search=<?= urlencode($search) ?>" class="w-8 h-8 flex items-center justify-center rounded-lg text-xs font-semibold <?= $i === $page ? 'bg-champagne text-slate-800' : 'text-slate-500 hover:bg-slate-100' ?>"><?= $i ?></a><?php endfor; ?></div>
    </div>
    <?php endif; ?>
</div>

<?php include('includes/admin-footer.php'); ?>
