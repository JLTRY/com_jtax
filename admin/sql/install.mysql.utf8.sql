SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `#__jtax_impot` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`asset_id` INT(10) unsigned NULL DEFAULT 0 COMMENT 'FK to the #__assets table.',
	`deduction` TINYINT(1) NOT NULL DEFAULT 1,
	`dons` INT(64) NOT NULL DEFAULT 0,
	`fraisreels` INT(64) NOT NULL DEFAULT 0,
	`name` VARCHAR(255) NULL DEFAULT '',
	`nbparts` FLOAT(7) NOT NULL DEFAULT 1,
	`pel` INT(64) NOT NULL DEFAULT 0,
	`revenu` INT(64) NOT NULL DEFAULT 0,
	`year` INT(64) NOT NULL DEFAULT 0,
	`params` TEXT NULL,
	`published` TINYINT(3) NULL DEFAULT 1,
	`created_by` INT unsigned NULL,
	`modified_by` INT unsigned,
	`created` DATETIME DEFAULT CURRENT_TIMESTAMP,
	`modified` DATETIME,
	`checked_out` int unsigned,
	`checked_out_time` DATETIME,
	`version` INT(10) unsigned NULL DEFAULT 1,
	`hits` INT(10) unsigned NULL DEFAULT 0,
	`access` INT(10) unsigned NULL DEFAULT 0,
	`ordering` INT(11) NULL DEFAULT 0,
	PRIMARY KEY  (`id`),
	KEY `idx_name` (`name`),
	KEY `idx_year` (`year`),
	KEY `idx_access` (`access`),
	KEY `idx_checkout` (`checked_out`),
	KEY `idx_createdby` (`created_by`),
	KEY `idx_modifiedby` (`modified_by`),
	KEY `idx_state` (`published`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS `#__jtax_year` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`asset_id` INT(10) unsigned NULL DEFAULT 0 COMMENT 'FK to the #__assets table.',
	`name` VARCHAR(255) NULL DEFAULT '',
	`taux1` FLOAT(7) NOT NULL DEFAULT 0,
	`taux2` FLOAT(7) NOT NULL DEFAULT 0,
	`taux3` FLOAT(7) NOT NULL DEFAULT 0,
	`taux4` FLOAT(7) NOT NULL DEFAULT 0,
	`tranche1` INT(64) NOT NULL DEFAULT 0,
	`tranche2` INT(64) NOT NULL DEFAULT 0,
	`tranche3` INT(64) NOT NULL DEFAULT 0,
	`tranche4` INT(64) NOT NULL DEFAULT 0,
	`params` TEXT NULL,
	`published` TINYINT(3) NULL DEFAULT 1,
	`created_by` INT unsigned NULL,
	`modified_by` INT unsigned,
	`created` DATETIME DEFAULT CURRENT_TIMESTAMP,
	`modified` DATETIME,
	`checked_out` int unsigned,
	`checked_out_time` DATETIME,
	`version` INT(10) unsigned NULL DEFAULT 1,
	`hits` INT(10) unsigned NULL DEFAULT 0,
	`access` INT(10) unsigned NULL DEFAULT 0,
	`ordering` INT(11) NULL DEFAULT 0,
	PRIMARY KEY  (`id`),
	KEY `idx_name` (`name`),
	KEY `idx_access` (`access`),
	KEY `idx_checkout` (`checked_out`),
	KEY `idx_createdby` (`created_by`),
	KEY `idx_modifiedby` (`modified_by`),
	KEY `idx_state` (`published`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

SET @user = (SELECT `id` from `#__users` LIMIT 1);
INSERT INTO `#__jtax_year`
  (`name`, `taux1`, `taux2`, `taux3`, `taux4`,
  `tranche1`, `tranche2`, `tranche3`, `tranche4`,`created_by`, `modified_by`)
VALUES ('2022', '0.11', '0.3', '0.41', '0.5', '10777', '27478', '78570', '168994', @user, @user ),
('2023', '0.11', '0.3', '0.41', '0.5', '11294', '28797', '82347', '177106', @user, @user ),
('2024', '0.11', '0.3', '0.41', '0.45', '11497', '29315', '83823', '180294', @user, @user ),
('2025', '0.11', '0.3', '0.41', '0.45', '11727', '29901', '85499', '183900', @user, @user );


INSERT INTO `#__jtax_impot` ( `deduction`,`fraisreels`,`name` ,`nbparts`,
  `revenu`, `dons`, `pel`, `year`, `created_by`, `modified_by`)
VALUES ('1', '0', 'Revenus 2022 smic', '1', '15948', '0', '0', '1', @user, @user ),
('1', '0', 'Revenus 2023 smic', '1', '16236', '0', '0', '2', @user, @user ),
('1', '0', 'Revenus 2024 smic', '1', '16839', '0', '0', '3', @user, @user ),
('1', '0', 'Revenus 2025 smic', '1', '17115', '0', '0', '4', @user, @user );


