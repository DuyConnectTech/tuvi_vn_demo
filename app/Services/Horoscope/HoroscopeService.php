<?php

namespace App\Services\Horoscope;

use App\Models\Horoscope;
use App\Models\HoroscopeHouse;
use App\Models\HoroscopeHouseStar;
use App\Models\HoroscopeMetum;
use App\Models\Star;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class HoroscopeService
{
    protected CalendarService $calendarService;

    const CANS = ['Giáp', 'Ất', 'Bính', 'Đinh', 'Mậu', 'Kỷ', 'Canh', 'Tân', 'Nhâm', 'Quý'];
    const CHIS = ['Tý', 'Sửu', 'Dần', 'Mão', 'Thìn', 'Tỵ', 'Ngọ', 'Mùi', 'Thân', 'Dậu', 'Tuất', 'Hợi'];

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

    protected $energyLevels = [];

    public function __construct(CalendarService $calendarService)
    {
        $this->calendarService = $calendarService;
        $this->loadEnergyLevels();
    }

    protected function loadEnergyLevels()
    {
        $levels = \App\Models\StarEnergyLevel::all();
        foreach ($levels as $level) {
            $this->energyLevels[$level->star_slug][$level->branch_code] = $level->energy_level;
        }
    }

    public function generateHoroscope(Horoscope $horoscope, Carbon $birthGregorian, string $gender, string $timezone): Horoscope
    {
        $lunarDetails = $this->calendarService->getLunarDetails($birthGregorian);
        $canChiYear = $lunarDetails['can_chi_year'];
        $lunarMonth = $lunarDetails['lunar_month'];
        $lunarDay = $lunarDetails['lunar_day'];
        $lunarHour = $lunarDetails['chi_hour_index'];

        $yearCan = Str::before($canChiYear, ' ');
        $yearChi = Str::after($canChiYear, ' ');

        $amDuong = $this->determineAmDuong($yearCan, $gender);

        $horoscope->update([
            'birth_lunar_year' => $lunarDetails['lunar_year'],
            'birth_lunar_month' => $lunarMonth,
            'birth_lunar_day' => $lunarDay,
            'birth_lunar_is_leap' => $lunarDetails['is_leap'],
            'can_chi_year' => $canChiYear,
            'can_chi_month' => $lunarDetails['can_chi_month'],
            'can_chi_day' => $lunarDetails['can_chi_day'],
            'can_chi_hour' => $lunarDetails['can_chi_hour'],
            'am_duong' => $amDuong,
        ]);

        $napAm = $this->determineNapAm($canChiYear);
        $horoscope->update(['nap_am' => $napAm]);

        $cucInfo = $this->determineCuc($lunarMonth, $lunarHour, $yearCan);
        $horoscope->update(['cuc' => $cucInfo['cuc'], 'so_cuc' => $cucInfo['so_cuc']]);

        // An Cung Menh Than, Can Cung, Dai Van
        $this->anCungMenhThan($horoscope, $lunarMonth, $lunarHour, $yearCan, $cucInfo['so_cuc'], $amDuong);

        $menhChiIndex = $this->calculateMenhChiIndex($lunarMonth, $lunarHour);

        $this->anChinhTinh($horoscope, $lunarDay, $cucInfo['so_cuc']);
        $this->anTuHoa($horoscope);
        $this->anPhuTinhCoBan($horoscope, $lunarMonth, $lunarHour, $yearCan, $yearChi);
        $this->anVongThaiTue($horoscope, $yearChi);
        $this->anVongTrangSinh($horoscope, $cucInfo['cuc'], $amDuong);
        $this->anTuanTriet($horoscope, $yearCan, $yearChi);

        $chuMenh = $this->calculateChuMenh($yearChi);
        $chuThan = $this->calculateChuThan($yearChi);
        $laiNhanBranch = $this->calculateLaiNhanCung($yearCan);
        
        $laiNhanHouse = $horoscope->houses->firstWhere('branch', $laiNhanBranch);
        $laiNhanCungCode = $laiNhanHouse ? $laiNhanHouse->code : '---';

        $anThanIndex = (array_search('Dần', self::CHIS) + ($lunarMonth - 1) + $lunarHour) % 12;
        $thanBranch = self::CHIS[$anThanIndex];
        $thanHouse = $horoscope->houses->firstWhere('branch', $thanBranch);
        $thanCungCode = $thanHouse ? $thanHouse->code : '---';

        $menhElement = $this->getElementFromStr($napAm);
        $cucElement = $this->getElementFromStr($cucInfo['cuc']);
        $menhCucComment = $this->getMenhCucComment($menhElement, $cucElement);

        HoroscopeMetum::updateOrCreate(
            ['horoscope_id' => $horoscope->id],
            [
                'chu_menh' => $chuMenh,
                'chu_than' => $chuThan,
                'lai_nhan_cung' => $laiNhanCungCode,
                'than_cung_code' => $thanCungCode,
                'menh_chi_index' => $menhChiIndex,
                'extra' => ['menh_cuc_relation' => $menhCucComment]
            ]
        );
        
        $this->calculateAndStoreBranchRelations($horoscope);

        return $horoscope;
    }

    protected function determineAmDuong(string $yearCan, string $gender): string
    {
        $canIndex = array_search($yearCan, self::CANS);
        $canAmDuong = ($canIndex % 2 == 0) ? 'Dương' : 'Âm';
        return ($gender === 'male') ? ($canAmDuong === 'Dương' ? 'Dương Nam' : 'Âm Nam') : ($canAmDuong === 'Dương' ? 'Dương Nữ' : 'Âm Nữ');
    }

    protected function determineNapAm(string $canChiYear): string
    {
        $lucThap = \App\Models\LucThapHoaGiap::where('can_chi', $canChiYear)->first();
        return $lucThap ? $lucThap->nap_am : 'Không xác định';
    }

    protected function determineCuc(int $lunarMonth, int $lunarHour, string $yearCan): array
    {
        $menhChiIndex = $this->calculateMenhChiIndex($lunarMonth, $lunarHour);
        $menhChi = self::CHIS[$menhChiIndex];
        $canOfMenh = $this->getCanOfChi($yearCan, $menhChiIndex);
        $canChiMenh = $canOfMenh . ' ' . $menhChi;
        $lucThap = \App\Models\LucThapHoaGiap::where('can_chi', $canChiMenh)->first();
        
        if (!$lucThap) return ['cuc' => 'Không xác định', 'so_cuc' => 0];

        $hanhCuc = $lucThap->ngu_hanh;
        $cucMap = [
            'Thủy' => ['cuc' => 'Thủy Nhị Cục', 'so_cuc' => 2],
            'Mộc' => ['cuc' => 'Mộc Tam Cục', 'so_cuc' => 3],
            'Kim' => ['cuc' => 'Kim Tứ Cục', 'so_cuc' => 4],
            'Thổ' => ['cuc' => 'Thổ Ngũ Cục', 'so_cuc' => 5],
            'Hỏa' => ['cuc' => 'Hỏa Lục Cục', 'so_cuc' => 6],
        ];
        return $cucMap[$hanhCuc] ?? ['cuc' => 'Không xác định', 'so_cuc' => 0];
    }

    protected function calculateMenhChiIndex(int $lunarMonth, int $lunarHour): int
    {
        $menhChiIndex = (array_search('Dần', self::CHIS) + ($lunarMonth - 1));
        $menhChiIndex = ($menhChiIndex - $lunarHour);
        while ($menhChiIndex < 0) $menhChiIndex += 12;
        return $menhChiIndex % 12;
    }

    protected function getCanOfChi(string $yearCan, int $chiIndex): string
    {
        $yearCanIndex = array_search($yearCan, self::CANS);
        $canDhanIndex = (($yearCanIndex % 5) * 2 + 2) % 10;
        $steps = $chiIndex - array_search('Dần', self::CHIS); 
        if ($steps < 0) $steps += 12; 
        return self::CANS[($canDhanIndex + $steps) % 10];
    }

    protected function anCungMenhThan(Horoscope $horoscope, int $lunarMonth, int $lunarHour, string $yearCan, int $soCuc, string $amDuong): void
    {
        $anMenhIndex = $this->calculateMenhChiIndex($lunarMonth, $lunarHour);
        $anThanIndex = (array_search('Dần', self::CHIS) + ($lunarMonth - 1) + $lunarHour) % 12;
        $horoscope->houses()->delete();
        $this->initializeHousesWithBranches($horoscope, $anMenhIndex, $anThanIndex, $yearCan, $soCuc, $amDuong);
    }

    protected function initializeHousesWithBranches(Horoscope $horoscope, int $menhChiIndex, int $thanChiIndex, string $yearCan, int $soCuc, string $amDuong)
    {
        $houseCodesInOrder = ['MENH', 'PHU_MAU', 'PHUC_DUC', 'DIEN_TRACH', 'QUAN_LOC', 'NO_BOC', 'THIEN_DI', 'TAT_ACH', 'TAI_BACH', 'TU_TUC', 'PHU_THE', 'HUYNH_DE'];
        
        $direction = match($amDuong) {
            'Dương Nam', 'Âm Nữ' => 1,
            'Âm Nam', 'Dương Nữ' => -1,
            default => 1
        };

        for ($i = 0; $i < 12; $i++) {
            $houseCode = $houseCodesInOrder[$i];
            // Placement: Clockwise
            $chiIndex = ($menhChiIndex + $i) % 12; 
            $branch = self::CHIS[$chiIndex];
            
            // Calculate Can
            $can = $this->getCanOfChi($yearCan, $chiIndex);

            // Calculate Dai Van
            // Steps from Menh (0 to 11 or 0 to -11) based on direction
            // Standard: Dai Van starts at Menh (cuc). Next house (direction) is cuc+10.
            // We need to find "steps" from Menh to current House along Dai Van path.
            // Path depends on direction.
            // If Direction=1 (Thuận): Mệnh->Phụ->Phúc... (Same as House Order).
            // If Direction=-1 (Nghịch): Mệnh->Huynh->Phu... (Reverse of House Order).
            // Current House is at +$i steps from Menh in House Order.
            // If Direction=1, then steps along DaiVan = $i.
            // If Direction=-1, then steps along DaiVan?
            // Mệnh (0). Huynh (11). Phu (10)...
            // Dai Van Nghịch: Mệnh -> Huynh -> Phu...
            // So Huynh is Step 1. Phu is Step 2.
            // Step = (12 - $i) % 12.
            // Ex: i=0 (Menh) -> Step 0.
            // i=11 (Huynh) -> Step 1.
            // i=1 (Phu Mau) -> Step 11.
            
            if ($direction == 1) {
                $daiVanStep = $i;
            } else {
                $daiVanStep = ($i == 0) ? 0 : (12 - $i);
            }
            
            $daiVan = $soCuc + ($daiVanStep * 10);

            HoroscopeHouse::updateOrCreate(
                ['horoscope_id' => $horoscope->id, 'code' => $houseCode],
                [
                    'label' => $this->getHouseLabel($houseCode),
                    'branch' => $branch,
                    'can' => $can,
                    'element' => $this->getChiElement($branch),
                    'house_order' => $i + 1,
                    'dai_van_start_age' => $daiVan,
                ]
            );
        }
    }

    protected function getHouseLabel(string $code): string
    {
        return [
            'MENH' => 'Mệnh', 'PHU_MAU' => 'Phụ Mẫu', 'PHUC_DUC' => 'Phúc Đức', 
            'DIEN_TRACH' => 'Điền Trạch', 'QUAN_LOC' => 'Quan Lộc', 'NO_BOC' => 'Nô Bộc', 
            'THIEN_DI' => 'Thiên Di', 'TAT_ACH' => 'Tật Ách', 'TAI_BACH' => 'Tài Bạch', 
            'TU_TUC' => 'Tử Tức', 'PHU_THE' => 'Phu Thê', 'HUYNH_DE' => 'Huynh Đệ'
        ][$code] ?? $code;
    }

    protected function getChiElement(string $branch): string
    {
        $chiElements = ['Tý' => 'Thủy', 'Hợi' => 'Thủy', 'Sửu' => 'Thổ', 'Thìn' => 'Thổ', 'Mùi' => 'Thổ', 'Tuất' => 'Thổ', 'Dần' => 'Mộc', 'Mão' => 'Mộc', 'Tỵ' => 'Hỏa', 'Ngọ' => 'Hỏa', 'Thân' => 'Kim', 'Dậu' => 'Kim'];
        return $chiElements[$branch] ?? 'Không xác định';
    }

    protected function anChinhTinh(Horoscope $horoscope, int $lunarDay, int $cucNumber): void
    {
        foreach($horoscope->houses as $house) {
             $mainStarIds = $house->stars()->where('stars.is_main', true)->pluck('stars.id');
             if ($mainStarIds->isNotEmpty()) $house->stars()->detach($mainStarIds);
        }
        $mainStars = Star::where('is_main', true)->get()->keyBy('slug');
        $tuViChiIndex = $this->calculateTuViPosition($lunarDay, $cucNumber);
        $this->placeStar($horoscope, $mainStars['tu-vi'] ?? null, $tuViChiIndex, 'chinh_tinh');
        $thienPhuChiIndex = (16 - $tuViChiIndex) % 12;
        $this->placeStar($horoscope, $mainStars['thien-phu'] ?? null, $thienPhuChiIndex, 'chinh_tinh');
        $tuViStarsOffsets = ['thien-co' => -1, 'thai-duong' => -3, 'vu-khuc' => -4, 'thien-dong' => -5, 'liem-trinh' => -8];
        foreach ($tuViStarsOffsets as $slug => $offset) {
            $pos = ($tuViChiIndex + $offset); while ($pos < 0) $pos += 12; $pos %= 12;
            $this->placeStar($horoscope, $mainStars[$slug] ?? null, $pos, 'chinh_tinh');
        }
        $thienPhuStarsOffsets = ['thai-am' => 1, 'tham-lang' => 2, 'cu-mon' => 3, 'thien-tuong' => 4, 'thien-luong' => 5, 'that-sat' => 6, 'pha-quan' => 10];
        foreach ($thienPhuStarsOffsets as $slug => $offset) {
            $pos = ($thienPhuChiIndex + $offset) % 12;
            $this->placeStar($horoscope, $mainStars[$slug] ?? null, $pos, 'chinh_tinh');
        }
    }

    protected function placeStar(Horoscope $horoscope, ?Star $star, int $chiIndex, string $starGroupType = 'phu_tinh')
    {
        if (!$star) return;
        $branch = self::CHIS[$chiIndex];
        $house = $horoscope->houses->firstWhere('branch', $branch);
        if ($house) {
            $status = $this->calculateStatus($star->slug, $branch);
            HoroscopeHouseStar::firstOrCreate(
                ['horoscope_house_id' => $house->id, 'star_id' => $star->id],
                ['status' => $status]
            );
        }
    }

    protected function calculateStatus(string $starSlug, string $branchName): string
    {
        $branchCode = self::BRANCH_MAP[$branchName] ?? null;
        if (!$branchCode) return 'Bình';
        $level = $this->energyLevels[$starSlug][$branchCode] ?? null;
        if (!$level) return 'Bình'; 
        return match($level) { 'M' => 'Miếu', 'V' => 'Vượng', 'D' => 'Đắc', 'B' => 'Bình', 'H' => 'Hãm', default => 'Bình' };
    }

    protected function calculateTuViPosition(int $lunarDay, int $cucNumber): int
    {
        if ($lunarDay < $cucNumber) {
            $tuViChiIndex = (array_search('Dần', self::CHIS) - ($cucNumber - $lunarDay));
        } else {
            $tuViChiIndex = (array_search('Dần', self::CHIS) + ($lunarDay - $cucNumber));
        }
        while ($tuViChiIndex < 0) $tuViChiIndex += 12;
        return $tuViChiIndex % 12;
    }

    protected function anTuHoa(Horoscope $horoscope): void
    {
        $yearCan = Str::before($horoscope->can_chi_year, ' ');
        $starsToTransform = $this->tuHoaMap[$yearCan] ?? null;
        if (!$starsToTransform) return;
        $tuHoaStars = Star::whereIn('slug', ['hoa-loc', 'hoa-quyen', 'hoa-khoa', 'hoa-ky'])->get()->keyBy('slug');
        $suffixes = ['hoa-loc', 'hoa-quyen', 'hoa-khoa', 'hoa-ky'];
        foreach ($starsToTransform as $index => $starSlug) {
            $house = $horoscope->houses()->whereHas('stars', function($q) use ($starSlug) { $q->where('slug', $starSlug); })->first();
            if ($house) {
                $tuHoaSlug = $suffixes[$index];
                $tuHoaStar = $tuHoaStars[$tuHoaSlug] ?? null;
                if ($tuHoaStar) {
                    HoroscopeHouseStar::firstOrCreate(['horoscope_house_id' => $house->id, 'star_id' => $tuHoaStar->id], ['status' => 'Đắc']);
                }
            }
        }
    }

    protected function anPhuTinhCoBan(Horoscope $horoscope, int $lunarMonth, int $lunarHour, string $yearCan, string $yearChi): void
    {
        foreach($horoscope->houses as $house) {
             $auxStarIds = $house->stars()->where('stars.is_main', false)->pluck('stars.id');
             if ($auxStarIds->isNotEmpty()) $house->stars()->detach($auxStarIds);
        }
        $auxStars = Star::where('group_type', 'phu_tinh')->orWhere('group_type', 'sat_tinh')->orWhere('group_type', 'khac')->orWhere('slug', 'loc-ton')->orWhereIn('slug', ['hoa-tinh', 'linh-tinh'])->get()->keyBy('slug');
        
        // Lộc Tồn
        $locTonChiIndex = match($yearCan) {
            'Giáp' => array_search('Dần', self::CHIS), 'Ất' => array_search('Mão', self::CHIS),
            'Bính', 'Mậu' => array_search('Tỵ', self::CHIS), 'Đinh', 'Kỷ' => array_search('Ngọ', self::CHIS),
            'Canh' => array_search('Thân', self::CHIS), 'Tân' => array_search('Dậu', self::CHIS),
            'Nhâm' => array_search('Hợi', self::CHIS), 'Quý' => array_search('Tý', self::CHIS),
            default => -1,
        };
        $this->placeStar($horoscope, $auxStars['loc-ton'] ?? null, $locTonChiIndex, 'cat_tinh');

        // Kình Dương, Đà La
        $this->placeStar($horoscope, $auxStars['kinh-duong'] ?? null, ($locTonChiIndex + 1) % 12, 'sat_tinh');
        $daLaChiIndex = ($locTonChiIndex - 1); while($daLaChiIndex < 0) $daLaChiIndex += 12;
        $this->placeStar($horoscope, $auxStars['da-la'] ?? null, $daLaChiIndex, 'sat_tinh');

        // Văn Xương, Văn Khúc
        $vanXuongChiIndex = (array_search('Thìn', self::CHIS) - $lunarHour); while($vanXuongChiIndex < 0) $vanXuongChiIndex += 12;
        $this->placeStar($horoscope, $auxStars['van-xuong'] ?? null, $vanXuongChiIndex, 'cat_tinh');
        $this->placeStar($horoscope, $auxStars['van-khuc'] ?? null, (array_search('Tỵ', self::CHIS) + $lunarHour) % 12, 'cat_tinh');

        // Thiên Khôi, Thiên Việt
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

        // Tả Phù, Hữu Bật
        $this->placeStar($horoscope, $auxStars['ta-phu'] ?? null, (array_search('Thìn', self::CHIS) + ($lunarMonth - 1)) % 12, 'cat_tinh');
        $huuBatChiIndex = (array_search('Tuất', self::CHIS) - ($lunarMonth - 1)); while($huuBatChiIndex < 0) $huuBatChiIndex += 12;
        $this->placeStar($horoscope, $auxStars['huu-bat'] ?? null, $huuBatChiIndex, 'cat_tinh');

        // Địa Không, Địa Kiếp
        $diaKhongChiIndex = (array_search('Tỵ', self::CHIS) - $lunarHour); while($diaKhongChiIndex < 0) $diaKhongChiIndex += 12;
        $this->placeStar($horoscope, $auxStars['dia-khong'] ?? null, $diaKhongChiIndex, 'sat_tinh');
        $diaKiepChiIndex = (array_search('Hợi', self::CHIS) - $lunarHour); while($diaKiepChiIndex < 0) $diaKiepChiIndex += 12;
        $this->placeStar($horoscope, $auxStars['dia-kiep'] ?? null, $diaKiepChiIndex, 'sat_tinh');

        // Hỏa Tinh, Linh Tinh
        $this->placeStar($horoscope, $auxStars['hoa-tinh'] ?? null, $this->getHoaTinhChiIndex($yearChi, $lunarMonth, $lunarHour), 'sat_tinh');
        $this->placeStar($horoscope, $auxStars['linh-tinh'] ?? null, $this->getLinhTinhChiIndex($yearChi, $lunarMonth, $lunarHour), 'sat_tinh');
        
        // Thiên Mã
        $thienMaIndex = match($yearChi) {
            'Dần', 'Ngọ', 'Tuất' => array_search('Thân', self::CHIS),
            'Thân', 'Tý', 'Thìn' => array_search('Dần', self::CHIS),
            'Tỵ', 'Dậu', 'Sửu' => array_search('Hợi', self::CHIS),
            'Hợi', 'Mão', 'Mùi' => array_search('Tỵ', self::CHIS),
            default => -1
        };
        $this->placeStar($horoscope, $auxStars['thien-ma'] ?? null, $thienMaIndex, 'phu_tinh');
    }

    protected function getHoaTinhChiIndex(string $yearChi, int $lunarMonth, int $lunarHour): int
    {
        $offsetFromTy = match($yearChi) {
            'Dần', 'Ngọ', 'Tuất' => 2, 'Thân', 'Tý', 'Thìn' => 5,
            'Tỵ', 'Dậu', 'Sửu' => 8, 'Hợi', 'Mão', 'Mùi' => 11, default => 0,
        };
        return ($offsetFromTy + ($lunarMonth - 1)) % 12;
    }

    protected function getLinhTinhChiIndex(string $yearChi, int $lunarMonth, int $lunarHour): int
    {
        $offsetFromTy = match($yearChi) {
            'Dần', 'Ngọ', 'Tuất' => 3, 'Thân', 'Tý', 'Thìn' => 6,
            'Tỵ', 'Dậu', 'Sửu' => 9, 'Hợi', 'Mão', 'Mùi' => 0, default => 1,
        };
        return ($offsetFromTy + ($lunarMonth - 1)) % 12;
    }

    protected function anVongThaiTue(Horoscope $horoscope, string $yearChi): void
    {
        $stars = ['thai-tue', 'thieu-duong', 'tang-mon', 'thieu-am', 'quan-phu', 'tu-phu', 'tue-pha', 'long-duc', 'bach-ho', 'phuc-duc', 'dieu-khach', 'truc-phu'];
        $starObjs = Star::whereIn('slug', $stars)->get()->keyBy('slug');
        $startChiIndex = array_search($yearChi, self::CHIS); 
        foreach ($stars as $index => $slug) {
            $this->placeStar($horoscope, $starObjs[$slug] ?? null, ($startChiIndex + $index) % 12, 'phu_tinh');
        }
    }

    protected function anVongTrangSinh(Horoscope $horoscope, string $cucName, string $amDuong): void
    {
        $stars = ['trang-sinh', 'moc-duc', 'quan-doi', 'lam-quan', 'de-vuong', 'suy', 'benh', 'tu', 'mo', 'tuyet', 'thai', 'duong'];
        $starObjs = Star::whereIn('slug', $stars)->get()->keyBy('slug');
        $startIndex = match(true) {
            str_contains($cucName, 'Thủy') || str_contains($cucName, 'Thổ') => array_search('Thân', self::CHIS),
            str_contains($cucName, 'Mộc') => array_search('Hợi', self::CHIS),
            str_contains($cucName, 'Kim') => array_search('Tỵ', self::CHIS),
            str_contains($cucName, 'Hỏa') => array_search('Dần', self::CHIS),
            default => 0
        };
        $direction = match($amDuong) { 'Dương Nam', 'Âm Nữ' => 1, 'Âm Nam', 'Dương Nữ' => -1, default => 1 };

        foreach ($stars as $index => $slug) {
            $pos = ($startIndex + ($index * $direction));
            while ($pos < 0) $pos += 12;
            $this->placeStar($horoscope, $starObjs[$slug] ?? null, $pos % 12, 'phu_tinh');
        }
    }

    protected function anTuanTriet(Horoscope $horoscope, string $yearCan, string $yearChi): void
    {
        $tuan = Star::where('slug', 'tuan')->first();
        $triet = Star::where('slug', 'triet')->first();
        if (!$tuan && !$triet) return;

        $trietChiIndices = match($yearCan) {
            'Giáp', 'Kỷ' => [array_search('Thân', self::CHIS), array_search('Dậu', self::CHIS)],
            'Ất', 'Canh' => [array_search('Ngọ', self::CHIS), array_search('Mùi', self::CHIS)],
            'Bính', 'Tân' => [array_search('Thìn', self::CHIS), array_search('Tỵ', self::CHIS)],
            'Đinh', 'Nhâm' => [array_search('Dần', self::CHIS), array_search('Mão', self::CHIS)],
            'Mậu', 'Quý' => [array_search('Tý', self::CHIS), array_search('Sửu', self::CHIS)],
            default => []
        };
        foreach ($trietChiIndices as $index) $this->placeStar($horoscope, $triet, $index, 'phu_tinh');

        $canIndex = array_search($yearCan, self::CANS);
        $chiIndex = array_search($yearChi, self::CHIS);
        $diff = $chiIndex - $canIndex;
        if ($diff < 0) $diff += 12;
        
        $tuan1 = ($diff + 10) % 12;
        $tuan2 = ($diff + 11) % 12;
        
        $this->placeStar($horoscope, $tuan, $tuan1, 'phu_tinh');
        $this->placeStar($horoscope, $tuan, $tuan2, 'phu_tinh');
    }

    protected function calculateChuMenh(string $yearChi): string
    {
        return match($yearChi) {
            'Tý' => 'Tham Lang', 'Sửu', 'Hợi' => 'Cự Môn', 'Dần', 'Tuất' => 'Lộc Tồn',
            'Mão', 'Dậu' => 'Văn Khúc', 'Thìn', 'Thân' => 'Liêm Trinh', 'Tỵ', 'Mùi' => 'Vũ Khúc', 'Ngọ' => 'Phá Quân', default => '---'
        };
    }

    protected function calculateChuThan(string $yearChi): string
    {
        return match($yearChi) {
            'Tý', 'Ngọ' => 'Hỏa Tinh', 'Sửu', 'Mùi' => 'Thiên Tướng', 'Dần', 'Thân' => 'Thiên Lương',
            'Mão', 'Dậu' => 'Thiên Đồng', 'Thìn', 'Tuất' => 'Văn Xương', 'Tỵ', 'Hợi' => 'Thiên Cơ', default => '---'
        };
    }

    protected function calculateLaiNhanCung(string $yearCan): string
    {
        $targetChiIndex = -1;
        for ($i = 0; $i < 12; $i++) {
            if ($this->getCanOfChi($yearCan, $i) === $yearCan) {
                $targetChiIndex = $i;
                break;
            }
        }
        return ($targetChiIndex !== -1) ? self::CHIS[$targetChiIndex] : '---';
    }

    protected function calculateAndStoreBranchRelations(Horoscope $horoscope): void
    {
        $allRelations = \App\Models\BranchRelation::all()->groupBy('from_house_code');
        foreach ($horoscope->houses as $house) {
            $currentBranch = $house->branch;
            $relationsForThisHouse = [];
            $normalizedBranch = Str::slug($currentBranch, '');
            if (isset($allRelations[$normalizedBranch])) {
                foreach ($allRelations[$normalizedBranch] as $relation) {
                    $relationsForThisHouse[] = [
                        'type' => $relation->relation_type,
                        'to_branch_code' => $relation->to_house_code,
                        'description' => $relation->description,
                    ];
                }
            }
            $house->relations = $relationsForThisHouse;
            $house->save();
        }
    }

    protected function getElementFromStr($str) {
        $parts = explode(' ', trim($str));
        return end($parts);
    }

    protected function getMenhCucComment($menhHan, $cucHan) {
        $relations = [
            'Kim' => ['Kim'=>'bình hòa', 'Thủy'=>'sinh xuất', 'Mộc'=>'khắc xuất', 'Hỏa'=>'khắc nhập', 'Thổ'=>'sinh nhập'],
            'Mộc' => ['Mộc'=>'bình hòa', 'Hỏa'=>'sinh xuất', 'Thổ'=>'khắc xuất', 'Kim'=>'khắc nhập', 'Thủy'=>'sinh nhập'],
            'Thủy' => ['Thủy'=>'bình hòa', 'Mộc'=>'sinh xuất', 'Hỏa'=>'khắc xuất', 'Thổ'=>'khắc nhập', 'Kim'=>'sinh nhập'],
            'Hỏa' => ['Hỏa'=>'bình hòa', 'Thổ'=>'sinh xuất', 'Kim'=>'khắc xuất', 'Thủy'=>'khắc nhập', 'Mộc'=>'sinh nhập'],
            'Thổ' => ['Thổ'=>'bình hòa', 'Kim'=>'sinh xuất', 'Thủy'=>'khắc xuất', 'Mộc'=>'khắc nhập', 'Hỏa'=>'sinh nhập'],
        ];
        
        $rel = $relations[$menhHan][$cucHan] ?? '';
        return "Cục $cucHan Mệnh $menhHan $rel";
    }
}
