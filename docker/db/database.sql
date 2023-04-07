
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema cooper_leite
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `cooper_leite` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `cooper_leite` ;

-- -----------------------------------------------------
-- Table `cooper_leite`.`status`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `status` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `tipo` VARCHAR(45) NULL,
  `created_at` DATETIME NULL DEFAULT now(),
  `updated_at` DATETIME NULL DEFAULT now(),
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cooper_leite`.`groups`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `groups` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `created_at` DATETIME NULL DEFAULT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  `status` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_groups_status1_idx` (`status` ASC))
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `cooper_leite`.`clientes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clientes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `tipo_pessoa` VARCHAR(1) NOT NULL DEFAULT 'F',
  `papel` VARCHAR(1) NOT NULL DEFAULT 'C',
  `created_at` DATETIME NULL DEFAULT now(),
  `updated_at` DATETIME NULL DEFAULT now(),
  `status` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_clientes_status1_idx` (`status` ASC) ,
  CONSTRAINT `fk_clientes_status1`
    FOREIGN KEY (`status`)
    REFERENCES `status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cooper_leite`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `login` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NULL DEFAULT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  `group_id` INT NOT NULL,
  `cliente_id` INT NOT NULL,
  `status` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_users_groups_idx` (`group_id` ASC) ,
  INDEX `fk_users_clientes1_idx` (`cliente_id` ASC) ,
  INDEX `fk_users_status1_idx` (`status` ASC) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `cooper_leite`.`status_pedidos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `status_pedidos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `tipo` VARCHAR(45) NULL,
  `created_at` DATETIME NULL DEFAULT now(),
  `status` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_status_pedidos_status1_idx` (`status` ASC),
  CONSTRAINT `fk_status_pedidos_status1`
    FOREIGN KEY (`status`)
    REFERENCES `status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cooper_leite`.`pedidos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `dt_entrega` DATETIME NOT NULL,
  `dt_pedido` DATETIME NOT NULL,
  `qtd_produtos` INT NOT NULL,
  `vl_total` DECIMAL(10,6) NOT NULL,
  `created_at` DATETIME NULL DEFAULT now(),
  `updated_at` DATETIME NULL DEFAULT now(),
  `cliente_id` INT NOT NULL,
  `status` INT NOT NULL,
  `status_pedido_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_pedidos_clientes1_idx` (`cliente_id` ASC) ,
  INDEX `fk_pedidos_status1_idx` (`status` ASC) ,
  INDEX `fk_pedidos_status_pedidos1_idx` (`status_pedido_id` ASC) ,
  CONSTRAINT `fk_pedidos_clientes1`
    FOREIGN KEY (`cliente_id`)
    REFERENCES `clientes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedidos_status1`
    FOREIGN KEY (`status`)
    REFERENCES `status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedidos_status_pedidos1`
    FOREIGN KEY (`status_pedido_id`)
    REFERENCES `status_pedidos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cooper_leite`.`pessoa_fisicas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pessoa_fisicas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome_civil` VARCHAR(255) NULL,
  `dt_nascimento` DATETIME NULL,
  `cpf` VARCHAR(14) NULL,
  `rg` VARCHAR(10) NULL,
  `created_at` DATETIME NULL DEFAULT now(),
  `updated_at` DATETIME NULL DEFAULT now(),
  `cliente_id` INT NOT NULL,
  `status` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_pessoa_fisicas_clientes1_idx` (`cliente_id` ASC) ,
  INDEX `fk_pessoa_fisicas_status1_idx` (`status` ASC) ,
  CONSTRAINT `fk_pessoa_fisicas_clientes1`
    FOREIGN KEY (`cliente_id`)
    REFERENCES `clientes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pessoa_fisicas_status1`
    FOREIGN KEY (`status`)
    REFERENCES `status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cooper_leite`.`pessoa_juridicas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pessoa_juridicas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `cnpj` VARCHAR(18) NOT NULL,
  `razao_social` VARCHAR(255) NULL,
  `created_at` DATETIME NULL DEFAULT now(),
  `updated_at` DATETIME NULL DEFAULT now(),
  `cliente_id` INT NOT NULL,
  `status` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_pessoa_juridicas_clientes1_idx` (`cliente_id` ASC) ,
  INDEX `fk_pessoa_juridicas_status1_idx` (`status` ASC) ,
  CONSTRAINT `fk_pessoa_juridicas_clientes1`
    FOREIGN KEY (`cliente_id`)
    REFERENCES `clientes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pessoa_juridicas_status1`
    FOREIGN KEY (`status`)
    REFERENCES `status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cooper_leite`.`funcionarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `funcionarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `cargo` VARCHAR(45) NULL,
  `users_id` INT NOT NULL,
  `cliente_id` INT NOT NULL,
  `status` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_funcionarios_users1_idx` (`users_id` ASC) ,
  INDEX `fk_funcionarios_clientes1_idx` (`cliente_id` ASC) ,
  INDEX `fk_funcionarios_status1_idx` (`status` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cooper_leite`.`produtos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `produtos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(255) NULL,
  `unidade` VARCHAR(45) NULL,
  `created_at` DATETIME NULL DEFAULT now(),
  `updated_at` DATETIME NULL DEFAULT now(),
  `status` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cooper_leite`.`pedido_itens`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pedido_itens` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `qtd` DECIMAL(10,6) NOT NULL,
  `valor_unitario` DECIMAL(10,6) NOT NULL,
  `preco` DECIMAL(10,2) NULL,
  `preco_total` DECIMAL(10,2) NULL,
  `pedido_id` INT NOT NULL,
  `produto_id` INT NOT NULL,
  `status` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_pedido_itens_pedidos1_idx` (`pedido_id` ASC) ,
  INDEX `fk_pedido_itens_produtos1_idx` (`produto_id` ASC) ,
  CONSTRAINT `fk_pedido_itens_pedidos1`
    FOREIGN KEY (`pedido_id`)
    REFERENCES `pedidos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedido_itens_produtos1`
    FOREIGN KEY (`produto_id`)
    REFERENCES `produtos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
