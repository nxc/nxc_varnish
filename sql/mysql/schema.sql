DROP TABLE IF EXISTS `nxc_varnish_logs`;
CREATE TABLE `nxc_varnish_logs` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `is_completed` tinyint(1) unsigned NOT NULL default 0,
  `date` int(11) unsigned NOT NULL,
  `server` varchar(255) default NULL,
  `request` mediumtext default NULL,
  `response` mediumtext default NULL,
  `duration` float(11,6) default NULL,
  `backtrace` text default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
