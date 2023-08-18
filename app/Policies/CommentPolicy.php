<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     * Determine whether the user can delete the model.
     */
    public function update(User $user, Comment $comment): bool
    {
        return $comment->commentable_id == $user->id;
    }
}
