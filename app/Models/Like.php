<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Like extends Model
{
    use HasFactory;

    /**
     * Query scopes
     */
    public function scopeUserLikes(Builder $query, int $id) {
        $query->where('user_id', $id);
    }
}
