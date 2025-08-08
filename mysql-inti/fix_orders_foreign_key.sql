-- Sửa lại foreign key constraint cho bảng orders
-- user_id phải tham chiếu đến customers thay vì users
-- (Chạy file cleanup_customers_duplicates.sql trước)

-- Thêm foreign key constraint mới tham chiếu đến bảng customers
ALTER TABLE `orders` 
ADD CONSTRAINT `orders_customer_fk` 
FOREIGN KEY (`user_id`) REFERENCES `customers` (`id`) 
ON DELETE SET NULL ON UPDATE RESTRICT;

-- Thông báo hoàn thành
SELECT 'Đã thêm foreign key constraint cho orders -> customers thành công!' as message;
