<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LucThapHoaGiapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // KIM (6)
            ['Giáp Tý', 'Giáp', 'Tý', 'Hải Trung Kim', 'Kim'],
            ['Ất Sửu', 'Ất', 'Sửu', 'Hải Trung Kim', 'Kim'],
            ['Nhâm Dần', 'Nhâm', 'Dần', 'Kim Bạch Kim', 'Kim'],
            ['Quý Mão', 'Quý', 'Mão', 'Kim Bạch Kim', 'Kim'],
            ['Canh Thìn', 'Canh', 'Thìn', 'Bạch Lạp Kim', 'Kim'],
            ['Tân Tỵ', 'Tân', 'Tỵ', 'Bạch Lạp Kim', 'Kim'],
            ['Giáp Ngọ', 'Giáp', 'Ngọ', 'Sa Trung Kim', 'Kim'],
            ['Ất Mùi', 'Ất', 'Mùi', 'Sa Trung Kim', 'Kim'],
            ['Nhâm Thân', 'Nhâm', 'Thân', 'Kiếm Phong Kim', 'Kim'],
            ['Quý Dậu', 'Quý', 'Dậu', 'Kiếm Phong Kim', 'Kim'],
            ['Canh Tuất', 'Canh', 'Tuất', 'Thoa Xuyến Kim', 'Kim'],
            ['Tân Hợi', 'Tân', 'Hợi', 'Thoa Xuyến Kim', 'Kim'],

            // MỘC (6)
            ['Nhâm Tý', 'Nhâm', 'Tý', 'Tang Đố Mộc', 'Mộc'],
            ['Quý Sửu', 'Quý', 'Sửu', 'Tang Đố Mộc', 'Mộc'],
            ['Canh Dần', 'Canh', 'Dần', 'Tùng Bách Mộc', 'Mộc'],
            ['Tân Mão', 'Tân', 'Mão', 'Tùng Bách Mộc', 'Mộc'],
            ['Mậu Thìn', 'Mậu', 'Thìn', 'Đại Lâm Mộc', 'Mộc'],
            ['Kỷ Tỵ', 'Kỷ', 'Tỵ', 'Đại Lâm Mộc', 'Mộc'],
            ['Nhâm Ngọ', 'Nhâm', 'Ngọ', 'Dương Liễu Mộc', 'Mộc'],
            ['Quý Mùi', 'Quý', 'Mùi', 'Dương Liễu Mộc', 'Mộc'],
            ['Canh Thân', 'Canh', 'Thân', 'Thạch Lựu Mộc', 'Mộc'],
            ['Tân Dậu', 'Tân', 'Dậu', 'Thạch Lựu Mộc', 'Mộc'],
            ['Mậu Tuất', 'Mậu', 'Tuất', 'Bình Địa Mộc', 'Mộc'],
            ['Kỷ Hợi', 'Kỷ', 'Hợi', 'Bình Địa Mộc', 'Mộc'],

            // THỦY (6)
            ['Bính Tý', 'Bính', 'Tý', 'Giản Hạ Thủy', 'Thủy'],
            ['Đinh Sửu', 'Đinh', 'Sửu', 'Giản Hạ Thủy', 'Thủy'],
            ['Giáp Dần', 'Giáp', 'Dần', 'Đại Khê Thủy', 'Thủy'],
            ['Ất Mão', 'Ất', 'Mão', 'Đại Khê Thủy', 'Thủy'],
            ['Nhâm Thìn', 'Nhâm', 'Thìn', 'Trường Lưu Thủy', 'Thủy'],
            ['Quý Tỵ', 'Quý', 'Tỵ', 'Trường Lưu Thủy', 'Thủy'],
            ['Bính Ngọ', 'Bính', 'Ngọ', 'Thiên Hà Thủy', 'Thủy'],
            ['Đinh Mùi', 'Đinh', 'Mùi', 'Thiên Hà Thủy', 'Thủy'],
            ['Giáp Thân', 'Giáp', 'Thân', 'Tuyền Trung Thủy', 'Thủy'],
            ['Ất Dậu', 'Ất', 'Dậu', 'Tuyền Trung Thủy', 'Thủy'],
            ['Nhâm Tuất', 'Nhâm', 'Tuất', 'Đại Hải Thủy', 'Thủy'],
            ['Quý Hợi', 'Quý', 'Hợi', 'Đại Hải Thủy', 'Thủy'],

            // HỎA (6)
            ['Mậu Tý', 'Mậu', 'Tý', 'Tích Lịch Hỏa', 'Hỏa'],
            ['Kỷ Sửu', 'Kỷ', 'Sửu', 'Tích Lịch Hỏa', 'Hỏa'],
            ['Bính Dần', 'Bính', 'Dần', 'Lư Trung Hỏa', 'Hỏa'],
            ['Đinh Mão', 'Đinh', 'Mão', 'Lư Trung Hỏa', 'Hỏa'],
            ['Giáp Thìn', 'Giáp', 'Thìn', 'Phú Đăng Hỏa', 'Hỏa'],
            ['Ất Tỵ', 'Ất', 'Tỵ', 'Phú Đăng Hỏa', 'Hỏa'],
            ['Mậu Ngọ', 'Mậu', 'Ngọ', 'Thiên Thượng Hỏa', 'Hỏa'],
            ['Kỷ Mùi', 'Kỷ', 'Mùi', 'Thiên Thượng Hỏa', 'Hỏa'],
            ['Bính Thân', 'Bính', 'Thân', 'Sơn Hạ Hỏa', 'Hỏa'],
            ['Đinh Dậu', 'Đinh', 'Dậu', 'Sơn Hạ Hỏa', 'Hỏa'],
            ['Giáp Tuất', 'Giáp', 'Tuất', 'Sơn Đầu Hỏa', 'Hỏa'],
            ['Ất Hợi', 'Ất', 'Hợi', 'Sơn Đầu Hỏa', 'Hỏa'],

            // THỔ (6)
            ['Canh Tý', 'Canh', 'Tý', 'Bích Thượng Thổ', 'Thổ'],
            ['Tân Sửu', 'Tân', 'Sửu', 'Bích Thượng Thổ', 'Thổ'],
            ['Mậu Dần', 'Mậu', 'Dần', 'Thành Đầu Thổ', 'Thổ'],
            ['Kỷ Mão', 'Kỷ', 'Mão', 'Thành Đầu Thổ', 'Thổ'],
            ['Bính Thìn', 'Bính', 'Thìn', 'Sa Trung Thổ', 'Thổ'],
            ['Đinh Tỵ', 'Đinh', 'Tỵ', 'Sa Trung Thổ', 'Thổ'],
            ['Canh Ngọ', 'Canh', 'Ngọ', 'Lộ Bàng Thổ', 'Thổ'],
            ['Tân Mùi', 'Tân', 'Mùi', 'Lộ Bàng Thổ', 'Thổ'],
            ['Mậu Thân', 'Mậu', 'Thân', 'Đại Trạch Thổ', 'Thổ'],
            ['Kỷ Dậu', 'Kỷ', 'Dậu', 'Đại Trạch Thổ', 'Thổ'],
            ['Bính Tuất', 'Bính', 'Tuất', 'Ốc Thượng Thổ', 'Thổ'],
            ['Đinh Hợi', 'Đinh', 'Hợi', 'Ốc Thượng Thổ', 'Thổ'],
        ];

        $insertData = [];
        foreach ($data as $row) {
            $insertData[] = [
                'can_chi' => $row[0],
                'can' => $row[1],
                'chi' => $row[2],
                'nap_am' => $row[3],
                'ngu_hanh' => $row[4],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('luc_thap_hoa_giap')->insert($insertData);
    }
}