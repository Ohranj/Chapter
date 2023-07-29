<?php

namespace App\Http\Controllers;

use App\Models\Timeline;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Actions\Timeline\CreateNewEntry;
use Illuminate\Support\Facades\Storage;

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

    public function create(Request $request, CreateNewEntry $createNewEntry) {
        $request->validate([
            'text' => ['required', 'string', 'max:225'],
            'upload' => ['sometimes']
        ]);
        $params = [ 'entry' => $request->text ];
        if (isset($request->upload)) {
            $path = Storage::disk('timeline')->put('entries', $request->upload);
            $params = array_merge($params, ['image_path' => $path]);
        }
        $createNewEntry->run($params);
        return new JsonResponse([ 'success' => true, 'message' => 'Timeline updated' ], 201);
    }
}
