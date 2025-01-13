-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `ecommerce_db` DEFAULT CHARACTER SET utf8 ;
USE `ecommerce_db` ;

-- -----------------------------------------------------
-- Table `mydb`.`Customers`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ecommerce_db`.`Customers` (
  `CustomerID` INT NOT NULL,
  `Name` VARCHAR(45) NULL,
  `Email` VARCHAR(45) NULL,
  `Phone` VARCHAR(60) NULL,
  `Address` LINESTRING NULL,
  PRIMARY KEY (`CustomerID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce_db`.`Orders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ecommerce_db`.`Orders` (
  `OrderID` INT NOT NULL,
  `OrderDate` DATETIME NULL,
  `TotalAmount` DOUBLE NULL,
  `CustomerID` INT NOT NULL,
  PRIMARY KEY (`OrderID`),
  UNIQUE INDEX `CustomerID_UNIQUE` (`CustomerID` ASC) VISIBLE,
  CONSTRAINT `CustomerID`
    FOREIGN KEY (`CustomerID`)
    REFERENCES `ecommerce_db`.`Customers` (`CustomerID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce_db`.`Categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ecommerce_db`.`Categories` (
  `CategoryID` INT NOT NULL,
  `CategoryName` VARCHAR(45) NULL,
  PRIMARY KEY (`CategoryID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce_db`.`Products`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ecommerce_db`.`Products` (
  `ProductID` INT NOT NULL,
  `ProductName` VARCHAR(45) NULL,
  `Price` DOUBLE NOT NULL,
  `CategoryID` INT NOT NULL,
  `StockQuantity` INT ZEROFILL NOT NULL,
  PRIMARY KEY (`ProductID`),
  UNIQUE INDEX `ProductID_UNIQUE` (`ProductID` ASC) VISIBLE,
  UNIQUE INDEX `CategoryID_UNIQUE` (`CategoryID` ASC) VISIBLE,
  CONSTRAINT `CategoryID`
    FOREIGN KEY (`CategoryID`)
    REFERENCES `ecommerce_db`.`Categories` (`CategoryID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce_db`.`OrderDetails`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `OrderDetails` (
    `OrderDetailID` INT NOT NULL AUTO_INCREMENT,
    `OrderID` INT NOT NULL,
    `ProductID` INT NOT NULL,
    `Quantity` INT NULL,
    `Subtotal` DECIMAL(10, 2) NULL,
    PRIMARY KEY (`OrderDetailID`),
    INDEX `FK_OrderID` (`OrderID`),
    INDEX `FK_ProductID` (`ProductID`),
    CONSTRAINT `FK_OrderID`
        FOREIGN KEY (`OrderID`)
        REFERENCES `Orders` (`OrderID`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT `FK_ProductID`
        FOREIGN KEY (`ProductID`)
        REFERENCES `Products` (`ProductID`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce_db`.`Suppliers`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ecommerce_db`.`Suppliers` (
  `SupplierID` INT NOT NULL,
  `SupplierName` VARCHAR(45) NULL,
  `ContactInfo` VARCHAR(45) NULL,
  PRIMARY KEY (`SupplierID`),
  UNIQUE INDEX `SupplierID_UNIQUE` (`SupplierID` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce_db`.`Reviews`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ecommerce_db`.`Reviews` (
  `ReviewID` INT NOT NULL,
  `ProductID` INT NOT NULL,
  `CustomerID` INT NOT NULL,
  `Rating` FLOAT NULL,
  `Comment` MULTILINESTRING NULL,
  `ReviewDate` DATETIME NULL,
  PRIMARY KEY (`ReviewID`),
  UNIQUE INDEX `ReviewID_UNIQUE` (`ReviewID` ASC),
  UNIQUE INDEX `ProductID_UNIQUE` (`ProductID` ASC),
  UNIQUE INDEX `CustomerID_UNIQUE` (`CustomerID` ASC),
  CONSTRAINT `ProductID`
    FOREIGN KEY (`ProductID`)
    REFERENCES `ecommerce_db`.`Products` (`ProductID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `CustomerID`
    FOREIGN KEY (`CustomerID`)
    REFERENCES `ecommerce_db`.`Customers` (`CustomerID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce_db`.`Shipping`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ecommerce_db`.`Shipping` (
  `ShippingID` INT NOT NULL,
  `OrderID` INT NOT NULL,
  `ShippingDate` DATETIME NULL,
  `ShippingStatus` VARCHAR(45) NULL,
  PRIMARY KEY (`ShippingID`),
  UNIQUE INDEX `ShippingID_UNIQUE` (`ShippingID` ASC),
  UNIQUE INDEX `OrderID_UNIQUE` (`OrderID` ASC),
  CONSTRAINT `OrderID`
    FOREIGN KEY (`OrderID`)
    REFERENCES `ecommerce_db`.`OrderDetails` (`OrderID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce_db`.`Supplier-Products`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ecommerce_db`.`Supplier-Products` (
  `SupplierProductID` INT NOT NULL,
  `SupplierID` INT NOT NULL,
  `ProductID` INT NOT NULL,
  PRIMARY KEY (`SupplierProductID`),
  UNIQUE INDEX `SupplierProductID_UNIQUE` (`SupplierProductID` ASC),
  UNIQUE INDEX `SupplierID_UNIQUE` (`SupplierID` ASC),
  UNIQUE INDEX `ProductID_UNIQUE` (`ProductID` ASC),
  CONSTRAINT `Product_FK`
    FOREIGN KEY (`ProductID`)
    REFERENCES `ecommerce_db`.`Products` (`ProductID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `Supplier_FK`
    FOREIGN KEY (`SupplierID`)
    REFERENCES `ecommerce_db`.`Suppliers` (`SupplierID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);

ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
