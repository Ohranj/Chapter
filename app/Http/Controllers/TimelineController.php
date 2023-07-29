<?php

namespace App\Http\Controllers;

use App\Models\Timeline;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Actions\Timeline\CreateEntry;

class TimelineController extends Controller
{
    public function list() {
        $timeline = Timeline::whereBelongsTo(Auth::user(), 'author')
            ->orderBy('created_at', 'DESC')
            ->get();
        return new JsonResponse([
            'success' => true,
            'message' => 'Timeline retrieved',
            'data' => $timeline
        ]);
    }

    public function create(Request $request, CreateEntry $createEntry) {
        $request->validate([
            'text' => ['required', 'string', 'max:225']
        ]);
        $params = [ 'entry' => $request->text ];
        $createEntry->run($params);
        return new JsonResponse([ 'success' => true, 'message' => 'Timeline updated' ], 201);
    }
}
