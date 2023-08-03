<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ExploreCommunityController extends Controller
{
    public function __invoke() {
        $user = Auth::user();
        $user->load('following:id,name,surname');
        
        return view('explore-community')->with([ 'user' => $user ]);
    }
}
