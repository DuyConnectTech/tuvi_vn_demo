<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Horoscope\StoreHoroscopeRequest;
use App\Http\Requests\Admin\Horoscope\UpdateHoroscopeRequest;
use App\Models\Horoscope;
use App\Models\HoroscopeHouse;
use App\Models\Star;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HoroscopeController extends Controller
{
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
        
        // Combine date and time
        $birthGregorian = Carbon::parse($data['birth_date'] . ' ' . $data['birth_time']);
        
        // Generate slug
        $slug = Str::slug($data['name']) . '-' . $birthGregorian->format('YmdHi');
        
        $horoscope = Horoscope::create([
            'user_id' => auth()->id(), // Assign to current admin temporarily or null
            'slug' => $slug,
            'name' => $data['name'],
            'gender' => $data['gender'],
            'birth_gregorian' => $birthGregorian,
            'timezone' => $data['timezone'] ?? 'Asia/Ho_Chi_Minh',
            'view_year' => now()->year,
        ]);

        // Auto-initialize 12 Houses (Empty)
        $this->initializeHouses($horoscope);

        return redirect()->route('admin.horoscopes.edit', $horoscope)
            ->with('success', 'Lá số mới đã được tạo. Vui lòng thiết lập sao.');
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
        $horoscope->load(['houses.stars', 'meta']);
        $allStars = Star::orderBy('name')->get();
        
        return view('admin.horoscopes.edit', compact('horoscope', 'allStars'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHoroscopeRequest $request, Horoscope $horoscope): RedirectResponse
    {
        $data = $request->validated();
        
        // Combine date and time
        $birthGregorian = Carbon::parse($data['birth_date'] . ' ' . $data['birth_time']);
        
        $horoscope->update([
            'name' => $data['name'],
            'gender' => $data['gender'],
            'birth_gregorian' => $birthGregorian,
            'timezone' => $data['timezone'] ?? 'Asia/Ho_Chi_Minh',
        ]);

        return redirect()->route('admin.horoscopes.index')
            ->with('success', 'Cập nhật thông tin lá số thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Horoscope $horoscope): RedirectResponse
    {
        $horoscope->delete(); // Cascade delete houses/stars handled by DB or manual cleanup?
        // Should rely on DB cascade foreign keys ideally.
        
        return redirect()->route('admin.horoscopes.index')
            ->with('success', 'Đã xóa lá số.');
    }

    /**
     * Helper to initialize 12 houses
     */
    protected function initializeHouses(Horoscope $horoscope)
    {
        $houses = [
            'MENH' => 'Mệnh', 'PHU_MAU' => 'Phụ Mẫu', 'PHUC_DUC' => 'Phúc Đức', 
            'DIEN_TRACH' => 'Điền Trạch', 'QUAN_LOC' => 'Quan Lộc', 'NO_BOC' => 'Nô Bộc', 
            'THIEN_DI' => 'Thiên Di', 'TAT_ACH' => 'Tật Ách', 'TAI_BACH' => 'Tài Bạch', 
            'TU_TUC' => 'Tử Tức', 'PHU_THE' => 'Phu Thê', 'HUYNH_DE' => 'Huynh Đệ'
        ];

        $order = 1;
        foreach ($houses as $code => $label) {
            HoroscopeHouse::create([
                'horoscope_id' => $horoscope->id,
                'code' => $code,
                'label' => $label,
                'house_order' => $order++,
                // 'branch' => ... need calculation logic, leave null for manual set
            ]);
        }
    }
}
