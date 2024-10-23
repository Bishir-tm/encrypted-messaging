-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2024 at 04:20 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `buzzer_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `buzzers`
--

CREATE TABLE `buzzers` (
  `id` int(11) NOT NULL,
  `device_number` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buzzers`
--

INSERT INTO `buzzers` (`id`, `device_number`, `user_id`) VALUES
(10, '0987654321', 4),
(12, '66acd2855d6b9', 3),
(13, '789321', 3),
(14, '12345678901', 4),
(17, '2435231', 5),
(18, '543365', 6),
(19, '223344', 7);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `buzzer_id` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `encrypted_message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `buzzer_id`, `message`, `encrypted_message`) VALUES
(5, 13, 'qewrrerewwqrewq', ''),
(10, 12, 'zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzppppppppppppppppppppppp', ''),
(15, 18, '', ''),
(16, 19, '', ''),
(17, 18, NULL, 'aFd1eXJxcTVDSkt1aHZiNDBWSnY1aktjeXROTDcxQ1lldXJpZGorVW93czdSblgrTGs0OHYvVU5YRG5Ldk1FUDo6raE5tTPdgdhlpqcsgK5DTw==');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `device_number` varchar(50) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `device_number`, `password_hash`) VALUES
(3, 'bishir-tm', NULL, '$2y$10$2jY25gaY0BXSHcKqljsF3uSMEvvlNY2rIx62KNW23G0T6lJWk45Mq'),
(4, 'user', NULL, '$2y$10$5/ToF3UjdhTxxSUtnrhkz.YQNlVvX5ztRyoH9uRL3k6I4ASTS65e2'),
(5, 'meee', NULL, '$2y$10$QqjJ7zfrQ8w1z1EuTmwLUexiBNpe7QliTmtftOu32.fHuFNA/Jv0.'),
(6, 'User01', NULL, '$2y$10$gDmDenpaIiDudD/xQwC1s.uNTiqxZy6xI6LgH7K.b9QM.eVw3Eqom'),
(7, 'user02', NULL, '$2y$10$SM1qvdEn0EyZWP5ZxzS.O.r7/rVEin5mmcK4MaLeq2RRkFUBas3rq'),
(8, 'bishir-tm', NULL, '$2y$10$Ro5D9ZNcZbnFDcQEu.YbyO0yKWSNd1P.VsOeAvbR24G7CYEGCNSj2'),
(9, 'aaa', NULL, '$2y$10$y02evF1aAOxYW6D85J.MfOAsf2FTq0HFjN5AdGYCYWNMVy18GE5Mq');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buzzers`
--
ALTER TABLE `buzzers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `device_number` (`device_number`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buzzer_id` (`buzzer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `device_number` (`device_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buzzers`
--
ALTER TABLE `buzzers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buzzers`
--
ALTER TABLE `buzzers`
  ADD CONSTRAINT `buzzers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`buzzer_id`) REFERENCES `buzzers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
