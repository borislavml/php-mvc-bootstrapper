
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
-- -----------------------------------------------------
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
