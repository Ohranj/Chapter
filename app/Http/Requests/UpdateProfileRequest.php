<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'upload' => ['nullable', 'file'],
            'country' => ['nullable', 'string'],
            'current_read' => ['nullable', 'string', 'max:75'],
            'tags' => ['nullable', 'array', 'max:5'],
            'slogan' => ['required', 'string', 'max:150'],
            'name' => ['sometimes', 'required', 'string'],
            'surname' => ['sometimes', 'required', 'string']
        ];
    }
}
