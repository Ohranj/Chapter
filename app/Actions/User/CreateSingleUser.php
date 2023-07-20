<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class CreateSingleUser {
    public function run($params) {
        Log::info('User created. Add to Log.');
        return User::create($params);
    }
}