<?php

namespace App\Http\Controllers\Auth;


use App\Models\ActivityLog;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Actions\User\CreateSingleUser;
use Illuminate\Auth\Events\Registered;
use App\Actions\ActivityLog\CreateSingleLog;
use App\Http\Requests\Auth\CreateAccountRequest;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     * @param Request $request
     * @param CreateSingleUser $createSingleUser
     * @param CreateSingleLog $createSingleLog
     * 
     * @return JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(CreateAccountRequest $request, CreateSingleUser $createSingleUser, CreateSingleLog $createSingleLog): JsonResponse
    {
        $user = $createSingleUser->run($request->all());
        
        $createSingleLog->run($user, ActivityLog::ACTIVITY['Registered']);

        event(new Registered($user));

        Auth::login($user);

        return new JsonResponse([ 'success' => true, 'message' => 'Account created' ], 201);
    }
}
