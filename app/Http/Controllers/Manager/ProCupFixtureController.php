<?php

namespace App\Http\Controllers\Manager;

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

    public function index(\Illuminate\Http\Request $request, Division $division)
    {
        $this->authorize('allowProCup', $division);
        $rounds = $this->service->getPhases($division, $request->user()->consumer->id);

        return view('manager.divisions.info.pro_cup', compact('rounds', 'division'));
    }

    public function getPhaseFixtureFilter(Request $request, Division $division)
    {
        $this->authorize('allowProCup', $division);
        if ($request->has('phase')) {
            $proCupFixtures = $this->service->getPhaseFixtures($request->get('phase'), $division, $request->user()->consumer->id);

            return response()->json([
                'data'=> $proCupFixtures,
            ]);
        }
    }
}
