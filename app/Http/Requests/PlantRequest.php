<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlantRequest extends FormRequest
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
            'category_id' => 'required|exists:categories,id', 
            'price' => 'nullable|numeric',
            'name' => 'required|string|unique:plants,name', 
            // 'slug' => 'required|string|unique:plants,slug', // Slug must be unique
            'description' => 'required|string',
        ];
    }
}
