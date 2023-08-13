<?php

namespace App\Models;

use App\Models\Privacy;
use App\Models\Timeline;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [ 'name', 'surname', 'email', 'password', 'country' ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [ 'password', 'remember_token' ];

    /**
     * Model constants
     */
    const USER_TYPES = ['USER', 'SYSTEM'];

    /**
     * Appended JSON properties
     */
    protected $appends = ['full_name', 'initials', 'created_at_human'];

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
     * Concat a users initials
     */
    protected function initials(): Attribute
    {
        return new Attribute(
            get: fn () => ucwords($this->name[0]) . ucwords($this->surname[0]),
        );
    }

    /**
     * Convert a users created at to human readable
     */
    protected function createdAtHuman(): Attribute
    {
        return new Attribute(
            get: fn () => Carbon::parse($this->created_at)->format('jS M y'),
        );
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [ 'password' => 'hashed' ];

    /**
     * Relations
     */
    public function profile() {
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }

    public function entries() {
        return $this->hasMany(Timeline::class, 'user_id', 'id');
    }

    public function privacy() {
        return $this->hasOne(Privacy::class, 'user_id', 'id');
    }

    public function activity() {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, TagUser::class, 'user_id', 'tag_id')->as('user_tags');
    }

    public function following() {
        return $this->belongsToMany(User::class, FollowUser::class, 'user_id', 'following_id');
    }

    public function timelineLikes(): MorphToMany {
        return $this->morphedByMany(TimeLine::class, 'likeable', 'likes');
    }

    /**
     * Local scopes
     */
    public function scopeRandomFriends(Builder $query, int $count) {
        $query->inRandomOrder()->take($count);
    }
}
