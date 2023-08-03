-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';


-- -----------------------------------------------------
-- Schema mids
-- -----------------------------------------------------
SHOW WARNINGS;
USE `mids` ;

-- -----------------------------------------------------
-- Table `mids`.`clients`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`perdulog` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(30) NULL DEFAULT NULL,
  `subtype` VARCHAR(30) NULL DEFAULT NULL,
  `details` varchar(4000),
  `url` varchar(4000),
  `cre_date` DATETIME NOT NULL DEFAULT now(),
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

SHOW WARNINGS;
