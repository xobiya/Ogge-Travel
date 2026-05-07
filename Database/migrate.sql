-- ============================================================
-- Migration: Add missing tables and columns to existing database
-- Run this on the live database to fix the HTTP 500 admin error
-- ============================================================

-- 1. Add is_read column to contacts (if it doesn't already exist)
ALTER TABLE `contacts`
  ADD COLUMN IF NOT EXISTS `is_read` tinyint(1) NOT NULL DEFAULT 0;

-- 2. Create admin_logs table (if it doesn't already exist)
CREATE TABLE IF NOT EXISTS `admin_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `target_type` varchar(100) DEFAULT NULL,
  `target_id` int(11) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `admin_id` (`admin_id`),
  CONSTRAINT `admin_logs_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Create journals table (if it doesn't already exist)
CREATE TABLE IF NOT EXISTS `journals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `status` enum('pending','published','flagged') NOT NULL DEFAULT 'pending',
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `journals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 4. Harden user authentication storage
ALTER TABLE `users`
  MODIFY `email` varchar(255) NOT NULL,
  MODIFY `password` varchar(255) NOT NULL,
  MODIFY `role` varchar(50) DEFAULT 'user',
  CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Email uniqueness is required for account creation race safety.
-- The baseline schema already declares UNIQUE KEY `email` (`email`).
