<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Horoscope;
use App\Models\Rule;
use App\Models\Star;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'users_count' => User::count(),
            'stars_count' => Star::count(),
            'horoscopes_count' => Horoscope::count(),
            'rules_count' => Rule::count(),
        ];

        return view('admin.index', $stats);
    }
}