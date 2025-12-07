<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stars = [
            // --- 1. CHÍNH TINH (14 sao) ---
            // Nam Đẩu Tinh
            ['name' => 'Thiên Phủ', 'slug' => 'thien-phu', 'group_type' => 'chinh_tinh', 'default_element' => 'Thổ', 'is_main' => true, 'quality' => 'Nam Đẩu Tinh'],
            ['name' => 'Thiên Lương', 'slug' => 'thien-luong', 'group_type' => 'chinh_tinh', 'default_element' => 'Mộc', 'is_main' => true, 'quality' => 'Nam Đẩu Tinh'],
            ['name' => 'Thiên Cơ', 'slug' => 'thien-co', 'group_type' => 'chinh_tinh', 'default_element' => 'Mộc', 'is_main' => true, 'quality' => 'Nam Đẩu Tinh'],
            ['name' => 'Thiên Đồng', 'slug' => 'thien-dong', 'group_type' => 'chinh_tinh', 'default_element' => 'Thủy', 'is_main' => true, 'quality' => 'Nam Đẩu Tinh'],
            ['name' => 'Thiên Tướng', 'slug' => 'thien-tuong', 'group_type' => 'chinh_tinh', 'default_element' => 'Thủy', 'is_main' => true, 'quality' => 'Nam Đẩu Tinh'],
            ['name' => 'Thất Sát', 'slug' => 'that-sat', 'group_type' => 'chinh_tinh', 'default_element' => 'Kim', 'is_main' => true, 'quality' => 'Nam Đẩu Tinh'], // Cũng là Bắc Đẩu
            ['name' => 'Văn Xương', 'slug' => 'van-xuong', 'group_type' => 'cat_tinh', 'default_element' => 'Kim', 'is_main' => false, 'quality' => 'Trung Tinh'], // Often treated importantly

            // Bắc Đẩu Tinh
            ['name' => 'Tử Vi', 'slug' => 'tu-vi', 'group_type' => 'chinh_tinh', 'default_element' => 'Thổ', 'is_main' => true, 'quality' => 'Đế Tinh - Bắc Đẩu Chủ'],
            ['name' => 'Liêm Trinh', 'slug' => 'liem-trinh', 'group_type' => 'chinh_tinh', 'default_element' => 'Hỏa', 'is_main' => true, 'quality' => 'Bắc Đẩu Tinh'],
            ['name' => 'Vũ Khúc', 'slug' => 'vu-khuc', 'group_type' => 'chinh_tinh', 'default_element' => 'Kim', 'is_main' => true, 'quality' => 'Bắc Đẩu Tinh'],
            ['name' => 'Phá Quân', 'slug' => 'pha-quan', 'group_type' => 'chinh_tinh', 'default_element' => 'Thủy', 'is_main' => true, 'quality' => 'Bắc Đẩu Tinh'],
            ['name' => 'Tham Lang', 'slug' => 'tham-lang', 'group_type' => 'chinh_tinh', 'default_element' => 'Thủy', 'is_main' => true, 'quality' => 'Bắc Đẩu Tinh'], // Kiêm Nam Đẩu
            ['name' => 'Cự Môn', 'slug' => 'cu-mon', 'group_type' => 'chinh_tinh', 'default_element' => 'Thủy', 'is_main' => true, 'quality' => 'Bắc Đẩu Tinh'],
            
            // Trung Thiên Tinh
            ['name' => 'Thái Dương', 'slug' => 'thai-duong', 'group_type' => 'chinh_tinh', 'default_element' => 'Hỏa', 'is_main' => true, 'quality' => 'Trung Thiên Tinh (Nhật)'],
            ['name' => 'Thái Âm', 'slug' => 'thai-am', 'group_type' => 'chinh_tinh', 'default_element' => 'Thủy', 'is_main' => true, 'quality' => 'Trung Thiên Tinh (Nguyệt)'],

            // --- 2. LỤC CÁT TINH (6 sao tốt) ---
            ['name' => 'Văn Khúc', 'slug' => 'van-khuc', 'group_type' => 'cat_tinh', 'default_element' => 'Thủy', 'is_main' => false, 'quality' => 'Cát Tinh'],
            ['name' => 'Tả Phù', 'slug' => 'ta-phu', 'group_type' => 'cat_tinh', 'default_element' => 'Thổ', 'is_main' => false, 'quality' => 'Cát Tinh'],
            ['name' => 'Hữu Bật', 'slug' => 'huu-bat', 'group_type' => 'cat_tinh', 'default_element' => 'Thổ', 'is_main' => false, 'quality' => 'Cát Tinh'],
            ['name' => 'Thiên Khôi', 'slug' => 'thien-khoi', 'group_type' => 'cat_tinh', 'default_element' => 'Hỏa', 'is_main' => false, 'quality' => 'Cát Tinh'],
            ['name' => 'Thiên Việt', 'slug' => 'thien-viet', 'group_type' => 'cat_tinh', 'default_element' => 'Hỏa', 'is_main' => false, 'quality' => 'Cát Tinh'],
            // Văn Xương đã ở trên (do đôi khi xếp gần chính tinh về độ quan trọng trong an sao)

            // --- 3. LỤC SÁT TINH (6 sao xấu) ---
            ['name' => 'Kình Dương', 'slug' => 'kinh-duong', 'group_type' => 'sat_tinh', 'default_element' => 'Kim', 'is_main' => false, 'quality' => 'Sát Tinh'],
            ['name' => 'Đà La', 'slug' => 'da-la', 'group_type' => 'sat_tinh', 'default_element' => 'Kim', 'is_main' => false, 'quality' => 'Sát Tinh'],
            ['name' => 'Địa Không', 'slug' => 'dia-khong', 'group_type' => 'sat_tinh', 'default_element' => 'Hỏa', 'is_main' => false, 'quality' => 'Sát Tinh'],
            ['name' => 'Địa Kiếp', 'slug' => 'dia-kiep', 'group_type' => 'sat_tinh', 'default_element' => 'Hỏa', 'is_main' => false, 'quality' => 'Sát Tinh'],
            ['name' => 'Hỏa Tinh', 'slug' => 'hoa-tinh', 'group_type' => 'sat_tinh', 'default_element' => 'Hỏa', 'is_main' => false, 'quality' => 'Sát Tinh'],
            ['name' => 'Linh Tinh', 'slug' => 'linh-tinh', 'group_type' => 'sat_tinh', 'default_element' => 'Hỏa', 'is_main' => false, 'quality' => 'Sát Tinh'],

            // --- 4. TỨ HÓA (Biến hóa) ---
            ['name' => 'Hóa Lộc', 'slug' => 'hoa-loc', 'group_type' => 'tu_hoa', 'default_element' => 'Mộc', 'is_main' => false, 'quality' => 'Cát Tinh'],
            ['name' => 'Hóa Quyền', 'slug' => 'hoa-quyen', 'group_type' => 'tu_hoa', 'default_element' => 'Mộc', 'is_main' => false, 'quality' => 'Cát Tinh'],
            ['name' => 'Hóa Khoa', 'slug' => 'hoa-khoa', 'group_type' => 'tu_hoa', 'default_element' => 'Thủy', 'is_main' => false, 'quality' => 'Cát Tinh'],
            ['name' => 'Hóa Kỵ', 'slug' => 'hoa-ky', 'group_type' => 'tu_hoa', 'default_element' => 'Thủy', 'is_main' => false, 'quality' => 'Ám Tinh'],

            // --- 5. SAO KHÁC (Phổ biến) ---
            ['name' => 'Lộc Tồn', 'slug' => 'loc-ton', 'group_type' => 'cat_tinh', 'default_element' => 'Thổ', 'is_main' => false, 'quality' => 'Cát Tinh'],
            ['name' => 'Thiên Mã', 'slug' => 'thien-ma', 'group_type' => 'phu_tinh', 'default_element' => 'Hỏa', 'is_main' => false, 'quality' => 'Nghị lực'],
            ['name' => 'Đào Hoa', 'slug' => 'dao-hoa', 'group_type' => 'phu_tinh', 'default_element' => 'Mộc', 'is_main' => false, 'quality' => 'Duyên, Sắc'],
            ['name' => 'Hồng Loan', 'slug' => 'hong-loan', 'group_type' => 'phu_tinh', 'default_element' => 'Thủy', 'is_main' => false, 'quality' => 'Duyên, Hỷ'],
            ['name' => 'Thiên Hỷ', 'slug' => 'thien-hy', 'group_type' => 'phu_tinh', 'default_element' => 'Thủy', 'is_main' => false, 'quality' => 'Vui vẻ'],
            ['name' => 'Cô Thần', 'slug' => 'co-than', 'group_type' => 'phu_tinh', 'default_element' => 'Thổ', 'is_main' => false, 'quality' => 'Cô độc'],
            ['name' => 'Quả Tú', 'slug' => 'qua-tu', 'group_type' => 'phu_tinh', 'default_element' => 'Thổ', 'is_main' => false, 'quality' => 'Cô độc'],
            ['name' => 'Phục Binh', 'slug' => 'phuc-binh', 'group_type' => 'phu_tinh', 'default_element' => 'Hỏa', 'is_main' => false, 'quality' => 'Ám Tinh'],
            ['name' => 'Tướng Quân', 'slug' => 'tuong-quan', 'group_type' => 'phu_tinh', 'default_element' => 'Mộc', 'is_main' => false, 'quality' => 'Quyền'],
            ['name' => 'Thiên Hình', 'slug' => 'thien-hinh', 'group_type' => 'phu_tinh', 'default_element' => 'Hỏa', 'is_main' => false, 'quality' => 'Hình khắc'],
            ['name' => 'Thiên Riêu', 'slug' => 'thien-rieu', 'group_type' => 'phu_tinh', 'default_element' => 'Thủy', 'is_main' => false, 'quality' => 'Ám Tinh, Dục'],

        ];

        foreach ($stars as $star) {
            $star['created_at'] = now();
            $star['updated_at'] = now();
            DB::table('stars')->updateOrInsert(
                ['slug' => $star['slug']], // Check duplicate slug
                $star
            );
        }
    }
}