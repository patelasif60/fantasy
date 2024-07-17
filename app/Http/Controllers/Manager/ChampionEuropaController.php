<?php

namespace App\Http\Controllers\Manager;

use App\Enums\EuropeanPhasesNameEnum;
use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Services\ChampionEuropaService;
use Illuminate\Http\Request;
use JavaScript;

class ChampionEuropaController extends Controller
{
    /**
     * @var ChampionEuropaService
     */
    protected $service;

    /**
     * DivisionsController constructor.
     *
     * @param ChampionEuropaService $service
     */
    public function __construct(ChampionEuropaService $service)
    {
        $this->service = $service;
    }

    public function getChampionPhases(Request $request, Division $division)
    {
        $this->authorize('allowChampionLeague', $division);
        $consumer = $this->service->getManger($division, 'champion');
        //$consumer = $request->user()->consumer;
        $groupStages = $this->service->getChampionEuropaPhases($division, $consumer, EuropeanPhasesNameEnum::CHAMPIONS_LEAGUE);
        $runningPhase = $this->service->getGetRunningGroupPhase($groupStages);
        JavaScript::put([
            'CHAMPIONS_LEAGUE' => EuropeanPhasesNameEnum::CHAMPIONS_LEAGUE,
            'division' => $division,

        ]);

        return view('manager.divisions.info.champion_league', compact('division', 'groupStages', 'runningPhase'));
    }

    public function getChampionEuropaPhaseFixtures(Request $request, Division $division)
    {
        $this->authorize('allowChampionEuropaLeague', $division);
        
        if ($request->get('competition') == EuropeanPhasesNameEnum::CHAMPIONS_LEAGUE) {
            $competition = EuropeanPhasesNameEnum::CHAMPIONS_LEAGUE;
        } elseif ($request->get('competition') == EuropeanPhasesNameEnum::EUROPA_LEAGUE) {
            $competition = EuropeanPhasesNameEnum::EUROPA_LEAGUE;
        }

        $data = $this->service->getChampionEuropaPhaseFixtures($division, $request->all(), $competition);

        return response()->json([
            'data'=> $data,
        ]);
    }

    public function getChampionEuropaGroupStandings(Request $request, Division $division)
    {
        $this->authorize('allowChampionEuropaLeague', $division);
        if ($request->get('competition') == EuropeanPhasesNameEnum::CHAMPIONS_LEAGUE) {
            $competition = EuropeanPhasesNameEnum::CHAMPIONS_LEAGUE;
        } elseif ($request->get('competition') == EuropeanPhasesNameEnum::EUROPA_LEAGUE) {
            $competition = EuropeanPhasesNameEnum::EUROPA_LEAGUE;
        }
        $groupStandings = $this->service->getChampionEuropaGroupStandings(
            $division,
            $request->all(),
            $competition
        );

        return response()->json([
            'data'=> $groupStandings,
        ]);
    }

    public function getEuropaPhases(Division $division, Request $request)
    {
        $this->authorize('allowChampionEuropaLeague', $division);
        $consumer = $this->service->getManger($division, 'europa');
        //$consumer = $request->user()->consumer;
        $europaTypeOne = 1;
        $europaTypeTwo = 2;
        $groupStagesOne = $this->service->getChampionEuropaTeamPhases($division, $consumer, EuropeanPhasesNameEnum::EUROPA_LEAGUE, $europaTypeOne);

        $runningPhaseOne = $this->service->getGetRunningGroupPhase($groupStagesOne);

        $groupStagesTwo = $this->service->getChampionEuropaTeamPhases($division, $consumer, EuropeanPhasesNameEnum::EUROPA_LEAGUE, $europaTypeTwo);
        $runningPhaseTwo = $this->service->getGetRunningGroupPhase($groupStagesTwo);

        $europaTeamOne = $division->getEuropaTeamOne;
        $europaTeamTwo = $division->getEuropaTeamTwo;

        JavaScript::put([
            'EUROPA_LEAGUE' => EuropeanPhasesNameEnum::EUROPA_LEAGUE,
            'division' => $division,
            'europaTeamOne' => $europaTeamOne ? $europaTeamOne->id : 0,
            'europaTeamTwo' => $europaTeamTwo ? $europaTeamTwo->id : 0,

        ]);

        return view('manager.divisions.info.europa_league', compact('division', 'groupStagesOne', 'groupStagesTwo', 'runningPhaseOne', 'runningPhaseTwo','europaTeamOne','europaTeamTwo'));
    }
}
