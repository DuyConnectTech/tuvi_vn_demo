<?php

namespace App\Console\Commands;

use App\Models\Horoscope;
use App\Services\Horoscope\HoroscopeService;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DebugHoroscope extends Command
{
    protected $signature = 'horoscope:debug {datetime} {gender=male}';
    protected $description = 'Debug Horoscope Calculation';

    public function handle(HoroscopeService $service)
    {
        $datetime = $this->argument('datetime');
        $gender = $this->argument('gender');
        
        $birthDate = Carbon::createFromFormat('Y-m-d H:i', $datetime, 'Asia/Ho_Chi_Minh');
        
        $this->info("Input: " . $birthDate->format('Y-m-d H:i'));
        $this->info("Gender: " . $gender);

        // Create temp horoscope
        $horoscope = new Horoscope();
        $horoscope->name = 'Debug User';
        $horoscope->slug = 'debug-user-' . time(); // Unique slug
        $horoscope->gender = $gender;
        $horoscope->birth_gregorian = $birthDate;
        $horoscope->timezone = 'Asia/Ho_Chi_Minh';
        $horoscope->save();

        // Generate
        $service->generateHoroscope($horoscope, $birthDate, $gender, 'Asia/Ho_Chi_Minh');
        
        // Load data
        $horoscope->load('houses.stars', 'meta');

        $this->info("========================================");
        $this->info("Can Chi: " . $horoscope->can_chi_year . " | " . $horoscope->can_chi_month . " | " . $horoscope->can_chi_day . " | " . $horoscope->can_chi_hour);
        $this->info("Am Duong: " . $horoscope->am_duong);
        $this->info("Menh: " . $horoscope->nap_am . " | Cuc: " . $horoscope->cuc);
        $this->info("Chu Menh: " . $horoscope->meta->chu_menh . " | Chu Than: " . $horoscope->meta->chu_than);
        $this->info("Lai Nhan: " . $horoscope->meta->lai_nhan_cung);
        
        $this->info("================== HOUSES ======================");
        foreach ($horoscope->houses->sortBy('house_order') as $house) {
            $this->info("[$house->house_order] $house->label ($house->can $house->branch) - $house->element");
            
            $stars = $house->stars->map(function($s) {
                $status = $s->pivot->status != 'Bình' ? "({$s->pivot->status})" : "";
                return $s->name . $status;
            })->implode(', ');
            
            $this->line("   Stars: " . $stars);
            $this->line("   Dai Van: " . $house->dai_van_start_age);
            $this->line("------------------------------------------------");
        }

        // Cleanup
        // $horoscope->delete(); 
    }
}
