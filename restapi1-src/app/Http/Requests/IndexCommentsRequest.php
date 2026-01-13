<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexCommentsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'commentable_type' => 'nullable|string|in:App\\Models\\Product,App\\Models\\Company,App\\Models\\User',
            'commentable_id' => 'nullable|integer',
            'parent_id' => 'nullable|integer',
            'per_page' => 'nullable|integer|min:15|max:100',
        ];
    }
}
