<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\CustomCup;
use App\Models\Division;
use App\Services\CustomCupFixtureService;
use Illuminate\Http\Request;

class CustomCupFixtureController extends Controller
{
    /**
     * CustomCupFixtureController constructor.
     */
    public function __construct(CustomCupFixtureService $service)
    {
        $this->service = $service;
    }

    public function index(Division $division, CustomCup $customCup)
    {
        $customCup = $customCup->load('rounds', 'rounds.gameweeks', 'rounds.gameweeks.gameweek');
        $activeRound = $this->service->getCupActiveRound($customCup);

        return view('manager.divisions.info.custom_cup', compact('division', 'customCup', 'activeRound'));
    }

    public function getRoundFixtureFilter(Division $division, CustomCup $customCup, Request $request)
    {
        $round = $request->get('round');
        $response = $this->service->getRoundFixtureFilter($division, $customCup, $round);

        return response()->json([
            'data' => $response,
        ]);
    }
}
