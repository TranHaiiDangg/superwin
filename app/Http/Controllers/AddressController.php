<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class AddressController extends Controller
{
    /**
     * Lấy danh sách tỉnh/thành phố
     */
    public function getProvinces()
    {
        // Temporarily use fallback data for testing
        $provinces = $this->getFallbackProvinces();

        return response()->json([
            'success' => true,
            'data' => $provinces
        ]);
    }

    /**
     * Lấy danh sách quận/huyện theo tỉnh/thành phố
     */
    public function getDistricts($provinceCode)
    {
        // Fallback districts for major cities
        $fallbackDistricts = $this->getFallbackDistricts($provinceCode);
        
        return response()->json([
            'success' => true,
            'data' => $fallbackDistricts
        ]);
    }

    /**
     * Lấy danh sách phường/xã theo quận/huyện
     */
    public function getWards($districtCode)
    {
        // Fallback wards for major districts
        $fallbackWards = $this->getFallbackWards($districtCode);
        
        return response()->json([
            'success' => true,
            'data' => $fallbackWards
        ]);
    }

    /**
     * Danh sách tỉnh/thành phố dự phòng khi API lỗi
     */
    private function getFallbackProvinces()
    {
        return [
            ['code' => '01', 'name' => 'Hà Nội', 'full_name' => 'Thành phố Hà Nội', 'code_name' => 'ha_noi'],
            ['code' => '79', 'name' => 'Hồ Chí Minh', 'full_name' => 'Thành phố Hồ Chí Minh', 'code_name' => 'ho_chi_minh'],
            ['code' => '48', 'name' => 'Đà Nẵng', 'full_name' => 'Thành phố Đà Nẵng', 'code_name' => 'da_nang'],
            ['code' => '92', 'name' => 'Cần Thơ', 'full_name' => 'Thành phố Cần Thơ', 'code_name' => 'can_tho'],
            ['code' => '31', 'name' => 'Hải Phòng', 'full_name' => 'Thành phố Hải Phòng', 'code_name' => 'hai_phong'],
            ['code' => '02', 'name' => 'Hà Giang', 'full_name' => 'Tỉnh Hà Giang', 'code_name' => 'ha_giang'],
            ['code' => '04', 'name' => 'Cao Bằng', 'full_name' => 'Tỉnh Cao Bằng', 'code_name' => 'cao_bang'],
            ['code' => '06', 'name' => 'Bắc Kạn', 'full_name' => 'Tỉnh Bắc Kạn', 'code_name' => 'bac_kan'],
            ['code' => '08', 'name' => 'Tuyên Quang', 'full_name' => 'Tỉnh Tuyên Quang', 'code_name' => 'tuyen_quang'],
            ['code' => '10', 'name' => 'Lào Cai', 'full_name' => 'Tỉnh Lào Cai', 'code_name' => 'lao_cai'],
            ['code' => '11', 'name' => 'Điện Biên', 'full_name' => 'Tỉnh Điện Biên', 'code_name' => 'dien_bien'],
            ['code' => '12', 'name' => 'Lai Châu', 'full_name' => 'Tỉnh Lai Châu', 'code_name' => 'lai_chau'],
            ['code' => '14', 'name' => 'Sơn La', 'full_name' => 'Tỉnh Sơn La', 'code_name' => 'son_la'],
            ['code' => '15', 'name' => 'Yên Bái', 'full_name' => 'Tỉnh Yên Bái', 'code_name' => 'yen_bai'],
            ['code' => '17', 'name' => 'Hoà Bình', 'full_name' => 'Tỉnh Hoà Bình', 'code_name' => 'hoa_binh'],
            ['code' => '19', 'name' => 'Thái Nguyên', 'full_name' => 'Tỉnh Thái Nguyên', 'code_name' => 'thai_nguyen'],
            ['code' => '20', 'name' => 'Lạng Sơn', 'full_name' => 'Tỉnh Lạng Sơn', 'code_name' => 'lang_son'],
            ['code' => '22', 'name' => 'Quảng Ninh', 'full_name' => 'Tỉnh Quảng Ninh', 'code_name' => 'quang_ninh'],
            ['code' => '24', 'name' => 'Bắc Giang', 'full_name' => 'Tỉnh Bắc Giang', 'code_name' => 'bac_giang'],
            ['code' => '25', 'name' => 'Phú Thọ', 'full_name' => 'Tỉnh Phú Thọ', 'code_name' => 'phu_tho'],
            ['code' => '26', 'name' => 'Vĩnh Phúc', 'full_name' => 'Tỉnh Vĩnh Phúc', 'code_name' => 'vinh_phuc'],
            ['code' => '27', 'name' => 'Bắc Ninh', 'full_name' => 'Tỉnh Bắc Ninh', 'code_name' => 'bac_ninh'],
            ['code' => '30', 'name' => 'Hải Dương', 'full_name' => 'Tỉnh Hải Dương', 'code_name' => 'hai_duong'],
            ['code' => '33', 'name' => 'Hưng Yên', 'full_name' => 'Tỉnh Hưng Yên', 'code_name' => 'hung_yen'],
            ['code' => '34', 'name' => 'Thái Bình', 'full_name' => 'Tỉnh Thái Bình', 'code_name' => 'thai_binh'],
            ['code' => '35', 'name' => 'Hà Nam', 'full_name' => 'Tỉnh Hà Nam', 'code_name' => 'ha_nam'],
            ['code' => '36', 'name' => 'Nam Định', 'full_name' => 'Tỉnh Nam Định', 'code_name' => 'nam_dinh'],
            ['code' => '37', 'name' => 'Ninh Bình', 'full_name' => 'Tỉnh Ninh Bình', 'code_name' => 'ninh_binh'],
            ['code' => '38', 'name' => 'Thanh Hóa', 'full_name' => 'Tỉnh Thanh Hóa', 'code_name' => 'thanh_hoa'],
            ['code' => '40', 'name' => 'Nghệ An', 'full_name' => 'Tỉnh Nghệ An', 'code_name' => 'nghe_an'],
            ['code' => '42', 'name' => 'Hà Tĩnh', 'full_name' => 'Tỉnh Hà Tĩnh', 'code_name' => 'ha_tinh'],
            ['code' => '44', 'name' => 'Quảng Bình', 'full_name' => 'Tỉnh Quảng Bình', 'code_name' => 'quang_binh'],
            ['code' => '45', 'name' => 'Quảng Trị', 'full_name' => 'Tỉnh Quảng Trị', 'code_name' => 'quang_tri'],
            ['code' => '46', 'name' => 'Thừa Thiên Huế', 'full_name' => 'Tỉnh Thừa Thiên Huế', 'code_name' => 'thua_thien_hue'],
            ['code' => '49', 'name' => 'Quảng Nam', 'full_name' => 'Tỉnh Quảng Nam', 'code_name' => 'quang_nam'],
            ['code' => '51', 'name' => 'Quảng Ngãi', 'full_name' => 'Tỉnh Quảng Ngãi', 'code_name' => 'quang_ngai'],
            ['code' => '52', 'name' => 'Bình Định', 'full_name' => 'Tỉnh Bình Định', 'code_name' => 'binh_dinh'],
            ['code' => '54', 'name' => 'Phú Yên', 'full_name' => 'Tỉnh Phú Yên', 'code_name' => 'phu_yen'],
            ['code' => '56', 'name' => 'Khánh Hòa', 'full_name' => 'Tỉnh Khánh Hòa', 'code_name' => 'khanh_hoa'],
            ['code' => '58', 'name' => 'Ninh Thuận', 'full_name' => 'Tỉnh Ninh Thuận', 'code_name' => 'ninh_thuan'],
            ['code' => '60', 'name' => 'Bình Thuận', 'full_name' => 'Tỉnh Bình Thuận', 'code_name' => 'binh_thuan'],
            ['code' => '62', 'name' => 'Kon Tum', 'full_name' => 'Tỉnh Kon Tum', 'code_name' => 'kon_tum'],
            ['code' => '64', 'name' => 'Gia Lai', 'full_name' => 'Tỉnh Gia Lai', 'code_name' => 'gia_lai'],
            ['code' => '66', 'name' => 'Đắk Lắk', 'full_name' => 'Tỉnh Đắk Lắk', 'code_name' => 'dak_lak'],
            ['code' => '67', 'name' => 'Đắk Nông', 'full_name' => 'Tỉnh Đắk Nông', 'code_name' => 'dak_nong'],
            ['code' => '68', 'name' => 'Lâm Đồng', 'full_name' => 'Tỉnh Lâm Đồng', 'code_name' => 'lam_dong'],
            ['code' => '70', 'name' => 'Bình Phước', 'full_name' => 'Tỉnh Bình Phước', 'code_name' => 'binh_phuoc'],
            ['code' => '72', 'name' => 'Tây Ninh', 'full_name' => 'Tỉnh Tây Ninh', 'code_name' => 'tay_ninh'],
            ['code' => '74', 'name' => 'Bình Dương', 'full_name' => 'Tỉnh Bình Dương', 'code_name' => 'binh_duong'],
            ['code' => '75', 'name' => 'Đồng Nai', 'full_name' => 'Tỉnh Đồng Nai', 'code_name' => 'dong_nai'],
            ['code' => '77', 'name' => 'Bà Rịa - Vũng Tàu', 'full_name' => 'Tỉnh Bà Rịa - Vũng Tàu', 'code_name' => 'ba_ria_vung_tau'],
            ['code' => '80', 'name' => 'Long An', 'full_name' => 'Tỉnh Long An', 'code_name' => 'long_an'],
            ['code' => '82', 'name' => 'Tiền Giang', 'full_name' => 'Tỉnh Tiền Giang', 'code_name' => 'tien_giang'],
            ['code' => '83', 'name' => 'Bến Tre', 'full_name' => 'Tỉnh Bến Tre', 'code_name' => 'ben_tre'],
            ['code' => '84', 'name' => 'Trà Vinh', 'full_name' => 'Tỉnh Trà Vinh', 'code_name' => 'tra_vinh'],
            ['code' => '86', 'name' => 'Vĩnh Long', 'full_name' => 'Tỉnh Vĩnh Long', 'code_name' => 'vinh_long'],
            ['code' => '87', 'name' => 'Đồng Tháp', 'full_name' => 'Tỉnh Đồng Tháp', 'code_name' => 'dong_thap'],
            ['code' => '89', 'name' => 'An Giang', 'full_name' => 'Tỉnh An Giang', 'code_name' => 'an_giang'],
            ['code' => '91', 'name' => 'Kiên Giang', 'full_name' => 'Tỉnh Kiên Giang', 'code_name' => 'kien_giang'],
            ['code' => '93', 'name' => 'Hậu Giang', 'full_name' => 'Tỉnh Hậu Giang', 'code_name' => 'hau_giang'],
            ['code' => '94', 'name' => 'Sóc Trăng', 'full_name' => 'Tỉnh Sóc Trăng', 'code_name' => 'soc_trang'],
            ['code' => '95', 'name' => 'Bạc Liêu', 'full_name' => 'Tỉnh Bạc Liêu', 'code_name' => 'bac_lieu'],
            ['code' => '96', 'name' => 'Cà Mau', 'full_name' => 'Tỉnh Cà Mau', 'code_name' => 'ca_mau'],
        ];
    }

    /**
     * Danh sách quận/huyện dự phòng
     */
    private function getFallbackDistricts($provinceCode)
    {
        $districts = [
            '01' => [ // Hà Nội
                ['code' => '001', 'name' => 'Ba Đình', 'full_name' => 'Quận Ba Đình', 'code_name' => 'ba_dinh'],
                ['code' => '002', 'name' => 'Hoàn Kiếm', 'full_name' => 'Quận Hoàn Kiếm', 'code_name' => 'hoan_kiem'],
                ['code' => '003', 'name' => 'Tây Hồ', 'full_name' => 'Quận Tây Hồ', 'code_name' => 'tay_ho'],
                ['code' => '004', 'name' => 'Long Biên', 'full_name' => 'Quận Long Biên', 'code_name' => 'long_bien'],
                ['code' => '005', 'name' => 'Cầu Giấy', 'full_name' => 'Quận Cầu Giấy', 'code_name' => 'cau_giay'],
                ['code' => '006', 'name' => 'Đống Đa', 'full_name' => 'Quận Đống Đa', 'code_name' => 'dong_da'],
                ['code' => '007', 'name' => 'Hai Bà Trưng', 'full_name' => 'Quận Hai Bà Trưng', 'code_name' => 'hai_ba_trung'],
                ['code' => '008', 'name' => 'Hoàng Mai', 'full_name' => 'Quận Hoàng Mai', 'code_name' => 'hoang_mai'],
                ['code' => '009', 'name' => 'Thanh Xuân', 'full_name' => 'Quận Thanh Xuân', 'code_name' => 'thanh_xuan'],
            ],
            '79' => [ // Hồ Chí Minh
                ['code' => '760', 'name' => 'Quận 1', 'full_name' => 'Quận 1', 'code_name' => 'quan_1'],
                ['code' => '761', 'name' => 'Quận 2', 'full_name' => 'Quận 2', 'code_name' => 'quan_2'],
                ['code' => '762', 'name' => 'Quận 3', 'full_name' => 'Quận 3', 'code_name' => 'quan_3'],
                ['code' => '763', 'name' => 'Quận 4', 'full_name' => 'Quận 4', 'code_name' => 'quan_4'],
                ['code' => '764', 'name' => 'Quận 5', 'full_name' => 'Quận 5', 'code_name' => 'quan_5'],
                ['code' => '765', 'name' => 'Quận 6', 'full_name' => 'Quận 6', 'code_name' => 'quan_6'],
                ['code' => '766', 'name' => 'Quận 7', 'full_name' => 'Quận 7', 'code_name' => 'quan_7'],
                ['code' => '767', 'name' => 'Quận 8', 'full_name' => 'Quận 8', 'code_name' => 'quan_8'],
                ['code' => '768', 'name' => 'Quận 9', 'full_name' => 'Quận 9', 'code_name' => 'quan_9'],
                ['code' => '769', 'name' => 'Quận 10', 'full_name' => 'Quận 10', 'code_name' => 'quan_10'],
                ['code' => '770', 'name' => 'Quận 11', 'full_name' => 'Quận 11', 'code_name' => 'quan_11'],
                ['code' => '771', 'name' => 'Quận 12', 'full_name' => 'Quận 12', 'code_name' => 'quan_12'],
                ['code' => '772', 'name' => 'Quận Bình Thạnh', 'full_name' => 'Quận Bình Thạnh', 'code_name' => 'binh_thanh'],
                ['code' => '773', 'name' => 'Quận Gò Vấp', 'full_name' => 'Quận Gò Vấp', 'code_name' => 'go_vap'],
                ['code' => '774', 'name' => 'Quận Phú Nhuận', 'full_name' => 'Quận Phú Nhuận', 'code_name' => 'phu_nhuan'],
                ['code' => '775', 'name' => 'Quận Tân Bình', 'full_name' => 'Quận Tân Bình', 'code_name' => 'tan_binh'],
                ['code' => '776', 'name' => 'Quận Tân Phú', 'full_name' => 'Quận Tân Phú', 'code_name' => 'tan_phu'],
                ['code' => '777', 'name' => 'Thành phố Thủ Đức', 'full_name' => 'Thành phố Thủ Đức', 'code_name' => 'thu_duc'],
            ],
            '48' => [ // Đà Nẵng
                ['code' => '490', 'name' => 'Hải Châu', 'full_name' => 'Quận Hải Châu', 'code_name' => 'hai_chau'],
                ['code' => '491', 'name' => 'Thanh Khê', 'full_name' => 'Quận Thanh Khê', 'code_name' => 'thanh_khe'],
                ['code' => '492', 'name' => 'Sơn Trà', 'full_name' => 'Quận Sơn Trà', 'code_name' => 'son_tra'],
                ['code' => '493', 'name' => 'Ngũ Hành Sơn', 'full_name' => 'Quận Ngũ Hành Sơn', 'code_name' => 'ngu_hanh_son'],
                ['code' => '494', 'name' => 'Liên Chiểu', 'full_name' => 'Quận Liên Chiểu', 'code_name' => 'lien_chieu'],
                ['code' => '495', 'name' => 'Cẩm Lệ', 'full_name' => 'Quận Cẩm Lệ', 'code_name' => 'cam_le'],
            ],
        ];

        return $districts[$provinceCode] ?? [
            ['code' => '999', 'name' => 'Trung tâm', 'full_name' => 'Trung tâm thành phố', 'code_name' => 'trung_tam'],
            ['code' => '998', 'name' => 'Ngoại thành', 'full_name' => 'Khu vực ngoại thành', 'code_name' => 'ngoai_thanh'],
        ];
    }

    /**
     * Danh sách phường/xã dự phòng
     */
    private function getFallbackWards($districtCode)
    {
        // Generic wards for any district
        return [
            ['code' => '10001', 'name' => 'Phường 1', 'full_name' => 'Phường 1', 'code_name' => 'phuong_1'],
            ['code' => '10002', 'name' => 'Phường 2', 'full_name' => 'Phường 2', 'code_name' => 'phuong_2'],
            ['code' => '10003', 'name' => 'Phường 3', 'full_name' => 'Phường 3', 'code_name' => 'phuong_3'],
            ['code' => '10004', 'name' => 'Phường 4', 'full_name' => 'Phường 4', 'code_name' => 'phuong_4'],
            ['code' => '10005', 'name' => 'Phường 5', 'full_name' => 'Phường 5', 'code_name' => 'phuong_5'],
            ['code' => '10006', 'name' => 'Phường Trung tâm', 'full_name' => 'Phường Trung tâm', 'code_name' => 'trung_tam'],
            ['code' => '10007', 'name' => 'Phường Đông', 'full_name' => 'Phường Đông', 'code_name' => 'dong'],
            ['code' => '10008', 'name' => 'Phường Tây', 'full_name' => 'Phường Tây', 'code_name' => 'tay'],
            ['code' => '10009', 'name' => 'Phường Nam', 'full_name' => 'Phường Nam', 'code_name' => 'nam'],
            ['code' => '10010', 'name' => 'Phường Bắc', 'full_name' => 'Phường Bắc', 'code_name' => 'bac'],
        ];
    }
}
