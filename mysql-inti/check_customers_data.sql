-- Kiểm tra dữ liệu trong customers table trước khi sửa
SELECT 'Checking customers table structure and data' as info;

-- Kiểm tra cấu trúc table
DESCRIBE customers;

-- Kiểm tra dữ liệu hiện có
SELECT COUNT(*) as total_customers FROM customers;

-- Xem 5 record đầu tiên
SELECT id, name, email, customer_code, created_at FROM customers LIMIT 5;

-- Kiểm tra có duplicate id không
SELECT id, COUNT(*) as count 
FROM customers 
GROUP BY id 
HAVING COUNT(*) > 1;

-- Kiểm tra id = 0 hoặc NULL
SELECT COUNT(*) as zero_or_null_ids 
FROM customers 
WHERE id = 0 OR id IS NULL;