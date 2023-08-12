<?php

namespace App\Http\Controllers;

use App\Actions\Timeline\ToggleLike;
use App\Models\Timeline;
use Illuminate\Http\JsonResponse;

class LikeController extends Controller
{
    public function update(Timeline $timeline, ToggleLike $toggleLike) {
        $toggleLike->run($timeline);
        return new JsonResponse([ 'success' => true, 'message' => 'Like Updated for Entry' ], 201);
    }
}
