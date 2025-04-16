-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2025 at 02:52 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `travel_agency`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `travelers` int(11) NOT NULL,
  `special_requests` text DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `package_id`, `start_date`, `travelers`, `special_requests`, `status`, `created_at`) VALUES
(1, 1, 15, '2025-02-17', 2, 'car', 'pending', '2025-02-08 21:20:26'),
(2, 1, 15, '2025-02-10', 2, 'No', 'pending', '2025-02-08 21:23:26'),
(3, 1, 15, '2025-02-10', 2, 'No', 'pending', '2025-02-08 21:24:51'),
(4, 1, 15, '2025-02-10', 2, 'No', 'pending', '2025-02-08 21:25:29'),
(5, 1, 15, '2025-02-10', 2, 'No', 'pending', '2025-02-08 21:26:05'),
(6, 1, 9, '2025-02-10', 2, 'car', 'pending', '2025-02-08 22:48:16'),
(7, 3, 1, '2025-02-12', 2, 'car', 'pending', '2025-02-09 11:49:08'),
(8, 3, 1, '2025-02-11', 3, 'car', 'pending', '2025-02-09 11:54:19'),
(9, 1, 11, '2025-02-18', 2, 'food', 'pending', '2025-02-09 12:28:30');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'Feleke Eshetu Girma', 'eshetufeleke21@gmail.com', 'This website help me very well thanks', '2025-02-09 12:01:42'),
(2, 'Dagim', 'eshetufeleke21@gmail.com', 'Thanks', '2025-02-09 12:27:25');

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

CREATE TABLE `destinations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`id`, `name`, `description`, `image_url`, `created_at`) VALUES
(1, 'Arba Minch', 'Known for its breathtaking landscapes and the famous Nechisar National Park.', '../assets/images/arbaminch.jpg', '2025-01-28 11:16:02'),
(2, 'Hawassa', 'A stunning lakeside city known for its vibrant fish market and natural beauty.', '../assets/images/hawassa.jpg', '2025-01-28 11:16:02'),
(3, 'Gonder', 'Famous for its historical castles and being the Camelot of Africa.', '../assets/images/gonder.jpg', '2025-01-28 11:16:02'),
(4, 'Bahirdar', 'A beautiful city near Lake Tana and the Blue Nile Falls.', '../assets/images/bahirdar.jpg', '2025-01-28 11:16:02'),
(5, 'Mekelle', 'A cultural hub known for its historical significance and rock-hewn churches.', '../assets/images/mekelle.jpg', '2025-01-28 11:16:02'),
(6, 'Aksum', 'An ancient city famous for its obelisks and ties to the Ark of the Covenant.', '../assets/images/aksum.jpg', '2025-01-28 11:16:02'),
(7, 'Harer', 'A walled city known for its rich Islamic heritage and vibrant markets.', '../assets/images/harer.jpg', '2025-01-28 11:16:02'),
(8, 'Lalibela', 'Home to the incredible rock-hewn churches and a UNESCO World Heritage site.', '../assets/images/lalibela.jpg', '2025-01-28 11:16:02'),
(9, 'Jimma', 'Known as the birthplace of coffee and surrounded by lush green landscapes.', '../assets/images/jimma.jpg', '2025-01-28 11:16:02'),
(10, 'Simien Mountains', 'Dramatic mountain landscape with unique wildlife.', '../assets/images/simien.jpg', '2025-02-05 20:01:34'),
(11, 'Danakil Depression', 'One of the hottest places on Earth with alien landscapes.', '../assets/images/danakil.jpg', '2025-02-05 20:01:34'),
(12, 'Omo Valley', 'Cultural hub of diverse ethnic communities.', '../assets/images/omo.jpg', '2025-02-05 20:01:34'),
(13, 'Axum', 'Ancient city with historic obelisks.', '../assets/images/axum.jpg', '2025-02-05 20:01:34'),
(14, 'Addis Ababa', 'The vibrant capital city of Ethiopia, rich in history and culture.', '../assets/images/addis-ababa.jpg', '2025-02-05 20:01:34'),
(15, 'Bale Mountains', 'Home to unique wildlife and stunning highland scenery.', '../assets/images/bale-mountains.jpg', '2025-02-05 20:01:34'),
(16, 'Debre Damo', 'A remote monastery accessible only by climbing a sheer cliff.', '../assets/images/debre-damo.jpg', '2025-02-05 20:01:34'),
(17, 'Tiya', 'A UNESCO World Heritage Site with ancient stelae and archaeological significance.', '../assets/images/tiya.jpg', '2025-02-05 20:01:34'),
(18, 'Lake Tana', 'The largest lake in Ethiopia, dotted with ancient monasteries.', '../assets/images/lake-tana.jpg', '2025-02-05 20:01:34'),
(19, 'Blue Nile Falls', 'Known as \"The Smoking Water,\" one of Ethiopia\'s most spectacular waterfalls.', '../assets/images/blue-nile-falls.jpg', '2025-02-05 20:01:34'),
(20, 'Sof Omar Caves', 'One of the longest cave systems in the world, with stunning rock formations.', '../assets/images/sof-omar.jpg', '2025-02-05 20:01:34'),
(21, 'Debre Libanos', 'A historic monastery with breathtaking views of the surrounding landscape.', '../assets/images/debre-libanos.jpg', '2025-02-05 20:01:34'),
(22, 'Awash National Park', 'A wildlife haven with hot springs, waterfalls, and diverse fauna.', '../assets/images/awash.jpg', '2025-02-05 20:01:34'),
(23, 'Konso', 'A UNESCO World Heritage Site known for its terraced agriculture and unique culture.', '../assets/images/konso.jpg', '2025-02-05 20:01:34'),
(24, 'Gheralta Mountains', 'Famous for its rock-hewn churches and dramatic landscapes.', '../assets/images/gheralta.jpg', '2025-02-05 20:01:34'),
(25, 'Dire Dawa', 'A vibrant city with a mix of modern and traditional Ethiopian culture.', '../assets/images/dire-dawa.jpg', '2025-02-05 20:01:34');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `destination_id` int(11) NOT NULL,
  `duration` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `title`, `destination_id`, `duration`, `price`, `image_url`, `created_at`, `description`) VALUES
(1, 'Arba Minch Adventure', 1, '3 days, 2 nights', 15000.00, '../assets/images/arbaminch.jpg', '2025-01-28 11:28:24', 'Explore Nechisar National Park, Chamo Lake, and breathtaking landscapes in Arba Minch.'),
(2, 'Hawassa Lakeside Retreat', 2, '2 days, 1 night', 10000.00, '../assets/images/hawassa.jpg', '2025-01-28 11:28:24', 'Enjoy the serene beauty of Lake Hawassa, vibrant fish markets, and local culture.'),
(3, 'Gonder Historical Tour', 3, '2 days, 1 night', 20000.00, '../assets/images/gonder.jpg', '2025-01-28 11:28:24', 'Discover the Camelot of Africa, Gonder’s castles, and its historical significance.'),
(4, 'Bahirdar Blue Nile Experience', 4, '3 days, 2 nights', 13000.00, '../assets/images/bahirdar.jpg', '2025-01-28 11:28:24', 'Visit Lake Tana and the iconic Blue Nile Falls in Bahirdar.'),
(5, 'Mekelle Cultural Journey', 5, '3 days, 3 nights', 24000.00, '../assets/images/mekelle.jpg', '2025-01-28 11:28:24', 'Experience the cultural richness and historical landmarks of Mekelle.'),
(6, 'Aksum Heritage Exploration', 6, '4 days, 3 nights', 45000.00, '../assets/images/aksum.jpg', '2025-01-28 11:28:24', 'Discover the ancient obelisks and the legendary Ark of the Covenant in Aksum.'),
(7, 'Harer City Escape', 7, '2 days, 1 night', 18000.00, '../assets/images/harer.jpg', '2025-01-28 11:28:24', 'Explore the walled city of Harer, known for its vibrant markets and Islamic heritage.'),
(8, 'Lalibela Pilgrimage', 8, '4 days, 3 nights', 30000.00, '../assets/images/lalibela.jpg', '2025-01-28 11:28:24', 'Witness the rock-hewn churches of Lalibela, a UNESCO World Heritage site.'),
(9, 'Jimma Coffee Tour', 9, '2 days, 1 night', 18000.00, '../assets/images/jimma.jpg', '2025-01-28 11:28:24', 'Visit the birthplace of coffee and enjoy lush landscapes in Jimma.'),
(10, 'Historical Route Tour', 1, '5 Days', 45000.00, '../assets/images/historical-route.jpg', '2025-02-05 20:11:25', 'Explore the ancient cities and historical landmarks along the historical route.'),
(11, 'Simien Mountains Trek', 2, '4 Days', 32000.00, '../assets/images/simien-trek.jpg', '2025-02-05 20:11:25', 'Trek through the breathtaking Simien Mountains, home to stunning landscapes and wildlife.'),
(12, 'Danakil Adventure', 3, '3 Days', 28000.00, '../assets/images/danakil.jpg', '2025-02-05 20:11:25', 'Experience one of the hottest and most remote places on Earth with a thrilling adventure in the Danakil Depression.'),
(13, 'Omo Valley Cultural Experience', 4, '6 Days', 38000.00, '../assets/images/omo-cultural.jpg', '2025-02-05 20:11:25', 'Immerse yourself in the diverse cultures and traditions of the Omo Valley tribes.'),
(14, 'Rift Valley Explorer', 5, '4 Days', 35000.00, '../assets/images/rift-valley.jpg', '2025-02-05 20:11:25', 'Explore the stunning Rift Valley with its picturesque lakes, wildlife, and natural beauty.'),
(15, 'Ancient Kingdoms Tour', 6, '7 Days', 55000.00, '../assets/images/ancient-kingdoms.jpg', '2025-02-05 20:11:25', 'Discover the ancient kingdoms of Ethiopia, including the rich history and heritage of Aksum and Lalibela.');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `rating` enum('1','2','3','4','5') NOT NULL,
  `review` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `email`, `created_at`) VALUES
(1, 'user1@example.com', '2025-01-28 14:18:48'),
(2, 'user2@example.com', '2025-01-28 14:18:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Feleke Eshetu Girma', 'eshetufeleke21@gmail.com', '1234', 'user', '2025-02-08 18:34:01'),
(3, 'Dagim', 'feleabo02@gmail.com', '123456', 'user', '2025-02-09 11:48:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `package_id` (`package_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `destination_id` (`destination_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `package_id` (`package_id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`);

--
-- Constraints for table `packages`
--
ALTER TABLE `packages`
  ADD CONSTRAINT `packages_ibfk_1` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
