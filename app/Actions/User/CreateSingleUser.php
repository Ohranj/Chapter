<?php

namespace App\Actions\User;

use App\Models\User;

class CreateSingleUser {
    public function run($params) {
        return User::create($params);
    }
}