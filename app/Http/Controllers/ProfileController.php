<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Actions\User\UpdateSingleUser;
use App\Actions\Profile\StoreNewAvatar;
use App\Http\Requests\UpdateProfileRequest;
use App\Actions\ActivityLog\CreateSingleLog;
use App\Actions\Profile\UpdateSingleUsersProfile;
use App\Actions\Tag\SyncUserTags;

class ProfileController extends Controller
{   
    /**
     * Update a users profile
    */
    public function update(
        User $user,
        UpdateProfileRequest $request, 
        SyncUserTags $syncUserTags,
        StoreNewAvatar $storeNewAvatar,
        UpdateSingleUsersProfile $updateSingleUsersProfile, 
        CreateSingleLog $createSingleLog,
        UpdateSingleUser $updateSingleUser
    ) {
        if ($request->has('tags')) {
            $syncUserTags->run($user, $request->tags);
        }
        $updateSingleUser->run($user, $request->safe()->only('name', 'surname'));

        $profileParams = $request->safe()->only('country', 'current_read', 'slogan');
        if ($request->has('upload')) {
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
