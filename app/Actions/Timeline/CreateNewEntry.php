<?php

namespace App\Actions\Timeline;

use Illuminate\Support\Facades\Auth;

class CreateNewEntry {
    public function run($params) {
        Auth::user()->entries()->create($params);
    }
}