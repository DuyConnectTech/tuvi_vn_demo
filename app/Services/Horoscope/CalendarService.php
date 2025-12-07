<?php

namespace App\Services\Horoscope;

use LucNham\LunarCalendar\LunarDateTime;
use Carbon\Carbon;
use DateTimeZone;

class CalendarService
{
    protected $timeZone;

    const CANS = ['Giáp', 'Ất', 'Bính', 'Đinh', 'Mậu', 'Kỷ', 'Canh', 'Tân', 'Nhâm', 'Quý'];
    const CHIS = ['Tý', 'Sửu', 'Dần', 'Mão', 'Thìn', 'Tỵ', 'Ngọ', 'Mùi', 'Thân', 'Dậu', 'Tuất', 'Hợi'];

    public function __construct($timeZone = 'Asia/Ho_Chi_Minh')
    {
        $this->timeZone = new DateTimeZone($timeZone);
    }

    /**
     * Convert Solar Date to Lunar Date.
     *
     * @param string|Carbon $date Solar date
     * @return LunarDateTime
     */
    public function toLunar($date): LunarDateTime
    {
        if ($date instanceof Carbon) {
            $date = $date->format('Y-m-d H:i:s');
        }
        
        // Initialize LunarDateTime from Gregorian
        // Format required by library might be specific, let's try 'Y-m-d H:i:s'
        // Library constructor takes: $datetime = 'now', $timezone
        // If input is solar, use static method: LunarDateTime::fromGregorian($date, $timezone)
        
        return LunarDateTime::fromGregorian($date, $this->timeZone);
    }

    /**
     * Get Can Chi for Year, Month, Day, Hour.
     *
     * @param LunarDateTime $lunarDate
     * @return array ['year', 'month', 'day', 'hour'] strings (e.g. 'Giáp Tý')
     */
    public function getCanChi(LunarDateTime $lunarDate): array
    {
        $lunarYear = $lunarDate->year;
        $lunarMonth = $lunarDate->month;
        $jdn = $lunarDate->jdn;
        $hour = $lunarDate->hour;

        // 1. Can Chi Năm
        $canYearIndex = ($lunarYear + 6) % 10; // 4: Giáp (1984 % 10 = 4 -> Giáp. 4+6=10%10=0. Wait. 1984 is Giap Ty. 
        // Simple formula: (Year - 3) % 10. 
        // 1984 - 3 = 1981. 1981 % 10 = 1. But Giap is index 0.
        // Let's map: 4: Giap, 5: At, 6: Binh, 7: Dinh, 8: Mau, 9: Ky, 0: Canh, 1: Tan, 2: Nham, 3: Quy.
        // My array CANS: 0: Giap.
        // So (Year - 4) % 10 = index. (1984-4)%10 = 0 (Giap). Correct.
        $canYearIndex = ($lunarYear + 6) % 10; // Correction: 1984 -> Giap (0). (1984+6)%10 = 0. Correct.
        $chiYearIndex = ($lunarYear + 8) % 12; // 1984 -> Ty (0). (1984+8)%12 = 0. Correct.

        $canChiYear = self::CANS[$canYearIndex] . ' ' . self::CHIS[$chiYearIndex];

        // 2. Can Chi Tháng
        // Tháng 1 là Dần (index 2).
        // Can tháng tính theo Can Năm.
        // Giáp/Kỷ (0/5) -> Bính Dần (2). (2*0 + 2) % 10 = 2 (Binh)
        // Ất/Canh (1/6) -> Mậu Dần (4). (2*1 + 2) % 10 = 4 (Mau)
        // Bính/Tân (2/7) -> Canh Dần (6). (2*2 + 2) % 10 = 6 (Canh)
        // Đinh/Nhâm (3/8) -> Nhâm Dần (8). (2*3 + 2) % 10 = 8 (Nham)
        // Mậu/Quý (4/9) -> Giáp Dần (0). (2*4 + 2) % 10 = 0 (Giap) - actually 10%10=0.
        // Formula: CanThang1 = (CanNam * 2 + 2) % 10.
        
        $canMonthStart = ($canYearIndex * 2 + 2) % 10;
        $canMonthIndex = ($canMonthStart + ($lunarMonth - 1)) % 10;
        $chiMonthIndex = ($lunarMonth + 1) % 12; // Thang 1 la Dan (index 2). 1+1=2.
        
        $canChiMonth = self::CANS[$canMonthIndex] . ' ' . self::CHIS[$chiMonthIndex];

        // 3. Can Chi Ngày
        // Formula based on JDN.
        // JDN of 2024-02-10 (Mùng 1 Tết Giáp Thìn) is 2460351.
        // Can Ngày: (JDN + 9) % 10. 2460351 + 9 = 2460360 % 10 = 0 -> Giáp. Correct (Giáp Thìn).
        // Chi Ngày: (JDN + 1) % 12. 2460351 + 1 = 2460352 % 12 = 8 -> Thìn (4? Wait).
        // Chi Array: 0: Tý, 1: Sửu, 2: Dần, 3: Mão, 4: Thìn.
        // Let's check known date. 2024-02-10 is Giáp Thìn.
        // Can: 0 (Giáp). Chi: 4 (Thìn).
        // JDN: 2460351.
        // (2460351 + x) % 12 = 4. 3+x=4 -> x=1. So (JDN+1)%12.
        $jdnInt = floor($jdn + 0.5);
        $canDayIndex = ($jdnInt + 9) % 10;
        $chiDayIndex = ($jdnInt + 1) % 12;

        $canChiDay = self::CANS[$canDayIndex] . ' ' . self::CHIS[$chiDayIndex];

        // 4. Can Chi Giờ
        // Chi Giờ: 23-1: Tý (0). 1-3: Sửu (1).
        // Hour 0 (00:00-00:59) -> Tý (0).
        // Hour 1 (01:00-01:59) -> Sửu (1).
        // Formula: (Hour + 1) / 2 floor % 12.
        // 0 -> (1)/2 = 0 (Ty). 1 -> (2)/2 = 1 (Suu). 23 -> (24)/2 = 12%12 = 0 (Ty).
        $chiHourIndex = floor(($hour + 1) / 2) % 12;

        // Can Giờ tính theo Can Ngày.
        // Giáp/Kỷ (0/5) -> Giáp Tý (0). (2*0 + 0) = 0.
        // Ất/Canh (1/6) -> Bính Tý (2). (2*1 + 0) = 2.
        // Bính/Tân (2/7) -> Mậu Tý (4). (2*2 + 0) = 4.
        // ...
        // Formula: CanGioTy = (CanNgay * 2) % 10.
        $canHourStart = ($canDayIndex * 2) % 10;
        $canHourIndex = ($canHourStart + $chiHourIndex) % 10;

        $canChiHour = self::CANS[$canHourIndex] . ' ' . self::CHIS[$chiHourIndex];

        return [
            'year' => $canChiYear,
            'month' => $canChiMonth,
            'day' => $canChiDay,
            'hour' => $canChiHour,
        ];
    }

    /**
     * Get Lunar details array.
     * 
     * @param Carbon $solarDate
     * @return array
     */
    public function getLunarDetails(Carbon $solarDate): array
    {
        $lunar = $this->toLunar($solarDate);
        $canChi = $this->getCanChi($lunar);
        
        return [
            'lunar_year' => $lunar->year,
            'lunar_month' => $lunar->month,
            'lunar_day' => $lunar->day,
            'is_leap' => $lunar->leap, // Check if property 'leap' or 'isLeapMonth' exists
            'can_chi_year' => $canChi['year'],
            'can_chi_month' => $canChi['month'],
            'can_chi_day' => $canChi['day'],
            'can_chi_hour' => $canChi['hour'],
        ];
    }
}