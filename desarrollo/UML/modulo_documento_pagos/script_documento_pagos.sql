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
-- Table `nexthor_empresa`.`aplicacion_movimiento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`aplicacion_movimiento` (
  `idaplicacion_movimiento` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `idmovimiento_credito` INT(11) NOT NULL COMMENT '',
  `idmovimiento_debito` INT(11) NOT NULL COMMENT '',
  `monto` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `fecha` DATE NULL DEFAULT NULL COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  `estado` ENUM('Activo','Inactivo') NOT NULL DEFAULT 'Activo' COMMENT '',
  PRIMARY KEY (`idaplicacion_movimiento`)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`audittrail`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`audittrail` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `datetime` DATETIME NOT NULL COMMENT '',
  `script` VARCHAR(255) NULL DEFAULT NULL COMMENT '',
  `user` VARCHAR(255) NULL DEFAULT NULL COMMENT '',
  `action` VARCHAR(255) NULL DEFAULT NULL COMMENT '',
  `table` VARCHAR(255) NULL DEFAULT NULL COMMENT '',
  `field` VARCHAR(255) NULL DEFAULT NULL COMMENT '',
  `keyvalue` LONGTEXT NULL DEFAULT NULL COMMENT '',
  `oldvalue` LONGTEXT NULL DEFAULT NULL COMMENT '',
  `newvalue` LONGTEXT NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 342
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`banco`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`banco` (
  `idbanco` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `nombre` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `acronimo` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `telefono` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `url` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `idpais` INT(11) NULL DEFAULT NULL COMMENT '',
  `estado` ENUM('Activo','Inactivo') NOT NULL DEFAULT 'Activo' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`idbanco`)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 17
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`cuenta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`cuenta` (
  `idcuenta` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `idbanco` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `idsucursal` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `idmoneda` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `numero` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `nombre` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `saldo` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `debito` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `credito` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `estado` ENUM('Activo','Inactivo') NOT NULL DEFAULT 'Activo' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`idcuenta`)  COMMENT '',
  INDEX `fk_cuenta_idbanco_idx` (`idbanco` ASC)  COMMENT '',
  CONSTRAINT `fk_cuenta_idbanco`
    FOREIGN KEY (`idbanco`)
    REFERENCES `nexthor_empresa`.`banco` (`idbanco`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`boleta_deposito`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`boleta_deposito` (
  `idboleta_deposito` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `numero` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `idbanco` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `idcuenta` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `fecha` DATE NULL DEFAULT NULL COMMENT '',
  `estado` ENUM('Activo','Inactivo') NOT NULL DEFAULT 'Activo' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  `descripcion` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `efectivo` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `cheque` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `cheque_otro` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `monto` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  PRIMARY KEY (`idboleta_deposito`)  COMMENT '',
  INDEX `fk_boleta_deposito_idbanco_idx` (`idbanco` ASC)  COMMENT '',
  INDEX `fk_boleta_deposito_idcuenta_idx` (`idcuenta` ASC)  COMMENT '',
  CONSTRAINT `fk_boleta_deposito_idbanco`
    FOREIGN KEY (`idbanco`)
    REFERENCES `nexthor_empresa`.`banco` (`idbanco`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_boleta_deposito_idcuenta`
    FOREIGN KEY (`idcuenta`)
    REFERENCES `nexthor_empresa`.`cuenta` (`idcuenta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`cheque_cliente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`cheque_cliente` (
  `idcheque_cliente` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `numero` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `propietario` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `idbanco` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `cuenta` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `fecha` DATE NULL DEFAULT NULL COMMENT '',
  `estado` ENUM('Activo','Inactivo') NOT NULL DEFAULT 'Activo' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  `descripcion` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `monto` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `cheque_estado` ENUM('Recibido','Cobrado','Rechazado') NOT NULL DEFAULT 'Recibido' COMMENT '',
  PRIMARY KEY (`idcheque_cliente`)  COMMENT '',
  INDEX `fk_cheque_cliente_idbanco_idx` (`idbanco` ASC)  COMMENT '',
  CONSTRAINT `fk_cheque_cliente_idbanco`
    FOREIGN KEY (`idbanco`)
    REFERENCES `nexthor_empresa`.`banco` (`idbanco`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`persona`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`persona` (
  `idpersona` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `tipo_persona` ENUM('Individual','Juridica') NOT NULL DEFAULT 'Individual' COMMENT '',
  `nombre` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `apellido` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `direccion` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `cui` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `idpais` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `fecha_nacimiento` DATE NULL DEFAULT NULL COMMENT '',
  `email` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `sexo` ENUM('Masculino','Femenino') NOT NULL DEFAULT 'Masculino' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  `estado` ENUM('Activo','Inactivo') NOT NULL DEFAULT 'Activo' COMMENT '',
  PRIMARY KEY (`idpersona`)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`cliente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`cliente` (
  `idcliente` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `idpersona` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `codigo` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `nit` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `nombre_factura` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `direccion_factura` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `debito` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `credito` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  `email` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `estado` ENUM('Activo','Inactivo') NOT NULL DEFAULT 'Activo' COMMENT '',
  `telefono` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `tributa` ENUM('Si','No') NOT NULL DEFAULT 'Si' COMMENT '',
  PRIMARY KEY (`idcliente`)  COMMENT '',
  INDEX `fk_cliente_idpersona_idx` (`idpersona` ASC)  COMMENT '',
  CONSTRAINT `fk_cliente_idpersona`
    FOREIGN KEY (`idpersona`)
    REFERENCES `nexthor_empresa`.`persona` (`idpersona`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`cuenta_transaccion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`cuenta_transaccion` (
  `idcuenta_transaccion` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `idcuenta` INT(11) NULL DEFAULT NULL COMMENT '',
  `fecha` DATE NULL DEFAULT NULL COMMENT '',
  `descripcion` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `debito` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `credito` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `id_referencia` INT(11) NULL DEFAULT NULL COMMENT '',
  `tabla_referencia` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `estado` ENUM('Activo','Inactivo') NOT NULL DEFAULT 'Activo' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`idcuenta_transaccion`)  COMMENT '',
  INDEX `fk_cuenta_transaccion_idcuenta_idx` (`idcuenta` ASC)  COMMENT '',
  CONSTRAINT `fk_cuenta_transaccion_idcuenta`
    FOREIGN KEY (`idcuenta`)
    REFERENCES `nexthor_empresa`.`cuenta` (`idcuenta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 8
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`proveedor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`proveedor` (
  `idproveedor` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `idpersona` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `codigo` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `nit` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `nombre_factura` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `direccion_factura` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `debito` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `credito` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  `email` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `estado` ENUM('Activo','Inactivo') NOT NULL DEFAULT 'Activo' COMMENT '',
  PRIMARY KEY (`idproveedor`)  COMMENT '',
  INDEX `fk_proveedor_idpersona_idx` (`idpersona` ASC)  COMMENT '',
  CONSTRAINT `fk_proveedor_idpersona`
    FOREIGN KEY (`idpersona`)
    REFERENCES `nexthor_empresa`.`persona` (`idpersona`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`tipo_documento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`tipo_documento` (
  `idtipo_documento` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `nombre` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL COMMENT '',
  `estado` ENUM('Activo','Inactivo') CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL DEFAULT 'Activo' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`idtipo_documento`)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`documento_credito`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`documento_credito` (
  `iddocumento_credito` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `idtipo_documento` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `idsucursal` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `serie` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `correlativo` INT(11) NULL DEFAULT NULL COMMENT '',
  `fecha` DATE NULL DEFAULT NULL COMMENT '',
  `observaciones` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `estado_documento` ENUM('Recibido','Rechazado') NOT NULL DEFAULT 'Recibido' COMMENT '',
  `estado` ENUM('Activo','Inactivo') NULL DEFAULT 'Activo' COMMENT '',
  `monto` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `fecha_insercion` DATE NULL DEFAULT NULL COMMENT '',
  `idproveedor` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  PRIMARY KEY (`iddocumento_credito`)  COMMENT '',
  INDEX `fk_documento_credito_idtipodocumento_idx` (`idtipo_documento` ASC)  COMMENT '',
  INDEX `fk_documento_credito_idproveedor_idx` (`idproveedor` ASC)  COMMENT '',
  CONSTRAINT `fk_documento_credito_idproveedor`
    FOREIGN KEY (`idproveedor`)
    REFERENCES `nexthor_empresa`.`proveedor` (`idproveedor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_documento_credito_idtipodocumento`
    FOREIGN KEY (`idtipo_documento`)
    REFERENCES `nexthor_empresa`.`tipo_documento` (`idtipo_documento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 4
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
  PRIMARY KEY (`idproducto`)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`detalle_documento_credito`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`detalle_documento_credito` (
  `iddetalle_documento_credito` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `iddocumento_credito` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `idproducto` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `idbodega` INT(11) NOT NULL COMMENT '',
  `cantidad` INT(11) NOT NULL COMMENT '',
  `precio` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `monto` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `estado` ENUM('Activo','Inactivo') NOT NULL DEFAULT 'Activo' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  `bandera_maestro` ENUM('SI','NO') NOT NULL DEFAULT 'SI' COMMENT '',
  PRIMARY KEY (`iddetalle_documento_credito`)  COMMENT '',
  INDEX `fk_detalle_documento_credito_iddocumento_debito_credito_idx` (`iddocumento_credito` ASC)  COMMENT '',
  INDEX `fk_detalle_documento_credito_idproducto_idx` (`idproducto` ASC)  COMMENT '',
  CONSTRAINT `fk_detalle_documento_credito_iddocumento_debito_credito`
    FOREIGN KEY (`iddocumento_credito`)
    REFERENCES `nexthor_empresa`.`documento_credito` (`iddocumento_credito`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalle_documento_credito_idproducto`
    FOREIGN KEY (`idproducto`)
    REFERENCES `nexthor_empresa`.`producto` (`idproducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 8
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`serie_documento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`serie_documento` (
  `idserie_documento` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `idtipo_documento` INT(11) NOT NULL COMMENT '',
  `serie` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NULL DEFAULT NULL COMMENT '',
  `correlativo` INT(11) NULL DEFAULT NULL COMMENT '',
  `idsucursal` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `fecha` DATE NULL DEFAULT NULL COMMENT '',
  `estado` ENUM('Activo','Inactivo') CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL DEFAULT 'Activo' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`idserie_documento`)  COMMENT '',
  INDEX `fk_serie_documento_idtipo_documento_idx` (`idtipo_documento` ASC)  COMMENT '',
  CONSTRAINT `fk_serie_documento_idtipo_documento`
    FOREIGN KEY (`idtipo_documento`)
    REFERENCES `nexthor_empresa`.`tipo_documento` (`idtipo_documento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`documento_debito`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`documento_debito` (
  `iddocumento_debito` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `idtipo_documento` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `idsucursal` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `idserie_documento` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `serie` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NULL DEFAULT NULL COMMENT '',
  `correlativo` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `fecha` DATE NULL DEFAULT NULL COMMENT '',
  `nombre` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NULL DEFAULT NULL COMMENT '',
  `direccion` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NULL DEFAULT NULL COMMENT '',
  `nit` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NULL DEFAULT NULL COMMENT '',
  `observaciones` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NULL DEFAULT NULL COMMENT '',
  `estado_documento` ENUM('Emitido','Contabilizado','Anulado') CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL DEFAULT 'Emitido' COMMENT '',
  `estado` ENUM('Activo','Inactivo') CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL DEFAULT 'Activo' COMMENT '',
  `fecha_anulacion` DATE NULL DEFAULT NULL COMMENT '',
  `motivo_anulacion` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NULL DEFAULT NULL COMMENT '',
  `monto` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  `idcliente` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `importe_bruto` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `importe_descuento` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `importe_exento` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `importe_neto` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `importe_iva` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `importe_otros_impuestos` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `importe_isr` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `importe_total` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `idfecha_contable` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `idmoneda` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `tasa_cambio` DECIMAL(10,5) NOT NULL DEFAULT '1.00000' COMMENT '',
  PRIMARY KEY (`iddocumento_debito`)  COMMENT '',
  INDEX `fk_documento_debito_idserie_documento_idx` (`idserie_documento` ASC)  COMMENT '',
  INDEX `fk_documento_debito_idtipo_documento_idx` (`idtipo_documento` ASC)  COMMENT '',
  INDEX `fk_documento_debito_idcliente_idx` (`idcliente` ASC)  COMMENT '',
  CONSTRAINT `fk_documento_debito_idcliente`
    FOREIGN KEY (`idcliente`)
    REFERENCES `nexthor_empresa`.`cliente` (`idcliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_documento_debito_idserie_documento`
    FOREIGN KEY (`idserie_documento`)
    REFERENCES `nexthor_empresa`.`serie_documento` (`idserie_documento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_documento_debito_idtipo_documento`
    FOREIGN KEY (`idtipo_documento`)
    REFERENCES `nexthor_empresa`.`tipo_documento` (`idtipo_documento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 40
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`detalle_documento_debito`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`detalle_documento_debito` (
  `iddetalle_documento_debito` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `iddocumento_debito` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `idproducto` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `idbodega` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `cantidad` INT(11) NOT NULL DEFAULT '0' COMMENT '',
  `precio` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `monto` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `estado` ENUM('Activo','Inactivo') CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL DEFAULT 'Activo' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  `importe_descuento` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `importe_bruto` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `importe_exento` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `importe_neto` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `importe_iva` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `importe_otros_impuestos` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `importe_total` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `bandera_maestro` ENUM('SI','NO') CHARACTER SET 'utf8' COLLATE 'utf8_spanish_ci' NOT NULL DEFAULT 'SI' COMMENT '',
  PRIMARY KEY (`iddetalle_documento_debito`)  COMMENT '',
  INDEX `fk_detalle_documento_debito_iddocumento_debito_idx` (`iddocumento_debito` ASC)  COMMENT '',
  INDEX `fk_detalle_documento_debito_idproducto_idx` (`idproducto` ASC)  COMMENT '',
  INDEX `fk_detalle_document_idproducto_historial_idx` (`fecha_insercion` ASC)  COMMENT '',
  CONSTRAINT `fk_detalle_documento_debito_iddocumento_debito`
    FOREIGN KEY (`iddocumento_debito`)
    REFERENCES `nexthor_empresa`.`documento_debito` (`iddocumento_debito`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalle_documento_debito_idproducto`
    FOREIGN KEY (`idproducto`)
    REFERENCES `nexthor_empresa`.`producto` (`idproducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 37
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`documento_movimiento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`documento_movimiento` (
  `iddocumento_movimiento` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `idtipo_documento` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `idserie_documento` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `serie` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `correlativo` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `fecha` DATE NULL DEFAULT NULL COMMENT '',
  `observaciones` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `estado_documento` ENUM('Emitido','Anulado') NOT NULL DEFAULT 'Emitido' COMMENT '',
  `idsucursal_ingreso` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `idsucursal_egreso` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `estado` ENUM('Activo','Inactivo') NOT NULL DEFAULT 'Activo' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  `monto` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  PRIMARY KEY (`iddocumento_movimiento`)  COMMENT '',
  INDEX `fk_documento_movimiento_idtipo_documento_idx` (`idtipo_documento` ASC)  COMMENT '',
  INDEX `fk_documento_movimiento_idserie_documento_idx` (`idserie_documento` ASC)  COMMENT '',
  CONSTRAINT `fk_documento_movimiento_idserie_documento`
    FOREIGN KEY (`idserie_documento`)
    REFERENCES `nexthor_empresa`.`serie_documento` (`idserie_documento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_documento_movimiento_idtipo_documento`
    FOREIGN KEY (`idtipo_documento`)
    REFERENCES `nexthor_empresa`.`tipo_documento` (`idtipo_documento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`detalle_documento_movimiento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`detalle_documento_movimiento` (
  `iddetalle_documento_movimiento` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `iddocumento_movimiento` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `idproducto` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `idbodega_ingreso` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `idbodega_egreso` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `cantidad` INT(11) NOT NULL DEFAULT '0' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  `estado` ENUM('Activo','Inactivo') NOT NULL DEFAULT 'Activo' COMMENT '',
  `monto` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `precio` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  PRIMARY KEY (`iddetalle_documento_movimiento`)  COMMENT '',
  INDEX `fk_detalle_documento_movimiento_iddocumento_movimiento_idx` (`iddocumento_movimiento` ASC)  COMMENT '',
  INDEX `fk_detalle_documento_movimiento_idproducto_idx` (`idproducto` ASC)  COMMENT '',
  CONSTRAINT `fk_detalle_documento_movimiento_iddocumento_movimiento`
    FOREIGN KEY (`iddocumento_movimiento`)
    REFERENCES `nexthor_empresa`.`documento_movimiento` (`iddocumento_movimiento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalle_documento_movimiento_idproducto`
    FOREIGN KEY (`idproducto`)
    REFERENCES `nexthor_empresa`.`producto` (`idproducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`impuesto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`impuesto` (
  `idimpuesto` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `nombre` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `porcentaje` DECIMAL(10,5) NOT NULL DEFAULT '0.00000' COMMENT '',
  `estado` ENUM('Activo','Inactivo') NOT NULL DEFAULT 'Activo' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`idimpuesto`)  COMMENT '')
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`movimiento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`movimiento` (
  `idmovimiento` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `debito` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `credito` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `idrelacion` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `tabla_relacion` VARCHAR(45) NOT NULL DEFAULT 'documento' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  `estado` ENUM('Activo','Inactivo') NOT NULL DEFAULT 'Activo' COMMENT '',
  `idrelacion_persona` INT(11) NULL DEFAULT NULL COMMENT '',
  `tabla_relacion_persona` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `idsucursal` INT(11) NOT NULL COMMENT '',
  `monto_aplicado` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  PRIMARY KEY (`idmovimiento`)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 51
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`tipo_pago`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`tipo_pago` (
  `idtipo_pago` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `nombre` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `estado` ENUM('Activo','Inactivo') NOT NULL DEFAULT 'Activo' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`idtipo_pago`)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`voucher_tarjeta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`voucher_tarjeta` (
  `idvoucher_tarjeta` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `idbanco` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `idcuenta` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `marca` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `nombre` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `ultimos_cuatro_digitos` INT(11) NULL DEFAULT '0' COMMENT '',
  `referencia` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `fecha` DATE NULL DEFAULT NULL COMMENT '',
  `estado` ENUM('Activo','Inactivo') NOT NULL DEFAULT 'Activo' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  `descripcion` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  `monto` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  PRIMARY KEY (`idvoucher_tarjeta`)  COMMENT '',
  INDEX `fk_voucher_tarjeta_idbanco_idx` (`idbanco` ASC)  COMMENT '',
  INDEX `fk_voucher_tarjeta_idcuenta_idx` (`idcuenta` ASC)  COMMENT '',
  CONSTRAINT `fk_voucher_tarjeta_idbanco`
    FOREIGN KEY (`idbanco`)
    REFERENCES `nexthor_empresa`.`banco` (`idbanco`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_voucher_tarjeta_idcuenta`
    FOREIGN KEY (`idcuenta`)
    REFERENCES `nexthor_empresa`.`cuenta` (`idcuenta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3
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
  INDEX `fk_pago_cliente_idcliente_idx` (`idcliente` ASC)  COMMENT '',
  INDEX `fk_pago_cliente_idboleta_deposito_idx` (`idboleta_deposito` ASC)  COMMENT '',
  INDEX `fk_pago_cliente_idvoucher_tarjeta_idx` (`idvoucher_tarjeta` ASC)  COMMENT '',
  INDEX `fk_pago_cliente_idtipo_pago_idx` (`idtipo_pago` ASC)  COMMENT '',
  INDEX `fk_pago_cliente_idcheque_cliente_idx` (`idcheque_cliente` ASC)  COMMENT '',
  CONSTRAINT `fk_pago_cliente_idboleta_deposito`
    FOREIGN KEY (`idboleta_deposito`)
    REFERENCES `nexthor_empresa`.`boleta_deposito` (`idboleta_deposito`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pago_cliente_idcheque_cliente`
    FOREIGN KEY (`idcheque_cliente`)
    REFERENCES `nexthor_empresa`.`cheque_cliente` (`idcheque_cliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pago_cliente_idcliente`
    FOREIGN KEY (`idcliente`)
    REFERENCES `nexthor_empresa`.`cliente` (`idcliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pago_cliente_idtipo_pago`
    FOREIGN KEY (`idtipo_pago`)
    REFERENCES `nexthor_empresa`.`tipo_pago` (`idtipo_pago`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pago_cliente_idvoucher_tarjeta`
    FOREIGN KEY (`idvoucher_tarjeta`)
    REFERENCES `nexthor_empresa`.`voucher_tarjeta` (`idvoucher_tarjeta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 10
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`pago_proveedor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`pago_proveedor` (
  `idpago_proveedor` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `idproveedor` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `monto` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '',
  `fecha` DATE NULL DEFAULT NULL COMMENT '',
  `estado` ENUM('Activo','Inactivo') NOT NULL DEFAULT 'Activo' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  `idsucursal` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  PRIMARY KEY (`idpago_proveedor`)  COMMENT '',
  INDEX `fk_pago_proveedor_idproveedor_idx` (`idproveedor` ASC)  COMMENT '',
  CONSTRAINT `fk_pago_proveedor_idproveedor`
    FOREIGN KEY (`idproveedor`)
    REFERENCES `nexthor_empresa`.`proveedor` (`idproveedor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`parametros_sistema`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`parametros_sistema` (
  `idparametros_sistema` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `porcentaje_IVA` DECIMAL(10,4) NOT NULL DEFAULT '0.1200' COMMENT '',
  `idmoneda` INT(11) NOT NULL COMMENT '',
  `estado` ENUM('Activo','Inactivo') NOT NULL DEFAULT 'Activo' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`idparametros_sistema`)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 2
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
  INDEX `fk_producto_sucursal_idproducto_idx` (`idproducto` ASC)  COMMENT '',
  CONSTRAINT `fk_producto_sucursal_idproducto`
    FOREIGN KEY (`idproducto`)
    REFERENCES `nexthor_empresa`.`producto` (`idproducto`)
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
  INDEX `fk_producto_bodega_idproducto_idx` (`idproducto` ASC)  COMMENT '',
  INDEX `fk_producto_bodega_idproducto_sucursal_idx` (`idproducto_sucursal` ASC)  COMMENT '',
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
  INDEX `fk_producto_historial_idproducto_bodega_idx` (`idproducto_bodega` ASC)  COMMENT '',
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
-- Table `nexthor_empresa`.`userlevelpermissions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`userlevelpermissions` (
  `userlevelid` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `tablename` VARCHAR(255) NOT NULL COMMENT '',
  `permission` INT(11) NOT NULL COMMENT '',
  PRIMARY KEY (`userlevelid`, `tablename`)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`userlevels`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`userlevels` (
  `userlevelid` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `userlevelname` VARCHAR(255) NOT NULL COMMENT '',
  PRIMARY KEY (`userlevelid`)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `nexthor_empresa`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nexthor_empresa`.`usuario` (
  `idusuario` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `usuario` VARCHAR(45) NOT NULL COMMENT '',
  `contrasena` VARCHAR(45) NOT NULL COMMENT '',
  `estado` ENUM('Activo','Inactivo') NOT NULL DEFAULT 'Activo' COMMENT '',
  `fecha_insercion` DATETIME NULL DEFAULT NULL COMMENT '',
  `userlevelid` INT(11) NOT NULL DEFAULT '1' COMMENT '',
  `session` VARCHAR(45) NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`idusuario`)  COMMENT '',
  INDEX `fk_usuario_userlevelid_idx` (`userlevelid` ASC)  COMMENT '',
  CONSTRAINT `fk_usuario_userlevelid`
    FOREIGN KEY (`userlevelid`)
    REFERENCES `nexthor_empresa`.`userlevels` (`userlevelid`)
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
TRIGGER `nexthor_empresa`.`aplicacion_movimiento_AFTER_INSERT`
AFTER INSERT ON `nexthor_empresa`.`aplicacion_movimiento`
FOR EACH ROW
BEGIN
	update movimiento set monto_aplicado = monto_aplicado +(new.monto) where idmovimiento in(new.idmovimiento_debito, new.idmovimiento_credito);
   
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`aplicacion_movimiento_AFTER_UPDATE`
AFTER UPDATE ON `nexthor_empresa`.`aplicacion_movimiento`
FOR EACH ROW
BEGIN
	if new.monto!=old.monto then
		update movimiento set monto_aplicado = monto_aplicado +(new.monto-old.monto) where idmovimiento in(new.idmovimiento_debito, new.idmovimiento_credito);
	end if;
	if new.estado != old.estado then
		if new.estado ='Inactivo' then
			update movimiento set monto_aplicado = monto_aplicado -(new.monto) where idmovimiento in(new.idmovimiento_debito, new.idmovimiento_credito);
        elseif new.estado ='Activo' then
			update movimiento set monto_aplicado = monto_aplicado +(new.monto) where idmovimiento in(new.idmovimiento_debito, new.idmovimiento_credito);
        end if;
	end if;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`aplicacion_movimiento_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`aplicacion_movimiento`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`aplicacion_movimiento_BEFORE_UPDATE`
BEFORE UPDATE ON `nexthor_empresa`.`aplicacion_movimiento`
FOR EACH ROW
BEGIN
	if new.idmovimiento_credito!= old.idmovimiento_credito then
		set new.idmovimiento_credito = old.idmovimiento_credito;
    end if;
    if new.idmovimiento_debito != old.idmovimiento_debito then
		set new.idmovimiento_debito = old.idmovimiento_debito;
    end if;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`banco_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`banco`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`cuenta_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`cuenta`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`cuenta_BEFORE_UPDATE`
BEFORE UPDATE ON `nexthor_empresa`.`cuenta`
FOR EACH ROW
BEGIN
	set new.saldo = new.credito - new.debito;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`boleta_deposito_AFTER_INSERT`
AFTER INSERT ON `nexthor_empresa`.`boleta_deposito`
FOR EACH ROW
BEGIN
	insert into cuenta_transaccion (idcuenta, fecha, descripcion, credito, id_referencia, tabla_referencia)
		values (new.idcuenta, new.fecha, new.descripcion, new.monto, new.idboleta_deposito, 'boleta_deposito');
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`boleta_deposito_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`boleta_deposito`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
    set new.monto = (new.efectivo+new.cheque+new.cheque_otro);
    
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`boleta_deposito_BEFORE_UPDATE`
BEFORE UPDATE ON `nexthor_empresa`.`boleta_deposito`
FOR EACH ROW
BEGIN
	if new.estado!=old.estado then
		if new.estado = 'Inactivo' then
			set new.efectivo = 0;
            set new.cheque = 0;
            set new.cheque_otro = 0;
            set new.monto = 0;
		end if;
	end if;
	set new.monto = (new.efectivo+new.cheque+new.cheque_otro);
    if new.monto!=old.monto then
		update cuenta_transaccion set credito = credito+(new.monto-old.monto) where id_referencia = new.idboleta_deposito and tabla_referencia = 'boleta_deposito';
	end if;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`cheque_cliente_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`cheque_cliente`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`persona_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`persona`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`cliente_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`cliente`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`cuenta_transaccion_AFTER_INSERT`
AFTER INSERT ON `nexthor_empresa`.`cuenta_transaccion`
FOR EACH ROW
BEGIN
	update cuenta set debito = debito+(new.debito), credito = credito+(new.credito) where idcuenta = new.idcuenta;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`cuenta_transaccion_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`cuenta_transaccion`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`cuenta_transaccion_BEFORE_UPDATE`
BEFORE UPDATE ON `nexthor_empresa`.`cuenta_transaccion`
FOR EACH ROW
BEGIN
	if new.estado!=old.estado then
		if new.estado = 'Inactivo' then
			set new.debito = 0;
			set new.credito = 0;
		end if;
	end if;
    if new.debito!=old.debito or new.credito!=old.credito then
		update cuenta set debito = debito+(new.debito-old.debito), credito = credito+(new.credito-old.credito) where idcuenta = new.idcuenta;
	end if;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`proveedor_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`proveedor`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`tipo_documento_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`tipo_documento`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`documento_credito_AFTER_INSERT`
AFTER INSERT ON `nexthor_empresa`.`documento_credito`
FOR EACH ROW
BEGIN
	insert into movimiento (credito, idrelacion, tabla_relacion, idrelacion_persona, tabla_relacion_persona, idsucursal)
    values (new.monto,new.iddocumento_credito,'documento_credito', new.idproveedor, 'proveedor', new.idsucursal);

END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`documento_credito_AFTER_UPDATE`
AFTER UPDATE ON `nexthor_empresa`.`documento_credito`
FOR EACH ROW
BEGIN
	if new.monto != old.monto then
		update movimiento set credito = credito +(new.monto-old.monto) where idrelacion = new.iddocumento_credito and tabla_relacion = 'documento_credito';
    end if;
    if new.estado != old.estado then
		if new.estado ='Inactivo' then
			update movimiento set credito = credito -(new.monto) where idrelacion = new.iddocumento_credito and tabla_relacion = 'documento_credito';
		elseif new.estado ='Activo' then
			update movimiento set credito = credito +(new.monto) where idrelacion = new.iddocumento_credito and tabla_relacion = 'documento_credito';
		end if;
		update detalle_documento_credito set estado = new.estado, bandera_maestro = 'No' where iddocumento_credito = new.iddocumento_credito;
	end if;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`documento_credito_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`documento_credito`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`documento_credito_BEFORE_UPDATE`
BEFORE UPDATE ON `nexthor_empresa`.`documento_credito`
FOR EACH ROW
BEGIN
	if new.idproveedor != old.idproveedor then
		set new.idproveedor = old.idproveedor;
    end if;
    if new.idsucursal != old.idsucursal then
		set new.idsucursal = old.idsucursal;
    end if;
    if new.estado_documento != old.estado_documento then
		if new.estado_documento ='Anulado' then
			set new.monto = 0;
        end if;
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
TRIGGER `nexthor_empresa`.`detalle_documento_credito_AFTER_INSERT`
AFTER INSERT ON `nexthor_empresa`.`detalle_documento_credito`
FOR EACH ROW
BEGIN
	INSERT INTO producto_historial (idproducto, idbodega, fecha, unidades_ingreso, idrelacion, tabla_relacion) 
    VALUES (new.idproducto, new.idbodega, now(), new.cantidad, new.iddetalle_documento_credito, 'detalle_documento_credito');
    
    update documento_credito set monto = monto+(new.monto) where iddocumento_credito = new.iddocumento_credito;
    update producto set precio_compra = new.precio where idproducto = new.idproducto;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`detalle_documento_credito_AFTER_UPDATE`
AFTER UPDATE ON `nexthor_empresa`.`detalle_documento_credito`
FOR EACH ROW
BEGIN
	if new.cantidad!=old.cantidad then
		update producto_historial set unidades_ingreso = unidades_ingreso +(new.cantidad-old.cantidad) where idrelacion = new.iddetalle_documento_credito and tabla_relacion = 'detalle_documento_credito';
    end if;
    if new.monto!=old.monto then
		if new.bandera_maestro = 'SI' then
			update documento_credito set monto = monto+(new.monto-old.monto) where iddocumento_credito = new.iddocumento_credito;
		end if;
    end if;
    if new.precio!=old.precio then
		update producto set precio_compra = new.precio where idproducto = new.idproducto;
	end if;
    if  new.estado!=old.estado then
		if new.estado = 'Activo' then
			update producto_historial set unidades_ingreso = unidades_ingreso +(new.cantidad), estado ='Activo' where idrelacion = new.iddetalle_documento_credito and tabla_relacion = 'detalle_documento_credito';
			if new.bandera_maestro = 'SI' then
				update documento_credito set monto = monto+(new.monto) where iddocumento_credito = new.iddocumento_credito;
			end if;
        else
			update producto_historial set unidades_ingreso = unidades_ingreso -(new.cantidad), estado ='Inactivo' where idrelacion = new.iddetalle_documento_credito and tabla_relacion = 'detalle_documento_credito';
			if new.bandera_maestro = 'SI' then
				update documento_credito set monto = monto-(new.monto) where iddocumento_credito = new.iddocumento_credito;
			end if;
       end if;
    end if;
    
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`detalle_documento_credito_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`detalle_documento_credito`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
    set new.monto = new.cantidad*new.precio;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`detalle_documento_credito_BEFORE_UPDATE`
BEFORE UPDATE ON `nexthor_empresa`.`detalle_documento_credito`
FOR EACH ROW
BEGIN
	set new.monto = new.cantidad*new.precio;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`serie_documento_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`serie_documento`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`serie_documento_BEFORE_UPDATE`
BEFORE UPDATE ON `nexthor_empresa`.`serie_documento`
FOR EACH ROW
BEGIN
	if new.fecha != old.fecha then
		if new.fecha < old.fecha then
			set new.fecha = old.fecha;
        end if;
    end if;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`documento_debito_AFTER_INSERT`
AFTER INSERT ON `nexthor_empresa`.`documento_debito`
FOR EACH ROW
BEGIN
    insert into movimiento (debito, idrelacion, tabla_relacion, idrelacion_persona, tabla_relacion_persona, idsucursal)
    values (new.monto,new.iddocumento_debito,'documento', new.idcliente, 'cliente', new.idsucursal);
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`documento_debito_AFTER_UPDATE`
AFTER UPDATE ON `nexthor_empresa`.`documento_debito`
FOR EACH ROW
BEGIN
    if new.monto != old.monto then
		update movimiento set debito = debito +(new.monto-old.monto) where idrelacion = new.iddocumento_debito  and tabla_relacion = 'documento';
    end if;
    if new.estado != old.estado then
		if new.estado ='Inactivo' then
			update movimiento set debito = debito -(new.monto) where idrelacion = new.iddocumento_debito  and tabla_relacion = 'documento';
        elseif new.estado ='Activo' then
			update movimiento set debito = debito +(new.monto) where idrelacion = new.iddocumento_debito  and tabla_relacion = 'documento';
		end if;
        update detalle_documento_debito set estado = new.estado, bandera_maestro = 'No' where iddocumento_debito = new.iddocumento_debito;
	end if;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`documento_debito_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`documento_debito`
FOR EACH ROW
BEGIN
	declare var_serie VARCHAR(45);
	declare var_correlativo int;
	declare var_fecha date;
	
    select ifnull(serie,'SIN SERIE'), correlativo, fecha into var_serie, var_correlativo, var_fecha
	from serie_documento where idserie_documento = new.idserie_documento;
    
    if new.fecha < var_fecha then
		set new.fecha = var_fecha;
    end if;
    
    set new.fecha = fnc_use_fecha_contable_abierta(new.fecha,fnc_get_idempresa_idsucursal(new.idsucursal),'documento_debito');
	set new.idfecha_contable = fnc_get_idfecha_contable(new.fecha,fnc_get_idempresa_idsucursal(new.idsucursal),'documento_debito');
	
    update serie_documento set correlativo = correlativo + 1, fecha = new.fecha where idserie_documento = new.idserie_documento;
	
	set new.serie = var_serie;
	set new.correlativo = var_correlativo;
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`documento_debito_BEFORE_UPDATE`
BEFORE UPDATE ON `nexthor_empresa`.`documento_debito`
FOR EACH ROW
BEGIN
	if old.estado_documento = new.estado_documento then
		if old.estado_documento = 'Contabilizado' then
			SIGNAL SQLSTATE '45000'
			SET MESSAGE_TEXT = 'Ha ocurrido un error, No se puede modificar el documento debito porque esta contabilizado.';
        end if;
    end if;
    if new.idcliente != old.idcliente then
		set new.idcliente = old.idcliente;
    end if;
    if new.idsucursal != old.idsucursal then
		set new.idsucursal = old.idsucursal;
    end if;
    if new.estado_documento != old.estado_documento then
		if new.estado_documento ='Anulado' then
			set new.monto = 0;
        end if;
	end if;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`detalle_documento_debito_AFTER_INSERT`
AFTER INSERT ON `nexthor_empresa`.`detalle_documento_debito`
FOR EACH ROW
BEGIN
	INSERT INTO producto_historial (idproducto, idbodega, fecha, unidades_salida, idrelacion, tabla_relacion) 
    VALUES (new.idproducto, new.idbodega, now(), new.cantidad, new.iddetalle_documento_debito, 'detalle_documento_debito');
    
    update documento_debito  set monto = monto+(new.monto) where iddocumento_debito  = new.iddocumento_debito;
    
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`detalle_documento_debito_AFTER_UPDATE`
AFTER UPDATE ON `nexthor_empresa`.`detalle_documento_debito`
FOR EACH ROW
BEGIN
	if new.cantidad!=old.cantidad then
		update producto_historial set unidades_salida = unidades_salida +(new.cantidad-old.cantidad) where idrelacion = new.iddetalle_documento_debito  and tabla_relacion = 'detalle_documento_debito';
    end if;
    if new.monto!=old.monto then
		if new.bandera_maestro = 'SI' then
			update documento_debito  set monto = monto+(new.monto-old.monto) where iddocumento_debito  = new.iddocumento_debito;
		end if;
    end if;
	
	if new.importe_bruto!=old.importe_bruto or new.importe_descuento!=old.importe_descuento or new.importe_exento!=old.importe_exento or new.importe_otros_impuestos!=old.importe_otros_impuestos or new.importe_neto!=old.importe_neto or new.importe_iva!=old.importe_iva or new.importe_total!=old.importe_total  then
		update documento_debito  set importe_bruto = importe_bruto+(new.importe_bruto-old.importe_bruto), importe_descuento = importe_descuento+(new.importe_descuento-old.importe_descuento), importe_exento = importe_exento+(new.importe_exento-old.importe_exento), importe_otros_impuestos = importe_otros_impuestos+(new.importe_otros_impuestos-old.importe_otros_impuestos),
        importe_neto = importe_neto+(new.importe_neto-old.importe_neto), importe_iva = importe_iva+(new.importe_iva-old.importe_iva), importe_total = importe_total+(new.importe_total-old.importe_total) where iddocumento_debito  = new.iddocumento_debito;
    end if;
    if  new.estado!=old.estado then
		if new.estado = 'Activo' then
			update producto_historial set unidades_salida = unidades_salida +(new.cantidad), estado ='Activo' where idrelacion = new.iddetalle_documento_debito  and tabla_relacion = 'detalle_documento_debito';
			if new.bandera_maestro = 'SI' then
				update documento_debito  set monto = monto+(new.monto) where iddocumento_debito  = new.iddocumento_debito;
			end if;
		else
			update producto_historial set unidades_salida = unidades_salida -(new.cantidad), estado ='Inactivo' where idrelacion = new.iddetalle_documento_debito  and tabla_relacion = 'detalle_documento_debito';
			if new.bandera_maestro = 'SI' then
				update documento_debito  set monto = monto-(new.monto) where iddocumento_debito  = new.iddocumento_debito;
			end if;
		end if;
    end if;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`detalle_documento_debito_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`detalle_documento_debito`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
    set new.monto = new.cantidad*new.precio;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`detalle_documento_debito_BEFORE_UPDATE`
BEFORE UPDATE ON `nexthor_empresa`.`detalle_documento_debito`
FOR EACH ROW
BEGIN
	 set new.monto = new.cantidad*new.precio;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`documento_movimiento_AFTER_INSERT`
AFTER INSERT ON `nexthor_empresa`.`documento_movimiento`
FOR EACH ROW
BEGIN
	insert into movimiento (debito, idrelacion, tabla_relacion, idrelacion_persona, tabla_relacion_persona, idsucursal)
    values (new.monto,new.iddocumento_movimiento,'documento_movimiento_egreso', null, null, new.idsucursal_egreso);
	insert into movimiento (credito, idrelacion, tabla_relacion, idrelacion_persona, tabla_relacion_persona, idsucursal)
    values (new.monto,new.iddocumento_movimiento,'documento_movimiento_ingreso', null, null, new.idsucursal_ingreso);

END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`documento_movimiento_AFTER_UPDATE`
AFTER UPDATE ON `nexthor_empresa`.`documento_movimiento`
FOR EACH ROW
BEGIN
	if new.monto != old.monto then
		update movimiento set  debito = debito +(new.monto-old.monto) where idrelacion = new.iddocumento_movimiento and tabla_relacion = 'documento_movimiento_egreso';
		update movimiento set  credito = credito +(new.monto-old.monto) where idrelacion = new.iddocumento_movimiento and tabla_relacion = 'documento_movimiento_ingreso';
    end if;
    if new.estado != old.estado then
		if new.estado ='Inactivo' then
			update movimiento set debito = debito -(new.monto)  where idrelacion = new.iddocumento_movimiento and tabla_relacion = 'documento_movimiento_egreso';
			update movimiento set credito = credito -(new.monto)where idrelacion = new.iddocumento_movimiento and tabla_relacion = 'documento_movimiento_ingreso';
        elseif new.estado ='Activo' then
			update movimiento set debito = debito +(new.monto) where idrelacion = new.iddocumento_movimiento and tabla_relacion = 'documento_movimiento_egreso';
			update movimiento set credito = credito +(new.monto) where idrelacion = new.iddocumento_movimiento and tabla_relacion = 'documento_movimiento_ingreso';
		end if;
	end if;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`documento_movimiento_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`documento_movimiento`
FOR EACH ROW
BEGIN
	declare var_serie VARCHAR(45);
	declare var_correlativo int;
	declare var_fecha date;
	
    select ifnull(serie,'SIN SERIE'), correlativo, fecha into var_serie, var_correlativo, var_fecha
	from serie_documento where idserie_documento = new.idserie_documento;
    
    if new.fecha < var_fecha then
		set new.fecha = var_fecha;
    end if;
    update serie_documento set correlativo = correlativo + 1, fecha = new.fecha where idserie_documento = new.idserie_documento;
	
	set new.serie = var_serie;
	set new.correlativo = var_correlativo;
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`documento_movimiento_BEFORE_UPDATE`
BEFORE UPDATE ON `nexthor_empresa`.`documento_movimiento`
FOR EACH ROW
BEGIN
	if new.idsucursal_ingreso != old.idsucursal_ingreso then
		set new.idsucursal_ingreso = old.idsucursal_ingreso;
    end if;
    if new.idsucursal_egreso != old.idsucursal_egreso then
		set new.idsucursal_egreso = old.idsucursal_egreso;
    end if;
    if new.estado_documento != old.estado_documento then
		if new.estado_documento ='Anulado' then
			set new.monto = 0;
        end if;
	end if;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`detalle_documento_movimiento_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`detalle_documento_movimiento`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
    set new.monto = new.precio*new.cantidad;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`detalle_documento_movimiento_AFTER_INSERT`
AFTER INSERT ON `nexthor_empresa`.`detalle_documento_movimiento`
FOR EACH ROW
BEGIN
	INSERT INTO producto_historial (idproducto, idbodega, fecha, unidades_salida, idrelacion, tabla_relacion) 
    VALUES (new.idproducto, new.idbodega_egreso, now(), new.cantidad, new.iddetalle_documento_movimiento, 'detalle_documento_movimiento_egreso');
    INSERT INTO producto_historial (idproducto, idbodega, fecha, unidades_ingreso, idrelacion, tabla_relacion) 
    VALUES (new.idproducto, new.idbodega_ingreso, now(), new.cantidad, new.iddetalle_documento_movimiento, 'detalle_documento_movimiento_ingreso');
	
    update documento_movimiento set monto = monto+(new.monto) where iddocumento_movimiento = new.iddocumento_movimiento;

END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`detalle_documento_movimiento_BEFORE_UPDATE`
BEFORE UPDATE ON `nexthor_empresa`.`detalle_documento_movimiento`
FOR EACH ROW
BEGIN
	set new.monto = new.cantidad*new.precio;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`detalle_documento_movimiento_AFTER_UPDATE`
AFTER UPDATE ON `nexthor_empresa`.`detalle_documento_movimiento`
FOR EACH ROW
BEGIN
	update producto_historial set unidades_salida = unidades_salida +(new.cantidad-old.cantidad) where idrelacion = new.iddetalle_documento_movimiento and tabla_relacion = 'detalle_documento_movimiento_egreso';
	update producto_historial set unidades_ingreso = unidades_ingreso +(new.cantidad-old.cantidad) where idrelacion = new.iddetalle_documento_movimiento and tabla_relacion = 'detalle_documento_movimiento_ingreso';
	if  new.estado!=old.estado then
		if new.estado = 'Activo' then
			update producto_historial set unidades_salida = unidades_salida +(new.cantidad), estado ='Activo' where idrelacion = new.iddetalle_documento_movimiento and tabla_relacion = 'detalle_documento_movimiento_egreso';
			update producto_historial set unidades_ingreso = unidades_ingreso +(new.cantidad), estado ='Activo' where idrelacion = new.iddetalle_documento_movimiento and tabla_relacion = 'detalle_documento_movimiento_ingreso';
		else
			update producto_historial set unidades_salida = unidades_salida -(new.cantidad), estado ='Inactivo' where idrelacion = new.iddetalle_documento_movimiento and tabla_relacion = 'detalle_documento_movimiento_egreso';
			update producto_historial set unidades_ingreso = unidades_ingreso -(new.cantidad), estado ='Inactivo' where idrelacion = new.iddetalle_documento_movimiento and tabla_relacion = 'detalle_documento_movimiento_ingreso';
		end if;
    end if;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`movimiento_AFTER_INSERT`
AFTER INSERT ON `nexthor_empresa`.`movimiento`
FOR EACH ROW
BEGIN
	update sucursal set credito = credito +  (new.credito), debito = debito +  (new.debito) where idsucursal = new.idsucursal;
    if (new.tabla_relacion_persona ='cliente') then
		update cliente set credito = credito +  (new.credito), debito = debito +  (new.debito) where idcliente = new.idrelacion_persona;
	elseif (new.tabla_relacion_persona ='proveedor') then
		update proveedor set credito = credito +  (new.credito), debito = debito +  (new.debito) where idproveedor = new.idrelacion_persona;
    end if;
    
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`movimiento_AFTER_UPDATE`
AFTER UPDATE ON `nexthor_empresa`.`movimiento`
FOR EACH ROW
BEGIN
	update sucursal set credito = credito +  (new.credito-old.credito), debito = debito +  (new.debito-old.debito) where idsucursal = new.idsucursal;
	if (new.tabla_relacion_persona ='cliente') then
		update cliente set credito = credito +  (new.credito-old.credito), debito = debito +  (new.debito-old.debito) where idcliente = new.idrelacion_persona;
    elseif (new.tabla_relacion_persona ='proveedor') then
		update proveedor set credito = credito +  (new.credito-old.credito), debito = debito +  (new.debito-old.debito) where idproveedor = new.idrelacion_persona;
    end if;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`movimiento_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`movimiento`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`tipo_pago_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`tipo_pago`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`voucher_tarjeta_AFTER_INSERT`
AFTER INSERT ON `nexthor_empresa`.`voucher_tarjeta`
FOR EACH ROW
BEGIN
	insert into cuenta_transaccion (idcuenta, fecha, descripcion, credito, id_referencia, tabla_referencia)
		values (new.idcuenta, new.fecha, new.descripcion, new.monto, new.idvoucher_tarjeta, 'voucher_tarjeta');
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`voucher_tarjeta_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`voucher_tarjeta`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`voucher_tarjeta_BEFORE_UPDATE`
BEFORE UPDATE ON `nexthor_empresa`.`voucher_tarjeta`
FOR EACH ROW
BEGIN
	if new.estado!=old.estado then
		if new.estado = 'Inactivo' then
            set new.monto = 0;
		end if;
	end if;
    if new.monto!=old.monto then
		update cuenta_transaccion set credito = credito+(new.monto-old.monto) where id_referencia = new.idvoucher_tarjeta and tabla_referencia = 'voucher_tarjeta';
	end if;
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
TRIGGER `nexthor_empresa`.`pago_proveedor_AFTER_INSERT`
AFTER INSERT ON `nexthor_empresa`.`pago_proveedor`
FOR EACH ROW
BEGIN
	insert into movimiento (debito, idrelacion, tabla_relacion, idrelacion_persona, tabla_relacion_persona, idsucursal)
    values (new.monto,new.idpago_proveedor,'pago_proveedor', new.idproveedor, 'proveedor', new.idsucursal);

END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`pago_proveedor_AFTER_UPDATE`
AFTER UPDATE ON `nexthor_empresa`.`pago_proveedor`
FOR EACH ROW
BEGIN
	if new.monto != old.monto then
		update movimiento set debito = debito +(new.monto-old.monto) where idrelacion = new.idpago_proveedor and tabla_relacion = 'pago_proveedor';
    end if;
    if new.estado != old.estado then
		if new.estado ='Inactivo' then
			update movimiento set debito = debito -(new.monto) where idrelacion = new.idpago_proveedor and tabla_relacion = 'pago_proveedor';
        elseif new.estado ='Activo' then
			update movimiento set debito = debito +(new.monto) where idrelacion = new.idpago_proveedor and tabla_relacion = 'pago_proveedor';
		end if;
	end if;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`pago_proveedor_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`pago_proveedor`
FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`pago_proveedor_BEFORE_UPDATE`
BEFORE UPDATE ON `nexthor_empresa`.`pago_proveedor`
FOR EACH ROW
BEGIN
	if new.idproveedor!= old.idproveedor then
		set new.idproveedor = old.idproveedor;
    end if;
    if new.idsucursal != old.idsucursal then
		set new.idsucursal = old.idsucursal;
    end if;
END$$

USE `nexthor_empresa`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `nexthor_empresa`.`parametros_sistema_BEFORE_INSERT`
BEFORE INSERT ON `nexthor_empresa`.`parametros_sistema`
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


DELIMITER ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
