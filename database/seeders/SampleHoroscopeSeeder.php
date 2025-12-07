<?php

namespace Database\Seeders;

use App\Models\Horoscope;
use App\Models\HoroscopeHouse;
use App\Models\HoroscopeHouseStar;
use App\Models\HoroscopeMetum;
use App\Models\Rule;
use App\Models\RuleCondition;
use App\Models\Star;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SampleHoroscopeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Horoscope
        $horoscope = Horoscope::firstOrCreate(
            ['slug' => 'nguyen-van-test-1990'],
            [
                'name' => 'Nguyễn Văn Test',
                'gender' => 'male',
                'birth_gregorian' => '1990-01-01 12:00:00',
                'birth_lunar_year' => 1989, // Kỷ Tỵ (cuối năm) hoặc Canh Ngọ (đầu năm) - Test đại
                'can_chi_year' => 'Canh Ngọ',
                'can_chi_month' => 'Bính Dần',
                'can_chi_day' => 'Giáp Tý',
                'can_chi_hour' => 'Canh Ngọ',
                'nap_am' => 'Lộ Bàng Thổ',
                'am_duong' => 'Dương Nam',
                'cuc' => 'Thổ Ngũ Cục',
                'view_year' => 2025,
            ]
        );

        // 2. Create Meta
        HoroscopeMetum::firstOrCreate(
            ['horoscope_id' => $horoscope->id],
            [
                'chu_menh' => 'Phá Quân',
                'chu_than' => 'Linh Tinh',
            ]
        );

        // 3. Create 12 Houses
        // Giả sử Mệnh an tại Ngọ (Branch 'Ngo')
        $housesConfig = [
            ['code' => 'MENH', 'label' => 'Mệnh', 'branch' => 'Ngọ', 'house_order' => 7],
            ['code' => 'PHU_MAU', 'label' => 'Phụ Mẫu', 'branch' => 'Mùi', 'house_order' => 8],
            ['code' => 'PHUC_DUC', 'label' => 'Phúc Đức', 'branch' => 'Thân', 'house_order' => 9],
            ['code' => 'DIEN_TRACH', 'label' => 'Điền Trạch', 'branch' => 'Dậu', 'house_order' => 10],
            ['code' => 'QUAN_LOC', 'label' => 'Quan Lộc', 'branch' => 'Tuất', 'house_order' => 11],
            ['code' => 'NO_BOC', 'label' => 'Nô Bộc', 'branch' => 'Hợi', 'house_order' => 12],
            ['code' => 'THIEN_DI', 'label' => 'Thiên Di', 'branch' => 'Tý', 'house_order' => 1],
            ['code' => 'TAT_ACH', 'label' => 'Tật Ách', 'branch' => 'Sửu', 'house_order' => 2],
            ['code' => 'TAI_BACH', 'label' => 'Tài Bạch', 'branch' => 'Dần', 'house_order' => 3],
            ['code' => 'TU_TUC', 'label' => 'Tử Tức', 'branch' => 'Mão', 'house_order' => 4],
            ['code' => 'PHU_THE', 'label' => 'Phu Thê', 'branch' => 'Thìn', 'house_order' => 5],
            ['code' => 'HUYNH_DE', 'label' => 'Huynh Đệ', 'branch' => 'Tỵ', 'house_order' => 6],
        ];

        foreach ($housesConfig as $cfg) {
            $house = HoroscopeHouse::firstOrCreate(
                [
                    'horoscope_id' => $horoscope->id,
                    'code' => $cfg['code']
                ],
                [
                    'label' => $cfg['label'],
                    'branch' => $cfg['branch'],
                    'house_order' => $cfg['house_order'],
                    'element' => 'Hỏa', // Giả định
                ]
            );

            // 4. Assign Stars
            // Mệnh (Ngọ) có Tử Vi
            if ($cfg['code'] === 'MENH') {
                $starTuVi = Star::where('slug', 'tu-vi')->first();
                if ($starTuVi) {
                    HoroscopeHouseStar::firstOrCreate(
                        ['horoscope_house_id' => $house->id, 'star_id' => $starTuVi->id],
                        ['status' => 'Miếu']
                    );
                }
            }
            
            // Quan Lộc (Tuất) có Thiên Phủ (Giả sử đi với Liêm Trinh, nhưng ở đây test Thiên Phủ thôi)
            if ($cfg['code'] === 'QUAN_LOC') {
                $starThienPhu = Star::where('slug', 'thien-phu')->first();
                if ($starThienPhu) {
                    HoroscopeHouseStar::firstOrCreate(
                        ['horoscope_house_id' => $house->id, 'star_id' => $starThienPhu->id],
                        ['status' => 'Vượng']
                    );
                }
            }
        }

        // 5. Create Test Rules
        // Rule 1: Mệnh có Tử Vi
        $rule1 = Rule::firstOrCreate(
            ['code' => 'TEST_MENH_TU_VI'],
            [
                'scope' => 'house',
                'target_house' => 'MENH',
                'priority' => 100,
                'text_template' => 'Mệnh có sao Tử Vi: Tính cách tôn quý, có khả năng lãnh đạo.',
                'is_active' => true,
            ]
        );
        
        RuleCondition::firstOrCreate(
            ['rule_id' => $rule1->id, 'type' => 'has_star'],
            [
                'field' => 'house.MENH.stars',
                'operator' => '=',
                'value' => 'Tử Vi', // String value
            ]
        );

        // Rule 2: Quan Lộc có Thiên Phủ (Test has_any_star list)
        $rule2 = Rule::firstOrCreate(
            ['code' => 'TEST_QUAN_THIEN_PHU'],
            [
                'scope' => 'house',
                'target_house' => 'QUAN_LOC',
                'priority' => 90,
                'text_template' => 'Quan Lộc có Thiên Phủ: Tài chính vững vàng, công việc ổn định.',
                'is_active' => true,
            ]
        );

        RuleCondition::firstOrCreate(
            ['rule_id' => $rule2->id, 'type' => 'has_any_star'],
            [
                'field' => 'house.QUAN_LOC.stars',
                'operator' => 'IN',
                'value' => ['Thiên Phủ', 'Vũ Khúc'], // Array value directly
            ]
        );
    }
}