-- Cập nhật cấu trúc Hot Search để hỗ trợ multiple items

-- Tạo bảng hot_search_items để lưu nhiều items cho 1 hot search
CREATE TABLE IF NOT EXISTS `hot_search_items` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `hot_search_id` bigint(20) UNSIGNED NOT NULL COMMENT 'ID của hot search',
  `item_type` enum('product','brand','category') NOT NULL COMMENT 'Loại item',
  `item_id` bigint(20) UNSIGNED NOT NULL COMMENT 'ID của item (product_id, brand_id, category_id)',
  `sort_order` int(11) NOT NULL DEFAULT 0 COMMENT 'Thứ tự sắp xếp trong group',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_hot_search_id` (`hot_search_id`),
  KEY `idx_item_type` (`item_type`),
  KEY `idx_item_id` (`item_id`),
  KEY `idx_sort_order` (`sort_order`),
  FOREIGN KEY (`hot_search_id`) REFERENCES `hot_searches` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bảng lưu các items của hot search';

-- Cập nhật bảng hot_searches
-- Xóa cột reference_id vì không cần nữa
ALTER TABLE `hot_searches` DROP COLUMN `reference_id`;

-- Thêm cột max_items để giới hạn số lượng items hiển thị
ALTER TABLE `hot_searches` ADD COLUMN `max_items` int(11) NOT NULL DEFAULT 5 COMMENT 'Số lượng items tối đa hiển thị' AFTER `sort_order`;

-- Cập nhật dữ liệu mẫu
-- Xóa dữ liệu cũ
DELETE FROM `hot_searches`;

-- Thêm dữ liệu mẫu mới
INSERT INTO `hot_searches` (`type`, `title`, `keyword`, `description`, `sort_order`, `max_items`, `is_active`) VALUES
('keyword', 'Quạt trần cao cấp', 'quạt trần cao cấp', 'Từ khóa hot về quạt trần', 1, 5, 1),
('keyword', 'Bơm nước thông minh', 'bơm nước thông minh', 'Từ khóa hot về bơm nước', 2, 5, 1),
('keyword', 'Ống nhựa PVC', 'ống nhựa pvc', 'Từ khóa hot về ống nhựa', 3, 5, 1),
('product', 'Sản phẩm nổi bật', NULL, 'Các sản phẩm được đề xuất', 4, 8, 1),
('brand', 'Thương hiệu uy tín', NULL, 'Các thương hiệu đáng tin cậy', 5, 6, 1),
('category', 'Danh mục phổ biến', NULL, 'Các danh mục được quan tâm nhất', 6, 5, 1);

-- Lấy ID của hot search vừa tạo để thêm items mẫu
-- (Bạn sẽ cần chạy thêm SQL để thêm items vào hot_search_items sau khi có dữ liệu products, brands, categories)