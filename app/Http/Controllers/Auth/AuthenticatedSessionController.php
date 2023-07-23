<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $authenticated = Auth::attempt($request->safe()->only(['email', 'password']));
        if (!$authenticated) {
            return new JsonResponse([
                'success' => false,
                'message' => 'We are unable to validate these credentials. Please check and try again.'
            ], 422);
        }
        // $request->authenticate();
        $request->session()->regenerate();
        return new JsonResponse([ 'success' => true, 'message' => 'Sign in successfull' ], 200);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return new JsonResponse([ 'success' => true, 'message' => 'Logged out successfully' ], 200);
    }
}