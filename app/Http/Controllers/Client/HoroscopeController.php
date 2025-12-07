<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Horoscope\StoreHoroscopeRequest; // Re-use or create new request
use App\Models\Horoscope;
use App\Services\Horoscope\HoroscopeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HoroscopeController extends Controller
{
    protected HoroscopeService $horoscopeService;

    public function __construct(HoroscopeService $horoscopeService)
    {
        $this->horoscopeService = $horoscopeService;
    }

    /**
     * Show the form for creating a new horoscope (Home page).
     */
    public function create(): View
    {
        return view('client.index');
    }

    /**
     * Store a newly created horoscope in storage.
     */
    public function store(StoreHoroscopeRequest $request): RedirectResponse
    {
        $data = $request->validated();
        
        // Combine date and time with timezone
        $timezone = $data['timezone'] ?? 'Asia/Ho_Chi_Minh';
        $birthGregorian = Carbon::createFromFormat('Y-m-d H:i', $data['birth_date'] . ' ' . $data['birth_time'], $timezone);
        
        // Generate slug
        $slug = Str::slug($data['name']) . '-' . $birthGregorian->format('YmdHi') . '-' . Str::random(4); // Random to avoid collision
        
        $horoscope = Horoscope::create([
            'user_id' => Auth::id(), // Null if guest
            'slug' => $slug,
            'name' => $data['name'],
            'gender' => $data['gender'],
            'birth_gregorian' => $birthGregorian,
            'timezone' => $timezone,
            'view_year' => now()->year,
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

    /**
     * Display the specified horoscope chart.
     *
     * @param string $slug
     * @return View
     */
    public function show(string $slug): View
    {
        // Eager load everything needed for the chart view
        $horoscope = Horoscope::with([
            'houses.stars', // Stars in houses
            'meta',         // Meta info (Chu Menh, Chu Than...)
        ])->where('slug', $slug)->firstOrFail();

        $housesByBranch = $horoscope->houses->keyBy('branch');

        return view('client.horoscopes.show', compact('horoscope', 'housesByBranch'));
    }
}
