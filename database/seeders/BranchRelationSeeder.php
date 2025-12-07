<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchRelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            'ty' => 'Tý', 'suu' => 'Sửu', 'dan' => 'Dần', 'mao' => 'Mão', 
            'thin' => 'Thìn', 'ti' => 'Tỵ', 'ngo' => 'Ngọ', 'mui' => 'Mùi', 
            'than' => 'Thân', 'dau' => 'Dậu', 'tuat' => 'Tuất', 'hoi' => 'Hợi'
        ];

        $relations = [];

        // 1. TAM HỢP (Triune) - Tốt
        $tam_hop = [
            ['than', 'ty', 'thin'], // Thủy cục
            ['hoi', 'mao', 'mui'],  // Mộc cục
            ['dan', 'ngo', 'tuat'], // Hỏa cục
            ['ti', 'dau', 'suu'],   // Kim cục
        ];

        foreach ($tam_hop as $group) {
            foreach ($group as $b1_code) {
                foreach ($group as $b2_code) {
                    if ($b1_code !== $b2_code) {
                        // For Tam Hop, description could be "Tý Tam Hợp Thân Thìn" for "Tý" branch
                        // Or more simply "Tý Tam Hợp Thân" and "Tý Tam Hợp Thìn"
                        // Let's make it direct for simplicity for now: "Tý Tam Hợp Thân"
                        $relations[] = [
                            'from_house_code' => $b1_code,
                            'to_house_code' => $b2_code,
                            'relation_type' => 'tam_hop',
                            'description' => $branches[$b1_code] . ' Tam Hợp ' . $branches[$b2_code],
                            'created_at' => now(), 'updated_at' => now(),
                        ];
                    }
                }
            }
        }

        // 2. LỤC XUNG (Clash/Opposite) - Xấu (Chính chiếu)
        $luc_xung = [
            ['ty', 'ngo'],
            ['suu', 'mui'],
            ['dan', 'than'],
            ['mao', 'dau'],
            ['thin', 'tuat'],
            ['ti', 'hoi'],
        ];

        foreach ($luc_xung as $pair) {
            $relations[] = ['from_house_code' => $pair[0], 'to_house_code' => $pair[1], 'relation_type' => 'xung', 'description' => $branches[$pair[0]] . ' Lục Xung ' . $branches[$pair[1]], 'created_at' => now(), 'updated_at' => now()];
            $relations[] = ['from_house_code' => $pair[1], 'to_house_code' => $pair[0], 'relation_type' => 'xung', 'description' => $branches[$pair[1]] . ' Lục Xung ' . $branches[$pair[0]], 'created_at' => now(), 'updated_at' => now()];
        }

        // 3. NHỊ HỢP (Lục Hợp) - Tốt
        $nhi_hop = [
            ['ty', 'suu'],
            ['dan', 'hoi'],
            ['mao', 'tuat'],
            ['thin', 'dau'],
            ['ti', 'than'],
            ['ngo', 'mui'],
        ];

        foreach ($nhi_hop as $pair) {
            $relations[] = ['from_house_code' => $pair[0], 'to_house_code' => $pair[1], 'relation_type' => 'nhi_hop', 'description' => $branches[$pair[0]] . ' Nhị Hợp ' . $branches[$pair[1]], 'created_at' => now(), 'updated_at' => now()];
            $relations[] = ['from_house_code' => $pair[1], 'to_house_code' => $pair[0], 'relation_type' => 'nhi_hop', 'description' => $branches[$pair[1]] . ' Nhị Hợp ' . $branches[$pair[0]], 'created_at' => now(), 'updated_at' => now()];
        }

        // 4. LỤC HẠI - Xấu
        $luc_hai = [
            ['ty', 'mui'],
            ['suu', 'ngo'],
            ['dan', 'ti'],
            ['mao', 'thin'],
            ['than', 'hoi'],
            ['dau', 'tuat'],
        ];

        foreach ($luc_hai as $pair) {
            $relations[] = ['from_house_code' => $pair[0], 'to_house_code' => $pair[1], 'relation_type' => 'luc_hai', 'description' => $branches[$pair[0]] . ' Lục Hại ' . $branches[$pair[1]], 'created_at' => now(), 'updated_at' => now()];
            $relations[] = ['from_house_code' => $pair[1], 'to_house_code' => $pair[0], 'relation_type' => 'luc_hai', 'description' => $branches[$pair[1]] . ' Lục Hại ' . $branches[$pair[0]], 'created_at' => now(), 'updated_at' => now()];
        }

        DB::table('branch_relations')->insert($relations);
    }
}
