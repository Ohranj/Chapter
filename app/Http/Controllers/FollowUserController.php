<?php

namespace App\Http\Controllers;

use App\Actions\FollowUser\ToggleSingleFollowing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class FollowUserController extends Controller
{
    /**
     * @param Request $request
     * @param ToggleSingleFollowing $toggleSingleFollowing
     * 
     * @todo CREATE A BLOCK LIST THAT PEOPLE CAN ADD SO THEY KNOW LONGER SEE
     */
    public function update(Request $request, ToggleSingleFollowing $toggleSingleFollowing): JsonResponse {
        $user = User::find(Auth::id());

        [ 'attached' => $attached ] = $toggleSingleFollowing->run($user, $request->id);

        $message = count($attached)
            ? 'Friend Added'
            : 'Friend Removed';

        $user->load('following:id,name,surname');

        return new JsonResponse([ 'success' => true, 'message' => $message, 'data' => $user ], 201);
    }
}
