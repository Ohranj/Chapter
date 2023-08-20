<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class InboxCollection extends JsonResource
{
    private $flattenedReplies = [];
    private $has_read = true;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->computeReplies($this->replies);

        return [
            'id' => $this->id,
            'body' => $this->body,
            'is_read' => $this->when(!count($this->replies), 
                $this->user_id == Auth::id() ? true : $this->commentable_is_read, 
                $this->has_read
            ),
            'commentable_type' => $this->commentable_type,
            'commentable_id' => $this->commentable_id,
            'created_at' => $this->created_at,
            'inverse' => $this->when($this->user_id != Auth::id(), $this->author, $this->commentable),
            'created_at_human' => $this->created_at_human,
            'replies' => $this->flattenedReplies,
            'body_snippet' => substr($this->body, 0, 45) . '...',
        ];
    }

    /**
     * Flatten all the replies to a single layer array and compute the current is_read status
     */
    private function computeReplies($replies): array 
    {
        foreach($replies as $reply) {
            if ($this->has_read) {
                $this->has_read = $reply->user_id == Auth::id()
                    ? true
                    : $reply->commentable_is_read;
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