<?php

namespace App\Http\Requests\Person;

use Illuminate\Foundation\Http\FormRequest;

class CreatePersonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'category' => 'required|in:expert_advisors,board_of_directors,core_team',
        ];
    }
} 