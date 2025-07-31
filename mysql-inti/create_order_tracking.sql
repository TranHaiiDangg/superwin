-- Tạo bảng order_tracking
-- File: mysql-inti/create_order_tracking.sql

-- Kiểm tra và tạo bảng order_tracking nếu chưa tồn tại
CREATE TABLE IF NOT EXISTS order_tracking (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    status VARCHAR(50) NOT NULL,
    title VARCHAR(255),
    description TEXT,
    location VARCHAR(255),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_order_id (order_id),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
);

-- Thêm dữ liệu test cho order_tracking
INSERT INTO order_tracking (order_id, status, title, description, location, created_by) VALUES
(1, 'pending', 'Đơn hàng mới', 'Đơn hàng đã được tạo và đang chờ xử lý', 'Hà Nội', 1),
(1, 'processing', 'Đang xử lý', 'Đơn hàng đang được xử lý và chuẩn bị giao hàng', 'Hà Nội', 1),
(1, 'shipped', 'Đã gửi hàng', 'Đơn hàng đã được gửi đi và đang trong quá trình vận chuyển', 'Hà Nội', 1),
(2, 'pending', 'Đơn hàng mới', 'Đơn hàng đã được tạo và đang chờ xử lý', 'TP.HCM', 1),
(2, 'processing', 'Đang xử lý', 'Đơn hàng đang được xử lý và chuẩn bị giao hàng', 'TP.HCM', 1),
(3, 'pending', 'Đơn hàng mới', 'Đơn hàng đã được tạo và đang chờ xử lý', 'Đà Nẵng', 1),
(3, 'processing', 'Đang xử lý', 'Đơn hàng đang được xử lý và chuẩn bị giao hàng', 'Đà Nẵng', 1),
(3, 'shipped', 'Đã gửi hàng', 'Đơn hàng đã được gửi đi và đang trong quá trình vận chuyển', 'Đà Nẵng', 1),
(3, 'delivered', 'Đã giao hàng', 'Đơn hàng đã được giao thành công cho khách hàng', 'Đà Nẵng', 1);

-- Thông báo hoàn thành
SELECT 'Bảng order_tracking đã được tạo thành công!' as message;
SELECT COUNT(*) as total_order_tracking FROM order_tracking; 