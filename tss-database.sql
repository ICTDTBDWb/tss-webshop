-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema tss
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema tss
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `tss` DEFAULT CHARACTER SET utf8 ;
USE `tss` ;

-- -----------------------------------------------------
-- Table `tss`.`medewerkers`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tss`.`medewerkers` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `rol` ENUM('klantenservice', 'webredacteur', 'seospecialist') NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `voornaam` VARCHAR(45) NULL,
  `tussenvoegsel` VARCHAR(255) NULL,
  `achternaam` VARCHAR(255) NULL,
  `straat` VARCHAR(255) NULL,
  `huisnummer` VARCHAR(255) NULL,
  `postcode` VARCHAR(255) NULL,
  `woonplaats` VARCHAR(255) NULL,
  `land` VARCHAR(255) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tss`.`klanten`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tss`.`klanten` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `voornaam` VARCHAR(255) NULL,
  `tussenvoegsel` VARCHAR(255) NULL,
  `achternaam` VARCHAR(255) NULL,
  `straat` VARCHAR(255) NULL,
  `huisnummer` VARCHAR(255) NULL,
  `postcode` VARCHAR(255) NULL,
  `woonplaats` VARCHAR(255) NULL,
  `land` VARCHAR(255) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tss`.`producten`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tss`.`producten` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `naam` VARCHAR(255) NOT NULL,
  `prijs` DOUBLE(12,2) NOT NULL,
  `aantal` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tss`.`categorieen`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tss`.`categorieen` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `naam` VARCHAR(255) NOT NULL,
  `beschrijving` VARCHAR(255) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tss`.`product_categorieen`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tss`.`product_categorieen` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` BIGINT UNSIGNED NOT NULL,
  `categorie_id` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `categorie_id`, `product_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `product_id_idx` (`product_id` ASC) VISIBLE,
  INDEX `categorie_id_idx` (`categorie_id` ASC) VISIBLE,
  CONSTRAINT `fk_product_id_product_categorieen`
    FOREIGN KEY (`product_id`)
    REFERENCES `tss`.`producten` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_categorie_id_product_categorieen`
    FOREIGN KEY (`categorie_id`)
    REFERENCES `tss`.`categorieen` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tss`.`verzendmethoden`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tss`.`verzendmethoden` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `naam` VARCHAR(255) NOT NULL,
  `verzendkosten` DOUBLE(12,2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tss`.`bestellingen`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tss`.`bestellingen` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `klant_id` BIGINT UNSIGNED NOT NULL,
  `verzendmethode_id` BIGINT UNSIGNED NOT NULL,
  `besteldatum` DATETIME NOT NULL,
  `totaal` DOUBLE(12,2) NOT NULL,
  `voornaam` VARCHAR(255) NULL,
  `tussenvoegsel` VARCHAR(255) NULL,
  `achternaam` VARCHAR(255) NULL,
  `straat` VARCHAR(255) NULL,
  `huisnummer` VARCHAR(255) NULL,
  `postcode` VARCHAR(255) NULL,
  `woonplaats` VARCHAR(255) NULL,
  `land` VARCHAR(255) NULL,
  PRIMARY KEY (`id`, `klant_id`, `verzendmethode_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `klant_id_idx` (`klant_id` ASC) VISIBLE,
  INDEX `verzendmethode_id_idx` (`verzendmethode_id` ASC) VISIBLE,
  CONSTRAINT `fk_klant_id_bestellingen`
    FOREIGN KEY (`klant_id`)
    REFERENCES `tss`.`klanten` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_verzendmethode_id_bestellingen`
    FOREIGN KEY (`verzendmethode_id`)
    REFERENCES `tss`.`verzendmethoden` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tss`.`cadeaubonnen`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tss`.`cadeaubonnen` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(25) NOT NULL,
  `pin` VARCHAR(11) NOT NULL,
  `bedrag` DOUBLE(12,2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tss`.`bestelling_regels`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tss`.`bestelling_regels` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `bestelling_id` BIGINT UNSIGNED NOT NULL,
  `product_id` BIGINT UNSIGNED NOT NULL,
  `cadeaubon_id` BIGINT UNSIGNED NULL DEFAULT NULL,
  `aantal` INT(11) NOT NULL,
  `stukprijs` DOUBLE(12,2) NOT NULL,
  `totaal` DOUBLE(12,2) NOT NULL,
  PRIMARY KEY (`id`, `bestelling_id`, `product_id`),
  INDEX `bestelling_id_idx` (`bestelling_id` ASC) VISIBLE,
  INDEX `product_id_idx` (`product_id` ASC) VISIBLE,
  INDEX `cadeaubon_id_idx` (`cadeaubon_id` ASC) VISIBLE,
  CONSTRAINT `fk_bestelling_id_bestelling_regels`
    FOREIGN KEY (`bestelling_id`)
    REFERENCES `tss`.`bestellingen` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_id_bestelling_regels`
    FOREIGN KEY (`product_id`)
    REFERENCES `tss`.`producten` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cadeaubon_id_bestelling_regels`
    FOREIGN KEY (`cadeaubon_id`)
    REFERENCES `tss`.`cadeaubonnen` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `tss`.`facturen`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tss`.`facturen` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `bestelling_id` BIGINT UNSIGNED NOT NULL,
  `datum` DATETIME NOT NULL,
  `totaal` DOUBLE(12,2) NOT NULL,
  PRIMARY KEY (`id`, `bestelling_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `bestelling_id_idx` (`bestelling_id` ASC) VISIBLE,
  CONSTRAINT `fk_bestelling_id_facturen`
    FOREIGN KEY (`bestelling_id`)
    REFERENCES `tss`.`bestellingen` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tss`.`betalingen`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tss`.`betalingen` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `bestelling_id` BIGINT UNSIGNED NOT NULL,
  `betalingsprovider` VARCHAR(45) NOT NULL,
  `datum` DATETIME NOT NULL,
  `totaal` DOUBLE(12,2) NOT NULL,
  PRIMARY KEY (`id`, `bestelling_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `bestelling_id_idx` (`bestelling_id` ASC) VISIBLE,
  CONSTRAINT `fk_bestelling_id_betalingen`
    FOREIGN KEY (`bestelling_id`)
    REFERENCES `tss`.`bestellingen` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tss`.`media`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tss`.`media` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` BIGINT UNSIGNED NOT NULL,
  `naam` VARCHAR(255) NOT NULL,
  `pad` VARCHAR(255) NOT NULL,
  `extensie` VARCHAR(255) NULL,
  PRIMARY KEY (`id`, `product_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `product_id_idx` (`product_id` ASC) VISIBLE,
  CONSTRAINT `fk_product_id_media`
    FOREIGN KEY (`product_id`)
    REFERENCES `tss`.`producten` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
