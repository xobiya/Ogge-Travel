<?php
include('includes/admin-guard.php');
$page_title = 'Bookings';
$status_filter = $_GET['status'] ?? ''; $search = trim($_GET['search'] ?? '');
$page = max(1, (int)($_GET['page'] ?? 1)); $per_page = 10; $offset = ($page - 1) * $per_page;
$wp = [];
if ($status_filter && in_array($status_filter, ['pending','confirmed','cancelled'])) $wp[] = "b.status = '" . $db->real_escape_string($status_filter) . "'";
if ($search) { $s = $db->real_escape_string($search); $wp[] = "(u.name LIKE '%$s%' OR p.title LIKE '%$s%')"; }
$where = $wp ? 'WHERE ' . implode(' AND ', $wp) : '';
$total = $db->query("SELECT COUNT(*) as c FROM bookings b JOIN users u ON b.user_id=u.id JOIN packages p ON b.package_id=p.id $where")->fetch_assoc()['c'];
$total_pages = ceil($total / $per_page);
$bookings = $db->query("SELECT b.*, u.name as user_name, u.email as user_email, p.title as package_title, p.price, (p.price*b.travelers) as total_price FROM bookings b JOIN users u ON b.user_id=u.id JOIN packages p ON b.package_id=p.id $where ORDER BY b.created_at DESC LIMIT $per_page OFFSET $offset");
include('includes/admin-header.php');
?>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <h3 class="text-sm font-bold text-slate-800">Bookings (<?= $total ?>)</h3>
        <div class="flex items-center gap-3 flex-wrap w-full sm:w-auto">
            <form method="GET" class="flex items-center gap-2 flex-1 sm:flex-initial">
                <select name="status" onchange="this.form.submit()" class="px-3 py-2 text-xs font-semibold border border-slate-200 rounded-lg bg-slate-50 focus:outline-none focus:ring-2 focus:ring-champagne/30">
                    <option value="">All Status</option>
                    <option value="pending" <?= $status_filter==='pending'?'selected':'' ?>>Pending</option>
                    <option value="confirmed" <?= $status_filter==='confirmed'?'selected':'' ?>>Confirmed</option>
                    <option value="cancelled" <?= $status_filter==='cancelled'?'selected':'' ?>>Cancelled</option>
                </select>
                <div class="relative flex-1 sm:flex-initial">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" placeholder="Search..." value="<?= htmlspecialchars($search) ?>" class="pl-9 pr-3 py-2 text-sm border border-slate-200 rounded-lg bg-slate-50 focus:outline-none focus:ring-2 focus:ring-champagne/30 w-full sm:w-44">
                </div>
            </form>
            <a href="includes/admin-actions.php?action=export_bookings_csv" class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors whitespace-nowrap">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export CSV
            </a>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead><tr class="bg-slate-50">
                <th class="px-5 py-3 text-left text-[0.68rem] font-bold uppercase tracking-wider text-slate-400">ID</th>
                <th class="px-5 py-3 text-left text-[0.68rem] font-bold uppercase tracking-wider text-slate-400">Customer</th>
                <th class="px-5 py-3 text-left text-[0.68rem] font-bold uppercase tracking-wider text-slate-400 hidden lg:table-cell">Package</th>
                <th class="px-5 py-3 text-left text-[0.68rem] font-bold uppercase tracking-wider text-slate-400 hidden md:table-cell">Travel Date</th>
                <th class="px-5 py-3 text-center text-[0.68rem] font-bold uppercase tracking-wider text-slate-400 hidden sm:table-cell">Pax</th>
                <th class="px-5 py-3 text-left text-[0.68rem] font-bold uppercase tracking-wider text-slate-400">Total</th>
                <th class="px-5 py-3 text-left text-[0.68rem] font-bold uppercase tracking-wider text-slate-400">Payment</th>
                <th class="px-5 py-3 text-left text-[0.68rem] font-bold uppercase tracking-wider text-slate-400">Status</th>
                <th class="px-5 py-3 text-right text-[0.68rem] font-bold uppercase tracking-wider text-slate-400">Actions</th>
            </tr></thead>
            <tbody>
                <?php while ($b = $bookings->fetch_assoc()): ?>
                <tr class="border-b border-slate-50 hover:bg-slate-50/50">
                    <td class="px-5 py-3 text-sm font-semibold text-slate-400">#<?= str_pad($b['id'], 3, '0', STR_PAD_LEFT) ?></td>
                    <td class="px-5 py-3">
                        <p class="text-sm font-semibold text-slate-700"><?= htmlspecialchars($b['user_name']) ?></p>
                        <p class="text-xs text-slate-400"><?= htmlspecialchars($b['user_email']) ?></p>
                    </td>
                    <td class="px-5 py-3 text-sm text-slate-500 hidden lg:table-cell"><?= htmlspecialchars(mb_strimwidth($b['package_title'], 0, 22, '...')) ?></td>
                    <td class="px-5 py-3 text-sm text-slate-400 hidden md:table-cell"><?= date('M d, Y', strtotime($b['start_date'])) ?></td>
                    <td class="px-5 py-3 text-sm text-slate-500 text-center hidden sm:table-cell"><?= $b['travelers'] ?></td>
                    <td class="px-5 py-3 text-sm font-bold text-slate-700">ETB <?= number_format($b['total_price']) ?></td>
                    <td class="px-5 py-3"><span class="text-[0.6rem] font-black uppercase tracking-widest <?= $b['payment_status']==='paid' ? 'text-emerald-500' : 'text-slate-300' ?>"><?= $b['payment_status'] ?></span></td>
                    <td class="px-5 py-3"><span class="inline-block px-2.5 py-1 rounded-full text-[0.68rem] font-semibold <?= $b['status']==='confirmed' ? 'bg-emerald-50 text-emerald-700' : ($b['status']==='pending' ? 'bg-amber-50 text-amber-700' : 'bg-red-50 text-red-600') ?>"><?= $b['status'] ?></span></td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="<?= BASE_URL ?>/admin/booking-detail?id=<?= $b['id'] ?>" class="px-2.5 py-1.5 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">Details</a>
                            <form method="POST" action="includes/admin-actions.php?action=update_booking_status" class="flex items-center gap-1.5">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($admin_csrf_token) ?>">
                                <input type="hidden" name="id" value="<?= $b['id'] ?>">
                                <select name="status" class="px-2 py-1.5 text-xs font-semibold border border-slate-200 rounded-lg bg-slate-50 focus:outline-none focus:ring-2 focus:ring-champagne/30">
                                    <option value="pending" <?= $b['status']==='pending'?'selected':'' ?>>Pending</option>
                                    <option value="confirmed" <?= $b['status']==='confirmed'?'selected':'' ?>>Confirmed</option>
                                    <option value="cancelled" <?= $b['status']==='cancelled'?'selected':'' ?>>Cancelled</option>
                                </select>
                                <button type="submit" class="px-2.5 py-1.5 text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded-lg transition-colors">Save</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php if ($total == 0): ?><tr><td colspan="8" class="px-5 py-12 text-center text-sm text-slate-400">No bookings found.</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if ($total_pages > 1): ?>
    <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between text-sm text-slate-400">
        <span>Showing <?= $offset+1 ?>–<?= min($offset+$per_page, $total) ?> of <?= $total ?></span>
        <div class="flex gap-1"><?php for ($i = 1; $i <= $total_pages; $i++): ?><a href="?page=<?= $i ?>&status=<?= urlencode($status_filter) ?>&search=<?= urlencode($search) ?>" class="w-8 h-8 flex items-center justify-center rounded-lg text-xs font-semibold <?= $i === $page ? 'bg-champagne text-slate-800' : 'text-slate-500 hover:bg-slate-100' ?>"><?= $i ?></a><?php endfor; ?></div>
    </div>
    <?php endif; ?>
</div>

<?php include('includes/admin-footer.php'); ?>
