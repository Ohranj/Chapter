<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTimelineEntryRequest extends FormRequest
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
            'text' => ['required', 'string', 'max:750'],
            'upload' => ['sometimes', 'required', 'file']
        ];
    }

    /**
     * @return array
     */
    public function messages() {
        return [
            'text.required' => 'Your thoughts are required to create a new entry.'
        ];
    }
}
