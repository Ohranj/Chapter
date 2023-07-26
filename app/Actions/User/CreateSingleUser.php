<?php

namespace App\Actions\User;

use App\Models\User;

class CreateSingleUser {
    public function run(array $params) {
        return User::create($params);
    }
}