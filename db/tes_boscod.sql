/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100425
 Source Host           : localhost:3306
 Source Schema         : tes_boscod

 Target Server Type    : MySQL
 Target Server Version : 100425
 File Encoding         : 65001

 Date: 27/01/2023 11:13:42
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bank
-- ----------------------------
DROP TABLE IF EXISTS `bank`;
CREATE TABLE `bank`  (
  `id_bank` int NOT NULL AUTO_INCREMENT,
  `nama_bank` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_bank`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of bank
-- ----------------------------
INSERT INTO `bank` VALUES (1, 'BCA');
INSERT INTO `bank` VALUES (2, 'BNI');

-- ----------------------------
-- Table structure for ci_sessions
-- ----------------------------
DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE `ci_sessions`  (
  `id` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `timestamp` int UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `ci_sessions_timestamp`(`timestamp`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of ci_sessions
-- ----------------------------

-- ----------------------------
-- Table structure for generate_code
-- ----------------------------
DROP TABLE IF EXISTS `generate_code`;
CREATE TABLE `generate_code`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `tahun` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `bulan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `last_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of generate_code
-- ----------------------------
INSERT INTO `generate_code` VALUES (1, '23', '01', 2);
INSERT INTO `generate_code` VALUES (2, '23', '01', 3);
INSERT INTO `generate_code` VALUES (3, '23', '01', 4);
INSERT INTO `generate_code` VALUES (4, '23', '01', 5);

-- ----------------------------
-- Table structure for rekening_admin
-- ----------------------------
DROP TABLE IF EXISTS `rekening_admin`;
CREATE TABLE `rekening_admin`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_bank` int NULL DEFAULT NULL,
  `no_rekening` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `bank`(`id_bank`) USING BTREE,
  CONSTRAINT `bank` FOREIGN KEY (`id_bank`) REFERENCES `bank` (`id_bank`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of rekening_admin
-- ----------------------------
INSERT INTO `rekening_admin` VALUES (1, 1, '67666666666');
INSERT INTO `rekening_admin` VALUES (2, 2, '12700283733');

-- ----------------------------
-- Table structure for transaksi_transfer
-- ----------------------------
DROP TABLE IF EXISTS `transaksi_transfer`;
CREATE TABLE `transaksi_transfer`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_unik` int NOT NULL,
  `id_transaksi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nilai_transfer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `biaya_admin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `total_transfer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `bank_perantara` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `bank_tujuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `rekening_perantara` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `berlaku_hingga` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of transaksi_transfer
-- ----------------------------
INSERT INTO `transaksi_transfer` VALUES (1, 642, 'TF2301000001', '50000', '0', '50642', 'BNI', NULL, '12700283733', '2023-01-30 04:11:24');
INSERT INTO `transaksi_transfer` VALUES (2, 681, 'TF2301000002', '50000', '0', '50681', 'BNI', NULL, '12700283733', '2023-01-30 04:19:36');
INSERT INTO `transaksi_transfer` VALUES (3, 487, 'TF2301000003', '50000', '0', '50487', 'BNI', NULL, '12700283733', '2023-01-30 04:35:55');
INSERT INTO `transaksi_transfer` VALUES (4, 645, 'TF2301000004', '50000', '0', '50645', 'BNI', NULL, '12700283733', '2023-01-30 05:11:34');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'default.jpg',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `is_admin` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_confirmed` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'irsyad', 'irsyad@coba.com', '$2y$10$EgXHO4EIyAxRcuv7IyxY6uNBJ1WjMRKdRQAEbTVkN6ZbENn0cAGIe', 'default.jpg', '2023-01-25 23:55:49', NULL, 0, 0, 0);
INSERT INTO `users` VALUES (2, 'user@boscod.com', 'user@boscod.com', '$2y$10$yNdaKr37m86Et4nnrK5oB.6cbH8dS6lS7PVVuFzAqRvylFBYv47pu', 'default.jpg', '2023-01-27 05:10:28', NULL, 0, 0, 0);

SET FOREIGN_KEY_CHECKS = 1;
