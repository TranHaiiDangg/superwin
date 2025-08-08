-- =====================================================
-- SUPERWIN TEST DATA INSERT SCRIPT
-- =====================================================
-- File: database/test_data.sql
-- Date: 2025-01-08
-- Description: Test data for SuperWin e-commerce database
-- =====================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- =====================================================
-- 1. INSERT BRANDS
-- =====================================================
INSERT INTO `brands` (`id`, `name`, `image`, `description`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'SuperWin', '/image/logo.png', 'Thương hiệu máy bơm nước và quạt công nghiệp hàng đầu Việt Nam', 1, 1, NOW(), NOW()),
(2, 'Deton', '/image/logothc.png', 'Chuyên sản xuất quạt thông gió chất lượng cao', 1, 2, NOW(), NOW()),
(3, 'STHC', '/image/logothc.png', 'Công ty cổ phần Sài Gòn Thủ Đức', 1, 3, NOW(), NOW()),
(4, 'Vina Pump', '/image/logo.png', 'Máy bơm công nghiệp Việt Nam', 1, 4, NOW(), NOW()),
(5, 'ABC Motor', '/image/logo.png', 'Động cơ điện chuyên nghiệp', 1, 5, NOW(), NOW()),
(6, 'Inverter Fan', '/image/logo.png', 'Quạt biến tần cao cấp', 1, 6, NOW(), NOW());

-- =====================================================
-- 2. INSERT CATEGORIES
-- =====================================================
INSERT INTO `categories` (`id`, `name`, `parent_id`, `product_type`, `image`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
-- Root Categories
(1, 'Máy bơm nước', NULL, 'bom', '/image/bom.png', 'Máy bơm nước các loại', 1, 1, NOW(), NOW()),
(2, 'Quạt công nghiệp', NULL, 'quat', '/image/quat.png', 'Quạt thông gió công nghiệp', 2, 1, NOW(), NOW()),
(3, 'Động cơ điện', NULL, 'motor', '/image/quat.png', 'Động cơ điện công nghiệp', 3, 1, NOW(), NOW()),
(4, 'Máy bơm chìm', NULL, 'bom_chim', '/image/bom_chim.png', 'Máy bơm chìm nước thải', 4, 1, NOW(), NOW()),
(5, 'Quạt tròn', NULL, 'quat_tron', '/image/quat_tron.png', 'Quạt tròn thông gió', 5, 1, NOW(), NOW()),

-- Sub Categories for Máy bơm nước
(6, 'Máy bơm nước biển', 1, 'bom', '/image/bom.png', 'Máy bơm nước biển chống ăn mòn', 1, 1, NOW(), NOW()),
(7, 'Máy bơm hồ bơi', 1, 'bom', '/image/bom.png', 'Máy bơm dành cho hồ bơi', 2, 1, NOW(), NOW()),
(8, 'Máy bơm nhập khẩu', 1, 'bom', '/image/bom.png', 'Máy bơm nhập khẩu chất lượng cao', 3, 1, NOW(), NOW()),

-- Sub Categories for Quạt công nghiệp
(9, 'Quạt thông gió vuông SuperWin', 2, 'quat', '/image/quat_vuong.png', 'Quạt thông gió vuông thương hiệu SuperWin', 1, 1, NOW(), NOW()),
(10, 'Quạt thông gió vuông Deton', 2, 'quat', '/image/quat_vuong.png', 'Quạt thông gió vuông thương hiệu Deton', 2, 1, NOW(), NOW()),
(11, 'Quạt thông gió tròn', 2, 'quat_tron', '/image/quat_tron.png', 'Quạt thông gió hình tròn', 3, 1, NOW(), NOW()),

-- Sub Categories for Quạt đặc biệt
(12, 'Quạt hướng trục nối ống', 2, 'quat', '/image/quat.png', 'Quạt hướng trục nối ống thông gió', 4, 1, NOW(), NOW()),
(13, 'Quạt sàn công nghiệp', 2, 'quat', '/image/quat.png', 'Quạt sàn công nghiệp di động', 5, 1, NOW(), NOW()),
(14, 'Quạt trần công nghiệp', 2, 'quat', '/image/quat_tran.png', 'Quạt trần công nghiệp', 6, 1, NOW(), NOW()),
(15, 'Quạt chống cháy nổ', 2, 'quat', '/image/quat.png', 'Quạt chống cháy nổ an toàn', 7, 1, NOW(), NOW());

-- =====================================================
-- 3. INSERT PRODUCTS
-- =====================================================
INSERT INTO `products` (`id`, `name`, `slug`, `category_id`, `brand_id`, `product_type`, `description`, `short_description`, `price`, `sale_price`, `sku`, `stock_quantity`, `min_stock_level`, `weight`, `status`, `is_featured`, `is_sale`, `view_count`, `sold_count`, `rating_average`, `rating_count`, `meta_title`, `meta_description`, `meta_keywords`, `meta_robots`, `meta_author`, `meta_canonical_url`, `power`, `voltage`, `flow_rate`, `pressure`, `efficiency`, `noise_level`, `warranty_period`, `created_at`, `updated_at`) VALUES

-- Máy bơm nước
(1, 'Máy bơm nước SuperWin SW-100', 'may-bom-nuoc-superwin-sw-100', 1, 1, 'bom',
'Máy bơm nước SuperWin SW-100 là sản phẩm chất lượng cao, được thiết kế để bơm nước hiệu quả với công suất mạnh mẽ. Sản phẩm có khả năng chống ăn mòn tốt, độ bền cao và vận hành êm ái. Thích hợp sử dụng cho các hệ thống cấp nước sinh hoạt, công nghiệp và nông nghiệp.',
'Máy bơm nước SuperWin SW-100 công suất 1HP, lưu lượng 2000L/h',
2500000, 2200000, 'SPSWBM0001', 50, 5, 25.5, 1, 1, 1, 156, 12, 4.5, 8,
'Máy bơm nước SuperWin SW-100 - Chất lượng cao, giá tốt',
'Mua máy bơm nước SuperWin SW-100 chính hãng với giá ưu đãi. Bảo hành 24 tháng, giao hàng toàn quốc',
'máy bơm nước, superwin, sw-100, bơm nước công nghiệp', 'index,follow', 'SuperWin',
'https://superwin.com/products/may-bom-nuoc-superwin-sw-100',
'1HP (750W)', '220V/1 Phase', '2000 L/h', '35m', '85%', '≤55dB', '24 tháng', NOW(), NOW()),

(2, 'Máy bơm chìm Vina Pump VP-200', 'may-bom-chim-vina-pump-vp-200', 4, 4, 'bom_chim',
'Máy bơm chìm Vina Pump VP-200 chuyên dụng cho việc bơm nước thải, nước ngầm và các ứng dụng công nghiệp. Thiết kế compact, dễ lắp đặt và bảo trì. Motor được bảo vệ hoàn toàn bằng dầu mineral cao cấp.',
'Máy bơm chìm VP-200 công suất 2HP, độ sâu tối đa 15m',
4200000, 3800000, 'SPVPBC0002', 30, 3, 18.2, 1, 1, 1, 89, 8, 4.3, 5,
'Máy bơm chìm Vina Pump VP-200 - Bơm nước thải hiệu quả',
'Máy bơm chìm Vina Pump VP-200 chất lượng cao, phù hợp bơm nước thải, nước ngầm. Bảo hành chính hãng 18 tháng',
'máy bơm chìm, vina pump, vp-200, bơm nước thải, bơm nước ngầm', 'index,follow', 'SuperWin',
'https://superwin.com/products/may-bom-chim-vina-pump-vp-200',
'2HP (1500W)', '220V/1 Phase', '3500 L/h', '15m', '82%', '≤60dB', '18 tháng', NOW(), NOW()),

-- Quạt công nghiệp
(3, 'Quạt thông gió vuông SuperWin SWF-300', 'quat-thong-gio-vuong-superwin-swf-300', 9, 1, 'quat',
'Quạt thông gió vuông SuperWin SWF-300 với thiết kế hiện đại, lưu lượng gió lớn và tiết kiệm điện năng. Thích hợp lắp đặt cho nhà xưởng, nhà kho, văn phòng. Cánh quạt được thiết kế khí động học tối ưu.',
'Quạt thông gió vuông SWF-300, kích thước 300x300mm',
1800000, 1600000, 'SPSWQT0003', 25, 5, 8.5, 1, 1, 1, 203, 18, 4.7, 12,
'Quạt thông gió vuông SuperWin SWF-300 - Lưu lượng gió lớn',
'Quạt thông gió vuông SuperWin SWF-300 chính hãng, lưu lượng gió 3200m³/h, tiết kiệm điện. Bảo hành 12 tháng',
'quạt thông gió, superwin, swf-300, quạt vuông, thông gió nhà xưởng', 'index,follow', 'SuperWin',
'https://superwin.com/products/quat-thong-gio-vuong-superwin-swf-300',
'120W', '220V/1 Phase', '3200 m³/h', '45 Pa', '78%', '≤52dB', '12 tháng', NOW(), NOW()),

(4, 'Quạt trần công nghiệp Deton DT-1400', 'quat-tran-cong-nghiep-deton-dt-1400', 14, 2, 'quat',
'Quạt trần công nghiệp Deton DT-1400 với đường kính cánh quạt 1400mm, phù hợp cho không gian lớn. Thiết kế chắc chắn, vận hành êm ái và tiết kiệm điện năng. Motor chất lượng cao đảm bảo độ bền lâu dài.',
'Quạt trần công nghiệp DT-1400, đường kính 1400mm',
3200000, 2900000, 'SPDTQT0004', 15, 3, 12.8, 1, 0, 1, 134, 6, 4.2, 4,
'Quạt trần công nghiệp Deton DT-1400 - Phù hợp không gian lớn',
'Quạt trần công nghiệp Deton DT-1400 đường kính 1400mm, lưu lượng gió 28000m³/h, tiết kiệm điện năng',
'quạt trần công nghiệp, deton, dt-1400, quạt trần, thông gió công nghiệp', 'index,follow', 'SuperWin',
'https://superwin.com/products/quat-tran-cong-nghiep-deton-dt-1400',
'200W', '220V/1 Phase', '28000 m³/h', '65 Pa', '85%', '≤48dB', '18 tháng', NOW(), NOW()),

(5, 'Quạt hướng trục STHC ST-400', 'quat-huong-truc-sthc-st-400', 12, 3, 'quat',
'Quạt hướng trục STHC ST-400 chuyên dụng cho hệ thống ống gió. Thiết kế compact, lắp đặt dễ dàng. Cánh quạt được thiết kế tối ưu để tạo áp suất cao, phù hợp cho các hệ thống thông gió dài.',
'Quạt hướng trục ST-400, kết nối ống gió φ400mm',
2200000, NULL, 'SPSTHC0005', 40, 5, 6.2, 1, 1, 0, 98, 15, 4.4, 7,
'Quạt hướng trục STHC ST-400 - Chuyên dụng ống gió',
'Quạt hướng trục STHC ST-400 kết nối ống gió φ400mm, áp suất cao, phù hợp hệ thống thông gió dài',
'quạt hướng trục, sthc, st-400, quạt ống gió, thông gió ống dài', 'index,follow', 'SuperWin',
'https://superwin.com/products/quat-huong-truc-sthc-st-400',
'150W', '220V/1 Phase', '2800 m³/h', '180 Pa', '72%', '≤58dB', '12 tháng', NOW(), NOW()),

-- Động cơ điện
(6, 'Động cơ điện ABC 3HP', 'dong-co-dien-abc-3hp', 3, 5, 'motor',
'Động cơ điện ABC 3HP với công nghệ tiên tiến, hiệu suất cao và độ bền vượt trội. Thích hợp cho máy bơm, quạt công nghiệp và các thiết bị cơ khí khác. Thiết kế chống ẩm, chống bụi IP55.',
'Động cơ điện ABC 3HP, 3 phase, 1450 rpm',
5800000, 5200000, 'SPABCMT0006', 20, 2, 28.5, 1, 0, 1, 67, 3, 4.6, 3,
'Động cơ điện ABC 3HP - Hiệu suất cao, độ bền vượt trội',
'Động cơ điện ABC 3HP chính hãng, hiệu suất cao, độ bền vượt trội. Thích hợp máy bơm, quạt công nghiệp',
'động cơ điện, abc motor, 3hp, motor 3 phase, động cơ công nghiệp', 'index,follow', 'SuperWin',
'https://superwin.com/products/dong-co-dien-abc-3hp',
'3HP (2200W)', '380V/3 Phase', NULL, NULL, '87%', '≤65dB', '12 tháng', NOW(), NOW()),

-- Quạt tròn
(7, 'Quạt tròn Inverter Fan IF-250', 'quat-tron-inverter-fan-if-250', 5, 6, 'quat_tron',
'Quạt tròn Inverter Fan IF-250 với công nghệ biến tần tiết kiệm điện. Thiết kế aerodynamic giảm tiếng ồn và tăng hiệu suất. Phù hợp cho hệ thống thông gió chính xác.',
'Quạt tròn IF-250 biến tần, đường kính 250mm',
2800000, 2500000, 'SPIFQR0007', 35, 3, 5.8, 1, 1, 1, 112, 9, 4.8, 6,
'Quạt tròn Inverter Fan IF-250 - Công nghệ biến tần',
'Quạt tròn Inverter Fan IF-250 công nghệ biến tần tiết kiệm điện, thiết kế aerodynamic giảm tiếng ồn',
'quạt tròn, inverter fan, if-250, quạt biến tần, tiết kiệm điện', 'index,follow', 'SuperWin',
'https://superwin.com/products/quat-tron-inverter-fan-if-250',
'80W', '220V/1 Phase', '1800 m³/h', '120 Pa', '82%', '≤42dB', '24 tháng', NOW(), NOW()),

(8, 'Máy bơm nước biển SuperWin SWM-150', 'may-bom-nuoc-bien-superwin-swm-150', 6, 1, 'bom',
'Máy bơm nước biển SuperWin SWM-150 chuyên dụng cho môi trường nước mặn. Vỏ máy và cánh bơm được làm từ hợp kim chống ăn mòn đặc biệt. Phù hợp cho nuôi trồng thủy sản và công nghiệp ven biển.',
'Máy bơm nước biển SWM-150 chống ăn mòn, 1.5HP',
3800000, 3400000, 'SPSWBM0008', 25, 3, 22.3, 1, 1, 1, 78, 5, 4.4, 4,
'Máy bơm nước biển SuperWin SWM-150 - Chống ăn mòn',
'Máy bơm nước biển SuperWin SWM-150 chuyên dụng nước mặn, chống ăn mòn, phù hợp nuôi trồng thủy sản',
'máy bơm nước biển, superwin, swm-150, bơm nước mặn, chống ăn mòn', 'index,follow', 'SuperWin',
'https://superwin.com/products/may-bom-nuoc-bien-superwin-swm-150',
'1.5HP (1100W)', '220V/1 Phase', '2800 L/h', '28m', '83%', '≤58dB', '18 tháng', NOW(), NOW()),

(9, 'Quạt chống cháy nổ SuperWin EX-400', 'quat-chong-chay-no-superwin-ex-400', 15, 1, 'quat',
'Quạt chống cháy nổ SuperWin EX-400 được thiết kế đặc biệt cho môi trường có nguy cơ cháy nổ. Đạt tiêu chuẩn ATEX, motor chống cháy nổ Ex d IIB T4. Thích hợp cho nhà máy hóa chất, kho xăng dầu.',
'Quạt chống cháy nổ EX-400, tiêu chuẩn ATEX',
8500000, 7800000, 'SPSWEX0009', 10, 2, 15.8, 1, 0, 1, 45, 2, 4.9, 2,
'Quạt chống cháy nổ SuperWin EX-400 - Tiêu chuẩn ATEX',
'Quạt chống cháy nổ SuperWin EX-400 đạt tiêu chuẩn ATEX, motor Ex d IIB T4, an toàn cho môi trường cháy nổ',
'quạt chống cháy nổ, superwin, ex-400, atex, quạt an toàn', 'index,follow', 'SuperWin',
'https://superwin.com/products/quat-chong-chay-no-superwin-ex-400',
'250W', '220V/1 Phase', '3500 m³/h', '200 Pa', '75%', '≤60dB', '24 tháng', NOW(), NOW()),

(10, 'Máy bơm hồ bơi Vina Pump VP-POOL', 'may-bom-ho-boi-vina-pump-vp-pool', 7, 4, 'bom',
'Máy bơm hồ bơi Vina Pump VP-POOL thiết kế chuyên dụng cho hệ thống lọc nước hồ bơi. Vỏ nhựa ABS bền bỉ, motor tự mồi, vận hành êm ái. Tích hợp hệ thống lọc sơ bộ.',
'Máy bơm hồ bơi VP-POOL, tự mồi, lọc nước',
4500000, NULL, 'SPVPPL0010', 18, 2, 16.2, 1, 1, 0, 92, 7, 4.3, 5,
'Máy bơm hồ bơi Vina Pump VP-POOL - Chuyên dụng hồ bơi',
'Máy bơm hồ bơi Vina Pump VP-POOL chuyên dụng lọc nước hồ bơi, tự mồi, vận hành êm ái',
'máy bơm hồ bơi, vina pump, vp-pool, bơm lọc nước, hồ bơi', 'index,follow', 'SuperWin',
'https://superwin.com/products/may-bom-ho-boi-vina-pump-vp-pool',
'1HP (750W)', '220V/1 Phase', '12000 L/h', '12m', '80%', '≤52dB', '12 tháng', NOW(), NOW());

-- =====================================================
-- 4. INSERT PRODUCT IMAGES
-- =====================================================
INSERT INTO `product_images` (`id`, `product_id`, `url`, `alt_text`, `sort_order`, `is_primary`, `is_base`, `created_at`, `updated_at`) VALUES
-- Images for product 1
(1, 1, '/image/sp1.png', 'Máy bơm nước SuperWin SW-100', 1, 1, 1, NOW(), NOW()),
(2, 1, '/image/bom.png', 'Máy bơm nước SuperWin SW-100 - Góc cạnh', 2, 0, 0, NOW(), NOW()),

-- Images for product 2
(3, 2, '/image/bom_chim.png', 'Máy bơm chìm Vina Pump VP-200', 1, 1, 1, NOW(), NOW()),
(4, 2, '/image/sp1.png', 'Máy bơm chìm Vina Pump VP-200 - Chi tiết', 2, 0, 0, NOW(), NOW()),

-- Images for product 3
(5, 3, '/image/quat_vuong.png', 'Quạt thông gió vuông SuperWin SWF-300', 1, 1, 1, NOW(), NOW()),
(6, 3, '/image/quat.png', 'Quạt thông gió vuông SuperWin SWF-300 - Mặt nghiêng', 2, 0, 0, NOW(), NOW()),

-- Images for product 4
(7, 4, '/image/quat_tran.png', 'Quạt trần công nghiệp Deton DT-1400', 1, 1, 1, NOW(), NOW()),

-- Images for product 5
(8, 5, '/image/quat.png', 'Quạt hướng trục STHC ST-400', 1, 1, 1, NOW(), NOW()),

-- Images for product 6
(9, 6, '/image/sp1.png', 'Động cơ điện ABC 3HP', 1, 1, 1, NOW(), NOW()),

-- Images for product 7
(10, 7, '/image/quat_tron.png', 'Quạt tròn Inverter Fan IF-250', 1, 1, 1, NOW(), NOW()),

-- Images for product 8
(11, 8, '/image/bom.png', 'Máy bơm nước biển SuperWin SWM-150', 1, 1, 1, NOW(), NOW()),

-- Images for product 9
(12, 9, '/image/quat.png', 'Quạt chống cháy nổ SuperWin EX-400', 1, 1, 1, NOW(), NOW()),

-- Images for product 10
(13, 10, '/image/bom.png', 'Máy bơm hồ bơi Vina Pump VP-POOL', 1, 1, 1, NOW(), NOW());

-- =====================================================
-- 5. INSERT PRODUCT SPECIFICATIONS (Details)
-- =====================================================

-- Bom Details for regular pumps
INSERT INTO `bom_details` (`product_id`, `cong_suat`, `hut_sau`, `cot_ap`, `luu_luong`, `ong`, `dien_ap`, `dong_dien`, `duong_kinh_day`, `warranty_months`) VALUES
(1, '1HP (750W)', '8m', '35m', '2000 L/h', 'Φ50mm', '220V', '4.2A', 'Φ50mm', 24),
(8, '1.5HP (1100W)', '6m', '28m', '2800 L/h', 'Φ65mm', '220V', '5.8A', 'Φ65mm', 18),
(10, '1HP (750W)', '5m', '12m', '12000 L/h', 'Φ100mm', '220V', '4.0A', 'Φ100mm', 12);

-- Bom Chim Details for submersible pumps
INSERT INTO `bom_chim_details` (`product_id`, `cong_suat`, `dien_ap`, `cot_ap`, `luu_luong`, `ong`, `dong_dien`, `max_depth`, `warranty_months`) VALUES
(2, '2HP (1500W)', '220V', '15m', '3500 L/h', 'Φ80mm', '7.2A', '15m', 18);

-- Quat Details for fans
INSERT INTO `quat_details` (`product_id`, `duong_kinh_canh`, `dien_ap`, `cong_suat`, `luong_gio`, `toc_do`, `do_on`, `dien_tich_lam_mat`, `cot_ap`, `warranty_months`) VALUES
(3, '300mm', '220V', '120W', '3200 m³/h', '1450 rpm', '≤52dB', '25-30m²', '45 Pa', 12),
(4, '1400mm', '220V', '200W', '28000 m³/h', '320 rpm', '≤48dB', '200-300m²', '65 Pa', 18),
(5, '400mm', '220V', '150W', '2800 m³/h', '1200 rpm', '≤58dB', '20-25m²', '180 Pa', 12),
(7, '250mm', '220V', '80W', '1800 m³/h', '1600 rpm', '≤42dB', '15-20m²', '120 Pa', 24),
(9, '400mm', '220V', '250W', '3500 m³/h', '1100 rpm', '≤60dB', '30-40m²', '200 Pa', 24);

-- Motor Details
INSERT INTO `motor_details` (`product_id`, `cong_suat`, `dien_ap`, `toc_do`, `loai_dong_co`, `hieu_suat`, `warranty_months`) VALUES
(6, '3HP (2200W)', '380V/3 Phase', '1450 rpm', 'Induction Motor', '87%', 12);

-- =====================================================
-- 6. INSERT PRODUCT ATTRIBUTES
-- =====================================================
INSERT INTO `product_attributes` (`product_id`, `attribute_key`, `attribute_value`, `attribute_unit`, `attribute_description`, `sort_order`, `is_visible`, `created_at`, `updated_at`) VALUES
-- Attributes for Product 1 (Máy bơm SuperWin SW-100)
(1, 'material', 'Cast Iron', NULL, 'Chất liệu vỏ máy', 1, 1, NOW(), NOW()),
(1, 'inlet_size', '50', 'mm', 'Đường kính đầu hút', 2, 1, NOW(), NOW()),
(1, 'outlet_size', '40', 'mm', 'Đường kính đầu đẩy', 3, 1, NOW(), NOW()),
(1, 'weight', '25.5', 'kg', 'Trọng lượng', 4, 1, NOW(), NOW()),
(1, 'protection_class', 'IP55', NULL, 'Cấp độ bảo vệ', 5, 1, NOW(), NOW()),

-- Attributes for Product 2 (Máy bơm chìm VP-200)
(2, 'material', 'Stainless Steel', NULL, 'Chất liệu vỏ máy', 1, 1, NOW(), NOW()),
(2, 'cable_length', '10', 'm', 'Chiều dài cáp điện', 2, 1, NOW(), NOW()),
(2, 'float_switch', 'Có', NULL, 'Phao tự động', 3, 1, NOW(), NOW()),
(2, 'particle_size', '35', 'mm', 'Kích thước hạt tối đa', 4, 1, NOW(), NOW()),

-- Attributes for Product 3 (Quạt SuperWin SWF-300)
(3, 'blade_material', 'Aluminum', NULL, 'Chất liệu cánh quạt', 1, 1, NOW(), NOW()),
(3, 'housing_material', 'Galvanized Steel', NULL, 'Chất liệu vỏ quạt', 2, 1, NOW(), NOW()),
(3, 'speed_control', 'Single Speed', NULL, 'Điều khiển tốc độ', 3, 1, NOW(), NOW()),
(3, 'mounting_type', 'Wall/Window', NULL, 'Kiểu lắp đặt', 4, 1, NOW(), NOW());

-- =====================================================
-- 7. INSERT FLASH DEALS
-- =====================================================
INSERT INTO `flash_deals` (`product_id`, `title`, `discount_type`, `discount_value`, `original_price`, `sale_price`, `quantity_limit`, `sold_quantity`, `start_time`, `end_time`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Flash Deal - Máy bơm SuperWin SW-100', 'percentage', 12.00, 2500000, 2200000, 50, 12, DATE_SUB(NOW(), INTERVAL 2 DAY), DATE_ADD(NOW(), INTERVAL 5 DAY), 1, NOW(), NOW()),
(2, 'Giảm giá sốc - Máy bơm chìm VP-200', 'fixed_amount', 400000, 4200000, 3800000, 30, 8, DATE_SUB(NOW(), INTERVAL 1 DAY), DATE_ADD(NOW(), INTERVAL 7 DAY), 1, NOW(), NOW()),
(3, 'Hot Deal - Quạt thông gió SWF-300', 'percentage', 11.11, 1800000, 1600000, 25, 18, NOW(), DATE_ADD(NOW(), INTERVAL 3 DAY), 1, NOW(), NOW());

-- =====================================================
-- 8. INSERT BANNERS
-- =====================================================
INSERT INTO `banners` (`title`, `image`, `mobile_image`, `link`, `type`, `position`, `sort_order`, `is_active`, `start_date`, `end_date`, `click_count`, `created_at`, `updated_at`) VALUES
('Banner Chính - SuperWin', '/image/baner1.png', '/image/baner1.png', '/products', 'main_slider', 'main', 1, 1, DATE_SUB(NOW(), INTERVAL 7 DAY), DATE_ADD(NOW(), INTERVAL 30 DAY), 0, NOW(), NOW()),
('Banner Khuyến Mãi', '/image/baner2.png', '/image/baner2.png', '/deals', 'main_slider', 'main', 2, 1, DATE_SUB(NOW(), INTERVAL 7 DAY), DATE_ADD(NOW(), INTERVAL 30 DAY), 0, NOW(), NOW()),
('Banner Sản Phẩm Mới', '/image/baner3.png', '/image/baner3.png', '/products?featured=1', 'main_slider', 'main', 3, 1, DATE_SUB(NOW(), INTERVAL 7 DAY), DATE_ADD(NOW(), INTERVAL 30 DAY), 0, NOW(), NOW()),
('Banner Quạt Công Nghiệp', '/image/quat.png', '/image/quat.png', '/category/quat-cong-nghiep', 'promotion', 'sidebar', 1, 1, NOW(), DATE_ADD(NOW(), INTERVAL 15 DAY), 0, NOW(), NOW()),
('Banner Máy Bơm', '/image/bom.png', '/image/bom.png', '/category/may-bom-nuoc', 'promotion', 'sidebar', 2, 1, NOW(), DATE_ADD(NOW(), INTERVAL 15 DAY), 0, NOW(), NOW());

-- =====================================================
-- 9. INSERT USERS (Admin/Staff)
-- =====================================================
INSERT INTO `users` (`id`, `name`, `email`, `role`, `permissions`, `department`, `employee_id`, `hire_date`, `is_active`, `password`, `email_verified_at`, `last_login_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin SuperWin', 'admin@superwin.com', 'super_admin', NULL, 'IT', 'EMP001', '2024-01-01', 1, '$2y$12$LGHcF.VjWKKvhN4fF4rZneTQJnHU6bBZ1VsKHJCxEF9M5IZzFsFfS', NOW(), NULL, NULL, NOW(), NOW()),
(2, 'Nguyễn Văn A', 'manager@superwin.com', 'manager', NULL, 'Sales', 'EMP002', '2024-02-01', 1, '$2y$12$LGHcF.VjWKKvhN4fF4rZneTQJnHU6bBZ1VsKHJCxEF9M5IZzFsFfS', NOW(), NULL, NULL, NOW(), NOW()),
(3, 'Trần Thị B', 'staff@superwin.com', 'staff', NULL, 'Warehouse', 'EMP003', '2024-03-01', 1, '$2y$12$LGHcF.VjWKKvhN4fF4rZneTQJnHU6bBZ1VsKHJCxEF9M5IZzFsFfS', NOW(), NULL, NULL, NOW(), NOW());

-- =====================================================
-- 10. INSERT CUSTOMERS (Test customers)
-- =====================================================
INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `password`, `address`, `city`, `district`, `ward`, `status`, `customer_code`, `total_spent`, `loyalty_points`, `created_at`, `updated_at`) VALUES
(1, 'Khách Hàng Test 1', 'customer1@test.com', '0901234567', '$2y$12$LGHcF.VjWKKvhN4fF4rZneTQJnHU6bBZ1VsKHJCxEF9M5IZzFsFfS', '123 Nguyễn Văn Cừ', 'TP.HCM', 'Quận 5', 'Phường 1', 'active', 'KH0001', 5500000, 550, NOW(), NOW()),
(2, 'Khách Hàng Test 2', 'customer2@test.com', '0902345678', '$2y$12$LGHcF.VjWKKvhN4fF4rZneTQJnHU6bBZ1VsKHJCxEF9M5IZzFsFfS', '456 Lê Văn Sỹ', 'TP.HCM', 'Quận 3', 'Phường 12', 'active', 'KH0002', 2200000, 220, NOW(), NOW());

-- =====================================================
-- 11. INSERT SETTINGS
-- =====================================================
INSERT INTO `settings` (`key_name`, `value`, `description`, `type`, `created_at`, `updated_at`) VALUES
('site_name', 'SuperWin', 'Tên website', 'string', NOW(), NOW()),
('site_description', 'Chuyên cung cấp máy bơm nước và quạt công nghiệp chất lượng cao', 'Mô tả website', 'string', NOW(), NOW()),
('contact_phone', '1900-1234', 'Số điện thoại liên hệ', 'string', NOW(), NOW()),
('contact_email', 'info@superwin.com', 'Email liên hệ', 'string', NOW(), NOW()),
('contact_address', '123 Đường ABC, Quận XYZ, TP.HCM', 'Địa chỉ liên hệ', 'string', NOW(), NOW()),
('shipping_fee', '30000', 'Phí vận chuyển mặc định', 'number', NOW(), NOW()),
('vat_rate', '0.08', 'Thuế VAT (%)', 'number', NOW(), NOW()),
('min_order_amount', '500000', 'Đơn hàng tối thiểu', 'number', NOW(), NOW()),
('loyalty_point_rate', '0.01', 'Tỷ lệ tích điểm (1% = 0.01)', 'number', NOW(), NOW()),
('currency_symbol', '₫', 'Ký hiệu tiền tệ', 'string', NOW(), NOW());

SET FOREIGN_KEY_CHECKS = 1;

-- =====================================================
-- SUCCESS MESSAGE
-- =====================================================
SELECT 'Test data inserted successfully!' as message,
       (SELECT COUNT(*) FROM products) as total_products,
       (SELECT COUNT(*) FROM brands) as total_brands,
       (SELECT COUNT(*) FROM categories) as total_categories,
       (SELECT COUNT(*) FROM product_images) as total_images;
