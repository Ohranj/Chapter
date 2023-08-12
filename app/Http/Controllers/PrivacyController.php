<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Actions\ActivityLog\CreateSingleLog;
use App\Actions\Privacy\UpdateSingleUsersPrivacy;

class PrivacyController extends Controller
{
    public function update(
        User $user,
        Request $request,
        CreateSingleLog $createSingleLog,
        UpdateSingleUsersPrivacy $updateSingleUsersPrivacy
    ): JsonResponse {
        $updateSingleUsersPrivacy->run($user, $request->only('direct_messages', 'comment_replies'));
        $createSingleLog->run($user, ActivityLog::ACTIVITY['Privacy Updated']);
        return new JsonResponse([ 'success' => true, 'message' => 'Account Updated' ], 201);
    }
}
