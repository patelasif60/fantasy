<?php

namespace App\Http\Controllers\Api;

use App\Enums\EuropeanPhasesNameEnum;
use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Services\ChampionEuropaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    public function getChampionEuropaPhases(Division $division, Request $request)
    {
        if (! $request->user()->can('view', $division) && ! $request->user()->can('allowChampionEuropaLeague', $division)) {
            return response()
                    ->json(['status' => 'error', 'message' => 'Not authorized.'],
                    JsonResponse::HTTP_FORBIDDEN);
        }

        if (! $request->get('competition')) {
            return response()
                    ->json(['status' => 'error', 'message' => 'Pass all params.'],
                    JsonResponse::HTTP_FORBIDDEN);
        }

        $consumer = $request->user()->consumer;
        $competition = $request->get('competition');

        if (EuropeanPhasesNameEnum::CHAMPION == $competition) {
            $data = $this->getChampionPhases($division, $consumer);
            $groupStandings = $this->service->getChampionEuropaGroupStandings($division, $request->all(), EuropeanPhasesNameEnum::CHAMPIONS_LEAGUE);

            return response()->json([
                'phases'=> $data['groupStages'],
                'fixtures' => $data['runningGameweekFixture'],
                'groupStandings' => $groupStandings,
            ]);
        }

        if (EuropeanPhasesNameEnum::EUROPA == $competition) {
            $data = $this->getEuropaPhases($division, $consumer);

            return response()->json([
                'data'=> $data,
            ]);
        }

        return response()->json([
            'phases'=> [],
            'fixtures' => [],
        ]);
    }

    public function getChampionEuropaPhaseFixtures(Division $division, Request $request)
    {
        if (! $request->user()->can('view', $division) && ! $request->user()->can('allowChampionEuropaLeague', $division)) {
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $competition = $this->getCompetiotionType($request->get('competition'));

        $fixtures = $this->service->getChampionEuropaPhaseFixtures($division, $request->all(), $competition);

        return response()->json([
            'data'=> $fixtures,
        ]);
    }

    public function getChampionEuropaGroupStandings(Request $request, Division $division)
    {
        if (! $request->user()->can('view', $division) && ! $request->user()->can('allowChampionEuropaLeague', $division)) {
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }
        $competition = $this->getCompetiotionType($request->get('competition'));
        $groupStandings = $this->service->getChampionEuropaGroupStandings($division, $request->all(), $competition);

        return response()->json([
            'data'=> $groupStandings,
        ]);
    }

    public function getCompetiotionType($request)
    {
        if ($request == EuropeanPhasesNameEnum::EUROPA) {
            return  EuropeanPhasesNameEnum::EUROPA_LEAGUE;
        } else {
            return EuropeanPhasesNameEnum::CHAMPIONS_LEAGUE;
        }
    }

    public function getChampionPhases($division, $consumer)
    {
        $consumer = $this->service->getManger($division, 'champion');
        $grpStages = $this->service->getChampionEuropaPhases($division, $consumer,
                        EuropeanPhasesNameEnum::CHAMPIONS_LEAGUE);

        $getRunningGroupPhase = $this->service->getGetRunningGroupPhase($grpStages);
        $data['runningGameweekFixture'] = $this->service->
                                    getChampionEuropaPhaseFixtures($division, $getRunningGroupPhase,
                                        EuropeanPhasesNameEnum::CHAMPIONS_LEAGUE);

        $groupStages = $grpStages->map(function ($groupStage) {
            $groupStage->title = get_group_stage_and_number($groupStage,'stage');
            $groupStage->desc = get_group_stage_and_number($groupStage,'number');

            return $groupStage;
        });

        $data['groupStages'] = $groupStages;

        return $data;
    }

    public function getEuropaPhases($division, $consumer)
    {
        $europaTypeOne = 1;
        $europaTypeTwo = 2;
        $runningPhaseOne['team'] = $runningPhaseOne['team'] = $data['europaTeamOne'] = $data['europaTeamTwo'] = '';

        $data['phasesOne'] = $this->service
                                    ->getChampionEuropaTeamPhases($division, $consumer,
                                    EuropeanPhasesNameEnum::EUROPA_LEAGUE, $europaTypeOne);

        $runningPhaseOne = $this->service
                                ->getGetRunningGroupPhase($data['phasesOne']);

        if ($division->getEuropaTeamOne != null) {
            $runningPhaseOne['team'] = $division->getEuropaTeamOne->id;
            $data['europaTeamOne'] = $division->getEuropaTeamOne->id;
        }
        $data['FixtureOne'] = $this->service
                                            ->getChampionEuropaPhaseFixtures($division, $runningPhaseOne,
                                        EuropeanPhasesNameEnum::EUROPA_LEAGUE);

        if ($data['phasesOne']->first()) {
            $params['group'] = $data['phasesOne']->first()->group_no;
            $params['competition'] = EuropeanPhasesNameEnum::EUROPA;
            $data['groupStandingsOne'] = $this->service->
                                getChampionEuropaGroupStandings($division, $params,
                                EuropeanPhasesNameEnum::EUROPA_LEAGUE);
        }

        $data['phasesTwo'] = $this->service
                                    ->getChampionEuropaTeamPhases($division, $consumer,
                                    EuropeanPhasesNameEnum::EUROPA_LEAGUE, $europaTypeTwo);

        $runningPhaseTwo = $this->service
                                ->getGetRunningGroupPhase($data['phasesTwo']);
        if ($division->getEuropaTeamTwo != null) {
            $runningPhaseOne['team'] = $division->getEuropaTeamTwo->id;
            $data['europaTeamTwo'] = $division->getEuropaTeamTwo->id;
        }
        $data['FixtureTwo'] = $this->service
                                    ->getChampionEuropaPhaseFixtures($division, $runningPhaseTwo,
                                        EuropeanPhasesNameEnum::EUROPA_LEAGUE);

        if ($data['phasesTwo']->first()) {
            $params['group'] = $data['phasesTwo']->first()->group_no;
            $params['competition'] = EuropeanPhasesNameEnum::EUROPA;
            $data['groupStandingsTwo'] = $this->service->
                                getChampionEuropaGroupStandings($division, $params,
                                EuropeanPhasesNameEnum::EUROPA_LEAGUE);
        }

        return $data;
    }

    // public function getEuropaPhases($division, $consumer)
    // {
    //     $europaTypeOne = 1;
    //     $europaTypeTwo = 2;
    //     $consumer = $this->service->getManger($division, 'europa');

    //     $data['phasesOne'] = $this->service
    //                                 ->getChampionEuropaTeamPhases($division, $consumer,
    //                                 EuropeanPhasesNameEnum::EUROPA_LEAGUE, $europaTypeOne);

    //     $runningPhaseOne = $this->service
    //                             ->getGetRunningGroupPhase($data['phasesOne']);

    //     $runningPhaseOne['team'] = $division->getEuropaTeamOne->id;
    //     $data['FixtureOne'] = $this->service
    //                                         ->getChampionEuropaPhaseFixtures($division, $runningPhaseOne,
    //                                     EuropeanPhasesNameEnum::EUROPA_LEAGUE);

    //     if ($data['phasesOne']->first()) {
    //         $params['group'] = $data['phasesOne']->first()->group_no;
    //         $params['competition'] = EuropeanPhasesNameEnum::EUROPA;
    //         $data['groupStandingsOne'] = $this->service->
    //                             getChampionEuropaGroupStandings($division, $params,
    //                             EuropeanPhasesNameEnum::EUROPA_LEAGUE);
    //     }

    //     $data['phasesTwo'] = $this->service
    //                                 ->getChampionEuropaTeamPhases($division, $consumer,
    //                                 EuropeanPhasesNameEnum::EUROPA_LEAGUE, $europaTypeTwo);

    //     $runningPhaseTwo = $this->service
    //                             ->getGetRunningGroupPhase($data['phasesTwo']);
    //     $runningPhaseOne['team'] = $division->getEuropaTeamTwo->id;
    //     $data['FixtureTwo'] = $this->service
    //                                 ->getChampionEuropaPhaseFixtures($division, $runningPhaseTwo,
    //                                     EuropeanPhasesNameEnum::EUROPA_LEAGUE);

    //     if ($data['phasesTwo']->first()) {
    //         $params['group'] = $data['phasesTwo']->first()->group_no;
    //         $params['competition'] = EuropeanPhasesNameEnum::EUROPA;
    //         $data['groupStandingsTwo'] = $this->service->
    //                             getChampionEuropaGroupStandings($division, $params,
    //                             EuropeanPhasesNameEnum::EUROPA_LEAGUE);
    //     }
    //     $data['europaTeamOne'] = $division->getEuropaTeamOne->id;
    //     $data['europaTeamTwo'] = $division->getEuropaTeamTwo->id;

    //     return $data;
    // }
}
