<?php

namespace App\Http\Requests\Admin\Horoscope;

use Illuminate\Foundation\Http\FormRequest;

class StoreHoroscopeRequest extends FormRequest
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
            'birth_date' => ['required', 'date'], // YYYY-MM-DD
            'birth_time' => ['required', 'date_format:H:i'], // HH:MM
            'timezone' => ['nullable', 'string', 'max:64'],
        ];
    }
}
