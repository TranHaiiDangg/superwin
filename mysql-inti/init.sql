-- Categories table
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    parent_id INT NULL,
    product_type ENUM('bom', 'quat', 'motor', 'bom_chim', 'quat_tron') NOT NULL,
    image VARCHAR(255),
    description TEXT,
    sort_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL,
    INDEX idx_parent_id (parent_id),
    INDEX idx_product_type (product_type),
    INDEX idx_active (is_active)
);

-- Brands table
CREATE TABLE brands (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    image VARCHAR(255),
    description TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_name (name),
    INDEX idx_active (is_active)
);

-- Products table
CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE,
    category_id INT NOT NULL,
    brand_id INT NOT NULL,
    product_type ENUM('bom', 'quat', 'motor', 'bom_chim', 'quat_tron') NOT NULL,
    description TEXT,
    short_description VARCHAR(500),
    price DECIMAL(10, 2) NOT NULL,
    sale_price DECIMAL(10, 2),
    sku VARCHAR(100) UNIQUE,
    stock_quantity INT DEFAULT 0,
    min_stock_level INT DEFAULT 5,
    weight DECIMAL(8,3),
    status BOOLEAN DEFAULT TRUE,
    is_featured BOOLEAN DEFAULT FALSE,
    view_count INT DEFAULT 0,
    sold_count INT DEFAULT 0,
    rating_average DECIMAL(2,1) DEFAULT 0,
    rating_count INT DEFAULT 0,
    meta_title VARCHAR(255),
    meta_description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT,
    FOREIGN KEY (brand_id) REFERENCES brands(id) ON DELETE RESTRICT,
    INDEX idx_category_id (category_id),
    INDEX idx_brand_id (brand_id),
    INDEX idx_product_type (product_type),
    INDEX idx_status (status),
    INDEX idx_featured (is_featured),
    INDEX idx_price (price),
    INDEX idx_rating (rating_average),
    INDEX idx_name (name),
    INDEX idx_slug (slug)
);

-- Product images table
CREATE TABLE product_images (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    url VARCHAR(255) NOT NULL,
    alt_text VARCHAR(255),
    sort_order INT DEFAULT 0,
    is_primary BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    INDEX idx_product_id (product_id),
    INDEX idx_primary (is_primary)
);

-- Bom (Water Pump) details
CREATE TABLE bom_details (
    product_id INT PRIMARY KEY,
    cong_suat VARCHAR(100), -- Power
    hut_sau VARCHAR(100),   -- Suction depth
    cot_ap VARCHAR(100),    -- Head pressure
    luu_luong VARCHAR(100), -- Flow rate
    ong VARCHAR(100),       -- Pipe diameter
    dien_ap VARCHAR(100),   -- Voltage
    dong_dien VARCHAR(100), -- Current
    duong_kinh_day VARCHAR(100), -- Wire diameter
    warranty_months INT DEFAULT 12,
    
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Bom chim (Submersible pump) details
CREATE TABLE bom_chim_details (
    product_id INT PRIMARY KEY,
    cong_suat VARCHAR(100), -- Power
    dien_ap VARCHAR(100),   -- Voltage
    cot_ap VARCHAR(100),    -- Head pressure
    luu_luong VARCHAR(100), -- Flow rate
    ong VARCHAR(100),       -- Pipe diameter
    dong_dien VARCHAR(100), -- Current
    max_depth VARCHAR(100), -- Maximum depth
    warranty_months INT DEFAULT 12,
    
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Bom nhap (Import pump) details
CREATE TABLE bom_nhap_details (
    product_id INT PRIMARY KEY,
    cong_suat VARCHAR(100), -- Power
    dien_ap VARCHAR(100),   -- Voltage
    cot_ap VARCHAR(100),    -- Head pressure
    luu_luong VARCHAR(100), -- Flow rate
    ong VARCHAR(100),       -- Pipe diameter
    origin_country VARCHAR(100), -- Country of origin
    warranty_months INT DEFAULT 12,
    
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Quat (Fan) details
CREATE TABLE quat_details (
    product_id INT PRIMARY KEY,
    duong_kinh_canh VARCHAR(100),    -- Blade diameter
    dien_ap VARCHAR(100),            -- Voltage
    cong_suat VARCHAR(100),          -- Power
    luong_gio VARCHAR(100),          -- Air flow
    toc_do VARCHAR(100),             -- Speed (RPM)
    do_on VARCHAR(100),              -- Noise level
    dien_tich_lam_mat VARCHAR(100),  -- Cooling area
    cot_ap VARCHAR(100),             -- Static pressure
    warranty_months INT DEFAULT 12,
    
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Motor details
CREATE TABLE motor_details (
    product_id INT PRIMARY KEY,
    cong_suat VARCHAR(100),     -- Power
    dien_ap VARCHAR(100),       -- Voltage
    toc_do VARCHAR(100),        -- Speed (RPM)
    loai_dong_co VARCHAR(100),  -- Motor type
    hieu_suat VARCHAR(100),     -- Efficiency
    warranty_months INT DEFAULT 12,
    
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Users table
CREATE TABLE users (
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

-- Shopping carts
CREATE TABLE carts (
    user_id INT PRIMARY KEY,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Cart items
CREATE TABLE cart_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    cart_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (cart_id) REFERENCES carts(user_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_cart_product (cart_id, product_id),
    INDEX idx_cart_id (cart_id),
    INDEX idx_product_id (product_id)
);

-- Orders table
CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    order_code VARCHAR(50) UNIQUE NOT NULL,
    customer_name VARCHAR(255) NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    customer_email VARCHAR(255),
    shipping_address TEXT NOT NULL,
    shipping_city VARCHAR(100),
    shipping_district VARCHAR(100),
    shipping_ward VARCHAR(100),
    payment_method ENUM('cod', 'bank_transfer', 'momo', 'zalopay', 'vnpay') NOT NULL,
    shipping_method VARCHAR(50) DEFAULT 'standard',
    shipping_fee DECIMAL(10,2) DEFAULT 0,
    discount_amount DECIMAL(10,2) DEFAULT 0,
    tax_amount DECIMAL(10,2) DEFAULT 0,
    subtotal DECIMAL(10,2) NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled', 'returned') DEFAULT 'pending',
    cancel_reason TEXT,
    customer_note TEXT,
    admin_note TEXT,
    estimated_delivery_date DATE,
    delivered_at TIMESTAMP NULL,
    cancelled_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_user_id (user_id),
    INDEX idx_order_code (order_code),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at),
    INDEX idx_phone (customer_phone)
);

-- Order details (items)
CREATE TABLE order_details (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    product_name VARCHAR(255) NOT NULL, -- Store product name at time of order
    product_sku VARCHAR(100),
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT,
    INDEX idx_order_id (order_id),
    INDEX idx_product_id (product_id)
);

-- Payments table
CREATE TABLE payments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    payment_method ENUM('cod', 'bank_transfer', 'momo', 'zalopay', 'vnpay') NOT NULL,
    transaction_id VARCHAR(255),
    amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'processing', 'completed', 'failed', 'cancelled', 'refunded') DEFAULT 'pending',
    gateway_response JSON,
    paid_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    INDEX idx_order_id (order_id),
    INDEX idx_status (status),
    INDEX idx_transaction_id (transaction_id)
);

-- Order tracking
CREATE TABLE order_tracking (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    status VARCHAR(50) NOT NULL,
    title VARCHAR(255),
    description TEXT,
    location VARCHAR(255),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_order_id (order_id),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
);

-- Flash deals
CREATE TABLE flash_deals (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    title VARCHAR(255),
    discount_type ENUM('percentage', 'fixed_amount') DEFAULT 'percentage',
    discount_value DECIMAL(10,2) NOT NULL,
    original_price DECIMAL(10,2) NOT NULL,
    sale_price DECIMAL(10,2) NOT NULL,
    quantity_limit INT,
    sold_quantity INT DEFAULT 0,
    start_time TIMESTAMP NOT NULL,
    end_time TIMESTAMP NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    INDEX idx_product_id (product_id),
    INDEX idx_active (is_active),
    INDEX idx_time_range (start_time, end_time)
);

-- Banners
CREATE TABLE banners (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255),
    image VARCHAR(255) NOT NULL,
    mobile_image VARCHAR(255),
    link VARCHAR(255),
    type ENUM('main_slider', 'promotion', 'category', 'brand') NOT NULL,
    position VARCHAR(50),
    sort_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    start_date TIMESTAMP NULL,
    end_date TIMESTAMP NULL,
    click_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_type (type),
    INDEX idx_active (is_active),
    INDEX idx_position (position)
);

-- Product reviews
CREATE TABLE reviews (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    user_id INT NOT NULL,
    order_id INT,
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    title VARCHAR(255),
    comment TEXT,
    images JSON,
    pros TEXT,
    cons TEXT,
    is_verified_purchase BOOLEAN DEFAULT FALSE,
    is_approved BOOLEAN DEFAULT TRUE,
    helpful_count INT DEFAULT 0,
    parent_id INT NULL, -- For replies
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE SET NULL,
    FOREIGN KEY (parent_id) REFERENCES reviews(id) ON DELETE CASCADE,
    INDEX idx_product_id (product_id),
    INDEX idx_user_id (user_id),
    INDEX idx_rating (rating),
    INDEX idx_approved (is_approved),
    INDEX idx_created_at (created_at)
);

-- Search logs
CREATE TABLE search_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    keyword VARCHAR(255) NOT NULL,
    category_filter INT,
    brand_filter INT,
    price_min DECIMAL(10,2),
    price_max DECIMAL(10,2),
    results_count INT DEFAULT 0,
    suggested BOOLEAN DEFAULT FALSE,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_user_id (user_id),
    INDEX idx_keyword (keyword),
    INDEX idx_created_at (created_at)
);

-- Notifications
CREATE TABLE notifications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    type ENUM('order', 'promotion', 'system', 'review') NOT NULL,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    action_url VARCHAR(500),
    order_id INT,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    read_at TIMESTAMP NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_type (type),
    INDEX idx_read (is_read),
    INDEX idx_created_at (created_at)
);

-- Coupons/Discounts
CREATE TABLE coupons (
    id INT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(50) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    type ENUM('percentage', 'fixed_amount', 'free_shipping') NOT NULL,
    value DECIMAL(10,2) NOT NULL,
    minimum_amount DECIMAL(10,2) DEFAULT 0,
    maximum_discount DECIMAL(10,2),
    usage_limit INT,
    used_count INT DEFAULT 0,
    user_limit INT DEFAULT 1, -- Per user usage limit
    start_date TIMESTAMP NOT NULL,
    end_date TIMESTAMP NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_code (code),
    INDEX idx_active (is_active),
    INDEX idx_dates (start_date, end_date)
);

-- Coupon usage tracking
CREATE TABLE coupon_usage (
    id INT PRIMARY KEY AUTO_INCREMENT,
    coupon_id INT NOT NULL,
    user_id INT NOT NULL,
    order_id INT NOT NULL,
    discount_amount DECIMAL(10,2) NOT NULL,
    used_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (coupon_id) REFERENCES coupons(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_coupon_order (user_id, coupon_id, order_id),
    INDEX idx_coupon_id (coupon_id),
    INDEX idx_user_id (user_id)
);

-- Product view history
CREATE TABLE product_views (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    product_id INT NOT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_product_id (product_id),
    INDEX idx_created_at (created_at)
);

-- Settings table for system configuration
CREATE TABLE settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    key_name VARCHAR(255) UNIQUE NOT NULL,
    value TEXT,
    description TEXT,
    type ENUM('string', 'number', 'boolean', 'json') DEFAULT 'string',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert some default settings
INSERT INTO settings (key_name, value, description, type) VALUES
('site_name', 'Máy Bơm Store', 'Tên website', 'string'),
('site_description', 'Chuyên cung cấp máy bơm, quạt, motor chất lượng cao', 'Mô tả website', 'string'),
('contact_phone', '0123456789', 'Số điện thoại liên hệ', 'string'),
('contact_email', 'info@maybom.com', 'Email liên hệ', 'string'),
('shipping_fee', '30000', 'Phí vận chuyển mặc định', 'number'),
('free_shipping_threshold', '500000', 'Đơn hàng miễn phí ship', 'number'),
('tax_rate', '10', 'Thuế VAT (%)', 'number'),
('order_auto_cancel_hours', '24', 'Tự động hủy đơn hàng sau (giờ)', 'number');