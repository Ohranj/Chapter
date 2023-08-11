<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;

class TrendingController extends Controller
{
    /**
     * Handle the incoming request.
     * 
     * @todo MOVE TO A RESOURCE
     */
    public function __invoke(Request $request) {
        $params = http_build_query([
            'q' => 'The Lord of The Rings',
            'intitle' => 'The Fellowship of the Rings',
            'inauthor' => 'Tolkien',
            'langRestrict' => 'en',
           
            'maxResults' => 1,
            'printType' => 'books',
            'key' => config('google_api_key')
        ]);

        $responses = Http::pool(fn (Pool $pool) => [
            $pool->as('first')->get('https://www.googleapis.com/books/v1/volumes?' . $params),
            $pool->as('second')->get('https://www.googleapis.com/books/v1/volumes?' . $params),
            $pool->as('third')->get('https://www.googleapis.com/books/v1/volumes?' . $params),
            $pool->as('fourth')->get('https://www.googleapis.com/books/v1/volumes?' . $params),
            $pool->as('fifth')->get('https://www.googleapis.com/books/v1/volumes?' . $params),
        ]);

        $valid = true;
        foreach($responses as $response) {
            if ($response->failed()) {
                $valid = false;
                break;
            }
        }

        return $valid
            ? dd($responses['first']->json())
            : dd('No bueno');
    }
}