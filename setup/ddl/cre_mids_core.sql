-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mids
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mids
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mids` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
SHOW WARNINGS;
USE `mids` ;

-- -----------------------------------------------------
-- Table `mids`.`clients`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`clients` (
  `client_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(240) NULL DEFAULT NULL,
  `description` VARCHAR(4000) NULL DEFAULT NULL,
  `cre_date` DATETIME NOT NULL DEFAULT now(),
  `cre_user_id` BIGINT UNSIGNED NULL,
  `upd_date` DATETIME NULL,
  `upd_user_id` BIGINT NULL,
  PRIMARY KEY (`client_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`dml_log`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`dml_log` (
  `dml_log_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NULL DEFAULT NULL,
  `client_id` BIGINT UNSIGNED NOT NULL,
  `pk_id` INT NULL DEFAULT NULL,
  `table_name` VARCHAR(30) NULL DEFAULT NULL,
  `op` VARCHAR(1) NULL DEFAULT NULL,
  `old_context` VARCHAR(240) NULL DEFAULT NULL,
  `new_context` VARCHAR(240) NULL DEFAULT NULL,
  `cre_date` DATETIME NOT NULL DEFAULT now(),
  `cre_user_id` BIGINT UNSIGNED NULL,
  `upd_date` DATETIME NULL,
  `upd_user_id` VARCHAR(45) NULL,
  PRIMARY KEY (`dml_log_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`emails`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`emails` (
  `email_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` BIGINT UNSIGNED NOT NULL,
  `email_code` VARCHAR(30) NOT NULL COMMENT 'Enables us to select the right email to be used\n',
  `lang` VARCHAR(10) NULL DEFAULT NULL,
  `addr_to` VARCHAR(240) NULL DEFAULT NULL,
  `addr_from` VARCHAR(240) NULL DEFAULT NULL,
  `addr_cc` VARCHAR(240) NULL DEFAULT NULL,
  `addr_replyto` VARCHAR(240) NULL DEFAULT NULL,
  `subject` VARCHAR(240) NULL DEFAULT NULL,
  `body` TEXT NULL DEFAULT NULL,
  `cre_date` DATETIME NOT NULL DEFAULT now(),
  `cre_user_id` BIGINT UNSIGNED NULL,
  `upd_date` DATETIME NULL,
  `upd_user_id` BIGINT NULL,
  PRIMARY KEY (`email_id`),
  INDEX `fk_t_emails_t_clients1_idx` (`client_id` ASC) VISIBLE,
  CONSTRAINT `fk_t_emails_t_clients1`
    FOREIGN KEY (`client_id`)
    REFERENCES `mids`.`clients` (`client_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`failed_jobs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`failed_jobs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` VARCHAR(255) NOT NULL,
  `connection` TEXT NOT NULL,
  `queue` TEXT NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `exception` LONGTEXT NOT NULL,
  `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `t_failed_jobs_uuid_unique` (`uuid` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` BIGINT UNSIGNED NOT NULL DEFAULT 0,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `remember_token` VARCHAR(100) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  `secondary_email` VARCHAR(255) NULL,
  `mobile` VARCHAR(30) NULL DEFAULT NULL,
  `first_name` VARCHAR(80) NULL DEFAULT NULL,
  `last_name` VARCHAR(80) NULL DEFAULT NULL,
  `postal_code` VARCHAR(15) NULL DEFAULT NULL,
  `address1` VARCHAR(240) NULL DEFAULT NULL,
  `address2` VARCHAR(240) NULL DEFAULT NULL,
  `city` VARCHAR(240) NULL DEFAULT NULL,
  `county` VARCHAR(240) NULL DEFAULT NULL,
  `country` VARCHAR(2) NULL COMMENT 'Lookup of ISO country code - 2-char version\n\n',
  `lang` VARCHAR(10) NULL DEFAULT 'EN',
  `currency` VARCHAR(10) NULL DEFAULT 'GBP',
  `freq_data_copy2cloud_days` INT NULL DEFAULT NULL,
  `freq_data_email_days` INT NULL DEFAULT NULL,
  `last_login_date` DATE NULL DEFAULT NULL,
  `consec_failed_logins` INT NULL DEFAULT NULL,
  `account_type` VARCHAR(30) NULL DEFAULT NULL,
  `year_of_birth` INT NULL,
  `num_days_pre_exp_notifs_dflt` INT NULL COMMENT 'How many days in advance of the expiry of a service should reminders be sent (default can be overridden on items)\n',
  `cre_date` DATETIME NOT NULL DEFAULT now(),
  `cre_user_id` BIGINT UNSIGNED NULL,
  `upd_date` DATETIME NULL,
  `upd_user_id` BIGINT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE,
  UNIQUE INDEX `secondary_email_UNIQUE` (`secondary_email` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`inbound_emails`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`inbound_emails` (
  `inbound_email_id` BIGINT UNSIGNED NOT NULL,
  `user_id` BIGINT UNSIGNED NULL DEFAULT NULL,
  `client_id` BIGINT UNSIGNED NOT NULL,
  `date_received` DATE NULL DEFAULT NULL,
  `body_text` LONGTEXT NULL DEFAULT NULL,
  `num_attachments` INT NULL DEFAULT NULL,
  `cre_date` DATETIME NOT NULL DEFAULT now(),
  `cre_user_id` BIGINT UNSIGNED NULL,
  `upd_date` DATETIME NULL,
  `upd_user_id` BIGINT NULL,
  PRIMARY KEY (`inbound_email_id`),
  INDEX `fk_t_inbound_emails_t_mids_users1_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_t_inbound_emails_t_mids_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mids`.`users` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`inbound_email_attachments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`inbound_email_attachments` (
  `inbound_email_attach_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `inbound_email_id` BIGINT UNSIGNED NULL DEFAULT NULL,
  `user_id` BIGINT UNSIGNED NULL DEFAULT NULL,
  `client_id` BIGINT UNSIGNED NOT NULL,
  `attach_clob` LONGTEXT NULL DEFAULT NULL,
  `attach_blob` MEDIUMBLOB NULL DEFAULT NULL,
  `cre_date` DATETIME NOT NULL DEFAULT now(),
  `cre_user_id` BIGINT UNSIGNED NULL,
  `upd_date` DATETIME NULL,
  `upd_user_id` BIGINT NULL,
  INDEX `fk_t_inbound_email_attach_t_inbound_emails1_idx` (`inbound_email_id` ASC) VISIBLE,
  INDEX `fk_t_inbound_email_attach_t_mids_users1_idx` (`user_id` ASC) VISIBLE,
  PRIMARY KEY (`inbound_email_attach_id`),
  CONSTRAINT `fk_t_inbound_email_attach_t_inbound_emails1`
    FOREIGN KEY (`inbound_email_id`)
    REFERENCES `mids`.`inbound_emails` (`inbound_email_id`),
  CONSTRAINT `fk_t_inbound_email_attach_t_mids_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mids`.`users` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`categories` (
  `category_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `user_id` BIGINT UNSIGNED NULL,
  `client_id` BIGINT UNSIGNED NOT NULL,
  `system_or_user` VARCHAR(45) NOT NULL COMMENT 'SYSTEM, USER',
  `system_type` VARCHAR(45) NULL COMMENT 'PROPERTY, INVESTMENT, SUBSCRIPTION, CREDIT CARD, BANK ACCOUNT, INSURANCE, WARRANTY, COMMUNICATIONS etc…\n',
  `user_type` VARCHAR(45) NULL,
  `phys_or_digi` VARCHAR(10) NOT NULL COMMENT 'P, D\n\n',
  `cre_date` DATETIME NOT NULL DEFAULT now(),
  `cre_user_id` BIGINT UNSIGNED NULL,
  `upd_date` DATETIME NULL,
  `upd_user_id` BIGINT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE INDEX `system_type_UNIQUE` (`system_type` ASC) VISIBLE)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`room_types`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`room_types` (
  `room_type_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` BIGINT UNSIGNED NOT NULL,
  `code` VARCHAR(30) NOT NULL,
  `name` VARCHAR(80) NULL,
  `seq` INT UNSIGNED NULL,
  `cre_date` DATETIME NOT NULL DEFAULT now(),
  `cre_user_id` BIGINT UNSIGNED NULL,
  `upd_date` DATETIME NULL,
  `upd_user_id` BIGINT NULL,
  PRIMARY KEY (`room_type_id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`item_types`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`item_types` (
  `item_type_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NULL DEFAULT NULL COMMENT 'The user_id who owns the type\\n',
  `category_id` BIGINT UNSIGNED NOT NULL,
  `dflt_room_type_id` BIGINT UNSIGNED NULL COMMENT 'E.G. GARAGE,BED,LIVING,FAMILY,KITCHEN,UTILITY,LANDING,HALLWAY,BATHROOM,WC, SHED, SUMMERHOUSE…\n',
  `client_id` BIGINT UNSIGNED NOT NULL,
  `name` VARCHAR(80) NOT NULL,
  `code` VARCHAR(30) NOT NULL,
  `include_in_wizard` VARCHAR(1) NULL,
  `optional_description` VARCHAR(80) NULL,
  `show_retailer` VARCHAR(1) NULL,
  `retailer_label` VARCHAR(80) NULL,
  `show_mfr` VARCHAR(1) NULL,
  `mfr_label` VARCHAR(80) NULL,
  `show_model_name` VARCHAR(1) NULL,
  `model_name_label` VARCHAR(80) NULL,
  `show_serial` VARCHAR(1) NULL,
  `serial_label` VARCHAR(80) NULL,
  `show_purch_date` VARCHAR(1) NULL,
  `purch_date_label` VARCHAR(80) NULL,
  `show_start_date` VARCHAR(1) NULL,
  `start_date_label` VARCHAR(80) NULL,
  `show_expiry_date` VARCHAR(1) NULL,
  `expiry_date_label` VARCHAR(80) NULL,
  `show_price_paid` VARCHAR(1) NULL,
  `price_paid_label` VARCHAR(80) NULL,
  `show_val_now` VARCHAR(1) NULL,
  `val_now_label` VARCHAR(80) NULL,
  `show_val_now_eff_date` VARCHAR(1) NULL,
  `val_now_eff_date_label` VARCHAR(80) NULL,
  `show_val_basis` VARCHAR(1) NULL,
  `val_basis_label` VARCHAR(80) NULL,
  `show_contact_phone` VARCHAR(1) NULL,
  `contact_phone_label` VARCHAR(80) NULL,
  `cre_date` DATETIME NOT NULL DEFAULT now(),
  `cre_user_id` BIGINT UNSIGNED NULL,
  `upd_date` DATETIME NULL,
  `upd_user_id` BIGINT NULL,
  PRIMARY KEY (`item_type_id`),
  INDEX `fk_t_item_types_t_mids_users1_idx` (`user_id` ASC) VISIBLE,
  INDEX `fk_t_item_types_t_categories1_idx` (`category_id` ASC) VISIBLE,
  INDEX `fk_t_item_types_t_room_types1_idx` (`dflt_room_type_id` ASC) VISIBLE,
  CONSTRAINT `fk_t_item_types_t_mids_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mids`.`users` (`id`),
  CONSTRAINT `fk_t_item_types_t_categories1`
    FOREIGN KEY (`category_id`)
    REFERENCES `mids`.`categories` (`category_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_t_item_types_t_room_types1`
    FOREIGN KEY (`dflt_room_type_id`)
    REFERENCES `mids`.`room_types` (`room_type_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`login_attempts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`login_attempts` (
  `login_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NULL DEFAULT NULL,
  `client_id` BIGINT UNSIGNED NOT NULL,
  `login_date` DATETIME NULL DEFAULT now(),
  `login_result` VARCHAR(10) NULL DEFAULT NULL,
  `log_message` VARCHAR(4000) NULL DEFAULT NULL,
  `cre_date` DATETIME NOT NULL DEFAULT now(),
  `cre_user_id` BIGINT UNSIGNED NULL,
  `upd_date` DATETIME NULL,
  `upd_user_id` BIGINT NULL,
  PRIMARY KEY (`login_id`),
  INDEX `fk_t_login_attempts_t_mids_users1_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_t_login_attempts_t_mids_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mids`.`users` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`migrations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`migrations` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` VARCHAR(255) NOT NULL,
  `batch` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`my_properties`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`my_properties` (
  `my_property_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `client_id` BIGINT UNSIGNED NOT NULL,
  `friendly_name` VARCHAR(80) NOT NULL,
  `address1` VARCHAR(45) NULL DEFAULT NULL,
  `address2` VARCHAR(45) NULL DEFAULT NULL,
  `city` VARCHAR(45) NULL DEFAULT NULL,
  `county` VARCHAR(45) NULL DEFAULT NULL,
  `country` VARCHAR(2) NOT NULL COMMENT 'Will be a lookup of country codes - ISO - 2 character\n\n',
  `postal_code` VARCHAR(45) NULL DEFAULT NULL,
  `property_status` VARCHAR(45) NULL DEFAULT NULL COMMENT 'PROP_ACTIVE, PROP_DISPOSED',
  `photo` BLOB NULL,
  `currency` VARCHAR(10) NULL DEFAULT 'GBP',
  `cre_date` DATETIME NOT NULL DEFAULT now(),
  `cre_user_id` BIGINT UNSIGNED NULL,
  `upd_date` DATETIME NULL,
  `upd_user_id` BIGINT NULL,
  PRIMARY KEY (`my_property_id`),
  INDEX `fk_t_my_properties_t_mids_users1_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_t_my_properties_t_mids_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mids`.`users` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`my_property_rooms`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`my_property_rooms` (
  `property_room_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `my_property_id` BIGINT UNSIGNED NULL DEFAULT NULL,
  `room_type_id` BIGINT UNSIGNED NOT NULL,
  `client_id` BIGINT UNSIGNED NOT NULL,
  `room_name` VARCHAR(80) NULL DEFAULT NULL,
  `comments` VARCHAR(2000) NULL DEFAULT NULL,
  `cre_date` DATETIME NOT NULL DEFAULT now(),
  `cre_user_id` BIGINT UNSIGNED NULL,
  `upd_date` DATETIME NULL,
  `upd_user_id` BIGINT NULL,
  PRIMARY KEY (`property_room_id`),
  INDEX `fk_t_my_property_rooms_t_my_properties1_idx` (`my_property_id` ASC) VISIBLE,
  INDEX `fk_t_my_property_rooms_t_room_types1_idx` (`room_type_id` ASC) VISIBLE,
  CONSTRAINT `fk_t_my_property_rooms_t_my_properties1`
    FOREIGN KEY (`my_property_id`)
    REFERENCES `mids`.`my_properties` (`my_property_id`),
  CONSTRAINT `fk_t_my_property_rooms_t_room_types1`
    FOREIGN KEY (`room_type_id`)
    REFERENCES `mids`.`room_types` (`room_type_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`my_items`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`my_items` (
  `my_item_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_type_id` BIGINT UNSIGNED NOT NULL,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `my_property_id` BIGINT UNSIGNED NOT NULL,
  `client_id` BIGINT UNSIGNED NOT NULL,
  `version` INT NOT NULL COMMENT 'Record version number - starting at 1 - increments on each “date effective update”\n',
  `date_effective_from` DATE NOT NULL,
  `date_effective_to` DATE NULL,
  `insured_by_my_item_id` BIGINT UNSIGNED NULL COMMENT 'Link back to another row on this table which indicates the insurance policy that is covering this item\n',
  `name` VARCHAR(240) NULL DEFAULT NULL,
  `qty` INT NULL,
  `model_name` VARCHAR(240) NULL DEFAULT NULL,
  `mfr` VARCHAR(240) NULL DEFAULT NULL,
  `serial_number` VARCHAR(45) NULL DEFAULT NULL,
  `purch_date` DATE NULL DEFAULT NULL,
  `start_date` DATE NULL,
  `expiry_date` DATE NULL DEFAULT NULL,
  `price_paid` INT NULL DEFAULT NULL,
  `val_now` INT NULL,
  `val_now_eff_date` DATE NULL,
  `val_basis` VARCHAR(30) NULL,
  `contact_phone` VARCHAR(45) NULL,
  `comments` LONGTEXT NULL DEFAULT NULL,
  `status` VARCHAR(30) NOT NULL COMMENT 'ACTIVE\\nEXPIRED\\nDISPOSED\\n\n\nThis may not be required.',
  `property_room_id` BIGINT UNSIGNED NULL DEFAULT NULL,
  `num_days_pre_exp_notifs` INT NULL COMMENT 'How many days in advance of the expiry of a service should reminders be sent (default can be overridden on items)\n',
  `subs_plan_name` VARCHAR(240) NULL,
  `subs_plan_start` DATETIME NULL,
  `subs_plan_end` DATETIME NULL,
  `subs_plan_cost` INT NULL,
  `subs_plan_cost_basis` VARCHAR(30) NULL,
  `sample_flag` VARCHAR(1) NULL COMMENT 'Used for tracking data that is not entered by the user - demo / sample data',
  `cre_date` DATETIME NOT NULL DEFAULT now(),
  `cre_user_id` BIGINT UNSIGNED NULL,
  `upd_date` DATETIME NULL,
  `upd_user_id` BIGINT NULL,
  PRIMARY KEY (`my_item_id`),
  INDEX `fk_t_my_items_t_my_property_rooms1_idx` (`property_room_id` ASC) VISIBLE,
  INDEX `fk_t_my_items_t_mids_users1_idx` (`user_id` ASC) VISIBLE,
  INDEX `fk_t_my_items_t_my_properties1_idx` (`my_property_id` ASC) VISIBLE,
  CONSTRAINT `fk_t_my_items_t_master_item_types1`
    FOREIGN KEY (`item_type_id`)
    REFERENCES `mids`.`item_types` (`item_type_id`),
  CONSTRAINT `fk_t_my_items_t_mids_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mids`.`users` (`id`),
  CONSTRAINT `fk_t_my_items_t_my_property_rooms1`
    FOREIGN KEY (`property_room_id`)
    REFERENCES `mids`.`my_property_rooms` (`property_room_id`),
  CONSTRAINT `fk_t_my_items_t_my_properties1`
    FOREIGN KEY (`my_property_id`)
    REFERENCES `mids`.`my_properties` (`my_property_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`my_item_docs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`my_item_docs` (
  `item_doc_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `my_item_id` BIGINT UNSIGNED NOT NULL,
  `client_id` BIGINT UNSIGNED NOT NULL,
  `doc_content` BLOB NULL DEFAULT NULL,
  `comments` VARCHAR(2000) NULL DEFAULT NULL,
  `doc_type` VARCHAR(45) NOT NULL COMMENT 'PHOTO, DOCUMENT, RECEIPT\\n',
  `cre_date` DATETIME NOT NULL DEFAULT now(),
  `cre_user_id` BIGINT UNSIGNED NULL,
  `upd_date` DATETIME NULL,
  `upd_user_id` BIGINT NULL,
  PRIMARY KEY (`item_doc_id`),
  INDEX `fk_t_my_item_pics_t_my_items1_idx` (`my_item_id` ASC) VISIBLE,
  CONSTRAINT `fk_t_my_item_pics_t_my_items1`
    FOREIGN KEY (`my_item_id`)
    REFERENCES `mids`.`my_items` (`my_item_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`password_resets`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`password_resets` (
  `email` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  INDEX `t_password_resets_email_index` (`email` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`personal_access_tokens`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`personal_access_tokens` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` VARCHAR(255) NOT NULL,
  `tokenable_id` BIGINT UNSIGNED NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `token` VARCHAR(64) NOT NULL,
  `abilities` TEXT NULL DEFAULT NULL,
  `last_used_at` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `t_personal_access_tokens_token_unique` (`token` ASC) VISIBLE,
  INDEX `t_personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type` ASC, `tokenable_id` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`syslog`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`syslog` (
  `syslog_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` BIGINT UNSIGNED NOT NULL,
  `date_created` DATETIME NOT NULL DEFAULT now(),
  `message` VARCHAR(4000) NULL DEFAULT NULL,
  `cre_date` DATETIME NOT NULL DEFAULT now(),
  `cre_user_id` BIGINT UNSIGNED NULL,
  `upd_date` DATETIME NULL,
  `upd_user_id` BIGINT NULL,
  PRIMARY KEY (`syslog_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`trace`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`trace` (
  `trace_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NULL DEFAULT NULL,
  `client_id` BIGINT UNSIGNED NOT NULL,
  `ip` VARCHAR(240) NULL DEFAULT NULL,
  `visited_url` VARCHAR(4000) NULL DEFAULT NULL,
  `referrer_url` VARCHAR(4000) NULL DEFAULT NULL,
  `date_start` DATE NULL DEFAULT NULL,
  `date_end` DATE NULL DEFAULT NULL,
  `elapsed_ms` INT NULL DEFAULT NULL,
  `cre_date` DATETIME NOT NULL DEFAULT now(),
  `cre_user_id` BIGINT UNSIGNED NULL,
  `upd_date` DATETIME NULL,
  `upd_user_id` BIGINT NULL,
  PRIMARY KEY (`trace_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`plans`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`plans` (
  `plan_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` BIGINT UNSIGNED NOT NULL,
  `name` VARCHAR(240) NULL,
  `description` VARCHAR(4000) NULL,
  `date_avail_start` DATETIME NULL,
  `date_avail_end` DATETIME NULL,
  `discounted_months` INT NULL,
  `discounted_fee` FLOAT NULL COMMENT 'If this is zero then a user can create their account and be fully active without any payments\n',
  `revert_to_fee` FLOAT NULL,
  `plan_code` VARCHAR(45) NOT NULL COMMENT 'May be useful\n',
  `cre_date` DATETIME NOT NULL DEFAULT now(),
  `cre_user_id` BIGINT UNSIGNED NULL,
  `upd_date` DATETIME NULL,
  `upd_user_id` BIGINT NULL,
  `free_for_life_flag` VARCHAR(1) NOT NULL DEFAULT 'N' COMMENT 'Y or N',
  PRIMARY KEY (`plan_id`),
  INDEX `fk_t_plans_t_clients1_idx` (`client_id` ASC) VISIBLE,
  UNIQUE INDEX `plan_code_UNIQUE` (`plan_code` ASC) VISIBLE,
  CONSTRAINT `fk_t_plans_t_clients1`
    FOREIGN KEY (`client_id`)
    REFERENCES `mids`.`clients` (`client_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`user_plans`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`user_plans` (
  `user_plan_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `plan_id` BIGINT UNSIGNED NOT NULL,
  `client_id` BIGINT UNSIGNED NOT NULL,
  `from_name` VARCHAR(240) NULL COMMENT 'the plan name from which this column and other “from” columns are populated\n',
  `from_description` VARCHAR(4000) NULL,
  `from_date_avail_start` DATETIME NULL,
  `from_date_avail_end` DATETIME NULL,
  `from_discounted_months` INT NULL,
  `from_discounted_fee` FLOAT NULL,
  `from_revert_to_fee` FLOAT NULL,
  `cre_date` DATETIME NOT NULL DEFAULT now(),
  `cre_user_id` BIGINT UNSIGNED NULL,
  `upd_date` DATETIME NULL,
  `upd_user_id` BIGINT NULL,
  PRIMARY KEY (`user_plan_id`),
  INDEX `fk_t_mids_user_plans_t_mids_users1_idx` (`user_id` ASC) VISIBLE,
  INDEX `fk_t_mids_user_plans_t_plans1_idx` (`plan_id` ASC) VISIBLE,
  CONSTRAINT `fk_t_mids_user_plans_t_mids_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mids`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_t_mids_user_plans_t_plans1`
    FOREIGN KEY (`plan_id`)
    REFERENCES `mids`.`plans` (`plan_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`payment_history`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`payment_history` (
  `payment_history_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `client_id` BIGINT UNSIGNED NOT NULL,
  `payment_date` DATETIME NOT NULL,
  `payment_amount` FLOAT NOT NULL COMMENT 'May be zero and will be recorded - e.g. free trial\n',
  `payment_card_4_last_digits` INT NULL,
  `payment_covers_start_date` DATETIME NOT NULL,
  `payment_covers_end_date` DATETIME NOT NULL,
  `cre_date` DATETIME NOT NULL DEFAULT now(),
  `cre_user_id` BIGINT UNSIGNED NULL,
  `upd_date` DATETIME NULL,
  `upd_user_id` BIGINT NULL,
  INDEX `fk_t_payment_history_t_mids_users1_idx` (`user_id` ASC) VISIBLE,
  PRIMARY KEY (`payment_history_id`),
  CONSTRAINT `fk_t_payment_history_t_mids_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mids`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`pending_items`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`pending_items` (
  `pending_item_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `t_pending_itemscol` BIGINT NULL,
  `client_id` BIGINT UNSIGNED NOT NULL,
  `cre_date` DATETIME NOT NULL DEFAULT now(),
  `cre_user_id` BIGINT UNSIGNED NULL,
  `upd_date` DATETIME NULL,
  `upd_user_id` BIGINT NULL,
  PRIMARY KEY (`pending_item_id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`audit_log`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`audit_log` (
  `audit_log_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `client_id` BIGINT UNSIGNED NOT NULL,
  `audit_date` DATETIME NOT NULL DEFAULT now(),
  `ip_address` VARCHAR(45) NULL,
  `description` VARCHAR(4000) NOT NULL COMMENT 'Might simply hold a description of what was done - e.g. “logged in”\n',
  `context` VARCHAR(30) NOT NULL COMMENT 'e.g. GRANT_MADE, GRANT_REVOKED, ROOM_ADD, ITEM_ADD, PROPERTY_ADD, ITEM_UPDATE, ROOM_UPDATE, PROPERTY_UPDATE, LOGIN, LOGOFF',
  `t_audit_logcol` VARCHAR(45) NULL,
  `cre_date` DATETIME NOT NULL DEFAULT now(),
  `cre_user_id` BIGINT UNSIGNED NULL,
  `upd_date` DATETIME NULL,
  `upd_user_id` BIGINT NULL,
  PRIMARY KEY (`audit_log_id`),
  INDEX `fk_t_audit_log_t_mids_users1_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_t_audit_log_t_mids_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mids`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`accounts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`accounts` (
  `account_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `account_owner_user_id` BIGINT UNSIGNED NOT NULL,
  `client_id` BIGINT UNSIGNED NOT NULL,
  `account_code` VARCHAR(30) NOT NULL,
  `cre_date` DATETIME NOT NULL DEFAULT now(),
  `cre_user_id` BIGINT UNSIGNED NULL,
  `upd_date` DATETIME NULL,
  `upd_user_id` BIGINT NULL,
  PRIMARY KEY (`account_id`),
  INDEX `fk_t_accounts_t_mids_users1_idx` (`account_owner_user_id` ASC) VISIBLE,
  UNIQUE INDEX `account_code_UNIQUE` (`account_code` ASC) VISIBLE,
  UNIQUE INDEX `account_owner_user_id_UNIQUE` (`account_owner_user_id` ASC) VISIBLE,
  CONSTRAINT `fk_t_accounts_t_mids_users1`
    FOREIGN KEY (`account_owner_user_id`)
    REFERENCES `mids`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`user_account_access`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`user_account_access` (
  `user_account_access_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `account_id` BIGINT UNSIGNED NOT NULL,
  `client_id` BIGINT UNSIGNED NOT NULL,
  `date_granted` DATETIME NOT NULL,
  `access_mode` VARCHAR(45) NOT NULL COMMENT 'OWNER, NOMINEE',
  `cre_date` DATETIME NOT NULL DEFAULT now(),
  `cre_user_id` BIGINT UNSIGNED NULL,
  `upd_date` DATETIME NULL,
  `upd_user_id` BIGINT NULL,
  PRIMARY KEY (`user_account_access_id`),
  INDEX `fk_t_user_account_access_t_mids_users1_idx` (`user_id` ASC) VISIBLE,
  INDEX `fk_t_user_account_access_t_accounts1_idx` (`account_id` ASC) VISIBLE,
  CONSTRAINT `fk_t_user_account_access_t_mids_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mids`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_t_user_account_access_t_accounts1`
    FOREIGN KEY (`account_id`)
    REFERENCES `mids`.`accounts` (`account_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`item_type_extra_fields`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`item_type_extra_fields` (
  `item_type_field_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_type_id` BIGINT UNSIGNED NOT NULL,
  `client_id` BIGINT UNSIGNED NOT NULL,
  `seq` INT NOT NULL,
  `label` VARCHAR(45) NOT NULL,
  `presentation` VARCHAR(45) NOT NULL COMMENT 'RADIO, SELECT\n',
  `values` VARCHAR(240) NULL,
  `data_type` VARCHAR(45) NOT NULL COMMENT 'CHAR, NUMBER, DATE_Y, DATE_MY, DATE_DMY\n',
  `cre_date` DATETIME NOT NULL DEFAULT now(),
  `cre_user_id` BIGINT UNSIGNED NULL,
  `upd_date` DATETIME NULL,
  `upd_user_id` BIGINT NULL,
  INDEX `fk_t_item_type_fields_t_item_types1_idx` (`item_type_id` ASC) VISIBLE,
  PRIMARY KEY (`item_type_field_id`),
  CONSTRAINT `fk_t_item_type_fields_t_item_types1`
    FOREIGN KEY (`item_type_id`)
    REFERENCES `mids`.`item_types` (`item_type_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`stage_room_types`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`stage_room_types` (
  `code` VARCHAR(30) NOT NULL,
  `name` VARCHAR(80) NOT NULL)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`stage_categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`stage_categories` (
  `name` VARCHAR(30) NOT NULL,
  `system_or_user` VARCHAR(5) NOT NULL,
  `system_type` VARCHAR(30) NOT NULL,
  `user_type` VARCHAR(80) NULL,
  `phys_or_digi` VARCHAR(8) NOT NULL)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`stage_item_types`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`stage_item_types` (
  `name` VARCHAR(80) NOT NULL,
  `code` VARCHAR(30) NOT NULL,
  `category` VARCHAR(30) NOT NULL,
  `dflt_room_code` VARCHAR(80) NULL,
  `include_in_wizard` VARCHAR(1) NULL,
  `optional_description` VARCHAR(80) NULL,
  `show_retailer` VARCHAR(1) NULL,
  `retailer_label` VARCHAR(80) NULL,
  `show_mfr` VARCHAR(1) NULL,
  `mfr_label` VARCHAR(80) NULL,
  `show_model_name` VARCHAR(1) NULL,
  `model_name_label` VARCHAR(80) NULL,
  `show_serial` VARCHAR(1) NULL,
  `serial_label` VARCHAR(80) NULL,
  `show_purch_date` VARCHAR(1) NULL,
  `purch_date_label` VARCHAR(80) NULL,
  `show_start_date` VARCHAR(1) NULL,
  `start_date_label` VARCHAR(80) NULL,
  `show_expiry_date` VARCHAR(1) NULL,
  `expiry_date_label` VARCHAR(80) NULL,
  `show_price_paid` VARCHAR(1) NULL,
  `price_paid_label` VARCHAR(80) NULL,
  `show_val_now` VARCHAR(1) NULL,
  `val_now_label` VARCHAR(80) NULL,
  `show_val_now_eff_date` VARCHAR(1) NULL,
  `val_now_eff_date_label` VARCHAR(80) NULL,
  `show_val_basis` VARCHAR(1) NULL,
  `val_basis_label` VARCHAR(80) NULL,
  `show_contact_phone` VARCHAR(1) NULL,
  `contact_phone_label` VARCHAR(80) NULL)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`stage_suggested_items`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`stage_suggested_items` (
  `name` VARCHAR(80) NOT NULL,
  `item_type_code` VARCHAR(30) NOT NULL,
  `relevant_country` VARCHAR(2) NOT NULL)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`my_item_extra_fields`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`my_item_extra_fields` (
  `my_item_extra_field_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_type_field_id` BIGINT UNSIGNED NOT NULL,
  `my_item_id` BIGINT UNSIGNED NOT NULL,
  `client_id` BIGINT UNSIGNED NOT NULL,
  `field_value` LONGTEXT NULL COMMENT 'The idea is that this holds whatever data is entered - and we use info from t_item_type_extra_fields to define how we present the value (date, number, text etc.)\n',
  `cre_date` DATETIME NOT NULL DEFAULT now(),
  `cre_user_id` BIGINT UNSIGNED NULL,
  `upd_date` DATETIME NULL,
  `upd_user_id` BIGINT NULL,
  PRIMARY KEY (`my_item_extra_field_id`),
  INDEX `fk_t_my_item_extra_fields_t_item_type_extra_fields1_idx` (`item_type_field_id` ASC) VISIBLE,
  INDEX `fk_t_my_item_extra_fields_t_my_items1_idx` (`my_item_id` ASC) VISIBLE,
  CONSTRAINT `fk_t_my_item_extra_fields_t_item_type_extra_fields1`
    FOREIGN KEY (`item_type_field_id`)
    REFERENCES `mids`.`item_type_extra_fields` (`item_type_field_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_t_my_item_extra_fields_t_my_items1`
    FOREIGN KEY (`my_item_id`)
    REFERENCES `mids`.`my_items` (`my_item_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`nominee_obj_grants`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`nominee_obj_grants` (
  `obj_grant_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id_nominee` BIGINT UNSIGNED NOT NULL,
  `client_id` BIGINT UNSIGNED NOT NULL,
  `obj_type` VARCHAR(30) NOT NULL,
  `obj_id` BIGINT UNSIGNED NOT NULL,
  `priv` VARCHAR(10) NOT NULL COMMENT 'N (none), R (read), U (Update)\n',
  `cre_date` DATETIME NOT NULL DEFAULT now(),
  `cre_user_id` BIGINT UNSIGNED NULL,
  `upd_date` DATETIME NULL,
  `upd_user_id` BIGINT NULL,
  PRIMARY KEY (`obj_grant_id`),
  INDEX `fk_t_nominee_obj_grants_t_my_properties1_idx` (`user_id_nominee` ASC) VISIBLE,
  CONSTRAINT `fk_t_nominee_obj_grants_t_my_properties1`
    FOREIGN KEY (`user_id_nominee`)
    REFERENCES `mids`.`my_properties` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`my_nominees`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`my_nominees` (
  `user_nominee_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id_granting` BIGINT UNSIGNED NOT NULL,
  `user_id_nominee` BIGINT UNSIGNED NOT NULL,
  `client_id` BIGINT UNSIGNED NOT NULL,
  `nominee_label` VARCHAR(80) NOT NULL,
  `comments` VARCHAR(400) NULL,
  `status` VARCHAR(10) NOT NULL COMMENT 'PENDING / ACCEPTED',
  `cre_date` DATETIME NOT NULL DEFAULT now(),
  `cre_user_id` BIGINT UNSIGNED NULL,
  `upd_date` DATETIME NULL,
  `upd_user_id` BIGINT NULL,
  PRIMARY KEY (`user_nominee_id`),
  INDEX `fk_t_user_nominees_t_mids_users1_idx` (`user_id_granting` ASC) VISIBLE,
  INDEX `fk_t_user_nominees_t_my_properties1_idx` (`user_id_nominee` ASC) VISIBLE,
  CONSTRAINT `fk_t_user_nominees_t_mids_users1`
    FOREIGN KEY (`user_id_granting`)
    REFERENCES `mids`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_t_user_nominees_t_my_properties1`
    FOREIGN KEY (`user_id_nominee`)
    REFERENCES `mids`.`my_properties` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`suggested_items`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`suggested_items` (
  `suggested_item_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_type_id` BIGINT UNSIGNED NOT NULL,
  `client_id` BIGINT UNSIGNED NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `relevant_country` VARCHAR(3) NULL,
  PRIMARY KEY (`suggested_item_id`),
  INDEX `fk_t_suggested_items_t_item_types1_idx` (`item_type_id` ASC) VISIBLE,
  CONSTRAINT `fk_t_suggested_items_t_item_types1`
    FOREIGN KEY (`item_type_id`)
    REFERENCES `mids`.`item_types` (`item_type_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mids`.`sample_my_items`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`sample_my_items` (
  `item_code` VARCHAR(30) NULL,
  `cost` INT NULL,
  `cost_basis` VARCHAR(30) NULL,
  `start_date` DATE NULL,
  `expiry_date` DATE NULL,
  `mfr` VARCHAR(80) NULL,
  `model_name` VARCHAR(80) NULL,
  `purch_date` DATE NULL,
  `price_paid` INT NULL,
  `val_now` INT NULL,
  `serial_number` VARCHAR(80) NULL)
ENGINE = InnoDB;

SHOW WARNINGS;
USE `mids` ;

-- -----------------------------------------------------
-- Placeholder table for view `mids`.`v_my_items`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`v_my_items` (`my_item_id` INT, `item_type_id` INT, `user_id` INT, `my_property_id` INT, `client_id` INT, `version` INT, `date_effective_from` INT, `date_effective_to` INT, `cat_name` INT, `cat_system_type` INT, `item_type_code` INT, `cat_user_type` INT, `item_type_name` INT, `insured_by_my_item_id` INT, `name` INT, `qty` INT, `model_name` INT, `mfr` INT, `serial_number` INT, `purch_date` INT, `start_date` INT, `expiry_date` INT, `price_paid` INT, `val_now` INT, `val_now_eff_date` INT, `val_basis` INT, `contact_phone` INT, `comments` INT, `status` INT, `property_room_id` INT, `num_days_pre_exp_notifs` INT, `cre_date` INT, `cre_user_id` INT, `upd_date` INT, `upd_user_id` INT, `access_mode` INT);
SHOW WARNINGS;

-- -----------------------------------------------------
-- Placeholder table for view `mids`.`v_my_property_rooms`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`v_my_property_rooms` (`property_room_id` INT, `my_property_id` INT, `room_type_id` INT, `room_name` INT, `access_mode` INT);
SHOW WARNINGS;

-- -----------------------------------------------------
-- Placeholder table for view `mids`.`v_my_items_summary`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mids`.`v_my_items_summary` (`count_items` INT, `sum_subs_plan_cost` INT, `reporting_category` INT, `user_id` INT);
SHOW WARNINGS;

-- -----------------------------------------------------
-- View `mids`.`v_my_items`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mids`.`v_my_items`;
SHOW WARNINGS;
USE `mids`;
CREATE or replace VIEW `v_my_items` AS 
select my_item_id,
    mi.item_type_id,
    mi.user_id,
    my_property_id,
    mi.client_id,
    version,
    date_effective_from,
    date_effective_to,
    cat.name cat_name, 
    cat.system_type cat_system_type, 
    it.code item_type_code, 
    cat.user_type cat_user_type, 
    it.name item_type_name,
    insured_by_my_item_id,
    mi.name,
    qty,
    model_name,
    mfr,
    serial_number,
    purch_date,
    start_date,
    expiry_date,
    price_paid,
    val_now,
    val_now_eff_date,
    val_basis,
    contact_phone,
    comments,
    status,
    property_room_id,
    num_days_pre_exp_notifs,
    mi.cre_date,
    mi.cre_user_id,
    mi.upd_date,
    mi.upd_user_id,
    'FULL' access_mode
from my_items mi,
item_types it, 
categories cat
where mi.date_effective_to is null
and   mi.item_type_id = it.item_type_id
and   it.category_id = cat.category_id;
SHOW WARNINGS;

-- -----------------------------------------------------
-- View `mids`.`v_my_property_rooms`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mids`.`v_my_property_rooms`;
SHOW WARNINGS;
USE `mids`;
CREATE or replace
VIEW `mids`.`v_my_property_rooms` AS
    SELECT 
        `mids`.`my_property_rooms`.`property_room_id` AS `property_room_id`,
        `mids`.`my_property_rooms`.`my_property_id` AS `my_property_id`,
        `mids`.`my_property_rooms`.`room_type_id` AS `room_type_id`,
        `mids`.`my_property_rooms`.`room_name` AS `room_name`,
        'FULL' AS `access_mode`
    FROM
        `mids`.`my_property_rooms`;
SHOW WARNINGS;

-- -----------------------------------------------------
-- View `mids`.`v_my_items_summary`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mids`.`v_my_items_summary`;
SHOW WARNINGS;
USE `mids`;
CREATE or replace VIEW `v_my_items_summary` AS
select count(my_items.my_item_id) count_items, 
       ifnull(sum(subs_plan_cost),0) sum_subs_plan_cost, 
case categories.system_type
  when 'SUBS_DIGI_ADMIN' then 'ENTERTAINMENT'
  when 'SUBS_DIGI_ENT' then 'ENTERTAINMENT'
else 
  categories.system_type
end reporting_category,
my_items.user_id user_id
from item_types 
  left outer join my_items on item_types.item_type_id = my_items.item_type_id ,
  categories
where item_types.category_id = categories.category_id
and categories.system_type in ('SUBS_DIGI_ADMIN','SUBS_DIGI_ENT','COMMUNICATIONS','BROADBAND','MOTOR','INSURANCE')
-- latest record only
and my_items.date_effective_to is null
group by 3,4;
SHOW WARNINGS;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
