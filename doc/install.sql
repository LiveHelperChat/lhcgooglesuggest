CREATE TABLE `lhc_googlesugest_item` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `field` varchar(250) NOT NULL,
  `configuration` text NOT NULL,
  `identifier` varchar(20) NOT NULL,
  `search_id` varchar(250) NOT NULL,
  `referrer` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `identifier` (`identifier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;