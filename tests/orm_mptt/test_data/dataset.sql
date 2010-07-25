DROP TABLE IF EXISTS `test_orm_mptt`;
CREATE TABLE IF NOT EXISTS `test_orm_mptt` (
  `id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `lft` int(255) unsigned NOT NULL,
  `rgt` int(255) unsigned NOT NULL,
  `lvl` int(255) unsigned NOT NULL,
  `scope` int(255) unsigned NOT NULL,
  `path` varchar(255) DEFAULT NULL,
  `path_part` varchar(255) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;