<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{

    CONST ACTIVITY = [
        'Registered' => 'REGISTERED',
        'Profile Updated' => 'PROFILE_UPDATED',
        'Privacy Updated' => 'PRIVACY_UPDATED',
        'Password Updated' => 'PASSWORD_UPDATED'
    ];


    /**
     * Mass assign properties
     */
    protected $fillable = [
        'activity'
    ];

    /**
     * Relations
     */
    public function loggable(): MorphTo {
        return $this->morphTo();
    }
}
