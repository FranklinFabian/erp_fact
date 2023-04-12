-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.24-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para erp_base_ci
CREATE DATABASE IF NOT EXISTS `erp_base_ci` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `erp_base_ci`;

-- Volcando estructura para tabla erp_base_ci.almacen_almacen
CREATE TABLE IF NOT EXISTS `almacen_almacen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `correlativo` int(11) DEFAULT NULL,
  `codigo` varchar(100) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_base_ci.almacen_almacen: ~2 rows (aproximadamente)
DELETE FROM `almacen_almacen`;
/*!40000 ALTER TABLE `almacen_almacen` DISABLE KEYS */;
INSERT INTO `almacen_almacen` (`id`, `correlativo`, `codigo`, `nombre`, `descripcion`) VALUES
	(12, 2, '1.1.4.02', 'MATERIALES Y SUMINISTROS EN ALMACEN', 'MATERIALES Y SUMINISTROS EN ALMACEN'),
	(14, 3, '1.1.4.03', 'MATERIALES RETIRADOS', 'MATERIALES RETIRADOS');
/*!40000 ALTER TABLE `almacen_almacen` ENABLE KEYS */;

-- Volcando estructura para tabla erp_base_ci.almacen_articulo
CREATE TABLE IF NOT EXISTS `almacen_articulo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_grupo` int(11) DEFAULT NULL,
  `correlativo` int(11) DEFAULT NULL,
  `codigo` varchar(100) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `id_unidad` int(11) DEFAULT NULL,
  `stock_minimo` int(11) DEFAULT NULL,
  `monto_minimo` decimal(16,2) DEFAULT NULL,
  `monto_maximo` decimal(16,2) DEFAULT NULL,
  `monto_venta` decimal(10,2) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_almacen_articulo_almacen_unidad1_idx` (`id_unidad`),
  KEY `fk_almacen_articulo_almace_grupo1_idx` (`id_grupo`),
  CONSTRAINT `fk_almacen_articulo_almace_grupo100` FOREIGN KEY (`id_grupo`) REFERENCES `almacen_grupo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_almacen_articulo_almacen_unidad100` FOREIGN KEY (`id_unidad`) REFERENCES `almacen_unidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_base_ci.almacen_articulo: ~3 rows (aproximadamente)
DELETE FROM `almacen_articulo`;
/*!40000 ALTER TABLE `almacen_articulo` DISABLE KEYS */;
INSERT INTO `almacen_articulo` (`id`, `id_grupo`, `correlativo`, `codigo`, `nombre`, `id_unidad`, `stock_minimo`, `monto_minimo`, `monto_maximo`, `monto_venta`, `descripcion`) VALUES
	(6, 13, 1, '1001', 'Alambre Nro 10', 4, 100, 100.00, 100.00, 5.50, ''),
	(7, 13, 2, '1002', 'Cable', 4, 300, 200.00, 250.00, 30.00, ''),
	(8, 13, 3, '1003', 'rgb', 4, 1, 10.00, 15.00, 20.00, '');
/*!40000 ALTER TABLE `almacen_articulo` ENABLE KEYS */;

-- Volcando estructura para tabla erp_base_ci.almacen_cabecera
CREATE TABLE IF NOT EXISTS `almacen_cabecera` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `id_orden` int(11) DEFAULT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `glosa` text DEFAULT NULL,
  `traspaso` enum('si','no') DEFAULT NULL,
  `estado` enum('Pendiente','Aprobado') DEFAULT NULL,
  `tipo` enum('Ingreso','Egreso') DEFAULT NULL,
  `id_pedido` int(11) DEFAULT NULL,
  `solicitante` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_almacen_cabecera_almacen_proveedor1_idx` (`id_proveedor`),
  CONSTRAINT `fk_almacen_cabecera_almacen_proveedor1` FOREIGN KEY (`id_proveedor`) REFERENCES `almacen_proveedor` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_base_ci.almacen_cabecera: ~2 rows (aproximadamente)
DELETE FROM `almacen_cabecera`;
/*!40000 ALTER TABLE `almacen_cabecera` DISABLE KEYS */;
INSERT INTO `almacen_cabecera` (`id`, `id_usuario`, `id_proveedor`, `id_orden`, `codigo`, `fecha`, `glosa`, `traspaso`, `estado`, `tipo`, `id_pedido`, `solicitante`) VALUES
	(20, 1, 1, 6, 'IN-00001', '2023-01-30', '', 'no', 'Aprobado', 'Ingreso', NULL, NULL),
	(21, 1, 1, 6, 'IN-00002', '2023-01-30', 'ccc', 'no', 'Aprobado', 'Ingreso', NULL, NULL);
/*!40000 ALTER TABLE `almacen_cabecera` ENABLE KEYS */;

-- Volcando estructura para tabla erp_base_ci.almacen_cabecera_cotizacion
CREATE TABLE IF NOT EXISTS `almacen_cabecera_cotizacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `codigo` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_base_ci.almacen_cabecera_cotizacion: ~5 rows (aproximadamente)
DELETE FROM `almacen_cabecera_cotizacion`;
/*!40000 ALTER TABLE `almacen_cabecera_cotizacion` DISABLE KEYS */;
INSERT INTO `almacen_cabecera_cotizacion` (`id`, `id_usuario`, `codigo`, `fecha`) VALUES
	(3, 1, 0, '2023-01-30'),
	(4, 1, 0, '2023-01-30'),
	(5, 1, 0, '2023-01-31'),
	(6, 1, 0, '2023-01-31'),
	(7, 1, 0, '2023-01-31');
/*!40000 ALTER TABLE `almacen_cabecera_cotizacion` ENABLE KEYS */;

-- Volcando estructura para tabla erp_base_ci.almacen_cabecera_orden_compra
CREATE TABLE IF NOT EXISTS `almacen_cabecera_orden_compra` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `observacion` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_almacen_cabecera_orden_compra_almacen_proveedor1_idx` (`id_proveedor`),
  CONSTRAINT `fk_almacen_cabecera_orden_compra_almacen_proveedor1` FOREIGN KEY (`id_proveedor`) REFERENCES `almacen_proveedor` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_base_ci.almacen_cabecera_orden_compra: ~1 rows (aproximadamente)
DELETE FROM `almacen_cabecera_orden_compra`;
/*!40000 ALTER TABLE `almacen_cabecera_orden_compra` DISABLE KEYS */;
INSERT INTO `almacen_cabecera_orden_compra` (`id`, `id_usuario`, `id_proveedor`, `codigo`, `fecha`, `observacion`) VALUES
	(6, 1, 1, 'OC-00001', '2023-01-30', 'c1');
/*!40000 ALTER TABLE `almacen_cabecera_orden_compra` ENABLE KEYS */;

-- Volcando estructura para tabla erp_base_ci.almacen_cabecera_orden_trabajo
CREATE TABLE IF NOT EXISTS `almacen_cabecera_orden_trabajo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `observacion` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cabecera_orden_trabajo_almacen_proveedor1_idx` (`id_proveedor`),
  CONSTRAINT `fk_cabecera_orden_trabajo_almacen_proveedor10` FOREIGN KEY (`id_proveedor`) REFERENCES `almacen_proveedor` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_base_ci.almacen_cabecera_orden_trabajo: ~1 rows (aproximadamente)
DELETE FROM `almacen_cabecera_orden_trabajo`;
/*!40000 ALTER TABLE `almacen_cabecera_orden_trabajo` DISABLE KEYS */;
INSERT INTO `almacen_cabecera_orden_trabajo` (`id`, `id_usuario`, `id_proveedor`, `codigo`, `fecha`, `observacion`) VALUES
	(5, 1, 1, 'OT-00001', '2023-02-14', '');
/*!40000 ALTER TABLE `almacen_cabecera_orden_trabajo` ENABLE KEYS */;

-- Volcando estructura para tabla erp_base_ci.almacen_cabecera_pedido
CREATE TABLE IF NOT EXISTS `almacen_cabecera_pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `uso` varchar(255) DEFAULT NULL,
  `estado` enum('Pendiente','Aprobado') DEFAULT NULL,
  `tipo` enum('Tecnico','Administrativo') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_base_ci.almacen_cabecera_pedido: ~0 rows (aproximadamente)
DELETE FROM `almacen_cabecera_pedido`;
/*!40000 ALTER TABLE `almacen_cabecera_pedido` DISABLE KEYS */;
/*!40000 ALTER TABLE `almacen_cabecera_pedido` ENABLE KEYS */;

-- Volcando estructura para tabla erp_base_ci.almacen_correlativo
CREATE TABLE IF NOT EXISTS `almacen_correlativo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `formato` varchar(45) DEFAULT NULL,
  `padre` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_base_ci.almacen_correlativo: ~12 rows (aproximadamente)
DELETE FROM `almacen_correlativo`;
/*!40000 ALTER TABLE `almacen_correlativo` DISABLE KEYS */;
INSERT INTO `almacen_correlativo` (`id`, `nombre`, `numero`, `formato`, `padre`) VALUES
	(1, 'ingreso', 3, 'IN-', ''),
	(2, 'egreso', 1, 'EG-', ''),
	(3, 'nivel1', 1, '', ''),
	(4, 'nivel2', 1, '', 'nivel1'),
	(5, 'nivel3', 4, '', 'nivel2'),
	(6, 'almacen', 0, '0', 'nivel3'),
	(7, 'orden_compra', 2, 'OC-', ''),
	(8, 'orden_trabajo', 2, 'OT-', ''),
	(9, 'cotizacion', 6, 'CO-', ''),
	(21, 'pedido_tecnico', 1, 'PT-', NULL),
	(22, 'pedido_administrativo', 1, 'PA-', NULL),
	(23, 'proforma', 37, 'PROF-', NULL);
/*!40000 ALTER TABLE `almacen_correlativo` ENABLE KEYS */;

-- Volcando estructura para tabla erp_base_ci.almacen_cotizacion
CREATE TABLE IF NOT EXISTS `almacen_cotizacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cabecera_cotizacion` int(11) DEFAULT NULL,
  `id_articulo` int(11) DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `costo` decimal(16,2) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cotizacion_cabecera_cotizacion1_idx` (`id_cabecera_cotizacion`),
  KEY `fk_almacen_cotizacion_almacen_articulo1_idx` (`id_articulo`),
  KEY `fk_almacen_cotizacion_almacen_proveedor1_idx` (`id_proveedor`),
  CONSTRAINT `fk_almacen_cotizacion_almacen_articulo1` FOREIGN KEY (`id_articulo`) REFERENCES `almacen_articulo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_almacen_cotizacion_almacen_proveedor1` FOREIGN KEY (`id_proveedor`) REFERENCES `almacen_proveedor` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cotizacion_cabecera_cotizacion1` FOREIGN KEY (`id_cabecera_cotizacion`) REFERENCES `almacen_cabecera_cotizacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_base_ci.almacen_cotizacion: ~11 rows (aproximadamente)
DELETE FROM `almacen_cotizacion`;
/*!40000 ALTER TABLE `almacen_cotizacion` DISABLE KEYS */;
INSERT INTO `almacen_cotizacion` (`id`, `id_cabecera_cotizacion`, `id_articulo`, `id_proveedor`, `costo`, `cantidad`) VALUES
	(5, 4, 6, 1, 1.00, 1),
	(8, 5, 8, 1, 20.00, 2),
	(9, 5, 7, 1, 10.00, 2),
	(10, 6, 8, 1, 20.00, 2),
	(11, 6, 6, 1, 30.00, 2),
	(14, 7, 6, 1, 20.00, 1),
	(15, 7, 7, 1, 30.00, 2),
	(16, 7, 7, 1, 300.00, 1),
	(17, 7, 6, 1, 40.00, 1),
	(18, 3, 6, 1, 1000.00, 1),
	(19, 3, 7, 1, 2000.00, 2);
/*!40000 ALTER TABLE `almacen_cotizacion` ENABLE KEYS */;

-- Volcando estructura para tabla erp_base_ci.almacen_cuenta_auxiliar
CREATE TABLE IF NOT EXISTS `almacen_cuenta_auxiliar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cuenta_contable` int(11) DEFAULT NULL,
  `codigo` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cuenta_auxiliar_cuenta_contable1_idx` (`id_cuenta_contable`),
  CONSTRAINT `fk_cuenta_auxiliar_cuenta_contable1` FOREIGN KEY (`id_cuenta_contable`) REFERENCES `almacen_cuenta_contable` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_base_ci.almacen_cuenta_auxiliar: ~15 rows (aproximadamente)
DELETE FROM `almacen_cuenta_auxiliar`;
/*!40000 ALTER TABLE `almacen_cuenta_auxiliar` DISABLE KEYS */;
INSERT INTO `almacen_cuenta_auxiliar` (`id`, `id_cuenta_contable`, `codigo`, `nombre`, `descripcion`) VALUES
	(0, NULL, '0', 'SIN CUENTA AUXILIAR', NULL),
	(9, 485, '1.2.4.01.1.1', 'ORGANIZACION DE LA EMPRESA', NULL),
	(10, 485, '1.2.4.01.1.2', 'CONCESIONES Y PERMISOS', NULL),
	(11, 485, '1.2.4.01.1.3', 'OTROS BIENES INTANGIBLES', NULL),
	(12, 486, '1.2.4.01.2.1', 'ORGANIZACION DE LA EMPRESA', NULL),
	(13, 486, '1.2.4.01.2.2', 'CONCESIONES Y PERMISOS', NULL),
	(14, 486, '1.2.4.01.2.3', 'OTROS BIENES INTANGIBLES', NULL),
	(15, 487, '1.2.4.01.3.1', 'BIENES INTANGIBLES DE ALTA TENSION', NULL),
	(16, 487, '1.2.4.01.3.2', 'BIENES INTANGIBLES DE MEDIA TENSION', NULL),
	(17, 487, '1.2.4.01.3.3', 'BIENES INTANGIBLES DE BAJA TENSION', NULL),
	(18, 503, '2.1.4.01.4.1', 'I.V.A. DEBITO FISCAL', NULL),
	(19, 503, '2.1.4.01.4.2', 'I.V.A. SALDO A PAGAR', NULL),
	(20, 532, '2.1.5.01.2.1', 'OTRA CUENTAS 2020', NULL),
	(21, 532, '2.1.5.01.2.2', 'OTRA CUENTA 2 2020', NULL),
	(22, 532, '2.1.5.01.2.3', 'FFFF 2020', NULL);
/*!40000 ALTER TABLE `almacen_cuenta_auxiliar` ENABLE KEYS */;

-- Volcando estructura para tabla erp_base_ci.almacen_cuenta_contable
CREATE TABLE IF NOT EXISTS `almacen_cuenta_contable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=534 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_base_ci.almacen_cuenta_contable: ~67 rows (aproximadamente)
DELETE FROM `almacen_cuenta_contable`;
/*!40000 ALTER TABLE `almacen_cuenta_contable` DISABLE KEYS */;
INSERT INTO `almacen_cuenta_contable` (`id`, `codigo`, `nombre`, `descripcion`) VALUES
	(0, '0', 'SIN CUENTA CONTABLE', NULL),
	(467, '1.1.2.02.1', 'CLIENTES RESIDENCIALES ', NULL),
	(468, '1.1.2.02.2', 'CUENTES GENERALES', NULL),
	(469, '1.1.2.02.3', 'CUENTES INDUSTRIALES', NULL),
	(470, '1.1.2.02.4', 'CUENTES DE ALUMBRADO PUBLICO ', NULL),
	(471, '1.1.2.02.5', 'CLIENTES DE REVENTA', NULL),
	(472, '1.1.2.02.6', 'OTROS CLIENTES ', NULL),
	(473, '1.1.3.03.1', 'PAGOS ADELANTADOS DIVERSOS ', NULL),
	(474, '1.1.3.03.2', 'ANTICIPOS A PROVEEDORES Y CONTRATISTAS ', NULL),
	(475, '1.1.3.07.1', 'ANTICIPO DE IMPUESTOS', NULL),
	(476, '1.1.3.07.2', 'IVA CREDITO FISCAL', NULL),
	(477, '1.1.3.07.3', 'CREDITO FISCAL IUE A CTA IMPUESTO TRANSC', NULL),
	(478, '1.1.3.07.4', 'OTROS CREDITOS FISCALES ', NULL),
	(479, '1.2.1.02.1', 'CLIENTES RESIDENCIALES', NULL),
	(480, '1.2.1.02.2', 'CLIENTES GENERALES', NULL),
	(481, '1.2.1.02.3', 'CLIENTES INDUSTRIALES', NULL),
	(482, '1.2.1.02.4', 'CLIENTES DE ALUMBRADO PUBLICO', NULL),
	(483, '1.2.1.02.5', 'CLIENTES DE REVENTA', NULL),
	(484, '1.2.1.02.6', 'OTROS CLIENTES', NULL),
	(485, '1.2.4.01.1', 'BIENES INTANGIBLES DE GENERACION ', NULL),
	(486, '1.2.4.01.2', 'BIENES INTANGIBLES DE TRANSMISION', NULL),
	(487, '1.2.4.01.3', 'BIENES INTANGIBLES DE DISTRIBUCION', NULL),
	(488, '2.1.2.01.1', 'BONOS NO AFECTOS A LA CONCESION', NULL),
	(489, '2.1.2.01.2', 'BONOS PARA OBRAS DE ALTA TENSION', NULL),
	(490, '2.1.2.01.3', 'BONOS PARA OBRAS DE MEDIA TENSION', NULL),
	(491, '2.1.2.01.4', 'BONOS PARA OBRA DE BAJA TENSION', NULL),
	(492, '2.1.2.02.1', 'DEUDAS CON GARANTIA NO AFECTOS A LA CONCESION', NULL),
	(493, '2.1.2.02.2', 'DEUDAS CON GARANTIA PARA OBRAS EN ALTA TENSION', NULL),
	(494, '2.1.2.02.3', 'DEUDAS CON GARANTIA PARA OBRAS EN MEDIA TENSION', NULL),
	(495, '2.1.2.02.4', 'DEUDAS CON GARANTIA PARA OBRAS EN BAJA TENSION', NULL),
	(496, '2.1.2.03.1', 'DEUDAS SIN GARANTIA NO AFECTOS A LA CONCESION', NULL),
	(497, '2.1.2.03.2', 'DEUDAS SIN GARANTIA PARA OBRAS EN ALTA TENSION', NULL),
	(498, '2.1.2.03.3', 'DEUDAS SIN GARANTIA PARA OBRAS EN MEDIA TENSION', NULL),
	(499, '2.1.2.03.4', 'DEUDAS SIN GARANTIA PARA OBRA EN BAJA TENSION', NULL),
	(500, '2.1.4.01.1', 'IMPUESTO A LAS TRANSACCIONES ', NULL),
	(501, '2.1.4.01.2', 'IMPUESTO SOBRE UTILIDADES DE LA EMPRESA', NULL),
	(502, '2.1.4.01.3', 'IMPUESTOS A LA PROPIEDAD', NULL),
	(503, '2.1.4.01.4', 'IMPUESTO AL VALOR AGREGADO', NULL),
	(504, '2.1.5.01.1', 'DOCUMENTOS POR PAGAR NO AFECTOS A LA CONCESION', NULL),
	(505, '2.1.5.01.2', 'DOCUMENTOS POR PAGAR PARA OBRAS EN ALTA TENSION', NULL),
	(506, '2.1.5.01.3', 'DOCUMENTOS POR PAGAR PARA OBRAS EN MEDIA TENSION', NULL),
	(507, '2.1.5.01.4', 'DOCUMENTOS POR PAGAR PARA OBRAS EN BAJA TENSION', NULL),
	(508, '2.1.5.02.1', 'CUENTAS POR PAGAR NO AFECTOS A LA CONCESION', NULL),
	(509, '2.1.5.02.2', 'CUENTAS POR PAGAR PARA OBRAS EN ALTA TENSION', NULL),
	(510, '2.1.5.02.3', 'CUENTAS POR PAGAR PARA OBRAS EN MEDIA TENSION', NULL),
	(511, '2.1.5.02.4', 'CUENTAS POR PAGAR PARA OBRAS EN BAJA TENSION', NULL),
	(512, '2.2.2.01.1', 'BONOS NO AFECTOS A LA CONCESION', NULL),
	(513, '2.2.2.01.2', 'BONOS PARA 0BRAS EN ALTA TENSION', NULL),
	(514, '2.2.2.01.3', 'BONOS PARA OBRAS EN MEDIA TENSION', NULL),
	(515, '2.2.2.01.4', 'BONOS PARA OBRAS EN BAJA TENSION', NULL),
	(516, '2.2.2.02.1', 'DEUDAS CON GARANTIA NO AFECTOS A LA CONCESION', NULL),
	(517, '2.2.2.02.2', 'DEUDAS CON GARANTIA PARA OBRAS EN ALTA TENSION', NULL),
	(518, '2.2.2.02.3', 'DEUDAS CON GARANTIA PARA OBRAS EN MEDIA TENSION', NULL),
	(519, '2.2.2.02.4', 'DEUDAS CON GARANTIA PARA OBRAS EN BAJA TENSION', NULL),
	(520, '2.2.2.03.1', 'DEUDAS SIN GARANTIA NO AFECTOS A LA CONCESION', NULL),
	(521, '2.2.2.03.2', 'DEUDAS SIN GARANTIA PARA OBRAS EN ALTA TENSION', NULL),
	(522, '2.2.2.03.3', 'DEUDAS SIN GARANTIA PARA OBRAS EN MEDIA TENSION', NULL),
	(523, '2.2.2.03.4', 'DEUDAS SIN GARANTIA PARA OBRAS EN BAJA TENSION', NULL),
	(524, '2.2.5.01.1', 'DOCUMENTOS POR PAGAR NO AFECTOS A LA CONCESION', NULL),
	(525, '2.2.5.01.2', 'DOCUMENTOS POR PAGAR PARA OBRAS EN ALTA TENSION', NULL),
	(526, '2.2.5.01.3', 'DOCUMENTOS POR PAGAR PARA OBRAS EN MEDIA TENSION', NULL),
	(527, '2.2.5.01.4', 'DOCUMENTOS POR PAGAR PARA OBRAS EN BAJA TENSION', NULL),
	(528, '2.2.5.02.1', 'CUENTAS POR PAGAR NO AFECTOS A LA CONCESION', NULL),
	(529, '2.2.5.02.2', 'CUENTAS POR PAGAR PARA OBRAS EN ALTA TENSION', NULL),
	(530, '2.2.5.02.3', 'CUENTAS POR PAGAR PARA OBRAS EN MEDIA TENSION', NULL),
	(531, '2.2.5.02.4', 'CUENTAS POR PAGAR PARA OBRAS EN BAJA TENSION', NULL),
	(532, '2.1.5.01.2', 'DOCUMENTOS POR PAGAR PARA OBRAS EN ALTA TENSION - 2020', NULL);
/*!40000 ALTER TABLE `almacen_cuenta_contable` ENABLE KEYS */;

-- Volcando estructura para tabla erp_base_ci.almacen_departamento
CREATE TABLE IF NOT EXISTS `almacen_departamento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `abreviatura` varchar(45) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_base_ci.almacen_departamento: ~1 rows (aproximadamente)
DELETE FROM `almacen_departamento`;
/*!40000 ALTER TABLE `almacen_departamento` DISABLE KEYS */;
INSERT INTO `almacen_departamento` (`id`, `nombre`, `abreviatura`, `descripcion`) VALUES
	(1, 'La Paz', 'LP', 'La Paz');
/*!40000 ALTER TABLE `almacen_departamento` ENABLE KEYS */;

-- Volcando estructura para tabla erp_base_ci.almacen_grupo
CREATE TABLE IF NOT EXISTS `almacen_grupo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `correlativo` int(11) DEFAULT NULL,
  `codigo` varchar(100) DEFAULT NULL,
  `id_almacen` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_almacen_grupo_almacen_almacen1_idx` (`id_almacen`),
  CONSTRAINT `fk_almacen_grupo_almacen_almacen1` FOREIGN KEY (`id_almacen`) REFERENCES `almacen_almacen` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_base_ci.almacen_grupo: ~9 rows (aproximadamente)
DELETE FROM `almacen_grupo`;
/*!40000 ALTER TABLE `almacen_grupo` DISABLE KEYS */;
INSERT INTO `almacen_grupo` (`id`, `correlativo`, `codigo`, `id_almacen`, `nombre`, `descripcion`) VALUES
	(13, 1, '1.1.4.02.1', 12, 'MATERIAL DE VENTA', 'MATERIAL DE VENTA'),
	(14, 2, '1.1.4.02.2', 12, 'MATERIAL DE ESCRITORIO', 'MATERIAL DE ESCRITORIO'),
	(15, 3, '1.1.4.02.3', 12, 'MATERIALES Y SUMINISTROS DE RED ELECTRICA', 'MATERIALES Y SUMINISTROS DE RED ELECTRICA'),
	(16, 4, '1.1.4.02.4', 12, 'COMBUSTIBLES Y LUBRICANTES', 'COMBUSTIBLES Y LUBRICANTES'),
	(17, 5, '1.1.4.02.5', 12, 'OTROS MATERIALES Y ACCESORIOS', 'OTROS MATERIALES Y ACCESORIOS'),
	(18, 6, '1.1.4.02.6', 12, 'MATERIALES Y SUMINISTROS DE TV CABLE', 'MATERIALES Y SUMINISTROS DE TV CABLE'),
	(19, 1, '1.1.4.03.1', 14, 'MATERIAL RETIRADO ENERGIA ELECTRICA', 'MATERIAL RETIRADO ENERGIA ELECTRICA'),
	(20, 2, '1.1.4.03.2', 14, 'MATERIAL RETIRADO TV CABLE', 'MATERIAL RETIRADO TV CABLE'),
	(21, 3, '1.1.4.03.3', 14, 'MATERIAL RETIRADO INTERNET', 'MATERIAL RETIRADO INTERNET');
/*!40000 ALTER TABLE `almacen_grupo` ENABLE KEYS */;

-- Volcando estructura para tabla erp_base_ci.almacen_movimiento
CREATE TABLE IF NOT EXISTS `almacen_movimiento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cabecera` int(11) DEFAULT NULL,
  `id_articulo` int(11) DEFAULT NULL,
  `id_proyecto` int(11) DEFAULT NULL,
  `id_cuenta_contable` int(11) DEFAULT NULL,
  `id_cuenta_auxiliar` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `costo_real` decimal(16,2) DEFAULT NULL,
  `costo_contable` decimal(16,2) DEFAULT NULL,
  `saldo_cantidad` int(11) DEFAULT NULL,
  `saldo_valor_unitario` decimal(16,2) DEFAULT NULL,
  `saldo_valor_total` decimal(16,2) DEFAULT NULL,
  `tipo` enum('Ingreso','Egreso') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ingreso_cuenta_auxiliar1_idx` (`id_cuenta_auxiliar`),
  KEY `fk_egreso_proyecto1_idx` (`id_proyecto`),
  KEY `fk_movimiento_cabecera1_idx` (`id_cabecera`),
  KEY `fk_almacen_movimiento_almacen_articulo1_idx` (`id_articulo`),
  CONSTRAINT `fk_almacen_movimiento_almacen_articulo1` FOREIGN KEY (`id_articulo`) REFERENCES `almacen_articulo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_egreso_proyecto10` FOREIGN KEY (`id_proyecto`) REFERENCES `almacen_proyecto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ingreso_cuenta_auxiliar100` FOREIGN KEY (`id_cuenta_auxiliar`) REFERENCES `almacen_cuenta_auxiliar` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_movimiento_cabecera1` FOREIGN KEY (`id_cabecera`) REFERENCES `almacen_cabecera` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_base_ci.almacen_movimiento: ~2 rows (aproximadamente)
DELETE FROM `almacen_movimiento`;
/*!40000 ALTER TABLE `almacen_movimiento` DISABLE KEYS */;
INSERT INTO `almacen_movimiento` (`id`, `id_cabecera`, `id_articulo`, `id_proyecto`, `id_cuenta_contable`, `id_cuenta_auxiliar`, `cantidad`, `costo_real`, `costo_contable`, `saldo_cantidad`, `saldo_valor_unitario`, `saldo_valor_total`, `tipo`) VALUES
	(1, 20, 7, NULL, NULL, NULL, 1, 1.00, 0.87, NULL, NULL, NULL, 'Ingreso'),
	(2, 21, 7, NULL, NULL, NULL, 1, 1.00, 0.87, NULL, NULL, NULL, 'Ingreso');
/*!40000 ALTER TABLE `almacen_movimiento` ENABLE KEYS */;

-- Volcando estructura para tabla erp_base_ci.almacen_orden_compra
CREATE TABLE IF NOT EXISTS `almacen_orden_compra` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_articulo` int(11) DEFAULT NULL,
  `id_cabecera` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `costo` decimal(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_almacen_orden_compra_almacen_cabecera_orden_compra1_idx` (`id_cabecera`),
  CONSTRAINT `fk_almacen_orden_compra_almacen_cabecera_orden_compra1` FOREIGN KEY (`id_cabecera`) REFERENCES `almacen_cabecera_orden_compra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_base_ci.almacen_orden_compra: ~1 rows (aproximadamente)
DELETE FROM `almacen_orden_compra`;
/*!40000 ALTER TABLE `almacen_orden_compra` DISABLE KEYS */;
INSERT INTO `almacen_orden_compra` (`id`, `id_articulo`, `id_cabecera`, `cantidad`, `costo`) VALUES
	(3, 7, 6, 1, 1.00);
/*!40000 ALTER TABLE `almacen_orden_compra` ENABLE KEYS */;

-- Volcando estructura para tabla erp_base_ci.almacen_orden_trabajo
CREATE TABLE IF NOT EXISTS `almacen_orden_trabajo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cabecera` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `unidad` varchar(45) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `costo` decimal(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_almacen_orden_trabajo_almacen_cabecera_orden_trabajo1_idx` (`id_cabecera`),
  CONSTRAINT `fk_almacen_orden_trabajo_almacen_cabecera_orden_trabajo1` FOREIGN KEY (`id_cabecera`) REFERENCES `almacen_cabecera_orden_trabajo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_base_ci.almacen_orden_trabajo: ~0 rows (aproximadamente)
DELETE FROM `almacen_orden_trabajo`;
/*!40000 ALTER TABLE `almacen_orden_trabajo` DISABLE KEYS */;
/*!40000 ALTER TABLE `almacen_orden_trabajo` ENABLE KEYS */;

-- Volcando estructura para tabla erp_base_ci.almacen_pedido
CREATE TABLE IF NOT EXISTS `almacen_pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cabecera` int(11) DEFAULT NULL,
  `id_articulo` int(11) DEFAULT NULL,
  `id_proyecto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_egreso_proyecto1_idx` (`id_proyecto`),
  KEY `fk_pedido_cabecera_pedido1_idx` (`id_cabecera`),
  KEY `fk_almacen_pedido_almacen_articulo1_idx` (`id_articulo`),
  CONSTRAINT `fk_almacen_pedido_almacen_articulo1` FOREIGN KEY (`id_articulo`) REFERENCES `almacen_articulo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_egreso_proyecto100` FOREIGN KEY (`id_proyecto`) REFERENCES `almacen_proyecto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedido_cabecera_pedido1` FOREIGN KEY (`id_cabecera`) REFERENCES `almacen_cabecera_pedido` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_base_ci.almacen_pedido: ~0 rows (aproximadamente)
DELETE FROM `almacen_pedido`;
/*!40000 ALTER TABLE `almacen_pedido` DISABLE KEYS */;
/*!40000 ALTER TABLE `almacen_pedido` ENABLE KEYS */;

-- Volcando estructura para tabla erp_base_ci.almacen_proforma
CREATE TABLE IF NOT EXISTS `almacen_proforma` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `codigo` int(11) DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `estado` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `alamacen_proforma_FK` (`id_usuario`),
  KEY `almacen_proforma_FK` (`id_cliente`),
  CONSTRAINT `almacen_proforma_FK` FOREIGN KEY (`id_cliente`) REFERENCES `fact_cliente` (`idcliente`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla erp_base_ci.almacen_proforma: ~0 rows (aproximadamente)
DELETE FROM `almacen_proforma`;
/*!40000 ALTER TABLE `almacen_proforma` DISABLE KEYS */;
/*!40000 ALTER TABLE `almacen_proforma` ENABLE KEYS */;

-- Volcando estructura para tabla erp_base_ci.almacen_proforma_items
CREATE TABLE IF NOT EXISTS `almacen_proforma_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_proforma` int(11) DEFAULT NULL,
  `id_articulo` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `costo` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `almacen_proforma_items_FK` (`id_proforma`),
  KEY `almacen_proforma_items_FK_1` (`id_articulo`),
  CONSTRAINT `almacen_proforma_items_FK` FOREIGN KEY (`id_proforma`) REFERENCES `almacen_proforma` (`id`),
  CONSTRAINT `almacen_proforma_items_FK_1` FOREIGN KEY (`id_articulo`) REFERENCES `almacen_articulo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla erp_base_ci.almacen_proforma_items: ~0 rows (aproximadamente)
DELETE FROM `almacen_proforma_items`;
/*!40000 ALTER TABLE `almacen_proforma_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `almacen_proforma_items` ENABLE KEYS */;

-- Volcando estructura para tabla erp_base_ci.almacen_proveedor
CREATE TABLE IF NOT EXISTS `almacen_proveedor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `id_ciudad` int(11) DEFAULT NULL,
  `nit` varchar(45) DEFAULT NULL,
  `banco` varchar(45) DEFAULT NULL,
  `cuenta` varchar(45) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `test` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_almacen_proveedor_almacen_departamento1_idx` (`id_ciudad`),
  CONSTRAINT `fk_almacen_proveedor_almacen_departamento1` FOREIGN KEY (`id_ciudad`) REFERENCES `almacen_departamento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_base_ci.almacen_proveedor: ~1 rows (aproximadamente)
DELETE FROM `almacen_proveedor`;
/*!40000 ALTER TABLE `almacen_proveedor` DISABLE KEYS */;
INSERT INTO `almacen_proveedor` (`id`, `nombre`, `direccion`, `telefono`, `correo`, `id_ciudad`, `nit`, `banco`, `cuenta`, `descripcion`, `test`) VALUES
	(1, 'Proveedor 1', '', '', '', 1, '1037408015', '', '', '', NULL);
/*!40000 ALTER TABLE `almacen_proveedor` ENABLE KEYS */;

-- Volcando estructura para tabla erp_base_ci.almacen_proyecto
CREATE TABLE IF NOT EXISTS `almacen_proyecto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_base_ci.almacen_proyecto: ~3 rows (aproximadamente)
DELETE FROM `almacen_proyecto`;
/*!40000 ALTER TABLE `almacen_proyecto` DISABLE KEYS */;
INSERT INTO `almacen_proyecto` (`id`, `codigo`, `nombre`, `descripcion`) VALUES
	(0, NULL, 'Sin proyecto', NULL),
	(1, 'P001_2005', 'Proyecto 1 Gestion 2005', 'Este es un proyecto de ejemplo de la gestion 2005'),
	(2, 'P001_2005', 'Proyecto 1 Gestion 2005', 'Este es un proyecto de ejemplo de la gestion 2005');
/*!40000 ALTER TABLE `almacen_proyecto` ENABLE KEYS */;

-- Volcando estructura para tabla erp_base_ci.almacen_unidad
CREATE TABLE IF NOT EXISTS `almacen_unidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_base_ci.almacen_unidad: ~1 rows (aproximadamente)
DELETE FROM `almacen_unidad`;
/*!40000 ALTER TABLE `almacen_unidad` DISABLE KEYS */;
INSERT INTO `almacen_unidad` (`id`, `nombre`, `descripcion`) VALUES
	(4, 'Unidad 1', 'Unidad 1');
/*!40000 ALTER TABLE `almacen_unidad` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
