<?php
/**
 * Admin Guard — Protects all admin pages
 * Include this at the top of every admin page
 */
require_once __DIR__ . '/../../includes/auth-helpers.php';
ogge_start_secure_session();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Please login to access the admin panel.";
    header("Location: ../pages/Account.php");
    exit();
}

// Verify admin role from database (don't trust session alone)
include_once(__DIR__ . '/../../includes/db-connect.php');
$guard_stmt = $db->prepare("SELECT role FROM users WHERE id = ?");
$guard_stmt->bind_param("i", $_SESSION['user_id']);
$guard_stmt->execute();
$guard_result = $guard_stmt->get_result()->fetch_assoc();
$guard_stmt->close();

if (!$guard_result || $guard_result['role'] !== 'admin') {
    $_SESSION['error'] = "You do not have permission to access this area.";
    header("Location: ../pages/index.php");
    exit();
}

// Set admin variables for use in templates
$admin_name = $_SESSION['user_name'] ?? 'Admin';
$admin_email = $_SESSION['user_email'] ?? '';
$admin_id = $_SESSION['user_id'];

/**
 * Helper: Log admin action
 */
function logAdminAction($db, $admin_id, $action, $target_type = null, $target_id = null, $details = null) {
    $stmt = $db->prepare("INSERT INTO admin_logs (admin_id, action, target_type, target_id, details) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issis", $admin_id, $action, $target_type, $target_id, $details);
    $stmt->execute();
    $stmt->close();
}

/**
 * Helper: Format time ago
 */
function timeAgo($datetime) {
    $now = new DateTime();
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    if ($diff->y > 0) return $diff->y . 'y ago';
    if ($diff->m > 0) return $diff->m . 'mo ago';
    if ($diff->d > 0) return $diff->d . 'd ago';
    if ($diff->h > 0) return $diff->h . 'h ago';
    if ($diff->i > 0) return $diff->i . 'm ago';
    return 'Just now';
}
?>
