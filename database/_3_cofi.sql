/*
  Date: 18/01/2023 10:57:09
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cofi_comprobantes
-- ----------------------------
DROP TABLE IF EXISTS `cofi_comprobantes`;
CREATE TABLE `cofi_comprobantes` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `comprobante_tipo_id` int(11) NOT NULL,
  `correlativo` int(255) NOT NULL,
  `fecha` date DEFAULT NULL,
  `tcBsUS` float(11,6) DEFAULT NULL,
  `tcBsUFV` float(11,6) DEFAULT NULL,
  `nombre_razon_social` varchar(255) DEFAULT NULL,
  `moneda_id` int(11) DEFAULT NULL,
  `glosa` longtext,
  `empresa_gestion_id` int(11) DEFAULT NULL COMMENT 'de acuerdo a la tabla cofi_gestionempresas (se asigna un plan de cuentas especifico a cada gestion)',
  `anulado` tinyint(1) DEFAULT '0',
  `motivo_anulado` longtext,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `canceled_by` int(11) DEFAULT NULL,
  `canceled_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_comprobantes_comprobante_tipo_id` (`comprobante_tipo_id`) USING BTREE,
  KEY `fk_comprobantes_empresa_gestion_id` (`empresa_gestion_id`),
  KEY `fk_comprobantes_moneda_id` (`moneda_id`),
  CONSTRAINT `fk_comprobantes_comprobante_tipo_id` FOREIGN KEY (`comprobante_tipo_id`) REFERENCES `cofi_comprobantes_tipos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_comprobantes_empresa_gestion_id` FOREIGN KEY (`empresa_gestion_id`) REFERENCES `cofi_empresas_gestiones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_comprobantes_moneda_id` FOREIGN KEY (`moneda_id`) REFERENCES `cofi_monedas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cofi_comprobantes_correlativos
-- ----------------------------
DROP TABLE IF EXISTS `cofi_comprobantes_correlativos`;
CREATE TABLE `cofi_comprobantes_correlativos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comprobante_tipo_id` int(11) DEFAULT NULL,
  `contador` int(255) DEFAULT NULL,
  `empresa_gestion_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_comprobante_correlativo_comprobante_tipo_id` (`comprobante_tipo_id`),
  KEY `fk_comprobante_correlativo_empresa_gestion_id` (`empresa_gestion_id`),
  CONSTRAINT `fk_comprobante_correlativo_comprobante_tipo_id` FOREIGN KEY (`comprobante_tipo_id`) REFERENCES `cofi_comprobantes_tipos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_comprobante_correlativo_empresa_gestion_id` FOREIGN KEY (`empresa_gestion_id`) REFERENCES `cofi_empresas_gestiones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cofi_comprobantes_data
-- ----------------------------
DROP TABLE IF EXISTS `cofi_comprobantes_data`;
CREATE TABLE `cofi_comprobantes_data` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `comprobante_id` int(255) NOT NULL,
  `cuenta_id` int(255) NOT NULL,
  `debeBs` double(11,2) DEFAULT NULL,
  `haberBs` double(11,2) DEFAULT NULL,
  `debeUS` double(11,2) DEFAULT NULL,
  `haberUS` double(11,2) DEFAULT NULL,
  `debeUFV` double(11,2) DEFAULT NULL,
  `haberUFV` double(11,2) DEFAULT NULL,
  `referencia` longtext,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_comporbantes_data_cuenta_id` (`cuenta_id`) USING BTREE,
  KEY `fk_comporbantes_data_comprobante_id` (`comprobante_id`) USING BTREE,
  CONSTRAINT `fk_comporbantes_data_comprobante_id` FOREIGN KEY (`comprobante_id`) REFERENCES `cofi_comprobantes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_comporbantes_data_cuenta_id` FOREIGN KEY (`cuenta_id`) REFERENCES `cofi_cuentas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cofi_comprobantes_parametros
-- ----------------------------
DROP TABLE IF EXISTS `cofi_comprobantes_parametros`;
CREATE TABLE `cofi_comprobantes_parametros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad_digitos` int(4) NOT NULL,
  `numero_firmas` int(4) NOT NULL,
  `cargo_firma_uno` varchar(100) DEFAULT NULL,
  `nombre_firma_uno` varchar(100) DEFAULT NULL,
  `cargo_firma_dos` varchar(100) DEFAULT NULL,
  `nombre_firma_dos` varchar(100) DEFAULT NULL,
  `cargo_firma_tres` varchar(100) DEFAULT NULL,
  `nombre_firma_tres` varchar(100) DEFAULT NULL,
  `cargo_firma_cuatro` varchar(100) DEFAULT NULL,
  `nombre_firma_cuatro` varchar(100) DEFAULT NULL,
  `cargo_firma_cinco` varchar(100) DEFAULT NULL,
  `nombre_firma_cinco` varchar(100) DEFAULT NULL,
  `cargo_firma_seis` varchar(100) DEFAULT NULL,
  `nombre_firma_seis` varchar(100) DEFAULT NULL,
  `empresa_gestion_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cofi_comprobantes_parametros
-- ----------------------------
BEGIN;
INSERT INTO `cofi_comprobantes_parametros` VALUES (1, 6, 2, 'Elaborado por:', '', 'Autorizado por:', '', 'Tesorero:', '', 'Presidente:', '', 'Interesado:', '', 'Gerente:', '', 0);
COMMIT;

-- ----------------------------
-- Table structure for cofi_comprobantes_tipos
-- ----------------------------
DROP TABLE IF EXISTS `cofi_comprobantes_tipos`;
CREATE TABLE `cofi_comprobantes_tipos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `codigo` varchar(10) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cofi_comprobantes_tipos
-- ----------------------------
BEGIN;
INSERT INTO `cofi_comprobantes_tipos` VALUES (1, 'INGRESO', 'I', 1);
INSERT INTO `cofi_comprobantes_tipos` VALUES (2, 'EGRESO', 'E', 1);
INSERT INTO `cofi_comprobantes_tipos` VALUES (3, 'TRASPASO', 'D', 1);
COMMIT;

-- ----------------------------
-- Table structure for cofi_cuentas
-- ----------------------------
DROP TABLE IF EXISTS `cofi_cuentas`;
CREATE TABLE `cofi_cuentas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cuenta_grupo_id` int(11) DEFAULT NULL,
  `cuenta_tipo_id` int(11) DEFAULT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `codigo_formato` varchar(50) DEFAULT NULL,
  `nombre` varchar(200) DEFAULT NULL,
  `moneda_id` int(11) DEFAULT NULL,
  `actzUFV` varchar(2) DEFAULT NULL,
  `final` tinyint(1) DEFAULT NULL,
  `empresa_gestion_id` int(11) DEFAULT NULL COMMENT 'de acuerdo a la tabla cofi_gestionempresas (se asigna un plan de cuentas especifico a cada gestion)',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_idCuenta` (`cuenta_tipo_id`) USING BTREE,
  KEY `FK_idGrupo` (`cuenta_grupo_id`) USING BTREE,
  KEY `FK_moneda` (`moneda_id`) USING BTREE,
  CONSTRAINT `fk_cuentas_cuenta_grupo_id` FOREIGN KEY (`cuenta_grupo_id`) REFERENCES `cofi_cuentas_grupos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cuentas_cuenta_tipo_id` FOREIGN KEY (`cuenta_tipo_id`) REFERENCES `cofi_cuentas_tipos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cuentas_moneda_id` FOREIGN KEY (`moneda_id`) REFERENCES `cofi_monedas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=237 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cofi_cuentas
-- ----------------------------
BEGIN;
INSERT INTO `cofi_cuentas` VALUES (1, 1, 1, '1', '1', 'ACTIVO', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (2, 1, 2, '11', '1.1', 'ACTIVO CORRIENTE', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (3, 1, 3, '111', '1.1.1', 'DISPONIBILIDADES', 1, NULL, 0, 0);
INSERT INTO `cofi_cuentas` VALUES (4, 1, 4, '11101', '1.1.1.01', 'CAJA Y FONDOS FIJOS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (5, 1, 4, '11102', '1.1.1.02', 'BANCOS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (6, 1, 4, '11103', '1.1.1.03', 'INVERSIONES TEMPORARIAS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (7, 1, 3, '112', '1.1.2', 'CUENTAS COMERCIALES POR COBRAR', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (8, 1, 4, '11201', '1.1.2.01', 'DOCUMENTOS POR COBRAR', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (9, 1, 4, '11202', '1.1.2.02', 'CUENTAS DE CUENTES POR COBRAR', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (10, 1, 5, '112021', '1.1.2.02.1', 'CLIENTES RESIDENCIALES ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (11, 1, 5, '112022', '1.1.2.02.2', 'CUENTES GENERALES', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (12, 1, 5, '112023', '1.1.2.02.3', 'CUENTES INDUSTRIALES', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (13, 1, 5, '112024', '1.1.2.02.4', 'CUENTES DE ALUMBRADO PUBLICO ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (14, 1, 5, '112025', '1.1.2.02.5', 'CLIENTES DE REVENTA', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (15, 1, 5, '112026', '1.1.2.02.6', 'OTROS CLIENTES ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (16, 1, 4, '11203', '1.1.2.03', 'CLIENTES EN MORA', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (17, 1, 4, '11204', '1.1.2.04', 'CONEXIONES 0 RECONEXIONES', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (18, 1, 4, '11205', '1.1.2.05', 'PREVISION PARA CUENTAS DUDOSAS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (19, 1, 3, '113', '1.1.3', 'OTRAS CUENTAS POR COBRAR', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (20, 1, 4, '11301', '1.1.3.01', 'CUENTAS EMPLEADOS ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (21, 1, 4, '11302', '1.1.3.02', 'DEPOSITOS EN GARANTIA ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (22, 1, 4, '11303', '1.1.3.03', 'PAGOS ADELANTADOS ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (23, 1, 5, '113031', '1.1.3.03.1', 'PAGOS ADELANTADOS DIVERSOS ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (24, 1, 5, '113032', '1.1.3.03.2', 'ANTICIPOS A PROVEEDORES Y CONTRATISTAS ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (25, 1, 4, '11304', '1.1.3.04', 'DOCUMENTOS POR COBRAR A EMPRESAS VINCULADAS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (26, 1, 4, '11305', '1.1.3.05', 'CUENTAS POR COBRAR A EMPRESAS VINCULADAS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (27, 1, 4, '11306', '1.1.3.06', 'OTRAS CUENTAS POR COBRAR ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (28, 1, 4, '11307', '1.1.3.07', 'CREDITO FISCAL IMPOSITIVO', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (29, 1, 5, '113071', '1.1.3.07.1', 'ANTICIPO DE IMPUESTOS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (30, 1, 5, '113072', '1.1.3.07.2', 'IVA CREDITO FISCAL', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (31, 1, 5, '113073', '1.1.3.07.3', 'CREDITO FISCAL IUE A CTA IMPUESTO TRANSC', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (32, 1, 5, '113074', '1.1.3.07.4', 'OTROS CREDITOS FISCALES ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (33, 1, 4, '11308', '1.1.3.08', 'FONDOS CIRCULANTES ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (34, 1, 3, '114', '1.1.4', 'BIENES DE CAMBIO', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (35, 1, 4, '11401', '1.1.4.01', 'COMBUSTIBLE EN ALMACENES ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (36, 1, 4, '11402', '1.1.4.02', 'MATERIALES Y SUMINISTROS EN ALMACENES ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (37, 1, 4, '11403', '1.1.4.03', 'OTROS MATERIALES ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (38, 1, 4, '11404', '1.1.4.04', 'MATERIALES Y SUMINISTRO EN TRANSITO ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (39, 1, 4, '11405', '1.1.4.05', 'PROVISION PARA OESVALORIZACION Y OBSOLECENCíA ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (40, 1, 2, '12', '1.2', 'ACTIVO NO CORRIENTE', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (41, 1, 3, '121', '1.2.1', 'CUENTAS POR COBRAR', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (42, 1, 4, '12101', '1.2.1.01', 'DOCUMENTOS POR COBRAR ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (43, 1, 4, '12102', '1.2.1.02', 'CUENTAS POR COBRAR DE CLIENTES', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (44, 1, 5, '121021', '1.2.1.02.1', 'CLIENTES RESIDENCIALES', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (45, 1, 5, '121022', '1.2.1.02.2', 'CLIENTES GENERALES', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (46, 1, 5, '121023', '1.2.1.02.3', 'CLIENTES INDUSTRIALES', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (47, 1, 5, '121024', '1.2.1.02.4', 'CLIENTES DE ALUMBRADO PUBLICO', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (48, 1, 5, '121025', '1.2.1.02.5', 'CLIENTES DE REVENTA', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (49, 1, 5, '121026', '1.2.1.02.6', 'OTROS CLIENTES', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (50, 1, 4, '12103', '1.2.1.03', 'CLIENTES EN GESTION JUDICIAL', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (51, 1, 4, '12104', '1.2.1.04', 'PREVISION PARA CUENTAS DUDOSAS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (52, 1, 4, '12105', '1.2.1.05', 'DEPOSITOS DE GARANTIA', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (53, 1, 3, '122', '1.2.2', 'INVERSIONES PERMANENTES', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (54, 1, 4, '12201', '1.2.2.01', 'ACCIONES Y VALORES CON COTIZACION ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (55, 1, 4, '12202', '1.2.2.02', 'ACCIONES Y VALORES SIN COTIZACION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (56, 1, 3, '123', '1.2.3', 'BIENES DE USO', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (57, 1, 4, '12301', '1.2.3.01', 'BIENES DE USO AFECTOS A LA CONCESION Y EN SERVICIO', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (58, 1, 4, '12302', '1.2.3.02', 'BiENES DE SERVlCIO ELECTRICO  ALQUILADOS A TERCEROS ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (59, 1, 4, '12303', '1.2.3.03', 'OTROS BIENES DE SERVICIO ELECTRICO', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (60, 1, 4, '12304', '1.2.3.04', 'BIENES OE SERVICIO ELECTRICO EN PROCESO DE CONSTRUCCION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (61, 1, 4, '12305', '1.2.3.05', 'DEPREC. ACUM DE BIENES DE USO AFECTOS A LA CONCESION ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (62, 1, 4, '12306', '1.2.3.06', 'AMORT Y DEP ACUM. DE LOS BIENES DE SERV ELEC ALQ. A TER.  ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (63, 1, 4, '12307', '1.2.3.07', 'AMQRT. Y_DEP. ACUM. DE LOS OTROS_BIENES DE SERV. ELECTRICO', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (64, 1, 4, '12308', '1.2.3.08', 'AJUSTE DE BIENES DE SERVICIO ELECTRICO ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (65, 1, 4, '12309', '1.2.3.09', 'OTROS BIENES (No de Servicio Eléctrico) ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (66, 1, 4, '12310', '1.2.3.10.', 'AMORT Y DEPRECIACION ACUM DE OTROS BIENES (No de Servicio Eléctrico)', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (67, 1, 3, '124', '1.2.4', 'CARGOS DIFERIDOS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (68, 1, 4, '12401', '1.2.4.01', 'BIENES INTANGIBLES AFECTOS A LA CONCESION ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (69, 1, 5, '124011', '1.2.4.01.1', 'BIENES INTANGIBLES DE GENERACION ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (70, 1, 6, '1240111', '1.2.4.01.1.1', 'ORGANIZACION DE LA EMPRESA', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (71, 1, 6, '1240112', '1.2.4.01.1.2', 'CONCESIONES Y PERMISOS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (72, 1, 6, '1240113', '1.2.4.01.1.3', 'OTROS BIENES INTANGIBLES', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (73, 1, 5, '124012', '1.2.4.01.2', 'BIENES INTANGIBLES DE TRANSMISION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (74, 1, 6, '1240121', '1.2.4.01.2.1', 'ORGANIZACION DE LA EMPRESA', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (75, 1, 6, '1240122', '1.2.4.01.2.2', 'CONCESIONES Y PERMISOS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (76, 1, 6, '1240123', '1.2.4.01.2.3', 'OTROS BIENES INTANGIBLES', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (77, 1, 5, '124013', '1.2.4.01.3', 'BIENES INTANGIBLES DE DISTRIBUCION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (78, 1, 6, '1240131', '1.2.4.01.3.1', 'BIENES INTANGIBLES DE ALTA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (79, 1, 7, '124013101', '1.2.4.01.3.1.01', 'ORGANIZACION DE LA EMPRESA', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (80, 1, 7, '124013102', '1.2.4.01.3.1.02', 'CONCESIONES Y PERMISOS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (81, 1, 7, '124013103', '1.2.4.01.3.1.03', 'OTROS BIENES INTANGIBLES', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (82, 1, 6, '1240132', '1.2.4.01.3.2', 'BIENES INTANGIBLES DE MEDIA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (83, 1, 7, '124013201', '1.2.4.01.3.2.01', 'ORGANIZACION DE LA EMPRESA', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (84, 1, 7, '124013202', '1.2.4.01.3.2.02', 'CONCESIONES Y PERMISOS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (85, 1, 7, '124013203', '1.2.4.01.3.2.03', 'OTROS BIENES INTANGIBLES', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (86, 1, 6, '1240133', '1.2.4.01.3.3', 'BIENES INTANGIBLES DE BAJA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (87, 1, 7, '124013301', '1.2.4.01.3.3.01', 'ORGANIZACION DE LA EMPRESA', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (88, 1, 7, '124013302', '1.2.4.01.3.3.02', 'CONCESIONES Y PERMISOS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (89, 1, 7, '124013303', '1.2.4.01.3.3.03', 'OTROS BIENES INTANGIBLES', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (90, 1, 4, '12402', '1.2.4.02', 'AMORT ACUM DE BIENES INTANGIBLES AFECTOS A LA CONCESION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (91, 1, 4, '12403', '1.2.4.03', 'DESCUENTOS Y GASTOS APARA AMORTIZAR SOBRE DEUDAS A LARGO PLAZO', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (92, 1, 4, '12404', '1.2.4.04', 'PERDIDAS EXTRAORDINARIAS DE PROPIEDAD A AMORTIZAR', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (93, 1, 4, '12405', '1.2.4.05', 'CARGOS POR ESTUDIOS E INVESTIGACIONES PRELIMINARES', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (94, 1, 4, '12406', '1.2.4.06', 'OTROS CARGOS DIFERIDOS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (95, 1, 4, '12407', '1.2.4.07', 'CUENTAS PUENTES', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (96, 1, 3, '125', '1.2.5', 'CUENTAS DE ORDEN', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (97, 2, 1, '2', '2', 'PASIVO', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (98, 2, 2, '21', '2.1', 'PASIVO CORRIENTE', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (99, 2, 3, '211', '2.1.1', 'DEUDAS COMERCIALES POR PAGAR', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (100, 2, 4, '21101', '2.1.1.01', 'PROVEEDORES DE ELECTRICIDAD ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (101, 2, 4, '21102', '2.1.1.02', 'OTROS PROVEEDORES', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (102, 2, 4, '21103', '2.1.1.03', 'DOCUMENTOS POR PAGAR', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (103, 2, 4, '21104', '2.1.1.04', 'OTRAS CUENTAS POR PAGAR ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (104, 2, 4, '21105', '2.1.1.05', 'ALUMBRADOS PUBLICOS POR PAGAR ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (105, 2, 3, '212', '2.1.2', 'DEUDAS BANCARIAS Y FINANCIERAS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (106, 2, 4, '21201', '2.1.2.01', 'BONOS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (107, 2, 5, '212011', '2.1.2.01.1', 'BONOS NO AFECTOS A LA CONCESION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (108, 2, 5, '212012', '2.1.2.01.2', 'BONOS PARA OBRAS DE ALTA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (109, 2, 5, '212013', '2.1.2.01.3', 'BONOS PARA OBRAS DE MEDIA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (110, 2, 5, '212014', '2.1.2.01.4', 'BONOS PARA OBRA DE BAJA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (111, 2, 4, '21202', '2.1.2.02', 'DEUDAS CON GARANTIA', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (112, 2, 5, '212021', '2.1.2.02.1', 'DEUDAS CON GARANTIA NO AFECTOS A LA CONCESION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (113, 2, 5, '212022', '2.1.2.02.2', 'DEUDAS CON GARANTIA PARA OBRAS EN ALTA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (114, 2, 5, '212023', '2.1.2.02.3', 'DEUDAS CON GARANTIA PARA OBRAS EN MEDIA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (115, 2, 5, '212024', '2.1.2.02.4', 'DEUDAS CON GARANTIA PARA OBRAS EN BAJA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (116, 2, 4, '21203', '2.1.2.03', 'DEUDAS SIN GARANTIA', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (117, 2, 5, '212031', '2.1.2.03.1', 'DEUDAS SIN GARANTIA NO AFECTOS A LA CONCESION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (118, 2, 5, '212032', '2.1.2.03.2', 'DEUDAS SIN GARANTIA PARA OBRAS EN ALTA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (119, 2, 5, '212033', '2.1.2.03.3', 'DEUDAS SIN GARANTIA PARA OBRAS EN MEDIA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (120, 2, 5, '212034', '2.1.2.03.4', 'DEUDAS SIN GARANTIA PARA OBRA EN BAJA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (121, 2, 3, '213', '2.1.3', 'DEUDAS SOCIALES', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (122, 2, 4, '21301', '2.1.3.01', 'REMUNERACIONES A PAGAR', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (123, 2, 4, '21302', '2.1.3.02', 'CARGAS SOCIALES A PAGAR .', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (124, 2, 4, '21303', '2.1.3.03', 'PROVISIONES PARA AGUINALDOS ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (125, 2, 4, '21304', '2.1.3.04', 'PROVISIONES PARA PRIMAS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (126, 2, 3, '214', '2.1.4', 'DEUDAS FISCALES', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (127, 2, 4, '21401', '2.1.4.01', 'IMPUESTOS A PAGAR', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (128, 2, 5, '214011', '2.1.4.01.1', 'IMPUESTO A LAS TRANSACCIONES ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (129, 2, 5, '214012', '2.1.4.01.2', 'IMPUESTO SOBRE UTILIDADES DE LA EMPRESA', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (130, 2, 5, '214013', '2.1.4.01.3', 'IMPUESTOS A LA PROPIEDAD', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (131, 2, 5, '214014', '2.1.4.01.4', 'IMPUESTO AL VALOR AGREGADO', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (132, 2, 6, '2140141', '2.1.4.01.4.1', 'I.V.A. DEBITO FISCAL', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (133, 2, 6, '2140142', '2.1.4.01.4.2', 'I.V.A. SALDO A PAGAR', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (134, 2, 4, '21402', '2.1.4.02', 'RETENCIONES IMPOSITIVAS A PAGAR', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (135, 2, 3, '215', '2.1.5', 'OTRAS DEUDAS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (136, 2, 4, '21501', '2.1.5.01', 'DOCUMENTOS POR PAGAR A EMPRESAS VINCULADAS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (137, 2, 5, '215011', '2.1.5.01.1', 'DOCUMENTOS POR PAGAR NO AFECTOS A LA CONCESION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (138, 2, 5, '215012', '2.1.5.01.2', 'DOCUMENTOS POR PAGAR PARA OBRAS EN ALTA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (139, 2, 5, '215013', '2.1.5.01.3', 'DOCUMENTOS POR PAGAR PARA OBRAS EN MEDIA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (140, 2, 5, '215014', '2.1.5.01.4', 'DOCUMENTOS POR PAGAR PARA OBRAS EN BAJA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (141, 2, 4, '21502', '2.1.5.02', 'CUENTAS POR PAGAR A EMPRESAS VINCULADAS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (142, 2, 5, '215021', '2.1.5.02.1', 'CUENTAS POR PAGAR NO AFECTOS A LA CONCESION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (143, 2, 5, '215022', '2.1.5.02.2', 'CUENTAS POR PAGAR PARA OBRAS EN ALTA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (144, 2, 5, '215023', '2.1.5.02.3', 'CUENTAS POR PAGAR PARA OBRAS EN MEDIA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (145, 2, 5, '215024', '2.1.5.02.4', 'CUENTAS POR PAGAR PARA OBRAS EN BAJA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (146, 2, 4, '21503', '2.1.5.03', 'DEPOSITO DE GARANTIAS DE CLIENTES', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (147, 2, 4, '21504', '2.1.5.04', 'INTERESES A PAGAR', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (148, 2, 4, '21505', '2.1.5.05', 'DIVIDENDOS A PAGAR', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (149, 2, 4, '21506', '2.1.5.06', 'COBROS ADELANTADOS A CLIENTES', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (150, 2, 3, '216', '2.1.6', 'CREDITOS DIFERIDOS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (151, 2, 4, '21601', '2.1.6.01', 'INTERESES A DEVENGAR SOBRE DEUDAS A LARGO PLAZO', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (152, 2, 4, '21602', '2.1.6.02', 'ADELANTOS DE CLIENTES PARA CONSTRUCCION ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (153, 2, 4, '21603', '2.1.6.03', 'TASACIONES Y REVALORACIONES TRANSITORIAS ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (154, 2, 4, '21604', '2.1.6.04', 'OTROS CREDITOS DIFERIDOS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (155, 2, 2, '22', '2.2', 'PASIVO NO CORRIENTE', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (156, 2, 3, '221', '2.2.1', 'DEUDAS COMERCIALES POR PAGAR', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (157, 2, 4, '22101', '2.2.1.01', 'PROVEEDORES DE ELECTRICIDAD', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (158, 2, 4, '22102', '2.2.1.02', 'OTROS PROVEEDORES', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (159, 2, 4, '22103', '2.2.1.03', 'DOCUMENTOS POR PAGAR', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (160, 2, 4, '22104', '2.2.1.04', 'OTRAS CUENTAS POR PAGAR', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (161, 2, 4, '22105', '2.2.1.05', 'ALUMBRADO PUBLICO POR PAGAR', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (162, 2, 3, '222', '2.2.2', 'DEUDAS BANCARIAS Y FINANCIERAS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (163, 2, 4, '22201', '2.2.2.01', 'BONOS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (164, 2, 5, '222011', '2.2.2.01.1', 'BONOS NO AFECTOS A LA CONCESION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (165, 2, 5, '222012', '2.2.2.01.2', 'BONOS PARA 0BRAS EN ALTA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (166, 2, 5, '222013', '2.2.2.01.3', 'BONOS PARA OBRAS EN MEDIA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (167, 2, 5, '222014', '2.2.2.01.4', 'BONOS PARA OBRAS EN BAJA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (168, 2, 4, '22202', '2.2.2.02', 'DEUDAS CON GARANTIA', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (169, 2, 5, '222021', '2.2.2.02.1', 'DEUDAS CON GARANTIA NO AFECTOS A LA CONCESION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (170, 2, 5, '222022', '2.2.2.02.2', 'DEUDAS CON GARANTIA PARA OBRAS EN ALTA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (171, 2, 5, '222023', '2.2.2.02.3', 'DEUDAS CON GARANTIA PARA OBRAS EN MEDIA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (172, 2, 5, '222024', '2.2.2.02.4', 'DEUDAS CON GARANTIA PARA OBRAS EN BAJA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (173, 2, 4, '22203', '2.2.2.03', 'DEUDAS SIN GARANTIA', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (174, 2, 5, '222031', '2.2.2.03.1', 'DEUDAS SIN GARANTIA NO AFECTOS A LA CONCESION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (175, 2, 5, '222032', '2.2.2.03.2', 'DEUDAS SIN GARANTIA PARA OBRAS EN ALTA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (176, 2, 5, '222033', '2.2.2.03.3', 'DEUDAS SIN GARANTIA PARA OBRAS EN MEDIA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (177, 2, 5, '222034', '2.2.2.03.4', 'DEUDAS SIN GARANTIA PARA OBRAS EN BAJA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (178, 2, 3, '223', '2.2.3', 'DEUDAS SOCIALES', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (179, 2, 4, '22301', '2.2.3.01', 'REMUNERACIONES A PAGAR', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (180, 2, 4, '22302', '2.2.3.02', 'CARGAS SOCIALES A PAGAR', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (181, 2, 3, '224', '2.2.4', 'DEUDAS FISCALES', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (182, 2, 4, '22401', '2.2.4.01', 'IMPUESTOS A PAGAR', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (183, 2, 3, '225', '2.2.5', 'OTRAS DEUDAS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (184, 2, 4, '22501', '2.2.5.01', 'DOCUMENTOS POR PAGAR A EMPRESAS VINCULADAS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (185, 2, 5, '225011', '2.2.5.01.1', 'DOCUMENTOS POR PAGAR NO AFECTOS A LA CONCESION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (186, 2, 5, '225012', '2.2.5.01.2', 'DOCUMENTOS POR PAGAR PARA OBRAS EN ALTA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (187, 2, 5, '225013', '2.2.5.01.3', 'DOCUMENTOS POR PAGAR PARA OBRAS EN MEDIA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (188, 2, 5, '225014', '2.2.5.01.4', 'DOCUMENTOS POR PAGAR PARA OBRAS EN BAJA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (189, 2, 4, '22502', '2.2.5.02', 'CUENTAS POR PAGAR A EMPRESAS VINCULADAS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (190, 2, 5, '225021', '2.2.5.02.1', 'CUENTAS POR PAGAR NO AFECTOS A LA CONCESION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (191, 2, 5, '225022', '2.2.5.02.2', 'CUENTAS POR PAGAR PARA OBRAS EN ALTA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (192, 2, 5, '225023', '2.2.5.02.3', 'CUENTAS POR PAGAR PARA OBRAS EN MEDIA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (193, 2, 5, '225024', '2.2.5.02.4', 'CUENTAS POR PAGAR PARA OBRAS EN BAJA TENSION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (194, 2, 4, '22203', '2.2.2.03', 'DEPOSITO DE GARANTIAS DE CLIENTES', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (195, 2, 4, '22504', '2.2.5.04', 'INTERESES A PAGAR', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (196, 2, 4, '22505', '2.2.5.05', 'DIVIDENDOS A PAGAR', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (197, 2, 4, '22506', '2.2.5.06', 'OTRAS DEUDAS A LARGO PLAZO', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (198, 2, 3, '226', '2.2.6', 'PREVISIONES', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (199, 2, 4, '22601', '2.2.6.01', 'PREVISIONES PARA SEGUROS DE PROPIEDAD', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (200, 2, 4, '22602', '2.2.6.02', 'PREVISIONES PARA DAÑOS Y PERJUICIOS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (201, 2, 4, '22603', '2.2.6.03', 'PREVISIONES PARA INDEMNIZACIONES', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (202, 2, 4, '22604', '2.2.6.04', 'OTRAS PREVISIONES DE OPERACION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (203, 2, 3, '227', '2.2.7', 'CREDITOS DIFERIDOS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (204, 2, 4, '22701', '2.2.7.01', 'INTERESES A DEVENGAR SOBRE DEUDAS A LARGO PLAZO', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (205, 2, 4, '22702', '2.2.7.02', 'ADELANTOS DE CLIENTES PARA CONSTRUCCION', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (206, 2, 4, '22703', '2.2.7.03', 'TASACIONES Y REVALORACIONES TRANSITORIAS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (207, 2, 4, '22704', '2.2.7.04', 'OTROS CREDITOS DIFERIDOS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (208, 2, 3, '228', '2.2.8', 'CUENTAS DE ORDEN', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (209, 3, 1, '3', '3', 'PATRIMONIO NETO', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (210, 3, 2, '31', '3.1', 'CAPITAL', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (211, 3, 3, '311', '3.1.1', 'CAPITAL AUTORIZADO', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (212, 3, 4, '31101', '3.1.1.01', 'ACCIONES COMUNES AUTORIZADAS ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (213, 3, 4, '31102', '3.1.1.02', 'ACCIONES PREFERENTES AUTORIZADAS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (214, 3, 3, '312', '3.1.2', 'CAPITAL SUSCRITO', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (215, 3, 4, '31201', '3.1.2.01', 'ACCIONES COMUNES SUSCRITAS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (216, 3, 4, '31202', '3.1.2.02', 'ACCIONES PREFERENTES SUSCRITAS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (217, 3, 3, '313', '3.1.3', 'CAPITAL PAGADO', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (218, 3, 4, '31301', '3.1.3.01', 'ACCIONES COMUNES PAGADAS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (219, 3, 4, '31302', '3.1.3.02', 'ACCIONES PREFERENTES PAGADAS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (220, 3, 3, '314', '3.1.4', 'OTRO CAPITAL PAGADO POR SOCIEDADES ANONIMAS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (221, 3, 3, '315', '3.1.5', 'AJUSTE GLOBAL AL PATRIMONIO', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (222, 3, 2, '32', '3.2', 'RESERVAS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (223, 3, 3, '321', '3.2.1', 'RESERVA LEGAL ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (224, 3, 3, '322', '3.2.2', 'RESERVAS ESTATUTARIAS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (225, 3, 3, '323', '3.2.3', 'REVALORACION TECNICA DE BIENES', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (226, 3, 3, '324', '3.2.4', 'OTRA RESERVAS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (227, 3, 3, '325', '3.2.5', 'CONTRIBUCIONES DE TERCEROS EN 0 PARA BIENES DE SERV ELECTRICO', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (228, 3, 2, '33', '3.3', 'RESULTADOS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (229, 3, 3, '331', '3.3.1', 'RESULTADOS ACUMULADOS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (230, 3, 4, '33101', '3.3.1.01', 'DIVERSOS CREDITOS A SUPERAVIT', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (231, 3, 4, '33102', '3.3.1.02', 'DIVERSOS CARGOS A SUPERAVIT', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (232, 3, 4, '33103', '3.3.1.03', 'SALDO TRANSFERIDO DEL ESTADO DE RESULTADOS ', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (233, 3, 4, '33104', '3.3.1.04', 'CONSIGNACIONES DE SUPERAVIT', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (234, 3, 4, '33105', '3.3.1.05', 'AJUSTE DE EJERCICIOS ANTERIORES', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (235, 3, 4, '33106', '3.3.1.06', 'RESULTADOS ACUMULADOS NO DISTRIBUIDOS', 1, NULL, 5, 0);
INSERT INTO `cofi_cuentas` VALUES (236, 3, 3, '332', '3.3.2', 'RESULTADOS DEL EJERCICIO ', 1, NULL, 5, 0);
COMMIT;

-- ----------------------------
-- Table structure for cofi_cuentas_grupos
-- ----------------------------
DROP TABLE IF EXISTS `cofi_cuentas_grupos`;
CREATE TABLE `cofi_cuentas_grupos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `codigo` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cofi_cuentas_grupos
-- ----------------------------
BEGIN;
INSERT INTO `cofi_cuentas_grupos` VALUES (1, 'Activo', 'A');
INSERT INTO `cofi_cuentas_grupos` VALUES (2, 'Pasivo', 'P');
INSERT INTO `cofi_cuentas_grupos` VALUES (3, 'Patrimonio', 'T');
INSERT INTO `cofi_cuentas_grupos` VALUES (4, 'Ingreso', 'I');
INSERT INTO `cofi_cuentas_grupos` VALUES (5, 'Egreso', 'E');
COMMIT;

-- ----------------------------
-- Table structure for cofi_cuentas_tipos
-- ----------------------------
DROP TABLE IF EXISTS `cofi_cuentas_tipos`;
CREATE TABLE `cofi_cuentas_tipos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `codigo` varchar(10) DEFAULT NULL,
  `longitud` int(4) DEFAULT NULL,
  `sangria` int(4) DEFAULT NULL,
  `cantidad_digitos` int(2) DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cofi_cuentas_tipos
-- ----------------------------
BEGIN;
INSERT INTO `cofi_cuentas_tipos` VALUES (1, 'GRUPOS', 'G', 1, 0, 1);
INSERT INTO `cofi_cuentas_tipos` VALUES (2, 'SUBGRUPOS', 'SG', 2, 2, 1);
INSERT INTO `cofi_cuentas_tipos` VALUES (3, 'RUBROS', 'R', 3, 4, 1);
INSERT INTO `cofi_cuentas_tipos` VALUES (4, 'SUBRUBROS', 'SR', 5, 6, 2);
INSERT INTO `cofi_cuentas_tipos` VALUES (5, 'CUENTAS', 'C', 6, 8, 1);
INSERT INTO `cofi_cuentas_tipos` VALUES (6, 'SUBCUENTAS', 'SC', 7, 10, 1);
INSERT INTO `cofi_cuentas_tipos` VALUES (7, 'SUBSUBCUENTAS', 'SSC', 9, 12, 2);
COMMIT;

-- ----------------------------
-- Table structure for cofi_empresas
-- ----------------------------
DROP TABLE IF EXISTS `cofi_empresas`;
CREATE TABLE `cofi_empresas` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) DEFAULT NULL,
  `direccion` text,
  `telefono` varchar(20) DEFAULT NULL,
  `ciudad` varchar(50) DEFAULT NULL,
  `nit` varchar(20) DEFAULT NULL,
  `numero_patronal` varchar(20) DEFAULT NULL,
  `nombre_responsable` varchar(200) DEFAULT NULL,
  `numero_documento_responsable` varchar(20) DEFAULT NULL,
  `periodo_tipo_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_empresas_periodo_tipo_id` (`periodo_tipo_id`),
  CONSTRAINT `fk_empresas_periodo_tipo_id` FOREIGN KEY (`periodo_tipo_id`) REFERENCES `cofi_periodos_tipos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cofi_empresas_gestiones
-- ----------------------------
DROP TABLE IF EXISTS `cofi_empresas_gestiones`;
CREATE TABLE `cofi_empresas_gestiones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empresa_id` int(11) DEFAULT NULL,
  `gestion` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_empresas_gestions_empresa_id` (`empresa_id`),
  CONSTRAINT `fk_empresas_gestions_empresa_id` FOREIGN KEY (`empresa_id`) REFERENCES `cofi_empresas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cofi_monedas
-- ----------------------------
DROP TABLE IF EXISTS `cofi_monedas`;
CREATE TABLE `cofi_monedas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `codigo` varchar(10) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cofi_monedas
-- ----------------------------
BEGIN;
INSERT INTO `cofi_monedas` VALUES (1, 'Bolivianos', 'Bs.', 1);
INSERT INTO `cofi_monedas` VALUES (2, 'Dolares', 'US $.', 0);
INSERT INTO `cofi_monedas` VALUES (3, 'Unidad de Fomento de Vivienda', 'UFV.', 0);
INSERT INTO `cofi_monedas` VALUES (4, 'Bolivianos y Dolares', 'Bs y US $.', 0);
INSERT INTO `cofi_monedas` VALUES (5, 'Bolivianos y UFV', 'Bs y UFV.', 0);
INSERT INTO `cofi_monedas` VALUES (6, 'Bolivianos, Dolares y UFV', 'Todas.', 0);
COMMIT;

-- ----------------------------
-- Table structure for cofi_periodos_tipos
-- ----------------------------
DROP TABLE IF EXISTS `cofi_periodos_tipos`;
CREATE TABLE `cofi_periodos_tipos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inicio` varchar(10) DEFAULT NULL,
  `fin` varchar(10) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cofi_periodos_tipos
-- ----------------------------
BEGIN;
INSERT INTO `cofi_periodos_tipos` VALUES (1, 'Enero', 'Diciembre', 1);
INSERT INTO `cofi_periodos_tipos` VALUES (2, 'Abril', 'Marzo', 0);
INSERT INTO `cofi_periodos_tipos` VALUES (3, 'Julio', 'Junio', 0);
INSERT INTO `cofi_periodos_tipos` VALUES (4, 'Octubre', 'Septiembre', 0);
COMMIT;

-- ----------------------------
-- Table structure for cofi_plantillas
-- ----------------------------
DROP TABLE IF EXISTS `cofi_plantillas`;
CREATE TABLE `cofi_plantillas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` longtext,
  `empresa_gestion_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_plantillas_empresa_gestion_id` (`empresa_gestion_id`),
  CONSTRAINT `fk_plantillas_empresa_gestion_id` FOREIGN KEY (`empresa_gestion_id`) REFERENCES `cofi_empresas_gestiones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cofi_plantillas_data
-- ----------------------------
DROP TABLE IF EXISTS `cofi_plantillas_data`;
CREATE TABLE `cofi_plantillas_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plantilla_id` int(11) DEFAULT NULL,
  `cuenta_id` int(11) DEFAULT NULL,
  `tipo` enum('DEBE','HABER') DEFAULT NULL,
  `referencia` longtext,
  `porcentaje` double(11,2) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_plantillas_data_plantilla_id` (`plantilla_id`),
  KEY `fk_plantillas_data_cuenta_id` (`cuenta_id`),
  CONSTRAINT `fk_plantillas_data_cuenta_id` FOREIGN KEY (`cuenta_id`) REFERENCES `cofi_cuentas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_plantillas_data_plantilla_id` FOREIGN KEY (`plantilla_id`) REFERENCES `cofi_plantillas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cofi_tasas_cambio
-- ----------------------------
DROP TABLE IF EXISTS `cofi_tasas_cambio`;
CREATE TABLE `cofi_tasas_cambio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `tcBsUS` float(11,6) DEFAULT NULL,
  `tcBsUFV` float(11,6) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;

-- COFI FUNCTIONS
-- ==============

-- COFI_COUNT_CHILDREN_ACCOUNTS()
DELIMITER //
DROP FUNCTION IF EXISTS COFI_COUNT_CHILDREN_ACCOUNTS //
CREATE FUNCTION COFI_COUNT_CHILDREN_ACCOUNTS(codigo_formato VARCHAR(50), gestion_empresa_id INT(11))
	RETURNS INT(11)
BEGIN
	DECLARE COUNTER INT(11);

	SELECT COUNT(*) INTO COUNTER
	FROM cofi_cuentas c
	WHERE c.codigo_formato LIKE CONCAT(codigo_formato, "%") AND c.empresa_gestion_id = gestion_empresa_id;

	RETURN COUNTER;
END; //
DELIMITER ;

-- COFI_UPDATE_FINAL_ACCOUNTS()
DELIMITER //
DROP FUNCTION IF EXISTS COFI_UPDATE_FINAL_ACCOUNTS //
CREATE FUNCTION COFI_UPDATE_FINAL_ACCOUNTS(gestion_empresa_id INT(11))
	RETURNS VARCHAR(10)
BEGIN
	UPDATE cofi_cuentas c
	SET c.final = IF(COFI_COUNT_CHILDREN_ACCOUNTS(c.codigo_formato, gestion_empresa_id) = 1, 1, 0)
    WHERE c.empresa_gestion_id = gestion_empresa_id;

	RETURN "OK";
END; //
DELIMITER ;
