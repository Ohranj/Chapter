<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Actions\ActivityLog\CreateSingleLog;
use App\Actions\Profile\UpdateSingleUsersProfile;

class ProfileController extends Controller
{
    public function update(
        Request $request, 
        UpdateSingleUsersProfile $updateSingleUsersProfile, 
        CreateSingleLog $createSingleLog
    ) {
        $updateSingleUsersProfile->run(Auth::user(), $request->only('country', 'gender'));
        $createSingleLog->run(Auth::user(), ActivityLog::ACTIVITY['Profile Updated']);
        return new JsonResponse([ 'success' => true, 'message' => 'Account Updated' ], 201);
    }
}
