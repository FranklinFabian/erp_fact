SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for sis_servicios
-- ----------------------------
DROP TABLE IF EXISTS `sis_servicios`;
CREATE TABLE `sis_servicios` (
  `Id_Servicio` int(11) NOT NULL AUTO_INCREMENT,
  `Servicio` varchar(200) DEFAULT NULL,
  `Sigla` varchar(2) DEFAULT NULL,
  `Estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `_Creado_Por` varchar(15) NOT NULL,
  `_Actualizado_Por` varchar(15) DEFAULT NULL,
  `_Creado_El` datetime DEFAULT CURRENT_TIMESTAMP,
  `_Actualizado_El` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id_Servicio`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sis_servicios
-- ----------------------------
BEGIN;
INSERT INTO `sis_servicios` VALUES (1, 'ENERGIA ELECTRICA', NULL, 'ACTIVO', '', NULL, '2020-09-19 10:20:11', '2020-12-09 17:40:34');
INSERT INTO `sis_servicios` VALUES (2, 'TV-CABLE', NULL, 'ACTIVO', '', NULL, '2020-09-19 10:20:21', NULL);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;