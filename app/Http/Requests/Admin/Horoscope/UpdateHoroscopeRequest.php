<?php

namespace App\Http\Requests\Admin\Horoscope;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHoroscopeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:191'],
            'gender' => ['required', 'string', 'in:male,female'],
            'birth_date' => ['required', 'date'],
            'birth_time' => ['required', 'date_format:H:i'],
            'timezone' => ['nullable', 'string', 'max:64'],
            'description' => ['nullable', 'string'],
            'is_public' => ['nullable', 'boolean'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['exists:tags,id'],
        ];
    }
}
