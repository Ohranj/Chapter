<?php

namespace App\Http\Controllers;

use App\Models\Timeline;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Actions\Timeline\CreateNewEntry;
use App\Actions\Timeline\StoreNewEntryImage;
use App\Http\Requests\CreateTimelineEntryRequest;

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

    public function create(
        CreateTimelineEntryRequest $request, 
        CreateNewEntry $createNewEntry, 
        StoreNewEntryImage $storeNewEntryImage
    ) {
        $params = [ 'entry' => $request->safe()->text ];
        if (isset($request->safe()->upload)) {
            $path = $storeNewEntryImage->run($request->safe()->upload);
            $params = array_merge($params, ['image_path' => $path]);
        }
        $createNewEntry->run($params);
        return new JsonResponse([ 'success' => true, 'message' => 'Timeline updated' ], 201);
    }
}