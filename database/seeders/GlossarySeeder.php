<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GlossarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $terms = [
            [
                'term' => 'Cung Mệnh',
                'category' => 'Cung',
                'description' => 'Cung Mệnh là cung quan trọng nhất trên lá số Tử Vi, đại diện cho bản thân, cá tính, và số phận tổng quát của đương số.',
                'reference_url' => 'https://example.com/cung-menh',
            ],
            [
                'term' => 'Tam Hợp',
                'category' => 'Quan hệ cung',
                'description' => 'Mối quan hệ ba cung cách nhau 4 cung trên lá số, tạo thành một tam giác. Các cung Tam Hợp có ảnh hưởng tương hỗ lẫn nhau, mang ý nghĩa đồng khí, đồng dạng.',
                'reference_url' => 'https://example.com/tam-hop',
            ],
            [
                'term' => 'Tứ Hóa',
                'category' => 'Hóa tinh',
                'description' => 'Bao gồm Hóa Lộc, Hóa Quyền, Hóa Khoa, Hóa Kỵ. Đây là các yếu tố biến hóa của các sao khác, ảnh hưởng lớn đến ý nghĩa tốt xấu của lá số.',
                'reference_url' => 'https://example.com/tu-hoa',
            ],
            [
                'term' => 'Hãm Địa',
                'category' => 'Năng lượng sao',
                'description' => 'Trạng thái của sao khi an vào cung không phù hợp, làm giảm năng lượng tích cực và tăng năng lượng tiêu cực của sao đó.',
                'reference_url' => 'https://example.com/ham-dia',
            ],
            [
                'term' => 'Lục Thập Hoa Giáp',
                'category' => 'Thuật ngữ chung',
                'description' => 'Hệ thống chu kỳ 60 năm của lịch Âm Dương, mỗi năm là sự kết hợp của một Can (Thiên Can) và một Chi (Địa Chi), mỗi cặp có một Ngũ Hành Nạp Âm riêng biệt.',
                'reference_url' => 'https://example.com/luc-thap-hoa-giap',
            ],
        ];

        foreach ($terms as $termData) {
            DB::table('glossaries')->updateOrInsert(
                ['term' => $termData['term']],
                array_merge($termData, ['slug' => Str::slug($termData['term']), 'created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}