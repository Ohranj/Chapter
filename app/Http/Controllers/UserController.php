<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Actions\User\UpdateSingleUser;
use App\Http\Requests\UpdateUserRequest;
use App\Actions\ActivityLog\CreateSingleLog;

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

    /**
     * Paginated list of users
     */
    public function list(Request $request) {
        $users = User::where([
            [ 'level', User::USER_TYPES[0] ],
            [ 'id', '!=', Auth::id() ]
        ])
        ->with(['profile', 'privacy', 'tags'])
        ->paginate($request->perPage ?? 10);

        return new JsonResponse([ 'success' => true, 'message' => 'Users retrieved', 'data' => $users ]);
    }
}
