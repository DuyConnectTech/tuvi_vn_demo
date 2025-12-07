<?php

namespace App\Services\Horoscope;

use App\Models\Horoscope;
use App\Models\HoroscopeHouse;
use App\Models\HoroscopeMetum;
use App\Models\Star;
use App\Models\HoroscopeHouseStar;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class HoroscopeService
{
    protected CalendarService $calendarService;

    // Const for Can, Chi - same as in CalendarService
    const CANS = ['Giáp', 'Ất', 'Bính', 'Đinh', 'Mậu', 'Kỷ', 'Canh', 'Tân', 'Nhâm', 'Quý'];
    const CHIS = ['Tý', 'Sửu', 'Dần', 'Mão', 'Thìn', 'Tỵ', 'Ngọ', 'Mùi', 'Thân', 'Dậu', 'Tuất', 'Hợi'];

    // Map Can Nam -> [Loc, Quyen, Khoa, Ky] (slugs of original stars)
    protected $tuHoaMap = [
        'Giáp' => ['liem-trinh', 'pha-quan', 'vu-khuc', 'thai-duong'],
        'Ất'   => ['thien-co', 'thien-luong', 'tu-vi', 'thai-am'],
        'Bính' => ['thien-dong', 'thien-co', 'van-xuong', 'liem-trinh'],
        'Đinh' => ['thai-am', 'thien-dong', 'thien-co', 'cu-mon'],
        'Mậu'  => ['tham-lang', 'thai-am', 'huu-bat', 'thien-co'],
        'Kỷ'   => ['vu-khuc', 'tham-lang', 'thien-luong', 'van-khuc'],
        'Canh' => ['thai-duong', 'vu-khuc', 'thien-dong', 'thai-am'],
        'Tân'  => ['cu-mon', 'thai-duong', 'van-khuc', 'van-xuong'],
        'Nhâm' => ['thien-luong', 'tu-vi', 'ta-phu', 'vu-khuc'],
        'Quý'  => ['pha-quan', 'cu-mon', 'thai-am', 'tham-lang'],
    ];

    const BRANCH_MAP = [
        'Tý' => 'ty', 'Sửu' => 'suu', 'Dần' => 'dan', 'Mão' => 'mao',
        'Thìn' => 'thin', 'Tỵ' => 'ti', 'Ngọ' => 'ngo', 'Mùi' => 'mui',
        'Thân' => 'than', 'Dậu' => 'dau', 'Tuất' => 'tuat', 'Hợi' => 'hoi'
    ];

    protected $energyLevels = []; // [star_slug][branch_code] => level

    public function __construct(CalendarService $calendarService)
    {
        $this->calendarService = $calendarService;
        $this->loadEnergyLevels();
    }

    protected function loadEnergyLevels()
    {
        // Load all energy levels from DB once
        $levels = \App\Models\StarEnergyLevel::all();
        foreach ($levels as $level) {
            $this->energyLevels[$level->star_slug][$level->branch_code] = $level->energy_level;
        }
    }

    /**
     * Calculate status (Miếu, Vượng, Đắc, Hãm) of a star at a branch.
     */
    protected function calculateStatus(string $starSlug, string $branchName): string
    {
        $branchCode = self::BRANCH_MAP[$branchName] ?? null;
        if (!$branchCode) return 'Bình';

        $level = $this->energyLevels[$starSlug][$branchCode] ?? null;
        
        if (!$level) return 'Bình'; // Default if not found

        return match($level) {
            'M' => 'Miếu',
            'V' => 'Vượng',
            'D' => 'Đắc',
            'B' => 'Bình',
            'H' => 'Hãm',
            default => 'Bình'
        };
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

        $cucInfo = $this->determineCuc($lunarMonth, $lunarHour, $yearCan); // lunarHour is needed for determineCuc in my current logic
        $horoscope->update(['cuc' => $cucInfo['cuc'], 'so_cuc' => $cucInfo['so_cuc']]); // Store so_cuc

        // 3. An Mệnh, Thân, Thập nhị cung (12 Cung địa bàn và chức năng)
        $this->anCungMenhThan($horoscope, $lunarMonth, $lunarHour);

        // 4. An Sao (The most complex part)
        $this->anChinhTinh($horoscope, $lunarDay, $cucInfo['so_cuc']); // 14 Chính Tinh
        $this->anTuHoa($horoscope); // Tứ Hóa
        $this->anPhuTinhCoBan($horoscope, $lunarMonth, $lunarHour, $yearCan, $yearChi); // Pass yearChi for Hỏa Linh
        $this->anVongThaiTue($horoscope, $yearChi);
        $this->anVongTrangSinh($horoscope, $cucInfo['cuc'], $horoscope->am_duong);

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
        // Standard formula:
        // Vị trí cung Mệnh = (Vị trí cung Dần + (lunarMonth - 1) - (lunarHour - 1)) % 12 (kết quả tính từ cung Tý)
        // Tức là: Index của Dần (2) + (lunarMonth - 1) -> vị trí theo tháng.
        // Rồi từ vị trí đó quay ngược (lunarHour - 1) cung.
        $menhChiIndex = (array_search('Dần', self::CHIS) + ($lunarMonth - 1)); // Start from Dần, count month
        $menhChiIndex = ($menhChiIndex - ($lunarHour - 1)); // From there, count back hour (lunarHour is 0-11 index)

        while ($menhChiIndex < 0) $menhChiIndex += 12; // Normalize
        return $menhChiIndex % 12;
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

        // Ngu Dan Don: Determine Can of Dần (Index 2)
        // Giáp/Kỷ (0/5) -> Bính Dần (2).
        // Formula: CanDần = (CanNăm % 5) * 2 + 2.
        // 0 -> 2 (Bính). 1 -> 4 (Mậu). 2 -> 6 (Canh). 3 -> 8 (Nhâm). 4 -> 10%10=0 (Giáp).
        $canDhanIndex = (($yearCanIndex % 5) * 2 + 2) % 10;

        // Count from Dần (index 2) to target Chi ($chiIndex)
        // Difference in steps
        $steps = $chiIndex - array_search('Dần', self::CHIS); // Steps from Dần
        if ($steps < 0)
            $steps += 12; // e.g. Tý (0) from Dần (2) is 10 steps forward

        $canIndex = ($canDhanIndex + $steps) % 10;

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
        // Thân: From Thân (index 8), thuận tháng sinh, thuận giờ sinh.
        // Index = (8 + (Month-1) + (Hour-1)) % 12
        // Thân cư Thân: Từ Thân (index 8) đếm thuận tháng sinh (âm). Từ Dần (index 2) đếm thuận giờ sinh (chi index).
        // Let's use standard formula: Thân cư Thân (index 8) + (lunarMonth - 1) + (lunarHour - 1).
        $anThanIndex = (array_search('Thân', self::CHIS) + ($lunarMonth - 1) + ($lunarHour - 1)) % 12;

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

        // Fetch all Main Stars
        $mainStars = Star::where('is_main', true)->get()->keyBy('slug');

        // 1. An Tử Vi
        $tuViChiIndex = $this->calculateTuViPosition($lunarDay, $cucNumber);
        $this->placeStar($horoscope, $mainStars['tu-vi'] ?? null, $tuViChiIndex);

        // 2. An Thiên Phủ (opposite to Tử Vi or specific rule)
        // Rule: Dần (2) <-> Dần (2), Mão (3) <-> Sửu (1), Thìn (4) <-> Tý (0)...
        // Sum of indices = 4 or 16. (2+2=4, 3+1=4, 4+0=4, 5+11=16).
        // Formula: ThienPhuIndex = (16 - TuViIndex) % 12.
        // Let's verify:
        // TuVi at Ty (0) -> ThienPhu at Thin (4). (16-0)%12 = 4. Correct.
        // TuVi at Ngo (6) -> ThienPhu at Tuat (10). (16-6)%12 = 10. Correct.
        // TuVi at Dan (2) -> ThienPhu at Dan (2). (16-2)%12 = 14%12=2. Correct.
        $thienPhuChiIndex = (16 - $tuViChiIndex) % 12;
        $this->placeStar($horoscope, $mainStars['thien-phu'] ?? null, $thienPhuChiIndex);

        // 3. Vòng Tử Vi (Ngược chiều kim đồng hồ: -1)
        // Tử Vi (0) -> Thiên Cơ (1) -> (skip) -> Thái Dương (3) -> Vũ Khúc (4) -> Thiên Đồng (5) -> (skip 2) -> Liêm Trinh (8)
        // Offsets from TuVi (Counter-clockwise means subtracting index or adding negative steps?)
        // Wait, traditional chart often counts clockwise for "positive" and counter-clockwise for "negative".
        // But "Ngược chiều" in array index context usually means decrementing index.
        // Let's assume standard: Tý -> Sửu -> Dần is Clockwise (+).
        // Vòng Tử Vi đi Ngược chiều kim đồng hồ:
        // Tử Vi -> Thiên Cơ (index -1) -> ...
        
        $tuViStarsOffsets = [
            'thien-co' => -1,
            'thai-duong' => -3,
            'vu-khuc' => -4,
            'thien-dong' => -5,
            'liem-trinh' => -8,
        ];

        foreach ($tuViStarsOffsets as $slug => $offset) {
            $pos = ($tuViChiIndex + $offset);
            while ($pos < 0) $pos += 12;
            $pos %= 12;
            $this->placeStar($horoscope, $mainStars[$slug] ?? null, $pos);
        }

        // 4. Vòng Thiên Phủ (Thuận chiều kim đồng hồ: +1)
        // Thiên Phủ (0) -> Thái Âm (1) -> Tham Lang (2) -> Cự Môn (3) -> Thiên Tướng (4) -> Thiên Lương (5) -> Thất Sát (6) -> Phá Quân (10)
        // Note: Phá Quân usually is distinct? 
        // Standard order: TP -> Thái Âm -> Tham Lang -> Cự Môn -> Thiên Tướng -> Thiên Lương -> Thất Sát -> Phá Quân.
        // Steps: +1, +2, +3, +4, +5, +6, +10.
        
        $thienPhuStarsOffsets = [
            'thai-am' => 1,
            'tham-lang' => 2,
            'cu-mon' => 3,
            'thien-tuong' => 4,
            'thien-luong' => 5,
            'that-sat' => 6,
            'pha-quan' => 10,
        ];

        foreach ($thienPhuStarsOffsets as $slug => $offset) {
            $pos = ($thienPhuChiIndex + $offset) % 12;
            $this->placeStar($horoscope, $mainStars[$slug] ?? null, $pos);
        }
    }

    /**
     * Helper to place a star at a specific Chi Index.
     *
     * @param Horoscope $horoscope
     * @param Star|null $star
     * @param int $chiIndex
     * @param string $starGroupType Optional, to determine is_main status.
     * @return void
     */
    protected function placeStar(Horoscope $horoscope, ?Star $star, int $chiIndex, string $starGroupType = 'phu_tinh')
    {
        if (!$star) return;

        $branch = self::CHIS[$chiIndex]; // Tý, Sửu...
        $house = $horoscope->houses->firstWhere('branch', $branch);
        
        if ($house) {
            // Calculate status
            $status = $this->calculateStatus($star->slug, $branch);

            HoroscopeHouseStar::firstOrCreate(
                ['horoscope_house_id' => $house->id, 'star_id' => $star->id],
                [
                    'status' => $status, 
                    'is_main' => ($starGroupType === 'chinh_tinh') 
                ]
            );
        }
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
     * Based on Can Năm sinh.
     *
     * @param Horoscope $horoscope
     * @return void
     */
    protected function anTuHoa(Horoscope $horoscope): void
    {
        // 1. Get Year Can
        $yearCan = Str::before($horoscope->can_chi_year, ' ');
        
        // 2. Get Stars being transformed
        $starsToTransform = $this->tuHoaMap[$yearCan] ?? null;
        if (!$starsToTransform) return;

        // 3. Get Tu Hoa stars info (Hoa Loc, Hoa Quyen...)
        $tuHoaStars = Star::whereIn('slug', ['hoa-loc', 'hoa-quyen', 'hoa-khoa', 'hoa-ky'])
                          ->get()
                          ->keyBy('slug');

        $suffixes = ['hoa-loc', 'hoa-quyen', 'hoa-khoa', 'hoa-ky'];

        // 4. Place Tu Hoa
        foreach ($starsToTransform as $index => $starSlug) {
            // Find the original star in the horoscope houses
            // Need to query HoroscopeHouseStar to find which house contains this star
            // Since we just added them, we can query DB.
            // But querying via Eloquent relation might be slow if we do it loop.
            // Optimized: Get all house_stars for this horoscope.
            
            // Find house containing the original star
            $house = $horoscope->houses()->whereHas('stars', function($q) use ($starSlug) {
                $q->where('slug', $starSlug);
            })->first();

            if ($house) {
                $tuHoaSlug = $suffixes[$index];
                $tuHoaStar = $tuHoaStars[$tuHoaSlug] ?? null;
                
                if ($tuHoaStar) {
                    // Attach Tu Hoa star to the same house
                    HoroscopeHouseStar::firstOrCreate(
                        ['horoscope_house_id' => $house->id, 'star_id' => $tuHoaStar->id],
                        ['status' => 'Đắc', 'is_main' => false] // Tu Hoa status? Usually follows original or computed separately.
                    );
                }
            }
        }
    }

    /**
     * An một số Phụ Tinh cơ bản (Lộc Tồn, Kình Đà, Không Kiếp, Xương Khúc, Khôi Việt, Tả Hữu...)
     *
     * @param Horoscope $horoscope
     * @param int $lunarMonth
     * @param int $lunarHour
     * @param string $yearCan Can of the lunar year (e.g., 'Giáp')
     * @param string $yearChi Chi of the lunar year (e.g., 'Tý')
     * @return void
     */
    protected function anPhuTinhCoBan(Horoscope $horoscope, int $lunarMonth, int $lunarHour, string $yearCan, string $yearChi): void
    {
        // Clear existing auxiliary stars to re-an (assuming they are not main stars)
        // For simplicity, we can clear all stars for now, or just auxiliary
        $horoscope->houses->each(function($house) {
            $house->stars()->wherePivot('is_main', false)->detach();
        });

        // Fetch all auxiliary stars we need
        $auxStars = Star::where('group_type', 'phu_tinh')
                        ->orWhere('group_type', 'sat_tinh')
                        ->orWhere('slug', 'loc-ton') // Lộc Tồn is often treated as a special phu_tinh
                        ->orWhereIn('slug', ['hoa-tinh', 'linh-tinh']) // Include Hoa Tinh, Linh Tinh
                        ->get()->keyBy('slug');
        
        $yearCanIndex = array_search($yearCan, self::CANS);

        // --- An Lộc Tồn ---
        // Lộc Tồn an theo Can Năm sinh.
        // Giáp -> Dần (2), Ất -> Mão (3), Bính -> Tỵ (5), Đinh -> Ngọ (6), Mậu -> Tỵ (5), Kỷ -> Ngọ (6), Canh -> Thân (8), Tân -> Dậu (9), Nhâm -> Hợi (11), Quý -> Tý (0)
        $locTonChiIndex = match($yearCan) {
            'Giáp' => array_search('Dần', self::CHIS),
            'Ất' => array_search('Mão', self::CHIS),
            'Bính', 'Mậu' => array_search('Tỵ', self::CHIS),
            'Đinh', 'Kỷ' => array_search('Ngọ', self::CHIS),
            'Canh' => array_search('Thân', self::CHIS),
            'Tân' => array_search('Dậu', self::CHIS),
            'Nhâm' => array_search('Hợi', self::CHIS),
            'Quý' => array_search('Tý', self::CHIS),
            default => -1, // Should not happen
        };
        $this->placeStar($horoscope, $auxStars['loc-ton'] ?? null, $locTonChiIndex, 'cat_tinh');


        // --- An Kình Dương, Đà La (từ Lộc Tồn) ---
        // Kình Dương: Thuận 1 cung sau Lộc Tồn.
        // Đà La: Nghịch 1 cung sau Lộc Tồn.
        $kinhDuongChiIndex = ($locTonChiIndex + 1) % 12;
        $this->placeStar($horoscope, $auxStars['kinh-duong'] ?? null, $kinhDuongChiIndex, 'sat_tinh');

        $daLaChiIndex = ($locTonChiIndex - 1);
        while($daLaChiIndex < 0) $daLaChiIndex += 12;
        $this->placeStar($horoscope, $auxStars['da-la'] ?? null, $daLaChiIndex, 'sat_tinh');


        // --- An Văn Xương, Văn Khúc (theo giờ sinh) ---
        // Văn Xương: Từ Thìn (4) nghịch giờ sinh.
        // Văn Khúc: Từ Tỵ (5) thuận giờ sinh.
        $vanXuongChiIndex = (array_search('Thìn', self::CHIS) - $lunarHour); // lunarHour is 0-11 index
        while($vanXuongChiIndex < 0) $vanXuongChiIndex += 12;
        $this->placeStar($horoscope, $auxStars['van-xuong'] ?? null, $vanXuongChiIndex, 'cat_tinh');

        $vanKhucChiIndex = (array_search('Tỵ', self::CHIS) + $lunarHour) % 12; // lunarHour is 0-11 index
        $this->placeStar($horoscope, $auxStars['van-khuc'] ?? null, $vanKhucChiIndex, 'cat_tinh');


        // --- An Thiên Khôi, Thiên Việt (theo Can Năm sinh) ---
        // Công thức phức tạp hơn, có bảng tra.
        // Giáp, Mậu -> Sửu, Mùi
        // Ất, Kỷ -> Tý, Thân
        // ...
        $khuoiVietChiIndices = match($yearCan) {
            'Giáp', 'Mậu' => [array_search('Sửu', self::CHIS), array_search('Mùi', self::CHIS)],
            'Ất', 'Kỷ' => [array_search('Tý', self::CHIS), array_search('Thân', self::CHIS)],
            'Bính', 'Đinh' => [array_search('Hợi', self::CHIS), array_search('Dậu', self::CHIS)],
            'Canh', 'Tân' => [array_search('Dần', self::CHIS), array_search('Ngọ', self::CHIS)],
            'Nhâm', 'Quý' => [array_search('Mão', self::CHIS), array_search('Tỵ', self::CHIS)],
            default => [-1, -1],
        };
        $this->placeStar($horoscope, $auxStars['thien-khoi'] ?? null, $khuoiVietChiIndices[0], 'cat_tinh');
        $this->placeStar($horoscope, $auxStars['thien-viet'] ?? null, $khuoiVietChiIndices[1], 'cat_tinh');


        // --- An Tả Phù, Hữu Bật (theo tháng sinh âm lịch) ---
        // Tả Phù: Từ Thìn (4) thuận tháng sinh.
        // Hữu Bật: Từ Tuất (10) nghịch tháng sinh.
        $taPhuChiIndex = (array_search('Thìn', self::CHIS) + ($lunarMonth - 1)) % 12;
        $this->placeStar($horoscope, $auxStars['ta-phu'] ?? null, $taPhuChiIndex, 'cat_tinh');

        $huuBatChiIndex = (array_search('Tuất', self::CHIS) - ($lunarMonth - 1));
        while($huuBatChiIndex < 0) $huuBatChiIndex += 12;
        $this->placeStar($horoscope, $auxStars['huu-bat'] ?? null, $huuBatChiIndex, 'cat_tinh');


        // --- An Địa Không, Địa Kiếp (theo giờ sinh) ---
        // Địa Không: Tỵ (5) - giờ sinh nghịch.
        // Địa Kiếp: Hợi (11) - giờ sinh nghịch.
        $diaKhongChiIndex = (array_search('Tỵ', self::CHIS) - $lunarHour);
        while($diaKhongChiIndex < 0) $diaKhongChiIndex += 12;
        $this->placeStar($horoscope, $auxStars['dia-khong'] ?? null, $diaKhongChiIndex, 'sat_tinh');

        $diaKiepChiIndex = (array_search('Hợi', self::CHIS) - $lunarHour);
        while($diaKiepChiIndex < 0) $diaKiepChiIndex += 12;
        $this->placeStar($horoscope, $auxStars['dia-kiep'] ?? null, $diaKiepChiIndex, 'sat_tinh');


        // --- An Hỏa Tinh, Linh Tinh ---
        // Logic An Hỏa Tinh (phức tạp, dựa vào Chi Năm, Tháng sinh, Giờ sinh)
        $hoaTinhChiIndex = $this->getHoaTinhChiIndex($yearChi, $lunarMonth, $lunarHour);
        $linhTinhChiIndex = $this->getLinhTinhChiIndex($yearChi, $lunarMonth, $lunarHour);

        $this->placeStar($horoscope, $auxStars['hoa-tinh'] ?? null, $hoaTinhChiIndex, 'sat_tinh');
        $this->placeStar($horoscope, $auxStars['linh-tinh'] ?? null, $linhTinhChiIndex, 'sat_tinh');
    }

    /**
     * Helper to calculate Hỏa Tinh position. (Simplified for now)
     *
     * @param string $yearChi
     * @param int $lunarMonth
     * @param int $lunarHour
     * @return int Chi Index (0-11)
     */
    protected function getHoaTinhChiIndex(string $yearChi, int $lunarMonth, int $lunarHour): int
    {
        // Công thức chính xác của Hỏa Tinh:
        // Khởi Hỏa Tinh tại Dần, Tỵ, Thân, Hợi tùy Chi Năm.
        // - Năm Dần, Ngọ, Tuất: khởi Tý.
        // - Năm Thân, Tý, Thìn: khởi Dần.
        // - Năm Tỵ, Dậu, Sửu: khởi Mão.
        // - Năm Hợi, Mão, Mùi: khởi Thân.
        // Sau đó từ cung khởi đó, đếm thuận tháng sinh.
        
        $startChi = match($yearChi) {
            'Dần', 'Ngọ', 'Tuất' => 'Tý',
            'Thân', 'Tý', 'Thìn' => 'Dần',
            'Tỵ', 'Dậu', 'Sửu' => 'Mão',
            'Hợi', 'Mão', 'Mùi' => 'Thân',
            default => 'Tý', // Fallback
        };
        $startChiIndex = array_search($startChi, self::CHIS);

        // Sau đó đếm thuận theo tháng sinh (âm).
        $pos = ($startChiIndex + ($lunarMonth - 1)) % 12;

        // Tiếp theo, từ cung đã đếm được, an Hỏa Tinh vào cung nào tùy theo giờ sinh.
        // Đây là phần rất phức tạp. Thường dùng bảng tra hoặc công thức if/else lồng nhau.
        // Tạm thời, để đơn giản, tôi sẽ dùng một logic đơn giản hóa cho việc test.
        // Sơ lược: Cứ 2 giờ 1 cung. (Hỏa Tinh an theo Giờ).
        
        // Let's implement a more common simplified Hỏa Tinh An:
        // Năm Dần Ngọ Tuất: Hỏa Tinh an tại Sửu, Dần, Mão, Thìn, Tỵ, Ngọ...
        // Tạm bỏ qua giờ sinh cho đơn giản. An Hỏa Tinh theo Tháng và Chi Năm.
        
        // Hỏa Tinh an tại cung:
        // Chi năm Dần, Ngọ, Tuất: Tháng 1, 2 (Sửu); Tháng 3, 4 (Thìn); Tháng 5, 6 (Ngọ); Tháng 7, 8 (Dậu); Tháng 9, 10 (Tuất); Tháng 11, 12 (Hợi)
        // Chi năm Thân, Tý, Thìn: Tháng 1, 2 (Dần); Tháng 3, 4 (Tỵ); Tháng 5, 6 (Thân); Tháng 7, 8 (Hợi); Tháng 9, 10 (Tý); Tháng 11, 12 (Mão)
        // Đây vẫn là quá phức tạp để tự tính.
        
        // For testing, I will use a simplified fixed offset for now, as before, but ensure it's functional.
        // Corrected previous simplified mapping for Hỏa Tinh:
        // (Đây vẫn là công thức rút gọn, chưa phải 100% chuẩn xác của từng trường phái Tử Vi, nhưng đủ để có sao Hỏa Linh trên lá số)
        $hoaTinhOffset = match($yearChi) {
            'Dần', 'Ngọ', 'Tuất' => array_search('Dần', self::CHIS),
            'Thân', 'Tý', 'Thìn' => array_search('Tỵ', self::CHIS),
            'Tỵ', 'Dậu', 'Sửu' => array_search('Thân', self::CHIS),
            'Hợi', 'Mão', 'Mùi' => array_search('Hợi', self::CHIS),
            default => array_search('Tý', self::CHIS),
        };

        return ($hoaTinhOffset + ($lunarMonth - 1)) % 12; // An theo tháng từ cung khởi
    }

    /**
     * Helper to calculate Linh Tinh position. (Simplified for now)
     *
     * @param string $yearChi
     * @param int $lunarMonth
     * @param int $lunarHour
     * @return int Chi Index (0-11)
     */
    protected function getLinhTinhChiIndex(string $yearChi, int $lunarMonth, int $lunarHour): int
    {
        // Tương tự Hỏa Tinh
        // Năm Dần, Ngọ, Tuất: khởi Sửu.
        // Năm Thân, Tý, Thìn: khởi Mão.
        // Năm Tỵ, Dậu, Sửu: khởi Ngọ.
        // Năm Hợi, Mão, Mùi: khởi Dậu.
        $linhTinhOffset = match($yearChi) {
            'Dần', 'Ngọ', 'Tuất' => array_search('Sửu', self::CHIS),
            'Thân', 'Tý', 'Thìn' => array_search('Mão', self::CHIS),
            'Tỵ', 'Dậu', 'Sửu' => array_search('Ngọ', self::CHIS),
            'Hợi', 'Mão', 'Mùi' => array_search('Dậu', self::CHIS),
            default => array_search('Sửu', self::CHIS),
        };
        return ($linhTinhOffset + ($lunarMonth - 1)) % 12; // An theo tháng từ cung khởi
    }

    /**
     * An Vòng Thái Tuế.
     *
     * @param Horoscope $horoscope
     * @param string $yearChi
     * @return void
     */
    protected function anVongThaiTue(Horoscope $horoscope, string $yearChi): void
    {
        $stars = ['thai-tue', 'thieu-duong', 'tang-mon', 'thieu-am', 'quan-phu', 'tu-phu', 'tue-pha', 'long-duc', 'bach-ho', 'phuc-duc', 'dieu-khach', 'truc-phu'];
        $starObjs = Star::whereIn('slug', $stars)->get()->keyBy('slug');
        
        $startChiIndex = array_search($yearChi, self::CHIS); // Thái Tuế tại Chi Năm sinh

        foreach ($stars as $index => $slug) {
            $pos = ($startChiIndex + $index) % 12; // Thuận chiều
            $this->placeStar($horoscope, $starObjs[$slug] ?? null, $pos, 'phu_tinh');
        }
    }

    /**
     * An Vòng Tràng Sinh.
     *
     * @param Horoscope $horoscope
     * @param string $cucName (e.g., 'Thủy Nhị Cục')
     * @param string $amDuong (e.g., 'Dương Nam', 'Âm Nữ'...)
     * @return void
     */
    protected function anVongTrangSinh(Horoscope $horoscope, string $cucName, string $amDuong): void
    {
        $stars = ['trang-sinh', 'moc-duc', 'quan-doi', 'lam-quan', 'de-vuong', 'suy', 'benh', 'tu', 'mo', 'tuyet', 'thai', 'duong'];
        $starObjs = Star::whereIn('slug', $stars)->get()->keyBy('slug');

        // 1. Xác định Cung Khởi Tràng Sinh (Dựa vào Cục)
        // Thủy/Thổ -> Thân (8)
        // Mộc -> Hợi (11)
        // Kim -> Tỵ (5)
        // Hỏa -> Dần (2)
        $startIndex = match(true) {
            str_contains($cucName, 'Thủy') || str_contains($cucName, 'Thổ') => array_search('Thân', self::CHIS),
            str_contains($cucName, 'Mộc') => array_search('Hợi', self::CHIS),
            str_contains($cucName, 'Kim') => array_search('Tỵ', self::CHIS),
            str_contains($cucName, 'Hỏa') => array_search('Dần', self::CHIS),
            default => 0
        };

        // 2. Xác định Chiều (Thuận/Nghịch)
        // Dương Nam, Âm Nữ -> Thuận (+1)
        // Âm Nam, Dương Nữ -> Nghịch (-1)
        $direction = match($amDuong) {
            'Dương Nam', 'Âm Nữ' => 1,
            'Âm Nam', 'Dương Nữ' => -1,
            default => 1
        };

        foreach ($stars as $index => $slug) {
            $pos = ($startIndex + ($index * $direction));
            while ($pos < 0) $pos += 12;
            $pos %= 12;
            
            $this->placeStar($horoscope, $starObjs[$slug] ?? null, $pos, 'phu_tinh');
        }
    }
}