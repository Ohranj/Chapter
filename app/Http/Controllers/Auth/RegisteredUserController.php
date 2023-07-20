<?php

namespace App\Http\Controllers\Auth;

use App\Actions\User\CreateSingleUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateAccountRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     * @param Request $request
     * @param CreateSingleUser $createSingleUser
     * 
     * @return JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(CreateAccountRequest $request, CreateSingleUser $createSingleUser): JsonResponse
    {
        $user = $createSingleUser->run($request->all());

        event(new Registered($user));

        // Auth::login($user);

        return new JsonResponse([ 'success' => true, 'message' => 'Account created' ], 201);
    }
}
