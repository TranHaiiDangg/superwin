-- Tạo bảng customers từ users
CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20),
    password VARCHAR(255) NULL,
    google_id VARCHAR(255) UNIQUE,
    facebook_id VARCHAR(255) UNIQUE,
    avatar VARCHAR(255) NULL,
    date_of_birth DATE,
    gender ENUM('male', 'female', 'other'),
    address TEXT,
    city VARCHAR(100),
    district VARCHAR(100),
    ward VARCHAR(100),
    email_verified_at DATETIME NULL,
    phone_verified_at DATETIME NULL,
    status ENUM('active', 'inactive', 'banned') DEFAULT 'active',
    last_login_at TIMESTAMP NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_email (email),
    INDEX idx_phone (phone),
    INDEX idx_status (status)
);

-- Cập nhật bảng users để chỉ chứa thông tin admin
ALTER TABLE users 
DROP COLUMN google_id,
DROP COLUMN facebook_id,
DROP COLUMN avatar,
DROP COLUMN date_of_birth,
DROP COLUMN gender,
DROP COLUMN address,
DROP COLUMN city,
DROP COLUMN district,
DROP COLUMN ward,
DROP COLUMN phone_verified_at,
DROP COLUMN last_login_at;

-- Thêm các trường cho admin users
ALTER TABLE users 
ADD COLUMN role ENUM('super_admin', 'admin', 'manager', 'staff') DEFAULT 'staff' AFTER email,
ADD COLUMN permissions JSON NULL AFTER role,
ADD COLUMN is_active BOOLEAN DEFAULT TRUE AFTER permissions,
ADD COLUMN last_login_at TIMESTAMP NULL AFTER is_active;

-- Cập nhật index cho users
ALTER TABLE users 
DROP INDEX idx_phone,
DROP INDEX idx_status;

ALTER TABLE users 
ADD INDEX idx_role (role),
ADD INDEX idx_active (is_active);

-- Cập nhật các bảng liên quan để sử dụng customer_id thay vì user_id
-- Cập nhật bảng carts
ALTER TABLE carts 
CHANGE COLUMN user_id customer_id INT,
ADD CONSTRAINT fk_carts_customer_id FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
DROP INDEX user_id,
ADD INDEX idx_customer_id (customer_id);

-- Cập nhật bảng cart_items
ALTER TABLE cart_items 
CHANGE COLUMN cart_id customer_id INT,
ADD CONSTRAINT fk_cart_items_customer_id FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
DROP INDEX cart_id,
ADD INDEX idx_customer_id (customer_id);

-- Cập nhật bảng orders
ALTER TABLE orders 
CHANGE COLUMN user_id customer_id INT,
ADD CONSTRAINT fk_orders_customer_id FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE SET NULL,
DROP INDEX user_id,
ADD INDEX idx_customer_id (customer_id);

-- Cập nhật bảng order_tracking
ALTER TABLE order_tracking 
CHANGE COLUMN created_by customer_id INT,
ADD CONSTRAINT fk_order_tracking_customer_id FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE SET NULL,
ADD INDEX idx_customer_id (customer_id);

-- Cập nhật bảng reviews
ALTER TABLE reviews 
CHANGE COLUMN user_id customer_id INT,
ADD CONSTRAINT fk_reviews_customer_id FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
DROP INDEX user_id,
ADD INDEX idx_customer_id (customer_id);

-- Cập nhật bảng search_logs
ALTER TABLE search_logs 
CHANGE COLUMN user_id customer_id INT,
ADD CONSTRAINT fk_search_logs_customer_id FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE SET NULL,
DROP INDEX user_id,
ADD INDEX idx_customer_id (customer_id);

-- Cập nhật bảng notifications
ALTER TABLE notifications 
CHANGE COLUMN user_id customer_id INT,
ADD CONSTRAINT fk_notifications_customer_id FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
DROP INDEX user_id,
ADD INDEX idx_customer_id (customer_id);

-- Cập nhật bảng coupon_usage
ALTER TABLE coupon_usage 
CHANGE COLUMN user_id customer_id INT,
ADD CONSTRAINT fk_coupon_usage_customer_id FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
DROP INDEX user_id,
ADD INDEX idx_customer_id (customer_id);

-- Cập nhật bảng product_views
ALTER TABLE product_views 
CHANGE COLUMN user_id customer_id INT,
ADD CONSTRAINT fk_product_views_customer_id FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE SET NULL,
DROP INDEX user_id,
ADD INDEX idx_customer_id (customer_id);

-- Tạo admin user mặc định
INSERT INTO users (name, email, password, role, permissions, is_active) VALUES 
('Super Admin', 'admin@superwin.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'super_admin', '["*"]', TRUE);

-- Tạo customer mẫu
INSERT INTO customers (name, email, phone, password, status) VALUES 
('Nguyễn Văn A', 'customer@example.com', '0123456789', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'active'); 