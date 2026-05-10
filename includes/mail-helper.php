<?php
/**
 * OGGE Travel — Email Helper
 */
function sendAdminNotification($subject, $message) {
    // In a real production environment, you would use PHPMailer with SMTP.
    // This is a placeholder for the logic.
    $to = "admin@oggetravel.com"; // Should pull from site_settings
    $headers = "From: system@oggetravel.com\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    
    // mail($to, $subject, $message, $headers); // Uncomment on a real server
    
    // For now, we log this to a file as a 'Sent Email' simulation
    $log = "[" . date('Y-m-d H:i:s') . "] TO: $to | SUBJECT: $subject\nBODY: $message\n---\n";
    $logFile = __DIR__ . '/../scratch/email_log.txt';
    $logDir = dirname($logFile);
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    if (is_writable($logDir)) {
        file_put_contents($logFile, $log, FILE_APPEND);
    }
}

function sendCustomerNotification($to, $subject, $message) {
    $headers = "From: OGGE Travel <info@oggetravel.com>\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    // mail($to, $subject, $message, $headers);
    
    $log = "[" . date('Y-m-d H:i:s') . "] TO: $to | SUBJECT: $subject\nBODY: $message\n---\n";
    $logFile = __DIR__ . '/../scratch/email_log.txt';
    $logDir = dirname($logFile);
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    if (is_writable($logDir)) {
        file_put_contents($logFile, $log, FILE_APPEND);
    }
}
?>
