<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;

    protected $appends = ['has_avatar'];

    protected $fillable = [
        'country',
        'gender',
        'slogan',
        'avatar'
    ];

    /**
     * 
     */
    protected function hasAvatar(): Attribute
    {
        return new Attribute(
            get: fn () => isset($this->avatar),
        );
    }
}
