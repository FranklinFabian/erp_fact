-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 24-01-2023 a las 15:56:05
-- Versión del servidor: 5.7.40
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `facturacion_cobranzas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_abonados`
--

DROP TABLE IF EXISTS `fact_abonados`;
CREATE TABLE IF NOT EXISTS `fact_abonados` (
  `idabonado` int(11) NOT NULL AUTO_INCREMENT,
  `fase` varchar(3) COLLATE utf8_spanish_ci DEFAULT NULL,
  `numero` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `descripcion` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `medidor` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `capacidad` int(11) DEFAULT NULL,
  `indiceinicial` int(11) DEFAULT NULL,
  `mulmed` int(11) DEFAULT NULL,
  `encorte` tinyint(4) DEFAULT '0',
  `instalacion` date DEFAULT NULL,
  `corte` date DEFAULT NULL,
  `reposicion` date DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `usuario` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `idposte` int(11) NOT NULL,
  `idcalle` int(11) NOT NULL,
  `idcategoria` int(11) NOT NULL,
  `idestado` int(11) NOT NULL,
  `idliberacion` int(11) NOT NULL,
  `idsuministro` int(11) NOT NULL,
  `idconsumidor` int(11) NOT NULL,
  `idmedicion` int(11) NOT NULL,
  `idservicio` int(11) DEFAULT NULL,
  `idcentro` int(11) NOT NULL,
  `fecha_registro_abonado` date DEFAULT NULL,
  `abonado` int(11) DEFAULT NULL,
  `bloqueo` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechainsta` date DEFAULT NULL,
  `fechacorte` date DEFAULT NULL,
  `fecharepos` date DEFAULT NULL,
  `idpropiedad` int(11) DEFAULT NULL,
  `createAT` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idabonado`),
  KEY `fk_abonados_cliente1_idx` (`idcliente`),
  KEY `fk_abonados_postes1_idx` (`idposte`),
  KEY `fk_abonados_calles1_idx` (`idcalle`),
  KEY `fk_abonados_categorias1_idx` (`idcategoria`),
  KEY `fk_abonados_estados1_idx` (`idestado`),
  KEY `fk_abonados_liberaciones1_idx` (`idliberacion`),
  KEY `fk_abonados_suministros1_idx` (`idsuministro`),
  KEY `fk_abonados_consumidores1_idx` (`idconsumidor`),
  KEY `fk_abonados_mediciones1_idx` (`idmedicion`),
  KEY `fk_abonados_servicios1_idx` (`idservicio`),
  KEY `fk_abonados_centros1_idx` (`idcentro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad`
--

DROP TABLE IF EXISTS `fact_actividad`;
CREATE TABLE IF NOT EXISTS `fact_actividad` (
  `id_actividad` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_caeb` int(11) NOT NULL,
  `descripcion` varchar(75) COLLATE utf8_spanish_ci NOT NULL,
  `tipo_actividad` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_actividad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_adquisicion_producto`
--

DROP TABLE IF EXISTS `fact_adquisicion_producto`;
CREATE TABLE IF NOT EXISTS `fact_adquisicion_producto` (
  `id_adquisicion_producto` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` tinyint(4) DEFAULT NULL,
  `id_nro_adquisicion` int(11) DEFAULT NULL,
  `id_salida` int(11) DEFAULT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad_ingreso` float(10,2) DEFAULT NULL,
  `cantidad_existente_adquisicion` float(10,2) DEFAULT NULL,
  `precio_adquisicion` float(10,2) DEFAULT NULL,
  `cantidad_salida` float(10,2) DEFAULT NULL,
  `saldo_fisico` float(10,2) DEFAULT NULL,
  `ingreso_valorado` float(10,2) DEFAULT NULL,
  `salida_valorado` float(10,2) DEFAULT NULL,
  `saldo_valorado` float(10,2) DEFAULT NULL,
  `n_ingreso` int(11) DEFAULT NULL,
  `n_salida` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_adquisicion_producto`),
  KEY `fk_adquisicion_producto_nro_adquisicion1_idx` (`id_nro_adquisicion`),
  KEY `fk_adquisicion_producto_producto1_idx` (`id_producto`),
  KEY `fk_adquisicion_producto_salida1_idx` (`id_salida`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_afectados`
--

DROP TABLE IF EXISTS `fact_afectados`;
CREATE TABLE IF NOT EXISTS `fact_afectados` (
  `idafectado` int(11) NOT NULL AUTO_INCREMENT,
  `idresolucion` int(11) NOT NULL,
  `idabonado` int(11) NOT NULL,
  `devuelto` float(7,2) DEFAULT NULL,
  `saldo` float(7,2) DEFAULT NULL,
  `usuario` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idafectado`),
  KEY `fk_afectados_resoluciones1_idx` (`idresolucion`),
  KEY `fk_afectados_abonados1_idx` (`idabonado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_alertas`
--

DROP TABLE IF EXISTS `fact_alertas`;
CREATE TABLE IF NOT EXISTS `fact_alertas` (
  `idalerta` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `nota` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `activo` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idabonado` int(11) NOT NULL,
  PRIMARY KEY (`idalerta`),
  KEY `fk_alertas_abonados1_idx` (`idabonado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_alimentadores`
--

DROP TABLE IF EXISTS `fact_alimentadores`;
CREATE TABLE IF NOT EXISTS `fact_alimentadores` (
  `idalimentador` int(11) NOT NULL AUTO_INCREMENT,
  `cod_alimentador` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `subestacion` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `kva_alimentador` int(11) DEFAULT NULL,
  `kv_alimentador` int(11) DEFAULT NULL,
  `consum_mt_1` int(11) DEFAULT NULL,
  `consum_mt_2` int(11) DEFAULT NULL,
  `consum_bt_1` int(11) DEFAULT NULL,
  `consum_bt_2` int(11) DEFAULT NULL,
  `cod_localidades` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`idalimentador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_autorizaciones`
--

DROP TABLE IF EXISTS `fact_autorizaciones`;
CREATE TABLE IF NOT EXISTS `fact_autorizaciones` (
  `idautorizacion` bigint(20) NOT NULL AUTO_INCREMENT,
  `llave` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_ini` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `numero_ini` int(11) DEFAULT NULL,
  `numero_fin` int(11) DEFAULT NULL,
  `leyenda` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `activado` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` int(11) DEFAULT NULL,
  `autorizacion` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idautorizacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_beneficiarios`
--

DROP TABLE IF EXISTS `fact_beneficiarios`;
CREATE TABLE IF NOT EXISTS `fact_beneficiarios` (
  `idbeneficiario` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `usuario` int(11) DEFAULT NULL,
  `iddirecto` int(11) NOT NULL,
  `idley1886` int(11) NOT NULL,
  `idabonado` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  PRIMARY KEY (`idbeneficiario`),
  KEY `fk_beneficiarios_directos1_idx` (`iddirecto`),
  KEY `fk_beneficiarios_ley18861_idx` (`idley1886`),
  KEY `fk_beneficiarios_abonados1_idx` (`idabonado`),
  KEY `fk_beneficiarios_cliente1_idx` (`idcliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_calles`
--

DROP TABLE IF EXISTS `fact_calles`;
CREATE TABLE IF NOT EXISTS `fact_calles` (
  `idcalle` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(5) COLLATE utf8_spanish_ci DEFAULT NULL,
  `calle` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` int(11) DEFAULT NULL,
  `idzona` int(11) NOT NULL,
  PRIMARY KEY (`idcalle`),
  KEY `fk_calles_zonas1_idx` (`idzona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_categoria`
--

DROP TABLE IF EXISTS `fact_categoria`;
CREATE TABLE IF NOT EXISTS `fact_categoria` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_categoria` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado_categoria` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_categorias`
--

DROP TABLE IF EXISTS `fact_categorias`;
CREATE TABLE IF NOT EXISTS `fact_categorias` (
  `idcategoria` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(2) COLLATE utf8_spanish_ci DEFAULT NULL,
  `categoria` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` int(11) NOT NULL,
  `idservicio` int(11) NOT NULL,
  `garantia` int(11) DEFAULT NULL,
  PRIMARY KEY (`idcategoria`),
  KEY `fk_categorias_servicios1_idx` (`idservicio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_centros`
--

DROP TABLE IF EXISTS `fact_centros`;
CREATE TABLE IF NOT EXISTS `fact_centros` (
  `idcentro` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `centro` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` int(11) NOT NULL,
  `idpropiedad` int(11) NOT NULL,
  `idlocalidad` int(11) NOT NULL,
  PRIMARY KEY (`idcentro`),
  KEY `fk_centros_propiedades1_idx` (`idpropiedad`),
  KEY `fk_centros_localidades1_idx` (`idlocalidad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_cliente`
--

DROP TABLE IF EXISTS `fact_cliente`;
CREATE TABLE IF NOT EXISTS `fact_cliente` (
  `idcliente` int(11) NOT NULL AUTO_INCREMENT,
  `correo` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ci` varchar(20) COLLATE utf8_spanish_ci DEFAULT '1',
  `nit` varchar(20) COLLATE utf8_spanish_ci DEFAULT '0',
  `razon_social` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nacimiento` date DEFAULT NULL,
  `telefono` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` int(11) NOT NULL,
  `documento` varchar(13) COLLATE utf8_spanish_ci DEFAULT NULL,
  `complemento` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ocupacion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `sexo` varchar(5) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cex` varchar(20) COLLATE utf8_spanish_ci DEFAULT '1',
  `pas` varchar(25) COLLATE utf8_spanish_ci DEFAULT '1',
  `od` varchar(25) COLLATE utf8_spanish_ci DEFAULT '1',
  `tipo_doc_fact` char(1) COLLATE utf8_spanish_ci DEFAULT '1',
  `campo` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idcliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_conexiones`
--

DROP TABLE IF EXISTS `fact_conexiones`;
CREATE TABLE IF NOT EXISTS `fact_conexiones` (
  `idconexion` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) DEFAULT NULL,
  `idservicio` int(11) NOT NULL,
  `idorden` int(11) NOT NULL,
  `nota` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `estado` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_final` datetime DEFAULT NULL,
  `tiempo_tramite` float(7,2) DEFAULT NULL,
  `empleado` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `entregado` int(11) DEFAULT NULL,
  `fentregado` datetime DEFAULT NULL,
  `pentregado` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `devuelto` int(11) DEFAULT NULL,
  `fdevuelto` datetime DEFAULT NULL,
  `usuario` int(11) DEFAULT NULL,
  `solicitante` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idconexion`),
  KEY `fk_conexiones_servicios1_idx` (`idservicio`),
  KEY `fk_conexiones_ordenes1_idx` (`idorden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_configuracion`
--

DROP TABLE IF EXISTS `fact_configuracion`;
CREATE TABLE IF NOT EXISTS `fact_configuracion` (
  `id_configuracion` int(11) NOT NULL AUTO_INCREMENT,
  `telefono` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `pie_impresion` varchar(75) COLLATE utf8_spanish_ci DEFAULT NULL,
  `whatsapp` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `logo_linea1` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `logo_linea2` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_configuracion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_consumidores`
--

DROP TABLE IF EXISTS `fact_consumidores`;
CREATE TABLE IF NOT EXISTS `fact_consumidores` (
  `idconsumidor` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `consumidor` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` int(11) NOT NULL,
  PRIMARY KEY (`idconsumidor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_controles`
--

DROP TABLE IF EXISTS `fact_controles`;
CREATE TABLE IF NOT EXISTS `fact_controles` (
  `idcontrol` int(11) NOT NULL AUTO_INCREMENT,
  `control` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` int(11) NOT NULL,
  PRIMARY KEY (`idcontrol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_cortes`
--

DROP TABLE IF EXISTS `fact_cortes`;
CREATE TABLE IF NOT EXISTS `fact_cortes` (
  `idcorte` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) DEFAULT NULL,
  `idservicio` int(11) NOT NULL,
  `idabonado` int(11) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `lista` int(11) DEFAULT NULL,
  `meses` int(11) DEFAULT NULL,
  `pagado` int(11) DEFAULT NULL,
  `fecha_final` datetime DEFAULT NULL,
  `lectura` int(11) DEFAULT NULL,
  `empleado` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nota` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `entregado` int(11) DEFAULT NULL,
  `fentrega` datetime DEFAULT NULL,
  `pentrega` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `devuelto` int(11) DEFAULT NULL,
  `fdevuelto` datetime DEFAULT NULL,
  `usuario` int(11) DEFAULT NULL,
  `tiempo_tramite` float(7,2) DEFAULT NULL,
  `solicitante` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idcorte`),
  KEY `fk_cortes_servicios1_idx` (`idservicio`),
  KEY `fk_cortes_abonados1_idx` (`idabonado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_costos`
--

DROP TABLE IF EXISTS `fact_costos`;
CREATE TABLE IF NOT EXISTS `fact_costos` (
  `idcosto` int(11) NOT NULL AUTO_INCREMENT,
  `idgestion` int(11) NOT NULL,
  `idperiodo` int(11) NOT NULL,
  `importe` float(7,2) DEFAULT NULL,
  `usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`idcosto`),
  KEY `fk_costos_gestiones1_idx` (`idgestion`),
  KEY `fk_costos_periodos1_idx` (`idperiodo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_cufd`
--

DROP TABLE IF EXISTS `fact_cufd`;
CREATE TABLE IF NOT EXISTS `fact_cufd` (
  `id_cufd` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `codigo_control` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(75) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_vigencia` datetime NOT NULL,
  `id_punto_venta` int(11) NOT NULL,
  PRIMARY KEY (`id_cufd`),
  KEY `fk_cufd_punto_venta1_idx` (`id_punto_venta`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `fact_cufd`
--

INSERT INTO `fact_cufd` (`id_cufd`, `codigo`, `codigo_control`, `direccion`, `fecha_vigencia`, `id_punto_venta`) VALUES
(1, 'BQVVDKkxCQkE=NzjM5Q0ZGRjhGMjY=Qj5ycTVTQ0pXVUFIyQTlGNTY2M0Y4N', '46CF55307DC6D74', 'CALLE COMERCIO NRO.70 ZONA CENTRAL', '2022-09-02 18:56:42', 1),
(2, 'BQVVDKkxCQkE=NzjM5Q0ZGRjhGMjY=QnktNkFUQ0pXVUJIyQTlGNTY2M0Y4N', '893FB8707DC6D74', 'CALLE COMERCIO NRO.70 ZONA CENTRAL', '2022-09-02 19:00:58', 2),
(3, 'BQVVDKkxCQkE=NzjM5Q0ZGRjhGMjY=QkFWRFJMRUpXVUFIyQTlGNTY2M0Y4N', '5AAAB203EDC6D74', 'CALLE COMERCIO NRO.70 ZONA CENTRAL', '2022-09-04 11:17:03', 1),
(4, 'BQVVDKkxCQkE=NzjM5Q0ZGRjhGMjY=QlUxSFJMRUpXVUJIyQTlGNTY2M0Y4N', '028BC203EDC6D74', 'CALLE COMERCIO NRO.70 ZONA CENTRAL', '2022-09-04 11:17:08', 2),
(5, 'BQVVDKkxCQkE=NzjM5Q0ZGRjhGMjY=Qm9yRG1MWEpXVUFIyQTlGNTY2M0Y4N', '4AA4CF9F42D6D74', 'CALLE COMERCIO NRO.70 ZONA CENTRAL', '2022-09-23 11:38:03', 1),
(6, 'CQUFVQypMQkJBNzjM5Q0ZGRjhGMjY=QsKhJkdtTFhKV1VIyQTlGNTY2M0Y4N', '0B41DF9F42D6D74', 'CALLE COMERCIO NRO.70 ZONA CENTRAL', '2022-09-23 11:38:07', 2),
(7, 'BQVVDKkxCQkE=NzjM5Q0ZGRjhGMjY=QktAWWhUWkpXVUFIyQTlGNTY2M0Y4N', '2FCEB29BC2D6D74', 'CALLE COMERCIO NRO.70 ZONA CENTRAL', '2022-09-25 19:33:25', 1),
(8, 'CQUFVQypMQkJBNzjM5Q0ZGRjhGMjY=Qj7CoWJoVFpKV1VIyQTlGNTY2M0Y4N', '8C5AC29BC2D6D74', 'CALLE COMERCIO NRO.70 ZONA CENTRAL', '2022-09-25 19:33:28', 2),
(9, 'BQVVDKkxCQkE=NzjM5Q0ZGRjhGMjY=Qkt7ZXZVTktXVUFIyQTlGNTY2M0Y4N', '4B69367947E6D74', 'CALLE COMERCIO NRO.70 ZONA CENTRAL', '2022-10-13 20:47:31', 1),
(10, 'BQVVDKkxCQkE=NzjM5Q0ZGRjhGMjY=QmVdaXZVTktXVUJIyQTlGNTY2M0Y4N', '7309467947E6D74', 'CALLE COMERCIO NRO.70 ZONA CENTRAL', '2022-10-13 20:47:35', 2),
(11, 'BQVVDKkxCQkE=NzjM5Q0ZGRjhGMjY=Qj42a1ZWT0tXVUFIyQTlGNTY2M0Y4N', '6284028587E6D74', 'CALLE COMERCIO NRO.70 ZONA CENTRAL', '2022-10-14 21:21:37', 1),
(12, 'BQVVDKkxCQkE=NzjM5Q0ZGRjhGMjY=Qnx+cVZWT0tXVUJIyQTlGNTY2M0Y4N', '497D128587E6D74', 'CALLE COMERCIO NRO.70 ZONA CENTRAL', '2022-10-14 21:21:43', 2),
(13, 'BQVVDKkxCQkE=NzjM5Q0ZGRjhGMjY=QkE8TVFWV0tXVUFIyQTlGNTY2M0Y4N', '0A86505269E6D74', 'CALLE COMERCIO NRO.70 ZONA CENTRAL', '2022-10-22 21:16:13', 1),
(14, 'BQVVDKkxCQkE=NzjM5Q0ZGRjhGMjY=Qm8jVFFWV0tXVUJIyQTlGNTY2M0Y4N', '4231705269E6D74', 'CALLE COMERCIO NRO.70 ZONA CENTRAL', '2022-10-22 21:16:20', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_cuis`
--

DROP TABLE IF EXISTS `fact_cuis`;
CREATE TABLE IF NOT EXISTS `fact_cuis` (
  `id_cuis` int(11) NOT NULL AUTO_INCREMENT,
  `cuis_codigo` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `cuis_fecha_vigencia` datetime NOT NULL,
  `id_punto_venta` int(11) NOT NULL,
  PRIMARY KEY (`id_cuis`),
  KEY `fk_cuis_punto_venta_idx` (`id_punto_venta`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `fact_cuis`
--

INSERT INTO `fact_cuis` (`id_cuis`, `cuis_codigo`, `cuis_fecha_vigencia`, `id_punto_venta`) VALUES
(1, 'D2E296D2', '2022-09-01 14:10:33', 1),
(2, '3C062D5A', '2022-09-01 14:16:56', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_devueltos`
--

DROP TABLE IF EXISTS `fact_devueltos`;
CREATE TABLE IF NOT EXISTS `fact_devueltos` (
  `iddevuelto` int(11) NOT NULL AUTO_INCREMENT,
  `idafectado` int(11) NOT NULL,
  `idlectura` int(11) NOT NULL,
  `imp_devuelto` float(7,2) DEFAULT NULL,
  PRIMARY KEY (`iddevuelto`),
  KEY `fk_devueltos_afectados1_idx` (`idafectado`),
  KEY `fk_devueltos_lecturas1_idx` (`idlectura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_directos`
--

DROP TABLE IF EXISTS `fact_directos`;
CREATE TABLE IF NOT EXISTS `fact_directos` (
  `iddirecto` int(11) NOT NULL AUTO_INCREMENT,
  `beneficiario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`iddirecto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_documento_sector`
--

DROP TABLE IF EXISTS `fact_documento_sector`;
CREATE TABLE IF NOT EXISTS `fact_documento_sector` (
  `id_documento_sector` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_actividad` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `codigo_documento_sector` int(11) DEFAULT NULL,
  `tipo_documento_sector` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_documento_sector`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `fact_documento_sector`
--

INSERT INTO `fact_documento_sector` (`id_documento_sector`, `codigo_actividad`, `codigo_documento_sector`, `tipo_documento_sector`) VALUES
(1, '351000', 29, 'NOT_CON'),
(2, '351000', 1, 'FCV'),
(3, '351000', 24, 'NCD'),
(4, '351000', 13, 'FSBAS'),
(5, '351000', 35, 'FAC_CVB'),
(6, '351000', 40, 'FSERZF'),
(7, '351000', 34, 'FAC_SEG'),
(8, '351000', 47, 'NCDDE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_empleado`
--

DROP TABLE IF EXISTS `fact_empleado`;
CREATE TABLE IF NOT EXISTS `fact_empleado` (
  `id_empleado` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(35) COLLATE utf8_spanish_ci DEFAULT NULL,
  `apellido` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `nivel` char(1) COLLATE utf8_spanish_ci NOT NULL,
  `estado` char(1) COLLATE utf8_spanish_ci NOT NULL,
  `id_punto_venta` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_empleado`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `fact_empleado`
--

INSERT INTO `fact_empleado` (`id_empleado`, `nombre`, `apellido`, `usuario`, `password`, `nivel`, `estado`, `id_punto_venta`) VALUES
(1, 'carmelo ', 'molina', 'admin', '02f75b91ca0420cd1807f27bbce1dc74', '2', '1', NULL),
(2, 'RAFA', 'RAFA', 'rafa', '35cd2d0d62d9bc5e60a3ca9f7593b05b', '2', '1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_empleados`
--

DROP TABLE IF EXISTS `fact_empleados`;
CREATE TABLE IF NOT EXISTS `fact_empleados` (
  `idempleado` int(11) NOT NULL AUTO_INCREMENT,
  `documento` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `paterno` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `materno` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cargo` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nacimiento` date DEFAULT NULL,
  `vigente` int(11) DEFAULT NULL,
  `usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`idempleado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_estados`
--

DROP TABLE IF EXISTS `fact_estados`;
CREATE TABLE IF NOT EXISTS `fact_estados` (
  `idestado` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` char(1) COLLATE utf8_spanish_ci DEFAULT 'X',
  `estado` varchar(50) COLLATE utf8_spanish_ci DEFAULT 'SIN CONEXION',
  `usuario` int(11) NOT NULL,
  PRIMARY KEY (`idestado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_factores`
--

DROP TABLE IF EXISTS `fact_factores`;
CREATE TABLE IF NOT EXISTS `fact_factores` (
  `idfactor` int(11) NOT NULL AUTO_INCREMENT,
  `idperiodo` int(11) NOT NULL,
  `re_020` float DEFAULT NULL,
  `re_100` float DEFAULT NULL,
  `re_ade` float DEFAULT NULL,
  `ge_020` float DEFAULT NULL,
  `ge_100` float DEFAULT NULL,
  `ge_ade` float DEFAULT NULL,
  `i1_050` float DEFAULT NULL,
  `i1_ade` float DEFAULT NULL,
  `i2_ade` float DEFAULT NULL,
  `i2_dem` float DEFAULT NULL,
  `ta_ade` float DEFAULT NULL,
  `ba_020` float DEFAULT NULL,
  `ba_100` float DEFAULT NULL,
  `ba_ade` float DEFAULT NULL,
  `sc_020` float DEFAULT NULL,
  `sc_100` float DEFAULT NULL,
  `sc_ade` float DEFAULT NULL,
  `aseo` float DEFAULT NULL,
  `alumbrado` float DEFAULT NULL,
  `dignidad` float DEFAULT NULL,
  `ley1886` float DEFAULT NULL,
  `tv_ts` float DEFAULT NULL,
  `tv_tp` float DEFAULT NULL,
  `tv_c1` float DEFAULT NULL,
  `tv_c1_adi` float DEFAULT NULL,
  `tv_c2` float DEFAULT NULL,
  `tv_c2_adi` float DEFAULT NULL,
  `tv_c3` float DEFAULT NULL,
  `tv_c3_adi` float DEFAULT NULL,
  `usuario` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idfactor`),
  KEY `fk_factores_periodos1_idx` (`idperiodo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_factura`
--

DROP TABLE IF EXISTS `fact_factura`;
CREATE TABLE IF NOT EXISTS `fact_factura` (
  `id_factura` int(11) NOT NULL AUTO_INCREMENT,
  `cuf` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_emision` datetime DEFAULT NULL,
  `estado_fact` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_empleado` int(11) NOT NULL,
  `id_punto_venta` int(11) NOT NULL,
  `id_orden` int(11) DEFAULT NULL,
  `leyenda_fact` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nro_fact` int(11) DEFAULT NULL,
  `idcliente` int(11) DEFAULT NULL,
  `monto_total` float(7,2) DEFAULT NULL,
  `cufd` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipo_emision` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `codigo_fuera_linea` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id_factura`),
  KEY `fk_factura_empleado1_idx` (`id_empleado`),
  KEY `fk_factura_punto_venta1_idx` (`id_punto_venta`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `fact_factura`
--

INSERT INTO `fact_factura` (`id_factura`, `cuf`, `fecha_emision`, `estado_fact`, `id_empleado`, `id_punto_venta`, `id_orden`, `leyenda_fact`, `nro_fact`, `idcliente`, `monto_total`, `cufd`, `tipo_emision`, `codigo_fuera_linea`) VALUES
(1, '4530029637FFFBFCECDEC84C61028FEC79AB9E06A72FCEB29BC2D6D74', '2022-09-24 19:45:23', 'E', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, '4530029637FFFBFCEDEAF84A08D3298038E39E06A42FCEB29BC2D6D74', '2022-09-24 19:46:06', 'E', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, '4530029638000CF029FB414882BD5536B0D39E06A44B69367947E6D74', '2022-10-12 20:47:41', 'E', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, '4530029638000D21D62779A336EA690518AB9E06A26284028587E6D74', '2022-10-13 21:22:20', 'E', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, '4530029638000EAC3CD71198E93ED9CFD9739E06A30A86505269E6D74', '2022-10-21 21:16:26', 'E', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_facturas`
--

DROP TABLE IF EXISTS `fact_facturas`;
CREATE TABLE IF NOT EXISTS `fact_facturas` (
  `idfactura` int(11) NOT NULL AUTO_INCREMENT,
  `idautorizacion` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `factura` int(11) DEFAULT NULL,
  `autorizacion` int(11) DEFAULT NULL,
  `nombre` int(11) DEFAULT NULL,
  `nit` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `emision` date DEFAULT NULL,
  `importe` float(9,2) DEFAULT NULL,
  `ice` float DEFAULT NULL,
  `excento` float DEFAULT NULL,
  `neto` float DEFAULT NULL,
  `iva` float DEFAULT NULL,
  `ite` float DEFAULT NULL,
  `estado` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `codcontrol` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` int(11) DEFAULT NULL,
  `idlectura` int(11) DEFAULT NULL,
  PRIMARY KEY (`idfactura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_factura_13`
--

DROP TABLE IF EXISTS `fact_factura_13`;
CREATE TABLE IF NOT EXISTS `fact_factura_13` (
  `idfactura_13` int(11) NOT NULL AUTO_INCREMENT,
  `cuf` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_emision` datetime DEFAULT NULL,
  `estado_fact` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_punto_venta` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `leyenda_fact` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nro_fact` int(11) DEFAULT NULL,
  `idlectura` int(11) DEFAULT NULL,
  `monto_total` float(7,2) DEFAULT NULL,
  `cufd` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idfactura_13`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_factura_22`
--

DROP TABLE IF EXISTS `fact_factura_22`;
CREATE TABLE IF NOT EXISTS `fact_factura_22` (
  `idfactura_22` int(11) NOT NULL AUTO_INCREMENT,
  `cuf` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_emision` datetime DEFAULT NULL,
  `estado_fact` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_punto_venta` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `leyenda_fact` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nro_fact` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idlectura` int(11) DEFAULT NULL,
  `monto_total` float(7,2) DEFAULT NULL,
  `cufd` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idfactura_22`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_gestiones`
--

DROP TABLE IF EXISTS `fact_gestiones`;
CREATE TABLE IF NOT EXISTS `fact_gestiones` (
  `idgestion` int(11) NOT NULL AUTO_INCREMENT,
  `gestion` int(11) DEFAULT NULL,
  `descripcion` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` int(11) DEFAULT NULL,
  `idservicio` int(11) NOT NULL,
  PRIMARY KEY (`idgestion`),
  KEY `fk_gestiones_servicios1_idx` (`idservicio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_inquilinos`
--

DROP TABLE IF EXISTS `fact_inquilinos`;
CREATE TABLE IF NOT EXISTS `fact_inquilinos` (
  `idinquilino` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` int(11) DEFAULT NULL,
  `idcliente` int(11) NOT NULL,
  `idabonado` int(11) NOT NULL,
  PRIMARY KEY (`idinquilino`),
  KEY `fk_inquilinos_cliente1_idx` (`idcliente`),
  KEY `fk_inquilinos_abonados1_idx` (`idabonado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_items_orden`
--

DROP TABLE IF EXISTS `fact_items_orden`;
CREATE TABLE IF NOT EXISTS `fact_items_orden` (
  `id_items_orden` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad` float(7,2) DEFAULT NULL,
  `precio_venta` float(7,2) DEFAULT NULL,
  `descuento_item` float(7,2) DEFAULT NULL,
  `id_orden` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  PRIMARY KEY (`id_items_orden`),
  KEY `fk_items_orden_orden1_idx` (`id_orden`),
  KEY `fk_items_orden_producto1_idx` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_lecturas`
--

DROP TABLE IF EXISTS `fact_lecturas`;
CREATE TABLE IF NOT EXISTS `fact_lecturas` (
  `idlectura` int(11) NOT NULL AUTO_INCREMENT,
  `idabonado` int(11) NOT NULL,
  `idperiodo` int(11) NOT NULL,
  `idservicio` int(11) NOT NULL,
  `idcategoria` int(11) DEFAULT NULL,
  `indice` int(11) DEFAULT NULL,
  `estimado` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `mulmed` int(11) DEFAULT NULL,
  `kwh` int(11) DEFAULT NULL,
  `potencia` float DEFAULT NULL,
  `imp_fijo` float DEFAULT NULL,
  `imp_adic` float DEFAULT NULL,
  `imp_poten` float DEFAULT NULL,
  `imp_total` float DEFAULT NULL,
  `conexion` float DEFAULT NULL,
  `reposicion` float DEFAULT NULL,
  `recargo` float DEFAULT NULL,
  `aseo` float DEFAULT NULL,
  `alumbrado` float DEFAULT NULL,
  `ley1886` float DEFAULT NULL,
  `dignidad` float DEFAULT NULL,
  `afcoop` float DEFAULT NULL,
  `devolucion` float DEFAULT NULL,
  `desdom` float DEFAULT NULL,
  `desap` float DEFAULT NULL,
  `desau` float DEFAULT NULL,
  `desafcoop` float DEFAULT NULL,
  `kvarh` float DEFAULT NULL,
  `imp_penal` float DEFAULT NULL,
  `lectreactiva` float DEFAULT NULL,
  `freg_ene0` float DEFAULT NULL,
  `frepetido` float DEFAULT NULL,
  `estado` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `pago` datetime DEFAULT NULL,
  `cobrador` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `lecturador` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `generado` char(1) COLLATE utf8_spanish_ci DEFAULT '0',
  PRIMARY KEY (`idlectura`),
  KEY `fk_lecturas_servicios1_idx` (`idservicio`),
  KEY `fk_lecturas_abonados1_idx` (`idabonado`),
  KEY `fk_lecturas_periodos1_idx` (`idperiodo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_lecturas_observadas`
--

DROP TABLE IF EXISTS `fact_lecturas_observadas`;
CREATE TABLE IF NOT EXISTS `fact_lecturas_observadas` (
  `idlecturas_observadas` int(11) NOT NULL AUTO_INCREMENT,
  `idlectura` int(11) DEFAULT NULL,
  `idtipo` int(11) DEFAULT NULL,
  `usuario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idlecturas_observadas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_ley1886`
--

DROP TABLE IF EXISTS `fact_ley1886`;
CREATE TABLE IF NOT EXISTS `fact_ley1886` (
  `idley1886` int(11) NOT NULL AUTO_INCREMENT,
  `vigente` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `inicio` date DEFAULT NULL,
  `final` date DEFAULT NULL,
  `usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`idley1886`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_leyenda_factura`
--

DROP TABLE IF EXISTS `fact_leyenda_factura`;
CREATE TABLE IF NOT EXISTS `fact_leyenda_factura` (
  `id_leyenda_factura` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_actividad` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `descripcion_leyenda` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_leyenda_factura`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `fact_leyenda_factura`
--

INSERT INTO `fact_leyenda_factura` (`id_leyenda_factura`, `codigo_actividad`, `descripcion_leyenda`) VALUES
(1, '351000', 'Ley N° 453: Tienes derecho a un trato equitativo sin discriminación en la oferta de servicios.'),
(2, '351000', 'Ley N° 453: En caso de incumplimiento a lo ofertado o convenido, el proveedor debe reparar o sustituir el servicio.'),
(3, '351000', 'Ley N° 453: El proveedor debe exhibir certificaciones de habilitación o documentos que acrediten las capacidades u ofertas de servicios especializados.'),
(4, '351000', 'Ley N° 453: Tienes derecho a recibir información sobre las características y contenidos de los servicios que utilices.'),
(5, '351000', 'Ley N° 453: El proveedor de servicios debe habilitar medios e instrumentos para efectuar consultas y reclamaciones.'),
(6, '351000', 'Ley N° 453: El proveedor deberá suministrar el servicio en las modalidades y términos ofertados o convenidos.'),
(7, '351000', 'Ley N° 453: La interrupción del servicio debe comunicarse con anterioridad a las Autoridades que correspondan y a los usuarios afectados.'),
(8, '351000', 'Ley N° 453: Los servicios deben suministrarse en condiciones de inocuidad, calidad y seguridad.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_liberaciones`
--

DROP TABLE IF EXISTS `fact_liberaciones`;
CREATE TABLE IF NOT EXISTS `fact_liberaciones` (
  `idliberacion` int(11) NOT NULL,
  `liberacion` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` int(11) NOT NULL,
  PRIMARY KEY (`idliberacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_localidades`
--

DROP TABLE IF EXISTS `fact_localidades`;
CREATE TABLE IF NOT EXISTS `fact_localidades` (
  `idlocalidad` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `localidad` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` int(11) NOT NULL,
  PRIMARY KEY (`idlocalidad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_maniobras`
--

DROP TABLE IF EXISTS `fact_maniobras`;
CREATE TABLE IF NOT EXISTS `fact_maniobras` (
  `idmaniobra` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_proteccion` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `kva_proteccion` int(11) DEFAULT NULL,
  `kv_proteccion` int(11) DEFAULT NULL,
  `proteccion_sup` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `consum_mt_1` int(11) DEFAULT NULL,
  `consum_mt_2` int(11) DEFAULT NULL,
  `consum_bt_1` int(11) DEFAULT NULL,
  `consum_bt_2` int(11) DEFAULT NULL,
  `direccion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` int(11) NOT NULL,
  `idalimentador` int(11) NOT NULL,
  `idzona` int(11) NOT NULL,
  PRIMARY KEY (`idmaniobra`),
  KEY `fk_maniobras_alilmentadores1_idx` (`idalimentador`),
  KEY `fk_maniobras_zonas1_idx` (`idzona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_mediciones`
--

DROP TABLE IF EXISTS `fact_mediciones`;
CREATE TABLE IF NOT EXISTS `fact_mediciones` (
  `idmedicion` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(3) COLLATE utf8_spanish_ci DEFAULT NULL,
  `medicion` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` int(11) NOT NULL,
  PRIMARY KEY (`idmedicion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_mensaje_servicio`
--

DROP TABLE IF EXISTS `fact_mensaje_servicio`;
CREATE TABLE IF NOT EXISTS `fact_mensaje_servicio` (
  `id_mensaje_servicio` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_clasificador` int(11) DEFAULT NULL,
  `descripcion` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_mensaje_servicio`)
) ENGINE=InnoDB AUTO_INCREMENT=160 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `fact_mensaje_servicio`
--

INSERT INTO `fact_mensaje_servicio` (`id_mensaje_servicio`, `codigo_clasificador`, `descripcion`) VALUES
(1, 903, 'RECEPCION PROCESADA'),
(2, 904, 'RECEPCION OBSERVADA'),
(3, 906, 'ANULACION RECHAZADA'),
(4, 905, 'ANULACION CONFIRMADA'),
(5, 976, 'EL CODIGO DEL EVENTO ES INCORRECTO'),
(6, 977, 'NO EXISTEN ACTIVIDADES ASOCIADAS AL NIT'),
(7, 979, 'EL CUIS NO SE ENCUENTRA ASOCIADO AL SISTEMA O A LA SUCURSAL'),
(8, 980, 'EXISTE UN CUIS VIGENTE PARA LA SUCURSAL O PUNTO DE VENTA'),
(9, 982, 'NO EXISTE PUNTOS DE VENTA ASOCIADOS'),
(10, 984, 'EL EVENTO SIGNIFICATIVO NO CORRESPONDE AL CUFD DEL EVENTO REGISTRADO'),
(11, 986, 'NIT ACTIVO'),
(12, 987, 'NIT INACTIVO'),
(13, 988, 'CODIGO UNICO DE INICIO DE SISTEMA (CUIS) FUERA DE TOLERANCIA'),
(14, 990, 'EL CLIENTE NO TIENE ACTIVIDADES RELACIONADAS AL SECTOR QUE INTENTA ASOCIAR'),
(15, 991, 'ERROR EN BASE DE DATOS'),
(16, 992, 'ERROR SERVICIO PADRON'),
(17, 993, 'LA FECHA DE ENVIO ESTA FUERA DE PLAZO'),
(18, 994, 'NIT INEXISTENTE'),
(19, 2005, 'ADVERTENCIA: EL NIT DEL CLIENTE ENVIADO EN EL CAMPO NUMERO DE DOCUMENTO NO ES VALIDO'),
(20, 123, 'CODIGO UNICO DE FACTURACION DIARIA (CUFD) FUERA DE TOLERANCIA'),
(21, 901, 'RECEPCION PENDIENTE'),
(22, 902, 'RECEPCION RECHAZADA'),
(23, 907, 'REVERSION DE ANULACION CONFIRMADA'),
(24, 908, 'RECEPCION VALIDADA'),
(25, 909, 'REVERSION DE ANULACION RECHAZADA'),
(26, 910, 'EL PARAMETRO AMBIENTE ES INVALIDO'),
(27, 911, 'EL PARAMETRO CODIGO DE SISTEMA ES INVALIDO'),
(28, 912, 'EL SISTEMA NO ESTA ASOCIADO AL CONTRIBUYENTE'),
(29, 913, 'CODIGO UNICO DE INICIO DE SISTEMA (CUIS) INVALIDO'),
(30, 914, 'CODIGO UNICO DE FACTURACION DIARIA (CUFD) INVALIDO'),
(31, 915, 'EL PARAMETRO TIPO FACTURA DOCUMENTO ES INVALIDO'),
(32, 916, 'EL PARAMETRO TIPO DE EMISION ES INVALIDO'),
(33, 917, 'EL PARAMETRO MODALIDAD ES INVALIDO'),
(34, 918, 'EL PARAMETRO SUCURSAL ES INVALIDO'),
(35, 919, 'EL PARAMETRO NIT ES INVALIDO'),
(36, 920, 'EL PARAMETRO ARCHIVO ES INVALIDO'),
(37, 921, 'EL FIRMADO DEL XML ES INCORRECTO'),
(38, 922, 'LA FIRMA DEL XML NO CORRESPONDE AL CONTRIBUYENTE'),
(39, 923, 'EL PARAMETRO CODIGO DE RECEPCION ES INVALIDO'),
(40, 925, 'EL PARAMETRO MOTIVO DE ANULACION ES INVALIDO'),
(41, 926, 'COMUNICACION EXITOSA'),
(42, 927, 'EL CERTIFICADO DE LA FIRMA ES INVALIDO'),
(43, 928, 'EL CERTIFICADO SE ENCUENTRA REVOCADO'),
(44, 929, 'EL CODIGO UNICO DE INICIO DE SISTEMA (CUIS) NO ESTA VIGENTE'),
(45, 930, 'EL CODIGO UNICO DE INICIO DE SISTEMA (CUIS) NO CORRESPONDE A LA SUCURSAL/PUNTO VENTA'),
(46, 931, 'EL PARAMETRO CODIGO DOCUMENTO SECTOR ES INVALIDO'),
(47, 932, 'EL PARAMETRO CODIGO DOCUMENTO SECTOR NO CORRESPONDE AL SERVICIO'),
(48, 933, 'EL PUNTO DE VENTA ES INEXISTENTE O INVALIDO'),
(49, 934, 'LA SOLICITUD DE ANULACION DE LA FACTURA O NOTA DE CREDITO-DEBITO SE ENCUENTRA FUERA DE PLAZO'),
(50, 935, 'EL PARAMETRO FECHA DE ENVIO ES INVALIDO'),
(51, 936, 'LA FACTURA O NOTA DE CREDITO-DEBITO YA SE ENCUENTRA ANULADA'),
(52, 937, 'EL NIT NO TIENE ASOCIADO LA MODALIDAD DE FACTURACION'),
(53, 938, 'EL NIT PRESENTA MARCAS DE CONTROL'),
(54, 939, 'LA FACTURA O NOTA DE CREDITO - DEBITO NO CUMPLE CON EL FORMATO DEL XSD ESPECIFICADO'),
(55, 940, 'EL NIT NO TIENE HABILITADO EL DOCUMENTO SECTOR'),
(56, 941, 'LA FACTURA O NOTA DE CREDITO - DEBITO NO SE ENCUENTRA DISPONIBLE PARA SER ANULADA'),
(57, 942, 'EL CODIGO DE RECEPCION DE EVENTO SIGNIFICATIVO NO SE ENCUENTRA EN LA BASE DE DATOS DEL SIN'),
(58, 943, 'EL FORMATO DE LA FECHA DE ENVIO ES INCORRECTO'),
(59, 944, 'EL CODIGO DE RECEPCION NO SE ENCUENTRA EN LA BASE DE DATOS DEL SIN'),
(60, 945, 'EL ESTADO DE RECEPCION DE LA ANULACION ES INCORRECTA'),
(61, 946, 'EL CODIGO UNICO DE FACTURA (CUF) NO EXISTE EN BASE DE DATOS DEL SIN'),
(62, 947, 'EL PARAMETRO TIPO DE PUNTO DE VENTA ES INVALIDO'),
(63, 948, 'EL PARAMETRO NOMBRE DE PUNTO DE VENTA NO PUEDE SER VACIO'),
(64, 949, 'EL PARAMETRO DESCRIPCION DE PUNTO DE VENTA NO PUEDE SER VACIO'),
(65, 950, 'EL PARAMETRO CODIGO DE EVENTO SIGNIFICATIVO NO PUEDE SER VACIO'),
(66, 951, 'EL PARAMETRO DESCRIPCION DE EVENTO SIGNIFICATIVO NO PUEDE SER VACIO'),
(67, 952, 'EL CODIGO UNICO DE FACTURA (CUF) YA SE ENCUENTRA REGISTRADO EN LA BASE DE DATOS DEL SIN'),
(68, 953, 'EL CODIGO UNICO DE FACTURACION DIARIA (CUFD) NO SE ENCUENTRA VIGENTE'),
(69, 954, 'LA CANTIDAD DE FACTURAS EN EL  PAQUETE EMITIDO POR CONTINGENCIA HA EXCEDIO EL MAXIMO PERMITIDO'),
(70, 955, 'NO EXISTE REGISTRO PARA AUTORIZAR EL PROCESO MASIVO'),
(71, 956, 'LA CANTIDAD DE FACTURAS EN EL PAQUETE EMITIDO MASIVAMENTE HA EXCEDIO EL MAXIMO PERMITIDO'),
(72, 957, 'NO EXISTE REGISTRO DE EVENTO SIGNIFICATIVO EN LA BASE DE DATOS DEL SIN'),
(73, 958, 'EL USUARIO NO SE ENCUENTRA AUTORIZADO PARA CONSUMIR ESTE SERVICIO'),
(74, 959, 'EL CODIGO UNICO DE INICIO DE SISTEMA (CUIS) NO SE ENCUENTRA ASOCIADO AL SISTEMA'),
(75, 960, 'EL PARAMETRO FIN DE EVENTO ES REQUERIDO'),
(76, 961, 'EL NIT TIENE MARCA DE DOMICILIO INEXISTENTE'),
(77, 962, 'EL NIT TIENE BLOQUEO DE DOSIFICACION ORIGINADO EN FISCALIZACION'),
(78, 963, 'EL NIT TIENE BLOQUEO DE DOSIFICACION ORIGINADO EN JURIDICA'),
(79, 964, 'EL NIT NO CUMPLE CON OBLIGATORIEDAD DE PRESENTACION DE DDJJ'),
(80, 965, 'EL CONTRIBUYENTE NO CUENTA CON FIRMA VIGENTE REGISTRADA'),
(81, 966, 'NO SE PUEDE RECUPERAR LOS DATOS DEL CONTRIBUYENTE'),
(82, 967, 'TIEMPO DE ESPERA AGOTADO PARA CONEXION A BASE DE DATOS'),
(83, 968, 'LA ANULACION DE LA FACTURA O NOTA DE CREDITO - DEBITO YA SE ENCUENTRA REVERTIDA'),
(84, 969, 'EL PARAMETRO HASH ES INVALIDO'),
(85, 970, 'EL CUIS EN LA BASE DE DATOS SE ENCUENTRA VIGENTE, NO PUEDE SOLICITAR OTRO'),
(86, 971, 'EL TAMAÃ‘O DEL ARCHIVO EXCEDE EL TAMAÃ‘O PERMITIDO DE 100 MB'),
(87, 972, 'LA CANTIDAD DE FACTURAS ENVIADA EN EL PAQUETE ES MAYOR A LA DEFINIDA EN LA NORMATIVA'),
(88, 973, 'EL CODIGO UNICO DE INICIO DE SISTEMA (CUIS) NO SE ENCUENTRA VIGENTE'),
(89, 974, 'EL RANGO DE FECHAS DEL EVENTO SIGNIFICATIVO PARA REGISTRAR ES INVÃLIDO'),
(90, 975, 'EL SISTEMA NO SE ENCUENTRA AUTORIZADO O SE ENCUENTRA OBSERVADO'),
(91, 978, 'REVERSION DE LA FACTURA O NOTA DE CREDITO/DEBITO CONFIRMADA'),
(92, 985, 'LA CANTIDAD DE FACTURAS ES DIFERENTE A LA DECLARADA'),
(93, 999, 'ERROR EN LA EJECUCION DEL SERVICIO'),
(94, 1000, 'EL CUF ENVIADO YA EXISTE EN LA BASE DE DATOS DEL SIN'),
(95, 1001, 'EL NIT ENVIADO EN EL XML ES INEXISTENTE O NO CORRESPONDE AL CUFD'),
(96, 1002, 'EL CODIGO UNICO DE FACTURA (CUF) ENVIADO EN EL XML ES INVALIDO'),
(97, 1003, 'EL CODIGO UNICO DE FACTURACION DIARIA (CUFD) ENVIADO EN EL XML ES INVALIDO'),
(98, 1004, 'LA SUCURSAL ENVIADA EN EL XML NO CORRESPONDE A LOS DATOS DEL CUFD'),
(99, 1005, 'LA FACTURA O NOTA DE CREDITO-DEBITO NO PUEDE SER EMITIDA AL MISMO EMISOR'),
(100, 1006, 'EL CUFD ENVIADO NO CORRESPONDE AL EVENTO ASOCIADO AL PAQUETE ENVIADO'),
(101, 1007, 'LA DIRECCION ENVIADA EN EL XML NO CORRESPONDE A LA REGISTRADA EN PADRON'),
(102, 1008, 'EL PUNTO DE VENTA ENVIADO EN EL XML ES INEXISTENTE O INVALIDO'),
(103, 1009, 'LA FECHA DE EMISION ENVIADA EN EL XML NO ES VALIDA PARA EMISION EN LINEA'),
(104, 1010, 'LA FACTURA NO PUEDE SER ENVIADA CON NUMERO DE CI/NIT/CEX 0 PARA MONTOS MAYORES A 3000'),
(105, 1011, 'EL COMPLEMENTO SOLO PUEDE SER ENVIADO CUANDO EL TIPO DE DOCUMENTO ES CARNET DE IDENTIDAD'),
(106, 1012, 'EL NUMERO DE TARJETA SOLO PUEDE SER ENVIADO CUANDO EL METODO DE PAGO SEA CON TARJETA'),
(107, 1013, 'EL CALCULO DEL MONTO TOTAL ES ERRONEO'),
(108, 1014, 'EL CALCULO DEL  MONTO TOTAL MONEDA ES ERRONEO'),
(109, 1015, 'EL CALCULO DEL IMPORTE BASE PARA CREDITO FISCAL ES ERRONEO'),
(110, 1016, 'EL CODIGO DE ACTIVIDAD ECONOMICA NO ESTA HABILITADA PARA EL CONTRIBUYENTE'),
(111, 1017, 'EL CODIGO DE PRODUCTO NO ESTA RELACIONADO A NINGUN ACTIVIDAD ECONOMICA DEL CONTRIBUYENTE'),
(112, 1018, 'EL CALCULO DEL SUBTOTAL ES ERRONEO'),
(113, 1019, 'EL CALCULO DE ICE ESPECIFICO ES ERRONEO'),
(114, 1020, 'EL CALCULO DE ICE PORCENTUAL ES ERRONEO'),
(115, 1021, 'EL MONTO ICE ESPECIFICO ES ERRONEO'),
(116, 1022, 'EL MONTO ICE PORCENTUAL ES ERRONEO'),
(117, 1023, 'EL CODIGO NANDINA ENVIADO EN LA FACTURA ES ERRONEO'),
(118, 1024, 'LA SUMATORIA DE LO DETALLES ES ERRONEA'),
(119, 1025, 'EL MONTO SUJETO A CREDITO FISCAL LEY 317 ES ERRONEO'),
(120, 1026, 'EL MONTO TOTAL SUJETO AL IMPUESTO DEL JUEGO (IJ) ES ERRONEO'),
(121, 1027, 'EL MONTO DE DIFERENCIA DE CAMBIOS ES ERRONEO'),
(122, 1028, 'EL MONTO DE IVA ENVIADO ES ERRONEO'),
(123, 1029, 'EL MONTO TOTAL DEVUELTO ENVIADO ES ERRONEO'),
(124, 1030, 'EL MONTO TOTAL ORIGINAL ENVIADO ES ERRONEO'),
(125, 1031, 'EL MONTO EFECTIVO DE CREDITO O DEBITO DEVUELTO ENVIADO ES ERRONEO'),
(126, 1032, 'EL MONTO TOTAL DE IMPUESTO A LA PARTICIPACION EN JUEGO (IPJ) ES ERRONEO'),
(127, 1033, 'EL MONTO DEVUELTO ES MAYOR AL MONTO ORIGINAL'),
(128, 1034, 'LA FECHA DE EMISION ES MENOR AL PERIODO ANTERIOR'),
(129, 1035, 'FORMATO DE FECHA INCORRECTA'),
(130, 1036, 'NOMINATIVIDAD INCORRECTA PARA NOMBRE/RAZON SOCIAL'),
(131, 1037, 'EL NUMERO DOCUMENTO DE TIPO NIT NO ES VALIDO'),
(132, 1038, 'NIT CONJUNTO NO VALIDO'),
(133, 1039, 'FECHA EMISION PARA ENVIO MASIVO INCORRECTO'),
(134, 1040, 'FECHA DE EMISION NO SE ENCUENTRA EN EL RANGO DE CONTINGENCIA'),
(135, 1041, 'LA FECHA DE EMISION NO SE ENCUENTRA DENTRO DEL PLAZO ESTABLECIDO EN NORMA'),
(136, 989, 'API KEY NO VALIDO'),
(137, 1042, 'EL NIT DEL MEDICO ENVIADO NO ES VALIDO'),
(138, 1043, 'EL MONTO CONCILIADO ENVIADO ES ERRONEO'),
(139, 1044, 'EL MONTO TOTAL CONCILIADO ENVIADO ES ERRONEO'),
(140, 995, 'SERVICIO NO DISPONIBLE'),
(141, 1045, 'VALOR DE CAFC NO VALIDO PARA LA FACTURA'),
(142, 983, 'LA FECHA DE ENVIO DEL PAQUETE ESTA FUERA DE PLAZO'),
(143, 981, 'RANGO DE FECHAS DE EVENTO SIGNIFICATIVO INVALIDO'),
(144, 996, 'RANGO DE FECHAS INVALIDO'),
(145, 1046, 'FECHA EMISION PARA EL CAFC ENVIADO INCORRECTO'),
(146, 1047, 'NUMERO FACTURA PARA EL CAFC ENVIADO INCORRECTO'),
(147, 924, 'LA FACTURA O NOTA, NO EXISTE EN LA BASE DE DATOS DEL SIN'),
(148, 1048, 'FACTURA DE LA NOTA CREDITO DEBITO NO ENCONTRADA'),
(149, 1049, 'DETALLE DE LA NOTA DIFERENTE AL DETALLE DE LA FACTURA ORIGINAL'),
(150, 1050, 'MONTO GIFT CARD NO CORRESPONDE AL METODO DE PAGO'),
(151, 997, 'EL NOMBRE EXCEDE EL LIMITE DE CARACTERES PERMITIDOS'),
(152, 998, 'LA DESCRIPCION EXCEDE EL LIMITE DE CARACTERES PERMITIDOS'),
(153, 1052, 'EL CALCULO DEL MONTO IEHD ES ERRONEO'),
(154, 3000, 'EL NIT NO TIENE CONTRATO VIGENTE'),
(155, 3001, 'LA CATEGORIA DE CONTRATO NO CORRESPONDE AL SECTOR'),
(156, 1051, 'FECHA DE FACTURA INCORRECTA'),
(157, 3002, 'LA SOLICITUD EXCEDE EL LIMITE DE CUFD MASIVO PERMITIDO'),
(158, 1053, 'LA ACTIVIDAD DE LA NOTA DE CREDITO DEBITO NO SE ENCUENTRA AUTORIZADA PARA ESTE PLAZO'),
(159, 1054, 'EL MONTO DESCUENTO CREDITO DEBITO ES ERRONEO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_nro_adquisicion`
--

DROP TABLE IF EXISTS `fact_nro_adquisicion`;
CREATE TABLE IF NOT EXISTS `fact_nro_adquisicion` (
  `id_nro_adquisicion` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_adquisicion` datetime DEFAULT NULL,
  `id_empleado` int(11) NOT NULL,
  `proveedor` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `observacion` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `doc_respaldo` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nro_doc_respaldo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_nro_adquisicion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_observados`
--

DROP TABLE IF EXISTS `fact_observados`;
CREATE TABLE IF NOT EXISTS `fact_observados` (
  `idobservado` int(11) NOT NULL AUTO_INCREMENT,
  `nota` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` int(11) DEFAULT NULL,
  `idcliente` int(11) NOT NULL,
  PRIMARY KEY (`idobservado`),
  KEY `fk_observados_cliente1_idx` (`idcliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_orden`
--

DROP TABLE IF EXISTS `fact_orden`;
CREATE TABLE IF NOT EXISTS `fact_orden` (
  `id_orden` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_orden` datetime DEFAULT NULL,
  `estado_orden` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipo_orden` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `monto_descuento` float(7,2) DEFAULT NULL,
  `id_empleado` int(11) NOT NULL,
  `campo` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_orden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_ordenes`
--

DROP TABLE IF EXISTS `fact_ordenes`;
CREATE TABLE IF NOT EXISTS `fact_ordenes` (
  `idorden` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) DEFAULT NULL,
  `idabonado` int(11) NOT NULL,
  `idgestion` int(11) NOT NULL,
  `idservicio` int(11) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `costo` float(7,2) DEFAULT NULL,
  `nota` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_final` datetime DEFAULT NULL,
  `tiempo_tramite` float(7,2) DEFAULT NULL,
  `cobrado` int(11) DEFAULT '0',
  `idlectura` int(11) DEFAULT NULL,
  `empleado` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ncliente` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ncategoria` varchar(2) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nmedidior` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `impreso` int(11) DEFAULT NULL,
  `entrega` int(11) DEFAULT NULL,
  `fentrega` datetime DEFAULT NULL,
  `pentrega` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `devuelto` int(11) DEFAULT NULL,
  `fdevuelto` datetime DEFAULT NULL,
  `usuario` int(11) DEFAULT NULL,
  `solicitante` varchar(75) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idorden`),
  KEY `fk_ordenes_abonados1_idx` (`idabonado`),
  KEY `fk_ordenes_servicios1_idx` (`idservicio`),
  KEY `fk_ordenes_gestiones1_idx` (`idgestion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_parametrica_evento_significativo`
--

DROP TABLE IF EXISTS `fact_parametrica_evento_significativo`;
CREATE TABLE IF NOT EXISTS `fact_parametrica_evento_significativo` (
  `id_parametrica_evento_significativo` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_clasificador` int(11) DEFAULT NULL,
  `descripcion` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_parametrica_evento_significativo`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `fact_parametrica_evento_significativo`
--

INSERT INTO `fact_parametrica_evento_significativo` (`id_parametrica_evento_significativo`, `codigo_clasificador`, `descripcion`) VALUES
(1, 1, 'CORTE DEL SERVICIO DE INTERNET'),
(2, 2, 'INACCESIBILIDAD AL SERVICIO WEB DE LA ADMINISTRACIÓN TRIBUTARIA'),
(3, 3, 'INGRESO A ZONAS SIN INTERNET POR DESPLIEGUE DE PUNTO DE VENTA EN VEHICULOS AUTOMOTORES'),
(4, 4, 'VENTA EN LUGARES SIN INTERNET'),
(5, 5, 'CORTE DE SUMINISTRO DE ENERGIA ELECTRICA'),
(6, 6, 'VIRUS INFORMÁTICO O FALLA DE SOFTWARE'),
(7, 7, 'CAMBIO DE INFRAESTRUCTURA DEL SISTEMA INFORMÁTICO DE FACTURACIÓN O FALLA DE HARDWARE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_parametrica_motivo_anulacion`
--

DROP TABLE IF EXISTS `fact_parametrica_motivo_anulacion`;
CREATE TABLE IF NOT EXISTS `fact_parametrica_motivo_anulacion` (
  `id_parametrica_motivo_anulacion` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_clasificador` int(11) DEFAULT NULL,
  `descripcion` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_parametrica_motivo_anulacion`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `fact_parametrica_motivo_anulacion`
--

INSERT INTO `fact_parametrica_motivo_anulacion` (`id_parametrica_motivo_anulacion`, `codigo_clasificador`, `descripcion`) VALUES
(1, 1, 'FACTURA MAL EMITIDA'),
(2, 2, 'NOTA DE CREDITO-DEBITO MAL EMITIDA'),
(3, 3, 'DATOS DE EMISION INCORRECTOS'),
(4, 4, 'FACTURA O NOTA DE CREDITO-DEBITO DEVUELTA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_parametrica_pais_origen`
--

DROP TABLE IF EXISTS `fact_parametrica_pais_origen`;
CREATE TABLE IF NOT EXISTS `fact_parametrica_pais_origen` (
  `id_parametrica_pais_origen` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_clasificador` int(11) DEFAULT NULL,
  `descripcion` varchar(75) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_parametrica_pais_origen`)
) ENGINE=InnoDB AUTO_INCREMENT=210 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `fact_parametrica_pais_origen`
--

INSERT INTO `fact_parametrica_pais_origen` (`id_parametrica_pais_origen`, `codigo_clasificador`, `descripcion`) VALUES
(1, 1, 'AFGANISTÁN'),
(2, 2, 'ALBANIA'),
(3, 3, 'ALEMANIA'),
(4, 4, 'ANDORRA'),
(5, 5, 'ANGOLA'),
(6, 6, 'ANTIGUA Y BARBUDA'),
(7, 7, 'ARABIA SAUDITA'),
(8, 8, 'ARGELIA'),
(9, 9, 'ARGENTINA'),
(10, 10, 'ARMENIA'),
(11, 11, 'AUSTRALIA'),
(12, 12, 'AUSTRIA'),
(13, 13, 'AZERBAIYÁN'),
(14, 14, 'BAHAMAS'),
(15, 15, 'BAHREIN'),
(16, 16, 'BANGLADESH'),
(17, 17, 'BARBADOS'),
(18, 18, 'BIELORRUSIA'),
(19, 19, 'BELICE'),
(20, 20, 'BENIN'),
(21, 21, 'BUTÁN'),
(22, 22, 'BOLIVIA (ESTADO PLURINACIONAL DE)'),
(23, 23, 'BOSNIA Y HERZEGOVINA'),
(24, 24, 'BOTSUANA'),
(25, 25, 'BRASIL'),
(26, 26, 'BRUNEI DARUSSALAM'),
(27, 27, 'BULGARIA'),
(28, 28, 'BURKINA FASO'),
(29, 29, 'BURUNDI'),
(30, 30, 'BÉLGICA'),
(31, 31, 'CABO VERDE'),
(32, 32, 'CAMBOYA'),
(33, 33, 'CAMERÚN'),
(34, 34, 'CANADÁ'),
(35, 35, 'CHAD'),
(36, 36, 'CHEQUIA'),
(37, 37, 'CHILE'),
(38, 38, 'CHINA'),
(39, 39, 'CHIPRE'),
(40, 40, 'COLOMBIA'),
(41, 41, 'COMORAS'),
(42, 42, 'CONGO'),
(43, 43, 'COSTA RICA'),
(44, 44, 'CROACIA'),
(45, 45, 'CUBA'),
(46, 46, 'COSTA DE MARFIL'),
(47, 47, 'DINAMARCA'),
(48, 48, 'DJIBOUTI'),
(49, 49, 'DOMINICA'),
(50, 50, 'ECUADOR'),
(51, 51, 'EGIPTO'),
(52, 52, 'EL SALVADOR'),
(53, 53, 'EMIRATOS ÁRABES UNIDOS'),
(54, 54, 'ERITREA'),
(55, 55, 'ESLOVAQUIA'),
(56, 56, 'ESLOVENIA'),
(57, 57, 'ESPAÑA'),
(58, 58, 'ESTADOS UNIDOS DE AMÉRICA'),
(59, 59, 'ESTONIA'),
(60, 60, 'ETIOPÍA'),
(61, 61, 'FEDERACIÓN DE RUSIA'),
(62, 62, 'FIYI'),
(63, 63, 'FILIPINAS'),
(64, 64, 'FINLANDIA'),
(65, 65, 'FRANCIA'),
(66, 66, 'GABÓN'),
(67, 67, 'GAMBIA'),
(68, 68, 'GEORGIA'),
(69, 69, 'GHANA'),
(70, 70, 'GRANADA'),
(71, 71, 'GRECIA'),
(72, 72, 'GUATEMALA'),
(73, 73, 'GUINEA'),
(74, 74, 'GUINEA ECUATORIAL'),
(75, 75, 'GUINEA-BISSAU'),
(76, 76, 'GUYANA'),
(77, 77, 'HAITÍ'),
(78, 78, 'HONDURAS'),
(79, 79, 'HUNGRÍA'),
(80, 80, 'INDIA'),
(81, 81, 'INDONESIA'),
(82, 82, 'IRAQ'),
(83, 83, 'IRLANDA'),
(84, 84, 'IRÁN (REPÚBLICA ISLÁMICA DE)'),
(85, 85, 'ISLANDIA'),
(86, 86, 'ISLAS COOK'),
(87, 87, 'ISLAS FEROE (MIEMBRO ASOCIADO)'),
(88, 88, 'ISLAS MARSHALL'),
(89, 89, 'ISLAS SALOMÓN'),
(90, 90, 'ISRAEL'),
(91, 91, 'ITALIA'),
(92, 92, 'JAMAICA'),
(93, 93, 'JAPÓN'),
(94, 94, 'JORDANIA'),
(95, 95, 'KAZAJISTÁN'),
(96, 96, 'KENIA'),
(97, 97, 'KIRGUISTÁN'),
(98, 98, 'KIRIBATI'),
(99, 99, 'KUWAIT'),
(100, 100, 'LESOTO'),
(101, 101, 'LETONIA'),
(102, 102, 'LIBERIA'),
(103, 103, 'LIBIA'),
(104, 104, 'LITUANIA'),
(105, 105, 'LUXEMBURGO'),
(106, 106, 'LÍBANO'),
(107, 107, 'MADAGASCAR'),
(108, 108, 'MALASIA'),
(109, 109, 'MALAWI'),
(110, 110, 'MALDIVAS'),
(111, 111, 'MALTA'),
(112, 112, 'MALÍ'),
(113, 113, 'MARRUECOS'),
(114, 114, 'MAURICIO'),
(115, 115, 'MAURITANIA'),
(116, 116, 'MICRONESIA (ESTADOS FEDERADOS DE)'),
(117, 117, 'MONGOLIA'),
(118, 118, 'MONTENEGRO'),
(119, 119, 'MOZAMBIQUE'),
(120, 120, 'MYANMAR'),
(121, 121, 'MÉXICO'),
(122, 122, 'MÓNACO'),
(123, 123, 'NAMIBIA'),
(124, 124, 'NAURU'),
(125, 125, 'NEPAL'),
(126, 126, 'NICARAGUA'),
(127, 127, 'NIGERIA'),
(128, 128, 'NIUE'),
(129, 129, 'NORUEGA'),
(130, 130, 'NUEVA ZELANDA'),
(131, 131, 'NÍGER'),
(132, 132, 'OMÁN'),
(133, 133, 'PAKISTÁN'),
(134, 134, 'PALAOS'),
(135, 135, 'PANAMÁ'),
(136, 136, 'PAPUA NUEVA GUINEA'),
(137, 137, 'PARAGUAY'),
(138, 138, 'PAÍSES BAJOS'),
(139, 139, 'PERÚ'),
(140, 140, 'POLONIA'),
(141, 141, 'PORTUGAL'),
(142, 142, 'QATAR'),
(143, 143, 'REINO UNIDO'),
(144, 144, 'REPÚBLICA CENTROAFRICANA'),
(145, 145, 'REPÚBLICA DEMOCRÁTICA POPULAR LAO'),
(146, 146, 'REPÚBLICA DEMOCRÁTICA DEL CONGO'),
(147, 147, 'REPÚBLICA DOMINICANA'),
(148, 148, 'REPÚBLICA POPULAR DEMOCRÁTICA DE COREA'),
(149, 149, 'REPÚBLICA UNIDA DE TANZANÍA'),
(150, 150, 'REPÚBLICA DE COREA'),
(151, 151, 'REPÚBLICA DE MOLDAVIA'),
(152, 152, 'REPÚBLICA ÁRABE SIRIA'),
(153, 153, 'RUMANIA'),
(154, 154, 'REPÚBLICA DE RUANDA'),
(155, 155, 'SAN CRISTÓBAL Y NIEVES'),
(156, 156, 'SAMOA'),
(157, 157, 'SAN MARINO'),
(158, 158, 'SAN VICENTE Y LAS GRANADINAS'),
(159, 159, 'SANTA LUCÍA'),
(160, 160, 'SANTO TOMÉ Y PRÍNCIPE'),
(161, 161, 'SENEGAL'),
(162, 162, 'SERBIA'),
(163, 163, 'SEYCHELLES'),
(164, 164, 'SIERRA LEONA'),
(165, 165, 'SINGAPUR'),
(166, 166, 'SOMALIA'),
(167, 167, 'SRI LANKA'),
(168, 168, 'SUDÁFRICA'),
(169, 169, 'SUDÁN'),
(170, 170, 'SUDÁN DEL SUR'),
(171, 171, 'SUECIA'),
(172, 172, 'SUIZA'),
(173, 173, 'SURINAM'),
(174, 174, 'SUAZILANDIA'),
(175, 175, 'TAILANDIA'),
(176, 176, 'TAYIKISTÁN'),
(177, 177, 'TIMOR ORIENTAL'),
(178, 178, 'TOGO'),
(179, 179, 'TOKELAU'),
(180, 180, 'TONGA'),
(181, 181, 'TRINIDAD Y TOBAGO'),
(182, 182, 'TURKMENISTÁN'),
(183, 183, 'TURQUÍA'),
(184, 184, 'TUVALU'),
(185, 185, 'TÚNEZ'),
(186, 186, 'UCRANIA'),
(187, 187, 'UGANDA'),
(188, 188, 'URUGUAY'),
(189, 189, 'UZBEKISTÁN'),
(190, 190, 'VANUATU'),
(191, 191, 'VENEZUELA (REPÚBLICA BOLIVARIANA DE)'),
(192, 192, 'VIETNAM'),
(193, 193, 'YEMEN'),
(194, 194, 'ZAMBIA'),
(195, 195, 'ZIMBABUE'),
(196, 196, 'REPÚBLICA DE MACEDONIA'),
(197, 197, 'NO REGISTRADO'),
(198, 198, 'ANTILLAS NEERLANDESAS'),
(199, 199, 'ARUBA'),
(200, 200, 'BERMUDAS'),
(201, 201, 'ISLAS CAIMÁN'),
(202, 202, 'GROENLANDIA'),
(203, 203, 'ISLAS MALVINAS'),
(204, 204, 'YUGOSLAVIA'),
(205, 205, 'PUERTO RICO'),
(206, 206, 'HONG KONG'),
(207, 207, 'FORMOSA'),
(208, 208, 'NO ESPECIFICOS'),
(209, 209, 'ISLAS VIRGENES BRITANICAS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_parametrica_tipo_documento_identidad`
--

DROP TABLE IF EXISTS `fact_parametrica_tipo_documento_identidad`;
CREATE TABLE IF NOT EXISTS `fact_parametrica_tipo_documento_identidad` (
  `id_parametrica_tipo_documento_identidad` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_clasificador` int(11) DEFAULT NULL,
  `descripcion` varchar(75) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_parametrica_tipo_documento_identidad`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `fact_parametrica_tipo_documento_identidad`
--

INSERT INTO `fact_parametrica_tipo_documento_identidad` (`id_parametrica_tipo_documento_identidad`, `codigo_clasificador`, `descripcion`) VALUES
(1, 1, 'CI - CEDULA DE IDENTIDAD'),
(2, 2, 'CEX - CEDULA DE IDENTIDAD DE EXTRANJERO'),
(3, 3, 'PAS - PASAPORTE'),
(4, 4, 'OD - OTRO DOCUMENTO DE IDENTIDAD'),
(5, 5, 'NIT - NÚMERO DE IDENTIFICACIÓN TRIBUTARIA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_parametrica_tipo_documento_sector`
--

DROP TABLE IF EXISTS `fact_parametrica_tipo_documento_sector`;
CREATE TABLE IF NOT EXISTS `fact_parametrica_tipo_documento_sector` (
  `id_parametrica_tipo_documento_sector` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_clasificador` int(11) DEFAULT NULL,
  `descripcion` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_parametrica_tipo_documento_sector`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `fact_parametrica_tipo_documento_sector`
--

INSERT INTO `fact_parametrica_tipo_documento_sector` (`id_parametrica_tipo_documento_sector`, `codigo_clasificador`, `descripcion`) VALUES
(1, 1, 'FACTURA COMPRA-VENTA'),
(2, 2, 'FACTURA DE ALQUILER DE BIENES INMUEBLES'),
(3, 3, 'FACTURA COMERCIAL DE EXPORTACIÓN'),
(4, 4, 'FACTURA COMERCIAL DE EXPORTACIÓN EN LIBRE CONSIGNACIÓN'),
(5, 5, 'FACTURA DE ZONA FRANCA'),
(6, 6, 'FACTURA DE SERVICIO TURÍSTICO Y HOSPEDAJE'),
(7, 7, 'FACTURA DE COMERCIALIZACIÓN DE ALIMENTOS – SEGURIDAD '),
(8, 8, 'FACTURA DE TASA CERO POR VENTA DE LIBROS Y TRANSPORTE INTERNACIONAL DE CARGA'),
(9, 9, 'FACTURA DE COMPRA Y VENTA DE MONEDA EXTRANJERA '),
(10, 10, 'FACTURA DUTTY FREE'),
(11, 11, 'FACTURA SECTORES EDUCATIVOS'),
(12, 12, 'FACTURA DE COMERCIALIZACIÓN DE HIDROCARBUROS'),
(13, 13, 'FACTURA DE SERVICIOS BÁSICOS'),
(14, 14, 'FACTURA PRODUCTOS ALCANZADOS POR EL ICE'),
(15, 15, 'FACTURA DE ENTIDADES FINANCIERAS'),
(16, 16, 'FACTURA DE HOTELES'),
(17, 17, 'FACTURA DE HOSPITALES/CLÍNICAS'),
(18, 18, 'FACTURA DE JUEGOS DE AZAR'),
(19, 19, 'FACTURA HIDROCARBUROS ALCANZADA IEHD'),
(20, 20, 'FACTURA COMERCIAL DE EXPORTACIÓN DE MINERALES'),
(21, 21, 'FACTURA VENTA INTERNA MINERALES'),
(22, 22, 'FACTURA TELECOMUNICACIONES'),
(23, 23, 'FACTURA PREVALORADA'),
(24, 24, 'NOTA DE CRÉDITO-DÉBITO'),
(25, 28, 'FACTURA COMERCIAL DE EXPORTACIÓN DE SERVICIOS'),
(26, 29, 'NOTA DE CONCILIACION'),
(27, 30, 'BOLETO AEREO'),
(28, 31, 'FACTURA DE SUMINISTRO'),
(29, 32, 'FACTURA ICE ZONA FRANCA'),
(30, 33, 'FACTURA TASA CERO BIENES CAPITAL'),
(31, 34, 'FACTURA DE SEGUROS'),
(32, 35, 'FACTURA COMPRA VENTA BONIFICACIONES'),
(33, 36, 'FACTURA PREVALORADA SDCF'),
(34, 37, 'FACTURA DE COMERCIALIZACIÓN DE GNV'),
(35, 38, 'FACTURA HIDROCARBUROS NO ALCANZADA IEHD'),
(36, 39, 'FACTURA COMERCIALIZACION GN y GLP'),
(37, 40, 'FACTURA DE SERVICIOS BÁSICOS ZF'),
(38, 41, 'FACTURA COMPRA VENTA TASAS'),
(39, 42, 'FACTURA ALQUILER ZF'),
(40, 43, 'FACTURA COMERCIAL DE EXPORTACIÓN HIDROCARBUROS'),
(41, 44, 'FACTURA IMPORTACION COMERCIALIZACION LUBRICANTES'),
(42, 45, 'FACTURA COMERCIAL DE EXPORTACION PRECIO VENTA'),
(43, 46, 'FACTURA SECTORES EDUCATIVO ZONA FRANCA'),
(44, 47, 'NOTA CREDITO DEBITO DESCUENTO'),
(45, 48, 'NOTA CREDITO DEBITO ICE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_parametrica_tipo_emision`
--

DROP TABLE IF EXISTS `fact_parametrica_tipo_emision`;
CREATE TABLE IF NOT EXISTS `fact_parametrica_tipo_emision` (
  `id_parametrica_tipo_emision` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_clasificador` int(11) DEFAULT NULL,
  `descripcion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_parametrica_tipo_emision`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `fact_parametrica_tipo_emision`
--

INSERT INTO `fact_parametrica_tipo_emision` (`id_parametrica_tipo_emision`, `codigo_clasificador`, `descripcion`) VALUES
(1, 1, 'EN LINEA'),
(2, 2, 'FUERA DE LINEA'),
(3, 3, 'MASIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_parametrica_tipo_factura`
--

DROP TABLE IF EXISTS `fact_parametrica_tipo_factura`;
CREATE TABLE IF NOT EXISTS `fact_parametrica_tipo_factura` (
  `id_parametrica_tipo_factura` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_clasificador` int(11) DEFAULT NULL,
  `descripcion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_parametrica_tipo_factura`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `fact_parametrica_tipo_factura`
--

INSERT INTO `fact_parametrica_tipo_factura` (`id_parametrica_tipo_factura`, `codigo_clasificador`, `descripcion`) VALUES
(1, 1, 'FACTURA CON DERECHO A CREDITO FISCAL'),
(2, 2, 'FACTURA SIN DERECHO A CREDITO FISCAL'),
(3, 3, 'DOCUMENTO DE AJUSTE'),
(4, 4, 'DOCUMENTO EQUIVALENTE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_parametrica_tipo_habitacion`
--

DROP TABLE IF EXISTS `fact_parametrica_tipo_habitacion`;
CREATE TABLE IF NOT EXISTS `fact_parametrica_tipo_habitacion` (
  `id_parametrica_tipo_habitacion` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_clasificador` int(11) DEFAULT NULL,
  `descripcion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_parametrica_tipo_habitacion`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `fact_parametrica_tipo_habitacion`
--

INSERT INTO `fact_parametrica_tipo_habitacion` (`id_parametrica_tipo_habitacion`, `codigo_clasificador`, `descripcion`) VALUES
(1, 1, 'HABITACIÓN SENCILLA'),
(2, 2, 'HABITACIÓN DOBLE'),
(3, 3, 'HABITACION DOBLE DE USO INDIVIDUAL'),
(4, 4, 'HABITACIÓN DOBLE CON CAMA SUPLETORIA'),
(5, 5, 'HABITACIÓN MATRIMONIAL'),
(6, 6, 'HABITACIÓN TRIPLE'),
(7, 7, 'HABITACIÓN CUÁDRUPLE'),
(8, 8, 'HABITACIÓN FAMILIAR'),
(9, 9, 'JUNIOR SUITE'),
(10, 10, 'SUITE'),
(11, 11, 'SUITE DOBLE'),
(12, 12, 'SUITE NUPCIAL'),
(13, 13, 'SUITE PRESIDENCIAL'),
(14, 14, 'CABAÑA'),
(15, 15, 'DEPARTAMENTO'),
(16, 16, 'DORMITORIOS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_parametrica_tipo_metodo_pago`
--

DROP TABLE IF EXISTS `fact_parametrica_tipo_metodo_pago`;
CREATE TABLE IF NOT EXISTS `fact_parametrica_tipo_metodo_pago` (
  `id_parametrica_tipo_metodo_pago` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_clasificador` int(11) DEFAULT NULL,
  `descripcion` varchar(75) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_parametrica_tipo_metodo_pago`)
) ENGINE=InnoDB AUTO_INCREMENT=307 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `fact_parametrica_tipo_metodo_pago`
--

INSERT INTO `fact_parametrica_tipo_metodo_pago` (`id_parametrica_tipo_metodo_pago`, `codigo_clasificador`, `descripcion`) VALUES
(1, 1, 'EFECTIVO'),
(2, 2, 'TARJETA'),
(3, 3, 'CHEQUE'),
(4, 4, 'VALES'),
(5, 5, 'OTROS'),
(6, 6, 'PAGO POSTERIOR'),
(7, 7, 'TRANSFERENCIA BANCARIA'),
(8, 8, 'DEPOSITO EN CUENTA'),
(9, 9, 'TRANSFERENCIA SWIFT'),
(10, 10, 'EFECTIVO-TARJETA'),
(11, 11, 'EFECTIVO-CHEQUE'),
(12, 12, 'EFECTIVO-VALES'),
(13, 13, 'EFECTIVO-TRANSFERENCIA BANCARIA'),
(14, 14, 'EFECTIVO-DEPOSITO EN CUENTA'),
(15, 15, 'EFECTIVO-TRANSFERENCIA SWIFT'),
(16, 16, 'TARJETA-CHEQUE'),
(17, 17, 'TARJETA-VALES'),
(18, 18, 'TARJETA-TRANSFERENCIA BANCARIA'),
(19, 19, 'TARJETA-DEPOSITO EN CUENTA'),
(20, 20, 'TARJETA-TRANSFERENCIA SWIFT'),
(21, 21, 'VALES-TRANSFERENCIA BANCARIA'),
(22, 22, 'VALES-TDEPOSITO EN CUENTA'),
(23, 23, 'VALES-TRANSFERENCIA SWIFT'),
(24, 24, 'TRANSFERENCIA BANCARIA-DEPOSITO EN CUENTA'),
(25, 25, 'TRANSFERENCIA BANCARIA-TRANSFERENCIA SWIFT'),
(26, 26, 'DEPOSITO EN CUENTA-TRANSFERENCIA SWIFT'),
(27, 27, 'GIFT-CARD'),
(28, 30, 'GIFT-CARD OTROS'),
(29, 31, 'CANAL DE PAGO'),
(30, 32, 'BILLETERA MOVIL'),
(31, 33, 'PAGO ONLINE'),
(32, 34, 'EFECTIVO – PAGO POSTERIOR'),
(33, 35, 'EFECTIVO – GIFT CARD'),
(34, 36, 'EFECTIVO – CANAL PAGO'),
(35, 37, 'EFECTIVO – BILLETERA MOVIL'),
(36, 38, 'EFECTIVO – PAGO ONLINE'),
(37, 39, 'TARJETA – PAGO POSTERIOR'),
(38, 40, 'TARJETA – GIFT'),
(39, 41, 'TARJETA – CANAL PAGO'),
(40, 42, 'TARJETA – BILLETERA MOVIL'),
(41, 43, 'TARJETA – PAGO ONLINE'),
(42, 44, 'CHEQUE – VALES'),
(43, 45, 'CHEQUE – PAGO POSTERIOR'),
(44, 46, 'CHEQUE – TRANSFERENCIA'),
(45, 47, 'CHEQUE – DEPOSITO'),
(46, 48, 'CHEQUE – SWIFT'),
(47, 49, 'CHEQUE – GIFT'),
(48, 50, 'CHEQUE – CANAL PAGO'),
(49, 51, 'CHEQUE – BILLETERA'),
(50, 52, 'CHEQUE – PAGO ONLINE'),
(51, 53, 'VALES – GIFT'),
(52, 54, 'VALES – CANAL DE PAGO'),
(53, 55, 'VALES – BILLETERA'),
(54, 56, 'VALES – PAGO ONLINE'),
(55, 57, 'PAGO POSTERIOR – TRANSFERENCIA'),
(56, 58, 'PAGO POSTERIOR – DEPOSITO'),
(57, 59, 'PAGO POSTERIOR – SWIFT'),
(58, 60, 'PAGO POSTERIOR – GIFT'),
(59, 61, 'PAGO POSTERIOR – CANAL'),
(60, 62, 'PAGO POSTERIOR – BILLETERA'),
(61, 63, 'PAGO POSTERIOR – PAGO ONLINE'),
(62, 64, 'TRANSFERENCIA – GIFT'),
(63, 65, 'TRANSFERENCIA – CANAL'),
(64, 66, 'TRANSFERENCIA – BILLETERA'),
(65, 67, 'TRANSFERENCIA – PAGO ONLINE'),
(66, 68, 'DEPOSITO – GIFT'),
(67, 69, 'DEPOSITO – CANAL '),
(68, 70, 'DEPOSITO – BILLETERA'),
(69, 71, 'DEPOSITO – PAGO ONLINE'),
(70, 72, 'SWIFT – GIFT'),
(71, 73, 'SWIFT – CANAL'),
(72, 74, 'SWIFT – BILLETERA'),
(73, 75, 'SWIFT – PAGO ONLINE'),
(74, 76, 'GIFT – CANAL DE PAGO'),
(75, 77, 'GIFT – BILLETERA'),
(76, 78, 'GIFT – PAGO ONLINE'),
(77, 79, 'CANAL DE PAGO – BILLETERA'),
(78, 80, 'CANAL DE PAGO – PAGO ONLINE'),
(79, 81, 'BILLETERA – PAGO ONLINE'),
(80, 82, 'EFECTIVO - TARJETA - PAGO POSTERIOR'),
(81, 83, 'EFECTIVO - TARJETA - TRANSFERENCIA BANCARIA'),
(82, 84, 'EFECTIVO - TARJETA - DEPOSITO EN CUENTA'),
(83, 85, 'EFECTIVO - TARJETA - TRANSFERENCIA SWIFT'),
(84, 86, 'EFECTIVO - TARJETA - GIFT-CARD'),
(85, 87, 'EFECTIVO - TARJETA - CANAL DE PAGO'),
(86, 88, 'EFECTIVO - TARJETA - BILLETERA MOVIL'),
(87, 89, 'EFECTIVO - TARJETA - PAGO ONLINE'),
(88, 90, 'EFECTIVO – CHEQUE - PAGO POSTERIOR'),
(89, 91, 'EFECTIVO – CHEQUE - TRANSFERENCIA BANCARIA'),
(90, 92, 'EFECTIVO – CHEQUE - DEPOSITO EN CUENTA'),
(91, 93, 'EFECTIVO – CHEQUE - TRANSFERENCIA SWIFT'),
(92, 94, 'EFECTIVO – CHEQUE - GIFT-CARD'),
(93, 95, 'EFECTIVO – CHEQUE - CANAL DE PAGO'),
(94, 96, 'EFECTIVO – CHEQUE - BILLETERA MOVIL'),
(95, 97, 'EFECTIVO – CHEQUE - PAGO ONLINE'),
(96, 98, 'EFECTIVO – VALES - PAGO POSTERIOR'),
(97, 99, 'EFECTIVO – VALES - TRANSFERENCIA BANCARIA'),
(98, 100, 'EFECTIVO – VALES - DEPOSITO EN CUENTA'),
(99, 101, 'EFECTIVO – VALES - TRANSFERENCIA SWIFT'),
(100, 102, 'EFECTIVO – VALES - GIFT-CARD'),
(101, 103, 'EFECTIVO – VALES - CANAL DE PAGO'),
(102, 104, 'EFECTIVO – VALES - BILLETERA MOVIL'),
(103, 105, 'EFECTIVO – VALES - PAGO ONLINE'),
(104, 106, 'EFECTIVO – PAGO POSTERIOR - TRANSFERENCIA BANCARIA'),
(105, 107, 'EFECTIVO – PAGO POSTERIOR - DEPOSITO EN CUENTA'),
(106, 108, 'EFECTIVO – PAGO POSTERIOR - TRANSFERENCIA SWIFT'),
(107, 109, 'EFECTIVO – PAGO POSTERIOR - GIFT-CARD'),
(108, 110, 'EFECTIVO – PAGO POSTERIOR - CANAL DE PAGO'),
(109, 111, 'EFECTIVO – PAGO POSTERIOR - BILLETERA MOVIL'),
(110, 112, 'EFECTIVO – PAGO POSTERIOR - PAGO ONLINE'),
(111, 113, 'EFECTIVO – TRANSFERENCIA - DEPOSITO EN CUENTA'),
(112, 114, 'EFECTIVO – TRANSFERENCIA - TRANSFERENCIA SWIFT'),
(113, 115, 'EFECTIVO – TRANSFERENCIA - GIFT-CARD'),
(114, 116, 'EFECTIVO – TRANSFERENCIA - CANAL DE PAGO'),
(115, 117, 'EFECTIVO – TRANSFERENCIA - BILLETERA MOVIL'),
(116, 118, 'EFECTIVO – TRANSFERENCIA - PAGO ONLINE'),
(117, 119, 'EFECTIVO – DEPOSITO EN CUENTA - TRANSFERENCIA SWIFT'),
(118, 120, 'EFECTIVO – DEPOSITO EN CUENTA - GIFT-CARD'),
(119, 121, 'EFECTIVO – DEPOSITO EN CUENTA - CANAL DE PAGO'),
(120, 122, 'EFECTIVO – DEPOSITO EN CUENTA - BILLETERA MOVIL'),
(121, 123, 'EFECTIVO – DEPOSITO EN CUENTA - PAGO ONLINE'),
(122, 124, 'EFECTIVO – SWIFT - GIFT-CARD'),
(123, 125, 'EFECTIVO – SWIFT - CANAL DE PAGO'),
(124, 126, 'EFECTIVO – SWIFT - BILLETERA MOVIL'),
(125, 127, 'EFECTIVO – SWIFT - PAGO ONLINE'),
(126, 128, 'EFECTIVO – GIFT CARD - CANAL DE PAGO'),
(127, 129, 'EFECTIVO – GIFT CARD - BILLETERA MOVIL'),
(128, 130, 'EFECTIVO – GIFT CARD - PAGO ONLINE'),
(129, 131, 'EFECTIVO – CANAL PAGO - BILLETERA MOVIL'),
(130, 132, 'EFECTIVO – CANAL PAGO - PAGO ONLINE'),
(131, 133, 'EFECTIVO – BILLETERA MOVIL - PAGO ONLINE'),
(132, 134, 'TARJETA – CHEQUE - PAGO POSTERIOR'),
(133, 135, 'TARJETA – CHEQUE - TRANSFERENCIA BANCARIA'),
(134, 136, 'TARJETA – CHEQUE - DEPOSITO EN CUENTA'),
(135, 137, 'TARJETA – CHEQUE - TRANSFERENCIA SWIFT'),
(136, 138, 'TARJETA – CHEQUE - GIFT-CARD'),
(137, 139, 'TARJETA – CHEQUE - CANAL DE PAGO'),
(138, 140, 'TARJETA – CHEQUE - BILLETERA MOVIL'),
(139, 141, 'TARJETA – CHEQUE - PAGO ONLINE'),
(140, 142, 'TARJETA – VALES - PAGO POSTERIOR'),
(141, 143, 'TARJETA – VALES - TRANSFERENCIA BANCARIA'),
(142, 144, 'TARJETA – VALES - DEPOSITO EN CUENTA'),
(143, 145, 'TARJETA – VALES - TRANSFERENCIA SWIFT'),
(144, 146, 'TARJETA – VALES - GIFT-CARD'),
(145, 147, 'TARJETA – VALES - CANAL DE PAGO'),
(146, 148, 'TARJETA – VALES - BILLETERA MOVIL'),
(147, 149, 'TARJETA – VALES - PAGO ONLINE'),
(148, 150, 'TARJETA – PAGO POSTERIOR - TRANSFERENCIA BANCARIA'),
(149, 151, 'TARJETA – PAGO POSTERIOR - DEPOSITO EN CUENTA'),
(150, 152, 'TARJETA – PAGO POSTERIOR - TRANSFERENCIA SWIFT'),
(151, 153, 'TARJETA – PAGO POSTERIOR - GIFT-CARD'),
(152, 154, 'TARJETA – PAGO POSTERIOR - CANAL DE PAGO'),
(153, 155, 'TARJETA – PAGO POSTERIOR - BILLETERA MOVIL'),
(154, 156, 'TARJETA – PAGO POSTERIOR - PAGO ONLINE'),
(155, 157, 'TARJETA – TRANSFERENCIA - DEPOSITO EN CUENTA'),
(156, 158, 'TARJETA – TRANSFERENCIA - TRANSFERENCIA SWIFT'),
(157, 159, 'TARJETA – TRANSFERENCIA - GIFT-CARD'),
(158, 160, 'TARJETA – TRANSFERENCIA - CANAL DE PAGO'),
(159, 161, 'TARJETA – TRANSFERENCIA - BILLETERA MOVIL'),
(160, 162, 'TARJETA – TRANSFERENCIA - PAGO ONLINE'),
(161, 163, 'TARJETA – DEPOSITO - TRANSFERENCIA SWIFT'),
(162, 164, 'TARJETA – DEPOSITO - GIFT-CARD'),
(163, 165, 'TARJETA – DEPOSITO - CANAL DE PAGO'),
(164, 166, 'TARJETA – DEPOSITO - BILLETERA MOVIL'),
(165, 167, 'TARJETA – DEPOSITO - PAGO ONLINE'),
(166, 168, 'TARJETA – SWIFT - GIFT-CARD'),
(167, 169, 'TARJETA – SWIFT - CANAL DE PAGO'),
(168, 170, 'TARJETA – SWIFT - BILLETERA MOVIL'),
(169, 171, 'TARJETA – SWIFT - PAGO ONLINE'),
(170, 172, 'TARJETA – GIFT - CANAL DE PAGO'),
(171, 173, 'TARJETA – GIFT - BILLETERA MOVIL'),
(172, 174, 'TARJETA – GIFT - PAGO ONLINE'),
(173, 175, 'TARJETA – CANAL PAGO - BILLETERA MOVIL'),
(174, 176, 'TARJETA – CANAL PAGO - PAGO ONLINE'),
(175, 177, 'TARJETA – BILLETERA MOVIL - PAGO ONLINE'),
(176, 178, 'CHEQUE – VALES - PAGO POSTERIOR'),
(177, 179, 'CHEQUE – VALES - TRANSFERENCIA BANCARIA'),
(178, 180, 'CHEQUE – VALES - DEPOSITO EN CUENTA'),
(179, 181, 'CHEQUE – VALES - TRANSFERENCIA SWIFT'),
(180, 182, 'CHEQUE – VALES - GIFT-CARD'),
(181, 183, 'CHEQUE – VALES - CANAL DE PAGO'),
(182, 184, 'CHEQUE – VALES - BILLETERA MOVIL'),
(183, 185, 'CHEQUE – VALES - PAGO ONLINE'),
(184, 186, 'CHEQUE – PAGO POSTERIOR - TRANSFERENCIA BANCARIA'),
(185, 187, 'CHEQUE – PAGO POSTERIOR - DEPOSITO EN CUENTA'),
(186, 188, 'CHEQUE – PAGO POSTERIOR - TRANSFERENCIA SWIFT'),
(187, 189, 'CHEQUE – PAGO POSTERIOR - GIFT-CARD'),
(188, 190, 'CHEQUE – PAGO POSTERIOR - CANAL DE PAGO'),
(189, 191, 'CHEQUE – PAGO POSTERIOR - BILLETERA MOVIL'),
(190, 192, 'CHEQUE – PAGO POSTERIOR - PAGO ONLINE'),
(191, 193, 'CHEQUE – TRANSFERENCIA - DEPOSITO EN CUENTA'),
(192, 194, 'CHEQUE – TRANSFERENCIA - TRANSFERENCIA SWIFT'),
(193, 195, 'CHEQUE – TRANSFERENCIA - GIFT-CARD'),
(194, 196, 'CHEQUE – TRANSFERENCIA - CANAL DE PAGO'),
(195, 197, 'CHEQUE – TRANSFERENCIA - BILLETERA MOVIL'),
(196, 198, 'CHEQUE – TRANSFERENCIA - PAGO ONLINE'),
(197, 199, 'CHEQUE – DEPOSITO - TRANSFERENCIA SWIFT'),
(198, 200, 'CHEQUE – DEPOSITO - GIFT-CARD'),
(199, 201, 'CHEQUE – DEPOSITO - CANAL DE PAGO'),
(200, 202, 'CHEQUE – DEPOSITO - BILLETERA MOVIL'),
(201, 203, 'CHEQUE – DEPOSITO - PAGO ONLINE'),
(202, 204, 'CHEQUE – SWIFT - GIFT-CARD'),
(203, 205, 'CHEQUE – SWIFT - CANAL DE PAGO'),
(204, 206, 'CHEQUE – SWIFT - BILLETERA MOVIL'),
(205, 207, 'CHEQUE – SWIFT - PAGO ONLINE'),
(206, 208, 'CHEQUE – GIFT - CANAL DE PAGO'),
(207, 209, 'CHEQUE – GIFT - BILLETERA MOVIL'),
(208, 210, 'CHEQUE – GIFT - PAGO ONLINE'),
(209, 211, 'CHEQUE – CANAL PAGO - BILLETERA MOVIL'),
(210, 212, 'CHEQUE – CANAL PAGO - PAGO ONLINE'),
(211, 213, 'CHEQUE – BILLETERA - PAGO ONLINE'),
(212, 214, 'VALES – SWIFT - TRANSFERENCIA BANCARIA'),
(213, 215, 'VALES – SWIFT - DEPOSITO EN CUENTA'),
(214, 216, 'VALES – SWIFT - TRANSFERENCIA SWIFT'),
(215, 217, 'VALES – SWIFT - GIFT-CARD'),
(216, 218, 'VALES – SWIFT - CANAL DE PAGO'),
(217, 219, 'VALES – SWIFT - BILLETERA MOVIL'),
(218, 220, 'VALES – SWIFT - PAGO ONLINE'),
(219, 221, 'VALES – GIFT - DEPOSITO EN CUENTA'),
(220, 222, 'VALES – GIFT - TRANSFERENCIA SWIFT'),
(221, 223, 'VALES – GIFT - GIFT-CARD'),
(222, 224, 'VALES – GIFT - CANAL DE PAGO'),
(223, 225, 'VALES – GIFT - BILLETERA MOVIL'),
(224, 226, 'VALES – GIFT - PAGO ONLINE'),
(225, 227, 'VALES – CANAL DE PAGO - TRANSFERENCIA SWIFT'),
(226, 228, 'VALES – CANAL DE PAGO - GIFT-CARD'),
(227, 229, 'VALES – CANAL DE PAGO - CANAL DE PAGO'),
(228, 230, 'VALES – CANAL DE PAGO - BILLETERA MOVIL'),
(229, 231, 'VALES – CANAL DE PAGO - PAGO ONLINE'),
(230, 232, 'VALES – BILLETERA - GIFT-CARD'),
(231, 233, 'VALES – BILLETERA - CANAL DE PAGO'),
(232, 234, 'VALES – BILLETERA - BILLETERA MOVIL'),
(233, 235, 'VALES – BILLETERA - PAGO ONLINE'),
(234, 236, 'VALES – PAGO ONLINE - CANAL DE PAGO'),
(235, 237, 'VALES – PAGO ONLINE - BILLETERA MOVIL'),
(236, 238, 'VALES – PAGO ONLINE - PAGO ONLINE'),
(237, 239, 'PAGO POSTERIOR – TRANSFERENCIA - DEPOSITO EN CUENTA'),
(238, 240, 'PAGO POSTERIOR – TRANSFERENCIA - TRANSFERENCIA SWIFT'),
(239, 241, 'PAGO POSTERIOR – TRANSFERENCIA - GIFT-CARD'),
(240, 242, 'PAGO POSTERIOR – TRANSFERENCIA - CANAL DE PAGO'),
(241, 243, 'PAGO POSTERIOR – TRANSFERENCIA - BILLETERA MOVIL'),
(242, 244, 'PAGO POSTERIOR – TRANSFERENCIA - PAGO ONLINE'),
(243, 245, 'PAGO POSTERIOR – DEPOSITO - TRANSFERENCIA SWIFT'),
(244, 246, 'PAGO POSTERIOR – DEPOSITO - GIFT-CARD'),
(245, 247, 'PAGO POSTERIOR – DEPOSITO - CANAL DE PAGO'),
(246, 248, 'PAGO POSTERIOR – DEPOSITO - BILLETERA MOVIL'),
(247, 249, 'PAGO POSTERIOR – DEPOSITO - PAGO ONLINE'),
(248, 250, 'PAGO POSTERIOR – SWIFT - GIFT-CARD'),
(249, 251, 'PAGO POSTERIOR – SWIFT - CANAL DE PAGO'),
(250, 252, 'PAGO POSTERIOR – SWIFT - BILLETERA MOVIL'),
(251, 253, 'PAGO POSTERIOR – SWIFT - PAGO ONLINE'),
(252, 254, 'PAGO POSTERIOR – GIFT - CANAL DE PAGO'),
(253, 255, 'PAGO POSTERIOR – GIFT - BILLETERA MOVIL'),
(254, 256, 'PAGO POSTERIOR – GIFT - PAGO ONLINE'),
(255, 257, 'PAGO POSTERIOR – CANAL - BILLETERA MOVIL'),
(256, 258, 'PAGO POSTERIOR – CANAL - PAGO ONLINE'),
(257, 259, 'PAGO POSTERIOR – BILLETERA - PAGO ONLINE'),
(258, 260, 'TRANSFERENCIA – DEPOSITO  - TRANSFERENCIA SWIFT'),
(259, 261, 'TRANSFERENCIA – DEPOSITO  - GIFT-CARD'),
(260, 262, 'TRANSFERENCIA – DEPOSITO  - CANAL DE PAGO'),
(261, 263, 'TRANSFERENCIA – DEPOSITO  - BILLETERA MOVIL'),
(262, 264, 'TRANSFERENCIA – DEPOSITO  - PAGO ONLINE'),
(263, 265, 'TRANSFERENCIA – SWIFT - GIFT-CARD'),
(264, 266, 'TRANSFERENCIA – SWIFT - CANAL DE PAGO'),
(265, 267, 'TRANSFERENCIA – SWIFT - BILLETERA MOVIL'),
(266, 268, 'TRANSFERENCIA – SWIFT - PAGO ONLINE'),
(267, 269, 'TRANSFERENCIA – GIFT - CANAL DE PAGO'),
(268, 270, 'TRANSFERENCIA – GIFT - BILLETERA MOVIL'),
(269, 271, 'TRANSFERENCIA – GIFT-CARD - PAGO ONLINE'),
(270, 272, 'TRANSFERENCIA – CANAL - BILLETERA MOVIL'),
(271, 273, 'TRANSFERENCIA – CANAL - PAGO ONLINE'),
(272, 274, 'TRANSFERENCIA – BILLETERA - PAGO ONLINE'),
(273, 275, 'DEPOSITO – SWIFT - GIFT-CARD'),
(274, 276, 'DEPOSITO – SWIFT - CANAL DE PAGO'),
(275, 277, 'DEPOSITO – SWIFT - BILLETERA MOVIL'),
(276, 278, 'DEPOSITO – SWIFT - PAGO ONLINE'),
(277, 279, 'DEPOSITO – GIFT - CANAL DE PAGO'),
(278, 280, 'DEPOSITO – GIFT - BILLETERA MOVIL'),
(279, 281, 'DEPOSITO – GIFT - PAGO ONLINE'),
(280, 282, 'DEPOSITO – CANAL  - BILLETERA MOVIL'),
(281, 283, 'DEPOSITO – CANAL  - PAGO ONLINE'),
(282, 284, 'DEPOSITO – BILLETERA - PAGO ONLINE'),
(283, 285, 'SWIFT – GIFT - CANAL DE PAGO'),
(284, 286, 'SWIFT – GIFT - BILLETERA MOVIL'),
(285, 287, 'SWIFT – GIFT - PAGO ONLINE'),
(286, 288, 'SWIFT – CANAL - BILLETERA MOVIL'),
(287, 289, 'SWIFT – CANAL - PAGO ONLINE'),
(288, 290, 'SWIFT – BILLETERA - PAGO ONLINE'),
(289, 291, 'GIFT – CANAL DE PAGO - BILLETERA MOVIL'),
(290, 292, 'GIFT – CANAL DE PAGO - PAGO ONLINE'),
(291, 293, 'GIFT – BILLETERA - PAGO ONLINE'),
(292, 294, 'CANAL DE PAGO – BILLETERA - PAGO ONLINE'),
(293, 295, 'DEBITO AUTOMATICO'),
(294, 296, 'DEBITO AUTOMATICO – EFECTIVO'),
(295, 297, 'DEBITO AUTOMATICO -TARJETA'),
(296, 298, 'DEBITO AUTOMATICO – CHEQUE'),
(297, 299, 'DEBITO AUTOMATICO -  VALE'),
(298, 300, 'DEBITO AUTOMATICO -  PAGO POSTERIOR'),
(299, 301, 'DEBITO AUTOMATICO -  TRANSFERENCIA BANCARIA'),
(300, 302, 'DEBITO AUTOMATICO -  DEPOSITO EN CUENTA'),
(301, 303, 'DEBITO AUTOMATICO -  TRANSFERENCIA SWIFT'),
(302, 304, 'DEBITO AUTOMATICO -  GIFT CARD'),
(303, 305, 'DEBITO AUTOMATICO -  CANAL DE PAGO'),
(304, 306, 'DEBITO AUTOMATICO -  BILLETERA MOVIL'),
(305, 307, 'DEBITO AUTOMATICO -  PAGO ONLINE'),
(306, 308, 'DEBITO AUTOMATICO – OTRO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_parametrica_tipo_moneda`
--

DROP TABLE IF EXISTS `fact_parametrica_tipo_moneda`;
CREATE TABLE IF NOT EXISTS `fact_parametrica_tipo_moneda` (
  `id_parametrica_tipo_moneda` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_clasificador` int(11) DEFAULT NULL,
  `descripcion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_parametrica_tipo_moneda`)
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `fact_parametrica_tipo_moneda`
--

INSERT INTO `fact_parametrica_tipo_moneda` (`id_parametrica_tipo_moneda`, `codigo_clasificador`, `descripcion`) VALUES
(1, 1, 'BOLIVIANO'),
(2, 2, 'DOLAR'),
(3, 3, 'AFGANI'),
(4, 4, 'LEK'),
(5, 5, 'LIBRA ESTERLINA'),
(6, 6, 'DINAR'),
(7, 7, 'EURO'),
(8, 8, 'KUANZA DE ANGOLA'),
(9, 9, 'PESO ARGENTINO'),
(10, 10, 'DRAM ARMENIO'),
(11, 11, 'FLORÍN ARUBANO'),
(12, 12, 'DÓLAR AUSTRALIANO'),
(13, 13, 'MANAT AZERBAYANO'),
(14, 14, 'DÓLAR DE LAS BAHAMAS'),
(15, 15, 'DINAR DE BARÉIN'),
(16, 16, 'TAKA DE BANGLADÉS'),
(17, 17, 'DÓLAR DE LAS BARBADOS'),
(18, 18, 'RUBLO BIELORRUSO'),
(19, 19, 'DÓLAR BELICEÑO'),
(20, 20, 'GULTRUM BUTANÉS'),
(21, 21, 'MARCO CONVERTIBLE DE BOSNIA Y HERZEGOVINA'),
(22, 22, 'PULA DE BOTSUANA'),
(23, 23, 'REAL BRASILEÑO'),
(24, 24, 'DÓLAR DE BRUNEI'),
(25, 25, 'LEVA BÚLGARO'),
(26, 26, 'FRANCO CFA'),
(27, 27, 'KIAT DE BIRMANIA'),
(28, 28, 'FRANCO BURUNDÉS'),
(29, 29, 'RIEL CAMBOYANO'),
(30, 30, 'DÓLAR CANADIENSE'),
(31, 31, 'ESCUDO DE CABO VERDE'),
(32, 32, 'DÓLAR DE LAS ISLAS CAIMÁN'),
(33, 33, 'PESO CHILENO'),
(34, 34, 'YUAN, RENMINBI'),
(35, 35, 'PESO COLOMBIANO'),
(36, 36, 'FRANCO COMORANO'),
(37, 37, 'FRANCO CONGOLEÑO'),
(38, 38, 'COLÓN COSTARRICENSE'),
(39, 39, 'KUNA CROATA'),
(40, 40, 'PESO CUBANO'),
(41, 41, 'FLORÍN DE LAS ANTILLAS NEERLANDESAS'),
(42, 42, 'CORONA CHECA'),
(43, 43, 'CORONA DANESA'),
(44, 44, 'FRANCO YIBUTIANO'),
(45, 45, 'PESO DOMINICANO'),
(46, 46, 'DÓLAR ESTADOUNIDENSE'),
(47, 47, 'LIBRA EGIPCIA'),
(48, 48, 'COLÓN SALVADOREÑO'),
(49, 49, 'NAKFA DE ERITREA'),
(50, 50, 'BIR'),
(51, 51, 'FRANCO CFP'),
(52, 52, 'DALASI GAMBIANO'),
(53, 53, 'LARI GEORGIANO'),
(54, 54, 'CEDI DE GANA'),
(55, 55, 'LIBRA DE GIBRALTAR'),
(56, 56, 'QUETZAL'),
(57, 57, 'FRANCO GUINEANO'),
(58, 58, 'GURDE'),
(59, 59, 'LEMPIRA'),
(60, 60, 'FORINTO'),
(61, 61, 'CORONA ISLANDESA'),
(62, 62, 'RUPIA INDIA'),
(63, 63, 'RUPIA INDONESIA'),
(64, 64, 'RIAL IRANÍ'),
(65, 65, 'DINAR IRAKÍ'),
(66, 66, 'NUEVO SÉQUEL'),
(67, 67, 'DÓLAR JAMAICANO'),
(68, 68, 'YEN'),
(69, 69, 'DINAR JORDANO'),
(70, 70, 'TENGUE KAZAJO'),
(71, 71, 'CHELÍN KENIANO'),
(72, 72, 'WON NORCOREANO'),
(73, 73, 'WON SURCOREANO'),
(74, 74, 'DINAR KUWAITÍ'),
(75, 75, 'SOM KIRGUÍS'),
(76, 76, 'KIP'),
(77, 77, 'LATS'),
(78, 78, 'LIBRA LIBANESA'),
(79, 79, 'LOTI DE LESOTO'),
(80, 80, 'DÓLAR LIBERIANO'),
(81, 81, 'DINAR LIBIO'),
(82, 82, 'LITAS'),
(83, 83, 'PATACA DE MACAO'),
(84, 84, 'DENAR'),
(85, 85, 'ARIARI'),
(86, 86, 'KUACHA DE MALAUI'),
(87, 87, 'RINGIT'),
(88, 88, 'RUFIYA'),
(89, 89, 'UGUIYA'),
(90, 90, 'RUPIA DE MAURICIO'),
(91, 91, 'PESO MEXICANO'),
(92, 92, 'DÓLAR MICRONESIO'),
(93, 93, 'LEU MOLDAVO'),
(94, 94, 'TUGRIK MONGOL'),
(95, 95, 'DÍRHAM'),
(96, 96, 'METICAL'),
(97, 97, 'DÓLAR DE NAMIBIA'),
(98, 98, 'DÓLAR NAURUANO'),
(99, 99, 'RUPIA NEPALÍ'),
(100, 100, 'DÓLAR DE NUEVA ZELANDA'),
(101, 101, 'CÓRDOBA NICARAGÜENSE'),
(102, 102, 'NAIRA NIGERIANO'),
(103, 103, 'CORONA NORUEGA'),
(104, 104, 'RIAL DE OMÁN'),
(105, 105, 'RUPIA PAKISTANÍ'),
(106, 106, 'BALBOA PANAMEÑO'),
(107, 107, 'KINA'),
(108, 108, 'GUARANÍ PARAGUAYO'),
(109, 109, 'NUEVO SOL PERUANO'),
(110, 110, 'PESO FILIPINO'),
(111, 111, 'ZLOTI'),
(112, 112, 'RIAL CATARÍ'),
(113, 113, 'LEU RUMANO'),
(114, 114, 'RUBLO'),
(115, 115, 'FRANCO RUANDÉS'),
(116, 116, 'DÓLAR DEL CARIBE ORIENTAL'),
(117, 117, 'TALA'),
(118, 118, 'DOBRA'),
(119, 119, 'RIAL SAUDÍ'),
(120, 120, 'DINAR SERBIO'),
(121, 121, 'RUPIA SEYCHELLENSE'),
(122, 122, 'LEONA'),
(123, 123, 'DÓLAR SINGAPURENSE'),
(124, 124, 'DÓLAR SALOMONENSE'),
(125, 125, 'CHELÍN SOMALÍ'),
(126, 126, 'RAND'),
(127, 127, 'LIBRA SURSUDANESA'),
(128, 128, 'RUPIA CEILANDESA'),
(129, 129, 'LIBRA SUDANESA'),
(130, 130, 'DÓLAR SURINAMÉS'),
(131, 131, 'LILANGENI'),
(132, 132, 'CORONA SUECA'),
(133, 133, 'FRANCO SUIZO'),
(134, 134, 'LIBRA SIRIA'),
(135, 135, 'NUEVO DÓLAR DE TAIWÁN'),
(136, 136, 'SOMONI'),
(137, 137, 'CHELÍN TANZANIANO'),
(138, 138, 'BAT'),
(139, 139, 'PAANGA'),
(140, 140, 'DÓLAR TRINITENSE'),
(141, 141, 'DINAR TUNECINO'),
(142, 142, 'LIRA TURCA'),
(143, 143, 'MANAT TURCOMANO'),
(144, 144, 'CHELÍN UGANDÉS'),
(145, 145, 'GRIVNA'),
(146, 146, 'PESO URUGUAYO'),
(147, 147, 'SUM'),
(148, 148, 'VATU DO VANUATU'),
(149, 149, 'BOLÍVAR FUERTE'),
(150, 150, 'DONG'),
(151, 151, 'RIAL YEMENÍ'),
(152, 152, 'KUACHA ZAMBIANO'),
(153, 153, 'DÓLAR ZIMBABUENSE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_parametrica_tipo_punto_venta`
--

DROP TABLE IF EXISTS `fact_parametrica_tipo_punto_venta`;
CREATE TABLE IF NOT EXISTS `fact_parametrica_tipo_punto_venta` (
  `id_parametrica_tipo_punto_venta` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_clasificador` int(11) DEFAULT NULL,
  `descripcion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_parametrica_tipo_punto_venta`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `fact_parametrica_tipo_punto_venta`
--

INSERT INTO `fact_parametrica_tipo_punto_venta` (`id_parametrica_tipo_punto_venta`, `codigo_clasificador`, `descripcion`) VALUES
(1, 1, 'PUNTO VENTA COMISIONISTA'),
(2, 2, 'PUNTO VENTA VENTANILLA DE COBRANZA'),
(3, 3, 'PUNTO DE VENTA MOVILES'),
(4, 4, 'PUNTO DE VENTA YPFB'),
(5, 5, 'PUNTO DE VENTA CAJEROS'),
(6, 6, 'PUNTO DE VENTA CONJUNTA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_parametrica_unidad_medida`
--

DROP TABLE IF EXISTS `fact_parametrica_unidad_medida`;
CREATE TABLE IF NOT EXISTS `fact_parametrica_unidad_medida` (
  `id_parametrica_unidad_medida` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_clasificador` int(11) DEFAULT NULL,
  `descripcion` varchar(75) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_parametrica_unidad_medida`)
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `fact_parametrica_unidad_medida`
--

INSERT INTO `fact_parametrica_unidad_medida` (`id_parametrica_unidad_medida`, `codigo_clasificador`, `descripcion`) VALUES
(1, 1, 'BOBINAS'),
(2, 2, 'BALDE'),
(3, 3, 'BARRILES'),
(4, 4, 'BOLSA'),
(5, 5, 'BOTELLAS'),
(6, 6, 'CAJA'),
(7, 7, 'CARTONES'),
(8, 8, 'CENTIMETRO CUADRADO'),
(9, 9, 'CENTIMETRO CUBICO'),
(10, 10, 'CENTIMETRO LINEAL'),
(11, 11, 'CIENTO DE UNIDADES'),
(12, 12, 'CILINDRO'),
(13, 13, 'CONOS'),
(14, 14, 'DOCENA'),
(15, 15, 'FARDO'),
(16, 16, 'GALON INGLES'),
(17, 17, 'GRAMO'),
(18, 18, 'GRUESA'),
(19, 19, 'HECTOLITRO'),
(20, 20, 'HOJA'),
(21, 21, 'JUEGO'),
(22, 22, 'KILOGRAMO'),
(23, 23, 'KILOMETRO'),
(24, 24, 'KILOVATIO HORA'),
(25, 25, 'KIT'),
(26, 26, 'LATAS'),
(27, 27, 'LIBRAS'),
(28, 28, 'LITRO'),
(29, 29, 'MEGAWATT HORA'),
(30, 30, 'METRO'),
(31, 31, 'METRO CUADRADO'),
(32, 32, 'METRO CUBICO'),
(33, 33, 'MILIGRAMOS'),
(34, 34, 'MILILITRO'),
(35, 35, 'MILIMETRO'),
(36, 36, 'MILIMETRO CUADRADO'),
(37, 37, 'MILIMETRO CUBICO'),
(38, 38, 'MILLARES'),
(39, 39, 'MILLON DE UNIDADES'),
(40, 40, 'ONZAS'),
(41, 41, 'PALETAS'),
(42, 42, 'PAQUETE'),
(43, 43, 'PAR'),
(44, 44, 'PIES'),
(45, 45, 'PIES CUADRADOS'),
(46, 46, 'PIES CUBICOS'),
(47, 47, 'PIEZAS'),
(48, 48, 'PLACAS'),
(49, 49, 'PLIEGO'),
(50, 50, 'PULGADAS'),
(51, 51, 'RESMA'),
(52, 52, 'TAMBOR'),
(53, 53, 'TONELADA CORTA'),
(54, 54, 'TONELADA LARGA'),
(55, 55, 'TONELADAS'),
(56, 56, 'TUBOS'),
(57, 57, 'UNIDAD (BIENES)'),
(58, 58, 'UNIDAD (SERVICIOS)'),
(59, 59, 'US GALON (3,7843 L)'),
(60, 60, 'YARDA'),
(61, 61, 'YARDA CUADRADA'),
(62, 62, 'OTRO'),
(63, 63, 'ONZA TROY'),
(64, 64, 'LIBRA FINA'),
(65, 65, 'DISPLAY'),
(66, 66, 'BULTO'),
(67, 67, 'DIAS'),
(68, 68, 'MESES'),
(69, 69, 'QUINTAL'),
(70, 70, 'ROLLO'),
(71, 71, 'HORAS'),
(72, 72, 'AGUJA'),
(73, 73, 'AMPOLLA'),
(74, 74, 'BIDÓN'),
(75, 75, 'BOLSA'),
(76, 76, 'CAPSULA'),
(77, 77, 'CARTUCHO'),
(78, 78, 'COMPRIMIDO'),
(79, 79, 'ESTUCHE'),
(80, 80, 'FRASCO'),
(81, 81, 'JERINGA'),
(82, 82, 'MINI BOTELLA'),
(83, 83, 'SACHET'),
(84, 84, 'TABLETA'),
(85, 85, 'TERMO'),
(86, 86, 'TUBO'),
(87, 87, 'BARRIL (EEUU) 60 F'),
(88, 88, 'BARRIL [42 GALONES(EEUU)]'),
(89, 89, 'METRO CUBICO 68F VOL'),
(90, 90, 'MIL PIES CUBICOS 14696 PSI'),
(91, 91, 'MIL PIES CUBICOS 14696 PSI 68FAH'),
(92, 92, 'MILLAR DE PIES CUBICOS (1000 PC)'),
(93, 93, 'MILLONES DE PIES CUBICOS (1000000 PC)'),
(94, 94, 'MILLONES DE BTU (1000000 BTU)'),
(95, 95, 'UNIDAD TERMICA BRITANICA (TI)'),
(96, 96, 'POMO'),
(97, 97, 'VASO'),
(98, 98, 'TETRAPACK'),
(99, 99, 'CARTOLA'),
(100, 100, 'JABA'),
(101, 101, 'YARDA'),
(102, 102, 'BANDEJA'),
(103, 103, 'TURRIL'),
(104, 104, 'BLISTER'),
(105, 105, 'TIRA'),
(106, 106, 'MEGAWATT'),
(107, 107, 'KILOWATT'),
(108, 108, 'AMORTIZACION'),
(109, 109, 'OVULOS'),
(110, 110, 'SUPOSITORIOS'),
(111, 111, 'SOBRES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_periodos`
--

DROP TABLE IF EXISTS `fact_periodos`;
CREATE TABLE IF NOT EXISTS `fact_periodos` (
  `idperiodo` int(11) NOT NULL AUTO_INCREMENT,
  `emision` date DEFAULT NULL,
  `vencimiento` date DEFAULT NULL,
  `medicion` date DEFAULT NULL,
  `semision` date DEFAULT NULL,
  `idproceso` int(11) NOT NULL,
  `usuario` int(11) DEFAULT NULL,
  `fecstatus` date DEFAULT NULL,
  `estatus` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idperiodo`),
  KEY `fk_periodos_procesos1_idx` (`idproceso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_postes`
--

DROP TABLE IF EXISTS `fact_postes`;
CREATE TABLE IF NOT EXISTS `fact_postes` (
  `idposte` int(11) NOT NULL AUTO_INCREMENT,
  `poste` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `distancia` int(11) DEFAULT NULL,
  `unidades` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` int(11) DEFAULT NULL,
  `idcentro` int(11) NOT NULL,
  PRIMARY KEY (`idposte`),
  KEY `fk_postes_centros1_idx` (`idcentro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_procesos`
--

DROP TABLE IF EXISTS `fact_procesos`;
CREATE TABLE IF NOT EXISTS `fact_procesos` (
  `idproceso` int(11) NOT NULL AUTO_INCREMENT,
  `proceso` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` int(11) NOT NULL,
  PRIMARY KEY (`idproceso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_producto`
--

DROP TABLE IF EXISTS `fact_producto`;
CREATE TABLE IF NOT EXISTS `fact_producto` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `cod_producto` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre_producto` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_unidad_medida` int(11) NOT NULL,
  `id_producto_servicio` int(11) NOT NULL,
  `estado_producto` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `precio_venta` float(7,2) DEFAULT NULL,
  `id_categoria` int(11) NOT NULL,
  PRIMARY KEY (`id_producto`),
  KEY `fk_producto_categoria1_idx` (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_producto_servicio`
--

DROP TABLE IF EXISTS `fact_producto_servicio`;
CREATE TABLE IF NOT EXISTS `fact_producto_servicio` (
  `id_producto_servicio` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_actividad` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `codigo_producto` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `descripcion_producto` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_producto_servicio`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `fact_producto_servicio`
--

INSERT INTO `fact_producto_servicio` (`id_producto_servicio`, `codigo_actividad`, `codigo_producto`, `descripcion_producto`) VALUES
(1, '351000', '86311', 'SERVICIOS DE TRANSMISIÓN DE ELECTRICIDAD (A COMISIÓN O POR CONTRATO)'),
(2, '351000', '86312', 'SERVICIOS DE DISTRIBUCIÓN DE ELECTRICIDAD (A COMISIÓN O POR CONTRATO)'),
(3, '351000', '99100', 'OTROS PRODUCTOS O SERVICIOS ALCANZADOS POR EL IVA'),
(4, '351000', '863119', 'SERVICIOS DE TRANSMISIÓN DE ELECTRICIDAD (A COMISIÓN O POR CONTRATO) IMPORTADO'),
(5, '351000', '863129', 'SERVICIOS DE DISTRIBUCIÓN DE ELECTRICIDAD (A COMISIÓN O POR CONTRATO) IMPORTADO'),
(6, '351000', '991009', 'OTROS PRODUCTOS O SERVICIOS ALCANZADOS POR EL IVA IMPORTADO'),
(7, '351000', '99742', 'SERVICIOS DE GENERACIÓN, CAPTACIÓN Y DISTRIBUCIÓN DE ENERGÍA ELÉCTRICA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_propiedades`
--

DROP TABLE IF EXISTS `fact_propiedades`;
CREATE TABLE IF NOT EXISTS `fact_propiedades` (
  `idpropiedad` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(5) COLLATE utf8_spanish_ci DEFAULT NULL,
  `propiedad` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` int(11) NOT NULL,
  PRIMARY KEY (`idpropiedad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_proveedor`
--

DROP TABLE IF EXISTS `fact_proveedor`;
CREATE TABLE IF NOT EXISTS `fact_proveedor` (
  `id_proveedor` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_proveedor` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `razon_social` varchar(75) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nit_ci` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `celular` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `contacto` varchar(75) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cel_contacto` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_proveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_punto_venta`
--

DROP TABLE IF EXISTS `fact_punto_venta`;
CREATE TABLE IF NOT EXISTS `fact_punto_venta` (
  `id_punto_venta` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_sucursal` tinyint(4) NOT NULL,
  `codigo_punto_venta` tinyint(4) NOT NULL,
  `codigo_tipo_punto_venta` tinyint(4) NOT NULL,
  `descripcion_punto_venta` varchar(75) COLLATE utf8_spanish_ci NOT NULL,
  `nombre_punto_venta` varchar(75) COLLATE utf8_spanish_ci NOT NULL,
  `cont_fact` int(11) DEFAULT '1',
  PRIMARY KEY (`id_punto_venta`),
  UNIQUE KEY `codigo_punto_venta_UNIQUE` (`codigo_punto_venta`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `fact_punto_venta`
--

INSERT INTO `fact_punto_venta` (`id_punto_venta`, `codigo_sucursal`, `codigo_punto_venta`, `codigo_tipo_punto_venta`, `descripcion_punto_venta`, `nombre_punto_venta`, `cont_fact`) VALUES
(1, 0, 0, 5, 'CASA MATRIZ', 'CASA MATRIZ', 1),
(2, 0, 1, 5, 'pv1', 'PV1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_recargos`
--

DROP TABLE IF EXISTS `fact_recargos`;
CREATE TABLE IF NOT EXISTS `fact_recargos` (
  `idrecargo` int(11) NOT NULL AUTO_INCREMENT,
  `idabonado` int(11) NOT NULL,
  `idlectura` int(11) NOT NULL,
  `importe` float(7,2) DEFAULT NULL,
  `cobrado` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `lecturacobrado` int(11) DEFAULT NULL,
  `usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`idrecargo`),
  KEY `fk_recargos_lecturas1_idx` (`idlectura`),
  KEY `fk_recargos_abonados1_idx` (`idabonado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_reposiciones`
--

DROP TABLE IF EXISTS `fact_reposiciones`;
CREATE TABLE IF NOT EXISTS `fact_reposiciones` (
  `idreposicion` int(11) NOT NULL AUTO_INCREMENT,
  `idcorte` int(11) NOT NULL,
  `numero` int(11) DEFAULT NULL,
  `idservicio` int(11) NOT NULL,
  `fecha_pago` datetime DEFAULT NULL,
  `fecha_repos` datetime DEFAULT NULL,
  `tiempo_tramite` float(7,2) DEFAULT NULL,
  `lectura_rep` int(11) DEFAULT NULL,
  `estado` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `empleado` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `solicitante` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ci` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `costo` float(7,2) DEFAULT NULL,
  `cobrado` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idlectura` int(11) DEFAULT NULL,
  `entregado` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fentrega` datetime DEFAULT NULL,
  `pentrega` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `devuelto` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fdevuelto` datetime DEFAULT NULL,
  `usuario` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idreposicion`),
  KEY `fk_reposiciones_cortes1_idx` (`idcorte`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_requisitos`
--

DROP TABLE IF EXISTS `fact_requisitos`;
CREATE TABLE IF NOT EXISTS `fact_requisitos` (
  `idrequisito` int(11) NOT NULL AUTO_INCREMENT,
  `correlativo` int(11) NOT NULL DEFAULT '1',
  `idservicio` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `idcliente` int(11) NOT NULL,
  `idzona` int(11) NOT NULL,
  `idcalle` int(11) NOT NULL,
  `numero` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `referencias` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `atencion` datetime DEFAULT NULL,
  `empleado` varchar(75) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idrequisito`),
  KEY `fk_requisitos_servicios1_idx` (`idservicio`),
  KEY `fk_requisitos_cliente1_idx` (`idcliente`),
  KEY `fk_requisitos_zonas1_idx` (`idzona`),
  KEY `fk_requisitos_calles1_idx` (`idcalle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_resoluciones`
--

DROP TABLE IF EXISTS `fact_resoluciones`;
CREATE TABLE IF NOT EXISTS `fact_resoluciones` (
  `idresolucion` int(11) NOT NULL AUTO_INCREMENT,
  `resolucion` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `nota` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idresolucion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_salida`
--

DROP TABLE IF EXISTS `fact_salida`;
CREATE TABLE IF NOT EXISTS `fact_salida` (
  `id_salida` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_salida` datetime DEFAULT NULL,
  `observacion_salida` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_orden` int(11) NOT NULL,
  `id_empleado_responsable_salida` int(11) NOT NULL,
  PRIMARY KEY (`id_salida`),
  KEY `fk_salida_orden1_idx` (`id_orden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_servicios`
--

DROP TABLE IF EXISTS `fact_servicios`;
CREATE TABLE IF NOT EXISTS `fact_servicios` (
  `idservicio` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idservicio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_socios`
--

DROP TABLE IF EXISTS `fact_socios`;
CREATE TABLE IF NOT EXISTS `fact_socios` (
  `idsocio` int(11) NOT NULL AUTO_INCREMENT,
  `socio` int(11) DEFAULT NULL,
  `idcliente` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `anulado` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_anulado` date DEFAULT NULL,
  `nota` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idsocio`),
  KEY `fk_socios_cliente1_idx` (`idcliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_suministros`
--

DROP TABLE IF EXISTS `fact_suministros`;
CREATE TABLE IF NOT EXISTS `fact_suministros` (
  `idsuministro` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(2) COLLATE utf8_spanish_ci DEFAULT NULL,
  `suministro` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` int(11) NOT NULL,
  PRIMARY KEY (`idsuministro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_tipos`
--

DROP TABLE IF EXISTS `fact_tipos`;
CREATE TABLE IF NOT EXISTS `fact_tipos` (
  `idtipo` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(3) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipo` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` int(11) NOT NULL,
  PRIMARY KEY (`idtipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fact_zonas`
--

DROP TABLE IF EXISTS `fact_zonas`;
CREATE TABLE IF NOT EXISTS `fact_zonas` (
  `idzona` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(5) COLLATE utf8_spanish_ci DEFAULT NULL,
  `zona` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` int(11) DEFAULT NULL,
  `idlocalidad` int(11) NOT NULL,
  PRIMARY KEY (`idzona`),
  KEY `fk_zonas_localidades1_idx` (`idlocalidad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `fact_abonados`
--
ALTER TABLE `fact_abonados`
  ADD CONSTRAINT `fk_abonados_calles1` FOREIGN KEY (`idcalle`) REFERENCES `fact_calles` (`idcalle`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_abonados_categorias1` FOREIGN KEY (`idcategoria`) REFERENCES `fact_categorias` (`idcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_abonados_centros1` FOREIGN KEY (`idcentro`) REFERENCES `fact_centros` (`idcentro`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_abonados_cliente1` FOREIGN KEY (`idcliente`) REFERENCES `fact_cliente` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_abonados_consumidores1` FOREIGN KEY (`idconsumidor`) REFERENCES `fact_consumidores` (`idconsumidor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_abonados_estados1` FOREIGN KEY (`idestado`) REFERENCES `fact_estados` (`idestado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_abonados_liberaciones1` FOREIGN KEY (`idliberacion`) REFERENCES `fact_liberaciones` (`idliberacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_abonados_mediciones1` FOREIGN KEY (`idmedicion`) REFERENCES `fact_mediciones` (`idmedicion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_abonados_postes1` FOREIGN KEY (`idposte`) REFERENCES `fact_postes` (`idposte`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_abonados_servicios1` FOREIGN KEY (`idservicio`) REFERENCES `fact_servicios` (`idservicio`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_abonados_suministros1` FOREIGN KEY (`idsuministro`) REFERENCES `fact_suministros` (`idsuministro`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fact_adquisicion_producto`
--
ALTER TABLE `fact_adquisicion_producto`
  ADD CONSTRAINT `fk_adquisicion_producto_nro_adquisicion1` FOREIGN KEY (`id_nro_adquisicion`) REFERENCES `fact_nro_adquisicion` (`id_nro_adquisicion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_adquisicion_producto_producto1` FOREIGN KEY (`id_producto`) REFERENCES `fact_producto` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_adquisicion_producto_salida1` FOREIGN KEY (`id_salida`) REFERENCES `fact_salida` (`id_salida`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fact_afectados`
--
ALTER TABLE `fact_afectados`
  ADD CONSTRAINT `fk_afectados_abonados1` FOREIGN KEY (`idabonado`) REFERENCES `fact_abonados` (`idabonado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_afectados_resoluciones1` FOREIGN KEY (`idresolucion`) REFERENCES `fact_resoluciones` (`idresolucion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fact_alertas`
--
ALTER TABLE `fact_alertas`
  ADD CONSTRAINT `fk_alertas_abonados1` FOREIGN KEY (`idabonado`) REFERENCES `fact_abonados` (`idabonado`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fact_beneficiarios`
--
ALTER TABLE `fact_beneficiarios`
  ADD CONSTRAINT `fk_beneficiarios_abonados1` FOREIGN KEY (`idabonado`) REFERENCES `fact_abonados` (`idabonado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_beneficiarios_cliente1` FOREIGN KEY (`idcliente`) REFERENCES `fact_cliente` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_beneficiarios_directos1` FOREIGN KEY (`iddirecto`) REFERENCES `fact_directos` (`iddirecto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_beneficiarios_ley18861` FOREIGN KEY (`idley1886`) REFERENCES `fact_ley1886` (`idley1886`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fact_calles`
--
ALTER TABLE `fact_calles`
  ADD CONSTRAINT `fk_calles_zonas1` FOREIGN KEY (`idzona`) REFERENCES `fact_zonas` (`idzona`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fact_categorias`
--
ALTER TABLE `fact_categorias`
  ADD CONSTRAINT `fk_categorias_servicios1` FOREIGN KEY (`idservicio`) REFERENCES `fact_servicios` (`idservicio`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fact_centros`
--
ALTER TABLE `fact_centros`
  ADD CONSTRAINT `fk_centros_localidades1` FOREIGN KEY (`idlocalidad`) REFERENCES `fact_localidades` (`idlocalidad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_centros_propiedades1` FOREIGN KEY (`idpropiedad`) REFERENCES `fact_propiedades` (`idpropiedad`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fact_conexiones`
--
ALTER TABLE `fact_conexiones`
  ADD CONSTRAINT `fk_conexiones_ordenes1` FOREIGN KEY (`idorden`) REFERENCES `fact_ordenes` (`idorden`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_conexiones_servicios1` FOREIGN KEY (`idservicio`) REFERENCES `fact_servicios` (`idservicio`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fact_cortes`
--
ALTER TABLE `fact_cortes`
  ADD CONSTRAINT `fk_cortes_abonados1` FOREIGN KEY (`idabonado`) REFERENCES `fact_abonados` (`idabonado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cortes_servicios1` FOREIGN KEY (`idservicio`) REFERENCES `fact_servicios` (`idservicio`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fact_costos`
--
ALTER TABLE `fact_costos`
  ADD CONSTRAINT `fk_costos_gestiones1` FOREIGN KEY (`idgestion`) REFERENCES `fact_gestiones` (`idgestion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_costos_periodos1` FOREIGN KEY (`idperiodo`) REFERENCES `fact_periodos` (`idperiodo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fact_cufd`
--
ALTER TABLE `fact_cufd`
  ADD CONSTRAINT `fk_cufd_punto_venta1` FOREIGN KEY (`id_punto_venta`) REFERENCES `fact_punto_venta` (`id_punto_venta`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fact_cuis`
--
ALTER TABLE `fact_cuis`
  ADD CONSTRAINT `fk_cuis_punto_venta` FOREIGN KEY (`id_punto_venta`) REFERENCES `fact_punto_venta` (`id_punto_venta`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fact_devueltos`
--
ALTER TABLE `fact_devueltos`
  ADD CONSTRAINT `fk_devueltos_afectados1` FOREIGN KEY (`idafectado`) REFERENCES `fact_afectados` (`idafectado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_devueltos_lecturas1` FOREIGN KEY (`idlectura`) REFERENCES `fact_lecturas` (`idlectura`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fact_factores`
--
ALTER TABLE `fact_factores`
  ADD CONSTRAINT `fk_factores_periodos1` FOREIGN KEY (`idperiodo`) REFERENCES `fact_periodos` (`idperiodo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fact_factura`
--
ALTER TABLE `fact_factura`
  ADD CONSTRAINT `fk_factura_empleado1` FOREIGN KEY (`id_empleado`) REFERENCES `fact_empleado` (`id_empleado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_factura_punto_venta1` FOREIGN KEY (`id_punto_venta`) REFERENCES `fact_punto_venta` (`id_punto_venta`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fact_gestiones`
--
ALTER TABLE `fact_gestiones`
  ADD CONSTRAINT `fk_gestiones_servicios1` FOREIGN KEY (`idservicio`) REFERENCES `fact_servicios` (`idservicio`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fact_inquilinos`
--
ALTER TABLE `fact_inquilinos`
  ADD CONSTRAINT `fk_inquilinos_abonados1` FOREIGN KEY (`idabonado`) REFERENCES `fact_abonados` (`idabonado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inquilinos_cliente1` FOREIGN KEY (`idcliente`) REFERENCES `fact_cliente` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fact_items_orden`
--
ALTER TABLE `fact_items_orden`
  ADD CONSTRAINT `fk_items_orden_orden1` FOREIGN KEY (`id_orden`) REFERENCES `fact_orden` (`id_orden`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_items_orden_producto1` FOREIGN KEY (`id_producto`) REFERENCES `fact_producto` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fact_lecturas`
--
ALTER TABLE `fact_lecturas`
  ADD CONSTRAINT `fk_lecturas_abonados1` FOREIGN KEY (`idabonado`) REFERENCES `fact_abonados` (`idabonado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_lecturas_periodos1` FOREIGN KEY (`idperiodo`) REFERENCES `fact_periodos` (`idperiodo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_lecturas_servicios1` FOREIGN KEY (`idservicio`) REFERENCES `fact_servicios` (`idservicio`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fact_maniobras`
--
ALTER TABLE `fact_maniobras`
  ADD CONSTRAINT `fk_maniobras_alilmentadores1` FOREIGN KEY (`idalimentador`) REFERENCES `fact_alimentadores` (`idalimentador`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_maniobras_zonas1` FOREIGN KEY (`idzona`) REFERENCES `fact_zonas` (`idzona`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fact_observados`
--
ALTER TABLE `fact_observados`
  ADD CONSTRAINT `fk_observados_cliente1` FOREIGN KEY (`idcliente`) REFERENCES `fact_cliente` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fact_ordenes`
--
ALTER TABLE `fact_ordenes`
  ADD CONSTRAINT `fk_ordenes_abonados1` FOREIGN KEY (`idabonado`) REFERENCES `fact_abonados` (`idabonado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ordenes_gestiones1` FOREIGN KEY (`idgestion`) REFERENCES `fact_gestiones` (`idgestion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ordenes_servicios1` FOREIGN KEY (`idservicio`) REFERENCES `fact_servicios` (`idservicio`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fact_periodos`
--
ALTER TABLE `fact_periodos`
  ADD CONSTRAINT `fk_periodos_procesos1` FOREIGN KEY (`idproceso`) REFERENCES `fact_procesos` (`idproceso`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fact_postes`
--
ALTER TABLE `fact_postes`
  ADD CONSTRAINT `fk_postes_centros1` FOREIGN KEY (`idcentro`) REFERENCES `fact_centros` (`idcentro`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fact_producto`
--
ALTER TABLE `fact_producto`
  ADD CONSTRAINT `fk_producto_categoria1` FOREIGN KEY (`id_categoria`) REFERENCES `fact_categoria` (`id_categoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fact_recargos`
--
ALTER TABLE `fact_recargos`
  ADD CONSTRAINT `fk_recargos_abonados1` FOREIGN KEY (`idabonado`) REFERENCES `fact_abonados` (`idabonado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_recargos_lecturas1` FOREIGN KEY (`idlectura`) REFERENCES `fact_lecturas` (`idlectura`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fact_reposiciones`
--
ALTER TABLE `fact_reposiciones`
  ADD CONSTRAINT `fk_reposiciones_cortes1` FOREIGN KEY (`idcorte`) REFERENCES `fact_cortes` (`idcorte`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fact_requisitos`
--
ALTER TABLE `fact_requisitos`
  ADD CONSTRAINT `fk_requisitos_calles1` FOREIGN KEY (`idcalle`) REFERENCES `fact_calles` (`idcalle`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_requisitos_cliente1` FOREIGN KEY (`idcliente`) REFERENCES `fact_cliente` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_requisitos_servicios1` FOREIGN KEY (`idservicio`) REFERENCES `fact_servicios` (`idservicio`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_requisitos_zonas1` FOREIGN KEY (`idzona`) REFERENCES `fact_zonas` (`idzona`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fact_salida`
--
ALTER TABLE `fact_salida`
  ADD CONSTRAINT `fk_salida_orden1` FOREIGN KEY (`id_orden`) REFERENCES `fact_orden` (`id_orden`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fact_socios`
--
ALTER TABLE `fact_socios`
  ADD CONSTRAINT `fk_socios_cliente1` FOREIGN KEY (`idcliente`) REFERENCES `fact_cliente` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fact_zonas`
--
ALTER TABLE `fact_zonas`
  ADD CONSTRAINT `fk_zonas_localidades1` FOREIGN KEY (`idlocalidad`) REFERENCES `fact_localidades` (`idlocalidad`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
