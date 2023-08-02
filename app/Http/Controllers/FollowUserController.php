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

        $toggleSingleFollowing->run($user, $request->id);

        $user->load('following');

        return new JsonResponse([ 
            'success' => true, 
            'message' => 'Followers updated', 
            'data' => $user 
        ], 201);
    }
}
