<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;

class FollowUser extends Pivot
{
    /**
     * Relations
     */
    public function user() {
        return $this->belongsTo(User::class, 'following_id', 'id');
    }

    /**
     * Query scopes
     */
    public function scopeFollowing(Builder $query) {
        $query->with('user')->where('user_id', Auth::id());
    }
}
