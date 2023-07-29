<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
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
            'current' => [
                'required', 
                'string', 
                function($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        return $fail('Your current password is incorrect.');
                    }
                }
            ],
            'password' => [
                'required', 
                'string', 
                'confirmed', 
                'different:current', 
                Password::min(8)->symbols()->numbers()->letters()
            ],
            'password_confirmation' => [
                'required', 
                'same:password'
            ]
        ];
    }
}
