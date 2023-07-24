<?php

namespace App\Models;

use App\Models\Privacy;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'country'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Appended JSON properties
     */
    protected $appends = ['full_name'];

    /**
     * Concat a users full name
     */
    protected function fullName(): Attribute
    {
        return new Attribute(
            get: fn () => $this->name . ' ' . $this->surname,
        );
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relations
     */
    public function profile() {
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }

    public function privacy() {
        return $this->hasOne(Privacy::class, 'user_id', 'id');
    }

    public function activity() {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }
}
