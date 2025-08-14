/*
 Navicat Premium Dump SQL

 Source Server         : superwin
 Source Server Type    : MySQL
 Source Server Version : 80043 (8.0.43)
 Source Host           : localhost:3306
 Source Schema         : superwin

 Target Server Type    : MySQL
 Target Server Version : 80043 (8.0.43)
 File Encoding         : 65001

 Date: 14/08/2025 18:51:57
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for banners
-- ----------------------------
DROP TABLE IF EXISTS `banners`;
CREATE TABLE `banners`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `mobile_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `type` enum('main_slider','promotion','category','brand') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `position` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `sort_order` int NULL DEFAULT 0,
  `is_active` tinyint(1) NULL DEFAULT 1,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `click_count` int NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_type`(`type` ASC) USING BTREE,
  INDEX `idx_active`(`is_active` ASC) USING BTREE,
  INDEX `idx_position`(`position` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of banners
-- ----------------------------
INSERT INTO `banners` VALUES (1, 'Banner Chính - SuperWin', '/image/baner1.png', '/image/baner1.png', '/products', 'main_slider', 'main', 1, 1, '2025-07-31 16:42:01', '2025-09-06 16:42:01', 0, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `banners` VALUES (2, 'Banner Khuyến Mãi', '/image/baner2.png', '/image/baner2.png', '/deals', 'main_slider', 'main', 2, 1, '2025-07-31 16:42:01', '2025-09-06 16:42:01', 0, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `banners` VALUES (3, 'Banner Sản Phẩm Mới', '/image/baner3.png', '/image/baner3.png', '/products?featured=1', 'main_slider', 'main', 3, 1, '2025-07-31 16:42:01', '2025-09-06 16:42:01', 0, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `banners` VALUES (4, 'Banner Quạt Công Nghiệp', '/image/quat.png', '/image/quat.png', '/category/quat-cong-nghiep', 'promotion', 'sidebar', 1, 1, '2025-08-07 16:42:01', '2025-08-22 16:42:01', 0, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `banners` VALUES (5, 'Banner Máy Bơm', '/image/bom.png', '/image/bom.png', '/category/may-bom-nuoc', 'promotion', 'sidebar', 2, 1, '2025-08-07 16:42:01', '2025-08-22 16:42:01', 0, '2025-08-07 16:42:01', '2025-08-07 16:42:01');

-- ----------------------------
-- Table structure for bom_chim_details
-- ----------------------------
DROP TABLE IF EXISTS `bom_chim_details`;
CREATE TABLE `bom_chim_details`  (
  `product_id` int NOT NULL,
  `cong_suat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `dien_ap` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `cot_ap` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `luu_luong` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `ong` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `dong_dien` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `max_depth` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `warranty_months` int NULL DEFAULT 12,
  PRIMARY KEY (`product_id`) USING BTREE,
  CONSTRAINT `bom_chim_details_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of bom_chim_details
-- ----------------------------
INSERT INTO `bom_chim_details` VALUES (2, '2HP (1500W)', '220V', '15m', '3500 L/h', 'Φ80mm', '7.2A', '15m', 18);

-- ----------------------------
-- Table structure for bom_details
-- ----------------------------
DROP TABLE IF EXISTS `bom_details`;
CREATE TABLE `bom_details`  (
  `product_id` int NOT NULL,
  `cong_suat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `hut_sau` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `cot_ap` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `luu_luong` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `ong` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `dien_ap` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `dong_dien` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `duong_kinh_day` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `warranty_months` int NULL DEFAULT 12,
  PRIMARY KEY (`product_id`) USING BTREE,
  CONSTRAINT `bom_details_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of bom_details
-- ----------------------------
INSERT INTO `bom_details` VALUES (1, '1HP (750W)', '8m', '35m', '2000 L/h', 'Φ50mm', '220V', '4.2A', 'Φ50mm', 24);
INSERT INTO `bom_details` VALUES (8, '1.5HP (1100W)', '6m', '28m', '2800 L/h', 'Φ65mm', '220V', '5.8A', 'Φ65mm', 18);
INSERT INTO `bom_details` VALUES (10, '1HP (750W)', '5m', '12m', '12000 L/h', 'Φ100mm', '220V', '4.0A', 'Φ100mm', 12);

-- ----------------------------
-- Table structure for bom_nhap_details
-- ----------------------------
DROP TABLE IF EXISTS `bom_nhap_details`;
CREATE TABLE `bom_nhap_details`  (
  `product_id` int NOT NULL,
  `cong_suat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `dien_ap` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `cot_ap` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `luu_luong` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `ong` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `origin_country` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `warranty_months` int NULL DEFAULT 12,
  PRIMARY KEY (`product_id`) USING BTREE,
  CONSTRAINT `bom_nhap_details_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of bom_nhap_details
-- ----------------------------

-- ----------------------------
-- Table structure for brands
-- ----------------------------
DROP TABLE IF EXISTS `brands`;
CREATE TABLE `brands`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `is_active` tinyint(1) NULL DEFAULT 1,
  `sort_order` int NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_name`(`name` ASC) USING BTREE,
  INDEX `idx_active`(`is_active` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of brands
-- ----------------------------
INSERT INTO `brands` VALUES (1, 'SuperWin', '/image/logo.png', 'Thương hiệu máy bơm nước và quạt công nghiệp hàng đầu Việt Nam', 1, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `brands` VALUES (2, 'Deton', '/image/logothc.png', 'Chuyên sản xuất quạt thông gió chất lượng cao', 1, 2, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `brands` VALUES (3, 'STHC', '/image/logothc.png', 'Công ty cổ phần Sài Gòn Thủ Đức', 1, 3, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `brands` VALUES (4, 'Vina Pump', '/image/logo.png', 'Máy bơm công nghiệp Việt Nam', 1, 4, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `brands` VALUES (5, 'ABC Motor', '/image/logo.png', 'Động cơ điện chuyên nghiệp', 1, 5, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `brands` VALUES (6, 'Inverter Fan', '/image/logo.png', 'Quạt biến tần cao cấp', 1, 6, '2025-08-07 16:42:01', '2025-08-07 16:42:01');

-- ----------------------------
-- Table structure for cache
-- ----------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cache
-- ----------------------------

-- ----------------------------
-- Table structure for cache_locks
-- ----------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cache_locks
-- ----------------------------

-- ----------------------------
-- Table structure for cart_items
-- ----------------------------
DROP TABLE IF EXISTS `cart_items`;
CREATE TABLE `cart_items`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `cart_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `price` decimal(10, 2) NULL DEFAULT NULL,
  `attributes` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `unique_cart_product`(`cart_id` ASC, `product_id` ASC) USING BTREE,
  INDEX `idx_cart_id`(`cart_id` ASC) USING BTREE,
  INDEX `idx_product_id`(`product_id` ASC) USING BTREE,
  CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`user_id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cart_items
-- ----------------------------
INSERT INTO `cart_items` VALUES (6, 3, 4, 1, '2025-08-13 17:52:27', '2025-08-13 17:52:27', 2900000.00, '[]');

-- ----------------------------
-- Table structure for carts
-- ----------------------------
DROP TABLE IF EXISTS `carts`;
CREATE TABLE `carts`  (
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`) USING BTREE,
  CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of carts
-- ----------------------------
INSERT INTO `carts` VALUES (3, '2025-08-12 12:20:48', '2025-08-12 12:20:48');

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `parent_id` int NULL DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `sort_order` int NULL DEFAULT 0,
  `is_active` tinyint(1) NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_parent_id`(`parent_id` ASC) USING BTREE,
  INDEX `idx_active`(`is_active` ASC) USING BTREE,
  CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES (1, 'Máy bơm nước', NULL, '/image/bom.png', 'Máy bơm nước các loại', 1, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `categories` VALUES (2, 'Quạt công nghiệp', NULL, '/image/quat.png', 'Quạt thông gió công nghiệp', 2, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `categories` VALUES (3, 'Động cơ điện', NULL, '/image/quat.png', 'Động cơ điện công nghiệp', 3, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `categories` VALUES (4, 'Máy bơm chìm', NULL, '/image/bom_chim.png', 'Máy bơm chìm nước thải', 4, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `categories` VALUES (5, 'Quạt tròn', NULL, '/image/quat_tron.png', 'Quạt tròn thông gió', 5, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `categories` VALUES (6, 'Máy bơm nước biển', 1, '/image/bom.png', 'Máy bơm nước biển chống ăn mòn', 1, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `categories` VALUES (7, 'Máy bơm hồ bơi', 1, '/image/bom.png', 'Máy bơm dành cho hồ bơi', 2, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `categories` VALUES (8, 'Máy bơm nhập khẩu', 1, '/image/bom.png', 'Máy bơm nhập khẩu chất lượng cao', 3, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `categories` VALUES (9, 'Quạt thông gió vuông SuperWin', 2, '/image/quat_vuong.png', 'Quạt thông gió vuông thương hiệu SuperWin', 1, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `categories` VALUES (10, 'Quạt thông gió vuông Deton', 2, '/image/quat_vuong.png', 'Quạt thông gió vuông thương hiệu Deton', 2, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `categories` VALUES (11, 'Quạt thông gió tròn', 2, '/image/quat_tron.png', 'Quạt thông gió hình tròn', 3, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `categories` VALUES (12, 'Quạt hướng trục nối ống', 2, '/image/quat.png', 'Quạt hướng trục nối ống thông gió', 4, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `categories` VALUES (13, 'Quạt sàn công nghiệp', 2, '/image/quat.png', 'Quạt sàn công nghiệp di động', 5, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `categories` VALUES (14, 'Quạt trần công nghiệp', 2, '/image/quat_tran.png', 'Quạt trần công nghiệp', 6, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `categories` VALUES (15, 'Quạt chống cháy nổ', 2, '/image/quat.png', 'Quạt chống cháy nổ an toàn', 7, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');

-- ----------------------------
-- Table structure for coupon_usage
-- ----------------------------
DROP TABLE IF EXISTS `coupon_usage`;
CREATE TABLE `coupon_usage`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `coupon_id` int NOT NULL,
  `user_id` int NOT NULL,
  `order_id` int NOT NULL,
  `discount_amount` decimal(10, 2) NOT NULL,
  `used_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `unique_user_coupon_order`(`user_id` ASC, `coupon_id` ASC, `order_id` ASC) USING BTREE,
  INDEX `order_id`(`order_id` ASC) USING BTREE,
  INDEX `idx_coupon_id`(`coupon_id` ASC) USING BTREE,
  INDEX `idx_user_id`(`user_id` ASC) USING BTREE,
  CONSTRAINT `coupon_usage_ibfk_1` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `coupon_usage_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `coupon_usage_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of coupon_usage
-- ----------------------------

-- ----------------------------
-- Table structure for coupons
-- ----------------------------
DROP TABLE IF EXISTS `coupons`;
CREATE TABLE `coupons`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `type` enum('percentage','fixed_amount','free_shipping') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `value` decimal(10, 2) NOT NULL,
  `minimum_amount` decimal(10, 2) NULL DEFAULT 0.00,
  `maximum_discount` decimal(10, 2) NULL DEFAULT NULL,
  `usage_limit` int NULL DEFAULT NULL,
  `used_count` int NULL DEFAULT 0,
  `user_limit` int NULL DEFAULT 1,
  `start_date` timestamp NOT NULL,
  `end_date` timestamp NOT NULL,
  `is_active` tinyint(1) NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `code`(`code` ASC) USING BTREE,
  INDEX `idx_code`(`code` ASC) USING BTREE,
  INDEX `idx_active`(`is_active` ASC) USING BTREE,
  INDEX `idx_dates`(`start_date` ASC, `end_date` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of coupons
-- ----------------------------

-- ----------------------------
-- Table structure for customers
-- ----------------------------
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers`  (
  `id` int NOT NULL DEFAULT 0,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `google_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `facebook_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `date_of_birth` date NULL DEFAULT NULL,
  `gender` enum('male','female','other') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `city` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `district` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `ward` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `email_verified_at` datetime NULL DEFAULT NULL,
  `phone_verified_at` datetime NULL DEFAULT NULL,
  `status` enum('active','inactive','banned') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT 'active',
  `customer_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `total_spent` decimal(15, 2) NULL DEFAULT 0.00,
  `loyalty_points` int NULL DEFAULT 0,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE INDEX `customer_code`(`customer_code` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of customers
-- ----------------------------
INSERT INTO `customers` VALUES (1, 'Khách Hàng Test 1', 'customer1@test.com', '0901234567', '$2y$2y$12$3c.coPJRBdWek1ZBA7OoiO0NKr2TL4Z8uca97myZdLdZDICwiYMI.', NULL, NULL, NULL, NULL, NULL, '123 Nguyễn Văn Cừ', 'TP.HCM', 'Quận 5', 'Phường 1', NULL, NULL, 'active', 'KH0001', 5500000.00, 550, NULL, NULL, '2025-08-07 16:42:01', '2025-08-08 05:12:21');
INSERT INTO `customers` VALUES (2, 'Khách Hàng Test 2', 'customer2@gmail.com', '0902345678', '$2y$12$LGHcF.VjWKKvhN4fF4rZneTQJnHU6bBZ1VsKHJCxEF9M5IZzFsFfS', NULL, NULL, NULL, NULL, NULL, '456 Lê Văn Sỹ', 'TP.HCM', 'Quận 3', 'Phường 12', NULL, NULL, 'active', 'KH0002', 2200000.00, 220, NULL, NULL, '2025-08-07 16:42:01', '2025-08-08 05:24:19');
INSERT INTO `customers` VALUES (3, 'Nhat Dan', 'dantran2910@gmail.com', '0915217471', '$2y$12$NedmOeMfZ.fn2O6/c6PGu.natVX2005xIpL5Um7oSjGuMXRxUoftO', NULL, NULL, NULL, NULL, NULL, '433 nguyễn oanh', 'Phường Gò Vấp', 'gò vấp', 'phường 17', NULL, NULL, 'active', 'CUS003', 0.00, 0, NULL, 'y4OD8k3YxNw4bh6mqYj6j5WSHIGDdxOyx6DgrbrsLVoHZVkDG7RF3iG7yNOD', '2025-08-08 05:25:53', '2025-08-14 08:56:27');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for flash_deals
-- ----------------------------
DROP TABLE IF EXISTS `flash_deals`;
CREATE TABLE `flash_deals`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `discount_type` enum('percentage','fixed_amount') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT 'percentage',
  `discount_value` decimal(10, 2) NOT NULL,
  `original_price` decimal(10, 2) NOT NULL,
  `sale_price` decimal(10, 2) NOT NULL,
  `quantity_limit` int NULL DEFAULT NULL,
  `sold_quantity` int NULL DEFAULT 0,
  `start_time` timestamp NOT NULL,
  `end_time` timestamp NOT NULL,
  `is_active` tinyint(1) NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_product_id`(`product_id` ASC) USING BTREE,
  INDEX `idx_active`(`is_active` ASC) USING BTREE,
  INDEX `idx_time_range`(`start_time` ASC, `end_time` ASC) USING BTREE,
  CONSTRAINT `flash_deals_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of flash_deals
-- ----------------------------
INSERT INTO `flash_deals` VALUES (1, 1, 'Flash Deal - Máy bơm SuperWin SW-100', 'percentage', 12.00, 2500000.00, 2200000.00, 50, 12, '2025-08-05 16:42:01', '2025-08-12 16:42:01', 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `flash_deals` VALUES (2, 2, 'Giảm giá sốc - Máy bơm chìm VP-200', 'fixed_amount', 400000.00, 4200000.00, 3800000.00, 30, 8, '2025-08-06 16:42:01', '2025-08-14 16:42:01', 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `flash_deals` VALUES (3, 3, 'Hot Deal - Quạt thông gió SWF-300', 'percentage', 11.11, 1800000.00, 1600000.00, 25, 18, '2025-08-07 16:42:01', '2025-08-10 16:42:01', 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');

-- ----------------------------
-- Table structure for hot_search_items
-- ----------------------------
DROP TABLE IF EXISTS `hot_search_items`;
CREATE TABLE `hot_search_items`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `hot_search_id` bigint UNSIGNED NOT NULL COMMENT 'ID của hot search',
  `item_type` enum('product','brand','category') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Loại item',
  `item_id` bigint UNSIGNED NOT NULL COMMENT 'ID của item (product_id, brand_id, category_id)',
  `sort_order` int NOT NULL DEFAULT 0 COMMENT 'Thứ tự sắp xếp trong group',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_hot_search_id`(`hot_search_id` ASC) USING BTREE,
  INDEX `idx_item_type`(`item_type` ASC) USING BTREE,
  INDEX `idx_item_id`(`item_id` ASC) USING BTREE,
  INDEX `idx_sort_order`(`sort_order` ASC) USING BTREE,
  CONSTRAINT `hot_search_items_ibfk_1` FOREIGN KEY (`hot_search_id`) REFERENCES `hot_searches` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = 'Bảng lưu các items của hot search' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of hot_search_items
-- ----------------------------

-- ----------------------------
-- Table structure for hot_searches
-- ----------------------------
DROP TABLE IF EXISTS `hot_searches`;
CREATE TABLE `hot_searches`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` enum('product','keyword','brand','category') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Loại hot search: product, keyword, brand, category',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tiêu đề hiển thị',
  `keyword` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Từ khóa search (chỉ dùng với type=keyword)',
  `image_url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'URL hình ảnh (tùy chọn)',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT 'Mô tả ngắn',
  `sort_order` int NOT NULL DEFAULT 0 COMMENT 'Thứ tự sắp xếp',
  `max_items` int NOT NULL DEFAULT 5 COMMENT 'Số lượng items tối đa hiển thị',
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Trạng thái kích hoạt',
  `click_count` bigint UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Số lượt click',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_type`(`type` ASC) USING BTREE,
  INDEX `idx_is_active`(`is_active` ASC) USING BTREE,
  INDEX `idx_sort_order`(`sort_order` ASC) USING BTREE,
  INDEX `idx_click_count`(`click_count` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = 'Bảng quản lý hot search items' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of hot_searches
-- ----------------------------
INSERT INTO `hot_searches` VALUES (5, 'keyword', 'Quạt trần cao cấp', 'quạt trần cao cấp', NULL, 'Từ khóa hot về quạt trần', 1, 5, 1, 0, '2025-08-13 15:00:44', '2025-08-13 15:00:44');
INSERT INTO `hot_searches` VALUES (6, 'keyword', 'Bơm nước thông minh', 'bơm nước thông minh', NULL, 'Từ khóa hot về bơm nước', 2, 5, 1, 0, '2025-08-13 15:00:44', '2025-08-13 15:00:44');
INSERT INTO `hot_searches` VALUES (7, 'keyword', 'Ống nhựa PVC', 'ống nhựa pvc', NULL, 'Từ khóa hot về ống nhựa', 3, 5, 1, 0, '2025-08-13 15:00:44', '2025-08-13 15:00:44');
INSERT INTO `hot_searches` VALUES (8, 'product', 'Sản phẩm nổi bật', NULL, NULL, 'Các sản phẩm được đề xuất', 4, 8, 1, 0, '2025-08-13 15:00:44', '2025-08-13 15:00:44');
INSERT INTO `hot_searches` VALUES (9, 'brand', 'Thương hiệu uy tín', NULL, NULL, 'Các thương hiệu đáng tin cậy', 5, 6, 1, 0, '2025-08-13 15:00:44', '2025-08-13 15:00:44');
INSERT INTO `hot_searches` VALUES (10, 'category', 'Danh mục phổ biến', NULL, NULL, 'Các danh mục được quan tâm nhất', 6, 5, 1, 0, '2025-08-13 15:00:44', '2025-08-13 15:00:44');

-- ----------------------------
-- Table structure for job_batches
-- ----------------------------
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `cancelled_at` int NULL DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of job_batches
-- ----------------------------

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED NULL DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `jobs_queue_index`(`queue` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of jobs
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of migrations
-- ----------------------------

-- ----------------------------
-- Table structure for motor_details
-- ----------------------------
DROP TABLE IF EXISTS `motor_details`;
CREATE TABLE `motor_details`  (
  `product_id` int NOT NULL,
  `cong_suat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `dien_ap` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `toc_do` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `loai_dong_co` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `hieu_suat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `warranty_months` int NULL DEFAULT 12,
  PRIMARY KEY (`product_id`) USING BTREE,
  CONSTRAINT `motor_details_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of motor_details
-- ----------------------------
INSERT INTO `motor_details` VALUES (6, '3HP (2200W)', '380V/3 Phase', '1450 rpm', 'Induction Motor', '87%', 12);

-- ----------------------------
-- Table structure for notifications
-- ----------------------------
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NULL DEFAULT NULL,
  `type` enum('order','promotion','system','review') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `action_url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `order_id` int NULL DEFAULT NULL,
  `is_read` tinyint(1) NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `read_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `order_id`(`order_id` ASC) USING BTREE,
  INDEX `idx_user_id`(`user_id` ASC) USING BTREE,
  INDEX `idx_type`(`type` ASC) USING BTREE,
  INDEX `idx_read`(`is_read` ASC) USING BTREE,
  INDEX `idx_created_at`(`created_at` ASC) USING BTREE,
  CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of notifications
-- ----------------------------

-- ----------------------------
-- Table structure for order_details
-- ----------------------------
DROP TABLE IF EXISTS `order_details`;
CREATE TABLE `order_details`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `product_sku` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `quantity` int NOT NULL,
  `unit_price` decimal(10, 2) NOT NULL,
  `total_price` decimal(10, 2) NOT NULL,
  `created_at` date NULL DEFAULT NULL,
  `updated_at` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_order_id`(`order_id` ASC) USING BTREE,
  INDEX `idx_product_id`(`product_id` ASC) USING BTREE,
  CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of order_details
-- ----------------------------
INSERT INTO `order_details` VALUES (15, 24, 8, 'Máy bơm nước biển SuperWin SWM-150', 'SPSWBM0008', 4, 3400000.00, 13600000.00, '2025-08-12', '2025-08-12');
INSERT INTO `order_details` VALUES (16, 25, 1, 'Máy bơm nước SuperWin SW-500', 'SPSWBM0001', 1, 3000000.00, 3000000.00, '2025-08-13', '2025-08-13');
INSERT INTO `order_details` VALUES (17, 26, 1, 'Máy bơm nước SuperWin SW-700', 'SPSWBM0001', 1, 3500000.00, 3500000.00, '2025-08-13', '2025-08-13');
INSERT INTO `order_details` VALUES (18, 27, 4, 'Quạt trần công nghiệp Deton DT-1400', 'SPDTQT0004', 1, 2900000.00, 2900000.00, '2025-08-13', '2025-08-13');
INSERT INTO `order_details` VALUES (19, 28, 8, 'Máy bơm nước biển SuperWin SWM-150', 'SPSWBM0008', 1, 3400000.00, 3400000.00, '2025-08-14', '2025-08-14');

-- ----------------------------
-- Table structure for order_tracking
-- ----------------------------
DROP TABLE IF EXISTS `order_tracking`;
CREATE TABLE `order_tracking`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `created_by` int NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `created_by`(`created_by` ASC) USING BTREE,
  INDEX `idx_order_id`(`order_id` ASC) USING BTREE,
  INDEX `idx_status`(`status` ASC) USING BTREE,
  INDEX `idx_created_at`(`created_at` ASC) USING BTREE,
  CONSTRAINT `order_tracking_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `order_tracking_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of order_tracking
-- ----------------------------

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NULL DEFAULT NULL,
  `order_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `customer_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `customer_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `customer_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `shipping_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `shipping_city` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `shipping_district` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `shipping_ward` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `payment_method` enum('cod','bank_transfer','momo','zalopay','vnpay') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `shipping_method` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT 'standard',
  `shipping_fee` decimal(10, 2) NULL DEFAULT 0.00,
  `discount_amount` decimal(10, 2) NULL DEFAULT 0.00,
  `tax_amount` decimal(10, 2) NULL DEFAULT 0.00,
  `subtotal` decimal(10, 2) NOT NULL,
  `total_amount` decimal(10, 2) NOT NULL,
  `status` enum('pending','confirmed','processing','shipped','delivered','cancelled','returned') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT 'pending',
  `cancel_reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `customer_note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `admin_note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `estimated_delivery_date` date NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `final_amount` decimal(10, 2) NULL DEFAULT 0.00,
  `payment_status` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `shipping_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `shipping_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `order_code`(`order_code` ASC) USING BTREE,
  INDEX `idx_user_id`(`user_id` ASC) USING BTREE,
  INDEX `idx_order_code`(`order_code` ASC) USING BTREE,
  INDEX `idx_status`(`status` ASC) USING BTREE,
  INDEX `idx_created_at`(`created_at` ASC) USING BTREE,
  INDEX `idx_phone`(`customer_phone` ASC) USING BTREE,
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 29 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES (24, NULL, 'SW250812BL8T', 'Nhat Dan', '0915217471', 'dantran2910@gmail.com', '433 nguyễn oanh', 'Phường Gò Vấp', 'gò vấp', 'phường 17', 'cod', 'standard', 30000.00, 50000.00, 1088000.00, 13600000.00, 14668000.00, 'pending', NULL, NULL, NULL, '2025-08-15', NULL, NULL, '2025-08-12 12:20:47', '2025-08-12 12:20:47', 0.00, NULL, NULL, NULL);
INSERT INTO `orders` VALUES (25, NULL, 'SW250813YQJ5', 'Nhat Dan', '0915217471', 'dantran2910@gmail.com', '433 nguyễn oanh', 'Phường Gò Vấp', 'gò vấp', 'phường 17', 'cod', 'standard', 30000.00, 50000.00, 240000.00, 3000000.00, 3220000.00, 'pending', NULL, NULL, NULL, '2025-08-16', NULL, NULL, '2025-08-13 14:45:09', '2025-08-13 14:45:09', 0.00, NULL, NULL, NULL);
INSERT INTO `orders` VALUES (26, NULL, 'SW2508139ZBX', 'Nhat Dan', '0915217471', 'dantran2910@gmail.com', '433 nguyễn oanh', 'Phường Gò Vấp', 'gò vấp', 'phường 17', 'cod', 'standard', 30000.00, 50000.00, 280000.00, 3500000.00, 3760000.00, 'cancelled', 'Khách hàng hủy đơn', NULL, NULL, '2025-08-16', NULL, '2025-08-13 14:50:26', '2025-08-13 14:49:55', '2025-08-13 14:50:26', 0.00, NULL, NULL, NULL);
INSERT INTO `orders` VALUES (27, NULL, 'SW250813TJJB', 'Nhat Dan', '0915217471', 'dantran2910@gmail.com', '433 nguyễn oanh', 'Phường Gò Vấp', 'gò vấp', 'phường 17', 'cod', 'standard', 30000.00, 50000.00, 232000.00, 2900000.00, 3112000.00, 'pending', NULL, NULL, NULL, '2025-08-16', NULL, NULL, '2025-08-13 17:52:27', '2025-08-13 17:52:27', 0.00, NULL, NULL, NULL);
INSERT INTO `orders` VALUES (28, NULL, 'SW250814QAGC', 'Nhat Dan', '0915217471', 'dantran2910@gmail.com', '433 nguyễn oanh', 'Phường Gò Vấp', 'gò vấp', 'phường 17', 'cod', 'standard', 30000.00, 50000.00, 272000.00, 3400000.00, 3652000.00, 'pending', NULL, NULL, NULL, '2025-08-17', NULL, NULL, '2025-08-14 08:56:27', '2025-08-14 08:56:27', 0.00, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for payments
-- ----------------------------
DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `payment_method` enum('cod','bank_transfer','momo','zalopay','vnpay') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `transaction_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `amount` decimal(10, 2) NOT NULL,
  `status` enum('pending','processing','completed','failed','cancelled','refunded') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT 'pending',
  `gateway_response` json NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_order_id`(`order_id` ASC) USING BTREE,
  INDEX `idx_status`(`status` ASC) USING BTREE,
  INDEX `idx_transaction_id`(`transaction_id` ASC) USING BTREE,
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of payments
-- ----------------------------

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `module` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `name`(`name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 27 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of permissions
-- ----------------------------

-- ----------------------------
-- Table structure for product_attributes
-- ----------------------------
DROP TABLE IF EXISTS `product_attributes`;
CREATE TABLE `product_attributes`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` int UNSIGNED NOT NULL,
  `attribute_key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute_value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `attribute_unit` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `attribute_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  `is_visible` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 29 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of product_attributes
-- ----------------------------
INSERT INTO `product_attributes` VALUES (6, 2, 'material', 'Stainless Steel', NULL, 'Chất liệu vỏ máy', 1, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `product_attributes` VALUES (7, 2, 'cable_length', '10', 'm', 'Chiều dài cáp điện', 2, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `product_attributes` VALUES (8, 2, 'float_switch', 'Có', NULL, 'Phao tự động', 3, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `product_attributes` VALUES (9, 2, 'particle_size', '35', 'mm', 'Kích thước hạt tối đa', 4, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `product_attributes` VALUES (10, 3, 'blade_material', 'Aluminum', NULL, 'Chất liệu cánh quạt', 1, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `product_attributes` VALUES (11, 3, 'housing_material', 'Galvanized Steel', NULL, 'Chất liệu vỏ quạt', 2, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `product_attributes` VALUES (12, 3, 'speed_control', 'Single Speed', NULL, 'Điều khiển tốc độ', 3, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `product_attributes` VALUES (13, 3, 'mounting_type', 'Wall/Window', NULL, 'Kiểu lắp đặt', 4, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `product_attributes` VALUES (24, 1, 'material', 'Cast Iron', NULL, 'Chất liệu vỏ máy', 1, 1, '2025-08-13 11:57:49', '2025-08-13 11:57:49');
INSERT INTO `product_attributes` VALUES (25, 1, 'inlet_size', '50', 'mm', 'Đường kính đầu hút', 2, 1, '2025-08-13 11:57:49', '2025-08-13 11:57:49');
INSERT INTO `product_attributes` VALUES (26, 1, 'outlet_size', '40', 'mm', 'Đường kính đầu đẩy', 3, 1, '2025-08-13 11:57:49', '2025-08-13 11:57:49');
INSERT INTO `product_attributes` VALUES (27, 1, 'weight', '25.5', 'kg', 'Trọng lượng', 4, 1, '2025-08-13 11:57:49', '2025-08-13 11:57:49');
INSERT INTO `product_attributes` VALUES (28, 1, 'protection_class', 'IP55', NULL, 'Cấp độ bảo vệ', 5, 1, '2025-08-13 11:57:49', '2025-08-13 11:57:49');

-- ----------------------------
-- Table structure for product_images
-- ----------------------------
DROP TABLE IF EXISTS `product_images`;
CREATE TABLE `product_images`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `alt_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `sort_order` int NULL DEFAULT 0,
  `is_primary` tinyint(1) NULL DEFAULT 0,
  `is_base` tinyint(1) NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_product_id`(`product_id` ASC) USING BTREE,
  INDEX `idx_primary`(`is_primary` ASC) USING BTREE,
  INDEX `idx_is_base`(`is_base` ASC) USING BTREE,
  CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of product_images
-- ----------------------------
INSERT INTO `product_images` VALUES (1, 1, '/image/sp1.png', 'Máy bơm nước SuperWin SW-100', 1, 1, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `product_images` VALUES (2, 1, '/image/bom.png', 'Máy bơm nước SuperWin SW-100 - Góc cạnh', 2, 0, 0, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `product_images` VALUES (3, 2, '/image/bom_chim.png', 'Máy bơm chìm Vina Pump VP-200', 1, 1, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `product_images` VALUES (4, 2, '/image/sp1.png', 'Máy bơm chìm Vina Pump VP-200 - Chi tiết', 2, 0, 0, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `product_images` VALUES (5, 3, '/image/quat_vuong.png', 'Quạt thông gió vuông SuperWin SWF-300', 1, 1, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `product_images` VALUES (6, 3, '/image/quat.png', 'Quạt thông gió vuông SuperWin SWF-300 - Mặt nghiêng', 2, 0, 0, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `product_images` VALUES (7, 4, '/image/quat_tran.png', 'Quạt trần công nghiệp Deton DT-1400', 1, 1, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `product_images` VALUES (8, 5, '/image/quat.png', 'Quạt hướng trục STHC ST-400', 1, 1, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `product_images` VALUES (9, 6, '/image/sp1.png', 'Động cơ điện ABC 3HP', 1, 1, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `product_images` VALUES (10, 7, '/image/quat_tron.png', 'Quạt tròn Inverter Fan IF-250', 1, 1, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `product_images` VALUES (11, 8, '/image/bom.png', 'Máy bơm nước biển SuperWin SWM-150', 1, 1, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `product_images` VALUES (12, 9, '/image/quat.png', 'Quạt chống cháy nổ SuperWin EX-400', 1, 1, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `product_images` VALUES (13, 10, '/image/bom.png', 'Máy bơm hồ bơi Vina Pump VP-POOL', 1, 1, 1, '2025-08-07 16:42:01', '2025-08-07 16:42:01');

-- ----------------------------
-- Table structure for product_variants
-- ----------------------------
DROP TABLE IF EXISTS `product_variants`;
CREATE TABLE `product_variants`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Tên hiển thị variant (VD: Máy bơm nhật)',
  `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Mã variant do user nhập (VD: MBN1)',
  `quantity` int NOT NULL DEFAULT 0 COMMENT 'Số lượng tồn kho',
  `price` decimal(10, 2) NOT NULL COMMENT 'Giá gốc',
  `price_sale` decimal(10, 2) NULL DEFAULT NULL COMMENT 'Giá khuyến mãi',
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Trạng thái hoạt động',
  `sort_order` int NOT NULL DEFAULT 0 COMMENT 'Thứ tự sắp xếp',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `unique_product_code`(`product_id` ASC, `code` ASC) USING BTREE,
  INDEX `idx_product_id`(`product_id` ASC) USING BTREE,
  INDEX `idx_active`(`is_active` ASC) USING BTREE,
  INDEX `idx_code`(`code` ASC) USING BTREE,
  CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci COMMENT = 'Bảng quản lý các biến thể sản phẩm đơn giản (tên, mã, giá, số lượng)' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of product_variants
-- ----------------------------
INSERT INTO `product_variants` VALUES (1, 1, 'Máy bơm nước SuperWin SW-500', 'SW-500', 100, 3000000.00, NULL, 1, 0, '2025-08-13 11:55:43', '2025-08-13 11:55:43');
INSERT INTO `product_variants` VALUES (2, 1, 'Máy bơm nước SuperWin SW-700', 'SW-700', 200, 3500000.00, NULL, 1, 1, '2025-08-13 11:57:02', '2025-08-13 11:57:02');
INSERT INTO `product_variants` VALUES (3, 1, 'Máy bơm nước SuperWin SW-1000', 'SW-1000', 100, 4000000.00, NULL, 1, 2, '2025-08-13 11:57:49', '2025-08-13 11:57:49');

-- ----------------------------
-- Table structure for product_views
-- ----------------------------
DROP TABLE IF EXISTS `product_views`;
CREATE TABLE `product_views`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NULL DEFAULT NULL,
  `product_id` int NOT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_user_id`(`user_id` ASC) USING BTREE,
  INDEX `idx_product_id`(`product_id` ASC) USING BTREE,
  INDEX `idx_created_at`(`created_at` ASC) USING BTREE,
  CONSTRAINT `product_views_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `product_views_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of product_views
-- ----------------------------

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `category_id` int NOT NULL,
  `brand_id` int NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `short_description` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `price` decimal(10, 2) NOT NULL,
  `sale_price` decimal(10, 2) NULL DEFAULT NULL,
  `sku` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `stock_quantity` int NULL DEFAULT 0,
  `min_stock_level` int NULL DEFAULT 5,
  `weight` decimal(8, 3) NULL DEFAULT NULL,
  `status` tinyint(1) NULL DEFAULT 1,
  `is_featured` tinyint(1) NULL DEFAULT 0,
  `is_sale` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Sản phẩm có khuyến mãi',
  `view_count` int NULL DEFAULT 0,
  `sold_count` int NULL DEFAULT 0,
  `rating_average` decimal(2, 1) NULL DEFAULT 0.0,
  `rating_count` int NULL DEFAULT 0,
  `meta_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `meta_keywords` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `meta_robots` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT 'index,follow',
  `meta_author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `meta_canonical_url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `power` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `voltage` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `flow_rate` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `pressure` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `efficiency` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `noise_level` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `warranty_period` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `slug`(`slug` ASC) USING BTREE,
  UNIQUE INDEX `sku`(`sku` ASC) USING BTREE,
  INDEX `idx_category_id`(`category_id` ASC) USING BTREE,
  INDEX `idx_brand_id`(`brand_id` ASC) USING BTREE,
  INDEX `idx_status`(`status` ASC) USING BTREE,
  INDEX `idx_featured`(`is_featured` ASC) USING BTREE,
  INDEX `idx_price`(`price` ASC) USING BTREE,
  INDEX `idx_rating`(`rating_average` ASC) USING BTREE,
  INDEX `idx_name`(`name` ASC) USING BTREE,
  INDEX `idx_slug`(`slug` ASC) USING BTREE,
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `products_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES (1, 'Máy bơm nước SuperWin SW-100', 'may-bom-nuoc-superwin-sw-100', 1, 1, 'Máy bơm nước SuperWin SW-100 là sản phẩm chất lượng cao, được thiết kế để bơm nước hiệu quả với công suất mạnh mẽ. Sản phẩm có khả năng chống ăn mòn tốt, độ bền cao và vận hành êm ái. Thích hợp sử dụng cho các hệ thống cấp nước sinh hoạt, công nghiệp và nông nghiệp.', 'Máy bơm nước SuperWin SW-100 công suất 1HP, lưu lượng 2000L/h', 2500000.00, 2200000.00, 'SPSWBM0001', 50, 5, 25.500, 1, 1, 1, 178, 12, 4.5, 8, 'Máy bơm nước SuperWin SW-100 - Chất lượng cao, giá tốt', 'Mua máy bơm nước SuperWin SW-100 chính hãng với giá ưu đãi. Bảo hành 24 tháng, giao hàng toàn quốc', 'máy bơm nước, superwin, sw-100, bơm nước công nghiệp', 'index,follow', 'SuperWin', 'https://superwin.com/products/may-bom-nuoc-superwin-sw-100', '1HP (750W)', '220V/1 Phase', '2000 L/h', '35m', '85%', '≤55dB', '24 tháng', '2025-08-07 16:42:01', '2025-08-13 18:27:29');
INSERT INTO `products` VALUES (2, 'Máy bơm chìm Vina Pump VP-200', 'may-bom-chim-vina-pump-vp-200', 4, 4, 'Máy bơm chìm Vina Pump VP-200 chuyên dụng cho việc bơm nước thải, nước ngầm và các ứng dụng công nghiệp. Thiết kế compact, dễ lắp đặt và bảo trì. Motor được bảo vệ hoàn toàn bằng dầu mineral cao cấp.', 'Máy bơm chìm VP-200 công suất 2HP, độ sâu tối đa 15m', 4200000.00, 3800000.00, 'SPVPBC0002', 30, 3, 18.200, 1, 1, 1, 90, 8, 4.3, 5, 'Máy bơm chìm Vina Pump VP-200 - Bơm nước thải hiệu quả', 'Máy bơm chìm Vina Pump VP-200 chất lượng cao, phù hợp bơm nước thải, nước ngầm. Bảo hành chính hãng 18 tháng', 'máy bơm chìm, vina pump, vp-200, bơm nước thải, bơm nước ngầm', 'index,follow', 'SuperWin', 'https://superwin.com/products/may-bom-chim-vina-pump-vp-200', '2HP (1500W)', '220V/1 Phase', '3500 L/h', '15m', '82%', '≤60dB', '18 tháng', '2025-08-07 16:42:01', '2025-08-08 13:56:50');
INSERT INTO `products` VALUES (3, 'Quạt thông gió vuông SuperWin SWF-300', 'quat-thong-gio-vuong-superwin-swf-300', 9, 1, 'Quạt thông gió vuông SuperWin SWF-300 với thiết kế hiện đại, lưu lượng gió lớn và tiết kiệm điện năng. Thích hợp lắp đặt cho nhà xưởng, nhà kho, văn phòng. Cánh quạt được thiết kế khí động học tối ưu.', 'Quạt thông gió vuông SWF-300, kích thước 300x300mm', 1800000.00, 1600000.00, 'SPSWQT0003', 25, 5, 8.500, 1, 1, 1, 205, 18, 4.7, 12, 'Quạt thông gió vuông SuperWin SWF-300 - Lưu lượng gió lớn', 'Quạt thông gió vuông SuperWin SWF-300 chính hãng, lưu lượng gió 3200m³/h, tiết kiệm điện. Bảo hành 12 tháng', 'quạt thông gió, superwin, swf-300, quạt vuông, thông gió nhà xưởng', 'index,follow', 'SuperWin', 'https://superwin.com/products/quat-thong-gio-vuong-superwin-swf-300', '120W', '220V/1 Phase', '3200 m³/h', '45 Pa', '78%', '≤52dB', '12 tháng', '2025-08-07 16:42:01', '2025-08-13 15:01:19');
INSERT INTO `products` VALUES (4, 'Quạt trần công nghiệp Deton DT-1400', 'quat-tran-cong-nghiep-deton-dt-1400', 14, 2, 'Quạt trần công nghiệp Deton DT-1400 với đường kính cánh quạt 1400mm, phù hợp cho không gian lớn. Thiết kế chắc chắn, vận hành êm ái và tiết kiệm điện năng. Motor chất lượng cao đảm bảo độ bền lâu dài.', 'Quạt trần công nghiệp DT-1400, đường kính 1400mm', 3200000.00, 2900000.00, 'SPDTQT0004', 15, 3, 12.800, 1, 0, 1, 135, 6, 4.2, 4, 'Quạt trần công nghiệp Deton DT-1400 - Phù hợp không gian lớn', 'Quạt trần công nghiệp Deton DT-1400 đường kính 1400mm, lưu lượng gió 28000m³/h, tiết kiệm điện năng', 'quạt trần công nghiệp, deton, dt-1400, quạt trần, thông gió công nghiệp', 'index,follow', 'SuperWin', 'https://superwin.com/products/quat-tran-cong-nghiep-deton-dt-1400', '200W', '220V/1 Phase', '28000 m³/h', '65 Pa', '85%', '≤48dB', '18 tháng', '2025-08-07 16:42:01', '2025-08-13 15:06:01');
INSERT INTO `products` VALUES (5, 'Quạt hướng trục STHC ST-400', 'quat-huong-truc-sthc-st-400', 12, 3, 'Quạt hướng trục STHC ST-400 chuyên dụng cho hệ thống ống gió. Thiết kế compact, lắp đặt dễ dàng. Cánh quạt được thiết kế tối ưu để tạo áp suất cao, phù hợp cho các hệ thống thông gió dài.', 'Quạt hướng trục ST-400, kết nối ống gió φ400mm', 2200000.00, NULL, 'SPSTHC0005', 40, 5, 6.200, 1, 1, 0, 101, 15, 4.4, 7, 'Quạt hướng trục STHC ST-400 - Chuyên dụng ống gió', 'Quạt hướng trục STHC ST-400 kết nối ống gió φ400mm, áp suất cao, phù hợp hệ thống thông gió dài', 'quạt hướng trục, sthc, st-400, quạt ống gió, thông gió ống dài', 'index,follow', 'SuperWin', 'https://superwin.com/products/quat-huong-truc-sthc-st-400', '150W', '220V/1 Phase', '2800 m³/h', '180 Pa', '72%', '≤58dB', '12 tháng', '2025-08-07 16:42:01', '2025-08-14 11:47:16');
INSERT INTO `products` VALUES (6, 'Động cơ điện ABC 3HP', 'dong-co-dien-abc-3hp', 3, 5, 'Động cơ điện ABC 3HP với công nghệ tiên tiến, hiệu suất cao và độ bền vượt trội. Thích hợp cho máy bơm, quạt công nghiệp và các thiết bị cơ khí khác. Thiết kế chống ẩm, chống bụi IP55.', 'Động cơ điện ABC 3HP, 3 phase, 1450 rpm', 5800000.00, 5200000.00, 'SPABCMT0006', 20, 2, 28.500, 1, 0, 1, 69, 3, 4.6, 3, 'Động cơ điện ABC 3HP - Hiệu suất cao, độ bền vượt trội', 'Động cơ điện ABC 3HP chính hãng, hiệu suất cao, độ bền vượt trội. Thích hợp máy bơm, quạt công nghiệp', 'động cơ điện, abc motor, 3hp, motor 3 phase, động cơ công nghiệp', 'index,follow', 'SuperWin', 'https://superwin.com/products/dong-co-dien-abc-3hp', '3HP (2200W)', '380V/3 Phase', NULL, NULL, '87%', '≤65dB', '12 tháng', '2025-08-07 16:42:01', '2025-08-11 02:36:45');
INSERT INTO `products` VALUES (7, 'Quạt tròn Inverter Fan IF-250', 'quat-tron-inverter-fan-if-250', 5, 6, 'Quạt tròn Inverter Fan IF-250 với công nghệ biến tần tiết kiệm điện. Thiết kế aerodynamic giảm tiếng ồn và tăng hiệu suất. Phù hợp cho hệ thống thông gió chính xác.', 'Quạt tròn IF-250 biến tần, đường kính 250mm', 2800000.00, 2500000.00, 'SPIFQR0007', 35, 3, 5.800, 1, 1, 1, 122, 9, 4.8, 6, 'Quạt tròn Inverter Fan IF-250 - Công nghệ biến tần', 'Quạt tròn Inverter Fan IF-250 công nghệ biến tần tiết kiệm điện, thiết kế aerodynamic giảm tiếng ồn', 'quạt tròn, inverter fan, if-250, quạt biến tần, tiết kiệm điện', 'index,follow', 'SuperWin', 'https://superwin.com/products/quat-tron-inverter-fan-if-250', '80W', '220V/1 Phase', '1800 m³/h', '120 Pa', '82%', '≤42dB', '24 tháng', '2025-08-07 16:42:01', '2025-08-13 18:22:22');
INSERT INTO `products` VALUES (8, 'Máy bơm nước biển SuperWin SWM-150', 'may-bom-nuoc-bien-superwin-swm-150', 6, 1, 'Máy bơm nước biển SuperWin SWM-150 chuyên dụng cho môi trường nước mặn. Vỏ máy và cánh bơm được làm từ hợp kim chống ăn mòn đặc biệt. Phù hợp cho nuôi trồng thủy sản và công nghiệp ven biển.', 'Máy bơm nước biển SWM-150 chống ăn mòn, 1.5HP', 3800000.00, 3400000.00, 'SPSWBM0008', 25, 3, 22.300, 1, 1, 1, 99, 5, 4.4, 4, 'Máy bơm nước biển SuperWin SWM-150 - Chống ăn mòn', 'Máy bơm nước biển SuperWin SWM-150 chuyên dụng nước mặn, chống ăn mòn, phù hợp nuôi trồng thủy sản', 'máy bơm nước biển, superwin, swm-150, bơm nước mặn, chống ăn mòn', 'index,follow', 'SuperWin', 'https://superwin.com/products/may-bom-nuoc-bien-superwin-swm-150', '1.5HP (1100W)', '220V/1 Phase', '2800 L/h', '28m', '83%', '≤58dB', '18 tháng', '2025-08-07 16:42:01', '2025-08-14 08:55:41');
INSERT INTO `products` VALUES (9, 'Quạt chống cháy nổ SuperWin EX-400', 'quat-chong-chay-no-superwin-ex-400', 15, 1, 'Quạt chống cháy nổ SuperWin EX-400 được thiết kế đặc biệt cho môi trường có nguy cơ cháy nổ. Đạt tiêu chuẩn ATEX, motor chống cháy nổ Ex d IIB T4. Thích hợp cho nhà máy hóa chất, kho xăng dầu.', 'Quạt chống cháy nổ EX-400, tiêu chuẩn ATEX', 8500000.00, 7800000.00, 'SPSWEX0009', 10, 2, 15.800, 1, 0, 1, 45, 2, 4.9, 2, 'Quạt chống cháy nổ SuperWin EX-400 - Tiêu chuẩn ATEX', 'Quạt chống cháy nổ SuperWin EX-400 đạt tiêu chuẩn ATEX, motor Ex d IIB T4, an toàn cho môi trường cháy nổ', 'quạt chống cháy nổ, superwin, ex-400, atex, quạt an toàn', 'index,follow', 'SuperWin', 'https://superwin.com/products/quat-chong-chay-no-superwin-ex-400', '250W', '220V/1 Phase', '3500 m³/h', '200 Pa', '75%', '≤60dB', '24 tháng', '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `products` VALUES (10, 'Máy bơm hồ bơi Vina Pump VP-POOL', 'may-bom-ho-boi-vina-pump-vp-pool', 7, 4, 'Máy bơm hồ bơi Vina Pump VP-POOL thiết kế chuyên dụng cho hệ thống lọc nước hồ bơi. Vỏ nhựa ABS bền bỉ, motor tự mồi, vận hành êm ái. Tích hợp hệ thống lọc sơ bộ.', 'Máy bơm hồ bơi VP-POOL, tự mồi, lọc nước', 4500000.00, NULL, 'SPVPPL0010', 18, 2, 16.200, 1, 1, 0, 92, 7, 4.3, 5, 'Máy bơm hồ bơi Vina Pump VP-POOL - Chuyên dụng hồ bơi', 'Máy bơm hồ bơi Vina Pump VP-POOL chuyên dụng lọc nước hồ bơi, tự mồi, vận hành êm ái', 'máy bơm hồ bơi, vina pump, vp-pool, bơm lọc nước, hồ bơi', 'index,follow', 'SuperWin', 'https://superwin.com/products/may-bom-ho-boi-vina-pump-vp-pool', '1HP (750W)', '220V/1 Phase', '12000 L/h', '12m', '80%', '≤52dB', '12 tháng', '2025-08-07 16:42:01', '2025-08-07 16:42:01');

-- ----------------------------
-- Table structure for quat_details
-- ----------------------------
DROP TABLE IF EXISTS `quat_details`;
CREATE TABLE `quat_details`  (
  `product_id` int NOT NULL,
  `duong_kinh_canh` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `dien_ap` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `cong_suat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `luong_gio` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `toc_do` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `do_on` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `dien_tich_lam_mat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `cot_ap` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `warranty_months` int NULL DEFAULT 12,
  PRIMARY KEY (`product_id`) USING BTREE,
  CONSTRAINT `quat_details_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of quat_details
-- ----------------------------
INSERT INTO `quat_details` VALUES (3, '300mm', '220V', '120W', '3200 m³/h', '1450 rpm', '≤52dB', '25-30m²', '45 Pa', 12);
INSERT INTO `quat_details` VALUES (4, '1400mm', '220V', '200W', '28000 m³/h', '320 rpm', '≤48dB', '200-300m²', '65 Pa', 18);
INSERT INTO `quat_details` VALUES (5, '400mm', '220V', '150W', '2800 m³/h', '1200 rpm', '≤58dB', '20-25m²', '180 Pa', 12);
INSERT INTO `quat_details` VALUES (7, '250mm', '220V', '80W', '1800 m³/h', '1600 rpm', '≤42dB', '15-20m²', '120 Pa', 24);
INSERT INTO `quat_details` VALUES (9, '400mm', '220V', '250W', '3500 m³/h', '1100 rpm', '≤60dB', '30-40m²', '200 Pa', 24);

-- ----------------------------
-- Table structure for reviews
-- ----------------------------
DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `user_id` int NOT NULL,
  `order_id` int NULL DEFAULT NULL,
  `rating` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `images` json NULL,
  `pros` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `cons` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `is_verified_purchase` tinyint(1) NULL DEFAULT 0,
  `is_approved` tinyint(1) NULL DEFAULT 1,
  `helpful_count` int NULL DEFAULT 0,
  `parent_id` int NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `order_id`(`order_id` ASC) USING BTREE,
  INDEX `parent_id`(`parent_id` ASC) USING BTREE,
  INDEX `idx_product_id`(`product_id` ASC) USING BTREE,
  INDEX `idx_user_id`(`user_id` ASC) USING BTREE,
  INDEX `idx_rating`(`rating` ASC) USING BTREE,
  INDEX `idx_approved`(`is_approved` ASC) USING BTREE,
  INDEX `idx_created_at`(`created_at` ASC) USING BTREE,
  CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `reviews_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `reviews_ibfk_4` FOREIGN KEY (`parent_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `reviews_chk_1` CHECK ((`rating` >= 1) and (`rating` <= 5))
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of reviews
-- ----------------------------

-- ----------------------------
-- Table structure for role_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_permissions`;
CREATE TABLE `role_permissions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` bigint UNSIGNED NOT NULL,
  `permission_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `role_permissions_role_id_permission_id_unique`(`role_id` ASC, `permission_id` ASC) USING BTREE,
  INDEX `role_permissions_role_id_foreign`(`role_id` ASC) USING BTREE,
  INDEX `role_permissions_permission_id_foreign`(`permission_id` ASC) USING BTREE,
  CONSTRAINT `role_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `role_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 93 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of role_permissions
-- ----------------------------

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `name`(`name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of roles
-- ----------------------------

-- ----------------------------
-- Table structure for search_logs
-- ----------------------------
DROP TABLE IF EXISTS `search_logs`;
CREATE TABLE `search_logs`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NULL DEFAULT NULL,
  `keyword` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `category_filter` int NULL DEFAULT NULL,
  `brand_filter` int NULL DEFAULT NULL,
  `price_min` decimal(10, 2) NULL DEFAULT NULL,
  `price_max` decimal(10, 2) NULL DEFAULT NULL,
  `results_count` int NULL DEFAULT 0,
  `suggested` tinyint(1) NULL DEFAULT 0,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_user_id`(`user_id` ASC) USING BTREE,
  INDEX `idx_keyword`(`keyword` ASC) USING BTREE,
  INDEX `idx_created_at`(`created_at` ASC) USING BTREE,
  CONSTRAINT `search_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of search_logs
-- ----------------------------

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `payload` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sessions_user_id_index`(`user_id` ASC) USING BTREE,
  INDEX `sessions_last_activity_index`(`last_activity` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sessions
-- ----------------------------
INSERT INTO `sessions` VALUES ('nhmFBpwn4cAAlPkHD933cJzdU8YEpMYM29rqLohL', NULL, '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNGY5RTNyWkZtQW5XNXY3OHpBeHBXSTZaRUdVVFE0TFpRUlNvZGR5NSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9jYXRlZ29yeS8xIjt9czo1NToibG9naW5fY3VzdG9tZXJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO30=', 1755172242);
INSERT INTO `sessions` VALUES ('OiMUQSNd4HKYWoAU8N17oBYknCIAq5VmbIoN49i4', 4, '172.18.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiaGhWQndER2JjQmFOR3M2UkR1b0ltWTE4TDZaY2dwbWdhNEJCVmliUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjQ6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9jaGVja291dD9idXlfbm93PTEmcHJvZHVjdF9pZD04JnF1YW50aXR5PTEiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjU1OiJsb2dpbl9jdXN0b21lcl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7czozOiJ1cmwiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7fQ==', 1755109714);

-- ----------------------------
-- Table structure for settings
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `key_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `type` enum('string','number','boolean','json') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT 'string',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `key_name`(`key_name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of settings
-- ----------------------------
INSERT INTO `settings` VALUES (1, 'site_name', 'SuperWin', 'Tên website', 'string', '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `settings` VALUES (2, 'site_description', 'Chuyên cung cấp máy bơm nước và quạt công nghiệp chất lượng cao', 'Mô tả website', 'string', '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `settings` VALUES (3, 'contact_phone', '1900-1234', 'Số điện thoại liên hệ', 'string', '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `settings` VALUES (4, 'contact_email', 'info@superwin.com', 'Email liên hệ', 'string', '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `settings` VALUES (5, 'contact_address', '123 Đường ABC, Quận XYZ, TP.HCM', 'Địa chỉ liên hệ', 'string', '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `settings` VALUES (6, 'shipping_fee', '30000', 'Phí vận chuyển mặc định', 'number', '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `settings` VALUES (7, 'vat_rate', '0.08', 'Thuế VAT (%)', 'number', '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `settings` VALUES (8, 'min_order_amount', '500000', 'Đơn hàng tối thiểu', 'number', '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `settings` VALUES (9, 'loyalty_point_rate', '0.01', 'Tỷ lệ tích điểm (1% = 0.01)', 'number', '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `settings` VALUES (10, 'currency_symbol', '₫', 'Ký hiệu tiền tệ', 'string', '2025-08-07 16:42:01', '2025-08-07 16:42:01');

-- ----------------------------
-- Table structure for user_roles
-- ----------------------------
DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE `user_roles`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `user_roles_user_id_role_id_unique`(`user_id` ASC, `role_id` ASC) USING BTREE,
  INDEX `user_roles_user_id_index`(`user_id` ASC) USING BTREE,
  INDEX `user_roles_role_id_foreign`(`role_id` ASC) USING BTREE,
  CONSTRAINT `user_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of user_roles
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `role` enum('super_admin','admin','manager','staff') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT 'staff',
  `permissions` json NULL,
  `department` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `employee_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `hire_date` date NULL DEFAULT NULL,
  `is_active` tinyint(1) NULL DEFAULT 1,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `email_verified_at` datetime NULL DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `email`(`email` ASC) USING BTREE,
  UNIQUE INDEX `employee_id`(`employee_id` ASC) USING BTREE,
  INDEX `idx_email`(`email` ASC) USING BTREE,
  INDEX `idx_role`(`role` ASC) USING BTREE,
  INDEX `idx_employee_id`(`employee_id` ASC) USING BTREE,
  INDEX `idx_department`(`department` ASC) USING BTREE,
  INDEX `idx_is_active`(`is_active` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (2, 'Nguyễn Văn A', 'manager@superwin.com', 'manager', NULL, 'Sales', 'EMP002', '2024-02-01', 1, '$2y$12$LGHcF.VjWKKvhN4fF4rZneTQJnHU6bBZ1VsKHJCxEF9M5IZzFsFfS', '2025-08-07 16:42:01', NULL, NULL, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `users` VALUES (3, 'Trần Thị B', 'staff@superwin.com', 'staff', NULL, 'Warehouse', 'EMP003', '2024-03-01', 1, '$2y$12$LGHcF.VjWKKvhN4fF4rZneTQJnHU6bBZ1VsKHJCxEF9M5IZzFsFfS', '2025-08-07 16:42:01', NULL, NULL, '2025-08-07 16:42:01', '2025-08-07 16:42:01');
INSERT INTO `users` VALUES (4, 'Super Admin', 'superadmin@superwin.com', 'super_admin', NULL, NULL, NULL, NULL, 1, '$2y$12$3c.coPJRBdWek1ZBA7OoiO0NKr2TL4Z8uca97myZdLdZDICwiYMI.', '2025-08-07 18:10:11', NULL, NULL, '2025-08-07 18:10:11', '2025-08-07 18:10:11');

SET FOREIGN_KEY_CHECKS = 1;
