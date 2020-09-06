--
-- Table structure for table `allies`
--

DROP TABLE IF EXISTS `allies`;
CREATE TABLE IF NOT EXISTS `allies` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `allyname` varchar(225) NOT NULL,
  `value` varchar(255) NOT NULL,
  `owner` varchar(225) NOT NULL,
  `clan` varchar(3) NOT NULL DEFAULT 'XXX',
  `time_added` datetime DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  `server` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pins`
--

DROP TABLE IF EXISTS `pins`;
CREATE TABLE IF NOT EXISTS `pins` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `clan` varchar(225) NOT NULL,
  `X` varchar(255) NOT NULL,
  `Y` varchar(225) NOT NULL,
  `realm` int(12) NOT NULL DEFAULT 0,
  `server` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;
COMMIT;
