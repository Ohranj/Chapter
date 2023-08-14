<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function list(Request $request): JsonResponse {
        $inbox = Comment::where(fn($q) => $q->received(Auth::id()))
            ->orWhere(fn($q) => $q->sent(Auth::id()))
            ->paginate($request->paginate ?? 10);

        $unread = Comment::unread(Auth::id())->count();

        return new JsonResponse([ 
            'success' => true, 
            'message' => 'Inbox retrieved', 
            'data' => [ 'inbox' => $inbox, 'unread' => $unread ]]);
    }
}