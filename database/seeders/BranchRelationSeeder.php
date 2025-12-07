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
            // Create pairs for each combination in the group
            foreach ($group as $b1) {
                foreach ($group as $b2) {
                    if ($b1 !== $b2) {
                        $relations[] = [
                            'from_house_code' => $b1,
                            'to_house_code' => $b2,
                            'relation_type' => 'tam_hop',
                            'description' => 'Tam Hợp',
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
            $relations[] = ['from_house_code' => $pair[0], 'to_house_code' => $pair[1], 'relation_type' => 'xung', 'description' => 'Lục Xung (Chính Chiếu)', 'created_at' => now(), 'updated_at' => now()];
            $relations[] = ['from_house_code' => $pair[1], 'to_house_code' => $pair[0], 'relation_type' => 'xung', 'description' => 'Lục Xung (Chính Chiếu)', 'created_at' => now(), 'updated_at' => now()];
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
            $relations[] = ['from_house_code' => $pair[0], 'to_house_code' => $pair[1], 'relation_type' => 'nhi_hop', 'description' => 'Nhị Hợp', 'created_at' => now(), 'updated_at' => now()];
            $relations[] = ['from_house_code' => $pair[1], 'to_house_code' => $pair[0], 'relation_type' => 'nhi_hop', 'description' => 'Nhị Hợp', 'created_at' => now(), 'updated_at' => now()];
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
            $relations[] = ['from_house_code' => $pair[0], 'to_house_code' => $pair[1], 'relation_type' => 'luc_hai', 'description' => 'Lục Hại', 'created_at' => now(), 'updated_at' => now()];
            $relations[] = ['from_house_code' => $pair[1], 'to_house_code' => $pair[0], 'relation_type' => 'luc_hai', 'description' => 'Lục Hại', 'created_at' => now(), 'updated_at' => now()];
        }

        DB::table('branch_relations')->insert($relations);
    }
}