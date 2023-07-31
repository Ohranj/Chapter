<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\JsonResponse;

class CountryController extends Controller
{
    public function __invoke() {
        $countries = Country::all()->toBase();

        return new JsonResponse([
            'success' => true,
            'message' => 'Countries fetched',
            'data' => $countries
        ]);
    }
}
