-- Thêm trường price vào bảng cart_items
ALTER TABLE cart_items
ADD COLUMN price DECIMAL(10,2) NOT NULL DEFAULT 0.00
COMMENT 'Giá của sản phẩm tại thời điểm thêm vào giỏ hàng';

-- Thêm trường attributes vào bảng cart_items
ALTER TABLE cart_items
ADD COLUMN attributes JSON NULL
COMMENT 'Thuộc tính của sản phẩm (màu sắc, kích thước, v.v.)';
