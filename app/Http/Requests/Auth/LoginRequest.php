<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;

class LoginRequest extends FormRequest
{
    private $maxAttempts = 5;
    private $decaySeconds = 60;

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
            'email' => [ 'required', 'string', 'email' ],
            'password' => [ 'required', 'string' ],
            'remember' => ['required', 'boolean']
        ];
    }

    /**
     * Check if the email is rate limited
     */
    public function isNotRateLimited(): bool {
        $key = 'authenticate:' . strtolower($this->email);

        $attemptsLeft = RateLimiter::attempt($key, $this->maxAttempts, fn() => true, $this->decaySeconds);

        if ($attemptsLeft) return true;

        RateLimiter::hit($key);
        return false;
    }

    /**
     * Check the seconds before rate limit expires
     */
    public function rateLimitAvailableIn(): int {
        return RateLimiter::availableIn('authenticate:' . $this->email);
    }

    /**
     * Clear the rate limiter
     */
    public function clearRateLimiter(): void {
        $key = 'authenticate:' . strtolower($this->email);
        RateLimiter::clear($key);
    }
}
