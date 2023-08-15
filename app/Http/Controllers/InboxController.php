<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\InboxCollection;

class InboxController extends Controller 
{
    /**
     * 
     */
    public function index() {
        return view('inbox');
    }

    /**
     * @todo add policy to block seeing those that arent for the logged in user
     */
    public function list(Request $request) {
        $inbox = Comment::where(fn($q) => $q->received(Auth::id()))
            ->orWhere(fn($q) => $q->sent(Auth::id()))
            ->with('commentable.profile', 'author.profile')->paginate(10);
        
        $countUnread = Comment::unread(Auth::id())->count();

        return InboxCollection::collection($inbox)->additional([ 'countUnread' => $countUnread ]);
    }
}

//Can only show pagination returning itself