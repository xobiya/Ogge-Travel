<?php
include('includes/admin-guard.php');
$id = $_GET['id'] ?? null;
$dest = null;
if ($id) { $stmt = $db->prepare("SELECT * FROM destinations WHERE id = ?"); $stmt->bind_param("i", $id); $stmt->execute(); $dest = $stmt->get_result()->fetch_assoc(); $stmt->close(); if (!$dest) { header("Location: " . BASE_URL . "/admin/destinations"); exit(); } }
$page_title = $dest ? 'Edit Destination' : 'Add Destination';
include('includes/admin-header.php');
?>

<div class="max-w-2xl">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sm:p-8">
        <h3 class="text-lg font-bold text-slate-800 mb-1"><?= $dest ? 'Edit' : 'New' ?> Destination</h3>
        <p class="text-sm text-slate-400 mb-6"><?= $dest ? 'Update destination details below.' : 'Fill in the details to add a new destination.' ?></p>

        <form method="POST" action="includes/admin-actions.php?action=save_destination" class="space-y-5">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($admin_csrf_token) ?>">
            <?php if ($dest): ?><input type="hidden" name="id" value="<?= $dest['id'] ?>"><?php endif; ?>

            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Destination Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($dest['name'] ?? '') ?>" placeholder="e.g. Lalibela" required class="w-full px-4 py-3 text-sm border border-slate-200 rounded-xl bg-slate-50 focus:outline-none focus:ring-2 focus:ring-champagne/30 focus:border-champagne focus:bg-white transition-all">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Description</label>
                <textarea name="description" rows="5" placeholder="Describe this destination..." required class="w-full px-4 py-3 text-sm border border-slate-200 rounded-xl bg-slate-50 focus:outline-none focus:ring-2 focus:ring-champagne/30 focus:border-champagne focus:bg-white transition-all resize-none"><?= htmlspecialchars($dest['description'] ?? '') ?></textarea>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Image URL</label>
                <input type="text" name="image_url" id="imageUrl" value="<?= htmlspecialchars($dest['image_url'] ?? '') ?>" placeholder="../assets/images/example.jpg" required oninput="previewImage(this, 'imgPreview')" class="w-full px-4 py-3 text-sm border border-slate-200 rounded-xl bg-slate-50 focus:outline-none focus:ring-2 focus:ring-champagne/30 focus:border-champagne focus:bg-white transition-all">
                <img id="imgPreview" src="<?= htmlspecialchars($dest['image_url'] ?? '') ?>" class="mt-3 w-full max-w-xs h-44 object-cover rounded-xl border border-slate-200" style="<?= $dest ? '' : 'display:none;' ?>" onerror="this.style.display='none'">
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="px-6 py-2.5 text-sm font-bold text-slate-800 bg-champagne hover:bg-champagne-light rounded-xl transition-colors"><?= $dest ? 'Update' : 'Create' ?> Destination</button>
                <a href="<?= BASE_URL ?>/admin/destinations" class="px-6 py-2.5 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include('includes/admin-footer.php'); ?>
