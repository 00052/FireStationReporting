CREATE TABLE `station_stg` (
	`_id` int(11) NOT NULL AUTO_INCREMENT,
	`user_ID` int(11) NOT NULL,
	`date` date NOT NULL,
	`officer` tinyint(2) NOT NULL,
	`soldier` tinyint(2) NOT NULL,
	`employee` tinyint(2) NOT NULL,
	`fireengine` tinyint(2) NOT NULL,
	`driver` tinyint(2) NOT NULL,
  	PRIMARY KEY (`_id`),
	FOREIGN KEY(`user_ID`) REFERENCES `users` (`_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `small_station_stg` (
	`_id` int(11) NOT NULL AUTO_INCREMENT,
	`user_ID` int(11) NOT NULL,
	`onduty` tinyint(2) NOT NULL,
	`driver` tinyint(2) NOT NULL,
	`vehicle` tinyint(2) NOT NULL,
	`vehicle_inuse` tinyint(2) NOT NULL,
	`vehicle_condition` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
	`equipment_condition` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  	PRIMARY KEY (`_id`),
	FOREIGN KEY(`user_ID`) REFERENCES `users` (`_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8  COLLATE=utf8_unicode_ci;


CREATE TABLE `officers` (
	`_id` int(11) NOT NULL AUTO_INCREMENT,
	`department` tinyint(1) NOT NULL CHECK(department>=0 and department <=3),
	`name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
	`duty` tinyint(1) NOT NULL,
  	PRIMARY KEY (`_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8  COLLATE=utf8_unicode_ci;

CREATE TABLE `rota` (
	`_id` int(11) NOT NULL AUTO_INCREMENT,
	`date` date NOT NULL,
	`dbsz_id` int(11) NOT NULL,
	`zbld_id` int(11) NOT NULL,
	`zhz_id` int(11) NOT NULL,
	`zhzl_id` int(11) NOT NULL,
	`xzzb_id` int(11) NOT NULL,
	`zhc_id` int(11) NOT NULL,
  	PRIMARY KEY (`_id`),
	FOREIGN KEY(`dbsz_id`) REFERENCES `officers` (`_id`),
	FOREIGN KEY(`zbld_id`) REFERENCES `officers` (`_id`),
	FOREIGN KEY(`zhz_id`) REFERENCES `officers` (`_id`),
	FOREIGN KEY(`zhzl_id`) REFERENCES `officers` (`_id`),
	FOREIGN KEY(`xzzb_id`) REFERENCES `officers` (`_id`),
	FOREIGN KEY(`zhc_id`) REFERENCES `officers` (`_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8  COLLATE=utf8_unicode_ci;
