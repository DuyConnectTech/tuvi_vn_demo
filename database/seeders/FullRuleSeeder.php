<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FullRuleSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('rules')->truncate();
        DB::table('rule_conditions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $rules = [
            // ==========================================
            // 1. TÍNH CÁCH & CỐT CÁCH (MỆNH)
            // ==========================================
            [
                'code' => 'MENH_TU_VI',
                'target_house' => 'MENH',
                'text_template' => '<strong>Tử Vi thủ Mệnh:</strong> Dáng người tầm thước hoặc đẫy đà, khuôn mặt đầy đặn, phúc hậu. Tính tình trung hậu, điềm đạm, trọng danh dự, có tài lãnh đạo và khả năng quản lý. Cuộc đời thường gặp nhiều may mắn, được quý nhân phù trợ.',
                'conditions' => [['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'tu-vi']), 'operator' => 'exists']]
            ],
            [
                'code' => 'MENH_THIEN_PHU',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thiên Phủ thủ Mệnh:</strong> Là kho trời, chủ về sự ổn định, ôn hòa và tài lộc. Người có Thiên Phủ thường thông minh, cẩn trọng, biết hưởng thụ cuộc sống. Có duyên với việc quản lý tài chính, ngân hàng.',
                'conditions' => [['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-phu']), 'operator' => 'exists']]
            ],
            [
                'code' => 'MENH_THAI_DUONG',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thái Dương thủ Mệnh:</strong> Tượng trưng cho mặt trời, chủ về quan lộc và danh tiếng. Tính tình thẳng thắn, bộc trực, quang minh chính đại, thích giúp đỡ người khác. Nếu đắc địa thì thông minh xuất chúng, có tài lãnh đạo.',
                'conditions' => [['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thai-duong']), 'operator' => 'exists']]
            ],
            [
                'code' => 'MENH_THAI_AM',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thái Âm thủ Mệnh:</strong> Tượng trưng cho mặt trăng, chủ về điền sản và tài lộc. Tính tình dịu dàng, lãng mạn, yêu văn chương nghệ thuật, sạch sẽ và ngăn nắp. Nữ mệnh rất đảm đang.',
                'conditions' => [['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thai-am']), 'operator' => 'exists']]
            ],
            [
                'code' => 'MENH_VU_KHUC',
                'target_house' => 'MENH',
                'text_template' => '<strong>Vũ Khúc thủ Mệnh:</strong> Sao tài tinh, chủ về tiền bạc và sự quyết đoán. Tính cách cương nghị, quả quyết, có chí tiến thủ mạnh mẽ. Đôi khi hơi cô độc hoặc lạnh lùng trong tình cảm.',
                'conditions' => [['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'vu-khuc']), 'operator' => 'exists']]
            ],
            [
                'code' => 'MENH_THIEN_DONG',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thiên Đồng thủ Mệnh:</strong> Phúc tinh, tính tình ôn hòa, trẻ con, hay thay đổi, thích hưởng thụ và ham vui. Cuộc đời thường an nhàn, ít sóng gió lớn, được nhiều người yêu mến.',
                'conditions' => [['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-dong']), 'operator' => 'exists']]
            ],
            [
                'code' => 'MENH_LIEM_TRINH',
                'target_house' => 'MENH',
                'text_template' => '<strong>Liêm Trinh thủ Mệnh:</strong> Sao Đào hoa thứ hai, chủ về sự liêm khiết nhưng cũng nóng nảy. Tính cách thẳng thắn, thích cạnh tranh, phân bua. Nếu đắc địa thì là người nghiêm túc, có uy quyền.',
                'conditions' => [['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'liem-trinh']), 'operator' => 'exists']]
            ],
            [
                'code' => 'MENH_THAM_LANG',
                'target_house' => 'MENH',
                'text_template' => '<strong>Tham Lang thủ Mệnh:</strong> Chủ về dục vọng và tài nghệ. Người đa tài đa nghệ, khéo giao tiếp, thích vui chơi, có tham vọng lớn. Dễ thành công trong kinh doanh hoặc các ngành nghề cần sự khéo léo.',
                'conditions' => [['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'tham-lang']), 'operator' => 'exists']]
            ],
            [
                'code' => 'MENH_CU_MON',
                'target_house' => 'MENH',
                'text_template' => '<strong>Cự Môn thủ Mệnh:</strong> Ám tinh, chủ về ngôn ngữ và sự nghi ngờ. Có tài ăn nói, hùng biện, lý luận sắc bén. Tuy nhiên dễ gặp thị phi, khẩu thiệt nếu không tu dưỡng.',
                'conditions' => [['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'cu-mon']), 'operator' => 'exists']]
            ],
            [
                'code' => 'MENH_THIEN_TUONG',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thiên Tướng thủ Mệnh:</strong> Tướng tinh, chủ về quyền lệnh và sự tương trợ. Dáng người đẹp đẽ, tính tình quân tử, trượng nghĩa, thích giúp đỡ người khác. Có tài quản lý và tổ chức.',
                'conditions' => [['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-tuong']), 'operator' => 'exists']]
            ],
            [
                'code' => 'MENH_THIEN_LUONG',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thiên Lương thủ Mệnh:</strong> Ấm tinh, chủ về thọ trường và sự che chở. Tính tình hiền lành, nhân hậu, thích làm việc thiện, hay lo chuyện bao đồng. Thường gặp dữ hóa lành.',
                'conditions' => [['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'thien-luong']), 'operator' => 'exists']]
            ],
            [
                'code' => 'MENH_THAT_SAT',
                'target_house' => 'MENH',
                'text_template' => '<strong>Thất Sát thủ Mệnh:</strong> Tướng tinh, chủ về uy quyền và sát phạt. Tính cách cương cường, dũng cảm, quyết đoán, đôi khi nóng nảy. Thích làm việc lớn, không ngại khó khăn gian khổ.',
                'conditions' => [['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'that-sat']), 'operator' => 'exists']]
            ],
            [
                'code' => 'MENH_PHA_QUAN',
                'target_house' => 'MENH',
                'text_template' => '<strong>Phá Quân thủ Mệnh:</strong> Hao tinh, chủ về phu thê, tử tức và sự hao tán. Tính cách ngang tàng, phá cách, không chịu khuôn khổ. Dám nghĩ dám làm, thích khai phá cái mới.',
                'conditions' => [['type' => 'star_in_house', 'house_code' => 'MENH', 'value' => json_encode(['star_slug' => 'pha-quan']), 'operator' => 'exists']]
            ],

            // ==========================================
            // 2. SỰ NGHIỆP & NGHỀ NGHIỆP (QUAN LỘC / MỆNH)
            // ==========================================
            [
                'code' => 'NGHE_TAI_CHINH',
                'target_house' => 'QUAN_LOC',
                'text_template' => '<strong>Định hướng nghề nghiệp:</strong> Với bộ sao Vũ Khúc / Thiên Phủ, bạn rất phù hợp với các lĩnh vực Tài chính, Ngân hàng, Kế toán, Kinh doanh, Quản lý kho quỹ. Bạn có khả năng quản lý tiền bạc xuất sắc.',
                'conditions' => [
                    ['type' => 'star_in_house', 'house_code' => 'QUAN_LOC', 'value' => json_encode(['star_slug' => 'vu-khuc']), 'operator' => 'exists'],
                    // OR condition logic needed here, but for now seeding separate rules or simple match
                ]
            ],
            [
                'code' => 'NGHE_TAI_CHINH_2',
                'target_house' => 'QUAN_LOC',
                'text_template' => '<strong>Định hướng nghề nghiệp:</strong> Thiên Phủ cư Quan Lộc là cách "Lộc khố", rất hợp làm quản lý, tài chính, nhân sự, hành chính. Công việc ổn định, thăng tiến vững chắc.',
                'conditions' => [['type' => 'star_in_house', 'house_code' => 'QUAN_LOC', 'value' => json_encode(['star_slug' => 'thien-phu']), 'operator' => 'exists']]
            ],
            [
                'code' => 'NGHE_GIAO_DUC_TRUYEN_THONG',
                'target_house' => 'QUAN_LOC',
                'text_template' => '<strong>Định hướng nghề nghiệp:</strong> Thái Dương / Thái Âm chiếu rọi, bạn có tố chất làm Lãnh đạo, Chính trị, Giáo dục, Truyền thông, hoặc các công việc mang tính chất lan tỏa, công chúng.',
                'conditions' => [['type' => 'star_in_house', 'house_code' => 'QUAN_LOC', 'value' => json_encode(['star_slug' => 'thai-duong']), 'operator' => 'exists']]
            ],
            [
                'code' => 'NGHE_KY_THUAT_LUAT',
                'target_house' => 'QUAN_LOC',
                'text_template' => '<strong>Định hướng nghề nghiệp:</strong> Thiên Cơ / Cự Môn là bộ sao của trí tuệ và ngôn ngữ. Rất hợp với nghề Kỹ thuật, Công nghệ thông tin, Nghiên cứu, Luật sư, Tư vấn, Giáo viên.',
                'conditions' => [['type' => 'star_in_house', 'house_code' => 'QUAN_LOC', 'value' => json_encode(['star_slug' => 'thien-co']), 'operator' => 'exists']]
            ],
            [
                'code' => 'NGHE_KY_THUAT_LUAT_2',
                'target_house' => 'QUAN_LOC',
                'text_template' => '<strong>Định hướng nghề nghiệp:</strong> Cự Môn cư Quan, bạn sử dụng lời nói để kiếm tiền và thăng tiến. Hợp nghề Luật, Ngoại giao, Sales, Marketing, Giảng dạy.',
                'conditions' => [['type' => 'star_in_house', 'house_code' => 'QUAN_LOC', 'value' => json_encode(['star_slug' => 'cu-mon']), 'operator' => 'exists']]
            ],
            [
                'code' => 'NGHE_QUAN_SU_KY_THUAT',
                'target_house' => 'QUAN_LOC',
                'text_template' => '<strong>Định hướng nghề nghiệp:</strong> Bộ Sát Phá Tham (Thất Sát, Phá Quân, Tham Lang) chủ về hành động. Hợp với Lực lượng vũ trang (Công an, Quân đội), Kỹ thuật cơ khí, Xây dựng, hoặc Kinh doanh mạo hiểm, Khai phá thị trường mới.',
                'conditions' => [['type' => 'star_in_house', 'house_code' => 'QUAN_LOC', 'value' => json_encode(['star_slug' => 'that-sat']), 'operator' => 'exists']]
            ],
            [
                'code' => 'NGHE_Y_TE_PHUC_LOI',
                'target_house' => 'QUAN_LOC',
                'text_template' => '<strong>Định hướng nghề nghiệp:</strong> Thiên Đồng / Thiên Lương là bộ sao phúc thiện. Rất hợp với ngành Y tế (Bác sĩ, Dược sĩ), Giáo dục, Công tác xã hội, Từ thiện, hoặc các ngành Dịch vụ chăm sóc khách hàng.',
                'conditions' => [['type' => 'star_in_house', 'house_code' => 'QUAN_LOC', 'value' => json_encode(['star_slug' => 'thien-luong']), 'operator' => 'exists']]
            ],

            // ==========================================
            // 3. TÀI LỘC (TÀI BẠCH)
            // ==========================================
            [
                'code' => 'TAI_LOC_TON',
                'target_house' => 'TAI_BACH',
                'text_template' => '<strong>Lộc Tồn cư Tài Bạch:</strong> Bạn là người rất biết giữ tiền, chi tiêu có kế hoạch. Tiền bạc tích tụ dần dần mà thành giàu có. Tuy nhiên đôi khi quá cẩn trọng nên bỏ lỡ cơ hội đầu tư lớn.',
                'conditions' => [['type' => 'star_in_house', 'house_code' => 'TAI_BACH', 'value' => json_encode(['star_slug' => 'loc-ton']), 'operator' => 'exists']]
            ],
            [
                'code' => 'TAI_HOA_LOC',
                'target_house' => 'TAI_BACH',
                'text_template' => '<strong>Hóa Lộc cư Tài Bạch:</strong> Dòng tiền dồi dào, kiếm tiền nhẹ nhàng, có duyên với kinh doanh. Tiền bạc ra vào tấp nập, không bao giờ thiếu túng.',
                'conditions' => [['type' => 'star_in_house', 'house_code' => 'TAI_BACH', 'value' => json_encode(['star_slug' => 'hoa-loc']), 'operator' => 'exists']]
            ],
            [
                'code' => 'TAI_SONG_HAO',
                'target_house' => 'TAI_BACH',
                'text_template' => '<strong>Đại Tiểu Hao cư Tài Bạch:</strong> "Đại Tiểu Hao lâm Tài Bạch, tiền vào nhà khó như gió vào nhà trống". Bạn chi tiêu rất thoáng tay, khó giữ tiền. Tuy nhiên nếu làm kinh doanh dòng tiền luân chuyển nhanh thì lại đắc cách.',
                'conditions' => [['type' => 'star_in_house', 'house_code' => 'TAI_BACH', 'value' => json_encode(['star_slug' => 'dai-hao']), 'operator' => 'exists']]
            ],

            // ==========================================
            // 4. TÌNH DUYÊN (PHU THÊ)
            // ==========================================
            [
                'code' => 'PHU_THE_CO_QUA',
                'target_house' => 'PHU_THE',
                'text_template' => '<strong>Cô Thần / Quả Tú cư Phu Thê:</strong> Duyên phận thường đến muộn, hoặc vợ chồng ít có thời gian gần gũi, chia sẻ. Cần vun đắp tình cảm nhiều hơn để tránh sự xa cách.',
                'conditions' => [['type' => 'star_in_house', 'house_code' => 'PHU_THE', 'value' => json_encode(['star_slug' => 'co-than']), 'operator' => 'exists']]
            ],
            [
                'code' => 'PHU_THE_HOA_KY',
                'target_house' => 'PHU_THE',
                'text_template' => '<strong>Hóa Kỵ cư Phu Thê:</strong> Vợ chồng dễ nảy sinh mâu thuẫn, khắc khẩu vì những chuyện nhỏ nhặt. Nên nhường nhịn nhau để giữ hòa khí.',
                'conditions' => [['type' => 'star_in_house', 'house_code' => 'PHU_THE', 'value' => json_encode(['star_slug' => 'hoa-ky']), 'operator' => 'exists']]
            ],
            [
                'code' => 'PHU_THE_THAI_AM',
                'target_house' => 'PHU_THE',
                'text_template' => '<strong>Thái Âm cư Phu Thê:</strong> Người phối ngẫu thường dịu dàng, đẹp người đẹp nết (nhất là nếu là vợ). Cuộc sống hôn nhân lãng mạn, êm đềm.',
                'conditions' => [['type' => 'star_in_house', 'house_code' => 'PHU_THE', 'value' => json_encode(['star_slug' => 'thai-am']), 'operator' => 'exists']]
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