<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HoroscopeHouse;
use App\Models\HoroscopeHouseStar;
use App\Models\Star;
use Illuminate\Http\Request;

class HoroscopeHouseStarController extends Controller
{
    public function store(Request $request, HoroscopeHouse $horoscopeHouse)
    {
        $request->validate([
            'star_id' => 'required|exists:stars,id',
            'status' => 'nullable|string',
        ]);

        // Check duplicate
        if ($horoscopeHouse->stars()->where('star_id', $request->star_id)->exists()) {
            return response()->json(['message' => 'Sao này đã có trong cung.'], 422);
        }

        $star = Star::find($request->star_id);
        
        // Add star
        $horoscopeHouse->stars()->attach($star->id, [
            'status' => $request->status ?? 'Bình', // Default status
            'created_at' => now(), 
            'updated_at' => now()
        ]);

        return response()->json([
            'message' => 'Đã thêm sao thành công.',
            'star_name' => $star->name,
            'is_main' => $star->is_main,
        ]);
    }

    public function destroy(HoroscopeHouse $horoscopeHouse, Star $star)
    {
        $horoscopeHouse->stars()->detach($star->id);
        return response()->json(['message' => 'Đã xóa sao khỏi cung.']);
    }
}
