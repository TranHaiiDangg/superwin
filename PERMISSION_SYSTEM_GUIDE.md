# 🛡️ Hệ thống Phân quyền Linh hoạt - Hướng dẫn sử dụng

## ✨ **Tính năng mới**

### 🔧 **1. PermissionManager Tool**
- **File**: `app/Services/PermissionManager.php`
- **Chức năng**: Quản lý permissions từ code, không cần thêm database thủ công
- **Config permissions**: Tất cả permissions được định nghĩa trong `PERMISSIONS_CONFIG`
- **Config roles**: Tất cả roles và permissions được định nghĩa trong `ROLES_CONFIG`

### ⚡ **2. Artisan Command**
```bash
# Sync permissions từ code vào database
php artisan permissions:sync

# Sync cả permissions và roles
php artisan permissions:sync --roles

# Sync không hỏi xác nhận
php artisan permissions:sync --force
```

### 🎭 **3. Form Edit User Thống nhất**
- **Trước**: Vai trò hệ thống và quyền bổ sung riêng biệt
- **Sau**: Gom thành 2 tab trong 1 form
  - **Tab 1**: Vai trò hệ thống (roles)
  - **Tab 2**: Quyền chi tiết (individual permissions)

### 🎛️ **4. Admin Interface**
- **URL**: `/admin/permissions`
- **Chức năng**:
  - Xem tất cả permissions theo module
  - Sync permissions từ code
  - Thêm permission mới
  - Xóa permission
  - Quản lý role permissions

## 🚀 **Cách sử dụng**

### **Bước 1: Khởi động database**
```bash
# Nếu dùng Docker
docker-compose up -d

# Hoặc khởi động MySQL thủ công
```

### **Bước 2: Sync permissions**
```bash
php artisan permissions:sync --roles --force
```

### **Bước 3: Test hệ thống**
1. Vào `/admin/users` → Edit user
2. Thấy form mới với 2 tab
3. Vào `/admin/permissions` → Quản lý permissions
4. Test phân quyền dashboard

## 📊 **Permissions mới**

### **Dashboard Permissions**
- `dashboard.view` - Xem Dashboard
- `dashboard.stats` - Xem thống kê
- `dashboard.reports` - Xem báo cáo
- `dashboard.charts` - Xem biểu đồ

### **Permissions chi tiết hơn**
- `products.export`, `products.import`, `products.restore`
- `orders.create`, `orders.export`, `orders.print`, `orders.status`
- `users.ban`, `users.permissions`
- `customers.ban`, `customers.export`
- Và nhiều hơn nữa...

## 🔄 **Thêm Permission mới**

### **Cách 1: Từ Code (Khuyến nghị)**
1. Mở `app/Services/PermissionManager.php`
2. Thêm vào `PERMISSIONS_CONFIG`:
```php
'new_module' => [
    'new_module.view' => 'Xem new module',
    'new_module.create' => 'Thêm new module',
],
```
3. Chạy: `php artisan permissions:sync --force`

### **Cách 2: Từ Admin Interface**
1. Vào `/admin/permissions`
2. Click "Thêm Permission"
3. Điền thông tin và lưu

### **Cách 3: Thêm trực tiếp vào Role Config**
```php
'manager' => [
    'display_name' => 'Manager',
    'permissions' => [
        'dashboard.view', 'dashboard.stats',
        'new_module.*', // Tất cả permissions của new_module
    ]
]
```

## 🎯 **Ưu điểm hệ thống mới**

### ✅ **Linh hoạt**
- Không cần sửa database khi thêm permission
- Config permissions ngay trong code
- Sync tự động

### ✅ **Dễ quản lý**
- Form thống nhất cho edit user
- Admin interface trực quan
- Command line tiện lợi

### ✅ **Hiệu năng cao**
- Cache permissions trong User model
- Ưu tiên roles system
- Fallback permissions cũ

### ✅ **Backward Compatible**
- Vẫn support permissions cũ
- Mapping tự động
- Không phá vỡ code hiện tại

## 🧪 **Test Cases**

### **Test 1: Sync Permissions**
```bash
php artisan permissions:sync --roles
# Kiểm tra: permissions và roles được tạo
```

### **Test 2: Dashboard Permissions**
1. Tạo user chỉ có `dashboard.view`
2. Login → Chỉ thấy dashboard trống
3. Thêm `dashboard.stats` → Thấy thống kê

### **Test 3: Edit User Form**
1. Vào edit user
2. Thấy 2 tab: "Vai trò hệ thống" và "Quyền chi tiết"
3. Chọn role → Tự động có permissions
4. Hoặc chọn permissions riêng lẻ

### **Test 4: Admin Interface**
1. Vào `/admin/permissions`
2. Test sync, thêm, xóa permissions
3. Xem permissions theo module

## 🔧 **Troubleshooting**

### **Lỗi Database Connection**
```bash
# Kiểm tra .env
DB_HOST=127.0.0.1  # hoặc mysql nếu dùng Docker
DB_PORT=3306
DB_DATABASE=superwin

# Khởi động database
docker-compose up -d mysql
```

### **Permissions không sync**
```bash
# Clear cache
php artisan cache:clear
php artisan config:clear

# Sync lại
php artisan permissions:sync --roles --force
```

### **User không có quyền**
1. Kiểm tra user có roles không: `$user->roles`
2. Kiểm tra role có permissions không: `$role->permissions`
3. Chạy: `php artisan permissions:sync --roles`

## 🎉 **Kết luận**

Hệ thống phân quyền đã được nâng cấp hoàn toàn:
- **Linh hoạt**: Thêm permissions từ code
- **Tự động**: Sync bằng command
- **Thống nhất**: Form edit user gọn gàng
- **Quản lý**: Admin interface đầy đủ
- **Hiệu năng**: Cache và tối ưu

**Không còn cần thêm database thủ công nữa!** 🚀