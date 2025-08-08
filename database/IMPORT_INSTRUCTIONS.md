# 📋 **Hướng dẫn Import Data Test vào Database SuperWin**

## 🎯 **Tổng quan**
File `test_data.sql` chứa data test đầy đủ cho dự án SuperWin bao gồm:
- 6 thương hiệu (brands)
- 15 danh mục (categories) 
- 10 sản phẩm (products) với đầy đủ thông tin
- Hình ảnh, thuộc tính, flash deals
- Users, customers, settings

## 🔧 **Cách 1: Import qua MySQL Command Line**

```bash
# 1. Đảm bảo database đã tồn tại
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS superwin;"

# 2. Import cấu trúc database (nếu chưa có)
mysql -u root -p superwin < mysql-inti/init.sql

# 3. Import data test
mysql -u root -p superwin < database/test_data.sql
```

## 🔧 **Cách 2: Import qua phpMyAdmin**

1. Mở phpMyAdmin → Chọn database `superwin`
2. Vào tab **Import**
3. Chọn file `database/test_data.sql`
4. Click **Go** để thực hiện

## 🔧 **Cách 3: Import qua Docker (nếu dùng Docker)**

```bash
# Copy file vào container
docker cp database/test_data.sql superwin_mysql:/tmp/

# Exec vào container và import
docker exec -i superwin_mysql mysql -u root -p superwin < /tmp/test_data.sql
```

## 🔧 **Cách 4: Sử dụng Laravel Artisan (Khuyến nghị)**

```bash
# 1. Tạo migration từ file SQL
php artisan make:migration import_test_data

# 2. Hoặc chạy trực tiếp bằng DB::unprepared
php artisan tinker
```

Trong tinker:
```php
DB::unprepared(file_get_contents('database/test_data.sql'));
```

## ✅ **Kiểm tra sau khi import**

```sql
-- Kiểm tra số lượng records
SELECT 'Brands' as table_name, COUNT(*) as count FROM brands
UNION ALL
SELECT 'Categories', COUNT(*) FROM categories  
UNION ALL
SELECT 'Products', COUNT(*) FROM products
UNION ALL
SELECT 'Product Images', COUNT(*) FROM product_images
UNION ALL
SELECT 'Flash Deals', COUNT(*) FROM flash_deals;
```

**Kết quả mong đợi:**
- Brands: 6
- Categories: 15  
- Products: 10
- Product Images: 13
- Flash Deals: 3

## 🔐 **Thông tin đăng nhập test**

### **Admin Users:**
- **Super Admin**: admin@superwin.com / password123
- **Manager**: manager@superwin.com / password123  
- **Staff**: staff@superwin.com / password123

### **Customers:**
- **Customer 1**: customer1@test.com / password123
- **Customer 2**: customer2@test.com / password123

## 🎨 **Dữ liệu tạo sẵn**

### **Sản phẩm có Flash Deal:**
1. Máy bơm SuperWin SW-100 (giảm 12%)
2. Máy bơm chìm VP-200 (giảm 400k)
3. Quạt thông gió SWF-300 (giảm 11.11%)

### **Sản phẩm nổi bật (Featured):**
- Máy bơm SuperWin SW-100
- Máy bơm chìm VP-200  
- Quạt SWF-300
- Quạt hướng trục ST-400
- Máy bơm hồ bơi VP-POOL

### **Hình ảnh sản phẩm:**
Tất cả sản phẩm đều có ít nhất 1 hình ảnh chính, một số có thêm hình ảnh phụ.

## 🐛 **Troubleshooting**

### **Lỗi Foreign Key:**
```sql
SET FOREIGN_KEY_CHECKS = 0;
-- Import data
SET FOREIGN_KEY_CHECKS = 1;
```

### **Lỗi Duplicate Entry:**
```sql
-- Clear existing data trước khi import
TRUNCATE TABLE product_images;
TRUNCATE TABLE flash_deals;
TRUNCATE TABLE products;
TRUNCATE TABLE categories;
TRUNCATE TABLE brands;
```

### **Lỗi Permission:**
```bash
# Grant quyền cho user MySQL
GRANT ALL PRIVILEGES ON superwin.* TO 'your_user'@'localhost';
FLUSH PRIVILEGES;
```

## 🎉 **Kết quả mong đợi**

Sau khi import thành công:
- Trang chủ sẽ hiển thị sản phẩm nổi bật
- Flash deals sẽ có 3 sản phẩm khuyến mãi
- Categories menu sẽ có đầy đủ danh mục
- Admin có thể quản lý tất cả dữ liệu

---
**Lưu ý:** Đảm bảo đã backup database trước khi import nếu đang có dữ liệu quan trọng!
