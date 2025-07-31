-- Test Data cho SuperWin
-- Categories, Brands, Products và Product Images

-- ========================================
-- CATEGORIES (Danh mục sản phẩm)
-- ========================================

-- Danh mục chính
INSERT INTO categories (name, product_type, image, description, sort_order, is_active) VALUES
('Máy bơm nước', 'bom', '/image/categories/bom-nuoc.jpg', 'Máy bơm nước công nghiệp và dân dụng', 1, TRUE),
('Máy bơm chìm', 'bom_chim', '/image/categories/bom-chim.jpg', 'Máy bơm chìm giếng khoan và hố ga', 2, TRUE),
('Quạt điện', 'quat', '/image/categories/quat-dien.jpg', 'Quạt điện các loại', 3, TRUE),
('Quạt trần', 'quat_tron', '/image/categories/quat-tran.jpg', 'Quạt trần trang trí', 4, TRUE),
('Động cơ điện', 'motor', '/image/categories/dong-co.jpg', 'Động cơ điện công nghiệp', 5, TRUE);

-- Danh mục con cho máy bơm nước
INSERT INTO categories (name, parent_id, product_type, image, description, sort_order, is_active) VALUES
('Máy bơm tăng áp', 1, 'bom', '/image/categories/bom-tang-ap.jpg', 'Máy bơm tăng áp tự động', 1, TRUE),
('Máy bơm ly tâm', 1, 'bom', '/image/categories/bom-ly-tam.jpg', 'Máy bơm ly tâm công nghiệp', 2, TRUE),
('Máy bơm nước thải', 1, 'bom', '/image/categories/bom-nuoc-thai.jpg', 'Máy bơm nước thải', 3, TRUE);

-- Danh mục con cho quạt điện
INSERT INTO categories (name, parent_id, product_type, image, description, sort_order, is_active) VALUES
('Quạt cây', 3, 'quat', '/image/categories/quat-cay.jpg', 'Quạt cây làm mát', 1, TRUE),
('Quạt bàn', 3, 'quat', '/image/categories/quat-ban.jpg', 'Quạt bàn nhỏ gọn', 2, TRUE),
('Quạt hơi nước', 3, 'quat', '/image/categories/quat-hoi-nuoc.jpg', 'Quạt hơi nước làm mát', 3, TRUE);

-- ========================================
-- BRANDS (Thương hiệu)
-- ========================================

INSERT INTO brands (name, image, description, is_active, sort_order) VALUES
('Panasonic', '/image/brands/panasonic.png', 'Thương hiệu điện tử hàng đầu Nhật Bản', TRUE, 1),
('Mitsubishi', '/image/brands/mitsubishi.png', 'Công ty đa quốc gia Nhật Bản', TRUE, 2),
('Grundfos', '/image/brands/grundfos.png', 'Chuyên gia máy bơm nước Đan Mạch', TRUE, 3),
('Wilo', '/image/brands/wilo.png', 'Thương hiệu máy bơm nước Đức', TRUE, 4),
('DAB', '/image/brands/dab.png', 'Máy bơm nước chất lượng cao từ Ý', TRUE, 5),
('Toshiba', '/image/brands/toshiba.png', 'Công nghệ tiên tiến từ Nhật Bản', TRUE, 6),
('LG', '/image/brands/lg.png', 'Thương hiệu Hàn Quốc uy tín', TRUE, 7),
('Samsung', '/image/brands/samsung.png', 'Công nghệ hiện đại từ Hàn Quốc', TRUE, 8),
('Daikin', '/image/brands/daikin.png', 'Chuyên gia điều hòa và quạt Nhật Bản', TRUE, 9),
('Sharp', '/image/brands/sharp.png', 'Công nghệ sắc nét từ Nhật Bản', TRUE, 10);

-- ========================================
-- PRODUCTS (Sản phẩm)
-- ========================================

-- Máy bơm tăng áp
INSERT INTO products (name, slug, category_id, brand_id, product_type, description, short_description, price, sale_price, sku, stock_quantity, min_stock_level, weight, status, is_featured, meta_title, meta_description) VALUES
('Máy bơm tăng áp Panasonic GP-129JXK', 'may-bom-tang-ap-panasonic-gp-129jxk', 6, 1, 'bom', 
'Máy bơm tăng áp tự động Panasonic GP-129JXK với công suất mạnh mẽ, phù hợp cho hộ gia đình và văn phòng. Tự động bật/tắt theo áp lực nước, tiết kiệm điện năng.',
'Máy bơm tăng áp tự động, công suất 125W, lưu lượng 25L/phút, cột áp 25m',
2500000, 2200000, 'PAN-GP129JXK', 15, 5, 8.5, TRUE, TRUE,
'Máy bơm tăng áp Panasonic GP-129JXK - Chính hãng',
'Máy bơm tăng áp Panasonic GP-129JXK chính hãng, công suất 125W, lưu lượng 25L/phút, cột áp 25m. Bảo hành 12 tháng.'),

('Máy bơm tăng áp Grundfos UPA 15-90', 'may-bom-tang-ap-grundfos-upa-15-90', 6, 3, 'bom',
'Máy bơm tăng áp Grundfos UPA 15-90 với thiết kế nhỏ gọn, hiệu suất cao. Phù hợp cho hệ thống nước gia đình, tự động điều chỉnh áp lực.',
'Máy bơm tăng áp tự động, công suất 120W, lưu lượng 25L/phút, cột áp 9m',
3200000, 2900000, 'GRU-UPA1590', 12, 3, 6.2, TRUE, TRUE,
'Máy bơm tăng áp Grundfos UPA 15-90 - Chất lượng Đan Mạch',
'Máy bơm tăng áp Grundfos UPA 15-90, công suất 120W, lưu lượng 25L/phút, cột áp 9m. Thiết kế nhỏ gọn, hiệu suất cao.'),

-- Máy bơm ly tâm
INSERT INTO products (name, slug, category_id, brand_id, product_type, description, short_description, price, sale_price, sku, stock_quantity, min_stock_level, weight, status, is_featured, meta_title, meta_description) VALUES
('Máy bơm ly tâm Wilo PB-088EA', 'may-bom-ly-tam-wilo-pb-088ea', 7, 4, 'bom',
'Máy bơm ly tâm Wilo PB-088EA với động cơ mạnh mẽ, phù hợp cho hệ thống tưới tiêu và cấp nước công nghiệp. Hiệu suất cao, tuổi thọ lâu dài.',
'Máy bơm ly tâm công nghiệp, công suất 370W, lưu lượng 50L/phút, cột áp 35m',
4500000, 4100000, 'WIL-PB088EA', 8, 2, 12.5, TRUE, FALSE,
'Máy bơm ly tâm Wilo PB-088EA - Công nghiệp',
'Máy bơm ly tâm Wilo PB-088EA, công suất 370W, lưu lượng 50L/phút, cột áp 35m. Phù hợp hệ thống tưới tiêu và cấp nước công nghiệp.'),

-- Máy bơm chìm
INSERT INTO products (name, slug, category_id, brand_id, product_type, description, short_description, price, sale_price, sku, stock_quantity, min_stock_level, weight, status, is_featured, meta_title, meta_description) VALUES
('Máy bơm chìm DAB FEKA VS 750 M-A', 'may-bom-chim-dab-feka-vs-750-m-a', 2, 5, 'bom_chim',
'Máy bơm chìm DAB FEKA VS 750 M-A với thiết kế chống thấm nước hoàn hảo, phù hợp cho giếng khoan và hố ga. Động cơ mạnh mẽ, hiệu suất cao.',
'Máy bơm chìm giếng khoan, công suất 750W, lưu lượng 15L/phút, cột áp 60m',
3800000, 3500000, 'DAB-FEKA750', 10, 3, 18.0, TRUE, TRUE,
'Máy bơm chìm DAB FEKA VS 750 M-A - Giếng khoan',
'Máy bơm chìm DAB FEKA VS 750 M-A, công suất 750W, lưu lượng 15L/phút, cột áp 60m. Thiết kế chống thấm nước, phù hợp giếng khoan.'),

-- Quạt cây
INSERT INTO products (name, slug, category_id, brand_id, product_type, description, short_description, price, sale_price, sku, stock_quantity, min_stock_level, weight, status, is_featured, meta_title, meta_description) VALUES
('Quạt cây Panasonic F-14MS1', 'quat-cay-panasonic-f-14ms1', 8, 1, 'quat',
'Quạt cây Panasonic F-14MS1 với thiết kế hiện đại, 3 tốc độ gió, chế độ hẹn giờ thông minh. Tiết kiệm điện, an toàn cho gia đình.',
'Quạt cây 3 tốc độ, công suất 45W, đường kính cánh 14 inch, chế độ hẹn giờ',
1200000, 1100000, 'PAN-F14MS1', 25, 8, 4.2, TRUE, TRUE,
'Quạt cây Panasonic F-14MS1 - 3 tốc độ',
'Quạt cây Panasonic F-14MS1, 3 tốc độ gió, công suất 45W, đường kính cánh 14 inch. Chế độ hẹn giờ thông minh, tiết kiệm điện.'),

('Quạt cây Toshiba VH-S15ME', 'quat-cay-toshiba-vh-s15me', 8, 6, 'quat',
'Quạt cây Toshiba VH-S15ME với thiết kế sang trọng, 5 tốc độ gió, chế độ tự động xoay. Động cơ bền bỉ, tiếng ồn thấp.',
'Quạt cây 5 tốc độ, công suất 50W, đường kính cánh 15 inch, tự động xoay',
1500000, 1350000, 'TOS-VHS15ME', 20, 5, 5.1, TRUE, FALSE,
'Quạt cây Toshiba VH-S15ME - 5 tốc độ',
'Quạt cây Toshiba VH-S15ME, 5 tốc độ gió, công suất 50W, đường kính cánh 15 inch. Chế độ tự động xoay, tiếng ồn thấp.'),

-- Quạt trần
INSERT INTO products (name, slug, category_id, brand_id, product_type, description, short_description, price, sale_price, sku, stock_quantity, min_stock_level, weight, status, is_featured, meta_title, meta_description) VALUES
('Quạt trần Panasonic F-M14D9', 'quat-tran-panasonic-f-m14d9', 4, 1, 'quat_tron',
'Quạt trần Panasonic F-M14D9 với thiết kế trang trí hiện đại, 3 tốc độ gió, điều khiển từ xa. Phù hợp cho phòng khách và phòng ngủ.',
'Quạt trần trang trí, 3 tốc độ, công suất 60W, đường kính cánh 14 inch, điều khiển từ xa',
2800000, 2500000, 'PAN-FM14D9', 15, 4, 8.8, TRUE, TRUE,
'Quạt trần Panasonic F-M14D9 - Trang trí hiện đại',
'Quạt trần Panasonic F-M14D9, thiết kế trang trí hiện đại, 3 tốc độ gió, điều khiển từ xa. Phù hợp phòng khách và phòng ngủ.'),

-- Động cơ điện
INSERT INTO products (name, slug, category_id, brand_id, product_type, description, short_description, price, sale_price, sku, stock_quantity, min_stock_level, weight, status, is_featured, meta_title, meta_description) VALUES
('Động cơ điện Mitsubishi 0.75kW', 'dong-co-dien-mitsubishi-075kw', 5, 2, 'motor',
'Động cơ điện Mitsubishi 0.75kW với hiệu suất cao, tiết kiệm điện năng. Phù hợp cho máy móc công nghiệp và hệ thống bơm nước.',
'Động cơ điện 0.75kW, 220V/380V, tốc độ 1450rpm, hiệu suất cao',
8500000, 7800000, 'MIT-075KW', 6, 2, 25.0, TRUE, FALSE,
'Động cơ điện Mitsubishi 0.75kW - Công nghiệp',
'Động cơ điện Mitsubishi 0.75kW, 220V/380V, tốc độ 1450rpm. Hiệu suất cao, tiết kiệm điện, phù hợp máy móc công nghiệp.');

-- ========================================
-- PRODUCT IMAGES (Hình ảnh sản phẩm)
-- ========================================

-- Hình ảnh cho Máy bơm tăng áp Panasonic GP-129JXK
INSERT INTO product_images (product_id, url, alt_text, sort_order, is_primary) VALUES
(1, '/image/products/panasonic-gp-129jxk-1.jpg', 'Máy bơm tăng áp Panasonic GP-129JXK - Góc chính', 1, TRUE),
(1, '/image/products/panasonic-gp-129jxk-2.jpg', 'Máy bơm tăng áp Panasonic GP-129JXK - Góc nghiêng', 2, FALSE),
(1, '/image/products/panasonic-gp-129jxk-3.jpg', 'Máy bơm tăng áp Panasonic GP-129JXK - Thông số kỹ thuật', 3, FALSE),
(1, '/image/products/panasonic-gp-129jxk-4.jpg', 'Máy bơm tăng áp Panasonic GP-129JXK - Bảo hành', 4, FALSE);

-- Hình ảnh cho Máy bơm tăng áp Grundfos UPA 15-90
INSERT INTO product_images (product_id, url, alt_text, sort_order, is_primary) VALUES
(2, '/image/products/grundfos-upa-15-90-1.jpg', 'Máy bơm tăng áp Grundfos UPA 15-90 - Góc chính', 1, TRUE),
(2, '/image/products/grundfos-upa-15-90-2.jpg', 'Máy bơm tăng áp Grundfos UPA 15-90 - Góc nghiêng', 2, FALSE),
(2, '/image/products/grundfos-upa-15-90-3.jpg', 'Máy bơm tăng áp Grundfos UPA 15-90 - Thông số', 3, FALSE);

-- Hình ảnh cho Máy bơm ly tâm Wilo PB-088EA
INSERT INTO product_images (product_id, url, alt_text, sort_order, is_primary) VALUES
(3, '/image/products/wilo-pb-088ea-1.jpg', 'Máy bơm ly tâm Wilo PB-088EA - Góc chính', 1, TRUE),
(3, '/image/products/wilo-pb-088ea-2.jpg', 'Máy bơm ly tâm Wilo PB-088EA - Góc nghiêng', 2, FALSE),
(3, '/image/products/wilo-pb-088ea-3.jpg', 'Máy bơm ly tâm Wilo PB-088EA - Động cơ', 3, FALSE),
(3, '/image/products/wilo-pb-088ea-4.jpg', 'Máy bơm ly tâm Wilo PB-088EA - Bảo hành', 4, FALSE);

-- Hình ảnh cho Máy bơm chìm DAB FEKA VS 750 M-A
INSERT INTO product_images (product_id, url, alt_text, sort_order, is_primary) VALUES
(4, '/image/products/dab-feka-vs-750-1.jpg', 'Máy bơm chìm DAB FEKA VS 750 M-A - Góc chính', 1, TRUE),
(4, '/image/products/dab-feka-vs-750-2.jpg', 'Máy bơm chìm DAB FEKA VS 750 M-A - Góc nghiêng', 2, FALSE),
(4, '/image/products/dab-feka-vs-750-3.jpg', 'Máy bơm chìm DAB FEKA VS 750 M-A - Cáp điện', 3, FALSE);

-- Hình ảnh cho Quạt cây Panasonic F-14MS1
INSERT INTO product_images (product_id, url, alt_text, sort_order, is_primary) VALUES
(5, '/image/products/panasonic-f-14ms1-1.jpg', 'Quạt cây Panasonic F-14MS1 - Góc chính', 1, TRUE),
(5, '/image/products/panasonic-f-14ms1-2.jpg', 'Quạt cây Panasonic F-14MS1 - Góc nghiêng', 2, FALSE),
(5, '/image/products/panasonic-f-14ms1-3.jpg', 'Quạt cây Panasonic F-14MS1 - Điều khiển', 3, FALSE),
(5, '/image/products/panasonic-f-14ms1-4.jpg', 'Quạt cây Panasonic F-14MS1 - Bảo hành', 4, FALSE);

-- Hình ảnh cho Quạt cây Toshiba VH-S15ME
INSERT INTO product_images (product_id, url, alt_text, sort_order, is_primary) VALUES
(6, '/image/products/toshiba-vh-s15me-1.jpg', 'Quạt cây Toshiba VH-S15ME - Góc chính', 1, TRUE),
(6, '/image/products/toshiba-vh-s15me-2.jpg', 'Quạt cây Toshiba VH-S15ME - Góc nghiêng', 2, FALSE),
(6, '/image/products/toshiba-vh-s15me-3.jpg', 'Quạt cây Toshiba VH-S15ME - Điều khiển', 3, FALSE);

-- Hình ảnh cho Quạt trần Panasonic F-M14D9
INSERT INTO product_images (product_id, url, alt_text, sort_order, is_primary) VALUES
(7, '/image/products/panasonic-f-m14d9-1.jpg', 'Quạt trần Panasonic F-M14D9 - Góc chính', 1, TRUE),
(7, '/image/products/panasonic-f-m14d9-2.jpg', 'Quạt trần Panasonic F-M14D9 - Góc nghiêng', 2, FALSE),
(7, '/image/products/panasonic-f-m14d9-3.jpg', 'Quạt trần Panasonic F-M14D9 - Điều khiển từ xa', 3, FALSE),
(7, '/image/products/panasonic-f-m14d9-4.jpg', 'Quạt trần Panasonic F-M14D9 - Lắp đặt', 4, FALSE);

-- Hình ảnh cho Động cơ điện Mitsubishi 0.75kW
INSERT INTO product_images (product_id, url, alt_text, sort_order, is_primary) VALUES
(8, '/image/products/mitsubishi-075kw-1.jpg', 'Động cơ điện Mitsubishi 0.75kW - Góc chính', 1, TRUE),
(8, '/image/products/mitsubishi-075kw-2.jpg', 'Động cơ điện Mitsubishi 0.75kW - Góc nghiêng', 2, FALSE),
(8, '/image/products/mitsubishi-075kw-3.jpg', 'Động cơ điện Mitsubishi 0.75kW - Thông số', 3, FALSE);

-- ========================================
-- BOM DETAILS (Chi tiết máy bơm)
-- ========================================

INSERT INTO bom_details (product_id, cong_suat, hut_sau, cot_ap, luu_luong, ong, dien_ap, dong_dien, duong_kinh_day, warranty_months) VALUES
(1, '125W', '8m', '25m', '25L/phút', '1 inch', '220V', '0.8A', '1.5mm²', 12),
(2, '120W', '8m', '9m', '25L/phút', '1 inch', '220V', '0.7A', '1.5mm²', 24),
(3, '370W', '8m', '35m', '50L/phút', '1.5 inch', '220V', '2.1A', '2.5mm²', 12);

-- ========================================
-- BOM CHIM DETAILS (Chi tiết máy bơm chìm)
-- ========================================

INSERT INTO bom_chim_details (product_id, cong_suat, hut_sau, cot_ap, luu_luong, ong, dien_ap, dong_dien, duong_kinh_day, warranty_months) VALUES
(4, '750W', '20m', '60m', '15L/phút', '1 inch', '220V', '4.2A', '4mm²', 12);

-- ========================================
-- QUAT DETAILS (Chi tiết quạt)
-- ========================================

INSERT INTO quat_details (product_id, cong_suat, duong_kinh_canh, toc_do_gio, che_do_hoat_dong, warranty_months) VALUES
(5, '45W', '14 inch', '3 tốc độ', 'Thường + Hẹn giờ', 12),
(6, '50W', '15 inch', '5 tốc độ', 'Thường + Tự động xoay', 12);

-- ========================================
-- MOTOR DETAILS (Chi tiết động cơ)
-- ========================================

INSERT INTO motor_details (product_id, cong_suat, dien_ap, toc_do, hieu_suat, warranty_months) VALUES
(8, '0.75kW', '220V/380V', '1450rpm', '85%', 12);

-- ========================================
-- CẬP NHẬT SLUG CHO SẢN PHẨM
-- ========================================

UPDATE products SET slug = 'may-bom-tang-ap-panasonic-gp-129jxk' WHERE id = 1;
UPDATE products SET slug = 'may-bom-tang-ap-grundfos-upa-15-90' WHERE id = 2;
UPDATE products SET slug = 'may-bom-ly-tam-wilo-pb-088ea' WHERE id = 3;
UPDATE products SET slug = 'may-bom-chim-dab-feka-vs-750-m-a' WHERE id = 4;
UPDATE products SET slug = 'quat-cay-panasonic-f-14ms1' WHERE id = 5;
UPDATE products SET slug = 'quat-cay-toshiba-vh-s15me' WHERE id = 6;
UPDATE products SET slug = 'quat-tran-panasonic-f-m14d9' WHERE id = 7;
UPDATE products SET slug = 'dong-co-dien-mitsubishi-075kw' WHERE id = 8;

-- ========================================
-- THÔNG BÁO HOÀN THÀNH
-- ========================================

SELECT 'Dữ liệu test đã được thêm thành công!' as message;
SELECT COUNT(*) as total_categories FROM categories;
SELECT COUNT(*) as total_brands FROM brands;
SELECT COUNT(*) as total_products FROM products;
SELECT COUNT(*) as total_product_images FROM product_images; 