CREATE TABLE tbl_user (
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(128) NOT NULL,
    password VARCHAR(128) NOT NULL,
    email VARCHAR(128) NOT NULL
);

INSERT INTO tbl_user (username, password, email) VALUES ('test1', 'pass1', 'test1@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test2', 'pass2', 'test2@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test3', 'pass3', 'test3@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test4', 'pass4', 'test4@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test5', 'pass5', 'test5@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test6', 'pass6', 'test6@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test7', 'pass7', 'test7@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test8', 'pass8', 'test8@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test9', 'pass9', 'test9@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test10', 'pass10', 'test10@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test11', 'pass11', 'test11@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test12', 'pass12', 'test12@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test13', 'pass13', 'test13@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test14', 'pass14', 'test14@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test15', 'pass15', 'test15@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test16', 'pass16', 'test16@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test17', 'pass17', 'test17@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test18', 'pass18', 'test18@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test19', 'pass19', 'test19@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test20', 'pass20', 'test20@example.com');
INSERT INTO tbl_user (username, password, email) VALUES ('test21', 'pass21', 'test21@example.com');

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `wearxplay` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `wearxplay` ;

CREATE  TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(45) NULL ,
  `password` VARCHAR(100) NULL ,
  `cover_photo` VARCHAR(45) NULL ,
  `profile_photo` VARCHAR(45) NULL ,
  `email` VARCHAR(100) NULL ,
  `key` VARCHAR(100) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;

CREATE  TABLE IF NOT EXISTS `athletes` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(100) NULL ,
  `sport` VARCHAR(100) NULL ,
  `bio` TEXT NULL ,
  `brand` VARCHAR(45) NULL ,
  `profile_photo` VARCHAR(45) NULL ,
  `cover_photo` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;

CREATE  TABLE IF NOT EXISTS `gears` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(1000) NULL ,
  `description` TEXT NULL ,
  `type` VARCHAR(45) NOT NULL ,
  `brand` VARCHAR(45) NULL ,
  `gender` VARCHAR(45) NOT NULL ,
  `sport` VARCHAR(100) NOT NULL ,
  `likes` INT NULL ,
  `buy_url` TEXT NULL ,
  `price` FLOAT NULL ,
  `color_images` TEXT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;

CREATE  TABLE IF NOT EXISTS `votes` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `athletes_id` INT NOT NULL ,
  `match_date` DATE NULL ,
  `match_title` VARCHAR(100) NULL ,
  `match_description` TEXT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_votes_athletes1_idx` (`athletes_id` ASC) ,
  UNIQUE INDEX `athletes_id_UNIQUE` (`athletes_id` ASC) ,
  CONSTRAINT `fk_votes_athletes1`
    FOREIGN KEY (`athletes_id` )
    REFERENCES `athletes` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE  TABLE IF NOT EXISTS `comments` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `gears_id` INT NOT NULL ,
  `users_id` INT NOT NULL ,
  `comment` TEXT NULL ,
  `rate` INT NULL ,
  PRIMARY KEY (`id`, `gears_id`, `users_id`) ,
  INDEX `fk_comments_products1_idx` (`gears_id` ASC) ,
  INDEX `fk_comments_users1_idx` (`users_id` ASC) ,
  CONSTRAINT `fk_comments_products1`
    FOREIGN KEY (`gears_id` )
    REFERENCES `gears` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_comments_users1`
    FOREIGN KEY (`users_id` )
    REFERENCES `users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE  TABLE IF NOT EXISTS `user_favourites` (
  `users_id` INT NOT NULL ,
  `gears_id` INT NOT NULL ,
  PRIMARY KEY (`users_id`, `gears_id`) ,
  INDEX `fk_users_has_products_products1_idx` (`gears_id` ASC) ,
  INDEX `fk_users_has_products_users_idx` (`users_id` ASC) ,
  CONSTRAINT `fk_users_has_products_users`
    FOREIGN KEY (`users_id` )
    REFERENCES `users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_has_products_products1`
    FOREIGN KEY (`gears_id` )
    REFERENCES `gears` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


CREATE  TABLE IF NOT EXISTS `users_follow_athletes` (
  `users_id` INT NOT NULL ,
  `athletes_id` INT NOT NULL ,
  PRIMARY KEY (`users_id`, `athletes_id`) ,
  INDEX `fk_users_has_athletes_athletes1_idx` (`athletes_id` ASC) ,
  INDEX `fk_users_has_athletes_users1_idx` (`users_id` ASC) ,
  CONSTRAINT `fk_users_has_athletes_users1`
    FOREIGN KEY (`users_id` )
    REFERENCES `users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_has_athletes_athletes1`
    FOREIGN KEY (`athletes_id` )
    REFERENCES `athletes` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



CREATE  TABLE IF NOT EXISTS `brands` (
  `name` VARCHAR(100) NOT NULL ,
  `logo_url` TEXT NULL ,
  PRIMARY KEY (`name`) )
ENGINE = InnoDB;



CREATE  TABLE IF NOT EXISTS `athlete_gears` (
  `athletes_id` INT NOT NULL ,
  `gears_id` INT NOT NULL ,
  `endorsed` INT NULL ,
  PRIMARY KEY (`athletes_id`, `gears_id`) ,
  INDEX `fk_athletes_has_products_products1_idx` (`gears_id` ASC) ,
  INDEX `fk_athletes_has_products_athletes1_idx` (`athletes_id` ASC) ,
  CONSTRAINT `fk_athletes_has_products_athletes1`
    FOREIGN KEY (`athletes_id` )
    REFERENCES `athletes` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_athletes_has_products_products1`
    FOREIGN KEY (`gears_id` )
    REFERENCES `gears` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


CREATE  TABLE IF NOT EXISTS `gear_votes` (
  `gears_id` INT NOT NULL ,
  `votes_id` INT NOT NULL ,
  `votes` INT NULL ,
  PRIMARY KEY (`gears_id`, `votes_id`) ,
  INDEX `fk_votes_has_products_products1_idx` (`gears_id` ASC) ,
  INDEX `fk_votes_has_products_votes1_idx` (`votes_id` ASC) ,
  CONSTRAINT `fk_votes_has_products_votes1`
    FOREIGN KEY (`votes_id` )
    REFERENCES `votes` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_votes_has_products_products1`
    FOREIGN KEY (`gears_id` )
    REFERENCES `gears` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


CREATE  TABLE IF NOT EXISTS `feeds` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `read` INT NULL ,
  `record_timestamp` TIMESTAMP NULL ,
  `feed` TEXT NULL ,
  `type` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


CREATE  TABLE IF NOT EXISTS `user_friends` (
  `users_id` INT NOT NULL ,
  `friend_id` INT NOT NULL ,
  `status` VARCHAR(45) NULL ,
  PRIMARY KEY (`users_id`, `friend_id`) ,
  INDEX `fk_users_has_users_users2_idx` (`friend_id` ASC) ,
  INDEX `fk_users_has_users_users1_idx` (`users_id` ASC) ,
  CONSTRAINT `fk_users_has_users_users1`
    FOREIGN KEY (`users_id` )
    REFERENCES `users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_has_users_users2`
    FOREIGN KEY (`friend_id` )
    REFERENCES `users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


CREATE  TABLE IF NOT EXISTS `features` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `athletes_id` INT NOT NULL ,
  `description` VARCHAR(45) NULL ,
  `cover_photo` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_features_athletes1_idx` (`athletes_id` ASC) ,
  CONSTRAINT `fk_features_athletes1`
    FOREIGN KEY (`athletes_id` )
    REFERENCES `athletes` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `wearxplay` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


START TRANSACTION;
USE `wearxplay`;
INSERT INTO `users` (`id`, `username`, `password`, `cover_photo`, `profile_photo`, `email`, `key`) VALUES (1, 'admin', 'admin123', NULL, NULL, NULL, 'admin123');

COMMIT;
