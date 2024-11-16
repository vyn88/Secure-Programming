-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 16, 2024 at 07:45 AM
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
-- Database: `ojekku`
--

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `available` tinyint(1) DEFAULT 1,
  `location` point DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `name`, `email`, `phone`, `available`, `location`, `password`) VALUES
(1, 'driver', 'driver@gmail.com', NULL, 1, NULL, '$2y$10$TJFbNfvAyWxY65yUAfNuaOVQ6tTnKuBT7sSTEzlvl3eXzMa0L1b.O');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `origin` varchar(100) DEFAULT NULL,
  `destination` varchar(100) DEFAULT NULL,
  `status` enum('pending','accepted','in_progress','completed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `perjalanan`
--

CREATE TABLE `perjalanan` (
  `id` int(11) NOT NULL,
  `asal` varchar(255) DEFAULT NULL,
  `tujuan` varchar(255) DEFAULT NULL,
  `jarak` float DEFAULT NULL,
  `biaya` float DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `waktu_tempuh` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `perjalanan`
--

INSERT INTO `perjalanan` (`id`, `asal`, `tujuan`, `jarak`, `biaya`, `tanggal`, `waktu_tempuh`) VALUES
(1, 'Binus anggrek, Jalan Raya Kebon Jeruk, Kebon Jeruk, West Jakarta City, Jakarta, Indonesia', 'Grand Indonesia, Jalan MH Thamrin, Menteng, Central Jakarta City, Jakarta, Indonesia', 8.586, 42930, '2024-10-30 15:11:34', NULL),
(2, 'Binus anggrek, Jalan Raya Kebon Jeruk, Kebon Jeruk, West Jakarta City, Jakarta, Indonesia', 'Grand Indonesia, Jalan MH Thamrin, Menteng, Central Jakarta City, Jakarta, Indonesia', 8.586, 42930, '2024-10-30 15:11:36', NULL),
(3, 'Binus anggrek, Jalan Raya Kebon Jeruk, Kebon Jeruk, West Jakarta City, Jakarta, Indonesia', 'Grand Indonesia, Jalan MH Thamrin, Menteng, Central Jakarta City, Jakarta, Indonesia', 8.586, 42930, '2024-10-30 15:11:38', NULL),
(4, 'Binus anggrek, Jalan Raya Kebon Jeruk, Kebon Jeruk, West Jakarta City, Jakarta, Indonesia', 'Grand Indonesia, Jalan MH Thamrin, Menteng, Central Jakarta City, Jakarta, Indonesia', 8.586, 42930, '2024-10-30 15:11:49', NULL),
(5, 'Binus anggrek, Jalan Raya Kebon Jeruk, Kebon Jeruk, West Jakarta City, Jakarta, Indonesia', 'Grand Indonesia, Jalan MH Thamrin, Menteng, Central Jakarta City, Jakarta, Indonesia', 8.586, 42930, '2024-10-30 15:11:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'www', 'der@example.com', '$2y$10$u96H1vwhbLWQtD1xkWnCOulgUwRbhb9b3Oq9M8kEYgw4T8nliznJS'),
(2, 'darr', 'darr@example.com', '$2y$10$apB5h62LwH1Z9sohDVtjxel5qoSTjj6CwEIL8GMaCHnKyoDC/AIwu'),
(14, 'halo', 'halo@gmail.com', '$2y$10$V9POzk0lcf3NBB5R7l1.zerY3oL5kKbKEcOqME4OvhiILqNcYMC3S'),
(15, 'woi', 'woi@gmail.com', '$2y$10$Rj/Itfshuw38Wzcc3COVUOzBG8zGAMCSH2BIWQb3ybR9YPA67mAn.'),
(16, 'woi1', 'woi1@gmail.com', '$2y$10$QLYIeBq48jucj1PtMrcrXe35vmqMmJGBDQsoLyZz9HU7tDM1FmKNq'),
(17, 'test', 'test@gmail.com', '$2y$10$GRk373WzxIgsBvhEuJOHxOcNNgKx/ajqTL5k24AoEEL2uWDyAvdBa'),
(18, 'testya', 'testya@email.com', '$2y$10$ahRFIpevzUK6K7exQ.J20evXoStavMqR5IE1q0KYh/rh78f1Idztq'),
(20, 'testya1', 'testya1@email.com', '$2y$10$nrCc.rnowC92nDXKgcF1seWLkEW6FR1TAdyMqtkjZKF6wrBuJr5gC');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `driver_id` (`driver_id`);

--
-- Indexes for table `perjalanan`
--
ALTER TABLE `perjalanan`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `perjalanan`
--
ALTER TABLE `perjalanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
