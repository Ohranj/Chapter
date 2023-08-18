<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [ 'user_id', 'body' ];

    protected $appends = [ 'created_at_human' ];

    /**
     * Appended Attributes
     */
    protected function createdAtHuman(): Attribute {
        return new Attribute(
            get: fn() => Carbon::parse($this->created_at)->setTimezone('Europe/London')->format('jS M y \a\t H:i')
        );
    }
    

    /**
     * Relations
     */
    public function commentable(): MorphTo {
        return $this->morphTo();
    }

    public function author() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function replies() {
        return $this->hasMany(Comment::class, 'parent_id', 'id')->with('replies');
    }


    /**
     * Scopes
     */
    public function scopeReceived(Builder $query, int $user_id) {
        $query->where([[ 'commentable_id', $user_id ], [ 'parent_id', null ]]);
    }

    public function scopeSent(Builder $query, int $user_id) {
        $query->whereHas('author')->where([[ 'user_id', $user_id ], [ 'parent_id', null ]]);
    }

    public function scopeUnread(Builder $query, int $user_id) {
        $query->where([['commentable_id', $user_id], ['commentable_is_read', false]]);
    }
}
