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
     * @todo PUT A POLICY AGAINST THOSE THAT DONT WANT TO BE FOLLOWED - Create this ability in privacy
     */
    public function update(Request $request, ToggleSingleFollowing $toggleSingleFollowing) {
        $user = User::find(Auth::id());

        [ 'attached' => $attached ] = $toggleSingleFollowing->run($user, $request->id);

        $message = count($attached)
            ? 'Friend Added'
            : 'Friend Removed';

        $user->load('following:id,name,surname');

        return new JsonResponse([ 'success' => true, 'message' => $message, 'data' => $user ], 201);
    }
}
