-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 27 mai 2024 à 10:30
-- Version du serveur : 10.4.12-MariaDB-log
-- Version de PHP : 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `nourapp-b2`
--

-- --------------------------------------------------------

--
-- Structure de la table `areas`
--

CREATE TABLE `areas` (
  `id` int(10) UNSIGNED NOT NULL,
  `create_by` int(11) DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT current_timestamp(),
  `update_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `name` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `areas`
--

INSERT INTO `areas` (`id`, `create_by`, `create_at`, `update_at`, `name`) VALUES
(1, NULL, '2023-07-08 10:00:09', '2023-07-08 10:00:09', 'terasse');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `create_by` int(11) DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT current_timestamp(),
  `update_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `name` varchar(50) NOT NULL,
  `image` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `create_by`, `create_at`, `update_at`, `name`, `image`) VALUES
(3, NULL, '2024-05-27 09:33:28', '2024-05-27 09:33:28', 'Tacos', 'C9ycQFU8PqZbWhk06nKB.png'),
(4, NULL, '2024-05-27 09:39:05', '2024-05-27 09:39:05', 'Pizzas', '4z6MAoJKqDUGWnc8latd.jpg'),
(5, NULL, '2024-05-27 09:44:53', '2024-05-27 09:44:53', 'Burgers', 'DaLFXYn0U9t4skMqliV6.jpg'),
(6, NULL, '2024-05-27 09:49:18', '2024-05-27 09:49:18', 'Paninis', 'CeDjW9EKzF81hnfX0oaA.jpg'),
(7, NULL, '2024-05-27 09:52:34', '2024-05-27 09:52:34', 'Salades', 'oTDZG3jpmCNUenB6qxaY.jpg'),
(8, NULL, '2024-05-27 09:57:40', '2024-05-27 09:57:40', 'Jus', 'MY4ET3nC01S_HGLQliRd.jpeg'),
(9, NULL, '2024-05-27 10:02:27', '2024-05-27 10:02:27', 'Boissons Chaudes', 'HhTrigbFkXqZGoNzdOmP.jpg'),
(10, NULL, '2024-05-27 10:11:13', '2024-05-27 10:11:13', 'Pâtisserie', 'L_5lKWE3t4hZmyCUxg1D.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `create_by` int(11) DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT current_timestamp(),
  `update_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `name` varchar(50) NOT NULL,
  `address` varchar(200) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `daily`
--

CREATE TABLE `daily` (
  `id` int(10) UNSIGNED NOT NULL,
  `create_by` int(11) DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT current_timestamp(),
  `update_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `close_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `daily`
--

INSERT INTO `daily` (`id`, `create_by`, `create_at`, `update_at`, `close_at`) VALUES
(5, NULL, '2024-05-27 10:23:41', '2024-05-27 10:23:41', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `equips_in`
--

CREATE TABLE `equips_in` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `printer_name` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `equips_in`
--

INSERT INTO `equips_in` (`id`, `name`, `printer_name`) VALUES
(3, 'cachier', 'SII RP-D10'),
(20, 'Barman', 'SII RP-D10'),
(19, 'Salade', 'SII RP-D10'),
(21, 'Pâtisserie', 'SII RP-D10'),
(22, 'Cuisinier', 'SII RP-D10');

-- --------------------------------------------------------

--
-- Structure de la table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(10) UNSIGNED NOT NULL,
  `create_by` int(11) DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT current_timestamp(),
  `update_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `title` varchar(100) NOT NULL,
  `amount` float NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `daily_id` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `expense_daily`
--

CREATE TABLE `expense_daily` (
  `id` int(10) UNSIGNED NOT NULL,
  `create_by` int(11) DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT current_timestamp(),
  `update_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `close_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `menu`
--

CREATE TABLE `menu` (
  `id` int(10) UNSIGNED NOT NULL,
  `create_by` int(11) DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT current_timestamp(),
  `update_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `category_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `capital` float NOT NULL,
  `price` float NOT NULL,
  `quantity` float DEFAULT NULL,
  `equips_in` int(10) NOT NULL,
  `image` text CHARACTER SET utf8mb4 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `menu`
--

INSERT INTO `menu` (`id`, `create_by`, `create_at`, `update_at`, `category_id`, `name`, `capital`, `price`, `quantity`, `equips_in`, `image`) VALUES
(6, NULL, '2024-05-27 09:34:15', '2024-05-27 09:34:15', 3, 'Tacos Chicken', 0, 45, NULL, 22, 'mxlTG0uCpKbtB_YZE6d9.jpg'),
(7, NULL, '2024-05-27 09:35:45', '2024-05-27 09:35:45', 3, 'Tacos Mixt', 0, 45, NULL, 22, 'UspXM1c3_DjBhPEnxtFw.jpeg'),
(8, NULL, '2024-05-27 09:36:17', '2024-05-27 09:36:17', 3, 'Tacos Fruit de Mer', 0, 50, NULL, 22, 'jmyNEoW1Sx295TdVU4le.jpg'),
(9, NULL, '2024-05-27 09:37:18', '2024-05-27 09:37:18', 3, 'Tacos Viande Hachée', 0, 45, NULL, 22, '3rlGA9XCZ7pidwn0NzJE.jpg'),
(10, NULL, '2024-05-27 09:38:28', '2024-05-27 09:38:28', 3, 'Tacos Cow-Boy', 0, 45, NULL, 22, 'E2HzDFAgcflux3X0WbTy.jpg'),
(11, NULL, '2024-05-27 09:39:55', '2024-05-27 09:39:55', 4, 'Pizza Fruit de Mer', 0, 70, NULL, 22, 'SBilcJTFeHC5bkMs9KPE.jpg'),
(12, NULL, '2024-05-27 09:40:19', '2024-05-27 09:40:19', 4, 'Pizza Chicken', 0, 50, NULL, 22, 'S0b4OcHpIGY72lR5Bayg.jpg'),
(13, NULL, '2024-05-27 09:41:03', '2024-05-27 09:41:03', 4, 'Pizza Végétarienne', 0, 45, NULL, 22, 'dITbzm87UJ5P_ceilY6A.jpg'),
(14, NULL, '2024-05-27 09:41:22', '2024-05-27 09:41:22', 4, 'Pizza Thon', 0, 55, NULL, 22, 'dMSjWUA6iNGZDtsyFE7L.jpg'),
(15, NULL, '2024-05-27 09:42:14', '2024-05-27 09:42:14', 4, 'Pizza 4 Saisons', 0, 70, NULL, 22, 'ZmMKs1OPGeoRgr8TIUB7.jpg'),
(16, NULL, '2024-05-27 09:42:37', '2024-05-27 09:42:37', 4, 'Pizza Mixt', 0, 50, NULL, 22, 'd9OtgWDM3rCfypqZ0jJu.jpg'),
(17, NULL, '2024-05-27 09:43:01', '2024-05-27 09:43:01', 4, 'Pizza Margherita', 0, 40, NULL, 22, 'Zx7Iaqd_30ADo1BKuFGf.jpg'),
(18, NULL, '2024-05-27 09:43:36', '2024-05-27 09:43:36', 4, 'Pizza Chawaema', 0, 55, NULL, 22, 'nsMYPle6UgckINrB0_ti.jpg'),
(19, NULL, '2024-05-27 09:44:00', '2024-05-27 09:44:00', 4, 'Pizza Pepperoni', 0, 55, NULL, 22, 'XATIh3Zo5wt4qkPE9_dR.jpg'),
(20, NULL, '2024-05-27 09:45:52', '2024-05-27 09:45:52', 5, 'Cheese Burger', 0, 30, NULL, 22, 'rKJhiYM6eAtO0bQCpuWd.png'),
(21, NULL, '2024-05-27 09:46:22', '2024-05-27 09:46:22', 5, 'Chicken Grill', 0, 35, NULL, 22, 'RkhDQTUCg0238FyLjf4A.jpeg'),
(22, NULL, '2024-05-27 09:46:53', '2024-05-27 09:46:53', 5, 'Biggy Burger', 0, 45, NULL, 22, 'RkhDQTUCg0238FyLjf4A.jpeg'),
(23, NULL, '2024-05-27 09:47:19', '2024-05-27 09:47:19', 5, 'Fish To Fish', 0, 30, NULL, 22, 'YldMthTRF89b4vcQp5nk.jpg'),
(24, NULL, '2024-05-27 09:47:46', '2024-05-27 09:47:46', 5, 'Black Pepper', 0, 35, NULL, 22, '_jLd2J1ZgowtcpGNmIT5.jpg'),
(25, NULL, '2024-05-27 09:48:25', '2024-05-27 09:48:25', 5, 'Double Cheese Burger', 0, 30, NULL, 22, 'lLG7zsjFwd4m5gZb2NRD.jpg'),
(26, NULL, '2024-05-27 09:48:48', '2024-05-27 09:48:48', 5, 'Spicy Burger', 0, 30, NULL, 22, 'eZ2CGwd39rvDab8J16qE.jpg'),
(27, NULL, '2024-05-27 09:50:06', '2024-05-27 09:50:06', 6, 'Panini Viande Hachee', 0, 30, NULL, 22, 'WvzpXUHKeOdQIq69ghmo.jpg'),
(28, NULL, '2024-05-27 09:50:23', '2024-05-27 09:50:23', 6, 'Panini Poulet', 0, 30, NULL, 22, 'y4a7_PjFoXZEHusNxmhO.jpg'),
(29, NULL, '2024-05-27 09:50:45', '2024-05-27 09:50:45', 6, 'Panini Thon', 0, 30, NULL, 22, 'YefTCHkN0X6il3pa5KFP.jpeg'),
(30, NULL, '2024-05-27 09:51:12', '2024-05-27 09:51:12', 6, 'Panini Mozzarella', 0, 25, NULL, 22, 'TxqgvodLe876RJYuF_1E.jpeg'),
(31, NULL, '2024-05-27 09:51:48', '2024-05-27 09:51:48', 6, 'Panini Dinde Fumée', 0, 30, NULL, 22, '2i6HvsKEGwraPU47XAbJ.jpg'),
(32, NULL, '2024-05-27 09:53:11', '2024-05-27 09:53:11', 7, 'Salade Niçoise', 0, 40, NULL, 19, 'L7OgJ2Kjlsy9qQvk6IMB.jpg'),
(33, NULL, '2024-05-27 09:53:45', '2024-05-27 09:53:45', 7, 'Salade César', 0, 35, NULL, 19, 'txY941ym0k7fEbhWK3U8.jpg'),
(34, NULL, '2024-05-27 09:54:09', '2024-05-27 09:54:09', 7, 'Salade Marocaine', 0, 30, NULL, 19, 'OZ3Mzt_h6Fg0paqbPs5c.jpg'),
(35, NULL, '2024-05-27 09:55:02', '2024-05-27 09:55:02', 7, 'Salade Royal', 0, 60, NULL, 19, 'IC9pfeYxXPkEbnUyBDwu.jpg'),
(36, NULL, '2024-05-27 09:55:31', '2024-05-27 09:55:31', 7, 'Salade Fruit de Mer', 0, 60, NULL, 19, '91U4H5cyRrBweiFpTYN3.jpeg'),
(37, NULL, '2024-05-27 09:55:56', '2024-05-27 09:55:56', 7, 'Salade Mexican', 0, 50, NULL, 19, 'b8UVnJIW1zHurZmOFsq0.jpg'),
(38, NULL, '2024-05-27 09:58:05', '2024-05-27 09:58:05', 8, 'Jus de Banane', 0, 25, NULL, 20, 'BhcygAp3vSieUWO_Vjqz.jpg'),
(39, NULL, '2024-05-27 09:58:24', '2024-05-27 09:58:24', 8, 'Jus de Fraise', 0, 30, NULL, 20, 'KlvIFj1boTZfP0AdiqMc.jpeg'),
(40, NULL, '2024-05-27 09:59:07', '2024-05-27 09:59:07', 8, 'Jus de Pomme', 0, 25, NULL, 20, 'N2LhdXaMYwef7V45cbUz.jpeg'),
(41, NULL, '2024-05-27 09:59:25', '2024-05-27 09:59:25', 8, 'Jus de Citron', 0, 25, NULL, 20, 'NlcnU7SCjamPiMxy0dJD.jpg'),
(42, NULL, '2024-05-27 09:59:47', '2024-05-27 09:59:47', 8, 'Jus d\'Orange', 0, 25, NULL, 20, 'NwMnl6SI4jekp8Y2CaAH.jpg'),
(43, NULL, '2024-05-27 10:00:21', '2024-05-27 10:00:21', 8, 'Jus de Panaché', 0, 30, NULL, 20, 'Y6zW45PyfwB8bZncM7e1.jpeg'),
(44, NULL, '2024-05-27 10:00:47', '2024-05-27 10:00:47', 8, 'Za3Za3', 0, 35, NULL, 20, 'yNfa3eARWVpzZSPHUKgb.jpg'),
(45, NULL, '2024-05-27 10:03:24', '2024-05-27 10:03:24', 9, 'Café Noir + Eau', 0, 11, NULL, 20, 'u0dJDQ4Gx9p5kliS2v1N.jpg'),
(46, NULL, '2024-05-27 10:03:47', '2024-05-27 10:03:47', 9, 'Café Créme', 0, 11, NULL, 20, 'irghYx25HfjesmwLbaQu.jpeg'),
(47, NULL, '2024-05-27 10:04:13', '2024-05-27 10:04:13', 9, 'Lait Choud', 0, 7, NULL, 20, '3XlunCkwMPg7OacSY8zV.jpg'),
(48, NULL, '2024-05-27 10:05:05', '2024-05-27 10:05:05', 9, 'Verre de Thé', 0, 10, NULL, 20, 'Pix4TXI9UEVyo8D3qCJs.jpg'),
(49, NULL, '2024-05-27 10:07:02', '2024-05-27 10:07:02', 9, 'Nescafé', 0, 10, NULL, 20, 'TM1OWDIySEYkl9cHRpua.jpg'),
(50, NULL, '2024-05-27 10:07:27', '2024-05-27 10:07:27', 9, 'Lipton', 0, 10, NULL, 20, 'CmfiOvKduHPLaG6N5tW_.jpg'),
(51, NULL, '2024-05-27 10:07:54', '2024-05-27 10:07:54', 9, 'Cappuccino', 0, 12, NULL, 20, 'QuTOGKm6aD80rxpd3k4Y.jpg'),
(52, NULL, '2024-05-27 10:08:44', '2024-05-27 10:08:44', 9, 'Thé Verveine', 0, 10, NULL, 20, 'S60T4HZstJPLYhjQArf9.jpg'),
(53, NULL, '2024-05-27 10:11:41', '2024-05-27 10:11:41', 10, 'Tiramisu', 0, 20, NULL, 21, 'U4YaL6mVNsgpJ2FGjqyk.jpg'),
(54, NULL, '2024-05-27 10:12:15', '2024-05-27 10:12:15', 10, 'Panna Cotta', 0, 22, NULL, 21, 'A3VkZXhcTina6MCKv8qI.jpg'),
(55, NULL, '2024-05-27 10:15:32', '2024-05-27 10:15:32', 10, 'Original Waffle', 0, 30, NULL, 21, 'ZxTGok4rXwKUR026meSA.jpg'),
(56, NULL, '2024-05-27 10:16:29', '2024-05-27 10:16:29', 10, 'Banana Split Crepe', 0, 25, NULL, 21, 'BTuP0UFrWoIbq49HDXw5.jpg'),
(57, NULL, '2024-05-27 10:16:48', '2024-05-27 10:16:48', 10, 'Nutella Crepe', 0, 20, NULL, 21, '9dYRTwaO6VkoQxHIygXe.jpg'),
(58, NULL, '2024-05-27 10:17:26', '2024-05-27 10:17:26', 10, 'Chicken Crepe', 0, 25, NULL, 21, 'VTH6U27BoMFaYhRn3Zv5.jpg'),
(59, NULL, '2024-05-27 10:18:25', '2024-05-27 10:18:25', 10, 'Chocolate Croissant', 0, 5, NULL, 21, 'uGzHgSIkEQla8KeOcf2v.jpg'),
(60, NULL, '2024-05-27 10:18:51', '2024-05-27 10:18:51', 10, 'Muffin', 0, 10, NULL, 21, 'U8Si4Rx0Kfu9Mh67BY13.jpg'),
(61, NULL, '2024-05-27 10:19:18', '2024-05-27 10:19:18', 10, 'Baklava', 0, 8, NULL, 21, 's2eSA0nUkoubNQM6gmZw.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `create_by` text DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT current_timestamp(),
  `update_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `daily_id` int(10) UNSIGNED DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  `table_id` int(11) DEFAULT NULL,
  `table_area` varchar(20) DEFAULT NULL,
  `table_name` varchar(20) DEFAULT NULL,
  `no_people` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `customer_name` varchar(50) DEFAULT NULL,
  `customer_address` varchar(200) DEFAULT NULL,
  `customer_phone` varchar(30) DEFAULT NULL,
  `paid` tinyint(1) NOT NULL DEFAULT 0,
  `paid_at` timestamp NULL DEFAULT NULL,
  `amountProvided` float NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `create_by`, `create_at`, `update_at`, `daily_id`, `type`, `table_id`, `table_area`, `table_name`, `no_people`, `customer_id`, `customer_name`, `customer_address`, `customer_phone`, `paid`, `paid_at`, `amountProvided`) VALUES
(59, 'admin', '2024-05-27 10:24:55', '2024-05-27 10:29:10', 5, 'import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-05-27 10:29:10', 200),
(57, 'admin', '2024-05-27 10:20:39', '2024-05-27 10:23:41', 5, 'import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-05-27 10:23:41', 250),
(58, 'admin', '2024-05-27 10:24:30', '2024-05-27 10:29:17', 5, 'import', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-05-27 10:29:17', 200);

-- --------------------------------------------------------

--
-- Structure de la table `sales`
--

CREATE TABLE `sales` (
  `id` int(10) UNSIGNED NOT NULL,
  `create_by` int(11) DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT current_timestamp(),
  `update_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `order_id` int(10) UNSIGNED NOT NULL,
  `menu_id` int(11) NOT NULL,
  `equips_in` varchar(10) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `price` float NOT NULL,
  `capital` float NOT NULL,
  `qnt` float NOT NULL,
  `note` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `sales`
--

INSERT INTO `sales` (`id`, `create_by`, `create_at`, `update_at`, `order_id`, `menu_id`, `equips_in`, `category_name`, `title`, `price`, `capital`, `qnt`, `note`) VALUES
(121, NULL, '2024-05-27 10:24:55', '2024-05-27 10:24:55', 59, 6, '22', 'Tacos', 'Tacos Chicken', 45, 0, 2, NULL),
(120, NULL, '2024-05-27 10:24:55', '2024-05-27 10:24:55', 59, 37, '19', 'Salades', 'Salade Mexican', 50, 0, 2, NULL),
(119, NULL, '2024-05-27 10:24:30', '2024-05-27 10:24:30', 58, 6, '22', 'Tacos', 'Tacos Chicken', 45, 0, 1, NULL),
(118, NULL, '2024-05-27 10:24:30', '2024-05-27 10:24:30', 58, 39, '20', 'Jus', 'Jus de Fraise', 30, 0, 1, NULL),
(117, NULL, '2024-05-27 10:24:30', '2024-05-27 10:24:30', 58, 37, '19', 'Salades', 'Salade Mexican', 50, 0, 1, NULL),
(116, NULL, '2024-05-27 10:20:39', '2024-05-27 10:20:39', 57, 6, '22', 'Tacos', 'Tacos Chicken', 45, 0, 1, NULL),
(115, NULL, '2024-05-27 10:20:39', '2024-05-27 10:20:39', 57, 7, '22', 'Tacos', 'Tacos Mixt', 45, 0, 1, NULL),
(114, NULL, '2024-05-27 10:20:39', '2024-05-27 10:20:39', 57, 33, '19', 'Salades', 'Salade César', 35, 0, 1, NULL),
(113, NULL, '2024-05-27 10:20:39', '2024-05-27 10:20:39', 57, 40, '20', 'Jus', 'Jus de Pomme', 25, 0, 1, NULL),
(112, NULL, '2024-05-27 10:20:39', '2024-05-27 10:20:39', 57, 41, '20', 'Jus', 'Jus de Citron', 25, 0, 1, NULL),
(111, NULL, '2024-05-27 10:20:39', '2024-05-27 10:20:39', 57, 50, '20', 'Boissons Chaudes', 'Lipton', 10, 0, 1, NULL),
(110, NULL, '2024-05-27 10:20:39', '2024-05-27 10:20:39', 57, 56, '21', 'Pâtisserie', 'Banana Split Crepe', 25, 0, 1, NULL),
(109, NULL, '2024-05-27 10:20:39', '2024-05-27 10:20:39', 57, 53, '21', 'Pâtisserie', 'Tiramisu', 20, 0, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tables`
--

CREATE TABLE `tables` (
  `id` int(10) UNSIGNED NOT NULL,
  `create_by` int(11) DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT current_timestamp(),
  `update_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `area_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `tables`
--

INSERT INTO `tables` (`id`, `create_by`, `create_at`, `update_at`, `area_id`, `name`) VALUES
(1, NULL, '2023-07-08 10:00:18', '2023-07-08 10:00:18', 1, 'table 1'),
(2, NULL, '2023-07-08 10:00:24', '2023-07-08 10:00:24', 1, 'table 2'),
(3, NULL, '2024-05-27 09:16:07', '2024-05-27 09:16:07', 1, 'table 3'),
(4, NULL, '2024-05-27 09:16:20', '2024-05-27 09:16:20', 1, 'table 4'),
(5, NULL, '2024-05-27 09:16:23', '2024-05-27 09:16:23', 1, 'table 5'),
(6, NULL, '2024-05-27 09:16:28', '2024-05-27 09:16:28', 1, 'table 6'),
(7, NULL, '2024-05-27 09:16:34', '2024-05-27 09:16:34', 1, 'table 7'),
(8, NULL, '2024-05-27 09:16:39', '2024-05-27 09:16:39', 1, 'table 8');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `create_by` int(11) DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT current_timestamp(),
  `update_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fullName` varchar(30) DEFAULT NULL,
  `type` varchar(15) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `visiblepass` text DEFAULT NULL,
  `rfidCode` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `create_by`, `create_at`, `update_at`, `fullName`, `type`, `username`, `password`, `visiblepass`, `rfidCode`) VALUES
(1, NULL, '2023-07-05 21:39:05', '2023-07-05 22:11:59', 'admin', 'admin', 'admin', '$2y$10$2U97X2paJJuCvJytYPJ3LuvAJkwjrpaCwKOuzewHmg.v9AcqisIx.', 'admin', ''),
(8, NULL, '2023-07-08 19:00:56', '2023-07-08 19:00:56', 'cachier', 'cashier', 'caissier', '$2y$10$pHGX0a7RNRwNwuHakcglqe4ZgtjDOSdHDBu.niVeljmKssY9YwSsm', 'caissier', '');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `daily`
--
ALTER TABLE `daily`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `equips_in`
--
ALTER TABLE `equips_in`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `expense_daily`
--
ALTER TABLE `expense_daily`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_menu_categories` (`category_id`),
  ADD KEY `equips_in` (`equips_in`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orders_daily` (`daily_id`);

--
-- Index pour la table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sales_orders` (`order_id`);

--
-- Index pour la table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tables_areas` (`area_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `daily`
--
ALTER TABLE `daily`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `equips_in`
--
ALTER TABLE `equips_in`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `expense_daily`
--
ALTER TABLE `expense_daily`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT pour la table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT pour la table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
