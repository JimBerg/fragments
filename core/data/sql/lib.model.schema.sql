
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- Destination
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `Destination`;


CREATE TABLE `Destination`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`location_id` INTEGER,
	`location_name` VARCHAR(256),
	`region` VARCHAR(256),
	`geolocation` VARCHAR(64),
	`area` VARCHAR(64),
	`elevation` VARCHAR(64),
	`population` VARCHAR(64),
	`infotext` TEXT,
	`population_density` VARCHAR(64),
	`airport_name` VARCHAR(256),
	`airport_abbr` VARCHAR(16),
	`airport_type` VARCHAR(128),
	`timezone` VARCHAR(64),
	PRIMARY KEY (`id`)
) ENGINE=InnoDB;

#-----------------------------------------------------------------------------
#-- Flight
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `Flight`;


CREATE TABLE `Flight`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`User_id` INTEGER  NOT NULL,
	`Friend_id` INTEGER,
	`start_location_id` INTEGER  NOT NULL,
	`target_location_id` INTEGER  NOT NULL,
	`flight_type` VARCHAR(64) COMMENT 'freund der angeflogen wird',
	`flight_start` DATETIME,
	`flight_end` DATETIME,
	`flight_duration` INTEGER COMMENT 'in sekunden... kann man dann immer noch umrechnen?',
	`flight_accepted` VARCHAR(32),
	`landing_notification` TINYINT,
	PRIMARY KEY (`id`),
	KEY `fk_Flight_User1`(`User_id`),
	KEY `fk_Flight_Friend1`(`Friend_id`),
	KEY `fk_Flight_Location1`(`start_location_id`),
	KEY `fk_Flight_Location2`(`target_location_id`),
	CONSTRAINT `Flight_FK_1`
		FOREIGN KEY (`User_id`)
		REFERENCES `User` (`id`),
	CONSTRAINT `Flight_FK_2`
		FOREIGN KEY (`Friend_id`)
		REFERENCES `Friend` (`id`),
	CONSTRAINT `Flight_FK_3`
		FOREIGN KEY (`start_location_id`)
		REFERENCES `Location` (`id`),
	CONSTRAINT `Flight_FK_4`
		FOREIGN KEY (`target_location_id`)
		REFERENCES `Location` (`id`)
) ENGINE=InnoDB;

#-----------------------------------------------------------------------------
#-- Friend
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `Friend`;


CREATE TABLE `Friend`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`fb_id` VARCHAR(64),
	`name` VARCHAR(64),
	`is_invited` TINYINT,
	`Location_id` INTEGER  NOT NULL,
	PRIMARY KEY (`id`),
	KEY `fk_Friend_Location1`(`Location_id`),
	CONSTRAINT `Friend_FK_1`
		FOREIGN KEY (`Location_id`)
		REFERENCES `Location` (`id`)
) ENGINE=InnoDB;

#-----------------------------------------------------------------------------
#-- Friendlist
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `Friendlist`;


CREATE TABLE `Friendlist`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`User_id` INTEGER  NOT NULL,
	PRIMARY KEY (`id`),
	KEY `fk_Friendlist_User1`(`User_id`),
	CONSTRAINT `Friendlist_FK_1`
		FOREIGN KEY (`User_id`)
		REFERENCES `User` (`id`)
) ENGINE=InnoDB;

#-----------------------------------------------------------------------------
#-- Friendrelation
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `Friendrelation`;


CREATE TABLE `Friendrelation`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`Friend_id` INTEGER  NOT NULL,
	`Friendlist_id` INTEGER  NOT NULL,
	PRIMARY KEY (`id`),
	KEY `fk_FriendRelation_Friend1`(`Friend_id`),
	KEY `fk_FriendRelation_Friendlist1`(`Friendlist_id`),
	CONSTRAINT `Friendrelation_FK_1`
		FOREIGN KEY (`Friend_id`)
		REFERENCES `Friend` (`id`),
	CONSTRAINT `Friendrelation_FK_2`
		FOREIGN KEY (`Friendlist_id`)
		REFERENCES `Friendlist` (`id`)
) ENGINE=InnoDB;

#-----------------------------------------------------------------------------
#-- Location
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `Location`;


CREATE TABLE `Location`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`location_name` VARCHAR(256),
	`lat` FLOAT,
	`lng` FLOAT,
	`country` VARCHAR(128),
	`timezone` VARCHAR(128),
	`swiss_destination` TINYINT,
	`foreign_destination` TINYINT,
	`nearest_destination` VARCHAR(128),
	PRIMARY KEY (`id`),
	KEY `location_name`(`location_name`)
) ENGINE=InnoDB;

#-----------------------------------------------------------------------------
#-- Pictures
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `Pictures`;


CREATE TABLE `Pictures`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`Destination_id` INTEGER  NOT NULL,
	`title` VARCHAR(128),
	`path` VARCHAR(256),
	`link` VARCHAR(128),
	`author` VARCHAR(64),
	PRIMARY KEY (`id`),
	KEY `fk_Pictures_Destination1`(`Destination_id`),
	CONSTRAINT `Pictures_FK_1`
		FOREIGN KEY (`Destination_id`)
		REFERENCES `Destination` (`id`)
) ENGINE=InnoDB;

#-----------------------------------------------------------------------------
#-- Playerstatus
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `Playerstatus`;


CREATE TABLE `Playerstatus`
(
	`User_id` INTEGER  NOT NULL,
	`on_flight` TINYINT,
	`points` VARCHAR(32),
	`bonus` INTEGER,
	`flight_points` INTEGER,
	`available_miles` INTEGER COMMENT 'verfügbare Meilen',
	`flightmiles_total` INTEGER COMMENT 'Flugmeilen',
	`flightmiles_week` INTEGER COMMENT 'Flugmeilen',
	`flight_count` INTEGER COMMENT 'Anzahl der Flüge',
	`homebase_flight` INTEGER,
	`player_rank` VARCHAR(128) COMMENT 'Rangname',
	`week1` INTEGER,
	`week2` INTEGER,
	`week3` INTEGER,
	`week4` INTEGER,
	`week5` INTEGER,
	`week6` INTEGER,
	`week7` INTEGER,
	`week8` INTEGER,
	PRIMARY KEY (`User_id`),
	KEY `fk_PlayerStatus_User`(`User_id`),
	CONSTRAINT `Playerstatus_FK_1`
		FOREIGN KEY (`User_id`)
		REFERENCES `User` (`id`)
) ENGINE=InnoDB;

#-----------------------------------------------------------------------------
#-- User
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `User`;


CREATE TABLE `User`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`fb_id` VARCHAR(64),
	`access_token` VARCHAR(256),
	`is_fan` TINYINT,
	`firstname` VARCHAR(256),
	`lastname` VARCHAR(256),
	`email` VARCHAR(256),
	`locale` VARCHAR(64),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`inactive_notification` TINYINT,
	`weekly_notification` TINYINT,
	`Location_id` INTEGER  NOT NULL,
	PRIMARY KEY (`id`),
	KEY `fk_User_Location1`(`Location_id`),
	CONSTRAINT `User_FK_1`
		FOREIGN KEY (`Location_id`)
		REFERENCES `Location` (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
