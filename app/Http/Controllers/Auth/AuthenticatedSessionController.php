<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $authenticated = Auth::attempt($request->only(['email', 'password']));
        if (!$authenticated) {
            return new JsonResponse([
                'success' => false,
                'message' => 'We are unable to validate the provided credentials. Please check and try again.'
            ], 422);
        }
        // $request->authenticate();
        $request->session()->regenerate();
        return response()->json([ 'success' => true, 'message' => 'Sign in successfull' ], 200);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
