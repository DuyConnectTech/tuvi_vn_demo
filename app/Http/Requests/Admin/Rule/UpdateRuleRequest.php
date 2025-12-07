<?php

namespace App\Http\Requests\Admin\Rule;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule as ValidationRule; // Alias Rule to avoid conflict with App\Models\Rule

class UpdateRuleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $ruleId = $this->route('rule') ? $this->route('rule')->id : null;

        return [
            'code' => ['required', 'string', 'max:100', ValidationRule::unique('rules', 'code')->ignore($ruleId)],
            'scope' => ['required', 'string', ValidationRule::in(['house', 'global', 'period'])],
            'target_house' => ['nullable', 'string', 'max:50'],
            'priority' => ['nullable', 'integer', 'min:0'],
            'text_template' => ['required', 'string'],
            'is_active' => ['boolean'],

            // Validation for conditions
            'conditions' => ['nullable', 'array'],
            'conditions.*.type' => ['required', 'string', ValidationRule::in([
                'has_star', 'has_not_star', 'has_any_star', 'has_not_any_star', // Sao
                'has_star_pair', 'has_not_star_pair', // Cặp sao
                'can_chi_year', 'can_chi_month', 'can_chi_day', 'can_chi_hour', // Can Chi
                'house_element', 'house_life_phase', // Cung
                'nap_am', 'am_duong', 'cuc', // Mệnh
                'age_at_view', // Vận hạn
                'custom', // Tùy chỉnh (dùng cho các trường hợp phức tạp cần code tay)
            ])],
            'conditions.*.field' => ['required', 'string', 'max:100'],
            'conditions.*.operator' => ['required', 'string', ValidationRule::in([
                '=', '!=', '>', '<', '>=', '<=', // Toán tử số học
                'IN', 'NOT_IN', // Chứa trong mảng
                'CONTAINS', 'NOT_CONTAINS', // Chuỗi chứa
                'IS_EMPTY', 'IS_NOT_EMPTY', // Kiểm tra rỗng
                'EXISTS', 'NOT_EXISTS', // Kiểm tra tồn tại (cho JSON)
            ])],
            'conditions.*.value' => ['nullable'], // Có thể là string, array, number... Validate dựa vào type/operator
            'conditions.*.or_group' => ['nullable', 'integer', 'min:1'],
            'conditions.*.house_code' => ['nullable', 'string', 'max:50'], // House code nếu condition apply cho một cung cụ thể khác target_house của Rule
        ];
    }

    public function messages(): array
    {
        return [
            'conditions.*.type.required' => 'Loại điều kiện không được để trống.',
            'conditions.*.type.in' => 'Loại điều kiện không hợp lệ.',
            'conditions.*.field.required' => 'Trường áp dụng điều kiện không được để trống.',
            'conditions.*.operator.required' => 'Toán tử không được để trống.',
            'conditions.*.operator.in' => 'Toán tử không hợp lệ.',
            // 'conditions.*.value.required' => 'Giá trị điều kiện không được để trống.',
        ];
    }
}
