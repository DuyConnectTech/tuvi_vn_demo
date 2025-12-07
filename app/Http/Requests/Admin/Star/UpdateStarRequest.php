<?php

namespace App\Http\Requests\Admin\Star;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $starId = $this->route('star') ? $this->route('star')->id : null;

        return [
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['required', 'string', 'max:100', 'unique:stars,slug,' . $starId],
            'group_type' => ['required', 'string', 'max:20'],
            'default_element' => ['nullable', 'string', 'max:20'],
            'is_main' => ['boolean'],
            'quality' => ['nullable', 'string', 'max:100'],
            'aliases' => ['nullable', 'array'],
            'keywords' => ['nullable', 'array'],
            'description' => ['nullable', 'string'],
        ];
    }
}
