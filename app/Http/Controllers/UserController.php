<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UpdateUserRequest;
use App\Actions\ActivityLog\CreateSingleLog;
use App\Actions\User\UpdateSingleUser;

class UserController extends Controller
{
    /**
     * Update a user model
     */
    public function update(User $user, UpdateUserRequest $request, UpdateSingleUser $updateSingleUser, CreateSingleLog $createSingleLog) { 
        $updateSingleUser->run($user, $request->safe()->only(['password']));
        $createSingleLog->run($user, ActivityLog::ACTIVITY['Password Updated']);
        return new JsonResponse([ 'success' => true, 'message' => 'Account updated' ], 201);
    }
}
