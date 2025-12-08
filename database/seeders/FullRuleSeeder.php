<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FullRuleSeeder extends Seeder
{
    public function run(): void
    {
        // Disable FK checks to truncate safely
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('rules')->truncate();
        DB::table('rule_conditions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $rules = [
            // --- TỬ VI ---
            [
                'code' => 'MENH_TU_VI',
                'target_house' => 'MENH',
                'text_template' => '<strong>Tử Vi thủ Mệnh:</strong> Dáng người tầm thước hoặc đẫy đà, khuôn mặt đầy đặn, phúc hậu. Tính tình trung hậu, điềm đạm, trọng danh dự, có tài lãnh đạo và khả năng quản lý. Cuộc đời thường gặp nhiều may mắn, được quý nhân phù trợ.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'tu-vi']), 'operator' => 'exists']
                ]
            ],
            [
                'code' => 'TAI_TU_VI',
                'target_house' => 'TAI_BACH',
                'text_template' => '<strong>Tử Vi cư Tài Bạch:</strong> Tài vận hanh thông, kiếm tiền dễ dàng, thường làm chủ hoặc quản lý tài chính. Nguồn tài chính ổn định, vượng phát.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'TAI_BACH', 'value' => json_encode(['star_slug' => 'tu-vi']), 'operator' => 'exists']
                ]
            ],
            [
                'code' => 'QUAN_TU_VI',
                'target_house' => 'QUAN_LOC',
                'text_template' => '<strong>Tử Vi cư Quan Lộc:</strong> Công danh hiển đạt, có chức quyền, thường làm lãnh đạo hoặc giữ vị trí quan trọng trong tổ chức. Sự nghiệp vững chắc.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'QUAN_LOC', 'value' => json_encode(['star_slug' => 'tu-vi']), 'operator' => 'exists']
                ]
            ],

            // --- THIÊN CƠ ---
            [
                'code' => 'MENH_THIEN_CO',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thiên Cơ thủ Mệnh:</strong> Người thông minh, khéo léo, đa tài đa nghệ, thích nghiên cứu tìm tòi. Tâm tính thiện lương nhưng hay lo nghĩ. Thích hợp các nghề tham mưu, kỹ thuật, thủ công.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-co']), 'operator' => 'exists']
                ]
            ],
            [
                'code' => 'HUYNH_THIEN_CO',
                'target_house' => 'HUYNH_DE',
                'text_template' => '<strong>Thiên Cơ cư Huynh Đệ:</strong> Anh em thông minh, tài giỏi, có người làm nghề kỹ thuật hoặc khéo tay. Tuy nhiên anh em có thể ly tán hoặc không ở gần nhau.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'HUYNH_DE', 'value' => json_encode(['star_slug' => 'thien-co']), 'operator' => 'exists']
                ]
            ],

            // --- THÁI DƯƠNG ---
            [
                'code' => 'MENH_THAI_DUONG',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thái Dương thủ Mệnh:</strong> Tính tình thẳng thắn, bộc trực, quang minh chính đại, thích giúp đỡ người khác. Dung mạo sáng sủa, uy nghi. Nữ mệnh Thái Dương thường tài giỏi như nam giới.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thai-duong']), 'operator' => 'exists']
                ]
            ],

            // --- VŨ KHÚC ---
            [
                'code' => 'MENH_VU_KHUC',
                'target_house' => 'MENH',
                'text_template' => '<strong>Vũ Khúc thủ Mệnh:</strong> Sao tài tinh, chủ về tiền bạc. Tính tình cương nghị, quả quyết, có chí tiến thủ nhưng hơi cô độc. Thích hợp kinh doanh buôn bán.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'vu-khuc']), 'operator' => 'exists']
                ]
            ],

            // --- THIÊN ĐỒNG ---
            [
                'code' => 'MENH_THIEN_DONG',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thiên Đồng thủ Mệnh:</strong> Phúc tinh, tính tình ôn hòa, hay thay đổi, thích hưởng thụ, ham vui chơi. Cuộc đời thường an nhàn, ít sóng gió lớn.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-dong']), 'operator' => 'exists']
                ]
            ],

            // --- LIÊM TRINH ---
            [
                'code' => 'MENH_LIEM_TRINH',
                'target_house' => 'MENH',
                'text_template' => '<strong>Liêm Trinh thủ Mệnh:</strong> Tính tình nóng nảy nhưng thẳng thắn, liêm khiết. Thích tranh đấu, cạnh tranh. Nữ mệnh Liêm Trinh thường xinh đẹp nhưng tình duyên lận đận.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'liem-trinh']), 'operator' => 'exists']
                ]
            ],

            // --- THIÊN PHỦ ---
            [
                'code' => 'MENH_THIEN_PHU',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thiên Phủ thủ Mệnh:</strong> Kho trời, chủ về tài lộc và sự ổn định. Tính tình ôn hòa, cẩn trọng, biết hưởng thụ. Cuộc đời sung túc, giàu sang.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-phu']), 'operator' => 'exists']
                ]
            ],

            // --- THÁI ÂM ---
            [
                'code' => 'MENH_THAI_AM',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thái Âm thủ Mệnh:</strong> Chủ về điền sản và tài lộc. Tính tình dịu dàng, lãng mạn, yêu văn chương nghệ thuật. Nữ mệnh Thái Âm rất đảm đang, khéo léo.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thai-am']), 'operator' => 'exists']
                ]
            ],

            // --- THAM LANG ---
            [
                'code' => 'MENH_THAM_LANG',
                'target_house' => 'MENH',
                'text_template' => '<strong>Tham Lang thủ Mệnh:</strong> Đa tài đa nghệ, khéo giao tiếp, thích vui chơi hưởng thụ. Tính cách phóng khoáng, tham vọng lớn. Dễ thành công trong kinh doanh hoặc nghệ thuật.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'tham-lang']), 'operator' => 'exists']
                ]
            ],

            // --- CỰ MÔN ---
            [
                'code' => 'MENH_CU_MON',
                'target_house' => 'MENH',
                'text_template' => '<strong>Cự Môn thủ Mệnh:</strong> Chủ về ngôn ngữ, ăn nói. Có tài hùng biện, lý luận sắc bén. Tuy nhiên dễ gặp thị phi, khẩu thiệt. Thích hợp nghề luật sư, giáo viên.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'cu-mon']), 'operator' => 'exists']
                ]
            ],

            // --- THIÊN TƯỚNG ---
            [
                'code' => 'MENH_THIEN_TUONG',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thiên Tướng thủ Mệnh:</strong> Dáng người đẫy đà, đẹp đẽ. Tính tình quân tử, trượng nghĩa, thích giúp đỡ người khác. Có tài quản lý, tổ chức.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-tuong']), 'operator' => 'exists']
                ]
            ],

            // --- THIÊN LƯƠNG ---
            [
                'code' => 'MENH_THIEN_LUONG',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thiên Lương thủ Mệnh:</strong> Ấm tinh, chủ về thọ trường và sự che chở. Tính tình hiền lành, nhân hậu, thích làm việc thiện. Thường gặp dữ hóa lành.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-luong']), 'operator' => 'exists']
                ]
            ],

            // --- THẤT SÁT ---
            [
                'code' => 'MENH_THAT_SAT',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thất Sát thủ Mệnh:</strong> Tính cách cương cường, dũng cảm, quyết đoán. Thích làm việc lớn, không ngại khó khăn. Cuộc đời nhiều thăng trầm, biến động.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'that-sat']), 'operator' => 'exists']
                ]
            ],

            // --- PHÁ QUÂN ---
            [
                'code' => 'MENH_PHA_QUAN',
                'target_house' => 'MENH',
                'text_template' => '<strong>Phá Quân thủ Mệnh:</strong> Tính cách ngang tàng, phá cách, không chịu khuôn khổ. Dám nghĩ dám làm, liều lĩnh. Thích hợp khai phá, sáng tạo cái mới.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'pha-quan']), 'operator' => 'exists']
                ]
            ],

            // --- PHỤ TINH ---
            [
                'code' => 'MENH_LOC_TON',
                'target_house' => 'MENH',
                'text_template' => '<strong>Lộc Tồn thủ Mệnh:</strong> Người biết giữ tiền, tính toán cẩn thận, cuộc đời no đủ. Tuy nhiên có thể hơi cô độc hoặc keo kiệt.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'loc-ton']), 'operator' => 'exists']
                ]
            ],
            [
                'code' => 'MENH_THIEN_MA',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thiên Mã thủ Mệnh:</strong> Người năng động, tháo vát, hay di chuyển, thay đổi chỗ ở hoặc công việc. Có nghị lực vươn lên.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-ma']), 'operator' => 'exists']
                ]
            ],
            [
                'code' => 'MENH_HOA_LOC',
                'target_house' => 'MENH',
                'text_template' => '<strong>Hóa Lộc thủ Mệnh:</strong> Có duyên với tiền bạc, khéo léo trong giao tiếp, dễ kiếm tiền. Tính tình vui vẻ, hòa đồng.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'hoa-loc']), 'operator' => 'exists']
                ]
            ],
            [
                'code' => 'MENH_HOA_QUYEN',
                'target_house' => 'MENH',
                'text_template' => '<strong>Hóa Quyền thủ Mệnh:</strong> Thích quyền lực, muốn chỉ huy người khác. Tính cách mạnh mẽ, quyết đoán, có uy.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'hoa-quyen']), 'operator' => 'exists']
                ]
            ],
            [
                'code' => 'MENH_HOA_KHOA',
                'target_house' => 'MENH',
                'text_template' => '<strong>Hóa Khoa thủ Mệnh:</strong> Thông minh, học giỏi, có danh tiếng. Tính tình ôn hòa, lịch sự. Được quý nhân giúp đỡ, giải trừ tai họa.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'hoa-khoa']), 'operator' => 'exists']
                ]
            ],
            [
                'code' => 'MENH_HOA_KY',
                'target_house' => 'MENH',
                'text_template' => '<strong>Hóa Kỵ thủ Mệnh:</strong> Cuộc đời nhiều trắc trở, thị phi, hay bị hiểu lầm. Tính tình đa nghi, hay lo lắng. Tuy nhiên nếu đắc địa thì lại thành người thâm trầm, sâu sắc.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'hoa-ky']), 'operator' => 'exists']
                ]
            ],
            
            // --- SÁT TINH ---
            [
                'code' => 'MENH_KHONG_KIEP',
                'target_house' => 'MENH',
                'text_template' => '<strong>Địa Không - Địa Kiếp thủ Mệnh:</strong> Tính cách táo bạo, liều lĩnh, dám làm việc người khác không dám làm. Cuộc đời lên voi xuống chó thất thường. Nếu phát thì phát rất nhanh nhưng cũng dễ sụp đổ.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'dia-khong']), 'operator' => 'exists']
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
