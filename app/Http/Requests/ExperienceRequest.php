<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExperienceRequest extends FormRequest
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
        return [
            'type' => 'required|string|in:full-time,part-time,contract,freelance,internship,volunteer,self-employed,partnership,seasonal,apprenticeship',
            'title' => 'required|string|max:100',
            'company' => 'required|string|max:150',
            'location' => 'nullable|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'description' => 'nullable|string|max:1000',
            'skills' => 'nullable|string|max:200',
        ];
    }
}
