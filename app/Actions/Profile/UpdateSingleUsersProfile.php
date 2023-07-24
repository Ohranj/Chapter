<?php

namespace App\Actions\Profile;

use App\Models\User;

class UpdateSingleUsersProfile {
    public function run(User $user, array $params) {
        return $user->profile()->update($params);
    }
}