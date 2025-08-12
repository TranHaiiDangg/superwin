-- Tạo bảng hot_searches để quản lý các mục hot search
CREATE TABLE IF NOT EXISTS `hot_searches` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` enum('product','keyword','brand','category') NOT NULL COMMENT 'Loại hot search: product, keyword, brand, category',
  `title` varchar(255) NOT NULL COMMENT 'Tiêu đề hiển thị',
  `reference_id` bigint(20) UNSIGNED NULL COMMENT 'ID tham chiếu đến product_id, brand_id, category_id (null với keyword)',
  `keyword` varchar(255) NULL COMMENT 'Từ khóa search (chỉ dùng với type=keyword)',
  `image_url` varchar(500) NULL COMMENT 'URL hình ảnh (tùy chọn)',
  `description` text NULL COMMENT 'Mô tả ngắn',
  `sort_order` int(11) NOT NULL DEFAULT 0 COMMENT 'Thứ tự sắp xếp',
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Trạng thái kích hoạt',
  `click_count` bigint(20) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Số lượt click',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_type` (`type`),
  KEY `idx_is_active` (`is_active`),
  KEY `idx_sort_order` (`sort_order`),
  KEY `idx_reference_id` (`reference_id`),
  KEY `idx_click_count` (`click_count`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bảng quản lý hot search items';

-- Thêm một số dữ liệu mẫu
INSERT INTO `hot_searches` (`type`, `title`, `reference_id`, `keyword`, `image_url`, `description`, `sort_order`, `is_active`) VALUES
('keyword', 'Quạt trần cao cấp', NULL, 'quạt trần cao cấp', NULL, 'Từ khóa hot về quạt trần', 1, 1),
('keyword', 'Bơm nước thông minh', NULL, 'bơm nước thông minh', NULL, 'Từ khóa hot về bơm nước', 2, 1),
('keyword', 'Ống nhựa PVC', NULL, 'ống nhựa pvc', NULL, 'Từ khóa hot về ống nhựa', 3, 1),
('keyword', 'Thiết bị điện', NULL, 'thiết bị điện', NULL, 'Từ khóa hot về thiết bị điện', 4, 1);

-- Lưu ý: 
-- - Với type='product': reference_id sẽ là product_id
-- - Với type='brand': reference_id sẽ là brand_id  
-- - Với type='category': reference_id sẽ là category_id
-- - Với type='keyword': reference_id sẽ là NULL, sử dụng field keyword