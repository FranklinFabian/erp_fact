DROP TABLE IF EXISTS `security_actions`;
DROP TABLE IF EXISTS `security_sites`;
DROP TABLE IF EXISTS `modules`;
-- ----------------------------
-- Table structure for modules
-- ----------------------------
CREATE TABLE `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- ----------------------------
-- Records of modules
-- ----------------------------
BEGIN;
INSERT INTO `modules` VALUES (1, 'Contabilidad y Finanzas', 'COFI', 'Es el modulo de contabilidad y finanzas', NULL, 1, '2022-07-01 22:01:14', NULL, NULL);
INSERT INTO `modules` VALUES (2, 'Recursos Humanos', 'RRHH', 'Módulo de recursos humanos', NULL, 1, '2022-07-01 22:01:44', NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for security_sites
-- ----------------------------
CREATE TABLE `security_sites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) DEFAULT NULL,
  `method` varchar(10) DEFAULT NULL,
  `path` text DEFAULT NULL,
  `type` enum('REPORTE') DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `modules_security_sites` (`module_id`),
  CONSTRAINT `modules_security_sites` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of security_sites
-- ----------------------------
BEGIN;
INSERT INTO `security_sites` VALUES (1, 1, 'GET', '/cofi/libros/diario_pdf', 'REPORTE', 'Reporte Libro Diario en PDF', 'Reporte Libro Diario en PDF', 1, 1, '2022-07-01 21:53:46', NULL, NULL);
INSERT INTO `security_sites` VALUES (2, 1, 'GET', '/cofi/libros/diario_excel', 'REPORTE', 'Reporte Libro Diario en EXCEL', 'Reporte Libro Diario en EXCEL', 1, 1, '2022-07-01 21:53:46', NULL, NULL);
INSERT INTO `security_sites` VALUES (3, 1, 'GET', '/cofi/libros/mayor_pdf', 'REPORTE', 'Reporte Libro Mayor en PDF', 'Reporte Libro Mayor en PDF', 1, 1, '2022-07-01 22:14:57', NULL, NULL);
INSERT INTO `security_sites` VALUES (4, 1, 'GET', '/cofi/libros/mayor_excel', 'REPORTE', 'Reporte Libro Mayor en EXCEL', 'Reporte Libro Mayor en EXCEL', 1, 1, '2022-07-01 22:15:19', NULL, NULL);
INSERT INTO `security_sites` VALUES (5, 1, 'GET', NULL, NULL, NULL, NULL, 0, 1, '2022-07-01 22:16:45', NULL, NULL);
INSERT INTO `security_sites` VALUES (6, 1, 'GET', NULL, NULL, NULL, NULL, 0, 1, '2022-07-01 22:16:47', NULL, NULL);
INSERT INTO `security_sites` VALUES (7, 1, 'GET', NULL, NULL, NULL, NULL, 0, 1, '2022-07-01 22:16:49', NULL, NULL);
INSERT INTO `security_sites` VALUES (8, 1, 'GET', NULL, NULL, NULL, NULL, 0, 1, '2022-07-01 22:16:51', NULL, NULL);
INSERT INTO `security_sites` VALUES (9, 1, 'GET', '/cofi/estadosFinancieros/balance_sumas_saldos_pdf', 'REPORTE', 'Estados Financieros: Balance de Sumas y Saldos en PDF', 'Estados Financieros: Balance de Sumas y Saldos en PDF', 1, 1, '2022-07-01 22:16:53', NULL, NULL);
INSERT INTO `security_sites` VALUES (10, 1, 'GET', '/cofi/estadosFinancieros/balance_sumas_saldos_pdf', 'REPORTE', 'Estados Financieros: Balance de Sumas y Saldos en EXCEL', 'Estados Financieros: Balance de Sumas y Saldos en EXCEL', 1, 1, '2022-07-01 22:16:59', NULL, NULL);
INSERT INTO `security_sites` VALUES (11, 1, 'GET', '/cofi/estadosFinancieros/balance_general_pdf', 'REPORTE', 'Estados Financieros: Balance General en PDF', 'Estados Financieros: Balance General en PDF', 1, 1, '2022-07-01 22:16:56', NULL, NULL);
INSERT INTO `security_sites` VALUES (12, 1, 'GET', '/cofi/estadosFinancieros/balance_general_excel', 'REPORTE', 'Estados Financieros: Balance General en EXCEL', 'Estados Financieros: Balance General en EXCEL', 1, 1, '2022-07-01 22:16:56', NULL, NULL);
INSERT INTO `security_sites` VALUES (13, 1, 'GET', '/cofi/estadosFinancieros/estado_resultados_pdf', 'REPORTE', 'Estados Financieros: Estado de Resultados en PDF', 'Estados Financieros: Estado de Resultados en PDF', 1, 1, '2022-07-01 22:19:56', NULL, NULL);
INSERT INTO `security_sites` VALUES (14, 1, 'GET', '/cofi/estadosFinancieros/estado_resultados_excel', 'REPORTE', 'Estados Financieros: Estado de Resultados en EXCEL', 'Estados Financieros: Estado de Resultados en EXCEL', 1, 1, NULL, NULL, NULL);
INSERT INTO `security_sites` VALUES (15, 1, 'GET', '/cofi/estadosFinancieros/estado_cuentas_pdf', 'REPORTE', 'Estados Financieros: Estado de Cuentas en PDF', 'Estados Financieros: Estado de Cuentas en PDF', 1, 1, NULL, NULL, NULL);
INSERT INTO `security_sites` VALUES (16, 1, 'GET', '/cofi/estadosFinancieros/estado_cuentas_excel', 'REPORTE', 'Estados Financieros: Estado de Cuentas en EXCEL (no implementado)', 'Estados Financieros: Estado de Cuentas en EXCEL (no implementado)', 0, 1, NULL, NULL, NULL);
INSERT INTO `security_sites` VALUES (17, 1, 'GET', '/cofi/estadosFinancieros/balance_gral_estado_res_comp_pdf', 'REPORTE', 'Estados Financieros: Balance General y Estado de Resultados Comparativos en PDF', 'Estados Financieros: Balance General y Estado de Resultados Comparativos en PDF', 1, 1, NULL, NULL, NULL);
INSERT INTO `security_sites` VALUES (18, 1, 'GET', '/cofi/estadosFinancieros/balance_gral_estado_res_comp_excel', 'REPORTE', 'Estados Financieros: Balance General y Estado de Resultados Comparativos en EXCEL (no implementado)', 'Estados Financieros: Balance General y Estado de Resultados Comparativos en EXCEL (no implementado)', 0, 1, NULL, NULL, NULL);
INSERT INTO `security_sites` VALUES (19, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `security_sites` VALUES (20, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `security_sites` VALUES (21, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `security_sites` VALUES (22, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `security_sites` VALUES (23, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `security_sites` VALUES (24, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `security_sites` VALUES (25, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `security_sites` VALUES (26, 2, 'POST', '/rrhh/calculos/planilla_salarial', NULL, 'Ejecución de calculo de planillas Salariales', 'Ejecución de calculo de planillas Salariales', 1, 1, '2022-07-05 10:25:05', NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for security_actions
-- ----------------------------
CREATE TABLE `security_actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) DEFAULT NULL,
  `path` text DEFAULT NULL,
  `query` text DEFAULT NULL,
  `method` varchar(10) DEFAULT NULL,
  `data_get` longtext DEFAULT NULL,
  `data_post` longtext DEFAULT NULL,
  `data_session` longtext DEFAULT NULL,
  `more_info` longtext DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `made_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_security_actions_sites` (`site_id`),
  CONSTRAINT `fk_security_actions_sites` FOREIGN KEY (`site_id`) REFERENCES `security_sites` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
