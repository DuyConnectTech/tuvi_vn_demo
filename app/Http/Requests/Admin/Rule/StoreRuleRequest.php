<?php

namespace App\Http\Requests\Admin\Rule;

use Illuminate\Foundation\Http\FormRequest;

class StoreRuleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:100', 'unique:rules,code'],
            'scope' => ['required', 'string', 'in:house,global,period'], // house: áp dụng cho cung cụ thể, global: toàn lá số
            'target_house' => ['nullable', 'string', 'max:50'], // Ví dụ: MENH, PHU_MAU... (chỉ dùng nếu scope là house)
            'priority' => ['integer', 'min:0'],
            'text_template' => ['required', 'string'],
            'is_active' => ['boolean'],
        ];
    }
}
