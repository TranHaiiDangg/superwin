-- Thêm cột is_active vào bảng customers
ALTER TABLE `customers` ADD COLUMN `is_active` BOOLEAN NOT NULL DEFAULT 1 AFTER `status`;

-- Cập nhật is_active dựa trên status hiện tại
UPDATE `customers` SET `is_active` = 1 WHERE `status` = 'active';
UPDATE `customers` SET `is_active` = 0 WHERE `status` != 'active';