<?php
include('includes/admin-guard.php');
$page_title = 'Dashboard';

// Stats
$total_bookings_res = $db->query("SELECT COUNT(*) as c FROM bookings");
$total_bookings = ($total_bookings_res) ? $total_bookings_res->fetch_assoc()['c'] : 0;
$revenue_query = $db->query("SELECT COALESCE(SUM(p.price * b.travelers), 0) as r FROM bookings b JOIN packages p ON b.package_id = p.id WHERE b.status = 'confirmed'");
$revenue = $revenue_query ? $revenue_query->fetch_assoc()['r'] : 0;
$total_users_res = $db->query("SELECT COUNT(*) as c FROM users WHERE role = 'user'");
$total_users = ($total_users_res) ? $total_users_res->fetch_assoc()['c'] : 0;
$total_destinations_res = $db->query("SELECT COUNT(*) as c FROM destinations");
$total_destinations = ($total_destinations_res) ? $total_destinations_res->fetch_assoc()['c'] : 0;
$pending_count_res = $db->query("SELECT COUNT(*) as c FROM bookings WHERE status = 'pending'");
$pending_count = ($pending_count_res) ? $pending_count_res->fetch_assoc()['c'] : 0;
$unread_msgs_res = $db->query("SELECT COUNT(*) as c FROM contacts WHERE is_read = 0");
$unread_msgs = ($unread_msgs_res) ? $unread_msgs_res->fetch_assoc()['c'] : 0;

// Recent Data
$recent_bookings = $db->query("SELECT b.*, u.name as user_name, p.title as package_title, p.price FROM bookings b JOIN users u ON b.user_id = u.id JOIN packages p ON b.package_id = p.id ORDER BY b.created_at DESC LIMIT 5");
$recent_messages = $db->query("SELECT * FROM contacts ORDER BY created_at DESC LIMIT 5");
// Chart 1: Bookings by Month (Last 6 Months)
$bookings_chart = [];
for ($i = 5; $i >= 0; $i--) {
    $ms = date('Y-m-01', strtotime("-$i months"));
    $me = date('Y-m-t', strtotime("-$i months"));
    $ml = date('M', strtotime("-$i months"));
    $mc = $db->query("SELECT COUNT(*) as c FROM bookings WHERE created_at BETWEEN '$ms' AND '$me 23:59:59'")->fetch_assoc()['c'];
    $bookings_chart[] = ['label' => $ml, 'count' => (int)$mc];
}

// Chart 2: Revenue Trend (Last 6 Months)
$revenue_chart = [];
for ($i = 5; $i >= 0; $i--) {
    $ms = date('Y-m-01', strtotime("-$i months"));
    $me = date('Y-m-t', strtotime("-$i months"));
    $ml = date('M', strtotime("-$i months"));
    $mr = $db->query("SELECT COALESCE(SUM(p.price * b.travelers), 0) as r FROM bookings b JOIN packages p ON b.package_id = p.id WHERE b.status = 'confirmed' AND b.created_at BETWEEN '$ms' AND '$me 23:59:59'")->fetch_assoc()['r'];
    $revenue_chart[] = ['label' => $ml, 'revenue' => (float)$mr];
}

// Chart 3: Booking Status Distribution
$status_dist = $db->query("SELECT status, COUNT(*) as c FROM bookings GROUP BY status");
$status_data = [];
while($row = $status_dist->fetch_assoc()) {
    $status_data[] = $row;
}

include('includes/admin-header.php');
?>

<!-- Enhanced Stats with Hover Effects -->
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
        <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        </div>
        <p class="text-3xl font-black text-slate-800 tracking-tight"><?= number_format($total_bookings) ?></p>
        <p class="text-sm text-slate-400 font-semibold mt-1">Total Bookings</p>
        <div class="mt-4 h-1 w-full bg-slate-50 rounded-full overflow-hidden">
            <div class="h-full bg-blue-500 rounded-full" style="width: 75%"></div>
        </div>
    </div>
    
    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
        <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
            <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <p class="text-3xl font-black text-slate-800 tracking-tight"><span class="text-xs align-middle mr-1">ETB</span><?= number_format($revenue) ?></p>
        <p class="text-sm text-slate-400 font-semibold mt-1">Confirmed Revenue</p>
        <div class="mt-4 h-1 w-full bg-slate-50 rounded-full overflow-hidden">
            <div class="h-full bg-emerald-500 rounded-full" style="width: 45%"></div>
        </div>
    </div>

    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
        <div class="w-14 h-14 rounded-2xl bg-violet-50 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
            <svg class="w-6 h-6 text-violet-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        </div>
        <p class="text-3xl font-black text-slate-800 tracking-tight"><?= number_format($total_users) ?></p>
        <p class="text-sm text-slate-400 font-semibold mt-1">Registered Users</p>
        <div class="mt-4 h-1 w-full bg-slate-50 rounded-full overflow-hidden">
            <div class="h-full bg-violet-500 rounded-full" style="width: 60%"></div>
        </div>
    </div>

    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
        <div class="w-14 h-14 rounded-2xl bg-amber-50 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
            <svg class="w-6 h-6 text-champagne" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <p class="text-3xl font-black text-slate-800 tracking-tight"><?= $total_destinations ?></p>
        <p class="text-sm text-slate-400 font-semibold mt-1">Destinations</p>
        <div class="mt-4 h-1 w-full bg-slate-50 rounded-full overflow-hidden">
            <div class="h-full bg-champagne rounded-full" style="width: 85%"></div>
        </div>
    </div>
</div>

<!-- Interactive Graphs Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Booking Trends (Line) -->
    <div class="lg:col-span-2 bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Revenue & Booking Trends</h3>
                <p class="text-xs text-slate-400 font-medium mt-1">Performance over the last 6 months</p>
            </div>
            <div class="flex gap-2">
                <span class="flex items-center gap-1.5 text-[0.65rem] font-bold text-slate-500 bg-slate-50 px-3 py-1.5 rounded-full border border-slate-100">
                    <span class="w-2 h-2 rounded-full bg-champagne"></span> Revenue
                </span>
                <span class="flex items-center gap-1.5 text-[0.65rem] font-bold text-slate-500 bg-slate-50 px-3 py-1.5 rounded-full border border-slate-100">
                    <span class="w-2 h-2 rounded-full bg-blue-400"></span> Bookings
                </span>
            </div>
        </div>
        <div class="relative h-[300px]">
            <canvas id="performanceChart"></canvas>
        </div>
    </div>

    <!-- Booking Distribution (Doughnut) -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">
        <h3 class="text-lg font-bold text-slate-800 mb-1">Booking Status</h3>
        <p class="text-xs text-slate-400 font-medium mb-8">Distribution by current status</p>
        <div class="relative h-[250px] flex items-center justify-center">
            <canvas id="statusChart"></canvas>
        </div>
        <div class="mt-8 space-y-3">
            <?php foreach($status_data as $s): ?>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full <?= $s['status'] === 'confirmed' ? 'bg-emerald-500' : ($s['status'] === 'pending' ? 'bg-amber-500' : 'bg-red-500') ?>"></span>
                    <span class="text-xs font-bold text-slate-600 capitalize"><?= $s['status'] ?></span>
                </div>
                <span class="text-xs font-black text-slate-800"><?= $s['c'] ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
    <!-- Recent Activity -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-50 flex items-center justify-between bg-slate-50/30">
            <h3 class="text-sm font-bold text-slate-800">Recent Bookings</h3>
            <a href="bookings.php" class="text-[0.65rem] font-black uppercase tracking-wider text-champagne hover:text-champagne-dark transition-colors">View All →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead><tr class="bg-slate-50/50"><th class="px-8 py-4 text-left text-[0.6rem] font-black uppercase tracking-widest text-slate-400">Customer</th><th class="px-8 py-4 text-left text-[0.6rem] font-black uppercase tracking-widest text-slate-400">Package</th><th class="px-8 py-4 text-left text-[0.6rem] font-black uppercase tracking-widest text-slate-400">Status</th><th class="px-8 py-4 text-left text-[0.6rem] font-black uppercase tracking-widest text-slate-400">Time</th></tr></thead>
                <tbody>
                    <?php while ($recent_bookings && $b = $recent_bookings->fetch_assoc()): ?>
                    <tr class="border-b border-slate-50/50 hover:bg-slate-50/30 transition-colors">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-[0.6rem] font-bold text-slate-500"><?= strtoupper(substr($b['user_name'], 0, 1)) ?></div>
                                <span class="text-sm font-bold text-slate-700"><?= htmlspecialchars($b['user_name']) ?></span>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-sm text-slate-500 font-medium"><?= htmlspecialchars(mb_strimwidth($b['package_title'], 0, 25, '...')) ?></td>
                        <td class="px-8 py-5"><span class="inline-block px-3 py-1 rounded-full text-[0.6rem] font-black uppercase tracking-tighter <?= $b['status']==='confirmed' ? 'bg-emerald-50 text-emerald-700' : ($b['status']==='pending' ? 'bg-amber-50 text-amber-700' : 'bg-red-50 text-red-600') ?>"><?= $b['status'] ?></span></td>
                        <td class="px-8 py-5 text-xs text-slate-400 font-medium"><?= timeAgo($b['created_at']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Contact Stream -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-50 flex items-center justify-between bg-slate-50/30">
            <h3 class="text-sm font-bold text-slate-800">Latest Enquiries</h3>
            <a href="contacts.php" class="text-[0.65rem] font-black uppercase tracking-wider text-champagne hover:text-champagne-dark transition-colors">View All →</a>
        </div>
        <div class="p-8 space-y-6">
            <?php while ($recent_messages && $m = $recent_messages->fetch_assoc()): ?>
            <div class="flex gap-4 group cursor-pointer">
                <div class="w-10 h-10 rounded-2xl bg-slate-50 flex items-center justify-center flex-shrink-0 group-hover:bg-champagne/10 transition-colors">
                    <svg class="w-5 h-5 text-slate-400 group-hover:text-champagne transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between mb-1">
                        <p class="text-sm font-bold text-slate-800 truncate"><?= htmlspecialchars($m['name']) ?></p>
                        <span class="text-[0.6rem] font-bold text-slate-400 whitespace-nowrap"><?= timeAgo($m['created_at']) ?></span>
                    </div>
                    <p class="text-xs text-slate-400 line-clamp-2 leading-relaxed"><?= htmlspecialchars($m['message']) ?></p>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
Chart.defaults.font.family = "'Inter', sans-serif";
Chart.defaults.color = '#94a3b8';

// Performance Chart (Multi-type)
new Chart(document.getElementById('performanceChart').getContext('2d'), {
    type: 'line',
    data: {
        labels: <?= json_encode(array_column($bookings_chart, 'label')) ?>,
        datasets: [
            {
                label: 'Revenue',
                data: <?= json_encode(array_column($revenue_chart, 'revenue')) ?>,
                borderColor: '#c9a96e',
                backgroundColor: 'rgba(201, 169, 110, 0.1)',
                borderWidth: 4,
                tension: 0.4,
                fill: true,
                pointRadius: 0,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#c9a96e',
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 3,
                yAxisID: 'y'
            },
            {
                label: 'Bookings',
                data: <?= json_encode(array_column($bookings_chart, 'count')) ?>,
                type: 'bar',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                hoverBackgroundColor: 'rgba(59, 130, 246, 0.2)',
                borderRadius: 8,
                barPercentage: 0.4,
                yAxisID: 'y1'
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { intersect: false, mode: 'index' },
        plugins: { legend: { display: false }, tooltip: { padding: 12, borderRadius: 12, titleFont: { size: 13, weight: 'bold' } } },
        scales: {
            y: { position: 'left', beginAtZero: true, grid: { color: '#f8fafc' }, ticks: { font: { size: 10, weight: 'bold' } } },
            y1: { position: 'right', beginAtZero: true, grid: { display: false }, ticks: { display: false } },
            x: { grid: { display: false }, ticks: { font: { size: 10, weight: 'bold' } } }
        }
    }
});

// Status Distribution Chart
new Chart(document.getElementById('statusChart').getContext('2d'), {
    type: 'doughnut',
    data: {
        labels: <?= json_encode(array_column($status_data, 'status')) ?>,
        datasets: [{
            data: <?= json_encode(array_column($status_data, 'c')) ?>,
            backgroundColor: [
                '#10b981', // confirmed
                '#f59e0b', // pending
                '#ef4444'  // cancelled
            ],
            borderWidth: 0,
            hoverOffset: 20,
            cutout: '80%',
            borderRadius: 10
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false }, tooltip: { cornerRadius: 10, padding: 10 } }
    }
});
</script>

<?php include('includes/admin-footer.php'); ?>
