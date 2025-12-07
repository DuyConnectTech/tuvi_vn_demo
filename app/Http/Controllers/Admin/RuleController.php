<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Rule\StoreRuleRequest;
use App\Http\Requests\Admin\Rule\UpdateRuleRequest;
use App\Models\HoroscopeHouse;
use App\Models\Rule;
use App\Models\RuleCondition;
use App\Models\Star;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $rules = Rule::latest()->paginate(20);
        return view('admin.rules.index', compact('rules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.rules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRuleRequest $request): RedirectResponse
    {
        // Tạo Rule
        $rule = Rule::create($request->validated());

        return redirect()->route('admin.rules.edit', $rule)
            ->with('success', 'Luật giải đã được tạo. Vui lòng thêm điều kiện cho luật này.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rule $rule)
    {
        return redirect()->route('admin.rules.edit', $rule);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rule $rule): View
    {
        // Eager load conditions
        $rule->load('conditions');

        // Data for dynamic form
        $allStars = Star::select('id', 'name')->orderBy('name')->get();
        $allHouses = [
            'MENH', 'PHU_MAU', 'PHUC_DUC', 'DIEN_TRACH', 'QUAN_LOC', 'NO_BOC',
            'THIEN_DI', 'TAT_ACH', 'TAI_BACH', 'TU_TUC', 'PHU_THE', 'HUYNH_DE'
        ]; // Hardcoded for now, can be dynamically loaded from HoroscopeHouse model later

        $conditionTypes = [
            'has_star' => 'Có sao',
            'has_not_star' => 'Không có sao',
            'has_any_star' => 'Có ít nhất 1 trong các sao',
            'has_not_any_star' => 'Không có sao nào trong số',
            'has_star_pair' => 'Có cặp sao',
            'has_not_star_pair' => 'Không có cặp sao',
            'can_chi_year' => 'Can Chi năm',
            'can_chi_month' => 'Can Chi tháng',
            'can_chi_day' => 'Can Chi ngày',
            'can_chi_hour' => 'Can Chi giờ',
            'house_element' => 'Ngũ hành cung',
            'house_life_phase' => 'Vòng trường sinh',
            'nap_am' => 'Nạp âm',
            'am_duong' => 'Âm Dương',
            'cuc' => 'Cục',
            'age_at_view' => 'Tuổi hiện tại',
            'custom' => 'Tùy chỉnh (JSON)',
        ];

        $operators = [
            '=' => 'Bằng',
            '!=' => 'Không bằng',
            '>' => 'Lớn hơn',
            '<' => 'Nhỏ hơn',
            '>=' => 'Lớn hơn hoặc bằng',
            '<=' => 'Nhỏ hơn hoặc bằng',
            'IN' => 'Trong danh sách',
            'NOT_IN' => 'Không trong danh sách',
            'CONTAINS' => 'Chứa chuỗi',
            'NOT_CONTAINS' => 'Không chứa chuỗi',
            'IS_EMPTY' => 'Rỗng',
            'IS_NOT_EMPTY' => 'Không rỗng',
            'EXISTS' => 'Tồn tại (JSON)',
            'NOT_EXISTS' => 'Không tồn tại (JSON)',
        ];

        return view('admin.rules.edit', compact(
            'rule',
            'allStars',
            'allHouses',
            'conditionTypes',
            'operators'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRuleRequest $request, Rule $rule): RedirectResponse
    {
        $validatedData = $request->validated();
        
        // Update basic rule information
        $rule->update($validatedData);

        // Handle Rule Conditions
        $rule->conditions()->delete(); // Clear existing conditions
        if (isset($validatedData['conditions'])) {
            $conditionsData = collect($validatedData['conditions'])->map(function ($condition) {
                // Ensure 'value' is stored as JSON string if it's an array
                if (is_array($condition['value'] ?? null)) {
                    $condition['value'] = json_encode($condition['value']);
                }
                return $condition;
            });
            $rule->conditions()->createMany($conditionsData->toArray());
        }

        return redirect()->route('admin.rules.edit', $rule)
            ->with('success', 'Cập nhật luật giải và điều kiện thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rule $rule): RedirectResponse
    {
        $rule->delete(); // Cascade delete conditions nếu đã cấu hình trong DB/Model
        // Nếu chưa, cần xóa tay: $rule->conditions()->delete();

        return redirect()->route('admin.rules.index')
            ->with('success', 'Đã xóa luật giải.');
    }
}
