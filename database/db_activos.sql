-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.8-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura para tabla erp_atocha.activos_catalogo_cuenta
CREATE TABLE IF NOT EXISTS `activos_catalogo_cuenta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_grupo` int(11) DEFAULT NULL,
  `codigo` varchar(45) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `abreviatura` varchar(45) DEFAULT NULL,
  `correlativo` int(11) DEFAULT NULL,
  `coeficiente_depreciacion` decimal(16,2) DEFAULT NULL,
  `vida_util` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT NULL,
  `id_cuenta` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_activos_catalogo_cuenta_activos_catalogo_grupo1_idx` (`id_grupo`),
  CONSTRAINT `fk_activos_catalogo_cuenta_activos_catalogo_grupo1` FOREIGN KEY (`id_grupo`) REFERENCES `activos_catalogo_grupo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_atocha.activos_catalogo_cuenta: ~32 rows (aproximadamente)
/*!40000 ALTER TABLE `activos_catalogo_cuenta` DISABLE KEYS */;
INSERT INTO `activos_catalogo_cuenta` (`id`, `id_grupo`, `codigo`, `nombre`, `abreviatura`, `correlativo`, `coeficiente_depreciacion`, `vida_util`, `descripcion`, `estado`) VALUES
	(1, 6, '1.2.3.1.3.1.03', 'Equipos de Estaciones - AT', NULL, 2, 0.25, 48, 'Equipos de Estaciones - AT', NULL),
	(2, 6, '1.2.3.1.3.1.05', 'Postes, Torres y Accesorios  - AT', NULL, 1, NULL, NULL, 'Postes, Torres y Accesorios  - AT', NULL),
	(3, 1, '1.2.3.1.4.1.02', 'Edificios, Estructuras y Mejoras - MT', 'EEMT', 5, 2.50, 40, 'Edificios, Estructuras y Mejoras - MT', NULL),
	(4, 1, '1.2.3.1.4.1.03', 'Equipos de Estaciones  - MT', NULL, 1, 3.30, 30, 'Equipos de Estaciones  - MT', NULL),
	(5, 1, '1.2.3.1.4.1.05', 'Postes, Torres y Accesorios  - MT', NULL, 1, 5.00, 20, 'Postes, Torres y Accesorios  - MT', NULL),
	(6, 1, '1.2.3.1.4.1.06', 'Conductores Aereos y Accesorioe - MT', NULL, 1, NULL, NULL, 'Conductores Aereos y Accesorioe - MT', NULL),
	(7, 1, '1.2.3.1.4.1.09', 'Transformadores de linea - MT', NULL, 1, NULL, NULL, 'Transformadores de linea - MT', NULL),
	(8, 1, '1.2.3.1.4.1.10', 'Bienes de Supervisión y Cont. Otros - MT', NULL, 1, NULL, NULL, 'Bienes de Supervisión y Cont. Otros - MT', NULL),
	(9, 1, '1.2.3.1.4.2.10', 'Otros Equipos Generales Media Tensión', NULL, 1, NULL, NULL, 'Otros Equipos Generales Media Tensión', NULL),
	(10, 2, '1.2.3.1.5.1.05', 'Posters, Torres y Accesorios - BT', NULL, 1, NULL, NULL, 'Posters, Torres y Accesorios - BT', NULL),
	(11, 2, '1.2.3.1.5.1.06', 'Conductores Aereso y Accesorios - BT', NULL, 1, NULL, NULL, 'Conductores Aereso y Accesorios - BT', NULL),
	(12, NULL, '1.2.3.1.5.1.10', 'Acometidas y Accesorios', NULL, 1, NULL, NULL, 'Acometidas y Accesorios', NULL),
	(13, 2, '1.2.3.1.5.1.11', 'Medidores - BT', NULL, 1, NULL, NULL, 'Medidores - BT', NULL),
	(14, NULL, '1.2.3.1.5.1.12', 'Alumbrado Público y Señalización', NULL, 1, NULL, NULL, 'Alumbrado Público y Señalización', NULL),
	(15, 2, '1.2.3.1.5.1.14', 'Bienes de Supervisión y Control - BT', NULL, 1, NULL, NULL, 'Bienes de Supervisión y Control - BT', NULL),
	(16, NULL, '1.2.3.1.5.2.01', 'Terrenos - PG', NULL, 1, NULL, NULL, 'Terrenos - PG', NULL),
	(17, NULL, '1.2.3.1.5.2.02', 'Edificios, Estructuras y Mejoras', NULL, 1, NULL, NULL, 'Edificios, Estructuras y Mejoras', NULL),
	(18, NULL, '1.2.3.1.5.2.03', 'Mobiliario y Equipo de Oficina', NULL, 1, NULL, NULL, 'Mobiliario y Equipo de Oficina', NULL),
	(19, NULL, '1.2.3.1.5.2.04', 'Equipo de Transporte', NULL, 1, NULL, NULL, 'Equipo de Transporte', NULL),
	(20, NULL, '1.2.3.1.5.2.05', 'Equipo de Almacenes', NULL, 1, NULL, NULL, 'Equipo de Almacenes', NULL),
	(21, NULL, '1.2.3.1.5.2.06', 'Herramientas, Equipo de Taller y Garaje', NULL, 1, NULL, NULL, 'Herramientas, Equipo de Taller y Garaje', NULL),
	(22, NULL, '1.2.3.1.5.2.07', 'Equipo de Laboratorio', NULL, 1, NULL, NULL, 'Equipo de Laboratorio', NULL),
	(23, NULL, '1.2.3.1.5.2.09', 'Equipo de Comunicaciones', NULL, 1, NULL, NULL, 'Equipo de Comunicaciones', NULL),
	(24, NULL, '1.2.3.1.5.2.10', 'Otros Equipos Generales', NULL, 1, NULL, NULL, 'Otros Equipos Generales', NULL),
	(25, NULL, '1.2.3.1.5.2.12', 'Equipos de Computación', 'ECM', 1, NULL, NULL, 'Equipos de Computación', NULL),
	(26, NULL, '1.2.3.1.5.2.13', 'Software', NULL, 1, NULL, NULL, 'Software', NULL),
	(27, NULL, '1.2.3.3.1.4.01', 'Terrenos - GE', NULL, 1, NULL, NULL, 'Terrenos - GE', NULL),
	(28, NULL, '1.2.3.3.1.4.02', 'Edificios Estructuras y Mejoras - GE', NULL, 1, NULL, NULL, 'Edificios Estructuras y Mejoras - GE', NULL),
	(29, NULL, '1.2.3.3.1.4.03', 'Despositos de Combustible y Accesorios - GE', NULL, 1, NULL, NULL, 'Despositos de Combustible y Accesorios - GE', NULL),
	(30, NULL, '1.2.3.3.1.4.04', 'Motores y Turbinas - GE', NULL, 1, NULL, NULL, 'Motores y Turbinas - GE', NULL),
	(31, NULL, '1.2.3.3.1.4.06', 'Equipos Electricos y Accesorios - GE', NULL, 1, NULL, NULL, 'Equipos Electricos y Accesorios - GE', NULL),
	(32, NULL, '1.2.3.3.1.4.07', 'Equipos Varios de la Central', NULL, 1, NULL, NULL, 'Equipos Varios de la Central', NULL);
/*!40000 ALTER TABLE `activos_catalogo_cuenta` ENABLE KEYS */;

-- Volcando estructura para tabla erp_atocha.activos_catalogo_empresa
CREATE TABLE IF NOT EXISTS `activos_catalogo_empresa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `abreviatura` varchar(45) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_atocha.activos_catalogo_empresa: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `activos_catalogo_empresa` DISABLE KEYS */;
INSERT INTO `activos_catalogo_empresa` (`id`, `nombre`, `direccion`, `telefono`, `abreviatura`, `descripcion`, `estado`) VALUES
	(3, 'COSEAL', 'DIrección X', '22785321', 'CA', 'testxxxx', 'Activo');
/*!40000 ALTER TABLE `activos_catalogo_empresa` ENABLE KEYS */;

-- Volcando estructura para tabla erp_atocha.activos_catalogo_grupo
CREATE TABLE IF NOT EXISTS `activos_catalogo_grupo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_servicio` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_activos_catalogo_grupo_activos_catalogo_servicio1_idx` (`id_servicio`),
  CONSTRAINT `fk_activos_catalogo_grupo_activos_catalogo_servicio1` FOREIGN KEY (`id_servicio`) REFERENCES `activos_catalogo_servicio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_atocha.activos_catalogo_grupo: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `activos_catalogo_grupo` DISABLE KEYS */;
INSERT INTO `activos_catalogo_grupo` (`id`, `id_servicio`, `nombre`, `descripcion`, `estado`) VALUES
	(1, 1, 'Distribución de Media Tensión', 'Distribución de Media Tensión', 'Activo'),
	(2, 1, 'Distribución de Baja Tensión', 'Distribución de Baja Tensión', 'Activo'),
	(3, 1, 'Propiedad General', 'Propiedad General', 'Activo'),
	(4, 1, 'Generación', 'Generación', 'Inactivo'),
	(5, 1, 'Propiedad General Media Tensión', 'Propiedad General Media Tensión', 'Inactivo'),
	(6, 3, 'Distribución de Alta Tensióna', 'Distribución de Alta Tensióna', 'Inactivo');
/*!40000 ALTER TABLE `activos_catalogo_grupo` ENABLE KEYS */;

-- Volcando estructura para tabla erp_atocha.activos_catalogo_lugar
CREATE TABLE IF NOT EXISTS `activos_catalogo_lugar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_atocha.activos_catalogo_lugar: ~13 rows (aproximadamente)
/*!40000 ALTER TABLE `activos_catalogo_lugar` DISABLE KEYS */;
INSERT INTO `activos_catalogo_lugar` (`id`, `nombre`, `descripcion`, `estado`) VALUES
	(1, 'Oficina Central Planta Baja', 'Oficina Central Planta Baja', 'Activo'),
	(2, 'Oficina Central Planta Alta', 'Oficina Central Planta Alta', 'Activo'),
	(3, 'Planta Técnica', 'Planta Técnica', 'Activo'),
	(4, 'Red de Distribución Energía Eléctrica', 'Red de Distribución Energía Eléctrica', 'Activo'),
	(5, 'Propiedad en Chajrahuasi', 'Propiedad en Chajrahuasi', 'Activo'),
	(6, 'Choroma', 'Choroma', 'Activo'),
	(7, 'Propiedad La Posta', 'Propiedad La Posta', 'Activo'),
	(8, 'Planta de Tv-Cable', 'Planta de Tv-Cable', 'Activo'),
	(9, 'Oploca', 'Oploca', 'Activo'),
	(10, 'Transportes', 'Transportes', 'Activo'),
	(11, 'Predio II V. Bethania', 'Predio II V. Bethania', 'Activo'),
	(12, 'Edificio Plaza Independencia', 'Edificio Plaza Independencia', 'Activo'),
	(13, 'Planta Técnica V.B.', 'Planta Técnica V.B.', 'Activo');
/*!40000 ALTER TABLE `activos_catalogo_lugar` ENABLE KEYS */;

-- Volcando estructura para tabla erp_atocha.activos_catalogo_responsable
CREATE TABLE IF NOT EXISTS `activos_catalogo_responsable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) DEFAULT NULL,
  `id_tipo_responsable` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ci` varchar(45) DEFAULT NULL,
  `cargo` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_activos_responsable_activos_catalogo_tipo_responsable1_idx` (`id_tipo_responsable`),
  KEY `fk_activos_responsable_activos_catalogo_empresa1_idx` (`id_empresa`),
  CONSTRAINT `fk_activos_responsable_activos_catalogo_empresa1` FOREIGN KEY (`id_empresa`) REFERENCES `activos_catalogo_empresa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_activos_responsable_activos_catalogo_tipo_responsable1` FOREIGN KEY (`id_tipo_responsable`) REFERENCES `activos_catalogo_tipo_responsable` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_atocha.activos_catalogo_responsable: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `activos_catalogo_responsable` DISABLE KEYS */;
INSERT INTO `activos_catalogo_responsable` (`id`, `id_empresa`, `id_tipo_responsable`, `nombre`, `ci`, `cargo`, `descripcion`, `estado`) VALUES
	(1, 3, 1, 'COSEAL', '1', 'Acometidas', 'asdasda', 'Activo');
/*!40000 ALTER TABLE `activos_catalogo_responsable` ENABLE KEYS */;

-- Volcando estructura para tabla erp_atocha.activos_catalogo_servicio
CREATE TABLE IF NOT EXISTS `activos_catalogo_servicio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_atocha.activos_catalogo_servicio: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `activos_catalogo_servicio` DISABLE KEYS */;
INSERT INTO `activos_catalogo_servicio` (`id`, `nombre`, `descripcion`, `estado`) VALUES
	(1, 'Energía Eléctrica', 'Energía Eléctrica', 'Activo'),
	(3, 'Internet', 'Internet', 'Activo'),
	(4, 'Biblioteca', 'Biblioteca', 'Activo'),
	(5, 'TV - Cable', 'TV - Cable', 'Inactivo'),
	(6, 'XXX', '', 'Activo'),
	(7, 'asdasd', '', '');
/*!40000 ALTER TABLE `activos_catalogo_servicio` ENABLE KEYS */;

-- Volcando estructura para tabla erp_atocha.activos_catalogo_tipo_responsable
CREATE TABLE IF NOT EXISTS `activos_catalogo_tipo_responsable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_atocha.activos_catalogo_tipo_responsable: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `activos_catalogo_tipo_responsable` DISABLE KEYS */;
INSERT INTO `activos_catalogo_tipo_responsable` (`id`, `nombre`, `descripcion`, `estado`) VALUES
	(1, 'Tipo A', 'Tipo A', 'Inactivo'),
	(2, 'Tipo B', 'Tipo B', 'Inactivo');
/*!40000 ALTER TABLE `activos_catalogo_tipo_responsable` ENABLE KEYS */;

-- Volcando estructura para tabla erp_atocha.activos_catalogo_ubicacion
CREATE TABLE IF NOT EXISTS `activos_catalogo_ubicacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_lugar` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_activos_catalogo_ubicacion_activos_catalogo_lugar1_idx` (`id_lugar`),
  CONSTRAINT `fk_activos_catalogo_ubicacion_activos_catalogo_lugar1` FOREIGN KEY (`id_lugar`) REFERENCES `activos_catalogo_lugar` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_atocha.activos_catalogo_ubicacion: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `activos_catalogo_ubicacion` DISABLE KEYS */;
INSERT INTO `activos_catalogo_ubicacion` (`id`, `id_lugar`, `nombre`, `descripcion`, `estado`) VALUES
	(1, 2, 'Arch1', 'Archivo Contable y Secretaria Planta Alta', 'Activo'),
	(2, 2, 'Archi', 'Archivo Activos Planta Alta', 'Activo'),
	(3, 2, 'B', 'Biblioteca CD', 'Activo'),
	(4, 2, 'BBLI', 'Biblioteca Juegos', 'Activo'),
	(5, 2, 'BI', 'Biblioteca Videos', 'Activo'),
	(6, 2, 'BIB', 'Bibliote Libros', 'Activo');
/*!40000 ALTER TABLE `activos_catalogo_ubicacion` ENABLE KEYS */;

-- Volcando estructura para tabla erp_atocha.activos_catalogo_ufv
CREATE TABLE IF NOT EXISTS `activos_catalogo_ufv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `valor` decimal(6,5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_atocha.activos_catalogo_ufv: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `activos_catalogo_ufv` DISABLE KEYS */;
INSERT INTO `activos_catalogo_ufv` (`id`, `fecha`, `valor`) VALUES
	(1, '2016-12-31', 2.17259),
	(2, '2017-12-31', 2.23694),
	(4, '2018-12-31', 2.29076),
	(13, '2019-12-31', 2.33187),
	(14, '2020-03-31', 2.34086);
/*!40000 ALTER TABLE `activos_catalogo_ufv` ENABLE KEYS */;

-- Volcando estructura para tabla erp_atocha.activos_catalogo_unidad
CREATE TABLE IF NOT EXISTS `activos_catalogo_unidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_atocha.activos_catalogo_unidad: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `activos_catalogo_unidad` DISABLE KEYS */;
INSERT INTO `activos_catalogo_unidad` (`id`, `nombre`, `descripcion`, `estado`) VALUES
	(1, 'PZA', 'PIEZA', 'Activo');
/*!40000 ALTER TABLE `activos_catalogo_unidad` ENABLE KEYS */;

-- Volcando estructura para tabla erp_atocha.activos_depreciacion
CREATE TABLE IF NOT EXISTS `activos_depreciacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_activo` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `valor_inicial` decimal(16,2) DEFAULT NULL,
  `id_ufv` int(11) DEFAULT NULL,
  `factor` decimal(8,7) DEFAULT NULL,
  `incremento_actualizacion` decimal(16,2) DEFAULT NULL,
  `valor_actualizado` decimal(16,2) DEFAULT NULL,
  `depreciacion_acumulada` decimal(16,2) DEFAULT NULL,
  `aitb_depreciacion_acumulada` decimal(16,2) DEFAULT NULL,
  `depreciacion_ejercicio` decimal(16,2) DEFAULT NULL,
  `depreciacion_acumulada_actualizada` decimal(16,2) DEFAULT NULL,
  `valor_neto` decimal(16,2) DEFAULT NULL,
  `meses_vida_util` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_activos_depreciacion_activos_registro1_idx` (`id_activo`),
  KEY `fk_activos_depreciacion_activos_catalogo_ufv1_idx` (`id_ufv`),
  CONSTRAINT `fk_activos_depreciacion_activos_catalogo_ufv1` FOREIGN KEY (`id_ufv`) REFERENCES `activos_catalogo_ufv` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_activos_depreciacion_activos_registro1` FOREIGN KEY (`id_activo`) REFERENCES `activos_registro` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_atocha.activos_depreciacion: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `activos_depreciacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `activos_depreciacion` ENABLE KEYS */;

-- Volcando estructura para tabla erp_atocha.activos_registro
CREATE TABLE IF NOT EXISTS `activos_registro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cuenta` int(11) DEFAULT NULL,
  `id_responsable` int(11) DEFAULT NULL,
  `id_ubicacion` int(11) DEFAULT NULL,
  `id_unidad` int(11) DEFAULT NULL,
  `id_articulo_almacen` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` enum('Activo','Retirado') DEFAULT NULL,
  `cantidad` decimal(16,2) DEFAULT NULL,
  `fecha_alta` date DEFAULT NULL,
  `ufv_inicial` decimal(7,6) DEFAULT NULL,
  `costo` decimal(16,2) DEFAULT NULL,
  `codigo_activo` varchar(45) DEFAULT NULL,
  `fecha_registro_almacen` date DEFAULT NULL,
  `fecha_depreciacion` date DEFAULT NULL,
  `valor_actualizado` decimal(16,2) DEFAULT NULL,
  `depreciacion_acumulada` decimal(16,2) DEFAULT NULL,
  `valor_neto` varchar(45) DEFAULT NULL,
  `vida_util` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_activos_registro_activos_catalogo_ubicacion1_idx` (`id_ubicacion`),
  KEY `fk_activos_registro_activos_catalogo_cuenta1_idx` (`id_cuenta`),
  KEY `fk_activos_registro_activos_catalogo_unidad1_idx` (`id_unidad`),
  KEY `fk_activos_registro_activos_responsable1_idx` (`id_responsable`),
  KEY `fk_activos_registro_almacen_movimiento1_idx` (`id_articulo_almacen`),
  CONSTRAINT `fk_activos_registro_activos_catalogo_cuenta1` FOREIGN KEY (`id_cuenta`) REFERENCES `activos_catalogo_cuenta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_activos_registro_activos_catalogo_ubicacion1` FOREIGN KEY (`id_ubicacion`) REFERENCES `activos_catalogo_ubicacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_activos_registro_activos_catalogo_unidad1` FOREIGN KEY (`id_unidad`) REFERENCES `activos_catalogo_unidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_activos_registro_activos_responsable1` FOREIGN KEY (`id_responsable`) REFERENCES `activos_catalogo_responsable` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_activos_registro_almacen_movimiento1` FOREIGN KEY (`id_articulo_almacen`) REFERENCES `almacen_movimiento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_atocha.activos_registro: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `activos_registro` DISABLE KEYS */;
INSERT INTO `activos_registro` (`id`, `id_cuenta`, `id_responsable`, `id_ubicacion`, `id_unidad`, `id_articulo_almacen`, `descripcion`, `estado`, `cantidad`, `fecha_alta`, `ufv_inicial`, `costo`, `codigo_activo`, `fecha_registro_almacen`, `fecha_depreciacion`, `valor_actualizado`, `depreciacion_acumulada`, `valor_neto`, `vida_util`) VALUES
	(1, 1, 1, 1, 1, 12, 'asd', 'Activo', 1.00, '2016-04-01', 2.147620, 30276.00, 'AC-MN-PS-01', '2016-04-01', '2020-03-31', 30276.00, 0.00, '1', 48),
	(15, 1, 1, 1, 1, 12, 'asd', 'Activo', 1.00, '2016-04-01', 2.147620, 30276.00, 'AC-MN-PS-02', '2016-04-01', '2020-03-31', 30276.00, 0.00, '1', 48);
/*!40000 ALTER TABLE `activos_registro` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
