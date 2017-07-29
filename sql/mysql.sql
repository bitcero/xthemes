CREATE TABLE `xt_menus` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `theme` int(11) NOT NULL,
  `menu` varchar(100) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id_menu`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `xt_options` (
  `id_config` int(11) NOT NULL AUTO_INCREMENT,
  `theme` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `value` text NOT NULL,
  `type` varchar(5) NOT NULL,
  PRIMARY KEY (`id_config`),
  KEY `theme` (`theme`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `xt_themes` (
  `id_theme` int(11) NOT NULL AUTO_INCREMENT,
  `dir` varchar(100) NOT NULL,
  `date` int(10) NOT NULL,
  PRIMARY KEY (`id_theme`),
  KEY `dir` (`dir`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
