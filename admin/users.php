<?php
include('includes/admin-guard.php');
$page_title = 'Users';
$search = trim($_GET['search'] ?? '');
$page = max(1, (int)($_GET['page'] ?? 1)); $per_page = 10; $offset = ($page - 1) * $per_page;
$where = $search ? "WHERE name LIKE '%" . $db->real_escape_string($search) . "%' OR email LIKE '%" . $db->real_escape_string($search) . "%'" : '';
$total = $db->query("SELECT COUNT(*) as c FROM users $where")->fetch_assoc()['c'];
$total_pages = ceil($total / $per_page);
$users = $db->query("SELECT u.*, (SELECT COUNT(*) FROM bookings WHERE user_id=u.id) as booking_count FROM users u $where ORDER BY u.created_at DESC LIMIT $per_page OFFSET $offset");
include('includes/admin-header.php');
?>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <h3 class="text-sm font-bold text-slate-800">All Users (<?= $total ?>)</h3>
        <form method="GET" class="relative w-full sm:w-auto">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" placeholder="Search users..." value="<?= htmlspecialchars($search) ?>" class="pl-9 pr-3 py-2 text-sm border border-slate-200 rounded-lg bg-slate-50 focus:outline-none focus:ring-2 focus:ring-champagne/30 focus:border-champagne w-full sm:w-60">
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead><tr class="bg-slate-50"><th class="px-5 py-3 text-left text-[0.68rem] font-bold uppercase tracking-wider text-slate-400">Name</th><th class="px-5 py-3 text-left text-[0.68rem] font-bold uppercase tracking-wider text-slate-400">Email</th><th class="px-5 py-3 text-left text-[0.68rem] font-bold uppercase tracking-wider text-slate-400">Role</th><th class="px-5 py-3 text-center text-[0.68rem] font-bold uppercase tracking-wider text-slate-400 hidden sm:table-cell">Bookings</th><th class="px-5 py-3 text-left text-[0.68rem] font-bold uppercase tracking-wider text-slate-400 hidden md:table-cell">Registered</th><th class="px-5 py-3 text-right text-[0.68rem] font-bold uppercase tracking-wider text-slate-400">Actions</th></tr></thead>
            <tbody>
                <?php while ($u = $users->fetch_assoc()): ?>
                <tr class="border-b border-slate-50 hover:bg-slate-50/50">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-gradient-to-br from-champagne/20 to-champagne/5 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-xs font-bold text-champagne"><?= strtoupper(substr($u['name'], 0, 1)) ?></span>
                            </div>
                            <span class="text-sm font-semibold text-slate-700"><?= htmlspecialchars($u['name']) ?></span>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-sm text-slate-400"><?= htmlspecialchars($u['email']) ?></td>
                    <td class="px-5 py-3"><span class="inline-block px-2.5 py-1 rounded-full text-[0.68rem] font-semibold <?= $u['role']==='admin' ? 'bg-champagne/10 text-champagne' : 'bg-indigo-50 text-indigo-600' ?>"><?= $u['role'] ?></span></td>
                    <td class="px-5 py-3 text-sm text-slate-500 text-center hidden sm:table-cell"><?= $u['booking_count'] ?></td>
                    <td class="px-5 py-3 text-xs text-slate-400 hidden md:table-cell"><?= date('M d, Y', strtotime($u['created_at'])) ?></td>
                    <td class="px-5 py-3 text-right">
                        <?php if ($u['id'] != $admin_id): ?>
                        <div class="flex items-center justify-end gap-2">
                            <form method="POST" action="includes/admin-actions.php?action=update_user_role">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($admin_csrf_token) ?>">
                                <input type="hidden" name="id" value="<?= $u['id'] ?>">
                                <input type="hidden" name="role" value="<?= $u['role'] === 'admin' ? 'user' : 'admin' ?>">
                                <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">Make <?= $u['role'] === 'admin' ? 'User' : 'Admin' ?></button>
                            </form>
                            <button onclick="confirmDelete('includes/admin-actions.php?action=delete_user&id=<?= $u['id'] ?>', '<?= htmlspecialchars(addslashes($u['name'])) ?>')" class="px-3 py-1.5 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">Delete</button>
                        </div>
                        <?php else: ?><span class="text-xs text-slate-400 italic">You</span><?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
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
