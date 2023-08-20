<?php

namespace App\Http\Controllers;

use App\Actions\Comment\ToggleIsReadState;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\InboxCollection;
use Illuminate\Http\JsonResponse;

class InboxController extends Controller 
{
    /**
     * 
     */
    public function index() {
        return view('inbox');
    }

    /**
     *
     */
    public function list(Request $request) {
        $inbox = Comment::where(fn($q) => $q->received(Auth::id()))
            ->orWhere(fn($q) => $q->sent(Auth::id()))
            ->with('commentable.profile', 'author.profile', 'replies')
            ->paginate($request->paginate ?? 10);
        
        $countUnread = Comment::unread(Auth::id())->count();

        return InboxCollection::collection($inbox)->additional([ 'countUnread' => $countUnread ]);
    }

    /**
     *
     */
    public function toggleIsRead(Comment $comment, ToggleIsReadState $toggleIsReadState) {
        $this->authorize('update', $comment);
        $toggleIsReadState->run($comment);
        return new JsonResponse([ 'success' => true, 'message' => 'Inbox item status toggled' ], 201);
    }
}