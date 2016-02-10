-- create table `publishers` and insert data
CREATE TABLE IF NOT EXISTS `publishers` (
	`id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`name` varchar(50) NOT NULL,
	`address` varchar(200) NOT NULL,
	`city` varchar(50) NOT NULL,
	`state` varchar(50),
	`nation` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `publishers` (`name`, `address`, `city`, `state`, `nation`)
	SELECT `title_imprint`, `pub_add`, `pub_city`, `pub_stat`, `pub_nat`
	FROM `title`;

-- insert publisher id into table

ALTER TABLE `title` ADD `publishers_id` int;

UPDATE `title` SET `publishers_id` = (
	SELECT `publishers`.`id` 
	FROM `publishers` WHERE `publishers`.`name` = `title`.`imprint`
	);

-- delete redundant publisher info from table 
ALTER TABLE `title` DROP `title_imprint`, `pub_add`, `pub_city`, `pub_city`, `pub_nat`;