<?php

namespace App\Actions\ActivityLog;

use App\Models\ActivityLog;

class CreateSingleLog {
    public function run($model, string $activity) {
        $log = new ActivityLog();
        $log->loggable()->associate($model);
        $log->activity = $activity;
        $log->save();
    }
}