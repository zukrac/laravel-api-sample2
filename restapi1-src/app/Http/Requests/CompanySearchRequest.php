<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanySearchRequest extends FormRequest
{
    public function rules()
    {
        return [
            'q' => 'nullable|string|max:255',
            'page' => 'nullable|integer',
            'per_page' => 'nullable|integer',
            'offset' => 'nullable|integer',
            'limit' => 'nullable|integer',
        ];
    }

}
