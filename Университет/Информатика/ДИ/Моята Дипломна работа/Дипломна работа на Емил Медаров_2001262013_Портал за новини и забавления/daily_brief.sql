-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Време на генериране:  6 авг 2024 в 14:13
-- Версия на сървъра: 8.2.0
-- Версия на PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данни: `daily_brief`
--

-- --------------------------------------------------------

--
-- Структура на таблица `bulgaria`
--

DROP TABLE IF EXISTS `bulgaria`;
CREATE TABLE IF NOT EXISTS `bulgaria` (
  `bulgaria_id` int NOT NULL AUTO_INCREMENT,
  `bulgaria_post_photo` mediumblob,
  `bulgaria_post_title` varchar(255) NOT NULL,
  `bulgaria_post_description` text,
  `location_name` enum('София','Пловдив','Варна','Бургас','Стара Загора','Плевен','Русе','Велико Търново','Хасково','Кърджали') NOT NULL,
  `date_published` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `category_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`bulgaria_id`),
  KEY `bulgaria_ibfk_1` (`user_id`),
  KEY `bulgaria_ibfk_2` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Структура на таблица `business`
--

DROP TABLE IF EXISTS `business`;
CREATE TABLE IF NOT EXISTS `business` (
  `business_id` int NOT NULL AUTO_INCREMENT,
  `business_post_photo` mediumblob,
  `business_post_title` varchar(255) NOT NULL,
  `business_post_description` text,
  `business_type` enum('Технологии','Автомобили') NOT NULL,
  `date_published` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `category_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`business_id`),
  KEY `business_ibfk_1` (`user_id`),
  KEY `business_ibfk_2` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Структура на таблица `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Схема на данните от таблица `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'България'),
(2, 'Бизнес'),
(3, 'Забавления'),
(4, 'Спорт');

-- --------------------------------------------------------

--
-- Структура на таблица `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int NOT NULL AUTO_INCREMENT,
  `comment_author_name` varchar(100) NOT NULL,
  `comment_author_email` varchar(100) NOT NULL,
  `comment_date_gmt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `comment_content` text NOT NULL,
  `user_id` int DEFAULT NULL,
  `bulgaria_id` int DEFAULT NULL,
  `business_id` int DEFAULT NULL,
  `entertainment_id` int DEFAULT NULL,
  `sport_id` int DEFAULT NULL,
  PRIMARY KEY (`comment_id`),
  UNIQUE KEY `unique_comment_source` (`bulgaria_id`,`business_id`,`entertainment_id`,`sport_id`),
  KEY `user_id` (`user_id`),
  KEY `comments_ibfk_2` (`business_id`),
  KEY `comments_ibfk_3` (`entertainment_id`),
  KEY `comments_ibfk_4` (`sport_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Структура на таблица `entertainments`
--

DROP TABLE IF EXISTS `entertainments`;
CREATE TABLE IF NOT EXISTS `entertainments` (
  `entertainment_id` int NOT NULL AUTO_INCREMENT,
  `entertainment_post_photo` mediumblob,
  `entertainment_post_title` varchar(255) NOT NULL,
  `entertainment_post_description` text,
  `entertainment_type` enum('Вицове','Хороскопи','Филми','Пътувания','Култура','Любопитно') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `date_published` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `category_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`entertainment_id`),
  KEY `entertainments_ibfk_1` (`user_id`),
  KEY `entertainments_ibfk_2` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Структура на таблица `sport`
--

DROP TABLE IF EXISTS `sport`;
CREATE TABLE IF NOT EXISTS `sport` (
  `sport_id` int NOT NULL AUTO_INCREMENT,
  `sport_post_photo` mediumblob,
  `sport_post_title` varchar(255) NOT NULL,
  `sport_post_description` text,
  `sport_type` enum('БГ Футбол','Баскетбол','Волейбол','Тенис') NOT NULL,
  `date_published` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `category_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`sport_id`),
  KEY `sport_ibfk_1` (`user_id`),
  KEY `sport_ibfk_2` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Структура на таблица `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `userType` enum('client','admin') NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_first_name` varchar(50) DEFAULT NULL,
  `user_last_name` varchar(50) DEFAULT NULL,
  `user_registered_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Ограничения за дъмпнати таблици
--

--
-- Ограничения за таблица `bulgaria`
--
ALTER TABLE `bulgaria`
  ADD CONSTRAINT `bulgaria_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `bulgaria_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения за таблица `business`
--
ALTER TABLE `business`
  ADD CONSTRAINT `business_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `business_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения за таблица `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`bulgaria_id`) REFERENCES `bulgaria` (`bulgaria_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`business_id`) REFERENCES `business` (`business_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`entertainment_id`) REFERENCES `entertainments` (`entertainment_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_4` FOREIGN KEY (`sport_id`) REFERENCES `sport` (`sport_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения за таблица `entertainments`
--
ALTER TABLE `entertainments`
  ADD CONSTRAINT `entertainments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `entertainments_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения за таблица `sport`
--
ALTER TABLE `sport`
  ADD CONSTRAINT `sport_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `sport_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
