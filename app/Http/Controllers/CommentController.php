<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Actions\Comment\CreateComment;
use App\Actions\ActivityLog\CreateSingleLog;

class CommentController extends Controller
{
    /**
     * @todo ALLOW PEOPLE TO BLOCK MESSAGES FROM SPECIFIC PEOPLE
     */
    public function create(Request $request, CreateComment $createComment, CreateSingleLog $createSingleLog) {
        $recipient = User::find($request->recipient);
        $params = [ 'body' => $request->comment, 'user_id' => Auth::id() ];
        $comment = $createComment->run($params, $recipient);
        $createSingleLog->run($comment, ActivityLog::ACTIVITY['Created Comment']);
        return new JsonResponse([ 'success' => true, 'message' => 'Message issued to recipient' ], 201);
    }
}
