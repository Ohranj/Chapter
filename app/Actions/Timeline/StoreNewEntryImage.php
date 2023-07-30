<?php

namespace App\Actions\Timeline;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StoreNewEntryImage {
    public function run($file) {
        return Storage::disk('timelines')->put(Auth::id(), $file);
    }
}