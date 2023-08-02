<?php

namespace App\Actions\FollowUser;

use App\Models\User;

class ToggleSingleFollowing {
    public function run(User $user, int $id) {
        $user->following()->toggle([ 'following_id' => $id ]);
    }
}