-- Sample data for product_attributes table

-- Thêm thuộc tính cho sản phẩm 1 (nếu tồn tại)
INSERT INTO `product_attributes` (
    `product_id`, 
    `attribute_key`, 
    `attribute_value`, 
    `attribute_unit`, 
    `attribute_description`, 
    `sort_order`, 
    `is_visible`, 
    `created_at`, 
    `updated_at`
) VALUES 
-- Thuộc tính cho sản phẩm ID 1
(1, 'power', '1.5', 'HP', 'Công suất động cơ', 1, 1, NOW(), NOW()),
(1, 'voltage', '220', 'V', 'Điện áp hoạt động', 2, 1, NOW(), NOW()),
(1, 'flow_rate', '50', 'L/phút', 'Lưu lượng nước', 3, 1, NOW(), NOW()),
(1, 'pressure', '25', 'm', 'Cột áp tối đa', 4, 1, NOW(), NOW()),
(1, 'warranty_period', '24', 'tháng', 'Thời gian bảo hành', 5, 1, NOW(), NOW()),

-- Thuộc tính cho sản phẩm ID 2 (nếu tồn tại)
(2, 'power', '2.0', 'HP', 'Công suất động cơ', 1, 1, NOW(), NOW()),
(2, 'voltage', '380', 'V', 'Điện áp hoạt động', 2, 1, NOW(), NOW()),
(2, 'flow_rate', '80', 'L/phút', 'Lưu lượng nước', 3, 1, NOW(), NOW()),
(2, 'pressure', '35', 'm', 'Cột áp tối đa', 4, 1, NOW(), NOW()),
(2, 'material', 'Inox 304', '', 'Chất liệu vỏ máy', 5, 1, NOW(), NOW()),
(2, 'warranty_period', '36', 'tháng', 'Thời gian bảo hành', 6, 1, NOW(), NOW());

SELECT 'Product attributes sample data inserted successfully!' AS Message;
