-- Fix customers table - thêm primary key và auto_increment cho id
-- Vấn đề: customers.id không có PRIMARY KEY nên không thể tạo foreign key reference

-- Bước 1: Kiểm tra cấu trúc hiện tại
DESCRIBE customers;

-- Bước 2: Xóa foreign key constraint cũ trong carts nếu có
-- ALTER TABLE `carts` DROP FOREIGN KEY `carts_ibfk_1`;

-- Bước 3: Sửa cấu trúc customers table
-- Thêm PRIMARY KEY và AUTO_INCREMENT cho id
ALTER TABLE `customers` 
MODIFY `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY;

-- Bước 4: Thêm lại foreign key constraint trong carts
ALTER TABLE `carts` 
ADD CONSTRAINT `carts_ibfk_1` 
FOREIGN KEY (`user_id`) REFERENCES `customers` (`id`) 
ON DELETE CASCADE ON UPDATE RESTRICT;

-- Bước 5: Kiểm tra kết quả
SHOW CREATE TABLE `customers`;
SHOW CREATE TABLE `carts`;

-- Bước 6: Kiểm tra dữ liệu hiện có
SELECT COUNT(*) as total_customers FROM customers;
SELECT * FROM customers LIMIT 5;