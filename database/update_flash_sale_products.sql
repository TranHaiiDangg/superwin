-- =====================================================
-- UPDATE FLASH SALE PRODUCTS
-- =====================================================
-- File: database/update_flash_sale_products.sql
-- Date: 2025-01-08
-- Description: Update products to have is_sale = true for flash sale testing
-- =====================================================

-- Cập nhật một số sản phẩm thành flash sale
UPDATE `products` SET
    `is_sale` = 1,
    `sale_price` = CASE
        WHEN `id` = 5 THEN 1900000  -- Quạt hướng trục STHC ST-400
        WHEN `id` = 6 THEN 2800000  -- Quạt sàn công nghiệp ABC SF-600
        WHEN `id` = 7 THEN 4500000  -- Động cơ điện ABC Motor AM-500
        WHEN `id` = 8 THEN 1800000  -- Quạt biến tần Inverter Fan IF-200
        ELSE `sale_price`
    END,
    `updated_at` = NOW()
WHERE `id` IN (5, 6, 7, 8);

-- Cập nhật thêm một số sản phẩm khác thành flash sale
UPDATE `products` SET
    `is_sale` = 1,
    `sale_price` = ROUND(`price` * 0.85, -3), -- Giảm 15%
    `updated_at` = NOW()
WHERE `id` IN (9, 10, 11, 12) AND `is_sale` = 0;

-- Hiển thị danh sách sản phẩm flash sale
SELECT
    `id`,
    `name`,
    `price`,
    `sale_price`,
    ROUND(((price - sale_price) / price * 100), 1) as discount_percentage,
    `is_sale`
FROM `products`
WHERE `is_sale` = 1
ORDER BY discount_percentage DESC;
