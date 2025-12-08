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
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'in:male,female'],
            
            // Split Date Fields
            'day' => ['required', 'integer', 'min:1', 'max:31'],
            'month' => ['required', 'integer', 'min:1', 'max:12'],
            'year' => ['required', 'integer', 'min:1900', 'max:2100'],
            
            // Split Time Fields
            'hour' => ['required', 'integer', 'min:0', 'max:23'],
            'minute' => ['required', 'integer', 'min:0', 'max:59'],

            // View Date
            'view_year' => ['required', 'integer', 'min:1900', 'max:2100'],
            'view_month' => ['nullable', 'integer', 'min:1', 'max:12'],
            
            'timezone' => ['nullable', 'string'],
        ];
    }
}