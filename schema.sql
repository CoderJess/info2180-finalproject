DROP DATABASE IF EXISTS dolphin_crm;
CREATE DATABASE dolphin_crm;
USE dolphin_crm;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `firstname` varchar(35) NOT NULL default '',
  `lastname` varchar(35) NOT NULL default '',
  `password` varchar(20) NOT NULL default '',
  `email` varchar(35) NOT NULL default '',
  `role` varchar(35) NOT NULL default '',
  `created_at` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4080 DEFAULT CHARSET=utf8mb4;

LOCK TABLES `users` WRITE;

INSERT INTO `users` VALUES (1,'John','Doe','password123','admin@project2.com', 'admin', '2024-11-25 16:18:00'),
(2, 'Jack', 'Daniels', 'jdaniels2', 'jdaniels@project2.com', 'user', '2024-11-26 17:19:00'),
(3, 'Cat', 'Valentine', 'catvalentine3', 'catvalentine@project2.com', 'user', '2024-11-27 17:00:00'),
(4, 'Blade', 'Daywalker', 'bladedaywalker4', 'bladedaywalker@project2.com', 'user', '2024-11-29 13:00:00'),
(5, 'Black', 'Widow', 'backwidow5', 'blackwidow@project2.com', 'user', '2024-11-29 19:00:00');
UNLOCK TABLES;

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts` (
  `id` int(11) NOT NULL auto_increment,
  `title` char(35) NOT NULL default '',
  `firstname` char(35) NOT NULL default '',
  `lastname` char(35) NOT NULL default '',
  `email` char(20) NOT NULL default '',
  `telephone` char(12) NOT NULL default '',
  `company` char(35) NOT NULL default '',
  `type` char(20) NOT NULL default '',
  `assigned_to` int(11) NOT NULL default 0,
  `created_by` int(11) NOT NULL default 0,
  `craated_at` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `updated_at` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4080 DEFAULT CHARSET=utf8mb4;

LOCK TABLES `contacts` WRITE;

INSERT INTO `contacts` VALUES (1, 'Ms', 'Wonder', 'Woman', 'wonderwoman@project2.com', '876-111-1111', 'Jet Green', 'Support', 1, 1, '2024-11-25 16:18:00', '2024-11-25 16:21:00'),
(2, 'Mr', 'Tony', 'Stark', 'tonystark@project2.com', '876-000-0000', 'Avengers', 'Sales Lead', 2, 2, '2024-12-01 16:18:00', '2024-12-01 16:21:00'),
(3, 'Ms', 'Gwen', 'Stacy', 'gwenstacy@project2.com', '876-222-2222', 'Oscorp', 'Sales Lead', 3, 3, '2024-12-01 16:18:00', '2024-11-25 16:21:00'),
(4, 'Mr', 'Peter', 'Parker', 'peterparker@project2.com', '876-444-4444', 'Oscorp', 'Support', 4, 4, '2024-12-01 16:18:00', '2024-11-25 16:21:00'),
(5, 'Ms', 'Clary', 'Fray', 'claryfray@project2.com', '876-555-5555', 'Cars Automotive', 'Support', 5, 5, '2024-12-01 16:18:00', '2024-11-25 16:21:00');
UNLOCK TABLES;

DROP TABLE IF EXISTS `notes`;

DROP TABLE IF EXISTS `notes`;
CREATE TABLE `notes` (
  `id` int(11) NOT NULL auto_increment,
  `contact_id` int(11) NOT NULL default 0,
  `comment` text(500) NOT NULL default '',
  `created-by` int(11) NOT NULL default 0,
  `created_at` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4080 DEFAULT CHARSET=utf8mb4;

LOCK TABLES `notes` WRITE;

INSERT INTO `notes` VALUES (1, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 1, '2024-11-25 16:21:00'),
(2, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 2, '2024-11-25 16:21:00');
UNLOCK TABLES;

