<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Symfony\Component\HttpFoundation\JsonResponse;

class TagController extends Controller
{
    public function __invoke() {
        $tags = Tag::orderBy('tag')->get();
        return new JsonResponse([ 'success' => true, 'message' => 'Tags retrieved', 'data' => $tags ]);
    }
}
