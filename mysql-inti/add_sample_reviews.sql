-- Add sample reviews for testing rating calculation
-- Make sure to run this after products and customers are set up

-- Insert sample reviews for product ID 4 (if exists)
INSERT INTO reviews (product_id, user_id, rating, title, comment, is_approved, created_at, updated_at) VALUES
(4, 1, 5, 'Sản phẩm tuyệt vời', 'Chất lượng rất tốt, hoạt động êm ái và hiệu quả cao. Rất hài lòng với sản phẩm này.', 1, NOW(), NOW()),
(4, 2, 4, 'Khá ổn', 'Sản phẩm hoạt động tốt, có một số điểm nhỏ cần cải thiện nhưng nhìn chung rất hài lòng.', 1, DATE_SUB(NOW(), INTERVAL 2 DAY), DATE_SUB(NOW(), INTERVAL 2 DAY)),
(4, 1, 5, 'Rất hài lòng', 'Đã sử dụng được 1 tháng, sản phẩm hoạt động rất tốt, không có vấn đề gì.', 1, DATE_SUB(NOW(), INTERVAL 5 DAY), DATE_SUB(NOW(), INTERVAL 5 DAY))
ON DUPLICATE KEY UPDATE 
rating = VALUES(rating),
title = VALUES(title),
comment = VALUES(comment),
updated_at = VALUES(updated_at);

-- Insert sample reviews for product ID 5 (if exists)  
INSERT INTO reviews (product_id, user_id, rating, title, comment, is_approved, created_at, updated_at) VALUES
(5, 2, 3, 'Bình thường', 'Sản phẩm hoạt động ổn, không có gì đặc biệt. Giá cả hợp lý.', 1, DATE_SUB(NOW(), INTERVAL 1 DAY), DATE_SUB(NOW(), INTERVAL 1 DAY)),
(5, 1, 4, 'Tốt', 'Chất lượng tốt trong tầm giá. Giao hàng nhanh, đóng gói cẩn thận.', 1, DATE_SUB(NOW(), INTERVAL 3 DAY), DATE_SUB(NOW(), INTERVAL 3 DAY))
ON DUPLICATE KEY UPDATE 
rating = VALUES(rating),
title = VALUES(title),
comment = VALUES(comment),
updated_at = VALUES(updated_at);

-- Update product ratings based on reviews
UPDATE products p SET 
    rating_average = (
        SELECT ROUND(AVG(r.rating), 1) 
        FROM reviews r 
        WHERE r.product_id = p.id AND r.is_approved = 1
    ),
    rating_count = (
        SELECT COUNT(*) 
        FROM reviews r 
        WHERE r.product_id = p.id AND r.is_approved = 1
    )
WHERE p.id IN (
    SELECT DISTINCT product_id 
    FROM reviews 
    WHERE is_approved = 1
);

-- Set rating to 0 for products with no reviews
UPDATE products SET 
    rating_average = 0,
    rating_count = 0
WHERE rating_average IS NULL OR rating_count IS NULL;
