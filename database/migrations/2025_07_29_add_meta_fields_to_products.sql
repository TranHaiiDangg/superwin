-- Add meta fields to products table
ALTER TABLE products 
ADD COLUMN meta_keywords VARCHAR(500) NULL AFTER meta_description,
ADD COLUMN meta_robots VARCHAR(100) DEFAULT 'index,follow' AFTER meta_keywords,
ADD COLUMN meta_author VARCHAR(255) NULL AFTER meta_robots,
ADD COLUMN meta_canonical_url VARCHAR(500) NULL AFTER meta_author;

-- Update product_images table to add is_base field
ALTER TABLE product_images 
ADD COLUMN is_base BOOLEAN DEFAULT FALSE AFTER is_primary;

-- Add index for is_base field
ALTER TABLE product_images 
ADD INDEX idx_is_base (is_base);

-- Update existing records to set first image as base if no base image exists
UPDATE product_images pi1
SET is_base = TRUE
WHERE pi1.id = (
    SELECT MIN(pi2.id) 
    FROM product_images pi2 
    WHERE pi2.product_id = pi1.product_id 
    AND pi2.is_base = FALSE
    AND NOT EXISTS (
        SELECT 1 FROM product_images pi3 
        WHERE pi3.product_id = pi2.product_id 
        AND pi3.is_base = TRUE
    )
);

-- Thêm cột created_at và updated_at vào bảng product_images
ALTER TABLE `product_images`
ADD COLUMN `created_at` TIMESTAMP NULL DEFAULT NULL,
ADD COLUMN `updated_at` TIMESTAMP NULL DEFAULT NULL;

-- (Tùy chọn) Cập nhật giá trị mặc định cho các bản ghi hiện có (nếu bảng đã có dữ liệu)
UPDATE `product_images`
SET `created_at` = NOW(),
    `updated_at` = NOW()
WHERE `created_at` IS NULL;
-- Add constraint to ensure only one base image per product
-- Note: This will be handled at application level for better performance 