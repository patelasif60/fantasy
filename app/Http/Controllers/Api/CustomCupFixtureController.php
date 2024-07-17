<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomCup as CustomCupResource;
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

    public function getCustomCups(Division $division, Request $request)
    {
        $customCups = $this->service->getCustomCups($division, $request->user()->consumer);

        return response()->json([
            'data' => CustomCupResource::collection($customCups),
        ]);
    }

    public function index(Division $division, CustomCup $customCup)
    {
        $customCup = $customCup->load('rounds');
        $activeRound = $this->service->getCupActiveRound($customCup);
        $fixtures = $this->service->getRoundFixtureFilter($division, $customCup, $activeRound);

        return response()->json([
            'status' => 'success',
            'activeRound' => $activeRound,
            'customCup' => $customCup,
            'fixtures' => $fixtures,
            'message' => 'Custom cup fixtures',
        ]);
    }

    public function getRoundFixtureFilter(Division $division, CustomCup $customCup, Request $request)
    {
        $round = $request->get('round');
        $response = $this->service->getRoundFixtureFilter($division, $customCup, $round);

        return response()->json([
            'status' => 'success',
            'data' => $response,
        ]);
    }
}
