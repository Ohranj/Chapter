<?php

namespace App\Actions\Timeline;

use Illuminate\Support\Facades\Auth;

class ToggleLike {
    public function run($timeline) {
        return Auth::user()->timelineLikes()->toggle($timeline);
    }
}