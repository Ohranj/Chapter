<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    use HasFactory;

    CONST ACTIVITY = [
        'Registered' => 'REGISTERED'
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
