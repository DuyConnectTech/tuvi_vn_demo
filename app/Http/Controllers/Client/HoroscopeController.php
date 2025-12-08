<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Horoscope\StoreHoroscopeRequest;
use App\Models\Horoscope;
use App\Services\Horoscope\HoroscopeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HoroscopeController extends Controller
{
    protected HoroscopeService $horoscopeService;

    public function __construct(HoroscopeService $horoscopeService)
    {
        $this->horoscopeService = $horoscopeService;
    }

    public function create(): View
    {
        return view('client.index'); // Changed from welcome to index as per user context
    }

    public function store(StoreHoroscopeRequest $request): RedirectResponse
    {
        $data = $request->validated();
        
        $timezone = $data['timezone'] ?? 'Asia/Ho_Chi_Minh';
        
        try {
            // Explicitly create Carbon instance from split fields
            $birthGregorian = Carbon::create(
                $data['year'],
                $data['month'],
                $data['day'],
                $data['hour'],
                $data['minute'],
                0,
                $timezone
            );
        } catch (\Exception $e) {
            return back()->withErrors(['dob' => 'Ngày giờ sinh không hợp lệ.']);
        }
        
        // Debug Logging
        try {
            $lunarDetails = $this->horoscopeService->getCalendarService()->getLunarDetails($birthGregorian);
            Log::info('Horoscope Generation Debug:', [
                'input_solar' => $birthGregorian->format('Y-m-d H:i:s P'),
                'lunar_output' => $lunarDetails,
                'view_year' => $data['view_year'],
                'gender' => $data['gender']
            ]);
        } catch (\Exception $e) {
            Log::error('Horoscope Debug Error: ' . $e->getMessage());
        }

        // Generate slug
        $slug = Str::slug($data['name']) . '-' . $birthGregorian->format('YmdHi') . '-' . Str::random(4);
        
        $horoscope = Horoscope::create([
            'user_id' => auth()->id(),
            'slug' => $slug,
            'name' => $data['name'],
            'gender' => $data['gender'],
            'birth_gregorian' => $birthGregorian,
            'timezone' => $timezone,
            'view_year' => $data['view_year'],
            'view_month' => $data['view_month'] ?? null,
        ]);

        // Generate Horoscope Data
        $this->horoscopeService->generateHoroscope(
            $horoscope,
            $birthGregorian,
            $data['gender'],
            $timezone
        );

        return redirect()->route('client.horoscopes.show', $slug);
    }

    public function show(string $slug): View
    {
        $horoscope = Horoscope::with([
            'houses.stars',
            'meta',
            'readings'
        ])->where('slug', $slug)->firstOrFail();

        $housesByBranch = $horoscope->houses->keyBy('branch');

        return view('client.horoscopes.show', compact('horoscope', 'housesByBranch'));
    }

    public function myIndex()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $horoscopes = auth()->user()->horoscopes()->latest()->paginate(10);
        return view('client.horoscopes.my_index', compact('horoscopes'));
    }
}