/*
 Navicat Premium Data Transfer

 Source Server         : IlmerConn
 Source Server Type    : MariaDB
 Source Server Version : 100134
 Source Host           : localhost:3306
 Source Schema         : erp_atocha

 Target Server Type    : MariaDB
 Target Server Version : 100134
 File Encoding         : 65001

 Date: 28/01/2021 14:11:27
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for aetn_alimentadores
-- ----------------------------
DROP TABLE IF EXISTS `aetn_alimentadores`;
CREATE TABLE `aetn_alimentadores`  (
  `COD_ALIMENTADOR` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ID Alimentador',
  `COD_PROTECCION` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `SUBESTACION` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `KVA_ALIMENTADOR` float(11, 2) NOT NULL,
  `KV_ALIMENTADOR` float(11, 2) NOT NULL,
  `CONSUM_MT_1` int(11) NOT NULL,
  `CONSUM_MT_2` int(11) NOT NULL,
  `CONSUM_BT_1` int(11) NOT NULL,
  `CONSUM_BT_2` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `COD_LOCALIDADES` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `FECHA_REGISTRO` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`COD_ALIMENTADOR`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of aetn_alimentadores
-- ----------------------------
INSERT INTO `aetn_alimentadores` VALUES ('CENTRO', 'F1', 'TUPIZA', 1313.00, 7.00, 3, 0, 2325, '0', 'TUP', '2020-10-06 14:59:37');
INSERT INTO `aetn_alimentadores` VALUES ('DISTRITO XI', '2F2', 'TUPIZA', 100.00, 7.00, 0, 0, 0, '0', 'TUP', '2020-10-06 14:59:37');
INSERT INTO `aetn_alimentadores` VALUES ('ER', 'TOT', 'LOC', 21.00, 43.00, 65, 87, 43, '22', 'TUP', '2020-10-06 17:53:14');
INSERT INTO `aetn_alimentadores` VALUES ('ERER', 'RETO', 'TYO', 22.00, 23.00, 33, 35, 44, '55', 'TRE, TYO', '2020-12-16 22:39:02');
INSERT INTO `aetn_alimentadores` VALUES ('GR5', 'ERT6', 'TU', 432.00, 543.00, 645, 7556, 6534, '5346', 'PRUEBA 2', '2020-10-07 15:49:36');
INSERT INTO `aetn_alimentadores` VALUES ('LAMBOL', 'F8', 'TUPIZA', 2490.00, 7.00, 7, 0, 1513, '0', 'TUP', '2020-10-06 14:59:37');
INSERT INTO `aetn_alimentadores` VALUES ('OESTE', 'FC1', 'TUPIZA', 6000.00, 7.00, 0, 0, 0, '0', 'TUPIZA', '2020-10-06 14:59:37');
INSERT INTO `aetn_alimentadores` VALUES ('SUR', 'SF1', 'TUPIZA', 523.00, 7.00, 3, 0, 691, '0', 'TUP, YUR', '2020-10-06 14:59:37');
INSERT INTO `aetn_alimentadores` VALUES ('TAMBILLO', '5F1', 'TUPIZA', 100.00, 7.00, 0, 0, 0, '0', 'TUP, TAM, CHO', '2020-10-06 14:59:37');

-- ----------------------------
-- Table structure for aetn_causa
-- ----------------------------
DROP TABLE IF EXISTS `aetn_causa`;
CREATE TABLE `aetn_causa`  (
  `CAUSA` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `DESCRIPCION` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`CAUSA`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of aetn_causa
-- ----------------------------
INSERT INTO `aetn_causa` VALUES ('2', 'INTERRUPCIONES PROGRAMADAS');
INSERT INTO `aetn_causa` VALUES ('3', 'CONDICIONES CLIMATICAS - MEDIO AMBIENTE');
INSERT INTO `aetn_causa` VALUES ('4', 'ANIMALES - TERCEROS');
INSERT INTO `aetn_causa` VALUES ('5', 'PROPIAS DE LA RED');
INSERT INTO `aetn_causa` VALUES ('6', 'OTRAS CAUSAS');

-- ----------------------------
-- Table structure for aetn_causa_tipo
-- ----------------------------
DROP TABLE IF EXISTS `aetn_causa_tipo`;
CREATE TABLE `aetn_causa_tipo`  (
  `CAUSA_TIPO` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `DESCRIPCION` varchar(70) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `CAUSA` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`CAUSA_TIPO`) USING BTREE,
  INDEX `FK_CAUSA_TIPO_CAUSA`(`CAUSA`) USING BTREE,
  CONSTRAINT `FK_CAUSA_TIPO_CAUSA` FOREIGN KEY (`CAUSA`) REFERENCES `aetn_causa` (`CAUSA`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of aetn_causa_tipo
-- ----------------------------
INSERT INTO `aetn_causa_tipo` VALUES ('20', 'Ampliacion o mejoras', '2');
INSERT INTO `aetn_causa_tipo` VALUES ('21', 'Reparaciones', '2');
INSERT INTO `aetn_causa_tipo` VALUES ('22', 'Mantenimiento preventivo', '2');
INSERT INTO `aetn_causa_tipo` VALUES ('23', 'Poda o derriba de árboles', '2');
INSERT INTO `aetn_causa_tipo` VALUES ('24', 'Programada no clasificada', '2');
INSERT INTO `aetn_causa_tipo` VALUES ('30', 'Descargas atomosféricas', '3');
INSERT INTO `aetn_causa_tipo` VALUES ('31', 'Lluvia', '3');
INSERT INTO `aetn_causa_tipo` VALUES ('32', 'Viento', '3');
INSERT INTO `aetn_causa_tipo` VALUES ('33', 'Nevada o granizo', '3');
INSERT INTO `aetn_causa_tipo` VALUES ('34', 'Inundación', '3');
INSERT INTO `aetn_causa_tipo` VALUES ('35', 'Incendion (no debido a fallas)', '3');
INSERT INTO `aetn_causa_tipo` VALUES ('36', 'Deslizamiento de tierra', '3');
INSERT INTO `aetn_causa_tipo` VALUES ('37', 'Caída o crecimiento de árboles', '3');
INSERT INTO `aetn_causa_tipo` VALUES ('40', 'Aves u otros animales', '4');
INSERT INTO `aetn_causa_tipo` VALUES ('41', 'Daño o interferencia intencional o voluntario', '4');
INSERT INTO `aetn_causa_tipo` VALUES ('42', 'Daño o interferencia accidental', '4');
INSERT INTO `aetn_causa_tipo` VALUES ('43', 'Falla acometida de los consumidores', '4');
INSERT INTO `aetn_causa_tipo` VALUES ('44', 'Choque de vehículos a postes, estructuras o tirantes', '4');
INSERT INTO `aetn_causa_tipo` VALUES ('50', 'Problema de trabajos de línea viva', '5');
INSERT INTO `aetn_causa_tipo` VALUES ('51', 'Error de operación', '5');
INSERT INTO `aetn_causa_tipo` VALUES ('52', 'Sobrecarga', '5');
INSERT INTO `aetn_causa_tipo` VALUES ('53', 'Instalación o construcción deficiente', '5');
INSERT INTO `aetn_causa_tipo` VALUES ('54', 'Aplicación incorrecta de equipos', '5');
INSERT INTO `aetn_causa_tipo` VALUES ('55', 'Mala operación o ajuste de equipos de protección', '5');
INSERT INTO `aetn_causa_tipo` VALUES ('56', 'Deterioro de equipo pro envejecimiento', '5');
INSERT INTO `aetn_causa_tipo` VALUES ('57', 'Falta de mantenimiento inadecuado de lineas o equipos', '5');
INSERT INTO `aetn_causa_tipo` VALUES ('58', 'Lineas reventadas', '5');
INSERT INTO `aetn_causa_tipo` VALUES ('59', 'Lineas trenzadas', '5');

-- ----------------------------
-- Table structure for aetn_centro_transfo
-- ----------------------------
DROP TABLE IF EXISTS `aetn_centro_transfo`;
CREATE TABLE `aetn_centro_transfo`  (
  `COD_CENTRO` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'codigo del centro de transformacion',
  `TIPO_TRAFO` enum('Monofásico','Bifásico','Trifásico') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'M =Monofasico, B=Bifasico, T=Trifasico',
  `KVA_CENTRO` int(11) NOT NULL,
  `TIPO_USO` enum('General','Exclusivo') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'G=General, E=Exclusivo',
  `NIVEL_CALIDAD` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `COD_PROTECCION` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `COD_ALIMENTADOR` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `COD_PROPIEDAD` enum('Del Distribuidor','Particular') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'D=Del Distribuidor, P=Particular',
  `REL_TRAFO` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `POSICION_TAP` int(11) NOT NULL,
  `CONSUM_MT` int(11) NOT NULL,
  `CONSUM_BT` int(11) NOT NULL,
  `DIRECCION` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `FECHA_REGISTRO` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`COD_CENTRO`) USING BTREE,
  INDEX `FK_CENTRO_CODPROTECCION`(`COD_PROTECCION`) USING BTREE,
  INDEX `FK_CENTRO_CODALIMENTADOR`(`COD_ALIMENTADOR`) USING BTREE,
  CONSTRAINT `FK_CENTRO_CODALIMENTADOR` FOREIGN KEY (`COD_ALIMENTADOR`) REFERENCES `aetn_alimentadores` (`COD_ALIMENTADOR`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_CENTRO_CODPROTECCION` FOREIGN KEY (`COD_PROTECCION`) REFERENCES `aetn_maniobra` (`COD_PROTECCION`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of aetn_centro_transfo
-- ----------------------------
INSERT INTO `aetn_centro_transfo` VALUES ('1', 'Trifásico', 150, 'General', '2', 'F1(MT)', 'CENTRO', 'Particular', '6900/380-220V', 4, 0, 499, 'COCHABAMBA-SUIPACHA', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('10', 'Trifásico', 150, 'General', '2', 'F10(MT)', 'DISTRITO XI', 'Particular', '6600/380-220V', 4, 0, 329, 'AV. BARRIENTOS', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('101', 'Trifásico', 113, 'Exclusivo', '2', 'FHI(MT)', 'CENTRO', 'Particular', '6600/380-220V', 4, 1, 0, 'TEC. SAN JUAN', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('102', 'Trifásico', 100, 'Exclusivo', '2', 'FCNS(MT)', 'CENTRO', 'Particular', '6900/380-220V', 4, 1, 0, 'HOSPITAL OBRERO C.N.S.', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('103', 'Trifásico', 30, 'Exclusivo', '2', 'FAP(MT)', 'LAMBOL', 'Particular', '6600/380-220V', 4, 1, 0, 'C. 7 DE NOVIEMBRE', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('104', 'Trifásico', 50, 'Exclusivo', '2', 'FENT(MT)', 'LAMBOL', 'Particular', '6600/380/220V', 4, 1, 0, 'EDIFICIO ENTEL', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('105', 'Trifásico', 200, 'Exclusivo', '2', 'FBER(MT)', 'TAMBILLO', 'Particular', '6600/380-220', 4, 2, 0, 'EMP. FUNDICION BERNAL', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('106', 'Trifásico', 50, 'Exclusivo', '2', 'FLAB(MT)', 'TAMBILLO', 'Particular', '6600/380-220V', 4, 1, 0, 'CHOROMA -  LABORATORIO LAMBOL', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('107', 'Trifásico', 1000, 'Exclusivo', '2', 'FING(MT)', 'LAMBOL', 'Particular', '6600/380-220V', 4, 1, 0, 'CHOROMA - INGENIO', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('108', 'Trifásico', 600, 'Exclusivo', '2', 'FMIN(MT)', 'LAMBOL', 'Particular', '6600/380-220V', 4, 1, 0, 'CHOROMA - MINA', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('109', 'Trifásico', 50, 'General', '2', 'FVILL(MT)', 'CENTRO', 'Particular', '6600/380-220V', 4, 1, 0, 'COMPLEJO VILLEGAS', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('11', 'Trifásico', 30, 'General', '2', 'F11(MT)', 'LAMBOL', 'Particular', '6900/380-220V', 4, 0, 104, 'VILLA BETHANIA', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('110', 'Trifásico', 15, 'General', '2', 'FTV(MT)', 'DISTRITO XI', 'Particular', '6600/380-220V', 4, 1, 0, 'CHAJRAHUASI NORTE - TV EVANGELICO', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('112', 'Trifásico', 30, 'Exclusivo', '2', 'FMATA(MT)', 'SUR', 'Particular', '6600/380-220V', 4, 1, 0, 'MATADERO MUNICIPAL', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('113', 'Trifásico', 50, 'Exclusivo', '2', 'FCAR(MT)', 'LAMBOL', 'Particular', '6600/380-220V', 4, 1, 0, 'MINERA CARVAR', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('114', 'Trifásico', 300, 'Exclusivo', '2', 'FCOL(MT)', 'LAMBOL', 'Particular', '6600/380-220', 4, 1, 0, 'CHOROMA - DIQUE DE COLAS', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('115', 'Trifásico', 100, 'Exclusivo', '2', 'FHI(MT)', 'CENTRO', 'Del Distribuidor', '6600/400-231', 4, 1, 0, 'HOSPITAL INCHAUSTI - AV. CHICHAS', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('12', 'Trifásico', 100, 'General', '2', 'F12(MT)', 'TAMBILLO', 'Particular', '6600/380-220V', 4, 0, 266, 'VILLA AGUADITA', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('13', 'Trifásico', 150, 'General', '2', 'F13(MT)', 'TAMBILLO', 'Particular', '6900/380-220V', 4, 0, 282, 'VILLA LOURDES ESTE', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('14', 'Trifásico', 75, 'General', '2', 'F14(MT)', 'TAMBILLO', 'Particular', '6600/380-220V', 4, 0, 163, 'VILLA LOURDES OESTE', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('15', 'Trifásico', 100, 'General', '2', 'F15(MT)', 'LAMBOL', 'Particular', '6600/380-220V', 4, 0, 245, 'PUEBLO NUEVO', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('19', 'Trifásico', 30, 'General', '2', 'F19(MT)', 'DISTRITO XI', 'Particular', '6600/380-220V', 4, 0, 14, 'PUENTE TUPIZA', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('2', 'Trifásico', 100, 'General', '2', 'F2(MT)', 'CENTRO', 'Particular', '6900/380-220V', 4, 0, 257, 'AV. CHICHAS WILDE', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('20', 'Trifásico', 750, 'General', '2', 'F20(MT)', 'DISTRITO XI', 'Particular', '6600/380-220V', 4, 0, 180, 'CHAJRAHUASI SUR', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('21', 'Trifásico', 7, 'General', '2', 'F21(MT)', 'DISTRITO XI', 'Particular', '6600/380/220V', 4, 0, 100, 'CALLE ARGENTINA', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('22', 'Trifásico', 75, 'General', '2', 'F22(MT)', 'DISTRITO XI', 'Particular', '6600/380-220V', 4, 0, 277, 'CHAJRAHUASI NORTE', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('23', 'Trifásico', 100, 'General', '2', 'F23(MT)', 'DISTRITO XI', 'Particular', '6600/380-220', 4, 0, 54, 'LA COLORADA', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('24', 'Trifásico', 100, 'General', '2', 'F24(MT)', 'DISTRITO XI', 'Particular', '6600/380-220V', 4, 0, 75, 'LA COLORADA ESTE', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('25', 'Trifásico', 50, 'General', '2', 'F25(MT)', 'DISTRITO XI', 'Particular', '6600/380-220V', 4, 0, 257, 'SAN ANTONIO SUR', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('26', 'Trifásico', 125, 'General', '2', 'F26(MT)', 'DISTRITO XI', 'Particular', '6600/380-220V', 4, 0, 454, 'SAN ANTONIO', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('27', 'Trifásico', 113, 'General', '2', 'F27(MT)', 'DISTRITO XI', 'Particular', '6900/380/220V', 4, 0, 392, 'SAN ANTONIO NORTE', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('3', 'Trifásico', 100, 'General', '2', 'F3(MT)', 'CENTRO', 'Particular', '6900/380-220V', 4, 0, 208, 'AV. CHICHAS - C. FLORIDA', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('30', 'Trifásico', 50, 'General', '2', 'F30(MT)', 'DISTRITO XI', 'Particular', '6600/380-220V', 4, 0, 52, 'ZONA RELAVE', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('31', 'Trifásico', 30, 'General', '2', 'F31(MT)', 'DISTRITO XI', 'Particular', '6600/380-220V', 4, 0, 392, 'VILLA REMEDIOS', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('32', 'Trifásico', 50, 'General', '2', 'F32(MT)', 'DISTRITO XI', 'Particular', '6600/380-220V', 4, 0, 180, 'B. MAGISTERIO', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('32tr', 'Monofásico', 433, 'General', 'Calidad 2', 'RE34', 'GR5', 'Del Distribuidor', '4ew322', 322, 344, 544, 'dasdsa moficiado', '2020-10-12 11:15:54');
INSERT INTO `aetn_centro_transfo` VALUES ('33', 'Trifásico', 100, 'General', '2', 'F33(MT)', 'DISTRITO XI', 'Particular', '6600/380-220V', 4, 0, 117, 'VILLA REMEDIOS NORTE', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('34', 'Trifásico', 75, 'General', '2', 'F34(MT)', 'DISTRITO XI', 'Particular', '6600/380-220V', 4, 0, 291, 'B. RENTISTAS', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('35', 'Trifásico', 30, 'General', '2', 'F35(MT)', 'DISTRITO XI', 'Particular', '6600/380-220V', 4, 0, 141, 'B. LAS DELICIAS', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('36', 'Trifásico', 100, 'General', '2', 'F36(MT)', 'DISTRITO XI', 'Particular', '6600/380-200V', 4, 0, 0, 'B. LAS DELICIAS NORTE', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('37', 'Trifásico', 30, 'General', '2', 'F37(MT)', 'LAMBOL', 'Particular', '6600/380-220V', 4, 0, 60, 'ALFREDO DOMINGUEZ', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('4', 'Trifásico', 150, 'General', '2', 'F4(MT)', 'CENTRO', 'Particular', '6600/380-220V', 4, 0, 233, 'AV. SERRANO', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('40', 'Trifásico', 30, 'General', '2', 'F40(MT)', 'SUR', 'Particular', '6600/380-220V', 4, 0, 10, 'PAMPA COLORADA', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('41', 'Trifásico', 100, 'General', '2', 'F41(MT)', 'SUR', 'Particular', '6900/380-220V', 4, 0, 210, 'VILLA FLORIDA OESTE', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('42', 'Trifásico', 100, 'General', '2', 'F42(MT)', 'SUR', 'Particular', '6900/380-220V', 4, 0, 304, 'VILLA FLORIDA ESTE', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('43', 'Trifásico', 113, 'General', '2', 'F43(MT)', 'SUR', 'Particular', '6600/380-220V', 4, 0, 87, 'SANTA ELENA', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('44', 'Trifásico', 75, 'General', '2', 'F44(MT)', 'SUR', 'Particular', '6600/380-220V', 4, 0, 17, 'SANTA ELENA FINAL', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('45', 'Trifásico', 20, 'General', '2', 'F45(MT)', 'SUR', 'Particular', '6600/380-220V', 4, 0, 5, 'VILLA ESPERANZA', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('46', 'Trifásico', 20, 'General', '2', 'F46(MT)', 'SUR', 'Particular', '6600/380-220V', 4, 0, 94, 'YURCUMA', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('47', 'Trifásico', 45, 'General', '2', 'F47(MT)', 'SUR', 'Particular', '6600/220V', 4, 1, 0, 'YURCUMA - CEPAD', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('49', 'Trifásico', 30, 'General', '2', '1F1', 'SUR', 'Particular', '', 4, 0, 1, 'ZONA BOLIVAR', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('5', 'Trifásico', 200, 'General', '2', 'F5(MT)', 'CENTRO', 'Particular', '6900/380-220V', 4, 0, 444, 'AV. SANTA CRUZ - C. JUNIN', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('51', 'Trifásico', 100, 'General', '2', 'F51(MT)', 'TAMBILLO', 'Particular', '6600/380-220V', 4, 0, 218, 'VILLA FATIMA ALTA', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('52', 'Trifásico', 100, 'General', '2', 'F52(MT)', 'TAMBILLO', 'Particular', '6600/380-220V', 4, 0, 343, 'VILLA FATIMA', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('53', 'Trifásico', 30, 'General', '2', 'F53(MT)', 'TAMBILLO', 'Particular', '6600/380-220V', 4, 0, 166, 'BARRIO 21 DE DICIEMBRE', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('54', 'Trifásico', 30, 'General', '2', 'F54(MT)', 'TAMBILLO', 'Particular', '6900/380-220V', 4, 0, 34, 'LA GRANJA', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('55', 'Trifásico', 50, 'General', '2', 'F55(MT)', 'TAMBILLO', 'Particular', '6900/380-220V', 4, 0, 296, 'SAN GERARDO', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('56', 'Trifásico', 30, 'General', '2', 'F56(MT)', 'TAMBILLO', 'Particular', '6600/380-220V', 4, 0, 1, 'PALALA BAJA', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('57', 'Trifásico', 30, 'General', '2', 'F57(MT)', 'TAMBILLO', 'Particular', '6600/380-220V', 4, 0, 103, 'PALALA PUEBLO', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('58', 'Trifásico', 15, 'General', '2', 'F58(MT)', 'TAMBILLO', 'Particular', '6600/380-220V', 4, 0, 23, 'GRANJA BERNAL', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('59', 'Trifásico', 37, 'General', '2', 'F59(MT)', 'TAMBILLO', 'Particular', '6600/380-220V', 4, 0, 42, 'TAMBILLO BAJO', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('6', 'Trifásico', 150, 'General', '2', 'F6(MT)', 'CENTRO', 'Particular', '6900/380-220V', 4, 0, 283, 'AV. SANTA CRUZ NORTE', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('60', 'Trifásico', 37, 'General', '2', 'F60(MT)', 'TAMBILLO', 'Particular', '6600/380-220V', 4, 0, 6, 'TAMBILLO ALTO', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('61', 'Trifásico', 10, 'General', '2', 'F61(MT)', 'TAMBILLO', 'Particular', '6600/380-220', 4, 0, 16, 'TAMBILLO ALTO', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('7', 'Trifásico', 100, 'General', '2', 'F7(MT)', 'CENTRO', 'Particular', '6600/380-220V', 4, 0, 444, 'C. CHOROLQUE - C. AROMA', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('77PRUEBA', 'Monofásico', 777, 'Exclusivo', 'C', 'RE34', 'GR5', 'Del Distribuidor', '78REM', 55, 66, 77, 'PRUEBA 1', '2020-10-12 11:06:33');
INSERT INTO `aetn_centro_transfo` VALUES ('9', 'Trifásico', 75, 'General', '2', '2F3', 'DISTRITO XI', 'Particular', '6600/380-220V', 3, 0, 150, 'AV. BARRIENTOS', '2020-10-09 16:31:04');
INSERT INTO `aetn_centro_transfo` VALUES ('PROB', 'Monofásico', 550, 'General', 'Calidad 2', 'REM', 'ERER', 'Del Distribuidor', '5624', 100, 1200, 2000, 'PRUEBA #1', '2020-12-17 14:46:55');

-- ----------------------------
-- Table structure for aetn_codif_reclamo
-- ----------------------------
DROP TABLE IF EXISTS `aetn_codif_reclamo`;
CREATE TABLE `aetn_codif_reclamo`  (
  `MOTIVO` int(11) NOT NULL,
  `DESCRIPCION` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `DESCRIPCION_TIPO` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `DESCRIPCION_CATEGORIA` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`MOTIVO`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of aetn_codif_reclamo
-- ----------------------------
INSERT INTO `aetn_codif_reclamo` VALUES (0, '', NULL, NULL);
INSERT INTO `aetn_codif_reclamo` VALUES (110100, 'Baja Tensión', 'PRODUCTO TÉCNICO', '');
INSERT INTO `aetn_codif_reclamo` VALUES (110200, 'Sobre Tensión', 'PRODUCTO TÉCNICO', '');
INSERT INTO `aetn_codif_reclamo` VALUES (110300, 'Intermitente no Instantánea', 'PRODUCTO TÉCNICO', '');
INSERT INTO `aetn_codif_reclamo` VALUES (110400, 'Variación de frecuencia', 'PRODUCTO TÉCNICO', '');
INSERT INTO `aetn_codif_reclamo` VALUES (110500, 'Perturbación por Armónicas', 'PRODUCTO TÉCNICO', '');
INSERT INTO `aetn_codif_reclamo` VALUES (110600, 'Interferencia', 'PRODUCTO TÉCNICO', '');
INSERT INTO `aetn_codif_reclamo` VALUES (120101, 'Instalación Interior', 'SERVICIO TÉCNICO', 'FALTA DE ENERGÍA');
INSERT INTO `aetn_codif_reclamo` VALUES (120102, 'En Edificio', 'SERVICIO TÉCNICO', 'FALTA DE ENERGÍA');
INSERT INTO `aetn_codif_reclamo` VALUES (120103, 'Cuadra', 'SERVICIO TÉCNICO', 'FALTA DE ENERGÍA\r\n');
INSERT INTO `aetn_codif_reclamo` VALUES (120104, 'Zona', 'SERVICIO TÉCNICO', 'FALTA DE ENERGÍA');
INSERT INTO `aetn_codif_reclamo` VALUES (120105, 'Ciudad', 'SERVICIO TÉCNICO', 'FALTA DE ENERGÍA');
INSERT INTO `aetn_codif_reclamo` VALUES (120106, 'Alimentador', 'SERVICIO TÉCNICO', 'FALTA DE ENERGÍA');
INSERT INTO `aetn_codif_reclamo` VALUES (120107, 'Falla Instalación Interna del consumidor', 'SERVICIO TÉCNICO', 'FALTA DE ENERGÍA');
INSERT INTO `aetn_codif_reclamo` VALUES (120200, 'CORTES REITERADOS DE ENERGÍA', 'SERVICIO TÉCNICO', NULL);
INSERT INTO `aetn_codif_reclamo` VALUES (130000, 'RESARCIMIENTO DE DAÑOS', NULL, NULL);
INSERT INTO `aetn_codif_reclamo` VALUES (140100, 'Reparación de Vereda', 'SEGURIDAD PÚBLICA', NULL);
INSERT INTO `aetn_codif_reclamo` VALUES (150200, 'Otros', 'OTROS TÉCNICOS', NULL);
INSERT INTO `aetn_codif_reclamo` VALUES (210101, 'Error de Lectura Anterior', 'FACTURACIÓN', 'ERROR DE LECTURA');
INSERT INTO `aetn_codif_reclamo` VALUES (210102, 'Error de Lectura Actual', 'FACTURACIÓN', 'ERROR DE LECTURA');
INSERT INTO `aetn_codif_reclamo` VALUES (210201, 'Error de Promedio', 'FACTURACIÓN', 'FACTURACIÓN ESTIMADA');
INSERT INTO `aetn_codif_reclamo` VALUES (210202, 'Error de Ajuste', 'FACTURACIÓN', 'FACTURACIÓN ESTIMADA');
INSERT INTO `aetn_codif_reclamo` VALUES (210301, 'Mal estado del Medidor', 'FACTURACIÓN', 'FACTURACIÓN INDEBIDA');
INSERT INTO `aetn_codif_reclamo` VALUES (210302, 'Facturas no Recibidas', 'FACTURACIÓN', 'FACTURACIÓN INDEBIDA');
INSERT INTO `aetn_codif_reclamo` VALUES (210303, 'Facturas Fuera de Término', 'FACTURACIÒN', 'FACTURACIÓN INDEBIDA');
INSERT INTO `aetn_codif_reclamo` VALUES (210304, 'Mala aplicación de Recargo por Mora', 'FACTURACIÓN', 'FACTURACIÓN INDEBIDA');
INSERT INTO `aetn_codif_reclamo` VALUES (210306, 'Cobro Indebido de Deudas Ajenas', 'FACTURACIÓN', 'FACTURACIÓN INDEBIDA');
INSERT INTO `aetn_codif_reclamo` VALUES (210307, 'Error en el Sistema de Facturación', 'FACTURACIÓN', 'FACTURACIÓN INDEBIDA');
INSERT INTO `aetn_codif_reclamo` VALUES (210308, 'Excesivo consumo', 'FACTURACIÓN', 'FACTURACIÓN INDEBIDA');
INSERT INTO `aetn_codif_reclamo` VALUES (210309, 'Cargos Indebidos', 'FACTURACIÓN', 'FACTURACIÓN INDEBIDA');
INSERT INTO `aetn_codif_reclamo` VALUES (210310, 'Factor de Medición Incorrecto', 'FACTURACIÓN', 'FACTURACIÓN INDEBIDA');
INSERT INTO `aetn_codif_reclamo` VALUES (210401, 'Incorrecta Aplicación de la estructura', 'FACTURACIÓN', 'TARIFACIÓN');
INSERT INTO `aetn_codif_reclamo` VALUES (210402, 'Categoría Errada', 'FACTURACIÓN', 'TARIFACIÓN');
INSERT INTO `aetn_codif_reclamo` VALUES (210403, 'Error en el Cálculo del Factor de Indexación', 'FACTURACIÓN', 'TARIFACIÓN');
INSERT INTO `aetn_codif_reclamo` VALUES (210501, 'Facturas o Avisos de cobranza no recibidos', 'FACTURACIÓN', 'OTROS DE FACTURACIÓN');
INSERT INTO `aetn_codif_reclamo` VALUES (210502, 'Facturas o Avisos de cobranza fuera de términos', 'FACTURACIÓN', 'OTROS DE FACTURACIÓN');
INSERT INTO `aetn_codif_reclamo` VALUES (210503, 'Otros', 'FACTURACIÓN', 'OTROS DE FACTURACIÓN');
INSERT INTO `aetn_codif_reclamo` VALUES (220102, 'Mal Trabajo Operativo', 'CORTES Y RECONEXIONES DE SERVICIO', 'CORTES');
INSERT INTO `aetn_codif_reclamo` VALUES (220201, 'Reconexión Demorada', 'CORTES Y RECONEXIONES DE SERVICIO', 'RECONEXIONES');
INSERT INTO `aetn_codif_reclamo` VALUES (220202, 'Mal Trabajo Operativo', 'CORTES Y RECONEXIONES DE SERVICIO', 'RECONEXIONES');
INSERT INTO `aetn_codif_reclamo` VALUES (220301, 'Suspensión Indebida del Servicio', 'SUSPENSIONES', NULL);
INSERT INTO `aetn_codif_reclamo` VALUES (220302, 'Retiro Indebido del Medidor', 'SUSPENSIONES', NULL);
INSERT INTO `aetn_codif_reclamo` VALUES (220303, 'Mal Trabajo Opearativo', 'SUSPENSIONES', NULL);
INSERT INTO `aetn_codif_reclamo` VALUES (220401, 'Retiro Indebido del Medidor', 'REHABILITACIONES', NULL);
INSERT INTO `aetn_codif_reclamo` VALUES (220402, 'Mal Trabajo Operativo', 'REHABILITACIONES', NULL);
INSERT INTO `aetn_codif_reclamo` VALUES (230101, 'Inspección atrasada o demorada', 'SOLICITUDES DE SERVICIO', 'CONEXIÓN NUEVA');
INSERT INTO `aetn_codif_reclamo` VALUES (230102, 'Demora en Conexión con Modificación de Red', 'SOLICITUDES DE SERVICIO', 'CONEXIÓN NUEVA');
INSERT INTO `aetn_codif_reclamo` VALUES (230103, 'Demora en Conexión sin Modificación de Red', 'SOLICITUDES DE SERVICIO', 'CONEXIÓN NUEVA');
INSERT INTO `aetn_codif_reclamo` VALUES (230104, 'Mal Trabajo Operativo', 'SOLICITUDES DE SERVICIO', 'CONEXIÓN NUEVA');
INSERT INTO `aetn_codif_reclamo` VALUES (230201, 'Demora', 'SOLICITUDES DE SERVICIO', 'INCREMENTO/REDUCCIÓN DE LA DEMANDA');
INSERT INTO `aetn_codif_reclamo` VALUES (230202, 'Mal Trabajo Operativo', 'SOLICITUDES DE SERVICIO', 'INCREMENTO/REDUCCIÓN DE LA DEMANDA');
INSERT INTO `aetn_codif_reclamo` VALUES (230401, 'Demora', 'SOLICITUDES DE SERVICIO', 'CAMBIO DE CATEGORÍA');
INSERT INTO `aetn_codif_reclamo` VALUES (230402, 'Categoría Errada', 'SOLICITUDES DE SERVICIO', 'CAMBIO DE CATEGORÍA');
INSERT INTO `aetn_codif_reclamo` VALUES (230501, 'Demora', 'SOLICITUDES DE SERVICIO', 'TRASLADO');
INSERT INTO `aetn_codif_reclamo` VALUES (230502, 'Mal Trabajo Operativo', 'SOLICITUDES DE SERVICIO', 'TRASLADO');
INSERT INTO `aetn_codif_reclamo` VALUES (230601, 'Demora', 'SOLICITUDES DE SERVICIO', 'CAMBIO DE NOMBRE DEL CONSUMIDOR');
INSERT INTO `aetn_codif_reclamo` VALUES (230602, 'Nombre Errado', 'SOLICITUDES DE SERVICIO', 'CAMBIO DE NOMBRE DEL CONSUMIDOR');
INSERT INTO `aetn_codif_reclamo` VALUES (230701, 'Demora', 'SOLICITUDES DE SERVICIO', 'CONEXIONES TEMPORALES');
INSERT INTO `aetn_codif_reclamo` VALUES (230702, 'Mal Trabajo Operativo', 'SOLICITUDES DE SERVICIO', 'CONEXIONES TEMPORALES');
INSERT INTO `aetn_codif_reclamo` VALUES (230801, 'Demora', 'SOLICITUDES DE SERVICIO', 'SUSPENSIONES TEMPORALES/DEFINITIVAS');
INSERT INTO `aetn_codif_reclamo` VALUES (230802, 'Mal Trabajo Operativo', 'SOLICITUDES DE SERVICIO', 'SUSPENSIONES TEMPORALES/DEFINITIVAS');
INSERT INTO `aetn_codif_reclamo` VALUES (230901, 'Demora', 'SOLICITUDES DE SERVICIO', 'CAMBIO EQUIPO DE MEDICIÓN');
INSERT INTO `aetn_codif_reclamo` VALUES (230902, 'Mal Trabajo Operativo', 'SOLICITUDES DE SERVICIO', 'CAMBIO EQUIPO DE MEDICIÓN');
INSERT INTO `aetn_codif_reclamo` VALUES (230903, 'Conductor subdimensionado', 'SOLICITUDES DE SERVICIO', 'CAMBIO EQUIPO DE MEDICIÓN');
INSERT INTO `aetn_codif_reclamo` VALUES (231001, 'Demora', 'SOLICITUDES DE SERVICIO', 'CAMBIO/REPARACIÓN ACOMETIDA');
INSERT INTO `aetn_codif_reclamo` VALUES (231002, 'Mal Trabajo Operativo', 'SOLICITUDES DE SERVICIO', 'CAMBIO/REPARACIÓN ACOMETIDA');
INSERT INTO `aetn_codif_reclamo` VALUES (231003, 'Conductor subdimensionado', 'SOLICITUDES DE SERVICIO', 'CAMBIO/REPARACIÓN ACOMETIDA');
INSERT INTO `aetn_codif_reclamo` VALUES (231200, 'OTROS', 'SOLICITUDES DE SERVICIO', NULL);
INSERT INTO `aetn_codif_reclamo` VALUES (240101, 'Mala Atención en Oficinas', 'OTROS COMERCIALES', 'MALA ATENCIÓN');
INSERT INTO `aetn_codif_reclamo` VALUES (240102, 'Mala Atención en Terreno', 'OTROS COMERCIALES', 'MALA ATENCIÓN');
INSERT INTO `aetn_codif_reclamo` VALUES (240103, 'Mala Atención por Teléfono', 'OTROS COMERCIALES', 'MALA ATENCIÓN');
INSERT INTO `aetn_codif_reclamo` VALUES (240104, 'No contestan el Teléfono', 'OTROS COMERCIALES', 'MALA ATENCIÓN');
INSERT INTO `aetn_codif_reclamo` VALUES (240105, 'Otros', 'OTROS COMERCIALES', 'MALA ATENCIÓN');

-- ----------------------------
-- Table structure for aetn_corte_programado
-- ----------------------------
DROP TABLE IF EXISTS `aetn_corte_programado`;
CREATE TABLE `aetn_corte_programado`  (
  `NRO_PROGRAMADO` int(11) NOT NULL AUTO_INCREMENT,
  `COD_ALIMENTADOR` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `COD_PROTECCION` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `FECHA_HORA_INI` datetime(0) NOT NULL,
  `FECHA_HORA_FIN` datetime(0) NOT NULL,
  `COD_ORIGEN` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ORIGEN_TIPO` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `COD_CAUSA` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `CAUSA_TIPO` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `TIEMPO_INTERRUPCION` decimal(10, 2) NOT NULL,
  `KVA_INTERRUMP` int(11) NOT NULL,
  `CONSUM_AFECTADOS` int(11) NOT NULL,
  `COD_ZONAS` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `TRABAJO` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `ESTADO` enum('ACTIVO','INACTIVO') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `FECHA_REGISTRO` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`NRO_PROGRAMADO`) USING BTREE,
  INDEX `FK_CORTES_PGR_ALIMENTADOR`(`COD_ALIMENTADOR`) USING BTREE,
  INDEX `FK_CORTES_PGR_PROTECCION`(`COD_PROTECCION`) USING BTREE,
  INDEX `FK_CORTES_PGR_CAUSA`(`COD_CAUSA`) USING BTREE,
  INDEX `FK_CORTES_PGR_TIPO_CAUSA`(`CAUSA_TIPO`) USING BTREE,
  INDEX `FK_CORTES_PGR_ORIGEN`(`COD_ORIGEN`) USING BTREE,
  INDEX `FK_CORTES_PGR_ORIGEN_TIPO`(`ORIGEN_TIPO`) USING BTREE,
  CONSTRAINT `FK_CORTES_PGR_ALIMENTADOR` FOREIGN KEY (`COD_ALIMENTADOR`) REFERENCES `aetn_alimentadores` (`COD_ALIMENTADOR`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_CORTES_PGR_CAUSA` FOREIGN KEY (`COD_CAUSA`) REFERENCES `aetn_causa` (`CAUSA`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_CORTES_PGR_ORIGEN` FOREIGN KEY (`COD_ORIGEN`) REFERENCES `aetn_origen` (`ORIGEN`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_CORTES_PGR_ORIGEN_TIPO` FOREIGN KEY (`ORIGEN_TIPO`) REFERENCES `aetn_origen_tipo` (`ORIGEN_TIPO`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_CORTES_PGR_PROTECCION` FOREIGN KEY (`COD_PROTECCION`) REFERENCES `aetn_maniobra` (`COD_PROTECCION`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_CORTES_PGR_TIPO_CAUSA` FOREIGN KEY (`CAUSA_TIPO`) REFERENCES `aetn_causa_tipo` (`CAUSA_TIPO`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of aetn_corte_programado
-- ----------------------------
INSERT INTO `aetn_corte_programado` VALUES (4, 'ER', 'F52(BT)', '2020-10-17 09:25:00', '2020-10-17 14:26:00', '1', '10', '6', '61', 5.01, 444, 777, 'B1,B2', 'prueba 3 editado', 'ACTIVO', '2020-10-17 09:43:02');
INSERT INTO `aetn_corte_programado` VALUES (5, 'GR5', 'F51(MT)', '2020-10-17 11:01:00', '2020-10-17 13:08:00', '1', '10', '4', '43', 2.07, 232, 34, 'B1,B2', 'Prueba 4 edit', 'ACTIVO', '2020-10-17 11:02:44');
INSERT INTO `aetn_corte_programado` VALUES (6, 'ER', 'F51(MT)', '2020-11-09 22:17:00', '2020-11-09 23:18:00', '1', '11', '3', '31', 1.01, 250, 200, 'A10,A1', 'Corte', 'ACTIVO', '2020-11-09 22:18:49');

-- ----------------------------
-- Table structure for aetn_cronograma_equipos
-- ----------------------------
DROP TABLE IF EXISTS `aetn_cronograma_equipos`;
CREATE TABLE `aetn_cronograma_equipos`  (
  `CODIGO_AE` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Codigo de Identificacion Punto de Control PT1',
  `NRO_ID` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Centro Transfo para campañas y Nro cuenta',
  `FECHA_HORA_INST` datetime(0) NOT NULL COMMENT 'Instalacion de Equipo de equipos Medicion',
  `FECHA_HORA_RET` datetime(0) NOT NULL COMMENT 'Retiro de Equipo de equipos Medicion',
  `CAMPANIA` enum('Baja Tensión','Media Tensión','Centro de Transformación','') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `MES` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TIPO_PUNTO` enum('Básico','Reclamo','Alternativo') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TIPO_MEDICION` enum('Medición','Nueva Medición','Remedición') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `OBSERVACION` varchar(400) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ESTADO` enum('ACTIVO','INACTIVO') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `FECHA_REGISTRO` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `_Creado_Por` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `_Actualizado_Por` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `_Creado_El` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `_Actualizado_El` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`CODIGO_AE`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of aetn_cronograma_equipos
-- ----------------------------
INSERT INTO `aetn_cronograma_equipos` VALUES ('TUBB0N1', '2', '2020-11-19 18:19:00', '2020-11-19 20:25:00', 'Baja Tensión', '11', 'Básico', 'Medición', 'Prueba 1', 'ACTIVO', '2020-11-19 18:21:37', NULL, NULL, '2020-11-19 18:20:20', '2020-11-19 18:21:42');
INSERT INTO `aetn_cronograma_equipos` VALUES ('TUCA111', '6', '2020-11-20 09:05:00', '2020-11-20 12:08:00', 'Centro de Transformación', '01', 'Alternativo', 'Medición', 'Prueba 3', 'ACTIVO', '2020-11-20 09:05:30', NULL, NULL, '2020-11-20 09:05:30', '2020-11-20 09:29:28');
INSERT INTO `aetn_cronograma_equipos` VALUES ('TUMR0D1', '4', '2020-11-20 09:30:00', '2020-11-21 10:20:00', 'Media Tensión', '12', 'Reclamo', 'Medición', 'Prueba 2 Editado', 'ACTIVO', '2020-11-20 09:00:51', NULL, NULL, '2020-11-20 09:00:51', '2020-11-20 11:17:39');

-- ----------------------------
-- Table structure for aetn_equipos
-- ----------------------------
DROP TABLE IF EXISTS `aetn_equipos`;
CREATE TABLE `aetn_equipos`  (
  `Id_equipos` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador',
  `Id_reclamo` int(11) NOT NULL COMMENT 'Identificador Reclamo',
  `Descripcion` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Descripcion del daño',
  `Marca` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Marca del equipo dañado',
  `Modelo` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Modelo del equipo',
  `Serie` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Serie',
  `Anio` int(10) NULL DEFAULT NULL COMMENT 'Año',
  `Observaciones` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Observaciones',
  `Estado` enum('ACTIVO','INACTIVO') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Estado del registro',
  `_Creado_Por` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `_Actualizado_Por` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `_Creado_El` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `_Actualizado_El` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id_equipos`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of aetn_equipos
-- ----------------------------
INSERT INTO `aetn_equipos` VALUES (4, 16, 'Tv ', 'Samsung', '2020', '1245', 2020, 'Quemado', NULL, NULL, NULL, '2020-10-30 15:22:53', NULL);
INSERT INTO `aetn_equipos` VALUES (5, 19, 'Radio', 'Sony', '2015', '1455L', 2015, 'Quemado', NULL, NULL, NULL, '2020-11-02 18:47:16', NULL);
INSERT INTO `aetn_equipos` VALUES (6, 19, 'Tv', 'Samsung', '2017', '5456F', 2017, 'Quemado', NULL, NULL, NULL, '2020-11-02 18:47:16', NULL);
INSERT INTO `aetn_equipos` VALUES (7, 20, 'Radio ', 'MAR', '1245', 'dasK', 1245, 'Nin.', NULL, NULL, NULL, '2020-11-02 18:56:38', NULL);
INSERT INTO `aetn_equipos` VALUES (8, 20, 'Tv', 'JUH', '3242', '5667G', 5456, '-', NULL, NULL, NULL, '2020-11-02 18:56:38', NULL);
INSERT INTO `aetn_equipos` VALUES (11, 31, 'ewq', 'ewq', 'ewqe', 'wq', 0, 'ewq', NULL, NULL, NULL, '2020-11-06 18:08:34', NULL);
INSERT INTO `aetn_equipos` VALUES (12, 33, 'dsa', 'das', 'dsa', 'dsa', 0, 'das', NULL, NULL, NULL, '2020-11-06 22:04:05', NULL);
INSERT INTO `aetn_equipos` VALUES (13, 34, 'EW', 'GD', 'RTR', 'RER', 0, 'NGH', NULL, NULL, NULL, '2020-11-06 22:14:26', NULL);

-- ----------------------------
-- Table structure for aetn_feriados
-- ----------------------------
DROP TABLE IF EXISTS `aetn_feriados`;
CREATE TABLE `aetn_feriados`  (
  `ID_FERIADO` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `FECHA` date NOT NULL,
  `ESTADO` enum('ACTIVO','INACTIVO') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`ID_FERIADO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of aetn_feriados
-- ----------------------------
INSERT INTO `aetn_feriados` VALUES (1, 'AÑO NUEVO', '2020-01-01', 'ACTIVO');
INSERT INTO `aetn_feriados` VALUES (2, 'Dia de Evo editado', '2020-01-23', 'INACTIVO');
INSERT INTO `aetn_feriados` VALUES (4, 'Prueba', '2020-08-11', 'INACTIVO');
INSERT INTO `aetn_feriados` VALUES (5, 'Prueba', '2020-12-16', 'INACTIVO');
INSERT INTO `aetn_feriados` VALUES (6, 'sadasdas', '2020-12-16', 'INACTIVO');
INSERT INTO `aetn_feriados` VALUES (7, '!ro de Enero', '2021-01-01', 'ACTIVO');
INSERT INTO `aetn_feriados` VALUES (8, 'preub', '2020-12-22', 'INACTIVO');
INSERT INTO `aetn_feriados` VALUES (9, 'Navidad', '2020-12-25', 'ACTIVO');
INSERT INTO `aetn_feriados` VALUES (10, 'Navidad', '2015-12-25', 'ACTIVO');

-- ----------------------------
-- Table structure for aetn_interrupciones
-- ----------------------------
DROP TABLE IF EXISTS `aetn_interrupciones`;
CREATE TABLE `aetn_interrupciones`  (
  `NRO_INTERRUPCION` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Numero Correlativo de Interrupcion(No repetitivo)',
  `NRO_DIARIO` int(11) NOT NULL COMMENT 'Numero correlativo de registro diario. Coincidir DB-12',
  `NRO_PROGRAMADO` int(11) NULL DEFAULT NULL COMMENT 'Numero correlativo de corte programado:Coincidor DB-11',
  `TIPO_FALLA` enum('Monofasico','Bifasico','Trifasico') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Tipo de falla(M=Monofasico,T=trifasico.B=bifasico',
  `COD_ALIMENTADOR` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Codigo del Alimentador afectado',
  `COD_PROTECCION` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Coodigo del equipo de proteccion o maniobra que opero',
  `ABONADO` int(11) NULL DEFAULT NULL COMMENT 'Identificador del Abonado',
  `FECHA_HORA_INI` datetime(0) NOT NULL COMMENT '(dd/mm/aa hh:mm= Fecha y Hora de inicio de interrupcion',
  `FECHA_HORA_FIN` datetime(0) NOT NULL COMMENT '(dd/mm/aa hh:mm= Fecha y Hora de finalizacion de interrupcion',
  `COD_ORIGEN` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Codigo del origen de la interrupcion segun tabla ST1',
  `ORIGEN_TIPO` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `COD_CAUSA` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Codigo de la causa de la interrupcion segun tabla ST1',
  `CAUSA_TIPO` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `TIEMPO_INTERRUPCION` decimal(10, 2) NOT NULL COMMENT 'Tiempo dela interrupcion en horas (2 decimales)',
  `CONSUM_BT_1` int(11) NOT NULL COMMENT 'Consumidores en BT calidad 1 o 3 afectados',
  `CONSUM_BT_2` int(11) NOT NULL COMMENT 'Consumidores en BT calidad 2 afectados',
  `CONSUM_MT_1` int(11) NOT NULL COMMENT 'Consumidores en MT calidad 1 o 3',
  `CONSUM_MT_2` int(11) NOT NULL COMMENT 'Consumidores en MT calidad 2 afectados',
  `KVA_BT_1` decimal(10, 2) NOT NULL COMMENT 'Potencia Interrumpida BT calidad 1 o 3 (2 decimales)',
  `KVA_BT_2` decimal(10, 2) NOT NULL COMMENT 'Potencia Interrumpida BT calidad 2 (2 decimales)',
  `KVA_MT_1` decimal(10, 2) NOT NULL COMMENT 'Potencia Interrumpida MT calidad 1 o 3 (2 decimales)',
  `KVA_MT_2` decimal(10, 2) NOT NULL COMMENT 'Potencia Interrumpida MT calidad 2 (2 decimales)',
  `MOTIVO` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'Motivos de la Interrupcion (texto explicativo)',
  `OBSERVACION` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'Comentario sobre la Interrupcion',
  `ESTADO` enum('ACTIVO','INACTIVO') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `FECHA_REGISTRO` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`NRO_INTERRUPCION`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of aetn_interrupciones
-- ----------------------------
INSERT INTO `aetn_interrupciones` VALUES (1, 0, 5, 'Trifasico', 'ER', 'RE34', NULL, '2020-10-26 22:33:00', '2020-10-26 23:52:00', '1', '12', '4', '43', 1.19, 12, 43, 54, 65, 433.00, 432.00, 4324.00, 435.00, 'Prueba 1', 'Prueba 1,0', 'ACTIVO', '2020-10-26 22:34:57');
INSERT INTO `aetn_interrupciones` VALUES (2, 0, 1, 'Monofasico', 'CENTRO', 'F60(BT)', NULL, '2020-10-27 15:15:00', '2020-10-27 17:18:00', '1', '11', '4', '43', 2.03, 222, 333, 432, 43, 423.00, 543.00, 65.00, 654.00, 'Prueba 2 EDIT', 'Prueba 2.0 EDITADO', 'ACTIVO', '2020-10-27 15:16:49');
INSERT INTO `aetn_interrupciones` VALUES (3, 10, 6, 'Monofasico', 'ERER', 'REM', NULL, '2020-12-19 16:15:00', '2020-12-19 16:31:00', '0', '03', '5', '52', 0.27, 312, 423, 543, 654, 978.00, 988.00, 890.00, 867.00, 'prueba', 'Obs', 'ACTIVO', '2020-12-19 15:49:56');

-- ----------------------------
-- Table structure for aetn_libro_guardia
-- ----------------------------
DROP TABLE IF EXISTS `aetn_libro_guardia`;
CREATE TABLE `aetn_libro_guardia`  (
  `NRO_DIARIO` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID DIARIO',
  `NRO_PROGRAMADO` int(11) NULL DEFAULT NULL COMMENT 'Numero de corte programdo, si corresponde',
  `TIPO_FALLA` enum('Monofasico','Bifasico','Trifasico') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Tipo de falla(M:Monofasico,B:Bifasico,T:Trifasico)',
  `COD_ALIMENTADOR` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Codigo del Alimentador afectado',
  `COD_PROTECCION` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Codigo del equipo de proteccion o maniobra que opero',
  `FECHA_HORA_INI` datetime(0) NULL COMMENT 'dd/mm/aa hh:mm Fecha y Hra del inicio de la Interrupcion',
  `FECHA_HORA_FIN` datetime(0) NULL DEFAULT NULL COMMENT 'dd/mm/aa hh:mm Fecha y Hra de finalizacion de Interrupcion',
  `COD_ORIGEN` int(10) NULL DEFAULT NULL COMMENT 'Codigo del Origen de la Interrupcion segun Tabla ST1',
  `ORIGEN_TIPO` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `COD_CAUSA` int(10) NULL DEFAULT NULL COMMENT 'Codigo de la causa de la Interrupcion segun Tabla ST1',
  `CAUSA_TIPO` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `TIEMPO_INTERRUPCION` float(11, 2) NULL DEFAULT NULL COMMENT 'Tiempo de Interrupcion en hras (2 decimales)',
  `CONSUM_AFECTADOS` int(11) NULL DEFAULT NULL COMMENT 'Cantidad total de consumidores afectados',
  `OBSERVACION` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'Detalle y/o Observaciones sobre la Interrupcion',
  `ESTADO` enum('ACTIVO','INACTIVO') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `FECHA_REGISTRO` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`NRO_DIARIO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of aetn_libro_guardia
-- ----------------------------
INSERT INTO `aetn_libro_guardia` VALUES (1, NULL, 'Bifasico', '40', '0', NULL, NULL, 1, NULL, 2, NULL, 3.00, 23, 'cdss', 'INACTIVO', '2020-10-26 08:05:33');
INSERT INTO `aetn_libro_guardia` VALUES (2, 0, 'Monofasico', '21', '12', NULL, NULL, 8, NULL, 5, NULL, 1.00, 88, 'DFDS', 'INACTIVO', '2020-10-26 08:45:58');
INSERT INTO `aetn_libro_guardia` VALUES (4, 3, 'Trifasico', 'ER', 'F53(BT)', '2020-10-26 15:14:00', '2020-10-26 00:00:00', 1, '12', 4, '42', -15.00, 20, 'PRUEBA 1', 'ACTIVO', '2020-10-26 15:15:48');
INSERT INTO `aetn_libro_guardia` VALUES (5, 3, 'Trifasico', 'GR5', 'RE34', '2020-10-26 15:14:00', '2020-10-26 00:00:00', 1, '12', 4, '42', -15.00, 20, 'PRUEBA 1', 'ACTIVO', '2020-10-26 16:36:30');
INSERT INTO `aetn_libro_guardia` VALUES (10, 0, 'Bifasico', 'ERER', 'REM', '2020-12-19 11:15:00', '2020-12-19 11:31:00', 1, '10', 6, '60', 0.27, 344, 'obs', 'ACTIVO', '2020-12-19 11:10:28');

-- ----------------------------
-- Table structure for aetn_maniobra
-- ----------------------------
DROP TABLE IF EXISTS `aetn_maniobra`;
CREATE TABLE `aetn_maniobra`  (
  `COD_PROTECCION` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `COD_ALIMENTADOR` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `TIPO_PROTECCION` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ESTADO` enum('ABIERTO','CERRADO') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `KVA_PROTECCION` int(11) NOT NULL,
  `KV_PROTECCION` int(11) NOT NULL,
  `COD_ZONA` int(11) NOT NULL,
  `PROTECCION_SUP` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `CONSUM_MT_1` int(11) NOT NULL,
  `CONSUM_MT_2` int(11) NOT NULL,
  `CONSUM_BT_1` int(11) NOT NULL,
  `CONSUM_BT_2` int(11) NOT NULL,
  `DIRECCION` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `FECHA_REGISTRO` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`COD_PROTECCION`) USING BTREE,
  INDEX `FK_MANIOBRA_ALIMENTADOR`(`COD_ALIMENTADOR`) USING BTREE,
  CONSTRAINT `FK_MANIOBRA_ALIMENTADOR` FOREIGN KEY (`COD_ALIMENTADOR`) REFERENCES `aetn_alimentadores` (`COD_ALIMENTADOR`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of aetn_maniobra
-- ----------------------------
INSERT INTO `aetn_maniobra` VALUES ('1F1', 'SUR', 'SECCIONADOR FUSIBLE', 'CERRADO', 1716, 7, 31, 'S1', 0, 0, 0, 0, 'VILLA BETHANIA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('1F2', 'SUR', 'SECCIONADOR FUSIBLE', 'CERRADO', 363, 7, 25, '1F1', 0, 0, 0, 0, 'AV. BARRIENTOS - J. M. LINARES', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('1F3', 'SUR', 'SECCIONADOR FUSIBLE', 'CERRADO', 75, 7, 21, '1F2', 0, 0, 0, 0, 'AV. BARRIENTOS - YPFB', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('2F2', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 1093, 7, 25, '1F1', 0, 0, 0, 0, 'CALLE J.M. LINARES - AV. BARRIENTOS', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('2F3', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'ABIERTO', 0, 7, 2, '2F2', 0, 0, 0, 0, 'PLAZUELA PEDRO ARRAYA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('2F4', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 893, 7, 11, '2F2', 0, 0, 0, 0, 'PUENTE TUPIZA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('2F5', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 493, 7, 28, '2F4', 0, 0, 0, 0, 'AV. DIEGO DE ALMAGRO - 3RA AVENIDA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('2F6', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 380, 7, 27, '2F5', 0, 0, 0, 0, 'AV. DIEGO DE ALMAGRO - 6TA AVENIDA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('2F7', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 205, 7, 27, '2F6', 0, 0, 0, 0, 'AV. DIEGO DE ALMAGRO - CANCHA LOS ALCONES', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('3F1', 'CENTRO', 'SECCIONADOR FUSIBLE', 'CERRADO', 1263, 7, 31, 'S1', 0, 0, 0, 0, 'VILLA BETHANIA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('3F2', 'CENTRO', 'SECCIONADOR FUSIBLE', 'CERRADO', 1627, 7, 2, '3S1', 0, 0, 0, 0, 'CALLE SUIPACHA - AV. CHICHAS', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('3F3', 'CENTRO', 'SECCIONADOR FUSIBLE', 'ABIERTO', 1000, 7, 2, '3F2', 0, 0, 0, 0, 'CALLE SUIPACHA - PLAZUELA CASTILLIN', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('3F4', 'CENTRO', 'SECCIONADOR FUSIBLE', 'CERRADO', 1215, 7, 2, '3F2', 0, 3, 0, 2241, 'AV. CHICHAS - E. WILDE', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('3F5', 'CENTRO', 'SECCIONADOR FUSIBLE', 'CERRADO', 215, 7, 2, '3F4', 0, 0, 0, 538, 'AV. LA PAZ - PLAZUELA PEDRO D. MURILO', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('3F6', 'CENTRO', 'SECCIONADOR FUSIBLE', 'CERRADO', 115, 7, 22, '3F5', 0, 0, 0, 178, 'VILLA FÁTIMA - AV. LOS ALAMOS', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('3F7', 'CENTRO', 'SECCIONADOR FUSIBLE', 'CERRADO', 15, 7, 40, '3F6', 0, 0, 0, 1, 'Cerro Villa Fatima (Antenal Entel)', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('4F1', 'LAMBOL', 'SECCIONADOR FUSIBLE', 'CERRADO', 1455, 7, 31, 'S1', 0, 0, 0, 0, 'VILLA BETHANIA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('4F2', 'LAMBOL', 'SECCIONADOR FUSIBLE', 'CERRADO', 1180, 7, 39, '4F1', 0, 0, 0, 0, 'CALLE ALTO DE LA ALIANZA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('4F3', 'LAMBOL', 'SECCIONADOR FUSIBLE', 'CERRADO', 1180, 7, 22, '4F2', 0, 0, 0, 0, 'FINAL TUMUSLA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('4F4', 'LAMBOL', 'SECCIONADOR FUSIBLE', 'CERRADO', 1100, 7, 45, '4F3', 0, 0, 0, 0, 'INGENIO LAMBOL', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('5F1', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 817, 7, 31, 'S1', 0, 0, 0, 0, 'VILLA BETHANIA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('5F2', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 482, 7, 39, '5F1', 0, 0, 0, 0, 'PUERTO LA MAR', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('5F3', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 282, 7, 22, '5F2', 0, 0, 0, 0, 'AV. LOS ALAMOS', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('5F4', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 142, 7, 36, '5F3', 0, 0, 0, 0, 'El Callejon', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('5F5', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 47, 7, 35, '5F4', 0, 0, 0, 0, 'PALALA ALTA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('5F6', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 50, 7, 44, '5F4', 0, 0, 0, 0, 'TAMBILLO BAJO', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('5F7', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 50, 7, 45, '5F6', 0, 0, 0, 0, 'CHOROMA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F1(BT)', 'CENTRO', 'SECCIONADOR FUSIBLE', 'CERRADO', 150, 1, 2, 'F1(MT)', 0, 0, 0, 0, 'C. COCHABAMBA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F1(MT)', 'CENTRO', 'SECCIONADOR FUSIBLE', 'CERRADO', 150, 7, 2, '3F2', 0, 0, 0, 0, 'C. COCHAMBAMBA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F10(BT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 150, 1, 2, 'F10(MT)', 0, 0, 0, 0, 'AV. BARRIENTOS', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F10(MT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 150, 7, 2, '2F2', 0, 0, 0, 0, 'AV. BARRIENTOS', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F11(BT)', 'LAMBOL', 'SECCIONADOR FUSIBLE', 'CERRADO', 50, 0, 31, 'F11(MT)', 0, 0, 0, 0, 'VILLA BETHANIA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F11(MT)', 'LAMBOL', 'SECCIONADOR FUSIBLE', 'CERRADO', 50, 7, 31, '4F1', 0, 0, 0, 0, 'VILLA BETHANIA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F12(BT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 100, 1, 20, 'F12(MT)', 0, 0, 0, 0, 'C. ENRIQUE BALDIVIEZO', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F12(MT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 100, 7, 20, '5F1', 0, 0, 0, 0, 'C. ENRIQUE BALDIVIEZO', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F13(BT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 150, 1, 26, 'F13(MT)', 0, 0, 0, 0, 'AV. SATURNINO MURILLO', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F13(MT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 150, 7, 26, '5F1', 0, 0, 0, 0, 'AV. SATURNINO MURILLO', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F14(BT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 150, 1, 26, 'F14(MT)', 0, 0, 0, 0, 'AV. SATURNINO MURILLO', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F14(MT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 75, 7, 26, '5F1', 0, 0, 0, 0, 'AV. SATURNINO MURILLO', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F15(BT)', 'LAMBOL', 'SECCIONADOR FUSIBLE', 'CERRADO', 100, 1, 39, 'F15(MT)', 0, 0, 0, 0, 'PUEBLO NUEVO', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F15(MT)', 'LAMBOL', 'SECCIONADOR FUSIBLE', 'CERRADO', 100, 7, 39, '4F1', 0, 0, 0, 0, 'PUEBLO NUEVO', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F19(BT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 50, 1, 11, 'F19(MT)', 0, 0, 0, 0, 'PUENTE TUPIZA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F19(MT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 50, 7, 11, '2F2', 0, 0, 0, 0, 'PUENTE TUPIZA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F2(BT)', 'CENTRO', 'SECCIONADOR FUSIBLE', 'CERRADO', 100, 1, 2, 'F2(MT)', 0, 0, 0, 0, 'AV. CHICHAS', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F2(MT)', 'CENTRO', 'SECCIONADOR FUSIBLE', 'CERRADO', 100, 7, 2, '3F2', 0, 0, 0, 0, 'AV. CHICHAS', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F20(BT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 75, 1, 11, 'F20(MT)', 0, 0, 0, 0, 'AV. JOSE LUIS SAN JUAN G.', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F20(MT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 75, 7, 11, '2F4', 0, 0, 0, 0, 'AV. JOSE LUIS SAN JUAN G.', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F21(BT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 100, 7, 11, 'F21(MT)', 0, 0, 0, 100, 'CALLE ARGENTINA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F21(MT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 100, 7, 11, '2F4', 0, 0, 0, 100, 'CALLE ARGENTINA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F22(BT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 100, 1, 11, 'F22(MT)', 0, 0, 0, 0, 'CALLE ILLAMPU', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F22(MT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 200, 7, 11, '2F4', 0, 0, 0, 0, 'CALLE ILLAMPU', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F23(BT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 50, 1, 11, 'F23(MT)', 0, 0, 0, 0, 'CALLE LADISLAO CABRERA - LA COLARADA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F23(MT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 50, 7, 11, '2F4', 0, 0, 0, 0, 'CALLE LADISLAO CABRERA - LA COLARADA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F24(BT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 50, 1, 11, 'F24(MT)', 0, 0, 0, 0, 'LA COLORADA OESTE', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F24(MT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 50, 7, 11, '2F4', 0, 0, 0, 0, 'LA COLORADA OESTE', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F25(BT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 75, 1, 28, 'F25(MT)', 0, 0, 0, 0, 'C. IGNACIO SANJINEZ - SAN ANTONIO SUR', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F25(MT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 75, 7, 28, '2F4', 0, 0, 0, 0, 'C. IGNACIO SANJINEZ - SAN ANTONIO SUR', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F26(BT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 125, 1, 28, 'F26(MT)', 0, 0, 0, 0, 'CALLE TOMAS FRIAS - PLAZUELA SAN ANTONIO', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F26(MT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 125, 7, 28, '2F4', 0, 0, 0, 0, 'C. TOMAS FRIAS - PLAZUELA SAN ANTONIO', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F27(BT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 100, 1, 28, 'F27(MT)', 0, 0, 0, 0, 'C. MARIANO SOZA - I. LA CATOLICA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F27(MT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 100, 7, 28, '2F6', 0, 0, 0, 0, 'C. MARIANO SOZA - I. LA CATOLICA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F3(BT)', 'CENTRO', 'SECCIONADOR FUSIBLE', 'CERRADO', 100, 1, 2, 'F3(MT)', 0, 0, 0, 0, 'MERCADO GIL DURAN', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F3(MT)', 'CENTRO', 'SECCIONADOR FUSIBLE', 'CERRADO', 100, 7, 2, '3F3', 0, 0, 0, 0, 'MERCADO GIL DURAN', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F30(BT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 75, 1, 47, 'F30(MT)', 0, 0, 0, 0, 'CALLE RITA ROMANO - C. MANUEL VACA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F30(MT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 75, 7, 47, '2F6', 0, 0, 0, 0, 'C. RITA ROMANO - C. MANUEL VACA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F31(BT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 113, 1, 27, 'F31(MT)', 0, 0, 0, 0, 'AV. DIEGO DE ALMAGRO', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F31(MT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 113, 7, 27, '2F5', 0, 0, 0, 0, 'AV. DIEGO DE ALMAGRO', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F32(BT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 50, 1, 16, 'F32(MT)', 0, 0, 0, 0, 'C. MARIANO SOZA - C. RITA ROMANO', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F32(MT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 50, 7, 16, '2F6', 0, 0, 0, 0, 'C. MARIANO SOZA - C. RITA ROMANO', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F33(BT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 50, 1, 27, 'F33(MT)', 0, 0, 0, 0, 'AV. DIEGO DE ALMAGRO - CANCHA ALCONES', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F33(MT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 50, 7, 27, '2F6', 0, 0, 0, 0, 'AV. DIEGO DE ALMAGRO - CANCHA ALCONES', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F34(BT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 75, 1, 19, 'F34(MT)', 0, 0, 0, 0, 'AV. DIEGO DE ALMAGRO - 24 DE JUNIO', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F34(MT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 75, 7, 19, '2F7', 0, 0, 0, 0, 'AV. DIEGO DE ALMAGRO - 24 DE JUNIO', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F35(BT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 30, 1, 15, 'F35(MT)', 0, 0, 0, 0, 'PLAZUELA LAS DELICIAS', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F35(MT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 30, 7, 15, '2F7', 0, 0, 0, 0, 'PLAZUELA LAS DELICIAS', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F36(BT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 100, 0, 9, 'F36(MT)', 0, 0, 0, 0, 'AV. BOLIVIA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F36(MT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 100, 7, 9, '2F7', 0, 0, 0, 0, 'AV. BOLIVIA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F37(BT)', 'LAMBOL', 'SECCIONADOR FUSIBLE', 'CERRADO', 30, 1, 9, 'F37(MT)', 0, 0, 0, 0, 'B. ALFREDO DOMINGUEZ NORTE', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F37(MT)', 'LAMBOL', 'SECCIONADOR FUSIBLE', 'CERRADO', 30, 7, 9, '4F3', 0, 0, 0, 0, 'B. ALFREDO DOMINGUEZ NORTE', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F4(BT)', 'CENTRO', 'SECCIONADOR FUSIBLE', 'CERRADO', 150, 1, 2, 'F4(MT)', 0, 0, 0, 0, 'AV. SERRANO', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F4(MT)', 'CENTRO', 'SECCIONADOR FUSIBLE', 'CERRADO', 150, 7, 2, '3F3', 0, 0, 0, 0, 'AV. SERRANO', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F40(BT)', 'SUR', 'SECCIONADOR FUSIBLE', 'CERRADO', 30, 1, 25, 'F40(MT)', 0, 0, 0, 0, 'VILLA PAMPA COLORADA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F40(MT)', 'SUR', 'SECCIONADOR FUSIBLE', 'CERRADO', 30, 7, 25, '1F1', 0, 0, 0, 0, 'VILLA PAMPA COLORADA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F41(BT)', 'SUR', 'SECCIONADOR FUSIBLE', 'CERRADO', 100, 1, 25, 'F41(MT)', 0, 0, 0, 0, 'AV. J. M. LINARES - MERCADO CAMPESINO', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F41(MT)', 'SUR', 'SECCIONADOR FUSIBLE', 'CERRADO', 100, 7, 25, '1F1', 0, 0, 0, 0, 'AV. J. M. LINARES - MERCADO CAMPESINO', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F42(BT)', 'SUR', 'SECCIONADOR FUSIBLE', 'CERRADO', 100, 1, 24, 'F42(MT)', 0, 0, 0, 0, 'AV. BARRIENTOS', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F42(MT)', 'SUR', 'SECCIONADOR FUSIBLE', 'CERRADO', 100, 7, 24, '1F2', 0, 0, 0, 0, 'AV. BARRIENTOS', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F43(BT)', 'SUR', 'SECCIONADOR FUSIBLE', 'CERRADO', 113, 1, 42, 'F43(MT)', 0, 0, 0, 0, 'AV. BARRIENTOS', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F43(MT)', 'SUR', 'SECCIONADOR FUSIBLE', 'CERRADO', 113, 7, 42, '1F2', 0, 0, 0, 0, 'AV. BARRIENTOS', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F44(BT)', 'SUR', 'SECCIONADOR FUSIBLE', 'CERRADO', 75, 1, 42, 'F44(MT)', 0, 0, 0, 0, 'AV. BARRIENTOS - YPFB', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F44(MT)', 'SUR', 'SECCIONADOR FUSIBLE', 'CERRADO', 75, 7, 42, '1F2', 0, 0, 0, 0, 'AV. BARRIENTOS - YPFB', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F45(BT)', 'SUR', 'SECCIONADOR FUSIBLE', 'CERRADO', 30, 1, 21, 'F45(MT)', 0, 0, 0, 0, 'VILLA ESPERANZA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F45(MT)', 'SUR', 'SECCIONADOR FUSIBLE', 'CERRADO', 30, 7, 21, '1F3', 0, 0, 0, 0, 'VILLA ESPERANZA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F46(BT)', 'SUR', 'SECCIONADOR FUSIBLE', 'CERRADO', 30, 1, 30, 'F46(MT)', 0, 0, 0, 0, 'YURCUMA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F46(MT)', 'SUR', 'SECCIONADOR FUSIBLE', 'CERRADO', 30, 7, 30, '1F3', 0, 0, 0, 0, 'YURCUMA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F47(BT)', 'SUR', 'SECCIONADOR FUSIBLE', 'CERRADO', 45, 1, 30, 'F47(MT)', 0, 0, 0, 0, 'GRANJA CEPAD', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F47(MT)', 'SUR', 'SECCIONADOR FUSIBLE', 'CERRADO', 45, 7, 30, '1F3', 0, 0, 0, 0, 'GRANJA CEPAD', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F5(BT)', 'CENTRO', 'SECCIONADOR FUSIBLE', 'CERRADO', 200, 1, 2, 'F5(MT)', 0, 0, 0, 0, 'AV. SANTA CRUZ', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F5(MT)', 'CENTRO', 'SECCIONADOR FUSIBLE', 'CERRADO', 200, 7, 2, '3F3', 0, 0, 0, 0, 'AV. SANTA CRUZ', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F51(BT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 100, 1, 23, 'F51(MT)', 0, 0, 0, 0, 'JUAN PABLO II', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F51(MT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 100, 7, 23, '5F2', 0, 0, 0, 0, 'JUAN PABLO II', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F52(BT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 100, 1, 22, 'F52(MT)', 0, 0, 0, 0, 'AV. LOS ALAMOS', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F52(MT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 100, 7, 22, '5F2', 0, 0, 0, 0, 'AV. LOS ALAMOS', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F53(BT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 30, 1, 8, 'F53(MT)', 0, 0, 0, 0, 'CALLE MIRAFLORES', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F53(MT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 30, 7, 8, '5F3', 0, 0, 0, 0, 'CALLE MIRAFLORES', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F54(BT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 30, 1, 40, 'F24(MT)', 0, 0, 0, 0, 'AV. LOS ALAMOS', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F54(MT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 30, 7, 40, '5F3', 0, 0, 0, 0, 'AV. LOS ALAMOS', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F55(BT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 50, 1, 41, 'F55(MT)', 0, 0, 0, 0, 'AV. LOS ALAMOS', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F55(MT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 50, 7, 41, '5F3', 0, 0, 0, 0, 'AV. LOS ALAMOS', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F56(BT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 30, 1, 36, 'F56(MT)', 0, 0, 0, 0, 'AV. LOS ALAMOS', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F56(MT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 30, 7, 36, '5F3', 0, 0, 0, 0, 'AV. LOS ALAMOS', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F57(BT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 30, 1, 36, 'F57(MT)', 0, 0, 0, 0, 'PALALA BAJA PUEBLO', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F57(MT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 30, 7, 36, '5F3', 0, 0, 0, 0, 'PALALA BAJA PUEBLO', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F58(BT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 30, 1, 35, 'F58(MT)', 0, 0, 0, 0, 'PALALA ALTA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F58(MT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 30, 7, 35, '5F4', 0, 0, 0, 0, 'PALALA ALTA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F59(BT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 15, 1, 44, 'F59(MT)', 0, 0, 0, 0, 'TAMBILLO BAJO', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F59(MT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 15, 7, 44, '5F4', 0, 0, 0, 0, 'TAMBILLO BAJO', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F6(BT)', 'CENTRO', 'SECCIONADOR FUSIBLE', 'CERRADO', 150, 1, 2, 'F6(MT)', 0, 0, 0, 0, 'AV. SANTA CRUZ NORTE', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F6(MT)', 'CENTRO', 'SECCIONADOR FUSIBLE', 'CERRADO', 150, 7, 2, '3F3', 0, 0, 0, 0, 'AV. SANTA CRUZ NORTE', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F60(BT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 37, 1, 35, 'F60(MT)', 0, 0, 0, 0, 'PALALA ALTA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F60(MT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 37, 7, 35, '5F5', 0, 0, 0, 0, 'PALALA ALTA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F61(BT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 10, 1, 43, 'F61(MT)', 0, 0, 0, 0, 'TAMBILLO ALTO', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F61(MT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 10, 7, 43, '5F5', 0, 0, 0, 0, 'TAMBILLO ALTO', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F7(BT)', 'CENTRO', 'SECCIONADOR FUSIBLE', 'CERRADO', 100, 1, 2, 'F7(MT)', 0, 0, 0, 0, 'CALLE AROMA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('F7(MT)', 'CENTRO', 'SECCIONADOR FUSIBLE', 'CERRADO', 100, 7, 2, '3F3', 0, 0, 0, 0, 'CALLE AROMA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('FAP(BT)', 'LAMBOL', 'SECCIONADOR FUSIBLE', 'CERRADO', 75, 1, 2, 'FAP(MT)', 0, 0, 0, 0, 'CALLE 7 DE NOVIEMBRE', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('FAP(MT)', 'LAMBOL', 'SECCIONADOR FUSIBLE', 'CERRADO', 75, 7, 2, '4F1', 0, 0, 0, 0, 'CALLE 7 DE NOVIEMBRE', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('FBER(BT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 200, 1, 35, 'FBER(MT)', 0, 0, 0, 0, 'EMPRESA BERNAL', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('FBER(MT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 200, 7, 35, '5F3', 0, 0, 0, 0, 'EMPRESA BERNAL', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('FBON(BT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 100, 1, 44, 'FBON(MT)', 0, 0, 0, 0, 'BOMBA LAMBOL', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('FBON(MT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 100, 7, 44, '5F5', 0, 0, 0, 0, 'BOMBA LAMBOL', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('FCAR(BT)', 'LAMBOL', 'SECCIONADOR FUSIBLE', 'CERRADO', 50, 1, 9, 'FCAR(MT)', 0, 0, 0, 0, 'B. ALFREDO DOMINGUEZ - CARVAR', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('FCAR(MT)', 'LAMBOL', 'SECCIONADOR FUSIBLE', 'CERRADO', 50, 7, 9, '4F3', 0, 0, 0, 0, 'BARRIO ALFREDO DOMINGUEZ - CARVAR', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('FCNS(BT)', 'CENTRO', 'SECCIONADOR FUSIBLE', 'CERRADO', 200, 1, 2, 'FCNS(MT)', 0, 0, 0, 0, 'C.N.S.', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('FCNS(MT)', 'CENTRO', 'SECCIONADOR FUSIBLE', 'CERRADO', 200, 7, 2, '3F3', 0, 0, 0, 0, 'C.N.S.', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('FCOL(BT)', 'LAMBOL', 'SECCIONADOR FUSIBLE', 'CERRADO', 300, 1, 45, 'FCOL(MT)', 0, 0, 0, 0, 'DIQUE DE COLAS', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('FCOL(MT)', 'LAMBOL', 'SECCIONADOR FUSIBLE', 'CERRADO', 300, 7, 45, '4F4', 0, 0, 0, 0, 'DIQUE DE COLAS', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('FENT(BT)', 'LAMBOL', 'SECCIONADOR FUSIBLE', 'CERRADO', 50, 1, 2, 'FENT(MT)', 0, 0, 0, 0, 'CALLE PUERTO LA MAR', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('FENT(MT)', 'LAMBOL', 'SECCIONADOR FUSIBLE', 'CERRADO', 50, 7, 2, '4F1', 0, 0, 0, 0, 'C. PUERTO LA MAR', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('FHI(BT)', 'CENTRO', 'SECCIONADOR FUSIBLE', 'CERRADO', 100, 1, 2, 'FHI(MT)', 0, 0, 0, 0, 'H. BENIGNO INCHAUSTE', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('FHI(MT)', 'CENTRO', 'SECCIONADOR FUSIBLE', 'CERRADO', 100, 7, 2, '3F3', 0, 0, 0, 0, 'H. BENIGNO INCHAUSTE', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('FING(BT)', 'LAMBOL', 'SECCIONADOR FUSIBLE', 'CERRADO', 1000, 1, 45, 'FING(MT)', 0, 0, 0, 0, 'INGENIO I', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('FING(MT)', 'LAMBOL', 'SECCIONADOR FUSIBLE', 'CERRADO', 1000, 7, 45, '4F4', 1, 0, 0, 0, 'INGENIO I', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('FLAB(BT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 50, 1, 45, 'FLAB(MT)', 0, 0, 0, 0, 'CHOROMA - LABORATORIO LAMBOL', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('FLAB(MT)', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'CERRADO', 50, 7, 45, '5F7', 0, 0, 0, 0, 'CHOROMA - LABORATORIO LAMBOL', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('FMATA(BT)', 'SUR', 'SECCIONADOR FUSIBLE', 'CERRADO', 30, 1, 30, 'FMATA(MT)', 0, 0, 1, 0, 'YURCUMA - MATADERO', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('FMATA(MT)', 'SUR', 'SECCIONADOR FUSIBLE', 'CERRADO', 30, 7, 30, '1F3', 0, 0, 1, 0, 'YURCUMA - MATADERO', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('FMIN(BT)', 'LAMBOL', 'SECCIONADOR FUSIBLE', 'CERRADO', 50, 1, 45, 'FMIN(MT)', 0, 0, 0, 0, 'MINA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('FMIN(MT)', 'LAMBOL', 'SECCIONADOR FUSIBLE', 'CERRADO', 50, 7, 45, '4F4', 0, 0, 0, 0, 'MINA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('FPUENTE', 'TAMBILLO', 'SECCIONADOR FUSIBLE', 'ABIERTO', 0, 7, 45, '5F7', 0, 0, 0, 0, 'INGENIO LAMBOL', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('FTEC(BT)', 'CENTRO', 'SECCIONADOR FUSIBLE', 'CERRADO', 113, 1, 2, 'FTEC(MT)', 0, 0, 0, 0, 'CALLE SUCRE', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('FTEC(MT)', 'CENTRO', 'SECCIONADOR FUSIBLE', 'CERRADO', 113, 7, 2, '3F2', 0, 0, 0, 0, 'CALLE SUCRE', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('FTV(BT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 50, 1, 11, 'FTV(MT)', 0, 0, 0, 0, 'PLAZUELA CHAJRAHUASI', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('FTV(MT)', 'DISTRITO XI', 'SECCIONADOR FUSIBLE', 'CERRADO', 50, 7, 11, '2F4', 0, 0, 0, 0, 'PLAZUELA CHAJRAHUASI', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('FVILL(BT)', 'CENTRO', 'SECCIONADOR FUSIBLE', 'CERRADO', 50, 1, 2, 'FVILL(MT)', 0, 0, 0, 0, 'AV. COSTANERA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('FVILL(MT)', 'CENTRO', 'SECCIONADOR FUSIBLE', 'CERRADO', 50, 7, 2, '3F4', 0, 0, 0, 0, 'AV. COSTANERA', '2020-10-07 17:43:59');
INSERT INTO `aetn_maniobra` VALUES ('RE34', 'ER', 'Seccionalizador', 'CERRADO', 77, 88, 1, '99', 33, 44, 55, 66, 'DEFECTO, UY, iL', '2020-10-08 17:10:57');
INSERT INTO `aetn_maniobra` VALUES ('REM', 'ERER', 'Reconectador', 'ABIERTO', 122, 123, 2, '122', 125, 133, 145, 150, 'PROB', '2020-12-17 00:52:08');

-- ----------------------------
-- Table structure for aetn_origen
-- ----------------------------
DROP TABLE IF EXISTS `aetn_origen`;
CREATE TABLE `aetn_origen`  (
  `ORIGEN` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `DESCRIPCION` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`ORIGEN`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of aetn_origen
-- ----------------------------
INSERT INTO `aetn_origen` VALUES ('0', 'ORIGEN INTERNO');
INSERT INTO `aetn_origen` VALUES ('1', 'ORIGEN EXTERNO');

-- ----------------------------
-- Table structure for aetn_origen_tipo
-- ----------------------------
DROP TABLE IF EXISTS `aetn_origen_tipo`;
CREATE TABLE `aetn_origen_tipo`  (
  `ORIGEN_TIPO` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `DESCRIPCION` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ORIGEN` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`ORIGEN_TIPO`) USING BTREE,
  INDEX `FK_ORIGEN_TIPO_ORIGEN`(`ORIGEN`) USING BTREE,
  CONSTRAINT `FK_ORIGEN_TIPO_ORIGEN` FOREIGN KEY (`ORIGEN`) REFERENCES `aetn_origen` (`ORIGEN`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of aetn_origen_tipo
-- ----------------------------
INSERT INTO `aetn_origen_tipo` VALUES ('01', 'Generación - Subtransmision', '0');
INSERT INTO `aetn_origen_tipo` VALUES ('02', 'Distribución Primaria', '0');
INSERT INTO `aetn_origen_tipo` VALUES ('03', 'Distribución Secundaria', '0');
INSERT INTO `aetn_origen_tipo` VALUES ('10', 'Generación', '1');
INSERT INTO `aetn_origen_tipo` VALUES ('11', 'Transmisión', '1');
INSERT INTO `aetn_origen_tipo` VALUES ('12', 'Otros no pertenecientes al distribuidor', '1');

-- ----------------------------
-- Table structure for aetn_reclamos
-- ----------------------------
DROP TABLE IF EXISTS `aetn_reclamos`;
CREATE TABLE `aetn_reclamos`  (
  `NUMERO` int(20) NOT NULL AUTO_INCREMENT COMMENT 'Numero correlativo de Reclamo (No repeptitivo)',
  `NRO_CUENTA` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Numero de Cuenta del Consumidor',
  `NIVEL_CALIDAD` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '1=Calidad 1; 2= Calidad 2; 3=Calidad 3',
  `COD_LOCALIDAD` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Codigo de localidad del Consumidor',
  `CATEGORIA` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Categoria a la que pertenece el Consumidor',
  `COD_RECLAMO` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Codigo de motivo del reclamo segun tabla SC1',
  `FECHA_HORA_REC` datetime(0) NOT NULL COMMENT '(dd/mm/aa hh.mm)Fecha y hora de Presentacion Reclamo',
  `FECHA_HORA_RES` datetime(0) NULL DEFAULT NULL COMMENT '(dd/mm/aa hh.mm)Fecha y hora de respuesta al Consumidor',
  `FECHA_HORA_SOL` datetime(0) NULL DEFAULT NULL COMMENT '(dd/mm/aa hh.mm)Fecha y hora de solucion Reclamo',
  `TIEMPO_TRAMITE` float(11, 2) NULL DEFAULT NULL COMMENT 'Tiempo de tramite en horas con dos decimales',
  `IND_JUSTIFICADO` enum('SI','NO') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Indicador que especifica si el reclamo es justificado',
  `IND_CONFORMIDAD` enum('SI','NO') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Indicador que especifica la conformidad del Consumidor',
  `ESTADO` enum('EMITIDO','PROCESADO','ANULADO','RECEPCIONADO') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'E=EMITIDO; P=PROCESADO; A=ANULADO',
  `MOTIVO` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Motivos (Texto Explicativo)',
  `OBSERVACION` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Comentarios sobre el Tramite',
  `ESTADO_DEL_REGISTRO` enum('ACTIVO','INACTIVO') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `_Creado_Por` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `_Actualizado_Por` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `_Creado_El` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `_Actualizado_El` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`NUMERO`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 39 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of aetn_reclamos
-- ----------------------------
INSERT INTO `aetn_reclamos` VALUES (19, '1', '2', 'TUP', 'TUP', '6000', '2020-11-03 09:33:00', '2020-11-04 09:43:00', '2020-11-04 09:30:00', 24.10, 'NO', NULL, 'PROCESADO', 'Prueba final 1', 'NO CORRESPONDE', 'ACTIVO', NULL, NULL, '2020-11-02 18:47:16', '2020-11-09 14:22:10');
INSERT INTO `aetn_reclamos` VALUES (20, '2', '3', 'TUP', 'TUP', '210402', '2020-11-04 10:20:00', '2020-11-05 09:10:00', '2020-11-05 08:40:00', 22.50, 'SI', NULL, 'PROCESADO', 'Prueba 2 Final', 'Concluido Editado ++', 'ACTIVO', NULL, NULL, '2020-11-02 18:56:37', '2020-11-09 14:06:00');
INSERT INTO `aetn_reclamos` VALUES (35, '5', '3', '1', 'GE', '240104', '2020-11-09 08:30:00', '2020-11-09 10:39:00', '2020-11-09 10:31:00', 2.09, 'SI', NULL, 'PROCESADO', 'Mala Atención', 'Ocupados', 'ACTIVO', NULL, NULL, '2020-11-09 10:39:01', '2020-11-09 10:40:57');
INSERT INTO `aetn_reclamos` VALUES (36, '4', '2', '1', 'GE', '240104', '2020-10-30 11:40:00', NULL, NULL, NULL, NULL, NULL, 'RECEPCIONADO', 'Mala Atencion', '', 'ACTIVO', NULL, NULL, '2020-11-16 09:23:45', NULL);
INSERT INTO `aetn_reclamos` VALUES (37, '1', '2', '1', 'GE', '110100', '2020-11-17 10:04:00', '2020-11-17 14:50:00', '2020-11-17 11:20:00', 4.46, 'SI', NULL, 'PROCESADO', 'Prueba de Tiempos', 'Solucionado', 'ACTIVO', NULL, NULL, '2020-11-17 09:38:39', '2020-11-17 09:40:29');
INSERT INTO `aetn_reclamos` VALUES (38, '5', '1', '1', 'GE', '110600', '2020-11-17 10:04:00', NULL, NULL, NULL, NULL, NULL, 'RECEPCIONADO', 'Obs.', '', 'ACTIVO', NULL, NULL, '2020-11-17 10:06:06', '2020-12-22 14:49:42');

-- ----------------------------
-- Table structure for aetn_reclamosabonado
-- ----------------------------
DROP TABLE IF EXISTS `aetn_reclamosabonado`;
CREATE TABLE `aetn_reclamosabonado`  (
  `Id_reclamosabonado` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador',
  `Id_reclamo` int(11) NOT NULL COMMENT 'Identificador de Reclamo',
  `Cliente` int(11) NOT NULL COMMENT 'Cliente Titular que figura en el Sistema ',
  `Nombre_reclamante` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Cliente que registra el reclamo',
  `Ci_reclamante` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'CI Reclamante',
  `Nro_cuenta_reclamante` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Direccion_reclamante` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Ubicacion de Domicilio del Reclamante',
  `Telefono_1_reclamante` int(10) NOT NULL COMMENT 'Telefono de referencia del reclamante',
  `Telefono_2_reclamante` int(10) NULL DEFAULT NULL COMMENT 'Telefono de referencia del reclamante',
  `Localidad_reclamante` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Zona_reclamante` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Nro_medidor_reclamante` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Domicilio_real_reclamante` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Ubicacion del Domcilio actual',
  `Domicilio_procesal` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Ubicacion del Domcilio actual',
  `Domicilio_especial` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Ubicacion del Domcilio actual',
  `Oficina_odeco` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Medio_recepcion` enum('PERSONAL','TELEFONO','CORREO ELECTRONICO','CORRESPONDENCIA','FACSIMILE') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Fecha_evento_causa` date NULL DEFAULT NULL COMMENT 'Fecha en la que se produjo lo ocurrido',
  `Hora_evento_causa` time(0) NULL DEFAULT NULL COMMENT 'Hora en la que ocurrio',
  `Equipo` tinyint(1) NULL DEFAULT NULL,
  `_Creado_Por` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `_Actualizado_Por` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `_Creado_El` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `_Actualizado_El` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id_reclamosabonado`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 36 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of aetn_reclamosabonado
-- ----------------------------
INSERT INTO `aetn_reclamosabonado` VALUES (16, 19, 1, 'Jorge Coco', '124522', '222222', NULL, 777777, 888888, '888888', '888888', '33333', 'Calle 5', 'Calle 6', 'Calle 7', '1', 'PERSONAL', '2020-11-02', '20:50:00', NULL, NULL, NULL, '2020-11-02 18:47:16', NULL);
INSERT INTO `aetn_reclamosabonado` VALUES (17, 20, 2, 'Juan Choque', '136533', '89666', 'Calle 001ª', 99999, 888888, '2', '4', '5555', 'Calle J', 'calle Y', 'Calle B', '2', 'CORRESPONDENCIA', '2020-11-03', '13:00:00', NULL, NULL, NULL, '2020-11-02 18:56:38', NULL);
INSERT INTO `aetn_reclamosabonado` VALUES (18, 21, 5, 'Ale', '7777777', '5', 'Calle URBANIZACI Nro 1', 432423, 0, '2', '4', '1111', 'Calle 3', 'Calle 4', 'Calle 5', 'TAMBILLO', 'CORREO ELECTRONICO', '2020-11-05', '10:56:00', NULL, NULL, NULL, '2020-11-06 16:54:13', NULL);
INSERT INTO `aetn_reclamosabonado` VALUES (19, 22, 5, 'Ale', '7777777', '5', 'Calle URBANIZACI Nro 1', 432432, 0, '2', '4', '1111', 'Calle 3', 'Calle 4', 'Calle 5', 'TUPIZA', 'CORREO ELECTRONICO', '2020-11-05', '16:00:00', NULL, NULL, NULL, '2020-11-06 16:59:59', NULL);
INSERT INTO `aetn_reclamosabonado` VALUES (20, 23, 5, 'Ale', '7777777', '5', 'Calle URBANIZACI Nro 1', 312321, 0, '1', '1', '1111', 'Calle 3', 'Calle 3', 'Calle 3', 'TUPIZA', 'CORREO ELECTRONICO', '2020-11-05', '17:04:00', NULL, NULL, NULL, '2020-11-06 17:02:12', NULL);
INSERT INTO `aetn_reclamosabonado` VALUES (31, 34, 2, 'PEPE', '654321', '2', 'Calle URBANIZACI Nro 2', 23123, 0, '1', '2', '2222', 'das', 'dsa', 'dsa', 'TUPIZA', 'CORRESPONDENCIA', '2020-11-06', '22:14:00', 1, NULL, NULL, '2020-11-06 22:14:26', NULL);
INSERT INTO `aetn_reclamosabonado` VALUES (32, 35, 5, 'Gustavo Mendez', '4563326', '', 'S/N', 7512466, 0, '2', '4', '', 'Calle 8', 'Calle 9', 'Calle 10', 'YURCUMA', 'CORREO ELECTRONICO', '2020-11-08', '15:45:00', 0, NULL, NULL, '2020-11-09 10:39:02', NULL);
INSERT INTO `aetn_reclamosabonado` VALUES (33, 36, 4, 'PEPE', '654321', '4', 'Calle URBANIZACI Nro 2', 77558877, 0, '1', '1', '22222', 'Calle 2', 'Calle 2', 'Calle 2', 'YURCUMA', 'PERSONAL', '2020-10-30', '10:24:00', 0, NULL, NULL, '2020-11-16 09:23:45', NULL);
INSERT INTO `aetn_reclamosabonado` VALUES (34, 37, 1, 'Jesus Perez', '123456', '1', 'Calle URBANIZACI Nro 1', 0, 0, '1', '1', '1111111', 'NN', 'NN', 'NN', 'TUPIZA', 'TELEFONO', '2020-11-17', '10:04:00', 0, NULL, NULL, '2020-11-17 09:38:39', NULL);
INSERT INTO `aetn_reclamosabonado` VALUES (35, 38, 5, 'Ale', '7777777', '5', 'Calle URBANIZACI Nro 1', 0, 0, '1', '1', '1111', 'SN', 'SN', 'SN', 'TUPIZA', 'PERSONAL', '2020-11-17', '10:04:00', 0, NULL, NULL, '2020-11-17 10:06:06', NULL);

-- ----------------------------
-- Table structure for aetn_reposicion_suministros
-- ----------------------------
DROP TABLE IF EXISTS `aetn_reposicion_suministros`;
CREATE TABLE `aetn_reposicion_suministros`  (
  `NRO_REPOSICION` int(11) NOT NULL AUTO_INCREMENT,
  `NRO_INTERRUPCION` int(11) NOT NULL,
  `COD_PROTECCION` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `FECHA_HORA_REPOS` datetime(1) NOT NULL,
  `CONSUM_REP_BT_1` int(11) NOT NULL,
  `CONSUM_REP_BT_2` int(11) NOT NULL,
  `CONSUM_REP_MT_1` int(11) NOT NULL,
  `CONSUM_REP_MT_2` int(11) NOT NULL,
  `KVA_RESPUESTA_BT_1` int(11) NULL DEFAULT NULL,
  `KVA_RESPUESTA_BT_2` int(11) NULL DEFAULT NULL,
  `KVA_RESPUESTA_MT_1` int(11) NULL DEFAULT NULL,
  `KVA_RESPUESTA_MT_2` int(11) NULL DEFAULT NULL,
  `TIEMPO` decimal(11, 2) NOT NULL COMMENT 'En horas 2 decimales',
  `MOTIVO` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `OBSERVACION` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `ESTADO` enum('ACTIVO','INACTIVO') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `FECHA_REGISTRO` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`NRO_REPOSICION`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of aetn_reposicion_suministros
-- ----------------------------
INSERT INTO `aetn_reposicion_suministros` VALUES (2, 2, 'F51(MT)', '2020-10-27 17:16:00.0', 123, 321, 321, 321, 321, 321, 321, 321, 121.00, 'das', 'dsadsa', 'ACTIVO', '2020-10-28 18:02:32.5');
INSERT INTO `aetn_reposicion_suministros` VALUES (3, 1, 'RE34', '2020-10-27 20:10:00.0', 22, 33, 44, 55, 66, 77, 88, 99, 1297.00, 'Edit', 'Editado', 'ACTIVO', '2020-10-28 18:03:52.0');
INSERT INTO `aetn_reposicion_suministros` VALUES (4, 1, 'F52(BT)', '2020-10-28 18:03:00.0', 12, 32, 43, 45, 65, 76, 78, 89, 2610.00, 'Prueba 1', 'Prueba 1,0', 'ACTIVO', '2020-10-28 18:04:56.3');
INSERT INTO `aetn_reposicion_suministros` VALUES (5, 3, 'REM', '2020-12-19 16:31:00.0', 312, 423, 543, 654, 22, 22, 22, 22, 0.27, 'Prueba edit', 'Prueba 1', 'ACTIVO', '2020-12-22 00:26:04.9');

-- ----------------------------
-- Table structure for aetn_reposicion_suministros_mt
-- ----------------------------
DROP TABLE IF EXISTS `aetn_reposicion_suministros_mt`;
CREATE TABLE `aetn_reposicion_suministros_mt`  (
  `NRO_INTERRUPCION` int(11) NOT NULL,
  `NRO_REPOSICION` int(11) NOT NULL,
  `NRO_CUENTA` int(11) NOT NULL,
  `NIVEL_CALIDAD` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `FECHA_HORA_REPOS` datetime(0) NOT NULL,
  `TIEMPO` decimal(11, 2) NOT NULL COMMENT 'En horas con 2 decimales',
  `OBSERVACION` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `ESTADO` enum('ACTIVO','INACTIVO') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `FECHA_REGISTRO` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `_Creado_Por` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `_Actualizado_Por` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `_Creado_El` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `_Actualizado_El` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`NRO_REPOSICION`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of aetn_reposicion_suministros_mt
-- ----------------------------
INSERT INTO `aetn_reposicion_suministros_mt` VALUES (1, 2, 3, NULL, '2020-11-10 17:26:00', 354.00, 'Prueba 1', 'INACTIVO', '2020-11-10 17:27:08', NULL, NULL, '2020-11-10 17:27:08', '2020-12-22 02:45:56');
INSERT INTO `aetn_reposicion_suministros_mt` VALUES (2, 3, 2, NULL, '2020-11-10 17:00:00', 337.45, 'prueba 2 editado', 'INACTIVO', '2020-11-10 17:56:51', NULL, NULL, '2020-11-10 17:56:51', '2020-12-22 02:45:26');
INSERT INTO `aetn_reposicion_suministros_mt` VALUES (2, 4, 3, NULL, '2020-11-10 18:03:00', 338.48, 'Prueba 3', 'INACTIVO', '2020-11-10 18:03:54', NULL, NULL, '2020-11-10 18:03:54', '2020-12-22 02:45:50');
INSERT INTO `aetn_reposicion_suministros_mt` VALUES (3, 5, 1, NULL, '2020-12-19 16:41:00', 0.43, 'Prueba 1', 'ACTIVO', '2020-12-22 02:44:01', NULL, NULL, '2020-12-22 02:44:01', '2020-12-22 02:51:36');

-- ----------------------------
-- Table structure for aetn_semestres
-- ----------------------------
DROP TABLE IF EXISTS `aetn_semestres`;
CREATE TABLE `aetn_semestres`  (
  `Id_Semestre` int(11) NOT NULL AUTO_INCREMENT,
  `Sigla` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Mes_Inicio` date NOT NULL,
  `Mes_Final` date NOT NULL,
  `_Creado_Por` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `_Actualizado_Por` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `_Creado_El` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `_Actualizado_El` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id_Semestre`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of aetn_semestres
-- ----------------------------
INSERT INTO `aetn_semestres` VALUES (1, 'R09', '2015-05-01', '2015-10-31', NULL, NULL, '2020-11-15 15:44:17', NULL);
INSERT INTO `aetn_semestres` VALUES (2, 'R10', '2015-11-01', '2016-04-30', NULL, NULL, '2020-11-15 15:45:09', NULL);
INSERT INTO `aetn_semestres` VALUES (3, 'R11', '2016-05-01', '2016-10-31', NULL, NULL, '2020-11-15 15:46:10', NULL);
INSERT INTO `aetn_semestres` VALUES (4, 'R12', '2016-11-01', '2017-04-30', NULL, NULL, '2020-11-15 15:47:09', NULL);
INSERT INTO `aetn_semestres` VALUES (5, 'R13', '2017-05-01', '2017-10-31', NULL, NULL, '2020-11-15 15:48:10', NULL);
INSERT INTO `aetn_semestres` VALUES (6, 'R14', '2017-11-01', '2018-04-30', NULL, NULL, '2020-11-15 15:48:42', NULL);
INSERT INTO `aetn_semestres` VALUES (7, 'R15', '2018-05-01', '2018-10-31', NULL, NULL, '2020-11-15 15:48:49', '2020-11-15 15:51:27');
INSERT INTO `aetn_semestres` VALUES (8, 'R16', '2018-11-01', '2019-04-30', NULL, NULL, '2020-11-15 15:52:51', NULL);
INSERT INTO `aetn_semestres` VALUES (9, 'R17', '2019-05-01', '2019-10-31', NULL, NULL, '2020-11-15 15:53:52', NULL);
INSERT INTO `aetn_semestres` VALUES (10, 'R18', '2019-11-01', '2020-04-30', NULL, NULL, '2020-11-15 15:54:44', NULL);
INSERT INTO `aetn_semestres` VALUES (11, 'R19', '2020-05-01', '2020-10-31', NULL, NULL, '2020-11-15 15:55:12', NULL);
INSERT INTO `aetn_semestres` VALUES (12, 'R20', '2020-11-01', '2021-04-30', NULL, NULL, '2020-11-15 15:55:51', NULL);

SET FOREIGN_KEY_CHECKS = 1;
