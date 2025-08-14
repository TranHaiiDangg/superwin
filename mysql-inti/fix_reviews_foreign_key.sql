-- Sửa foreign key của bảng reviews để reference customers thay vì users
-- Bước 1: Drop foreign key constraint hiện tại
ALTER TABLE `reviews` DROP FOREIGN KEY `reviews_ibfk_2`;

-- Bước 2: Thêm foreign key mới reference tới customers
ALTER TABLE `reviews` ADD CONSTRAINT `reviews_ibfk_2` 
FOREIGN KEY (`user_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

-- Bước 3: Cập nhật comment để rõ ràng
ALTER TABLE `reviews` MODIFY COLUMN `user_id` int NOT NULL COMMENT 'References customers.id, not users.id';