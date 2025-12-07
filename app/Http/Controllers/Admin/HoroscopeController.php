<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Horoscope\StoreHoroscopeRequest;
use App\Http\Requests\Admin\Horoscope\UpdateHoroscopeRequest;
use App\Models\Horoscope;
use App\Models\HoroscopeHouse;
use App\Models\Star;
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
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $horoscopes = Horoscope::latest()->paginate(20);
        return view('admin.horoscopes.index', compact('horoscopes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.horoscopes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHoroscopeRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Combine date and time with timezone
        $timezone = $data['timezone'] ?? 'Asia/Ho_Chi_Minh';
        $birthGregorian = Carbon::createFromFormat('Y-m-d H:i', $data['birth_date'] . ' ' . $data['birth_time'], $timezone);

        // Generate slug
        $slug = Str::slug($data['name']) . '-' . $birthGregorian->format('YmdHi');

        $horoscope = Horoscope::create([
            'user_id' => Auth::id(),
            'slug' => $slug,
            'name' => $data['name'],
            'gender' => $data['gender'],
            'birth_gregorian' => $birthGregorian,
            'timezone' => $timezone,
            'view_year' => now()->year,
        ]);

        // Use Service to Generate Horoscope
        $this->horoscopeService->generateHoroscope(
            $horoscope,
            $birthGregorian,
            $data['gender'],
            $timezone
        );

        return redirect()->route('admin.horoscopes.edit', $horoscope)
            ->with('success', 'Lá số mới đã được tạo và an sao tự động.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Horoscope $horoscope)
    {
        return redirect()->route('admin.horoscopes.edit', $horoscope);
    }

    /**
     * Show the form for editing the specified resource.
     */
        public function edit(Horoscope $horoscope): View
        {
            $horoscope->load(['houses.stars', 'meta', 'tags']);
            $allStars = Star::orderBy('name')->get();
            $allTags = \App\Models\Tag::all();
            
            return view('admin.horoscopes.edit', compact('horoscope', 'allStars', 'allTags'));
        }
    /**
     * Update the specified resource in storage.
     */
        public function update(UpdateHoroscopeRequest $request, Horoscope $horoscope): RedirectResponse
        {
            $data = $request->validated();
            
            // Combine date and time with timezone
            $timezone = $data['timezone'] ?? 'Asia/Ho_Chi_Minh';
            $birthGregorian = Carbon::createFromFormat('Y-m-d H:i', $data['birth_date'] . ' ' . $data['birth_time'], $timezone);
            
            $horoscope->update([
                'name' => $data['name'],
                'gender' => $data['gender'],
                'birth_gregorian' => $birthGregorian,
                'timezone' => $timezone,
                'description' => $data['description'] ?? null,
                'is_public' => $request->boolean('is_public'),
            ]);
    
            // Sync Tags
            if (isset($data['tags'])) {
                $horoscope->tags()->sync($data['tags']);
            } else {
                $horoscope->tags()->detach();
            }
    
            // Re-generate Horoscope on update        $this->horoscopeService->generateHoroscope(
            $horoscope,
            $birthGregorian,
            $data['gender'],
            $timezone
        );

        return redirect()->route('admin.horoscopes.index')
            ->with('success', 'Cập nhật thông tin lá số và tính toán lại thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Horoscope $horoscope): RedirectResponse
    {
        $horoscope->delete();
        return redirect()->route('admin.horoscopes.index')
            ->with('success', 'Đã xóa lá số.');
    }
}