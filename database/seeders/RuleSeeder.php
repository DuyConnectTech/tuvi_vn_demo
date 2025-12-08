<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RuleSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('rules')->truncate();
        DB::table('rule_conditions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Rule 1: Mệnh có Tử Vi
        $ruleId1 = DB::table('rules')->insertGetId([
            'code' => 'MENH_TU_VI',
            'target_house' => 'MENH',
            'text_template' => 'Bạn là người có sao Tử Vi thủ mệnh. Tử Vi là đế tinh, chủ về quyền lực và tài lãnh đạo. Bạn thường có dáng vẻ uy nghi, điềm đạm, được người khác nể trọng. Tính cách nhân hậu, trọng danh dự.',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('rule_conditions')->insert([
            'rule_id' => $ruleId1,
            'type' => 'star_in_house', // matches migration 'type'
            'house_code' => 'MENH',
            'value' => json_encode(['star_slug' => 'tu-vi']), // value is json
            'operator' => 'exists',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Rule 2: Thân cư Tài Bạch
        $ruleId2 = DB::table('rules')->insertGetId([
            'code' => 'THAN_CU_TAI',
            'target_house' => 'TAI_BACH',
            'text_template' => 'Thân cư Tài Bạch: Bạn là người coi trọng đồng tiền, cả đời phấn đấu vì mục tiêu tài chính. Sướng hay khổ đều do tiền bạc quyết định. Có năng khiếu quản lý tài chính.',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('rule_conditions')->insert([
            'rule_id' => $ruleId2,
            'type' => 'house_position',
            'house_code' => 'TAI_BACH',
            'value' => json_encode(['meta_key' => 'than_cung_code', 'value' => 'TAI_BACH']), // logic stored in value
            'operator' => 'equals',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Rule 3: Mệnh có Kình Dương (Sát tinh)
        $ruleId3 = DB::table('rules')->insertGetId([
            'code' => 'MENH_KINH_DUONG',
            'target_house' => 'MENH',
            'text_template' => 'Mệnh có Kình Dương: Tính khí cương cường, nóng nảy, liều lĩnh. Thích làm việc lớn, không ngại khó khăn gian khổ. Tuy nhiên dễ gây xích mích, thị phi.',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('rule_conditions')->insert([
            'rule_id' => $ruleId3,
            'type' => 'star_in_house',
            'house_code' => 'MENH',
            'value' => json_encode(['star_slug' => 'kinh-duong']),
            'operator' => 'exists',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
