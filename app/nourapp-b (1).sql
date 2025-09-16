-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 04 sep. 2023 à 10:02
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
-- Structure de la table `areas`
--

DROP TABLE IF EXISTS `areas`;
CREATE TABLE IF NOT EXISTS `areas` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `create_by` int DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `areas`
--

INSERT INTO `areas` (`id`, `create_by`, `create_at`, `update_at`, `name`) VALUES
(1, NULL, '2023-07-08 10:00:09', '2023-07-08 10:00:09', 'terasse');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `create_by` int DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `image` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `create_by`, `create_at`, `update_at`, `name`, `image`) VALUES
(1, NULL, '2023-07-05 23:21:10', '2023-07-05 23:21:10', 'category1', NULL),
(2, NULL, '2023-07-05 23:21:16', '2023-07-05 23:21:16', 'category2', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `create_by` int DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `daily`
--

INSERT INTO `daily` (`id`, `create_by`, `create_at`, `update_at`, `close_at`) VALUES
(1, NULL, '2023-07-06 12:28:19', '2023-07-07 14:40:28', '2023-07-07 14:40:28'),
(2, NULL, '2023-07-07 14:40:28', '2023-07-07 14:40:28', NULL);

-- --------------------------------------------------------

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
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `expenses`
--

INSERT INTO `expenses` (`id`, `create_by`, `create_at`, `update_at`, `title`, `amount`, `description`, `daily_id`) VALUES
(16, NULL, '2023-08-09 11:15:25', '2023-08-09 11:15:25', 'zefe', 23, '', 9),
(2, NULL, '2023-07-25 14:41:57', '2023-07-25 14:41:57', 'miel', 80, 'description ', 1),
(3, NULL, '2023-07-25 15:59:35', '2023-07-25 15:59:35', 'title', 90, 'desc', 2),
(4, NULL, '2023-07-25 17:40:29', '2023-07-25 17:40:29', 'dffr', 123, 'vrezcs', 2),
(5, NULL, '2023-07-25 17:42:24', '2023-07-25 17:42:24', 'ux portfolio', 12, 'dee', 2),
(6, NULL, '2023-07-25 17:42:55', '2023-07-25 17:42:55', 'test', 100, 'zzz', 2),
(7, NULL, '2023-07-25 18:03:18', '2023-07-25 18:03:18', 'ezfz', 12, 'gf', 2),
(8, NULL, '2023-07-25 18:04:51', '2023-07-25 18:04:51', 'qxs', 123, 'gvd', 2),
(9, NULL, '2023-07-25 18:05:26', '2023-07-25 18:05:26', 'erer', 100, '', 2),
(15, NULL, '2023-08-09 11:05:45', '2023-08-09 11:05:45', 'ttbttb', 22, '', 9),
(12, NULL, '2023-07-25 19:18:43', '2023-07-25 19:18:43', 'EZZZ', 100, '', 7),
(17, NULL, '2023-08-09 11:15:43', '2023-08-09 11:15:43', 'jhu', 22, '', 9),
(14, NULL, '2023-07-25 19:55:10', '2023-07-25 19:55:10', 'na3na3', 20, '', 8),
(18, NULL, '2023-08-09 11:18:19', '2023-08-09 11:18:19', 'hdgdg', 10, '', 9),
(19, NULL, '2023-08-09 11:19:26', '2023-08-09 11:19:26', 'edd', 10, '', 9),
(20, NULL, '2023-08-09 11:20:57', '2023-08-09 11:20:57', 'dkkd', 10, '', 9),
(21, NULL, '2023-08-09 11:24:09', '2023-08-09 11:24:09', 'djhh', 10, '', 9),
(22, NULL, '2023-08-09 11:29:53', '2023-08-09 11:29:53', 'EE', 12, '', 10),
(23, NULL, '2023-08-09 11:30:04', '2023-08-09 11:30:04', 'djdj', 354, '', 10),
(24, NULL, '2023-08-09 11:30:35', '2023-08-09 11:30:35', 'eheyt', 22, '', 10),
(25, NULL, '2023-08-09 11:30:48', '2023-08-09 11:30:48', 'ddhh', 12, '', 10);

-- --------------------------------------------------------

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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `expense_daily`
--

INSERT INTO `expense_daily` (`id`, `create_by`, `create_at`, `update_at`, `close_at`) VALUES
(1, NULL, '2023-07-25 14:40:28', '2023-07-25 15:55:47', '2023-07-25 15:55:36'),
(2, NULL, '2023-07-25 15:56:03', '2023-07-25 19:11:53', '2023-07-25 19:11:53'),
(6, NULL, '2023-07-25 19:14:00', '2023-07-25 19:14:54', '2023-07-25 19:14:54'),
(5, NULL, '2023-07-25 19:11:53', '2023-07-25 19:14:00', '2023-07-25 19:14:00'),
(7, NULL, '2023-07-25 19:14:54', '2023-07-25 19:18:49', '2023-07-25 19:18:49'),
(8, NULL, '2023-07-25 19:18:49', '2023-07-25 19:55:49', '2023-07-25 19:55:49'),
(9, NULL, '2023-08-09 11:05:45', '2023-08-09 11:24:18', '2023-08-09 11:24:18'),
(10, NULL, '2023-08-09 11:29:53', '2023-08-09 11:48:38', '2023-08-09 11:48:38');

-- --------------------------------------------------------

--
-- Structure de la table `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `create_by` int DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `category_id` int UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `capital` float NOT NULL,
  `price` float NOT NULL,
  `quantity` float DEFAULT NULL,
  `equips_in` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `image` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`),
  KEY `fk_menu_categories` (`category_id`)
) ;

--
-- Déchargement des données de la table `menu`
--

INSERT INTO `menu` (`id`, `create_by`, `create_at`, `update_at`, `category_id`, `name`, `capital`, `price`, `quantity`, `equips_in`, `image`) VALUES
(1, NULL, '2023-07-05 23:21:31', '2023-07-05 23:21:31', 2, 'product1', 0, 20, NULL, 'kitchen', NULL),
(2, NULL, '2023-07-05 23:21:53', '2023-07-05 23:21:53', 1, 'productA', 0, 16, NULL, 'kitchen', NULL);

-- --------------------------------------------------------

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
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `create_by`, `create_at`, `update_at`, `daily_id`, `type`, `table_id`, `table_area`, `table_name`, `no_people`, `customer_id`, `customer_name`, `customer_address`, `customer_phone`, `paid`, `paid_at`) VALUES
(1, NULL, '2023-07-06 12:26:29', '2023-07-06 12:43:02', 1, 'import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-06 12:43:02'),
(2, NULL, '2023-07-06 12:45:54', '2023-07-06 12:46:00', 1, 'import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-06 12:46:00'),
(3, NULL, '2023-07-06 12:48:47', '2023-07-06 12:48:52', 1, 'import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-06 12:48:52'),
(4, NULL, '2023-07-06 12:49:47', '2023-07-06 12:49:52', 1, 'import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-06 12:49:52'),
(5, NULL, '2023-07-06 14:14:47', '2023-07-06 14:15:13', 1, 'import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-06 14:15:13'),
(6, NULL, '2023-07-06 14:15:54', '2023-07-06 14:16:48', 1, 'import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-06 14:16:48'),
(7, NULL, '2023-07-06 14:20:33', '2023-07-08 01:15:17', 2, 'import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-08 01:15:17'),
(8, NULL, '2023-07-06 14:22:40', '2023-07-06 14:22:40', 1, 'import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-06 14:22:40'),
(9, NULL, '2023-07-06 14:23:31', '2023-07-06 14:23:31', 1, 'import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-06 14:23:31'),
(10, NULL, '2023-07-06 14:26:03', '2023-07-08 01:15:13', 2, 'import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-08 01:15:13'),
(11, NULL, '2023-07-06 14:26:19', '2023-07-06 14:26:19', 1, 'import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-06 14:26:19'),
(12, NULL, '2023-07-07 09:40:40', '2023-07-08 01:15:07', 2, 'import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-08 01:15:07'),
(13, NULL, '2023-07-07 14:12:19', '2023-07-08 01:15:03', 2, 'import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-08 01:15:03'),
(14, '1', '2023-07-07 14:13:33', '2023-07-08 01:15:00', 2, 'import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-08 01:15:00'),
(15, NULL, '2023-07-07 14:14:41', '2023-07-08 01:14:58', 2, 'import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-08 01:14:58'),
(16, '1', '2023-07-07 14:25:08', '2023-07-08 01:14:55', 2, 'import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-08 01:14:55'),
(17, '1', '2023-07-08 01:14:44', '2023-07-08 01:14:44', 2, 'import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-08 01:14:44'),
(18, NULL, '2023-07-08 01:18:28', '2023-07-08 01:18:34', 2, 'import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-08 01:18:34'),
(19, NULL, '2023-07-08 01:20:51', '2023-07-08 01:20:51', 2, 'import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-08 01:20:51'),
(20, NULL, '2023-07-08 01:23:51', '2023-07-08 01:23:51', 2, 'import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-08 01:23:51'),
(21, 'admin', '2023-07-08 01:27:45', '2023-07-08 01:27:45', 2, 'import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-08 01:27:45'),
(22, 'admin', '2023-07-08 09:03:49', '2023-07-08 09:07:15', 2, 'import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-08 09:07:15'),
(23, 'admin', '2023-07-08 09:09:50', '2023-07-08 09:09:50', NULL, 'import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(24, 'admin', '2023-07-08 09:27:48', '2023-07-08 09:27:48', NULL, 'import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(25, 'admin', '2023-07-08 10:00:42', '2023-07-08 10:19:00', 2, 'table', 1, 'terasse', 'table 1', 4, NULL, NULL, NULL, NULL, 1, '2023-07-08 10:19:00'),
(26, 'admin', '2023-07-08 10:33:37', '2023-07-08 10:33:37', NULL, 'table', 2, 'terasse', 'table 2', 2, NULL, NULL, NULL, NULL, 0, NULL),
(27, 'admin', '2023-07-08 10:51:31', '2023-07-08 10:51:31', NULL, 'table', 1, 'terasse', 'table 1', 2, NULL, NULL, NULL, NULL, 0, NULL),
(28, 'admin', '2023-07-08 10:57:57', '2023-07-08 10:57:57', 2, 'table', 2, 'terasse', 'table 2', 5, NULL, NULL, NULL, NULL, 1, '2023-07-08 10:57:57'),
(29, 'admin', '2023-07-08 10:59:08', '2023-07-08 10:59:08', 2, 'table', 2, 'terasse', 'table 2', 5, NULL, NULL, NULL, NULL, 1, '2023-07-08 10:59:08'),
(30, 'admin', '2023-07-08 16:53:40', '2023-07-08 16:53:40', NULL, 'table', 2, 'terasse', 'table 2', 8, NULL, NULL, NULL, NULL, 0, NULL),
(31, 'omar', '2023-07-08 19:45:31', '2023-07-08 19:46:36', 2, 'table', 1, 'terasse', 'table 1', 1, NULL, NULL, NULL, NULL, 1, '2023-07-08 19:46:36'),
(32, 'khalid', '2023-07-08 19:48:37', '2023-07-09 13:17:50', 2, 'table', 2, 'terasse', 'table 2', 2, NULL, NULL, NULL, NULL, 1, '2023-07-09 13:17:50'),
(33, 'admin', '2023-07-15 14:38:35', '2023-07-15 14:38:35', NULL, 'table', 1, 'terasse', 'table 1', 4, NULL, NULL, NULL, NULL, 0, NULL),
(34, 'admin', '2023-07-15 14:49:42', '2023-07-15 14:49:42', NULL, 'table', 1, 'terasse', 'table 1', 2, NULL, NULL, NULL, NULL, 0, NULL),
(35, 'admin', '2023-07-15 14:56:21', '2023-07-15 14:56:21', NULL, 'table', 1, 'terasse', 'table 1', 4, NULL, NULL, NULL, NULL, 0, NULL),
(36, 'admin', '2023-07-15 14:58:28', '2023-07-15 14:58:28', NULL, 'table', 1, 'terasse', 'table 1', 2, NULL, NULL, NULL, NULL, 0, NULL),
(37, 'admin', '2023-07-15 15:05:56', '2023-07-15 15:06:07', 2, 'table', 1, 'terasse', 'table 1', 2, NULL, NULL, NULL, NULL, 1, '2023-07-15 15:06:07'),
(38, 'admin', '2023-07-15 16:07:28', '2023-07-15 16:07:28', NULL, 'table', 1, 'terasse', 'table 1', 4, NULL, NULL, NULL, NULL, 0, NULL),
(39, 'admin', '2023-07-15 16:53:24', '2023-07-15 16:53:51', 2, 'import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-15 16:53:51'),
(40, 'admin', '2023-07-15 17:49:27', '2023-07-15 17:49:27', NULL, 'table', 1, 'terasse', 'table 1', 2, NULL, NULL, NULL, NULL, 0, NULL),
(41, 'admin', '2023-07-17 08:38:20', '2023-07-17 08:38:34', 2, 'import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-17 08:38:34'),
(42, 'admin', '2023-07-17 08:39:58', '2023-07-17 08:40:08', 2, 'import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-07-17 08:40:08'),
(43, 'admin', '2023-07-17 08:49:25', '2023-07-17 08:49:25', NULL, 'import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(44, 'admin', '2023-07-17 18:47:34', '2023-07-17 18:47:34', NULL, 'table', 1, 'terasse', 'table 1', 5, NULL, NULL, NULL, NULL, 0, NULL),
(45, 'admin', '2023-08-01 17:50:29', '2023-08-01 17:50:29', NULL, 'table', 1, 'terasse', 'table 1', 2, NULL, NULL, NULL, NULL, 0, NULL),
(46, 'admin', '2023-08-01 17:50:39', '2023-08-01 17:50:48', 2, 'import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2023-08-01 17:50:48');

-- --------------------------------------------------------

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
-- Déchargement des données de la table `sales`
--

INSERT INTO `sales` (`id`, `create_by`, `create_at`, `update_at`, `order_id`, `menu_id`, `equips_in`, `category_name`, `title`, `price`, `capital`, `qnt`, `note`) VALUES
(1, NULL, '2023-07-06 12:26:29', '2023-07-06 12:26:29', 1, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 2, NULL),
(2, NULL, '2023-07-06 12:26:29', '2023-07-06 12:26:29', 1, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(3, NULL, '2023-07-06 12:45:54', '2023-07-06 12:45:54', 2, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 1, NULL),
(4, NULL, '2023-07-06 12:48:47', '2023-07-06 12:48:47', 3, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(5, NULL, '2023-07-06 12:49:47', '2023-07-06 12:49:47', 4, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 1, NULL),
(6, NULL, '2023-07-06 14:14:47', '2023-07-06 14:14:47', 5, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(7, NULL, '2023-07-06 14:15:54', '2023-07-06 14:15:54', 6, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 1, NULL),
(8, NULL, '2023-07-06 14:15:54', '2023-07-06 14:15:54', 6, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(9, NULL, '2023-07-06 14:20:33', '2023-07-06 14:20:33', 7, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 1, NULL),
(10, NULL, '2023-07-06 14:20:33', '2023-07-06 14:20:33', 7, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(11, NULL, '2023-07-06 14:22:40', '2023-07-06 14:22:40', 8, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 1, NULL),
(12, NULL, '2023-07-06 14:22:40', '2023-07-06 14:22:40', 8, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(13, NULL, '2023-07-06 14:23:31', '2023-07-06 14:23:31', 9, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 1, NULL),
(14, NULL, '2023-07-06 14:23:31', '2023-07-06 14:23:31', 9, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(15, NULL, '2023-07-06 14:26:03', '2023-07-06 14:26:03', 10, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 1, NULL),
(16, NULL, '2023-07-06 14:26:03', '2023-07-06 14:26:03', 10, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(17, NULL, '2023-07-06 14:26:19', '2023-07-06 14:26:19', 11, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 1, NULL),
(18, NULL, '2023-07-06 14:26:19', '2023-07-06 14:26:19', 11, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(19, NULL, '2023-07-07 09:40:40', '2023-07-07 09:40:40', 12, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 1, NULL),
(20, NULL, '2023-07-07 14:12:19', '2023-07-07 14:12:19', 13, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 1, NULL),
(21, NULL, '2023-07-07 14:12:19', '2023-07-07 14:12:19', 13, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(22, NULL, '2023-07-07 14:13:33', '2023-07-07 14:13:33', 14, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 1, NULL),
(23, NULL, '2023-07-07 14:13:33', '2023-07-07 14:13:33', 14, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(24, NULL, '2023-07-07 14:14:41', '2023-07-07 14:14:41', 15, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 1, NULL),
(25, NULL, '2023-07-07 14:14:41', '2023-07-07 14:14:41', 15, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(26, NULL, '2023-07-07 14:25:08', '2023-07-07 14:25:08', 16, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 1, NULL),
(27, NULL, '2023-07-07 14:25:08', '2023-07-07 14:25:08', 16, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(28, NULL, '2023-07-08 01:14:44', '2023-07-08 01:14:44', 17, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 1, NULL),
(29, NULL, '2023-07-08 01:14:44', '2023-07-08 01:14:44', 17, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(30, NULL, '2023-07-08 01:18:28', '2023-07-08 01:18:28', 18, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 1, NULL),
(31, NULL, '2023-07-08 01:18:28', '2023-07-08 01:18:28', 18, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(32, NULL, '2023-07-08 01:20:51', '2023-07-08 01:20:51', 19, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 1, NULL),
(33, NULL, '2023-07-08 01:20:51', '2023-07-08 01:20:51', 19, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(34, NULL, '2023-07-08 01:23:51', '2023-07-08 01:23:51', 20, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 1, NULL),
(35, NULL, '2023-07-08 01:23:51', '2023-07-08 01:23:51', 20, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(36, NULL, '2023-07-08 01:27:45', '2023-07-08 01:27:45', 21, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 1, NULL),
(37, NULL, '2023-07-08 01:27:45', '2023-07-08 01:27:45', 21, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(38, NULL, '2023-07-08 09:03:49', '2023-07-08 09:03:49', 22, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 1, NULL),
(39, NULL, '2023-07-08 09:03:49', '2023-07-08 09:03:49', 22, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(40, NULL, '2023-07-08 09:09:50', '2023-07-08 09:09:50', 23, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 1, NULL),
(41, NULL, '2023-07-08 09:27:48', '2023-07-08 09:27:48', 24, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 2, NULL),
(42, NULL, '2023-07-08 09:27:48', '2023-07-08 09:27:48', 24, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(43, NULL, '2023-07-08 10:00:42', '2023-07-08 10:00:42', 25, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 1, NULL),
(44, NULL, '2023-07-08 10:00:42', '2023-07-08 10:00:42', 25, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(45, NULL, '2023-07-08 10:33:37', '2023-07-08 10:33:37', 26, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 1, NULL),
(46, NULL, '2023-07-08 10:33:37', '2023-07-08 10:33:37', 26, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(47, NULL, '2023-07-08 10:51:31', '2023-07-08 10:51:31', 27, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(48, NULL, '2023-07-08 10:51:31', '2023-07-08 10:51:31', 27, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 2, NULL),
(49, NULL, '2023-07-08 10:57:57', '2023-07-08 10:57:57', 28, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 1, NULL),
(50, NULL, '2023-07-08 10:57:57', '2023-07-08 10:57:57', 28, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(51, NULL, '2023-07-08 10:59:08', '2023-07-08 10:59:08', 29, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 1, NULL),
(52, NULL, '2023-07-08 10:59:08', '2023-07-08 10:59:08', 29, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(53, NULL, '2023-07-08 16:53:40', '2023-07-08 16:53:40', 30, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 1, NULL),
(54, NULL, '2023-07-08 16:53:40', '2023-07-08 16:53:40', 30, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(55, NULL, '2023-07-08 19:45:31', '2023-07-08 19:45:31', 31, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 2, NULL),
(56, NULL, '2023-07-08 19:45:31', '2023-07-08 19:45:31', 31, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(57, NULL, '2023-07-08 19:48:37', '2023-07-08 19:48:37', 32, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(58, NULL, '2023-07-15 14:38:35', '2023-07-15 14:38:35', 33, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 1, NULL),
(59, NULL, '2023-07-15 14:49:42', '2023-07-15 14:49:42', 34, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 2, NULL),
(60, NULL, '2023-07-15 14:56:21', '2023-07-15 14:56:21', 35, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(61, NULL, '2023-07-15 14:58:28', '2023-07-15 14:58:28', 36, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(62, NULL, '2023-07-15 15:05:56', '2023-07-15 15:05:56', 37, 2, 'kitchen', 'category1', 'category1 productA', 300, 0, 1, NULL),
(63, NULL, '2023-07-15 16:07:28', '2023-07-15 16:07:28', 38, 2, 'kitchen', 'category1', 'category1 productA', 20.5, 0, 1, NULL),
(64, NULL, '2023-07-15 16:53:24', '2023-07-15 16:53:24', 39, 2, 'kitchen', 'category1', 'category1 productA', 100, 0, 1, NULL),
(65, NULL, '2023-07-15 16:53:24', '2023-07-15 16:53:24', 39, 1, 'kitchen', 'category2', 'category2 product1', 30, 0, 1, NULL),
(66, NULL, '2023-07-15 17:49:27', '2023-07-15 17:49:27', 40, 2, 'kitchen', 'category1', 'category1 productA', 256, 0, 1, NULL),
(67, NULL, '2023-07-17 08:38:20', '2023-07-17 08:38:20', 41, 2, 'kitchen', 'category1', 'category1 productA', 160, 0, 1, NULL),
(68, NULL, '2023-07-17 08:39:58', '2023-07-17 08:39:58', 42, 2, 'kitchen', 'category1', 'category1 productA', 300, 0, 1, NULL),
(69, NULL, '2023-07-17 08:39:58', '2023-07-17 08:39:58', 42, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(70, NULL, '2023-07-17 08:49:25', '2023-07-17 08:49:25', 43, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 1, NULL),
(71, NULL, '2023-07-17 08:49:25', '2023-07-17 08:49:25', 43, 1, 'kitchen', 'category2', 'category2 product1', 160, 0, 1, NULL),
(74, NULL, '2023-07-17 18:47:15', '2023-07-17 18:47:15', 43, 1, 'kitchen', 'category2', 'category2 product1', 0, 0, 1, NULL),
(75, NULL, '2023-07-17 18:47:15', '2023-07-17 18:47:15', 43, 2, 'kitchen', 'category1', 'category1 productA', 0, 0, 1, NULL),
(76, NULL, '2023-07-17 18:47:34', '2023-07-17 18:47:34', 44, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(77, NULL, '2023-07-17 18:59:55', '2023-07-17 18:59:55', 44, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 1, NULL),
(78, NULL, '2023-07-17 19:00:07', '2023-07-17 19:00:07', 44, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 1, NULL),
(79, NULL, '2023-07-17 19:16:36', '2023-07-17 19:16:36', 44, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 1, NULL),
(80, NULL, '2023-08-01 17:50:29', '2023-08-01 17:50:29', 45, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 1, NULL),
(81, NULL, '2023-08-01 17:50:29', '2023-08-01 17:50:29', 45, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL),
(82, NULL, '2023-08-01 17:50:39', '2023-08-01 17:50:39', 46, 2, 'kitchen', 'category1', 'category1 productA', 16, 0, 1, NULL),
(83, NULL, '2023-08-01 17:50:39', '2023-08-01 17:50:39', 46, 1, 'kitchen', 'category2', 'category2 product1', 20, 0, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tables`
--

DROP TABLE IF EXISTS `tables`;
CREATE TABLE IF NOT EXISTS `tables` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `create_by` int DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `area_id` int UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tables_areas` (`area_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tables`
--

INSERT INTO `tables` (`id`, `create_by`, `create_at`, `update_at`, `area_id`, `name`) VALUES
(1, NULL, '2023-07-08 10:00:18', '2023-07-08 10:00:18', 1, 'table 1'),
(2, NULL, '2023-07-08 10:00:24', '2023-07-08 10:00:24', 1, 'table 2');

-- --------------------------------------------------------

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
(1, NULL, '2023-07-05 21:39:05', '2023-07-05 22:11:59', 'mustapha', 'admin', 'admin', '$2y$10$2U97X2paJJuCvJytYPJ3LuvAJkwjrpaCwKOuzewHmg.v9AcqisIx.', 'admin', 'çéè_-(è'),
(10, NULL, '2023-07-08 19:38:27', '2023-07-08 19:38:27', 'said', 'cashier', 'said', '$2y$10$GqMt.rW66ryjHOgDnEJ2iehJpgtCaqtcde2Yock/8gdv7oYjBeFNG', 'said', ''),
(8, NULL, '2023-07-08 19:00:56', '2023-07-08 19:00:56', 'achraf', 'cashier', 'caissier', '$2y$10$pHGX0a7RNRwNwuHakcglqe4ZgtjDOSdHDBu.niVeljmKssY9YwSsm', 'caissier', '\'&ç\"_\"é'),
(9, NULL, '2023-07-08 19:38:04', '2023-07-08 19:38:04', 'omar', 'cashier', 'omar', '$2y$10$slWlArmmBfUExwq1mfC4K.dXk2ru6wFUq98f.k4PAdoLwRp3zNj/S', 'omar', ''),
(11, NULL, '2023-07-08 19:38:43', '2023-07-08 19:38:43', 'khalid', 'cashier', 'khalid', '$2y$10$wEAyRuJs1GSYrsgMouwVuuRpxmMq5lOUqSDtZb8kV34L.BtUi9BqS', 'khalid', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
