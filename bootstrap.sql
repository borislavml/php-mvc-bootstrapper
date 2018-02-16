
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
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;
-- --------insert into `bootstrap`.`roles`
(`id`, `role_name`)
values 
(UUID(), 'consumer'),
(UUID(), 'admin');
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
`id` varchar(36) not null,
`role_name` varchar(20) not null,
 Primary KEY (`id`),
 UNIQUE INDEX `role_name_unique` (`role_name` ASC))
Engine= InnoDB

insert into `bootstrap`.`roles`
(`id`, `role_name`)
values 
(UUID(), 'consumer'),
(UUID(), 'admin');


---------------------------------------------
-- Table `users_in_roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bootstrap`.`users_in_roles` (
	`user_id` int not null,
	`role_id` varchar(36) not null,
	CONSTRAINT
	PRIMARY KEY (`user_id`, `role_id`),
	CONSTRAINT
	 FOREIGN KEY (`user_id`) REFERENCES `bootstrap`.`users` (`id`)
	 ON DELETE NO ACTION ON UPDATE NO ACTION,
	 CONSTRAINT 
	 FOREIGN KEY (`role_id`) REFERENCES `bootstrap`.`roles` (`id`)
	 on DELETE NO ACTION ON UPDATE NO ACTION)
Engine = InnoDB


alter table bootstrap.users 
add column `date_registered` datetime null

