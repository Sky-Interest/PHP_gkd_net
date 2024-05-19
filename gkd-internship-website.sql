/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MariaDB
 Source Server Version : 100432
 Source Host           : localhost:3306
 Source Schema         : gkd-internship-website

 Target Server Type    : MariaDB
 Target Server Version : 100432
 File Encoding         : 65001

 Date: 19/05/2024 17:20:12
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for listing
-- ----------------------------
DROP TABLE IF EXISTS `listing`;
CREATE TABLE `listing`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `salary` decimal(10, 2) NULL DEFAULT NULL,
  `tags` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `company` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `city` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `province` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `requirements` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `benefits` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  CONSTRAINT `listing_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of listing
-- ----------------------------
INSERT INTO `listing` VALUES (1, 1, '软件工程师', '你好', 80000.00, '开发, 编程', '广科技术有限公司', '科技园路1号', '广州', '广东', '020-123456', 'hr@gkdtech.com', '精通Java, 熟悉Spring框架', '五险一金, 弹性工作', '2024-05-16 13:41:00');
INSERT INTO `listing` VALUES (2, 2, '数据分析师', '通过分析数据支持业务决策。', 70000.00, '分析, 数据', '广数据科技', '科创中心88号', '广州', '广东', '020-654321', 'contact@datatech.com', '擅长使用SQL和Excel', '年终奖, 员工旅游', '2024-05-16 13:41:00');
INSERT INTO `listing` VALUES (3, 3, '市场营销实习生', '协助市场部门推广活动的策划和执行。', 30000.00, '市场, 营销', '广告公司', '市中心广场5号', '广州', '广东', '020-987654', 'marketing@gkdad.com', '具备良好的沟通能力', '地铁通勤便利, 周末双休', '2024-05-16 13:41:00');
INSERT INTO `listing` VALUES (4, 4, '产品管理实习生', '参与产品的日常管理和新功能规划。', 40000.00, '产品, 管理', '科技创新中心', '创业街2号', '深圳', '广东', '0755-123456', 'pm@gkdinnovation.com', '对互联网产品有深刻见解', '股票期权, 弹性工作时间', '2024-05-16 13:41:00');
INSERT INTO `listing` VALUES (5, 1, '人力资源助理', '负责员工招聘、入职培训等工作。', 50000.00, '人力资源, 行政', '广人企业', '人民北路20号', '广州', '广东', '020-112233', 'hr@gkdhr.com', '具有相关人力资源工作经验', '五险一金, 带薪年假', '2024-05-16 13:41:00');
INSERT INTO `listing` VALUES (6, 2, '财务分析师', '进行财务报表分析和财务预测。', 90000.00, '财务, 分析', '广财金融', '金融城中心', '广州', '广东', '020-332211', 'finance@gkdfinance.com', '精通财务分析软件', '年终双薪, 交通补贴', '2024-05-16 13:41:00');
INSERT INTO `listing` VALUES (7, 3, '网络安全实习生', '协助进行公司网络安全的检查和维护。', 35000.00, '网络安全, IT', '广安科技', '科技园北区', '深圳', '广东', '0755-445566', 'security@gkdsec.com', '了解常见的网络攻击方式', '技术培训, 团队建设活动', '2024-05-16 13:41:00');
INSERT INTO `listing` VALUES (8, 4, '用户界面设计师', '负责产品的用户界面设计。', 85000.00, '设计, 用户体验', '广创设计', '创新工业园', '广州', '广东', '020-556677', 'design@gkdcreative.com', '精通Photoshop和Sketch', '灵活工作环境, 年度旅游', '2024-05-16 13:41:00');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `city` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `province` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `email`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Alice Johnson', 'alice@example.com', 'password123', '广州', '广东', '2024-05-16 13:40:48');
INSERT INTO `users` VALUES (2, 'Bob Smith', 'bob@example.com', 'password123', '深圳', '广东', '2024-05-16 13:40:48');
INSERT INTO `users` VALUES (3, 'Carol White', 'carol@example.com', 'password123', '珠海', '广东', '2024-05-16 13:40:48');
INSERT INTO `users` VALUES (4, 'David Brown', 'david@example.com', 'password123', '东莞', '广东', '2024-05-16 13:40:48');
INSERT INTO `users` VALUES (5, 'TEST1', 'TEST1@gmail.com', '$2y$10$F03F9b9DJwn/Mv26T2SRf.WtOKZkoyeiS3AWtYTvVX43e1sLRgknG', 'TEST1', 'TEST1', '2024-05-19 04:38:01');
INSERT INTO `users` VALUES (6, '123', '123@gmail.com', '$2y$10$Fqqh2G4/h7lYNoLRb4Kr..ttauTzl3DjfWMHhohrqrX6WK2TKBRFi', '123', '123', '2024-05-19 05:18:09');

SET FOREIGN_KEY_CHECKS = 1;
