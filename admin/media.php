<?php
include('includes/admin-guard.php');
$page_title = 'Media Library';

$upload_dir = '../assets/images/';
$allowed_ext = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

// Handle Upload
if (isset($_FILES['image'])) {
    $file = $_FILES['image'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (in_array($ext, $allowed_ext)) {
        $filename = time() . '_' . basename($file['name']);
        if (move_uploaded_file($file['tmp_name'], $upload_dir . $filename)) {
            logAdminAction($db, $admin_id, 'Uploaded image', 'media', 0, $filename);
            $_SESSION['admin_success'] = "Image uploaded successfully.";
        }
    } else {
        $_SESSION['admin_error'] = "Invalid file type.";
    }
}

// Fetch files
$files = array_diff(scandir($upload_dir), array('.', '..'));
$images = [];
foreach ($files as $f) {
    if (in_array(strtolower(pathinfo($f, PATHINFO_EXTENSION)), $allowed_ext)) {
        $images[] = [
            'name' => $f,
            'url' => '../assets/images/' . $f,
            'size' => filesize($upload_dir . $f),
            'date' => filemtime($upload_dir . $f)
        ];
    }
}
usort($images, function($a, $b) { return $b['date'] - $a['date']; });

include('includes/admin-header.php');
?>

<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8 mb-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Media Assets</h3>
            <p class="text-xs text-slate-400 font-medium">Manage and upload high-resolution travel photos</p>
        </div>
        <form method="POST" enctype="multipart/form-data" class="flex items-center gap-3">
            <input type="file" name="image" id="fileInput" class="hidden" onchange="this.form.submit()">
            <label for="fileInput" class="cursor-pointer inline-flex items-center gap-2 px-6 py-3 bg-champagne text-slate-800 text-sm font-black rounded-2xl hover:bg-champagne-dark transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Upload New Asset
            </label>
        </form>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6">
        <?php foreach ($images as $img): ?>
        <div class="group relative bg-slate-50 rounded-2xl overflow-hidden border border-slate-100 transition-all hover:shadow-xl hover:-translate-y-1">
            <div class="aspect-square">
                <img src="<?= $img['url'] ?>" class="w-full h-full object-cover enhanced-img">
            </div>
            <div class="absolute inset-0 bg-slate-900/80 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center p-4 text-center">
                <p class="text-[0.6rem] text-white/60 truncate w-full mb-3"><?= $img['name'] ?></p>
                <button onclick="copyToClipboard('<?= $img['url'] ?>')" class="px-3 py-1.5 bg-champagne text-slate-800 text-[0.6rem] font-black rounded-lg mb-2">Copy Path</button>
                <button onclick="if(confirm('Delete this image?')) window.location.href='includes/admin-actions.php?action=delete_media&file=<?= urlencode($img['name']) ?>'" class="text-[0.6rem] text-red-400 font-bold hover:text-red-300">Delete</button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('Path copied to clipboard!');
    });
}
</script>

<?php include('includes/admin-footer.php'); ?>
