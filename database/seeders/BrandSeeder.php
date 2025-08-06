<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Super Win',
                'slug' => 'super-win',
                'description' => 'Thương hiệu máy bơm nước và quạt công nghiệp hàng đầu Việt Nam',
                'image' => '/image/logo.png',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Vina Pump',
                'slug' => 'vina-pump',
                'description' => 'Chuyên sản xuất máy bơm nước chất lượng cao',
                'image' => null,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'ABC',
                'slug' => 'abc',
                'description' => 'Thương hiệu máy bơm nước uy tín',
                'image' => null,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Deton',
                'slug' => 'deton',
                'description' => 'Chuyên sản xuất quạt công nghiệp và thông gió',
                'image' => '/image/logothc.png',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'STHC',
                'slug' => 'sthc',
                'description' => 'Quạt công nghiệp chất lượng cao',
                'image' => null,
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($brands as $brandData) {
            Brand::create($brandData);
        }

        $this->command->info('Đã tạo ' . count($brands) . ' thương hiệu mẫu.');
    }
}
