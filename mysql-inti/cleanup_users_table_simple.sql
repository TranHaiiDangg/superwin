-- Dọn dẹp bảng users - phiên bản đơn giản
-- Chỉ thực hiện các thao tác cần thiết

-- Thêm các trường admin nếu chưa có
ALTER TABLE users 
ADD COLUMN role ENUM('super_admin', 'admin', 'manager', 'staff') DEFAULT 'staff' AFTER email;

ALTER TABLE users 
ADD COLUMN permissions JSON NULL AFTER role;

ALTER TABLE users 
ADD COLUMN department VARCHAR(100) NULL AFTER permissions;

ALTER TABLE users 
ADD COLUMN employee_id VARCHAR(50) UNIQUE NULL AFTER department;

ALTER TABLE users 
ADD COLUMN hire_date DATE NULL AFTER employee_id;

ALTER TABLE users 
ADD COLUMN is_active BOOLEAN DEFAULT TRUE AFTER hire_date;

-- Thêm index
ALTER TABLE users 
ADD INDEX idx_role (role);

ALTER TABLE users 
ADD INDEX idx_employee_id (employee_id);

ALTER TABLE users 
ADD INDEX idx_department (department);

ALTER TABLE users 
ADD INDEX idx_is_active (is_active);

-- Tạo admin user mặc định
INSERT IGNORE INTO users (name, email, password, role, permissions, is_active, created_at, updated_at) VALUES 
('Super Admin', 'admin@superwin.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'super_admin', '["*"]', TRUE, NOW(), NOW());

-- Cập nhật employee_id cho users hiện có
UPDATE users SET employee_id = CONCAT('EMP', LPAD(id, 3, '0')) WHERE employee_id IS NULL;

-- Cập nhật role cho users hiện có
UPDATE users SET role = 'staff' WHERE role IS NULL;

-- Cập nhật is_active cho users hiện có
UPDATE users SET is_active = TRUE WHERE is_active IS NULL; 