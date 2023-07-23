<?php

namespace App\Actions\User;

use App\Models\User;

class UpdateSingleUser {
    public function run(User $user, array $params) {
        return $user->update($params);
    }
}