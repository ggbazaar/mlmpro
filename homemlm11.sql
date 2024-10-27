-- Adminer 4.8.1 MySQL 8.0.30 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `app_accounts`;
CREATE TABLE `app_accounts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(150) DEFAULT NULL,
  `account_name` varchar(150) DEFAULT NULL,
  `account_no` varchar(80) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


SET NAMES utf8mb4;

DROP TABLE IF EXISTS `commissions`;
CREATE TABLE `commissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `purchase_id` int NOT NULL,
  `level` int NOT NULL,
  `level_commission` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `service_charge` decimal(10,2) NOT NULL,
  `payable_amount` decimal(10,2) NOT NULL,
  `status` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `commissions` (`id`, `user_id`, `purchase_id`, `level`, `level_commission`, `total_amount`, `service_charge`, `payable_amount`, `status`, `created_at`, `updated_at`) VALUES
(140,	85,	1,	1,	300.00,	300.00,	30.00,	270.00,	1,	'2024-10-22 01:38:34',	'2024-10-22 01:38:34'),
(141,	86,	3,	1,	300.00,	300.00,	30.00,	270.00,	1,	'2024-10-22 01:45:01',	'2024-10-22 01:45:01'),
(142,	85,	4,	2,	300.00,	300.00,	30.00,	270.00,	1,	'2024-10-22 01:46:47',	'2024-10-22 01:46:47'),
(143,	87,	4,	1,	300.00,	300.00,	30.00,	270.00,	1,	'2024-10-22 01:46:47',	'2024-10-22 01:46:47'),
(144,	86,	5,	2,	300.00,	300.00,	30.00,	270.00,	1,	'2024-10-22 02:06:44',	'2024-10-22 02:06:44'),
(145,	87,	5,	2,	300.00,	300.00,	30.00,	270.00,	1,	'2024-10-22 02:06:44',	'2024-10-22 02:06:44'),
(146,	88,	5,	1,	300.00,	300.00,	30.00,	270.00,	1,	'2024-10-22 02:06:44',	'2024-10-22 02:06:44'),
(147,	89,	5,	1,	300.00,	300.00,	30.00,	270.00,	1,	'2024-10-22 02:06:44',	'2024-10-22 02:06:44'),
(148,	90,	5,	1,	300.00,	300.00,	30.00,	270.00,	1,	'2024-10-22 02:06:44',	'2024-10-22 02:06:44'),
(149,	91,	5,	1,	300.00,	300.00,	30.00,	270.00,	1,	'2024-10-22 02:06:44',	'2024-10-22 02:06:44'),
(150,	85,	6,	3,	300.00,	300.00,	30.00,	270.00,	1,	'2024-10-22 02:07:10',	'2024-10-22 02:07:10');

DROP TABLE IF EXISTS `commissions1`;
CREATE TABLE `commissions1` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `purchase_id` int NOT NULL,
  `level_commission` int NOT NULL,
  `total_amount` int NOT NULL,
  `service_charge` int NOT NULL,
  `payable_amount` int NOT NULL,
  `status` smallint NOT NULL,
  `created_at` timestamp NOT NULL,
  `update_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `commissions1_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `kit_amounts`;
CREATE TABLE `kit_amounts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(90) NOT NULL,
  `description` varchar(3000) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `status` tinyint NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `kit_amounts` (`id`, `title`, `description`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(1,	'A plan',	'My Planc',	3500.00,	1,	'2024-10-20 10:53:37',	'2024-10-20 10:53:37'),
(2,	'B plan',	'My Planc1',	3500.00,	1,	'2024-10-20 10:53:37',	'2024-10-20 10:53:37');

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `oauth_access_tokens`;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `client_id` bigint unsigned NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('0177d7a30b75f576c5a51e07483632f1f89d9941651961cf95ad9d372684b2ca09ee60016b186e93',	240,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 02:48:26',	'2024-10-19 02:48:26',	'2025-10-19 08:18:26'),
('0ff2d543fdf788ddf9382f8e2764e914e2c9b84c14bd6d1f3078802c6e25d175fa2562186f8a1b67',	240,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 01:18:10',	'2024-10-19 01:18:10',	'2025-10-19 06:48:10'),
('193345d2cbdbc35e8fc78f21060c418a7e07c60691b01a2bc47303f4aac767ae908fb1723f7f7224',	240,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 02:52:11',	'2024-10-19 02:52:11',	'2025-10-19 08:22:11'),
('259d8fc8e000fbce5435db39f7f8f446996e7227e317babf0c4215fd0b075d010ddd072cf0e47164',	240,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 02:40:47',	'2024-10-19 02:40:47',	'2025-10-19 08:10:47'),
('3971a159ded05efecb8b98d8a6c4f9d9d57e99a717664de6aa141e841a9e18c55845fb8646af843f',	240,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 02:39:52',	'2024-10-19 02:39:52',	'2025-10-19 08:09:52'),
('3d947c8b2191cbb543b551c004977ebe3b8c8e96fd9e34f57a0cd389a2d3bb296b60cfab3d440e17',	240,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 02:39:10',	'2024-10-19 02:39:10',	'2025-10-19 08:09:10'),
('4ef99cea9b196afcd6834dbb039ddc3d9e44918bc1a1361b2774c443a4bc072e9ce9126fbde0a035',	86,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-22 01:06:45',	'2024-10-22 01:06:45',	'2025-10-22 06:36:45'),
('4f8a46d76834a79ed4ab00e60a24870ba86c1dc94fc698c327caa99415c8707e6cba78bf13408bfe',	248,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 04:28:23',	'2024-10-19 04:28:23',	'2025-10-19 09:58:23'),
('4fb25a93a60c23f458fb88a9dcba112d5c4e4b2af2376f071ca504d48c64a6cdf73e86cff0dbc581',	240,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 02:42:17',	'2024-10-19 02:42:17',	'2025-10-19 08:12:17'),
('56da6f19a750b7e534941af7960c04f053702aac1a1f7f64605281a1708c0e4f4378d277ad51dd1c',	248,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 04:26:43',	'2024-10-19 04:26:43',	'2025-10-19 09:56:43'),
('5b780ae2acb5fb0ba279d9926ec4020c7e8118fda6e6a336fb8be67efc005350237024bb0d06b15b',	240,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 02:49:48',	'2024-10-19 02:49:48',	'2025-10-19 08:19:48'),
('60cf8d80b60adabd75d28d71b39bb2e8c85e2edc172bc7a2a816dff7cedefa8139fc01dcaa1cf4d4',	240,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 02:36:58',	'2024-10-19 02:36:58',	'2025-10-19 08:06:58'),
('64c421f1f8f2881acf09242d1b44246217e5c650eb7f730a4eee8de45b3e89b1bb8ec7a37dcf82be',	86,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-22 01:05:14',	'2024-10-22 01:05:15',	'2025-10-22 06:35:14'),
('6a0ddb127ece8e9f8c08a93b2131a20459e2ac58d913c051f3afb7412dbe1b7c8f8b941d63fa64b5',	240,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 01:51:58',	'2024-10-19 01:51:59',	'2025-10-19 07:21:58'),
('707b5250ea84560de8d21607a33e68df61cbab31900adeef951bc934f9c5615a4a1c533ae2e770c0',	240,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 02:40:25',	'2024-10-19 02:40:25',	'2025-10-19 08:10:25'),
('7fb0985d52520ea7943ed2d2a3ac42d19002782b3c7ad406e4b2a008bb291a65ef90522c2f51d05e',	248,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 04:26:31',	'2024-10-19 04:26:31',	'2025-10-19 09:56:31'),
('804fc9c1d14ab23d8d9e33701a4f5513cd227f5373d9a929b1aeaa7921f817ef9835e35d71ecebd7',	240,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 02:38:03',	'2024-10-19 02:38:03',	'2025-10-19 08:08:03'),
('9869da0a1c4252f104d6ac71e24d6a3f4b4a03172541f20514bf27b6645d20940fdd16f1c39f0c06',	240,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 02:44:15',	'2024-10-19 02:44:15',	'2025-10-19 08:14:15'),
('9c92436747427b82d14b8b0f6907b21f09170ef9053fb0b1df7546571203056957a891a559fcf74a',	248,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 04:26:02',	'2024-10-19 04:26:02',	'2025-10-19 09:56:02'),
('a5adcba5bf13b3aa69050095552e3d41d417b7089492ebda9d4e831acd2e8d1a437294708981f009',	240,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 01:19:04',	'2024-10-19 01:19:04',	'2025-10-19 06:49:04'),
('afa36c9282eb6fb41e85343e5e173b63c6893b788cac0d16dbf0c2c46ff53b8be61bb19f3cdf5690',	240,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 02:43:03',	'2024-10-19 02:43:03',	'2025-10-19 08:13:03'),
('b292a3aaa1e15f0d1728b4a952699d5d9aa1f2e6688d76ce2192906d2156266de2d4535157b4c98d',	248,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 04:28:42',	'2024-10-19 04:28:42',	'2025-10-19 09:58:42'),
('b3117a8df52d4de3ee0f07461dacfb13f2e66f904ec24271586610e9eb0feeba5215ed7677d67040',	240,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 02:30:25',	'2024-10-19 02:30:25',	'2025-10-19 08:00:25'),
('b5653cca49842c47a831b61b557d027767801afbf50313aab6d98c2da8c45330f8541939828cf30b',	240,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 02:53:49',	'2024-10-19 02:53:49',	'2025-10-19 08:23:49'),
('b7f82232559054b0023a98a0dc735aaba3959e50ed993405b4cacfe5174ba155006497853bf86753',	240,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 02:41:55',	'2024-10-19 02:41:55',	'2025-10-19 08:11:55'),
('b9addb9286d66f3a6e3054a7e8711ac2b1e221c9fa0390d5c2291c649b41373f756f2eae3998a69d',	248,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 04:25:07',	'2024-10-19 04:25:07',	'2025-10-19 09:55:07'),
('b9f0350213a2f963325bd7231220e1263fca28fdb39ba647ccee29b9ada7c1f76a9527d8ae48ec67',	1,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-27 02:27:16',	'2024-10-27 02:27:17',	'2025-10-27 07:57:16'),
('ba70c947a762baaeaf67266cd6eb94a2745b65b3bf1be1952b0fb0ab15f69db450ff8d4ea9a9e78d',	240,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 02:48:44',	'2024-10-19 02:48:44',	'2025-10-19 08:18:44'),
('bf27d69f2cfbe39bb26bf69a4357397ec8cd6d6d95015015fbb1bb4b53558a5de1c79f55efe75be3',	240,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 02:38:45',	'2024-10-19 02:38:45',	'2025-10-19 08:08:45'),
('c0258edebda34dec1318d9c2bdf4edcc1c621ca74eeacab57a0bb4e0ae770466bda41cec8d5c81f0',	240,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 03:27:28',	'2024-10-19 03:27:28',	'2025-10-19 08:57:28'),
('c43681a4d9bf44af1b0724af425c073015ced06d0e446aa9b67539a979f04c3f8d6d6679192d4aeb',	240,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 02:22:15',	'2024-10-19 02:22:15',	'2025-10-19 07:52:15'),
('d46f35fedb26da38761b62dd8888c5b25a886db6b89a0d60437b6c8888ec11d424b15ab60b0e80ef',	240,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 02:27:18',	'2024-10-19 02:27:18',	'2025-10-19 07:57:18'),
('e0faf28efaaea095e9672660a246b5488a97276c851ccd855a3240320cc4bdb4eae8548c1a8ff632',	240,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 02:27:01',	'2024-10-19 02:27:01',	'2025-10-19 07:57:01'),
('e5247ba8542b152dc40bdcbe53265357c06491ace08c28efe2761481f36cf1fd1ddb9e9dae6a1d9a',	240,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 02:37:30',	'2024-10-19 02:37:30',	'2025-10-19 08:07:30'),
('edcf2232243f631ca2238891a5fc83f12fc9bb4919050ce186d1b575fa0c037105d9a22b2c1e63b1',	240,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 02:27:38',	'2024-10-19 02:27:38',	'2025-10-19 07:57:38'),
('f3463f0b197e10eaa1e037e059ffa98f573523deffb9953c893fdf8483cd2edf84e71fabe6cf6152',	240,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 02:38:23',	'2024-10-19 02:38:23',	'2025-10-19 08:08:23'),
('f41d9b96ce68a4ec9773b834620398d15cb61ee6b0f565eef0349c1c5d72237daa4b1724a2f47d46',	240,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 02:49:04',	'2024-10-19 02:49:04',	'2025-10-19 08:19:04'),
('fa5b281b9e51ba49b44b4e24d7ca1c2a12b12540f889d6c1e60646dd481b7387e5c489aa66ee7635',	240,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 04:08:11',	'2024-10-19 04:08:11',	'2025-10-19 09:38:11'),
('ff1655715de56218ad2d356d12ebf09fd40e761d67b387e4042322243eaad56177e0e0b0f20a66a8',	248,	1,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'[]',	0,	'2024-10-19 04:28:04',	'2024-10-19 04:28:04',	'2025-10-19 09:58:04');

DROP TABLE IF EXISTS `oauth_auth_codes`;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `client_id` bigint unsigned NOT NULL,
  `scopes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `oauth_clients`;
CREATE TABLE `oauth_clients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1,	NULL,	'ggbmlm',	'oqlH37LYPvg6yTfVM2RmZNYTmcuYJefowFdB71gj',	NULL,	'http://localhost',	1,	0,	0,	'2024-10-19 01:17:55',	'2024-10-19 01:17:55');

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1,	1,	'2024-10-19 01:17:56',	'2024-10-19 01:17:56');

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kit_id` int NOT NULL,
  `user_id` int NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `pay_type` varchar(50) NOT NULL,
  `pin_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `remark` text,
  `date` datetime NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  `approve_by` varchar(200) DEFAULT NULL,
  `approve_date` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `payments` (`id`, `kit_id`, `user_id`, `amount`, `pay_type`, `pin_code`, `remark`, `date`, `status`, `approve_by`, `approve_date`, `created_at`, `updated_at`) VALUES
(21,	1,	85,	3500.00,	'1',	'',	'Appoved by avinash',	'2024-10-27 07:51:43',	'1',	'Root',	'2024-10-27 07:57:30',	'2024-10-27 07:51:43',	'2024-10-27 07:57:30'),
(22,	1,	87,	3500.00,	'1',	'',	'Via Pin',	'2024-10-27 08:07:10',	'0',	NULL,	NULL,	'2024-10-27 08:07:10',	'2024-10-27 08:07:10'),
(23,	1,	88,	3500.00,	'3',	'',	'Via Pin',	'2024-10-27 08:42:06',	'0',	NULL,	NULL,	'2024-10-27 08:42:06',	'2024-10-27 08:42:06'),
(24,	1,	89,	3500.00,	'10',	'',	'Via Pin',	'2024-10-27 09:11:11',	'0',	NULL,	NULL,	'2024-10-27 09:11:11',	'2024-10-27 09:11:11'),
(25,	1,	100,	3500.00,	'10',	NULL,	'Via Pin',	'2024-10-27 09:24:56',	'0',	NULL,	NULL,	'2024-10-27 09:24:56',	'2024-10-27 09:24:56'),
(26,	1,	101,	3500.00,	'10',	NULL,	'Via Pin',	'2024-10-27 09:26:53',	'0',	NULL,	NULL,	'2024-10-27 09:26:53',	'2024-10-27 09:26:53'),
(29,	1,	102,	3500.00,	'10',	'GGBJY2XW',	'Pin-Via Pin',	'2024-10-27 09:35:45',	'0',	NULL,	NULL,	'2024-10-27 09:35:45',	'2024-10-27 09:35:45'),
(30,	1,	99,	3500.00,	'10',	'GGB9MVTF',	'Pin-Via Pin',	'2024-10-27 09:44:43',	'0',	NULL,	NULL,	'2024-10-27 09:44:43',	'2024-10-27 09:44:43');

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `expires_at` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `expires_at`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1,	'App\\Models\\Usermlm',	228,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'1a3537765615c2e3837040dd6bcef193fbd1a9bad46d06b16cbce1d6859ae8f8',	'[\"*\"]',	NULL,	NULL,	'2024-10-09 21:17:57',	'2024-10-09 21:17:57'),
(2,	'App\\Models\\Usermlm',	228,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'2bb19bf26a7d2a201c02205d318c93cb2c95295044ec369e88a5a9d60c08acf2',	'[\"*\"]',	NULL,	NULL,	'2024-10-09 21:19:21',	'2024-10-09 21:19:21'),
(3,	'App\\Models\\Usermlm',	228,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'6ad21f263f4c72ca4c02d181a4268ac52bfd73038ee648128ff7a6d5ca84ce21',	'[\"*\"]',	NULL,	NULL,	'2024-10-09 21:20:04',	'2024-10-09 21:20:04'),
(4,	'App\\Models\\Usermlm',	228,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'2c72026d6ec06be6da2f52e8797dbf5d5243783c81f73ab384796abb7324bae3',	'[\"*\"]',	NULL,	NULL,	'2024-10-09 21:22:15',	'2024-10-09 21:22:15'),
(5,	'App\\Models\\Usermlm',	228,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'30efa2254aeb15c864916398f7a454429e3fa9148e2c4aab91daa5388e0ee3bb',	'[\"*\"]',	NULL,	NULL,	'2024-10-09 21:22:49',	'2024-10-09 21:22:49'),
(6,	'App\\Models\\Usermlm',	228,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'fade5a134dc12aa77555f06b603488927afe64f668d6af009b9bb52e05b41ffa',	'[\"*\"]',	NULL,	NULL,	'2024-10-09 21:23:47',	'2024-10-09 21:23:47'),
(7,	'App\\Models\\Usermlm',	228,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'8a3dd0b88acad031b4dc10dfff478b50941cfb97841118cb2e225ddee77f52cf',	'[\"*\"]',	NULL,	NULL,	'2024-10-09 21:24:05',	'2024-10-09 21:24:05'),
(8,	'App\\Models\\Usermlm',	228,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'a3b5636dff9805752f10c77996be87b43964c660f8076dab838d2efaac8c7f61',	'[\"*\"]',	NULL,	NULL,	'2024-10-09 21:25:14',	'2024-10-09 21:25:14'),
(9,	'App\\Models\\Usermlm',	228,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'a3c9e20639e1870a63fd6290ea6ab81af4ff2f8e885e69df0a6b3e7d85d54243',	'[\"*\"]',	NULL,	NULL,	'2024-10-09 21:26:11',	'2024-10-09 21:26:11'),
(10,	'App\\Models\\Usermlm',	228,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'3c51c9971e016c8bef71936cd59956b3fb1041f79d9b1c4aada58c862f97f99c',	'[\"*\"]',	NULL,	NULL,	'2024-10-09 21:26:56',	'2024-10-09 21:26:56'),
(11,	'App\\Models\\Usermlm',	228,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'990ca234b7f74c8fc262a8d932625a29ebee1aa45eedc609da61ff2ee3b15bba',	'[\"*\"]',	NULL,	NULL,	'2024-10-09 21:27:21',	'2024-10-09 21:27:21'),
(12,	'App\\Models\\Usermlm',	228,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'a0382ce547fd2ece81d76cce441a2994db76b2cdb3026bff10dcb690ba907a59',	'[\"*\"]',	NULL,	NULL,	'2024-10-09 21:32:18',	'2024-10-09 21:32:18'),
(13,	'App\\Models\\Usermlm',	228,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'6e6c818cd09284d738600d9471089b61a36ca9dfd47160ef78321f03028529c9',	'[\"*\"]',	NULL,	NULL,	'2024-10-09 21:35:46',	'2024-10-09 21:35:46'),
(14,	'App\\Models\\Usermlm',	228,	'FKDIWIJdfdsfdsjhkgyW IEW J77872 78*&*&839039J DKSJH!#@^*&(',	'eaeaa7a2c50d2269326b61020e11abbff675f80bf7b90143faa34deed7393085',	'[\"*\"]',	NULL,	NULL,	'2024-10-09 21:37:02',	'2024-10-09 21:37:02'),
(15,	'App\\Models\\Usermlm',	228,	'Personal Access Token',	'f2d78e4f533debbaa4280f4f9814397887d93328dbeff91eab63eb413d3f3d0a',	'[\"*\"]',	NULL,	NULL,	'2024-10-09 21:48:48',	'2024-10-09 21:48:48'),
(16,	'App\\Models\\Usermlm',	228,	'Personal Access Token',	'634ccad38569631b0cfbcd37059d27688c1ced775f969f7b5e9dd41b0597931f',	'[\"*\"]',	NULL,	NULL,	'2024-10-09 21:48:52',	'2024-10-09 21:48:52'),
(17,	'App\\Models\\Usermlm',	228,	'Personal Access Token',	'a4af2b1e1554e4d2c77e3fa7be90bd8ac52fc9e51cd3d8c46a165ee6482c0c27',	'[\"*\"]',	NULL,	NULL,	'2024-10-09 21:49:40',	'2024-10-09 21:49:40'),
(18,	'App\\Models\\Usermlm',	228,	'Personal Access Token',	'2624a507aad3006b48fc2cb3aafd489392b7da1007c7dc0d890dfb56a684a7d6',	'[\"*\"]',	NULL,	NULL,	'2024-10-09 21:49:48',	'2024-10-09 21:49:48'),
(19,	'App\\Models\\Usermlm',	228,	'Personal Access Token',	'544247d6faa7d6e6fb4bfb5d36b2e23ee5239a6531adfebc61ad36e8ce927490',	'[\"*\"]',	NULL,	NULL,	'2024-10-09 21:50:40',	'2024-10-09 21:50:40'),
(20,	'App\\Models\\Usermlm',	228,	'Personal Access Token',	'f93feec84225c752e7c00e10bb9953094a03bbca487f275db8fbb0cbcea0eae7',	'[\"*\"]',	NULL,	NULL,	'2024-10-09 21:54:26',	'2024-10-09 21:54:26'),
(21,	'App\\Models\\Usermlm',	228,	'Personal Access Token',	'8cf852f12909e5811cbaa3b8c4ebeee6bc5f20a0371067fde5f8202e2f7c2904',	'[\"*\"]',	NULL,	NULL,	'2024-10-09 21:54:58',	'2024-10-09 21:54:58'),
(22,	'App\\Models\\Usermlm',	228,	'Personal Access Token',	'15898395cf81944c1a2893abfc9500073223661b0184f066ded726e1846035e5',	'[\"*\"]',	NULL,	NULL,	'2024-10-09 22:40:53',	'2024-10-09 22:40:53'),
(23,	'App\\Models\\Usermlm',	228,	'Personal Access Token',	'374a348392cc4da93b86ef0541fc96a75e25194b7e86f6654463ce779fec58c5',	'[\"*\"]',	NULL,	NULL,	'2024-10-09 22:44:16',	'2024-10-09 22:44:16'),
(24,	'App\\Models\\Usermlm',	228,	'Personal Access Token',	'2510d34af9aeb8cb11373dff4e4925142325534afe5719b75c7cdc882649154a',	'[\"*\"]',	NULL,	NULL,	'2024-10-09 22:57:59',	'2024-10-09 22:57:59'),
(25,	'App\\Models\\Usermlm',	228,	'Personal Access Token',	'b634cfac67441894e57504fe1155ba3c4cb40b9b05939435265c7146ce25b34c',	'[\"*\"]',	NULL,	NULL,	'2024-10-09 23:03:27',	'2024-10-09 23:03:27'),
(26,	'App\\Models\\Usermlm',	228,	'Personal Access Token',	'4b6021803861a44e2c7b4679c9d977ad2afb70e886f8c391252dd6159cc3ddd5',	'[\"*\"]',	NULL,	NULL,	'2024-10-09 23:04:41',	'2024-10-09 23:04:41'),
(27,	'App\\Models\\Usermlm',	228,	'Personal Access Token',	'3fe683f7f1b6c33bf372cda09f0949182707807958446a136715718f072b59bf',	'[\"*\"]',	NULL,	NULL,	'2024-10-09 23:05:37',	'2024-10-09 23:05:37'),
(28,	'App\\Models\\Usermlm',	228,	'Personal Access Token',	'88c84689d03a67d3b41e5250b2a329613efa426a46c5c34fbc86704904b61807',	'[\"*\"]',	NULL,	NULL,	'2024-10-09 23:05:48',	'2024-10-09 23:05:48'),
(29,	'App\\Models\\Usermlm',	228,	'Personal Access Token',	'3153caf0d38d26a5137b297246b42849dd12076c27def9972e9091fab21a268c',	'[\"*\"]',	NULL,	NULL,	'2024-10-09 23:06:21',	'2024-10-09 23:06:21'),
(30,	'App\\Models\\Usermlm',	240,	'Personal Access Token',	'e3bd6458bb298440ce74c756d94909b4d62fa094e63f77a3d07c630fd306ce37',	'[\"*\"]',	NULL,	NULL,	'2024-10-18 08:18:42',	'2024-10-18 08:18:42'),
(31,	'App\\Models\\Usermlm',	240,	'Personal Access Token',	'25a3f3bab73b19819e2ed8bb26f457ee1c98c525a99778fdcc89aaa1b2be1e62',	'[\"*\"]',	NULL,	NULL,	'2024-10-18 08:19:38',	'2024-10-18 08:19:38'),
(32,	'App\\Models\\Usermlm',	240,	'Personal Access Token',	'731917956e0cf554a3480e099607585eec7c15f11fe02f534b0a7da0f5556304',	'[\"*\"]',	NULL,	NULL,	'2024-10-18 08:24:34',	'2024-10-18 08:24:34'),
(33,	'App\\Models\\Usermlm',	240,	'Personal Access Token',	'051a981305c74c1b133b0bc15ce41e2ab508df4cc0c70499e330fb448bd3a6c0',	'[\"*\"]',	NULL,	NULL,	'2024-10-18 23:32:02',	'2024-10-18 23:32:02'),
(34,	'App\\Models\\Usermlm',	240,	'Personal Access Token',	'99a80f426ae728fb636374140e2dec7993c46ce0be61709624db20f3da2d475c',	'[\"*\"]',	NULL,	NULL,	'2024-10-19 00:25:53',	'2024-10-19 00:25:53'),
(35,	'App\\Models\\Usermlm',	240,	'Personal Access Token',	'fdb60beaa3471841569c17f4a3b41e940c43d9d1e206c24bb645a5c93f0c135d',	'[\"*\"]',	NULL,	NULL,	'2024-10-19 00:26:07',	'2024-10-19 00:26:07'),
(36,	'App\\Models\\Usermlm',	240,	'Personal Access Token',	'35504eb301ff10aaab751052f6b07676e8fa892a5a718535022aa32b34a0473c',	'[\"*\"]',	NULL,	NULL,	'2024-10-19 00:31:05',	'2024-10-19 00:31:05');

DROP TABLE IF EXISTS `pins`;
CREATE TABLE `pins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `buyer_id` int NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `generated_by` varchar(255) NOT NULL,
  `used_by` int DEFAULT '0',
  `pin` varchar(255) NOT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `pins` (`id`, `buyer_id`, `created_at`, `generated_by`, `used_by`, `pin`, `updated_at`) VALUES
(1,	85,	'2024-10-27 07:46:10',	'1',	89,	'GGBI1KZR',	'2024-10-27 07:46:10'),
(2,	85,	'2024-10-27 07:46:10',	'1',	102,	'GGBJY2XW',	'2024-10-27 15:05:45'),
(3,	87,	'2024-10-27 08:02:38',	'1',	99,	'GGB9MVTF',	'2024-10-27 15:14:43'),
(4,	87,	'2024-10-27 08:02:38',	'1',	0,	'GGBWQOVX',	'2024-10-27 13:58:27'),
(5,	87,	'2024-10-27 08:02:38',	'1',	0,	'GGBBB0NO',	'2024-10-27 13:58:27'),
(6,	87,	'2024-10-27 08:02:48',	'1',	0,	'GGBVEULR',	'2024-10-27 13:58:27'),
(7,	87,	'2024-10-27 08:02:48',	'1',	0,	'GGBWBWMO',	'2024-10-27 13:58:27'),
(8,	87,	'2024-10-27 08:02:48',	'1',	0,	'GGB9NTLL',	'2024-10-27 13:58:27'),
(9,	88,	'2024-10-27 08:06:22',	'1',	0,	'GGB4FZAL',	'2024-10-27 13:58:27'),
(10,	88,	'2024-10-27 08:06:22',	'1',	0,	'GGBPNXXM',	'2024-10-27 13:58:27'),
(11,	88,	'2024-10-27 08:06:22',	'1',	0,	'GGBKHCQ4',	'2024-10-27 13:58:27'),
(12,	89,	'2024-10-27 08:43:18',	'1',	0,	'GGBIQ4BA',	'2024-10-27 08:43:18'),
(13,	89,	'2024-10-27 08:43:18',	'1',	0,	'GGBN5YWZ',	'2024-10-27 08:43:18'),
(14,	89,	'2024-10-27 08:43:18',	'1',	0,	'GGB63B7G',	'2024-10-27 08:43:18'),
(15,	100,	'2024-10-27 09:23:58',	'1',	0,	'GGBEFGJH',	'2024-10-27 09:23:58'),
(16,	100,	'2024-10-27 09:23:58',	'1',	100,	'GGBNG8VX',	'2024-10-27 14:54:56'),
(17,	100,	'2024-10-27 09:23:58',	'1',	0,	'GGBAO1IT',	'2024-10-27 09:23:58'),
(18,	100,	'2024-10-27 09:23:58',	'1',	0,	'GGBWAIK8',	'2024-10-27 09:23:58'),
(19,	100,	'2024-10-27 09:23:58',	'1',	0,	'GGBZQUWB',	'2024-10-27 09:23:58'),
(20,	101,	'2024-10-27 09:26:22',	'1',	0,	'GGB7BJK6',	'2024-10-27 09:26:22'),
(21,	101,	'2024-10-27 09:26:22',	'1',	101,	'GGBHHN5R',	'2024-10-27 14:56:53'),
(22,	101,	'2024-10-27 09:26:22',	'1',	0,	'GGBRQDIF',	'2024-10-27 09:26:22'),
(23,	101,	'2024-10-27 09:26:22',	'1',	0,	'GGBUIMIL',	'2024-10-27 09:26:22'),
(24,	101,	'2024-10-27 09:26:22',	'1',	0,	'GGBLFAVP',	'2024-10-27 09:26:22'),
(25,	101,	'2024-10-27 10:09:33',	'1',	0,	'GGBZNSDJ',	'2024-10-27 10:09:33'),
(26,	101,	'2024-10-27 10:09:33',	'1',	0,	'GGBOBOOA',	'2024-10-27 10:09:33'),
(27,	101,	'2024-10-27 10:09:33',	'1',	0,	'GGB2VXJC',	'2024-10-27 10:09:33'),
(28,	101,	'2024-10-27 10:09:33',	'1',	0,	'GGBD9L0G',	'2024-10-27 10:09:33'),
(29,	101,	'2024-10-27 10:09:33',	'1',	0,	'GGBXBB4B',	'2024-10-27 10:09:33'),
(30,	1011,	'2024-10-27 10:09:42',	'1',	0,	'GGB90BC3',	'2024-10-27 10:09:42'),
(31,	1011,	'2024-10-27 10:09:42',	'1',	0,	'GGBICET8',	'2024-10-27 10:09:42'),
(32,	1011,	'2024-10-27 10:09:42',	'1',	0,	'GGBYGLYT',	'2024-10-27 10:09:42'),
(33,	1011,	'2024-10-27 10:09:42',	'1',	0,	'GGBRDLNP',	'2024-10-27 10:09:42'),
(34,	1011,	'2024-10-27 10:09:42',	'1',	0,	'GGB3WGKO',	'2024-10-27 10:09:42'),
(35,	90,	'2024-10-27 10:13:35',	'1',	0,	'GGB7I3RQ',	'2024-10-27 10:13:35'),
(36,	90,	'2024-10-27 10:13:35',	'1',	0,	'GGBNEVO8',	'2024-10-27 10:13:35'),
(37,	90,	'2024-10-27 10:13:35',	'1',	0,	'GGBQGCDC',	'2024-10-27 10:13:35'),
(38,	90,	'2024-10-27 10:13:35',	'1',	0,	'GGBYEE9O',	'2024-10-27 10:13:35'),
(39,	90,	'2024-10-27 10:13:35',	'1',	0,	'GGBLZGRM',	'2024-10-27 10:13:35');

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `amount` int NOT NULL,
  `type` varchar(250) DEFAULT NULL,
  `status` varchar(150) DEFAULT NULL,
  `paid_by` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `user_accounts`;
CREATE TABLE `user_accounts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(150) DEFAULT NULL,
  `account_name` varchar(150) DEFAULT NULL,
  `account_no` varchar(80) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `default` tinyint DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `usermlms`;
CREATE TABLE `usermlms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `child_left` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `child_right` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `last_left` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `last_right` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `level` int DEFAULT NULL,
  `paid_level` int DEFAULT NULL,
  `self_code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_gl_0900_ai_ci DEFAULT NULL,
  `mobile` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(222) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `whatsapp` varchar(100) DEFAULT NULL,
  `pan` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `adhar` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `relation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `relation_name` varchar(222) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `gender` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `used_code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_gl_0900_ai_ci DEFAULT NULL,
  `dob` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `referral_code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `parent_code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_gl_0900_ai_ci DEFAULT NULL,
  `role` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_gl_0900_ai_ci DEFAULT '1',
  `side` tinyint DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `plain_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `api_token` varchar(1255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `added_below` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `user_id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `usermlms` (`id`, `child_left`, `child_right`, `last_left`, `last_right`, `name`, `level`, `paid_level`, `self_code`, `mobile`, `email`, `whatsapp`, `pan`, `adhar`, `relation`, `relation_name`, `gender`, `used_code`, `dob`, `referral_code`, `parent_code`, `role`, `side`, `status`, `password`, `plain_password`, `api_token`, `added_below`, `created_at`, `updated_at`) VALUES
(1,	'',	'',	'',	'',	'Admin',	3,	NULL,	'',	'7985003120',	'admin@gmail.com',	'',	'',	'',	'',	'',	'Male',	'',	'31/10/1989',	NULL,	'0',	'2',	0,	1,	'admin@123',	NULL,	NULL,	NULL,	'2024-10-27 07:55:20',	'2024-10-27 07:55:20'),
(85,	'86',	'87',	'100',	'99',	'Root',	3,	NULL,	'GGB852024',	'8800318153',	'onlinenavifinance5@gmail.com',	'45111135',	'67568687',	'345345',	'W/O',	'root',	'Male',	'0',	'31/10/1989',	NULL,	'0',	'1',	0,	1,	'password@123',	NULL,	NULL,	NULL,	'2024-10-27 07:54:58',	'2024-10-27 07:54:58'),
(86,	'88',	'89',	'100',	'95',	'Avinash Maurya',	2,	NULL,	'GGB862024',	'8800318151',	'onlinenavifinance5@gmail.com',	'45111135',	'67568687',	'345345',	'W/O',	'Rahul',	'Male',	'85',	'31/10/1989',	NULL,	'85',	'1',	1,	1,	'password@123',	NULL,	NULL,	NULL,	'2024-10-27 07:54:58',	'2024-10-27 07:54:58'),
(87,	'90',	'91',	'96',	'99',	'Avinash Maurya',	2,	NULL,	'GGB872024',	'8800318152',	'onlinenavifinance5@gmail.com',	'45111135',	'67568687',	'345345',	'W/O',	'Rahul',	'Male',	'85',	'31/10/1989',	NULL,	'85',	'1',	2,	1,	'password@123',	NULL,	NULL,	NULL,	'2024-10-27 07:54:58',	'2024-10-27 07:54:58'),
(88,	'92',	'93',	'100',	'93',	'Avinash Maurya',	1,	NULL,	'GGB882024',	'8800318154',	'onlinenavifinance5@gmail.com',	'45111135',	'67568687',	'345345',	'W/O',	'Rahul',	'Male',	'85',	'31/10/1989',	NULL,	'86',	'1',	1,	1,	'password@123',	NULL,	NULL,	NULL,	'2024-10-27 07:54:58',	'2024-10-27 07:54:58'),
(89,	'94',	'95',	'94',	'95',	'Avinash Maurya',	1,	NULL,	'GGB892024',	'8800318155',	'onlinenavifinance5@gmail.com',	'45111135',	'67568687',	'345345',	'W/O',	'Rahul',	'Male',	'85',	'31/10/1989',	NULL,	'86',	'1',	2,	1,	'password@123',	NULL,	NULL,	NULL,	'2024-10-27 07:54:58',	'2024-10-27 07:54:58'),
(90,	'96',	'97',	'96',	'97',	'Avinash Maurya',	1,	NULL,	'GGB902024',	'8800318156',	'onlinenavifinance5@gmail.com',	'45111135',	'67568687',	'345345',	'W/O',	'Rahul',	'Male',	'85',	'31/10/1989',	NULL,	'87',	'1',	1,	1,	'password@123',	NULL,	NULL,	NULL,	'2024-10-27 07:54:58',	'2024-10-27 07:54:58'),
(91,	'98',	'99',	'98',	'99',	'Avinash Maurya',	1,	NULL,	'GGB912024',	'8800318157',	'onlinenavifinance5@gmail.com',	'45111135',	'67568687',	'345345',	'W/O',	'Rahul',	'Male',	'85',	'31/10/1989',	NULL,	'87',	'1',	2,	1,	'password@123',	NULL,	NULL,	NULL,	'2024-10-27 07:54:58',	'2024-10-27 07:54:58'),
(92,	'100',	'101',	'100',	'101',	'Avinash Maurya',	0,	NULL,	'GGB922024',	'8800318123',	'onlinenavifinance5@gmail.com',	'45111135',	'67568687',	'345345',	'W/O',	'Rahul',	'Male',	'85',	'31/10/1989',	NULL,	'88',	'1',	1,	1,	'password@123',	NULL,	NULL,	NULL,	'2024-10-27 07:54:58',	'2024-10-27 07:54:58'),
(93,	'102',	NULL,	'102',	NULL,	'Avinash Maurya',	0,	NULL,	'GGB932024',	'8800318133',	'onlinenavifinance5@gmail.com',	'45111135',	'67568687',	'345345',	'W/O',	'Rahul',	'Male',	'85',	'31/10/1989',	NULL,	'88',	'1',	2,	1,	'password@123',	NULL,	NULL,	NULL,	'2024-10-27 07:54:58',	'2024-10-27 07:54:58'),
(94,	NULL,	NULL,	NULL,	NULL,	'Avinash Maurya',	0,	NULL,	'GGB942024',	'8800318143',	'onlinenavifinance5@gmail.com',	'45111135',	'67568687',	'345345',	'W/O',	'Rahul',	'Male',	'85',	'31/10/1989',	NULL,	'89',	'1',	1,	1,	'password@123',	NULL,	NULL,	NULL,	'2024-10-27 07:54:58',	'2024-10-27 07:54:58'),
(95,	NULL,	NULL,	NULL,	NULL,	'Avinash Maurya',	0,	NULL,	'GGB952024',	'8800318163',	'onlinenavifinance5@gmail.com',	'45111135',	'67568687',	'345345',	'W/O',	'Rahul',	'Male',	'85',	'31/10/1989',	NULL,	'89',	'1',	2,	1,	'password@123',	NULL,	NULL,	NULL,	'2024-10-27 07:54:58',	'2024-10-27 07:54:58'),
(96,	NULL,	NULL,	NULL,	NULL,	'Avinash Maurya',	0,	NULL,	'GGB962024',	'8800318173',	'onlinenavifinance5@gmail.com',	'45111135',	'67568687',	'345345',	'W/O',	'Rahul',	'Male',	'85',	'31/10/1989',	NULL,	'90',	'1',	1,	1,	'password@123',	NULL,	NULL,	NULL,	'2024-10-27 07:54:58',	'2024-10-27 07:54:58'),
(97,	NULL,	NULL,	NULL,	NULL,	'Avinash Maurya',	0,	NULL,	'GGB972024',	'8800318183',	'onlinenavifinance5@gmail.com',	'45111135',	'67568687',	'345345',	'W/O',	'Rahul',	'Male',	'85',	'31/10/1989',	NULL,	'90',	'1',	2,	1,	'password@123',	NULL,	NULL,	NULL,	'2024-10-27 07:54:58',	'2024-10-27 07:54:58'),
(98,	NULL,	NULL,	NULL,	NULL,	'Avinash Maurya',	0,	NULL,	'GGB982024',	'8800318193',	'onlinenavifinance5@gmail.com',	'45111135',	'67568687',	'345345',	'W/O',	'Rahul',	'Male',	'85',	'31/10/1989',	NULL,	'91',	'1',	1,	1,	'password@123',	NULL,	NULL,	NULL,	'2024-10-27 07:54:58',	'2024-10-27 07:54:58'),
(99,	NULL,	NULL,	NULL,	NULL,	'Avinash Maurya',	0,	NULL,	'GGB992024',	'8800318194',	'onlinenavifinance5@gmail.com',	'45111135',	'67568687',	'345345',	'W/O',	'Rahul',	'Male',	'85',	'31/10/1989',	NULL,	'91',	'1',	2,	1,	'password@123',	NULL,	NULL,	NULL,	'2024-10-27 07:54:58',	'2024-10-27 07:54:58'),
(100,	NULL,	NULL,	NULL,	NULL,	'Avinash Maurya',	0,	NULL,	'GGB1002024',	'8800318195',	'onlinenavifinance5@gmail.com',	'45111135',	'67568687',	'345345',	'W/O',	'Rahul',	'Male',	'85',	'31/10/1989',	NULL,	'92',	'1',	1,	1,	'password@123',	NULL,	NULL,	NULL,	'2024-10-27 07:54:58',	'2024-10-27 07:54:58'),
(101,	NULL,	NULL,	NULL,	NULL,	'Avinash Maurya',	0,	NULL,	'GGB1012024',	'8800408190',	'onlinenavifinance5@gmail.com',	'45111135',	'67568687',	'345345',	'W/O',	'Rahul',	'Male',	'85',	'31/10/1989',	NULL,	'92',	'1',	2,	0,	'$2y$12$YCDkTn.7AC.S2jUOR8OmI.Jb9eQV/37U9rbe/VQ8zKIJCZ6XyC8ju',	'password@123',	NULL,	NULL,	'2024-10-27 07:54:58',	'2024-10-27 07:54:58'),
(102,	NULL,	NULL,	NULL,	NULL,	'Avinash Maurya',	0,	NULL,	'GGB1022024',	'8800408191',	'onlinenavifinance5@gmail.com',	'45111135',	'67568687',	'345345',	'W/O',	'Rahul',	'Male',	'85',	'31/10/1989',	NULL,	'93',	'1',	1,	0,	'password@123',	'password@123',	NULL,	NULL,	'2024-10-27 07:54:58',	'2024-10-27 07:54:58');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `referrer` varchar(255) DEFAULT NULL,
  `parent_id` int DEFAULT NULL,
  `sponsor_id` varchar(255) DEFAULT NULL,
  `direct_downlines` int DEFAULT '0',
  `level` int DEFAULT '0',
  `two` int DEFAULT '0',
  `three` int DEFAULT '0',
  `four` int DEFAULT '0',
  `five` int DEFAULT '0',
  `six` int DEFAULT '0',
  `password` varchar(255) NOT NULL,
  `password1` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `avartar` varchar(250) DEFAULT NULL,
  `role` varchar(150) DEFAULT 'user',
  `activated` varchar(150) DEFAULT 'no',
  `activated_at` datetime DEFAULT NULL,
  `activated_by` int DEFAULT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `remember_token` varchar(150) DEFAULT NULL,
  `address` text,
  `country` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `code` varchar(1255) DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `users` (`id`, `name`, `email`, `username`, `phone`, `referrer`, `parent_id`, `sponsor_id`, `direct_downlines`, `level`, `two`, `three`, `four`, `five`, `six`, `password`, `password1`, `avartar`, `role`, `activated`, `activated_at`, `activated_by`, `email_verified_at`, `remember_token`, `address`, `country`, `state`, `code`, `deleted`, `created_at`, `updated_at`) VALUES
(1,	'avinash',	'akmaur31@gmail.com',	'avi31',	'4562345345',	'root',	0,	'',	0,	0,	0,	0,	0,	0,	0,	'',	'',	NULL,	'user',	'no',	NULL,	NULL,	'2024-10-02 13:19:31',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2024-10-02 02:18:12',	'2024-10-02 02:18:12'),
(2,	'Avinash',	'user@tutorialvilla.com',	'avinashee',	'8800388752',	'admin',	NULL,	NULL,	0,	0,	0,	0,	0,	0,	0,	'$2y$12$PpfA2Se4d6K4EMiHYmjNYOqCD6/NAcW9MUof07ryGaIlXXyRm9jme',	'',	NULL,	'user',	'no',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2024-10-01 21:21:15',	'2024-10-01 21:21:15'),
(3,	'Avinash',	'user@tutorialvilla1.com',	'avinashee1',	'234123412',	'admin',	NULL,	NULL,	0,	0,	0,	0,	0,	0,	0,	'$2y$12$Qxqm1EBgl/iiK7ED2OPZjuA4FpjmUsnQQqcpVhnm8Kv3fHv9o96Ki',	'12345678',	NULL,	'user',	'no',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2024-10-01 21:27:25',	'2024-10-01 21:27:25');

DROP TABLE IF EXISTS `users_tree`;
CREATE TABLE `users_tree` (
  `ancestor` int unsigned NOT NULL,
  `descendant` int unsigned NOT NULL,
  `depth` int NOT NULL,
  PRIMARY KEY (`ancestor`,`descendant`),
  KEY `descendant` (`descendant`),
  CONSTRAINT `tree_hierarchy_ibfk_1` FOREIGN KEY (`ancestor`) REFERENCES `users` (`id`),
  CONSTRAINT `tree_hierarchy_ibfk_2` FOREIGN KEY (`descendant`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `wallets`;
CREATE TABLE `wallets` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `amount` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


-- 2024-10-27 10:18:30
