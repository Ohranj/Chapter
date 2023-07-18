<?php

namespace App\Http\Requests\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class CreateAccountRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [ 'required', 'string', 'max:255' ],
            'surname' => [ 'required', 'string', 'max:255' ],
            'email' => [ 'required', 'string', 'email', 'max:255', 'unique:users,email' ],
            'password' => [ 'required', 'confirmed', Password::min(8)->letters()->numbers()->symbols() ],
        ];
    }

    /**
     * Handle a passed validation attempt.
     */
    protected function passedValidation(): void
    {
        $this->replace([
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'password' => Hash::make($this->password)
        ]);
    }
}
