<?php

namespace App\Http\Requests\Admin\Glossary;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGlossaryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $glossaryId = $this->route('glossary') ? $this->route('glossary')->id : null;

        return [
            'term' => ['required', 'string', 'max:255', Rule::unique('glossaries', 'term')->ignore($glossaryId)],
            'definition' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:100'],
            'reference_url' => ['nullable', 'url', 'max:255'],
        ];
    }
}
