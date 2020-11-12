-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Generation Time: Jul 29, 2020 at 04:44 PM
-- Server version: 8.0.21
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";
USE sf4;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sf4`
--

-- --------------------------------------------------------

--
-- Table structure for table `artisan`
--

CREATE TABLE `artisan` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `artisan`
--

INSERT INTO `artisan` (`id`, `name`) VALUES
(1, 'SuperElec'),
(2, 'MegaPool');

-- --------------------------------------------------------

--
-- Table structure for table `user_review`
--

CREATE TABLE `user_review` (
  `id` int NOT NULL,
  `artisan_id` int NOT NULL,
  `author` varchar(255) NOT NULL,
  `grade` int NOT NULL,
  `comment` varchar(255) NOT NULL,
  `review_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_review`
--

INSERT INTO `user_review` (`id`, `artisan_id`, `author`, `grade`, `comment`, `review_date`) VALUES
(1, 1, 'Paul', 4, 'Super electricien', '2020-02-15 00:00:00'),
(2, 2, 'Michel', 2, 'Ouai bof  ', '2020-07-01 00:00:00'),
(3, 2, 'Jacques', 3, 'Correct', '2020-05-12 00:00:00'),
(4, 2, 'François', 3, 'Super travail', '2020-03-10 00:00:00'),
(7, 1, 'Nicolas', 4, 'Bien', '2020-07-08 00:00:00'),
(8, 1, 'bob', 3, 'Pas bien', '2020-03-15 00:00:00'),
(9, 1, 'Paul', 2, 'un 4ieme avis', '2020-07-14 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artisan`
--
ALTER TABLE `artisan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_review`
--
ALTER TABLE `user_review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artisan_id` (`artisan_id`),
  ADD KEY `artisan_id_2` (`artisan_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artisan`
--
ALTER TABLE `artisan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_review`
--
ALTER TABLE `user_review`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_review`
--
ALTER TABLE `user_review`
  ADD CONSTRAINT `user_review_ibfk_1` FOREIGN KEY (`artisan_id`) REFERENCES `artisan` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;