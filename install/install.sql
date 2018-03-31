DROP TABLE IF EXISTS `log`;
DROP TABLE IF EXISTS `lostpw`;
DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` text COLLATE utf8_unicode_ci,
  `admin` varchar(1) COLLATE utf8_unicode_ci DEFAULT '0',
  `design` varchar(45) COLLATE utf8_unicode_ci DEFAULT 'dynamic',
  `last_login` int(11) DEFAULT NULL,
  `lang` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nickname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `log` (
  `_id` int(11) NOT NULL AUTO_INCREMENT,
  `errlevel` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `errmsg` text COLLATE utf8_unicode_ci NOT NULL,
  `file` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `line` smallint(6) NOT NULL,
  `sender` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `counter` int(11) unsigned DEFAULT NULL,
  `log` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `lostpw` (
  `_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_ID` int(11) NOT NULL,
  `hash` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`_id`,`user_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `sessions` (
  `sid` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `browser` text COLLATE utf8_unicode_ci,
  `lastactivity` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT '0',
  `data` text COLLATE utf8_unicode_ci,
  UNIQUE KEY `sid_UNIQUE` (`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
