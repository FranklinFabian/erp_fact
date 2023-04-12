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

-- Volcando estructura para tabla erp_atocha.ga_asistencia
CREATE TABLE IF NOT EXISTS `ga_asistencia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) DEFAULT NULL,
  `id_evento` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ga_asistencia_ga_cliente1_idx` (`id_cliente`),
  KEY `fk_ga_asistencia_ga_evento1_idx` (`id_evento`),
  CONSTRAINT `fk_ga_asistencia_ga_cliente1` FOREIGN KEY (`id_cliente`) REFERENCES `ga_cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ga_asistencia_ga_evento1` FOREIGN KEY (`id_evento`) REFERENCES `ga_evento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_atocha.ga_asistencia: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `ga_asistencia` DISABLE KEYS */;
/*!40000 ALTER TABLE `ga_asistencia` ENABLE KEYS */;

-- Volcando estructura para tabla erp_atocha.ga_certificado
CREATE TABLE IF NOT EXISTS `ga_certificado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(100) DEFAULT NULL,
  `id_suscripcion` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `estado` enum('Generado','Entregado','Anulado') DEFAULT NULL,
  `fecha_entrega` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ga_certificado_ga_suscripcion1_idx` (`id_suscripcion`),
  CONSTRAINT `fk_ga_certificado_ga_suscripcion1` FOREIGN KEY (`id_suscripcion`) REFERENCES `ga_suscripcion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_atocha.ga_certificado: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `ga_certificado` DISABLE KEYS */;
/*!40000 ALTER TABLE `ga_certificado` ENABLE KEYS */;

-- Volcando estructura para tabla erp_atocha.ga_cliente
CREATE TABLE IF NOT EXISTS `ga_cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(100) DEFAULT NULL,
  `ci` varchar(45) DEFAULT NULL,
  `id_expedido` int(11) DEFAULT NULL,
  `razon_social` varchar(255) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `genero` enum('Masculino','Femenino') DEFAULT NULL,
  `nit` varchar(45) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `id_profesion` int(11) DEFAULT NULL,
  `id_ocupacion` int(11) DEFAULT NULL,
  `id_nivel_educacion` int(11) DEFAULT NULL,
  `numero_dependientes` int(11) DEFAULT NULL,
  `id_estado_civil` int(11) DEFAULT NULL,
  `estado_cliente` enum('Pendiente','Aprobado','Anulado') DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `tipo_socio` enum('Pendiente','Nuevo','Transferido') DEFAULT NULL,
  `codigo_socio` varchar(100) DEFAULT NULL,
  `fecha_socio` date DEFAULT NULL,
  `fotografia` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cliente_profesion1_idx` (`id_profesion`),
  KEY `fk_cliente_ocupacion1_idx` (`id_ocupacion`),
  KEY `fk_cliente_nivel_educacion1_idx` (`id_nivel_educacion`),
  KEY `fk_ga_cliente_ga_estado_civil1_idx` (`id_estado_civil`),
  KEY `fk_ga_cliente_ga_departamento1_idx` (`id_expedido`),
  CONSTRAINT `fk_cliente_nivel_educacion1` FOREIGN KEY (`id_nivel_educacion`) REFERENCES `ga_nivel_educacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cliente_ocupacion1` FOREIGN KEY (`id_ocupacion`) REFERENCES `ga_ocupacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cliente_profesion1` FOREIGN KEY (`id_profesion`) REFERENCES `ga_profesion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ga_cliente_ga_departamento1` FOREIGN KEY (`id_expedido`) REFERENCES `ga_departamento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ga_cliente_ga_estado_civil1` FOREIGN KEY (`id_estado_civil`) REFERENCES `ga_estado_civil` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_atocha.ga_cliente: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `ga_cliente` DISABLE KEYS */;
/*!40000 ALTER TABLE `ga_cliente` ENABLE KEYS */;

-- Volcando estructura para tabla erp_atocha.ga_correlativo
CREATE TABLE IF NOT EXISTS `ga_correlativo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `formato` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_atocha.ga_correlativo: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `ga_correlativo` DISABLE KEYS */;
INSERT INTO `ga_correlativo` (`id`, `nombre`, `numero`, `formato`) VALUES
	(1, 'cliente', 1, 'CL-'),
	(2, 'suscripcion', 1, 'SU-'),
	(3, 'pago', 1, 'PA-'),
	(4, 'socio', 1, 'SO-'),
	(5, 'certificado', 1, 'CE-');
/*!40000 ALTER TABLE `ga_correlativo` ENABLE KEYS */;

-- Volcando estructura para tabla erp_atocha.ga_departamento
CREATE TABLE IF NOT EXISTS `ga_departamento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_atocha.ga_departamento: ~9 rows (aproximadamente)
/*!40000 ALTER TABLE `ga_departamento` DISABLE KEYS */;
INSERT INTO `ga_departamento` (`id`, `nombre`, `descripcion`) VALUES
	(1, 'Chuquisaca', NULL),
	(2, 'La Paz', 'La Paz'),
	(3, 'Cochabamba', NULL),
	(4, 'Oruro', NULL),
	(5, 'Potosí', NULL),
	(6, 'Tarija', ''),
	(7, 'Santa Cruz', NULL),
	(8, 'Beni', NULL),
	(9, 'Pando', NULL);
/*!40000 ALTER TABLE `ga_departamento` ENABLE KEYS */;

-- Volcando estructura para tabla erp_atocha.ga_estado_civil
CREATE TABLE IF NOT EXISTS `ga_estado_civil` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_atocha.ga_estado_civil: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `ga_estado_civil` DISABLE KEYS */;
INSERT INTO `ga_estado_civil` (`id`, `nombre`, `descripcion`) VALUES
	(1, 'Soltero', 'Soltero'),
	(2, 'Casado', 'Casado'),
	(3, 'Divorciado', 'Divorciado');
/*!40000 ALTER TABLE `ga_estado_civil` ENABLE KEYS */;

-- Volcando estructura para tabla erp_atocha.ga_evento
CREATE TABLE IF NOT EXISTS `ga_evento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_atocha.ga_evento: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `ga_evento` DISABLE KEYS */;
/*!40000 ALTER TABLE `ga_evento` ENABLE KEYS */;

-- Volcando estructura para tabla erp_atocha.ga_historial_transferencia
CREATE TABLE IF NOT EXISTS `ga_historial_transferencia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_socio_origen` int(11) DEFAULT NULL,
  `id_socio_destino` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `id_certificado_anulado` int(11) DEFAULT NULL,
  `id_certificado_nuevo` int(11) DEFAULT NULL,
  `motivo` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ga_historial_transferencia_ga_cliente1_idx` (`id_socio_origen`),
  KEY `fk_ga_historial_transferencia_ga_cliente2_idx` (`id_socio_destino`),
  KEY `fk_ga_historial_transferencia_ga_certificado1_idx` (`id_certificado_anulado`),
  KEY `fk_ga_historial_transferencia_ga_certificado2_idx` (`id_certificado_nuevo`),
  CONSTRAINT `fk_ga_historial_transferencia_ga_certificado1` FOREIGN KEY (`id_certificado_anulado`) REFERENCES `ga_certificado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ga_historial_transferencia_ga_certificado2` FOREIGN KEY (`id_certificado_nuevo`) REFERENCES `ga_certificado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ga_historial_transferencia_ga_cliente10` FOREIGN KEY (`id_socio_origen`) REFERENCES `ga_cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ga_historial_transferencia_ga_cliente20` FOREIGN KEY (`id_socio_destino`) REFERENCES `ga_cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_atocha.ga_historial_transferencia: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `ga_historial_transferencia` DISABLE KEYS */;
/*!40000 ALTER TABLE `ga_historial_transferencia` ENABLE KEYS */;

-- Volcando estructura para tabla erp_atocha.ga_nivel_educacion
CREATE TABLE IF NOT EXISTS `ga_nivel_educacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_atocha.ga_nivel_educacion: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `ga_nivel_educacion` DISABLE KEYS */;
INSERT INTO `ga_nivel_educacion` (`id`, `nombre`, `descripcion`) VALUES
	(1, 'Primaria', 'Nivel Primario'),
	(2, 'Secundaria', 'Nivel Secundario'),
	(3, 'Tecnico Medio', 'Nivel Tecnico Medio'),
	(4, 'Tecnico Superior', 'Nivel Tecnico Superior'),
	(5, 'Licenciatura', 'Nivel Licenciatura'),
	(6, 'Maestria', 'Nivel Master');
/*!40000 ALTER TABLE `ga_nivel_educacion` ENABLE KEYS */;

-- Volcando estructura para tabla erp_atocha.ga_ocupacion
CREATE TABLE IF NOT EXISTS `ga_ocupacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_atocha.ga_ocupacion: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `ga_ocupacion` DISABLE KEYS */;
INSERT INTO `ga_ocupacion` (`id`, `nombre`, `descripcion`) VALUES
	(1, 'Albañil', 'Albañil'),
	(2, 'Chofer', 'Chofer'),
	(3, 'Comerciantes', 'Comerciantes');
/*!40000 ALTER TABLE `ga_ocupacion` ENABLE KEYS */;

-- Volcando estructura para tabla erp_atocha.ga_pago
CREATE TABLE IF NOT EXISTS `ga_pago` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(100) DEFAULT NULL,
  `id_suscripcion` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `importe_pagado` decimal(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ga_pago_ga_suscripcion1_idx` (`id_suscripcion`),
  CONSTRAINT `fk_ga_pago_ga_suscripcion1` FOREIGN KEY (`id_suscripcion`) REFERENCES `ga_suscripcion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_atocha.ga_pago: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `ga_pago` DISABLE KEYS */;
/*!40000 ALTER TABLE `ga_pago` ENABLE KEYS */;

-- Volcando estructura para tabla erp_atocha.ga_profesion
CREATE TABLE IF NOT EXISTS `ga_profesion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_atocha.ga_profesion: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `ga_profesion` DISABLE KEYS */;
INSERT INTO `ga_profesion` (`id`, `nombre`, `descripcion`) VALUES
	(1, 'Ingeniero de Sistemas', 'Ingeniero de Sistemas'),
	(2, 'Profesor', 'Profesor'),
	(3, 'Abogado', 'Abogado'),
	(4, 'Medico', 'Medico');
/*!40000 ALTER TABLE `ga_profesion` ENABLE KEYS */;

-- Volcando estructura para tabla erp_atocha.ga_suscripcion
CREATE TABLE IF NOT EXISTS `ga_suscripcion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(100) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `costo` decimal(16,2) DEFAULT NULL,
  `nota` text DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `tipo` enum('Nueva','Transferida') DEFAULT NULL,
  `pagada` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ga_certificado_ga_cliente1_idx` (`id_cliente`),
  CONSTRAINT `fk_ga_certificado_ga_cliente1` FOREIGN KEY (`id_cliente`) REFERENCES `ga_cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_atocha.ga_suscripcion: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `ga_suscripcion` DISABLE KEYS */;
/*!40000 ALTER TABLE `ga_suscripcion` ENABLE KEYS */;

-- Volcando estructura para tabla erp_atocha.ga_valor_certificado
CREATE TABLE IF NOT EXISTS `ga_valor_certificado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `monto` decimal(16,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla erp_atocha.ga_valor_certificado: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `ga_valor_certificado` DISABLE KEYS */;
INSERT INTO `ga_valor_certificado` (`id`, `monto`) VALUES
	(1, 720.00);
/*!40000 ALTER TABLE `ga_valor_certificado` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
