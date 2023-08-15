<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class InboxCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'is_read' => $this->when($this->user_id != Auth::id(), $this->is_read),
            'commentable_type' => $this->commentable_type,
            'commentable_id' => $this->commentable_id,
            'created_at' => $this->created_at,
            'author' => $this->when($this->user_id != Auth::id(), $this->author),
            'commentable' => $this->when($this->user_id == Auth::id(), $this->commentable)
        ];
    }
}
