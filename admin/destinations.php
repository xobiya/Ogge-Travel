<?php
include('includes/admin-guard.php');
$page_title = 'Destinations';
$search = trim($_GET['search'] ?? '');
$page = max(1, (int)($_GET['page'] ?? 1));
$per_page = 10;
$offset = ($page - 1) * $per_page;
$where = $search ? "WHERE name LIKE '%" . $db->real_escape_string($search) . "%'" : '';
$total = $db->query("SELECT COUNT(*) as c FROM destinations $where")->fetch_assoc()['c'];
$total_pages = ceil($total / $per_page);
$destinations = $db->query("SELECT * FROM destinations $where ORDER BY name ASC LIMIT $per_page OFFSET $offset");
include('includes/admin-header.php');
?>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <h3 class="text-sm font-bold text-slate-800">All Destinations (<?= $total ?>)</h3>
        <div class="flex items-center gap-3 w-full sm:w-auto">
            <form method="GET" class="relative flex-1 sm:flex-initial">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" placeholder="Search..." value="<?= htmlspecialchars($search) ?>" class="pl-9 pr-3 py-2 text-sm border border-slate-200 rounded-lg bg-slate-50 focus:outline-none focus:ring-2 focus:ring-champagne/30 focus:border-champagne w-full sm:w-52">
            </form>
            <a href="<?= BASE_URL ?>/admin/destination-form" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-slate-800 bg-champagne hover:bg-champagne-light rounded-lg transition-colors whitespace-nowrap">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Add New
            </a>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead><tr class="bg-slate-50"><th class="px-5 py-3 text-left text-[0.68rem] font-bold uppercase tracking-wider text-slate-400">Image</th><th class="px-5 py-3 text-left text-[0.68rem] font-bold uppercase tracking-wider text-slate-400">Name</th><th class="px-5 py-3 text-left text-[0.68rem] font-bold uppercase tracking-wider text-slate-400 hidden md:table-cell">Description</th><th class="px-5 py-3 text-left text-[0.68rem] font-bold uppercase tracking-wider text-slate-400 hidden sm:table-cell">Created</th><th class="px-5 py-3 text-right text-[0.68rem] font-bold uppercase tracking-wider text-slate-400">Actions</th></tr></thead>
            <tbody>
                <?php while ($d = $destinations->fetch_assoc()): ?>
                <tr class="border-b border-slate-50 hover:bg-slate-50/50">
                    <td class="px-5 py-3 overflow-hidden rounded-lg"><img src="<?= htmlspecialchars($d['image_url']) ?>" class="w-14 h-14 rounded-lg object-cover border border-slate-200 enhanced-img" onerror="this.src='../assets/images/default.jpg'"></td>
                    <td class="px-5 py-3 text-sm font-semibold text-slate-700"><?= htmlspecialchars($d['name']) ?></td>
                    <td class="px-5 py-3 text-sm text-slate-400 max-w-[300px] truncate hidden md:table-cell"><?= htmlspecialchars(mb_strimwidth($d['description'], 0, 80, '...')) ?></td>
                    <td class="px-5 py-3 text-xs text-slate-400 hidden sm:table-cell"><?= date('M d, Y', strtotime($d['created_at'])) ?></td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="<?= BASE_URL ?>/admin/destination-form?id=<?= $d['id'] ?>" class="px-3 py-1.5 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">Edit</a>
                            <button onclick="confirmDelete('includes/admin-actions.php?action=delete_destination&id=<?= $d['id'] ?>', '<?= htmlspecialchars(addslashes($d['name'])) ?>')" class="px-3 py-1.5 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">Delete</button>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php if ($total == 0): ?><tr><td colspan="5" class="px-5 py-12 text-center text-sm text-slate-400">No destinations found.</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if ($total_pages > 1): ?>
    <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between text-sm text-slate-400">
        <span>Showing <?= $offset+1 ?>–<?= min($offset+$per_page, $total) ?> of <?= $total ?></span>
        <div class="flex gap-1"><?php for ($i = 1; $i <= $total_pages; $i++): ?><a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>" class="w-8 h-8 flex items-center justify-center rounded-lg text-xs font-semibold <?= $i === $page ? 'bg-champagne text-slate-800' : 'text-slate-500 hover:bg-slate-100' ?>"><?= $i ?></a><?php endfor; ?></div>
    </div>
    <?php endif; ?>
</div>

<?php include('includes/admin-footer.php'); ?>
