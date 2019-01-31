
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `bootstrap` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `bootstrap` ;

-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `bootstrap`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `password` VARCHAR(1028) NOT NULL,
  `date_registered` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;



---------------------------------------------
-- Table `login_tokens`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bootstrap`.`login_tokens`(
	`id` INT NOT NULL AUTO_INCREMENT,
	`token` varchar(60) NOT NULL,
	`user_id` int not null,
	PRIMARY KEY(`id`),
	UNIQUE INDEX `token_UNIQUE` (`token` ASC),
	INDEX `fx_users_tokens_idx` (`user_id` ASC),
	CONSTRAINT 
		FOREIGN KEY (`user_id`) REFERENCES `bootstrap`.`users` (`id`)
		ON DELETE NO ACTION ON UPDATE NO ACTION)
ENGINE = InnoDB;


---------------------------------------------
-- Table `roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bootstrap`.`roles` (
`id` INT not null,
`role_name` varchar(20) not null,
 Primary KEY (`id`),
 UNIQUE INDEX `role_name_unique` (`role_name` ASC))
Engine= InnoDB

insert into `bootstrap`.`roles`
(`id`, `role_name`)
values 
(1, 'consumer'),
(2, 'admin');


---------------------------------------------
-- Table `users_in_roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bootstrap`.`users_in_roles` (
	`user_id` int not null,
	`role_id` int not null,
	CONSTRAINT
	PRIMARY KEY (`user_id`, `role_id`),
	CONSTRAINT
	 FOREIGN KEY (`user_id`) REFERENCES `bootstrap`.`users` (`id`)
	 ON DELETE NO ACTION ON UPDATE NO ACTION,
	 CONSTRAINT 
	 FOREIGN KEY (`role_id`) REFERENCES `bootstrap`.`roles` (`id`)
	 on DELETE NO ACTION ON UPDATE NO ACTION)
Engine = InnoDB


insert into users_in_roles
(`user_id`, `role_id`)
values
(1, 2)

---------------------------------------------
-- stored procedure sp_get_users_list()
-- -----------------------------------------------------

DELIMITER //

CREATE PROCEDURE sp_get_users_list ()
BEGIN
	SELECT
	 u.id,
	 u.email,
	 u.date_registered,
	 (SELECT 
		GROUP_CONCAT(role_name SEPARATOR ', ') 
	  FROM roles as r
	  JOIN users_in_roles as ur on ur.role_id = r.id
	  WHERE ur.user_id = u.id) as user_roles
	FROM users as u;	
END;
//

DELIMITER;


---------------------------------------------
-- Table `permision_groups`
-- -----------------------------------------------------
CREATE TABLE `bootstrap`.`permision_groups` (
 `permission_group_id` int not null,
 `name` varchar(52) not null,
 PRIMARY KEY (`permission_group_id`),
 UNIQUE INDEX `role_name_unique` (`name` ASC))
 Engine = InnoDB
 
 
 CREATE TABLE `bootstrap`.`permissions` (
  `permission_id` int not null,
  `permission_group_id` int not null,
  `name` varchar(52) not null,
  PRIMARY KEY (`permission_id`),
  CONSTRAINT 
  FOREIGN KEY (`permission_group_id`) REFERENCES `bootstrap`.`permision_groups`(`permission_group_id`))
  Engine = InnoDB
 
 CREATE TABLE `bootstrap`.`user_permissions`(
  `user_permission_id` int not null AUTO_INCREMENT,
  `user_id` int not null,
  `permission_id` int not null,
   PRIMARY KEY (`user_permission_id`),
   CONSTRAINT
	FOREIGN KEY (`user_id`) REFERENCES users(`id`),
	CONSTRAINT 
	FOREIGN KEY (`permission_id`) REFERENCES `bootstrap`.`permissions`(`permission_id`))
  Engine = InnoDB
 


INSERT INTO `bootstrap`.`permision_groups` 
VALUES (1, 'consumer permissions'),
	   (2, 'admin permisions')
	
Shooger.Test
