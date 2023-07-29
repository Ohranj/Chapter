<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Timeline extends Model
{
    use HasFactory;

    protected $fillable = [
        'entry',
        'image_path'
    ];

    protected $appends = ['created_at_human'];

    protected function createdAtHuman(): Attribute
    {
        return new Attribute(
            get: fn () => Carbon::parse($this->created_at)->setTimezone('Europe/London')->diffForHumans(),
        );
    }

    /**
     * Relations
     */
    public function author() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}