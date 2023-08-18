<?php

namespace App\Actions\Comment;

use Illuminate\Support\Facades\Auth;

class ToggleIsReadState {
    public function run($comment) {
        if ($comment->user_id != Auth::id()) {
            $comment->commentable_is_read = true;
            $comment->save();
        }
        $replies =  $comment->replies()->get();
        $this->toggleNestedReplies($replies);
    }

    private function toggleNestedReplies($replies) {
        foreach($replies as $reply) {
            if ($reply->user_id != Auth::id()) {
                $reply->commentable_is_read = true;
                $reply->save();
            }
            if (count($reply->replies)) {
                $this->toggleNestedReplies($reply->replies);
            }
        }
    }
}