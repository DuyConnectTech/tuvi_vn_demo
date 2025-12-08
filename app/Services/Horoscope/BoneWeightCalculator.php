<?php

namespace App\Services\Horoscope;

class BoneWeightCalculator
{
    // Bảng tra lượng chỉ (Đơn vị: chỉ. 1 lượng = 10 chỉ)
    // Ví dụ: 1.2 lượng = 12 chỉ.

    protected static $yearWeights = [
        'Giáp Tý' => 12, 'Bính Tý' => 16, 'Mậu Tý' => 15, 'Canh Tý' => 7, 'Nhâm Tý' => 5,
        'Ất Sửu' => 9, 'Đinh Sửu' => 8, 'Kỷ Sửu' => 7, 'Tân Sửu' => 7, 'Quý Sửu' => 7,
        'Giáp Dần' => 12, 'Bính Dần' => 6, 'Mậu Dần' => 8, 'Canh Dần' => 9, 'Nhâm Dần' => 9,
        'Ất Mão' => 8, 'Đinh Mão' => 7, 'Kỷ Mão' => 19, 'Tân Mão' => 12, 'Quý Mão' => 12,
        'Giáp Thìn' => 8, 'Bính Thìn' => 8, 'Mậu Thìn' => 12, 'Canh Thìn' => 12, 'Nhâm Thìn' => 10,
        'Ất Tỵ' => 7, 'Đinh Tỵ' => 6, 'Kỷ Tỵ' => 6, 'Tân Tỵ' => 6, 'Quý Tỵ' => 7,
        'Giáp Ngọ' => 15, 'Bính Ngọ' => 13, 'Mậu Ngọ' => 19, 'Canh Ngọ' => 9, 'Nhâm Ngọ' => 8,
        'Ất Mùi' => 6, 'Đinh Mùi' => 5, 'Kỷ Mùi' => 6, 'Tân Mùi' => 8, 'Quý Mùi' => 7,
        'Giáp Thân' => 5, 'Bính Thân' => 14, 'Mậu Thân' => 14, 'Canh Thân' => 8, 'Nhâm Thân' => 7,
        'Ất Dậu' => 15, 'Đinh Dậu' => 14, 'Kỷ Dậu' => 5, 'Tân Dậu' => 16, 'Quý Dậu' => 8,
        'Giáp Tuất' => 15, 'Bính Tuất' => 6, 'Mậu Tuất' => 14, 'Canh Tuất' => 9, 'Nhâm Tuất' => 10,
        'Ất Hợi' => 9, 'Đinh Hợi' => 16, 'Kỷ Hợi' => 9, 'Tân Hợi' => 17, 'Quý Hợi' => 7,
    ];

    protected static $monthWeights = [
        1 => 6, 2 => 7, 3 => 18, 4 => 9, 5 => 5, 6 => 16,
        7 => 9, 8 => 15, 9 => 18, 10 => 8, 11 => 9, 12 => 5,
    ];

    protected static $dayWeights = [
        1 => 5, 2 => 10, 3 => 8, 4 => 15, 5 => 16, 6 => 15, 7 => 8, 8 => 16, 9 => 8, 10 => 16,
        11 => 9, 12 => 17, 13 => 8, 14 => 17, 15 => 10, 16 => 8, 17 => 9, 18 => 18, 19 => 5, 20 => 15,
        21 => 10, 22 => 9, 23 => 8, 24 => 9, 25 => 15, 26 => 18, 27 => 7, 28 => 8, 29 => 16, 30 => 6,
    ];

    protected static $hourWeights = [
        'Tý' => 16, 'Sửu' => 6, 'Dần' => 7, 'Mão' => 10, 'Thìn' => 9, 'Tỵ' => 16,
        'Ngọ' => 10, 'Mùi' => 8, 'Thân' => 8, 'Dậu' => 9, 'Tuất' => 6, 'Hợi' => 6,
    ];

    public static function calculate(string $yearCanChi, int $month, int $day, string $hourChi): string
    {
        // Clean Year Can Chi (e.g. "Kỷ Mão" -> "Kỷ Mão")
        $yearWeight = self::$yearWeights[$yearCanChi] ?? 0;
        $monthWeight = self::$monthWeights[$month] ?? 0;
        $dayWeight = self::$dayWeights[$day] ?? 0;
        $hourWeight = self::$hourWeights[$hourChi] ?? 0;

        $totalChi = $yearWeight + $monthWeight + $dayWeight + $hourWeight;
        
        $luong = floor($totalChi / 10);
        $chi = $totalChi % 10;

        return "{$luong} lượng {$chi} chỉ";
    }
}
