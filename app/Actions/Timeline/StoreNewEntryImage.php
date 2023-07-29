<?php

namespace App\Actions\Timeline;

use Illuminate\Support\Facades\Storage;

class StoreNewEntryImage {
    public function run($file) {
        return Storage::disk('timeline')->put('entries', $file);
    }
}