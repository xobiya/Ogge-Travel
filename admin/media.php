<?php
include('includes/admin-guard.php');
$page_title = 'Media Library';

$upload_dir = '../assets/images/';
$allowed_ext = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
$media_csrf_token = ogge_csrf_token();

// Handle Upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    if (!ogge_validate_csrf($_POST['csrf_token'] ?? null)) {
        $_SESSION['admin_error'] = 'Security check failed. Please upload again.';
    } else {
        $file = $_FILES['image'];
        $allowed_mimes = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            'image/gif' => 'gif',
        ];
        $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK && $file['size'] <= 5 * 1024 * 1024 && isset($allowed_mimes[$mime])) {
            $filename = time() . '_' . bin2hex(random_bytes(8)) . '.' . $allowed_mimes[$mime];
            if (move_uploaded_file($file['tmp_name'], $upload_dir . $filename)) {
                logAdminAction($db, $admin_id, 'Uploaded image', 'media', 0, $filename);
                $_SESSION['admin_success'] = "Image uploaded successfully.";
            }
        } else {
            $_SESSION['admin_error'] = "Upload a JPG, PNG, WebP, or GIF image under 5 MB.";
        }
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
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($media_csrf_token) ?>">
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
                <button onclick="if(confirm('Delete this image?')) window.location.href='includes/admin-actions.php?action=delete_media&file=<?= urlencode($img['name']) ?>&csrf_token=<?= urlencode($admin_csrf_token) ?>'" class="text-[0.6rem] text-red-400 font-bold hover:text-red-300">Delete</button>
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
