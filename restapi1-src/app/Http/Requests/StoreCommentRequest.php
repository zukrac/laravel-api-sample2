<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'content' => 'required|string|max:5000',
            'commentable_type' => 'required|string|in:App\\Models\\Product,App\\Models\\Company,App\\Models\\User',
            'commentable_id' => 'required|integer',
            'parent_id' => 'nullable|integer|exists:comments,id',
        ];
    }

    public function after(): array
    {
        $errors = [];

        if ($this->filled('commentable_type') && $this->filled('commentable_id')) {
            $commentableType = $this->input('commentable_type');
            $commentableId = $this->input('commentable_id');

            $table = match($commentableType) {
                'App\\Models\\Product' => 'products',
                'App\\Models\\Company' => 'companies',
                'App\\Models\\User' => 'users',
                default => null,
            };

            if ($table) {
                $exists = \Illuminate\Support\Facades\DB::table($table)->where('id', $commentableId)->exists();
                if (!$exists) {
                    $errors[] = [
                        'message' => "The {$commentableType} with ID {$commentableId} does not exist.",
                        'field' => 'commentable_id',
                    ];
                }
            }
        }

        return $errors;
    }
}
