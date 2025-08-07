-- Cập nhật cấu trúc bảng product_variants theo yêu cầu mới
-- Xóa bảng cũ và tạo lại với cấu trúc mới

DROP TABLE IF EXISTS `product_variants`;
CREATE TABLE `product_variants` (
    `id` int NOT NULL AUTO_INCREMENT,
    `product_id` int NOT NULL,
    `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Tên hiển thị variant (VD: Máy bơm nhật)',
    `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Mã variant do user nhập (VD: MBN1)',
    `quantity` int NOT NULL DEFAULT 0 COMMENT 'Số lượng tồn kho',
    `price` decimal(10,2) NOT NULL COMMENT 'Giá gốc',
    `price_sale` decimal(10,2) NULL DEFAULT NULL COMMENT 'Giá khuyến mãi',
    `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Trạng thái hoạt động',
    `sort_order` int NOT NULL DEFAULT 0 COMMENT 'Thứ tự sắp xếp',
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`) USING BTREE,
    INDEX `idx_product_id` (`product_id` ASC) USING BTREE,
    INDEX `idx_active` (`is_active` ASC) USING BTREE,
    INDEX `idx_code` (`code` ASC) USING BTREE,
    UNIQUE INDEX `unique_product_code` (`product_id` ASC, `code` ASC) USING BTREE,
    CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- Thêm comment cho bảng
ALTER TABLE `product_variants` COMMENT = 'Bảng quản lý các biến thể sản phẩm đơn giản (tên, mã, giá, số lượng)';