<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [ 'user_id', 'body' ];

    /**
     * Relations
     */
    public function commentable(): MorphTo {
        return $this->morphTo();
    }

    public function author() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Scopes
     */
    public function scopeReceived(Builder $query, int $user_id) {
        $query->where([
            [ 'commentable_id', $user_id ], 
            [ 'parent_id', null ]
        ])
        ->with('author:id,name,surname');
    }

    public function scopeSent(Builder $query, int $user_id) {
        $query->where([
            [ 'user_id', $user_id ], 
            [ 'parent_id', null ]
        ])
        ->with('commentable:id,name,surname');
    }

    public function scopeUnread(Builder $query, int $user_id) {
        $query->where([ [ 'user_id', $user_id ], [ 'is_read', false ] ])
            ->orWhere([ ['commentable_id', $user_id], ['is_read', false] ]);
    }
}
