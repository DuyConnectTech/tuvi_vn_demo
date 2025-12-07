<?php

namespace App\Services\Horoscope;

use App\Models\Horoscope;
use App\Models\HoroscopeHouse;
use App\Models\HoroscopeHouseStar;
use App\Models\HoroscopeMetum;
use App\Models\Star;
use Carbon\Carbon;
use Illuminate\Support\Str;

class HoroscopeService
{
    protected CalendarService $calendarService;

    // Const for Can, Chi - same as in CalendarService
    const CANS = ['Giáp', 'Ất', 'Bính', 'Đinh', 'Mậu', 'Kỷ', 'Canh', 'Tân', 'Nhâm', 'Quý'];
    const CHIS = ['Tý', 'Sửu', 'Dần', 'Mão', 'Thìn', 'Tỵ', 'Ngọ', 'Mùi', 'Thân', 'Dậu', 'Tuất', 'Hợi'];

    public function __construct(CalendarService $calendarService)
    {
        $this->calendarService = $calendarService;
    }

    /**
     * Generate / Calculate a full horoscope chart based on birth details.
     * This will populate the Horoscope model with calculated data.
     *
     * @param Horoscope $horoscope The Horoscope model instance (already created with basic info).
     * @param Carbon $birthGregorian Birth date and time (Gregorian).
     * @param string $gender 'male' or 'female'.
     * @param string $timezone Timezone (e.g., 'Asia/Ho_Chi_Minh').
     * @return Horoscope
     */
    public function generateHoroscope(Horoscope $horoscope, Carbon $birthGregorian, string $gender, string $timezone): Horoscope
    {
        // 1. Convert to Lunar & Get Can Chi
        $lunarDetails = $this->calendarService->getLunarDetails($birthGregorian);
        $canChiYear = $lunarDetails['can_chi_year'];
        $canChiMonth = $lunarDetails['can_chi_month'];
        $canChiDay = $lunarDetails['can_chi_day'];
        $canChiHour = $lunarDetails['can_chi_hour'];
        $lunarYear = $lunarDetails['lunar_year'];
        $lunarMonth = $lunarDetails['lunar_month'];
        $lunarDay = $lunarDetails['lunar_day'];
        $lunarHour = $lunarDetails['chi_hour_index']; // Chi Hour Index (0-11)
        // $isLeapMonth = $lunarDetails['is_leap']; // For now, ignoring leap month complexity

        // Determine Can Chi of the birth year (Can and Chi parts)
        $yearCan = Str::before($canChiYear, ' ');
        $yearChi = Str::after($canChiYear, ' ');

        // Update basic horoscope details
        $horoscope->update([
            'birth_lunar_year' => $lunarYear,
            'birth_lunar_month' => $lunarMonth,
            'birth_lunar_day' => $lunarDay,
            'birth_lunar_is_leap' => $lunarDetails['is_leap'],
            'can_chi_year' => $canChiYear,
            'can_chi_month' => $canChiMonth,
            'can_chi_day' => $canChiDay,
            'can_chi_hour' => $canChiHour,
            'am_duong' => $this->determineAmDuong($yearCan, $gender),
        ]);

        // 2. Determine Nap Am (Bản Mệnh) & Cục
        $napAm = $this->determineNapAm($canChiYear);
        $horoscope->update(['nap_am' => $napAm]);

        $cucInfo = $this->determineCuc($lunarMonth, $lunarDay, $yearCan);
        $horoscope->update(['cuc' => $cucInfo['cuc'], 'so_cuc' => $cucInfo['so_cuc']]); // Store so_cuc

        // 3. An Mệnh, Thân, Thập nhị cung (12 Cung địa bàn và chức năng)
        $this->anCungMenhThan($horoscope, $lunarMonth, $lunarHour);

        // 4. An Sao (The most complex part)
        $this->anChinhTinh($horoscope, $lunarDay, $cucInfo['so_cuc']); // Pass lunarDay and so_cuc
        $this->anTuHoa($horoscope); // Tứ Hóa
        $this->anPhuTinhCoBan($horoscope); // Một số Phụ Tinh cơ bản

        // 5. Update Horoscope Meta (if any other derived info needed)
        // HoroscopeMetum::updateOrCreate(['horoscope_id' => $horoscope->id], [...]);

        return $horoscope;
    }

    /**
     * Determine Am Duong for the horoscope based on year Can and gender.
     * (Dương Nam, Âm Nữ) = thuận lý. (Âm Nam, Dương Nữ) = nghịch lý.
     *
     * @param string $yearCan
     * @param string $gender
     * @return string 'Dương Nam', 'Âm Nữ', 'Âm Nam', 'Dương Nữ'
     */
    protected function determineAmDuong(string $yearCan, string $gender): string
    {
        $canIndex = array_search($yearCan, self::CANS);
        $canAmDuong = ($canIndex % 2 == 0) ? 'Dương' : 'Âm'; // 0,2,4,6,8 is Dương; 1,3,5,7,9 is Âm

        if ($gender === 'male') {
            return $canAmDuong === 'Dương' ? 'Dương Nam' : 'Âm Nam';
        } else { // female
            return $canAmDuong === 'Dương' ? 'Dương Nữ' : 'Âm Nữ';
        }
    }

    /**
     * Determine Nap Am (Bản Mệnh) from Can Chi Year.
     * (E.g., Giáp Tý -> Hải Trung Kim)
     * This needs to query the 'luc_thap_hoa_giap' table.
     *
     * @param string $canChiYear
     * @return string
     */
    protected function determineNapAm(string $canChiYear): string
    {
        $lucThap = \App\Models\LucThapHoaGiap::where('can_chi', $canChiYear)->first();
        return $lucThap ? $lucThap->nap_am : 'Không xác định';
    }

    /**
     * Determine Cục (Mộc Tam Cục, Kim Tứ Cục...)
     *
     * @param int $lunarMonth
     * @param int $lunarHour
     * @param string $yearCan
     * @return array ['cuc' => string, 'so_cuc' => int]
     */
    protected function determineCuc(int $lunarMonth, int $lunarHour, string $yearCan): array
    {
        // 1. Determine Menh Chi Index
        $menhChiIndex = $this->calculateMenhChiIndex($lunarMonth, $lunarHour);
        $menhChi = self::CHIS[$menhChiIndex];

        // 2. Determine Can of Menh Cung (Ngu Dan Don)
        // Year Can determines Can of Dan month (month 1)
        $canOfMenh = $this->getCanOfChi($yearCan, $menhChiIndex);

        // 3. Get Nap Am of Can + Chi Menh
        $canChiMenh = $canOfMenh . ' ' . $menhChi;
        $lucThap = \App\Models\LucThapHoaGiap::where('can_chi', $canChiMenh)->first();

        if (!$lucThap) {
            return ['cuc' => 'Không xác định', 'so_cuc' => 0];
        }

        $hanhCuc = $lucThap->ngu_hanh; // Kim, Moc, Thuy, Hoa, Tho

        // Map Element to Cuc Name and Number
        $cucMap = [
            'Thủy' => ['cuc' => 'Thủy Nhị Cục', 'so_cuc' => 2],
            'Mộc' => ['cuc' => 'Mộc Tam Cục', 'so_cuc' => 3],
            'Kim' => ['cuc' => 'Kim Tứ Cục', 'so_cuc' => 4],
            'Thổ' => ['cuc' => 'Thổ Ngũ Cục', 'so_cuc' => 5],
            'Hỏa' => ['cuc' => 'Hỏa Lục Cục', 'so_cuc' => 6],
        ];

        return $cucMap[$hanhCuc] ?? ['cuc' => 'Không xác định', 'so_cuc' => 0];
    }

    /**
     * Calculate the Chi Index of the Menh Cung.
     *
     * @param int $lunarMonth
     * @param int $lunarHour
     * @return int Index in self::CHIS (0=Ty, 1=Suu...)
     */
    protected function calculateMenhChiIndex(int $lunarMonth, int $lunarHour): int
    {
        // Formula: Start from Dan (index 2), count clockwise for month, then counter-clockwise for hour (from result? No, from Ty usually).
        // Standard: From Dan (2), clockwise (month-1), then counter-clockwise (hour-1).
        // Start at Dan = 2.
        // Add (Month - 1).
        // Subtract (Hour - 1).
        $index = (2 + ($lunarMonth - 1) - ($lunarHour - 1));

        // Normalize to 0-11
        while ($index < 0)
            $index += 12;
        return $index % 12;
    }

    /**
     * Determine Can of a Chi based on Year Can (Ngu Dan Don).
     *
     * @param string $yearCan
     * @param int $chiIndex Index of the Chi to find Can for.
     * @return string Can name
     */
    protected function getCanOfChi(string $yearCan, int $chiIndex): string
    {
        $yearCanIndex = array_search($yearCan, self::CANS);

        // Ngu Dan Don: Determine Can of Dan (Index 2)
        // Giap/Ky (0/5) -> Binh Dan (2).
        // Formula: CanDan = (CanNam % 5) * 2 + 2.
        // 0 -> 2 (Binh). 1 -> 4 (Mau). 2 -> 6 (Canh). 3 -> 8 (Nham). 4 -> 10%10=0 (Giap).
        $canDanIndex = (($yearCanIndex % 5) * 2 + 2) % 10;

        // Count from Dan (2) to target Chi ($chiIndex)
        // If target < 2 (Ty, Suu), it's actually end of cycle relative to Dan start? 
        // Usually we treat the sequence continuous.
        // Difference in steps
        $steps = $chiIndex - 2; // Steps from Dan
        if ($steps < 0)
            $steps += 12; // e.g. Ty (0) from Dan (2) is 10 steps forward

        $canIndex = ($canDanIndex + $steps) % 10;

        return self::CANS[$canIndex];
    }

    /**
     * An Mệnh, Thân và 12 Cung địa bàn.
     * Also determine position of 12 branches (Tý, Sửu...)
     * Needs lunar month and lunar hour.
     *
     * @param Horoscope $horoscope
     * @param int $lunarMonth
     * @param int $lunarHour
     * @return void
     */
    protected function anCungMenhThan(Horoscope $horoscope, int $lunarMonth, int $lunarHour): void
    {
        // Calculate Menh position
        $anMenhIndex = $this->calculateMenhChiIndex($lunarMonth, $lunarHour);

        // Calculate Than position
        // Thân: From Dần (2), clockwise Month, clockwise Hour.
        // Index = (2 + (Month-1) + (Hour-1)) % 12
        $anThanIndex = (2 + ($lunarMonth - 1) + ($lunarHour - 1)) % 12;

        // Initialize 12 houses if not already done (should be done on Horoscope create)
        $horoscope->houses()->delete(); // Clear old houses
        $this->initializeHousesWithBranches($horoscope, $anMenhIndex, $anThanIndex);
    }

    /**
     * Helper to initialize 12 houses with branches
     */
    protected function initializeHousesWithBranches(Horoscope $horoscope, int $menhChiIndex, int $thanChiIndex)
    {
        $houseCodesInOrder = [
            'MENH',
            'PHU_MAU',
            'PHUC_DUC',
            'DIEN_TRACH',
            'QUAN_LOC',
            'NO_BOC',
            'THIEN_DI',
            'TAT_ACH',
            'TAI_BACH',
            'TU_TUC',
            'PHU_THE',
            'HUYNH_DE'
        ];

        // Start from Mệnh (which is at $menhChiIndex)
        // Then Phụ Mẫu is next Chi, Phúc Đức next... clockwise
        $currentChiPosition = $menhChiIndex; // This is the Chi index where MENH is located

        for ($i = 0; $i < 12; $i++) {
            $houseCode = $houseCodesInOrder[$i]; // The functional house (MENH, PHU_MAU...)
            $branch = self::CHIS[$currentChiPosition]; // The actual branch (Tý, Sửu, Dần...)

            HoroscopeHouse::updateOrCreate(
                ['horoscope_id' => $horoscope->id, 'code' => $houseCode],
                [
                    'label' => $this->getHouseLabel($houseCode),
                    'branch' => $branch,
                    'element' => $this->getChiElement($branch), // Determine element from Branch
                    'house_order' => $i + 1, // 1 to 12
                ]
            );

            // If this is the Than cung, update its status
            if ($currentChiPosition === $thanChiIndex) {
                // TODO: Mark as Thân cư...
            }

            $currentChiPosition = ($currentChiPosition + 1) % 12; // Move to next Chi
        }
    }

    /**
     * Get the descriptive label for a house code.
     */
    protected function getHouseLabel(string $code): string
    {
        return [
            'MENH' => 'Mệnh',
            'PHU_MAU' => 'Phụ Mẫu',
            'PHUC_DUC' => 'Phúc Đức',
            'DIEN_TRACH' => 'Điền Trạch',
            'QUAN_LOC' => 'Quan Lộc',
            'NO_BOC' => 'Nô Bộc',
            'THIEN_DI' => 'Thiên Di',
            'TAT_ACH' => 'Tật Ách',
            'TAI_BACH' => 'Tài Bạch',
            'TU_TUC' => 'Tử Tức',
            'PHU_THE' => 'Phu Thê',
            'HUYNH_DE' => 'Huynh Đệ'
        ][$code] ?? $code;
    }

    /**
     * Determine the element of a Chi (Branch).
     * Needs to lookup from a fixed map (e.g., Tý/Hợi = Thủy, Dần/Mão = Mộc...)
     *
     * @param string $branch
     * @return string
     */
    protected function getChiElement(string $branch): string
    {
        $chiElements = [
            'Tý' => 'Thủy',
            'Hợi' => 'Thủy',
            'Sửu' => 'Thổ',
            'Thìn' => 'Thổ',
            'Mùi' => 'Thổ',
            'Tuất' => 'Thổ',
            'Dần' => 'Mộc',
            'Mão' => 'Mộc',
            'Tỵ' => 'Hỏa',
            'Ngọ' => 'Hỏa',
            'Thân' => 'Kim',
            'Dậu' => 'Kim',
        ];
        return $chiElements[$branch] ?? 'Không xác định';
    }


    /**
     * An 14 Chính Tinh.
     * Needs to calculate location of each star and save to HoroscopeHouseStar.
     *
     * @param Horoscope $horoscope
     * @param int $lunarDay Lunar day of birth
     * @param int $cucNumber The 'Cục' number (2,3,4,5,6)
     * @return void
     */
    protected function anChinhTinh(Horoscope $horoscope, int $lunarDay, int $cucNumber): void
    {
        // Clear existing main stars (if any) to re-an
        $horoscope->houses->each(function($house) {
            $house->stars()->wherePivot('is_main', true)->detach();
        });

        // 1. An Tử Vi
        $tuViChiIndex = $this->calculateTuViPosition($lunarDay, $cucNumber);
        $tuViHouse = $horoscope->houses->firstWhere('branch', self::CHIS[$tuViChiIndex]);
        $starTuVi = Star::where('name', 'Tử Vi')->first();

        if ($starTuVi && $tuViHouse) {
            HoroscopeHouseStar::firstOrCreate(
                ['horoscope_house_id' => $tuViHouse->id, 'star_id' => $starTuVi->id],
                ['status' => 'Miếu', 'is_main' => true] // Default status, should be calculated
            );
        }

        // 2. An Thiên Phủ (opposite to Tử Vi or 3 cung after) - commonly opposite to Tử Vi
        $thienPhuChiIndex = ($tuViChiIndex + 6) % 12; // Đối cung Tử Vi
        $thienPhuHouse = $horoscope->houses->firstWhere('branch', self::CHIS[$thienPhuChiIndex]);
        $starThienPhu = Star::where('name', 'Thiên Phủ')->first();

        if ($starThienPhu && $thienPhuHouse) {
            HoroscopeHouseStar::firstOrCreate(
                ['horoscope_house_id' => $thienPhuHouse->id, 'star_id' => $starThienPhu->id],
                ['status' => 'Miếu', 'is_main' => true] // Default status, should be calculated
            );
        }

        // TODO: An các chính tinh khác dựa trên Tử Vi và Thiên Phủ
        // ...
    }

    /**
     * Calculate the Chi Index for Tử Vi star.
     * Formula depends on Lunar Day and Cuc Number.
     *
     * @param int $lunarDay
     * @param int $cucNumber (2=Thuy, 3=Moc, 4=Kim, 5=Tho, 6=Hoa)
     * @return int Chi Index (0-11)
     */
    protected function calculateTuViPosition(int $lunarDay, int $cucNumber): int
    {
        // This formula is simplified for demonstration.
        // Actual calculation for Tử Vi is complex and depends on the specific
        // table/algorithm used.
        // A common method: (LunarDay - X) mod 12 + Y, where X,Y depend on Cục
        // Let's use a known table-based logic.
        // Example logic:
        // Cục 2 (Thủy): Tử Vi an tại Dần (2) nếu ngày 1.
        // Cục 3 (Mộc): Tử Vi an tại Mão (3) nếu ngày 1.
        // Dựa trên bảng "An Tử Vi, Thiên Phủ"
        // (Ngày Sinh + N + Cục) chia 12, số dư là vị trí (Dần, Tỵ, Thân, Hợi)
        // Or simplified version: (lunarDay - [offset based on Cuc]) % 12
        
        // This is a direct implementation of a common formula:
        // Cung Tử Vi = (Ngày Sinh - Cục) % 12 (kết quả tính từ cung Dần)
        // Nếu Ngày sinh < Cục: Tử Vi an tại Dần (index 2) + (Cục - Ngày sinh) ngược chiều.
        // Nếu Ngày sinh >= Cục: Tử Vi an tại Dần (index 2) + (Ngày sinh - Cục) thuận chiều.
        
        $offset = 0; // The base position of Tử Vi for Day 1.

        if ($lunarDay < $cucNumber) {
            // Count backward from Dần
            $tuViChiIndex = (array_search('Dần', self::CHIS) - ($cucNumber - $lunarDay));
        } else {
            // Count forward from Dần
            $tuViChiIndex = (array_search('Dần', self::CHIS) + ($lunarDay - $cucNumber));
        }

        // Normalize to 0-11
        while ($tuViChiIndex < 0) $tuViChiIndex += 12;
        return $tuViChiIndex % 12;
    }

    /**
     * An Tứ Hóa (Hóa Lộc, Hóa Quyền, Hóa Khoa, Hóa Kỵ)
     * Based on Can Năm sinh. Placeholder for now.
     *
     * @param Horoscope $horoscope
     * @return void
     */
    protected function anTuHoa(Horoscope $horoscope): void
    {
        // Logic to determine Tứ Hóa based on Can Year
        // For example, Giáp: Liêm Trinh Hóa Lộc, Phá Quân Hóa Quyền, Vũ Khúc Hóa Khoa, Thái Dương Hóa Kỵ
    }

    /**
     * An một số Phụ Tinh cơ bản (Lộc Tồn, Kình Đà, Không Kiếp, Xương Khúc, Khôi Việt, Tả Hữu...)
     * Placeholder for now.
     *
     * @param Horoscope $horoscope
     * @return void
     */
    protected function anPhuTinhCoBan(Horoscope $horoscope): void
    {
        // Logic for each basic phụ tinh
    }
}
