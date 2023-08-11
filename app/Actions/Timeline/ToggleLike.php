<?php

namespace App\Actions\Timeline;

use Illuminate\Support\Facades\Auth;

class ToggleLike {
    public function run($timeline) {
        Auth::user()->timelineLikes()->toggle($timeline);
    }
}