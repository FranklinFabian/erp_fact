SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for rrhh_empleado
-- ----------------------------
DROP TABLE IF EXISTS `rrhh_empleado`;
CREATE TABLE `rrhh_empleado`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empleado` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'nro_ci',
  `ci_extension` enum('LP','CB','OR','CH','PT','TJ','SC','BE','PD','OTRO') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'enum(\'LP\',\'CB\',\'OR\',\'CH\',\'PT\',\'TJ\',\'SC\',\'BE\',\'PD\',\'OTRO\')',
  `documento` enum('CI','PAS') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'enum(\'CI\',\'PAS\')',
  `paterno` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `materno` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ap_casada` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `nombre1` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `nombre2` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `telefono` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `direccion` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `zona` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `numero` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `profesion` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `estado_civil` enum('SOLTERO(A)','CASADO(A)','VIUDO(A)') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'enum(\'SOLTERO(A)\',\'CASADO(A)\',\'VIUDO(A)\')',
  `grado_instruccion` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `nacionalidad` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sexo` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `fecha_nacimiento` date NULL DEFAULT NULL,
  `lugar_nacimiento` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `club` tinyint(4) NOT NULL,
  `nua` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cuenta` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `trabajo_anterior` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `discapacitado` tinyint(4) NOT NULL,
  `discapacitado_tutor` tinyint(4) NOT NULL,
  `caja_salud` enum('Caja Nacional de Salud (CNS)') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'enum(\'Caja Nacional de Salud (CNS)\')',
  `afp_aporta` enum('APF Previsión','APF Futuro') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'enum(\'APF Previsión\',\'APF Futuro\')',
  `clasificacion_laboral` enum('Ocupaciones de la dirección en la administración pública y empresas','Ocupaciones de profesionales cientificos e intelectuales','Ocupaciones de técnicos y profesionales de apoyo','Empleados de Oficina','Trabajadores de los servicios y vendodores de comercio','Productores y trabajadores en la agricultura, pecuaria, agropecuaria y pesca','Trabajadores de la industria extractiva, contruccion, Ind. manufacturera y otros oficios','Operadores de instalaciones y maquinaria','Trabajadores no clasificados','Furezas Armadas') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'enum(\'10 opciones\')',
  `horas_pagadas` int(11) NOT NULL,
  `fecha_ingreso` date NULL DEFAULT NULL,
  `tipo_contrato` enum('Escrito','Verbal') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'enum(\'Escrito\',\'Verbal\')',
  `servicio` int(11) NULL DEFAULT NULL,
  `item` int(11) NULL DEFAULT NULL,
  `contrato` enum('Tiempo Indefinido','A plazo Fijo','Por Temporada','Por realizacion de obra','Condicional Eventual','Retirado') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'enum(\'Tiempo Indefinido\',\'A plazo Fijo\',\'Por Temporada\',\'Por realizacion de obra\',\'Condicional Eventual\',\'Retirado\')',
  `subsidio` enum('NINGUNO','CEPELIO','LACTANCIA','NATALIDAD','PRENATAL') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'enum(\'\'NINGUNO\',\'CEPELIO\',\'LACTANCIA\',\'NATALIDAD\',\'PRENATAL\'\')',
  `motivo_retiro` enum('-','Retiro voluntario del trabajador','Vencimiento de contrato','Conclusión de obra','Perjuicio material causado con intención en los instrumentos de trabajo','Revelación de secretos industriales','Omisiones o imprudencias que afecten a la seguridad o higiene industrial','Inasistencia injustificada de más de seis días continuos','Incumplimiento total o parcial del convenio','Robo o hurto por el trabajador','Retiro forzoso') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'enum(\'Retiro voluntario del trabajador.\',\'Vencimiento de contrato. \',\'Conclusión de obra.\',\'Perjuicio material causado con intención en los instrumentos de trabajo.\',\'Revelación de secretos industriales.\',\'Omisiones o imprudencias que afecten a la seguridad o higiene industrial.\',\'Inasistencia injustificada de más de seis días continuos.\',\'Incumplimiento total o parcial del convenio.\',\'Robo o hurto por el trabajador.\',\'Retiro forzoso.\')',
  `fecha_retiro` date NULL DEFAULT NULL,
  `jubilado` tinyint(4) NOT NULL,
  `fecha_jubilado` date NULL DEFAULT NULL,
  `rc_iva` decimal(12, 0) NULL DEFAULT NULL,
  `codigo_rciva` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `novedades` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `creadoPor` int(11) NULL DEFAULT NULL,
  `creadoEn` datetime(0) NULL DEFAULT NULL,
  `actualizadoPor` int(11) NULL DEFAULT NULL,
  `actualizadoEn` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`, `empleado`) USING BTREE,
  INDEX `empleado`(`empleado`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for rrhh_empleado_anticipos
-- ----------------------------
DROP TABLE IF EXISTS `rrhh_empleado_anticipos`;
CREATE TABLE `rrhh_empleado_anticipos`  (
  `empleado` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `mes` date NOT NULL,
  `importe` decimal(10, 2) NOT NULL,
  `creadoPor` int(11) NULL DEFAULT NULL,
  `creadoEn` datetime(0) NULL DEFAULT NULL,
  `actualizadoPor` int(11) NULL DEFAULT NULL,
  `actualizadoEn` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`empleado`, `mes`) USING BTREE,
  INDEX `FK_EMPLEADO_ANTICIPO_MES`(`mes`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for rrhh_empleado_asistencia_dia
-- ----------------------------
DROP TABLE IF EXISTS `rrhh_empleado_asistencia_dia`;
CREATE TABLE `rrhh_empleado_asistencia_dia`  (
  `empleado` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `fecha` date NOT NULL,
  `control` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `nota` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `mes` date NOT NULL,
  `vacacion` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`empleado`, `fecha`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for rrhh_empleado_bono_antiguedad
-- ----------------------------
DROP TABLE IF EXISTS `rrhh_empleado_bono_antiguedad`;
CREATE TABLE `rrhh_empleado_bono_antiguedad`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `anio_inicio` int(11) NULL DEFAULT NULL,
  `anio_final` int(11) NULL DEFAULT NULL,
  `porcentaje` double(11, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of rrhh_empleado_bono_antiguedad
-- ----------------------------
INSERT INTO `rrhh_empleado_bono_antiguedad` VALUES (1, 0, 2, 0.00);
INSERT INTO `rrhh_empleado_bono_antiguedad` VALUES (2, 2, 5, 5.00);
INSERT INTO `rrhh_empleado_bono_antiguedad` VALUES (3, 5, 8, 11.00);
INSERT INTO `rrhh_empleado_bono_antiguedad` VALUES (4, 8, 11, 18.00);
INSERT INTO `rrhh_empleado_bono_antiguedad` VALUES (5, 11, 15, 26.00);
INSERT INTO `rrhh_empleado_bono_antiguedad` VALUES (6, 15, 20, 34.00);
INSERT INTO `rrhh_empleado_bono_antiguedad` VALUES (7, 20, 25, 42.00);
INSERT INTO `rrhh_empleado_bono_antiguedad` VALUES (8, 25, 50, 50.00);

-- ----------------------------
-- Table structure for rrhh_empleado_control
-- ----------------------------
DROP TABLE IF EXISTS `rrhh_empleado_control`;
CREATE TABLE `rrhh_empleado_control`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `control` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `descripcion` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `creadoPor` int(11) NULL DEFAULT NULL,
  `creadoEn` datetime(0) NULL DEFAULT NULL,
  `actualizadoPor` int(11) NULL DEFAULT NULL,
  `actualizadoEn` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of rrhh_empleado_control
-- ----------------------------
INSERT INTO `rrhh_empleado_control` VALUES (1, 'AS', 'ASUETO', 1, '2017-11-30 08:58:14', 1, '2021-04-10 13:32:41');
INSERT INTO `rrhh_empleado_control` VALUES (2, 'AT', 'ATRASO', 1, '2017-06-19 09:22:28', NULL, NULL);
INSERT INTO `rrhh_empleado_control` VALUES (3, 'BM', 'BAJA MEDICA', 1, '2017-06-19 09:22:54', NULL, NULL);
INSERT INTO `rrhh_empleado_control` VALUES (4, 'CI', 'COMISION INSTITUCIONAL', 1, '2017-06-19 09:23:16', NULL, NULL);
INSERT INTO `rrhh_empleado_control` VALUES (5, 'CS', 'COMISION SINDICAL', 1, '2017-06-19 09:23:29', NULL, NULL);
INSERT INTO `rrhh_empleado_control` VALUES (6, 'CU', 'ASUETO P/CUMPLEAÑO', 1, '2017-08-01 14:19:10', NULL, NULL);
INSERT INTO `rrhh_empleado_control` VALUES (7, 'DF', 'DUELO FAMILIAR', 1, '2017-06-19 09:24:12', NULL, NULL);
INSERT INTO `rrhh_empleado_control` VALUES (8, 'F1', 'FALTA 1 DIA', 1, '2017-06-19 09:22:01', NULL, NULL);
INSERT INTO `rrhh_empleado_control` VALUES (9, 'F2', 'FALTA 1/2 DIA', 1, '2017-06-19 09:22:14', NULL, NULL);
INSERT INTO `rrhh_empleado_control` VALUES (10, 'FE', 'FERIADO', 1, '2017-08-09 09:12:44', NULL, NULL);
INSERT INTO `rrhh_empleado_control` VALUES (11, 'FS', 'FIN DE SEMANA', 1, '2017-07-31 18:35:51', NULL, NULL);
INSERT INTO `rrhh_empleado_control` VALUES (12, 'JE', 'JURADO ELECTORAL', 1, '2017-06-19 09:24:36', NULL, NULL);
INSERT INTO `rrhh_empleado_control` VALUES (13, 'L1', 'LICIENCIA CTA. VACACION 1 DIA', 1, '2017-06-19 09:18:55', 1, '2021-04-10 13:31:57');
INSERT INTO `rrhh_empleado_control` VALUES (14, 'L2', 'LICENCIA CTA. VACACION 1/2 DIA', 1, '2017-06-19 09:21:43', NULL, NULL);
INSERT INTO `rrhh_empleado_control` VALUES (15, 'MA', 'MATRIMONIO', 1, '2017-06-19 09:23:53', NULL, NULL);
INSERT INTO `rrhh_empleado_control` VALUES (16, 'PA', 'ASUETO POR PATERNIDAD - MATERNIDAD', 1, '2018-05-25 17:32:21', NULL, NULL);
INSERT INTO `rrhh_empleado_control` VALUES (17, 'PC', 'PARO CIVICO', 1, '2017-06-19 09:23:41', NULL, NULL);
INSERT INTO `rrhh_empleado_control` VALUES (18, 'PT', 'PRESENTE', 1, '2017-06-19 08:57:32', NULL, NULL);
INSERT INTO `rrhh_empleado_control` VALUES (19, 'RE', 'RETIRADO', 1, '2017-08-01 10:06:18', NULL, NULL);
INSERT INTO `rrhh_empleado_control` VALUES (20, 'SA', 'SANCION CON SUSPENCION', 1, '2017-10-30 17:29:09', NULL, NULL);
INSERT INTO `rrhh_empleado_control` VALUES (21, 'SU', 'SUSPENDIDO', 1, '2017-06-19 09:24:27', NULL, NULL);
INSERT INTO `rrhh_empleado_control` VALUES (22, 'VA', 'VACACIONES', 1, '2017-06-19 09:22:41', NULL, NULL);

-- ----------------------------
-- Table structure for rrhh_empleado_extras-eliminar
-- ----------------------------
DROP TABLE IF EXISTS `rrhh_empleado_extras-eliminar`;
CREATE TABLE `rrhh_empleado_extras-eliminar`  (
  `empleado` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `mes` date NOT NULL,
  `extras` decimal(10, 2) NOT NULL,
  `nota` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `dobles` decimal(10, 2) NOT NULL,
  `nocturnas` decimal(10, 2) NOT NULL,
  `recargo` decimal(10, 2) NOT NULL,
  `total` decimal(10, 2) NOT NULL,
  PRIMARY KEY (`empleado`, `mes`) USING BTREE,
  INDEX `FK_EMPLEADO_EXTRAS_MES`(`mes`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for rrhh_empleado_familia
-- ----------------------------
DROP TABLE IF EXISTS `rrhh_empleado_familia`;
CREATE TABLE `rrhh_empleado_familia`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empleado` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `documento` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'nro_ci',
  `nombre_completo` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `relacion` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `creadoPor` int(11) NULL DEFAULT NULL,
  `creadoEn` datetime(0) NULL DEFAULT NULL,
  `actualizadoPor` int(11) NULL DEFAULT NULL,
  `actualizadoEn` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for rrhh_empleado_fondo_rotativo
-- ----------------------------
DROP TABLE IF EXISTS `rrhh_empleado_fondo_rotativo`;
CREATE TABLE `rrhh_empleado_fondo_rotativo`  (
  `empleado` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `mes` date NOT NULL,
  `importe` decimal(10, 2) NOT NULL,
  `creadoPor` int(11) NULL DEFAULT NULL,
  `creadoEn` datetime(0) NULL DEFAULT NULL,
  `actualizadoPor` int(11) NULL DEFAULT NULL,
  `actualizadoEn` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`empleado`, `mes`) USING BTREE,
  INDEX `FK_EMPLEADO_FONDO_MES`(`mes`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for rrhh_empleado_form101
-- ----------------------------
DROP TABLE IF EXISTS `rrhh_empleado_form101`;
CREATE TABLE `rrhh_empleado_form101`  (
  `empleado` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `mes` date NOT NULL,
  `importe` decimal(10, 2) NOT NULL,
  `creadoPor` int(11) NULL DEFAULT NULL,
  `creadoEn` datetime(0) NULL DEFAULT NULL,
  `actualizadoPor` int(11) NULL DEFAULT NULL,
  `actualizadoEn` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`empleado`, `mes`) USING BTREE,
  INDEX `FK_EMPLEADO_FRM101_MES`(`mes`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for rrhh_empleado_horas_extras
-- ----------------------------
DROP TABLE IF EXISTS `rrhh_empleado_horas_extras`;
CREATE TABLE `rrhh_empleado_horas_extras`  (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `empleado` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `mes` date NOT NULL,
  `motivo` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `fecha` date NOT NULL,
  `desde` time(0) NOT NULL,
  `hasta` time(0) NOT NULL,
  `sencillas` decimal(10, 2) NOT NULL,
  `dobles` decimal(10, 2) NOT NULL,
  `nocturnas` decimal(10, 2) NOT NULL,
  `jefe_tec` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `creadoPor` int(11) NULL DEFAULT NULL,
  `creadoEn` datetime(0) NULL DEFAULT NULL,
  `actualizadoPor` int(11) NULL DEFAULT NULL,
  `actualizadoEn` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for rrhh_empleado_incremento
-- ----------------------------
DROP TABLE IF EXISTS `rrhh_empleado_incremento`;
CREATE TABLE `rrhh_empleado_incremento`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empleado` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `mes` date NOT NULL,
  `dias_trabajados` decimal(12, 2) NOT NULL,
  `haber_mensual` decimal(12, 2) NOT NULL,
  `remamplia` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `item_reemplazo` int(11) NULL DEFAULT NULL,
  `dias_reemplazo` decimal(12, 2) NOT NULL,
  `haber_reemplazo` decimal(12, 2) NOT NULL,
  `horas_extras` decimal(12, 2) NOT NULL,
  `haber_extras` decimal(12, 2) NOT NULL,
  `horas_recargo_nocturno` decimal(10, 2) NOT NULL,
  `monto_horas_nocturnas` decimal(10, 2) NOT NULL,
  `antiguedad` int(11) NOT NULL,
  `bono_antiguedad` decimal(12, 2) NOT NULL,
  `bono_frontera` decimal(12, 2) NOT NULL,
  `otros_ingresos` decimal(12, 2) NOT NULL,
  `total_ganado` decimal(12, 2) NOT NULL,
  `afp_individual` decimal(12, 2) NOT NULL,
  `afp_comun` decimal(12, 2) NOT NULL,
  `afp_comision` decimal(12, 2) NOT NULL,
  `sol_laboral` decimal(12, 2) NOT NULL,
  `rc_iva` decimal(12, 2) NOT NULL,
  `club` decimal(12, 2) NOT NULL,
  `pulperia` decimal(12, 2) NOT NULL,
  `fondo_rotativo` decimal(12, 2) NOT NULL,
  `anticipo` decimal(12, 2) NOT NULL,
  `dias_sancion` decimal(12, 2) NOT NULL,
  `sancion` decimal(12, 2) NOT NULL,
  `otros_descuentos` decimal(12, 2) NOT NULL,
  `total_descuentos` decimal(12, 2) NOT NULL,
  `sueldo_neto` decimal(12, 2) NOT NULL,
  `minimos_no_imponibles` decimal(12, 2) NOT NULL,
  `diferencia` decimal(12, 2) NOT NULL,
  `impuesto` decimal(12, 2) NOT NULL,
  `form_101` decimal(12, 2) NOT NULL,
  `dos_minimos` decimal(12, 2) NOT NULL,
  `impuesto_neto` decimal(10, 2) NOT NULL,
  `fisco` decimal(12, 2) NOT NULL,
  `dependiente` decimal(12, 2) NOT NULL,
  `saldo_anterior` decimal(12, 2) NOT NULL,
  `mantenimiento` decimal(12, 2) NOT NULL,
  `total_actualizado` decimal(12, 2) NOT NULL,
  `total_dependiente` decimal(12, 2) NOT NULL,
  `saldo_utilizado` decimal(12, 2) NOT NULL,
  `saldo_retenido` decimal(12, 2) NOT NULL,
  `saldo_mes_siguiente` decimal(12, 2) NOT NULL,
  `liquido_pagable` decimal(12, 2) NOT NULL,
  `pat_afp` decimal(12, 2) NOT NULL,
  `sol_patronal` decimal(12, 2) NOT NULL,
  `pat_cns` decimal(12, 2) NOT NULL,
  `pat_fonvis` decimal(12, 2) NOT NULL,
  `aguinaldo` decimal(12, 2) NOT NULL,
  `aguinaldo2` decimal(10, 2) NOT NULL,
  `prima` decimal(10, 2) NOT NULL,
  `indemnizacion` decimal(12, 2) NOT NULL,
  `pat_total` decimal(12, 2) NOT NULL,
  `pre_natal` decimal(12, 2) NOT NULL,
  `natal` decimal(12, 2) NOT NULL,
  `lactancia` decimal(12, 2) NOT NULL,
  `cepelio` decimal(12, 2) NOT NULL,
  `total_subsidio` decimal(12, 2) NOT NULL,
  `horas_extras_dominicales` decimal(10, 2) NOT NULL,
  `monto_extras_dominicales` decimal(10, 2) NOT NULL,
  `domingos_trabajados` decimal(10, 2) NOT NULL,
  `monto_domingo` decimal(10, 2) NOT NULL,
  `nro_dominicales` decimal(10, 2) NOT NULL,
  `salario_dominical` decimal(10, 2) NOT NULL,
  `bono_produccion` decimal(10, 2) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for rrhh_empleado_item
-- ----------------------------
DROP TABLE IF EXISTS `rrhh_empleado_item`;
CREATE TABLE `rrhh_empleado_item`  (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `cargo` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `basico` decimal(10, 2) NULL DEFAULT NULL,
  `seccion` int(11) NULL DEFAULT NULL,
  `creadoPor` int(11) NULL DEFAULT NULL,
  `creadoEn` datetime(0) NULL DEFAULT NULL,
  `actualizadoPor` int(11) NULL DEFAULT NULL,
  `actualizadoEn` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 43 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of rrhh_empleado_item
-- ----------------------------
INSERT INTO `rrhh_empleado_item` VALUES (1, 'Gerente General', 9927.05, 1, NULL, NULL, 1, '2021-04-14 09:27:22');
INSERT INTO `rrhh_empleado_item` VALUES (2, 'Gerente Técnico', 8936.00, 4, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (3, 'Jefe Técnico', 6506.00, 4, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (4, 'Maestro Electricista', 4928.00, 5, NULL, NULL, 1, '2020-08-18 00:28:26');
INSERT INTO `rrhh_empleado_item` VALUES (5, 'Maestro Electricista', 4928.00, 5, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (6, 'Maestro Electricista', 4928.00, 5, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (7, 'Maestro Electricista', 4928.00, 5, NULL, NULL, 1, '2020-08-17 23:48:10');
INSERT INTO `rrhh_empleado_item` VALUES (8, 'Encargado de Transportes', 4928.00, 5, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (9, 'Electricista I', 4535.00, 5, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (10, 'Electricista II', 4269.00, 5, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (11, 'Electricista II', 4269.00, 5, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (12, 'Ayudante Electricista I', 4031.00, 5, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (13, 'Sereno', 4031.00, 5, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (14, 'Ayudante Electricista II', 3481.00, 5, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (15, 'Ayudante Electricista II', 3481.00, 5, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (16, 'Ayudante Electricista III', 2822.00, 5, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (17, 'Ayudante Electricista III', 2822.00, 5, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (18, 'Ayudante Electricista III', 2822.00, 5, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (19, 'Ayudante Electricista III', 2822.00, 5, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (20, 'Contador General', 6506.00, 2, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (21, 'Encargado de C.P.D.', 5583.00, 2, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (22, 'Cajera', 5583.00, 3, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (23, 'Auxiliar de Contabilidad', 4535.00, 3, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (24, 'Encargada de Activos Fijos', 4535.00, 3, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (25, 'Encargado de Almacenes', 4535.00, 3, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (26, 'Secretario de Gerencia', 4535.00, 3, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (27, 'Encargada de Cobranzas', 4031.00, 3, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (28, 'Encargado de O.D.E.C.O', 4031.00, 3, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (29, 'Asistente Adm. Tv. Cable', 4031.00, 6, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (30, 'Secretaria de Directorio', 2822.00, 3, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (31, 'Caja Coopevision', 4269.00, 6, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (32, 'Ayudante Tv Cable 1', 4031.00, 6, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (33, 'Ayudante Tv Cable 2', 2822.00, 6, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (34, 'Tecnico Canal 21', 2822.00, 7, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (35, 'Tecnico Canal 21', 2822.00, 7, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (36, 'Enc. Proyectos y Manto. de Red', 7644.00, 4, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (37, 'Asesor Legal', 3822.00, 3, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (38, 'Mensajero - Enc. Limpieza', 2822.00, 3, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (39, 'Auditor Interno', 5583.00, 2, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (40, 'Encargado Tecnico de Coopevision', 4269.00, 6, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_item` VALUES (41, 'Asistente Administrativo', 4031.00, 3, NULL, NULL, 1, '2020-08-18 00:27:59');
INSERT INTO `rrhh_empleado_item` VALUES (42, 'CARGO DE NOMBRE DE SECCIÓN', 3500.00, 7, 1, '2021-04-14 09:26:00', NULL, NULL);

-- ----------------------------
-- Table structure for rrhh_empleado_mes
-- ----------------------------
DROP TABLE IF EXISTS `rrhh_empleado_mes`;
CREATE TABLE `rrhh_empleado_mes`  (
  `mes` date NOT NULL,
  `rc_iva` decimal(12, 2) NOT NULL,
  `sueldo_minimo` decimal(12, 2) NOT NULL,
  `cot_actual` decimal(12, 5) NOT NULL,
  `cot_anterior` decimal(12, 5) NOT NULL,
  `bono_frontera` decimal(12, 2) NOT NULL,
  `afp_individual` decimal(12, 4) NOT NULL,
  `afp_riesgo` decimal(12, 4) NOT NULL,
  `afp_comision` decimal(12, 4) NOT NULL,
  `pat_afp` decimal(12, 4) NOT NULL,
  `pat_cns` decimal(12, 4) NOT NULL,
  `pat_fonvis` decimal(12, 4) NOT NULL,
  `club` decimal(12, 4) NOT NULL,
  `sol_laboral` decimal(12, 4) NOT NULL,
  `sol_patronal` decimal(12, 4) NOT NULL,
  `estado` tinyint(4) NULL DEFAULT NULL,
  `refrigerio` decimal(10, 2) NOT NULL,
  `fallas_caja` decimal(10, 2) NOT NULL,
  `fallas_caja_central` decimal(10, 2) NOT NULL,
  `creadoPor` int(11) NULL DEFAULT NULL,
  `creadoEn` datetime(0) NULL DEFAULT NULL,
  `actualizadoPor` int(11) NULL DEFAULT NULL,
  `actualizadoEn` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`mes`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of rrhh_empleado_mes
-- ----------------------------
INSERT INTO `rrhh_empleado_mes` VALUES ('2022-01-31', 0.13, 2122.00, 2.33189, 2.32588, 0.20, 0.1000, 0.0171, 0.0050, 0.0171, 0.1000, 0.0200, 0.0100, 0.0050, 0.0300, 1, 21.00, 100.00, 150.00, 1, '2021-04-07 20:39:29', NULL, NULL);

-- ----------------------------
-- Table structure for rrhh_empleado_sancion
-- ----------------------------
DROP TABLE IF EXISTS `rrhh_empleado_sancion`;
CREATE TABLE `rrhh_empleado_sancion`  (
  `empleado` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `mes` date NOT NULL,
  `importe` double(11, 2) NOT NULL,
  `nota` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `dias` double(11, 2) NULL DEFAULT NULL,
  `creadoPor` int(11) NULL DEFAULT NULL,
  `creadoEn` datetime(0) NULL DEFAULT NULL,
  `actualizadoPor` int(11) NULL DEFAULT NULL,
  `actualizadoEn` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`empleado`, `mes`) USING BTREE,
  INDEX `FK_EMPLEADO_SANCION_MES`(`mes`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for rrhh_empleado_seccion
-- ----------------------------
DROP TABLE IF EXISTS `rrhh_empleado_seccion`;
CREATE TABLE `rrhh_empleado_seccion`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `servicio` int(11) NOT NULL,
  `creadoPor` int(11) NULL DEFAULT NULL,
  `creadoEn` datetime(0) NULL DEFAULT NULL,
  `actualizadoPor` int(11) NULL DEFAULT NULL,
  `actualizadoEn` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of rrhh_empleado_seccion
-- ----------------------------
INSERT INTO `rrhh_empleado_seccion` VALUES (1, 'EJECUTIVO', 1, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_seccion` VALUES (2, 'ADMINISTRACION', 1, NULL, NULL, 1, '2020-08-18 00:30:29');
INSERT INTO `rrhh_empleado_seccion` VALUES (3, 'ADMINISTRATIVO', 1, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_seccion` VALUES (4, 'TECNICO RED', 1, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_seccion` VALUES (5, 'TECNICO OBRERO', 1, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_seccion` VALUES (6, 'CANAL X', 2, NULL, NULL, NULL, NULL);
INSERT INTO `rrhh_empleado_seccion` VALUES (7, 'NOMBRE DE SECCIÓN', 1, 1, '2021-04-14 09:24:37', 1, '2021-04-14 09:24:55');

-- ----------------------------
-- Table structure for rrhh_empleado_sindicato
-- ----------------------------
DROP TABLE IF EXISTS `rrhh_empleado_sindicato`;
CREATE TABLE `rrhh_empleado_sindicato`  (
  `empleado` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `mes` date NOT NULL,
  `importe` decimal(10, 2) NOT NULL,
  `creadoPor` int(11) NULL DEFAULT NULL,
  `creadoEn` datetime(0) NULL DEFAULT NULL,
  `actualizadoPor` int(11) NULL DEFAULT NULL,
  `actualizadoEn` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`empleado`, `mes`) USING BTREE,
  INDEX `FK_EMPLEADO_SINDICATO_MES`(`mes`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for rrhh_empleado_sueldo
-- ----------------------------
DROP TABLE IF EXISTS `rrhh_empleado_sueldo`;
CREATE TABLE `rrhh_empleado_sueldo`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empleado` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `mes` date NOT NULL,
  `dias_trabajados` decimal(12, 2) NOT NULL,
  `haber_mensual` decimal(12, 2) NOT NULL,
  `remamplia` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `item_reemplazo` int(11) NULL DEFAULT NULL,
  `dias_reemplazo` decimal(12, 2) NOT NULL,
  `haber_reemplazo` decimal(12, 2) NOT NULL,
  `horas_extras` decimal(12, 2) NOT NULL,
  `haber_extras` decimal(12, 2) NOT NULL,
  `horas_recargo_nocturno` decimal(10, 2) NOT NULL,
  `monto_horas_nocturnas` decimal(10, 2) NOT NULL,
  `antiguedad` int(11) NOT NULL,
  `bono_antiguedad` decimal(12, 2) NOT NULL,
  `bono_frontera` decimal(12, 2) NOT NULL,
  `otros_ingresos` decimal(12, 2) NOT NULL,
  `total_ganado` decimal(12, 2) NOT NULL,
  `afp_individual` decimal(12, 2) NOT NULL,
  `afp_comun` decimal(12, 2) NOT NULL,
  `afp_comision` decimal(12, 2) NOT NULL,
  `sol_laboral` decimal(12, 2) NOT NULL,
  `rc_iva` decimal(12, 2) NOT NULL,
  `club` decimal(12, 2) NOT NULL,
  `pulperia` decimal(12, 2) NOT NULL,
  `fondo_rotativo` decimal(12, 2) NOT NULL,
  `anticipo` decimal(12, 2) NOT NULL,
  `dias_sancion` decimal(12, 2) NOT NULL,
  `sancion` decimal(12, 2) NOT NULL,
  `otros_descuentos` decimal(12, 2) NOT NULL,
  `total_descuentos` decimal(12, 2) NOT NULL,
  `sueldo_neto` decimal(12, 2) NOT NULL,
  `minimos_no_imponibles` decimal(12, 2) NOT NULL,
  `diferencia` decimal(12, 2) NOT NULL,
  `impuesto` decimal(12, 2) NOT NULL,
  `form_101` decimal(12, 2) NOT NULL,
  `dos_minimos` decimal(12, 2) NOT NULL,
  `impuesto_neto` decimal(10, 2) NOT NULL,
  `fisco` decimal(12, 2) NOT NULL,
  `dependiente` decimal(12, 2) NOT NULL,
  `saldo_anterior` decimal(12, 2) NOT NULL,
  `mantenimiento` decimal(12, 2) NOT NULL,
  `total_actualizado` decimal(12, 2) NOT NULL,
  `total_dependiente` decimal(12, 2) NOT NULL,
  `saldo_utilizado` decimal(12, 2) NOT NULL,
  `saldo_retenido` decimal(12, 2) NOT NULL,
  `saldo_mes_siguiente` decimal(12, 2) NOT NULL,
  `liquido_pagable` decimal(12, 2) NOT NULL,
  `pat_afp` decimal(12, 2) NOT NULL,
  `sol_patronal` decimal(12, 2) NOT NULL,
  `pat_cns` decimal(12, 2) NOT NULL,
  `pat_fonvis` decimal(12, 2) NOT NULL,
  `aguinaldo` decimal(12, 2) NOT NULL,
  `aguinaldo2` decimal(10, 2) NOT NULL,
  `prima` decimal(10, 2) NOT NULL,
  `indemnizacion` decimal(12, 2) NOT NULL,
  `pat_total` decimal(12, 2) NOT NULL,
  `pre_natal` decimal(12, 2) NOT NULL,
  `natal` decimal(12, 2) NOT NULL,
  `lactancia` decimal(12, 2) NOT NULL,
  `cepelio` decimal(12, 2) NOT NULL,
  `total_subsidio` decimal(12, 2) NOT NULL,
  `horas_extras_dominicales` decimal(10, 2) NOT NULL,
  `monto_extras_dominicales` decimal(10, 2) NOT NULL,
  `domingos_trabajados` decimal(10, 2) NOT NULL,
  `monto_domingos_trabajados` decimal(10, 2) NOT NULL,
  `nro_dominicales` decimal(10, 2) NOT NULL,
  `salario_dominical` decimal(10, 2) NOT NULL,
  `bono_produccion` decimal(10, 2) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `FK_SUELDO_EMPLEADO`(`empleado`) USING BTREE,
  INDEX `Fk_SUELDO_AMPLIA`(`remamplia`) USING BTREE,
  INDEX `FK_SUELDO_MES`(`mes`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for rrhh_empleado_suplencia
-- ----------------------------
DROP TABLE IF EXISTS `rrhh_empleado_suplencia`;
CREATE TABLE `rrhh_empleado_suplencia`  (
  `empleado` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `item` int(11) NOT NULL,
  `dias` double(11, 2) NOT NULL,
  `fecha_ini` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `mes` date NOT NULL,
  `nota` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `remamplia` enum('NINGUNO','Ampliación','Remplaza') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'enum (\'NINGUNO\',\'Ampliación\',\'Remplaza\')',
  `creadoPor` int(11) NULL DEFAULT NULL,
  `creadoEn` datetime(0) NULL DEFAULT NULL,
  `actualizadoPor` int(11) NULL DEFAULT NULL,
  `actualizadoEn` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`empleado`, `mes`, `item`) USING BTREE,
  INDEX `FK_EMPLEADO_SUPLE_MES`(`mes`) USING BTREE,
  INDEX `FK_EMPLEADO_SUPLE_ITEM`(`item`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for rrhh_empleado_vacaciones
-- ----------------------------
DROP TABLE IF EXISTS `rrhh_empleado_vacaciones`;
CREATE TABLE `rrhh_empleado_vacaciones`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empleado` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ci del empleado (id)',
  `antiguedad` double(11, 2) NULL DEFAULT NULL COMMENT 'antiguedad del empleado',
  `gestion_inicio` varchar(4) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'inicio de la gestión del registro de las vacaciones (YYYY)',
  `gestion_final` varchar(4) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'final de la gestion de las vacaciones (YYYY)',
  `dias_gestion` double(11, 2) NULL DEFAULT NULL,
  `dias_gestion_anterior` double(11, 2) NULL DEFAULT NULL,
  `dias_gestion_saldo` double(11, 2) NULL DEFAULT NULL COMMENT 'dias que le sobran para vacaciones (en la gestión)',
  `estado` tinyint(2) NULL DEFAULT NULL COMMENT '1: activo',
  `creadoPor` int(11) NULL DEFAULT NULL COMMENT 'id del usuario que creó el registro',
  `creadoEn` datetime(0) NULL DEFAULT NULL COMMENT 'fecha y hora del registro creado',
  `actualizadoPor` int(11) NULL DEFAULT NULL COMMENT 'id del último usuario que actualizó el  registro',
  `actualizadoEn` datetime(0) NULL DEFAULT NULL COMMENT 'fecha y hora de la última actualización del registro',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
