<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StarEnergyLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * M: Miếu, V: Vượng, D: Đắc, B: Bình, H: Hãm
     * Key convention: 
     *  - ty: Tý (Rat)
     *  - suu: Sửu (Ox)
     *  - dan: Dần (Tiger)
     *  - mao: Mão (Cat/Rabbit)
     *  - thin: Thìn (Dragon)
     *  - ti: Tỵ (Snake)
     *  - ngo: Ngọ (Horse)
     *  - mui: Mùi (Goat)
     *  - than: Thân (Monkey)
     *  - dau: Dậu (Rooster)
     *  - tuat: Tuất (Dog)
     *  - hoi: Hợi (Pig)
     */
    public function run(): void
    {
        $data = [
            // 1. TỬ VI (Thổ)
            // Miếu: Ngọ, Tỵ, Dần, Thân. Vượng: Thìn, Tuất. Đắc: Sửu, Mùi. Bình: Hợi, Tý, Mão, Dậu
            'tu-vi' => [
                'ngo' => 'M', 'ti' => 'M', 'dan' => 'M', 'than' => 'M',
                'thin' => 'V', 'tuat' => 'V',
                'suu' => 'D', 'mui' => 'D',
                'hoi' => 'B', 'ty' => 'B', 'mao' => 'B', 'dau' => 'B'
            ],

            // 2. LIÊM TRINH (Hỏa)
            // Miếu: Thìn, Tuất. Vượng: Tý, Ngọ, Dần, Thân. Đắc: Sửu, Mùi. Hãm: Tỵ, Hợi, Mão, Dậu
            'liem-trinh' => [
                'thin' => 'M', 'tuat' => 'M',
                'ty' => 'V', 'ngo' => 'V', 'dan' => 'V', 'than' => 'V',
                'suu' => 'D', 'mui' => 'D',
                'ti' => 'H', 'hoi' => 'H', 'mao' => 'H', 'dau' => 'H'
            ],

            // 3. THIÊN ĐỒNG (Thủy)
            // Miếu: Dần, Thân. Vượng: Tý. Đắc: Mão, Tỵ, Hợi. Hãm: Thìn, Tuất, Sửu, Mùi, Ngọ, Dậu
            'thien-dong' => [
                'dan' => 'M', 'than' => 'M',
                'ty' => 'V',
                'mao' => 'D', 'ti' => 'D', 'hoi' => 'D',
                'thin' => 'H', 'tuat' => 'H', 'suu' => 'H', 'mui' => 'H', 'ngo' => 'H', 'dau' => 'H'
            ],

            // 4. VŨ KHÚC (Kim)
            // Miếu: Thìn, Tuất, Sửu, Mùi. Vượng: Tý, Ngọ, Dần, Thân. Đắc: Mão, Dậu. Hãm: Tỵ, Hợi
            'vu-khuc' => [
                'thin' => 'M', 'tuat' => 'M', 'suu' => 'M', 'mui' => 'M',
                'ty' => 'V', 'ngo' => 'V', 'dan' => 'V', 'than' => 'V',
                'mao' => 'D', 'dau' => 'D',
                'ti' => 'H', 'hoi' => 'H'
            ],

            // 5. THÁI DƯƠNG (Hỏa) - Mặt trời
            // Miếu: Tỵ, Ngọ. Vượng: Dần, Mão, Thìn. Đắc: Sửu, Mùi. Hãm: Thân, Dậu, Tuất, Hợi, Tý
            'thai-duong' => [
                'ti' => 'M', 'ngo' => 'M',
                'dan' => 'V', 'mao' => 'V', 'thin' => 'V',
                'suu' => 'D', 'mui' => 'D',
                'than' => 'H', 'dau' => 'H', 'tuat' => 'H', 'hoi' => 'H', 'ty' => 'H'
            ],

            // 6. THIÊN CƠ (Mộc)
            // Miếu: Thìn, Tuất, Mão, Dậu. Vượng: Tỵ, Thân. Đắc: Tý, Ngọ, Sửu, Mùi. Hãm: Dần, Hợi
            'thien-co' => [
                'thin' => 'M', 'tuat' => 'M', 'mao' => 'M', 'dau' => 'M',
                'ti' => 'V', 'than' => 'V',
                'ty' => 'D', 'ngo' => 'D', 'suu' => 'D', 'mui' => 'D',
                'dan' => 'H', 'hoi' => 'H'
            ],

            // 7. THIÊN PHỦ (Thổ) - Vua kho
            // Miếu: Dần, Thân, Tý, Ngọ. Vượng: Thìn, Tuất. Đắc: Tỵ, Hợi, Mùi. Bình: Sửu, Mão, Dậu. (Thiên Phủ ko có Hãm địa thực sự, chỉ bình hòa)
            'thien-phu' => [
                'dan' => 'M', 'than' => 'M', 'ty' => 'M', 'ngo' => 'M',
                'thin' => 'V', 'tuat' => 'V',
                'ti' => 'D', 'hoi' => 'D', 'mui' => 'D',
                'suu' => 'B', 'mao' => 'B', 'dau' => 'B'
            ],

            // 8. THÁI ÂM (Thủy) - Mặt trăng
            // Miếu: Hợi, Tý, Sửu. Vượng: Dậu, Tuất. Đắc: Thân. Hãm: Dần, Mão, Thìn, Tỵ, Ngọ, Mùi
            'thai-am' => [
                'hoi' => 'M', 'ty' => 'M', 'suu' => 'M',
                'dau' => 'V', 'tuat' => 'V',
                'than' => 'D',
                'dan' => 'H', 'mao' => 'H', 'thin' => 'H', 'ti' => 'H', 'ngo' => 'H', 'mui' => 'H'
            ],

            // 9. THAM LANG (Thủy/Mộc)
            // Miếu: Sửu, Mùi. Vượng: Thìn, Tuất. Đắc: Dần, Thân. Hãm: Tỵ, Hợi, Tý, Ngọ, Mão, Dậu
            'tham-lang' => [
                'suu' => 'M', 'mui' => 'M',
                'thin' => 'V', 'tuat' => 'V',
                'dan' => 'D', 'than' => 'D',
                'ti' => 'H', 'hoi' => 'H', 'ty' => 'H', 'ngo' => 'H', 'mao' => 'H', 'dau' => 'H'
            ],

            // 10. CỰ MÔN (Thủy)
            // Miếu: Mão, Dậu. Vượng: Tý, Ngọ, Dần. Đắc: Hợi, Tỵ. Hãm: Thìn, Tuất, Sửu, Mùi, Thân
            'cu-mon' => [
                'mao' => 'M', 'dau' => 'M',
                'ty' => 'V', 'ngo' => 'V', 'dan' => 'V',
                'hoi' => 'D', 'ti' => 'D',
                'thin' => 'H', 'tuat' => 'H', 'suu' => 'H', 'mui' => 'H', 'than' => 'H'
            ],

            // 11. THIÊN TƯỚNG (Thủy)
            // Miếu: Dần, Thân. Vượng: Thìn, Tuất, Tý, Ngọ. Đắc: Tỵ, Hợi, Sửu, Mùi. Hãm: Mão, Dậu
            'thien-tuong' => [
                'dan' => 'M', 'than' => 'M',
                'thin' => 'V', 'tuat' => 'V', 'ty' => 'V', 'ngo' => 'V',
                'ti' => 'D', 'hoi' => 'D', 'suu' => 'D', 'mui' => 'D',
                'mao' => 'H', 'dau' => 'H'
            ],

            // 12. THIÊN LƯƠNG (Mộc)
            // Miếu: Ngọ, Thìn, Tuất. Vượng: Tý, Mão, Dần, Thân. Đắc: Sửu, Mùi. Hãm: Dậu, Tỵ, Hợi
            'thien-luong' => [
                'ngo' => 'M', 'thin' => 'M', 'tuat' => 'M',
                'ty' => 'V', 'mao' => 'V', 'dan' => 'V', 'than' => 'V',
                'suu' => 'D', 'mui' => 'D',
                'dau' => 'H', 'ti' => 'H', 'hoi' => 'H'
            ],

            // 13. THẤT SÁT (Kim/Hỏa)
            // Miếu: Dần, Thân, Tý, Ngọ. Vượng: Tỵ, Hợi. Đắc: Sửu, Mùi. Hãm: Mão, Dậu, Thìn, Tuất
            'that-sat' => [
                'dan' => 'M', 'than' => 'M', 'ty' => 'M', 'ngo' => 'M',
                'ti' => 'V', 'hoi' => 'V',
                'suu' => 'D', 'mui' => 'D',
                'mao' => 'H', 'dau' => 'H', 'thin' => 'H', 'tuat' => 'H'
            ],

            // 14. PHÁ QUÂN (Thủy)
            // Miếu: Tý, Ngọ. Vượng: Sửu, Mùi. Đắc: Thìn, Tuất. Hãm: Mão, Dậu, Dần, Thân, Tỵ, Hợi
            'pha-quan' => [
                'ty' => 'M', 'ngo' => 'M',
                'suu' => 'V', 'mui' => 'V',
                'thin' => 'D', 'tuat' => 'D',
                'mao' => 'H', 'dau' => 'H', 'dan' => 'H', 'than' => 'H', 'ti' => 'H', 'hoi' => 'H'
            ],
            
            // Kình Dương: Miếu (Thìn, Tuất, Sửu, Mùi). Hãm các cung còn lại.
             'kinh-duong' => [
                'thin' => 'M', 'tuat' => 'M', 'suu' => 'M', 'mui' => 'M',
                'ty' => 'H', 'ngo' => 'H', 'dan' => 'H', 'than' => 'H', 'mao' => 'H', 'dau' => 'H', 'ti' => 'H', 'hoi' => 'H'
            ],
            
            // Đà La: Miếu (Thìn, Tuất, Sửu, Mùi). Hãm các cung còn lại.
             'da-la' => [
                'thin' => 'M', 'tuat' => 'M', 'suu' => 'M', 'mui' => 'M',
                'ty' => 'H', 'ngo' => 'H', 'dan' => 'H', 'than' => 'H', 'mao' => 'H', 'dau' => 'H', 'ti' => 'H', 'hoi' => 'H'
            ],
        ];

        $insertData = [];

        foreach ($data as $starSlug => $levels) {
            foreach ($levels as $branchKey => $level) {
                // Ensure branchKey is a valid 12 branch code
                $insertData[] = [
                    'star_slug' => $starSlug,
                    'branch_code' => $branchKey,
                    'energy_level' => $level,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Use upsert or chunk insert. Since migration refreshes, insert is fine, but check for safety.
        // Chunking to avoid placeholder limits if any (though small here)
        foreach (array_chunk($insertData, 100) as $chunk) {
             DB::table('star_energy_levels')->insert($chunk);
        }
    }
}
