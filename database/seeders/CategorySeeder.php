<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Danh mục chính - khớp với menu header
        $mainCategories = [
            [
                'name' => 'Máy Bơm Nước',
                'slug' => 'may-bom-nuoc',
                'description' => '💧 Các loại máy bơm nước chất lượng cao từ các thương hiệu uy tín',
                'image' => '/image/bom.png',

                'sort_order' => 1,
                'children' => [
                    [
                        'name' => 'Máy bơm nước Super Win',
                        'slug' => 'may-bom-nuoc-super-win',
                        'description' => 'Máy bơm nước thương hiệu Super Win',
                        'image' => '/image/bom.png',

                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Máy bơm nước Vina Pump',
                        'slug' => 'may-bom-nuoc-vina-pump',
                        'description' => 'Máy bơm nước thương hiệu Vina Pump',
                        'image' => '/image/bom.png',

                        'sort_order' => 2,
                    ],
                    [
                        'name' => 'Máy bơm nước ABC',
                        'slug' => 'may-bom-nuoc-abc',
                        'description' => 'Máy bơm nước thương hiệu ABC',
                        'image' => '/image/bom.png',

                        'sort_order' => 3,
                    ],
                    [
                        'name' => 'Máy bơm nước biển',
                        'slug' => 'may-bom-nuoc-bien',
                        'description' => 'Máy bơm nước biển chuyên dụng',
                        'image' => '/image/bom.png',

                        'sort_order' => 4,
                    ],
                    [
                        'name' => 'Máy bơm hồ bơi',
                        'slug' => 'may-bom-ho-boi',
                        'description' => 'Máy bơm hồ bơi chuyên nghiệp',
                        'image' => '/image/bom.png',

                        'sort_order' => 5,
                    ],
                ]
            ],
            [
                'name' => 'Quạt Công Nghiệp',
                'slug' => 'quat-cong-nghiep',
                'description' => '🌪️ Quạt công nghiệp chất lượng cao cho nhà máy, xưởng sản xuất',
                'image' => '/image/quat.png',

                'sort_order' => 2,
                'children' => [
                    [
                        'name' => 'Quạt Super Win',
                        'slug' => 'quat-super-win',
                        'description' => 'Quạt công nghiệp thương hiệu Super Win',
                        'image' => '/image/quat.png',

                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Quạt Deton',
                        'slug' => 'quat-deton',
                        'description' => 'Quạt công nghiệp thương hiệu Deton',
                        'image' => '/image/quat.png',

                        'sort_order' => 2,
                    ],
                    [
                        'name' => 'Quạt STHC',
                        'slug' => 'quat-sthc',
                        'description' => 'Quạt công nghiệp thương hiệu STHC',
                        'image' => '/image/quat.png',

                        'sort_order' => 3,
                    ],
                    [
                        'name' => 'Quạt Inverter',
                        'slug' => 'quat-inverter',
                        'description' => 'Quạt công nghiệp Inverter tiết kiệm điện',
                        'image' => '/image/quat.png',

                        'sort_order' => 4,
                    ],
                ]
            ],
            [
                'name' => 'Quạt Thông Gió',
                'slug' => 'quat-thong-gio',
                'description' => '💨 Quạt thông gió cho nhà ở, văn phòng, công nghiệp',
                'image' => '/image/quat_tran.png',

                'sort_order' => 3,
                'children' => [
                    [
                        'name' => 'Quạt thông gió vuông Super Win',
                        'slug' => 'quat-thong-gio-vuong-super-win',
                        'description' => 'Quạt thông gió vuông thương hiệu Super Win',
                        'image' => '/image/quat_vuong.png',

                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Quạt thông gió vuông Deton',
                        'slug' => 'quat-thong-gio-vuong-deton',
                        'description' => 'Quạt thông gió vuông thương hiệu Deton',
                        'image' => '/image/quat_vuong.png',

                        'sort_order' => 2,
                    ],
                    [
                        'name' => 'Quạt thông gió tròn',
                        'slug' => 'quat-thong-gio-tron',
                        'description' => 'Quạt thông gió tròn đa dạng kích thước',
                        'image' => '/image/quat_tron.png',

                        'sort_order' => 3,
                    ],
                ]
            ],
            [
                'name' => 'Quạt Đặc Biệt',
                'slug' => 'quat-dac-biet',
                'description' => '⚡ Các loại quạt đặc biệt cho mục đích chuyên dụng',
                'image' => '/image/quat_tran.png',

                'sort_order' => 4,
                'children' => [
                    [
                        'name' => 'Quạt hướng trục nổi ống',
                        'slug' => 'quat-huong-truc-noi-ong',
                        'description' => 'Quạt hướng trục nổi ống công nghiệp',
                        'image' => '/image/quat_tran.png',

                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Quạt sàn công nghiệp',
                        'slug' => 'quat-san-cong-nghiep',
                        'description' => 'Quạt sàn công nghiệp chuyên dụng',
                        'image' => '/image/quat_tran.png',

                        'sort_order' => 2,
                    ],
                    [
                        'name' => 'Quạt trần công nghiệp',
                        'slug' => 'quat-tran-cong-nghiep',
                        'description' => 'Quạt trần công nghiệp chất lượng cao',
                        'image' => '/image/quat_tran.png',

                        'sort_order' => 3,
                    ],
                    [
                        'name' => 'Quạt chống cháy nổ',
                        'slug' => 'quat-chong-chay-no',
                        'description' => 'Quạt chống cháy nổ an toàn',
                        'image' => '/image/quat_tran.png',

                        'sort_order' => 4,
                    ],
                    [
                        'name' => 'Quạt vuông (trực tiếp/gián tiếp)',
                        'slug' => 'quat-vuong',
                        'description' => 'Quạt vuông trực tiếp và gián tiếp',
                        'image' => '/image/quat_vuong.png',
                        'product_type' => 'quat-vuong',
                        'sort_order' => 5,
                    ],
                    [
                        'name' => 'Quạt Composite',
                        'slug' => 'quat-composite',
                        'description' => 'Quạt Composite chống ăn mòn',
                        'image' => '/image/quat_tran.png',
                        'product_type' => 'quat-composite',
                        'sort_order' => 6,
                    ],
                ]
            ],
            [
                'name' => 'Tấm Làm Mát',
                'slug' => 'tam-lam-mat',
                'description' => '❄️ Tấm làm mát công nghiệp hiệu quả cao',
                'image' => '/image/quat_tran.png',
                'product_type' => 'tam-lam-mat',
                'sort_order' => 5,
            ],
            [
                'name' => 'Máy Bơm Chìm',
                'slug' => 'may-bom-chim',
                'description' => '🔧 Máy bơm chìm chất lượng cao',
                'image' => '/image/bom_chim.png',
                'product_type' => 'may-bom-chim',
                'sort_order' => 6,
            ],
        ];

        foreach ($mainCategories as $categoryData) {
            $children = $categoryData['children'] ?? [];
            unset($categoryData['children']);

            $category = Category::create($categoryData);

            foreach ($children as $childData) {
                $childData['parent_id'] = $category->id;
                Category::create($childData);
            }
        }
    }
}
