<?php

namespace App\Services\Horoscope;

use App\Models\Horoscope;
use App\Models\HoroscopeHouse;
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
        $horoscope->update(['cuc' => $cucInfo['cuc']]);

        // 3. An Mệnh, Thân, Thập nhị cung (12 Cung địa bàn và chức năng)
        $this->anCungMenhThan($horoscope, $lunarMonth, $lunarHour);

        // 4. An Sao (The most complex part)
        $this->anChinhTinh($horoscope); // 14 Chính Tinh
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
     * Needs lunar month, lunar day, and year Can.
     * This is a complex calculation. Placeholder for now.
     *
     * @param int $lunarMonth
     * @param int $lunarDay
     * @param string $yearCan
     * @return array ['cuc' => string, 'so_cuc' => int]
     */
    protected function determineCuc(int $lunarMonth, int $lunarDay, string $yearCan): array
    {
        // This is a simplified placeholder. Actual Cục calculation is intricate.
        // It depends on Can Chi of the year and the position of the Mệnh cung.
        // For now, let's return a dummy value.
        return [
            'cuc' => 'Thủy Nhị Cục', // Dummy value
            'so_cuc' => 2,
        ];
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
        // Địa chi Tý (index 0)
        $tyIndex = 0; // Tý is always the starting point for counting
        
        // An Cung Mệnh
        // Từ cung Dần, thuận chiều an tháng sinh
        // Từ cung Tý, nghịch chiều an giờ sinh
        // Điểm dừng là cung Mệnh.
        // Simplified: Assume Mệnh start at Dần for month, then count.
        // For now, let's hardcode for simplicity of testing.
        // If lunarMonth=1, lunarHour=1, Mệnh is at Dần.
        // Mệnh = (Dần + (tháng - 1)) - (giờ - 1).
        // Let's implement actual rule:
        // Start counting from Dần (index 2 in CHIS) for month
        $menhStartChiIndex = array_search('Dần', self::CHIS); // Index of Dần is 2

        // Count month: Thuận chiều
        $menhCountMonthIndex = ($menhStartChiIndex + ($lunarMonth - 1)) % 12;

        // Count hour: Nghịch chiều từ Tý
        $menhCountHourIndex = (array_search('Tý', self::CHIS) - ($lunarHour - 1));
        if ($menhCountHourIndex < 0) $menhCountHourIndex += 12;
        $menhCountHourIndex %= 12;

        // An Cung Thân
        // Thân cư Phúc Đức, Quan Lộc, Thiên Di, Phu Thê, Tài Bạch, Thiên Di (tùy theo Can Năm sinh).
        // Simplified: For now, assume Mệnh = Thân
        $thanChiIndex = $menhCountMonthIndex; // Mệnh và Thân cùng cung.

        // Initialize 12 houses if not already done (should be done on Horoscope create)
        $horoscope->houses()->delete(); // Clear old houses
        $this->initializeHouses($horoscope);

        $chiPosition = [
            'Tý', 'Sửu', 'Dần', 'Mão', 'Thìn', 'Tỵ',
            'Ngọ', 'Mùi', 'Thân', 'Dậu', 'Tuất', 'Hợi'
        ];

        // Mệnh is at the Menh Chi Index
        $menhChi = self::CHIS[$menhCountMonthIndex]; // This is wrong, formula should resolve to Chi Index
        // Let's use simplified logic:
        // Cung Mệnh: Từ Dần (index 2) đếm thuận tháng sinh. Từ Tý (index 0) đếm nghịch giờ sinh.
        // VD: Tháng 1, Giờ Tý -> Mệnh tại Dần. (2 + 1-1) = 2. (0 - 0) = 0.
        // The common formula is:
        // Menh Chi: Dần starts at index 2 (counting from Tý=0).
        // Menh Chi Index = (2 + (lunarMonth - 1) - (lunarHour - 1)) % 12;
        // This is not standard.
        // Let's use a standard simplified way:
        // Start from Dần for month, then Tý for hour.
        // Month start at Dan = 2
        // Hour start at Ty = 0
        $anMenhIndex = (2 + ($lunarMonth - 1) - ($lunarHour - 1)); // Dần is CHIS[2]
        if ($anMenhIndex < 0) $anMenhIndex += 12; // Handle negative index
        $anMenhIndex %= 12; // Final index in CHIS array

        // An Thân cung
        // Typically Thân follows Mệnh depending on Can year
        // For simplicity: Thân cư Mệnh
        $anThanIndex = $anMenhIndex;


        // Update houses with their branches and roles
        $houseCodes = ['MENH', 'PHU_MAU', 'PHUC_DUC', 'DIEN_TRACH', 'QUAN_LOC', 'NO_BOC', 
                       'THIEN_DI', 'TAT_ACH', 'TAI_BACH', 'TU_TUC', 'PHU_THE', 'HUYNH_DE'];

        // Map CHIS (Tý->Hợi) to house codes
        $chiToHouseCodeMap = [];
        // Assuming Mệnh is at CHIS[$anMenhIndex]
        $startHouseIndex = array_search('MENH', $houseCodes); // Index of MENH in the fixed order of house codes
        
        $currentChiIndex = $anMenhIndex; // The branch where MENH is located
        for ($i = 0; $i < 12; $i++) {
            $houseCode = $houseCodes[($startHouseIndex + $i) % 12];
            $chi = self::CHIS[$currentChiIndex];
            $chiToHouseCodeMap[$chi] = $houseCode;
            
            // Move to next Chi (clockwise)
            $currentChiIndex = ($currentChiIndex + 1) % 12;
        }

        foreach ($horoscope->houses as $house) {
            $currentHouseChi = array_search($house->code, $chiToHouseCodeMap); // Find branch for this house code
            if ($currentHouseChi === false) { // No, need to re-map. This logic is complicated.
                // Let's simplify and make $horoscope->houses have the branch directly
                // This means the initializeHouses() needs to take branches
                // Or, use the fixed $chiPosition array and rotate it.

                // For testing:
                // Mệnh at Ngọ (index 6)
                // Phụ Mẫu at Mùi (index 7) ...
                // This is defined in SampleHoroscopeSeeder.
                // I need to use this to update branches.

                // Re-initialize all houses with proper branch assignment (based on $anMenhIndex)
                $horoscope->houses()->delete();
                $menhChiIndex = $anMenhIndex; // The Chi where Menh is
                $this->initializeHousesWithBranches($horoscope, $menhChiIndex, $anThanIndex);
                break; // Re-init, so break and rely on fresh data
            }
        }
    }

    /**
     * Helper to initialize 12 houses with branches
     */
    protected function initializeHousesWithBranches(Horoscope $horoscope, int $menhChiIndex, int $thanChiIndex)
    {
        $houseCodesInOrder = ['MENH', 'PHU_MAU', 'PHUC_DUC', 'DIEN_TRACH', 'QUAN_LOC', 'NO_BOC', 
                              'THIEN_DI', 'TAT_ACH', 'TAI_BACH', 'TU_TUC', 'PHU_THE', 'HUYNH_DE'];

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
            'MENH' => 'Mệnh', 'PHU_MAU' => 'Phụ Mẫu', 'PHUC_DUC' => 'Phúc Đức', 
            'DIEN_TRACH' => 'Điền Trạch', 'QUAN_LOC' => 'Quan Lộc', 'NO_BOC' => 'Nô Bộc', 
            'THIEN_DI' => 'Thiên Di', 'TAT_ACH' => 'Tật Ách', 'TAI_BACH' => 'Tài Bạch', 
            'TU_TUC' => 'Tử Tức', 'PHU_THE' => 'Phu Thê', 'HUYNH_DE' => 'Huynh Đệ'
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
            'Tý' => 'Thủy', 'Hợi' => 'Thủy',
            'Sửu' => 'Thổ', 'Thìn' => 'Thổ', 'Mùi' => 'Thổ', 'Tuất' => 'Thổ',
            'Dần' => 'Mộc', 'Mão' => 'Mộc',
            'Tỵ' => 'Hỏa', 'Ngọ' => 'Hỏa',
            'Thân' => 'Kim', 'Dậu' => 'Kim',
        ];
        return $chiElements[$branch] ?? 'Không xác định';
    }


    /**
     * An 14 Chính Tinh.
     * Needs to calculate location of each star and save to HoroscopeHouseStar.
     * This will be a big method with many sub-calculations. Placeholder for now.
     *
     * @param Horoscope $horoscope
     * @return void
     */
    protected function anChinhTinh(Horoscope $horoscope): void
    {
        // For example: Tử Vi an tại cung nào dựa trên Cục và Tháng sinh
        // Lấy Cục từ horoscope->cuc (hoặc so_cuc)
        // $cuc = $horoscope->so_cuc;
        // $lunarMonth = $horoscope->birth_lunar_month;

        // Placeholder: Add a dummy star for testing
        $star = Star::where('name', 'Tử Vi')->first();
        if ($star) {
            $menhHouse = $horoscope->houses->firstWhere('code', 'MENH');
            if ($menhHouse) {
                // Attach star to the house
                // Check if already exists to avoid duplicate
                HoroscopeHouseStar::firstOrCreate(
                    ['horoscope_house_id' => $menhHouse->id, 'star_id' => $star->id],
                    ['status' => 'Miếu', 'is_main' => true]
                );
            }
        }
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
