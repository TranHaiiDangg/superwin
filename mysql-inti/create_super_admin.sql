-- Tạo Super Admin User với full quyền
INSERT INTO `users` (
    `name`, 
    `email`, 
    `password`, 
    `role`,
    `is_active`,
    `email_verified_at`, 
    `created_at`, 
    `updated_at`
) VALUES (
    'Super Admin',
    'superadmin@superwin.com',
    '$2y$12$3c.coPJRBdWek1ZBA7OoiO0NKr2TL4Z8uca97myZdLdZDICwiYMI.',
    'super_admin',
    1,
    NOW(),
    NOW(),
    NOW()
);

-- Gán user vào role super_admin (có tất cả quyền)
INSERT INTO `user_roles` (`user_id`, `role_id`, `created_at`, `updated_at`)
SELECT u.id, r.id, NOW(), NOW() 
FROM users u, roles r 
WHERE u.email = 'superadmin@superwin.com' AND r.name = 'super_admin';

-- Hiển thị thông tin user vừa tạo
SELECT 'User created successfully!' as message;
SELECT 'Email: superadmin@superwin.com' as login_info;
SELECT 'Password: abc123' as password_info;
SELECT 'Role: Super Admin (Full Access)' as role_info;