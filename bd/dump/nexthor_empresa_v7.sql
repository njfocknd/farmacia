CREATE DATABASE  IF NOT EXISTS `nexthor_empresa` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `nexthor_empresa`;
-- MySQL dump 10.13  Distrib 5.6.24, for Win32 (x86)
--
-- Host: nexthordb.cquvmppcukva.us-west-2.rds.amazonaws.com    Database: nexthor_empresa
-- ------------------------------------------------------
-- Server version	5.6.23-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `aplicacion_movimiento`
--

DROP TABLE IF EXISTS `aplicacion_movimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aplicacion_movimiento` (
  `idaplicacion_movimiento` int(11) NOT NULL AUTO_INCREMENT,
  `idmovimiento_credito` int(11) NOT NULL,
  `idmovimiento_debito` int(11) NOT NULL,
  `monto` decimal(10,2) NOT NULL DEFAULT '0.00',
  `fecha` date DEFAULT NULL,
  `fecha_insercion` datetime DEFAULT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idaplicacion_movimiento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aplicacion_movimiento`
--

LOCK TABLES `aplicacion_movimiento` WRITE;
/*!40000 ALTER TABLE `aplicacion_movimiento` DISABLE KEYS */;
/*!40000 ALTER TABLE `aplicacion_movimiento` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`aplicacion_movimiento_BEFORE_INSERT` BEFORE INSERT ON `aplicacion_movimiento` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`aplicacion_movimiento_AFTER_INSERT` AFTER INSERT ON `aplicacion_movimiento` FOR EACH ROW
BEGIN
	update movimiento set monto_aplicado = monto_aplicado +(new.monto) where idmovimiento in(new.idmovimiento_debito, new.idmovimiento_credito);
   
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`aplicacion_movimiento_BEFORE_UPDATE` BEFORE UPDATE ON `aplicacion_movimiento` FOR EACH ROW
BEGIN
	if new.idmovimiento_credito!= old.idmovimiento_credito then
		set new.idmovimiento_credito = old.idmovimiento_credito;
    end if;
    if new.idmovimiento_debito != old.idmovimiento_debito then
		set new.idmovimiento_debito = old.idmovimiento_debito;
    end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`aplicacion_movimiento_AFTER_UPDATE` AFTER UPDATE ON `aplicacion_movimiento` FOR EACH ROW
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
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `audittrail`
--

DROP TABLE IF EXISTS `audittrail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audittrail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `script` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `table` varchar(255) DEFAULT NULL,
  `field` varchar(255) DEFAULT NULL,
  `keyvalue` longtext,
  `oldvalue` longtext,
  `newvalue` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audittrail`
--

LOCK TABLES `audittrail` WRITE;
/*!40000 ALTER TABLE `audittrail` DISABLE KEYS */;
INSERT INTO `audittrail` VALUES (1,'2015-11-09 06:17:51','/farmacia/app/logout.php','Administrator','Salir del Sistema','::1','','','',''),(2,'2015-11-09 06:40:45','/farmacia/app/pago_proveedoredit.php','1','U','pago_proveedor','monto','2','100.00','101.00'),(3,'2015-11-11 00:15:07','/farmacia/app/login.php','admin','Ingresar','::1','','','',''),(4,'2015-11-11 00:17:47','/farmacia/app/cuenta_transaccionadd.php','-1','A','cuenta_transaccion','idcuenta','4','','1'),(5,'2015-11-11 00:17:47','/farmacia/app/cuenta_transaccionadd.php','-1','A','cuenta_transaccion','fecha','4','','2015-11-10'),(6,'2015-11-11 00:17:47','/farmacia/app/cuenta_transaccionadd.php','-1','A','cuenta_transaccion','descripcion','4','',NULL),(7,'2015-11-11 00:17:47','/farmacia/app/cuenta_transaccionadd.php','-1','A','cuenta_transaccion','debito','4','','0'),(8,'2015-11-11 00:17:47','/farmacia/app/cuenta_transaccionadd.php','-1','A','cuenta_transaccion','credito','4','','5000'),(9,'2015-11-11 00:17:47','/farmacia/app/cuenta_transaccionadd.php','-1','A','cuenta_transaccion','idcuenta_transaccion','4','','4'),(10,'2015-11-11 05:23:24','/farmacia/app/pago_clienteedit.php','-1','U','pago_cliente','idvoucher_tarjeta','2',NULL,'2');
/*!40000 ALTER TABLE `audittrail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banco`
--

DROP TABLE IF EXISTS `banco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banco` (
  `idbanco` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `acronimo` varchar(45) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `url` varchar(45) DEFAULT NULL,
  `idpais` int(11) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime DEFAULT NULL,
  PRIMARY KEY (`idbanco`),
  KEY `fk_banco_idpais_idx` (`idpais`),
  CONSTRAINT `fk_banco_idpais` FOREIGN KEY (`idpais`) REFERENCES `pais` (`idpais`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banco`
--

LOCK TABLES `banco` WRITE;
/*!40000 ALTER TABLE `banco` DISABLE KEYS */;
INSERT INTO `banco` VALUES (1,'Crédito Hipotecario Nacional','CHN','2379-1650','www.chn.com.gt',1,'Activo','2015-11-08 18:21:57'),(2,'Banco de Desarrollo Rural','BANRU','2379-1650','www.banrural.com',1,'Activo','2015-11-08 18:21:57'),(3,'Banco Industrial','BI','242-03000','www.bi.com.gt',1,'Activo','2015-11-08 18:21:57'),(4,'Banco G&T Continental','GyT','2338-6801','www.gytcontinental.com.gt',1,'Activo','2015-11-08 18:21:57'),(5,'Banco Agromercantil','AGRO','233-86565','www.agromercantil.com.gt',1,'Activo','2015-11-08 18:21:57'),(6,'Banco Americano','AMERI','2386-1700','www.bancoamericano.com.gt',1,'Activo','2015-11-08 18:21:57'),(7,'Banco Azteca de Guatemala','AZTEC','2229-2222','www.bancoazteca.com.gt',1,'Activo','2015-11-08 18:21:57'),(8,'Banco de Antigua','ANTIG','2420-5555','NA',1,'Activo','2015-11-08 18:21:57'),(9,'Banco de America Central','BAC','2361-0909','http://www.bac.net',1,'Activo','2015-11-08 18:21:57'),(10,'Banco de los Trabajadores','BANTR','2363-3423','NA',1,'Activo','2015-11-08 18:21:57'),(11,'Banco Inmobiliario','INMOB','2429-3700','www.bancoinmobiliario.com.gt',1,'Activo','2015-11-08 18:21:57'),(12,'Banco Internacional','INTER','2277-3666','www.bancointernacional.com.gt',1,'Activo','2015-11-08 18:21:57'),(13,'Banco Reformador','REFOR','2382-1300','www.bancoreformador.com',1,'Activo','2015-11-08 18:21:57'),(14,'Citi Bank Guatemala','CITI','2336-8001','www.citi.com.gt',1,'Activo','2015-11-08 18:21:57'),(15,'Vivibanco','VIVIB','2277-7878','www.vivibanco.com.gt',1,'Activo','2015-11-08 18:21:57'),(16,'Banco de Credito','CREDT','2384-4900','www.bancredit.com.gt',1,'Activo','2015-11-08 18:21:57');
/*!40000 ALTER TABLE `banco` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bodega`
--

DROP TABLE IF EXISTS `bodega`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bodega` (
  `idbodega` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idsucursal` int(11) NOT NULL,
  `idtipo_bodega` int(11) NOT NULL DEFAULT '1',
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idbodega`),
  KEY `fk_bodega_idtipo_bodega_idx` (`idtipo_bodega`),
  KEY `fk_bodega_idsucursal_idx` (`idsucursal`),
  CONSTRAINT `fk_bodega_idsucursal` FOREIGN KEY (`idsucursal`) REFERENCES `sucursal` (`idsucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_bodega_idtipo_bodega` FOREIGN KEY (`idtipo_bodega`) REFERENCES `tipo_bodega` (`idtipo_bodega`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bodega`
--

LOCK TABLES `bodega` WRITE;
/*!40000 ALTER TABLE `bodega` DISABLE KEYS */;
INSERT INTO `bodega` VALUES (1,'Estanteria',1,1,'Activo'),(2,'Bodega',1,2,'Activo'),(3,'Bodegon',2,2,'Activo');
/*!40000 ALTER TABLE `bodega` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `boleta_deposito`
--

DROP TABLE IF EXISTS `boleta_deposito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `boleta_deposito` (
  `idboleta_deposito` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(45) DEFAULT NULL,
  `idbanco` int(11) NOT NULL DEFAULT '1',
  `idcuenta` int(11) NOT NULL DEFAULT '1',
  `fecha` date DEFAULT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `efectivo` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cheque` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cheque_otro` decimal(10,2) NOT NULL DEFAULT '0.00',
  `monto` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`idboleta_deposito`),
  KEY `fk_boleta_deposito_idbanco_idx` (`idbanco`),
  KEY `fk_boleta_deposito_idcuenta_idx` (`idcuenta`),
  CONSTRAINT `fk_boleta_deposito_idbanco` FOREIGN KEY (`idbanco`) REFERENCES `banco` (`idbanco`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_boleta_deposito_idcuenta` FOREIGN KEY (`idcuenta`) REFERENCES `cuenta` (`idcuenta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `boleta_deposito`
--

LOCK TABLES `boleta_deposito` WRITE;
/*!40000 ALTER TABLE `boleta_deposito` DISABLE KEYS */;
INSERT INTO `boleta_deposito` VALUES (1,'1',1,1,'2015-11-10','Activo','2015-11-11 02:30:29',NULL,10000.00,1000.00,0.00,11000.00);
/*!40000 ALTER TABLE `boleta_deposito` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`boleta_deposito_BEFORE_INSERT` BEFORE INSERT ON `boleta_deposito` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
    set new.monto = (new.efectivo+new.cheque+new.cheque_otro);
    
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`boleta_deposito_AFTER_INSERT` AFTER INSERT ON `boleta_deposito` FOR EACH ROW
BEGIN
	insert into cuenta_transaccion (idcuenta, fecha, descripcion, credito, id_referencia, tabla_referencia)
		values (new.idcuenta, new.fecha, new.descripcion, new.monto, new.idboleta_deposito, 'boleta_deposito');
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`boleta_deposito_BEFORE_UPDATE` BEFORE UPDATE ON `boleta_deposito` FOR EACH ROW
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
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria` (
  `idcategoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL,
  `fecha_insercion` datetime DEFAULT NULL,
  PRIMARY KEY (`idcategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'Antigripal','Activo',NULL);
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cliente` (
  `idcliente` int(11) NOT NULL AUTO_INCREMENT,
  `idpersona` int(11) NOT NULL DEFAULT '1',
  `codigo` varchar(45) DEFAULT NULL,
  `nit` varchar(45) DEFAULT NULL,
  `nombre_factura` varchar(45) DEFAULT NULL,
  `direccion_factura` varchar(45) DEFAULT NULL,
  `debito` decimal(10,2) NOT NULL DEFAULT '0.00',
  `credito` decimal(10,2) NOT NULL DEFAULT '0.00',
  `fecha_insercion` datetime DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `telefono` varchar(45) DEFAULT NULL,
  `tributa` enum('Si','No') NOT NULL DEFAULT 'Si',
  PRIMARY KEY (`idcliente`),
  KEY `fk_cliente_idpersona_idx` (`idpersona`),
  CONSTRAINT `fk_cliente_idpersona` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (1,1,NULL,NULL,'Nestor Fock',NULL,200.00,700.00,NULL,NULL,'Activo',NULL,'Si'),(2,2,NULL,'7808912-2','Silvia Gómez','Ciudad',0.00,0.00,NULL,'njfock@gmail.com','Activo',NULL,'Si');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cuenta`
--

DROP TABLE IF EXISTS `cuenta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cuenta` (
  `idcuenta` int(11) NOT NULL AUTO_INCREMENT,
  `idbanco` int(11) NOT NULL DEFAULT '1',
  `idsucursal` int(11) NOT NULL DEFAULT '1',
  `idmoneda` int(11) NOT NULL DEFAULT '1',
  `numero` varchar(45) DEFAULT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `saldo` decimal(10,2) NOT NULL DEFAULT '0.00',
  `debito` decimal(10,2) NOT NULL DEFAULT '0.00',
  `credito` decimal(10,2) NOT NULL DEFAULT '0.00',
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime DEFAULT NULL,
  PRIMARY KEY (`idcuenta`),
  KEY `fk_cuenta_idbanco_idx` (`idbanco`),
  KEY `fk_cuenta_idsucursal_idx` (`idsucursal`),
  KEY `fk_cuenta_idmoneda_idx` (`idmoneda`),
  CONSTRAINT `fk_cuenta_idbanco` FOREIGN KEY (`idbanco`) REFERENCES `banco` (`idbanco`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cuenta_idmoneda` FOREIGN KEY (`idmoneda`) REFERENCES `moneda` (`idmoneda`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cuenta_idsucursal` FOREIGN KEY (`idsucursal`) REFERENCES `sucursal` (`idsucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cuenta`
--

LOCK TABLES `cuenta` WRITE;
/*!40000 ALTER TABLE `cuenta` DISABLE KEYS */;
INSERT INTO `cuenta` VALUES (1,1,1,1,'898','CHN CUENTA',15200.00,1000.00,16200.00,'Activo',NULL);
/*!40000 ALTER TABLE `cuenta` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`cuenta_BEFORE_INSERT` BEFORE INSERT ON `cuenta` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`cuenta_BEFORE_UPDATE` BEFORE UPDATE ON `cuenta` FOR EACH ROW
BEGIN
	set new.saldo = new.credito - new.debito;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `cuenta_transaccion`
--

DROP TABLE IF EXISTS `cuenta_transaccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cuenta_transaccion` (
  `idcuenta_transaccion` int(11) NOT NULL AUTO_INCREMENT,
  `idcuenta` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `debito` decimal(10,2) NOT NULL DEFAULT '0.00',
  `credito` decimal(10,2) NOT NULL DEFAULT '0.00',
  `id_referencia` int(11) DEFAULT NULL,
  `tabla_referencia` varchar(45) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime DEFAULT NULL,
  PRIMARY KEY (`idcuenta_transaccion`),
  KEY `fk_cuenta_transaccion_idcuenta_idx` (`idcuenta`),
  CONSTRAINT `fk_cuenta_transaccion_idcuenta` FOREIGN KEY (`idcuenta`) REFERENCES `cuenta` (`idcuenta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cuenta_transaccion`
--

LOCK TABLES `cuenta_transaccion` WRITE;
/*!40000 ALTER TABLE `cuenta_transaccion` DISABLE KEYS */;
INSERT INTO `cuenta_transaccion` VALUES (1,1,'2015-11-08','234324',1000.00,0.00,NULL,NULL,'Activo',NULL),(2,1,'2015-11-08','213',1000.00,0.00,NULL,NULL,'Activo','2015-11-09 05:02:20'),(3,1,'2015-11-08',NULL,0.00,0.00,NULL,NULL,'Inactivo','2015-11-09 05:08:02'),(4,1,'2015-11-10',NULL,0.00,5000.00,NULL,NULL,'Activo','2015-11-11 00:17:47'),(5,1,'2015-11-10',NULL,0.00,11000.00,1,'boleta_deposito','Activo','2015-11-11 02:30:29'),(6,1,NULL,NULL,0.00,200.00,2,'voucher_tarjeta','Activo','2015-11-11 02:56:44');
/*!40000 ALTER TABLE `cuenta_transaccion` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`cuenta_transaccion_BEFORE_INSERT` BEFORE INSERT ON `cuenta_transaccion` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`cuenta_transaccion_AFTER_INSERT` AFTER INSERT ON `cuenta_transaccion` FOR EACH ROW
BEGIN
	update cuenta set debito = debito+(new.debito), credito = credito+(new.credito) where idcuenta = new.idcuenta;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`cuenta_transaccion_BEFORE_UPDATE` BEFORE UPDATE ON `cuenta_transaccion` FOR EACH ROW
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
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `departamento`
--

DROP TABLE IF EXISTS `departamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departamento` (
  `iddepartamento` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idpais` int(11) NOT NULL DEFAULT '1',
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`iddepartamento`),
  KEY `fk_departamento_idpais_idx` (`idpais`),
  CONSTRAINT `fk_departamento_idpais` FOREIGN KEY (`idpais`) REFERENCES `pais` (`idpais`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departamento`
--

LOCK TABLES `departamento` WRITE;
/*!40000 ALTER TABLE `departamento` DISABLE KEYS */;
INSERT INTO `departamento` VALUES (1,'GUATEMALA',1,'Activo'),(2,'EL PROGRESO',1,'Activo'),(3,'SACATEPEQUEZ',1,'Activo'),(4,'CHIMALTENANGO',1,'Activo'),(5,'ESCUINTLA',1,'Activo'),(6,'SANTA ROSA',1,'Activo'),(7,'SOLOLA',1,'Activo'),(8,'TOTONICAPAN',1,'Activo'),(9,'QUETZALTENANGO',1,'Activo'),(10,'SUCHITEPEQUEZ',1,'Activo'),(11,'RETALHULEU',1,'Activo'),(12,'SAN MARCOS',1,'Activo'),(13,'HUEHUETENANGO',1,'Activo'),(14,'QUICHE',1,'Activo'),(15,'BAJA VERAPAZ',1,'Activo'),(16,'ALTA VERAPAZ',1,'Activo'),(17,'PETEN',1,'Activo'),(18,'IZABAL',1,'Activo'),(19,'ZACAPA',1,'Activo'),(20,'CHIQUIMULA',1,'Activo'),(21,'JALAPA',1,'Activo'),(22,'JUTIAPA',1,'Activo');
/*!40000 ALTER TABLE `departamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_documento_credito`
--

DROP TABLE IF EXISTS `detalle_documento_credito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalle_documento_credito` (
  `iddetalle_documento_credito` int(11) NOT NULL AUTO_INCREMENT,
  `iddocumento_credito` int(11) NOT NULL DEFAULT '1',
  `idproducto` int(11) NOT NULL DEFAULT '1',
  `idbodega` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL DEFAULT '0.00',
  `monto` decimal(10,2) NOT NULL DEFAULT '0.00',
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime DEFAULT NULL,
  PRIMARY KEY (`iddetalle_documento_credito`),
  KEY `fk_detalle_documento_credito_iddocumento_debito_credito_idx` (`iddocumento_credito`),
  KEY `fk_detalle_documento_credito_idbodega_idx` (`idbodega`),
  KEY `fk_detalle_documento_credito_idproducto_idx` (`idproducto`),
  CONSTRAINT `fk_detalle_documento_credito_idbodega` FOREIGN KEY (`idbodega`) REFERENCES `bodega` (`idbodega`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalle_documento_credito_iddocumento_debito_credito` FOREIGN KEY (`iddocumento_credito`) REFERENCES `documento_credito` (`iddocumento_credito`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalle_documento_credito_idproducto` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_documento_credito`
--

LOCK TABLES `detalle_documento_credito` WRITE;
/*!40000 ALTER TABLE `detalle_documento_credito` DISABLE KEYS */;
INSERT INTO `detalle_documento_credito` VALUES (1,1,2,3,2000,5.00,10000.00,'Activo','2015-11-05 20:08:08');
/*!40000 ALTER TABLE `detalle_documento_credito` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`detalle_documento_credito_BEFORE_INSERT` BEFORE INSERT ON `detalle_documento_credito` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
    set new.monto = new.cantidad*new.precio;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`detalle_documento_credito_AFTER_INSERT` AFTER INSERT ON `detalle_documento_credito` FOR EACH ROW
BEGIN
	INSERT INTO producto_historial (idproducto, idbodega, fecha, unidades_ingreso, idrelacion, tabla_relacion) 
    VALUES (new.idproducto, new.idbodega, now(), new.cantidad, new.iddetalle_documento_credito, 'detalle_documento_credito');
    
    update documento_credito set monto = monto+(new.monto) where iddocumento_credito = new.iddocumento_credito;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`detalle_documento_credito_BEFORE_UPDATE` BEFORE UPDATE ON `detalle_documento_credito` FOR EACH ROW
BEGIN
	set new.monto = new.cantidad*new.precio;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`detalle_documento_credito_AFTER_UPDATE` AFTER UPDATE ON `detalle_documento_credito` FOR EACH ROW
BEGIN
	update producto_historial set unidades_ingreso = unidades_ingreso +(new.cantidad-old.cantidad) where idrelacion = new.iddetalle_documento_credito and tabla_relacion = 'detalle_documento_credito';
    update documento_credito set monto = monto+(new.monto-old.monto) where iddocumento_credito = new.iddocumento_credito;
    if  new.estado!=old.estado then
		if new.estado = 'Activo' then
			update producto_historial set unidades_ingreso = unidades_ingreso +(new.cantidad), estado ='Activo' where idrelacion = new.iddetalle_documento_credito and tabla_relacion = 'detalle_documento_credito';
			update documento_credito set monto = monto+(new.monto) where iddocumento_credito = new.iddocumento_credito;
		else
			update producto_historial set unidades_ingreso = unidades_ingreso -(new.cantidad), estado ='Inactivo' where idrelacion = new.iddetalle_documento_credito and tabla_relacion = 'detalle_documento_credito';
			update documento_credito set monto = monto-(new.monto) where iddocumento_credito = new.iddocumento_credito;
        end if;
    end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `detalle_documento_debito`
--

DROP TABLE IF EXISTS `detalle_documento_debito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalle_documento_debito` (
  `iddetalle_documento_debito` int(11) NOT NULL AUTO_INCREMENT,
  `iddocumento_debito` int(11) NOT NULL DEFAULT '1',
  `idproducto` int(11) NOT NULL DEFAULT '1',
  `idbodega` int(11) NOT NULL DEFAULT '1',
  `cantidad` int(11) NOT NULL DEFAULT '0',
  `precio` decimal(10,2) NOT NULL DEFAULT '0.00',
  `monto` decimal(10,2) NOT NULL DEFAULT '0.00',
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime DEFAULT NULL,
  PRIMARY KEY (`iddetalle_documento_debito`),
  KEY `fk_detalle_documento_debito_iddocumento_debito_idx` (`iddocumento_debito`),
  KEY `fk_detalle_documento_debito_idproducto_idx` (`idproducto`),
  KEY `fk_detalle_documento_debito_idbodega_idx` (`idbodega`),
  KEY `fk_detalle_document_idproducto_historial_idx` (`fecha_insercion`),
  CONSTRAINT `fk_detalle_documento_debito_idbodega` FOREIGN KEY (`idbodega`) REFERENCES `bodega` (`idbodega`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalle_documento_debito_iddocumento_debito` FOREIGN KEY (`iddocumento_debito`) REFERENCES `documento_debito` (`iddocumento_debito`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalle_documento_debito_idproducto` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_documento_debito`
--

LOCK TABLES `detalle_documento_debito` WRITE;
/*!40000 ALTER TABLE `detalle_documento_debito` DISABLE KEYS */;
INSERT INTO `detalle_documento_debito` VALUES (2,1,1,1,21,5.50,115.50,'Activo','2015-10-29 22:28:11'),(3,1,2,1,2,10.00,20.00,'Activo','2015-10-29 22:29:46'),(4,1,1,1,249,1.00,249.00,'Inactivo','2015-10-29 22:34:56'),(5,2,1,1,100,2.00,200.00,'Inactivo','2015-10-29 22:42:00'),(6,2,1,1,200,4.00,800.00,'Activo','2015-10-29 22:42:11'),(7,4,2,1,48,2.00,96.00,'Activo','2015-11-05 20:02:39'),(8,6,2,1,100,2.00,200.00,'Activo','2015-11-06 01:38:35');
/*!40000 ALTER TABLE `detalle_documento_debito` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`detalle_documento_debito_BEFORE_INSERT` BEFORE INSERT ON `detalle_documento_debito` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
    set new.monto = new.cantidad*new.precio;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`detalle_documento_debito_AFTER_INSERT` AFTER INSERT ON `detalle_documento_debito` FOR EACH ROW
BEGIN
	INSERT INTO producto_historial (idproducto, idbodega, fecha, unidades_salida, idrelacion, tabla_relacion) 
    VALUES (new.idproducto, new.idbodega, now(), new.cantidad, new.iddetalle_documento_debito, 'detalle_documento_debito');
    
    update documento_debito  set monto = monto+(new.monto) where iddocumento_debito  = new.iddocumento_debito;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`detalle_documento_debito_BEFORE_UPDATE` BEFORE UPDATE ON `detalle_documento_debito` FOR EACH ROW
BEGIN
	 set new.monto = new.cantidad*new.precio;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`detalle_documento_debito_AFTER_UPDATE` AFTER UPDATE ON `detalle_documento_debito` FOR EACH ROW
BEGIN
	update producto_historial set unidades_salida = unidades_salida +(new.cantidad-old.cantidad) where idrelacion = new.iddetalle_documento_debito  and tabla_relacion = 'detalle_documento_debito';
    update documento_debito  set monto = monto+(new.monto-old.monto) where iddocumento_debito  = new.iddocumento_debito;
    if  new.estado!=old.estado then
		if new.estado = 'Activo' then
			update producto_historial set unidades_salida = unidades_salida +(new.cantidad), estado ='Activo' where idrelacion = new.iddetalle_documento_debito  and tabla_relacion = 'detalle_documento_debito';
			update documento_debito  set monto = monto+(new.monto) where iddocumento_debito  = new.iddocumento_debito;
		else
			update producto_historial set unidades_salida = unidades_salida -(new.cantidad), estado ='Inactivo' where idrelacion = new.iddetalle_documento_debito  and tabla_relacion = 'detalle_documento_debito';
			update documento_debito  set monto = monto-(new.monto) where iddocumento_debito  = new.iddocumento_debito;
        end if;
    end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `detalle_documento_movimiento`
--

DROP TABLE IF EXISTS `detalle_documento_movimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalle_documento_movimiento` (
  `iddetalle_documento_movimiento` int(11) NOT NULL AUTO_INCREMENT,
  `iddocumento_movimiento` int(11) NOT NULL DEFAULT '1',
  `idproducto` int(11) NOT NULL DEFAULT '1',
  `idbodega_ingreso` int(11) NOT NULL DEFAULT '1',
  `idbodega_egreso` int(11) NOT NULL DEFAULT '1',
  `cantidad` int(11) NOT NULL DEFAULT '0',
  `fecha_insercion` datetime DEFAULT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `monto` decimal(10,2) NOT NULL DEFAULT '0.00',
  `precio` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`iddetalle_documento_movimiento`),
  KEY `fk_detalle_documento_movimiento_iddocumento_movimiento_idx` (`iddocumento_movimiento`),
  KEY `fk_detalle_documento_movimiento_idproducto_idx` (`idproducto`),
  KEY `fk_detalle_documento_movimiento_idbodega_ingreso_idx` (`idbodega_ingreso`),
  KEY `fk_detalle_documento_movimiento_idbodega_egreso_idx` (`idbodega_egreso`),
  CONSTRAINT `fk_detalle_documento_movimiento_idbodega_egreso` FOREIGN KEY (`idbodega_egreso`) REFERENCES `bodega` (`idbodega`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalle_documento_movimiento_idbodega_ingreso` FOREIGN KEY (`idbodega_ingreso`) REFERENCES `bodega` (`idbodega`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalle_documento_movimiento_iddocumento_movimiento` FOREIGN KEY (`iddocumento_movimiento`) REFERENCES `documento_movimiento` (`iddocumento_movimiento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalle_documento_movimiento_idproducto` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_documento_movimiento`
--

LOCK TABLES `detalle_documento_movimiento` WRITE;
/*!40000 ALTER TABLE `detalle_documento_movimiento` DISABLE KEYS */;
INSERT INTO `detalle_documento_movimiento` VALUES (1,1,2,1,2,150,'2015-11-05 20:05:33','Activo',0.00,0.00),(2,3,1,1,2,100,'2015-11-06 02:12:57','Activo',1000.00,10.00),(3,3,1,1,2,100,'2015-11-06 02:20:30','Activo',1000.00,10.00),(4,3,1,1,2,100,'2015-11-06 02:24:01','Activo',1000.00,10.00);
/*!40000 ALTER TABLE `detalle_documento_movimiento` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`detalle_documento_movimiento_BEFORE_INSERT` BEFORE INSERT ON `detalle_documento_movimiento` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
    set new.monto = new.precio*new.cantidad;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`detalle_documento_movimiento_AFTER_INSERT` AFTER INSERT ON `detalle_documento_movimiento` FOR EACH ROW
BEGIN
	INSERT INTO producto_historial (idproducto, idbodega, fecha, unidades_salida, idrelacion, tabla_relacion) 
    VALUES (new.idproducto, new.idbodega_egreso, now(), new.cantidad, new.iddetalle_documento_movimiento, 'detalle_documento_movimiento_egreso');
    INSERT INTO producto_historial (idproducto, idbodega, fecha, unidades_ingreso, idrelacion, tabla_relacion) 
    VALUES (new.idproducto, new.idbodega_ingreso, now(), new.cantidad, new.iddetalle_documento_movimiento, 'detalle_documento_movimiento_ingreso');
	
    update documento_movimiento set monto = monto+(new.monto) where iddocumento_movimiento = new.iddocumento_movimiento;

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`detalle_documento_movimiento_BEFORE_UPDATE` BEFORE UPDATE ON `detalle_documento_movimiento` FOR EACH ROW
BEGIN
	set new.monto = new.cantidad*new.precio;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`detalle_documento_movimiento_AFTER_UPDATE` AFTER UPDATE ON `detalle_documento_movimiento` FOR EACH ROW
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
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `documento_credito`
--

DROP TABLE IF EXISTS `documento_credito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documento_credito` (
  `iddocumento_credito` int(11) NOT NULL AUTO_INCREMENT,
  `idtipo_documento` int(11) NOT NULL DEFAULT '1',
  `idsucursal` int(11) NOT NULL DEFAULT '1',
  `serie` varchar(45) DEFAULT NULL,
  `correlativo` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `observaciones` varchar(45) DEFAULT NULL,
  `estado_documento` enum('Recibido','Rechazado') NOT NULL DEFAULT 'Recibido',
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo',
  `monto` decimal(10,2) NOT NULL DEFAULT '0.00',
  `fecha_insercion` date DEFAULT NULL,
  `idproveedor` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`iddocumento_credito`),
  KEY `fk_documento_credito_idtipodocumento_idx` (`idtipo_documento`),
  KEY `fk_documento_credito_idsucursal_idx` (`idsucursal`),
  KEY `fk_documento_credito_idproveedor_idx` (`idproveedor`),
  CONSTRAINT `fk_documento_credito_idproveedor` FOREIGN KEY (`idproveedor`) REFERENCES `proveedor` (`idproveedor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_documento_credito_idsucursal` FOREIGN KEY (`idsucursal`) REFERENCES `sucursal` (`idsucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_documento_credito_idtipodocumento` FOREIGN KEY (`idtipo_documento`) REFERENCES `tipo_documento` (`idtipo_documento`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documento_credito`
--

LOCK TABLES `documento_credito` WRITE;
/*!40000 ALTER TABLE `documento_credito` DISABLE KEYS */;
INSERT INTO `documento_credito` VALUES (1,1,2,'asadf',5435463,'2015-11-05',NULL,'Recibido','Activo',10000.00,NULL,1);
/*!40000 ALTER TABLE `documento_credito` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`documento_credito_BEFORE_INSERT` BEFORE INSERT ON `documento_credito` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`documento_credito_AFTER_INSERT` AFTER INSERT ON `documento_credito` FOR EACH ROW
BEGIN
	insert into movimiento (credito, idrelacion, tabla_relacion, idrelacion_persona, tabla_relacion_persona, idsucursal)
    values (new.monto,new.iddocumento_credito,'documento_credito', new.idproveedor, 'proveedor', new.idsucursal);

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`documento_credito_BEFORE_UPDATE` BEFORE UPDATE ON `documento_credito` FOR EACH ROW
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
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`documento_credito_AFTER_UPDATE` AFTER UPDATE ON `documento_credito` FOR EACH ROW
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
	end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `documento_debito`
--

DROP TABLE IF EXISTS `documento_debito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documento_debito` (
  `iddocumento_debito` int(11) NOT NULL AUTO_INCREMENT,
  `idtipo_documento` int(11) NOT NULL DEFAULT '1',
  `idsucursal` int(11) NOT NULL DEFAULT '1',
  `idserie_documento` int(11) NOT NULL DEFAULT '1',
  `serie` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `correlativo` int(11) NOT NULL DEFAULT '1',
  `fecha` date DEFAULT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nit` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `observaciones` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado_documento` enum('Emitido','Anulado') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Emitido',
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  `fecha_anulacion` date DEFAULT NULL,
  `motivo_anulacion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL DEFAULT '0.00',
  `fecha_insercion` datetime DEFAULT NULL,
  `idcliente` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`iddocumento_debito`),
  KEY `fk_documento_debito_idserie_documento_idx` (`idserie_documento`),
  KEY `fk_documento_debito_idtipo_documento_idx` (`idtipo_documento`),
  KEY `fk_documento_debito_idsucursal_idx` (`idsucursal`),
  KEY `fk_documento_debito_idcliente_idx` (`idcliente`),
  CONSTRAINT `fk_documento_debito_idcliente` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_documento_debito_idserie_documento` FOREIGN KEY (`idserie_documento`) REFERENCES `serie_documento` (`idserie_documento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_documento_debito_idsucursal` FOREIGN KEY (`idsucursal`) REFERENCES `sucursal` (`idsucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_documento_debito_idtipo_documento` FOREIGN KEY (`idtipo_documento`) REFERENCES `tipo_documento` (`idtipo_documento`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documento_debito`
--

LOCK TABLES `documento_debito` WRITE;
/*!40000 ALTER TABLE `documento_debito` DISABLE KEYS */;
INSERT INTO `documento_debito` VALUES (1,1,1,1,'FP',1,'2015-10-01','Nestor Fock','Aguirre','3922140-7',NULL,'Emitido','Activo',NULL,NULL,384.50,'2015-10-29 20:55:12',1),(2,1,1,1,'FP',2,'2015-10-02','Silvia Gomez','Ciudad','13214312',NULL,'Emitido','Activo',NULL,NULL,800.00,'2015-10-29 20:58:50',1),(3,1,1,1,'FP',3,'2015-10-02','Erick Fock','ciudad','989123412',NULL,'Emitido','Activo',NULL,NULL,0.00,'2015-10-29 20:59:26',1),(4,1,1,1,'FP',4,'2015-11-05','gter','tew','4234',NULL,'Emitido','Activo',NULL,NULL,96.00,'2015-11-05 20:02:38',1),(6,1,1,1,'FP',6,'2015-11-05','rt','erwe','13214312','sw','Emitido','Activo',NULL,NULL,200.00,'2015-11-06 01:37:19',1);
/*!40000 ALTER TABLE `documento_debito` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`documento_debito_BEFORE_INSERT` BEFORE INSERT ON `documento_debito` FOR EACH ROW
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
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`documento_debito_AFTER_INSERT` AFTER INSERT ON `documento_debito` FOR EACH ROW
BEGIN
    insert into movimiento (credito, idrelacion, tabla_relacion, idrelacion_persona, tabla_relacion_persona, idsucursal)
    values (new.monto,new.iddocumento_debito,'documento', new.idcliente, 'cliente', new.idsucursal);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`documento_debito_BEFORE_UPDATE` BEFORE UPDATE ON `documento_debito` FOR EACH ROW
BEGIN
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
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`documento_debito_AFTER_UPDATE` AFTER UPDATE ON `documento_debito` FOR EACH ROW
BEGIN
    if new.monto != old.monto then
		update movimiento set credito = credito +(new.monto-old.monto) where idrelacion = new.iddocumento_debito  and tabla_relacion = 'documento';
    end if;
    if new.estado != old.estado then
		if new.estado ='Inactivo' then
			update movimiento set credito = credito -(new.monto) where idrelacion = new.iddocumento_debito  and tabla_relacion = 'documento';
        elseif new.estado ='Activo' then
			update movimiento set credito = credito +(new.monto) where idrelacion = new.iddocumento_debito  and tabla_relacion = 'documento';
		end if;
	end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `documento_movimiento`
--

DROP TABLE IF EXISTS `documento_movimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documento_movimiento` (
  `iddocumento_movimiento` int(11) NOT NULL AUTO_INCREMENT,
  `idtipo_documento` int(11) NOT NULL DEFAULT '1',
  `idserie_documento` int(11) NOT NULL DEFAULT '1',
  `serie` varchar(45) DEFAULT NULL,
  `correlativo` int(11) NOT NULL DEFAULT '1',
  `fecha` date DEFAULT NULL,
  `observaciones` varchar(45) DEFAULT NULL,
  `estado_documento` enum('Emitido','Anulado') NOT NULL DEFAULT 'Emitido',
  `idsucursal_ingreso` int(11) NOT NULL DEFAULT '1',
  `idsucursal_egreso` int(11) NOT NULL DEFAULT '1',
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`iddocumento_movimiento`),
  KEY `fk_documento_movimiento_idtipo_documento_idx` (`idtipo_documento`),
  KEY `fk_documento_movimiento_idserie_documento_idx` (`idserie_documento`),
  KEY `fk_documento_movimiento_idsucursal_ingreso_idx` (`idsucursal_ingreso`),
  KEY `fk_documento_movimiento_idsucursal_egreso_idx` (`idsucursal_egreso`),
  CONSTRAINT `fk_documento_movimiento_idserie_documento` FOREIGN KEY (`idserie_documento`) REFERENCES `serie_documento` (`idserie_documento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_documento_movimiento_idsucursal_egreso` FOREIGN KEY (`idsucursal_egreso`) REFERENCES `sucursal` (`idsucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_documento_movimiento_idsucursal_ingreso` FOREIGN KEY (`idsucursal_ingreso`) REFERENCES `sucursal` (`idsucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_documento_movimiento_idtipo_documento` FOREIGN KEY (`idtipo_documento`) REFERENCES `tipo_documento` (`idtipo_documento`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documento_movimiento`
--

LOCK TABLES `documento_movimiento` WRITE;
/*!40000 ALTER TABLE `documento_movimiento` DISABLE KEYS */;
INSERT INTO `documento_movimiento` VALUES (1,2,1,'FP',5,'2015-11-05',NULL,'Emitido',1,1,'Activo','2015-11-05 20:04:54',0.00),(3,1,1,'FP',7,'2015-11-05',NULL,'Emitido',1,2,'Activo','2015-11-06 02:07:19',3000.00);
/*!40000 ALTER TABLE `documento_movimiento` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`documento_movimiento_BEFORE_INSERT` BEFORE INSERT ON `documento_movimiento` FOR EACH ROW
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
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`documento_movimiento_AFTER_INSERT` AFTER INSERT ON `documento_movimiento` FOR EACH ROW
BEGIN
	insert into movimiento (debito, idrelacion, tabla_relacion, idrelacion_persona, tabla_relacion_persona, idsucursal)
    values (new.monto,new.iddocumento_movimiento,'documento_movimiento_egreso', null, null, new.idsucursal_egreso);
	insert into movimiento (credito, idrelacion, tabla_relacion, idrelacion_persona, tabla_relacion_persona, idsucursal)
    values (new.monto,new.iddocumento_movimiento,'documento_movimiento_ingreso', null, null, new.idsucursal_ingreso);

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`documento_movimiento_BEFORE_UPDATE` BEFORE UPDATE ON `documento_movimiento` FOR EACH ROW
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
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`documento_movimiento_AFTER_UPDATE` AFTER UPDATE ON `documento_movimiento` FOR EACH ROW
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
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `empresa`
--

DROP TABLE IF EXISTS `empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `empresa` (
  `idempresa` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  `idpais` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idempresa`),
  KEY `fk_empresa_idpais_idx` (`idpais`),
  CONSTRAINT `fk_empresa_idpais` FOREIGN KEY (`idpais`) REFERENCES `pais` (`idpais`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
INSERT INTO `empresa` VALUES (1,'Farmacias Nexthor','Ciudad','Activo',1);
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fabricante`
--

DROP TABLE IF EXISTS `fabricante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fabricante` (
  `idfabricante` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `idpais` int(11) NOT NULL DEFAULT '1',
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idfabricante`),
  KEY `fk_fabricante_idx` (`idpais`),
  CONSTRAINT `fk_fabricante` FOREIGN KEY (`idpais`) REFERENCES `pais` (`idpais`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fabricante`
--

LOCK TABLES `fabricante` WRITE;
/*!40000 ALTER TABLE `fabricante` DISABLE KEYS */;
INSERT INTO `fabricante` VALUES (1,'BAYER',1,'Activo');
/*!40000 ALTER TABLE `fabricante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marca`
--

DROP TABLE IF EXISTS `marca`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `marca` (
  `idmarca` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `idfabricante` int(11) NOT NULL DEFAULT '1',
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idmarca`),
  KEY `fk_marca_idfabricante_idx` (`idfabricante`),
  CONSTRAINT `fk_marca_idfabricante` FOREIGN KEY (`idfabricante`) REFERENCES `fabricante` (`idfabricante`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marca`
--

LOCK TABLES `marca` WRITE;
/*!40000 ALTER TABLE `marca` DISABLE KEYS */;
INSERT INTO `marca` VALUES (1,'Tapcin',1,'Activo');
/*!40000 ALTER TABLE `marca` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `moneda`
--

DROP TABLE IF EXISTS `moneda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `moneda` (
  `idmoneda` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `simbolo` varchar(45) DEFAULT NULL,
  `idpais` int(11) DEFAULT NULL,
  `tasa_cambio` decimal(10,2) NOT NULL DEFAULT '0.00',
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime DEFAULT NULL,
  PRIMARY KEY (`idmoneda`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `moneda`
--

LOCK TABLES `moneda` WRITE;
/*!40000 ALTER TABLE `moneda` DISABLE KEYS */;
INSERT INTO `moneda` VALUES (1,'Quetzal','Q',1,0.00,'Activo',NULL);
/*!40000 ALTER TABLE `moneda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `movimiento`
--

DROP TABLE IF EXISTS `movimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `movimiento` (
  `idmovimiento` int(11) NOT NULL AUTO_INCREMENT,
  `debito` decimal(10,2) NOT NULL DEFAULT '0.00',
  `credito` decimal(10,2) NOT NULL DEFAULT '0.00',
  `idrelacion` int(11) NOT NULL DEFAULT '1',
  `tabla_relacion` varchar(45) NOT NULL DEFAULT 'documento',
  `fecha_insercion` datetime DEFAULT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `idrelacion_persona` int(11) DEFAULT NULL,
  `tabla_relacion_persona` varchar(45) DEFAULT NULL,
  `idsucursal` int(11) NOT NULL,
  `monto_aplicado` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`idmovimiento`),
  KEY `fk_movimiento_idsucursal_idx` (`idsucursal`),
  CONSTRAINT `fk_movimiento_idsucursal` FOREIGN KEY (`idsucursal`) REFERENCES `sucursal` (`idsucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movimiento`
--

LOCK TABLES `movimiento` WRITE;
/*!40000 ALTER TABLE `movimiento` DISABLE KEYS */;
INSERT INTO `movimiento` VALUES (1,0.00,100.00,1,'documento',NULL,'Activo',1,'cliente',1,0.00),(2,0.00,500.00,1,'documento',NULL,'Activo',1,'cliente',1,0.00),(3,0.00,500.00,1,'documento',NULL,'Activo',1,'cliente',1,0.00),(4,100.00,0.00,1,'documento',NULL,'Activo',1,'cliente',1,0.00),(5,400.00,0.00,1,'documento_credito',NULL,'Activo',1,'proveedor',1,0.00),(6,0.00,200.00,6,'documento','2015-11-06 01:37:19','Activo',1,'cliente',1,0.00),(7,1000.00,1000.00,3,'documento_movimiento_egreso','2015-11-06 02:07:19','Activo',NULL,NULL,2,0.00),(8,1000.00,1000.00,3,'documento_movimiento_ingreso','2015-11-06 02:07:19','Activo',NULL,NULL,1,0.00),(9,0.00,0.00,1,'pago_cliente','2015-11-06 02:44:40','Activo',1,'cliente',1,0.00),(10,100.00,0.00,2,'pago_cliente','2015-11-08 23:09:05','Activo',1,'cliente',1,0.00),(11,0.00,101.00,2,'pago_proveedor','2015-11-09 00:41:41','Activo',1,'proveedor',1,0.00);
/*!40000 ALTER TABLE `movimiento` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`movimiento_BEFORE_INSERT` BEFORE INSERT ON `movimiento` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`movimiento_AFTER_INSERT` AFTER INSERT ON `movimiento` FOR EACH ROW
BEGIN
	update sucursal set credito = credito +  (new.credito), debito = debito +  (new.debito) where idsucursal = new.idsucursal;
    if (new.tabla_relacion_persona ='cliente') then
		update cliente set credito = credito +  (new.credito), debito = debito +  (new.debito) where idcliente = new.idrelacion_persona;
	elseif (new.tabla_relacion_persona ='proveedor') then
		update proveedor set credito = credito +  (new.credito), debito = debito +  (new.debito) where idproveedor = new.idrelacion_persona;
    end if;
    
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`movimiento_AFTER_UPDATE` AFTER UPDATE ON `movimiento` FOR EACH ROW
BEGIN
	update sucursal set credito = credito +  (new.credito-old.credito), debito = debito +  (new.debito-old.debito) where idsucursal = new.idsucursal;
	if (new.tabla_relacion_persona ='cliente') then
		update cliente set credito = credito +  (new.credito-old.credito), debito = debito +  (new.debito-old.debito) where idcliente = new.idrelacion_persona;
    elseif (new.tabla_relacion_persona ='proveedor') then
		update proveedor set credito = credito +  (new.credito-old.credito), debito = debito +  (new.debito-old.debito) where idproveedor = new.idrelacion_persona;
    end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `municipio`
--

DROP TABLE IF EXISTS `municipio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `municipio` (
  `idmunicipio` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `iddepartamento` int(11) NOT NULL DEFAULT '1',
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idmunicipio`),
  KEY `fk_municipio_iddepartamento_idx` (`iddepartamento`),
  CONSTRAINT `fk_municipio_iddepartamento` FOREIGN KEY (`iddepartamento`) REFERENCES `departamento` (`iddepartamento`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `municipio`
--

LOCK TABLES `municipio` WRITE;
/*!40000 ALTER TABLE `municipio` DISABLE KEYS */;
INSERT INTO `municipio` VALUES (1,'GUATEMALA',1,'Activo'),(2,'SANTA CATARINA PINULA',1,'Activo'),(3,'SAN JOSE PINULA',1,'Activo'),(4,'SAN JOSE DEL GOLFO',1,'Activo'),(5,'PALENCIA',1,'Activo'),(6,'CHINAUTLA',1,'Activo'),(7,'SAN PEDRO AYAMPUC',1,'Activo'),(8,'MIXCO',1,'Activo'),(9,'SAN PEDRO SACATEPEQUEZ',1,'Activo'),(10,'SAN JUAN SACATEPEQUEZ',1,'Activo'),(11,'SAN RAYMUNDO',1,'Activo'),(12,'CHUARRANCHO',1,'Activo'),(13,'FRAIJANES',1,'Activo'),(14,'AMATITLAN',1,'Activo'),(15,'VILLA NUEVA',1,'Activo'),(16,'VILLA CANALES',1,'Activo'),(17,'SAN MIGUEL PETAPA',1,'Activo'),(18,'ANTIGUA GUATEMALA',3,'Activo'),(19,'JOCOTENANGO',3,'Activo'),(20,'PASTORES',3,'Activo'),(21,'SUMPANGO',3,'Activo'),(22,'SANTO DOMINGO XENACOJ',3,'Activo'),(23,'SANTIAGO SACATEPEQUEZ',3,'Activo'),(24,'SAN BARTOLOME MILPAS ALTAS',3,'Activo'),(25,'SAN LUCAS SACATEPEQUEZ',3,'Activo'),(26,'SANTA LUCIA MILPAS ALTAS',3,'Activo'),(27,'MAGDALENA MILPAS ALTAS',3,'Activo'),(28,'SANTA MARIA DE JESUS',3,'Activo'),(29,'CIUDAD VIEJA',3,'Activo'),(30,'SAN MIGUEL DUENAS',3,'Activo'),(31,'SAN JUAN ALOTENANGO',3,'Activo'),(32,'SAN ANTONIO AGUAS CALIENTES',3,'Activo'),(33,'SANTA CATARINA BARAHONA',3,'Activo'),(34,'CHIMALTENANGO',4,'Activo'),(35,'SAN JOSE POAQUIL',4,'Activo'),(36,'SAN MARTIN JILOTEPEQUE',4,'Activo'),(37,'SAN JUAN COMALAPA',4,'Activo'),(38,'SANTA APOLONIA',4,'Activo'),(39,'TECPAN GUATEMALA',4,'Activo'),(40,'PATZUN',4,'Activo'),(41,'POCHUTA',4,'Activo'),(42,'PATZICIA',4,'Activo'),(43,'SANTA CRUZ BALANYA',4,'Activo'),(44,'ACATENANGO',4,'Activo'),(45,'SAN PEDRO YEPOCAPA',4,'Activo'),(46,'SAN ANDRES ITZAPA',4,'Activo'),(47,'PARRAMOS',4,'Activo'),(48,'ZARAGOZA',4,'Activo'),(49,'SAN MIGUEL EL TEJAR',4,'Activo'),(50,'GUASTATOYA',2,'Activo');
/*!40000 ALTER TABLE `municipio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pago_cliente`
--

DROP TABLE IF EXISTS `pago_cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pago_cliente` (
  `idpago_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `idcliente` int(11) NOT NULL DEFAULT '1',
  `monto` decimal(10,2) NOT NULL DEFAULT '0.00',
  `fecha` date DEFAULT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime DEFAULT NULL,
  `idsucursal` int(11) NOT NULL DEFAULT '1',
  `idboleta_deposito` int(11) DEFAULT NULL,
  `idvoucher_tarjeta` int(11) DEFAULT NULL,
  `idtipo_pago` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idpago_cliente`),
  KEY `fk_pago_cliente_idcliente_idx` (`idcliente`),
  KEY `fk_pago_cliente_idsucursal_idx` (`idsucursal`),
  KEY `fk_pago_cliente_idboleta_deposito_idx` (`idboleta_deposito`),
  KEY `fk_pago_cliente_idvoucher_tarjeta_idx` (`idvoucher_tarjeta`),
  KEY `fk_pago_cliente_idtipo_pago_idx` (`idtipo_pago`),
  CONSTRAINT `fk_pago_cliente_idboleta_deposito` FOREIGN KEY (`idboleta_deposito`) REFERENCES `boleta_deposito` (`idboleta_deposito`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pago_cliente_idcliente` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pago_cliente_idsucursal` FOREIGN KEY (`idsucursal`) REFERENCES `sucursal` (`idsucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pago_cliente_idtipo_pago` FOREIGN KEY (`idtipo_pago`) REFERENCES `tipo_pago` (`idtipo_pago`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pago_cliente_idvoucher_tarjeta` FOREIGN KEY (`idvoucher_tarjeta`) REFERENCES `voucher_tarjeta` (`idvoucher_tarjeta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pago_cliente`
--

LOCK TABLES `pago_cliente` WRITE;
/*!40000 ALTER TABLE `pago_cliente` DISABLE KEYS */;
INSERT INTO `pago_cliente` VALUES (1,1,200.00,NULL,'Inactivo','2015-11-06 02:44:40',1,NULL,NULL,1),(2,1,100.00,'2015-11-08','Activo','2015-11-08 23:09:05',1,NULL,2,1);
/*!40000 ALTER TABLE `pago_cliente` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`pago_cliente_BEFORE_INSERT` BEFORE INSERT ON `pago_cliente` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`pago_cliente_AFTER_INSERT` AFTER INSERT ON `pago_cliente` FOR EACH ROW
BEGIN
	insert into movimiento (debito, idrelacion, tabla_relacion, idrelacion_persona, tabla_relacion_persona, idsucursal)
    values (new.monto,new.idpago_cliente,'pago_cliente', new.idcliente, 'cliente', new.idsucursal);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`pago_cliente_BEFORE_UPDATE` BEFORE UPDATE ON `pago_cliente` FOR EACH ROW
BEGIN
	if new.idcliente != old.idcliente then
		set new.idcliente = old.idcliente;
    end if;
    if new.idsucursal != old.idsucursal then
		set new.idsucursal = old.idsucursal;
    end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`pago_cliente_AFTER_UPDATE` AFTER UPDATE ON `pago_cliente` FOR EACH ROW
BEGIN
	if new.monto != old.monto then
		update movimiento set debito = debito +(new.monto-old.monto) where idrelacion = new.idpago_cliente and tabla_relacion = 'pago_cliente';
    end if;
    if new.estado != old.estado then
		if new.estado ='Inactivo' then
			update movimiento set debito = debito -(new.monto) where idrelacion = new.idpago_cliente and tabla_relacion = 'pago_cliente';
        elseif new.estado ='Activo' then
			update movimiento set debito = debito +(new.monto) where idrelacion = new.idpago_cliente and tabla_relacion = 'pago_cliente';
		end if;
	end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `pago_proveedor`
--

DROP TABLE IF EXISTS `pago_proveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pago_proveedor` (
  `idpago_proveedor` int(11) NOT NULL AUTO_INCREMENT,
  `idproveedor` int(11) NOT NULL DEFAULT '1',
  `monto` decimal(10,2) NOT NULL DEFAULT '0.00',
  `fecha` date DEFAULT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime DEFAULT NULL,
  `idsucursal` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idpago_proveedor`),
  KEY `fk_pago_proveedor_idproveedor_idx` (`idproveedor`),
  KEY `fk_pago_proveedor_idsucursal_idx` (`idsucursal`),
  CONSTRAINT `fk_pago_proveedor_idproveedor` FOREIGN KEY (`idproveedor`) REFERENCES `proveedor` (`idproveedor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pago_proveedor_idsucursal` FOREIGN KEY (`idsucursal`) REFERENCES `sucursal` (`idsucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pago_proveedor`
--

LOCK TABLES `pago_proveedor` WRITE;
/*!40000 ALTER TABLE `pago_proveedor` DISABLE KEYS */;
INSERT INTO `pago_proveedor` VALUES (2,1,101.00,'2015-11-08','Activo','2015-11-09 00:41:41',1);
/*!40000 ALTER TABLE `pago_proveedor` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`pago_proveedor_BEFORE_INSERT` BEFORE INSERT ON `pago_proveedor` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`pago_proveedor_AFTER_INSERT` AFTER INSERT ON `pago_proveedor` FOR EACH ROW
BEGIN
	insert into movimiento (credito, idrelacion, tabla_relacion, idrelacion_persona, tabla_relacion_persona, idsucursal)
    values (new.monto,new.idpago_proveedor,'pago_proveedor', new.idproveedor, 'proveedor', new.idsucursal);

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`pago_proveedor_BEFORE_UPDATE` BEFORE UPDATE ON `pago_proveedor` FOR EACH ROW
BEGIN
	if new.idproveedor!= old.idproveedor then
		set new.idproveedor = old.idproveedor;
    end if;
    if new.idsucursal != old.idsucursal then
		set new.idsucursal = old.idsucursal;
    end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`pago_proveedor_AFTER_UPDATE` AFTER UPDATE ON `pago_proveedor` FOR EACH ROW
BEGIN
	if new.monto != old.monto then
		update movimiento set credito = credito +(new.monto-old.monto) where idrelacion = new.idpago_proveedor and tabla_relacion = 'pago_proveedor';
    end if;
    if new.estado != old.estado then
		if new.estado ='Inactivo' then
			update movimiento set credito = credito -(new.monto) where idrelacion = new.idpago_proveedor and tabla_relacion = 'pago_proveedor';
        elseif new.estado ='Activo' then
			update movimiento set credito = credito +(new.monto) where idrelacion = new.idpago_proveedor and tabla_relacion = 'pago_proveedor';
		end if;
	end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `pais`
--

DROP TABLE IF EXISTS `pais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pais` (
  `idpais` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idpais`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pais`
--

LOCK TABLES `pais` WRITE;
/*!40000 ALTER TABLE `pais` DISABLE KEYS */;
INSERT INTO `pais` VALUES (1,'Guatemala','Activo'),(2,'El Salvador','Inactivo');
/*!40000 ALTER TABLE `pais` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `persona`
--

DROP TABLE IF EXISTS `persona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `persona` (
  `idpersona` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_persona` enum('Individual','Juridica') NOT NULL DEFAULT 'Individual',
  `nombre` varchar(45) DEFAULT NULL,
  `apellido` varchar(45) DEFAULT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  `cui` varchar(45) DEFAULT NULL,
  `idpais` int(11) NOT NULL DEFAULT '1',
  `fecha_nacimiento` date DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `sexo` enum('Masculino','Femenino') NOT NULL DEFAULT 'Masculino',
  `fecha_insercion` datetime DEFAULT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idpersona`),
  KEY `fk_persona_idpais_idx` (`idpais`),
  CONSTRAINT `fk_persona_idpais` FOREIGN KEY (`idpais`) REFERENCES `pais` (`idpais`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persona`
--

LOCK TABLES `persona` WRITE;
/*!40000 ALTER TABLE `persona` DISABLE KEYS */;
INSERT INTO `persona` VALUES (1,'Individual','Nestor','Fock',NULL,NULL,1,NULL,NULL,'Masculino',NULL,'Activo'),(2,'Individual','Silvia','Gómez','ciudad','1231242131',1,'2015-11-08','jk@hotmail.com','Masculino',NULL,'Activo');
/*!40000 ALTER TABLE `persona` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto` (
  `idproducto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `idpais` int(11) NOT NULL COMMENT 'pais de fabricacion',
  `idmarca` int(11) NOT NULL DEFAULT '1',
  `existencia` int(11) NOT NULL DEFAULT '0',
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `idcategoria` int(11) NOT NULL DEFAULT '1',
  `precio_venta` decimal(10,2) NOT NULL DEFAULT '0.00',
  `precio_compra` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`idproducto`),
  KEY `fk_producto_idmarca_idx` (`idmarca`),
  KEY `fk_producto_idpais_idx` (`idpais`),
  KEY `fk_producto_idcategoria_idx` (`idcategoria`),
  CONSTRAINT `fk_producto_idcategoria` FOREIGN KEY (`idcategoria`) REFERENCES `categoria` (`idcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_idmarca` FOREIGN KEY (`idmarca`) REFERENCES `marca` (`idmarca`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_idpais` FOREIGN KEY (`idpais`) REFERENCES `pais` (`idpais`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` VALUES (1,'Gripe y Tos',1,1,1049,'Activo',1,0.00,0.00),(2,'Noche',1,1,2350,'Activo',1,0.00,0.00);
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto_bodega`
--

DROP TABLE IF EXISTS `producto_bodega`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto_bodega` (
  `idproducto_bodega` int(11) NOT NULL AUTO_INCREMENT,
  `idproducto` int(11) NOT NULL DEFAULT '1',
  `idbodega` int(11) NOT NULL DEFAULT '1',
  `existencia` int(11) DEFAULT '0',
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  `idproducto_sucursal` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idproducto_bodega`),
  KEY `fk_producto_bodega_idbodega_idx` (`idbodega`),
  KEY `fk_producto_bodega_idproducto_idx` (`idproducto`),
  KEY `fk_producto_bodega_idproducto_sucursal_idx` (`idproducto_sucursal`),
  CONSTRAINT `fk_producto_bodega_idbodega` FOREIGN KEY (`idbodega`) REFERENCES `bodega` (`idbodega`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_bodega_idproducto` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_bodega_idproducto_sucursal` FOREIGN KEY (`idproducto_sucursal`) REFERENCES `producto_sucursal` (`idproducto_sucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_bodega`
--

LOCK TABLES `producto_bodega` WRITE;
/*!40000 ALTER TABLE `producto_bodega` DISABLE KEYS */;
INSERT INTO `producto_bodega` VALUES (1,1,2,-200,'Activo',1),(2,1,1,1199,'Activo',1),(3,1,3,50,'Activo',2),(4,2,2,350,'Activo',3),(5,2,3,2000,'Activo',4),(6,2,1,0,'Activo',3);
/*!40000 ALTER TABLE `producto_bodega` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`producto_bodega_BEFORE_INSERT` BEFORE INSERT ON `producto_bodega` FOR EACH ROW
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
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`producto_bodega_BEFORE_UPDATE` BEFORE UPDATE ON `producto_bodega` FOR EACH ROW
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
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `producto_historial`
--

DROP TABLE IF EXISTS `producto_historial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto_historial` (
  `idproducto_historial` int(11) NOT NULL AUTO_INCREMENT,
  `idproducto` int(11) NOT NULL DEFAULT '1',
  `idbodega` int(11) NOT NULL DEFAULT '1',
  `idproducto_bodega` int(11) NOT NULL DEFAULT '1',
  `fecha` date DEFAULT NULL,
  `unidades_ingreso` int(11) NOT NULL DEFAULT '0',
  `unidades_salida` int(11) NOT NULL DEFAULT '0',
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime DEFAULT NULL,
  `idrelacion` int(11) NOT NULL DEFAULT '1',
  `tabla_relacion` varchar(45) COLLATE utf8_spanish_ci DEFAULT 'detalle_documento_debito',
  PRIMARY KEY (`idproducto_historial`),
  KEY `fk_producto_historial_idproducto_idx` (`idproducto`),
  KEY `fk_producto_historial_idbodega_idx` (`idbodega`),
  KEY `fk_producto_historial_idproducto_bodega_idx` (`idproducto_bodega`),
  CONSTRAINT `fk_producto_historial_idbodega` FOREIGN KEY (`idbodega`) REFERENCES `bodega` (`idbodega`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_historial_idproducto` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_historial_idproducto_bodega` FOREIGN KEY (`idproducto_bodega`) REFERENCES `producto_bodega` (`idproducto_bodega`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_historial`
--

LOCK TABLES `producto_historial` WRITE;
/*!40000 ALTER TABLE `producto_historial` DISABLE KEYS */;
INSERT INTO `producto_historial` VALUES (1,1,1,2,'2015-10-06',100,0,'Activo',NULL,1,'detalle_documento_debito'),(2,2,3,5,'2015-10-29',20000,0,'Inactivo',NULL,1,'detalle_documento_debito'),(3,1,1,2,'2015-10-29',0,21,'Activo','2015-10-29 22:28:11',2,'detalle_documento_debito'),(4,2,1,6,'2015-10-29',0,2,'Activo','2015-10-29 22:29:46',3,'detalle_documento_debito'),(5,1,1,2,'2015-10-29',0,0,'Inactivo','2015-10-29 22:34:56',4,'detalle_documento_debito'),(6,1,1,2,'2015-10-29',0,0,'Inactivo','2015-10-29 22:42:00',5,'detalle_documento_debito'),(7,1,1,2,'2015-10-29',0,200,'Activo','2015-10-29 22:42:11',6,'detalle_documento_debito'),(8,2,1,6,'2015-11-05',0,48,'Activo','2015-11-05 20:02:39',7,'detalle_documento_debito'),(9,2,2,4,'2015-11-05',0,150,'Activo','2015-11-05 20:05:33',1,'detalle_documento_movimiento_egreso'),(10,2,1,6,'2015-11-05',150,0,'Activo','2015-11-05 20:05:33',1,'detalle_documento_movimiento_ingreso'),(11,2,3,5,'2015-11-05',2000,0,'Activo','2015-11-05 20:08:08',1,'detalle_documento_credito'),(12,2,1,6,'2015-11-06',0,100,'Activo','2015-11-06 01:38:35',8,'detalle_documento_debito'),(13,1,2,1,'2015-11-06',0,100,'Activo','2015-11-06 02:12:57',2,'detalle_documento_movimiento_egreso'),(14,1,1,2,'2015-11-06',100,0,'Activo','2015-11-06 02:12:57',2,'detalle_documento_movimiento_ingreso'),(17,1,2,1,'2015-11-06',0,100,'Activo','2015-11-06 02:20:30',3,'detalle_documento_movimiento_egreso'),(18,1,1,2,'2015-11-06',100,0,'Activo','2015-11-06 02:20:30',3,'detalle_documento_movimiento_ingreso'),(19,1,2,1,'2015-11-06',0,100,'Activo','2015-11-06 02:24:01',4,'detalle_documento_movimiento_egreso'),(20,1,1,2,'2015-11-06',100,0,'Activo','2015-11-06 02:24:01',4,'detalle_documento_movimiento_ingreso');
/*!40000 ALTER TABLE `producto_historial` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`producto_historial_BEFORE_INSERT` BEFORE INSERT ON `producto_historial` FOR EACH ROW
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
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`producto_historial_BEFORE_UPDATE` BEFORE UPDATE ON `producto_historial` FOR EACH ROW
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
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `producto_sucursal`
--

DROP TABLE IF EXISTS `producto_sucursal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto_sucursal` (
  `idproducto_sucursal` int(11) NOT NULL AUTO_INCREMENT,
  `idproducto` int(11) NOT NULL DEFAULT '1',
  `idsucursal` int(11) NOT NULL DEFAULT '1',
  `existencia` int(11) NOT NULL DEFAULT '0',
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idproducto_sucursal`),
  KEY `fk_producto_sucursal_idsucursal_idx` (`idsucursal`),
  KEY `fk_producto_sucursal_idproducto_idx` (`idproducto`),
  CONSTRAINT `fk_producto_sucursal_idproducto` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_sucursal_idsucursal` FOREIGN KEY (`idsucursal`) REFERENCES `sucursal` (`idsucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_sucursal`
--

LOCK TABLES `producto_sucursal` WRITE;
/*!40000 ALTER TABLE `producto_sucursal` DISABLE KEYS */;
INSERT INTO `producto_sucursal` VALUES (1,1,1,999,'Activo'),(2,1,2,50,'Activo'),(3,2,1,350,'Activo'),(4,2,2,2000,'Activo');
/*!40000 ALTER TABLE `producto_sucursal` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`producto_sucursal_AFTER_INSERT` AFTER INSERT ON `producto_sucursal` FOR EACH ROW
BEGIN
	update producto set existencia = existencia + (new.existencia) where idproducto = new.idproducto;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`producto_sucursal_AFTER_UPDATE` AFTER UPDATE ON `producto_sucursal` FOR EACH ROW
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
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `proveedor`
--

DROP TABLE IF EXISTS `proveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proveedor` (
  `idproveedor` int(11) NOT NULL AUTO_INCREMENT,
  `idpersona` int(11) NOT NULL DEFAULT '1',
  `codigo` varchar(45) DEFAULT NULL,
  `nit` varchar(45) DEFAULT NULL,
  `nombre_factura` varchar(45) DEFAULT NULL,
  `direccion_factura` varchar(45) DEFAULT NULL,
  `debito` decimal(10,2) NOT NULL DEFAULT '0.00',
  `credito` decimal(10,2) NOT NULL DEFAULT '0.00',
  `fecha_insercion` datetime DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idproveedor`),
  KEY `fk_proveedor_idpersona_idx` (`idpersona`),
  CONSTRAINT `fk_proveedor_idpersona` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedor`
--

LOCK TABLES `proveedor` WRITE;
/*!40000 ALTER TABLE `proveedor` DISABLE KEYS */;
INSERT INTO `proveedor` VALUES (1,1,NULL,'23','GFSD','Proveedor',0.00,101.00,NULL,'32@KLD.COM','Activo'),(2,2,NULL,'23','GFSD','EDRF',0.00,0.00,NULL,'32@KLD.COM','Activo');
/*!40000 ALTER TABLE `proveedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registro_sanitario`
--

DROP TABLE IF EXISTS `registro_sanitario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registro_sanitario` (
  `idregistro_sanitario` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  `idpais` int(11) NOT NULL DEFAULT '1',
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `idproducto` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idregistro_sanitario`),
  KEY `fk_registro_sanitario_idpais_idx` (`idpais`),
  KEY `fk_registro_sanitario_idproducto_idx` (`idproducto`),
  CONSTRAINT `fk_registro_sanitario_idpais` FOREIGN KEY (`idpais`) REFERENCES `pais` (`idpais`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_registro_sanitario_idproducto` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registro_sanitario`
--

LOCK TABLES `registro_sanitario` WRITE;
/*!40000 ALTER TABLE `registro_sanitario` DISABLE KEYS */;
INSERT INTO `registro_sanitario` VALUES (1,'4324235',1,'Activo',1);
/*!40000 ALTER TABLE `registro_sanitario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `serie_documento`
--

DROP TABLE IF EXISTS `serie_documento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `serie_documento` (
  `idserie_documento` int(11) NOT NULL AUTO_INCREMENT,
  `idtipo_documento` int(11) NOT NULL,
  `serie` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `correlativo` int(11) DEFAULT NULL,
  `idsucursal` int(11) NOT NULL DEFAULT '1',
  `fecha` date DEFAULT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idserie_documento`),
  KEY `fk_serie_documento_idsucursal_idx` (`idsucursal`),
  KEY `fk_serie_documento_idtipo_documento_idx` (`idtipo_documento`),
  CONSTRAINT `fk_serie_documento_idsucursal` FOREIGN KEY (`idsucursal`) REFERENCES `sucursal` (`idsucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_serie_documento_idtipo_documento` FOREIGN KEY (`idtipo_documento`) REFERENCES `tipo_documento` (`idtipo_documento`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `serie_documento`
--

LOCK TABLES `serie_documento` WRITE;
/*!40000 ALTER TABLE `serie_documento` DISABLE KEYS */;
INSERT INTO `serie_documento` VALUES (1,1,'FP',8,1,'2015-11-05','Activo'),(2,1,'FM',1,2,'2015-10-02','Activo');
/*!40000 ALTER TABLE `serie_documento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sucursal`
--

DROP TABLE IF EXISTS `sucursal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sucursal` (
  `idsucursal` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idmunicipio` int(11) NOT NULL DEFAULT '1',
  `idempresa` int(11) NOT NULL DEFAULT '1',
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  `credito` decimal(10,2) NOT NULL DEFAULT '0.00',
  `debito` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`idsucursal`),
  KEY `fk_sucursal_idempresa_idx` (`idempresa`),
  KEY `fk_sucursal_idmunicipio_idx` (`idmunicipio`),
  CONSTRAINT `fk_sucursal_idempresa` FOREIGN KEY (`idempresa`) REFERENCES `empresa` (`idempresa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_sucursal_idmunicipio` FOREIGN KEY (`idmunicipio`) REFERENCES `municipio` (`idmunicipio`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sucursal`
--

LOCK TABLES `sucursal` WRITE;
/*!40000 ALTER TABLE `sucursal` DISABLE KEYS */;
INSERT INTO `sucursal` VALUES (1,'Farmacia Petapa','Av. Petapa',1,1,'Activo',2301.00,1600.00),(2,'Farmacia Monte Maria',NULL,1,1,'Activo',1000.00,1000.00);
/*!40000 ALTER TABLE `sucursal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_bodega`
--

DROP TABLE IF EXISTS `tipo_bodega`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_bodega` (
  `idtipo_bodega` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idtipo_bodega`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_bodega`
--

LOCK TABLES `tipo_bodega` WRITE;
/*!40000 ALTER TABLE `tipo_bodega` DISABLE KEYS */;
INSERT INTO `tipo_bodega` VALUES (1,'Mostrador','Activo'),(2,'Bodega','Activo');
/*!40000 ALTER TABLE `tipo_bodega` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_documento`
--

DROP TABLE IF EXISTS `tipo_documento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_documento` (
  `idtipo_documento` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idtipo_documento`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_documento`
--

LOCK TABLES `tipo_documento` WRITE;
/*!40000 ALTER TABLE `tipo_documento` DISABLE KEYS */;
INSERT INTO `tipo_documento` VALUES (1,'Factura','Activo'),(2,'Envio','Activo');
/*!40000 ALTER TABLE `tipo_documento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_pago`
--

DROP TABLE IF EXISTS `tipo_pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_pago` (
  `idtipo_pago` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime DEFAULT NULL,
  PRIMARY KEY (`idtipo_pago`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_pago`
--

LOCK TABLES `tipo_pago` WRITE;
/*!40000 ALTER TABLE `tipo_pago` DISABLE KEYS */;
INSERT INTO `tipo_pago` VALUES (1,'Efectivo','Activo','2015-11-11 03:13:47'),(2,'Cheque','Activo','2015-11-11 03:13:47'),(3,'Deposito','Activo','2015-11-11 03:13:47'),(4,'Tarjeta','Activo','2015-11-11 03:13:48');
/*!40000 ALTER TABLE `tipo_pago` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`tipo_pago_BEFORE_INSERT` BEFORE INSERT ON `tipo_pago` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `userlevelpermissions`
--

DROP TABLE IF EXISTS `userlevelpermissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userlevelpermissions` (
  `userlevelid` int(11) NOT NULL AUTO_INCREMENT,
  `tablename` varchar(255) NOT NULL,
  `permission` int(11) NOT NULL,
  PRIMARY KEY (`userlevelid`,`tablename`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userlevelpermissions`
--

LOCK TABLES `userlevelpermissions` WRITE;
/*!40000 ALTER TABLE `userlevelpermissions` DISABLE KEYS */;
INSERT INTO `userlevelpermissions` VALUES (1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}aplicacion_movimiento',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}audittrail',0),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}banco',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}bodega',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}cliente',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}cuenta',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}cuenta_transaccion',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}departamento',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}detalle_documento_credito',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}detalle_documento_debito',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}detalle_documento_movimiento',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}documento_credito',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}documento_debito',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}documento_movimiento',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}empresa',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}fabricante',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}marca',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}moneda',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}movimiento',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}municipio',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}pago_cliente',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}pago_proveedor',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}pais',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}persona',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}producto',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}producto_bodega',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}producto_historial',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}producto_sucursal',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}proveedor',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}registro_sanitario',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}serie_documento',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}sucursal',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}tipo_bodega',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}tipo_documento',109),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}userlevelpermissions',0),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}userlevels',0),(1,'{ED86D3C1-3D94-420E-B7AB-FE366AE4A0C9}usuario',0);
/*!40000 ALTER TABLE `userlevelpermissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userlevels`
--

DROP TABLE IF EXISTS `userlevels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userlevels` (
  `userlevelid` int(11) NOT NULL AUTO_INCREMENT,
  `userlevelname` varchar(255) NOT NULL,
  PRIMARY KEY (`userlevelid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userlevels`
--

LOCK TABLES `userlevels` WRITE;
/*!40000 ALTER TABLE `userlevels` DISABLE KEYS */;
INSERT INTO `userlevels` VALUES (-1,'Administrator'),(1,'Default');
/*!40000 ALTER TABLE `userlevels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(45) NOT NULL,
  `contrasena` varchar(45) NOT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime DEFAULT NULL,
  `userlevelid` int(11) NOT NULL DEFAULT '1',
  `session` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idusuario`),
  KEY `fk_usuario_userlevelid_idx` (`userlevelid`),
  CONSTRAINT `fk_usuario_userlevelid` FOREIGN KEY (`userlevelid`) REFERENCES `userlevels` (`userlevelid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'nestor.fock','123','Activo',NULL,-1,NULL);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `voucher_tarjeta`
--

DROP TABLE IF EXISTS `voucher_tarjeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `voucher_tarjeta` (
  `idvoucher_tarjeta` int(11) NOT NULL AUTO_INCREMENT,
  `idbanco` int(11) NOT NULL DEFAULT '1',
  `idcuenta` int(11) NOT NULL DEFAULT '1',
  `marca` varchar(45) DEFAULT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `ultimos_cuatro_digitos` int(11) DEFAULT '0',
  `referencia` varchar(45) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`idvoucher_tarjeta`),
  KEY `fk_voucher_tarjeta_idbanco_idx` (`idbanco`),
  KEY `fk_voucher_tarjeta_idcuenta_idx` (`idcuenta`),
  CONSTRAINT `fk_voucher_tarjeta_idbanco` FOREIGN KEY (`idbanco`) REFERENCES `banco` (`idbanco`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_voucher_tarjeta_idcuenta` FOREIGN KEY (`idcuenta`) REFERENCES `cuenta` (`idcuenta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voucher_tarjeta`
--

LOCK TABLES `voucher_tarjeta` WRITE;
/*!40000 ALTER TABLE `voucher_tarjeta` DISABLE KEYS */;
INSERT INTO `voucher_tarjeta` VALUES (2,1,1,'VISA','Nestor Fock',2143,'1232143213','2015-11-10','Activo','2015-11-11 02:56:44',NULL,200.00);
/*!40000 ALTER TABLE `voucher_tarjeta` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`voucher_tarjeta_BEFORE_INSERT` BEFORE INSERT ON `voucher_tarjeta` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`voucher_tarjeta_AFTER_INSERT` AFTER INSERT ON `voucher_tarjeta` FOR EACH ROW
BEGIN
	insert into cuenta_transaccion (idcuenta, fecha, descripcion, credito, id_referencia, tabla_referencia)
		values (new.idcuenta, new.fecha, new.descripcion, new.monto, new.idvoucher_tarjeta, 'voucher_tarjeta');
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`voucher_tarjeta_BEFORE_UPDATE` BEFORE UPDATE ON `voucher_tarjeta` FOR EACH ROW
BEGIN
	if new.estado!=old.estado then
		if new.estado = 'Inactivo' then
            set new.monto = 0;
		end if;
	end if;
    if new.monto!=old.monto then
		update cuenta_transaccion set credito = credito+(new.monto-old.monto) where id_referencia = new.idvoucher_tarjeta and tabla_referencia = 'voucher_tarjeta';
	end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Dumping events for database 'nexthor_empresa'
--

--
-- Dumping routines for database 'nexthor_empresa'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-11-10 23:26:33
