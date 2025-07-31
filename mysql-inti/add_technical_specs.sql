-- Thêm các trường thông số kỹ thuật vào bảng products
-- File: mysql-inti/add_technical_specs.sql

-- ========================================
-- THÊM CÁC TRƯỜNG THÔNG SỐ KỸ THUẬT
-- ========================================

-- Thêm các trường thông số kỹ thuật vào bảng products
ALTER TABLE products 
ADD COLUMN  power VARCHAR(100) AFTER meta_canonical_url;

ALTER TABLE products 
ADD COLUMN  voltage VARCHAR(100) AFTER power;

ALTER TABLE products 
ADD COLUMN flow_rate VARCHAR(100) AFTER voltage;

ALTER TABLE products 
ADD COLUMN pressure VARCHAR(100) AFTER flow_rate;

ALTER TABLE products 
ADD COLUMN  efficiency VARCHAR(100) AFTER pressure;

ALTER TABLE products 
ADD COLUMN noise_level VARCHAR(100) AFTER efficiency;

ALTER TABLE products 
ADD COLUMN  warranty_period VARCHAR(100) AFTER noise_level;

-- ========================================
-- THÊM INDEX CHO CÁC TRƯỜNG MỚI
-- ========================================

-- Thêm index cho các trường thông số kỹ thuật
ALTER TABLE products 
ADD INDEX IF NOT EXISTS idx_power (power);

ALTER TABLE products 
ADD INDEX IF NOT EXISTS idx_voltage (voltage);

ALTER TABLE products 
ADD INDEX IF NOT EXISTS idx_flow_rate (flow_rate);

-- ========================================
-- CẬP NHẬT DỮ LIỆU TEST
-- ========================================

-- Cập nhật thông số kỹ thuật cho sản phẩm test
UPDATE products 
SET power = '0.5 HP',
    voltage = '220V/50Hz',
    flow_rate = '25 L/phút',
    pressure = '25m',
    efficiency = '85%',
    noise_level = '< 65dB',
    warranty_period = '12 tháng'
WHERE name LIKE '%Panasonic GP-129JXK%';

UPDATE products 
SET power = '45W',
    voltage = '220V/50Hz',
    flow_rate = 'N/A',
    pressure = 'N/A',
    efficiency = 'N/A',
    noise_level = '< 55dB',
    warranty_period = '24 tháng'
WHERE name LIKE '%Panasonic F-14MS1%';

-- ========================================
-- KIỂM TRA KẾT QUẢ
-- ========================================

SELECT 'Đã thêm các trường thông số kỹ thuật thành công!' as message;

-- Kiểm tra các trường mới
SELECT 'Products có power:' as check_field, COUNT(*) as count FROM products WHERE power IS NOT NULL
UNION ALL
SELECT 'Products có voltage:' as check_field, COUNT(*) as count FROM products WHERE voltage IS NOT NULL
UNION ALL
SELECT 'Products có flow_rate:' as check_field, COUNT(*) as count FROM products WHERE flow_rate IS NOT NULL;

-- Hiển thị thông tin sản phẩm với thông số kỹ thuật
SELECT 
    name,
    power,
    voltage,
    flow_rate,
    pressure,
    efficiency,
    noise_level,
    warranty_period
FROM products 
WHERE power IS NOT NULL OR voltage IS NOT NULL; 