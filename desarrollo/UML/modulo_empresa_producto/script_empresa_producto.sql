-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema nexthor_empresa
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema nexthor_empresa
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `nexthor_empresa` DEFAULT CHARACTER SET latin1 ;
USE `nexthor_empresa` ;

-- -----------------------------------------------------
-- Table `nexthor_empresa`.`pais`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`pais` (
  `idpais` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `nombre` VARCHAR(45) NOT NULL COMMENT '',
  `estado` ENUM('Activo','Inactivo') NOT NULL DEFAULT 'Activo' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`idpais`)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`empresa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`empresa` (
  `idempresa` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `nombre` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NULL DEFAULT NULL COMMENT '',
  `direccion` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NULL DEFAULT NULL COMMENT '',
  `estado` ENUM('Activo','Inactivo') CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL DEFAULT 'Activo' COMMENT '',
  `idpais` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`idempresa`)  COMMENT '',
  INDEX `fk_empresa_idpais_idx` (`idpais` ASC)  COMMENT '',
  CONSTRAINT `fk_empresa_idpais`
    FOREIGN KEY (`idpais`)
    REFERENCES `nexthor_empresa`.`pais` (`idpais`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`departamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`departamento` (
  `iddepartamento` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `nombre` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NULL DEFAULT NULL COMMENT '',
  `idpais` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `estado` ENUM('Activo','Inactivo') CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL DEFAULT 'Activo' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`iddepartamento`)  COMMENT '',
  INDEX `fk_departamento_idpais_idx` (`idpais` ASC)  COMMENT '',
  CONSTRAINT `fk_departamento_idpais`
    FOREIGN KEY (`idpais`)
    REFERENCES `nexthor_empresa`.`pais` (`idpais`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 23
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`municipio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`municipio` (
  `idmunicipio` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `nombre` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NULL DEFAULT NULL COMMENT '',
  `iddepartamento` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `estado` ENUM('Activo','Inactivo') CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL DEFAULT 'Activo' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`idmunicipio`)  COMMENT '',
  INDEX `fk_municipio_iddepartamento_idx` (`iddepartamento` ASC)  COMMENT '',
  CONSTRAINT `fk_municipio_iddepartamento`
    FOREIGN KEY (`iddepartamento`)
    REFERENCES `nexthor_empresa`.`departamento` (`iddepartamento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 51
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`sucursal`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`sucursal` (
  `idsucursal` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `nombre` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NULL DEFAULT NULL COMMENT '',
  `direccion` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NULL DEFAULT NULL COMMENT '',
  `idmunicipio` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `idempresa` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `estado` ENUM('Activo','Inactivo') CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL DEFAULT 'Activo' COMMENT '',
  `credito` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `debito` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`idsucursal`)  COMMENT '',
  INDEX `fk_sucursal_idempresa_idx` (`idempresa` ASC)  COMMENT '',
  INDEX `fk_sucursal_idmunicipio_idx` (`idmunicipio` ASC)  COMMENT '',
  CONSTRAINT `fk_sucursal_idempresa`
    FOREIGN KEY (`idempresa`)
    REFERENCES `nexthor_empresa`.`empresa` (`idempresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sucursal_idmunicipio`
    FOREIGN KEY (`idmunicipio`)
    REFERENCES `nexthor_empresa`.`municipio` (`idmunicipio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`tipo_bodega`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`tipo_bodega` (
  `idtipo_bodega` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `nombre` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NULL DEFAULT NULL COMMENT '',
  `estado` ENUM('Activo','Inactivo') CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL DEFAULT 'Activo' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`idtipo_bodega`)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`bodega`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`bodega` (
  `idbodega` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `descripcion` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NULL DEFAULT NULL COMMENT '',
  `idsucursal` INT(11) NOT NULL COMMENT '',
  `idtipo_bodega` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `estado` ENUM('Activo','Inactivo') CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL DEFAULT 'Activo' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`idbodega`)  COMMENT '',
  INDEX `fk_bodega_idtipo_bodega_idx` (`idtipo_bodega` ASC)  COMMENT '',
  INDEX `fk_bodega_idsucursal_idx` (`idsucursal` ASC)  COMMENT '',
  CONSTRAINT `fk_bodega_idsucursal`
    FOREIGN KEY (`idsucursal`)
    REFERENCES `nexthor_empresa`.`sucursal` (`idsucursal`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bodega_idtipo_bodega`
    FOREIGN KEY (`idtipo_bodega`)
    REFERENCES `nexthor_empresa`.`tipo_bodega` (`idtipo_bodega`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`categoria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`categoria` (
  `idcategoria` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `nombre` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `estado` ENUM('Activo','Inactivo') NOT NULL COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`idcategoria`)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`fabricante`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`fabricante` (
  `idfabricante` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `nombre` VARCHAR(45) NOT NULL COMMENT '',
  `idpais` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `estado` ENUM('Activo','Inactivo') NOT NULL DEFAULT 'Activo' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`idfabricante`)  COMMENT '',
  INDEX `fk_fabricante_idx` (`idpais` ASC)  COMMENT '',
  CONSTRAINT `fk_fabricante`
    FOREIGN KEY (`idpais`)
    REFERENCES `nexthor_empresa`.`pais` (`idpais`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`periodo_contable`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`periodo_contable` (
  `idperiodo_contable` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `idempresa` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `mes` ENUM('1','2','3','4','5','6','7','8','9','10','11','12') NOT NULL DEFAULT '1' COMMENT '',
  `anio` ENUM('2015','2016') NOT NULL DEFAULT '2015' COMMENT '',
  `estado` ENUM('Abierto','Control','Cerrado','Presentado') NOT NULL DEFAULT 'Abierto' COMMENT '',
  `fecha_cierre` DATE NULL DEFAULT NULL COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`idperiodo_contable`)  COMMENT '',
  INDEX `fk_periodo_contable_idempresa_idx` (`idempresa` ASC)  COMMENT '',
  CONSTRAINT `fk_periodo_contable_idempresa`
    FOREIGN KEY (`idempresa`)
    REFERENCES `nexthor_empresa`.`empresa` (`idempresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 25
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`fecha_contable`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`fecha_contable` (
  `idfecha_contable` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `fecha` DATE NULL DEFAULT NULL COMMENT '',
  `estado_documento_debito` ENUM('Abierto','Control','Cerrado','Presentado') NOT NULL DEFAULT 'Abierto' COMMENT '',
  `estado_documento_credito` ENUM('Abierto','Control','Cerrado','Presentado') NOT NULL DEFAULT 'Abierto' COMMENT '',
  `estado_pago_cliente` ENUM('Abierto','Control','Cerrado','Presentado') NOT NULL DEFAULT 'Abierto' COMMENT '',
  `estado_pago_proveedor` ENUM('Abierto','Control','Cerrado','Presentado') NOT NULL DEFAULT 'Abierto' COMMENT '',
  `idperiodo_contable` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `idempresa` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  PRIMARY KEY (`idfecha_contable`)  COMMENT '',
  INDEX `fk_fecha_contable_idperiodo_contable_idx` (`idperiodo_contable` ASC)  COMMENT '',
  INDEX `fk_fecha_contable_idempresa_idx` (`idempresa` ASC)  COMMENT '',
  CONSTRAINT `fk_fecha_contable_idempresa`
    FOREIGN KEY (`idempresa`)
    REFERENCES `nexthor_empresa`.`empresa` (`idempresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_fecha_contable_idperiodo_contable`
    FOREIGN KEY (`idperiodo_contable`)
    REFERENCES `nexthor_empresa`.`periodo_contable` (`idperiodo_contable`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 41
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`marca`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`marca` (
  `idmarca` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `nombre` VARCHAR(45) NOT NULL COMMENT '',
  `idfabricante` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `estado` ENUM('Activo','Inactivo') NOT NULL DEFAULT 'Activo' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`idmarca`)  COMMENT '',
  INDEX `fk_marca_idfabricante_idx` (`idfabricante` ASC)  COMMENT '',
  CONSTRAINT `fk_marca_idfabricante`
    FOREIGN KEY (`idfabricante`)
    REFERENCES `nexthor_empresa`.`fabricante` (`idfabricante`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`meta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`meta` (
  `idmeta` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `idperiodo_contable` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `monto` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `idsucursal` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `estado` ENUM('Activo','Inactivo') NOT NULL DEFAULT 'Activo' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  `cantidad` INT(11) NOT NULL DEFAULT '0' COMMENT '',
  PRIMARY KEY (`idmeta`)  COMMENT '',
  INDEX `fk_meta_idsucursal_idx` (`idsucursal` ASC)  COMMENT '',
  INDEX `fk_meta_idperiodo_contable_idx` (`idperiodo_contable` ASC)  COMMENT '',
  CONSTRAINT `fk_meta_idsucursal`
    FOREIGN KEY (`idsucursal`)
    REFERENCES `nexthor_empresa`.`sucursal` (`idsucursal`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_meta_idperiodo_contable`
    FOREIGN KEY (`idperiodo_contable`)
    REFERENCES `nexthor_empresa`.`periodo_contable` (`idperiodo_contable`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 8
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`moneda`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`moneda` (
  `idmoneda` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `nombre` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `simbolo` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `idpais` INT(11) NULL DEFAULT NULL COMMENT '',
  `tasa_cambio` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `estado` ENUM('Activo','Inactivo') NOT NULL DEFAULT 'Activo' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`idmoneda`)  COMMENT '',
  INDEX `fk_moneda_idpais_idx` (`idpais` ASC)  COMMENT '',
  CONSTRAINT `fk_moneda_idpais`
    FOREIGN KEY (`idpais`)
    REFERENCES `nexthor_empresa`.`pais` (`idpais`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`pago_cliente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`pago_cliente` (
  `idpago_cliente` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `idtipo_pago` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `idcliente` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `monto` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `fecha` DATE NULL DEFAULT NULL COMMENT '',
  `estado` ENUM('Activo','Inactivo') NOT NULL DEFAULT 'Activo' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  `idsucursal` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `idboleta_deposito` INT(11) NULL DEFAULT NULL COMMENT '',
  `idvoucher_tarjeta` INT(11) NULL DEFAULT NULL COMMENT '',
  `idcheque_cliente` INT(11) NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`idpago_cliente`)  COMMENT '',
  INDEX `fk_pago_cliente_idsucursal_idx` (`idsucursal` ASC)  COMMENT '',
  CONSTRAINT `fk_pago_cliente_idsucursal`
    FOREIGN KEY (`idsucursal`)
    REFERENCES `nexthor_empresa`.`sucursal` (`idsucursal`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 10
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`producto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`producto` (
  `idproducto` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `nombre` VARCHAR(45) NOT NULL COMMENT '',
  `idpais` INT(11) NOT NULL COMMENT 'pais de fabricacion',
  `idmarca` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `existencia` INT(11) NOT NULL DEFAULT '0' COMMENT '',
  `estado` ENUM('Activo','Inactivo') NOT NULL DEFAULT 'Activo' COMMENT '',
  `idcategoria` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `precio_venta` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `precio_compra` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  `codigo_barra` VARCHAR(45) NOT NULL DEFAULT '1' COMMENT '',
  `foto` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`idproducto`)  COMMENT '',
  INDEX `fk_producto_idmarca_idx` (`idmarca` ASC)  COMMENT '',
  INDEX `fk_producto_idpais_idx` (`idpais` ASC)  COMMENT '',
  INDEX `fk_producto_idcategoria_idx` (`idcategoria` ASC)  COMMENT '',
  CONSTRAINT `fk_producto_idcategoria`
    FOREIGN KEY (`idcategoria`)
    REFERENCES `nexthor_empresa`.`categoria` (`idcategoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_idmarca`
    FOREIGN KEY (`idmarca`)
    REFERENCES `nexthor_empresa`.`marca` (`idmarca`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_idpais`
    FOREIGN KEY (`idpais`)
    REFERENCES `nexthor_empresa`.`pais` (`idpais`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`producto_sucursal`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`producto_sucursal` (
  `idproducto_sucursal` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `idproducto` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `idsucursal` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `existencia` INT(11) NOT NULL DEFAULT '0' COMMENT '',
  `estado` ENUM('Activo','Inactivo') CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL DEFAULT 'Activo' COMMENT '',
  PRIMARY KEY (`idproducto_sucursal`)  COMMENT '',
  INDEX `fk_producto_sucursal_idsucursal_idx` (`idsucursal` ASC)  COMMENT '',
  INDEX `fk_producto_sucursal_idproducto_idx` (`idproducto` ASC)  COMMENT '',
  CONSTRAINT `fk_producto_sucursal_idproducto`
    FOREIGN KEY (`idproducto`)
    REFERENCES `nexthor_empresa`.`producto` (`idproducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_sucursal_idsucursal`
    FOREIGN KEY (`idsucursal`)
    REFERENCES `nexthor_empresa`.`sucursal` (`idsucursal`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 8
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`producto_bodega`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`producto_bodega` (
  `idproducto_bodega` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `idproducto` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `idbodega` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `existencia` INT(11) NULL DEFAULT '0' COMMENT '',
  `estado` ENUM('Activo','Inactivo') CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL DEFAULT 'Activo' COMMENT '',
  `idproducto_sucursal` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  PRIMARY KEY (`idproducto_bodega`)  COMMENT '',
  INDEX `fk_producto_bodega_idbodega_idx` (`idbodega` ASC)  COMMENT '',
  INDEX `fk_producto_bodega_idproducto_idx` (`idproducto` ASC)  COMMENT '',
  INDEX `fk_producto_bodega_idproducto_sucursal_idx` (`idproducto_sucursal` ASC)  COMMENT '',
  CONSTRAINT `fk_producto_bodega_idbodega`
    FOREIGN KEY (`idbodega`)
    REFERENCES `nexthor_empresa`.`bodega` (`idbodega`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_bodega_idproducto`
    FOREIGN KEY (`idproducto`)
    REFERENCES `nexthor_empresa`.`producto` (`idproducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_bodega_idproducto_sucursal`
    FOREIGN KEY (`idproducto_sucursal`)
    REFERENCES `nexthor_empresa`.`producto_sucursal` (`idproducto_sucursal`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 10
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`producto_historial`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`producto_historial` (
  `idproducto_historial` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `idproducto` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `idbodega` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `idproducto_bodega` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `fecha` DATE NULL DEFAULT NULL COMMENT '',
  `unidades_ingreso` INT(11) NOT NULL DEFAULT '0' COMMENT '',
  `unidades_salida` INT(11) NOT NULL DEFAULT '0' COMMENT '',
  `estado` ENUM('Activo','Inactivo') CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL DEFAULT 'Activo' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  `idrelacion` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `tabla_relacion` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NULL DEFAULT 'detalle_documento_debito' COMMENT '',
  PRIMARY KEY (`idproducto_historial`)  COMMENT '',
  INDEX `fk_producto_historial_idproducto_idx` (`idproducto` ASC)  COMMENT '',
  INDEX `fk_producto_historial_idbodega_idx` (`idbodega` ASC)  COMMENT '',
  INDEX `fk_producto_historial_idproducto_bodega_idx` (`idproducto_bodega` ASC)  COMMENT '',
  CONSTRAINT `fk_producto_historial_idbodega`
    FOREIGN KEY (`idbodega`)
    REFERENCES `nexthor_empresa`.`bodega` (`idbodega`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_historial_idproducto`
    FOREIGN KEY (`idproducto`)
    REFERENCES `nexthor_empresa`.`producto` (`idproducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_historial_idproducto_bodega`
    FOREIGN KEY (`idproducto_bodega`)
    REFERENCES `nexthor_empresa`.`producto_bodega` (`idproducto_bodega`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 54
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`producto_precio_historial`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`producto_precio_historial` (
  `idproducto_precio_historial` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `idproducto` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `fecha` DATE NULL DEFAULT NULL COMMENT '',
  `precio_venta` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `precio_compra` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `estado` ENUM('Activo','Inactivo') NOT NULL DEFAULT 'Activo' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`idproducto_precio_historial`)  COMMENT '',
  INDEX `fk_producto_precio_historial_idproducto_idx` (`idproducto` ASC)  COMMENT '',
  CONSTRAINT `fk_producto_precio_historial_idproducto`
    FOREIGN KEY (`idproducto`)
    REFERENCES `nexthor_empresa`.`producto` (`idproducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`registro_sanitario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`registro_sanitario` (
  `idregistro_sanitario` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `descripcion` VARCHAR(45) NOT NULL COMMENT '',
  `idpais` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `estado` ENUM('Activo','Inactivo') NOT NULL DEFAULT 'Activo' COMMENT '',
  `idproducto` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`idregistro_sanitario`)  COMMENT '',
  INDEX `fk_registro_sanitario_idpais_idx` (`idpais` ASC)  COMMENT '',
  INDEX `fk_registro_sanitario_idproducto_idx` (`idproducto` ASC)  COMMENT '',
  CONSTRAINT `fk_registro_sanitario_idpais`
    FOREIGN KEY (`idpais`)
    REFERENCES `nexthor_empresa`.`pais` (`idpais`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_registro_sanitario_idproducto`
    FOREIGN KEY (`idproducto`)
    REFERENCES `nexthor_empresa`.`producto` (`idproducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;

USE `nexthor_empresa` ;

-- -----------------------------------------------------
-- function fnc_get_idempresa_idsucursal
-- -----------------------------------------------------

DELIMITER $$
USE `nexthor_empresa`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `fnc_get_idempresa_idsucursal`(pidsucursal int) RETURNS int(11)
BEGIN
	declare ridempresa INT default 0;
    select ifnull(idempresa,0) into ridempresa
	from sucursal 
	where idsucursal = pidsucursal
	limit 1;
	
	RETURN ridempresa;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- function fnc_get_idfecha_contable
-- -----------------------------------------------------

DELIMITER $$
USE `nexthor_empresa`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `fnc_get_idfecha_contable`(pfecha date, pidempresa int, ptabla varchar(40)) RETURNS int(11)
BEGIN
	declare ridfecha_contable INT default 0;
    if ptabla = 'documento_debito' then
		select ifnull(idfecha_contable,0) into ridfecha_contable
		from fecha_contable 
		where fecha = pfecha and idempresa = pidempresa and estado_documento_debito ='Abierto'
        limit 1;
	elseif  ptabla = 'documento_credito' then
		select ifnull(idfecha_contable,0) into ridfecha_contable
		from fecha_contable 
		where fecha = pfecha and idempresa = pidempresa and estado_documento_credito ='Abierto'
        limit 1;
	elseif  ptabla = 'pago_cliente' then
		select ifnull(idfecha_contable,0) into ridfecha_contable
		from fecha_contable 
		where fecha = pfecha and idempresa = pidempresa and estado_pago_cliente ='Abierto'
        limit 1;
	elseif  ptabla = 'pago_proveedor' then
		select ifnull(idfecha_contable,0) into ridfecha_contable
		from fecha_contable 
		where fecha = pfecha and idempresa = pidempresa and estado_pago_proveedor ='Abierto'
        limit 1;
	end if;
	RETURN ridfecha_contable;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- function fnc_get_porcentaje_iva
-- -----------------------------------------------------

DELIMITER $$
USE `nexthor_empresa`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `fnc_get_porcentaje_iva`() RETURNS decimal(10,5)
BEGIN
	declare rporcentaje_iva decimal(10,5) default 0;
    select ifnull(porcentaje_IVA,0) into rporcentaje_iva
	from parametros_sistema 
	where estado = 'Activo'
    order by 1 
	limit 1;
	
	RETURN rporcentaje_iva;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- function fnc_use_fecha_contable_abierta
-- -----------------------------------------------------

DELIMITER $$
USE `nexthor_empresa`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `fnc_use_fecha_contable_abierta`(pfecha date, pidempresa int, ptabla varchar(40)) RETURNS date
BEGIN
	declare rfecha_contable date;
    if ptabla = 'documento_debito' then
		select fecha into rfecha_contable
		from fecha_contable 
		where fecha >= pfecha and idempresa = pidempresa and estado_documento_debito ='Abierto'
        order by fecha
        limit 1;
	elseif  ptabla = 'documento_credito' then
		select fecha into rfecha_contable
		from fecha_contable 
		where fecha >= pfecha and idempresa = pidempresa and estado_documento_credito ='Abierto'
        order by fecha
        limit 1;
	elseif  ptabla = 'pago_cliente' then
		select fecha into rfecha_contable
		from fecha_contable 
		where fecha >= pfecha and idempresa = pidempresa and estado_pago_cliente ='Abierto'
        order by fecha
        limit 1;
	elseif  ptabla = 'pago_proveedor' then
		select fecha into rfecha_contable
		from fecha_contable 
		where fecha >= pfecha and idempresa = pidempresa and estado_pago_proveedor ='Abierto'
        order by fecha
        limit 1;
	end if;
	RETURN rfecha_contable;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure pr_calc_importe_fiscal_documento_debito
-- -----------------------------------------------------

DELIMITER $$
USE `nexthor_empresa`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `pr_calc_importe_fiscal_documento_debito`(in pidfecha_contable int)
BEGIN
	declare siddetalle_documento_debito int;
    declare simporte_bruto decimal(10,2);
    declare simporte_neto decimal(10,2);
    declare simporte_iva decimal(10,2);
    DECLARE done INT DEFAULT 0;

	DECLARE cur CURSOR FOR select ddd.iddetalle_documento_debito, ddd.monto importe_bruto, 
			ROUND(((ddd.monto-ddd.importe_descuento-ddd.importe_exento-ddd.importe_otros_impuestos)/(1+fnc_get_porcentaje_iva())),2) importe_neto,
			ROUND((ddd.monto-ddd.importe_descuento-ddd.importe_exento-ddd.importe_otros_impuestos),2)-ROUND(((ddd.monto-ddd.importe_descuento-ddd.importe_exento-ddd.importe_otros_impuestos)/(1+fnc_get_porcentaje_iva())),2) importe_iva
		from detalle_documento_debito ddd
		inner join documento_debito dd on ddd.iddocumento_debito = dd.iddocumento_debito
		where dd.idfecha_contable = pidfecha_contable and dd.estado = 'Activo' and ddd.estado = 'Activo'
			and dd.estado_documento = 'Emitido';
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
    OPEN cur;    
		REPEAT
			FETCH cur into siddetalle_documento_debito, simporte_bruto, simporte_neto, simporte_iva;
				IF NOT done THEN
					update detalle_documento_debito set importe_bruto = simporte_bruto, importe_neto = simporte_neto, importe_iva = simporte_iva, importe_total = importe_bruto where iddetalle_documento_debito = siddetalle_documento_debito;
				END IF;
		UNTIL done END REPEAT;    
	CLOSE cur;
END$$

DELIMITER ;
USE `nexthor_empresa`;

DELIMITER $$
USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`pais_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`pais`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`empresa_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`empresa`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`departamento_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`departamento`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`municipio_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`municipio`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`sucursal_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`sucursal`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`tipo_bodega_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`tipo_bodega`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`bodega_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`bodega`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`categoria_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`categoria`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`fabricante_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`fabricante`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`periodo_contable_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`periodo_contable`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`fecha_contable_AFTER_UPDATE`
AFTER UPDATE ON `nexthor_empresa`.`fecha_contable`
FOR EACH ROW
BEGIN
	if old.estado_documento_debito != new.estado_documento_debito then
		if old.estado_documento_debito = 'Control' then
			call pr_calc_importe_fiscal_documento_debito(new.idfecha_contable);
		elseif old.estado_documento_debito = 'Presentado' then
			update documento_debito set estado_documento = 'Contabilizado'
            where idfecha_contable = new.idfecha_contable and estado_documento = 'Emitido' and estado = 'Activo';
		end if;
	end if;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`fecha_contable_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`fecha_contable`
FOR EACH ROW
BEGIN
	declare s_idperiodo_contable int;
	select ifnull(idperiodo_contable,1) into s_idperiodo_contable
    from periodo_contable where mes = date_format(new.fecha,'%m') 
		and anio = date_format(new.fecha,'%Y')
        and idempresa = new.idempresa
    limit 1;
    
    set new.idperiodo_contable=s_idperiodo_contable;

END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`marca_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`marca`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`meta_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`meta`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`moneda_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`moneda`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`pago_cliente_AFTER_INSERT`
AFTER INSERT ON `nexthor_empresa`.`pago_cliente`
FOR EACH ROW
BEGIN
	insert into movimiento (credito, idrelacion, tabla_relacion, idrelacion_persona, tabla_relacion_persona, idsucursal)
    values (new.monto,new.idpago_cliente,'pago_cliente', new.idcliente, 'cliente', new.idsucursal);
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`pago_cliente_AFTER_UPDATE`
AFTER UPDATE ON `nexthor_empresa`.`pago_cliente`
FOR EACH ROW
BEGIN
	if new.monto != old.monto then
		update movimiento set credito = credito +(new.monto-old.monto) where idrelacion = new.idpago_cliente and tabla_relacion = 'pago_cliente';
    end if;
    if new.estado != old.estado then
		if new.estado ='Inactivo' then
			update movimiento set credito = credito -(new.monto) where idrelacion = new.idpago_cliente and tabla_relacion = 'pago_cliente';
        elseif new.estado ='Activo' then
			update movimiento set credito = credito +(new.monto) where idrelacion = new.idpago_cliente and tabla_relacion = 'pago_cliente';
		end if;
	end if;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`pago_cliente_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`pago_cliente`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`pago_cliente_BEFORE_UPDATE`
BEFORE UPDATE ON `nexthor_empresa`.`pago_cliente`
FOR EACH ROW
BEGIN
	if new.idcliente != old.idcliente then
		set new.idcliente = old.idcliente;
    end if;
    if new.idsucursal != old.idsucursal then
		set new.idsucursal = old.idsucursal;
    end if;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`producto_AFTER_UPDATE`
AFTER UPDATE ON `nexthor_empresa`.`producto`
FOR EACH ROW
BEGIN
	if new.precio_venta!=old.precio_venta or new.precio_compra!=old.precio_compra then
		insert into producto_precio_historial (idproducto, fecha, precio_venta, precio_compra)
		values (new.idproducto,now(),new.precio_venta, new.precio_compra);
	end if;
   

END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`producto_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`producto`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`producto_sucursal_AFTER_INSERT`
AFTER INSERT ON `nexthor_empresa`.`producto_sucursal`
FOR EACH ROW
BEGIN
	update producto set existencia = existencia + (new.existencia) where idproducto = new.idproducto;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`producto_sucursal_AFTER_UPDATE`
AFTER UPDATE ON `nexthor_empresa`.`producto_sucursal`
FOR EACH ROW
BEGIN
	if new.existencia!=old.existencia then
		update producto set existencia = existencia + (new.existencia-old.existencia) where idproducto = new.idproducto;
	end if;
    if  new.estado!=old.estado then
		if new.estado = 'Activo' then
			update producto set existencia = existencia + (new.existencia) where idproducto = new.idproducto;
		else
			update producto set existencia = existencia - (new.existencia) where idproducto = new.idproducto;
        end if;
    end if;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`producto_bodega_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`producto_bodega`
FOR EACH ROW
BEGIN
	declare var_idproducto_sucursal int default 0;
	declare var_idsucursal int default 0;
	
    select ifnull(idproducto_sucursal,0), b.idsucursal into var_idproducto_sucursal, var_idsucursal
	from bodega b left join producto_sucursal ps on b.idsucursal = ps.idsucursal and ps.idproducto = new.idproducto where idbodega = new.idbodega;
 
    if var_idproducto_sucursal = 0 then
		INSERT INTO producto_sucursal (idproducto, idsucursal, existencia) VALUES (new.idproducto, var_idsucursal, new.existencia);
        select ifnull(idproducto_sucursal,0) into var_idproducto_sucursal
		from bodega b left join producto_sucursal ps on b.idsucursal = ps.idsucursal and ps.idproducto = new.idproducto where idbodega = new.idbodega;
	else
		update producto_sucursal set existencia = existencia + (new.existencia) where idproducto_sucursal = var_idproducto_sucursal;
	end if;
    
    set new.idproducto_sucursal = var_idproducto_sucursal;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`producto_bodega_BEFORE_UPDATE`
BEFORE UPDATE ON `nexthor_empresa`.`producto_bodega`
FOR EACH ROW
BEGIN
	if new.existencia!=old.existencia then
		update producto_sucursal set existencia = existencia + (new.existencia-old.existencia) where idproducto_sucursal = new.idproducto_sucursal;
	end if;
    if  new.estado!=old.estado then
		if new.estado = 'Activo' then
			update producto_sucursal set existencia = existencia + (new.existencia) where idproducto_sucursal = new.idproducto_sucursal;
		else
			update producto_sucursal set existencia = existencia - (new.existencia) where idproducto_sucursal = new.idproducto_sucursal;
        end if;
    end if;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`producto_historial_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`producto_historial`
FOR EACH ROW
BEGIN
	declare var_idproducto_bodega int default 0;
	
    select ifnull(idproducto_bodega,0) into var_idproducto_bodega
	from producto_bodega where idbodega = new.idbodega and idproducto = new.idproducto limit 1;
 
    if var_idproducto_bodega = 0 then
		INSERT INTO producto_bodega (idproducto, idbodega, existencia) VALUES (new.idproducto, new.idbodega, (new.unidades_ingreso-new.unidades_salida));
        select ifnull(idproducto_bodega,0) into var_idproducto_bodega
		from producto_bodega  where idproducto = new.idproducto and idbodega = new.idbodega;
	else
		update producto_bodega set existencia = existencia +  (new.unidades_ingreso-new.unidades_salida) where idproducto_bodega = var_idproducto_bodega;
	end if;
    set new.fecha_insercion = now();
    set new.idproducto_bodega = var_idproducto_bodega;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`producto_historial_BEFORE_UPDATE`
BEFORE UPDATE ON `nexthor_empresa`.`producto_historial`
FOR EACH ROW
BEGIN
	if (new.unidades_ingreso-new.unidades_salida)!=(old.unidades_ingreso-old.unidades_salida) then
		update producto_bodega set existencia = existencia + ((new.unidades_ingreso-new.unidades_salida)-(old.unidades_ingreso-old.unidades_salida)) where idproducto_bodega = new.idproducto_bodega;
	end if;
    if  new.estado!=old.estado then
		if new.estado = 'Activo' then
			update producto_bodega set existencia = existencia + (new.unidades_ingreso-new.unidades_salida) where idproducto_bodega = new.idproducto_bodega;
		else
			update producto_bodega set existencia = existencia - (new.unidades_ingreso-new.unidades_salida) where idproducto_bodega = new.idproducto_bodega;
        end if;
    end if;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`producto_precio_historial_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`producto_precio_historial`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`registro_sanitario_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`registro_sanitario`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END$$


DELIMITER ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
