-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 15 avr. 2024 à 12:57
-- Version du serveur : 8.0.31
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `nourapp-b`
--

-- --------------------------------------------------------

--
-- Structure de la table `daily`
--

DROP TABLE IF EXISTS `daily`;
CREATE TABLE IF NOT EXISTS `daily` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `create_by` int DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `close_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ;


--
-- Structure de la table `expenses`
--

DROP TABLE IF EXISTS `expenses`;
CREATE TABLE IF NOT EXISTS `expenses` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `create_by` int DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `amount` float NOT NULL,
  `description` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `daily_id` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ;


--
-- Structure de la table `expense_daily`
--

DROP TABLE IF EXISTS `expense_daily`;
CREATE TABLE IF NOT EXISTS `expense_daily` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `create_by` int DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `close_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

--
-- Structure de la table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `create_by` text COLLATE utf8mb4_general_ci,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `daily_id` int UNSIGNED DEFAULT NULL,
  `type` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `table_id` int DEFAULT NULL,
  `table_area` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `table_name` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `no_people` int DEFAULT NULL,
  `customer_id` int DEFAULT NULL,
  `customer_name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `customer_address` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `customer_phone` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `paid` tinyint(1) NOT NULL DEFAULT '0',
  `paid_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_orders_daily` (`daily_id`)
) ;



--
-- Structure de la table `sales`
--

DROP TABLE IF EXISTS `sales`;
CREATE TABLE IF NOT EXISTS `sales` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `create_by` int DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `order_id` int UNSIGNED NOT NULL,
  `menu_id` int NOT NULL,
  `equips_in` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `category_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `price` float NOT NULL,
  `capital` float NOT NULL,
  `qnt` float NOT NULL,
  `note` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`),
  KEY `fk_sales_orders` (`order_id`)
) ;


--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `create_by` int DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fullName` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `type` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `username` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` text COLLATE utf8mb4_general_ci,
  `visiblepass` text COLLATE utf8mb4_general_ci,
  `rfidCode` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `create_by`, `create_at`, `update_at`, `fullName`, `type`, `username`, `password`, `visiblepass`, `rfidCode`) VALUES
(1, NULL, '2023-07-05 21:39:05', '2023-07-05 22:11:59', 'admin', 'admin', 'admin', '$2y$10$2U97X2paJJuCvJytYPJ3LuvAJkwjrpaCwKOuzewHmg.v9AcqisIx.', 'admin', ''),
(8, NULL, '2023-07-08 19:00:56', '2023-07-08 19:00:56', 'cachier', 'cashier', 'caissier', '$2y$10$pHGX0a7RNRwNwuHakcglqe4ZgtjDOSdHDBu.niVeljmKssY9YwSsm', 'caissier', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
