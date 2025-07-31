-- Cập nhật các trường còn thiếu
-- File: mysql-inti/update_missing_fields.sql

-- ========================================
-- CẬP NHẬT BẢNG CUSTOMERS
-- ========================================

-- Thêm các trường còn thiếu vào bảng customers
ALTER TABLE customers 
ADD COLUMN IF NOT EXISTS customer_code VARCHAR(50) UNIQUE AFTER status;

ALTER TABLE customers 
ADD COLUMN IF NOT EXISTS total_spent DECIMAL(15,2) DEFAULT 0 AFTER customer_code;

ALTER TABLE customers 
ADD COLUMN IF NOT EXISTS loyalty_points INT DEFAULT 0 AFTER total_spent;

ALTER TABLE customers 
ADD COLUMN IF NOT EXISTS preferred_payment_method VARCHAR(50) AFTER loyalty_points;

ALTER TABLE customers 
ADD COLUMN IF NOT EXISTS marketing_consent BOOLEAN DEFAULT FALSE AFTER preferred_payment_method;

ALTER TABLE customers 
ADD COLUMN IF NOT EXISTS newsletter_subscription BOOLEAN DEFAULT FALSE AFTER marketing_consent;

-- Thêm index cho các trường mới
ALTER TABLE customers 
ADD INDEX IF NOT EXISTS idx_customer_code (customer_code);

ALTER TABLE customers 
ADD INDEX IF NOT EXISTS idx_total_spent (total_spent);

ALTER TABLE customers 
ADD INDEX IF NOT EXISTS idx_loyalty_points (loyalty_points);

-- ========================================
-- CẬP NHẬT BẢNG PRODUCTS
-- ========================================

-- Thêm các trường meta còn thiếu vào bảng products
ALTER TABLE products 
ADD COLUMN IF NOT EXISTS meta_keywords VARCHAR(255) AFTER meta_description;

ALTER TABLE products 
ADD COLUMN IF NOT EXISTS meta_robots VARCHAR(100) AFTER meta_keywords;

ALTER TABLE products 
ADD COLUMN IF NOT EXISTS meta_author VARCHAR(255) AFTER meta_robots;

ALTER TABLE products 
ADD COLUMN IF NOT EXISTS meta_canonical_url VARCHAR(255) AFTER meta_author;

-- Thêm index cho các trường meta
ALTER TABLE products 
ADD INDEX IF NOT EXISTS idx_meta_keywords (meta_keywords);

-- ========================================
-- CẬP NHẬT BẢNG PRODUCT_IMAGES
-- ========================================

-- Thêm trường is_base vào bảng product_images
ALTER TABLE product_images 
ADD COLUMN IF NOT EXISTS is_base BOOLEAN DEFAULT FALSE AFTER is_primary;

-- Thêm index cho trường is_base
ALTER TABLE product_images 
ADD INDEX IF NOT EXISTS idx_is_base (is_base);

-- Cập nhật trường is_base cho ảnh đầu tiên của mỗi sản phẩm nếu chưa có ảnh base
UPDATE product_images pi1
SET is_base = TRUE
WHERE pi1.id = (
    SELECT MIN(pi2.id) 
    FROM product_images pi2 
    WHERE pi2.product_id = pi1.product_id
) 
AND NOT EXISTS (
    SELECT 1 
    FROM product_images pi3 
    WHERE pi3.product_id = pi1.product_id 
    AND pi3.is_base = TRUE
);

-- ========================================
-- CẬP NHẬT DỮ LIỆU TEST CHO CUSTOMERS
-- ========================================

-- Cập nhật customer_code cho customers hiện có nếu chưa có
UPDATE customers 
SET customer_code = CONCAT('CUS', LPAD(id, 3, '0')) 
WHERE customer_code IS NULL;

-- Cập nhật total_spent và loyalty_points cho customers hiện có
UPDATE customers 
SET total_spent = 0, loyalty_points = 0 
WHERE total_spent IS NULL OR loyalty_points IS NULL;

-- ========================================
-- CẬP NHẬT DỮ LIỆU TEST CHO PRODUCTS
-- ========================================

-- Cập nhật meta fields cho products hiện có
UPDATE products 
SET meta_keywords = CONCAT(name, ', ', product_type, ', máy bơm, quạt điện')
WHERE meta_keywords IS NULL;

UPDATE products 
SET meta_robots = 'index, follow'
WHERE meta_robots IS NULL;

UPDATE products 
SET meta_author = 'SuperWin'
WHERE meta_author IS NULL;

UPDATE products 
SET meta_canonical_url = CONCAT('https://superwin.com/products/', slug)
WHERE meta_canonical_url IS NULL;

-- ========================================
-- KIỂM TRA VÀ SỬA LỖI STATUS CỦA PRODUCTS
-- ========================================

-- Đảm bảo trường status có giá trị mặc định
UPDATE products 
SET status = TRUE 
WHERE status IS NULL;

-- Thêm index cho trường status nếu chưa có
ALTER TABLE products 
ADD INDEX IF NOT EXISTS idx_status (status);

-- ========================================
-- THÊM DỮ LIỆU TEST CHO PRODUCTS (nếu chưa có)
-- ========================================

-- Thêm sản phẩm test nếu bảng products trống
INSERT IGNORE INTO products (name, slug, category_id, brand_id, product_type, description, short_description, price, sale_price, sku, stock_quantity, min_stock_level, weight, status, is_featured, meta_title, meta_description, meta_keywords, meta_robots, meta_author, meta_canonical_url) VALUES
('Máy bơm tăng áp Panasonic GP-129JXK', 'may-bom-tang-ap-panasonic-gp-129jxk', 6, 1, 'bom', 
'Máy bơm tăng áp tự động Panasonic GP-129JXK với công suất mạnh mẽ, phù hợp cho hộ gia đình và văn phòng. Tự động bật/tắt theo áp lực nước, tiết kiệm điện năng.',
'Máy bơm tăng áp tự động, công suất 125W, lưu lượng 25L/phút, cột áp 25m',
2500000, 2200000, 'PAN-GP129JXK', 15, 5, 8.5, TRUE, TRUE,
'Máy bơm tăng áp Panasonic GP-129JXK - Chính hãng',
'Máy bơm tăng áp Panasonic GP-129JXK chính hãng, công suất 125W, lưu lượng 25L/phút, cột áp 25m. Bảo hành 12 tháng.',
'Panasonic, máy bơm tăng áp, tự động, 125W, bom, nuoc',
'index, follow',
'SuperWin',
'https://superwin.com/products/may-bom-tang-ap-panasonic-gp-129jxk'),

('Quạt cây Panasonic F-14MS1', 'quat-cay-panasonic-f-14ms1', 8, 1, 'quat',
'Quạt cây Panasonic F-14MS1 với thiết kế hiện đại, 3 tốc độ gió, chế độ hẹn giờ thông minh. Tiết kiệm điện, an toàn cho gia đình.',
'Quạt cây 3 tốc độ, công suất 45W, đường kính cánh 14 inch, chế độ hẹn giờ',
1200000, 1100000, 'PAN-F14MS1', 25, 8, 4.2, TRUE, TRUE,
'Quạt cây Panasonic F-14MS1 - 3 tốc độ',
'Quạt cây Panasonic F-14MS1, 3 tốc độ gió, công suất 45W, đường kính cánh 14 inch. Chế độ hẹn giờ thông minh, tiết kiệm điện.',
'Panasonic, quạt cây, 3 tốc độ, 45W, quat, dien',
'index, follow',
'SuperWin',
'https://superwin.com/products/quat-cay-panasonic-f-14ms1');

-- ========================================
-- THÊM DỮ LIỆU TEST CHO PRODUCT_IMAGES (nếu chưa có)
-- ========================================

-- Thêm hình ảnh test cho sản phẩm
INSERT IGNORE INTO product_images (product_id, url, alt_text, sort_order, is_primary, is_base) VALUES
(1, '/image/products/panasonic-gp-129jxk-1.jpg', 'Máy bơm tăng áp Panasonic GP-129JXK - Góc chính', 1, TRUE, TRUE),
(1, '/image/products/panasonic-gp-129jxk-2.jpg', 'Máy bơm tăng áp Panasonic GP-129JXK - Góc nghiêng', 2, FALSE, FALSE),
(1, '/image/products/panasonic-gp-129jxk-3.jpg', 'Máy bơm tăng áp Panasonic GP-129JXK - Thông số kỹ thuật', 3, FALSE, FALSE),
(2, '/image/products/panasonic-f-14ms1-1.jpg', 'Quạt cây Panasonic F-14MS1 - Góc chính', 1, TRUE, TRUE),
(2, '/image/products/panasonic-f-14ms1-2.jpg', 'Quạt cây Panasonic F-14MS1 - Góc nghiêng', 2, FALSE, FALSE),
(2, '/image/products/panasonic-f-14ms1-3.jpg', 'Quạt cây Panasonic F-14MS1 - Điều khiển', 3, FALSE, FALSE);

-- ========================================
-- THÔNG BÁO HOÀN THÀNH
-- ========================================

SELECT 'Đã cập nhật các trường còn thiếu thành công!' as message;

-- Kiểm tra kết quả
SELECT 'Customers' as table_name, COUNT(*) as total_records FROM customers
UNION ALL
SELECT 'Products' as table_name, COUNT(*) as total_records FROM products
UNION ALL
SELECT 'Product Images' as table_name, COUNT(*) as total_records FROM product_images;

-- Kiểm tra các trường mới
SELECT 'Customers có customer_code:' as check_field, COUNT(*) as count FROM customers WHERE customer_code IS NOT NULL
UNION ALL
SELECT 'Products có meta_keywords:' as check_field, COUNT(*) as count FROM products WHERE meta_keywords IS NOT NULL
UNION ALL
SELECT 'Product Images có is_base:' as check_field, COUNT(*) as count FROM product_images WHERE is_base = TRUE; 