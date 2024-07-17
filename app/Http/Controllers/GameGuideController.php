<?php

namespace App\Http\Controllers;

use App\Models\GameGuide;

class GameGuideController extends Controller
{
    public function show()
    {
        $gameGuide = GameGuide::orderBy('order')->get();

        return view('public-website.pages.gameguide', compact('gameGuide'));
    }
}
