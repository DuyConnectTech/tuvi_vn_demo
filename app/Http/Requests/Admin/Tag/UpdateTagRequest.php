<?php

namespace App\Http\Requests\Admin\Tag;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTagRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $tagId = $this->route('tag') ? $this->route('tag')->id : null;
        return [
            'name' => ['required', 'string', 'max:100', Rule::unique('tags', 'name')->ignore($tagId)],
            'slug' => ['nullable', 'string', 'max:100', Rule::unique('tags', 'slug')->ignore($tagId)],
        ];
    }
}
