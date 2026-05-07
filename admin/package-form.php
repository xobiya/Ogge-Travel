<?php
include('includes/admin-guard.php');
$id = $_GET['id'] ?? null; $pkg = null;
if ($id) { $stmt = $db->prepare("SELECT * FROM packages WHERE id = ?"); $stmt->bind_param("i", $id); $stmt->execute(); $pkg = $stmt->get_result()->fetch_assoc(); $stmt->close(); if (!$pkg) { header("Location: packages.php"); exit(); } }
$destinations = $db->query("SELECT id, name FROM destinations ORDER BY name ASC");
$page_title = $pkg ? 'Edit Package' : 'Add Package';
include('includes/admin-header.php');
?>

<div class="max-w-2xl">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sm:p-8">
        <h3 class="text-lg font-bold text-slate-800 mb-1"><?= $pkg ? 'Edit' : 'New' ?> Package</h3>
        <p class="text-sm text-slate-400 mb-6"><?= $pkg ? 'Update package details.' : 'Create a new travel package.' ?></p>

        <form method="POST" action="includes/admin-actions.php?action=save_package" class="space-y-5">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($admin_csrf_token) ?>">
            <?php if ($pkg): ?><input type="hidden" name="id" value="<?= $pkg['id'] ?>"><?php endif; ?>

            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Package Title</label>
                <input type="text" name="title" value="<?= htmlspecialchars($pkg['title'] ?? '') ?>" placeholder="e.g. Lalibela Pilgrimage" required class="w-full px-4 py-3 text-sm border border-slate-200 rounded-xl bg-slate-50 focus:outline-none focus:ring-2 focus:ring-champagne/30 focus:border-champagne focus:bg-white transition-all">
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Destination</label>
                    <select name="destination_id" required class="w-full px-4 py-3 text-sm border border-slate-200 rounded-xl bg-slate-50 focus:outline-none focus:ring-2 focus:ring-champagne/30 focus:border-champagne focus:bg-white transition-all">
                        <option value="">Select...</option>
                        <?php while ($d = $destinations->fetch_assoc()): ?><option value="<?= $d['id'] ?>" <?= ($pkg && $pkg['destination_id'] == $d['id']) ? 'selected' : '' ?>><?= htmlspecialchars($d['name']) ?></option><?php endwhile; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Duration</label>
                    <input type="text" name="duration" value="<?= htmlspecialchars($pkg['duration'] ?? '') ?>" placeholder="e.g. 3 days, 2 nights" required class="w-full px-4 py-3 text-sm border border-slate-200 rounded-xl bg-slate-50 focus:outline-none focus:ring-2 focus:ring-champagne/30 focus:border-champagne focus:bg-white transition-all">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Price (ETB)</label>
                <input type="number" name="price" value="<?= $pkg['price'] ?? '' ?>" placeholder="e.g. 25000" min="1" step="0.01" required class="w-full px-4 py-3 text-sm border border-slate-200 rounded-xl bg-slate-50 focus:outline-none focus:ring-2 focus:ring-champagne/30 focus:border-champagne focus:bg-white transition-all">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Description</label>
                <textarea name="description" rows="4" placeholder="Describe this package..." required class="w-full px-4 py-3 text-sm border border-slate-200 rounded-xl bg-slate-50 focus:outline-none focus:ring-2 focus:ring-champagne/30 focus:border-champagne focus:bg-white transition-all resize-none"><?= htmlspecialchars($pkg['description'] ?? '') ?></textarea>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Image URL</label>
                <input type="text" name="image_url" id="imageUrl" value="<?= htmlspecialchars($pkg['image_url'] ?? '') ?>" placeholder="../assets/images/example.jpg" required oninput="previewImage(this, 'imgPreview')" class="w-full px-4 py-3 text-sm border border-slate-200 rounded-xl bg-slate-50 focus:outline-none focus:ring-2 focus:ring-champagne/30 focus:border-champagne focus:bg-white transition-all">
                <img id="imgPreview" src="<?= htmlspecialchars($pkg['image_url'] ?? '') ?>" class="mt-3 w-full max-w-xs h-44 object-cover rounded-xl border border-slate-200" style="<?= $pkg ? '' : 'display:none;' ?>" onerror="this.style.display='none'">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="px-6 py-2.5 text-sm font-bold text-slate-800 bg-champagne hover:bg-champagne-light rounded-xl transition-colors"><?= $pkg ? 'Update' : 'Create' ?> Package</button>
                <a href="packages.php" class="px-6 py-2.5 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include('includes/admin-footer.php'); ?>
