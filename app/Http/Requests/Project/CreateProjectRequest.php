<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class CreateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'description' => 'required|string',
            'is_donation' => 'boolean',
            'goal' => 'required_if:is_donation,true|numeric|min:0',
        ];
    }
} 