<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MassiveRuleSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate tables to avoid duplicates
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('rules')->truncate();
        DB::table('rule_conditions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $rules = [
            // ==========================================
            // 1. TỬ VI TINH HỆ CƯ MỆNH
            // ==========================================
            [
                'code' => 'MENH_TU_VI_TY',
                'target_house' => 'MENH',
                'text_template' => '<strong>Tử Vi cư Tý (Bình Hòa):</strong> "Đế cư Tý Ngọ". Tại Tý, Tử Vi bình hòa, tính cách có phần do dự, thiếu quyết đoán hơn so với khi ở Ngọ. Tuy nhiên vẫn giữ được cốt cách tôn quý, nhân hậu. Cần có Tả Hữu, Khôi Việt phò tá mới làm nên chuyện lớn.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'tu-vi']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Tý']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_TU_VI_NGO',
                'target_house' => 'MENH',
                'text_template' => '<strong>Tử Vi cư Ngọ (Miếu Địa) - Cách "Cực Hướng Ly Minh":</strong> Đây là vị trí tốt nhất của Tử Vi. Vua ngồi ngai vàng, nhìn về phương Nam cai trị thiên hạ. Người có tài lãnh đạo xuất chúng, uy quyền hiển hách, công danh sự nghiệp rực rỡ.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'tu-vi']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Ngọ']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_TU_PHA_SUU',
                'target_house' => 'MENH',
                'text_template' => '<strong>Tử Vi Phá Quân đồng cung tại Sửu:</strong> Cách "Tử Phá". Mâu thuẫn giữa sự ổn định và phá cách. Cuộc đời nhiều biến động, thăng trầm. Có tài khai phá, sáng tạo nhưng dễ gặp rắc rối.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'tu-vi']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'pha-quan']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Sửu']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_TU_PHA_MUI',
                'target_house' => 'MENH',
                'text_template' => '<strong>Tử Vi Phá Quân đồng cung tại Mùi:</strong> Tương tự như ở Sửu, cách "Tử Phá" chủ về sự biến động và canh tân. Thích hợp làm kinh doanh, kỹ thuật hoặc các công việc đòi hỏi sự đột phá.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'tu-vi']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'pha-quan']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Mùi']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_TU_PHU_DAN',
                'target_house' => 'MENH',
                'text_template' => '<strong>Tử Vi Thiên Phủ đồng cung tại Dần:</strong> Cách "Tử Phủ Đồng Cung". Hai vua cùng ngồi một chỗ. Chủ về sự giàu sang, phú quý song toàn. Tính cách ôn hòa, cẩn trọng, có tài quản lý.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'tu-vi']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-phu']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Dần']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_TU_PHU_THAN',
                'target_house' => 'MENH',
                'text_template' => '<strong>Tử Vi Thiên Phủ đồng cung tại Thân:</strong> Tương tự như ở Dần, cách "Tử Phủ Đồng Cung". Chủ về phúc thọ song toàn, tài lộc dồi dào. Người có cách này thường được hưởng gia sản hoặc sự nghiệp từ cha ông để lại.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'tu-vi']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-phu']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Thân']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_TU_THAM_MAO',
                'target_house' => 'MENH',
                'text_template' => '<strong>Tử Vi Tham Lang đồng cung tại Mão:</strong> Cách "Đào Hoa Phạm Chủ". Người này rất có duyên, khéo léo, tài hoa, thích hưởng thụ và vui chơi. Nếu không có sao kìm hãm thì dễ sa đà vào tửu sắc. Thích hợp làm nghệ thuật, ngoại giao.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'tu-vi']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'tham-lang']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Mão']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_TU_THAM_DAU',
                'target_house' => 'MENH',
                'text_template' => '<strong>Tử Vi Tham Lang đồng cung tại Dậu:</strong> Tương tự ở Mão, cách "Đào Hoa Phạm Chủ". Chủ về sự phong lưu, đa tình. Có tài năng đặc biệt về tôn giáo, huyền học hoặc nghệ thuật.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'tu-vi']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'tham-lang']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Dậu']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_TU_TUONG_THIN',
                'target_house' => 'MENH',
                'text_template' => '<strong>Tử Vi Thiên Tướng đồng cung tại Thìn:</strong> Cách "Tử Tướng". Vua và Tướng cùng triều. Chủ về sự uy quyền, cương nhu phối hợp. Người có cách này thường rất tài giỏi, có khả năng lãnh đạo và thực thi nhiệm vụ xuất sắc.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'tu-vi']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-tuong']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Thìn']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_TU_TUONG_TUAT',
                'target_house' => 'MENH',
                'text_template' => '<strong>Tử Vi Thiên Tướng đồng cung tại Tuất:</strong> Tương tự ở Thìn, cách "Tử Tướng". Ở Tuất là Địa Võng. Người này thường phải đấu tranh với hoàn cảnh, tự lực cánh sinh. Có tính cách chính trực, trung thành.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'tu-vi']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-tuong']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Tuất']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_TU_SAT_TY',
                'target_house' => 'MENH',
                'text_template' => '<strong>Tử Vi Thất Sát đồng cung tại Tỵ:</strong> Cách "Tử Sát Hóa Quyền". Vua cầm kiếm ra trận. Chủ về quyền lực thực tế, khả năng hành động mạnh mẽ. Người có cách này thường làm trong lực lượng vũ trang, quản lý doanh nghiệp lớn.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'tu-vi']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'that-sat']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Tỵ']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_TU_SAT_HOI',
                'target_house' => 'MENH',
                'text_template' => '<strong>Tử Vi Thất Sát đồng cung tại Hợi:</strong> Tương tự ở Tỵ, cách "Tử Sát". Chủ về người có chí lớn, tài cao, dám nghĩ dám làm. Cuộc đời thường có những bước ngoặt lớn, thành công rực rỡ nhưng cũng nhiều gian nan.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'tu-vi']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'that-sat']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Hợi']), 'operator' => 'equals'],
                ]
            ],

            // --- THIÊN CƠ ---
            [
                'code' => 'MENH_THIEN_CO_TY',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thiên Cơ cư Tý:</strong> Cách "Cơ Nguyệt Đồng Lương" (hội họp). Người thông minh, mưu trí, có đầu óc tính toán. Thích hợp với các công việc văn phòng, tham mưu, kế hoạch.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-co']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Tý']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_THIEN_CO_NGO',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thiên Cơ cư Ngọ:</strong> Tương tự ở Tý, người có trí tuệ sắc sảo, khả năng phân tích tốt. Thường làm cố vấn, trợ lý đắc lực. Mệnh ở Ngọ (Dương) thường hoạt bát, năng động hơn ở Tý.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-co']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Ngọ']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_THIEN_CO_SUU',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thiên Cơ cư Sửu (Hãm):</strong> Trí tuệ bị che mờ, hay lo nghĩ vẩn vơ, thiếu định hướng. Cuộc đời thường gặp nhiều trắc trở trong công việc.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-co']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Sửu']), 'operator' => 'equals'],
                ]
            ],

            // --- CỰ MÔN ---
            [
                'code' => 'MENH_CU_MON_TY',
                'target_house' => 'MENH',
                'text_template' => '<strong>Cự Môn cư Tý:</strong> Cách "Thạch Trung Ẩn Ngọc" (Ngọc trong đá). Tài năng tiềm ẩn, cần mài giũa mới sáng. Tuổi trẻ vất vả, về sau thành đạt lớn.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'cu-mon']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Tý']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_CU_CO_MAO',
                'target_house' => 'MENH',
                'text_template' => '<strong>Cự Môn Thiên Cơ đồng cung tại Mão:</strong> Cách "Cự Cơ Mão Dậu". Người đa mưu túc trí, có tài tham mưu, hoạch định chiến lược. Rất giàu có và quyền quý.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'cu-mon']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-co']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Mão']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_CU_CO_DAU',
                'target_house' => 'MENH',
                'text_template' => '<strong>Cự Môn Thiên Cơ đồng cung tại Dậu (Hãm):</strong> "Cự Cơ Mão Dậu". Tương tự ở Mão. Chủ về sự thông minh, mưu trí, có tài tham mưu. Tuy nhiên ở Dậu là đất hãm nên dễ gặp thị phi.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'cu-mon']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-co']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Dậu']), 'operator' => 'equals'],
                ]
            ],

            // --- THÁI DƯƠNG ---
            [
                'code' => 'MENH_THAI_DUONG_THIN',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thái Dương cư Thìn:</strong> Cách "Nhật Xuất Kỳ Khu" (Mặt trời mọc). Rất tốt đẹp. Chủ về sự thăng tiến nhanh chóng, danh tiếng vang xa. Tính cách hào sảng, quang minh.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thai-duong']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Thìn']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_THAI_DUONG_TUAT',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thái Dương cư Tuất:</strong> Cách "Nhật Trầm Thủy Bể" (Mặt trời chìm đáy nước). Chủ về sự vất vả, thiếu thời không thuận lợi. Tài năng có nhưng khó được trọng dụng.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thai-duong']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Tuất']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_CU_DUONG_DAN',
                'target_house' => 'MENH',
                'text_template' => '<strong>Cự Môn Thái Dương đồng cung tại Dần:</strong> "Cự Nhật". Người thông minh, có tài hùng biện, giao tiếp giỏi. Thích hợp làm trong ngành ngoại giao, giáo dục, pháp luật.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'cu-mon']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thai-duong']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Dần']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_CU_DUONG_THAN',
                'target_house' => 'MENH',
                'text_template' => '<strong>Cự Môn Thái Dương đồng cung tại Thân (Hãm):</strong> "Cự Nhật". Chủ về sự vất vả, gian nan, danh tiếng thường đi kèm với thị phi. Cần nỗ lực rất lớn mới mong thành công.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'cu-mon']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thai-duong']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Thân']), 'operator' => 'equals'],
                ]
            ],

            // --- VŨ KHÚC ---
            [
                'code' => 'MENH_VU_KHUC_THIN',
                'target_house' => 'MENH',
                'text_template' => '<strong>Vũ Khúc cư Thìn:</strong> Cách "Vũ Khúc Trấn Mệnh". Tài tinh nhập miếu. Chủ về giàu sang phú quý, tiền bạc dư dả. Có khả năng kinh doanh xuất sắc.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'vu-khuc']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Thìn']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_THAM_VU_SUU',
                'target_house' => 'MENH',
                'text_template' => '<strong>Tham Lang Vũ Khúc đồng cung tại Sửu:</strong> "Tham Vũ Đồng Hành". Chủ về phát đạt muộn (tiền bần hậu phú). Tuổi trẻ vất vả nhưng trung niên trở đi thì giàu có hoạch phát.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'tham-lang']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'vu-khuc']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Sửu']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_THAM_VU_MUI',
                'target_house' => 'MENH',
                'text_template' => '<strong>Tham Lang Vũ Khúc đồng cung tại Mùi:</strong> "Tham Vũ Đồng Hành". Tương tự ở Sửu. Chủ về phát đạt muộn (tiền bần hậu phú).',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'tham-lang']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'vu-khuc']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Mùi']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_VU_SAT_MAO',
                'target_house' => 'MENH',
                'text_template' => '<strong>Vũ Khúc Thất Sát đồng cung tại Mão:</strong> Cách "Vũ Sát". Tài tinh gặp Tướng tinh. Chủ về kiếm tiền bằng sự táo bạo, quyết đoán. Tuy nhiên dễ gặp tai nạn hình thương.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'vu-khuc']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'that-sat']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Mão']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_PHU_VU_TY',
                'target_house' => 'MENH',
                'text_template' => '<strong>Vũ Khúc Thiên Phủ đồng cung tại Tý:</strong> Cách "Vũ Phủ". Sự kết hợp giữa Tài tinh và Khoa tinh. Chủ về giàu có, quyền quý. Người có tài quản lý tài chính.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'vu-khuc']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-phu']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Tý']), 'operator' => 'equals'],
                ]
            ],

            // --- THIÊN ĐỒNG ---
            [
                'code' => 'MENH_THIEN_DONG_DAU',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thiên Đồng cư Dậu (Hãm):</strong> Tính cách hay thay đổi, không kiên định, "đứng núi này trông núi nọ". Thích hưởng thụ nhưng điều kiện không cho phép.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-dong']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Dậu']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_DONG_LUONG_DAN',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thiên Đồng Thiên Lương đồng cung tại Dần:</strong> Cách "Đồng Lương Dần Thân". Chủ về phúc thọ song toàn. Người có tài năng về y học, giáo dục, sư phạm.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-dong']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-luong']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Dần']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_DONG_LUONG_THAN',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thiên Đồng Thiên Lương đồng cung tại Thân:</strong> "Đồng Lương Thân Dần". Tương tự ở Dần. Chủ về phúc thọ song toàn.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-dong']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-luong']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Thân']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_DONG_AM_TY',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thiên Đồng Thái Âm đồng cung tại Tý:</strong> "Đồng Âm". Chủ về sự hiền lành, nhân hậu, thông minh, tài hoa. Cuộc đời an nhàn, hưởng thụ.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-dong']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thai-am']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Tý']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_DONG_AM_NGO',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thiên Đồng Thái Âm đồng cung tại Ngọ (Hãm):</strong> "Đồng Âm". Ở Ngọ là đất hãm. Chủ về sự vất vả, bôn ba, tình cảm trắc trở. Tuy nhiên nếu có Tuần/Triệt thì lại trở nên tốt.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-dong']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thai-am']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Ngọ']), 'operator' => 'equals'],
                ]
            ],

            // --- LIÊM TRINH ---
            [
                'code' => 'MENH_LIEM_PHU_DAN',
                'target_house' => 'MENH',
                'text_template' => '<strong>Liêm Trinh Thiên Phủ đồng cung tại Dần:</strong> Cách "Liêm Phủ". Sự kết hợp giữa Liêm Trinh (nghiêm khắc) và Thiên Phủ (ôn hòa) tạo nên tính cách cân bằng. Giỏi ngoại giao, quản lý.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'liem-trinh']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-phu']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Dần']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_LIEM_PHU_THAN',
                'target_house' => 'MENH',
                'text_template' => '<strong>Liêm Trinh Thiên Phủ đồng cung tại Thân:</strong> "Liêm Phủ". Tương tự ở Dần. Giỏi ngoại giao, quản lý, kinh doanh. Cuộc đời sung túc.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'liem-trinh']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-phu']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Thân']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_LIEM_TUONG_NGO',
                'target_house' => 'MENH',
                'text_template' => '<strong>Liêm Trinh Thiên Tướng đồng cung tại Ngọ:</strong> Cách "Liêm Tướng". Rất tốt cho binh nghiệp, chính trị. Người có uy quyền, dũng cảm, trung thành.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'liem-trinh']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-tuong']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Ngọ']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_LIEM_SAT_SUU',
                'target_house' => 'MENH',
                'text_template' => '<strong>Liêm Trinh Thất Sát đồng cung tại Sửu:</strong> "Liêm Sát". Người có tính cách cương cường, quyết đoán, có tài lãnh đạo. Thích hợp làm trong lực lượng vũ trang, hoặc kinh doanh lớn.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'liem-trinh']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'that-sat']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Sửu']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_LIEM_SAT_MUI',
                'target_house' => 'MENH',
                'text_template' => '<strong>Liêm Trinh Thất Sát đồng cung tại Mùi:</strong> "Liêm Sát". Tương tự ở Sửu. Người có tính cách cương cường, quyết đoán, có tài lãnh đạo.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'liem-trinh']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'that-sat']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Mùi']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_LIEM_PHA_MAO',
                'target_house' => 'MENH',
                'text_template' => '<strong>Liêm Trinh Phá Quân đồng cung tại Mão:</strong> Cách "Liêm Phá". Hãm địa. Chủ về tính cách ngang tàng, bướng bỉnh, dễ gặp rắc rối pháp luật hoặc tai nạn.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'liem-trinh']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'pha-quan']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Mão']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_LIEM_PHA_DAU',
                'target_house' => 'MENH',
                'text_template' => '<strong>Liêm Trinh Phá Quân đồng cung tại Dậu:</strong> Cách "Liêm Phá". Hãm địa. Tương tự ở Mão. Cần tu dưỡng đạo đức và cẩn trọng trong hành động.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'liem-trinh']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'pha-quan']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Dậu']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_LIEM_THAM_TY',
                'target_house' => 'MENH',
                'text_template' => '<strong>Liêm Trinh Tham Lang đồng cung tại Tỵ:</strong> "Liêm Tham". Hãm địa. Chủ về tính cách đam mê tửu sắc, dễ sa đọa. Cuộc đời thường gặp rắc rối vì tình duyên hoặc tiền bạc.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'liem-trinh']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'tham-lang']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Tỵ']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_LIEM_THAM_HOI',
                'target_house' => 'MENH',
                'text_template' => '<strong>Liêm Trinh Tham Lang đồng cung tại Hợi:</strong> "Liêm Tham". Hãm địa. Tương tự ở Tỵ. Cần đề phòng tai ách tù tội (Hình ngục nan đào).',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'liem-trinh']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'tham-lang']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Hợi']), 'operator' => 'equals'],
                ]
            ],

            // --- THIÊN PHỦ ---
            [
                'code' => 'MENH_THIEN_PHU_TY',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thiên Phủ cư Tỵ:</strong> Thiên Phủ độc tọa, đối cung là Tử Vi Thất Sát. Người có tài lộc dồi dào, khả năng quản lý tài chính tốt.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-phu']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Tỵ']), 'operator' => 'equals'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'tu-vi']), 'operator' => 'not_exists'],
                ]
            ],
            [
                'code' => 'MENH_THIEN_PHU_HOI',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thiên Phủ cư Hợi:</strong> Tương tự ở Tỵ, chủ về sự giàu có và ổn định. Thiên Phủ ở Hợi thường có duyên với việc đi xa, xuất ngoại.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-phu']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Hợi']), 'operator' => 'equals'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'tu-vi']), 'operator' => 'not_exists'],
                ]
            ],

            // --- THIÊN TƯỚNG ---
            [
                'code' => 'MENH_THIEN_TUONG_SUU',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thiên Tướng cư Sửu:</strong> Độc tọa. Đối cung là Tử Vi Phá Quân. Người có tính cách ôn hòa bên ngoài nhưng cương quyết bên trong.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-tuong']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Sửu']), 'operator' => 'equals'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'tu-vi']), 'operator' => 'not_exists'],
                ]
            ],
            [
                'code' => 'MENH_THIEN_TUONG_MUI',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thiên Tướng cư Mùi:</strong> Độc tọa. Tương tự ở Sửu. Thích sự ổn định nhưng hoàn cảnh thường bắt buộc phải thay đổi.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-tuong']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Mùi']), 'operator' => 'equals'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'tu-vi']), 'operator' => 'not_exists'],
                ]
            ],

            // --- THIÊN LƯƠNG ---
            [
                'code' => 'MENH_THIEN_LUONG_TY',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thiên Lương cư Tý:</strong> Cách "Thọ Tinh Nhập Miếu". Chủ về sống lâu, khỏe mạnh, thông minh, nhân hậu. Cuộc đời thanh nhàn.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-luong']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Tý']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_THIEN_LUONG_NGO',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thiên Lương cư Ngọ:</strong> Cách "Thọ Tinh Nhập Miếu". Tương tự ở Tý. Rất tốt đẹp. Chủ về danh tiếng, uy tín.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-luong']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Ngọ']), 'operator' => 'equals'],
                ]
            ],

            // --- THẤT SÁT ---
            [
                'code' => 'MENH_THAT_SAT_DAN',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thất Sát cư Dần:</strong> Cách "Thất Sát Triều Đẩu". Rất tốt cho nam mệnh. Chủ về uy quyền, tài năng lãnh đạo, làm nên nghiệp lớn.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'that-sat']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Dần']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_THAT_SAT_THAN',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thất Sát cư Thân:</strong> Cách "Thất Sát Triều Đẩu". Tương tự ở Dần. Chủ về sự nghiệp hiển hách, nắm quyền sinh sát.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'that-sat']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Thân']), 'operator' => 'equals'],
                ]
            ],

            // --- PHÁ QUÂN ---
            [
                'code' => 'MENH_PHA_QUAN_TY',
                'target_house' => 'MENH',
                'text_template' => '<strong>Phá Quân cư Tý:</strong> Cách "Anh Tinh Nhập Miếu". Phá Quân đắc địa tại Thủy cung. Chủ về sự thông minh, sáng tạo đột phá.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'pha-quan']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Tý']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_PHA_QUAN_NGO',
                'target_house' => 'MENH',
                'text_template' => '<strong>Phá Quân cư Ngọ:</strong> Cách "Anh Tinh Nhập Miếu". Tương tự ở Tý. Dám làm việc lớn, khai phá vùng đất mới.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'pha-quan']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Ngọ']), 'operator' => 'equals'],
                ]
            ],

            // --- PHỤ TINH ---
            [
                'code' => 'DI_LOC_TON',
                'target_house' => 'THIEN_DI',
                'text_template' => '<strong>Lộc Tồn cư Thiên Di:</strong> Ra ngoài hay gặp may mắn về tiền bạc, dễ kiếm tiền nơi phương xa. Được người khác giúp đỡ.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'THIEN_DI', 'value' => json_encode(['star_slug' => 'loc-ton']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'MENH_KINH_DUONG_NGO',
                'target_house' => 'MENH',
                'text_template' => '<strong>Kình Dương cư Ngọ:</strong> Cách "Mã Đầu Đới Kiếm" (Gươm treo cổ ngựa). Rất nguy hiểm nhưng cũng rất anh hùng. Nếu gặp Phượng Các, Giải Thần thì làm tướng soái.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'kinh-duong']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Ngọ']), 'operator' => 'equals'],
                ]
            ],
            [
                'code' => 'MENH_DA_LA',
                'target_house' => 'MENH',
                'text_template' => '<strong>Đà La thủ Mệnh:</strong> Tính tình thâm trầm, kín đáo, hay do dự, nghi ngờ. Làm việc gì cũng chậm chạp nhưng chắc chắn.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'da-la']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'MENH_KHONG_KIEP_TY_HOI',
                'target_house' => 'MENH',
                'text_template' => '<strong>Địa Không Địa Kiếp đắc địa (Tỵ/Hợi):</strong> "Không Kiếp Tỵ Hợi". Cách này chủ về phát dã như lôi. Người có tài năng xuất chúng, dám nghĩ dám làm.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'dia-khong']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Tỵ']), 'operator' => 'equals'], 
                ]
            ],
            [
                'code' => 'MENH_THAM_HOA',
                'target_house' => 'MENH',
                'text_template' => '<strong>Tham Lang Hỏa Tinh đồng cung:</strong> Cách "Tham Hỏa Tương Phùng". Chủ về phú ông, giàu có nức tiếng. Phát tài rất nhanh.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'tham-lang']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'hoa-tinh']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'MENH_XUONG_KHUC',
                'target_house' => 'MENH',
                'text_template' => '<strong>Văn Xương Văn Khúc thủ Mệnh:</strong> Người văn hay chữ tốt, thông minh, học giỏi, có năng khiếu nghệ thuật.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'van-xuong']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'van-khuc']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'MENH_KHOI_VIET',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thiên Khôi Thiên Việt:</strong> "Tọa Quý Hướng Quý". Chủ về sự đỗ đạt, bằng cấp, được quý nhân nâng đỡ.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-khoi']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'QUAN_TA_HUU',
                'target_house' => 'QUAN_LOC',
                'text_template' => '<strong>Tả Phù Hữu Bật cư Quan Lộc:</strong> Trong công việc luôn có người giúp đỡ, phò tá đắc lực.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'QUAN_LOC', 'value' => json_encode(['star_slug' => 'ta-phu']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'QUAN_LOC', 'value' => json_encode(['star_slug' => 'huu-bat']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'MENH_HOA_KHOA',
                'target_house' => 'MENH',
                'text_template' => '<strong>Hóa Khoa thủ Mệnh:</strong> Đệ nhất giải thần. Chủ về sự thông minh, khoa bảng, danh tiếng.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'hoa-khoa']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'DI_HOA_KY',
                'target_house' => 'THIEN_DI',
                'text_template' => '<strong>Hóa Kỵ cư Thiên Di:</strong> Ra ngoài hay gặp thị phi, khẩu thiệt, tiểu nhân quấy phá.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'THIEN_DI', 'value' => json_encode(['star_slug' => 'hoa-ky']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'PHU_THE_HOA_LOC',
                'target_house' => 'PHU_THE',
                'text_template' => '<strong>Hóa Lộc cư Phu Thê:</strong> Vợ chồng có duyên tiền định, yêu thương nhau.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'PHU_THE', 'value' => json_encode(['star_slug' => 'hoa-loc']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'TAI_HOA_QUYEN',
                'target_house' => 'TAI_BACH',
                'text_template' => '<strong>Hóa Quyền cư Tài Bạch:</strong> Có quyền lực trong việc chi tiêu, quản lý tài chính.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'TAI_BACH', 'value' => json_encode(['star_slug' => 'hoa-quyen']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'MENH_DAO_HOA',
                'target_house' => 'MENH',
                'text_template' => '<strong>Đào Hoa thủ Mệnh:</strong> Người xinh đẹp, duyên dáng, có sức thu hút người khác phái.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'dao-hoa']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'TAI_LOC_TON',
                'target_house' => 'TAI_BACH',
                'text_template' => '<strong>Lộc Tồn cư Tài Bạch:</strong> Bạn là người rất biết giữ tiền, chi tiêu có kế hoạch.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'TAI_BACH', 'value' => json_encode(['star_slug' => 'loc-ton']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'QUAN_LOC_TON',
                'target_house' => 'QUAN_LOC',
                'text_template' => '<strong>Lộc Tồn cư Quan Lộc:</strong> Công danh sự nghiệp vững chắc, được hưởng lộc từ công việc.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'QUAN_LOC', 'value' => json_encode(['star_slug' => 'loc-ton']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'MENH_KHONG_KIEP_HAM',
                'target_house' => 'MENH',
                'text_template' => '<strong>Địa Không Địa Kiếp thủ Mệnh (Hãm địa):</strong> Cuộc đời thăng trầm bất định, dễ gặp tai họa bất ngờ, phá sản.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'dia-khong']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'dia-kiep']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Tý']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'MENH_THAM_LINH',
                'target_house' => 'MENH',
                'text_template' => '<strong>Tham Lang Linh Tinh đồng cung:</strong> Cách "Tham Linh Tương Phùng". Chủ về phát phú phát quý nhanh chóng.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'tham-lang']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'linh-tinh']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'QUAN_THIEN_KHOI',
                'target_house' => 'QUAN_LOC',
                'text_template' => '<strong>Thiên Khôi cư Quan Lộc:</strong> Trong công việc thường đứng đầu, làm trưởng nhóm, lãnh đạo.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'QUAN_LOC', 'value' => json_encode(['star_slug' => 'thien-khoi']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'DI_THIEN_VIET',
                'target_house' => 'THIEN_DI',
                'text_template' => '<strong>Thiên Việt cư Thiên Di:</strong> Ra ngoài hay gặp quý nhân giúp đỡ (thường là người khác phái hoặc người trẻ tuổi).',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'THIEN_DI', 'value' => json_encode(['star_slug' => 'thien-viet']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'TAI_VAN_XUONG',
                'target_house' => 'TAI_BACH',
                'text_template' => '<strong>Văn Xương cư Tài Bạch:</strong> Kiếm tiền bằng nghề văn, dạy học, viết lách, nghệ thuật.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'TAI_BACH', 'value' => json_encode(['star_slug' => 'van-xuong']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'PHU_THE_VAN_KHUC',
                'target_house' => 'PHU_THE',
                'text_template' => '<strong>Văn Khúc cư Phu Thê:</strong> Người phối ngẫu đa tài, lãng mạn, khéo léo.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'PHU_THE', 'value' => json_encode(['star_slug' => 'van-khuc']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'TAI_TA_PHU',
                'target_house' => 'TAI_BACH',
                'text_template' => '<strong>Tả Phù cư Tài Bạch:</strong> Có nhiều nguồn thu nhập, dễ kiếm tiền từ nhiều nghề tay trái.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'TAI_BACH', 'value' => json_encode(['star_slug' => 'ta-phu']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'QUAN_HOA_KY',
                'target_house' => 'QUAN_LOC',
                'text_template' => '<strong>Hóa Kỵ cư Quan Lộc:</strong> Công việc hay gặp trắc trở, thị phi, bị đồng nghiệp đố kỵ hoặc cấp trên chèn ép.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'QUAN_LOC', 'value' => json_encode(['star_slug' => 'hoa-ky']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'TAI_HOA_KY',
                'target_house' => 'TAI_BACH',
                'text_template' => '<strong>Hóa Kỵ cư Tài Bạch:</strong> Tiền bạc hay bị thất thoát, tranh chấp, kiện tụng vì tiền.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'TAI_BACH', 'value' => json_encode(['star_slug' => 'hoa-ky']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'DI_HOA_QUYEN',
                'target_house' => 'THIEN_DI',
                'text_template' => '<strong>Hóa Quyền cư Thiên Di:</strong> Ra ngoài được người nể trọng, có uy quyền, lời nói có trọng lượng.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'THIEN_DI', 'value' => json_encode(['star_slug' => 'hoa-quyen']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'QUAN_HOA_KHOA',
                'target_house' => 'QUAN_LOC',
                'text_template' => '<strong>Hóa Khoa cư Quan Lộc:</strong> Công danh thuận lợi nhờ bằng cấp, học vấn. Làm việc có phương pháp, khoa học.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'QUAN_LOC', 'value' => json_encode(['star_slug' => 'hoa-khoa']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'MENH_HOA_TINH_HAM',
                'target_house' => 'MENH',
                'text_template' => '<strong>Hỏa Tinh thủ Mệnh (Hãm):</strong> Tính tình nóng nảy, bộp chộp, dễ gây gổ. Cuộc đời nhiều sóng gió.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'hoa-tinh']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'tham-lang']), 'operator' => 'not_exists'],
                ]
            ],
            [
                'code' => 'MENH_LINH_TINH_HAM',
                'target_house' => 'MENH',
                'text_template' => '<strong>Linh Tinh thủ Mệnh (Hãm):</strong> Tính tình thâm trầm, hay để bụng, nóng nảy ngầm. Cuộc đời cô độc, ít người thân tín.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'linh-tinh']), 'operator' => 'exists'],
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'tham-lang']), 'operator' => 'not_exists'],
                ]
            ],
            [
                'code' => 'MENH_KINH_DUONG_HAM',
                'target_house' => 'MENH',
                'text_template' => '<strong>Kình Dương thủ Mệnh (Hãm):</strong> Tính khí hung bạo, liều lĩnh, hay gây tai họa. Dễ bị thương tích.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'kinh-duong']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Tý']), 'operator' => 'exists'], // Simplified check for Ham
                ]
            ],
            [
                'code' => 'MENH_DA_LA_HAM',
                'target_house' => 'MENH',
                'text_template' => '<strong>Đà La thủ Mệnh (Hãm):</strong> Tính tình gian xảo, hay lừa lọc, gây thị phi. Cuộc đời lận đận, cô độc.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'da-la']), 'operator' => 'exists'],
                    ['type' => 'house_branch', 'house_code' => 'MENH', 'value' => json_encode(['branch' => 'Tý']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'NGHE_TAI_CHINH',
                'target_house' => 'QUAN_LOC',
                'text_template' => '<strong>Định hướng nghề nghiệp:</strong> Với bộ sao Vũ Khúc / Thiên Phủ, bạn rất phù hợp với các lĩnh vực Tài chính, Ngân hàng, Kinh doanh.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'QUAN_LOC', 'value' => json_encode(['star_slug' => 'vu-khuc']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'NGHE_GIAO_DUC_TRUYEN_THONG',
                'target_house' => 'QUAN_LOC',
                'text_template' => '<strong>Định hướng nghề nghiệp:</strong> Thái Dương / Thái Âm chiếu rọi, bạn có tố chất làm Lãnh đạo, Giáo dục, Truyền thông.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'QUAN_LOC', 'value' => json_encode(['star_slug' => 'thai-duong']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'NGHE_KY_THUAT_LUAT',
                'target_house' => 'QUAN_LOC',
                'text_template' => '<strong>Định hướng nghề nghiệp:</strong> Thiên Cơ / Cự Môn là bộ sao của trí tuệ và ngôn ngữ. Rất hợp với nghề Kỹ thuật, Luật sư, Tư vấn, Giáo viên.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'QUAN_LOC', 'value' => json_encode(['star_slug' => 'thien-co']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'NGHE_QUAN_SU_KY_THUAT',
                'target_house' => 'QUAN_LOC',
                'text_template' => '<strong>Định hướng nghề nghiệp:</strong> Bộ Sát Phá Tham chủ về hành động. Hợp với Lực lượng vũ trang, Kỹ thuật cơ khí, Xây dựng.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'QUAN_LOC', 'value' => json_encode(['star_slug' => 'that-sat']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'NGHE_Y_TE_PHUC_LOI',
                'target_house' => 'QUAN_LOC',
                'text_template' => '<strong>Định hướng nghề nghiệp:</strong> Thiên Đồng / Thiên Lương là bộ sao phúc thiện. Rất hợp với ngành Y tế, Giáo dục, Công tác xã hội.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'QUAN_LOC', 'value' => json_encode(['star_slug' => 'thien-luong']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'PHU_THE_CO_QUA',
                'target_house' => 'PHU_THE',
                'text_template' => '<strong>Cô Thần / Quả Tú cư Phu Thê:</strong> Duyên phận thường đến muộn, hoặc vợ chồng ít có thời gian gần gũi.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'PHU_THE', 'value' => json_encode(['star_slug' => 'co-than']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'PHU_THE_HOA_KY',
                'target_house' => 'PHU_THE',
                'text_template' => '<strong>Hóa Kỵ cư Phu Thê:</strong> Vợ chồng dễ nảy sinh mâu thuẫn, khắc khẩu vì những chuyện nhỏ nhặt.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'PHU_THE', 'value' => json_encode(['star_slug' => 'hoa-ky']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'PHU_THE_THAI_AM',
                'target_house' => 'PHU_THE',
                'text_template' => '<strong>Thái Âm cư Phu Thê:</strong> Người phối ngẫu thường dịu dàng, đẹp người đẹp nết. Cuộc sống hôn nhân lãng mạn.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'PHU_THE', 'value' => json_encode(['star_slug' => 'thai-am']), 'operator' => 'exists'],
                ]
            ],
            [
                'code' => 'TAI_SONG_HAO',
                'target_house' => 'TAI_BACH',
                'text_template' => '<strong>Đại Tiểu Hao cư Tài Bạch:</strong> Tiền vào nhà khó như gió vào nhà trống. Bạn chi tiêu rất thoáng tay.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'TAI_BACH', 'value' => json_encode(['star_slug' => 'dai-hao']), 'operator' => 'exists'],
                ]
            ],
        ];

        foreach ($rules as $data) {
            $conditions = $data['conditions'];
            unset($data['conditions']);

            $ruleId = DB::table('rules')->insertGetId(array_merge($data, [
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));

            foreach ($conditions as $condition) {
                DB::table('rule_conditions')->insert(array_merge($condition, [
                    'rule_id' => $ruleId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }
}