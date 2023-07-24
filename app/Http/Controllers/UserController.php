<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Actions\User\UpdateSingleUser;
use App\Actions\ActivityLog\CreateSingleLog;

class UserController extends Controller
{
    public function update(Request $request, UpdateSingleUser $updateSingleUser, CreateSingleLog $createSingleLog) {
        $updateSingleUser->run(Auth::user(), $request->only('country'));
        $createSingleLog->run(Auth::user(), ActivityLog::ACTIVITY['Account Updated']);
        return new JsonResponse([ 'success' => true, 'message' => 'Account Updated' ], 201);
    }
}
