<?php
/**
 * Admin Actions — Centralized POST Handler
 */
include('admin-guard.php');

$action = $_GET['action'] ?? '';
$redirect = $_SERVER['HTTP_REFERER'] ?? '../admin/index.php';

switch ($action) {

    // ===== DESTINATIONS =====
    case 'save_destination':
        $id = $_POST['id'] ?? null;
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $image_url = trim($_POST['image_url'] ?? '');

        if (empty($name) || empty($description) || empty($image_url)) {
            $_SESSION['admin_error'] = "All fields are required.";
            header("Location: $redirect"); exit();
        }

        if ($id) {
            $stmt = $db->prepare("UPDATE destinations SET name=?, description=?, image_url=? WHERE id=?");
            $stmt->bind_param("sssi", $name, $description, $image_url, $id);
            $stmt->execute(); $stmt->close();
            logAdminAction($db, $admin_id, 'Updated destination', 'destination', $id, $name);
            $_SESSION['admin_success'] = "Destination updated successfully.";
        } else {
            $stmt = $db->prepare("INSERT INTO destinations (name, description, image_url) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $description, $image_url);
            $stmt->execute();
            $new_id = $db->insert_id;
            $stmt->close();
            logAdminAction($db, $admin_id, 'Created destination', 'destination', $new_id, $name);
            $_SESSION['admin_success'] = "Destination created successfully.";
        }
        header("Location: ../destinations.php"); exit();

    case 'delete_destination':
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $name = $db->query("SELECT name FROM destinations WHERE id=$id")->fetch_assoc()['name'] ?? '';
            // Check if packages depend on this destination
            $pkg_count = $db->query("SELECT COUNT(*) as c FROM packages WHERE destination_id=$id")->fetch_assoc()['c'];
            if ($pkg_count > 0) {
                $_SESSION['admin_error'] = "Cannot delete: $pkg_count package(s) are linked to this destination.";
            } else {
                $db->query("DELETE FROM destinations WHERE id=$id");
                logAdminAction($db, $admin_id, 'Deleted destination', 'destination', $id, $name);
                $_SESSION['admin_success'] = "Destination deleted.";
            }
        }
        header("Location: ../destinations.php"); exit();

    // ===== PACKAGES =====
    case 'save_package':
        $id = $_POST['id'] ?? null;
        $title = trim($_POST['title'] ?? '');
        $destination_id = (int)($_POST['destination_id'] ?? 0);
        $duration = trim($_POST['duration'] ?? '');
        $price = (float)($_POST['price'] ?? 0);
        $description = trim($_POST['description'] ?? '');
        $image_url = trim($_POST['image_url'] ?? '');

        if (empty($title) || $destination_id <= 0 || empty($duration) || $price <= 0 || empty($description) || empty($image_url)) {
            $_SESSION['admin_error'] = "All fields are required and price must be greater than 0.";
            header("Location: $redirect"); exit();
        }

        if ($id) {
            $stmt = $db->prepare("UPDATE packages SET title=?, destination_id=?, duration=?, price=?, description=?, image_url=? WHERE id=?");
            $stmt->bind_param("sisdisi", $title, $destination_id, $duration, $price, $description, $image_url, $id);
            $stmt->execute(); $stmt->close();
            logAdminAction($db, $admin_id, 'Updated package', 'package', $id, $title);
            $_SESSION['admin_success'] = "Package updated successfully.";
        } else {
            $stmt = $db->prepare("INSERT INTO packages (title, destination_id, duration, price, description, image_url) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sisdss", $title, $destination_id, $duration, $price, $description, $image_url);
            $stmt->execute();
            $new_id = $db->insert_id;
            $stmt->close();
            logAdminAction($db, $admin_id, 'Created package', 'package', $new_id, $title);
            $_SESSION['admin_success'] = "Package created successfully.";
        }
        header("Location: ../packages.php"); exit();

    case 'delete_package':
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $name = $db->query("SELECT title FROM packages WHERE id=$id")->fetch_assoc()['title'] ?? '';
            $booking_count = $db->query("SELECT COUNT(*) as c FROM bookings WHERE package_id=$id")->fetch_assoc()['c'];
            if ($booking_count > 0) {
                $_SESSION['admin_error'] = "Cannot delete: $booking_count booking(s) are linked to this package.";
            } else {
                $db->query("DELETE FROM packages WHERE id=$id");
                logAdminAction($db, $admin_id, 'Deleted package', 'package', $id, $name);
                $_SESSION['admin_success'] = "Package deleted.";
            }
        }
        header("Location: ../packages.php"); exit();

    // ===== BOOKINGS =====
    case 'update_booking_status':
        $id = (int)($_POST['id'] ?? 0);
        $status = $_POST['status'] ?? '';
        if ($id > 0 && in_array($status, ['pending', 'confirmed', 'cancelled'])) {
            $stmt = $db->prepare("UPDATE bookings SET status=? WHERE id=?");
            $stmt->bind_param("si", $status, $id);
            $stmt->execute(); $stmt->close();
            logAdminAction($db, $admin_id, "Booking status → $status", 'booking', $id);
            $_SESSION['admin_success'] = "Booking #$id status updated to $status.";
        }
        header("Location: $redirect"); exit();

    case 'delete_booking':
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $db->query("DELETE FROM bookings WHERE id=$id");
            logAdminAction($db, $admin_id, 'Deleted booking', 'booking', $id);
            $_SESSION['admin_success'] = "Booking deleted.";
        }
        header("Location: ../bookings.php"); exit();

    // ===== USERS =====
    case 'update_user_role':
        $id = (int)($_POST['id'] ?? 0);
        $role = $_POST['role'] ?? '';
        if ($id > 0 && in_array($role, ['user', 'admin']) && $id !== $admin_id) {
            $stmt = $db->prepare("UPDATE users SET role=? WHERE id=?");
            $stmt->bind_param("si", $role, $id);
            $stmt->execute(); $stmt->close();
            logAdminAction($db, $admin_id, "User role → $role", 'user', $id);
            $_SESSION['admin_success'] = "User role updated.";
        } elseif ($id === $admin_id) {
            $_SESSION['admin_error'] = "You cannot change your own role.";
        }
        header("Location: ../users.php"); exit();

    case 'delete_user':
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0 && $id !== $admin_id) {
            $name = $db->query("SELECT name FROM users WHERE id=$id")->fetch_assoc()['name'] ?? '';
            $db->query("DELETE FROM bookings WHERE user_id=$id");
            $db->query("DELETE FROM users WHERE id=$id");
            logAdminAction($db, $admin_id, 'Deleted user', 'user', $id, $name);
            $_SESSION['admin_success'] = "User deleted.";
        } elseif ($id === $admin_id) {
            $_SESSION['admin_error'] = "You cannot delete yourself.";
        }
        header("Location: ../users.php"); exit();

    // ===== CONTACTS =====
    case 'mark_contact_read':
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $db->query("UPDATE contacts SET is_read=1 WHERE id=$id");
        }
        header("Location: ../contacts.php"); exit();

    case 'delete_contact':
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $db->query("DELETE FROM contacts WHERE id=$id");
            logAdminAction($db, $admin_id, 'Deleted contact message', 'contact', $id);
            $_SESSION['admin_success'] = "Message deleted.";
        }
        header("Location: ../contacts.php"); exit();

    // ===== REVIEWS =====
    case 'delete_review':
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $db->query("DELETE FROM reviews WHERE id=$id");
            logAdminAction($db, $admin_id, 'Deleted review', 'review', $id);
            $_SESSION['admin_success'] = "Review deleted.";
        }
        header("Location: ../reviews.php"); exit();

    // ===== SUBSCRIPTIONS =====
    case 'delete_subscription':
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $db->query("DELETE FROM subscriptions WHERE id=$id");
            $_SESSION['admin_success'] = "Subscriber removed.";
        }
        header("Location: ../subscriptions.php"); exit();

    case 'export_subscribers_csv':
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="subscribers_' . date('Y-m-d') . '.csv"');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['Email', 'Subscribed Date']);
        $subs = $db->query("SELECT email, created_at FROM subscriptions ORDER BY created_at DESC");
        while ($row = $subs->fetch_assoc()) {
            fputcsv($output, [$row['email'], $row['created_at']]);
        }
        fclose($output);
        exit();

    case 'export_bookings_csv':
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="bookings_' . date('Y-m-d') . '.csv"');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Customer', 'Email', 'Package', 'Travel Date', 'Travelers', 'Total Price', 'Status', 'Booked At']);
        $rows = $db->query("SELECT b.id, u.name, u.email, p.title, b.start_date, b.travelers, (p.price*b.travelers) as total, b.status, b.created_at FROM bookings b JOIN users u ON b.user_id=u.id JOIN packages p ON b.package_id=p.id ORDER BY b.created_at DESC");
        while ($row = $rows->fetch_assoc()) {
            fputcsv($output, array_values($row));
        }
        fclose($output);
        exit();

    // ===== JOURNALS =====
    case 'update_journal_status':
        $id = (int)($_POST['id'] ?? 0);
        $status = $_POST['status'] ?? '';
        if ($id > 0 && in_array($status, ['pending', 'published', 'flagged'])) {
            $db->query("UPDATE journals SET status='$status' WHERE id=$id");
            logAdminAction($db, $admin_id, "Journal status → $status", 'journal', $id);
            $_SESSION['admin_success'] = "Journal status updated.";
        }
        header("Location: $redirect"); exit();

    case 'toggle_journal_featured':
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $db->query("UPDATE journals SET is_featured = NOT is_featured WHERE id=$id");
            $_SESSION['admin_success'] = "Featured status toggled.";
        }
        header("Location: $redirect"); exit();

    case 'delete_journal':
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $db->query("DELETE FROM journals WHERE id=$id");
            logAdminAction($db, $admin_id, 'Deleted journal', 'journal', $id);
            $_SESSION['admin_success'] = "Journal deleted.";
        }
        header("Location: ../journals.php"); exit();

    // ===== LOGS =====
    case 'clear_logs':
        $db->query("DELETE FROM admin_logs");
        logAdminAction($db, $admin_id, 'Cleared all activity logs');
        $_SESSION['admin_success'] = "All logs have been cleared.";
        header("Location: ../logs.php"); exit();

    // ===== SETTINGS =====
    case 'update_settings':
        foreach ($_POST as $key => $value) {
            $stmt = $db->prepare("UPDATE site_settings SET setting_value=? WHERE setting_key=?");
            $stmt->bind_param("ss", $value, $key);
            $stmt->execute();
            $stmt->close();
        }
        logAdminAction($db, $admin_id, 'Updated site settings');
        $_SESSION['admin_success'] = "Site settings updated successfully.";
        header("Location: $redirect"); exit();

    // ===== MEDIA =====
    case 'delete_media':
        $file = $_GET['file'] ?? '';
        $path = '../../assets/images/' . $file;
        if (!empty($file) && file_exists($path)) {
            unlink($path);
            logAdminAction($db, $admin_id, 'Deleted media file', 'media', 0, $file);
            $_SESSION['admin_success'] = "Media asset deleted.";
        }
        header("Location: ../media.php"); exit();

    default:
        $_SESSION['admin_error'] = "Unknown action.";
        header("Location: ../index.php"); exit();
}
?>
