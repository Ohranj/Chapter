<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * @todo ALLOW PEOPLE TO BLOCK MESSAGES FROM SPECIFIC PEOPLE
     */
    public function create(Request $request) {
        $recipient = User::find($request->recipient);
        $comment = new Comment([ 'body' => $request->comment, 'user_id' => Auth::id() ]);
        $comment->commentable()->associate($recipient);
        $comment->save();
        return new JsonResponse([ 'success' => true, 'message' => 'Message issued to recipient' ], 201);
    }
}
