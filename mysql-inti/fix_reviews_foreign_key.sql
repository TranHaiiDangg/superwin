-- Fix foreign key constraint for reviews table
USE superwin;

-- Check existing foreign keys first
SHOW CREATE TABLE `reviews`;

-- Drop existing foreign key constraint (without IF EXISTS)
ALTER TABLE `reviews` DROP FOREIGN KEY `reviews_ibfk_2`;

-- Add new foreign key constraint referencing customers table
ALTER TABLE `reviews` ADD CONSTRAINT `reviews_customer_fk` 
    FOREIGN KEY (`user_id`) REFERENCES `customers` (`id`) 
    ON DELETE CASCADE ON UPDATE RESTRICT;

-- Verify the structure
DESCRIBE `reviews`;

-- Show sample data to confirm
SELECT * FROM `reviews` LIMIT 5;