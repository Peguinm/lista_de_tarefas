
-- Criando o banco
CREATE SCHEMA IF NOT EXISTS `tasklist` DEFAULT CHARACTER SET utf8mb4 ;
USE `tasklist` ;


-- Tabela de tasks
CREATE TABLE IF NOT EXISTS `tasklist`.`tasks` (
  `taskId` INT(11) NOT NULL AUTO_INCREMENT,
  `taskname` VARCHAR(50) NOT NULL,
  `description` VARCHAR(500) NOT NULL,
  `date` DATE NOT NULL,
  `userKey` INT(11) NOT NULL,
  `priority` INT(1) NOT NULL,
  PRIMARY KEY (`taskId`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- Tabela de usuários
CREATE TABLE IF NOT EXISTS `tasklist`.`users` (
  `userId` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`userId`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;
