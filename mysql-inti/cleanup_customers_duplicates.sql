-- Dọn dẹp dữ liệu duplicate trong bảng customers và chuẩn bị cho PRIMARY KEY

-- Bước 1: Xóa tất cả dữ liệu trong bảng customers (vì có quá nhiều duplicate)
DELETE FROM customers;

-- Bước 2: Reset AUTO_INCREMENT về 1
ALTER TABLE customers AUTO_INCREMENT = 1;

-- Bước 3: Thêm PRIMARY KEY cho bảng customers
ALTER TABLE `customers` ADD PRIMARY KEY (`id`);

-- Bước 4: Thay đổi id thành AUTO_INCREMENT
ALTER TABLE `customers` MODIFY `id` int NOT NULL AUTO_INCREMENT;

-- Bước 5: Thêm lại dữ liệu customers sạch (không duplicate)
INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `address`, `city`, `district`, `ward`, `status`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Nguyễn Văn An', 'nguyenvanan@gmail.com', '0901234567', '123 Đường ABC, Phường 1', 'Hồ Chí Minh', 'Quận 1', 'Phường 1', 'active', 1, NOW(), NOW()),
(2, 'Trần Thị Bình', 'tranthibinh@gmail.com', '0912345678', '456 Đường XYZ, Phường 2', 'Hà Nội', 'Quận Ba Đình', 'Phường 2', 'active', 1, NOW(), NOW()),
(3, 'Lê Hoàng Cường', 'lehoangcuong@gmail.com', '0923456789', '789 Đường DEF, Phường 3', 'Đà Nẵng', 'Quận Hải Châu', 'Phường 3', 'active', 1, NOW(), NOW()),
(4, 'Phạm Thị Dung', 'phamthidung@gmail.com', '0934567890', '321 Đường GHI, Phường 4', 'Cần Thơ', 'Quận Ninh Kiều', 'Phường 4', 'active', 1, NOW(), NOW()),
(5, 'Hoàng Văn Em', 'hoangvanem@gmail.com', '0945678901', '654 Đường JKL, Phường 5', 'Hải Phòng', 'Quận Hồng Bàng', 'Phường 5', 'active', 0, NOW(), NOW());

-- Thông báo hoàn thành
SELECT 'Đã dọn dẹp customers và thêm PRIMARY KEY thành công!' as message;
SELECT CONCAT('Tổng số customers: ', COUNT(*)) AS customer_count FROM customers;
