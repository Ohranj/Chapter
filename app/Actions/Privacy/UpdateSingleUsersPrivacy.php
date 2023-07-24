<?php

namespace App\Actions\Privacy;

use App\Models\User;

class UpdateSingleUsersPrivacy {
    public function run(User $user, array $params) {
        return $user->privacy()->update($params);
    }
}