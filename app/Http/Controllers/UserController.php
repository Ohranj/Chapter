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
     * Return a users dashboard
     */
    public function index() {
        return view('dashboard');
    }
    
    /**
     * Update a user model
     * @param User $user
     * @param UpdateUserRequest $updateUserRequest
     * @param UpdateSingleUser $updateSingleUser
     * @param CreateSingleLog $createSingleLog
     */
    public function update(User $user, UpdateUserRequest $request, UpdateSingleUser $updateSingleUser, CreateSingleLog $createSingleLog): JsonResponse { 
        $updateSingleUser->run($user, $request->safe()->only(['password']));
        $createSingleLog->run($user, ActivityLog::ACTIVITY['Password Updated']);
        return new JsonResponse([ 'success' => true, 'message' => 'Account updated' ], 201);
    }

    /**
     * Paginated list of users
     * @param Request $request
     */
    public function list(Request $request): JsonResponse {
        $users = User::where([ [ 'level', User::USER_TYPES[0] ], [ 'id', '!=', Auth::id() ] ])
            ->with(['profile', 'tags'])
            ->select('id', 'name', 'surname')
            ->paginate($request->perPage ?? 10);
        return new JsonResponse([ 'success' => true, 'message' => 'Users retrieved', 'data' => $users ]);
    }
}
