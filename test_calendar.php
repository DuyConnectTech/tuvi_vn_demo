<?php

require __DIR__ . '/vendor/autoload.php';

use App\Services\Horoscope\CalendarService;
use Carbon\Carbon;

try {
    $service = new CalendarService();
    // 12:30 VN
    $solarDate = Carbon::create(2000, 1, 1, 12, 30, 0, 'Asia/Ho_Chi_Minh');
    
    $lunar = $service->toLunar($solarDate);
    
    echo "Solar: " . $solarDate->format('Y-m-d H:i:s P') . "\n";
    echo "Lunar Date: " . $lunar->format('d/m/Y H:i:s P') . "\n";
    echo "Lunar Hour Property: " . $lunar->hour . "\n";
    
    $lunarDetails = $service->getLunarDetails($solarDate);
    echo "Chi Hour Index: " . $lunarDetails['chi_hour_index'] . "\n";
    echo "Can Chi Gio: " . $lunarDetails['can_chi_hour'] . "\n";

} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

