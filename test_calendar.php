<?php

require __DIR__ . '/vendor/autoload.php';

use App\Services\Horoscope\CalendarService;
use Carbon\Carbon;

try {
    $service = new CalendarService();
    $solarDate = Carbon::create(2024, 2, 10, 12, 0, 0); // Giáp Thìn, Bính Dần, Giáp Thìn, Canh Ngọ
    
    $lunar = $service->toLunar($solarDate);
    echo "JDN: " . $lunar->jdn . "\n";
    
    $lunarDetails = $service->getLunarDetails($solarDate);
    
    echo "Solar: " . $solarDate->toDateTimeString() . "\n";
    echo "Lunar: " . $lunarDetails['lunar_day'] . '/' . $lunarDetails['lunar_month'] . '/' . $lunarDetails['lunar_year'] . "\n";
    echo "Can Chi Nam: " . $lunarDetails['can_chi_year'] . "\n";
    echo "Can Chi Thang: " . $lunarDetails['can_chi_month'] . "\n";
    echo "Can Chi Ngay: " . $lunarDetails['can_chi_day'] . "\n";
    echo "Can Chi Gio: " . $lunarDetails['can_chi_hour'] . "\n";

} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}