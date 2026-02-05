CREATE TABLE IF NOT EXISTS `geopos_business_health` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `score` int(11) NOT NULL DEFAULT 85,
  PRIMARY KEY (`id`),
  UNIQUE KEY `date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
