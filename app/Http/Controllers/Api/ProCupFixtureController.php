<?php

namespace App\Http\Controllers\Api;

use App\Models\Division;
use App\Services\ProcupFixtureService;
use Illuminate\Http\Request;

class ProCupFixtureController extends Controller
{
    /**
     * @var LeagueReport
     */
    protected $procupFixtureService;

    /**
     * DivisionsController constructor.
     *
     * @param DivisionService $service
     */
    public function __construct(ProcupFixtureService $procupFixtureService)
    {
        $this->service = $procupFixtureService;
    }

    public function getPhases(\Illuminate\Http\Request $request, Division $division)
    {
        if (! $request->user()->can('view', $division) && ! $request->user()->can('allowProCup', $division)) {
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $proCupFixtures = [];
        $message = 'No pro cup fixtures';
        $phases = $this->service->getPhases($division, $request->user()->consumer->id);
        if ($phases->count()) {
            $proCupFixtures = $this->service->getPhaseFixtures($phases->keys()->last(), $division, $request->user()->consumer->id);
            $message = 'Pro cup fixtures';
        }

        return response()->json([
            'phases' => $phases,
            'latestPhaseFixture' => $proCupFixtures,
            'message' => $message,
        ]);
    }

    public function getPhaseFixtureFilter(Request $request, Division $division)
    {
        if (! $request->user()->can('view', $division) && ! $request->user()->can('allowProCup', $division)) {
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        if ($request->has('phase')) {
            $proCupFixtures = $this->service->getPhaseFixtures($request->get('phase'), $division, $request->user()->consumer->id);

            return response()->json([
                'data'=> $proCupFixtures,
            ]);
        }
    }
}
