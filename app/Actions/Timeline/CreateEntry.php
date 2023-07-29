<?php

namespace App\Actions\Timeline;

use Illuminate\Support\Facades\Auth;

class CreateEntry {
    public function run($params) {
        Auth::user()->entries()->create($params);
    }
}