<?php

namespace App\Actions\User;

use App\Models\User;

class CreateSingleUser {
    public function run(array $params) {
        $user = User::create($params);
        $this->createRelations($user);
        return $user;
    }

    private function createRelations($user) {
        $user->profile()->create();
        $user->privacy()->create();
    }
}