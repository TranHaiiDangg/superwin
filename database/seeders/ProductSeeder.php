<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy categories và brands
        $categories = Category::all();
        $brands = Brand::all();

        if ($categories->isEmpty() || $brands->isEmpty()) {
            $this->command->warn('Categories hoặc Brands chưa được tạo. Vui lòng chạy CategorySeeder và BrandSeeder trước.');
            return;
        }

        // Tạo sản phẩm mẫu cho Flash Deals
        $flashDealsProducts = [
            [
                'name' => 'Máy bơm nước Super Win SW-750',
                'short_description' => 'Máy bơm nước gia đình công suất 750W, lưu lượng cao',
                'description' => 'Máy bơm nước Super Win SW-750 với công suất 750W, lưu lượng nước cao, phù hợp cho gia đình và văn phòng.',
                'price' => 2500000,
                'sale_price' => 1750000,
                'category_id' => $categories->where('slug', 'may-bom-nuoc')->first()->id ?? $categories->first()->id,
                'brand_id' => $brands->first()->id,
                'is_featured' => true,
                'status' => true,
                'stock_quantity' => 50,
                'sold_count' => 120,
            ],
            [
                'name' => 'Quạt công nghiệp Deton D-18',
                'short_description' => 'Quạt công nghiệp cánh 18 inch, gió mạnh',
                'description' => 'Quạt công nghiệp Deton D-18 với cánh quạt 18 inch, tạo gió mạnh, phù hợp cho nhà máy, xưởng sản xuất.',
                'price' => 1800000,
                'sale_price' => 1260000,
                'category_id' => $categories->where('slug', 'quat-cong-nghiep')->first()->id ?? $categories->first()->id,
                'brand_id' => $brands->first()->id,
                'is_featured' => true,
                'status' => true,
                'stock_quantity' => 30,
                'sold_count' => 85,
            ],
            [
                'name' => 'Máy bơm chìm Super Win SW-1000',
                'short_description' => 'Máy bơm chìm công suất 1000W, thả chìm',
                'description' => 'Máy bơm chìm Super Win SW-1000 với công suất 1000W, có thể thả chìm trong nước, phù hợp cho giếng khoan.',
                'price' => 3200000,
                'sale_price' => 2240000,
                'category_id' => $categories->where('slug', 'may-bom-chim')->first()->id ?? $categories->first()->id,
                'brand_id' => $brands->first()->id,
                'is_featured' => false,
                'status' => true,
                'stock_quantity' => 25,
                'sold_count' => 65,
            ],
            [
                'name' => 'Quạt thông gió vuông Super Win',
                'short_description' => 'Quạt thông gió vuông 300x300mm',
                'description' => 'Quạt thông gió vuông Super Win kích thước 300x300mm, lắp tường, thông gió hiệu quả.',
                'price' => 850000,
                'sale_price' => 595000,
                'category_id' => $categories->where('slug', 'quat-thong-gio')->first()->id ?? $categories->first()->id,
                'brand_id' => $brands->first()->id,
                'is_featured' => false,
                'status' => true,
                'stock_quantity' => 80,
                'sold_count' => 200,
            ],
            [
                'name' => 'Máy bơm nước Vina Pump VP-500',
                'short_description' => 'Máy bơm nước gia đình 500W',
                'description' => 'Máy bơm nước Vina Pump VP-500 với công suất 500W, tiết kiệm điện, phù hợp gia đình.',
                'price' => 1500000,
                'sale_price' => 1050000,
                'category_id' => $categories->where('slug', 'may-bom-nuoc')->first()->id ?? $categories->first()->id,
                'brand_id' => $brands->first()->id,
                'is_featured' => false,
                'status' => true,
                'stock_quantity' => 60,
                'sold_count' => 150,
            ],
            [
                'name' => 'Quạt trần công nghiệp STHC',
                'short_description' => 'Quạt trần công nghiệp 56 inch',
                'description' => 'Quạt trần công nghiệp STHC 56 inch, gió mạnh, phù hợp cho nhà xưởng lớn.',
                'price' => 2800000,
                'sale_price' => 1960000,
                'category_id' => $categories->where('slug', 'quat-dac-biet')->first()->id ?? $categories->first()->id,
                'brand_id' => $brands->first()->id,
                'is_featured' => false,
                'status' => true,
                'stock_quantity' => 20,
                'sold_count' => 45,
            ],
            [
                'name' => 'Máy bơm nước ABC AB-800',
                'short_description' => 'Máy bơm nước ABC 800W, bền bỉ',
                'description' => 'Máy bơm nước ABC AB-800 với công suất 800W, động cơ bền bỉ, tuổi thọ cao.',
                'price' => 2200000,
                'sale_price' => 1540000,
                'category_id' => $categories->where('slug', 'may-bom-nuoc')->first()->id ?? $categories->first()->id,
                'brand_id' => $brands->first()->id,
                'is_featured' => false,
                'status' => true,
                'stock_quantity' => 40,
                'sold_count' => 95,
            ],
            [
                'name' => 'Quạt Inverter Super Win',
                'short_description' => 'Quạt Inverter tiết kiệm điện 50%',
                'description' => 'Quạt Inverter Super Win với công nghệ tiết kiệm điện 50%, điều khiển thông minh.',
                'price' => 3500000,
                'sale_price' => 2450000,
                'category_id' => $categories->where('slug', 'quat-cong-nghiep')->first()->id ?? $categories->first()->id,
                'brand_id' => $brands->first()->id,
                'is_featured' => true,
                'status' => true,
                'stock_quantity' => 15,
                'sold_count' => 35,
            ],
            [
                'name' => 'Tấm làm mát công nghiệp',
                'short_description' => 'Tấm làm mát cellulose hiệu quả cao',
                'description' => 'Tấm làm mát cellulose công nghiệp, hiệu quả làm mát cao, tuổi thọ lâu dài.',
                'price' => 1200000,
                'sale_price' => 840000,
                'category_id' => $categories->where('slug', 'tam-lam-mat')->first()->id ?? $categories->first()->id,
                'brand_id' => $brands->first()->id,
                'is_featured' => false,
                'status' => true,
                'stock_quantity' => 100,
                'sold_count' => 280,
            ],
            [
                'name' => 'Máy bơm nước biển Super Win',
                'short_description' => 'Máy bơm nước biển chống ăn mòn',
                'description' => 'Máy bơm nước biển Super Win với vật liệu chống ăn mòn, phù hợp cho tàu thuyền.',
                'price' => 4500000,
                'sale_price' => 3150000,
                'category_id' => $categories->where('slug', 'may-bom-nuoc')->first()->id ?? $categories->first()->id,
                'brand_id' => $brands->first()->id,
                'is_featured' => false,
                'status' => true,
                'stock_quantity' => 10,
                'sold_count' => 25,
            ],
        ];

                foreach ($flashDealsProducts as $productData) {
            Product::create($productData);
        }

        $this->command->info('Đã tạo ' . count($flashDealsProducts) . ' sản phẩm Flash Deals mẫu.');
    }
}
