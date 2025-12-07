<?php

namespace App\Http\Requests\Admin\Glossary;

use Illuminate\Foundation\Http\FormRequest;

class StoreGlossaryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'term' => ['required', 'string', 'max:255', 'unique:glossaries,term'],
            'definition' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:100'],
            'reference_url' => ['nullable', 'url', 'max:255'],
        ];
    }
}
