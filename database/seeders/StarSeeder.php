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
            
            // --- 6. TUẦN / TRIỆT ---
            ['name' => 'Tuần', 'slug' => 'tuan', 'group_type' => 'khac', 'is_main' => false, 'quality' => 'Không Vong'],
            ['name' => 'Triệt', 'slug' => 'triet', 'group_type' => 'khac', 'is_main' => false, 'quality' => 'Không Vong'],

            // --- 7. VÒNG THÁI TUẾ ---
            ['name' => 'Thái Tuế', 'slug' => 'thai-tue', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Đứng đầu vòng Thái Tuế'],
            ['name' => 'Thiếu Dương', 'slug' => 'thieu-duong', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Sao phụ vòng Thái Tuế'],
            ['name' => 'Tang Môn', 'slug' => 'tang-mon', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Sao phụ vòng Thái Tuế'],
            ['name' => 'Thiếu Âm', 'slug' => 'thieu-am', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Sao phụ vòng Thái Tuế'],
            ['name' => 'Quan Phù', 'slug' => 'quan-phu', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Sao phụ vòng Thái Tuế'],
            ['name' => 'Tử Phù', 'slug' => 'tu-phu', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Sao phụ vòng Thái Tuế'],
            ['name' => 'Tuế Phá', 'slug' => 'tue-pha', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Sao phụ vòng Thái Tuế'],
            ['name' => 'Long Đức', 'slug' => 'long-duc', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Sao phụ vòng Thái Tuế'],
            ['name' => 'Bạch Hổ', 'slug' => 'bach-ho', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Sao phụ vòng Thái Tuế'],
            ['name' => 'Phúc Đức', 'slug' => 'phuc-duc', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Sao phụ vòng Thái Tuế'],
            ['name' => 'Điếu Khách', 'slug' => 'dieu-khach', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Sao phụ vòng Thái Tuế'],
            ['name' => 'Trực Phù', 'slug' => 'truc-phu', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Sao phụ vòng Thái Tuế'],

            // --- 8. VÒNG TRÀNG SINH ---
            ['name' => 'Tràng Sinh', 'slug' => 'trang-sinh', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Đứng đầu vòng Tràng Sinh'],
            ['name' => 'Mộc Dục', 'slug' => 'moc-duc', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Sao phụ vòng Tràng Sinh'],
            ['name' => 'Quan Đới', 'slug' => 'quan-doi', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Sao phụ vòng Tràng Sinh'],
            ['name' => 'Lâm Quan', 'slug' => 'lam-quan', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Sao phụ vòng Tràng Sinh'],
            ['name' => 'Đế Vượng', 'slug' => 'de-vuong', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Sao phụ vòng Tràng Sinh'],
            ['name' => 'Suy', 'slug' => 'suy', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Sao phụ vòng Tràng Sinh'],
            ['name' => 'Bệnh', 'slug' => 'benh', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Sao phụ vòng Tràng Sinh'],
            ['name' => 'Tử', 'slug' => 'tu', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Sao phụ vòng Tràng Sinh'],
            ['name' => 'Mộ', 'slug' => 'mo', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Sao phụ vòng Tràng Sinh'],
            ['name' => 'Tuyệt', 'slug' => 'tuyet', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Sao phụ vòng Tràng Sinh'],
            ['name' => 'Thai', 'slug' => 'thai', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Sao phụ vòng Tràng Sinh'],
            ['name' => 'Dưỡng', 'slug' => 'duong', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Sao phụ vòng Tràng Sinh'],

            // --- 9. VÒNG BÁC SỸ ---
            ['name' => 'Bác Sỹ', 'slug' => 'bac-sy', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Đứng đầu vòng Bác Sỹ'],
            ['name' => 'Lực Sỹ', 'slug' => 'luc-sy', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Sao phụ vòng Bác Sỹ'],
            ['name' => 'Thanh Long', 'slug' => 'thanh-long', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Sao phụ vòng Bác Sỹ'],
            ['name' => 'Tiểu Hao', 'slug' => 'tieu-hao', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Sao phụ vòng Bác Sỹ'],
            // Tướng Quân đã có
            ['name' => 'Tấu Thư', 'slug' => 'tau-thu', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Sao phụ vòng Bác Sỹ'],
            ['name' => 'Phi Liêm', 'slug' => 'phi-liem', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Sao phụ vòng Bác Sỹ'],
            ['name' => 'Hỷ Thần', 'slug' => 'hy-than', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Sao phụ vòng Bác Sỹ'],
            ['name' => 'Bệnh Phù', 'slug' => 'benh-phu', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Sao phụ vòng Bác Sỹ'],
            ['name' => 'Đại Hao', 'slug' => 'dai-hao', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Sao phụ vòng Bác Sỹ'],
            // Phục Binh đã có
            ['name' => 'Quan Phủ', 'slug' => 'quan-phu-bac-sy', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Sao phụ vòng Bác Sỹ'], 

            // --- 10. SAO LƯU (Theo năm xem) ---
            ['name' => 'L.Thái Tuế', 'slug' => 'luu-thai-tue', 'group_type' => 'luu_tinh', 'is_main' => false, 'quality' => 'Sao Lưu'],
            ['name' => 'L.Lộc Tồn', 'slug' => 'luu-loc-ton', 'group_type' => 'luu_tinh', 'is_main' => false, 'quality' => 'Sao Lưu'],
            ['name' => 'L.Kình Dương', 'slug' => 'luu-kinh-duong', 'group_type' => 'luu_tinh', 'is_main' => false, 'quality' => 'Sao Lưu'],
            ['name' => 'L.Đà La', 'slug' => 'luu-da-la', 'group_type' => 'luu_tinh', 'is_main' => false, 'quality' => 'Sao Lưu'],
            ['name' => 'L.Thiên Mã', 'slug' => 'luu-thien-ma', 'group_type' => 'luu_tinh', 'is_main' => false, 'quality' => 'Sao Lưu'],
            ['name' => 'L.Bạch Hổ', 'slug' => 'luu-bach-ho', 'group_type' => 'luu_tinh', 'is_main' => false, 'quality' => 'Sao Lưu'],
            ['name' => 'L.Tang Môn', 'slug' => 'luu-tang-mon', 'group_type' => 'luu_tinh', 'is_main' => false, 'quality' => 'Sao Lưu'],
            ['name' => 'L.Thiên Khốc', 'slug' => 'luu-thien-khoc', 'group_type' => 'luu_tinh', 'is_main' => false, 'quality' => 'Sao Lưu'],
            ['name' => 'L.Thiên Hư', 'slug' => 'luu-thien-hu', 'group_type' => 'luu_tinh', 'is_main' => false, 'quality' => 'Sao Lưu'],
            ['name' => 'L.Đào Hoa', 'slug' => 'luu-dao-hoa', 'group_type' => 'luu_tinh', 'is_main' => false, 'quality' => 'Sao Lưu'],
            ['name' => 'L.Hồng Loan', 'slug' => 'luu-hong-loan', 'group_type' => 'luu_tinh', 'is_main' => false, 'quality' => 'Sao Lưu'],
            ['name' => 'L.Thiên Hỷ', 'slug' => 'luu-thien-hy', 'group_type' => 'luu_tinh', 'is_main' => false, 'quality' => 'Sao Lưu'],
            ['name' => 'L.Hóa Lộc', 'slug' => 'luu-hoa-loc', 'group_type' => 'luu_tinh', 'is_main' => false, 'quality' => 'Sao Lưu'],
            ['name' => 'L.Hóa Quyền', 'slug' => 'luu-hoa-quyen', 'group_type' => 'luu_tinh', 'is_main' => false, 'quality' => 'Sao Lưu'],
            ['name' => 'L.Hóa Khoa', 'slug' => 'luu-hoa-khoa', 'group_type' => 'luu_tinh', 'is_main' => false, 'quality' => 'Sao Lưu'],
            ['name' => 'L.Hóa Kỵ', 'slug' => 'luu-hoa-ky', 'group_type' => 'luu_tinh', 'is_main' => false, 'quality' => 'Sao Lưu'],

            // --- 11. SAO NHỎ KHÁC ---
            ['name' => 'Địa Giải', 'slug' => 'dia-giai', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Giải ách'],
            ['name' => 'Thiên Giải', 'slug' => 'thien-giai', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Giải ách'],
            ['name' => 'Giải Thần', 'slug' => 'giai-than', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Giải ách'],
            ['name' => 'Phá Toái', 'slug' => 'pha-toai', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Hao tán'],
            ['name' => 'Thiên Quan', 'slug' => 'thien-quan', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Quý tinh'],
            ['name' => 'Thiên Phúc', 'slug' => 'thien-phuc', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Quý tinh'],
            ['name' => 'Thiên Tài', 'slug' => 'thien-tai', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Tài năng'],
            ['name' => 'Thiên Thọ', 'slug' => 'thien-tho', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Thọ trường'],
            ['name' => 'Tam Thai', 'slug' => 'tam-thai', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Phò tá'],
            ['name' => 'Bát Tọa', 'slug' => 'bat-toa', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Phò tá'],
            ['name' => 'Ân Quang', 'slug' => 'an-quang', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Quý tinh'],
            ['name' => 'Thiên Quý', 'slug' => 'thien-quy', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Quý tinh'],
            ['name' => 'Thai Phụ', 'slug' => 'thai-phu', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Văn tinh'],
            ['name' => 'Phong Cáo', 'slug' => 'phong-cao', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Văn tinh'],
            ['name' => 'Thiên Khốc', 'slug' => 'thien-khoc', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Bại tinh'],
            ['name' => 'Thiên Hư', 'slug' => 'thien-hu', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Bại tinh'],
            ['name' => 'Lưu Hà', 'slug' => 'luu-ha', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Sát tinh'],
            ['name' => 'Thiên Y', 'slug' => 'thien-y', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Y thuật'],
            ['name' => 'Thiên Thương', 'slug' => 'thien-thuong', 'group_type' => 'sat_tinh', 'is_main' => false, 'quality' => 'Thương tổn'],
            ['name' => 'Thiên Sứ', 'slug' => 'thien-su', 'group_type' => 'sat_tinh', 'is_main' => false, 'quality' => 'Hao tán'],
            ['name' => 'Đẩu Quân', 'slug' => 'dau-quan', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Nghiêm nghị'],
            ['name' => 'Kiếp Sát', 'slug' => 'kiep-sat', 'group_type' => 'sat_tinh', 'is_main' => false, 'quality' => 'Sát tinh'],
            ['name' => 'Đường Phù', 'slug' => 'duong-phu', 'group_type' => 'phu_tinh', 'is_main' => false, 'quality' => 'Quyền'],

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