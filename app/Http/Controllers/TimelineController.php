<?php

namespace App\Http\Controllers;

use App\Models\Timeline;
use App\Models\FollowUser;
use Illuminate\Http\JsonResponse;
use App\Actions\Timeline\CreateNewEntry;
use App\Actions\Timeline\StoreNewEntryImage;
use App\Http\Requests\CreateTimelineEntryRequest;

class TimelineController extends Controller
{
    public function list(): JsonResponse {
        $followings = FollowUser::following()->pluck('following_id')->toArray();
        $timeline = Timeline::searchWithinIds($followings)
            ->orderBy('created_at', 'DESC')
            ->take(15)
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
    ): JsonResponse {
        $params = [ 'entry' => $request->safe()->text ];
        if (isset($request->safe()->upload)) {
            $path = $storeNewEntryImage->run($request->safe()->upload);
            $params = array_merge($params, ['image_path' => $path]);
        }
        $createNewEntry->run($params);
        return new JsonResponse([ 'success' => true, 'message' => 'Timeline updated' ], 201);
    }
}