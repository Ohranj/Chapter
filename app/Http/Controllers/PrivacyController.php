<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Actions\ActivityLog\CreateSingleLog;
use App\Actions\Privacy\UpdateSingleUsersPrivacy;

class PrivacyController extends Controller
{
    public function update(
        Request $request,
        CreateSingleLog $createSingleLog,
        UpdateSingleUsersPrivacy $updateSingleUsersPrivacy
    ) {
        $updateSingleUsersPrivacy->run(Auth::user(), $request->only('direct_messages', 'comment_replies'));
        $createSingleLog->run(Auth::user(), ActivityLog::ACTIVITY['Privacy Updated']);
        return new JsonResponse([ 'success' => true, 'message' => 'Account Updated' ], 201);
    }
}
