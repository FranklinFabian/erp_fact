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

-- Volcando estructura para tabla erp_atocha.caja_chica_catalogo_cuenta
CREATE TABLE IF NOT EXISTS `caja_chica_catalogo_cuenta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_atocha.caja_chica_catalogo_cuenta: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `caja_chica_catalogo_cuenta` DISABLE KEYS */;
INSERT INTO `caja_chica_catalogo_cuenta` (`id`, `codigo`, `nombre`, `descripcion`) VALUES
	(1, 'CO-1', 'Cuenta 1', 'Cuenta 1'),
	(2, 'CO-2', 'Cuenta 2', 'Cuenta 2'),
	(3, 'CO-3', 'Cuenta 3', 'Cuenta 3'),
	(4, 'CO-4', 'Cuenta 4', 'Cuenta 4'),
	(7, 'ddd', 'ddd', 'dddd');
/*!40000 ALTER TABLE `caja_chica_catalogo_cuenta` ENABLE KEYS */;

-- Volcando estructura para tabla erp_atocha.caja_chica_catalogo_solicitante
CREATE TABLE IF NOT EXISTS `caja_chica_catalogo_solicitante` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `cargo` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_atocha.caja_chica_catalogo_solicitante: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `caja_chica_catalogo_solicitante` DISABLE KEYS */;
INSERT INTO `caja_chica_catalogo_solicitante` (`id`, `nombre`, `cargo`, `descripcion`) VALUES
	(1, 'Juan Perez', 'Tecnico I', 'Tecnico I'),
	(2, 'Jose Sanchez', 'Tecnico II', 'Tecnico II'),
	(3, 'Raul Beltran', 'Profesional I', 'Profesional I'),
	(4, 'Rene Soria', 'Profesional II', 'Profesional II'),
	(5, 'Jose Blanco', 'Profesional III', 'Profesional III');
/*!40000 ALTER TABLE `caja_chica_catalogo_solicitante` ENABLE KEYS */;

-- Volcando estructura para tabla erp_atocha.caja_chica_configuracion
CREATE TABLE IF NOT EXISTS `caja_chica_configuracion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `monto_maximo` decimal(16,2) DEFAULT NULL,
  `porcentaje_minimo` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_atocha.caja_chica_configuracion: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `caja_chica_configuracion` DISABLE KEYS */;
INSERT INTO `caja_chica_configuracion` (`id`, `monto_maximo`, `porcentaje_minimo`, `descripcion`) VALUES
	(1, 5000.10, 75, 'Monto Configurado por la empresa');
/*!40000 ALTER TABLE `caja_chica_configuracion` ENABLE KEYS */;

-- Volcando estructura para tabla erp_atocha.caja_chica_registro
CREATE TABLE IF NOT EXISTS `caja_chica_registro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `id_cuenta` int(11) DEFAULT NULL,
  `id_solicitante` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `monto` decimal(16,2) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_caja_chica_catalogo_registro_caja_chica_catalogo_cuenta1_idx` (`id_cuenta`),
  KEY `fk_caja_chica_catalogo_registro_caja_chica_catalogo_solicit_idx` (`id_solicitante`),
  CONSTRAINT `fk_caja_chica_catalogo_registro_caja_chica_catalogo_cuenta1` FOREIGN KEY (`id_cuenta`) REFERENCES `caja_chica_catalogo_cuenta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_caja_chica_catalogo_registro_caja_chica_catalogo_solicitan1` FOREIGN KEY (`id_solicitante`) REFERENCES `caja_chica_catalogo_solicitante` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_atocha.caja_chica_registro: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `caja_chica_registro` DISABLE KEYS */;
INSERT INTO `caja_chica_registro` (`id`, `id_usuario`, `id_cuenta`, `id_solicitante`, `fecha`, `monto`, `descripcion`) VALUES
	(4, 1, 1, 4, '2021-08-28', 666.67, 'Teclado Inalambricoxxx'),
	(5, 1, 3, 4, '2021-09-28', 885.00, 'Gastos Alimentacion');
/*!40000 ALTER TABLE `caja_chica_registro` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
