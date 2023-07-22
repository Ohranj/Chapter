<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class CreateSingleUser {
    public function run($params) {
        return User::create($params);
    }
}