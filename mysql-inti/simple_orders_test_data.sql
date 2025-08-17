-- Test data đơn giản cho orders (chỉ 2 đơn hàng)

-- Xóa dữ liệu cũ nếu có
DELETE FROM order_tracking;
DELETE FROM payments;  
DELETE FROM order_details;
DELETE FROM orders;

-- Reset AUTO_INCREMENT
ALTER TABLE orders AUTO_INCREMENT = 1;
ALTER TABLE order_details AUTO_INCREMENT = 1;
ALTER TABLE payments AUTO_INCREMENT = 1;
ALTER TABLE order_tracking AUTO_INCREMENT = 1;

-- Tạo 2 orders test
INSERT INTO `orders` (`user_id`, `order_code`, `customer_name`, `customer_phone`, `customer_email`, `shipping_address`, `shipping_city`, `shipping_district`, `shipping_ward`, `payment_method`, `shipping_method`, `shipping_fee`, `discount_amount`, `tax_amount`, `subtotal`, `total_amount`, `status`, `customer_note`, `admin_note`, `created_at`, `updated_at`) VALUES
(1, 'ORD-2024-0001', 'Nguyễn Văn An', '0901234567', 'nguyenvanan@gmail.com', '123 Đường ABC, Phường 1, Quận 1, TP.HCM', 'Hồ Chí Minh', 'Quận 1', 'Phường 1', 'cod', 'standard', 30000.00, 0.00, 0.00, 1500000.00, 1530000.00, 'pending', 'Giao hàng giờ hành chính', NULL, DATE_SUB(NOW(), INTERVAL 1 DAY), NOW()),
(2, 'ORD-2024-0002', 'Trần Thị Bình', '0912345678', 'tranthibinh@gmail.com', '456 Đường XYZ, Phường 2, Quận Ba Đình, Hà Nội', 'Hà Nội', 'Quận Ba Đình', 'Phường 2', 'cod', 'express', 50000.00, 100000.00, 0.00, 2000000.00, 1950000.00, 'confirmed', 'Giao hàng buổi chiều', 'Đã xác nhận đơn hàng', DATE_SUB(NOW(), INTERVAL 2 HOUR), NOW());

-- Tạo order_details cho 2 orders
INSERT INTO `order_details` (`order_id`, `product_id`, `product_name`, `product_sku`, `quantity`, `unit_price`, `total_price`) VALUES
(1, 4, 'Sản phẩm test 1', 'SP3997', 1, 1500000.00, 1500000.00),
(2, 5, 'Sản phẩm test 2', 'SPTTTE7839', 1, 2000000.00, 2000000.00);

-- Tạo payments cho 1 order
INSERT INTO `payments` (`order_id`, `payment_method`, `transaction_id`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(2, 'cod', 'COD-2024-0001', 1950000.00, 'pending', NOW(), NOW());

-- Tạo order_tracking cho 2 orders
INSERT INTO `order_tracking` (`order_id`, `status`, `title`, `description`, `location`, `created_by`, `created_at`) VALUES
(1, 'pending', 'Đơn hàng đã được tạo', 'Đơn hàng đang chờ xác nhận', 'Hệ thống', 4, DATE_SUB(NOW(), INTERVAL 1 DAY)),
(2, 'confirmed', 'Đơn hàng đã được xác nhận', 'Đơn hàng đã được xác nhận và đang chuẩn bị', 'Kho hàng TP.HCM', 4, DATE_SUB(NOW(), INTERVAL 2 HOUR));

-- Thông báo kết quả
SELECT 'Orders test data created successfully!' AS Message;
SELECT CONCAT('Total orders: ', COUNT(*)) AS Summary FROM orders;
SELECT status, COUNT(*) as count FROM orders GROUP BY status ORDER BY status;
