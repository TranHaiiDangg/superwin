-- Fix carts table foreign key constraint
-- Có 2 cách giải quyết:

-- CÁCH 1: Thay đổi foreign key từ users sang customers
-- Bước 1: Xóa constraint cũ
ALTER TABLE `carts` DROP FOREIGN KEY `carts_ibfk_1`;

-- Bước 2: Thêm constraint mới tham chiếu đến customers
ALTER TABLE `carts` 
ADD CONSTRAINT `carts_ibfk_1` 
FOREIGN KEY (`user_id`) REFERENCES `customers` (`id`) 
ON DELETE CASCADE ON UPDATE RESTRICT;

-- CÁCH 2: Đổi tên cột user_id thành customer_id (khuyến nghị)
-- Bước 1: Xóa constraint cũ
-- ALTER TABLE `carts` DROP FOREIGN KEY `carts_ibfk_1`;

-- Bước 2: Đổi tên cột
-- ALTER TABLE `carts` CHANGE `user_id` `customer_id` INT NOT NULL;

-- Bước 3: Thêm constraint mới
-- ALTER TABLE `carts` 
-- ADD CONSTRAINT `carts_customer_fk` 
-- FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) 
-- ON DELETE CASCADE ON UPDATE RESTRICT;

-- Kiểm tra kết quả
SHOW CREATE TABLE `carts`;