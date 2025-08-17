-- Tạo các roles cơ bản
INSERT INTO `roles` (`name`, `display_name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
('super_admin', 'Super Admin', 'Quản trị viên cấp cao - có tất cả quyền', 1, NOW(), NOW()),
('admin', 'Admin', 'Quản trị viên - có hầu hết quyền', 1, NOW(), NOW()),
('manager', 'Manager', 'Quản lý - có quyền hạn chế', 1, NOW(), NOW()),
('staff', 'Staff', 'Nhân viên - quyền cơ bản', 1, NOW(), NOW());

-- Gán tất cả permissions cho super_admin role
INSERT INTO `role_permissions` (`role_id`, `permission_id`, `created_at`, `updated_at`)
SELECT r.id, p.id, NOW(), NOW()
FROM roles r, permissions p
WHERE r.name = 'super_admin' AND p.is_active = 1;

-- Gán hầu hết permissions cho admin role - trừ một số quyền nhạy cảm
INSERT INTO `role_permissions` (`role_id`, `permission_id`, `created_at`, `updated_at`)
SELECT r.id, p.id, NOW(), NOW()
FROM roles r, permissions p
WHERE r.name = 'admin'
AND p.is_active = 1
AND p.name NOT IN ('users.delete', 'users.ban', 'users.permissions');

-- Gán user adminmaster@gmail.com vào role admin
INSERT INTO `user_roles` (`user_id`, `role_id`, `created_at`, `updated_at`)
SELECT u.id, r.id, NOW(), NOW()
FROM users u, roles r
WHERE u.email = 'adminmaster@gmail.com' AND r.name = 'admin';
