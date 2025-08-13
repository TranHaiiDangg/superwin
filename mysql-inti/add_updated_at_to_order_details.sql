-- Add missing created_at and updated_at columns to order_details table
-- This fixes the error: Unknown column 'created_at' and 'updated_at' in 'field list'

USE superwin;

-- Add created_at column to order_details table
ALTER TABLE `order_details` 
ADD COLUMN `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP;

-- Add updated_at column to order_details table
ALTER TABLE `order_details` 
ADD COLUMN `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- Update existing records to have current timestamp
UPDATE `order_details` 
SET `created_at` = NOW(), `updated_at` = NOW() 
WHERE `created_at` IS NULL OR `updated_at` IS NULL;

-- Verify the structure
DESCRIBE `order_details`;

-- Show sample data to confirm
SELECT * FROM `order_details` LIMIT 3;
