-- Thêm customers test để phù hợp với orders test data

-- Thêm 2 customers tương ứng với 2 orders test
INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `address`, `city`, `district`, `ward`, `status`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Nguyễn Văn An', 'nguyenvanan@gmail.com', '0901234567', '123 Đường ABC, Phường 1', 'Hồ Chí Minh', 'Quận 1', 'Phường 1', 'active', 1, NOW(), NOW()),
(2, 'Trần Thị Bình', 'tranthibinh@gmail.com', '0912345678', '456 Đường XYZ, Phường 2', 'Hà Nội', 'Quận Ba Đình', 'Phường 2', 'active', 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE
  name = VALUES(name),
  email = VALUES(email),
  phone = VALUES(phone),
  address = VALUES(address),
  city = VALUES(city),
  district = VALUES(district),
  ward = VALUES(ward),
  status = VALUES(status),
  is_active = VALUES(is_active),
  updated_at = NOW();

-- Thông báo kết quả
SELECT 'Test customers added successfully!' AS Message;
SELECT CONCAT('Total customers: ', COUNT(*)) AS Summary FROM customers;
SELECT id, name, email, phone FROM customers WHERE id IN (1, 2);
