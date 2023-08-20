<?php

namespace App\Actions\Comment;

use App\Models\Comment;

class CreateComment {
    public function run(array $params, $recipient) {
        $comment = new Comment($params);
        $comment->commentable()->associate($recipient);
        $comment->save();
        return $comment;
    }
}