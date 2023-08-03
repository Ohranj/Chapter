<?php

namespace App\Actions\FollowUser;

use App\Models\User;

class ToggleSingleFollowing {
    public function run(User $user, int $id) {
        return $user->following()->toggle([ 'following_id' => $id ]);
    }
}