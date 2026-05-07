<?php
include('includes/admin-guard.php');

$id = $_GET['id'] ?? 0;
$booking = $db->query("SELECT b.*, u.name as user_name, u.email as user_email, p.title as package_title, p.price, p.duration, p.image_url as package_image, d.name as destination_name 
    FROM bookings b 
    JOIN users u ON b.user_id = u.id 
    JOIN packages p ON b.package_id = p.id 
    JOIN destinations d ON p.destination_id = d.id
    WHERE b.id = " . (int)$id)->fetch_assoc();

if (!$booking) {
    header("Location: bookings.php");
    exit();
}

$page_title = 'Booking Detail #' . str_pad($id, 3, '0', STR_PAD_LEFT);
include('includes/admin-header.php');
?>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    <!-- Booking Information -->
    <div class="xl:col-span-2 space-y-8">
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-50 flex items-center justify-between bg-slate-50/30">
                <h3 class="text-sm font-bold text-slate-800">Reservation Breakdown</h3>
                <span class="inline-block px-3 py-1 rounded-full text-[0.65rem] font-black uppercase tracking-widest <?= $booking['status']==='confirmed' ? 'bg-emerald-50 text-emerald-700' : ($booking['status']==='pending' ? 'bg-amber-50 text-amber-700' : 'bg-red-50 text-red-600') ?>">
                    <?= $booking['status'] ?>
                </span>
            </div>
            
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <p class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-widest mb-2">Package Details</p>
                        <div class="flex items-start gap-4">
                            <img src="<?= htmlspecialchars($booking['package_image']) ?>" class="w-20 h-20 rounded-2xl object-cover border border-slate-100" onerror="this.src='../assets/images/default.jpg'">
                            <div>
                                <h4 class="text-base font-bold text-slate-800"><?= htmlspecialchars($booking['package_title']) ?></h4>
                                <p class="text-xs text-slate-500 mt-1"><?= htmlspecialchars($booking['destination_name']) ?> • <?= htmlspecialchars($booking['duration']) ?></p>
                                <p class="text-sm font-bold text-champagne mt-2">ETB <?= number_format($booking['price']) ?> / person</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <p class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-widest mb-2">Traveler Info</p>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-xs text-slate-500">Travel Date:</span>
                                <span class="text-xs font-bold text-slate-800"><?= date('F d, Y', strtotime($booking['start_date'])) ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-xs text-slate-500">Number of Travelers:</span>
                                <span class="text-xs font-bold text-slate-800"><?= $booking['travelers'] ?> pax</span>
                            </div>
                            <div class="flex justify-between pt-2 border-t border-slate-50">
                                <span class="text-xs font-bold text-slate-800">Total Price:</span>
                                <span class="text-lg font-black text-slate-800">ETB <?= number_format($booking['price'] * $booking['travelers']) ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 rounded-2xl p-6">
                    <p class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-widest mb-3">Special Requests</p>
                    <p class="text-sm text-slate-600 leading-relaxed italic">
                        <?= !empty($booking['special_requests']) ? nl2br(htmlspecialchars($booking['special_requests'])) : 'No special requests provided.' ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Action Card -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">
            <h3 class="text-sm font-bold text-slate-800 mb-6">Manage Booking Status</h3>
            <form action="includes/admin-actions.php?action=update_booking_status" method="POST" class="flex flex-wrap items-center gap-4">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($admin_csrf_token) ?>">
                <input type="hidden" name="id" value="<?= $booking['id'] ?>">
                <div class="flex-1 min-w-[200px]">
                    <select name="status" class="w-full px-4 py-3 text-sm border border-slate-200 rounded-xl bg-slate-50 focus:ring-2 focus:ring-champagne/30 focus:border-champagne outline-none transition-all">
                        <option value="pending" <?= $booking['status']==='pending'?'selected':'' ?>>Pending Approval</option>
                        <option value="confirmed" <?= $booking['status']==='confirmed'?'selected':'' ?>>Confirmed / Approved</option>
                        <option value="cancelled" <?= $booking['status']==='cancelled'?'selected':'' ?>>Cancelled / Rejected</option>
                    </select>
                </div>
                <button type="submit" class="px-8 py-3 bg-champagne text-slate-800 text-sm font-bold rounded-xl hover:bg-champagne-dark transition-all">Update Status</button>
                <button type="button" onclick="confirmDelete('includes/admin-actions.php?action=delete_booking&id=<?= $booking['id'] ?>', 'Booking #<?= $id ?>')" class="px-8 py-3 bg-red-50 text-red-600 text-sm font-bold rounded-xl hover:bg-red-100 transition-all ml-auto">Delete Record</button>
            </form>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div class="space-y-8">
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">
            <h3 class="text-sm font-bold text-slate-800 mb-6">Customer Profile</h3>
            <div class="flex items-center gap-4 mb-6">
                <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center text-xl font-bold text-slate-400">
                    <?= strtoupper(substr($booking['user_name'], 0, 1)) ?>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-800"><?= htmlspecialchars($booking['user_name']) ?></h4>
                    <p class="text-xs text-slate-400"><?= htmlspecialchars($booking['user_email']) ?></p>
                </div>
            </div>
            <div class="space-y-4">
                <a href="mailto:<?= $booking['user_email'] ?>" class="flex items-center gap-3 w-full px-4 py-3 rounded-xl border border-slate-100 text-xs font-bold text-slate-600 hover:bg-slate-50 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Send Email
                </a>
                <a href="users.php?search=<?= urlencode($booking['user_email']) ?>" class="flex items-center gap-3 w-full px-4 py-3 rounded-xl border border-slate-100 text-xs font-bold text-slate-600 hover:bg-slate-50 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    View User History
                </a>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">
            <h3 class="text-sm font-bold text-slate-800 mb-6">Payment Verification</h3>
            <div class="space-y-4">
                <div class="p-4 rounded-2xl border <?= $booking['payment_status']==='paid' ? 'bg-emerald-50/50 border-emerald-100' : 'bg-slate-50 border-slate-100' ?>">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[0.6rem] font-black uppercase tracking-widest text-slate-400">Current Status</span>
                        <span class="text-[0.65rem] font-black uppercase tracking-widest <?= $booking['payment_status']==='paid' ? 'text-emerald-600' : 'text-slate-500' ?>"><?= strtoupper($booking['payment_status'] ?? 'pending') ?></span>
                    </div>
                    <?php if (($booking['payment_status'] ?? '') === 'paid'): ?>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span class="text-xs font-black text-slate-800">Transaction Secured</span>
                        </div>
                    <?php else: ?>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-xs font-bold text-slate-400">Awaiting Settlement</span>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="flex justify-between items-center px-4">
                    <span class="text-[0.6rem] font-black uppercase tracking-widest text-slate-400">Transaction ID</span>
                    <span class="text-[0.65rem] font-mono text-slate-600"><?= htmlspecialchars($booking['transaction_id'] ?? 'N/A') ?></span>
                </div>
            </div>
        </div>

        <div class="bg-sidebar rounded-[2.5rem] p-8 text-white">
            <h3 class="text-sm font-bold mb-4">Internal Notes</h3>
            <p class="text-xs text-white/50 leading-relaxed">Booked on: <?= date('F d, Y @ H:i', strtotime($booking['created_at'])) ?></p>
            <div class="mt-6 p-4 bg-white/5 rounded-2xl border border-white/10">
                <p class="text-[0.65rem] text-white/30 uppercase font-black tracking-widest mb-2">Helpful Tip</p>
                <p class="text-xs leading-relaxed text-white/70 italic">Confirming this booking will notify the customer via email (if integrated) and update their personal dashboard.</p>
            </div>
        </div>
    </div>
</div>

<?php include('includes/admin-footer.php'); ?>
