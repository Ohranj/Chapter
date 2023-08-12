<?php

namespace App\Http\Controllers;

use App\Models\Timeline;
use App\Models\FollowUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Actions\Timeline\CreateNewEntry;
use App\Actions\Timeline\DeleteEntry;
use App\Actions\Timeline\StoreNewEntryImage;
use App\Http\Requests\CreateTimelineEntryRequest;

class TimelineController extends Controller
{
    public function list(): JsonResponse {
        $followings = FollowUser::following()->pluck('following_id')->toArray();
        $timeline = Timeline::with('author.profile')
            ->searchWithinIds($followings)
            ->withCount('likes')
            ->withExists([ 'likes' => fn($q) => $q->userLikes(Auth::id()) ])
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

    public function delete(Timeline $timeline, DeleteEntry $deleteEntry) {
        $this->authorize('delete', $timeline);
        $deleteEntry->run($timeline);
        return new JsonResponse([ 'success' => true, 'message' => 'Timeline Entry removed' ], 201);
    }
}