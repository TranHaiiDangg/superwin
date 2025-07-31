-- Fix lỗi order_tracking - File tổng hợp
-- File: mysql-inti/fix_order_tracking.sql

-- Bước 1: Tạo bảng customers nếu chưa tồn tại
CREATE TABLE IF NOT EXISTS customers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    google_id VARCHAR(255),
    facebook_id VARCHAR(255),
    avatar VARCHAR(255),
    date_of_birth DATE,
    gender ENUM('male', 'female', 'other'),
    address TEXT,
    city VARCHAR(100),
    district VARCHAR(100),
    ward VARCHAR(100),
    phone_verified_at TIMESTAMP NULL,
    status ENUM('active', 'inactive', 'banned') DEFAULT 'active',
    customer_code VARCHAR(50) UNIQUE,
    total_spent DECIMAL(15,2) DEFAULT 0,
    loyalty_points INT DEFAULT 0,
    preferred_payment_method VARCHAR(50),
    marketing_consent BOOLEAN DEFAULT FALSE,
    newsletter_subscription BOOLEAN DEFAULT FALSE,
    last_login_at TIMESTAMP NULL,
    remember_token VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_email (email),
    INDEX idx_phone (phone),
    INDEX idx_status (status),
    INDEX idx_customer_code (customer_code)
);

-- Bước 2: Tạo bảng orders nếu chưa tồn tại
CREATE TABLE IF NOT EXISTS orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_code VARCHAR(50) UNIQUE NOT NULL,
    customer_id INT NOT NULL,
    total_amount DECIMAL(15,2) NOT NULL,
    shipping_fee DECIMAL(10,2) DEFAULT 0,
    discount_amount DECIMAL(10,2) DEFAULT 0,
    final_amount DECIMAL(15,2) NOT NULL,
    status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled', 'returned') DEFAULT 'pending',
    payment_status ENUM('pending', 'paid', 'failed', 'refunded') DEFAULT 'pending',
    payment_method VARCHAR(50),
    shipping_address TEXT,
    shipping_city VARCHAR(100),
    shipping_district VARCHAR(100),
    shipping_ward VARCHAR(100),
    shipping_phone VARCHAR(20),
    shipping_name VARCHAR(255),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE RESTRICT,
    INDEX idx_customer_id (customer_id),
    INDEX idx_order_code (order_code),
    INDEX idx_status (status),
    INDEX idx_payment_status (payment_status),
    INDEX idx_created_at (created_at)
);

-- Bước 3: Tạo bảng order_tracking nếu chưa tồn tại
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

-- Bước 4: Thêm dữ liệu test cho customers (chỉ nếu chưa có)
INSERT IGNORE INTO customers (name, email, password, phone, address, city, district, ward, status, customer_code, total_spent, loyalty_points) VALUES
('Nguyễn Văn An', 'nguyenvanan@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0123456789', '123 Đường ABC', 'Hà Nội', 'Ba Đình', 'Phúc Xá', 'active', 'CUS001', 5000000, 500),
('Trần Thị Bình', 'tranthibinh@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0987654321', '456 Đường XYZ', 'TP.HCM', 'Quận 1', 'Bến Nghé', 'active', 'CUS002', 3200000, 320),
('Lê Văn Cường', 'levancuong@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0369852147', '789 Đường DEF', 'Đà Nẵng', 'Hải Châu', 'Hải Châu 1', 'active', 'CUS003', 1800000, 180),
('Phạm Thị Dung', 'phamthidung@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0521478963', '321 Đường GHI', 'Hải Phòng', 'Hồng Bàng', 'Hoàng Văn Thụ', 'active', 'CUS004', 750000, 75);

-- Bước 5: Thêm dữ liệu test cho orders (chỉ nếu chưa có)
INSERT IGNORE INTO orders (order_code, customer_id, total_amount, shipping_fee, discount_amount, final_amount, status, payment_status, payment_method, shipping_address, shipping_city, shipping_district, shipping_ward, shipping_phone, shipping_name) VALUES
('ORD2025001', 1, 2500000, 50000, 100000, 2450000, 'delivered', 'paid', 'cod', '123 Đường ABC', 'Hà Nội', 'Ba Đình', 'Phúc Xá', '0123456789', 'Nguyễn Văn An'),
('ORD2025002', 2, 3200000, 50000, 0, 3250000, 'shipped', 'paid', 'bank_transfer', '456 Đường XYZ', 'TP.HCM', 'Quận 1', 'Bến Nghé', '0987654321', 'Trần Thị Bình'),
('ORD2025003', 3, 1800000, 30000, 50000, 1780000, 'delivered', 'paid', 'cod', '789 Đường DEF', 'Đà Nẵng', 'Hải Châu', 'Hải Châu 1', '0369852147', 'Lê Văn Cường'),
('ORD2025004', 4, 750000, 20000, 0, 770000, 'pending', 'pending', 'cod', '321 Đường GHI', 'Hải Phòng', 'Hồng Bàng', 'Hoàng Văn Thụ', '0521478963', 'Phạm Thị Dung'),
('ORD2025005', 1, 1200000, 30000, 0, 1230000, 'processing', 'paid', 'momo', '123 Đường ABC', 'Hà Nội', 'Ba Đình', 'Phúc Xá', '0123456789', 'Nguyễn Văn An');

-- Bước 6: Thêm dữ liệu test cho order_tracking (chỉ nếu chưa có)
INSERT IGNORE INTO order_tracking (order_id, status, title, description, location, created_by) VALUES
(1, 'pending', 'Đơn hàng mới', 'Đơn hàng đã được tạo và đang chờ xử lý', 'Hà Nội', 1),
(1, 'processing', 'Đang xử lý', 'Đơn hàng đang được xử lý và chuẩn bị giao hàng', 'Hà Nội', 1),
(1, 'shipped', 'Đã gửi hàng', 'Đơn hàng đã được gửi đi và đang trong quá trình vận chuyển', 'Hà Nội', 1),
(1, 'delivered', 'Đã giao hàng', 'Đơn hàng đã được giao thành công cho khách hàng', 'Hà Nội', 1),
(2, 'pending', 'Đơn hàng mới', 'Đơn hàng đã được tạo và đang chờ xử lý', 'TP.HCM', 1),
(2, 'processing', 'Đang xử lý', 'Đơn hàng đang được xử lý và chuẩn bị giao hàng', 'TP.HCM', 1),
(2, 'shipped', 'Đã gửi hàng', 'Đơn hàng đã được gửi đi và đang trong quá trình vận chuyển', 'TP.HCM', 1),
(3, 'pending', 'Đơn hàng mới', 'Đơn hàng đã được tạo và đang chờ xử lý', 'Đà Nẵng', 1),
(3, 'processing', 'Đang xử lý', 'Đơn hàng đang được xử lý và chuẩn bị giao hàng', 'Đà Nẵng', 1),
(3, 'shipped', 'Đã gửi hàng', 'Đơn hàng đã được gửi đi và đang trong quá trình vận chuyển', 'Đà Nẵng', 1),
(3, 'delivered', 'Đã giao hàng', 'Đơn hàng đã được giao thành công cho khách hàng', 'Đà Nẵng', 1),
(4, 'pending', 'Đơn hàng mới', 'Đơn hàng đã được tạo và đang chờ xử lý', 'Hải Phòng', 1),
(5, 'pending', 'Đơn hàng mới', 'Đơn hàng đã được tạo và đang chờ xử lý', 'Hà Nội', 1),
(5, 'processing', 'Đang xử lý', 'Đơn hàng đang được xử lý và chuẩn bị giao hàng', 'Hà Nội', 1);

-- Thông báo hoàn thành
SELECT 'Đã sửa lỗi order_tracking thành công!' as message;
SELECT COUNT(*) as total_customers FROM customers;
SELECT COUNT(*) as total_orders FROM orders;
SELECT COUNT(*) as total_order_tracking FROM order_tracking; 