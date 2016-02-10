-- create new table `persons` and insert data

CREATE TABLE `persons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `role` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE(`name`, `role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO `persons` (`name`, `role`) 
	SELECT `title_pers_name`, `title_pers_role`
	FROM `title`;

INSERT IGNORE INTO `persons` (`name`, `role`) 
	SELECT `issue_pers_name`, `issue_pers_role`
	FROM `issue`;

INSERT IGNORE INTO `persons` (`name`, `role`) 
	SELECT `item_pers_name`, `item_pers_role`
	FROM `item`;

-- insert person id into each table title, issue, item

ALTER TABLE `title` ADD `person_id` int;

ALTER TABLE `issue` ADD `person_id` int;

ALTER TABLE `item` ADD `person_id` int;

UPDATE `title` SET `person_id` = (
	SELECT `persons`.`id`
	FROM `persons` WHERE `title`.`title_pers_name` = `persons`.`name` AND `title`.`title_pers_role` = `persons`.`role`
	);

UPDATE `issue` SET `person_id` = (
	SELECT `persons`.`id`
	FROM `persons` WHERE `issue`.`issue_pers_name` = `persons`.`name` AND `issue`.`issue_pers_role` = `persons`.`role`
	);

UPDATE `item` SET `person_id` = (
	SELECT `persons`.`id`
	FROM `persons` WHERE `item`.`item_pers_name` = `persons`.`name` AND `item`.`item_pers_role` = `persons`.`role`
	);

-- CREATE TABLE `role` (
-- 	`person_id` varchar(200) NOT NULL,
-- 	`role` varchar(50) NOT NULL
-- 	PRIMARY KEY (`person_id`)
-- ) Engine=InnoDB DEFAULT CHARSET=utf8mb4;

-- delete person name and role from each table

ALTER TABLE `title` DROP `title_pers_name`, `title_pers_role`;

ALTER TABLE `issue` DROP `issue_pers_name`, `issue_pers_role`;

ALTER TABLE `item` DROP `item_pers_name`, `item_pers_role`;