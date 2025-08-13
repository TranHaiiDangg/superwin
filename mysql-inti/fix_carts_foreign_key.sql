-- Fix foreign key constraint for carts table
-- The issue: carts.user_id references users.id but customers use customers table
-- Solution: Change foreign key to reference customers.id instead

USE superwin;

-- First, check current structure
DESCRIBE `carts`;
SHOW CREATE TABLE `carts`;

-- Drop the existing foreign key constraint
ALTER TABLE `carts` 
DROP FOREIGN KEY `carts_ibfk_1`;

-- Rename the column to be more clear (optional but recommended)
ALTER TABLE `carts` 
CHANGE COLUMN `user_id` `customer_id` INT(11) NOT NULL;

-- Add new foreign key constraint referencing customers table
ALTER TABLE `carts` 
ADD CONSTRAINT `carts_customer_fk` 
FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) 
ON DELETE CASCADE ON UPDATE RESTRICT;

-- Verify the new structure
DESCRIBE `carts`;
SHOW CREATE TABLE `carts`;

-- Check if there are any orphaned cart records
SELECT c.*, cu.name as customer_name 
FROM `carts` c 
LEFT JOIN `customers` cu ON c.customer_id = cu.id 
WHERE cu.id IS NULL;

-- Show sample data to confirm
SELECT c.*, cu.name as customer_name 
FROM `carts` c 
JOIN `customers` cu ON c.customer_id = cu.id 
LIMIT 5;
