<?php
include('includes/admin-guard.php');
$page_title = 'System Activity Logs';

$page = max(1, (int)($_GET['page'] ?? 1)); $per_page = 20; $offset = ($page - 1) * $per_page;
$total_res = $db->query("SELECT COUNT(*) as c FROM admin_logs");
$total = ($total_res) ? $total_res->fetch_assoc()['c'] : 0;
$total_pages = ceil($total / $per_page);

$logs = $db->query("SELECT l.*, u.name as admin_name 
    FROM admin_logs l 
    JOIN users u ON l.admin_id = u.id 
    ORDER BY l.created_at DESC 
    LIMIT $per_page OFFSET $offset");

include('includes/admin-header.php');
?>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
        <h3 class="text-sm font-bold text-slate-800">Admin Activity History (<?= $total ?>)</h3>
        <button onclick="if(confirm('Clear all logs?')) window.location.href='includes/admin-actions.php?action=clear_logs'" class="px-3 py-1.5 text-[0.65rem] font-bold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg uppercase tracking-wider transition-colors">Clear All Logs</button>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead><tr class="bg-slate-50">
                <th class="px-5 py-3 text-left text-[0.68rem] font-bold uppercase tracking-wider text-slate-400 w-40">Admin</th>
                <th class="px-5 py-3 text-left text-[0.68rem] font-bold uppercase tracking-wider text-slate-400">Action</th>
                <th class="px-5 py-3 text-left text-[0.68rem] font-bold uppercase tracking-wider text-slate-400">Details</th>
                <th class="px-5 py-3 text-left text-[0.68rem] font-bold uppercase tracking-wider text-slate-400">Time</th>
            </tr></thead>
            <tbody>
                <?php while ($logs && $l = $logs->fetch_assoc()): ?>
                <tr class="border-b border-slate-50 hover:bg-slate-50/50">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-[0.55rem] font-bold text-slate-400"><?= strtoupper(substr($l['admin_name'],0,1)) ?></div>
                            <span class="text-xs font-semibold text-slate-700"><?= htmlspecialchars($l['admin_name']) ?></span>
                        </div>
                    </td>
                    <td class="px-5 py-3">
                        <span class="inline-block px-2 py-0.5 rounded text-[0.65rem] font-bold <?= strpos($l['action'], 'delete') !== false ? 'bg-red-50 text-red-600' : (strpos($l['action'], 'update') !== false ? 'bg-blue-50 text-blue-600' : 'bg-emerald-50 text-emerald-600') ?> uppercase">
                            <?= str_replace('_', ' ', $l['action']) ?>
                        </span>
                    </td>
                    <td class="px-5 py-3 text-xs text-slate-500 font-medium">
                        <?php if ($l['target_type']): ?><span class="text-slate-400"><?= $l['target_type'] ?> #<?= $l['target_id'] ?>:</span><?php endif; ?>
                        <?= htmlspecialchars($l['details']) ?>
                    </td>
                    <td class="px-5 py-3 text-xs text-slate-400 whitespace-nowrap"><?= date('M d, Y @ H:i:s', strtotime($l['created_at'])) ?></td>
                </tr>
                <?php endwhile; ?>
                <?php if ($total == 0): ?><tr><td colspan="4" class="px-5 py-12 text-center text-sm text-slate-400">No activity logs found.</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if ($total_pages > 1): ?>
    <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between text-sm text-slate-400">
        <span>Showing <?= $offset+1 ?>–<?= min($offset+$per_page, $total) ?> of <?= $total ?></span>
        <div class="flex gap-1"><?php for ($i = 1; $i <= $total_pages; $i++): ?><a href="?page=<?= $i ?>" class="w-8 h-8 flex items-center justify-center rounded-lg text-xs font-semibold <?= $i === $page ? 'bg-champagne text-slate-800' : 'text-slate-500 hover:bg-slate-100' ?>"><?= $i ?></a><?php endfor; ?></div>
    </div>
    <?php endif; ?>
</div>

<?php include('includes/admin-footer.php'); ?>
