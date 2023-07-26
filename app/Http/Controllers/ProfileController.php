<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Actions\ActivityLog\CreateSingleLog;
use App\Actions\Profile\StoreNewAvatar;
use App\Actions\Profile\UpdateSingleUsersProfile;
use App\Http\Requests\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function update(
        UpdateProfileRequest $request, 
        StoreNewAvatar $storeNewAvatar,
        UpdateSingleUsersProfile $updateSingleUsersProfile, 
        CreateSingleLog $createSingleLog
    ) {
        $params = $request->safe()->only('country', 'gender', 'slogan');

        if (isset($request->upload)) {
            $path = $storeNewAvatar->run($request->upload);
            $params = array_merge([ 'avatar' => $path ], $params);
        }
       
        $updateSingleUsersProfile->run(Auth::user(), $params);
        $createSingleLog->run(Auth::user(), ActivityLog::ACTIVITY['Profile Updated']);
        return new JsonResponse([ 
            'success' => true, 
            'message' => 'Account Updated', 
            'data' => [ 'user' => Auth::user() ] 
        ], 201);
    }
}
