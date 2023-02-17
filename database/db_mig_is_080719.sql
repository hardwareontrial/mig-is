/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 100134
 Source Host           : localhost:3306
 Source Schema         : db_mig_is

 Target Server Type    : MySQL
 Target Server Version : 100134
 File Encoding         : 65001

 Date: 08/07/2019 10:22:51
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for division_has_positions
-- ----------------------------
DROP TABLE IF EXISTS `division_has_positions`;
CREATE TABLE `division_has_positions`  (
  `division_id` int(10) UNSIGNED NOT NULL,
  `position_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`division_id`, `position_id`) USING BTREE,
  INDEX `division_has_positions_position_id_foreign`(`position_id`) USING BTREE,
  INDEX `division_id`(`division_id`) USING BTREE,
  CONSTRAINT `division_has_positions_division_id_foreign` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `division_has_positions_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for divisions
-- ----------------------------
DROP TABLE IF EXISTS `divisions`;
CREATE TABLE `divisions`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of divisions
-- ----------------------------
INSERT INTO `divisions` VALUES (1, 'Corporate', '', '2019-02-28 09:21:05', '2019-02-28 09:21:15');
INSERT INTO `divisions` VALUES (2, 'Compliance', '', '2019-02-28 09:22:28', '2019-02-28 09:23:11');
INSERT INTO `divisions` VALUES (3, 'Dry Ice Sales', '', '2019-02-28 09:22:30', '2019-02-28 09:22:52');
INSERT INTO `divisions` VALUES (4, 'Plant', '', '2019-02-28 09:22:39', '2019-02-28 09:22:50');
INSERT INTO `divisions` VALUES (5, 'Accounting & Finance', '', '2019-02-28 09:23:15', NULL);
INSERT INTO `divisions` VALUES (6, 'CO2 Sales - East', '', '2019-02-28 09:23:20', NULL);
INSERT INTO `divisions` VALUES (7, 'CO2 Sales - West', '', '2019-02-28 09:24:30', NULL);
INSERT INTO `divisions` VALUES (8, 'HRM & GA', '', '2019-02-28 09:24:37', NULL);
INSERT INTO `divisions` VALUES (9, 'Logistic', '', '2019-02-28 09:24:38', NULL);

-- ----------------------------
-- Table structure for helpdesk
-- ----------------------------
DROP TABLE IF EXISTS `helpdesk`;
CREATE TABLE `helpdesk`  (
  `id` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `title` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `creator_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `date_start` datetime(0) NULL DEFAULT NULL,
  `date_end` datetime(0) NULL DEFAULT NULL,
  `type` enum('Normal','Urgent') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `privilege` enum('Private','Public') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'Private',
  `status` enum('Pending','In Process','New','Complete') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'New',
  `created_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `creator_id`(`creator_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of helpdesk
-- ----------------------------
INSERT INTO `helpdesk` VALUES ('19030001', 'Test Helpdesk', 57, '2019-06-03 04:03:00', '2019-06-03 04:03:00', 'Normal', 'Private', 'New', '2019-03-06 04:58:10', '2019-03-07 07:51:20');
INSERT INTO `helpdesk` VALUES ('19030002', 'Server rusak', 56, '2019-06-03 15:03:00', '2019-06-05 17:25:00', 'Normal', 'Private', 'In Process', '2019-03-06 23:34:01', '2019-03-07 08:33:08');
INSERT INTO `helpdesk` VALUES ('19030003', 'AC tidak dapat menyala', 56, '2019-08-03 10:00:00', '2019-08-03 15:20:00', 'Normal', 'Private', 'Pending', '2019-03-08 04:01:04', '2019-04-21 11:33:55');
INSERT INTO `helpdesk` VALUES ('19030004', 'oke', 56, '2019-09-03 12:10:00', '2019-09-03 23:55:00', 'Normal', 'Public', 'New', '2019-03-09 23:56:29', '2019-03-09 23:56:29');
INSERT INTO `helpdesk` VALUES ('19030005', 'Server hang', 56, '2019-10-03 07:58:00', '2019-12-03 12:00:00', 'Normal', 'Public', 'Complete', '2019-03-10 07:58:52', '2019-04-21 11:34:25');
INSERT INTO `helpdesk` VALUES ('19030006', 'OKE 123', 56, '2019-10-03 08:11:00', '2019-10-03 02:10:00', 'Normal', 'Public', 'New', '2019-03-10 08:12:24', '2019-03-10 08:12:24');
INSERT INTO `helpdesk` VALUES ('19030007', 'Upload new file', 56, '2019-10-03 10:24:00', '2019-10-03 10:24:00', 'Normal', 'Public', 'New', '2019-03-10 10:24:43', '2019-03-10 10:24:43');
INSERT INTO `helpdesk` VALUES ('19030008', 'Upload new file', 56, '2019-10-03 10:24:00', '2019-10-03 10:24:00', 'Normal', 'Public', 'New', '2019-03-10 10:26:07', '2019-03-10 10:26:07');
INSERT INTO `helpdesk` VALUES ('19030009', 'Upload new file', 56, '2019-10-03 10:24:00', '2019-10-03 10:24:00', 'Normal', 'Public', 'New', '2019-03-10 10:30:12', '2019-03-10 10:30:12');
INSERT INTO `helpdesk` VALUES ('19030010', 'Oke upload', 56, '2019-10-03 10:54:00', '2019-10-03 10:54:00', 'Normal', 'Public', 'New', '2019-03-10 10:54:36', '2019-03-10 10:54:36');
INSERT INTO `helpdesk` VALUES ('19030011', '1234 hehe', 56, '2019-10-03 11:14:00', '2019-10-03 11:14:00', 'Normal', 'Public', 'New', '2019-03-10 11:14:19', '2019-03-10 11:14:19');
INSERT INTO `helpdesk` VALUES ('19030012', 'Upload file bermasalah', 56, '2019-10-03 03:30:00', '2019-10-03 15:30:00', 'Normal', 'Public', 'New', '2019-03-10 15:34:20', '2019-03-10 15:34:20');
INSERT INTO `helpdesk` VALUES ('19030013', 'Upload 2x', 56, '2019-10-03 04:53:00', '2019-10-03 16:53:00', 'Normal', 'Public', 'New', '2019-03-10 16:53:57', '2019-03-10 16:53:57');
INSERT INTO `helpdesk` VALUES ('19030014', 'Okeeeee', 56, '2019-10-03 04:55:00', '2019-10-03 16:55:00', 'Normal', 'Public', 'New', '2019-03-10 16:56:02', '2019-03-10 16:56:02');
INSERT INTO `helpdesk` VALUES ('19030015', 'Okeeeee', 56, '2019-10-03 04:55:00', '2019-10-03 16:55:00', 'Normal', 'Public', 'New', '2019-03-10 17:03:10', '2019-03-10 17:03:10');
INSERT INTO `helpdesk` VALUES ('19030016', 'Okeeeee', 56, '2019-10-03 04:55:00', '2019-10-03 16:55:00', 'Normal', 'Public', 'New', '2019-03-10 17:04:15', '2019-03-10 17:04:15');
INSERT INTO `helpdesk` VALUES ('19030017', 'Okeeeee', 56, '2019-10-03 04:55:00', '2019-10-03 16:55:00', 'Normal', 'Public', 'New', '2019-03-10 17:07:10', '2019-03-10 17:07:10');
INSERT INTO `helpdesk` VALUES ('19030018', 'Okeeeee', 56, '2019-10-03 04:55:00', '2019-10-03 16:55:00', 'Normal', 'Public', 'New', '2019-03-10 17:15:25', '2019-03-10 17:15:25');
INSERT INTO `helpdesk` VALUES ('19030019', 'Okeeeee', 56, '2019-10-03 04:55:00', '2019-10-03 16:55:00', 'Normal', 'Public', 'New', '2019-03-10 17:16:54', '2019-03-10 17:16:54');
INSERT INTO `helpdesk` VALUES ('19030020', 'Okeeeee', 56, '2019-10-03 04:55:00', '2019-10-03 16:55:00', 'Normal', 'Public', 'New', '2019-03-10 17:17:47', '2019-03-10 17:17:47');
INSERT INTO `helpdesk` VALUES ('19030021', 'Test 1234567', 56, '2019-10-03 04:55:00', '2019-10-03 16:55:00', 'Normal', 'Public', 'New', '2019-03-10 17:19:27', '2019-03-10 17:19:27');
INSERT INTO `helpdesk` VALUES ('19030022', 'Test 1234567', 56, '2019-10-03 04:55:00', '2019-10-03 16:55:00', 'Normal', 'Public', 'New', '2019-03-10 17:20:11', '2019-03-10 17:20:11');
INSERT INTO `helpdesk` VALUES ('19030023', 'Satu', 56, '2019-10-03 05:21:00', '2019-10-03 17:21:00', 'Normal', 'Public', 'New', '2019-03-10 17:22:12', '2019-03-10 17:22:12');
INSERT INTO `helpdesk` VALUES ('19030024', 'Dua', 56, '2019-10-03 05:25:00', '2019-10-03 17:25:00', 'Normal', 'Public', 'New', '2019-03-10 17:26:13', '2019-03-10 17:26:13');
INSERT INTO `helpdesk` VALUES ('19030025', 'New Master Data', 56, '2019-10-03 05:26:00', '2019-10-03 17:26:00', 'Normal', 'Public', 'New', '2019-03-10 17:27:14', '2019-03-10 17:27:14');
INSERT INTO `helpdesk` VALUES ('19030026', 'Master data 123', 56, '2019-10-03 05:30:00', '2019-10-03 17:30:00', 'Normal', 'Public', 'New', '2019-03-10 17:30:46', '2019-03-10 17:30:46');
INSERT INTO `helpdesk` VALUES ('19030027', '123 kkkkk', 56, '2019-10-03 05:35:00', '2019-10-03 17:35:00', 'Normal', 'Public', 'New', '2019-03-10 17:35:25', '2019-03-10 17:35:25');
INSERT INTO `helpdesk` VALUES ('19030028', 'gggggg', 56, '2019-10-03 05:36:00', '2019-10-03 17:36:00', 'Normal', 'Public', 'New', '2019-03-10 17:36:32', '2019-03-10 17:36:32');
INSERT INTO `helpdesk` VALUES ('19030029', 'ssssss', 56, '2019-10-03 05:37:00', '2019-10-03 17:37:00', 'Normal', 'Public', 'New', '2019-03-10 17:37:55', '2019-03-10 17:37:55');
INSERT INTO `helpdesk` VALUES ('19030030', 'OK COY', 56, '2019-10-03 05:39:00', '2019-10-03 17:39:00', 'Normal', 'Public', 'New', '2019-03-10 17:39:18', '2019-03-10 17:39:18');
INSERT INTO `helpdesk` VALUES ('19030031', 'Sipdeh', 56, '2019-10-03 06:38:00', '2019-10-03 18:38:00', 'Normal', 'Public', 'New', '2019-03-10 18:39:23', '2019-03-10 18:39:23');
INSERT INTO `helpdesk` VALUES ('19030032', 'Sipdeh', 56, '2019-10-03 06:38:00', '2019-10-03 18:38:00', 'Normal', 'Public', 'New', '2019-03-10 18:47:04', '2019-03-10 18:47:04');
INSERT INTO `helpdesk` VALUES ('19030033', 'Test master data', 56, '2019-10-03 06:58:00', '2019-10-03 18:58:00', 'Normal', 'Public', 'New', '2019-03-10 18:58:28', '2019-03-10 18:58:28');
INSERT INTO `helpdesk` VALUES ('19030034', 'xxxx', 56, '2019-10-03 11:26:00', '2019-10-03 23:26:00', 'Normal', 'Public', 'New', '2019-03-10 23:26:46', '2019-03-10 23:26:46');
INSERT INTO `helpdesk` VALUES ('19030035', 'Master Data 13 New Material', 56, '2019-11-03 03:35:00', '2019-11-03 15:35:00', 'Normal', 'Public', 'New', '2019-03-11 15:39:55', '2019-03-11 15:39:55');

-- ----------------------------
-- Table structure for helpdesk_activity
-- ----------------------------
DROP TABLE IF EXISTS `helpdesk_activity`;
CREATE TABLE `helpdesk_activity`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `helpdesk_id` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `user_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `title` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 88 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of helpdesk_activity
-- ----------------------------
INSERT INTO `helpdesk_activity` VALUES (29, '19030003', 56, 'create new helpdesk', '2019-03-08 14:01:04', '2019-03-08 15:14:23');
INSERT INTO `helpdesk_activity` VALUES (30, '19030003', 56, 'comment on this post', '2019-03-08 14:17:15', '2019-03-08 15:14:24');
INSERT INTO `helpdesk_activity` VALUES (31, '19030004', 56, 'create new helpdesk', '2019-03-09 23:56:29', '2019-03-09 23:56:29');
INSERT INTO `helpdesk_activity` VALUES (32, '19030005', 56, 'create new helpdesk', '2019-03-10 07:58:52', '2019-03-10 07:58:52');
INSERT INTO `helpdesk_activity` VALUES (33, '19030005', 56, 'comment on this post', '2019-03-10 07:58:52', '2019-03-10 07:59:15');
INSERT INTO `helpdesk_activity` VALUES (34, '19030006', 56, 'create new helpdesk', '2019-03-10 08:12:24', '2019-03-10 08:12:24');
INSERT INTO `helpdesk_activity` VALUES (35, '19030006', 56, 'comment on this post', '2019-03-10 08:12:24', '2019-03-10 08:12:24');
INSERT INTO `helpdesk_activity` VALUES (36, '19030007', 56, 'create new helpdesk', '2019-03-10 10:24:43', '2019-03-10 10:24:43');
INSERT INTO `helpdesk_activity` VALUES (37, '19030007', 56, 'comment on this post with attachment file', '2019-03-10 10:24:43', '2019-03-10 10:24:43');
INSERT INTO `helpdesk_activity` VALUES (38, '19030008', 56, 'create new helpdesk', '2019-03-10 10:26:07', '2019-03-10 10:26:07');
INSERT INTO `helpdesk_activity` VALUES (39, '19030008', 56, 'comment on this post with attachment file', '2019-03-10 10:26:07', '2019-03-10 10:26:07');
INSERT INTO `helpdesk_activity` VALUES (40, '19030009', 56, 'create new helpdesk', '2019-03-10 10:30:13', '2019-03-10 10:30:13');
INSERT INTO `helpdesk_activity` VALUES (41, '19030009', 56, 'comment on this post with attachment file', '2019-03-10 10:30:13', '2019-03-10 10:30:13');
INSERT INTO `helpdesk_activity` VALUES (42, '19030010', 56, 'create new helpdesk', '2019-03-10 10:54:36', '2019-03-10 10:54:36');
INSERT INTO `helpdesk_activity` VALUES (43, '19030010', 56, 'comment on this post with attachment file', '2019-03-10 10:54:36', '2019-03-10 10:54:36');
INSERT INTO `helpdesk_activity` VALUES (44, '19030011', 56, 'create new helpdesk', '2019-03-10 11:14:19', '2019-03-10 11:14:19');
INSERT INTO `helpdesk_activity` VALUES (45, '19030011', 56, 'upload new attachment', '2019-03-10 11:14:19', '2019-03-10 11:14:19');
INSERT INTO `helpdesk_activity` VALUES (46, '19030012', 56, 'create new helpdesk', '2019-03-10 15:34:20', '2019-03-10 15:34:20');
INSERT INTO `helpdesk_activity` VALUES (47, '19030013', 56, 'create new helpdesk', '2019-03-10 16:53:57', '2019-03-10 16:53:57');
INSERT INTO `helpdesk_activity` VALUES (48, '19030014', 56, 'create new helpdesk', '2019-03-10 16:56:02', '2019-03-10 16:56:02');
INSERT INTO `helpdesk_activity` VALUES (49, '19030014', 56, 'comment on this post', '2019-03-10 16:56:02', '2019-03-10 16:56:02');
INSERT INTO `helpdesk_activity` VALUES (50, '19030015', 56, 'create new helpdesk', '2019-03-10 17:03:10', '2019-03-10 17:03:10');
INSERT INTO `helpdesk_activity` VALUES (51, '19030015', 56, 'comment on this post', '2019-03-10 17:03:10', '2019-03-10 17:03:10');
INSERT INTO `helpdesk_activity` VALUES (52, '19030016', 56, 'create new helpdesk', '2019-03-10 17:04:15', '2019-03-10 17:04:15');
INSERT INTO `helpdesk_activity` VALUES (53, '19030016', 56, 'comment on this post', '2019-03-10 17:04:15', '2019-03-10 17:04:15');
INSERT INTO `helpdesk_activity` VALUES (54, '19030017', 56, 'create new helpdesk', '2019-03-10 17:07:10', '2019-03-10 17:07:10');
INSERT INTO `helpdesk_activity` VALUES (55, '19030017', 56, 'comment on this post', '2019-03-10 17:07:10', '2019-03-10 17:07:10');
INSERT INTO `helpdesk_activity` VALUES (56, '19030018', 56, 'create new helpdesk', '2019-03-10 17:15:25', '2019-03-10 17:15:25');
INSERT INTO `helpdesk_activity` VALUES (57, '19030018', 56, 'comment on this post', '2019-03-10 17:15:25', '2019-03-10 17:15:25');
INSERT INTO `helpdesk_activity` VALUES (58, '19030019', 56, 'create new helpdesk', '2019-03-10 17:16:54', '2019-03-10 17:16:54');
INSERT INTO `helpdesk_activity` VALUES (59, '19030019', 56, 'comment on this post', '2019-03-10 17:16:54', '2019-03-10 17:16:54');
INSERT INTO `helpdesk_activity` VALUES (60, '19030020', 56, 'create new helpdesk', '2019-03-10 17:17:47', '2019-03-10 17:17:47');
INSERT INTO `helpdesk_activity` VALUES (61, '19030020', 56, 'comment on this post', '2019-03-10 17:17:47', '2019-03-10 17:17:47');
INSERT INTO `helpdesk_activity` VALUES (62, '19030021', 56, 'create new helpdesk', '2019-03-10 17:19:27', '2019-03-10 17:19:27');
INSERT INTO `helpdesk_activity` VALUES (63, '19030021', 56, 'comment on this post', '2019-03-10 17:19:27', '2019-03-10 17:19:27');
INSERT INTO `helpdesk_activity` VALUES (64, '19030022', 56, 'create new helpdesk', '2019-03-10 17:20:11', '2019-03-10 17:20:11');
INSERT INTO `helpdesk_activity` VALUES (65, '19030022', 56, 'comment on this post', '2019-03-10 17:20:11', '2019-03-10 17:20:11');
INSERT INTO `helpdesk_activity` VALUES (66, '19030023', 56, 'create new helpdesk', '2019-03-10 17:22:12', '2019-03-10 17:22:12');
INSERT INTO `helpdesk_activity` VALUES (67, '19030023', 56, 'comment on this post', '2019-03-10 17:22:12', '2019-03-10 17:22:12');
INSERT INTO `helpdesk_activity` VALUES (68, '19030024', 56, 'create new helpdesk', '2019-03-10 17:26:14', '2019-03-10 17:26:14');
INSERT INTO `helpdesk_activity` VALUES (69, '19030024', 56, 'comment on this post', '2019-03-10 17:26:14', '2019-03-10 17:26:14');
INSERT INTO `helpdesk_activity` VALUES (70, '19030025', 56, 'create new helpdesk', '2019-03-10 17:27:14', '2019-03-10 17:27:14');
INSERT INTO `helpdesk_activity` VALUES (71, '19030025', 56, 'comment on this post', '2019-03-10 17:27:14', '2019-03-10 17:27:14');
INSERT INTO `helpdesk_activity` VALUES (72, '19030026', 56, 'create new helpdesk', '2019-03-10 17:30:46', '2019-03-10 17:30:46');
INSERT INTO `helpdesk_activity` VALUES (73, '19030026', 56, 'comment on this post', '2019-03-10 17:30:46', '2019-03-10 17:30:46');
INSERT INTO `helpdesk_activity` VALUES (74, '19030027', 56, 'create new helpdesk', '2019-03-10 17:35:25', '2019-03-10 17:35:25');
INSERT INTO `helpdesk_activity` VALUES (75, '19030028', 56, 'create new helpdesk', '2019-03-10 17:36:32', '2019-03-10 17:36:32');
INSERT INTO `helpdesk_activity` VALUES (76, '19030028', 56, 'comment on this post', '2019-03-10 17:36:32', '2019-03-10 17:36:32');
INSERT INTO `helpdesk_activity` VALUES (77, '19030029', 56, 'create new helpdesk', '2019-03-10 17:37:55', '2019-03-10 17:37:55');
INSERT INTO `helpdesk_activity` VALUES (78, '19030029', 56, 'upload new attachment', '2019-03-10 17:37:55', '2019-03-10 17:37:55');
INSERT INTO `helpdesk_activity` VALUES (79, '19030030', 56, 'create new helpdesk', '2019-03-10 17:39:18', '2019-03-10 17:39:18');
INSERT INTO `helpdesk_activity` VALUES (80, '19030030', 56, 'comment on this post with attachment file', '2019-03-10 17:39:18', '2019-03-10 17:39:18');
INSERT INTO `helpdesk_activity` VALUES (81, '19030031', 56, 'create new helpdesk', '2019-03-10 18:39:23', '2019-03-10 18:39:23');
INSERT INTO `helpdesk_activity` VALUES (82, '19030032', 56, 'create new helpdesk', '2019-03-10 18:47:04', '2019-03-10 18:47:04');
INSERT INTO `helpdesk_activity` VALUES (83, '19030033', 56, 'create new helpdesk', '2019-03-10 18:58:28', '2019-03-10 18:58:28');
INSERT INTO `helpdesk_activity` VALUES (84, '19030034', 56, 'create new helpdesk', '2019-03-10 23:26:46', '2019-03-10 23:26:46');
INSERT INTO `helpdesk_activity` VALUES (85, '19030034', 56, 'comment on this post with attachment file', '2019-03-10 23:26:46', '2019-03-10 23:26:46');
INSERT INTO `helpdesk_activity` VALUES (86, '19030035', 56, 'create new helpdesk', '2019-03-11 15:39:55', '2019-03-11 15:39:55');
INSERT INTO `helpdesk_activity` VALUES (87, '19030035', 56, 'comment on this post with attachment file', '2019-03-11 15:39:55', '2019-03-11 15:39:55');

-- ----------------------------
-- Table structure for helpdesk_assign
-- ----------------------------
DROP TABLE IF EXISTS `helpdesk_assign`;
CREATE TABLE `helpdesk_assign`  (
  `helpdesk_id` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `user_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `division_id` int(10) UNSIGNED NULL DEFAULT NULL,
  INDEX `helpdesk_id`(`helpdesk_id`) USING BTREE,
  INDEX `helpdesk_assign_user_division_id_fk`(`division_id`) USING BTREE,
  INDEX `helpdesk_assign_user_user_id_fk`(`user_id`) USING BTREE,
  CONSTRAINT `helpdesk_assign_user_division_id_fk` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `helpdesk_assign_user_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of helpdesk_assign
-- ----------------------------
INSERT INTO `helpdesk_assign` VALUES ('19030001', NULL, 1);
INSERT INTO `helpdesk_assign` VALUES ('19030001', NULL, 2);
INSERT INTO `helpdesk_assign` VALUES ('19030002', NULL, 3);
INSERT INTO `helpdesk_assign` VALUES ('19030002', 57, NULL);
INSERT INTO `helpdesk_assign` VALUES ('19030003', 5, NULL);
INSERT INTO `helpdesk_assign` VALUES ('19030003', 42, NULL);
INSERT INTO `helpdesk_assign` VALUES ('19030004', 54, NULL);
INSERT INTO `helpdesk_assign` VALUES ('19030004', 55, NULL);
INSERT INTO `helpdesk_assign` VALUES ('19030004', 56, NULL);
INSERT INTO `helpdesk_assign` VALUES ('19030005', NULL, 1);
INSERT INTO `helpdesk_assign` VALUES ('19030005', NULL, 2);
INSERT INTO `helpdesk_assign` VALUES ('19030005', NULL, 6);
INSERT INTO `helpdesk_assign` VALUES ('19030005', 46, NULL);
INSERT INTO `helpdesk_assign` VALUES ('19030006', NULL, 3);
INSERT INTO `helpdesk_assign` VALUES ('19030009', 27, NULL);
INSERT INTO `helpdesk_assign` VALUES ('19030009', 40, NULL);
INSERT INTO `helpdesk_assign` VALUES ('19030009', 42, NULL);
INSERT INTO `helpdesk_assign` VALUES ('19030010', NULL, 2);
INSERT INTO `helpdesk_assign` VALUES ('19030011', NULL, 2);
INSERT INTO `helpdesk_assign` VALUES ('19030011', NULL, 4);
INSERT INTO `helpdesk_assign` VALUES ('19030012', 45, NULL);
INSERT INTO `helpdesk_assign` VALUES ('19030012', 46, NULL);
INSERT INTO `helpdesk_assign` VALUES ('19030013', NULL, 3);
INSERT INTO `helpdesk_assign` VALUES ('19030022', NULL, 3);
INSERT INTO `helpdesk_assign` VALUES ('19030023', 17, NULL);
INSERT INTO `helpdesk_assign` VALUES ('19030024', 22, NULL);
INSERT INTO `helpdesk_assign` VALUES ('19030025', NULL, 4);
INSERT INTO `helpdesk_assign` VALUES ('19030026', 56, NULL);
INSERT INTO `helpdesk_assign` VALUES ('19030027', NULL, 1);
INSERT INTO `helpdesk_assign` VALUES ('19030028', 17, NULL);
INSERT INTO `helpdesk_assign` VALUES ('19030029', 10, NULL);
INSERT INTO `helpdesk_assign` VALUES ('19030030', 9, NULL);
INSERT INTO `helpdesk_assign` VALUES ('19030031', NULL, 2);
INSERT INTO `helpdesk_assign` VALUES ('19030032', NULL, 2);
INSERT INTO `helpdesk_assign` VALUES ('19030033', NULL, 5);
INSERT INTO `helpdesk_assign` VALUES ('19030034', 5, NULL);
INSERT INTO `helpdesk_assign` VALUES ('19030034', 8, NULL);
INSERT INTO `helpdesk_assign` VALUES ('19030035', NULL, 3);

-- ----------------------------
-- Table structure for helpdesk_attachment
-- ----------------------------
DROP TABLE IF EXISTS `helpdesk_attachment`;
CREATE TABLE `helpdesk_attachment`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `activity_id` int(10) NULL DEFAULT NULL,
  `user_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `filename` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `filepath` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `helpdesk_attachment_helpdesk_id_fk`(`activity_id`) USING BTREE,
  INDEX `helpdesk_attachment_user_id_fk`(`user_id`) USING BTREE,
  CONSTRAINT `helpdesk_attachment_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of helpdesk_attachment
-- ----------------------------
INSERT INTO `helpdesk_attachment` VALUES (2, 30, 56, 'inigambar.jpg', 'images/inigambar.jpg', NULL, NULL);
INSERT INTO `helpdesk_attachment` VALUES (3, 65, NULL, 'WhatsApp Image 2019-02-27 at 13.11.22.jpeg', 'public/helpdesk/19030022//1552213211_WhatsApp Image 2019-02-27 at 13.11.22.jpeg.', '2019-03-10 17:20:11', '2019-03-10 17:20:11');
INSERT INTO `helpdesk_attachment` VALUES (4, 67, NULL, 'WhatsApp Image 2019-02-27 at 11.37.27.jpeg', 'public/helpdesk/19030023//1552213332_WhatsApp Image 2019-02-27 at 11.37.27.jpeg', '2019-03-10 17:22:12', '2019-03-10 17:22:12');
INSERT INTO `helpdesk_attachment` VALUES (5, 69, NULL, 'MATERIAL MASTER 21-02-2019.xml', 'public/helpdesk/19030024//1552213574_MATERIAL MASTER 21-02-2019.xml', '2019-03-10 17:26:14', '2019-03-10 17:26:14');
INSERT INTO `helpdesk_attachment` VALUES (6, 71, NULL, 'MATERIAL MASTER 21-02-2019.xml', 'public/helpdesk/19030025//1552213635_MATERIAL MASTER 21-02-2019.xml', '2019-03-10 17:27:15', '2019-03-10 17:27:15');
INSERT INTO `helpdesk_attachment` VALUES (7, 73, NULL, 'Material-Template 18022019 warehouse.xls', 'public/helpdesk/19030026//1552213846_Material-Template 18022019 warehouse.xls', '2019-03-10 17:30:46', '2019-03-10 17:30:46');
INSERT INTO `helpdesk_attachment` VALUES (8, 76, NULL, 'Minimal stok Kend 2018 (1).xlsx', 'public/helpdesk/19030028//1552214193_Minimal stok Kend 2018 (1).xlsx', '2019-03-10 17:36:33', '2019-03-10 17:36:33');
INSERT INTO `helpdesk_attachment` VALUES (9, 78, NULL, 'WhatsApp Image 2019-02-27 at 11.37.27.jpeg', 'public/helpdesk/19030029//1552214275_WhatsApp Image 2019-02-27 at 11.37.27.jpeg', '2019-03-10 17:37:55', '2019-03-10 17:37:55');
INSERT INTO `helpdesk_attachment` VALUES (10, 80, NULL, 'WhatsApp Image 2019-02-27 at 11.37.45.jpeg', 'public/helpdesk/19030030//1552214358_WhatsApp Image 2019-02-27 at 11.37.45.jpeg', '2019-03-10 17:39:18', '2019-03-10 17:39:18');
INSERT INTO `helpdesk_attachment` VALUES (11, 85, NULL, 'WhatsApp Image 2019-02-27 at 11.37.45.jpeg', 'public/helpdesk/19030034//1552235206_WhatsApp Image 2019-02-27 at 11.37.45.jpeg', '2019-03-10 23:26:46', '2019-03-10 23:26:46');
INSERT INTO `helpdesk_attachment` VALUES (12, 87, NULL, 'Minimal stok Kend 2018.xlsx', 'public/helpdesk/19030035//1552293595_Minimal stok Kend 2018.xlsx', '2019-03-11 15:39:55', '2019-03-11 15:39:55');

-- ----------------------------
-- Table structure for helpdesk_comment
-- ----------------------------
DROP TABLE IF EXISTS `helpdesk_comment`;
CREATE TABLE `helpdesk_comment`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `activity_id` int(10) NULL DEFAULT NULL,
  `user_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `content` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `helpdesk_comment_user_id_fk`(`user_id`) USING BTREE,
  CONSTRAINT `helpdesk_comment_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of helpdesk_comment
-- ----------------------------
INSERT INTO `helpdesk_comment` VALUES (1, 30, 56, 'test<br> <b>123</b>', '2019-03-08 14:17:00', '2019-03-10 09:03:26');
INSERT INTO `helpdesk_comment` VALUES (8, 33, 56, '<p>Oke cepat</p>', '2019-03-10 07:58:52', '2019-03-10 09:03:55');
INSERT INTO `helpdesk_comment` VALUES (9, 35, 56, '<p><b>sip kan?</b></p>', '2019-03-10 08:12:24', '2019-03-10 09:03:57');
INSERT INTO `helpdesk_comment` VALUES (10, 41, NULL, '<p>ini file nya</p>', '2019-03-10 10:30:13', '2019-03-10 10:30:13');
INSERT INTO `helpdesk_comment` VALUES (11, 43, NULL, '<p>okee</p>', '2019-03-10 10:54:36', '2019-03-10 10:54:36');
INSERT INTO `helpdesk_comment` VALUES (12, 65, NULL, '<p>aaaaa</p>', '2019-03-10 17:20:11', '2019-03-10 17:20:11');
INSERT INTO `helpdesk_comment` VALUES (13, 67, NULL, '<p>aaaaaa</p>', '2019-03-10 17:22:12', '2019-03-10 17:22:12');
INSERT INTO `helpdesk_comment` VALUES (14, 69, NULL, '<p>ini file nya</p>', '2019-03-10 17:26:14', '2019-03-10 17:26:14');
INSERT INTO `helpdesk_comment` VALUES (15, 71, NULL, '<p>ssss</p>', '2019-03-10 17:27:15', '2019-03-10 17:27:15');
INSERT INTO `helpdesk_comment` VALUES (16, 73, NULL, '<p>okkk</p>', '2019-03-10 17:30:46', '2019-03-10 17:30:46');
INSERT INTO `helpdesk_comment` VALUES (17, 80, NULL, '<p>sssss</p>', '2019-03-10 17:39:18', '2019-03-10 17:39:18');
INSERT INTO `helpdesk_comment` VALUES (18, 85, NULL, '<p>ccccc</p>', '2019-03-10 23:26:46', '2019-03-10 23:26:46');
INSERT INTO `helpdesk_comment` VALUES (19, 87, NULL, '<p>Ini filenya</p>', '2019-03-11 15:39:55', '2019-03-11 15:39:55');

-- ----------------------------
-- Table structure for helpdesk_sap_auth
-- ----------------------------
DROP TABLE IF EXISTS `helpdesk_sap_auth`;
CREATE TABLE `helpdesk_sap_auth`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `helpdesk_id` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `code` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for helpdesk_sap_form
-- ----------------------------
DROP TABLE IF EXISTS `helpdesk_sap_form`;
CREATE TABLE `helpdesk_sap_form`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `request_type` enum('New Master Data','Change Master Data','Delete Master Data','Authorization','New User','Delete User') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `helpdesk_id` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `user_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `username` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 34 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of helpdesk_sap_form
-- ----------------------------
INSERT INTO `helpdesk_sap_form` VALUES (29, 'New Master Data', '19030031', 56, 'spvfinance', '2019-03-10 18:39:23', '2019-03-10 18:47:37');
INSERT INTO `helpdesk_sap_form` VALUES (30, 'Authorization', '19030032', 56, 'spvfinance', '2019-03-10 18:47:04', '2019-03-10 18:51:49');
INSERT INTO `helpdesk_sap_form` VALUES (31, NULL, '19030033', 56, 'spvpm', '2019-03-10 18:58:28', '2019-03-10 18:58:28');
INSERT INTO `helpdesk_sap_form` VALUES (32, 'New Master Data', '19030034', 56, 'spvddd', '2019-03-10 23:26:46', '2019-03-10 23:26:46');
INSERT INTO `helpdesk_sap_form` VALUES (33, 'New Master Data', '19030035', 56, 'SPVGA', '2019-03-11 15:39:55', '2019-03-11 15:39:55');

-- ----------------------------
-- Table structure for helpdesk_sap_master_data
-- ----------------------------
DROP TABLE IF EXISTS `helpdesk_sap_master_data`;
CREATE TABLE `helpdesk_sap_master_data`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `form_id` int(10) NULL DEFAULT NULL,
  `type` enum('BP Customer','BP Vendor','MM Material') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `code` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 35 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of helpdesk_sap_master_data
-- ----------------------------
INSERT INTO `helpdesk_sap_master_data` VALUES (29, 30, NULL, '123', 'sip', '2019-03-10 18:47:04', '2019-03-10 18:47:04');
INSERT INTO `helpdesk_sap_master_data` VALUES (30, 31, NULL, '123', 'aaa', '2019-03-10 18:58:28', '2019-03-10 18:58:28');
INSERT INTO `helpdesk_sap_master_data` VALUES (31, 32, 'BP Customer', '123', '222', '2019-03-10 23:26:46', '2019-03-10 23:26:46');
INSERT INTO `helpdesk_sap_master_data` VALUES (32, 33, 'MM Material', 'FILT0001', 'FILTER SOLAR', '2019-03-11 15:39:56', '2019-03-12 08:48:19');
INSERT INTO `helpdesk_sap_master_data` VALUES (33, 33, 'MM Material', 'FILT0002', 'FILTER OLI', '2019-03-11 15:39:56', '2019-03-12 08:48:22');
INSERT INTO `helpdesk_sap_master_data` VALUES (34, 33, 'MM Material', 'FILT0003', 'FILTER ABC', '2019-03-11 15:39:56', '2019-03-11 15:39:56');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_02_16_101308_create_permission_tables', 2);
INSERT INTO `migrations` VALUES (4, '2016_06_01_000001_create_oauth_auth_codes_table', 3);
INSERT INTO `migrations` VALUES (5, '2016_06_01_000002_create_oauth_access_tokens_table', 3);
INSERT INTO `migrations` VALUES (6, '2016_06_01_000003_create_oauth_refresh_tokens_table', 3);
INSERT INTO `migrations` VALUES (7, '2016_06_01_000004_create_oauth_clients_table', 3);
INSERT INTO `migrations` VALUES (8, '2016_06_01_000005_create_oauth_personal_access_clients_table', 3);

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions`  (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_permissions_model_id_model_type_index`(`model_id`, `model_type`) USING BTREE,
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles`  (
  `role_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_roles_model_id_model_type_index`(`model_id`, `model_type`) USING BTREE,
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------
INSERT INTO `model_has_roles` VALUES (1, 'App\\User', 1);
INSERT INTO `model_has_roles` VALUES (1, 'App\\User', 2);
INSERT INTO `model_has_roles` VALUES (1, 'App\\User', 6);
INSERT INTO `model_has_roles` VALUES (3, 'App\\User', 102);
INSERT INTO `model_has_roles` VALUES (4, 'App\\User', 37);
INSERT INTO `model_has_roles` VALUES (4, 'App\\User', 101);
INSERT INTO `model_has_roles` VALUES (5, 'App\\User', 9);
INSERT INTO `model_has_roles` VALUES (7, 'App\\User', 11);
INSERT INTO `model_has_roles` VALUES (7, 'App\\User', 50);
INSERT INTO `model_has_roles` VALUES (7, 'App\\User', 55);
INSERT INTO `model_has_roles` VALUES (7, 'App\\User', 56);

-- ----------------------------
-- Table structure for oauth_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `oauth_access_tokens`;
CREATE TABLE `oauth_access_tokens`  (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NULL DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `scopes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `expires_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `oauth_access_tokens_user_id_index`(`user_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of oauth_access_tokens
-- ----------------------------
INSERT INTO `oauth_access_tokens` VALUES ('20569febc15710c701554cdf5d95631d16dfd3fb3446be06f136bdd6fe830fbf6de8b99e47bbb5ea', 56, 1, 'Personal Access Token', '[]', 0, '2019-05-17 08:34:19', '2019-05-17 08:34:19', '2020-05-17 08:34:19');
INSERT INTO `oauth_access_tokens` VALUES ('c0e11056826477756c8bc483d536051d544771baf6a9916404988475c7a3472da4819a01e3c541af', 56, 1, 'Personal Access Token', '[]', 0, '2019-05-17 09:16:13', '2019-05-17 09:16:13', '2020-05-17 09:16:13');
INSERT INTO `oauth_access_tokens` VALUES ('c1a09c2c8a85c074bf52a4e7747e81280cc608dd3e09149ed37f69570cfaeb80b8569b53f10e5958', 56, 1, 'Personal Access Token', '[]', 0, '2019-05-16 14:45:31', '2019-05-16 14:45:31', '2020-05-16 14:45:31');
INSERT INTO `oauth_access_tokens` VALUES ('ef0b9e19bc908bfaf6d9005d752eedc9022d2580610c562c65b7a98774cea20b0fd45ff5916adda8', 1, 1, 'Personal Access Token', '[]', 1, '2019-05-16 14:42:02', '2019-05-16 14:42:02', '2020-05-16 14:42:02');

-- ----------------------------
-- Table structure for oauth_auth_codes
-- ----------------------------
DROP TABLE IF EXISTS `oauth_auth_codes`;
CREATE TABLE `oauth_auth_codes`  (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `scopes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for oauth_clients
-- ----------------------------
DROP TABLE IF EXISTS `oauth_clients`;
CREATE TABLE `oauth_clients`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `oauth_clients_user_id_index`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of oauth_clients
-- ----------------------------
INSERT INTO `oauth_clients` VALUES (1, NULL, 'Laravel Personal Access Client', 'DpOJsROUrwAVXPRTDQmTVKUfmdeNFCgud7Y61fbJ', 'http://localhost', 1, 0, 0, '2019-05-16 12:36:26', '2019-05-16 12:36:26');
INSERT INTO `oauth_clients` VALUES (2, NULL, 'Laravel Password Grant Client', 'L1MPyRMksUJqDZKMCNsq4Ff34lg4YwLIjtee5Hpv', 'http://localhost', 0, 1, 0, '2019-05-16 12:36:26', '2019-05-16 12:36:26');

-- ----------------------------
-- Table structure for oauth_personal_access_clients
-- ----------------------------
DROP TABLE IF EXISTS `oauth_personal_access_clients`;
CREATE TABLE `oauth_personal_access_clients`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `oauth_personal_access_clients_client_id_index`(`client_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of oauth_personal_access_clients
-- ----------------------------
INSERT INTO `oauth_personal_access_clients` VALUES (1, 1, '2019-05-16 12:36:26', '2019-05-16 12:36:26');

-- ----------------------------
-- Table structure for oauth_refresh_tokens
-- ----------------------------
DROP TABLE IF EXISTS `oauth_refresh_tokens`;
CREATE TABLE `oauth_refresh_tokens`  (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `oauth_refresh_tokens_access_token_id_index`(`access_token_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for okm_exam_participant
-- ----------------------------
DROP TABLE IF EXISTS `okm_exam_participant`;
CREATE TABLE `okm_exam_participant`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `schedule_id` int(10) NULL DEFAULT NULL,
  `nik` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `updated_by` int(10) NULL DEFAULT NULL,
  `is_active` int(1) NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of okm_exam_participant
-- ----------------------------
INSERT INTO `okm_exam_participant` VALUES (1, 1, '244', '2019-07-04 08:14:33', 1, '2019-07-04 08:14:33', NULL, 1);
INSERT INTO `okm_exam_participant` VALUES (2, 2, '244', '2019-07-04 09:02:44', 1, '2019-07-04 09:02:44', NULL, 1);
INSERT INTO `okm_exam_participant` VALUES (3, 3, '244', '2019-07-07 20:04:55', 1, '2019-07-08 08:20:05', NULL, 1);

-- ----------------------------
-- Table structure for okm_exam_schedule
-- ----------------------------
DROP TABLE IF EXISTS `okm_exam_schedule`;
CREATE TABLE `okm_exam_schedule`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `collection_id` int(10) NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `duration` int(10) NULL DEFAULT NULL,
  `date_start` datetime(0) NULL DEFAULT NULL,
  `date_end` datetime(0) NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `updated_by` int(10) NULL DEFAULT NULL,
  `is_active` int(1) NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of okm_exam_schedule
-- ----------------------------
INSERT INTO `okm_exam_schedule` VALUES (1, 7, NULL, 60, '2019-07-04 08:00:00', '2019-07-04 09:00:00', '2019-07-04 08:14:33', 1, '2019-07-04 08:14:33', NULL, 1);
INSERT INTO `okm_exam_schedule` VALUES (2, 7, NULL, 70000, '2019-07-04 09:02:00', '2019-08-21 23:42:00', '2019-07-04 09:02:44', 1, '2019-07-04 09:02:44', NULL, 1);
INSERT INTO `okm_exam_schedule` VALUES (3, 7, NULL, NULL, '2019-07-07 20:00:00', '2019-07-08 23:15:00', '2019-07-07 20:04:55', 1, '2019-07-08 08:13:45', NULL, 1);

-- ----------------------------
-- Table structure for okm_material
-- ----------------------------
DROP TABLE IF EXISTS `okm_material`;
CREATE TABLE `okm_material`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `division_id` int(10) NULL DEFAULT NULL,
  `level` enum('Beginner','Intermediate','Advanced') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `sinopsis` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `hours` int(10) NULL DEFAULT NULL,
  `view_count` int(10) NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `created_by` int(10) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `updated_by` int(10) NULL DEFAULT NULL,
  `is_active` int(1) NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of okm_material
-- ----------------------------
INSERT INTO `okm_material` VALUES (1, 'Sistem Manajemen Perusahaan', 2, 'Beginner', '<p>Merupakan suatu standard manajerial yang diterapkan pada&nbsp;</p>', 10, 18, '2018-09-05 11:27:42', 1, '2019-05-20 14:19:32', 1, 1);
INSERT INTO `okm_material` VALUES (2, 'Test Materi 21', 3, 'Intermediate', '<p><b>Ini adalah</b></p><p><b></b><b></b>adalah asdasasdasd</p><p>asdddjkasdllasd ajk</p><p></p>', 9, 2, '2018-09-26 12:10:02', 1, '2019-05-21 11:42:19', 1, 0);
INSERT INTO `okm_material` VALUES (3, 'Dasar K3 Bagian 57', 4, 'Advanced', '<p>Ini adalah hehehehe</p>', 7, 10, '2018-09-27 03:49:53', 1, '2019-05-20 13:55:44', 1, 1);
INSERT INTO `okm_material` VALUES (4, 'Pemahaman Server IT', 8, 'Intermediate', '<p>hehehehe hohoo</p>', 10, 3, '2018-09-28 09:23:26', 1, '2019-05-22 14:58:09', 1, 1);
INSERT INTO `okm_material` VALUES (5, 'Membuat brosur SMOKE', 3, 'Intermediate', '<p><strong>Test<em>123</em></strong></p>', 17, NULL, '2019-05-20 14:41:48', 1, '2019-05-22 12:22:19', 1, 0);
INSERT INTO `okm_material` VALUES (6, 'Server Gudang MIG', 9, 'Intermediate', '<p>aaaaa</p>', 5, NULL, '2019-05-20 14:44:54', 1, '2019-05-21 10:52:36', 1, 1);
INSERT INTO `okm_material` VALUES (7, 'Ilmu bela diri IT', 8, 'Intermediate', '<p>Test satu</p>\r\n<ul>\r\n<li style=\"text-align: center;\">ini adalah</li>\r\n<li style=\"text-align: center;\">satu</li>\r\n<li style=\"text-align: center;\">dua tiga</li>\r\n</ul>', 3, NULL, '2019-06-16 10:01:12', 1, '2019-06-16 10:01:12', NULL, 1);
INSERT INTO `okm_material` VALUES (8, 'Strategi marketing', 6, 'Beginner', '<p>1233333</p>', 1, NULL, '2019-06-16 10:43:03', 1, '2019-06-16 10:43:03', NULL, 1);
INSERT INTO `okm_material` VALUES (9, 'Ubah Materi Test', 5, 'Intermediate', '<p>Edit test</p>', 9, NULL, '2019-06-16 10:55:30', 1, '2019-06-16 11:34:55', 1, 0);
INSERT INTO `okm_material` VALUES (10, 'Ujian Bela diri 2019', 3, 'Intermediate', '<p>mig suksessss</p>', 7, NULL, '2019-06-27 22:33:21', 101, '2019-06-27 22:33:21', NULL, 1);
INSERT INTO `okm_material` VALUES (11, 'Hafiz Quran', 9, 'Advanced', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam felis urna, volutpat ut volutpat non, pretium sit amet urna. Mauris efficitur sagittis accumsan. Phasellus urna elit, efficitur nec augue et, consectetur consectetur dui. Interdum et malesuada fames ac ante ipsum primis in faucibus. In sit amet ultrices augue. Aenean tortor enim, pretium at purus non, scelerisque condimentum diam. Fusce ultrices tincidunt est in commodo. Nulla risus magna, venenatis a nisl id, tempus elementum quam. Nam eu rutrum orci. Maecenas pretium neque nulla, a auctor orci luctus et. Pellentesque tincidunt, ligula in dapibus varius, risus nisl blandit libero, id suscipit tortor leo in est. Aliquam ultricies odio in mi commodo, at facilisis nulla malesuada. Donec vehicula accumsan ligula, ut fringilla purus rutrum quis.</p>\r\n<p>Ut et aliquet mauris. Curabitur aliquet in metus quis feugiat. Proin hendrerit nisi vitae lorem tristique, non vehicula ex sodales. Interdum et malesuada fames ac ante ipsum primis in faucibus. Duis lacinia leo porttitor mauris vestibulum ullamcorper. Curabitur imperdiet augue a urna iaculis posuere. Proin lobortis tellus sit amet erat mollis aliquet. Suspendisse vulputate pharetra aliquet. Vestibulum hendrerit eros quis metus ultrices, eget facilisis metus placerat.</p>', 5, NULL, '2019-07-02 14:44:42', 1, '2019-07-02 14:44:42', NULL, 1);

-- ----------------------------
-- Table structure for okm_material_content
-- ----------------------------
DROP TABLE IF EXISTS `okm_material_content`;
CREATE TABLE `okm_material_content`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `material_id` int(10) NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `filepath` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `download_count` int(10) NULL DEFAULT 0,
  `created_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `updated_by` int(10) NULL DEFAULT NULL,
  `is_active` int(1) NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of okm_material_content
-- ----------------------------
INSERT INTO `okm_material_content` VALUES (1, 2, 'Pembelajaran tahap 1', 'public/elearning/material/1537944088_5.doc', 3, '2018-09-26 13:41:28', NULL, '2019-05-21 12:07:49', NULL, 1);
INSERT INTO `okm_material_content` VALUES (2, 2, 'Pembelajaran tahap 2', 'public/elearning/material/1537944397_5.xlsx', 2, '2018-09-26 13:46:37', NULL, '2019-05-21 12:07:55', NULL, 1);
INSERT INTO `okm_material_content` VALUES (3, 1, 'Bagian 2', 'public/elearning/material/1538015099_1.xlsx', 1, '2018-09-27 07:43:47', NULL, '2019-06-16 11:34:42', 1, 0);
INSERT INTO `okm_material_content` VALUES (4, 1, 'Bagian 1', 'public/elearning/material/1538015215_1.pdf', 4, '2018-09-27 09:26:55', NULL, '2019-05-21 12:08:05', NULL, 1);
INSERT INTO `okm_material_content` VALUES (5, 1, 'Bagian 6', 'public/elearning/material/1538058257_1.xlsx', 10, '2018-09-27 21:24:17', NULL, '2019-05-21 12:08:12', NULL, 1);
INSERT INTO `okm_material_content` VALUES (6, 4, 'test', 'public/elearning/material/1538101441_1.xlsx', 2, '2018-09-28 09:24:01', NULL, '2019-05-21 12:08:16', NULL, 1);
INSERT INTO `okm_material_content` VALUES (7, 2, 'test', 'public/elearning/material/1545801154_1.exe', 5, '2018-12-26 12:12:34', NULL, '2019-05-21 12:08:21', NULL, 1);
INSERT INTO `okm_material_content` VALUES (8, 1, 'Bagian 3', NULL, 0, '2019-05-20 15:30:07', 1, '2019-05-20 15:30:57', NULL, 1);
INSERT INTO `okm_material_content` VALUES (9, 3, 'Test K3 1', NULL, 0, '2019-05-20 16:03:46', 1, '2019-05-20 16:03:46', NULL, 1);
INSERT INTO `okm_material_content` VALUES (10, 2, 'Bagian 2', NULL, 0, '2019-05-21 07:44:39', 1, '2019-05-21 07:44:39', NULL, 1);
INSERT INTO `okm_material_content` VALUES (11, 2, 'Bagian 3', 'public/elearning/material/2/1558399773_Print0312.pdf', 0, '2019-05-21 07:49:33', 1, '2019-05-21 12:09:20', NULL, 1);
INSERT INTO `okm_material_content` VALUES (12, 2, 'Dry Ice 1', 'public/elearning/material/2/1558401026_Flow Dry Ice sales documentation.xlsx', 0, '2019-05-21 08:10:26', 1, '2019-05-21 12:09:18', NULL, 1);
INSERT INTO `okm_material_content` VALUES (13, 5, 'Bagian 1', 'public/elearning/material/5/1558414662_test.pdf', 0, '2019-05-21 11:57:42', 1, '2019-05-21 12:09:14', NULL, 1);
INSERT INTO `okm_material_content` VALUES (14, 5, 'Bagian 2 Part 1', 'public/elearning/material/5/1558420500_test.pdf', 0, '2019-05-21 11:57:52', 1, '2019-05-21 13:35:00', 1, 1);
INSERT INTO `okm_material_content` VALUES (15, 5, 'Bagian 4', 'public/elearning/material/5/1558420567_1.png', 0, '2019-05-21 13:07:45', 1, '2019-05-21 13:36:07', 1, 1);
INSERT INTO `okm_material_content` VALUES (16, 6, 'Gudang 1', 'public/elearning/material/6/1558421498_Login.jpg', 0, '2019-05-21 13:51:38', 1, '2019-05-21 14:03:55', 1, 0);
INSERT INTO `okm_material_content` VALUES (17, 6, 'Gudang 2', 'public/elearning/material/6/1558421517_test.pdf', 0, '2019-05-21 13:51:57', 1, '2019-05-21 14:03:44', 1, 1);
INSERT INTO `okm_material_content` VALUES (18, 8, 'Test 2222', 'public/elearning/material/8/1560659968_DB-CompanyProfile.txt', 0, '2019-06-16 11:39:28', 1, '2019-06-16 11:39:28', NULL, 1);
INSERT INTO `okm_material_content` VALUES (19, 10, 'test', 'public/elearning/material/10/1561649637_1538015099_1 (7).xlsx', 0, '2019-06-27 22:33:57', 101, '2019-06-27 22:33:57', NULL, 1);

-- ----------------------------
-- Table structure for okm_question
-- ----------------------------
DROP TABLE IF EXISTS `okm_question`;
CREATE TABLE `okm_question`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `collection_id` int(10) NULL DEFAULT NULL,
  `question` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `updated_by` int(10) NULL DEFAULT NULL,
  `is_active` int(1) NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of okm_question
-- ----------------------------
INSERT INTO `okm_question` VALUES (1, 1, 'Siapa nama ayah mu?', '2018-10-31 07:25:11', NULL, '2018-10-31 07:25:11', NULL, 1);
INSERT INTO `okm_question` VALUES (2, 1, 'Hai apa kabar?', '2019-05-22 08:06:31', NULL, '2019-06-27 14:36:59', 1, 0);
INSERT INTO `okm_question` VALUES (3, 4, 'Siapa presiden indonesia saat ini?', '2019-05-23 15:56:58', 1, '2019-06-14 21:51:05', 1, 0);
INSERT INTO `okm_question` VALUES (4, 4, 'Siapa presiden indonesia saat ini?', '2019-05-23 16:10:48', 1, '2019-06-14 21:50:58', 1, 0);
INSERT INTO `okm_question` VALUES (5, 4, 'KP 223?', '2019-05-23 16:11:06', 1, '2019-06-14 21:50:13', 1, 0);
INSERT INTO `okm_question` VALUES (6, 4, 'KPS?', '2019-05-23 16:11:17', 1, '2019-06-14 21:50:52', 1, 0);
INSERT INTO `okm_question` VALUES (7, 4, 'KPS berapa sob?', '2019-05-23 16:11:48', 1, '2019-06-14 21:33:25', 1, 1);
INSERT INTO `okm_question` VALUES (8, 4, 'KPU', '2019-05-23 16:12:30', 1, '2019-05-23 16:12:30', NULL, 1);
INSERT INTO `okm_question` VALUES (9, 3, 'Test 123 adalah ? satu ok', '2019-05-24 08:01:48', 1, '2019-06-16 12:46:13', 1, 1);
INSERT INTO `okm_question` VALUES (10, 3, 'Ya ya ya', '2019-05-24 08:03:37', 1, '2019-06-16 12:45:59', 1, 1);
INSERT INTO `okm_question` VALUES (11, 3, 'Abbcc', '2019-05-24 08:43:04', 1, '2019-06-16 12:30:31', 1, 1);
INSERT INTO `okm_question` VALUES (12, 4, 'Siapa presiden indonesia saat ini?', '2019-06-13 16:06:56', 1, '2019-06-13 16:06:56', NULL, 1);
INSERT INTO `okm_question` VALUES (13, 4, 'Sebutkan nama nama hewan yang berada di area bumi mondoroko raya gang 11 RT 12 Wssdddd yyyyyyyy ?', '2019-06-14 21:34:28', 1, '2019-06-14 21:37:32', 1, 1);
INSERT INTO `okm_question` VALUES (14, 3, 'KPS berapa sob?', '2019-06-16 12:46:46', 1, '2019-06-16 12:46:46', NULL, 1);
INSERT INTO `okm_question` VALUES (15, 6, '1 + 1 = ?', '2019-06-20 15:49:47', 1, '2019-06-22 09:33:14', 1, 1);
INSERT INTO `okm_question` VALUES (16, 6, '2 * 4 = ?', '2019-06-20 15:50:10', 1, '2019-06-23 10:52:32', 1, 1);
INSERT INTO `okm_question` VALUES (17, 6, '6 * 6 = ?', '2019-06-22 08:11:25', 1, '2019-06-22 09:35:59', 1, 0);
INSERT INTO `okm_question` VALUES (18, 6, '7 * 2 = ?', '2019-06-23 10:53:41', 1, '2019-06-23 10:55:39', 1, 1);
INSERT INTO `okm_question` VALUES (19, 1, '1 + 10 = ?', '2019-06-27 14:37:22', 1, '2019-06-27 14:37:22', NULL, 1);
INSERT INTO `okm_question` VALUES (20, 7, '10 + 10 = ?', '2019-07-02 14:45:54', 1, '2019-07-02 14:45:54', NULL, 1);
INSERT INTO `okm_question` VALUES (21, 7, '22 + 22 = ?', '2019-07-02 14:46:30', 1, '2019-07-02 14:46:30', NULL, 1);
INSERT INTO `okm_question` VALUES (22, 7, '50 x 2 = ?', '2019-07-02 14:46:58', 1, '2019-07-02 14:46:58', NULL, 1);
INSERT INTO `okm_question` VALUES (23, 7, '19 x 1 = ?', '2019-07-02 14:47:21', 1, '2019-07-02 14:47:21', NULL, 1);
INSERT INTO `okm_question` VALUES (24, 7, '17 + 3 = ?', '2019-07-02 14:47:53', 1, '2019-07-02 14:47:53', NULL, 1);
INSERT INTO `okm_question` VALUES (25, 8, '10 + 100 = ?', '2019-07-02 14:51:08', 1, '2019-07-02 14:51:08', NULL, 1);

-- ----------------------------
-- Table structure for okm_question_answer
-- ----------------------------
DROP TABLE IF EXISTS `okm_question_answer`;
CREATE TABLE `okm_question_answer`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `question_content_id` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `answer` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `answer_key` enum('1','0') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `updated_by` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 81 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of okm_question_answer
-- ----------------------------
INSERT INTO `okm_question_answer` VALUES (1, '1', 'Budi', '0', '2018-10-31 07:25:12', NULL, '2018-10-31 07:25:12', NULL);
INSERT INTO `okm_question_answer` VALUES (2, '1', 'Joni', '1', '2018-10-31 07:25:12', NULL, '2018-10-31 07:25:12', NULL);
INSERT INTO `okm_question_answer` VALUES (3, '1', 'Toni', '0', '2018-10-31 07:25:12', NULL, '2018-10-31 07:25:12', NULL);
INSERT INTO `okm_question_answer` VALUES (4, '1', 'Doni', '0', '2018-10-31 07:25:12', NULL, '2018-10-31 07:25:12', NULL);
INSERT INTO `okm_question_answer` VALUES (5, '7', 'Budi', '1', '2019-05-23 16:11:48', NULL, '2019-06-14 21:33:25', NULL);
INSERT INTO `okm_question_answer` VALUES (6, '7', 'Andri', '0', '2019-05-23 16:11:48', NULL, '2019-06-14 21:33:13', NULL);
INSERT INTO `okm_question_answer` VALUES (7, '7', 'Antok', '0', '2019-05-23 16:11:48', NULL, '2019-06-14 21:33:05', NULL);
INSERT INTO `okm_question_answer` VALUES (8, '7', 'Deni', '0', '2019-05-23 16:11:48', NULL, '2019-06-14 21:33:25', NULL);
INSERT INTO `okm_question_answer` VALUES (9, '8', 'aaa', '0', '2019-05-23 16:12:30', NULL, '2019-05-23 16:12:30', NULL);
INSERT INTO `okm_question_answer` VALUES (10, '8', 'bbb', '0', '2019-05-23 16:12:30', NULL, '2019-05-23 16:12:30', NULL);
INSERT INTO `okm_question_answer` VALUES (11, '8', 'ccc', '1', '2019-05-23 16:12:30', NULL, '2019-05-23 16:12:30', NULL);
INSERT INTO `okm_question_answer` VALUES (12, '8', 'ddd', '0', '2019-05-23 16:12:30', NULL, '2019-05-23 16:12:30', NULL);
INSERT INTO `okm_question_answer` VALUES (13, '9', 'Satu OK', '1', '2019-05-24 08:01:48', NULL, '2019-06-16 12:46:13', NULL);
INSERT INTO `okm_question_answer` VALUES (14, '9', 'Dua', '0', '2019-05-24 08:01:48', NULL, '2019-05-24 08:01:48', NULL);
INSERT INTO `okm_question_answer` VALUES (15, '9', 'Tiga', '0', '2019-05-24 08:01:48', NULL, '2019-06-16 12:45:42', NULL);
INSERT INTO `okm_question_answer` VALUES (16, '9', 'Empat', '0', '2019-05-24 08:01:48', NULL, '2019-06-16 12:45:48', NULL);
INSERT INTO `okm_question_answer` VALUES (17, '10', 'abc', '0', '2019-05-24 08:03:37', NULL, '2019-05-24 08:03:37', NULL);
INSERT INTO `okm_question_answer` VALUES (18, '10', 'def', '0', '2019-05-24 08:03:37', NULL, '2019-06-16 12:45:59', NULL);
INSERT INTO `okm_question_answer` VALUES (19, '10', 'ghi', '0', '2019-05-24 08:03:37', NULL, '2019-05-24 08:03:37', NULL);
INSERT INTO `okm_question_answer` VALUES (20, '10', 'jkl', '1', '2019-05-24 08:03:37', NULL, '2019-06-16 12:45:59', NULL);
INSERT INTO `okm_question_answer` VALUES (21, '11', 'aa', '0', '2019-05-24 08:43:04', NULL, '2019-05-24 08:43:04', NULL);
INSERT INTO `okm_question_answer` VALUES (22, '11', 'aas', '1', '2019-05-24 08:43:04', NULL, '2019-05-24 08:43:04', NULL);
INSERT INTO `okm_question_answer` VALUES (23, '11', 'ddd', '0', '2019-05-24 08:43:04', NULL, '2019-05-24 08:43:04', NULL);
INSERT INTO `okm_question_answer` VALUES (24, '11', 'qqq', '0', '2019-05-24 08:43:04', NULL, '2019-05-24 08:43:04', NULL);
INSERT INTO `okm_question_answer` VALUES (25, '12', '1', '0', '2019-06-13 16:06:56', NULL, '2019-06-13 16:06:56', NULL);
INSERT INTO `okm_question_answer` VALUES (26, '12', '2', '0', '2019-06-13 16:06:56', NULL, '2019-06-13 16:06:56', NULL);
INSERT INTO `okm_question_answer` VALUES (27, '12', '3', '0', '2019-06-13 16:06:56', NULL, '2019-06-13 16:06:56', NULL);
INSERT INTO `okm_question_answer` VALUES (28, '12', '4', '1', '2019-06-13 16:06:56', NULL, '2019-06-13 16:06:56', NULL);
INSERT INTO `okm_question_answer` VALUES (29, '13', 'Ini adalah jawaban A yaitu Ini adalah jawaban A yaitu', '1', '2019-06-14 21:34:28', NULL, '2019-06-14 21:37:32', NULL);
INSERT INTO `okm_question_answer` VALUES (30, '13', 'Ini adalah jawaban B yaitu Ini adalah jawaban B yaitu', '0', '2019-06-14 21:34:28', NULL, '2019-06-14 21:34:28', NULL);
INSERT INTO `okm_question_answer` VALUES (31, '13', 'Ini adalah jawaban C yaitu', '0', '2019-06-14 21:34:28', NULL, '2019-06-14 21:37:32', NULL);
INSERT INTO `okm_question_answer` VALUES (32, '13', 'Ini adalah jawaban A yaitu Ini adalah jawabaIni adalah jawaban A yaitu yaitu Ini adalah jawaban A yaitu', '0', '2019-06-14 21:34:28', NULL, '2019-06-14 21:34:28', NULL);
INSERT INTO `okm_question_answer` VALUES (33, '14', 'xxx', '0', '2019-06-16 12:46:46', NULL, '2019-06-16 12:46:46', NULL);
INSERT INTO `okm_question_answer` VALUES (34, '14', 'yyy', '0', '2019-06-16 12:46:46', NULL, '2019-06-16 12:46:46', NULL);
INSERT INTO `okm_question_answer` VALUES (35, '14', 'ddd', '1', '2019-06-16 12:46:46', NULL, '2019-06-16 12:46:46', NULL);
INSERT INTO `okm_question_answer` VALUES (36, '14', 'ccc', '0', '2019-06-16 12:46:46', NULL, '2019-06-16 12:46:46', NULL);
INSERT INTO `okm_question_answer` VALUES (37, '15', '3', '0', '2019-06-20 15:49:47', NULL, '2019-06-20 15:49:47', NULL);
INSERT INTO `okm_question_answer` VALUES (38, '15', '2', '1', '2019-06-20 15:49:47', NULL, '2019-06-20 15:49:47', NULL);
INSERT INTO `okm_question_answer` VALUES (39, '15', '7', '0', '2019-06-20 15:49:47', NULL, '2019-06-20 15:49:47', NULL);
INSERT INTO `okm_question_answer` VALUES (40, '15', '11', '0', '2019-06-20 15:49:47', NULL, '2019-06-20 15:49:47', NULL);
INSERT INTO `okm_question_answer` VALUES (41, '16', '8', '1', '2019-06-20 15:50:10', NULL, '2019-06-23 10:52:32', NULL);
INSERT INTO `okm_question_answer` VALUES (42, '16', '3', '0', '2019-06-20 15:50:10', NULL, '2019-06-20 15:50:10', NULL);
INSERT INTO `okm_question_answer` VALUES (43, '16', '4', '0', '2019-06-20 15:50:10', NULL, '2019-06-23 10:49:46', NULL);
INSERT INTO `okm_question_answer` VALUES (44, '16', '19', '0', '2019-06-20 15:50:10', NULL, '2019-06-23 10:52:32', NULL);
INSERT INTO `okm_question_answer` VALUES (45, '17', '36', '1', '2019-06-22 08:11:25', NULL, '2019-06-22 08:11:25', NULL);
INSERT INTO `okm_question_answer` VALUES (46, '17', '72', '0', '2019-06-22 08:11:25', NULL, '2019-06-22 08:11:25', NULL);
INSERT INTO `okm_question_answer` VALUES (47, '17', '122', '0', '2019-06-22 08:11:25', NULL, '2019-06-22 08:11:25', NULL);
INSERT INTO `okm_question_answer` VALUES (48, '17', '144', '0', '2019-06-22 08:11:25', NULL, '2019-06-22 08:11:25', NULL);
INSERT INTO `okm_question_answer` VALUES (49, '18', '12', '0', '2019-06-23 10:53:41', NULL, '2019-06-23 10:55:39', 1);
INSERT INTO `okm_question_answer` VALUES (50, '18', '13', '0', '2019-06-23 10:53:41', NULL, '2019-06-23 10:55:39', 1);
INSERT INTO `okm_question_answer` VALUES (51, '18', '14', '1', '2019-06-23 10:53:41', NULL, '2019-06-23 10:55:39', 1);
INSERT INTO `okm_question_answer` VALUES (52, '18', '19', '0', '2019-06-23 10:53:41', NULL, '2019-06-23 10:55:39', 1);
INSERT INTO `okm_question_answer` VALUES (53, '19', '12', '0', '2019-06-27 14:37:22', 1, '2019-06-27 14:37:22', NULL);
INSERT INTO `okm_question_answer` VALUES (54, '19', '11', '1', '2019-06-27 14:37:22', 1, '2019-06-27 14:37:22', NULL);
INSERT INTO `okm_question_answer` VALUES (55, '19', '19', '0', '2019-06-27 14:37:22', 1, '2019-06-27 14:37:22', NULL);
INSERT INTO `okm_question_answer` VALUES (56, '19', '20', '0', '2019-06-27 14:37:22', 1, '2019-06-27 14:37:22', NULL);
INSERT INTO `okm_question_answer` VALUES (57, '20', '20', '1', '2019-07-02 14:45:54', 1, '2019-07-02 14:45:54', NULL);
INSERT INTO `okm_question_answer` VALUES (58, '20', '40', '0', '2019-07-02 14:45:54', 1, '2019-07-02 14:45:54', NULL);
INSERT INTO `okm_question_answer` VALUES (59, '20', '10', '0', '2019-07-02 14:45:54', 1, '2019-07-02 14:45:54', NULL);
INSERT INTO `okm_question_answer` VALUES (60, '20', '30', '0', '2019-07-02 14:45:54', 1, '2019-07-02 14:45:54', NULL);
INSERT INTO `okm_question_answer` VALUES (61, '21', '30', '0', '2019-07-02 14:46:30', 1, '2019-07-02 14:46:30', NULL);
INSERT INTO `okm_question_answer` VALUES (62, '21', '44', '1', '2019-07-02 14:46:30', 1, '2019-07-02 14:46:30', NULL);
INSERT INTO `okm_question_answer` VALUES (63, '21', '10', '0', '2019-07-02 14:46:30', 1, '2019-07-02 14:46:30', NULL);
INSERT INTO `okm_question_answer` VALUES (64, '21', '20', '0', '2019-07-02 14:46:30', 1, '2019-07-02 14:46:30', NULL);
INSERT INTO `okm_question_answer` VALUES (65, '22', '19', '0', '2019-07-02 14:46:58', 1, '2019-07-02 14:46:58', NULL);
INSERT INTO `okm_question_answer` VALUES (66, '22', '10', '0', '2019-07-02 14:46:58', 1, '2019-07-02 14:46:58', NULL);
INSERT INTO `okm_question_answer` VALUES (67, '22', '100', '1', '2019-07-02 14:46:58', 1, '2019-07-02 14:46:58', NULL);
INSERT INTO `okm_question_answer` VALUES (68, '22', '20', '0', '2019-07-02 14:46:58', 1, '2019-07-02 14:46:58', NULL);
INSERT INTO `okm_question_answer` VALUES (69, '23', '90', '0', '2019-07-02 14:47:21', 1, '2019-07-02 14:47:21', NULL);
INSERT INTO `okm_question_answer` VALUES (70, '23', '99', '0', '2019-07-02 14:47:21', 1, '2019-07-02 14:47:21', NULL);
INSERT INTO `okm_question_answer` VALUES (71, '23', '20', '0', '2019-07-02 14:47:21', 1, '2019-07-02 14:47:21', NULL);
INSERT INTO `okm_question_answer` VALUES (72, '23', '19', '1', '2019-07-02 14:47:21', 1, '2019-07-02 14:47:21', NULL);
INSERT INTO `okm_question_answer` VALUES (73, '24', '30', '0', '2019-07-02 14:47:53', 1, '2019-07-02 14:47:53', NULL);
INSERT INTO `okm_question_answer` VALUES (74, '24', '20', '1', '2019-07-02 14:47:53', 1, '2019-07-02 14:47:53', NULL);
INSERT INTO `okm_question_answer` VALUES (75, '24', '10', '0', '2019-07-02 14:47:53', 1, '2019-07-02 14:47:53', NULL);
INSERT INTO `okm_question_answer` VALUES (76, '24', '11', '0', '2019-07-02 14:47:53', 1, '2019-07-02 14:47:53', NULL);
INSERT INTO `okm_question_answer` VALUES (77, '25', '110', '1', '2019-07-02 14:51:08', 1, '2019-07-02 14:51:08', NULL);
INSERT INTO `okm_question_answer` VALUES (78, '25', '120', '0', '2019-07-02 14:51:09', 1, '2019-07-02 14:51:09', NULL);
INSERT INTO `okm_question_answer` VALUES (79, '25', '130', '0', '2019-07-02 14:51:10', 1, '2019-07-02 14:51:10', NULL);
INSERT INTO `okm_question_answer` VALUES (80, '25', '140', '0', '2019-07-02 14:51:10', 1, '2019-07-02 14:51:10', NULL);

-- ----------------------------
-- Table structure for okm_question_collection
-- ----------------------------
DROP TABLE IF EXISTS `okm_question_collection`;
CREATE TABLE `okm_question_collection`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `material_id` int(10) NULL DEFAULT NULL,
  `title` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `duration` int(10) NULL DEFAULT NULL,
  `minimum_score` double(255, 0) NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `updated_by` int(10) NULL DEFAULT NULL,
  `is_active` int(1) NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of okm_question_collection
-- ----------------------------
INSERT INTO `okm_question_collection` VALUES (1, 3, 'Post Test K3', 3, 80, '2018-10-31 07:24:42', NULL, '2019-05-22 07:58:14', NULL, 1);
INSERT INTO `okm_question_collection` VALUES (2, 3, 'Ujian Nasional Senam K3', 5, 75, '2019-05-22 12:41:54', NULL, '2019-05-22 15:58:34', 1, 1);
INSERT INTO `okm_question_collection` VALUES (3, 4, 'Latihan Dasar Server IT', 1, 53, '2019-05-22 14:57:48', NULL, '2019-05-24 08:43:48', 1, 1);
INSERT INTO `okm_question_collection` VALUES (4, 6, 'Soal Persiapan UNAS 2', 5, 80, '2019-05-23 09:25:58', NULL, '2019-06-13 16:07:42', 1, 1);
INSERT INTO `okm_question_collection` VALUES (5, 1, 'Ujian Bela diri 12', 3, 60, '2019-06-16 12:03:48', NULL, '2019-06-22 07:57:37', 1, 0);
INSERT INTO `okm_question_collection` VALUES (6, 7, 'Soal akhlakul karimah', 75, 60, '2019-06-20 15:49:11', 1, '2019-07-07 19:48:02', 1, 1);
INSERT INTO `okm_question_collection` VALUES (7, 11, 'Post Test Hafiz Quran', 2000, 40, '2019-07-02 14:45:27', 1, '2019-07-08 08:00:40', 1, 1);
INSERT INTO `okm_question_collection` VALUES (8, 11, 'Remidi Hafiz Quran', 45, 50, '2019-07-02 14:50:46', 1, '2019-07-07 19:45:14', 1, 1);

-- ----------------------------
-- Table structure for okm_raport
-- ----------------------------
DROP TABLE IF EXISTS `okm_raport`;
CREATE TABLE `okm_raport`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nik` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `collection_id` int(10) NULL DEFAULT NULL,
  `schedule_id` int(10) NULL DEFAULT NULL,
  `hours` int(10) NULL DEFAULT NULL,
  `score` int(10) NULL DEFAULT NULL,
  `status` enum('1','0') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0',
  `start_at` datetime(0) NULL DEFAULT NULL,
  `finish_at` datetime(0) NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `updated_by` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of okm_raport
-- ----------------------------
INSERT INTO `okm_raport` VALUES (1, '244', 7, 1, 0, 0, '0', '2019-07-07 21:04:59', NULL, '2019-07-04 08:14:33', NULL, '2019-07-07 21:04:59', NULL);
INSERT INTO `okm_raport` VALUES (2, '244', 7, 2, 0, 0, '0', NULL, NULL, '2019-07-04 09:02:44', NULL, '2019-07-04 09:02:44', NULL);
INSERT INTO `okm_raport` VALUES (3, '244', 7, 3, 0, 0, '0', NULL, NULL, '2019-07-07 20:04:55', NULL, '2019-07-08 10:04:32', NULL);

-- ----------------------------
-- Table structure for okm_user_answer
-- ----------------------------
DROP TABLE IF EXISTS `okm_user_answer`;
CREATE TABLE `okm_user_answer`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nik` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `schedule_id` int(10) NULL DEFAULT NULL,
  `question_id` int(10) NULL DEFAULT NULL,
  `answer_id` int(10) NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `created_by` int(10) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `updated_by` int(10) NULL DEFAULT NULL,
  `is_active` int(1) NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for okm_user_page_position
-- ----------------------------
DROP TABLE IF EXISTS `okm_user_page_position`;
CREATE TABLE `okm_user_page_position`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nik` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `schedule_id` int(10) NULL DEFAULT NULL,
  `page` int(10) NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `created_by` int(10) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `updated_by` int(10) NULL DEFAULT NULL,
  `is_active` int(1) NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of okm_user_page_position
-- ----------------------------
INSERT INTO `okm_user_page_position` VALUES (1, '244', 2, 2, '2019-07-05 15:18:43', NULL, '2019-07-05 15:19:07', NULL, 1);
INSERT INTO `okm_user_page_position` VALUES (2, '244', 3, 2, '2019-07-07 20:20:10', NULL, '2019-07-08 10:02:23', NULL, 1);

-- ----------------------------
-- Table structure for okm_user_pattern
-- ----------------------------
DROP TABLE IF EXISTS `okm_user_pattern`;
CREATE TABLE `okm_user_pattern`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nik` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `schedule_id` int(10) NULL DEFAULT NULL,
  `pattern` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `created_by` int(10) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `updated_by` int(10) NULL DEFAULT NULL,
  `is_active` int(1) NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of okm_user_pattern
-- ----------------------------
INSERT INTO `okm_user_pattern` VALUES (2, '244', 9, '22,20,24,23,21', '2019-07-03 16:11:10', NULL, '2019-07-03 16:11:10', NULL, 1);
INSERT INTO `okm_user_pattern` VALUES (3, '244', 1, '20,22,24,23,21', '2019-07-04 08:22:27', NULL, '2019-07-04 08:22:27', NULL, 1);
INSERT INTO `okm_user_pattern` VALUES (4, '244', 2, '24,20,22,21,23', '2019-07-04 09:03:21', NULL, '2019-07-04 09:03:21', NULL, 1);
INSERT INTO `okm_user_pattern` VALUES (5, '244', 3, '21,20,23,22,24', '2019-07-07 20:20:10', NULL, '2019-07-07 20:20:10', NULL, 1);

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 38 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (1, 'admin all', 'web', '2019-02-20 00:38:03', '2019-02-20 00:38:03');
INSERT INTO `permissions` VALUES (2, 'admin helpdesk', 'web', '2019-02-20 00:38:31', '2019-02-20 00:38:31');
INSERT INTO `permissions` VALUES (3, 'read helpdesk', 'web', '2019-02-20 00:40:37', '2019-02-20 00:40:37');
INSERT INTO `permissions` VALUES (4, 'create helpdesk', 'web', '2019-02-20 00:41:19', '2019-02-20 00:41:19');
INSERT INTO `permissions` VALUES (5, 'update helpdesk', 'web', '2019-02-20 00:41:19', '2019-02-20 00:41:19');
INSERT INTO `permissions` VALUES (6, 'delete edoc', 'web', '2019-02-20 00:41:19', '2019-02-20 00:41:19');
INSERT INTO `permissions` VALUES (7, 'admin edoc', 'web', '2019-02-20 00:41:19', '2019-02-20 00:41:19');
INSERT INTO `permissions` VALUES (8, 'read edoc', 'web', '2019-02-20 00:41:19', '2019-02-20 00:41:19');
INSERT INTO `permissions` VALUES (9, 'create edoc', 'web', '2019-02-20 00:41:19', '2019-02-20 00:41:19');
INSERT INTO `permissions` VALUES (10, 'update edoc', 'web', '2019-02-20 00:41:19', '2019-05-16 16:04:02');
INSERT INTO `permissions` VALUES (11, 'delete edoc', 'web', '2019-02-20 00:41:19', '2019-02-20 00:41:19');
INSERT INTO `permissions` VALUES (12, 'read iso document', 'web', '2019-02-20 00:41:19', '2019-02-20 00:41:19');
INSERT INTO `permissions` VALUES (13, 'create iso document', 'web', '2019-02-20 00:41:19', '2019-02-20 00:41:19');
INSERT INTO `permissions` VALUES (14, 'update iso document', 'web', '2019-02-20 00:41:19', '2019-02-20 00:41:19');
INSERT INTO `permissions` VALUES (15, 'delete iso document', 'web', '2019-02-20 00:41:19', '2019-02-20 00:41:19');
INSERT INTO `permissions` VALUES (16, 'read form document', 'web', '2019-02-20 00:41:19', '2019-02-20 00:41:19');
INSERT INTO `permissions` VALUES (17, 'create form document', 'web', '2019-02-20 00:41:19', '2019-02-20 00:41:19');
INSERT INTO `permissions` VALUES (18, 'update form document', 'web', '2019-02-20 00:41:19', '2019-02-20 00:41:19');
INSERT INTO `permissions` VALUES (19, 'delete form document', 'web', '2019-02-20 00:41:19', '2019-02-20 00:41:19');
INSERT INTO `permissions` VALUES (20, 'read supporting document', 'web', '2019-02-20 00:41:19', '2019-02-20 00:41:19');
INSERT INTO `permissions` VALUES (21, 'create supporting document', 'web', '2019-02-20 00:41:19', '2019-02-20 00:41:19');
INSERT INTO `permissions` VALUES (22, 'update supporting document', 'web', '2019-02-20 00:41:19', '2019-02-20 00:41:19');
INSERT INTO `permissions` VALUES (23, 'delete supporting document', 'web', '2019-02-20 00:41:19', '2019-02-20 00:41:19');
INSERT INTO `permissions` VALUES (24, 'admin okm', 'web', '2019-02-20 00:41:19', '2019-06-27 22:11:30');
INSERT INTO `permissions` VALUES (25, 'admin cuti & lembur online', 'web', '2019-02-20 00:41:19', '2019-02-20 00:41:19');
INSERT INTO `permissions` VALUES (26, 'admin asset', 'web', '2019-02-20 00:41:19', '2019-02-20 00:41:19');
INSERT INTO `permissions` VALUES (27, 'read schedule okm', 'web', '2019-05-17 08:06:36', '2019-05-17 08:16:10');
INSERT INTO `permissions` VALUES (28, 'read raport okm', 'web', '2019-05-17 08:26:40', '2019-05-17 08:26:40');
INSERT INTO `permissions` VALUES (29, 'read material okm', 'web', '2019-06-16 19:43:16', '2019-06-16 19:43:16');
INSERT INTO `permissions` VALUES (30, 'read question okm', 'web', '2019-06-16 19:43:49', '2019-06-16 19:43:49');
INSERT INTO `permissions` VALUES (31, 'create material okm', 'web', '2019-06-16 19:44:10', '2019-06-16 19:44:10');
INSERT INTO `permissions` VALUES (32, 'create question okm', 'web', '2019-06-16 19:44:10', '2019-06-16 19:44:10');
INSERT INTO `permissions` VALUES (33, 'create schedule okm', 'web', '2019-06-16 19:44:10', '2019-06-16 19:44:10');
INSERT INTO `permissions` VALUES (34, 'delete schedule okm', 'web', '2019-06-16 19:44:10', '2019-06-16 19:44:10');
INSERT INTO `permissions` VALUES (35, 'delete material okm', 'web', '2019-06-16 19:44:10', '2019-06-16 19:44:10');
INSERT INTO `permissions` VALUES (36, 'delete collection question okm', 'web', '2019-06-16 19:44:10', '2019-06-16 19:44:10');
INSERT INTO `permissions` VALUES (37, 'update schedule okm', 'web', '2019-06-16 19:44:10', '2019-06-16 19:44:10');

-- ----------------------------
-- Table structure for positions
-- ----------------------------
DROP TABLE IF EXISTS `positions`;
CREATE TABLE `positions`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 59 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of positions
-- ----------------------------
INSERT INTO `positions` VALUES (1, 'Director', '', '2019-02-28 09:27:27', NULL);
INSERT INTO `positions` VALUES (2, 'Personal Assistant', '', '2019-02-28 09:27:34', NULL);
INSERT INTO `positions` VALUES (3, 'Financial Analyst', '', '2019-02-28 09:27:38', NULL);
INSERT INTO `positions` VALUES (4, 'HSE Officer', '', '2019-02-28 09:27:42', NULL);
INSERT INTO `positions` VALUES (5, 'Dry Ice Sales Manager', '', '2019-02-28 09:28:44', '2019-03-06 13:38:53');
INSERT INTO `positions` VALUES (6, 'Dry Ice Sales Adm Staff - Lawang', '', '2019-02-28 09:29:20', '2019-03-06 13:38:53');
INSERT INTO `positions` VALUES (7, 'Dry Ice Sales Adm Staff - Bali', '', '2019-02-28 09:29:21', '2019-03-06 13:38:53');
INSERT INTO `positions` VALUES (8, 'Dry Ice Sales Representative - Bali', '', '2019-02-28 09:30:00', '2019-03-06 13:38:53');
INSERT INTO `positions` VALUES (9, 'Dry Ice Distribution Staff - Bali', '', '2019-02-28 09:30:43', '2019-03-06 13:38:53');
INSERT INTO `positions` VALUES (10, 'Dry Ice Sales Supervisor', '', '2019-02-28 09:31:01', '2019-03-06 13:38:53');
INSERT INTO `positions` VALUES (11, 'Plant Manager', '', '2019-02-28 09:31:08', '2019-03-06 13:38:53');
INSERT INTO `positions` VALUES (12, 'Technical Design Officer', '', '2019-02-28 09:31:31', '2019-03-06 13:38:53');
INSERT INTO `positions` VALUES (13, 'Quality Control Supervisor', '', '2019-02-28 09:31:33', '2019-03-06 13:38:53');
INSERT INTO `positions` VALUES (14, 'Quality Control Staff', '', '2019-03-05 07:59:10', '2019-03-06 13:38:53');
INSERT INTO `positions` VALUES (15, 'Production Supervisor', '', '2019-03-06 13:39:13', NULL);
INSERT INTO `positions` VALUES (16, 'CO2 Production Operator Staff', '', '2019-03-06 13:39:13', NULL);
INSERT INTO `positions` VALUES (17, 'Utility Supervisor', '', '2019-03-06 13:39:13', NULL);
INSERT INTO `positions` VALUES (18, 'Technical Support Staff', '', '2019-03-06 13:39:13', NULL);
INSERT INTO `positions` VALUES (19, 'Utility Opr Staff', '', '2019-03-06 13:39:13', NULL);
INSERT INTO `positions` VALUES (20, 'Utility Welder Staff', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (21, 'Utility Support Staff', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (22, 'Dry Ice Production Operator Staff', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (23, 'Compliance Manager', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (24, 'Compliance Officer', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (25, 'Logistic Manager', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (26, 'Logistic Supervisor', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (27, 'Purchasing Administration Staff', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (28, 'Warehouse Administration Staff', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (29, 'Warehouse Staff', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (30, 'Accounting & Finance Manager', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (31, 'Accounting & Finance Supervisor', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (32, 'Cashier Staff', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (33, 'Custodian Staff (AR/AP)', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (34, 'Billing & Collection Staff', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (35, 'HRM & GA Manager', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (36, 'HRM Supervisor', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (37, 'HRM Operation Staff', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (38, 'General Affair Supervisor', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (39, 'Corporate Affair Staff', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (40, 'IT Staff', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (41, 'Plant Housekeeping Staff', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (42, 'GA Staff', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (43, 'Office Housekeeping Staff', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (44, 'Security Senior Staff', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (45, 'Security Staff', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (46, 'BOC/BOD Driver', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (47, 'CO2 Sales Manager', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (48, 'CO2 Sales Administration Staff', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (49, 'Distribution Management Spv', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (50, 'Transporter Driver', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (51, 'Transporter Co - Driver', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (52, 'Regular Driver', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (53, 'Transporter Mechanical Staff', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (54, 'CO2 Sales Supervisor (Pj CO2 Sales Manager)', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (55, 'QC & Inventory Supervisor', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (56, 'General Administration Staff', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (57, 'HSE & Technical Support Staff', '', '2019-03-06 13:39:14', NULL);
INSERT INTO `positions` VALUES (58, 'General Support Staff', '', '2019-03-06 13:39:14', NULL);

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions`  (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `role_id`) USING BTREE,
  INDEX `role_has_permissions_role_id_foreign`(`role_id`) USING BTREE,
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------
INSERT INTO `role_has_permissions` VALUES (1, 1);
INSERT INTO `role_has_permissions` VALUES (2, 1);
INSERT INTO `role_has_permissions` VALUES (2, 2);
INSERT INTO `role_has_permissions` VALUES (2, 9);
INSERT INTO `role_has_permissions` VALUES (3, 7);
INSERT INTO `role_has_permissions` VALUES (3, 9);
INSERT INTO `role_has_permissions` VALUES (4, 7);
INSERT INTO `role_has_permissions` VALUES (5, 7);
INSERT INTO `role_has_permissions` VALUES (7, 1);
INSERT INTO `role_has_permissions` VALUES (7, 3);
INSERT INTO `role_has_permissions` VALUES (8, 7);
INSERT INTO `role_has_permissions` VALUES (9, 7);
INSERT INTO `role_has_permissions` VALUES (10, 7);
INSERT INTO `role_has_permissions` VALUES (12, 7);
INSERT INTO `role_has_permissions` VALUES (16, 7);
INSERT INTO `role_has_permissions` VALUES (20, 7);
INSERT INTO `role_has_permissions` VALUES (24, 1);
INSERT INTO `role_has_permissions` VALUES (24, 4);
INSERT INTO `role_has_permissions` VALUES (24, 5);
INSERT INTO `role_has_permissions` VALUES (24, 6);
INSERT INTO `role_has_permissions` VALUES (26, 6);
INSERT INTO `role_has_permissions` VALUES (29, 7);
INSERT INTO `role_has_permissions` VALUES (29, 8);
INSERT INTO `role_has_permissions` VALUES (30, 7);
INSERT INTO `role_has_permissions` VALUES (30, 8);
INSERT INTO `role_has_permissions` VALUES (31, 7);
INSERT INTO `role_has_permissions` VALUES (31, 8);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'Admin', 'web', '2019-02-20 00:37:05', '2019-02-20 00:37:05');
INSERT INTO `roles` VALUES (2, 'Admin Helpdesk', 'web', '2019-02-20 00:37:05', '2019-02-20 00:37:05');
INSERT INTO `roles` VALUES (3, 'Admin E-Doc', 'web', '2019-02-20 00:37:05', '2019-02-20 00:37:05');
INSERT INTO `roles` VALUES (4, 'Admin OKM', 'web', '2019-02-20 00:37:05', '2019-06-27 22:10:40');
INSERT INTO `roles` VALUES (5, 'Admin HRD', 'web', '2019-02-20 00:37:05', '2019-02-20 00:37:05');
INSERT INTO `roles` VALUES (6, 'Admin Assets', 'web', '2019-02-20 00:37:05', '2019-02-20 00:37:05');
INSERT INTO `roles` VALUES (7, 'User Level 1', 'web', '2019-02-20 00:37:05', '2019-02-20 00:37:05');
INSERT INTO `roles` VALUES (8, 'User Level 2', 'web', '2019-02-20 13:38:04', '2019-02-20 13:38:04');
INSERT INTO `roles` VALUES (9, 'Custom', 'web', '2019-02-20 13:38:04', '2019-05-16 10:10:30');

-- ----------------------------
-- Table structure for subordinate
-- ----------------------------
DROP TABLE IF EXISTS `subordinate`;
CREATE TABLE `subordinate`  (
  `id` int(13) NOT NULL,
  `parent_id` int(13) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of subordinate
-- ----------------------------
INSERT INTO `subordinate` VALUES (38, 37);
INSERT INTO `subordinate` VALUES (55, 50);
INSERT INTO `subordinate` VALUES (56, 50);

-- ----------------------------
-- Table structure for user_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `user_has_roles`;
CREATE TABLE `user_has_roles`  (
  `role_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`, `user_id`) USING BTREE,
  INDEX `user_has_roles_user_id_foreign`(`user_id`) USING BTREE,
  CONSTRAINT `user_has_roles_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `user_has_roles_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nik` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp(0) NULL DEFAULT NULL,
  `position_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `division_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `api_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE,
  INDEX `nik`(`nik`(191)) USING BTREE,
  INDEX `users_position_id_fk`(`position_id`) USING BTREE,
  INDEX `users_division_id_fk`(`division_id`) USING BTREE,
  CONSTRAINT `users_division_id_fk` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `users_position_id_fk` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 104 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, '000', 'Administrator', 'admin@molindointigas.co.id', NULL, NULL, NULL, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, 'dTQeNMa4ruR78usdPFtYP0PDQ1AMfQYZR4SCHfueo8grRazcXT2k4nccp5KD', NULL, '2019-02-16 02:23:05', '2019-02-23 05:50:56');
INSERT INTO `users` VALUES (2, '056', 'Eveline Valenciana', 'evelinevalenciana@mig.com', '0000-00-00 00:00:00', 1, 1, '$2y$10$u0d1RnmnKLY6uDRcqqu3iO4QzFb0WrVWOpB/adJdpQPwb8THldAHG', 'public/users/photo/Eveline Valenciana.JPG', 'wCefWLEPTCgE83S4PQAZ3az3tgpptiP3evzXQOOjuj6qSjYbx8N7nFjw4HvA', NULL, NULL, '2019-06-16 16:28:36');
INSERT INTO `users` VALUES (3, '225', 'Gregoria Pranesti', 'gregoriapranesti@mig.com', '0000-00-00 00:00:00', 2, 1, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', 'public/users/photo/Gregoria Pranesti.JPG', '19tQcyocCIRfiRyiuq06NrsWZPJ4MyGaHQCeyXOXHmbiPpygCqq9wcfgfQGM', '', NULL, NULL);
INSERT INTO `users` VALUES (4, '218', 'Tanti Dwi Mandasari', 'tantidwimandasari@mig.com', '0000-00-00 00:00:00', 3, 1, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', 'public/users/photo/Tanti Dwi Mandasari.JPG', NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (5, '086', 'Endhy Wisnu Novindra', 'endhywisnun.@mig.com', '0000-00-00 00:00:00', 4, 1, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', 'public/users/photo/Endhy Wisnu Novindra.JPG', NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (6, '230', 'Teguh Ariyanto', 'teguhariyanto@mig.com', '0000-00-00 00:00:00', 5, 1, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (7, '209', 'Arry Atur Sukmawati', 'arryatursukmawati@mig.com', '0000-00-00 00:00:00', 6, 3, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', 'public/users/photo/Arry Atur Sukmawati.JPG', NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (8, '234', 'Tsani Bagus Kurniawan', 'tsanibaguskurniawan@mig.com', '0000-00-00 00:00:00', 7, 3, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', 'public/users/photo/Tsani Bagus Kurniawan.JPG', NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (9, '236', 'Darius Rengga', 'dariusrengga@mig.com', '0000-00-00 00:00:00', 8, 3, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', 'public/users/photo/Darius Rengga.JPG', NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (10, '237', 'Aries Wijanarko', 'arieswijanarko@mig.com', '0000-00-00 00:00:00', 9, 3, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', 'public/users/photo/Aries Wijanarko.JPG', NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (11, '083', 'Aslichuddin Fadlol', 'aslichuddinfadlol@mig.com', '0000-00-00 00:00:00', 10, 3, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', 'public/users/photo/Aslichuddin Fadlol.JPG', NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (12, '210', 'Yohanes Kurniawan', 'yohaneskurniawan@mig.com', '0000-00-00 00:00:00', 11, 4, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', 'public/users/photo/Yohanes Kurniawan.JPG', NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (13, '241', 'Umar Ali', 'umarali@mig.com', '0000-00-00 00:00:00', 12, 4, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', 'public/users/photo/Umar Ali.JPG', NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (14, '177', 'Fahma Riza', 'fahmariza@mig.com', '0000-00-00 00:00:00', 13, 4, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', 'public/users/photo/Fahma Riza.JPG', NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (15, '104', 'Hari Sutanto', 'harisutanto@mig.com', '0000-00-00 00:00:00', 14, 4, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', 'public/users/photo/Hari Sutanto.JPG', NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (16, '106', 'Handy Heksa S.', 'handyheksas.@mig.com', '0000-00-00 00:00:00', 14, 4, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', 'public/users/photo/Handy Heksa S..JPG', NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (17, '082', 'Sunaryo', 'sunaryo@mig.com', '0000-00-00 00:00:00', 14, 4, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', 'public/users/photo/Sunaryo.JPG', NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (18, '075', 'Didin Wijaya', 'didinwijaya@mig.com', '0000-00-00 00:00:00', 14, 4, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', 'public/users/photo/Didin Wijaya.JPG', NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (19, '089', 'Eko  Ferry  F.', 'ekoferryf.@mig.com', '0000-00-00 00:00:00', 15, 4, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (20, '061', 'Suhariyadi', 'suhariyadi@mig.com', '0000-00-00 00:00:00', 16, 4, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (21, '059', 'Khoirul Rosidin', 'khoirulrosidin@mig.com', '0000-00-00 00:00:00', 16, 4, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (22, '101', 'Andriyanto', 'andriyanto@mig.com', '0000-00-00 00:00:00', 16, 4, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (23, '126', 'Erwin Sulistyo', 'erwinsulistyo@mig.com', '0000-00-00 00:00:00', 16, 4, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (24, '039', 'M.Yanuar Firmansyah', 'm.yanuarfirmansyah@mig.com', '0000-00-00 00:00:00', 17, 4, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (25, '012', 'Haris Setiawan', 'harissetiawan@mig.com', '0000-00-00 00:00:00', 18, 4, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (26, '052', 'Endri Prabowo', 'endriprabowo@mig.com', '0000-00-00 00:00:00', 19, 4, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (27, '054', 'Arifin Suliyanto', 'arifinsuliyanto@mig.com', '0000-00-00 00:00:00', 19, 4, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (28, '084', 'Feri Santosa', 'ferisantosa@mig.com', '0000-00-00 00:00:00', 19, 4, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (29, '102', 'Hendri Setianto', 'hendrisetianto@mig.com', '0000-00-00 00:00:00', 19, 4, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (30, '018', 'Indra Bastian', 'indrabastian@mig.com', '0000-00-00 00:00:00', 19, 4, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (31, '128', 'Cipto Mulyo', 'ciptomulyo@mig.com', '0000-00-00 00:00:00', 20, 4, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (32, '145', 'Suwondo', 'suwondo@mig.com', '0000-00-00 00:00:00', 21, 4, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (33, '035', 'Sugeng Purnomo', 'sugengpurnomo@mig.com', '0000-00-00 00:00:00', 22, 4, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (34, '161', 'Achmad Arianto', 'achmadarianto@mig.com', '0000-00-00 00:00:00', 22, 4, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (35, '162', 'Choirul Anwar', 'choirulanwar@mig.com', '0000-00-00 00:00:00', 22, 4, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (36, '151', 'Ari Pramono', 'aripramono@mig.com', '0000-00-00 00:00:00', 22, 4, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (37, '023', 'Suci Andayani', 'suciandayani@mig.com', '0000-00-00 00:00:00', 23, 2, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', 'public/users/photo/Suci Andayani.JPG', 'HDNMbluwR26mcC25JMCEri20Tt0SvxueIfHWP32dOBXsaC1G6o6ahev8r6qu', '', NULL, NULL);
INSERT INTO `users` VALUES (38, '176', 'Any Shofiyah', 'anyshofiyah@mig.com', '0000-00-00 00:00:00', 24, 2, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', 'public/users/photo/Any Shofiyah.JPG', NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (39, '233', 'Sulkhan Effendi', 'sulkhaneffendi@mig.com', '0000-00-00 00:00:00', 25, 4, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (40, '226', 'Lestari Indah Karyati', 'lestariindahkaryati@mig.com', '0000-00-00 00:00:00', 26, 9, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (41, '133', 'Rizqa Makhsunah', 'rizqamakhsunah@mig.com', '0000-00-00 00:00:00', 27, 9, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (42, '187', 'Imelda Sukri', 'imeldasukri@mig.com', '0000-00-00 00:00:00', 28, 9, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (43, '098', 'Samuel Tri S.', 'samueltris.@mig.com', '0000-00-00 00:00:00', 29, 9, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (44, '049', 'M. Chairul Anam', 'm.chairulanam@mig.com', '0000-00-00 00:00:00', 29, 9, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (45, '055', 'Nining Sri W', 'niningsriw@mig.com', '0000-00-00 00:00:00', 30, 5, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (46, '050', 'Yetty Adistana', 'yettyadistana@mig.com', '0000-00-00 00:00:00', 31, 5, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (47, '011', 'Sudibyo Tri W', 'sudibyotriw@mig.com', '0000-00-00 00:00:00', 32, 5, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (48, '142', 'Ambar Palupi', 'ambarpalupi@mig.com', '0000-00-00 00:00:00', 33, 5, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (49, '058', 'Supriono', 'supriono@mig.com', '0000-00-00 00:00:00', 34, 5, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (50, '033', 'Indarwati Dewi A', 'indarwatidewia@mig.com', '0000-00-00 00:00:00', 35, 8, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, 'sjB3K9NKvzU8oEUe083cNJPUjENhfqKVUIEAupRf7YNZVFLMJv6WVAZx4TJ3', '', NULL, NULL);
INSERT INTO `users` VALUES (51, '103', 'Luluk Tri Astutik', 'luluktriastutik@mig.com', '0000-00-00 00:00:00', 36, 8, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (52, '137', 'Naumi Debi Alvia', 'naumidebialvia@mig.com', '0000-00-00 00:00:00', 37, 8, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (53, '019', 'Meili Wirawati', 'meiliwirawati@mig.com', '0000-00-00 00:00:00', 38, 8, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (54, '184', 'Maretta Ramadhiana P.', 'marettaramadhianap.@mig.com', '0000-00-00 00:00:00', 39, 8, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (55, '235', 'Dhika Putra Permana', 'dhikaputrapermana@mig.com', '0000-00-00 00:00:00', 40, 8, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', 'public/users/photo/Dhika Putra Permana.JPG', '6sXw8BuFy4YnInv8EFUq4WyaTb7e9gR0t5PKimVYQiAxgr55i6j3izVsOZ1h', '', NULL, NULL);
INSERT INTO `users` VALUES (56, '244', 'Reza Kurniawan', 'reza@molindointigas.co.id', '0000-00-00 00:00:00', 40, 8, '$2y$10$yr1fAQkwR3Tkhvk5Q37xAupaarxJrmM1k9OaxJwntRJldutxf2Ly6', 'public/users/photo/Reza Kurniawan.JPG', '1WwmD8oIptSp5xuk9NKc8Oeeub7L8mGTxbkQdz4WaBxKq90JlDlW8aw0noaI', '', NULL, '2019-05-16 14:44:57');
INSERT INTO `users` VALUES (57, '146', 'Djanuar Ari Wibowo', 'djanuarariwibowo@mig.com', '0000-00-00 00:00:00', 41, 8, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (58, '166', 'Santoso Budi Raharjo', 'santosobudiraharjo@mig.com', '0000-00-00 00:00:00', 41, 8, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (59, '149', 'Beny Setiyawan', 'benysetiyawan@mig.com', '0000-00-00 00:00:00', 42, 8, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (60, '183', 'Moh Johan Witono', 'mohjohanwitono@mig.com', '0000-00-00 00:00:00', 43, 8, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (61, '238', 'Agus Hartanto', 'agushartanto@mig.com', '0000-00-00 00:00:00', 43, 8, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (62, '009', 'Sudi Hartoyo', 'sudihartoyo@mig.com', '0000-00-00 00:00:00', 44, 8, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (63, '010', 'Slamet', 'slamet@mig.com', '0000-00-00 00:00:00', 45, 8, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (64, '022', 'Supriyanto', 'supriyanto@mig.com', '0000-00-00 00:00:00', 45, 8, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (65, '074', 'Nari Santoso', 'narisantoso@mig.com', '0000-00-00 00:00:00', 45, 8, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (66, '114', 'Supangat', 'supangat@mig.com', '0000-00-00 00:00:00', 46, 8, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (67, '223', 'Didik Suhartono', 'didiksuhartono@mig.com', '0000-00-00 00:00:00', 46, 8, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (68, '144', 'Jimmy Kristianto', 'jimmykristianto@mig.com', '0000-00-00 00:00:00', 47, 6, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (69, '078', 'Slamet Riyadi', 'slametriyadi@mig.com', '0000-00-00 00:00:00', 48, 6, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (70, '080', 'Luhur Budi Waluyo', 'luhurbudiwaluyo@mig.com', '0000-00-00 00:00:00', 49, 6, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (71, '032', 'Wiyoto', 'wiyoto@mig.com', '0000-00-00 00:00:00', 50, 6, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (72, '067', 'Ali Kosim', 'alikosim@mig.com', '0000-00-00 00:00:00', 50, 6, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (73, '044', 'Rumajianto', 'rumajianto@mig.com', '0000-00-00 00:00:00', 50, 6, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (74, '030', 'Yoyok Yuliono', 'yoyokyuliono@mig.com', '0000-00-00 00:00:00', 50, 6, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (75, '163', 'Sarpin', 'sarpin@mig.com', '0000-00-00 00:00:00', 50, 6, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (76, '211', 'Herman Toni', 'hermantoni@mig.com', '0000-00-00 00:00:00', 50, 6, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (77, '212', 'Feril Dwi Fitanto', 'ferildwifitanto@mig.com', '0000-00-00 00:00:00', 50, 6, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (78, '221', 'Mujiarto', 'mujiarto@mig.com', '0000-00-00 00:00:00', 50, 6, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (79, '229', 'Akhmad Basori', 'akhmadbasori@mig.com', '0000-00-00 00:00:00', 50, 6, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (80, '232', 'Ali Bukhori', 'alibukhori@mig.com', '0000-00-00 00:00:00', 50, 6, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (81, '239', 'Agus Sugianto', 'agussugianto@mig.com', '0000-00-00 00:00:00', 50, 6, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (82, '240', 'Wagianto', 'wagianto@mig.com', '0000-00-00 00:00:00', 50, 6, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (83, '228', 'Krisdianto', 'krisdianto@mig.com', '0000-00-00 00:00:00', 51, 6, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (84, '081', 'Murwanto', 'murwanto@mig.com', '0000-00-00 00:00:00', 51, 6, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (85, '038', 'Sugeng Rianto', 'sugengrianto@mig.com', '0000-00-00 00:00:00', 51, 6, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (86, '079', 'Slamet Tarmuji', 'slamettarmuji@mig.com', '0000-00-00 00:00:00', 51, 6, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (87, '178', 'Hendra Setiawan', 'hendrasetiawan@mig.com', '0000-00-00 00:00:00', 51, 6, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (88, '242', 'Arif Wibowo', 'arifwibowo@mig.com', '0000-00-00 00:00:00', 52, 6, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (89, '164', 'Yunianto', 'yunianto@mig.com', '0000-00-00 00:00:00', 53, 6, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (90, '123', 'Surono', 'surono@mig.com', '0000-00-00 00:00:00', 54, 7, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (91, '206', 'Nindya Farah Fauzan', 'nindyafarahfauzan@mig.com', '0000-00-00 00:00:00', 55, 7, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (92, '158', 'Mesrawati', 'mesrawati@mig.com', '0000-00-00 00:00:00', 56, 7, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (93, '231', 'Didik Darmadi', 'didikdarmadi@mig.com', '0000-00-00 00:00:00', 57, 7, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (94, '121', 'Yono ', 'yono@mig.com', '0000-00-00 00:00:00', 50, 7, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (95, '154', 'Suhendi', 'suhendi@mig.com', '0000-00-00 00:00:00', 50, 7, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (96, '173', 'Erwan', 'erwan@mig.com', '0000-00-00 00:00:00', 50, 7, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (97, '200', 'Kurniawan', 'kurniawan@mig.com', '0000-00-00 00:00:00', 50, 7, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (98, '201', 'Tatang Sihabudin', 'tatangsihabudin@mig.com', '0000-00-00 00:00:00', 50, 7, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (99, '140', 'Asan ', 'asan@mig.com', '0000-00-00 00:00:00', 50, 7, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, '', NULL, NULL);
INSERT INTO `users` VALUES (100, '122', 'Unang Suherman', 'unangsuherman@mig.com', '0000-00-00 00:00:00', 58, 7, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, 'e2XM9wuLGHQ1z9BPyscAtAC1yaWim5v27KylpwkMgdnPYpxhGtDRpCKV6Hee', '', NULL, NULL);
INSERT INTO `users` VALUES (101, '999', 'Admin OKM', 'okm@molindointigas.co.id', '0000-00-00 00:00:00', NULL, NULL, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, 'LTUSdmbJkVC9VObud2Wvw4Buz0xEOXRU4UD6cYjPAgrkMtX2woIjkquSz6sl', NULL, '2019-02-16 02:23:05', '2019-02-23 05:50:56');
INSERT INTO `users` VALUES (102, '888', 'Admin EDOC', 'edoc@molindointigas.co.id', '0000-00-00 00:00:00', NULL, NULL, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, NULL, NULL, '2019-02-16 02:23:05', '2019-02-23 05:50:56');
INSERT INTO `users` VALUES (103, '777', 'Admin Test', 'test@mig.co.id', '0000-00-00 00:00:00', NULL, NULL, '$2y$10$e1acrysdKv64SQVPO66yyONMPcF4s7cVRcChhliReuMHllhxw4bBe', NULL, 'sJ9F5DrrJVVrBa5YMX9Y3zoHwLdJBJH1MNPAa6b4GAzSr6tONb4AXF1WmiES', NULL, '0000-00-00 00:00:00', NULL);

-- ----------------------------
-- Table structure for users_log
-- ----------------------------
DROP TABLE IF EXISTS `users_log`;
CREATE TABLE `users_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT NULL,
  `activity` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `type` enum('login','logout','insert','update','') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ip` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `date` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 97 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of users_log
-- ----------------------------
INSERT INTO `users_log` VALUES (1, 1, 'berhasil login', 'login', '::1', '2019-04-23 07:42:25');
INSERT INTO `users_log` VALUES (2, 1, 'berhasil login', 'login', '::1', '2019-04-25 08:59:55');
INSERT INTO `users_log` VALUES (3, 1, 'menambah data <a href=\'http://localhost/mig/admin/career/detail/1\'>career</a>', 'insert', '::1', '2019-04-25 09:00:19');
INSERT INTO `users_log` VALUES (4, 1, 'menambah data <a href=\'http://localhost/mig/admin/career/detail/2\'>career</a>', 'insert', '::1', '2019-04-25 09:00:51');
INSERT INTO `users_log` VALUES (5, 1, 'menambah data <a href=\'http://localhost/mig/news/detail/27\'>news</a>', 'insert', '::1', '2019-04-25 09:24:52');
INSERT INTO `users_log` VALUES (6, 1, 'mengubah data <a href=\'http://localhost/mig/news/detail/27\'>news</a>', 'update', '::1', '2019-04-25 09:25:14');
INSERT INTO `users_log` VALUES (7, 1, 'mengubah status non-aktif data <a href=\'http://localhost/mig/news/detail/27\'>news</a>', 'update', '::1', '2019-04-25 09:26:47');
INSERT INTO `users_log` VALUES (8, 1, 'mengubah status aktif data <a href=\'http://localhost/mig/admin/news/detail/27\'>news</a>', 'update', '::1', '2019-04-25 09:27:11');
INSERT INTO `users_log` VALUES (9, 1, 'menambah data <a href=\'http://localhost/mig/admin/career/detail/3\'>career</a>', 'insert', '::1', '2019-04-25 09:29:47');
INSERT INTO `users_log` VALUES (10, 1, 'mengubah status non-aktif data career', 'update', '::1', '2019-04-25 09:30:12');
INSERT INTO `users_log` VALUES (11, 1, 'mengubah status aktif data <a href=\'http://localhost/mig/admin/career/detail/3\'>karir</a>', 'update', '::1', '2019-04-25 09:31:26');
INSERT INTO `users_log` VALUES (12, 1, 'mengubah status non-aktif data <a href=\'http://localhost/mig/admin/career/detail/3\'>karir</a>', 'update', '::1', '2019-04-25 09:31:36');
INSERT INTO `users_log` VALUES (13, 1, 'mengubah status non-aktif data <a href=\'http://localhost/mig/admin/news/detail/27\'>berita</a>', 'update', '::1', '2019-04-25 10:09:19');
INSERT INTO `users_log` VALUES (14, 1, 'mengubah status aktif data <a href=\'http://localhost/mig/admin/career/detail/3\'>karir</a>', 'update', '::1', '2019-04-25 11:39:33');
INSERT INTO `users_log` VALUES (15, 1, 'berhasil login', 'login', '::1', '2019-04-29 07:25:56');
INSERT INTO `users_log` VALUES (16, 1, 'mengubah status non-aktif data <a href=\'http://localhost/mig/admin/career/detail/3\'>karir</a>', 'update', '::1', '2019-04-29 07:28:36');
INSERT INTO `users_log` VALUES (17, 1, 'mengubah status aktif data <a href=\'http://localhost/mig/admin/career/detail/3\'>karir</a>', 'update', '::1', '2019-04-29 07:28:48');
INSERT INTO `users_log` VALUES (18, 1, 'mengubah status non-aktif data subscriber', 'update', '::1', '2019-04-29 07:29:38');
INSERT INTO `users_log` VALUES (19, 1, 'mengubah status aktif data <a href=\'http://localhost/mig/admin/news/detail/27\'>berita</a>', 'update', '::1', '2019-04-29 08:05:24');
INSERT INTO `users_log` VALUES (20, 1, 'mengubah status non-aktif data <a href=\'http://localhost/mig/admin/news/detail/27\'>berita</a>', 'update', '::1', '2019-04-29 08:05:48');
INSERT INTO `users_log` VALUES (21, 1, 'mengubah status aktif data <a href=\'http://localhost/mig/admin/news/detail/27\'>berita</a>', 'update', '::1', '2019-04-29 08:05:56');
INSERT INTO `users_log` VALUES (22, 1, 'mengubah status non-aktif data <a href=\'http://localhost/mig/admin/news/detail/27\'>berita</a>', 'update', '::1', '2019-04-29 08:05:57');
INSERT INTO `users_log` VALUES (23, 1, 'mengubah status non-aktif data <a href=\'http://localhost/mig/admin/news/detail/25\'>berita</a>', 'update', '::1', '2019-04-29 08:36:01');
INSERT INTO `users_log` VALUES (24, 1, 'mengubah status non-aktif data <a href=\'http://localhost/mig/admin/career/detail/3\'>karir</a>', 'update', '::1', '2019-04-29 08:36:28');
INSERT INTO `users_log` VALUES (25, 1, 'mengubah status non-aktif data <a href=\'http://localhost/mig/admin/career/detail/1\'>karir</a>', 'update', '::1', '2019-04-29 08:36:46');
INSERT INTO `users_log` VALUES (26, 1, 'mengubah status aktif data <a href=\'http://localhost/mig/admin/career/detail/1\'>karir</a>', 'update', '::1', '2019-04-29 08:37:05');
INSERT INTO `users_log` VALUES (27, 1, 'mengubah status aktif data <a href=\'http://localhost/mig/admin/news/detail/27\'>berita</a>', 'update', '::1', '2019-04-29 08:40:28');
INSERT INTO `users_log` VALUES (28, 1, 'mengubah status non-aktif data <a href=\'http://localhost/mig/admin/news/detail/27\'>berita</a>', 'update', '::1', '2019-04-29 08:40:40');
INSERT INTO `users_log` VALUES (29, 1, 'mengubah status aktif data <a href=\'http://localhost/mig/admin/news/detail/27\'>berita</a>', 'update', '::1', '2019-04-29 08:41:32');
INSERT INTO `users_log` VALUES (30, 1, 'berhasil login', 'login', '::1', '2019-04-29 10:59:32');
INSERT INTO `users_log` VALUES (31, 1, 'berhasil logout', 'logout', '::1', '2019-04-29 11:52:32');
INSERT INTO `users_log` VALUES (32, 5, 'berhasil login', 'login', '::1', '2019-04-29 11:52:47');
INSERT INTO `users_log` VALUES (33, 5, 'berhasil logout', 'logout', '::1', '2019-04-29 11:53:31');
INSERT INTO `users_log` VALUES (34, 1, 'berhasil login', 'login', '::1', '2019-04-29 11:53:38');
INSERT INTO `users_log` VALUES (35, 1, 'berhasil login', 'login', '::1', '2019-04-30 07:57:12');
INSERT INTO `users_log` VALUES (36, 1, 'berhasil login', 'login', '::1', '2019-05-02 10:23:49');
INSERT INTO `users_log` VALUES (37, 1, 'berhasil login', 'login', '::1', '2019-05-03 09:07:57');
INSERT INTO `users_log` VALUES (38, 1, 'mengubah status aktif data <a href=\'http://localhost/mig/admin/career/detail/1\'>karir</a>', 'update', '::1', '2019-05-03 09:18:05');
INSERT INTO `users_log` VALUES (39, 1, 'berhasil login', 'login', '::1', '2019-05-05 20:53:37');
INSERT INTO `users_log` VALUES (40, 1, 'berhasil login', 'login', '::1', '2019-05-06 07:32:57');
INSERT INTO `users_log` VALUES (41, 1, 'berhasil login', 'login', '::1', '2019-05-07 07:51:55');
INSERT INTO `users_log` VALUES (42, 1, 'berhasil login', 'login', '::1', '2019-05-07 10:39:58');
INSERT INTO `users_log` VALUES (43, 1, 'berhasil login', 'login', '::1', '2019-05-07 19:58:00');
INSERT INTO `users_log` VALUES (44, 1, 'berhasil login', 'login', '::1', '2019-05-07 21:41:04');
INSERT INTO `users_log` VALUES (45, 1, 'berhasil login', 'login', '::1', '2019-05-08 07:28:42');
INSERT INTO `users_log` VALUES (46, 1, 'berhasil logout', 'logout', '::1', '2019-05-08 09:03:19');
INSERT INTO `users_log` VALUES (47, 1, 'berhasil login', 'login', '::1', '2019-05-08 09:58:36');
INSERT INTO `users_log` VALUES (48, 1, 'berhasil login', 'login', '::1', '2019-05-08 12:53:49');
INSERT INTO `users_log` VALUES (49, 1, 'berhasil logout', 'logout', '::1', '2019-05-08 12:54:56');
INSERT INTO `users_log` VALUES (50, 1, 'berhasil login', 'login', '::1', '2019-05-08 13:47:57');
INSERT INTO `users_log` VALUES (51, 1, 'menambah data <a href=\'http://localhost/mig/news/detail/28\'>news</a>', 'insert', '::1', '2019-05-08 14:47:58');
INSERT INTO `users_log` VALUES (52, 1, 'menambah data <a href=\'http://localhost/mig/news/detail/29\'>news</a>', 'insert', '::1', '2019-05-08 14:48:09');
INSERT INTO `users_log` VALUES (53, 1, 'menambah data <a href=\'http://localhost/mig/news/detail/30\'>news</a>', 'insert', '::1', '2019-05-08 14:48:44');
INSERT INTO `users_log` VALUES (54, 1, 'menambah data <a href=\'http://localhost/mig/news/detail/31\'>news</a>', 'insert', '::1', '2019-05-08 14:50:18');
INSERT INTO `users_log` VALUES (55, 1, 'menambah data <a href=\'http://localhost/mig/news/detail/32\'>news</a>', 'insert', '::1', '2019-05-08 14:53:01');
INSERT INTO `users_log` VALUES (56, 1, 'menambah data <a href=\'http://localhost/mig/news/detail/33\'>news</a>', 'insert', '::1', '2019-05-08 14:53:19');
INSERT INTO `users_log` VALUES (57, 1, 'menambah data <a href=\'http://localhost/mig/news/detail/34\'>news</a>', 'insert', '::1', '2019-05-08 14:54:05');
INSERT INTO `users_log` VALUES (58, 1, 'menambah data <a href=\'http://localhost/mig/news/detail/35\'>news</a>', 'insert', '::1', '2019-05-08 14:55:19');
INSERT INTO `users_log` VALUES (59, 1, 'menambah data <a href=\'http://localhost/mig/news/detail/36\'>news</a>', 'insert', '::1', '2019-05-08 14:55:50');
INSERT INTO `users_log` VALUES (60, 1, 'menambah data <a href=\'http://localhost/mig/news/detail/37\'>news</a>', 'insert', '::1', '2019-05-08 14:56:54');
INSERT INTO `users_log` VALUES (61, 1, 'menambah data <a href=\'http://localhost/mig/news/detail/38\'>news</a>', 'insert', '::1', '2019-05-08 14:59:44');
INSERT INTO `users_log` VALUES (62, 1, 'menambah data <a href=\'http://localhost/mig/news/detail/39\'>news</a>', 'insert', '::1', '2019-05-08 15:00:01');
INSERT INTO `users_log` VALUES (63, 1, 'menambah data <a href=\'http://localhost/mig/news/detail/40\'>news</a>', 'insert', '::1', '2019-05-08 15:00:34');
INSERT INTO `users_log` VALUES (64, 1, 'menambah data <a href=\'http://localhost/mig/news/detail/41\'>news</a>', 'insert', '::1', '2019-05-08 15:03:06');
INSERT INTO `users_log` VALUES (65, 1, 'menambah data <a href=\'http://localhost/mig/news/detail/42\'>news</a>', 'insert', '::1', '2019-05-08 15:04:18');
INSERT INTO `users_log` VALUES (66, 1, 'menambah data <a href=\'http://localhost/mig/news/detail/43\'>news</a>', 'insert', '::1', '2019-05-08 15:05:00');
INSERT INTO `users_log` VALUES (67, 1, 'menambah data <a href=\'http://localhost/mig/news/detail/44\'>news</a>', 'insert', '::1', '2019-05-08 15:05:49');
INSERT INTO `users_log` VALUES (68, 1, 'menambah data <a href=\'http://localhost/mig/news/detail/45\'>news</a>', 'insert', '::1', '2019-05-08 15:19:23');
INSERT INTO `users_log` VALUES (69, 1, 'menambah data <a href=\'http://localhost/mig/news/detail/46\'>news</a>', 'insert', '::1', '2019-05-08 15:20:22');
INSERT INTO `users_log` VALUES (70, 1, 'menambah data <a href=\'http://localhost/mig/admin/career/detail/4\'>career</a>', 'insert', '::1', '2019-05-08 15:22:02');
INSERT INTO `users_log` VALUES (71, 1, 'menambah data <a href=\'http://localhost/mig/news/detail/47\'>news</a>', 'insert', '::1', '2019-05-08 15:23:57');
INSERT INTO `users_log` VALUES (72, 1, 'menambah data <a href=\'http://localhost/mig/admin/career/detail/5\'>career</a>', 'insert', '::1', '2019-05-08 15:27:21');
INSERT INTO `users_log` VALUES (73, 1, 'menambah data <a href=\'http://localhost/mig/news/detail/48\'>news</a>', 'insert', '::1', '2019-05-08 15:37:34');
INSERT INTO `users_log` VALUES (74, 1, 'berhasil login', 'login', '::1', '2019-05-09 13:06:19');
INSERT INTO `users_log` VALUES (75, 1, 'mengubah status non-aktif data subscriber', 'update', '::1', '2019-05-09 14:12:23');
INSERT INTO `users_log` VALUES (76, 1, 'mengubah status non-aktif data subscriber', 'update', '::1', '2019-05-09 14:12:24');
INSERT INTO `users_log` VALUES (77, 1, 'menambah data <a href=\'http://localhost/mig/admin/career/detail/6\'>career</a>', 'insert', '::1', '2019-05-09 14:13:13');
INSERT INTO `users_log` VALUES (78, 1, 'berhasil logout', 'logout', '::1', '2019-05-09 14:44:09');
INSERT INTO `users_log` VALUES (79, 3, 'berhasil login', 'login', '::1', '2019-05-09 14:44:15');
INSERT INTO `users_log` VALUES (80, 3, 'menambah data <a href=\'http://localhost/mig/news/detail/49\'>news</a>', 'insert', '::1', '2019-05-09 15:05:43');
INSERT INTO `users_log` VALUES (81, 3, 'mengubah data <a href=\'http://localhost/mig/news/detail/49\'>news</a>', 'update', '::1', '2019-05-09 15:08:25');
INSERT INTO `users_log` VALUES (82, 3, 'mengubah data <a href=\'http://localhost/mig/news/detail/49\'>news</a>', 'update', '::1', '2019-05-09 15:09:21');
INSERT INTO `users_log` VALUES (83, 1, 'berhasil login', 'login', '::1', '2019-05-10 15:08:54');
INSERT INTO `users_log` VALUES (84, 1, 'berhasil login', 'login', '::1', '2019-05-11 17:51:35');
INSERT INTO `users_log` VALUES (85, 1, 'mengubah data <a href=\'http://localhost/mig/admin/career/detail/2\'>career</a>', 'update', '::1', '2019-05-11 18:42:05');
INSERT INTO `users_log` VALUES (86, 1, 'mengubah data <a href=\'http://localhost/mig/admin/career/detail/1\'>career</a>', 'update', '::1', '2019-05-11 18:42:31');
INSERT INTO `users_log` VALUES (87, 1, 'mengubah data <a href=\'http://localhost/mig/news/detail/2\'>news</a>', 'update', '::1', '2019-05-11 20:44:02');
INSERT INTO `users_log` VALUES (88, 1, 'mengubah data <a href=\'http://localhost/mig/admin/career/detail/6\'>career</a>', 'update', '::1', '2019-05-11 20:52:50');
INSERT INTO `users_log` VALUES (89, 1, 'berhasil login', 'login', '::1', '2019-05-12 08:33:16');
INSERT INTO `users_log` VALUES (90, 1, 'berhasil login', 'login', '::1', '2019-05-12 13:07:33');
INSERT INTO `users_log` VALUES (91, 1, 'berhasil login', 'login', '::1', '2019-05-12 20:01:14');
INSERT INTO `users_log` VALUES (92, 1, 'berhasil login', 'login', '::1', '2019-05-13 07:41:39');
INSERT INTO `users_log` VALUES (93, 1, 'berhasil login', 'login', '::1', '2019-05-13 13:37:20');
INSERT INTO `users_log` VALUES (94, 1, 'mengubah data <a href=\'http://localhost/mig/news/detail/49\'>news</a>', 'update', '::1', '2019-05-13 14:57:13');
INSERT INTO `users_log` VALUES (95, 1, 'mengubah data <a href=\'http://localhost/mig/news/detail/49\'>news</a>', 'update', '::1', '2019-05-13 14:57:27');
INSERT INTO `users_log` VALUES (96, 1, 'berhasil login', 'login', '::1', '2019-05-14 07:39:58');

SET FOREIGN_KEY_CHECKS = 1;
