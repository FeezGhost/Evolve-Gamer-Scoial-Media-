-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema Evolve
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema Evolve
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `Evolve` DEFAULT CHARACTER SET utf8 ;
USE `Evolve` ;

-- -----------------------------------------------------
-- Table `Evolve`.`Gamers`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Evolve`.`Gamers` (
  `idGamers` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `fname` VARCHAR(45) NULL,
  `lname` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `password` VARCHAR(45) NULL,
  `gender` VARCHAR(45) NULL,
  PRIMARY KEY (`idGamers`, `username`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Evolve`.`Servers`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Evolve`.`Servers` (
  `idServers` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `area` VARCHAR(45) NULL,
  `platform` VARCHAR(45) NULL,
  `adminID` VARCHAR(45) NULL,
  `created_on` TIMESTAMP(6) NULL,
  PRIMARY KEY (`idServers`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Evolve`.`Games`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Evolve`.`Games` (
  `idGames` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `developed by` VARCHAR(45) NULL,
  PRIMARY KEY (`idGames`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Evolve`.`Server_Posts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Evolve`.`Server_Posts` (
  `idServer_Posts` INT NOT NULL,
  `title` VARCHAR(45) NULL,
  `details` LONGTEXT NULL,
  `posted_at` TIMESTAMP(6) NULL,
  `Servers_idServers` INT NOT NULL,
  PRIMARY KEY (`idServer_Posts`, `Servers_idServers`),
  INDEX `fk_Server_Posts_Servers1_idx` (`Servers_idServers` ASC) ,
  CONSTRAINT `fk_Server_Posts_Servers1`
    FOREIGN KEY (`Servers_idServers`)
    REFERENCES `Evolve`.`Servers` (`idServers`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Evolve`.`Server_Chat`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Evolve`.`Server_Chat` (
  `idServer_Chat` INT NOT NULL AUTO_INCREMENT,
  `sentby` INT NULL,
  `server_id` INT NULL,
  `Servers_idServers` INT NOT NULL,
  `createdOn` TIMESTAMP(6) NULL,
  PRIMARY KEY (`idServer_Chat`, `Servers_idServers`),
  INDEX `fk_Server_Chat_Servers1_idx` (`Servers_idServers` ASC) ,
  CONSTRAINT `fk_Server_Chat_Servers1`
    FOREIGN KEY (`Servers_idServers`)
    REFERENCES `Evolve`.`Servers` (`idServers`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Evolve`.`Server_Media`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Evolve`.`Server_Media` (
  `Servers_idServers` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(250) NULL,
  `folder` VARCHAR(45) NULL,
  `size` VARCHAR(45) NULL,
  `address` VARCHAR(250) NULL,
  `created_on` TIMESTAMP(6) NULL,
  PRIMARY KEY (`Servers_idServers`),
  CONSTRAINT `fk_Server_Media_Servers1`
    FOREIGN KEY (`Servers_idServers`)
    REFERENCES `Evolve`.`Servers` (`idServers`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Evolve`.`Gamers_Media`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Evolve`.`Gamers_Media` (
  `Gamers_idGamers` INT NOT NULL AUTO_INCREMENT,
  `Gamers_username` VARCHAR(45) NOT NULL,
  `name` VARCHAR(250) NULL,
  `folder` VARCHAR(45) NULL,
  `size` VARCHAR(45) NULL,
  `address` VARCHAR(250) NULL,
  `created_on` TIMESTAMP(6) NULL,
  PRIMARY KEY (`Gamers_idGamers`, `Gamers_username`),
  CONSTRAINT `fk_Gamers_Media_Gamers1`
    FOREIGN KEY (`Gamers_idGamers` , `Gamers_username`)
    REFERENCES `Evolve`.`Gamers` (`idGamers` , `username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Evolve`.`Game_Genre`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Evolve`.`Game_Genre` (
  `idGame_Genre` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`idGame_Genre`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Evolve`.`Gamers_Post`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Evolve`.`Gamers_Post` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NULL,
  `details` LONGTEXT NULL,
  `posted_at` TIMESTAMP(6) NULL,
  `Gamers_idGamers` INT NOT NULL,
  `Gamers_username` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`, `Gamers_idGamers`, `Gamers_username`),
  INDEX `fk_Gamers_Post_Gamers1_idx` (`Gamers_idGamers` ASC, `Gamers_username` ASC) ,
  CONSTRAINT `fk_Gamers_Post_Gamers1`
    FOREIGN KEY (`Gamers_idGamers` , `Gamers_username`)
    REFERENCES `Evolve`.`Gamers` (`idGamers` , `username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Evolve`.`Gamers_has_Servers`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Evolve`.`Gamers_has_Servers` (
  `Gamers_idGamers` INT NOT NULL,
  `Gamers_username` VARCHAR(45) NOT NULL,
  `Servers_idServers` INT NOT NULL,
  PRIMARY KEY (`Gamers_idGamers`, `Gamers_username`, `Servers_idServers`),
  INDEX `fk_Gamers_has_Servers_Servers1_idx` (`Servers_idServers` ASC) ,
  INDEX `fk_Gamers_has_Servers_Gamers_idx` (`Gamers_idGamers` ASC, `Gamers_username` ASC) ,
  CONSTRAINT `fk_Gamers_has_Servers_Gamers`
    FOREIGN KEY (`Gamers_idGamers` , `Gamers_username`)
    REFERENCES `Evolve`.`Gamers` (`idGamers` , `username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Gamers_has_Servers_Servers1`
    FOREIGN KEY (`Servers_idServers`)
    REFERENCES `Evolve`.`Servers` (`idServers`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Evolve`.`Gamer_Game`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Evolve`.`Gamer_Game` (
  `Games_idGames` INT NOT NULL,
  `Gamers_idGamers` INT NOT NULL,
  `Gamers_username` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Games_idGames`, `Gamers_idGamers`, `Gamers_username`),
  INDEX `fk_Games_has_Gamers_Gamers1_idx` (`Gamers_idGamers` ASC, `Gamers_username` ASC) ,
  INDEX `fk_Games_has_Gamers_Games1_idx` (`Games_idGames` ASC) ,
  CONSTRAINT `fk_Games_has_Gamers_Games1`
    FOREIGN KEY (`Games_idGames`)
    REFERENCES `Evolve`.`Games` (`idGames`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Games_has_Gamers_Gamers1`
    FOREIGN KEY (`Gamers_idGamers` , `Gamers_username`)
    REFERENCES `Evolve`.`Gamers` (`idGamers` , `username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Evolve`.`Server_Games`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Evolve`.`Server_Games` (
  `Games_idGames` INT NOT NULL,
  `Servers_idServers` INT NOT NULL,
  PRIMARY KEY (`Games_idGames`, `Servers_idServers`),
  INDEX `fk_Games_has_Servers_Servers1_idx` (`Servers_idServers` ASC) ,
  INDEX `fk_Games_has_Servers_Games1_idx` (`Games_idGames` ASC) ,
  CONSTRAINT `fk_Games_has_Servers_Games1`
    FOREIGN KEY (`Games_idGames`)
    REFERENCES `Evolve`.`Games` (`idGames`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Games_has_Servers_Servers1`
    FOREIGN KEY (`Servers_idServers`)
    REFERENCES `Evolve`.`Servers` (`idServers`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Evolve`.`Games_has_Genre`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Evolve`.`Games_has_Genre` (
  `Games_idGames` INT NOT NULL,
  `Game_Genre_idGame_Genre` INT NOT NULL,
  PRIMARY KEY (`Games_idGames`, `Game_Genre_idGame_Genre`),
  INDEX `fk_Games_has_Game_Genre_Game_Genre1_idx` (`Game_Genre_idGame_Genre` ASC) ,
  INDEX `fk_Games_has_Game_Genre_Games1_idx` (`Games_idGames` ASC) ,
  CONSTRAINT `fk_Games_has_Game_Genre_Games1`
    FOREIGN KEY (`Games_idGames`)
    REFERENCES `Evolve`.`Games` (`idGames`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Games_has_Game_Genre_Game_Genre1`
    FOREIGN KEY (`Game_Genre_idGame_Genre`)
    REFERENCES `Evolve`.`Game_Genre` (`idGame_Genre`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Evolve`.`Interested_Servers`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Evolve`.`Interested_Servers` (
  `Gamers_idGamers` INT NOT NULL,
  `Gamers_username` VARCHAR(45) NOT NULL,
  `Servers_idServers` INT NOT NULL,
  PRIMARY KEY (`Gamers_idGamers`, `Gamers_username`, `Servers_idServers`),
  INDEX `fk_Gamers_has_Servers1_Servers1_idx` (`Servers_idServers` ASC) ,
  INDEX `fk_Gamers_has_Servers1_Gamers1_idx` (`Gamers_idGamers` ASC, `Gamers_username` ASC) ,
  CONSTRAINT `fk_Gamers_has_Servers1_Gamers1`
    FOREIGN KEY (`Gamers_idGamers` , `Gamers_username`)
    REFERENCES `Evolve`.`Gamers` (`idGamers` , `username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Gamers_has_Servers1_Servers1`
    FOREIGN KEY (`Servers_idServers`)
    REFERENCES `Evolve`.`Servers` (`idServers`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Evolve`.`Direct_Messages`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Evolve`.`Direct_Messages` (
  `sender_id` INT NOT NULL,
  `sender_username` VARCHAR(45) NOT NULL,
  `receiver_id` INT NOT NULL,
  `receiver_username` VARCHAR(45) NOT NULL,
  `message` LONGTEXT NULL,
  `createdon` TIMESTAMP(6) NULL,
  PRIMARY KEY (`sender_id`, `sender_username`, `receiver_id`, `receiver_username`),
  INDEX `fk_Gamers_has_Gamers_Gamers2_idx` (`receiver_id` ASC, `receiver_username` ASC) ,
  INDEX `fk_Gamers_has_Gamers_Gamers1_idx` (`sender_id` ASC, `sender_username` ASC) ,
  CONSTRAINT `fk_Gamers_has_Gamers_Gamers1`
    FOREIGN KEY (`sender_id` , `sender_username`)
    REFERENCES `Evolve`.`Gamers` (`idGamers` , `username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Gamers_has_Gamers_Gamers2`
    FOREIGN KEY (`receiver_id` , `receiver_username`)
    REFERENCES `Evolve`.`Gamers` (`idGamers` , `username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Evolve`.`Server_Cover`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Evolve`.`Server_Cover` (
  `idServer_Cover` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(250) NULL,
  `folder` VARCHAR(45) NULL,
  `address` VARCHAR(245) NULL,
  `size` VARCHAR(45) NULL,
  `createdOn` TIMESTAMP(6) NULL,
  `Servers_idServers` INT NOT NULL,
  PRIMARY KEY (`idServer_Cover`, `Servers_idServers`),
  INDEX `fk_Server_Cover_Servers1_idx` (`Servers_idServers` ASC) ,
  CONSTRAINT `fk_Server_Cover_Servers1`
    FOREIGN KEY (`Servers_idServers`)
    REFERENCES `Evolve`.`Servers` (`idServers`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Evolve`.`Server_Profile`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Evolve`.`Server_Profile` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(250) NULL,
  `folder` VARCHAR(45) NULL,
  `address` VARCHAR(245) NULL,
  `size` VARCHAR(45) NULL,
  `createdOn` TIMESTAMP(6) NULL,
  `Servers_idServers` INT NOT NULL,
  PRIMARY KEY (`id`, `Servers_idServers`),
  INDEX `fk_Server_Profile_Servers1_idx` (`Servers_idServers` ASC) ,
  CONSTRAINT `fk_Server_Profile_Servers1`
    FOREIGN KEY (`Servers_idServers`)
    REFERENCES `Evolve`.`Servers` (`idServers`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Evolve`.`Gamer_Profile`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Evolve`.`Gamer_Profile` (
  `idServer_Cover` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(250) NULL,
  `folder` VARCHAR(45) NULL,
  `address` VARCHAR(245) NULL,
  `size` VARCHAR(45) NULL,
  `createdOn` TIMESTAMP(6) NULL,
  `Gamers_idGamers` INT NOT NULL,
  `Gamers_username` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idServer_Cover`, `Gamers_idGamers`, `Gamers_username`),
  INDEX `fk_Gamer_Profile_Gamers1_idx` (`Gamers_idGamers` ASC, `Gamers_username` ASC) ,
  CONSTRAINT `fk_Gamer_Profile_Gamers1`
    FOREIGN KEY (`Gamers_idGamers` , `Gamers_username`)
    REFERENCES `Evolve`.`Gamers` (`idGamers` , `username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Evolve`.`Gamer_Cover`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Evolve`.`Gamer_Cover` (
  `idServer_Cover` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(250) NULL,
  `folder` VARCHAR(45) NULL,
  `address` VARCHAR(245) NULL,
  `size` VARCHAR(45) NULL,
  `createdOn` TIMESTAMP(6) NULL,
  `Gamers_idGamers` INT NOT NULL,
  `Gamers_username` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idServer_Cover`, `Gamers_idGamers`, `Gamers_username`),
  INDEX `fk_Gamer_Cover_Gamers1_idx` (`Gamers_idGamers` ASC, `Gamers_username` ASC) ,
  CONSTRAINT `fk_Gamer_Cover_Gamers1`
    FOREIGN KEY (`Gamers_idGamers` , `Gamers_username`)
    REFERENCES `Evolve`.`Gamers` (`idGamers` , `username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
