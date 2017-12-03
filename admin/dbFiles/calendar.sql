--
-- Test calendar database table
--
CREATE TABLE IF NOT EXISTS `calendar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,  
  `date` date DEFAULT NULL,
  `time` time NOT NULL,
	`event` varchar(100),
	`location` varchar(100),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;


INSERT INTO `calendar` (`id`, `date`, `time`, `event`, `location`) VALUES
(1, '2017-12-09', '12:00:00', 'Graduation', 'Athens, AL');