<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class InboxCollection extends JsonResource
{
    private $flattenedReplies = [];
    private $has_read = false;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->flattenReplies($this->replies);

        return [
            'id' => $this->id,
            'body' => $this->body,
            'is_read' => $this->when(!$this->parent_id, $this->user_id == Auth::id() ? true : $this->commentable_is_read, $this->has_read),
            'commentable_type' => $this->commentable_type,
            'commentable_id' => $this->commentable_id,
            'created_at' => $this->created_at,
            'inverse' => $this->when($this->user_id != Auth::id(), $this->author, $this->commentable),
            'created_at_human' => $this->created_at_human,
            'replies' => $this->flattenedReplies
        ];
    }

    /**
     * Flatten all the replies to a single layer array
     */
    private function flattenReplies($replies): array 
    {
        foreach($replies as $reply) {
            if ($reply->commentable->id == Auth::id()) {
                if ($this->has_read) {
                    $this->has_read = $reply->commentable->is_read;
                }
            }
            $this->flattenedReplies[] = [
                'body' => $reply['body'],
                'commentable_id' => $reply['commentable_id'],
                'created_at_human' => $reply['created_at_human'],
                'user_id' => $reply['user_id'],
            ];
            if (count($reply->replies)) {
                $this->flattenReplies($reply->replies);
            }
        }
        return $this->flattenedReplies;
    }
}