<?php

namespace App\Actions\ActivityLog;

use App\Models\ActivityLog;

class CreateSingleLog {
    public function run($model, string $activity) {
        $log = new ActivityLog([ 'activity' => $activity ]);
        $log->loggable()->associate($model);
        $log->save();
    }
}