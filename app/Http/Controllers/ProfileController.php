<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Actions\ActivityLog\CreateSingleLog;
use App\Actions\Profile\StoreNewAvatar;
use App\Actions\Profile\UpdateSingleUsersProfile;
use App\Actions\User\UpdateSingleUser;
use App\Http\Requests\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function update(
        UpdateProfileRequest $request, 
        StoreNewAvatar $storeNewAvatar,
        UpdateSingleUsersProfile $updateSingleUsersProfile, 
        CreateSingleLog $createSingleLog,
        UpdateSingleUser $updateSingleUser
    ) {
        $user = Auth::user();
        
        $updateSingleUser->run($user, $request->safe()->only('name', 'surname'));

        $profileParams = $request->safe()->only('country', 'gender', 'slogan');
        if (isset($request->upload)) {
            $path = $storeNewAvatar->run($request->upload);
            $profileParams = array_merge([ 'avatar' => $path ], $profileParams);
        }
        $updateSingleUsersProfile->run($user, $profileParams);
        $createSingleLog->run($user, ActivityLog::ACTIVITY['Profile Updated']);

        return new JsonResponse([ 
            'success' => true, 
            'message' => 'Account Updated', 
            'data' => [ 'user' => Auth::user() ] 
        ], 201);
    }
}
