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
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audittrail`
--

LOCK TABLES `audittrail` WRITE;
/*!40000 ALTER TABLE `audittrail` DISABLE KEYS */;
INSERT INTO `audittrail` VALUES (1,'2015-11-09 06:17:51','/farmacia/app/logout.php','Administrator','Salir del Sistema','::1','','','',''),(2,'2015-11-09 06:40:45','/farmacia/app/pago_proveedoredit.php','1','U','pago_proveedor','monto','2','100.00','101.00'),(3,'2015-11-11 00:15:07','/farmacia/app/login.php','admin','Ingresar','::1','','','',''),(4,'2015-11-11 00:17:47','/farmacia/app/cuenta_transaccionadd.php','-1','A','cuenta_transaccion','idcuenta','4','','1'),(5,'2015-11-11 00:17:47','/farmacia/app/cuenta_transaccionadd.php','-1','A','cuenta_transaccion','fecha','4','','2015-11-10'),(6,'2015-11-11 00:17:47','/farmacia/app/cuenta_transaccionadd.php','-1','A','cuenta_transaccion','descripcion','4','',NULL),(7,'2015-11-11 00:17:47','/farmacia/app/cuenta_transaccionadd.php','-1','A','cuenta_transaccion','debito','4','','0'),(8,'2015-11-11 00:17:47','/farmacia/app/cuenta_transaccionadd.php','-1','A','cuenta_transaccion','credito','4','','5000'),(9,'2015-11-11 00:17:47','/farmacia/app/cuenta_transaccionadd.php','-1','A','cuenta_transaccion','idcuenta_transaccion','4','','4'),(10,'2015-11-11 05:23:24','/farmacia/app/pago_clienteedit.php','-1','U','pago_cliente','idvoucher_tarjeta','2',NULL,'2'),(11,'2015-11-11 06:40:37','/farmacia/app/productoedit.php','-1','U','producto','precio_venta','1','0.00','10'),(12,'2015-11-11 06:40:37','/farmacia/app/productoedit.php','-1','U','producto','precio_compra','1','0.00','4'),(13,'2015-11-11 06:41:23','/farmacia/app/productoedit.php','-1','U','producto','precio_compra','1','4.00','6'),(14,'2015-11-12 02:23:11','/farmacia/app/login.php','admin','Ingresar','::1','','','',''),(15,'2015-11-12 04:41:06','/farmacia/app/serie_documentoadd.php','-1','A','serie_documento','idtipo_documento','3','','1'),(16,'2015-11-12 04:41:06','/farmacia/app/serie_documentoadd.php','-1','A','serie_documento','idsucursal','3','','1'),(17,'2015-11-12 04:41:06','/farmacia/app/serie_documentoadd.php','-1','A','serie_documento','serie','3','','TEST1'),(18,'2015-11-12 04:41:06','/farmacia/app/serie_documentoadd.php','-1','A','serie_documento','correlativo','3','','0'),(19,'2015-11-12 04:41:06','/farmacia/app/serie_documentoadd.php','-1','A','serie_documento','fecha','3','','2015-11-11'),(20,'2015-11-12 04:41:06','/farmacia/app/serie_documentoadd.php','-1','A','serie_documento','idserie_documento','3','','3'),(21,'2015-11-12 04:46:09','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','idtipo_documento','15','','1'),(22,'2015-11-12 04:46:09','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','idsucursal','15','','1'),(23,'2015-11-12 04:46:09','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','idserie_documento','15','','3'),(24,'2015-11-12 04:46:09','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','fecha','15','','2015-11-11'),(25,'2015-11-12 04:46:09','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','nombre','15','',NULL),(26,'2015-11-12 04:46:09','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','direccion','15','',NULL),(27,'2015-11-12 04:46:09','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','nit','15','',NULL),(28,'2015-11-12 04:46:09','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','observaciones','15','',NULL),(29,'2015-11-12 04:46:09','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','fecha_insercion','15','',NULL),(30,'2015-11-12 04:46:09','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','idcliente','15','','1'),(31,'2015-11-12 04:46:09','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','iddocumento_debito','15','','15'),(32,'2015-11-12 04:50:02','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','idtipo_documento','16','','1'),(33,'2015-11-12 04:50:02','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','idsucursal','16','','1'),(34,'2015-11-12 04:50:02','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','idserie_documento','16','','3'),(35,'2015-11-12 04:50:02','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','fecha','16','','2015-11-10'),(36,'2015-11-12 04:50:02','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','nombre','16','',NULL),(37,'2015-11-12 04:50:02','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','direccion','16','',NULL),(38,'2015-11-12 04:50:02','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','nit','16','',NULL),(39,'2015-11-12 04:50:02','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','observaciones','16','',NULL),(40,'2015-11-12 04:50:02','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','fecha_insercion','16','',NULL),(41,'2015-11-12 04:50:02','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','idcliente','16','','1'),(42,'2015-11-12 04:50:02','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','iddocumento_debito','16','','16'),(43,'2015-11-12 04:51:27','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','idtipo_documento','17','','1'),(44,'2015-11-12 04:51:27','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','idsucursal','17','','1'),(45,'2015-11-12 04:51:27','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','idserie_documento','17','','3'),(46,'2015-11-12 04:51:27','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','fecha','17','','2015-11-11'),(47,'2015-11-12 04:51:27','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','nombre','17','',NULL),(48,'2015-11-12 04:51:27','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','direccion','17','',NULL),(49,'2015-11-12 04:51:27','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','nit','17','',NULL),(50,'2015-11-12 04:51:27','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','observaciones','17','',NULL),(51,'2015-11-12 04:51:27','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','fecha_insercion','17','',NULL),(52,'2015-11-12 04:51:27','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','idcliente','17','','1'),(53,'2015-11-12 04:51:27','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','iddocumento_debito','17','','17'),(54,'2015-11-12 04:53:07','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','idtipo_documento','18','','1'),(55,'2015-11-12 04:53:07','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','idsucursal','18','','1'),(56,'2015-11-12 04:53:07','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','idserie_documento','18','','1'),(57,'2015-11-12 04:53:07','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','fecha','18','','2015-11-11'),(58,'2015-11-12 04:53:07','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','nombre','18','',NULL),(59,'2015-11-12 04:53:07','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','direccion','18','',NULL),(60,'2015-11-12 04:53:07','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','nit','18','',NULL),(61,'2015-11-12 04:53:07','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','observaciones','18','',NULL),(62,'2015-11-12 04:53:07','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','fecha_insercion','18','',NULL),(63,'2015-11-12 04:53:07','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','idcliente','18','','1'),(64,'2015-11-12 04:53:07','/farmacia/app/documento_debitoadd.php','-1','A','documento_debito','iddocumento_debito','18','','18'),(65,'2015-11-12 05:24:04','/farmacia/app/documento_debitoedit.php','-1','U','documento_debito','nombre','18',NULL,'qw'),(66,'2015-11-12 05:24:04','/farmacia/app/documento_debitoedit.php','-1','U','documento_debito','fecha_insercion','18','2015-11-12 04:53:07','2015-11-12'),(67,'2015-11-12 05:25:36','/farmacia/app/documento_debitoedit.php','-1','U','documento_debito','nombre','18','qw','qw3'),(68,'2015-11-12 05:25:36','/farmacia/app/documento_debitoedit.php','-1','U','documento_debito','estado_documento','18','Emitido','Contabilizado'),(69,'2015-11-12 05:25:36','/farmacia/app/documento_debitoedit.php','-1','U','documento_debito','fecha_insercion','18','2015-11-12 00:00:00','2015-11-12'),(70,'2015-11-12 05:26:22','/farmacia/app/documento_debitoedit.php','-1','U','documento_debito','nombre','18','qw3','qw342'),(71,'2015-11-12 05:26:22','/farmacia/app/documento_debitoedit.php','-1','U','documento_debito','direccion','18',NULL,'21'),(72,'2015-11-12 05:26:22','/farmacia/app/documento_debitoedit.php','-1','U','documento_debito','fecha_insercion','18','2015-11-12 00:00:00','2015-11-12'),(73,'2015-11-12 05:27:54','/farmacia/app/documento_debitoedit.php','-1','U','documento_debito','nombre','18','qw342','qw342a'),(74,'2015-11-12 05:27:54','/farmacia/app/documento_debitoedit.php','-1','U','documento_debito','fecha_insercion','18','2015-11-12 00:00:00','2015-11-12'),(75,'2015-11-12 05:28:38','/farmacia/app/documento_debitoedit.php','-1','U','documento_debito','nombre','18','qw342a','qw342a1'),(76,'2015-11-12 05:28:38','/farmacia/app/documento_debitoedit.php','-1','U','documento_debito','fecha_insercion','18','2015-11-12 00:00:00','2015-11-12'),(77,'2015-11-12 14:36:36','/farmacia/app/login.php','admin','Ingresar','::1','','','','');
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
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`banco_BEFORE_INSERT` BEFORE INSERT ON `banco` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
  `fecha_insercion` datetime DEFAULT NULL,
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
INSERT INTO `bodega` VALUES (1,'Estanteria',1,1,'Activo',NULL),(2,'Bodega',1,2,'Activo',NULL),(3,'Bodegon',2,2,'Activo',NULL);
/*!40000 ALTER TABLE `bodega` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`bodega_BEFORE_INSERT` BEFORE INSERT ON `bodega` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`categoria_BEFORE_INSERT` BEFORE INSERT ON `categoria` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `cheque_cliente`
--

DROP TABLE IF EXISTS `cheque_cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cheque_cliente` (
  `idcheque_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(45) DEFAULT NULL,
  `propietario` varchar(45) DEFAULT NULL,
  `idbanco` int(11) NOT NULL DEFAULT '1',
  `cuenta` varchar(45) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cheque_estado` enum('Recibido','Cobrado','Rechazado') NOT NULL DEFAULT 'Recibido',
  PRIMARY KEY (`idcheque_cliente`),
  KEY `fk_cheque_cliente_idbanco_idx` (`idbanco`),
  CONSTRAINT `fk_cheque_cliente_idbanco` FOREIGN KEY (`idbanco`) REFERENCES `banco` (`idbanco`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cheque_cliente`
--

LOCK TABLES `cheque_cliente` WRITE;
/*!40000 ALTER TABLE `cheque_cliente` DISABLE KEYS */;
INSERT INTO `cheque_cliente` VALUES (1,'12321','SDEW',1,'3123124','2015-11-03','Activo','2015-11-11 06:12:44','JKÑJFSA',100.00,'Recibido');
/*!40000 ALTER TABLE `cheque_cliente` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`cheque_cliente_BEFORE_INSERT` BEFORE INSERT ON `cheque_cliente` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (1,1,NULL,NULL,'Nestor Fock',NULL,200.00,700.00,NULL,NULL,'Activo',NULL,'Si'),(2,2,NULL,'7808912-2','Silvia Gómez','Ciudad',0.00,0.00,NULL,'njfock@gmail.com','Activo',NULL,'Si'),(3,3,NULL,'5678104-0','Romeo Muñoz','Ciudad',0.00,130.00,'2015-11-11 17:55:38',NULL,'Activo',NULL,'Si'),(4,4,NULL,'3922140-7','Nestor Fock','Ciudad',0.00,0.00,'2015-11-11 19:49:24',NULL,'Activo',NULL,'Si');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`cliente_BEFORE_INSERT` BEFORE INSERT ON `cliente` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
  `fecha_insercion` datetime DEFAULT NULL,
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
INSERT INTO `departamento` VALUES (1,'GUATEMALA',1,'Activo',NULL),(2,'EL PROGRESO',1,'Activo',NULL),(3,'SACATEPEQUEZ',1,'Activo',NULL),(4,'CHIMALTENANGO',1,'Activo',NULL),(5,'ESCUINTLA',1,'Activo',NULL),(6,'SANTA ROSA',1,'Activo',NULL),(7,'SOLOLA',1,'Activo',NULL),(8,'TOTONICAPAN',1,'Activo',NULL),(9,'QUETZALTENANGO',1,'Activo',NULL),(10,'SUCHITEPEQUEZ',1,'Activo',NULL),(11,'RETALHULEU',1,'Activo',NULL),(12,'SAN MARCOS',1,'Activo',NULL),(13,'HUEHUETENANGO',1,'Activo',NULL),(14,'QUICHE',1,'Activo',NULL),(15,'BAJA VERAPAZ',1,'Activo',NULL),(16,'ALTA VERAPAZ',1,'Activo',NULL),(17,'PETEN',1,'Activo',NULL),(18,'IZABAL',1,'Activo',NULL),(19,'ZACAPA',1,'Activo',NULL),(20,'CHIQUIMULA',1,'Activo',NULL),(21,'JALAPA',1,'Activo',NULL),(22,'JUTIAPA',1,'Activo',NULL);
/*!40000 ALTER TABLE `departamento` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`departamento_BEFORE_INSERT` BEFORE INSERT ON `departamento` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
  `importe_descuento` decimal(10,2) NOT NULL DEFAULT '0.00',
  `importe_bruto` decimal(10,2) NOT NULL DEFAULT '0.00',
  `importe_exento` decimal(10,2) NOT NULL DEFAULT '0.00',
  `importe_neto` decimal(10,2) NOT NULL DEFAULT '0.00',
  `importe_iva` decimal(10,2) NOT NULL DEFAULT '0.00',
  `importe_otros_impuestos` decimal(10,2) NOT NULL DEFAULT '0.00',
  `importe_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`iddetalle_documento_debito`),
  KEY `fk_detalle_documento_debito_iddocumento_debito_idx` (`iddocumento_debito`),
  KEY `fk_detalle_documento_debito_idproducto_idx` (`idproducto`),
  KEY `fk_detalle_documento_debito_idbodega_idx` (`idbodega`),
  KEY `fk_detalle_document_idproducto_historial_idx` (`fecha_insercion`),
  CONSTRAINT `fk_detalle_documento_debito_idbodega` FOREIGN KEY (`idbodega`) REFERENCES `bodega` (`idbodega`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalle_documento_debito_iddocumento_debito` FOREIGN KEY (`iddocumento_debito`) REFERENCES `documento_debito` (`iddocumento_debito`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalle_documento_debito_idproducto` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_documento_debito`
--

LOCK TABLES `detalle_documento_debito` WRITE;
/*!40000 ALTER TABLE `detalle_documento_debito` DISABLE KEYS */;
INSERT INTO `detalle_documento_debito` VALUES (2,1,1,1,21,5.50,115.50,'Activo','2015-10-29 22:28:11',0.00,115.50,0.00,103.13,12.37,0.00,115.50),(3,1,2,1,2,10.00,20.00,'Activo','2015-10-29 22:29:46',0.00,20.00,0.00,17.86,2.14,0.00,20.00),(4,1,1,1,249,1.00,249.00,'Inactivo','2015-10-29 22:34:56',0.00,0.00,0.00,0.00,0.00,0.00,0.00),(5,2,1,1,100,2.00,200.00,'Inactivo','2015-10-29 22:42:00',50.00,0.00,0.00,0.00,0.00,0.00,0.00),(6,2,1,1,200,4.00,800.00,'Activo','2015-10-29 22:42:11',800.00,800.00,0.00,0.00,0.00,0.00,800.00),(7,4,2,1,48,2.00,96.00,'Activo','2015-11-05 20:02:39',0.00,96.00,0.00,85.71,10.29,0.00,96.00),(8,6,2,1,100,2.00,200.00,'Activo','2015-11-06 01:38:35',0.00,200.00,0.00,89.29,10.71,100.00,200.00),(10,8,1,1,0,10.00,0.00,'Activo','2015-11-11 22:35:55',0.00,0.00,0.00,-0.89,-0.11,1.00,0.00),(11,9,1,1,1,10.00,10.00,'Activo','2015-11-11 22:49:29',0.00,10.00,0.00,8.93,1.07,0.00,10.00),(12,10,1,1,1,10.00,10.00,'Activo','2015-11-11 22:52:23',0.00,10.00,0.00,8.93,1.07,0.00,10.00),(13,11,1,1,2,10.00,20.00,'Activo','2015-11-11 23:04:42',0.00,20.00,0.00,17.86,2.14,0.00,20.00),(14,12,1,1,2,10.00,20.00,'Activo','2015-11-11 23:09:11',0.00,20.00,0.00,17.86,2.14,0.00,20.00),(15,13,1,1,1,10.00,10.00,'Activo','2015-11-11 23:11:58',0.00,10.00,0.00,8.93,1.07,0.00,10.00),(16,19,1,1,1,10.00,10.00,'Activo','2015-11-12 14:52:32',0.00,0.00,0.00,0.00,0.00,0.00,0.00),(17,20,1,1,1,10.00,10.00,'Activo','2015-11-12 14:53:42',0.00,0.00,0.00,0.00,0.00,0.00,0.00),(18,21,1,1,1,10.00,10.00,'Activo','2015-11-12 14:59:52',0.00,0.00,0.00,0.00,0.00,0.00,0.00),(19,22,1,1,1,10.00,10.00,'Activo','2015-11-12 15:06:05',0.00,0.00,0.00,0.00,0.00,0.00,0.00),(20,23,1,1,1,10.00,10.00,'Activo','2015-11-12 15:16:38',0.00,0.00,0.00,0.00,0.00,0.00,0.00),(21,23,1,1,1,10.00,10.00,'Activo','2015-11-12 15:16:44',0.00,0.00,0.00,0.00,0.00,0.00,0.00);
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
	if new.cantidad!=old.cantidad then
		update producto_historial set unidades_salida = unidades_salida +(new.cantidad-old.cantidad) where idrelacion = new.iddetalle_documento_debito  and tabla_relacion = 'detalle_documento_debito';
    end if;
    if new.monto!=old.monto then
		update documento_debito  set monto = monto+(new.monto-old.monto) where iddocumento_debito  = new.iddocumento_debito;
    end if;
	if new.importe_bruto!=old.importe_bruto or new.importe_descuento!=old.importe_descuento or new.importe_exento!=old.importe_exento or new.importe_otros_impuestos!=old.importe_otros_impuestos or new.importe_neto!=old.importe_neto or new.importe_iva!=old.importe_iva or new.importe_total!=old.importe_total  then
		update documento_debito  set importe_bruto = importe_bruto+(new.importe_bruto-old.importe_bruto), importe_descuento = importe_descuento+(new.importe_descuento-old.importe_descuento), importe_exento = importe_exento+(new.importe_exento-old.importe_exento), importe_otros_impuestos = importe_otros_impuestos+(new.importe_otros_impuestos-old.importe_otros_impuestos),
        importe_neto = importe_neto+(new.importe_neto-old.importe_neto), importe_iva = importe_iva+(new.importe_iva-old.importe_iva), importe_total = importe_total+(new.importe_total-old.importe_total) where iddocumento_debito  = new.iddocumento_debito;
    end if;
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
  `estado_documento` enum('Emitido','Contabilizado','Anulado') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Emitido',
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Activo',
  `fecha_anulacion` date DEFAULT NULL,
  `motivo_anulacion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL DEFAULT '0.00',
  `fecha_insercion` datetime DEFAULT NULL,
  `idcliente` int(11) NOT NULL DEFAULT '1',
  `importe_bruto` decimal(10,2) NOT NULL DEFAULT '0.00',
  `importe_descuento` decimal(10,2) NOT NULL DEFAULT '0.00',
  `importe_exento` decimal(10,2) NOT NULL DEFAULT '0.00',
  `importe_neto` decimal(10,2) NOT NULL DEFAULT '0.00',
  `importe_iva` decimal(10,2) NOT NULL DEFAULT '0.00',
  `importe_otros_impuestos` decimal(10,2) NOT NULL DEFAULT '0.00',
  `importe_isr` decimal(10,2) NOT NULL DEFAULT '0.00',
  `importe_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `idfecha_contable` int(11) NOT NULL,
  PRIMARY KEY (`iddocumento_debito`),
  KEY `fk_documento_debito_idserie_documento_idx` (`idserie_documento`),
  KEY `fk_documento_debito_idtipo_documento_idx` (`idtipo_documento`),
  KEY `fk_documento_debito_idsucursal_idx` (`idsucursal`),
  KEY `fk_documento_debito_idcliente_idx` (`idcliente`),
  KEY `fk_documento_debito_idfecha_contable_idx` (`idfecha_contable`),
  CONSTRAINT `fk_documento_debito_idcliente` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_documento_debito_idfecha_contable` FOREIGN KEY (`idfecha_contable`) REFERENCES `fecha_contable` (`idfecha_contable`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_documento_debito_idserie_documento` FOREIGN KEY (`idserie_documento`) REFERENCES `serie_documento` (`idserie_documento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_documento_debito_idsucursal` FOREIGN KEY (`idsucursal`) REFERENCES `sucursal` (`idsucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_documento_debito_idtipo_documento` FOREIGN KEY (`idtipo_documento`) REFERENCES `tipo_documento` (`idtipo_documento`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documento_debito`
--

LOCK TABLES `documento_debito` WRITE;
/*!40000 ALTER TABLE `documento_debito` DISABLE KEYS */;
INSERT INTO `documento_debito` VALUES (1,1,1,1,'FP',1,'2015-10-01','Nestor Fock','Aguirre','3922140-7',NULL,'Contabilizado','Activo',NULL,NULL,384.50,'2015-10-29 20:55:12',1,135.50,0.00,0.00,120.99,14.51,0.00,0.00,135.50,1),(2,1,1,1,'FP',2,'2015-10-02','Silvia Gomez','Ciudad','13214312',NULL,'Contabilizado','Activo',NULL,NULL,800.00,'2015-10-29 20:58:50',1,800.00,0.00,0.00,0.00,0.00,0.00,0.00,800.00,1),(3,1,1,1,'FP',3,'2015-10-02','Erick Fock','ciudad','989123412',NULL,'Contabilizado','Activo',NULL,NULL,0.00,'2015-10-29 20:59:26',1,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,1),(4,1,1,1,'FP',4,'2015-11-05','gter','tew','4234',NULL,'Contabilizado','Activo',NULL,NULL,96.00,'2015-11-05 20:02:38',1,96.00,0.00,0.00,85.71,10.29,0.00,0.00,96.00,1),(6,1,1,1,'FP',6,'2015-11-05','rt','erwe','13214312','sw','Contabilizado','Activo',NULL,NULL,200.00,'2015-11-06 01:37:19',1,200.00,0.00,0.00,89.29,10.71,0.00,0.00,200.00,1),(7,1,1,1,'FP',8,'2015-11-11','Romeo Muñoz','Ciudad','5678104-0',NULL,'Contabilizado','Activo',NULL,NULL,0.00,'2015-11-11 22:28:15',3,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,1),(8,1,1,1,'FP',9,'2015-11-11','Romeo Muñoz','Ciudad','5678104-0',NULL,'Contabilizado','Activo',NULL,NULL,0.00,'2015-11-11 22:35:54',3,0.00,0.00,0.00,-0.89,-0.11,0.00,0.00,0.00,1),(9,1,1,1,'FP',10,'2015-11-11','Romeo Muñoz','Ciudad','5678104-0',NULL,'Contabilizado','Activo',NULL,NULL,10.00,'2015-11-11 22:49:28',3,10.00,0.00,0.00,8.93,1.07,0.00,0.00,10.00,1),(10,1,1,1,'FP',11,'2015-11-11','Romeo Muñoz','Ciudad','5678104-0',NULL,'Contabilizado','Activo',NULL,NULL,10.00,'2015-11-11 22:52:22',3,10.00,0.00,0.00,8.93,1.07,0.00,0.00,10.00,1),(11,1,1,1,'FP',12,'2015-11-11','Romeo Muñoz','Ciudad','5678104-0',NULL,'Contabilizado','Activo',NULL,NULL,20.00,'2015-11-11 23:04:41',3,20.00,0.00,0.00,17.86,2.14,0.00,0.00,20.00,1),(12,1,1,1,'FP',13,'2015-11-11','Romeo Muñoz','Ciudad','5678104-0',NULL,'Contabilizado','Activo',NULL,NULL,20.00,'2015-11-11 23:09:11',3,20.00,0.00,0.00,17.86,2.14,0.00,0.00,20.00,1),(13,1,1,1,'FP',14,'2015-11-11','Romeo Muñoz','Ciudad','5678104-0',NULL,'Contabilizado','Activo',NULL,NULL,10.00,'2015-11-11 23:11:57',3,10.00,0.00,0.00,8.93,1.07,0.00,0.00,10.00,1),(15,1,1,3,'TEST1',0,'2015-11-11',NULL,NULL,NULL,NULL,'Contabilizado','Activo',NULL,NULL,0.00,'2015-11-12 04:46:09',1,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,1),(16,1,1,3,'TEST1',1,'2015-11-11',NULL,NULL,NULL,NULL,'Contabilizado','Activo',NULL,NULL,0.00,'2015-11-12 04:50:02',1,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,1),(17,1,1,3,'TEST1',2,'2015-11-11',NULL,NULL,NULL,NULL,'Contabilizado','Activo',NULL,NULL,0.00,'2015-11-12 04:51:27',1,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,1),(18,1,1,1,'FP',15,'2015-11-13','qw342a1','21',NULL,NULL,'Contabilizado','Activo',NULL,NULL,0.00,'2015-11-12 00:00:00',1,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,3),(19,1,1,1,'FP',16,'2015-11-13','Romeo Muñoz','Ciudad','5678104-0',NULL,'Emitido','Activo',NULL,NULL,10.00,'2015-11-12 14:52:31',3,10.00,0.00,0.00,8.93,1.07,0.00,0.00,10.00,3),(20,1,1,1,'FP',17,'2015-11-13','Romeo Muñoz','Ciudad','5678104-0',NULL,'Emitido','Activo',NULL,NULL,10.00,'2015-11-12 14:53:41',3,10.00,0.00,0.00,8.93,1.07,0.00,0.00,10.00,3),(21,1,1,1,'FP',18,'2015-11-13','Romeo Muñoz','Ciudad','5678104-0',NULL,'Emitido','Activo',NULL,NULL,10.00,'2015-11-12 14:59:51',3,10.00,0.00,0.00,8.93,1.07,0.00,0.00,10.00,3),(22,1,1,1,'FP',19,'2015-11-13','Romeo Muñoz','Ciudad','5678104-0',NULL,'Emitido','Activo',NULL,NULL,10.00,'2015-11-12 15:06:04',3,10.00,0.00,0.00,8.93,1.07,0.00,0.00,10.00,3),(23,1,1,1,'FP',20,'2015-11-13','Romeo Muñoz','Ciudad','5678104-0',NULL,'Emitido','Activo',NULL,NULL,20.00,'2015-11-12 15:16:37',3,20.00,0.00,0.00,17.86,2.14,0.00,0.00,20.00,3);
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
    
    set new.fecha = fnc_use_fecha_contable_abierta(new.fecha,fnc_get_idempresa_idsucursal(new.idsucursal),'documento_debito');
	set new.idfecha_contable = fnc_get_idfecha_contable(new.fecha,fnc_get_idempresa_idsucursal(new.idsucursal),'documento_debito');
	
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
        update detalle_documento_debito set estado = new.estado where iddocumento_debito = new.iddocumento_debito;
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
  `fecha_insercion` datetime DEFAULT NULL,
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
INSERT INTO `empresa` VALUES (1,'Farmacias Nexthor','Ciudad','Activo',1,NULL);
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`empresa_BEFORE_INSERT` BEFORE INSERT ON `empresa` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
  `fecha_insercion` datetime DEFAULT NULL,
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
INSERT INTO `fabricante` VALUES (1,'BAYER',1,'Activo',NULL);
/*!40000 ALTER TABLE `fabricante` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`fabricante_BEFORE_INSERT` BEFORE INSERT ON `fabricante` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `fecha_contable`
--

DROP TABLE IF EXISTS `fecha_contable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fecha_contable` (
  `idfecha_contable` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime DEFAULT NULL,
  `estado_documento_debito` enum('Abierto','Control','Cerrado','Presentado') NOT NULL DEFAULT 'Abierto',
  `estado_documento_credito` enum('Abierto','Control','Cerrado','Presentado') NOT NULL DEFAULT 'Abierto',
  `estado_pago_cliente` enum('Abierto','Control','Cerrado','Presentado') NOT NULL DEFAULT 'Abierto',
  `estado_pago_proveedor` enum('Abierto','Control','Cerrado','Presentado') NOT NULL DEFAULT 'Abierto',
  `idperiodo_contable` int(11) NOT NULL DEFAULT '1',
  `idempresa` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idfecha_contable`),
  KEY `fk_fecha_contable_idperiodo_contable_idx` (`idperiodo_contable`),
  KEY `fk_fecha_contable_idempresa_idx` (`idempresa`),
  CONSTRAINT `fk_fecha_contable_idempresa` FOREIGN KEY (`idempresa`) REFERENCES `empresa` (`idempresa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_fecha_contable_idperiodo_contable` FOREIGN KEY (`idperiodo_contable`) REFERENCES `periodo_contable` (`idperiodo_contable`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fecha_contable`
--

LOCK TABLES `fecha_contable` WRITE;
/*!40000 ALTER TABLE `fecha_contable` DISABLE KEYS */;
INSERT INTO `fecha_contable` VALUES (1,'2015-11-11 00:00:00','Presentado','Abierto','Abierto','Abierto',11,1),(2,'2015-11-12 00:00:00','Control','Abierto','Abierto','Abierto',11,1),(3,'2015-11-13 00:00:00','Abierto','Abierto','Abierto','Abierto',11,1),(4,'2015-11-14 00:00:00','Abierto','Abierto','Abierto','Abierto',11,1),(5,'2015-11-15 00:00:00','Abierto','Abierto','Abierto','Abierto',11,1),(6,'2015-11-16 00:00:00','Abierto','Abierto','Abierto','Abierto',11,1);
/*!40000 ALTER TABLE `fecha_contable` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`fecha_contable_BEFORE_INSERT` BEFORE INSERT ON `fecha_contable` FOR EACH ROW
BEGIN
	declare s_idperiodo_contable int;
	select ifnull(idperiodo_contable,1) into s_idperiodo_contable
    from periodo_contable where mes = date_format(20151111,'%m') 
		and anio = date_format(20151111,'%Y')
        and idempresa = new.idempresa
    limit 1;
    
    set new.idperiodo_contable=s_idperiodo_contable;

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
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`fecha_contable_AFTER_UPDATE` AFTER UPDATE ON `fecha_contable` FOR EACH ROW
BEGIN
	if old.estado_documento_debito != new.estado_documento_debito then
		if old.estado_documento_debito = 'Control' then
			call pr_calc_importe_fiscal_documento_debito(new.idfecha_contable);
		elseif old.estado_documento_debito = 'Presentado' then
			update documento_debito set estado_documento = 'Contabilizado'
            where idfecha_contable = new.idfecha_contable and estado_documento = 'Emitido' and estado = 'Activo';
		end if;
	end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `impuesto`
--

DROP TABLE IF EXISTS `impuesto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `impuesto` (
  `idimpuesto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `porcentaje` decimal(10,5) NOT NULL DEFAULT '0.00000',
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime DEFAULT NULL,
  PRIMARY KEY (`idimpuesto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `impuesto`
--

LOCK TABLES `impuesto` WRITE;
/*!40000 ALTER TABLE `impuesto` DISABLE KEYS */;
/*!40000 ALTER TABLE `impuesto` ENABLE KEYS */;
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
  `fecha_insercion` datetime DEFAULT NULL,
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
INSERT INTO `marca` VALUES (1,'Tapcin',1,'Activo',NULL);
/*!40000 ALTER TABLE `marca` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`marca_BEFORE_INSERT` BEFORE INSERT ON `marca` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `meta`
--

DROP TABLE IF EXISTS `meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meta` (
  `idmeta` int(11) NOT NULL AUTO_INCREMENT,
  `idperiodo_contable` int(11) NOT NULL DEFAULT '1',
  `monto` decimal(10,2) NOT NULL,
  `idsucursal` int(11) NOT NULL DEFAULT '1',
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime DEFAULT NULL,
  PRIMARY KEY (`idmeta`),
  UNIQUE KEY `idperiodo_contable_UNIQUE` (`idperiodo_contable`),
  UNIQUE KEY `idsucursal_UNIQUE` (`idsucursal`),
  KEY `fk_meta_idsucursal_idx` (`idsucursal`),
  CONSTRAINT `fk_meta_idperiodo_contable` FOREIGN KEY (`idperiodo_contable`) REFERENCES `periodo_contable` (`idperiodo_contable`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_meta_idsucursal` FOREIGN KEY (`idsucursal`) REFERENCES `sucursal` (`idsucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meta`
--

LOCK TABLES `meta` WRITE;
/*!40000 ALTER TABLE `meta` DISABLE KEYS */;
INSERT INTO `meta` VALUES (1,1,1500.00,1,'Activo','2015-11-12 03:59:23');
/*!40000 ALTER TABLE `meta` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`meta_BEFORE_INSERT` BEFORE INSERT ON `meta` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`moneda_BEFORE_INSERT` BEFORE INSERT ON `moneda` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movimiento`
--

LOCK TABLES `movimiento` WRITE;
/*!40000 ALTER TABLE `movimiento` DISABLE KEYS */;
INSERT INTO `movimiento` VALUES (1,0.00,100.00,1,'documento',NULL,'Activo',1,'cliente',1,0.00),(2,0.00,500.00,1,'documento',NULL,'Activo',1,'cliente',1,0.00),(3,0.00,500.00,1,'documento',NULL,'Activo',1,'cliente',1,0.00),(4,100.00,0.00,1,'documento',NULL,'Activo',1,'cliente',1,0.00),(5,400.00,0.00,1,'documento_credito',NULL,'Activo',1,'proveedor',1,0.00),(6,0.00,200.00,6,'documento','2015-11-06 01:37:19','Activo',1,'cliente',1,0.00),(7,1000.00,1000.00,3,'documento_movimiento_egreso','2015-11-06 02:07:19','Activo',NULL,NULL,2,0.00),(8,1000.00,1000.00,3,'documento_movimiento_ingreso','2015-11-06 02:07:19','Activo',NULL,NULL,1,0.00),(9,0.00,0.00,1,'pago_cliente','2015-11-06 02:44:40','Activo',1,'cliente',1,0.00),(10,100.00,0.00,2,'pago_cliente','2015-11-08 23:09:05','Activo',1,'cliente',1,0.00),(11,0.00,101.00,2,'pago_proveedor','2015-11-09 00:41:41','Activo',1,'proveedor',1,0.00),(12,0.00,0.00,7,'documento','2015-11-11 22:28:15','Activo',3,'cliente',1,0.00),(13,0.00,0.00,8,'documento','2015-11-11 22:35:54','Activo',3,'cliente',1,0.00),(14,0.00,10.00,9,'documento','2015-11-11 22:49:28','Activo',3,'cliente',1,0.00),(15,0.00,10.00,10,'documento','2015-11-11 22:52:22','Activo',3,'cliente',1,0.00),(16,0.00,20.00,11,'documento','2015-11-11 23:04:41','Activo',3,'cliente',1,0.00),(17,0.00,20.00,12,'documento','2015-11-11 23:09:11','Activo',3,'cliente',1,0.00),(18,0.00,10.00,13,'documento','2015-11-11 23:11:57','Activo',3,'cliente',1,0.00),(19,0.00,0.00,15,'documento','2015-11-12 04:46:09','Activo',1,'cliente',1,0.00),(20,0.00,0.00,16,'documento','2015-11-12 04:50:02','Activo',1,'cliente',1,0.00),(21,0.00,0.00,17,'documento','2015-11-12 04:51:27','Activo',1,'cliente',1,0.00),(22,0.00,0.00,18,'documento','2015-11-12 04:53:07','Activo',1,'cliente',1,0.00),(23,0.00,10.00,19,'documento','2015-11-12 14:52:31','Activo',3,'cliente',1,0.00),(24,0.00,10.00,20,'documento','2015-11-12 14:53:41','Activo',3,'cliente',1,0.00),(25,0.00,10.00,21,'documento','2015-11-12 14:59:51','Activo',3,'cliente',1,0.00),(26,0.00,10.00,22,'documento','2015-11-12 15:06:04','Activo',3,'cliente',1,0.00),(27,0.00,20.00,23,'documento','2015-11-12 15:16:37','Activo',3,'cliente',1,0.00);
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
  `fecha_insercion` datetime DEFAULT NULL,
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
INSERT INTO `municipio` VALUES (1,'GUATEMALA',1,'Activo',NULL),(2,'SANTA CATARINA PINULA',1,'Activo',NULL),(3,'SAN JOSE PINULA',1,'Activo',NULL),(4,'SAN JOSE DEL GOLFO',1,'Activo',NULL),(5,'PALENCIA',1,'Activo',NULL),(6,'CHINAUTLA',1,'Activo',NULL),(7,'SAN PEDRO AYAMPUC',1,'Activo',NULL),(8,'MIXCO',1,'Activo',NULL),(9,'SAN PEDRO SACATEPEQUEZ',1,'Activo',NULL),(10,'SAN JUAN SACATEPEQUEZ',1,'Activo',NULL),(11,'SAN RAYMUNDO',1,'Activo',NULL),(12,'CHUARRANCHO',1,'Activo',NULL),(13,'FRAIJANES',1,'Activo',NULL),(14,'AMATITLAN',1,'Activo',NULL),(15,'VILLA NUEVA',1,'Activo',NULL),(16,'VILLA CANALES',1,'Activo',NULL),(17,'SAN MIGUEL PETAPA',1,'Activo',NULL),(18,'ANTIGUA GUATEMALA',3,'Activo',NULL),(19,'JOCOTENANGO',3,'Activo',NULL),(20,'PASTORES',3,'Activo',NULL),(21,'SUMPANGO',3,'Activo',NULL),(22,'SANTO DOMINGO XENACOJ',3,'Activo',NULL),(23,'SANTIAGO SACATEPEQUEZ',3,'Activo',NULL),(24,'SAN BARTOLOME MILPAS ALTAS',3,'Activo',NULL),(25,'SAN LUCAS SACATEPEQUEZ',3,'Activo',NULL),(26,'SANTA LUCIA MILPAS ALTAS',3,'Activo',NULL),(27,'MAGDALENA MILPAS ALTAS',3,'Activo',NULL),(28,'SANTA MARIA DE JESUS',3,'Activo',NULL),(29,'CIUDAD VIEJA',3,'Activo',NULL),(30,'SAN MIGUEL DUENAS',3,'Activo',NULL),(31,'SAN JUAN ALOTENANGO',3,'Activo',NULL),(32,'SAN ANTONIO AGUAS CALIENTES',3,'Activo',NULL),(33,'SANTA CATARINA BARAHONA',3,'Activo',NULL),(34,'CHIMALTENANGO',4,'Activo',NULL),(35,'SAN JOSE POAQUIL',4,'Activo',NULL),(36,'SAN MARTIN JILOTEPEQUE',4,'Activo',NULL),(37,'SAN JUAN COMALAPA',4,'Activo',NULL),(38,'SANTA APOLONIA',4,'Activo',NULL),(39,'TECPAN GUATEMALA',4,'Activo',NULL),(40,'PATZUN',4,'Activo',NULL),(41,'POCHUTA',4,'Activo',NULL),(42,'PATZICIA',4,'Activo',NULL),(43,'SANTA CRUZ BALANYA',4,'Activo',NULL),(44,'ACATENANGO',4,'Activo',NULL),(45,'SAN PEDRO YEPOCAPA',4,'Activo',NULL),(46,'SAN ANDRES ITZAPA',4,'Activo',NULL),(47,'PARRAMOS',4,'Activo',NULL),(48,'ZARAGOZA',4,'Activo',NULL),(49,'SAN MIGUEL EL TEJAR',4,'Activo',NULL),(50,'GUASTATOYA',2,'Activo',NULL);
/*!40000 ALTER TABLE `municipio` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`municipio_BEFORE_INSERT` BEFORE INSERT ON `municipio` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `pago_cliente`
--

DROP TABLE IF EXISTS `pago_cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pago_cliente` (
  `idpago_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `idtipo_pago` int(11) NOT NULL DEFAULT '1',
  `idcliente` int(11) NOT NULL DEFAULT '1',
  `monto` decimal(10,2) NOT NULL DEFAULT '0.00',
  `fecha` date DEFAULT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime DEFAULT NULL,
  `idsucursal` int(11) NOT NULL DEFAULT '1',
  `idboleta_deposito` int(11) DEFAULT NULL,
  `idvoucher_tarjeta` int(11) DEFAULT NULL,
  `idcheque_cliente` int(11) DEFAULT NULL,
  PRIMARY KEY (`idpago_cliente`),
  KEY `fk_pago_cliente_idcliente_idx` (`idcliente`),
  KEY `fk_pago_cliente_idsucursal_idx` (`idsucursal`),
  KEY `fk_pago_cliente_idboleta_deposito_idx` (`idboleta_deposito`),
  KEY `fk_pago_cliente_idvoucher_tarjeta_idx` (`idvoucher_tarjeta`),
  KEY `fk_pago_cliente_idtipo_pago_idx` (`idtipo_pago`),
  KEY `fk_pago_cliente_idcheque_cliente_idx` (`idcheque_cliente`),
  CONSTRAINT `fk_pago_cliente_idboleta_deposito` FOREIGN KEY (`idboleta_deposito`) REFERENCES `boleta_deposito` (`idboleta_deposito`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pago_cliente_idcheque_cliente` FOREIGN KEY (`idcheque_cliente`) REFERENCES `cheque_cliente` (`idcheque_cliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
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
INSERT INTO `pago_cliente` VALUES (1,1,1,200.00,NULL,'Inactivo','2015-11-06 02:44:40',1,NULL,NULL,NULL),(2,1,1,100.00,'2015-11-08','Activo','2015-11-08 23:09:05',1,NULL,2,NULL);
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
  `fecha_insercion` datetime DEFAULT NULL,
  PRIMARY KEY (`idpais`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pais`
--

LOCK TABLES `pais` WRITE;
/*!40000 ALTER TABLE `pais` DISABLE KEYS */;
INSERT INTO `pais` VALUES (1,'Guatemala','Activo',NULL),(2,'El Salvador','Inactivo',NULL);
/*!40000 ALTER TABLE `pais` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`pais_BEFORE_INSERT` BEFORE INSERT ON `pais` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `parametros_sistema`
--

DROP TABLE IF EXISTS `parametros_sistema`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parametros_sistema` (
  `idparametros_sistema` int(11) NOT NULL AUTO_INCREMENT,
  `porcentaje_IVA` decimal(10,4) NOT NULL DEFAULT '0.1200',
  `idmoneda` int(11) NOT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime DEFAULT NULL,
  PRIMARY KEY (`idparametros_sistema`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parametros_sistema`
--

LOCK TABLES `parametros_sistema` WRITE;
/*!40000 ALTER TABLE `parametros_sistema` DISABLE KEYS */;
INSERT INTO `parametros_sistema` VALUES (1,0.1200,1,'Activo','2015-11-12 02:24:39');
/*!40000 ALTER TABLE `parametros_sistema` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`parametros_sistema_BEFORE_INSERT` BEFORE INSERT ON `parametros_sistema` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `periodo_contable`
--

DROP TABLE IF EXISTS `periodo_contable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `periodo_contable` (
  `idperiodo_contable` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) NOT NULL DEFAULT '1',
  `mes` enum('1','2','3','4','5','6','7','8','9','10','11','12') NOT NULL DEFAULT '1',
  `anio` enum('2015','2016') NOT NULL DEFAULT '2015',
  `estado` enum('Abierto','Control','Cerrado','Presentado') NOT NULL DEFAULT 'Abierto',
  `fecha_cierre` date DEFAULT NULL,
  `fecha_insercion` datetime DEFAULT NULL,
  PRIMARY KEY (`idperiodo_contable`),
  KEY `fk_periodo_contable_idempresa_idx` (`idempresa`),
  CONSTRAINT `fk_periodo_contable_idempresa` FOREIGN KEY (`idempresa`) REFERENCES `empresa` (`idempresa`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `periodo_contable`
--

LOCK TABLES `periodo_contable` WRITE;
/*!40000 ALTER TABLE `periodo_contable` DISABLE KEYS */;
INSERT INTO `periodo_contable` VALUES (1,1,'1','2015','Abierto',NULL,NULL),(2,1,'2','2015','Abierto',NULL,NULL),(3,1,'3','2015','Abierto',NULL,NULL),(4,1,'4','2015','Abierto',NULL,NULL),(5,1,'5','2015','Abierto',NULL,NULL),(6,1,'6','2015','Abierto',NULL,NULL),(7,1,'7','2015','Abierto',NULL,NULL),(8,1,'8','2015','Abierto',NULL,NULL),(9,1,'9','2015','Abierto',NULL,NULL),(10,1,'10','2015','Abierto',NULL,NULL),(11,1,'11','2015','Abierto',NULL,NULL),(12,1,'12','2015','Abierto',NULL,NULL);
/*!40000 ALTER TABLE `periodo_contable` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`periodo_contable_BEFORE_INSERT` BEFORE INSERT ON `periodo_contable` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persona`
--

LOCK TABLES `persona` WRITE;
/*!40000 ALTER TABLE `persona` DISABLE KEYS */;
INSERT INTO `persona` VALUES (1,'Individual','Nestor','Fock',NULL,NULL,1,NULL,NULL,'Masculino',NULL,'Activo'),(2,'Individual','Silvia','Gómez','ciudad','1231242131',1,'2015-11-08','jk@hotmail.com','Masculino',NULL,'Activo'),(3,'Individual','Romeo Muñoz','Romeo Muñoz','Ciudad',NULL,1,NULL,NULL,'Masculino','2015-11-11 17:55:36','Activo'),(4,'Individual','Nestor Fock','Nestor Fock','Ciudad',NULL,1,NULL,NULL,'Masculino','2015-11-11 19:49:23','Activo');
/*!40000 ALTER TABLE `persona` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`persona_BEFORE_INSERT` BEFORE INSERT ON `persona` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
  `fecha_insercion` datetime DEFAULT NULL,
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
INSERT INTO `producto` VALUES (1,'Gripe y Tos',1,1,1036,'Activo',1,10.00,6.00,NULL),(2,'Noche',1,1,2350,'Activo',1,0.00,0.00,NULL);
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`producto_BEFORE_INSERT` BEFORE INSERT ON `producto` FOR EACH ROW
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
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`producto_AFTER_UPDATE` AFTER UPDATE ON `producto` FOR EACH ROW
BEGIN
	if new.precio_venta!=old.precio_venta or new.precio_compra!=old.precio_compra then
		insert into producto_precio_historial (idproducto, fecha, precio_venta, precio_compra)
		values (new.idproducto,now(),new.precio_venta, new.precio_compra);
	end if;
   

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
INSERT INTO `producto_bodega` VALUES (1,1,2,-200,'Activo',1),(2,1,1,1186,'Activo',1),(3,1,3,50,'Activo',2),(4,2,2,350,'Activo',3),(5,2,3,2000,'Activo',4),(6,2,1,0,'Activo',3);
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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_historial`
--

LOCK TABLES `producto_historial` WRITE;
/*!40000 ALTER TABLE `producto_historial` DISABLE KEYS */;
INSERT INTO `producto_historial` VALUES (1,1,1,2,'2015-10-06',100,0,'Activo',NULL,1,'detalle_documento_debito'),(2,2,3,5,'2015-10-29',20000,0,'Inactivo',NULL,1,'detalle_documento_debito'),(3,1,1,2,'2015-10-29',0,21,'Activo','2015-10-29 22:28:11',2,'detalle_documento_debito'),(4,2,1,6,'2015-10-29',0,2,'Activo','2015-10-29 22:29:46',3,'detalle_documento_debito'),(5,1,1,2,'2015-10-29',0,0,'Inactivo','2015-10-29 22:34:56',4,'detalle_documento_debito'),(6,1,1,2,'2015-10-29',0,0,'Inactivo','2015-10-29 22:42:00',5,'detalle_documento_debito'),(7,1,1,2,'2015-10-29',0,200,'Activo','2015-10-29 22:42:11',6,'detalle_documento_debito'),(8,2,1,6,'2015-11-05',0,48,'Activo','2015-11-05 20:02:39',7,'detalle_documento_debito'),(9,2,2,4,'2015-11-05',0,150,'Activo','2015-11-05 20:05:33',1,'detalle_documento_movimiento_egreso'),(10,2,1,6,'2015-11-05',150,0,'Activo','2015-11-05 20:05:33',1,'detalle_documento_movimiento_ingreso'),(11,2,3,5,'2015-11-05',2000,0,'Activo','2015-11-05 20:08:08',1,'detalle_documento_credito'),(12,2,1,6,'2015-11-06',0,100,'Activo','2015-11-06 01:38:35',8,'detalle_documento_debito'),(13,1,2,1,'2015-11-06',0,100,'Activo','2015-11-06 02:12:57',2,'detalle_documento_movimiento_egreso'),(14,1,1,2,'2015-11-06',100,0,'Activo','2015-11-06 02:12:57',2,'detalle_documento_movimiento_ingreso'),(17,1,2,1,'2015-11-06',0,100,'Activo','2015-11-06 02:20:30',3,'detalle_documento_movimiento_egreso'),(18,1,1,2,'2015-11-06',100,0,'Activo','2015-11-06 02:20:30',3,'detalle_documento_movimiento_ingreso'),(19,1,2,1,'2015-11-06',0,100,'Activo','2015-11-06 02:24:01',4,'detalle_documento_movimiento_egreso'),(20,1,1,2,'2015-11-06',100,0,'Activo','2015-11-06 02:24:01',4,'detalle_documento_movimiento_ingreso'),(21,1,1,2,'2015-11-11',0,0,'Activo','2015-11-11 22:35:55',10,'detalle_documento_debito'),(22,1,1,2,'2015-11-11',0,1,'Activo','2015-11-11 22:49:29',11,'detalle_documento_debito'),(23,1,1,2,'2015-11-11',0,1,'Activo','2015-11-11 22:52:23',12,'detalle_documento_debito'),(24,1,1,2,'2015-11-11',0,2,'Activo','2015-11-11 23:04:42',13,'detalle_documento_debito'),(25,1,1,2,'2015-11-11',0,2,'Activo','2015-11-11 23:09:11',14,'detalle_documento_debito'),(26,1,1,2,'2015-11-11',0,1,'Activo','2015-11-11 23:11:58',15,'detalle_documento_debito'),(27,1,1,2,'2015-11-12',0,1,'Activo','2015-11-12 14:52:32',16,'detalle_documento_debito'),(28,1,1,2,'2015-11-12',0,1,'Activo','2015-11-12 14:53:42',17,'detalle_documento_debito'),(29,1,1,2,'2015-11-12',0,1,'Activo','2015-11-12 14:59:52',18,'detalle_documento_debito'),(30,1,1,2,'2015-11-12',0,1,'Activo','2015-11-12 15:06:05',19,'detalle_documento_debito'),(31,1,1,2,'2015-11-12',0,1,'Activo','2015-11-12 15:16:38',20,'detalle_documento_debito'),(32,1,1,2,'2015-11-12',0,1,'Activo','2015-11-12 15:16:44',21,'detalle_documento_debito');
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
-- Table structure for table `producto_precio_historial`
--

DROP TABLE IF EXISTS `producto_precio_historial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto_precio_historial` (
  `idproducto_precio_historial` int(11) NOT NULL AUTO_INCREMENT,
  `idproducto` int(11) NOT NULL DEFAULT '1',
  `fecha` date DEFAULT NULL,
  `precio_venta` decimal(10,2) NOT NULL DEFAULT '0.00',
  `precio_compra` decimal(10,2) NOT NULL DEFAULT '0.00',
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `fecha_insercion` datetime DEFAULT NULL,
  PRIMARY KEY (`idproducto_precio_historial`),
  KEY `fk_producto_precio_historial_idproducto_idx` (`idproducto`),
  CONSTRAINT `fk_producto_precio_historial_idproducto` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_precio_historial`
--

LOCK TABLES `producto_precio_historial` WRITE;
/*!40000 ALTER TABLE `producto_precio_historial` DISABLE KEYS */;
INSERT INTO `producto_precio_historial` VALUES (1,1,'2015-11-11',10.00,4.00,'Activo',NULL),(2,1,'2015-11-11',10.00,6.00,'Activo','2015-11-11 06:41:23');
/*!40000 ALTER TABLE `producto_precio_historial` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`producto_precio_historial_BEFORE_INSERT` BEFORE INSERT ON `producto_precio_historial` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
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
INSERT INTO `producto_sucursal` VALUES (1,1,1,986,'Activo'),(2,1,2,50,'Activo'),(3,2,1,350,'Activo'),(4,2,2,2000,'Activo');
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
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`proveedor_BEFORE_INSERT` BEFORE INSERT ON `proveedor` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
  `fecha_insercion` datetime DEFAULT NULL,
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
INSERT INTO `registro_sanitario` VALUES (1,'4324235',1,'Activo',1,NULL);
/*!40000 ALTER TABLE `registro_sanitario` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`registro_sanitario_BEFORE_INSERT` BEFORE INSERT ON `registro_sanitario` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
  `fecha_insercion` datetime DEFAULT NULL,
  PRIMARY KEY (`idserie_documento`),
  KEY `fk_serie_documento_idsucursal_idx` (`idsucursal`),
  KEY `fk_serie_documento_idtipo_documento_idx` (`idtipo_documento`),
  CONSTRAINT `fk_serie_documento_idsucursal` FOREIGN KEY (`idsucursal`) REFERENCES `sucursal` (`idsucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_serie_documento_idtipo_documento` FOREIGN KEY (`idtipo_documento`) REFERENCES `tipo_documento` (`idtipo_documento`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `serie_documento`
--

LOCK TABLES `serie_documento` WRITE;
/*!40000 ALTER TABLE `serie_documento` DISABLE KEYS */;
INSERT INTO `serie_documento` VALUES (1,1,'FP',21,1,'2015-11-13','Activo',NULL),(2,1,'FM',1,2,'2015-10-02','Activo',NULL),(3,1,'TEST1',3,1,'2015-11-11','Activo','2015-11-12 04:41:06');
/*!40000 ALTER TABLE `serie_documento` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`serie_documento_BEFORE_INSERT` BEFORE INSERT ON `serie_documento` FOR EACH ROW
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
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`serie_documento_BEFORE_UPDATE` BEFORE UPDATE ON `serie_documento` FOR EACH ROW
BEGIN
	if new.fecha != old.fecha then
		if new.fecha < old.fecha then
			set new.fecha = old.fecha;
        end if;
    end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
  `fecha_insercion` datetime DEFAULT NULL,
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
INSERT INTO `sucursal` VALUES (1,'Farmacia Petapa','Av. Petapa',1,1,'Activo',2431.00,1600.00,NULL),(2,'Farmacia Monte Maria',NULL,1,1,'Activo',1000.00,1000.00,NULL);
/*!40000 ALTER TABLE `sucursal` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`sucursal_BEFORE_INSERT` BEFORE INSERT ON `sucursal` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
  `fecha_insercion` datetime DEFAULT NULL,
  PRIMARY KEY (`idtipo_bodega`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_bodega`
--

LOCK TABLES `tipo_bodega` WRITE;
/*!40000 ALTER TABLE `tipo_bodega` DISABLE KEYS */;
INSERT INTO `tipo_bodega` VALUES (1,'Mostrador','Activo',NULL),(2,'Bodega','Activo',NULL);
/*!40000 ALTER TABLE `tipo_bodega` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`tipo_bodega_BEFORE_INSERT` BEFORE INSERT ON `tipo_bodega` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
  `fecha_insercion` datetime DEFAULT NULL,
  PRIMARY KEY (`idtipo_documento`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_documento`
--

LOCK TABLES `tipo_documento` WRITE;
/*!40000 ALTER TABLE `tipo_documento` DISABLE KEYS */;
INSERT INTO `tipo_documento` VALUES (1,'Factura','Activo',NULL),(2,'Envio','Activo',NULL);
/*!40000 ALTER TABLE `tipo_documento` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`dbadmin`@`%`*/ /*!50003 TRIGGER `nexthor_empresa`.`tipo_documento_BEFORE_INSERT` BEFORE INSERT ON `tipo_documento` FOR EACH ROW
BEGIN
	set new.fecha_insercion = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
/*!50003 DROP FUNCTION IF EXISTS `fnc_get_idempresa_idsucursal` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`dbadmin`@`%` FUNCTION `fnc_get_idempresa_idsucursal`(pidsucursal int) RETURNS int(11)
BEGIN
	declare ridempresa INT default 0;
    select ifnull(idempresa,0) into ridempresa
	from sucursal 
	where idsucursal = pidsucursal
	limit 1;
	
	RETURN ridempresa;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fnc_get_idfecha_contable` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`dbadmin`@`%` FUNCTION `fnc_get_idfecha_contable`(pfecha date, pidempresa int, ptabla varchar(40)) RETURNS int(11)
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fnc_get_porcentaje_iva` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`dbadmin`@`%` FUNCTION `fnc_get_porcentaje_iva`() RETURNS decimal(10,5)
BEGIN
	declare rporcentaje_iva decimal(10,5) default 0;
    select ifnull(porcentaje_IVA,0) into rporcentaje_iva
	from parametros_sistema 
	where estado = 'Activo'
    order by 1 
	limit 1;
	
	RETURN rporcentaje_iva;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fnc_use_fecha_contable_abierta` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`dbadmin`@`%` FUNCTION `fnc_use_fecha_contable_abierta`(pfecha date, pidempresa int, ptabla varchar(40)) RETURNS date
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `pr_calc_importe_fiscal_documento_debito` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`dbadmin`@`%` PROCEDURE `pr_calc_importe_fiscal_documento_debito`(in pidfecha_contable int)
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-11-12 10:10:02
