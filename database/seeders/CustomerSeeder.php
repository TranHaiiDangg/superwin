<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo một số khách hàng mẫu
        $customers = [
            [
                'name' => 'Nguyễn Văn An',
                'email' => 'nguyenvanan@example.com',
                'phone' => '0901234567',
                'password' => Hash::make('password123'),
                'address' => '123 Đường ABC',
                'city' => 'Hồ Chí Minh',
                'district' => 'Quận 1',
                'ward' => 'Phường Bến Nghé',
                'customer_code' => 'CUS001',
                'status' => 'active',
            ],
            [
                'name' => 'Trần Thị Bình',
                'email' => 'tranthibinh@example.com',
                'phone' => '0901234568',
                'password' => Hash::make('password123'),
                'address' => '456 Đường XYZ',
                'city' => 'Hà Nội',
                'district' => 'Ba Đình',
                'ward' => 'Phường Phúc Xá',
                'customer_code' => 'CUS002',
                'status' => 'active',
            ],
            [
                'name' => 'Lê Văn Cường',
                'email' => 'levancuong@example.com',
                'phone' => '0901234569',
                'password' => Hash::make('password123'),
                'address' => '789 Đường DEF',
                'city' => 'Đà Nẵng',
                'district' => 'Hải Châu',
                'ward' => 'Phường Hải Châu I',
                'customer_code' => 'CUS003',
                'status' => 'active',
            ],
        ];

        foreach ($customers as $customerData) {
            Customer::create($customerData);
        }
    }
}
