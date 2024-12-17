-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 17, 2024 at 07:55 PM
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
-- Database: `jewelquest`
--

-- --------------------------------------------------------

--
-- Table structure for table `boards`
--

CREATE TABLE `boards` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `boards`
--

INSERT INTO `boards` (`id`, `user_id`, `title`, `image`, `link`, `description`) VALUES
(1, 14, 'Voluptas suscipit ut', '../uploads/images/Screenshot 2022-12-13 at 7.57.55 AM.png', NULL, NULL),
(2, 14, 'Eu sit consequatur ', '../uploads/images/Simulator Screen Shot - iPhone 14 - 2022-12-25 at 03.10.04.png', NULL, NULL),
(3, 14, 'Sint quam commodi of', '../uploads/images/Screen Shot 2022-08-12 at 9.00.49 AM.png', '', 'Voluptatem commodo a'),
(4, 14, 'Molestiae architecto', '../uploads/images/Screen Shot 2022-08-28 at 7.54.35 PM.png', 'Elit ut aliquip dol', 'In rerum rerum tempo'),
(5, 14, 'Inventore placeat q', '../uploads/images/Screen Shot 2022-08-12 at 9.00.49 AM.png', 'Omnis ut voluptas ul', 'Ut consectetur quis '),
(6, 12, 'Fuga Sit rerum sim', '../uploads/images/Screen Shot 2022-09-14 at 3.29.56 PM.png', 'Dolores tempor vitae', 'Nobis omnis magna od'),
(7, 15, 'Aperiam et aute dolo', '../uploads/images/Screen Shot 2022-08-30 at 4.15.41 PM.png', 'Saepe delectus et s', 'Numquam vel cupidata');

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `user_id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pins`
--

CREATE TABLE `pins` (
  `id` int(11) NOT NULL,
  `board_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pins`
--

INSERT INTO `pins` (`id`, `board_id`, `title`, `image`, `user_id`, `description`, `created_at`) VALUES
(2, 1, 'Pinned Image', 'uploads/images/Screenshot 2022-12-13 at 7.57.55 AM.png', 15, 'null', '2024-12-17 18:43:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT '../assets/images/default_profile.webp',
  `bio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `profile_picture`, `bio`) VALUES
(1, 'ruzuluge', 'favo@mailinator.com', '$2y$10$W70przMxTcwYGhdVpYyY7u6741o1S.IktN158ka6mnVQOixGuFhEi', '../assets/images/default_profile.webp', NULL),
(2, 'fefydoge', 'zaxi@mailinator.com', '$2y$10$L47Hxs8hocTsGzZCmm543uZv9A3RmYQ0yw6LkhH4qQHk7L2xUx/L6', '../assets/images/default_profile.webp', NULL),
(3, 'xevujehyg', 'xilixahes@mailinator.com', '$2y$10$Lk112dR4NjwOEdVz0wz0POFmpuN98JG5ylkqs/WJLp22Rqi5jgm3y', '../assets/images/default_profile.webp', NULL),
(4, 'liwohof', 'cuzoxu@mailinator.com', '$2y$10$iMzL8JNERusxiyZB72e0qOXljOYlWIETI84WyKz7ha6IeEHbp/Oz.', '../assets/images/default_profile.webp', NULL),
(5, 'betozebic', 'syxilahe@mailinator.com', '$2y$10$cPY8wncEQyJPsPQnHiTz1.P4lV3s5pBirLcsprbQs7ZXW3TNAkIhO', '../assets/images/default_profile.webp', NULL),
(6, 'vububyhem', 'cajece@mailinator.com', '$2y$10$H/sj.zX51uuHviAmCwS1weYaOH4czWues9xWZqmpBfive6/YNgcG.', '../assets/images/default_profile.webp', NULL),
(7, 'rylob', 'biker@mailinator.com', '$2y$10$AN3pytkRv0UqwJyTRvT06OtC24Zben8D5FdsjdrT7BMDEKH6jvKfC', '../assets/images/default_profile.webp', NULL),
(8, 'jejejyp', 'hipamib@mailinator.com', '$2y$10$kzSuWfmRyRITbfve0uXE2OO18nGyZ6IKmmUdMyd8KyTPGD4Xt5HyG', '../assets/images/default_profile.webp', NULL),
(9, 'hacyzik', 'wyfo@mailinator.com', '$2y$10$8jBQJ9TUPJbbsBxZm4DhcOuA7BI9Ifin/eVo1eNWKkK5R7qO/8PBC', '../assets/images/default_profile.webp', NULL),
(10, 'luhut', 'mebe@mailinator.com', '$2y$10$D8Md7sOhRsf1talWTG7lvusG14gnebrptvvFzjaAqfhCOCn7D6vT2', '../uploads/images/675877eb-4aec-4709-a6c2-7895f248d156.jpeg', NULL),
(11, 'nitazehas', 'suxili@mailinator.com', '$2y$10$muHSGntpZa0HuDRYz00SJ.Nmc54VKExa8npYnTOxCoAnzB8NzgNLS', '../assets/images/default_profile.webp', NULL),
(12, 'kajivi', 'zehyjyn@mailinator.com', '$2y$10$frad/uORjNaIxIVXDduxv.PWrW9YlJ0Fm37b47cf6eo6bj3T5dJRO', '../uploads/images/muñecos.png', NULL),
(13, 'kinamyv', 'xotulyr@mailinator.com', '$2y$10$pJCMwXV1pNhii.bPycvJ2eCzeOGjWywX4NIBhmzjqcPVDLchF6SeC', '../assets/images/default_profile.webp', NULL),
(14, 'qolokexav', 'reqiv@mailinator.com', '$2y$10$OUX7MQxue0OxyuouAH8PM.6/4dArZduE9tnhNhHgzRUdwu9xhe.Ri', '../assets/images/default_profile.webp', NULL),
(15, 'tehywipahu', 'mulyheb@mailinator.com', '$2y$10$/uWjDK.jXj6G53CR712HKe2sD/EwVtcOYcThoid6vpaRIiav821wK', '../assets/images/default_profile.webp', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `boards`
--
ALTER TABLE `boards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`user_id`,`follower_id`),
  ADD KEY `follower_id` (`follower_id`);

--
-- Indexes for table `pins`
--
ALTER TABLE `pins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `board_id` (`board_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `boards`
--
ALTER TABLE `boards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pins`
--
ALTER TABLE `pins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `boards`
--
ALTER TABLE `boards`
  ADD CONSTRAINT `boards_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `followers`
--
ALTER TABLE `followers`
  ADD CONSTRAINT `followers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `followers_ibfk_2` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pins`
--
ALTER TABLE `pins`
  ADD CONSTRAINT `pins_ibfk_1` FOREIGN KEY (`board_id`) REFERENCES `boards` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pins_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
